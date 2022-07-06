<?
/*
 * CRON JOB za slanje poruka kupcima koji temp order nisu ni potvrdili ni otkazali
 * mailove bi trebalo slati ako je:
 * - datum bookinga jucer ili ranije
 * - datum transfera u buducnosti (dakle ne ako je vec prosao)
 * - status transfera 4 (temp order)
 * - MEmailSentDate prazan (nije ranije vec poslan reminder)
 */

define("NL", "<br>");
define("B", " ");
$root='/home/jamtrans/laravel/public/cms.jamtransfer.com';

//require_once $root . '/db/db.class.php';
require_once $root . '/db/v4_OrderLog.class.php';
require_once $root . '/lng/en.php';

$db = new DataBaseMysql();
$ol = new v4_OrderLog();

$dateLimit = date("Y-m-d");

$qm  = " SELECT * FROM v4_OrdersMaster ";
$qm .= " WHERE MOrderStatus = '4' ";
$qm .= " AND   MOrderDate < '{$dateLimit}' ";
$qm .= " AND   MEmailSentDate = '' ";
$qm .= " ORDER BY MOrderDate DESC";

$wm = $db->RunQuery($qm);

while($om = $wm->fetch_object()) {

	// ispitujemo samo prvi transfer, jer ako je on vec prosao onda nema smisla slati ovo
	$qd  = " SELECT * FROM v4_OrderDetails ";
	$qd .= " WHERE OrderID = '{$om->MOrderID}' ";
	$qd .= " AND   TransferStatus not in (3,9) ";
	$qd .= " AND   TNo = '1' ";

	$wd = $db->RunQuery($qd);

	$od = $wd->fetch_object();
	$DetailsID = $od->DetailsID;

	if($od->PickupDate > date("Y-m-d") and $om->MPaxEmail != '') {

		$coData = getUserData1($om->MUserID);

		$mailto 	= $om->MPaxEmail;

		$from_mail 	= $replyto = $coData['AuthUserMail'];
		$from_name 	= $coData['AuthUserCompany'];

		$subject  	= $from_name . ' ' . VERIFICATION_REQUEST;

		$message 	='';

		$message 	.= '<h2>' . $from_name . '</h2><br>';
		$message  	.= HELLO . ' '. ucfirst($om->MPaxFirstName) . B . ucfirst($om->MPaxLastName) .'!'. NL.NL;
		$message 	.= REMINDER_TEXT . NL.NL.NL.NL;

		$message 	.= '<a
						style="padding:8px;background: #2e59c9;
						color:#fff;text-decoration:none !important;
						font-weight:300;font-size:15px;"
						href="http://www.jamtransfer.com/confirmOrder.php?id='.
						$om->MOrderID.'">'.CONFIRM_MY_ORDER.' &#x276F;</a>'.NL.NL.NL.NL;

		$message 	.= AFTER_CONFIRMATION .NL;

		$message 	.= FEEDBACK;
		$message 	.= '<small>- - -<br>';
		$message 	.= THIS_SITE . '<strong>'.$from_name . '</strong>' . AUTHORIZED_PARTNER;
		$message	.= NO_SPAM;
		$message 	.= '</small>';

		$sent = mail_html($mailto, $from_mail, $from_name, $replyto, $subject, $message);

		if($sent) {
			$qm2  = "UPDATE v4_OrdersMaster SET MEmailSentDate = '".date("Y-m-d")."' ";
			$qm2 .= "WHERE MOrderID ='".$om->MOrderID."' ";
			$db->RunQuery($qm2);
			//echo $om->MOrderID . NL;

			// log sending order reminder
			$ol->setShowToCustomer(1);
			$ol->setOrderID($om->MOrderID);
			$ol->setDetailsID($DetailsID); // upisuje se samo za prvi transfer
			$ol->setUserID(879); // generic sysadmin
			$ol->setIcon("fa fa-info-circle");
			$ol->setAction("Email");
			$ol->setTitle("Email sent");
			$ol->setDescription("Order conformation reminder sent");
			$ol->setDateAdded(date("Y-m-d"));
			$ol->setTimeAdded(date("H:i:s"));
			$ol->saveAsNew();
		}
	}
}

function getUserData1($UserID) {
	//require_once $root . '/db/db.class.php';
	$db = new DataBaseMysql();

	$UserID = $db->real_escape_string($UserID);

	$q  = " SELECT * FROM v4_AuthUsers ";
	$q .= " WHERE AuthUserID = '{$UserID}'";

	$w = $db->RunQuery($q);
	$c = mysqli_fetch_array($w);

	return $c;
}

function mail_html($mailto, $from_mail, $from_name, $replyto, $subject, $message) {
	$root='/home/jamtrans/laravel/public/cms.jamtransfer.com';
	require_once $root . '/PHPMailer-master/PHPMailerAutoload.php';
	// $mailto = 'bogo@jamtransfer.com';

	$mail = new PHPMailer;
	$mail->setFrom($from_mail, $from_name);
	$mail->addAddress($mailto); // Add a recipient
	$mail->addReplyTo($replyto, $from_name);
	$mail->isHTML(true); // Set email format to HTML
	$mail->Subject = $subject;
	$mail->Body = $message;

	if(!$mail->send()) {
		return 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		return 'OK';
	}
}

