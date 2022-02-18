<?
require("/home/intheexp/atn.bigskyheathen.com/members/db.php");
require("/home/intheexp/atn.bigskyheathen.com/members/functions.php");
require_once '/home/intheexp/atn.bigskyheathen.com/members/vendor/autoload.php';
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
<div class="uk-card-default  uk-card-body">
<center><img src="logo2.png" width="50%"><br>
		Your email address has been verified.<Br>
		Your application will be forwarded to our Chancellor of Member Affairs, Alex LaFountain for approval.<br>
		Unlike joining a typical website, to maintain a safe and inclusive community, all applications are vetted before they are approved. <br>
		If for any reason we need more information from you in order to approve your application, we will email you at the address you provided.<br><br>
		We thank you for your patience and hope to have your application approved soon.<br>
		-Awaken The North.<Br>
		<a href="http://www.awakenthenorth.org">www.awakenthenorth.org</a><br>
	<a href="https://www.facebook.com/AwakenTheNorth/">www.facebook.com/AwakenTheNorth</a><br>
<br>
<h3>Help support AtN</h3>
	</center>	

While you are waiting for your membership application to be processed, please consider making a donation to Awaken the North.<br>
Awaken the North is in the process of becoming a 501c3 Organization.<br>
We have many goals in the works. We are going to be distributing pocket altars to memebrs of the armed services, and eventually even first responders.<Br>
Our resident Goði, Casey "Beast" Clark is working hard on a Goðar Training Program, as well as a Pocket Havamal and a Study Havamal.<br>
Whether it is $1.00 or $100.00, every bit helps spread the reach of Inclusive Heathenry.<br><br>
As an incentive to donate, you'll be able to recieve the following perks based on your donation amount:<br><br>
<div uk-lightbox="animation: fade">
    <a href="stickers.png"><img src="stickers.png" width="200px"></a>
	<a href="cert.png"><img src="cert.png" width="200px"></a>
</div>
<ul>
<li><b>$5</b> - ATN sticker<br>
<li><b>$10</b> - ATN sticker, Numbered Member Certificate<br>
<li><b>$20</b> - ATN sticker, Numbered Member Certificate, ATN etched shot glass<br>
<li><b>$35</b> - ATN sticker, Numbered Member Certificate, ATN etched shot glass, ATN etched pint glass <br>
<li><b>$50</b> - ATN sticker, Numbered Member Certificate, ATN etched shot glass, ATN etched pint glass, ATN Shirt<br>
</ul>
<br>

<script>
function donate5() { 
    var myText = '<div width="100%"><h3>$5 donation</h3>' +
	'<form method="post" action="donate.php?page=donate&amount=5">'+
	'Select Sticker Color: <select name="color" class="uk-select"><option value="black">Black</option><option value="white">White</option></select>'+
	'<input type="submit" value="Continue" class="uk-form-large"></form>';

    document.getElementById('donateform').innerHTML = myText;
}
function donate10() { 
    var myText = "$10 donation";
    document.getElementById('donateform').innerHTML = myText;
}
function donate20() { 
    var myText = "$20 donation";
    document.getElementById('donateform').innerHTML = myText;
}
function donate35() { 
    var myText = "$35 donation";
    document.getElementById('donateform').innerHTML = myText;
}
function donate50() { 
    var myText = "$50 donation";
    document.getElementById('donateform').innerHTML = myText;
}
</script>
<h3>Select a donation amount:</h3>
<button onclick="donate5()" class="uk-form-large" />$5</button>
<button onclick="donate10()" class="uk-form-large" />$10</button>
<button onclick="donate20()" class="uk-form-large" />$20</button>
<button onclick="donate35()" class="uk-form-large" />$35</button>
<button onclick="donate50()" class="uk-form-large" />$50</button><br><br>
<style>optgroup { font-size:20px; }</style>
<div id="donateform"></div>
<br><br>
As part of our mission to be transparent to our members, in the member portal, you will soon be able to see the donations we recieve, and what we are spending this money on.<Br>
Once this system is up and running, it will be updated on a regular basis.<br>