<?
/*
 * CRON JOB za slanje obavjesti vozacima da potvrde transfer ako jos nisu - IPAK SE NECE KORISTITI
 * - salje se tri puta dnevno (svakih 8 sati)
 * - sadrzi listu nepotvrdjenih transfera u sljedeca 24 sata
 *   zajedno sa linkom na cms da potvrde/odbiju
 * - ne salje podsjetnik za transfere di je driver = 0
 * - ne salje podsjetnik vozacima koji nemaju email adresu
*/
$root='/home/jamtrans/laravel/public/cms.jamtransfer.com';
//require_once $root . '/db/db.class.php';
require_once $root . '/db/v4_OrderDetails.class.php';
require_once $root . '/db/v4_AuthUsers.class.php';
require_once $root . '/PHPMailer-master/PHPMailerAutoload.php';

$db = new DataBaseMysql();
$od = new v4_OrderDetails();
$au = new v4_AuthUsers();

$transferKeys = array();
$driverKeys = array();
$dateToday = date('Y-m-d');
date_default_timezone_set('Europe/Zagreb');
$time = date('H:i');
$dateTomorrow = new DateTime('tomorrow');
$dateTomorrow = $dateTomorrow->format('Y-m-d');

// uzmi nepotvrdjene transfere u sljedeca 24h koja imaju drivera sa email adresom
$sql = "SELECT * FROM v4_OrderDetails INNER JOIN v4_AuthUsers ON v4_OrderDetails.DriverID = v4_AuthUsers.AuthUserID ";
$sql .= "WHERE v4_OrderDetails.DriverID != 0 AND (((PickupDate = '".$dateToday."' AND PickupTime >= '".$time."') OR ";
$sql .= "(PickupDate = '".$dateTomorrow."' AND PickupTime <= '".$time."')) OR OrderDate >(CURRENT_DATE)-INTERVAL 2 DAY) AND DriverConfStatus = '1' AND v4_AuthUsers.AuthUserMail != '' ";
$sql .= "AND TransferStatus = '1' ";
$sql .= "ORDER BY v4_OrderDetails.DriverID ASC, PickupDate ASC, PickupTime ASC";
$r = $db->RunQuery($sql);
while ($d = $r->fetch_object()) {
	$transferKeys[] = $d->DetailsID;
}

// slozi drivere sa transferima u array
foreach ($transferKeys as $key) {
	$od->getRow($key);
	$au->getRow($od->getDriverID());
	if (end($driverKeys) != $od->getDriverID()) $driverKeys[] = $od->getDriverID();
}

// uzmi nepotvrdjene transfere za svakog drivere te slozi i posalji mailove
foreach ($driverKeys as $key) {
	$au->getRow($key);
	if ( $au->getAuthUserMail() != '') { // druga provjera, sql uvijet sam nije potpuno funkcionirao (primjer AuthUser 1664)
		$sql = "SELECT * FROM v4_OrderDetails WHERE DriverConfStatus = '1' AND DriverID = " . $key . " ";
		$sql .= "AND (((PickupDate = '".$dateToday."' AND PickupTime >= '".$time."') ";		
		$sql .= "OR (PickupDate = '".$dateTomorrow."' AND PickupTime <= '".$time."')) OR ";
		$sql .=	" OrderDate >(CURRENT_DATE)-INTERVAL 2 DAY)";
		$sql .= "AND TransferStatus = '1' ";
		$sql .= "ORDER BY PickupDate ASC, PickupTime ASC";
		$r = $db->RunQuery($sql);

        $transferKeys = array();
		while ($d = $r->fetch_object()) {
			$transferKeys[] = $d->DetailsID;
		}

        $userEmail = $au->getAuthUserMail();
		// START MAIL
		$message = '<div style="width:1000px;margin:0 auto;border:solid 6px black;border-left:0;border-right:0;font-family:sans-serif"><div style="padding:12px;text-align:center"><img src="https://www.jamtransfer.com/i/logo_hor.png"></div><div style="padding:24px 36px;background:#eee"><p>Dear partner '.$au->getAuthUserRealName().',</p><p>Please <b>CONFIRM OR DECLINE</b> these transfers immediately:</p><table style="width:100%;margin:24px auto;border:solid 1px black;text-align:center"><tr><th>Order</th><th>Status</th><th>Pickup</th><th>View</th></tr>';
		foreach ($transferKeys as $key) {
			$od->getRow($key);
			$message .= '<tr><td>'.$od->getOrderID().'-'.$od->getTNo().'</td><td>';

			switch ($od->getDriverConfStatus()) {
				case 0: $message .= 'No driver'; break;
				case 1: $message .= 'Not confirmed'; break;
				case 2: $message .= 'Confirmed'; break;
				case 3: $message .= 'Ready'; break;
				case 4: $message .= 'Declined'; break;
				case 5: $message .= 'No show'; break;
				case 6: $message .= 'Driver error'; break;
				case 7: $message .= 'Completed'; break;
				default: $message .= 'Error'; break;
			}

			$message .= '</td><td>'.$od->getPickupDate().' '.$od->getPickupTime().' - '.$od->getPickupName().'</td><td><a href="https://www.jamtransfer.com/cms/index.php?p=transfersList&transfersFilter=details&id='.$key.'">View</a></td></tr>';
			//$message .= '</td><td>'.$od->getPickupDate().' '.$od->getPickupTime().' - '.$od->getPickupName().'</td><td><a href="https://www.jamtransfer.com/cms/dc.php?code='.$od->getDetailsID() .'&control='.$orderKey.'&id='.$od->getDriverID().'">'. $od->getOrderID().'-'.$od->getTNo() .'</a></td></tr>';
			
		}

		$message .= '</table><p>Kind Regards,<br>JamTransfer</p><p style="margin:24px 0 0;text-align:center;font-size:small">This is an automatically generated email, please do not reply to this message.</p></div><div style="padding:1em;text-align:center;background:white"><img src="https://www.jamtransfer.com/images/check-crveni.png" style="vertical-align:middle">LOWEST PRICES&nbsp;&nbsp;&nbsp;<img src="https://www.jamtransfer.com/images/check-crveni.png" style="vertical-align:middle">EASY ONLINE BOOKING&nbsp;&nbsp;&nbsp;<img src="https://www.jamtransfer.com/images/check-crveni.png" style="vertical-align:middle">24/7 CUSTOMER SERVICE&nbsp;&nbsp;&nbsp;<img src="https://www.jamtransfer.com/images/check-crveni.png" style="vertical-align:middle">CHILD SEATS&nbsp;&nbsp;&nbsp;</div></div>';
		// END MAIL

		echo $userEmail. ' - '. $message;	
		mail_html($userEmail, $message);  
    }
}

function mail_html($mailto, $message) {
	$mail = new PHPMailer;
	$mail->isHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->setFrom('cms@jamtransfer.com', 'Jam Transfer');
	$mail->addReplyTo('info@jamtransfer.com', 'Jam Transfer');
	$mail->Subject = 'JamTransfer - Confirm/Decline Transfers';

	$mail->addAddress($mailto);
	$mail->Body    = $message;

	if(!$mail->send()) {
		return 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		return 'OK';
	}
}
