<?php
error_reporting(E_ALL);
require_once '/home/intheexp/atn.bigskyheathen.com/members/users/init.php';
require("/home/intheexp/atn.bigskyheathen.com/members/db.php");
require("/home/intheexp/atn.bigskyheathen.com/members/functions.php");
require_once '/home/intheexp/atn.bigskyheathen.com/members/vendor/autoload.php';
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
$page="index";
if (isset($_GET["page"])) { $page=$_GET["page"]; } else { $page="index"; }
if (isset($_GET["id"])) { $id=$_GET["id"]; } else { $page="index"; }
if (isset($_GET["do"])) { $do=$_GET["do"];
if($do=="note") {
	if (isset($_POST["note"])) {
	$note=$_POST["note"];
	$app=MDB::queryFirstRow("SELECT * FROM atn_applications WHERE id=%i", $id);
	if (!empty($app["notes"])) {
		$notes=json_decode($app["notes"], true);
		
	}
	$notes[]=array("author"=>$author, "added"=>time(), "note"=>$note);	
	MDB::update("atn_applications", array("notes"=>json_encode($notes)), "id=%i", $id);
	}
}
if ($do=="update") {
	$app=MDB::queryFirstRow("SELECT * FROM atn_applications WHERE id=%i", $id);
	$data=json_decode($app["application"], true);
	$napp=$_POST;
	$data["first"]=$napp["first"];
	$data["last"]=$napp["last"];
	$data["rname"]=$napp["rname"];
	$data["pronouns"]=$napp["pronouns"];
	$data["dob"]=$napp["dob"];
	$data["street"]=$napp["street"];
	$data["streetunit"]=$napp["streetunit"];
	$data["city"]=$napp["city"];
	$data["state"]=$napp["state"];
	$data["zip"]=$napp["zip"];
	$data["country"]=$napp["country"];
	$data["email"]=$napp["email"];
	$data["phone"]=$napp["phone"];
	$data["website"]=$napp["website"];
	$data["facebook"]=$napp["facebook"];
	$data["twitter"]=$napp["twitter"];
	$data["instagram"]=$napp["instagram"];
	MDB::update("atn_applications", array("email"=>$napp["email"], "key"=>MD5($id."::".$napp["email"]), "application"=>json_encode($data)), "id=%i", $id);
}
}
if ($page=="modify") {
	if (isset($_GET["what"])) { 
	$what=$_GET["what"]; 
	if ($what=="deny") {
	$app=MDB::queryFirstRow("SELECT * FROM atn_applications WHERE id=%i", $id);
	$appdata=json_decode($app["application"], TRUE);
	?>
	<script src="js/tinymce/jquery.tinymce.min.js"></script>
	<script src="js/tinymce/tinymce.min.js"></script>
	<h1>Deny Application</h1>
	<table cellspacing="0" border="1">
	<tr><td class="td">Field</td><td class="td">Info</td><td class="td">Privacy Level</td></tr>
	<tr><td class="td">Legal Name:</td><td class="td"><? echo $appdata["first"]." ".$appdata["last"];?></td><td class="td"><? echo "<b>(".$appdata["name_privacy"].")";?></td></tr>
	<tr><td class="td">Preferred Name:</td><td class="td"><? echo $appdata["rname"];?></td><td class="td"><? echo "<b>(".$appdata["rname_privacy"].")";?></td></tr>
	<tr><td class="td">Preferred Pronouns:</td><td class="td"><? echo $appdata["pronouns"];?></td><td class="td"></td></tr>
	<tr><td class="td">Date of Birth:</td><td class="td"><? echo date("m/d/Y", strtotime($appdata["dob"]));?></td><td class="td"><? echo "<b>(".$appdata["dob_privacy"].")";?></td></tr>
	<tr><td class="td">Address:</td><td class="td"><? echo $appdata["street"]." ".$appdata["streetunit"]."<br>".
	$appdata["city"]." ".$appdata["state"]." ".$appdata["zip"]." ".$appdata["country"];
	?></td><td class="td"><? echo "<b>(".$appdata["address_privacy"].")";?></td></tr>
	<tr><td class="td">Email Address:</td><td class="td"><? echo $appdata["email"];?></td><td class="td"><? echo "<b>(".$appdata["email_privacy"].")";?></td></tr>
	<tr><td class="td">Phone:</td><td class="td"><? echo $appdata["phone"];?></td><td class="td"><? echo "<b>(".$appdata["phone_privacy"].")";?></td></tr>
	<tr><td class="td">Member Map:</td><td class="td"><? echo $appdata["membermap"];?></td><td class="td"></td></tr>
	<tr><td class="td">Solitary/Kindred:</td><td class="td"><? echo $appdata["solitary"];?></td><td class="td"></td></tr>
	<tr><td class="td">Military Member:</td><td class="td"><? echo $appdata["military"];?></td><td class="td"></td></tr>
	<?

	$letters=MDB::queryFirstRow("SELECT * FROM atn_email_templates WHERE code=%s", "denial");
	$body_html=str_replace("{{legal_name}}", ($appdata["first"]." ".$appdata["last"]), $letters["body_html"]);
	$body_html=str_replace("{{preferred_name}}", $appdata["rname"], $body_html);
	?>
	</table></center>
	<form method="post" action="deny.php?type=application&id=<? echo $id; ?>">
	Subject Line: <input type="text" name="subject" size="100" value="<? echo $letters["subject"]; ?>"><br>
	Email Body:<br>
	<textarea id="text" name="text"><? echo $body_html; ?></textarea><br>
	
	<input type="submit" value="Send Denial Letter">
	<script>
tinymce.init({
  selector: 'textarea#text',
  height: 500,
  menubar: false,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table paste code help wordcount'
  ],
  toolbar: 'undo redo | formatselect | ' +
  'bold italic backcolor | alignleft aligncenter ' +
  'alignright alignjustify | bullist numlist outdent indent | ' +
  'removeformat | help',
  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
});
</script>
	<?	
		
	}
	if ($what=="approve") {
	$app=MDB::queryFirstRow("SELECT * FROM atn_applications WHERE id=%i", $id);
	$appdata=json_decode($app["application"], TRUE);
	?>
	<script src="js/tinymce/jquery.tinymce.min.js"></script>
	<script src="js/tinymce/tinymce.min.js"></script>
	<h1>Approve Application</h1>
	<table cellspacing="0" border="1">
	<tr><td class="td">Field</td><td class="td">Info</td><td class="td">Privacy Level</td></tr>
	<tr><td class="td">Legal Name:</td><td class="td"><? echo $appdata["first"]." ".$appdata["last"];?></td><td class="td"><? echo "<b>(".$appdata["name_privacy"].")";?></td></tr>
	<tr><td class="td">Preferred Name:</td><td class="td"><? echo $appdata["rname"];?></td><td class="td"><? echo "<b>(".$appdata["rname_privacy"].")";?></td></tr>
	<tr><td class="td">Preferred Pronouns:</td><td class="td"><? echo $appdata["pronouns"];?></td><td class="td"></td></tr>
	<tr><td class="td">Date of Birth:</td><td class="td"><? echo date("m/d/Y", strtotime($appdata["dob"]));?></td><td class="td"><? echo "<b>(".$appdata["dob_privacy"].")";?></td></tr>
	<tr><td class="td">Address:</td><td class="td"><? echo $appdata["street"]." ".$appdata["streetunit"]."<br>".
	$appdata["city"]." ".$appdata["state"]." ".$appdata["zip"]." ".$appdata["country"];
	?></td><td class="td"><? echo "<b>(".$appdata["address_privacy"].")";?></td></tr>
	<tr><td class="td">Email Address:</td><td class="td"><? echo $appdata["email"];?></td><td class="td"><? echo "<b>(".$appdata["email_privacy"].")";?></td></tr>
	<tr><td class="td">Phone:</td><td class="td"><? echo $appdata["phone"];?></td><td class="td"><? echo "<b>(".$appdata["phone_privacy"].")";?></td></tr>
	<tr><td class="td">Member Map:</td><td class="td"><? echo $appdata["membermap"];?></td><td class="td"></td></tr>
	<tr><td class="td">Solitary/Kindred:</td><td class="td"><? echo $appdata["solitary"];?></td><td class="td"></td></tr>
	<tr><td class="td">Military Member:</td><td class="td"><? echo $appdata["military"];?></td><td class="td"></td></tr>
	<?
	if (strtolower($appdata["military"]) != "no") {
	echo '<tr><td class="td">Branch:</td><td class="td">'.$appdata["branch"].'</td><td class="td"></td></tr>';	
	echo '<tr><td class="td">Country:</td><td class="td">'.$appdata["milcountry"].'</td><td class="td"></td></tr>';	
	$letters=MDB::queryFirstRow("SELECT * FROM atn_email_templates WHERE code=%s", "welcome_military");
	} else {
	$letters=MDB::queryFirstRow("SELECT * FROM atn_email_templates WHERE code=%s", "welcome_regular");
	}
	$body_html=str_replace("{{legal_name}}", ($appdata["first"]." ".$appdata["last"]), $letters["body_html"]);
	$body_html=str_replace("{{preferred_name}}", $appdata["rname"], $body_html);
	//Member Number: {{member_number}}<br>
	$body_html=str_replace("{{discord}}", DISCORD_INVITE, $body_html);
	?>
	</table></center>
	<form method="post" action="approve.php?type=application&id=<? echo $id; ?>">
	Subject Line: <input type="text" name="subject" size="100" value="<? echo $letters["subject"]; ?>"><br>
	Email Body:<br>
	<textarea id="text" name="text"><? echo $body_html; ?></textarea><br>
	<input type="checkbox" checked name="wordpress" value="yes"> Create Wordpress User<br>
	<input type="checkbox" checked name="portal" value="yes"> Create Member Portal Account.<br>
	<input type="submit" value="Send Welcome Letter">
	<script>
tinymce.init({
  selector: 'textarea#text',
  height: 500,
  menubar: false,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table paste code help wordcount'
  ],
  toolbar: 'undo redo | formatselect | ' +
  'bold italic backcolor | alignleft aligncenter ' +
  'alignright alignjustify | bullist numlist outdent indent | ' +
  'removeformat | help',
  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
});
</script>
	<?
	}
	
	
	
	
	
	} else { $page="index"; }
	
}
if ($page=="index") {
?>
<h1>Member Applications</h1>
<table border="1">
<tr><td class="td">#</td><td class="td"></td><td class="td">Name</td><td class="td">Military</td><td class="td">Date Applied</td><td class="td">Status</td></tr>
<?
$i=1;
$apps=MDB::query("SELECT * FROM atn_applications WHERE verified = 1 AND status < 3");
foreach ($apps as $row) {
	$info=json_decode($row["application"], true);
	echo '<tr><td class="td">'.$i.'</td><td class="td"><a href="'.SITE_URL.'admin/applications.php?page=view&id='.$row["id"].'">View</a></td><td class="td">'.$info["first"].' '.$info["last"].'</td><td class="td">'.$info["military"].'</td><td class="td">'.date("m/d/Y", $row["submitted"]).'</td><td class="td">'.appstatus($row["status"]).'</td></tr>';
	$i++;
}

?></table>
<?
}
if ($page=="view") {
	?><h1>View Application</h1>
	<a href="applications.php?page=edit&id=<? echo $id; ?>">Edit Application</a> | <a href="applications.php?page=modify&what=approve&id=<? echo $id; ?>">Approve Application</a> | <? 
	$null='<a href="applications.php?page=modify&what=deny&id=<? echo $id; ?>">Deny Application</a> | <a href="applications.php?page=modify&what=message&id=<? echo $id; ?>">Messages</a><br>'; ?>
	<a href="deny.php?id=<? echo $id; ?>">Deny Application</a> | Message applicant
	<?
	$app=MDB::queryFirstRow("SELECT * FROM atn_applications WHERE id=%i", $id);
	$appdata=json_decode($app["application"], TRUE);
	?>
	
	<table cellspacing="0">
	<tr><td class="td">Field</td><td class="td">Info</td><td class="td">Privacy Level</td></tr>
	<tr><td class="td">Legal Name:</td><td class="td"><? echo $appdata["first"]." ".$appdata["last"];?></td><td class="td"><? echo "<b>(".$appdata["name_privacy"].")";?></td></tr>
	<tr><td class="td">Preferred Name:</td><td class="td"><? echo $appdata["rname"];?></td><td class="td"><? echo "<b>(".$appdata["rname_privacy"].")";?></td></tr>
	<tr><td class="td">Preferred Pronouns:</td><td class="td"><? echo $appdata["pronouns"];?></td><td class="td"></td></tr>
	<tr><td class="td">Date of Birth:</td><td class="td"><? echo date("m/d/Y", strtotime($appdata["dob"]));?></td><td class="td"><? echo "<b>(".$appdata["dob_privacy"].")";?></td></tr>
	<tr><td class="td">Address:</td><td class="td"><? echo $appdata["street"]." ".$appdata["streetunit"]."<br>".
	$appdata["city"]." ".$appdata["state"]." ".$appdata["zip"]." ".$appdata["country"];
	?></td><td class="td"><? echo "<b>(".$appdata["address_privacy"].")";?></td></tr>
	<tr><td class="td">Email Address:</td><td class="td"><? echo $appdata["email"];?></td><td class="td"><? echo "<b>(".$appdata["email_privacy"].")";?></td></tr>
	<tr><td class="td">Phone:</td><td class="td"><? echo $appdata["phone"];?></td><td class="td"><? echo "<b>(".$appdata["phone_privacy"].")";?></td></tr>
	<tr><td class="td">Member Map:</td><td class="td"><? echo $appdata["membermap"];?></td><td class="td"></td></tr>
	<tr><td class="td">Solitary/Kindred:</td><td class="td"><? echo $appdata["solitary"];?></td><td class="td"></td></tr>
	<tr><td class="td">Military Member:</td><td class="td"><? echo $appdata["military"];?></td><td class="td"></td></tr>
	<?
	if (strtolower($appdata["military"]) != "no") {
	echo '<tr><td class="td">Branch:</td><td class="td">'.$appdata["branch"].'</td><td class="td"></td></tr>';	
	echo '<tr><td class="td">Country:</td><td class="td">'.$appdata["milcountry"].'</td><td class="td"></td></tr>';	
	}
	?>
	<tr><td class="td">Experience with Heathenry:</td><td class="td"><? echo $appdata["experience"];?></td><td class="td"></td></tr>
	<tr><td class="td">Define Asatru:</td><td class="td"><? echo $appdata["defineasatru"];?></td><td class="td"></td></tr>
	<tr><td class="td">Hopes for ATN:</td><td class="td"><? echo $appdata["hopes"];?></td><td class="td"></td></tr>
	<tr><td class="td">Questions/Comments:</td><td class="td"><? echo $appdata["questions"];?></td><td class="td"></td></tr>
	<tr><td class="td">How they found AtN:</td><td class="td"><? echo $appdata["howfound"];?></td><td class="td"></td></tr>
	<tr><td class="td">Who Referred Them:</td><td class="td"><? echo $appdata["referral"];?></td><td class="td"></td></tr>
	
	<tr><td class="td">Website:</td><td class="td"><? echo $appdata["website"];?></td><td class="td"><? echo "<b>(".$appdata["website_privacy"].")";?></td></tr>
	<tr><td class="td">Facebook:</td><td class="td"><? echo $appdata["facebook"];?></td><td class="td"><? echo "<b>(".$appdata["facebook_privacy"].")";?></td></tr>
	<tr><td class="td">Twitter:</td><td class="td"><? echo $appdata["twitter"];?></td><td class="td"><? echo "<b>(".$appdata["twitter_privacy"].")";?></td></tr>
	<tr><td class="td">Instagram:</td><td class="td"><? echo $appdata["instagram"];?></td><td class="td"><? echo "<b>(".$appdata["instagram_privacy"].")";?></td></tr>
	</table>
	<b>Notes:</b><br>
	<table border="1" cellspacing="0" width="50%"><tr><td width="20%">Author</td><td width="30%">Added</td><td>Note</td></tr>
	<?
	$notes=json_decode($app["notes"], true);
	foreach ($notes as $row) {
		echo '<tr><td>'.$row["author"].'</td><td>'.date("m/d/Y h:i:s A", $row["added"]).'</td><td>'.$row["note"].'</td></tr>';
	}
	?>
	</table><br><br>
	<b>Add note:</b><br>
	<form method="post" action="applications.php?page=view&id=<? echo $id; ?>&do=note">
	<textarea name="note" style="min-width: 500px; min-height: 100px;"></textarea><br>
	<input type="submit" value="Save Note"></form>
	<?
	
}

