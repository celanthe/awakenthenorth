<?php
require_once 'users/init.php';
require("db.php");
require("functions.php");
require_once '/home/intheexp/atn.bigskyheathen.com/members/vendor/autoload.php';
//require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
if(isset($user) && $user->isLoggedIn()){
	$loggedin = 1;
} else {
	$loggedin=0;
}
//print_r(fetchUserPermissions($user->data()->id));


?>

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
   
	</head>
<body style="background-color: 000000;">

<div class="uk-container">
<? echo navbar("main"); ?>

<div class="uk-card-default  uk-card-body">
<center><img src="logo2.png" width="50%"><br><br>
Welcome to the AtN Member Portal.<br>
<?
if ($loggedin == 1) {
	echo '
This is where you will be able to update your member information and privacy settings, view AtN Financial status, apply for training programs, and participate in elections.<br><br>
This portal is still under construction, and will be functional soon. An email will be sent out to all members when it is up and running.<br>';
} else {
	echo 'If you are not an AtN member, <a href="https://members.awakenthenorth.org/application.php">click here to apply</a>. If you are, <a href="http://members.awakenthenorth.org/users/login.php">click here to login</a><br>';
}
?>



</div>

