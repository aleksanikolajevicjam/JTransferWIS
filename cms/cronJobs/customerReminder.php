<?
/*
 * CRON JOB za dnevno slanje podsjetnika kupcima
 * - salje se jednom dnevno
 * - za transfere kojima je PickupDate preksutra
 * - samo za JAM vozace
 */
$root='/home/jamtrans/laravel/public/cms.jamtransfer.com';
//require_once $root . '/db/db.class.php';
require_once $root . '/db/v4_OrderDetails.class.php';
require_once $root . '/db/v4_OrdersMaster.class.php';
require_once $root . '/PHPMailer-master/PHPMailerAutoload.php';

$db = new DataBaseMysql();
$od = new v4_OrderDetails();
$om = new v4_OrdersMaster();


date_default_timezone_set('Europe/Zagreb');

// preksutra
$dateTomorrow = new DateTime('tomorrow + 1 day');
$dateTomorrow = $dateTomorrow->format('Y-m-d');

// uzmi transfere koji se voze preksutra
$sql = "SELECT * FROM v4_OrderDetails ";

$sql .= "WHERE PickupDate = '".$dateTomorrow."' ";

$sql .= "AND TransferStatus != '3' ";
$sql .= "AND TransferStatus != '4' ";
$sql .= "AND TransferStatus != '5' ";
$sql .= "AND TransferStatus != '9' ";

$sql .= "AND (";
$sql .= "DriverID = '556' OR ";
$sql .= "DriverID = '843' OR ";
$sql .= "DriverID = '876' OR ";
$sql .= "DriverID = '884' OR ";
$sql .= "DriverID = '885' OR ";
$sql .= "DriverID = '886' OR ";
$sql .= "DriverID = '887' OR ";
$sql .= "DriverID = '901' OR ";
$sql .= "DriverID = '902' OR ";
$sql .= "DriverID = '903' OR ";
$sql .= "DriverID = '907' OR ";
$sql .= "DriverID = '908' OR ";
$sql .= "DriverID = '1542' OR ";
$sql .= "DriverID = '1543' OR ";
$sql .= "DriverID = '1566' OR ";
$sql .= "DriverID = '1582'";
$sql .= ") ";
$sql .= "ORDER BY OrderID ASC, PickupDate ASC, PickupTime ASC";
$r = $db->RunQuery($sql);

$i = 0;

while ($d = $r->fetch_object()) {
        
    $om->getRow($d->OrderID);
    if($om->getMOrderID() == $d->OrderID) {

		$userEmail = trim( $om->getMPaxEmail() );
		
		if($userEmail != '') { // ako je email prazan, ne salji nista
            // START MAIL
            $message = '
                        <div style="font-family: sans-serif; font-size:14px;">
                        Dear '.$d->PaxName.',<br>
                        we just wish to remind You of Your transfer <strong>'.$d->OrderID. '-' . $d->TNo . '</strong>:<br>
                        <br>
                        From: <strong>'.$d->PickupName.'</strong>, '.$d->PickupAddress .'<br>
                        To &nbsp;&nbsp;&nbsp;: <strong>'.$d->DropName.'</strong>, '.$d->DropAddress.'<br>
                        <br>
                        Pickup Date: <strong>'.$d->PickupDate.'</strong><small> (Y-M-D)</small><br>
                        Pickup Time: <strong>'.$d->PickupTime.'</strong><small> (hours:minutes, 24h time format)</small><br>
                        <br>
                        <br>
                        <strong>If there are any last minute changes to your itinerary, please send an e-mail to 
                        <a href="mailto:dispatcher@jam-group.net">dispatcher@jam-group.net</a></strong><br>
                        <br>
                        Looking forward to meeting You!<br>
                        <br>
                        Kindest regards,<br>
                        Your driver Josip<br>
                        <br>
                        </div>
            ';


            // END MAIL

            mail_html($userEmail, $message);
            //break; // samo za test, da ne idu svi mailovi
            $i++;
        } 
	} //endif

} // end while

mail_html('bogo@jamtransfer.com', $i. ' Customer Reminder e-mails sent - ' . date("Y-m-d H:i:s") );
mail_html('dispatcher@jam-group.net', $i. ' Customer Reminder e-mails sent - ' . date("Y-m-d H:i:s") );

function mail_html($mailto, $message) {
	$mail = new PHPMailer;
	$mail->isHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->setFrom('dispatcher@jam-group.net', 'JamTransfer.com');
	$mail->addReplyTo('dispatcher@jam-group.net', 'JamTransfer.com');
	$mail->Subject = 'JamTransfer - Transfer Reminder';

    //$mailto = 'bogo.split@gmail.com'; // just for testing
	
    $mail->addAddress($mailto);
	$mail->Body    = $message;

	if(!$mail->send()) {
		return 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		return 'OK';
	}
}
