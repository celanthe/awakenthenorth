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
if (isset($_GET["id"])) {
	$id=$_GET["id"];
} else {
	echo "error";
	exit();
}
if (isset($_GET["page"])) {
	$page=$_GET["page"];
} else {
	$page="start";
}

if ($page=="start") {
	$app=MDB::queryFirstRow("SELECT * FROM atn_applications WHERE id=%i", $id);
	$appdata=json_decode($app["application"], TRUE);
	?>
	<h2>Deny Application</h2>
	
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
	Denial Reason:
	<form method="post" action="deny.php?id=<? echo $id; ?>&page=letter">
	<input type="hidden" name="name" value="<? echo $appdata["first"]." ".$appdata["last"]; ?>">
	<table>
	<?
	$reasons=MDB::query("SELECT * FROM atn_denials_reasons");
	foreach ($reasons as $row) {
		echo '<tr><td><input type="radio" name="reason" value="'.$row["id"].'"><td>'.$row["message"].'</td></tr>';
	}
	?>
	</table><br>
	If this is a for cause denial, select where we had a problem with application:<br>
	<input type="checkbox" name="cause[]" value="Application">Application &nbsp;-&nbsp;
	<input type="checkbox" name="cause[]" value="Social Media">Social Media &nbsp;-&nbsp;
	<input type="checkbox" name="cause[]" value="Other Affiliations">Affiliations<br>
	<br>
	Additional message you want to include in the email:<br>
	<textarea name="message" cols="60" rows="5"></textarea><br><br>
	For internal use only, please note any information that lead you to deny this application. <br>
	Members will never see this:<br>
	<textarea name="notes" cols="60" rows="5"></textarea><br><br>
	Click proceed To view the denial letter, and make any changes before it is sent.<br>
	 
	<input type="submit" value="Proceed"></form>
	<?
}
if ($page=="letter") {
	$reason=$_POST["reason"];
	$cause=$_POST["cause"];
	$notes=$_POST["notes"];
	$message=$_POST["message"];
	$name=$_POST["name"];
	$rdb=MDB::queryFirstRow("SELECT * FROM atn_denials_reasons WHERE id=%i", $reason);
	$letters=MDB::queryFirstRow("SELECT * FROM atn_email_templates WHERE code=%s", $rdb["template"]);
	$body_html=str_replace("{{name}}", $name, $letters["body_html"]);
	$body_html=str_replace("{{criteria}}", implode(", ", $cause), $body_html);
	$body_html=str_replace("{{note}}", $message, $body_html);
	?>
	<script src="js/tinymce/jquery.tinymce.min.js"></script>
	<script src="js/tinymce/tinymce.min.js"></script>
	
	<form method="post" action="deny.php?page=send&id=<? echo $id; ?>">
	<input type="hidden" name="reason" value="<? echo $reason; ?>">
	<input type="hidden" name="notes" value="<? echo $notes; ?>">
	Subject Line: <input type="text" name="subject" size="100" value="<? echo $letters["subject"]; ?>"><br>
	Email Body:<br>
	<textarea id="text" name="text"><? echo $body_html; ?></textarea><br>
	
	<input type="checkbox" checked name="sendemail" value="yes"> Send denial letter. Uncheck to deny application without sending email.<br>
	<input type="submit" value="Deny Application">
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
if ($page=="send") {
	$subject=$_POST["subject"];
	$sendemail=$_POST["sendemail"];
	$text=$_POST["text"];
	$reason=$_POST["reason"];
	$notes=$_POST["notes"];
	$app=MDB::queryFirstRow("SELECT * FROM atn_applications WHERE id=%i", $id);
	$toemail[]=$app["email"];
	MDB::update("atn_applications", array("status"=>3), "id=%i", $id);
	MDB::insert("atn_denials", array("appid"=>$id, "reason"=>$reason, "notes"=>$notes, "email"=>$app["email"]));
	if ($sendemail == "yes") {
	$text=str_replace('img src="../', 'img src="https://members.awakenthenorth.org/', $text);
	$ptext=strip_tags($text);
	
	$transport = (new Swift_SmtpTransport(MAIL_SERVER, MAIL_PORT))
  ->setUsername(MAIL_USERNAME)
  ->setPassword(MAIL_PASSWORD)
;

// Create the Mailer using your created Transport

$mailer = new Swift_Mailer($transport);
$bcctoemail[]="chris.claus42@gmail.com";
//$bcctoemail[]="atn@awakenthenorth.org";

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
MDB::insert("atn_emails_sent", array("date"=>time(), "to"=>json_encode(array_merge($toemail, $bcctoemail)), "subject"=>$subject, "body"=>$text));
echo "<h2>Application Denied</h2><h3>Denial Letter Sent</h3>";
} else {
	echo "<h2>Application Denied</h2><h3>Denial Letter NOT Sent</h3>";
}
}
?>