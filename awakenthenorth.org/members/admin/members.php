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

if (isset($_GET["do"])) {
	$do=$_GET["do"];
	if ($do=="ban") {
		if (isset($_GET["id"])) {
			$id=$_GET["id"];
			$banreason=$_POST["notes"];
			$doban=$_POST["doban"];
			if ($doban=="yes") {
				$mem=MDB::queryFirstRow("SELECT * FROM atn_cmr WHERE id=%i", $id);
				if (!empty($mem["notes"])) {
					$notes=json_decode($mem["notes"], true);
				} else {
					$notes=array();
				}
				//[{"author":"Casey Clark","added":1619749905,"note":"Approved by Beast"}]
				$notes[]=array("author"=>"SYSTEM", "added"=>time(), "note"=>"Member banned by ".$author.". Reason: ".$banreason);
				MDB::update("atn_cmr", array("status"=>9, "notes"=>json_encode($notes), "map"=>"no"), "id=%i", $id);
				echo "<h1>Member Banned</h1>";
			}
			
		}
	}
}
if (isset($_GET["page"])) { $page=$_GET["page"]; } else { $page="index"; }

if ($page=="index") {
?>
<h2>Member Registry</h2>
<table border="1" cellspacing="0">
<tr><td>Member ID</td><td>Legal Name</td><td>Preferred Name</td><td>Military</td><td>State</td><td>Country</td><td>Joined</td><td>Birthdate</td><td>Referral</td><td>How They Found AtN</td><td>Status</td><td>Level</td><tr>
<?
$members=MDB::query("SELECT * FROM atn_cmr");
foreach ($members as $row) {
	$m=json_decode($row["military"], true);
	$mil=$m["military"];
	$app=MDB::queryFirstRow("SELECT * FROM atn_applications WHERE id=%i", $row["appid"]);
		$appdata=json_decode($app["application"], true);
	echo '<tr><td>'.$row["id"].'</td><td><a href="members.php?page=view&id='.$row["id"].'">'.$row["first"].' '.$row["last"].'</a></td><td>'.$row["pname"].'</td><td>'.$mil.'</td><td>'.$row["state"].'</td><td>'.$row["country"].'</td><td>'.date("m/d/Y", $row["joined"]).'</td><td class="td">'.$appdata["dob"].'</td><td>'.$appdata["referral"].'</td><td>'.$appdata["howfound"].'</td><td>'.member_status($row["status"]).'</td><td>'.member_level($row["level"]).'</td></tr>';
}
?>
</table><br><br>
<textarea style="min-width: 400px; min-height: 200px;">
<?
$emembers=MDB::query("SELECT * FROM atn_cmr WHERE status<9");
foreach ($emembers as $row) {
	echo $row["email"]."; ";
}
?>
</textarea>
</div>
<?
}
if ($page=="function") {
	
	if (isset($_GET["id"])) {
		$id=$_GET["id"];
		$what=$_POST["what"];
		//echo "hello";
	if (!isset($_POST["what"]) || $what=="" || $what=="null") { $page="view"; }	
		$mem=MDB::queryFirstRow("SELECT * FROM atn_cmr WHERE id=%i", $id);
		
		if ($what=="ban") {
			echo '<h2>Ban Member</h2><br>
			<form method="post" action="members.php?do=ban&id='.$id.'">
			You are attempting to ban '.$mem["first"].' '.$mem["last"].'<br>
			Check this box if this is correct: <input type="checkbox" unchecked name="doban" value="yes"><br>
			Please explain why you are banning this member:<br>
			<textarea name="notes"></textarea><br>
			<input type="submit" value="Ban"></form>';
		}
	}
	
}
if ($page=="view") {
	if (isset($_GET["id"])) {
		$id=$_GET["id"];
		$mem=MDB::queryFirstRow("SELECT * FROM atn_cmr WHERE id=%i", $id);
		$app=MDB::queryFirstRow("SELECT * FROM atn_applications WHERE id=%i", $mem["appid"]);
		$appdata=json_decode($app["application"], true);
		$privacy=json_decode($mem["privacy"], true);
		$military=json_decode($mem["military"], true);
		$social=json_decode($mem["socialmedia"], true);
		
		?>
		<h2>Member Info</h2>
		<a href="members.php">Return to Member Registry</a><br><br>
		<table cellspacing="0">
	<tr><td class="td">Field</td><td class="td">Info</td><td class="td">Privacy Level</td></tr>
	<tr><td class="td">Legal Name:</td><td class="td"><? echo $mem["first"]." ".$mem["last"];?></td><td class="td"><? echo "<b>(".$privacy["name_privacy"].")";?></td></tr>
	<tr><td class="td">Preferred Name:</td><td class="td"><? echo $mem["pname"];?></td><td class="td"><? echo "<b>(".$privacy["rname_privacy"].")";?></td></tr>
	<tr><td class="td">Preferred Pronouns:</td><td class="td"><? echo $mem["pronouns"];?></td><td class="td"></td></tr>
	<tr><td class="td">Date of Birth:</td><td class="td"><? if (!empty($mem["dob"])) { echo date("m/d/Y", strtotime($mem["dob"])); }?></td><td class="td"><? echo "<b>(".$privacy["dob_privacy"].")";?></td></tr>
	<tr><td class="td">Address:</td><td class="td"><? echo $mem["address"]." ".$mem["address2"]."<br>".
	$mem["city"]." ".$mem["state"]." ".$mem["zip"]." ".$mem["country"];
	?></td><td class="td"><? echo "<b>(".$privacy["address_privacy"].")";?></td></tr>
	<tr><td class="td">Email Address:</td><td class="td"><? echo $mem["email"];?></td><td class="td"><? echo "<b>(".$privacy["email_privacy"].")";?></td></tr>
	<tr><td class="td">Phone:</td><td class="td"><? echo $mem["phone"];?></td><td class="td"><? echo "<b>(".$privacy["phone_privacy"].")";?></td></tr>
	<tr><td class="td">Member Map:</td><td class="td"><? echo $mem["map"];?></td><td class="td"></td></tr>
	<tr><td class="td">Solitary/Kindred:</td><td class="td"><? echo $mem["solitary"];?></td><td class="td"></td></tr>
	<tr><td class="td">Military Member:</td><td class="td"><? echo $military["military"];?></td><td class="td"></td></tr>
	<?
	if (strtolower($military["military"]) != "no") {
	echo '<tr><td class="td">Branch:</td><td class="td">'.$military["branch"].'</td><td class="td"></td></tr>';	
	echo '<tr><td class="td">Country:</td><td class="td">'.$military["milcountry"].'</td><td class="td"></td></tr>';	
	}
	?>
	<tr><td class="td">Experience with Heathenry:</td><td class="td"><? echo $appdata["experience"];?></td><td class="td"></td></tr>
	<tr><td class="td">Define Asatru:</td><td class="td"><? echo $appdata["defineasatru"];?></td><td class="td"></td></tr>
	<tr><td class="td">Hopes for ATN:</td><td class="td"><? echo $appdata["hopes"];?></td><td class="td"></td></tr>
	<tr><td class="td">Questions/Comments:</td><td class="td"><? echo $appdata["questions"];?></td><td class="td"></td></tr>
	<tr><td class="td">How they found AtN:</td><td class="td"><? echo $appdata["howfound"];?></td><td class="td"></td></tr>
	<tr><td class="td">Who Referred Them:</td><td class="td"><? echo $appdata["referral"];?></td><td class="td"></td></tr>
	
	<tr><td class="td">Website:</td><td class="td"><? echo $social["website"];?></td><td class="td"><? echo "<b>(".$privacy["website_privacy"].")";?></td></tr>
	<tr><td class="td">Facebook:</td><td class="td"><? echo $social["facebook"];?></td><td class="td"><? echo "<b>(".$privacy["facebook_privacy"].")";?></td></tr>
	<tr><td class="td">Twitter:</td><td class="td"><? echo $social["twitter"];?></td><td class="td"><? echo "<b>(".$privacy["twitter_privacy"].")";?></td></tr>
	<tr><td class="td">Instagram:</td><td class="td"><? echo $social["instagram"];?></td><td class="td"><? echo "<b>(".$privacy["instagram_privacy"].")";?></td></tr>
	</table>
		<b>Notes:</b><br>
	<table border="1" cellspacing="0" width="50%"><tr><td width="20%">Author</td><td width="30%">Added</td><td>Note</td></tr>
	<?
	$notes=json_decode($mem["notes"], true);
	foreach ($notes as $row) {
		echo '<tr><td>'.$row["author"].'</td><td>'.date("m/d/Y h:i:s A", $row["added"]).'</td><td>'.$row["note"].'</td></tr>';
	}
	?>
	</table><br><br>
	<br><br><br><br><br><br><br>
	<form method="post" action="members.php?page=function&id=<? echo $id; ?>">
	<select name="what"><option value="null"></option>
	<option value="ban">Ban Member</option></select>
	<input type="submit" value="Execute"></form>
		<?
	}
}

