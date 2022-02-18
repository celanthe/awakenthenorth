<?php
/*
error_reporting(E_ALL);
require_once '/home/intheexp/atn.bigskyheathen.com/members/users/init.php';
require("/home/intheexp/atn.bigskyheathen.com/members/db.php");
require("/home/intheexp/atn.bigskyheathen.com/members/functions.php");
require_once '/home/intheexp/atn.bigskyheathen.com/members/vendor/autoload.php';
	
$body_html='<img src="https://members.awakenthenorth.org/logo2.png" width="250px"><br><br>
<p>I am resending the welcome letter out to everyone that has had their application processed, as I\'m told that</p>
<p>there was an error and some people may have not received theirs.</p>
<p>I am very sorry about the 30+ blank emails you received earlier. That was a mistake on my part. We will not spam you like that in the future!</p>
<br>
<p>Hail and welcome friend to our amazing community, Awaken the North!</p>
<p>We are excited to have you here with us and we look forward to your participation in the<br />community. My name is Alex "Freyrson" LaFountain and I am the Chancellor of Member<br />Affairs.</p>
<p>I wanted to take a moment to introduce myself as well as welcome you to our<br />community and share with you some of the amazing things we have to offer.</p>
<br>
<p>As you have indicated either present or past military service, we do want to thank you for your <br>service to your country. Awaken the North holds great respect for anyone that makes the choice to serve in such a way.<br>
Our Chancellor for Military Services, Anthony Powers is available if you ever have any comments, questions, <br>or suggestions. We are constantly looking for ways to help our fellow Heathens in the military.<br></p>
<br>
<p>As a member, you have access to several perks which includes things such as access<br />to our social media group, free copies of all newsletters, access to our Clergy training<br />program, invitations to join virtual moots, and access to our Kindred association<br />program. As a member, your voice is also considered important to the Council.</p>
<p>We encourage all members to review all meeting minutes as we strive for transparency. If<br />you ever have an issue or specific question you would like to ask, you can always<br />contact any Chancellor by visiting the Council page on our main website<br />(https://awakenthenorth.org/the-council) or by sending an email to one of the following<br />Chancellor\'s listed below.</p>
<p>Visiting the Council page will also help you understand more<br />about what each Council member does and how they represent you in the community.</p>
<ul>
<li>Chancellor of Religious Studies: <a href="mailto:CoRS@AwakentheNorth.org">CoRS@AwakentheNorth.org</a></li>
<li>Chancellor of the Ambassador Program: <a href="mailto:CoAP@AwakentheNorth.org">CoAP@AwakentheNorth.org</a></li>
<li>Chancellor of Public Affairs: <a href="mailto:CoPA@AwakentheNorth.org">CoPA@AwakentheNorth.org</a></li>
<li>Chancellor of Affiliated Partners: <a href="mailto:CoAP@AwakentheNorth.org">CoAP@AwakentheNorth.org</a></li>
<li>High Drighton: <a href="mailto:HD@AwakentheNorth.org">HD@AwakentheNorth.org</a></li>
<li>Chancellor of the Treasury: <a href="mailto:CoTT@AwakentheNorth.org">CoTT@AwakentheNorth.org</a></li>
<li>Chancellor of Military Services: <a href="mailto:CoMS@AwakentheNorth.org">CoMS@AwakentheNorth.org</a></li>
<li>Chancellor of Member Affairs: <a href="mailto:CoMA@AwakentheNorth.org">CoMA@AwakentheNorth.org</a></li>
</ul>
<p><br />To stay up to date on the latest events in our community, please keep an eye out for<br />newsletters and announcements in our Facebook group as well as on the main website.<br />We post regularly and most announcements will be made there in real time. If you are<br />interested in serving as an Ambassador please contact the Chancellor of the<br />Ambassador Program for more information as well as to learn how to apply.</p><br>
<p>As part of your membership, you have access to a few different things.<br>

The Awaken The North Member Portal. This portal is where you will be able to update your <br>
personal information, change your privacy settings, search for other members, <br>
see the financial information for AtN, among other functions.<br>
You can access that at <a href="https://members.awakenthenorth.org">members.awakenthenorth.org</a> with the username and password you provided in your application.<br><br>
The Awaken The North Website. <br>
While our website does have a lot of information available to the public, there is more that is only available to members. <br>
You can access that by clicking on the Member Login link on the website or by going to <a href="https://www.awakenthenorth.org/member-login/">www.awakenthenorth.org/member-login</a><br>
The Awaken The North Members Discord. <a href="{{discord}}">{{discord}}</a><br>
Please do not share that invite link with anyone. We will be verifying all members that<br>
join and only official AtN members will be approved.<br><br>
The Members Only Facebook Group. You may already be a member of the public facebook group, <br>
but we also have a private Members Only Facebook Group. You can join that here: <a href="https://www.facebook.com/groups/atnmembers/">https://www.facebook.com/groups/atnmembers/</a><br><br>
You will also have the option to take our various training programs.<br>
Please note that we are still developing all of this, so not everything will be available right away.<br>
</p>
<p><br />Again, I would like to thank you for joining our organization and becoming a part of its<br />growth. I welcome you on behalf of our Heathen community and may your time with us<br />be educational as well as pleasurable!</p>
<p><br />Blessings of the Gods and Ancestors be upon you friend!<br />Alex "Freyrson" LaFountain<br />Chancellor of Member Affairs</p>';
$subject="AtN Welcome Letter - Resent";
$body_html=str_replace("{{discord}}", DISCORD_INVITE, $body_html);

$ptext=strip_tags($body_html);

$transport = (new Swift_SmtpTransport(MAIL_SERVER, MAIL_PORT))
 ->setUsername("members@awakenthenorth.org")
->setPassword("password");

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);
//$bcctoemail[]="chris.claus42@gmail.com";
//$bcctoemail[]="atn@awakenthenorth.org";
$toemail[]="members@awakenthenorth.org";
$bccemail=array("Northernskies2012@gmail.com", "tonypowers0902@gmail.com", "cowboyup02@mail.com", "Jacenpeel@gmail.com", "sadixon70@gmail.com", "davidoliver68@msn.com", "marshalljuderiley@gmail.com", "vgkfaninok@gmail.com", "Markudy2144@gmail.com");
// Create a message
$message = (new Swift_Message($subject))
  ->setFrom(['noreply@awakenthenorth.org' => 'Awaken The North'])
  ->setTo($toemail)
  ->setBcc($bccemail)
  ->setBody($body_html, 'text/html')
  ->addPart($ptext, 'text/plain')
  ;

// Send the message
$result = $mailer->send($message);

echo "done";
/*