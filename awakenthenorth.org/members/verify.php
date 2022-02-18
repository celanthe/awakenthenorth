<?
require("/home/intheexp/atn.bigskyheathen.com/members/db.php");
require("/home/intheexp/atn.bigskyheathen.com/members/functions.php");
require_once '/home/intheexp/atn.bigskyheathen.com/members/vendor/autoload.php';
if (isset($_GET["code"])) {
	$key=$_GET["code"];
	$app=MDB::queryFirstRow("SELECT * FROM atn_applications WHERE `key`=%s", $key);
	if ($app["verified"] == 0) {
	if ($key == MD5($app["id"]."::".$app["email"])) {
		MDB::update("atn_applications", array("verified"=>1), "id=%i", $app["id"]);
		$deets=json_decode($app["application"], true);
		if (strtolower($deets["military"]) == "no") {
			email_staff("new", $app["id"]);
		} else {
		email_staff("new", $app["id"], "yes");
		}
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
		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
		<link rel="manifest" href="/site.webmanifest">

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
As an incentive to donate, you'll be able to recieve the following perks based on your donation amount:<br>
<ul>
<li><b>$5</b> - ATN sticker<br>
<li><b>$10</b> - ATN sticker, Numbered Member Certificate<br>
<li><b>$20</b> - ATN sticker, Numbered Member Certificate, ATN etched shot glass<br>
<li><b>$35</b> - ATN sticker, Numbered Member Certificate, ATN etched shot glass, ATN etched pint glass<br>
<li><b>$50</b> - ATN sticker, Numbered Member Certificate, ATN etched shot glass, ATN etched pint glass, ATN Shirt<br>
</ul>
<br>

<style>optgroup { font-size:20px; }</style>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_donations" />
<input type="hidden" name="business" value="784M5LRES7ERG" />
<input type="hidden" name="item_name" value="Membership Donation" />
<input type="hidden" name="currency_code" value="USD" />
<table><tr><td><select name="amount" style="height: 50px; font-size: 20px;">
<optgroup>
<option value="1">$1.00</option>
<option value="5">$5.00</option>
<option value="10">$10.00</option>
<option value="15">$15.00</option>
<option value="20">$20.00</option>
<option value="25">$25.00</option>
<option value="30">$30.00</option>
<option value="35">$35.00</option>
<option value="40">$40.00</option>
<option value="45">$45.00</option>
<option value="50">$50.00</option>
<option value="75">$75.00</option>
<option value="100">$100.00</option>
</optgroup>
</select></td><td>
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
</form>
</td></tr></table><br><br>

As part of our mission to be transparent to our members, in the member portal, you will soon be able to see the donations we recieve, and what we are spending this money on.<Br>
Once this system is up and running, it will be updated on a regular basis.<br>
		<?
	} else {
		echo "Invalid Key<br>";
		//echo $app["id"]."::".$app["email"]."<br>";
		//echo MD5($app["id"]."::".$app["email"])."<br>";
		//echo $key;
		
		exit();
	}
	
} else {
	echo "Email address already verified.";
	exit();
}
} else {
	echo "Missing Key";
	exit();
}