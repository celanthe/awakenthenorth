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

if (isset($_GET["type"])) {
	$type=$_GET["type"];
} else {
	exit();
}

if ($type=="application" && isset($_GET["id"])) {
	$id=$_GET["id"];
	$app=MDB::queryFirstRow("SELECT * FROM atn_applications WHERE id=%i", $id);
	$text=$_POST["text"];
	$text=str_replace('img src="../', 'img src="https://members.awakenthenorth.org/', $text);
	$subject=$_POST["subject"];
	$ptext=strip_tags($text);
	
	$transport = (new Swift_SmtpTransport(MAIL_SERVER, MAIL_PORT))
  ->setUsername(MAIL_USERNAME)
  ->setPassword(MAIL_PASSWORD)
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message
$message = (new Swift_Message($subject))
  ->setFrom(['noreply@awakenthenorth.org' => 'Awaken The North'])
  ->setTo([$app["email"]])
  ->setBody($text, 'text/html')
  ->addPart($ptext, 'text/plain')
  ;

// Send the message
$result = $mailer->send($message);
//echo $text;
echo "sent";
	
}
?>