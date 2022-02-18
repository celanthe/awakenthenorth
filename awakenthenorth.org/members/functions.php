<?
//ERROR_REPORTING(E_ALL);
function navbar($menu) {
	/*
	member:1
	admin:2
	council:3
	banished:4
	emissary:5
	gothar:6
	*/
	
	
function object_to_array($data)
{
    if (is_array($data) || is_object($data))
    {
        $result = array();
        foreach ($data as $key => $value)
        {
            $result[$key] = object_to_array($value);
        }
        return $result;
    }
    return $data;
}
	
	
	global $user;
	if(isset($user) && $user->isLoggedIn()){
		$loggedin=1;
		$usrpermsarr=object_to_array(fetchUserPermissions($user->data()->id));
		//print_r($usrpermsarr);
		foreach ($usrpermsarr as $row) {
			//echo $row["permission_id"]."<Br>";
			$user_perms[]=$row["permission_id"];	
		}
	} else {
		$loggedin=0;
		$user_perms[]=0;
	}
	$user_perms[]="*";
	//$loggedin=0;
	//unset($user_perms);
	//$user_perms[]=0;
	//$user_perms[]=1;
	//print_r($user_perms);
	//$user
	
	$current_file_name = basename($_SERVER['PHP_SELF']);
	if ($loggedin==1) {
	$nav=MDB::query("SELECT * FROM atn_menu_test WHERE menu = %s AND type <= 2 AND parent = '0' AND (loggedin = 0 OR loggedin = 1) ORDER BY `order` ASC", $menu); //is logged in
	}
	if ($loggedin==0) {
	$nav=MDB::query("SELECT * FROM atn_menu_test WHERE menu = %s AND type <= 2 AND parent = '0' AND (loggedin = 0 OR loggedin = 3) ORDER BY `order` ASC", $menu); //is logged in
	}
	foreach ($nav as $row) {
		$canview="no";
		$nperms=json_decode($row["perms"], true);
		foreach ($nperms as $row2) {
			
			if (in_array($row2, $user_perms)) { $canview="yes"; }
		}
				if (in_array("2", $user_perms) || in_array("3", $user_perms)) { $can_view="yes"; }

		if ($canview=="yes") {
			$nnav[]=$row;
		}
	}
	$data='<nav class="uk-navbar-container" uk-navbar>
    <div class="uk-navbar-left">
	<ul class="uk-navbar-nav">';
	foreach ($nnav as $row) {
		$can_view=false;
		unset($perms);

		$perms=json_decode($row["perms"]);
		foreach ($perms as $prow) {		
				if (in_array($prow, $user_perms, true)) {
					$can_view=true;
				}
		}
		if (in_array("*", $perms, true)) {
			$can_view=true;
		}
		if (in_array("2", $user_perms) || in_array("3", $user_perms)) { $can_view=true; }
		unset($perms);
		if ($can_view==true) {
			if ($row["type"]==1) {
				if (basename($row["link"])== $current_file_name) { $class='uk-active'; } else { $class=""; }
				$data.='<li class="'.$class.'"><a href="'.SITE_URL.$row["link"].'">'.$row["name"].'</a></li>';
			} //single menu item, not a parent;
			if ($row["type"]==2) {
				$data.='<li>
				<a href="'.SITE_URL.$row["link"].'">'.$row["name"].'</a>
				<div class="uk-navbar-dropdown">
				<ul class="uk-nav uk-navbar-dropdown-nav">';
				$children=MDB::query("SELECT * FROM atn_menu_test WHERE menu = %s AND type = 3 AND parent = %i", $menu, $row["id"]);
				foreach ($children as $items) {
					$ccan_view=false;
					unset($cperms);
					$cperms=json_decode($items["perms"]);
					foreach ($cperms as $prow) {
						if (in_array($prow, $user_perms)) {
							$ccan_view=true;
						}
					}
					if (in_array("*", $cperms, true)) {
						$ccan_view=true;
					}
					if (in_array("2", $user_perms) || in_array("3", $user_perms)) { $ccan_view=true; }
					unset($perms);
					if ($ccan_view == true) {
						if (basename($items["link"])== $current_file_name) { $class='uk-active'; } else { $class=""; }
						$data.='<li class="'.$class.'"><a href="'.SITE_URL.$items["link"].'">'.$items["name"].'</a></li>';
					}
				}
				$data.='</ul>
				</div>
				</li>';
			} // parent menu item
		}
	
	}
	
	$data.='</ul>
    </div>
	</nav>';
	return $data;
}

function appstatus($id) {
	$value="";
	switch ($id) {
		case 1:
			$value="New";
			break;
		case 2:
			$value="Pending";
			break;
		case 3:
			$value="Denied";
			break;
		case 4:
			$value="Denied - Unsutable";
			break;
		case 5:
			$value="Approved";
			break;
	}
	return $value;
	
}

function privacy($id) {
	$value="";
	switch ($id) {
		case "p":
			$value="Publishable";
			break;
		case "s":
			$value="Shareable";
			break;
		case "c":
			$value="Confidential";
			break;
	}
	return $value;
	
}

