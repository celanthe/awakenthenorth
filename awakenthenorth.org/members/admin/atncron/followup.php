<?
function do_followup() {
	$cutoff=strtotime("2 weeks ago");
	$members=MDB::query("SELECT * FROM atn_cmr WHERE reminder = '0' AND joined <= %i AND id > %i AND reminder = %i", $cutoff, 165, 0);
	//$members=MDB::query("SELECT * FROM atn_cmr WHERE id = %i AND reminder = %i", 1,0);
	$template=MDB::queryFirstRow("SELECT * FROM atn_email_templates WHERE code = %s", "membership_followup");
	$text=$template["body_html"];
	$ptext=strip_tags($text);
	foreach ($members as $row) {
		$toemail=$row["email"];
		//echo $row["first"]." ".$row["last"]."<br>";	
		
		$transport = (new Swift_SmtpTransport(MAIL_SERVER, MAIL_PORT))
		  ->setUsername(MAIL_USERNAME)
		  ->setPassword(MAIL_PASSWORD)
		;

		// Create the Mailer using your created Transport

		$mailer = new Swift_Mailer($transport);
		$bcctoemail[]="chris.claus42@gmail.com";
		//$bcctoemail[]="atn@awakenthenorth.org";

		// Create a message
		$message = (new Swift_Message($template["subject"]))
		  ->setFrom(['noreply@awakenthenorth.org' => 'Gothi Beast - Awaken The North'])
		  ->setSender('cors@awakenthenorth.org')
		  ->setReplyTo('cors@awakenthenorth.org')
		  ->setTo($toemail)
		  ->setBcc($bcctoemail)
		  ->setBody($text, 'text/html')
		  ->addPart($ptext, 'text/plain')
		  ;

		// Send the message
		$result = $mailer->send($message);
		MDB::insert("atn_emails_sent", array("date"=>time(), "to"=>$toemail, "subject"=>$template["subject"], "body"=>$text));
		MDB::update("atn_cmr", array("reminder"=>time()), "id=%i", $row["id"]);
		}
	
}