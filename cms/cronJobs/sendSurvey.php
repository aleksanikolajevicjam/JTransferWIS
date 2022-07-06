<?
/*
 * CRON JOB za slanje ankete kupcima koji su zavrsili transfer
 * anketu bi trebalo slati ako je:
 * - proslo bar 3 dana od zavrsenog transfera (i povratnog)
 * - status transfera 5 (completed)
 * - MSendEmail i MEmailSentDate transfera prazno (anketa jos nije poslana)
 * - Order od Jam Transfer (SiteID = 2)
 * - nije agent napravio (MUserLevelID != 2)
 */
$root='/home/jamtrans/laravel/public/cms.jamtransfer.com';

//require_once $root . '/db/db.class.php';
require_once $root . '/db/v4_OrdersMaster.class.php';
require_once $root . '/db/v4_OrderDetails.class.php';

$db = new DataBaseMysql();
$om = new v4_OrdersMaster();
$od = new v4_OrderDetails();


//echo 'START sending survey';

$emailsSent = 0;
$dateLimitUp = date("Y-m-d",strtotime("-3 days"));
$dateLimitDown = date("Y-m-d",strtotime("-7 days"));
# echo '<br>Date limit is: ' . $dateLimitDown . ' - ' . $dateLimitUp;
$omKeys = $om->getKeysBy("MOrderID", "DESC", "WHERE SiteID = 2 AND MUserLevelID != 2 AND MSendEmail = 0 AND MEmailSentDate = '' AND MPaxEmail != ''");
//$omKeys = $om->getKeysBy("MOrderID", "DESC", "WHERE SiteID = 2 AND MUserLevelID != 2  AND MPaxEmail != ''");

# echo '<br>Found ' . count($omKeys) . ' MOrders with no sent mail';

//$sql = "SELECT `OrderID`,`TNo` FROM `v4_OrderDetails` WHERE TransferStatus=5 AND PickupDate < '".$dateLimitUp."' AND PickupDate > '".$dateLimitDown."' GROUP BY `OrderID` ORDER BY `PickupDate` DESC ";
$sql = "SELECT `OrderID`,`TNo`,`PickupDate`,`TransferStatus` FROM `v4_OrderDetails` ORDER BY `OrderID`,`PickupDate` DESC";
$rec = $db->RunQuery($sql);

$tr_arr=array();
$ch=0;
while ($row = $rec->fetch_assoc() ) {
	if ($ch<>$row['OrderID'] && $row['PickupDate']>$dateLimitDown && $row['PickupDate']<$dateLimitUp && $row['TransferStatus']==5) $tr_arr[]=$row['OrderID'];
	$ch=$row['OrderID'];	
}
$rec3=$tr_arr;

foreach ($omKeys as $MOrderID) {

	if ($emailsSent < 30 && in_array($MOrderID,$rec3))	{
		// START SEND EMAIL
		 echo '<br>Sending survey for ' . $MOrderID;
		$om->getRow($MOrderID);
		$userEmail = $om->MPaxEmail;

		//$jamMail = 'info@jamtransfer.com'; 
		$jamMail = 'cms@jamtransfer.com'; 
		$jamMail2 = 'magdalena@jamtransfer.com'; 

		
		$img1Link = 'https://www.jamtransfer.com/i/logo_hor.png';
		$img2Link = 'https://www.jamtransfer.com/i/surveyScores.png';
		$returnLink = 'https://www.jamtransfer.com/survey.php?oid='.$MOrderID;

		$message = '<div style="width:800px;margin:0 auto;border:none;padding:12px;font-size:large">
			<a href="http://www.jamtransfer.com" style="display:block;text-align:center"><img src="'.$img1Link.'"></a>
			<p>Hello,</p><p>Thank you for travelling with JamTransfer.com and we hope to welcome you back soon!</p>
			<p>We appreciate your trust and greatly value your opinion. Please help us to improve our service by taking a couple of
			minutes to fill this survey and let us know about service you have received so far.</p>
			<p>Thank you very much in advance for your time.<br>Best regards,<br>JamTransfer.com</p>
			<div style="font-size:18px;color: #666;font-weight:bold"><br>&nbsp;&nbsp;&nbsp;&nbsp;Please rate the service:
			<a href="'.$returnLink.'" style="display:block"><img src="'.$img2Link.'" style="display:block;margin:0 auto"></a>
			</div></div>';

		$result = mail_html ($userEmail, $jamMail, 'Jam Transfer', $jamMail2, 'JamTransfer Survey', $message);
		//$result2 = mail_html ('jam.bg09@gmail.com', $jamMail, 'Jam Transfer', $jamMail2, 'JamTransfer Survey', $message); 
		//$result3 = mail_html ('jam.bgprogrameri@gmail.com', $jamMail, 'Jam Transfer', $jamMail2, 'JamTransfer Survey', $message); 
		

		if ($result == "OK") {
			$emailsSent++;
			$om->setMSendEmail(1);
			$om->setMEmailSentDate(date("Y-m-d"));
			$om->saveRow();
			echo '<br>Mail sent: ' . $userEmail . '-' . $result;
		} else {
			echo '<br>Error: ' . $result . '-' . $MOrderID . '-' . $userEmail;
			$om->setMSendEmail(2);
			$om->setMEmailSentDate(date("Y-m-d")); 
			$om->saveRow();
		}	
		// END SEND EMAIL 
	}
}

# echo '<br>Sending survey DONE: ' . $emailsSent . ' emails sent';
# echo '<br>END sending survey';


function mail_html($mailto, $from_mail, $from_name, $replyto, $subject, $message, $attachment = '') {	
	$root='/home/jamtrans/laravel/public/cms.jamtransfer.com';
	require_once   $root . '/PHPMailer-master/PHPMailerAutoload.php';

	$mail = new PHPMailer;

	$mail->CharSet = 'UTF-8';
	$mail->setFrom($from_mail, $from_name);
	$mail->addAddress($mailto);     // Add a recipient

	$mail->addReplyTo($replyto, $from_name);


	if($attachment != '') $mail->addAttachment($attachment);         // Add attachments

	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = $subject;
	$mail->Body    = $message;


	if(!$mail->send()) {
		return 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		return 'OK';
	}
}

