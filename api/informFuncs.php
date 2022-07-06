<?
@session_start();

// za vozace je hardkodirano na engleski

	// LANGUAGES
	if ( isset($_SESSION['CMSLang']) and $_SESSION['CMSLang'] != '') {
		$languageFile = ROOT .'/cms/lng/' . $_SESSION['CMSLang'] . '_text.php';
		if ( file_exists( $languageFile) ) require_once $languageFile;
		else {
			$_SESSION['CMSLang'] = 'en';
			require_once ROOT .'/cms/lng/en_text.php';
		}
	}
	else {
		$_SESSION['CMSLang'] = 'en';
		require_once ROOT .'/cms/lng/en_text.php';
	}
	// END OF LANGUAGES	
require_once ROOT . '/f/f.php';


function informCustomer($OrderID, $TNo, $msg) {
	require_once ROOT .'/db/v4_OrdersMaster.class.php';
	require_once ROOT .'/db/v4_OrderDetails.class.php';
	
	$om = new v4_OrdersMaster();
	$od = new v4_OrderDetails();
	$om->getRow($OrderID);
	
	$mailto = $om->getMPaxEmail();
	
	
	$message  = HELLO . '!<br><br>';
	$message .= IMPORTANT_UPDATE . ':<br>';
	$message .= $msg;
	$message .= '<br><br>'.THANK_YOU . '! <br><br><br>';
	$message .= pdfFooter('1');
	
	mail_html($mailto, 'driver-info@jamtransfer.com', 'JamTransfer', 'info@jamtransfer.com',
		  IMPORTANT_UPDATE . ' Ref: ' . $OrderID.'-'.$TNo , $message);


	mail_html('cms@jamtransfer.com', 'driver-info@jamtransfer.com', 'JamTransfer', 'info@jamtransfer.com',
		  IMPORTANT_UPDATE . ' Ref: ' . $OrderID.'-'.$TNo , $message);
  

	return '>>> Customer informed.';
}


function informDriver($OrderID, $TNo, $msg) {

	require_once ROOT .'/db/v4_OrderDetails.class.php';
	require_once ROOT .'/db/v4_AuthUsers.class.php';
		
	$om = new v4_OrdersMaster();
	$od = new v4_OrderDetails();
	$au = new v4_AuthUsers();
	
	$where = " WHERE OrderID = '" . $OrderID . "' AND TNo = '" . $TNo . "'";
	$odk = $od->getKeysBy('DetailsID', 'ASC', $where);

	if(count($odk) == 1) {
		$od->getRow($odk[0]);

		$au->getRow( $od->getDriverID() );

		$mailto = $au->getAuthUserMail();
	
		$message  = 'Hello' . '!<br><br>';
		$message .= 'Important update' . ':<br>';
		$message .= $msg;
		$message .= '<br><br>' . 'Thank You' . '! <br><br><br>';
		$message .= pdfFooter('1');
	
		mail_html($mailto, 'transfer-update@jamtransfer.com', 'JamTransfer', 'info@jamtransfer.com',
			  'Important update' . ' Ref: ' . $OrderID.'-'.$TNo , $message);

		mail_html('cms@jamtransfer.com', 'transfer-update@jamtransfer.com', 'JamTransfer', 'info@jamtransfer.com',
			  'Important update' . ' Ref: ' . $OrderID.'-'.$TNo , $message);

		return '>>> Driver informed.';

	} else {
		return '>>> Error: Driver not informed or not found.';
	}
}

function informNewDriver($OrderID, $TNo, $DriverID) {
	require_once ROOT .'/db/v4_OrdersMaster.class.php';
	require_once ROOT .'/db/v4_OrderDetails.class.php';
	require_once ROOT .'/db/v4_AuthUsers.class.php';
	
	$om = new v4_OrdersMaster();
	$od = new v4_OrderDetails();
	$au = new v4_AuthUsers();
	
	$au->getRow($DriverID);
	
	$message .= 'Hello' . '!<br><br>';
	$message .= 'We have new transfer(s) for you.<br>Please Confirm or Decline these transfers immediately using the link(s) below:<br><br>';
	
	$k = $od->getKeysBy('DetailsID', 'asc', " WHERE OrderID = '". $OrderID . "' AND TNo ='" . $TNo ."'");
	//foreach($k as $nn => $id) {
		$od->getRow($k[0]);
		
		$om->getRow($od->getOrderID());
		$orderKey = $om->getMOrderKey();
		$mailto = $au->getAuthUserMail();			
		
		$link = '<a href="http://' . $_SERVER['SERVER_NAME'] . '/cms/dcN.php?code='.$od->getDetailsID() .
				'&control='.$orderKey.'&id='.$DriverID.'">'. 
				$od->getOrderID().'-'.$od->getTNo() .
				'</a>';
		$message .= $link . '<br>';
	//}
	
	//$driverData = getUser($)
	
	$message .= '<br><br>' . 'Thank You' . '! <br><br><br>';
	$message .= pdfFooter('1');
	
	mail_html($mailto, 'new-transfer@jamtransfer.com', 'JamTransfer', 'info@jamtransfer.com',
		  'New transfer' . ' - ' . $OrderKey , $message);

	mail_html('cms@jamtransfer.com', 'new-transfer@jamtransfer.com', 'JamTransfer', 'info@jamtransfer.com',
		  'New transfer' . ' - ' . $OrderKey , $message);
		  
		  
	return '>>> New Driver informed. Driver ID: ' . $DriverID . ' E-mail: ' . $mailto;
}


function informOldDriver($OrderID, $TNo, $DriverID) {

	require_once ROOT .'/db/v4_OrdersMaster.class.php';
	require_once ROOT .'/db/v4_OrderDetails.class.php';
	require_once ROOT .'/db/v4_AuthUsers.class.php';
	
	$om = new v4_OrdersMaster();
	$od = new v4_OrderDetails();
	$au = new v4_AuthUsers();
	
	$au->getRow($DriverID);
	
	$k = $od->getKeysBy('DetailsID', 'asc', " WHERE OrderID = '". $OrderID . "' AND TNo ='" . $TNo ."'");
	$od->getRow($k[0]);
		
	$om->getRow($od->getOrderID());

	$mailto = $au->getAuthUserMail();	
	$message  = 'Hello' . '!<br><br>';
	$message .= 'Following Transfer(s) have been cancelled and/or removed from system' . ':<br>';
	$message .= '<h3>'.$OrderID.'-'.$TNo .'</h3><br><br>';
	$message .= 'Please update Your schedule and Pick-up plans accordingly.';
	$message .= '<br><br>' . 'Thank You' . '! <br><br><br>';
	$message .= pdfFooter('1');

	mail_html($mailto, 'transfer-update@jamtransfer.com', 'JamTransfer', 'info@jamtransfer.com',
		  'Important update' . ' Ref: ' . $OrderID.'-'.$TNo , $message);

	mail_html('cms@jamtransfer.com', 'transfer-update@jamtransfer.com', 'JamTransfer', 'info@jamtransfer.com',
		  'Important update' . ' Ref: ' . $OrderID.'-'.$TNo , $message);

	return '>>> Old Driver informed. Driver ID: '. $DriverID. ' E-mail: ' . $mailto;
}
