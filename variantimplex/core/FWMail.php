<?php
require_once 'vendors/swift/swift_required.php'; 
//require_once ('swift_required.php');
/* Of course write a valid gmail account, my problem was that gmail needs ssl option*/
//$result = new MailTo("nagarjuna.b@tlisoftware.com", "nagarjuna.knb@gmail.com", "testing for new frame work", "testing purpose plz ignore");


class FWMail{

	function __construct($sendTo, $from, $subject, $body) {
	
		$this->sendMailTo($sendTo, $from, $subject, $body);
	}

	public function sendMailTo($sendTo, $from, $subject, $body){
		$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
		  ->setUsername('nagarjuna.babu@gmail.com')
		  ->setPassword('luckynag');
		  $mailer = Swift_Mailer::newInstance($transport);
		$message = Swift_Message::newInstance()
		//Give the message a subject
		  ->setSubject($subject)
		  //Set the From address with an associative array
		  ->setFrom(array($from))
		  //Set the To addresses with an associative array
		  ->setTo(array($sendTo))
		  //Give it a body
		  ->setBody($body);
		  $result = $mailer->send($message);
		
	   return $result;	
	
	}
}
 
?>