function email_staff($type, $id, $mil="no") {
$transport = (new Swift_SmtpTransport('mail.awakenthenorth.org', 2525))
  ->setUsername('noreply@awakenthenorth.org')
  ->setPassword('password');
$app=MDB::queryFirstRow("SELECT * FROM atn_applications WHERE id=%i", $id);
$appdata=json_decode($app["application"], true);

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

if ($type=="new") {
$toemail[]="coma@awakenthenorth.org";
if (strtolower($appdata["military"]) != "no" ) {
	$toemail[]="coms@awakenthenorth.org";
	$letters=MDB::queryFirstRow("SELECT * FROM atn_email_templates WHERE code=%s", "newapp_military");
	$subject=$letters["subject"];
	$body_html=str_replace("{{NAME}}", ($appdata["first"]." ".$appdata["last"]), $letters["body_html"]);
	$body_html=str_replace("{{PNAME}}", $appdata["rname"], $body_html);
	$body_html=str_replace("{{SERVICE}}", $appdata["military"], $body_html);
	$body_html=str_replace("{{BRANCH}}", $appdata["branch"], $body_html);
	$body_html=str_replace("{{COUNTRY}}", $appdata["milcountry"], $body_html);
	$body_html=str_replace("{{APPID}}", $id, $body_html);
	
} else {
	$subejct='New ATN Membership Application';
	$letters=MDB::queryFirstRow("SELECT * FROM atn_email_templates WHERE code=%s", "newapp");
	$subject=$letters["subject"];
	$body_html=str_replace("{{NAME}}", ($appdata["first"]." ".$appdata["last"]), $letters["body_html"]);
	$body_html=str_replace("{{PNAME}}", $appdata["rname"], $body_html);
	$body_html=str_replace("{{APPID}}", $id, $body_html);
}
$toemail[]="chris.claus42@gmail.com";
$toemail[]="atn@awakenthenorth.org";
// Create a message
  $message = (new Swift_Message($subject))
  ->setFrom(['noreply@awakenthenorth.org' => 'Awaken The North'])
  ->setTo($toemail)
  ->setBody($body_html, 'text/html')
  ->addPart(strip_tags($body_html), 'text/plain');

// Send the message
$result = $mailer->send($message);
MDB::insert("atn_emails_sent", array("date"=>time(), "to"=>json_encode($toemail), "subject"=>$subject, "body"=>$body_html));
}
}	

	
	


function priv_form($field, $sel="null") {
	$s["c"]=$s["p"]=$s["s"]="";
	if ($sel=="c") { $s["c"]="selected"; }
	if ($sel=="p") { $s["p"]="selected"; }
	if ($sel=="s") { $s["s"]="selected"; }
	//$selected=$s[$sel];
	$form='<select class="uk-select uk-form-width-medium" name="'.$field.'_privacy"><option value="p" '.$s["p"].'>Publishable - Everyone can see</option>
<option value="s"  '.$s["s"].'>Sharable - ATN Members can see</option>
<option value="c"  '.$s["c"].'>Confidential - Only Councilors and Chairs can see</option></select>';
return $form;
}
function spacer($size=5) {
	return '<div style="height: '.$size.'px;"></div>';
}


function geocode($address){
    // url encode the address
    $address = urlencode($address);
     
    // google map geocode api url
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=".MAPS_API_KEY;
 
    // get the json response
    $resp_json = file_get_contents($url);
     
    // decode the json
    $resp = json_decode($resp_json, true);
 
    // response status will be 'OK', if able to geocode given address 
    if($resp['status']=='OK'){
 
        // get the important data
        $lati = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
        $longi = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
        $formatted_address = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : "";
         
        // verify if data is complete
        if($lati && $longi && $formatted_address){
         
            // put the data in the array
            $data_arr = array();            
             
            array_push(
                $data_arr, 
                    $lati, 
                    $longi, 
                    $formatted_address
                );
             
            return $data_arr;
             
        }else{
            return false;
        }
         
    }
 
    else{
        echo "<strong>ERROR: {$resp['status']}</strong>";
        return false;
    }
}

function member_level($id) {
	switch ($id) {
		case 1:
			$level="Member";
			break;
		case 9:
			$level="Chancellor";
			break;
	}
	return $level;
}
function member_status($id) {
	switch ($id) {
		case 1:
			$status="Active";
			break;
	
		case 9:
			$status="Banned";
			break;
	}
	return $status;
}

function pgheader($title="", $menu="main") {
	
$content='<!DOCTYPE html>
<html>
<title>Awaken The North '.$title.'</title>
	<head>
		<!-- UIkit CSS -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.7/dist/css/uikit.min.css" />
		<!-- UIkit JS -->
		<script src="https://cdn.jsdelivr.net/npm/uikit@3.5.7/dist/js/uikit.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/uikit@3.5.7/dist/js/uikit-icons.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.min.js"></script>
		<link rel="stylesheet" href="https://members.awakenthenorth.org/includes/datepicker.css">
		<script src="https://members.awakenthenorth.org/includes/datepicker.js"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<style>
		   .error {
      color: red;
      font-weight: bold;
   }
   
   .uk-card-default {
	   background-color: F0F0F0;
   }
   </style>
<style>
	td {
		border-bottom: 1px solid black;
	}
	</style>   
	</head>
<body style="background-color: 000000;">

<div class="uk-container">
'.navbar($menu).'

<div class="uk-card-default  uk-card-body">
<center><img src="'.SITE_URL.'logo2.png" width="50%"><br>';
echo $content;
}
//function redirect($location) {
//	echo '<meta http-equiv="refresh" content="0;URL=\''.$location.'\'" />'
//}

function duration($time) {
    if ($time < 1) {
        return;
    }
	if ($time >= 60) {
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return $hours." hours ".$minutes." minutes";
	}
	else {
		return $minutes." minutes";
	}
}
?>