<?php
error_reporting(E_ALL);
require_once '/home/intheexp/atn.bigskyheathen.com/members/users/init.php';
require("/home/intheexp/atn.bigskyheathen.com/members/db.php");
require("/home/intheexp/atn.bigskyheathen.com/members/functions.php");
require_once '/home/intheexp/atn.bigskyheathen.com/members/vendor/autoload.php';
define("WPDIR", "/home/intheexp/atn.bigskyheathen.com/");
require_once(WPDIR.'wp-blog-header.php');
require_once(WPDIR.'wp-includes/registration.php');
//if (isset($_POST)) { print_r($_POST); exit; }
if(isset($user) && $user->isLoggedIn()){
	$loggedin = 1;
} else {
	$loggedin=0;
}
if (!securePage($_SERVER['PHP_SELF'])){die();}
$author=$user->data()->fname." ".$user->data()->lname;
?>
<!DOCTYPE html>
<html>
<title>Awaken The North Membership Application</title>
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
<? echo navbar("main"); ?>

<div class="uk-card-default  uk-card-body">
<center><img src="<? echo SITE_URL; ?>logo2.png" width="50%"><br>
<?
if (isset($_GET["type"])) {
	$type=$_GET["type"];
} else {
	echo "error";
	exit();
}

if ($type=="application" && isset($_GET["id"])) {
	$id=$_GET["id"];
	$app=MDB::queryFirstRow("SELECT * FROM atn_applications WHERE id=%i", $id);
	
	if ($app["status"] == 1) {
	$text=$_POST["text"];
	$text=str_replace('img src="../', 'img src="https://members.awakenthenorth.org/', $text);
	$subject=$_POST["subject"];
	$ptext=strip_tags($text);
	
	$transport = (new Swift_SmtpTransport(MAIL_SERVER, MAIL_PORT))
  ->setUsername(MAIL_USERNAME)
  ->setPassword(MAIL_PASSWORD)
;

// Create the Mailer using your created Transport


$appdata=json_decode($app["application"], true);
$geo=geocode($appdata["city"]." ".$appdata["state"]." ".$appdata["zip"]." ".$appdata["country"]);
if (!isset($appdata["dob"])) { $appdata["dob"]=""; }
if (!isset($appdata["namedisp"])) { $appdata["namedisp"]=1; }
$passwordhash=password_hash($appdata["password1"], PASSWORD_BCRYPT, array('cost' => 12));
MDB::insert("atn_cmr", array(
"appid"=>$app["id"],
"joined"=>time(),
"username"=>$appdata["username"],
"first"=>$appdata["first"],
"last"=>$appdata["last"],
"pname"=>$appdata["rname"],
"namedisp"=>$appdata["namedisp"],
"dob"=>$appdata["dob"],
"phone"=>$appdata["phone"],
"email"=>$appdata["email"],
"address"=>$appdata["street"],
"address2"=>$appdata["streetunit"],
"city"=>$appdata["city"],
"state"=>$appdata["state"],
"zip"=>$appdata["zip"],
"country"=>$appdata["country"],
"military"=>json_encode(array("military"=>$appdata["military"], "branch"=>$appdata["branch"], "milcountry"=>$appdata["milcountry"])),
"notes"=>$app["notes"],
"files"=>"",
"status"=>1,
"updates"=>"",
"privacy"=>json_encode(array("name_privacy"=>$appdata["name_privacy"], "rname_privacy"=>$appdata["rname_privacy"], "dob_privacy"=>$appdata["dob_privacy"], "address_privacy"=>$appdata["address_privacy"], "email_privacy"=>$appdata["email_privacy"], "phone_privacy"=>$appdata["phone_privacy"])),
"map"=>$appdata["membermap"],
"lati"=>$geo[0],
"longi"=>$geo[1],
"socialmedia"=>json_encode(array("website"=>$appdata["website"], "facebook"=>$appdata["facebook"], "twitter"=>$appdata["twitter"], "instagram"=>$appdata["instagram"])),
"dob"=>$appdata["dob"],
"level"=>1));
$memid=MDB::insertId();
$text=str_replace("{{member_number}}", $memid, $text);
$ptext=str_replace("{{member_number}}", $memid, $ptext);
$mailer = new Swift_Mailer($transport);
$bcctoemail[]="chris.claus42@gmail.com";
$bcctoemail[]="atn@awakenthenorth.org";
$toemail[]=$app["email"];
// Create a message
$message = (new Swift_Message($subject))
  ->setFrom(['noreply@awakenthenorth.org' => 'Awaken The North'])
  ->setTo($toemail)
  ->setBcc($bcctoemail)
  ->setBody($text, 'text/html')
  ->addPart($ptext, 'text/plain')
  ;

// Send the message
$result = $mailer->send($message);
MDB::insert("atn_emails_sent", array("date"=>time(), "to"=>$toemail, "subject"=>$subject, "body"=>$text));
MDB::update("atn_applications", array("status"=>5), "id=%i", $id);
echo "<h2>Member added successfully.</h2>";
if (isset($_POST["portal"]) && $_POST["portal"]=="yes") {
$fields=array(
              'username' => $appdata["username"],
              'fname' => ucfirst($appdata["first"]),
              'lname' => ucfirst($appdata["last"]),
              'password' => $passwordhash,
              'email' => $appdata["email"],
              'permissions' => 1,
              'account_owner' => 1,
              'join_date' => date("Y-m-d H:i:s"),
              'email_verified' => 1,
              'active' => 1,
              'vericode' => randomstring(15),
              'force_pr' => 0,
            );
MDB::insert('users',$fields);
$theNewId=MDB::insertId();
$addNewPermission = array('user_id' => $theNewId, 'permission_id' => 1);
MDB::insert('user_permission_matches',$addNewPermission);
include($abs_us_root.$us_url_root.'usersc/scripts/during_user_creation.php');
//echo $theNewId;
MDB::update("atn_cmr", array("acctid"=>$theNewId), "id=%i", $memid);
echo "Member portal user created.<br>";
}
/*
if (isset($_POST["wordpress"]) && $_POST["wordpress"]=="yes") {

$url = 'https://www.awakenthenorth.org/wp-json/wp/v2/users/register';
 
//Initiate cURL.
$ch = curl_init($url);
 
//The JSON data.
$jsonData = array(
    'username' => $appdata["username"],
    'password' => $appdata["password1"],
	'email' => $appdata["email"]
);
 
//Encode the array into JSON.
$jsonDataEncoded = json_encode($jsonData);
 
//Tell cURL that we want to send a POST request.
curl_setopt($ch, CURLOPT_POST, 1);
 
//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
 
//Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
 
//Execute the request
$result = curl_exec($ch);
//print_r($result);
//$result=json_decode($result, true);
echo "Creating Wordpress Account: ";
if (stripos($result, "Registration was Successful") != false) { echo "Wordpress user created.<br>"; } else { print_r($result); }
}
*/
$user_email=$appdata["email"];
$user_login=$appdata["username"];
$user_pass=$appdata["password1"];
if (email_exists($user_email)) {
	
	echo '<p>Email already registered: '. $user_email .'</p>';
	
} elseif (username_exists($user_login)) {
	
	echo '<p>Username already registered: '. $user_login .'</p>';
	
} else {
	
	//$user_pass = wp_generate_password(16, false);
	
	$user_id = wp_insert_user(
		array(
			'user_email' => $user_email,
			'user_login' => $user_login,
			'user_pass'  => $user_pass,
			'user_url'   => $user_url,
			'first_name' => $first_name,
			'last_name'  => $last_name,
			'role'       => $role,
		)
	);
	echo "Wordpress User Created";
}
echo "<br><h2>Done.</h2><br>";

$webhookurl = "https://discord.com/api/webhooks/802237112631951420/3ytYieaLswM42PhHCIb8M3hS-HZqPL9n4_hKkxfecBGGrT0wOP7fBvHxbG9MZnoA_5Ep";


$mem=$members[0];
if (empty($appdata["rname"])) { $minfo=$appdata["first"]." ".$appdata["last"]; } else { $minfo=$appdata["first"]." ".$appdata["last"].". Preferred Name: ".$appdata["rname"]; }
if (!empty($appdata["pronouns"])) { $minfo.=". Pronouns: ".$appdata["pronouns"]; }
$timestamp = date("c", strtotime("now"));
$json_data = json_encode([
    // Message
    "content" => "New Member: ".$minfo,
    
    // Username
    "username" => "Herald",

    // Avatar URL.
    // Uncoment to replace image set in webhook
    //"avatar_url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=512",

    // Text-to-speech
    "tts" => false,

    // File upload
    // "file" => "",

    

], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );


$ch = curl_init( $webhookurl );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec( $ch );
// If you need to debug, or find out why you can't send message uncomment line below, and execute script.
// echo $response;
curl_close( $ch );
echo "Announced: ".$appdata["first"]." ".$appdata["last"].". Preferred Name: ".$appdata["rname"];
MDB::update("atn_cmr", array("discord"=>1), "id=%i", $memid);



} else {
	echo "<h2>Member application already approved/declined.</h2>";
}
} else {
	echo "<h2>An Error has occured</h2>";
}
?>