if ($page=="edit") {
	?><h1>Edit Application</h1>
	<a href="applications.php?page=view&id=<? echo $id; ?>">View Application</a> | <a href="applications.php?page=modify&what=approve&id=<? echo $id; ?>">Approve Application</a> | <a href="applications.php?page=modify&what=deny&id=<? echo $id; ?>">Deny Application</a> | <a href="applications.php?page=modify&what=message&id=<? echo $id; ?>">Messages</a><br>
	<?
	$app=MDB::queryFirstRow("SELECT * FROM atn_applications WHERE id=%i", $id);
	$appdata=json_decode($app["application"], TRUE);
	?><br>
	<form method="post" action="applications.php?page=view&do=update&id=<? echo $id; ?>">
	Here you can edit a persons application, and when approved these changes will go into the member registry.<br>Note that this is only to edit contact information. <br>You can't change the applicants privacy settings, or the answers to the 4 questions.<br><br>
	<table cellspacing="0">
	<tr><td class="td">Field</td><td class="td">Info</td><td class="td">Privacy Level</td></tr>
	<tr><td class="td">Legal Name:</td><td class="td"><input type="text" name="first" value="<? echo $appdata["first"]?>"> <input type="text" name="last" value="<? echo $appdata["last"];?>"></td><td class="td"><? echo $appdata["name_privacy"];?></td></tr>
	<tr><td class="td">Preferred Name:</td><td class="td"><input type="text" name="rname" value="<? echo $appdata["rname"];?>"></td><td class="td"><? echo $appdata["rname_privacy"];?></td></tr>
	<tr><td class="td">Preferred Pronouns:</td><td class="td"><input type="text" name="pronouns" value="<? echo $appdata["pronouns"];?>"></td><td class="td"></td></tr>
	<tr><td class="td">Date of Birth:</td><td class="td"><input type="text" name="dob" placeholder="Date of Birth" value="<? echo date("m/d/Y", strtotime($appdata["dob"])); ?>" class="form-control dob"></td><td><? echo $appdata["dob_privacy"]; ?><br><br>
	<tr><td class="td">Address:</td><td class="td"><input type="text" name="street" value="<? echo $appdata["street"]; ?>"> <input type="text" name="streetunit" size="5" value="<? echo $appdata["streetunit"];?>"><br>
	<input type="text" name="city" size="7" value="<? echo $appdata["city"];?>"> <input type="text" name="state" size="3" value="<? echo $appdata["state"];?>"> <input type="text" name="zip" size="6" value="<? echo $appdata["zip"];?>"> <input type="text" name="country" size="5" value="<? echo $appdata["country"]; ?>"><br>
	</td><td class="td"><? echo $appdata["address_privacy"];?></td></tr>
	<tr><td class="td">Email Address:</td><td class="td"><input type="text" name="email" value="<? echo $appdata["email"];?>"></td><td class="td"><? echo $appdata["email_privacy"];?></td></tr>
	<tr><td class="td">Phone:</td><td class="td"><input type="text" name="phone" value="<? echo $appdata["phone"];?>"></td><td class="td"><? echo $appdata["phone_privacy"];?></td></tr>
	<tr><td class="td">Member Map:</td><td class="td"><? echo $appdata["membermap"];?></td><td class="td"></td></tr>
	<tr><td class="td">Solitary/Kindred:</td><td class="td"><? echo $appdata["solitary"];?></td><td class="td"></td></tr>
	<tr><td class="td">Military Member:</td><td class="td"><? echo $appdata["military"];?></td><td class="td"></td></tr>
	<?
	if (strtolower($appdata["military"]) != "no") {
	echo '<tr><td class="td">Branch:</td><td class="td">'.$appdata["branch"].'</td><td class="td"></td></tr>';	
	echo '<tr><td class="td">Country:</td><td class="td">'.$appdata["milcountry"].'</td><td class="td"></td></tr>';	
	}
	?>
	<tr><td class="td">Experience with Heathenry:</td><td class="td"><? echo $appdata["experience"];?></td><td class="td"></td></tr>
	<tr><td class="td">Define Asatru:</td><td class="td"><? echo $appdata["defineasatru"];?></td><td class="td"></td></tr>
	<tr><td class="td">Hopes for ATN:</td><td class="td"><? echo $appdata["hope"];?></td><td class="td"></td></tr>
	<tr><td class="td">Questions/Comments:</td><td class="td"><? echo $appdata["questions"];?></td><td class="td"></td></tr>
	
	<tr><td class="td">Website:</td><td class="td"><input type="text" name="website" value="<? echo $appdata["website"];?>"></td><td class="td"><? echo "<b>(".$appdata["website_privacy"].")";?></td></tr>
	<tr><td class="td">Facebook:</td><td class="td"><input type="text" name="facebook" value="<? echo $appdata["facebook"];?>"></td><td class="td"><? echo "<b>(".$appdata["facebook_privacy"].")";?></td></tr>
	<tr><td class="td">Twitter:</td><td class="td"><input type="text" name="twitter" value="<? echo $appdata["twitter"];?>"></td><td class="td"><? echo "<b>(".$appdata["twitter_privacy"].")";?></td></tr>
	<tr><td class="td">Instagram:</td><td class="td"><input type="text" name="instagram" value="<? echo $appdata["instagram"];?>"></td><td class="td"><? echo "<b>(".$appdata["instagram_privacy"].")";?></td></tr>
	</table><br>
	<input type="submit" value="Update Application">
	
	<script>
    $(function() {
      var $dob = $('.dob');
      

      $dob.datepicker({
        autoHide: true,
		
      });
      
    });
  </script>
	
	<?
	
}
?>
</div>

