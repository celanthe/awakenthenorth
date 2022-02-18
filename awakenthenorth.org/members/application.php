<?
require("/home/intheexp/atn.bigskyheathen.com/members/db.php");
require("/home/intheexp/atn.bigskyheathen.com/members/functions.php");
require_once '/home/intheexp/atn.bigskyheathen.com/members/vendor/autoload.php';
//error_reporting(E_ALL);
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
		<link rel="stylesheet" href="includes/datepicker.css">
		<script src="includes/datepicker.js"></script>
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
<?
if (isset($_GET["do"])) { $do=$_GET["do"]; } else { $do="showapp"; }

if ($do=="showapp") {
	?>
<div class="uk-container">
<div class="uk-card-default  uk-card-body">
<center><img src="logo2.png" width="50%"><br>
<span class="uk-heading-small">Membership Application</span><br></center><br>
</div>
<? echo spacer(); ?>
<div class="uk-card-default  uk-card-body">
<center><b>About member information privacy:</b></center><br>
<div style="height: 200px; overflow-y: scroll; border: 1px solid grey; background-color: FFFFFF;">
All members have full control over the privacy of their personally identifiable information.<br>
You will be able to update your information and privacy settings at any time.<br>
The three privacy settings are as follows:<br>
<b>Publishable:</b> Any information you mark as Publishable will be viewable to non-members on our websites member database. This is helpful to people curious about ATN, they can see if there are members in their area and contact them to ask about ATN.<br>
<b>Sharable:</b> Any information you mark as Sharable will be visible only to members who are logged in to our website. This helps members contact other members in their area or in areas they may be travelling to.<br>
<b>Confidential:</b> Any information you mark as Confidential will only be viewable to the Awaken The North Council, Chancellors and Chairs, as needed in the course of their duties. It will not be published on the website, or viewable to any outside parties.<br><br>
<b>The Member Map:</b><br>
The Member Map will be publically viewable on our website and will show a pin in the City of every Awaken The North Member. If you opt in to the member map below, your pin will include any contact information that you mark as Publishable viewable to non-members, or Sharable, viewable only to members. If you select No to the member map below, your pin will not include any identifiable information.<Br>
</div><br>
</div>
<form method="post" id="joinform" action="application.php?do=save">
<? echo spacer(); ?>
<div class="uk-card-default  uk-card-body">
<center><b>Contact Information:</b></center><br>
Legal Name:<br><input class="uk-input uk-form-width-small" type="text" placeholder="First" name="first" id="first" required> <input class="uk-input uk-form-width-small" type="text" placeholder="Last" name="last" id="last" required> &nbsp; <? echo priv_form("name"); ?><br><br>
Preferred Name (optional):<br><input class="uk-input uk-form-width-small" type="text" name="rname" id="rname"> &nbsp; <? echo priv_form("rname"); ?><br>
How do you want your name printed on your member certificate: <select name="namedisp" class="uk-select uk-form-width-small" id="namedisp">
<option value="1">First Last</option>
<option value="2">Preferred</option>
<option value="3">Preferred Last</option></select><br>
<br>
What are your pronouns? (optional):<Br><input class="uk-input uk-form-width-small" type="text" name="pronouns" id="pronouns"><br><br>
Date of Birth (mm/dd/yyyy):<br>
<input type="date"  name="dob" id="dob" class="form-control dob uk-input uk-form-width-medium"> &nbsp; <? echo priv_form("dob"); ?><br><br>
Address:  &nbsp; <? echo priv_form("address"); ?><br>
<input class="uk-input uk-form-width-medium" type="text"name="street" id="street" placeholder="123 Main Street" required>&nbsp;
<input class="uk-input uk-form-width-xsmall" type="text" name="streetunit" id="streetunit" placeholder="Apt B"><br>
<input class="uk-input uk-form-width-medium" type="text" name="city" id="city" placeholder="Anytown" required>&nbsp;
<input class="uk-input uk-form-width-small" type="text" name="state" id="tate" placeholder="State" required>&nbsp;
<input class="uk-input uk-form-width-small" type="text" name="zip" id="zip" placeholder="12345" required><br>
<input class="uk-input uk-form-width-medium" type="text" name="country" id="country" placeholder="Country"><br><br>

Email Address:<br><input class="uk-input uk-form-width-medium" type="text" name="email" id="email" required>&nbsp; <? echo priv_form("email"); ?><br><br>
Phone Number (optional):<br><input class="uk-input uk-form-width-medium" type="text" name="phone" id="phone">&nbsp; <? echo priv_form("phone"); ?><br><br>
</div>
<? echo spacer(); ?>
<div class="uk-card-default  uk-card-body">
<center><b>Member Questions:</b></center><br>
<select class="uk-select uk-form-width-small" name="membermap" required><option value="">---</option><option value="no">No</option><option value="yes">Yes</option></select>Do you want to be added to the member map?<br><br>
Are you a solitary practitioner, a member of a local kindred, or still searching for your path? 
<select class="uk-select" name="solitary" style="width: 100px;"><option name="solitary">Solitary</option><option name="kindred">Member of a Kindred</option><option name="searching">Still Searching</option></select><br><br>
We value our military members! Have you ever or are you currently serving in any branch of any military, whether US or otherwise?<Br>
If so, which branch and which country of service?:<br>
<select class="uk-select uk-form-width-small" name="military"><option name="no">No</option><option name="current">Currently Serving</option><option value="retired">Retired/Veteran</option></select>&nbsp;
<input class="uk-input uk-form-width-medium" type="text" name="branch" id="branch" placeholder="Branch">&nbsp;
<input class="uk-input uk-form-width-small" type="text" name="milcountry" id="milcountry" placeholder="Country"><br>
</div>
<? echo spacer(); ?>
<div class="uk-card-default  uk-card-body">
<center><b>Please take a moment to review our mission and inclusivity statements and answer the following
questions.</b></center><br>

<div style="height: 200px; overflow-y: scroll; border: 1px solid grey;  background-color: FFFFFF;">
Awaken the North Mission Statement<br><br>
Awaken the North is an all inclusive group of heathens whom have come together in
solidarity and frith to honor the Norse Pantheon. We accept people from all walks of life
regardless of sex, gender, gender identity, ability, nationality, ethnicity, age, sexual
orientation, race, faith or creed. We embrace our differences and celebrate the
uniqueness of others. <br>
With a strong Zero Hate tolerance, Awaken the North will not
stand for racism, bigotry, or xenophobia of any kind. Our goal is to create a safe space
for all, where we may learn, grow, and support each other on our spiritual walks through
Heathenry. <br>
We are a Heathen organization, dedicated to the worship and veneration of the Old Gods.
</div><br>

<div style="height: 200px; overflow-y: scroll; border: 1px solid grey;  background-color: FFFFFF;">
Awaken the North Inclusivity Statement<br><br>
Awaken the North is an all inclusive group of Heathens whom have come together in solidarity and frith to honor the Norse Pantheon. <br>
We accept people from all walks of life regardless of sex, gender, gender identity, ability, nationality, ethnicity, age, sexual orientation, race, faith or creed. <br>
We embrace our differences and celebrate the uniqueness of others. With a strong Zero Hate tolerance, 
Awaken the North will not stand for racism, bigotry, or xenophobia of any kind. <br>
Our goal is to create a safe space for all, where we may learn, grow, and support each other on our spiritual walks through Heathenry. <br>
We are a Heathen organization, dedicated to the worship and veneration of the Old Norse Gods.
</div><br>

<select class="uk-select uk-form-width-small" name="acceptmission" required><option value="">---</option><option value="no">No</option><option value="yes">Yes</option></select>Having read these statements, do you object to anything within these statements?<br><br>
<select class="uk-select uk-form-width-small" name="acceptstance" required><option value="">---</option><option value="no">No</option><option value="yes">Yes</option></select>Awaken the North takes a firm stance against racism and folkish behavior. Do you
support this stance?<br><br>
<select class="uk-select uk-form-width-small" name="acceptrules" required><option value="">---</option><option value="no">No</option><option value="yes">Yes</option></select>Do you agree to abide by the rules of the group, maintaining frith?<br><br>
What is your experience with Heathenry?:<br>
<textarea class="uk-textarea" name="experience" style="min-height: 100px;" required></textarea><br><br>
In your own words, define Asatru:<br>
<textarea class="uk-textarea" name="defineasatru" style="min-height: 100px;" required></textarea><br><br>
What do you hope to get out of this organization as a member?:<br>
<textarea class="uk-textarea" name="hopes" style="min-height: 100px;" required></textarea><br><br>
Do you have any questions or concerns?:<br>
<textarea class="uk-textarea" name="questions" style="min-height: 100px;"></textarea><br><br>
How did you find Awaken the North?:<br>
<textarea class="uk-textarea" name="howfound" style="min-height: 100px;"></textarea><br><br>
Did another member reccomend that you join AtN? If so, let us know who so we can thank them:<br>
<input type="text" class="uk-input uk-form-width-large" name="referral"><br><br>

</div>
<? echo spacer(); ?>
<div class="uk-card-default  uk-card-body">
<? echo spacer(); ?>
<div class="uk-card-default  uk-card-body">
<center><b>Social Media:</b></center><br>
Website:<br><input class="uk-input uk-form-width-medium" type="text" name="website" id="website">&nbsp; <? echo priv_form("website"); ?><br><br>
Facebook:<br><input class="uk-input uk-form-width-medium" type="text" name="facebook" id="facebook">&nbsp; <? echo priv_form("facebook"); ?><br><br>
Twitter:<br><input class="uk-input uk-form-width-medium" type="text" name="twitter" id="twitter">&nbsp; <? echo priv_form("twitter"); ?><br><br>
Instagram:<br><input class="uk-input uk-form-width-medium" type="text" name="instagram" id="instagram">&nbsp; <? echo priv_form("instagram"); ?><br><br>

</div>

<div class="uk-card-default  uk-card-body">
<center><b>Website Access:</b></center><br>
Username:<br><input class="uk-input uk-form-width-medium" type="text" name="username" id="username" required><br>
Password:<br><input class="uk-input uk-form-width-medium" type="password" name="password1" id="password1"><br>
Confirm Password:<br><input class="uk-input uk-form-width-medium" type="password" name="password2" id="password2"><br>
Note: Password must be at least 8 characters long. We reccomend including numbers and at least one symbol such as !@#$%<br>
This username and password will be used to log in to the member portal for updating your information, and for logging into the main website.<br>

</div>
<center><input type="submit" value="Join ATN" class="uk-form-large"></center></div>
</form>
<script>
$("#joinform").validate({
  rules: {
    email: {
      required: true,
      email: true
    }
	password1 : {
        minlength : 8
    },
    password2 : {
        minlength : 8,
        equalTo : "#password1"
    }
  }
});

    $(function() {
      var $dob = $('.dob');
      

      $dob.datepicker({
        autoHide: true,
		
      });
      
    });
  </script>
</div>
<?
}
else if ($do=="save") {

$app=$_POST;
$applications=MDB::query("SELECT * FROM atn_applications WHERE email = %s", $email);
if (!$applications) {
	$ip1=$_SERVER['HTTP_X_FORWARDED_FOR'];
	$ip2=$_SERVER['REMOTE_ADDR'];
MDB::insert("atn_applications", array("submitted"=>time(), "status"=>1, "notes"=>"", "verified"=>0, "key"=>"", "email"=>$app["email"], "application"=>json_encode($app), "versent"=>time(), "ip"=>$ip1, "ipforwarded"=>$ip2));
$id=MDB::insertId();
$code=MD5($id."::".$app["email"]);
MDB::update("atn_applications", array("key"=>$code), "id=%i", $id);

$transport = (new Swift_SmtpTransport('mail.awakenthenorth.org', 2525))
  ->setUsername('noreply@awakenthenorth.org')
  ->setPassword('password')
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);
/*
$toemail[]="coma@awakenthenorth.org";
if ($app["military"] != "no") {
	$toemail[]="coms@awakenthenorth.org";
}
*/
$bodyh='
<img src="'.SITE_URL.'logo2.png"><br>
Dear '.$app["first"].' '.$app["last"].',<br>
Thank you for applying for membership to Awaken The North.<br><br>
There are two steps left before you become an AtN member.<br>
First, you must verify your email address by clicking this link: <a href="http://members.awakenthenorth.org/verify.php?code='.$code.'">Verify my E-Mail</a><br>
Or by copying and pasting the following into the address bar of your browser: http://members.awakenthenorth.org/verify.php?code='.$code.'<br><br>
Once you have verified your email address, your application will be forwarded to our Chancellor of Member Affairs, Anja Solsystir for approval.<br>
Unlike joining a typical website, to maintain a safe and inclusive community, all applications are vetted before they are approved. <br>
If for any reason we need more information from you in order to approve your application, we will email you at the address you provided.<br><br>
We thank you for your patience and hope to have your application approved soon.<br>
-Awaken The North.<Br>
<a href="http://www.awakenthenorth.org">www.awakenthenorth.org</a><br>
<a href="https://www.facebook.com/AwakenTheNorth/">www.facebook.com/AwakenTheNorth</a><br>';

$bodyp='Dear '.$app["first"].' '.$app["last"].',
Thank you for applying for membership to Awaken The North.
There are two steps left before you become an AtN member.
First, you must verify your email address by copying and pasting the following into the address bar of your browser: http://members.awakenthenorth.org/verify.php?code='.$code.'
Once you have verified your email address, your application will be forwarded to our Chancellor of Member Affairs, Anja Solsystir for approval.
Unlike joining a typical website, to maintain a safe and inclusive community, all applications are vetted before they are approved.
If for any reason we need more information from you in order to approve your application, we will email you at the address you provided.

We thank you for your patience and hope to have your application approved soon.
-Awaken The North.
www.awakenthenorth.org
www.facebook.com/AwakenTheNorth';

$toemail[]=$app["email"];
// Create a message
$message = (new Swift_Message('ATN: Please verify your email address.'))
  ->setFrom(['noreply@awakenthenorth.org' => 'Awaken The North'])
  ->setTo($toemail)
  ->setBody($bodyh, 'text/html')
  ->addPart($bodyp, 'text/plain')
  ;

// Send the message
$result = $mailer->send($message);
MDB::insert("atn_emails_sent", array("date"=>time(), "to"=>$toemail, "subject"=>"ATN: Please verify your email address.", "body"=>$bodyh));

?>
<div class="uk-container">
<div class="uk-card-default  uk-card-body">
<center><img src="logo2.png" width="50%"><br>
<span class="uk-heading-small">Membership Application</span><br></center><br>
Thank you for applying for membership to Awaken The North.<br><br>
There are two steps left before you become an AtN member.<br>
First, you must verify your email address by clicking the link in the email you'll soon recieve<br>
Once you have verified your email address, your application will be forwarded to our Chancellor of Member Affairs, Anja Solsystir for approval.<br>
Unlike joining a typical website, to maintain a safe and inclusive community, all applications are vetted before they are approved. <br>
If for any reason we need more information from you in order to approve your application, we will email you at the address you provided.<br><br>
We thank you for your patience and hope to have your application approved soon.<br>
-Awaken The North.<Br>
<a href="http://www.awakenthenorth.org">www.awakenthenorth.org</a><br>
<a href="https://www.facebook.com/AwakenTheNorth/">www.facebook.com/AwakenTheNorth</a><br>
<?
} else {
	Echo "It looks like an application with that email address already exists. If you have already applied, you will be contacted when your application has been processed.";
}
}