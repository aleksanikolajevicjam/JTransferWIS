<?
	//require_once ROOT . '/sessionThingy.php';
//@session_start();

function Lang() {
	return strtoupper(substr($_SESSION['language'],0,2));
}

function maskEmail($email) {
	$parts = explode('@', $email);
	$masked = '';
	for($i=1; $i <= strlen($parts[0]); $i++) {
		$masked .= '*';
	}
	$masked .= '@' .$parts[1];
	return $masked;
}

function consolidate($inputFile, $outputFile, $startOver = false) {
	if($startOver == true) unlink($outputFile);

	$in = file_get_contents($inputFile);
	file_put_contents($outputFile, $in, FILE_APPEND );
}


function pdfFooter($SiteID) {
	require_once ROOT .'/db/db.class.php';
	require_once ROOT .'/db/v4_CoInfo.class.php';
	$db = new v4_CoInfo();

	$ret = NO_COMPANY_DATA;
	$k = $db->getKeysBy('ID', 'asc', " WHERE ID = '". $SiteID . "'");

	if (count($k) > 0) {

		$db->getRow($k[0]);

		if ($db->getID() == $SiteID) {

			$ret  = '<cite><strong>'.$db->getco_name() . '</strong><br>';
			$ret .= $db->getco_address() . '<br>';
			$ret .= $db->getco_zip() .' ' . $db->getco_city() . '<br>';
			$ret .= $db->getco_country() . '<br>';
			$ret .= $db->getco_tel() . '<br>';
			$ret .= $db->getco_fax() . '<br>';
			$ret .= 'info@jamtransfer.com</cite>';
		}
	}
	return $ret;
}

# Mail koji se salje vozacu sa zahtjevom da potvrdi transfer
function sendDriverNotification($OrderID, $OrderKey) {
	require_once ROOT .'/db/v4_OrdersMaster.class.php';
	require_once ROOT .'/db/v4_OrderDetails.class.php';


	$om = new v4_OrdersMaster();
	$od = new v4_OrderDetails();

	$message .= HELLO . '!<br><br>';
	$message .= TRANSFER_FOR_YOU;

	$om->getRow($OrderID);
	$orderKey = $om->getMOrderKey();

	/*
	$coData = getUserData($om->getMUserID());
	$from_mail = $coData['AuthUserMail'];
	$from_name = $coData['AuthUserCompany'];
	*/

	$k = $od->getKeysBy('DetailsID', 'asc', " WHERE OrderID = '". $OrderID . "'");

	foreach($k as $nn => $id) {
		$od->getRow($id);

		$link = '<a href="https://' . 
		//$_SERVER['SERVER_NAME'] . 
		'cms.jamtransfer.com'.		
		'/cms/dc.php?code='.$od->getDetailsID() .
				'&control='.$orderKey.'&id='.$od->getDriverID().'">'.
				$od->getOrderID().'-'.$od->getTNo() .
				'</a>';
		$message .= $link . '<br>';
	}
	$message .= '<br><br>'.THANK_YOU . '! <br><br><br>';
	$message .= pdfFooter('1');

	$mailto = $od->getDriverEmail();
	mail_html($mailto, 'info@jamtransfer.com', 'JamTransfer', 'info@jamtransfer.com',
		  NEW_TRANSFER . ' - ' . $OrderKey , $message);

	mail_html('bogo@jamtransfer.com', 'info@jamtransfer.com', 'JamTransfer', 'info@jamtransfer.com',
		  'sendToDriverNotification' . ' - ' . $OrderKey , $message);

}



function Logo($color='black') { ?>
		  <span style="font-family: Arial, sans-serif;" >
		  <span style="font-weight:300;color:<?= $color?>;"><span style="color:#f44336;">&#9670;</span><span style="color:<?= $color?>;font-weight:bold;">jam</span>transfer.com</span>
		  </span>
<?
}

function CSV($csv, $row) {
	# csv = csv string
	# row = array with values

	$delimiter = ";";
	foreach($row as $key => $value) {
		$csv .= $value . $delimiter;
	}
	return $csv;
}



# Provjera Refresh-a stranice
function PageRefreshed() {
	//The second parameter on print_r returns the result to a variable rather than displaying it
	$RequestSignature = md5($_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING'].print_r($_REQUEST, true));

	if ($_SESSION['LastRequest'] == $RequestSignature)
	{
	// refresh
	return true;
	}
	else
	{
	  // This is a new request.
	  $_SESSION['LastRequest'] = $RequestSignature;
	  return false;
	}
}




# vraca root folder na serveru
function Root() {
	return(substr($_SERVER["SCRIPT_FILENAME"], 0, (stripos($_SERVER["SCRIPT_FILENAME"], $_SERVER["SCRIPT_NAME"])+1)));
}



# ispituje postoji li $_SESSION ili $_REQUEST varijabla
# i je li prazna
# Ako ima sadrzaj, vraca TRUE, ako ne postoji ili je prazna vraca FALSE

function is($value, $type='s') {
	if ($type == 's') {
		if( isset($_SESSION[$value]) and
		($_SESSION[$value] != '' or $_SESSION[$value] != 0 or $_SESSION[$value] != NULL)
		) return true;
	}
	if ($type == 'r') {
		if( isset($_REQUEST[$value]) and
		($_REQUEST[$value] != '' or $_REQUEST[$value] != 0 or $_REQUEST[$value] != NULL)
		) return true;
	}

	return false;
}


# Vraca array sa tekstovima za trazenu stranicu
function getArticles($page, $lang) {
	require_once ROOT .'/db/v4_Articles.class.php';
	$ar = new v4_Articles();
	$Articles = array();

	//languages
	/* za ovaj slucaj ne vrijedi!!!
	$getArticle = 'getArticle';
	if(s('language') != 'en') {
		$getArticle = 'getArticle_'. strtoupper( s('language') );
	} */
	$keys = $ar->getKeysBy('Position', 'asc', " WHERE Page = '".$page."'
												AND Published = '1'
												AND Language = '" . $lang ."'");
	foreach($keys as $nn => $id) {
		$ar->getRow($id);
		$Articles[] = html_entity_decode($ar->getArticle(), ENT_QUOTES | ENT_XML1, 'UTF-8');
		//$Articles[] = htmlentities($ar->getArticle(), ENT_COMPAT, 'UTF-8');


	}

	return $Articles;
}


# kreira random broj narudzbe
function create_order_key() {
	srand(time());
	$whichone1 = (rand()%10);
	$whichone2 = (rand()%10);
	$whichone3 = (rand()%10);
	$whichone4 = (rand()%10);
	$whichone5 = (rand()%10);
	$str = "";
	$str2 = "ABCDEFGHIJKLMNPQRSTUVWXYZ";
	for($i=0;$i<10;$i++) {
		$random = (rand()%10);
		$random2 = (rand()%11);
		$random3 = (rand()%27);
		if($i == $whichone1 || $i == $whichone2 || $i == $whichone3 || $i == $whichone4 || $i == $whichone5)
			$str .= $str2[$random3];
		else {
			if ($random == 0) $random = 1;
			$str .= $random;
		}
	}

	return $str;
}


# sort 2-d arraya
function subval_sort($a,$subkey) {
	foreach($a as $k=>$v) {
		$b[$k] = strtolower($v[$subkey]);
	}
	asort($b);
	foreach($b as $key=>$val) {
		$c[] = $a[$key];
	}

	return $c;
}

# sort 2-d arraya
function subval_sort_int($a,$subkey) {
	foreach($a as $k=>$v) {
		$b[$k] = intval($v[$subkey]);
	}
	asort($b);
	foreach($b as $key=>$val) {
		$c[] = $a[$key];
	}

	return $c;
}

# pretrazivanje 2-d arraya
function recursive_array_search($needle,$haystack,$strict=true) {
 foreach($haystack as $key=>$value) {
		$current_key=$key;
		if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
			echo $current_key . $value[$current_key].'<br>';
			return $current_key;
		}
		//echo $needle.'<br>';
	}

	return NULL;
}


# Postoji li u Places
function isPlace($string) {
	require_once ROOT.'/db/v4_Places.class.php';
	$p = new v4_Places();

	$string = $p->myreal_escape_string($string);

	$where  = " WHERE PlaceNameEN = '". $string . "' ";
	$where .= " OR PlaceNameRU = '". $string . "' ";
	$where .= " OR PlaceNameFR = '". $string . "' ";
	$where .= " OR PlaceNameDE = '". $string . "' ";
	$where .= " OR PlaceNameIT = '". $string . "' ";
	$where .= " OR PlaceNameSEO = '". $string . "' ";

	$keys = $p->getKeysBy("PlaceID", "ASC", $where);
	$p->endv4_Places();

	if (count($keys) != 0)  return true;
	else return false;
}


# vraca CountryDesc
function countryInfo($countryID) {
	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();

	$countryID = $db->real_escape_string($countryID);

	$q  = "SELECT * FROM v4_Countries ";
	$q .= "WHERE CountryID = '{$countryID}'";

	$w = $db->RunQuery($q);
	$c = mysqli_fetch_object($w);
	$v = 'CountryDesc'.Lang();

	return $c->$v; // $c->CountryDesc;
}


# vraca CountryName
function countryName($countryID) {
	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();
	$q  = "SELECT * FROM v4_Countries ";
	$q .= "WHERE CountryID = '{$countryID}'";

	$w = $db->RunQuery($q);
	$c = $w->fetch_object();
	$v = "CountryName".Lang();

	return $c->$v; // $c->CountryName;
}


function s($variable) {
	if(isset($_SESSION[$variable])
		and $_SESSION[$variable] != ''
		//and !empty($_SESSION[$variable])
		and $_SESSION[$variable] != NULL)

		return $_SESSION[$variable];
	else return '';
}


function r($variable) {
	if(isset($_REQUEST[$variable])
		and $_REQUEST[$variable] != ''
		//and !empty($_REQUEST[$variable])
		and $_REQUEST[$variable] != NULL)

		return $_REQUEST[$variable];
	else return '';
}


function getCountryName($CountryID) {
	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();

	$CountryID = $db->real_escape_string($CountryID);

	$q  = " SELECT * FROM v4_Countries ";
	$q .= " WHERE CountryID = '{$CountryID}'";

	$w = $db->RunQuery($q);
	$c = mysqli_fetch_object($w);
	$v = 'CountryName'.Lang();

	return $c->$v; // $c->CountryName;
}


function getCountryPrefix($CountryName) {
	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();

	//$CountryName = $db->real_escape_string($CountryName);

	$q  = " SELECT * FROM v4_Countries ";
	$q .= " WHERE CountryName = '" . $CountryName . "'";

	$w = $db->RunQuery($q);
	$c = mysqli_fetch_object($w);

	return $c->PhonePrefix; // $c->CountryName;
}

function getDriverPrice($ServiceID) {
	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();

	$ServiceID = $db->real_escape_string($ServiceID);

	$q  = " SELECT * FROM v4_Services ";
	$q .= " WHERE ServiceID = '{$ServiceID}'";

	$w = $db->RunQuery($q);
	$c = $w->fetch_object();

	return $c->ServicePrice1;
}


// Dodavanje dogovorene provizije na osnovnu cijenu
function addJTProvision($price, $ownerid, $VehicleClass = 1) {
	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();

	# Driver
	$q = "SELECT * FROM v4_AuthUsers
				WHERE AuthUserID = '" .$ownerid."'
				";
	$w = $db->RunQuery($q);

	$d = $w->fetch_object();

	if($d->AuthUserID == $ownerid) {

		// STANDARD CLASS
		//if($VehicleClass < 11) {
			if ($price >= $d->R1Low and $price <= $d->R1Hi) return $price + ($price*$d->R1Percent / 100);
			else if ($price >= $d->R2Low and $price <= $d->R2Hi) return $price + ($price*$d->R2Percent / 100);
			else if ($price >= $d->R3Low and $price <= $d->R3Hi) return $price + ($price*$d->R3Percent / 100);
			else return $price;
		//}
/*
		// PREMIUM CLASS
		if($VehicleClass >= 11 and $VehicleClass < 21) {
			if ($price >= $d->PR1Low and $price <= $d->PR1Hi) return $price + ($price*$d->PR1Percent / 100);
			else if ($price >= $d->PR2Low and $price <= $d->PR2Hi) return $price + ($price*$d->PR2Percent / 100);
			else if ($price >= $d->PR3Low and $price <= $d->PR3Hi) return $price + ($price*$d->PR3Percent / 100);
			else return $price;
		}

		// FIRST CLASS
		if($VehicleClass >= 21) {
			if ($price >= $d->FR1Low and $price <= $d->FR1Hi) return $price + ($price*$d->FR1Percent / 100);
			else if ($price >= $d->FR2Low and $price <= $d->FR2Hi) return $price + ($price*$d->FR2Percent / 100);
			else if ($price >= $d->FR3Low and $price <= $d->FR3Hi) return $price + ($price*$d->FR3Percent / 100);
			else return $price;
		}
*/
	}

	return '0';


}


function getUserData($UserID) {
	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();

	$UserID = $db->real_escape_string($UserID);

	$q  = " SELECT * FROM v4_AuthUsers ";
	$q .= " WHERE AuthUserID = '{$UserID}'";

	$w = $db->RunQuery($q);
	$c = mysqli_fetch_array($w);

	return $c;
}


function getUser($UserID) {
	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();

	$UserID = $db->real_escape_string($UserID);

	$q  = " SELECT * FROM v4_AuthUsers ";
	$q .= " WHERE AuthUserID = '{$UserID}'";

	$w = $db->RunQuery($q);
	$c = mysqli_fetch_object($w);

	return $c;
}



function GetPlaceDescription($placeID) {
	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();

	$placeID = $db->real_escape_string($placeID);

	$q  = "SELECT * FROM v4_Places ";
	$q .= "WHERE PlaceID = '{$placeID}'";

	$w = $db->RunQuery($q);
	$c = mysqli_fetch_object($w);
	$v = 'PlaceDesc'.Lang();

	return $c->$v; // $c->PlaceDesc;
}

function getPlaceIDFromPlaceName ($placeName) {
	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();

	$placeName = $db->real_escape_string($placeName);


	$q  = " SELECT * FROM v4_Places ";
	$q .= " WHERE PlaceNameSEO = '{$placeName}'";
	$q .= " OR PlaceNameEN = '{$placeName}'";
	$q .= " OR PlaceNameRU = '{$placeName}'";
	$q .= " OR PlaceNameDE = '{$placeName}'";
	$q .= " OR PlaceNameFR = '{$placeName}'";
	$q .= " OR PlaceNameIT = '{$placeName}'";

	$w = $db->RunQuery($q);
	$c = mysqli_fetch_object($w);

	return $c->PlaceID;
}

function getPlaceName ($placeID) {
	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();

	$placeID = $db->real_escape_string($placeID);

	$q  = " SELECT * FROM v4_Places ";
	$q .= " WHERE PlaceID = '{$placeID}'";

	$w = $db->RunQuery($q);
	$c = mysqli_fetch_object($w);

	$name = 'PlaceName'.Lang();



	$PlaceName = $c->$name; // $c->{$name};
	if(trim($PlaceName) == '') $PlaceName = $c->PlaceNameEN;
	$db->CloseMysql();

	return $PlaceName;
}

function getPlaceCountry ($placeID) {
	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();

	$placeID = $db->real_escape_string($placeID);

	$q  = " SELECT * FROM v4_Places ";
	$q .= " WHERE PlaceID = '{$placeID}'";

	$w = $db->RunQuery($q);
	$c = mysqli_fetch_object($w);

	return $c->PlaceCountry;
}

// vraca PlaceTypeID
function getPlaceType ($placeID) {
	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();

	$placeID = $db->real_escape_string($placeID);

	$q  = " SELECT * FROM v4_Places ";
	$q .= " WHERE PlaceID = '{$placeID}'";

	$w = $db->RunQuery($q);
	$c = mysqli_fetch_object($w);

	$name = 'PlaceType';
	//error_log('Log: ' . $placeID,3,ROOT . '/mylog.log'); // ovo radi :)
	return $c->{$name};
}

function getPlaceSEO ($placeID) {
	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();

	$placeID = $db->real_escape_string($placeID);

	$q  = " SELECT * FROM v4_Places ";
	$q .= " WHERE PlaceID = '{$placeID}'";

	$w = $db->RunQuery($q);
	$c = mysqli_fetch_object($w);

	$name = 'PlaceName'.'SEO';
	//error_log('Log: ' . $placeID,3,ROOT . '/mylog.log'); // ovo radi :)
	return $c->{$name};
}

function getPlaceCountryFromPlaceName ($placeName) {

	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();

	$placeName = $db->real_escape_string($placeName);

	$q  = " SELECT * FROM v4_Places ";
	$q .= " WHERE PlaceNameSEO = '{$placeName}'";
	$q .= " OR PlaceNameEN = '{$placeName}'";
	$q .= " OR PlaceNameRU = '{$placeName}'";
	$q .= " OR PlaceNameFR = '{$placeName}'";
	$q .= " OR PlaceNameDE = '{$placeName}'";
	$q .= " OR PlaceNameIT = '{$placeName}'";


	$w = $db->RunQuery($q);
	$c = $w->fetch_object();

	return $c->PlaceCountry;
}

function getVehicleTypeName($vehicleTypeId) {
	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();



	$q  = " SELECT * FROM v4_VehicleTypes ";
	//$q .= " WHERE VehicleClass = '{$vehicleTypeId}'"; // ovo je bilo do 03.03.2016
	$q .= " WHERE VehicleTypeID = '{$vehicleTypeId}'";

	$w = $db->RunQuery($q);
	$c = mysqli_fetch_object($w);

	$v = 'VehicleTypeName'.Lang();

	return $c->$v; // $c->VehicleTypeName
}

function getVehicleTypeID($vehicleId) {
	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();
	$q  = " SELECT * FROM v4_Vehicles ";
	$q .= " WHERE VehicleID = '{$vehicleId}'";

	$w = $db->RunQuery($q);
	$c = mysqli_fetch_object($w);

	return $c->VehicleTypeID;
}

function getSubVehicleName($vehicleId) {
    require_once ROOT .'/db/db.class.php';
    $db = new DataBaseMysql();
    $q  = " SELECT * FROM v4_SubVehicles ";
    $q .= " WHERE VehicleID = '{$vehicleId}'";

    $w = $db->RunQuery($q);
    $c = mysqli_fetch_object($w);

    return $c->VehicleDescription;
}

function getMaxPax($vehicleTypeId) {
	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();
	$q  = " SELECT * FROM v4_VehicleTypes ";
	$q .= " WHERE VehicleTypeID = '{$vehicleTypeId}'";

	$w = $db->RunQuery($q);
	$c = mysqli_fetch_object($w);

	return $c->Max;
}

function getVehicleName($vehicleId) {
	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();
	$q  = " SELECT * FROM v4_Vehicles ";
	$q .= " WHERE VehicleID = '{$vehicleId}'";

	$w = $db->RunQuery($q);
	$c = mysqli_fetch_object($w);

	return $c->VehicleName;
}

function getFromRoutes($RouteID, $field='FromID') {
	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();
	$q  = " SELECT * FROM v4_Routes ";
	$q .= " WHERE RouteID = '{$RouteID}'";

	$w = $db->RunQuery($q);
	$c = mysqli_fetch_object($w);

	return $c->{$field};
}

function getOrderDetails($OrderID) {
	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();
	$q  = " SELECT * FROM v4_OrderDetails ";
	$q .= " WHERE OrderID = '{$OrderID}'";
	$retArr = array();

	$w = $db->RunQuery($q);
	while($c = $w->fetch_object() ) {
		// array of objects
		$retArr[] = $c;

	}

	return $retArr;
}

function getServiceName($ServiceID) {
	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();
	$q  = " SELECT * FROM v4_Extras ";
	$q .= " WHERE ID = '{$ServiceID}'";

	$w = $db->RunQuery($q);
	$c = mysqli_fetch_object($w);
	$v = 'Service'.Lang();

	return $c->$v;
}

function mail_html($mailto, $from_mail, $from_name, $replyto, $subject, $message, $attachment = '') {


	require_once ROOT . '/PHPMailer-master/PHPMailerAutoload.php';

	$mail = new PHPMailer;

	//$mail->SMTPDebug = 3;									// Enable verbose debug output
	/*
    $mail->isSMTP();										// Set mailer to use SMTP
    $mail->Host = 'smtp1.example.com;smtp2.example.com';	// Specify main and backup SMTP servers
    $mail->SMTPAuth = true;									// Enable SMTP authentication
    $mail->Username = 'user@example.com';					// SMTP username
    $mail->Password = 'secret';								// SMTP password
    $mail->SMTPSecure = 'tls';								// Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;										// TCP port to connect to
    */
	$mail->CharSet = 'UTF-8';
	$mail->setFrom($from_mail, $from_name);
	$mail->addAddress($mailto);									// Add a recipient
	//$mail->addAddress('ellen@example.com');					// Name is optional
	$mail->addReplyTo($replyto, $from_name);
	//$mail->addCC('cc@example.com');
	//$mail->addBCC('bcc@example.com');

	if($attachment != '') $mail->addAttachment($attachment);	// Add attachments
	//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');		// Optional name
	$mail->isHTML(true);										// Set email format to HTML

	$mail->Subject = $subject;
	$mail->Body    = $message;
	//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	if(!$mail->send()) {
		return 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		return 'OK';
	}
}

/*
**
** FROM CMS
**
*/


/*
	poziva: cms/dc.php, cms/a/sendUpdateEmail.php
*/

function printReservation( $OrderID, $profile, $d, $m) {
?>
	<?
	$PickupName = $d->PickupName;
	$DropName = $d->DropName;
	/* fix za problem sa voucherima za vozace na drugim jezicima */
	if ($profile == 'driver') {
		require_once ROOT . '/db/v4_Places.class.php';
		$p = new v4_Places();

		$p->getRow($d->getPickupID());
		$PickupName = $p->getPlaceNameEN();

		$p->getRow($d->getDropID());
		$DropName = $p->getPlaceNameEN();
	}
	?>
	<table width="100%" style="table-layout:fixed">
		<col width="200px">
		<col>
		<tr>
			<td colspan="2">
				<h3>RESERVATION CODE :
					<strong><?= $m->MOrderKey . '-'. $m->MOrderID .'-'.$d->TNo ?></strong>
				</h3>
				<small><?= $m->MOrderDate . ' ' . $m->MOrderTime ?></small><hr>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<h3 class=""><?= ROUTE ?></h3>
			</td>
		<tr>
		<tr>
			<td><?= FROM ?>:</td>
			<td><strong><?= $PickupName ?></strong></td>
		</tr>
		<tr>
			<td><?= PICKUP_ADDRESS ?>:</td>
			<td><?= $d->PickupAddress  ?></td>
		</tr>
		<tr>
			<td><?= TO ?>:</td>
			<td><strong><?= $DropName ?></strong></td>
		</tr>
		<tr>
			<td><?= DROPOFF_ADDRESS ?>:</td>
			<td><?=  $d->DropAddress  ?></td>
		</tr>
		<tr>
			<td><?= PICKUP_DATE ?>:</td>
			<td><?= $d->PickupDate  ?> <small>(Y-M-D)</small></td>
		</tr>
		<tr>
			<td><?= PICKUP_TIME ?>:</td>
			<td><?= $d->PickupTime  ?> <small>(H:M 24h)</small></td>
		</tr>
		<tr>
			<td><?= FLIGHT_NO ?>:</td>
			<td><?= $d->FlightNo  ?></td>
		</tr>
		<tr>
			<td><?= FLIGHT_TIME ?>:</td>
			<td><?= $d->FlightTime  ?></td>
		</tr>
		<tr>
			<td><?= PAX?>:</td>
			<td><?= $d->PaxNo  ?></td>
		</tr>
		<tr>
			<td colspan="2">
				<br>
				<h3 class=""><?= PASSENGER ?></h3>
			</td>
		</tr>
		<tr>
			<td><?= NAME ?>:</td>
			<td><?= $d->PaxName  ?></td>
		</tr>
		<!---
		<tr>
			<td><?= EMAIL ?>:</td>
			<td><?= maskEmail($m->MPaxEmail) ?></td>
		</tr>
		!--->
		<tr>
			<td><?= MOB ?>:</td>
			<td><?= $m->MPaxTel ?></td>
		</tr>
		<tr>
			<td colspan="2">
				<br>
				<h3 class=""><?= VEHICLE?></h3>
			</td>
		</tr>
		<tr>
			<td><?=  VEHICLETYPEID ?>:</td>
			<td><?= getVehicleTypeName($d->VehicleType)  ?> </td>
		</tr>

		<tr>
			<td><?=  VEHICLECAPACITY ?>:</td>
			<td><?= getMaxPax($d->VehicleType)  ?></td>
		</tr>

		<tr>
			<td><?=  VEHICLES ?>:</td>
			<td><?= $d->VehiclesNo ?> </td>
		</tr>

		<tr>
			<td><?=  NOTES ?>:</td>
			<td><?= $d->PickupNotes ?></td>
		</tr>

        <?
        // vozaci nesmiju viditi prodajnu cijenu kod agentskih rezervacija (#956)
        if (($profile != 'driver') and ($d->AgentID != 0)) { ?>
		<tr>
			<td><?= PRICE ?>:</td>
			<td><strong><?= number_format($d->DetailPrice ,2)  . ' ' . CURRENCY ?></strong></td>
		</tr>
        <? } ?>
        
		<tr>
			<td>

			<?
	#				   $ExtraServices  = $d->ExtraServices ;
	#				   $ExtraSubtotals = $d->ExtraSubtotals ;
	#				   $ExtraItems	 = $d->ExtraItems ;
	#
	#				   foreach($ExtraServices as $rbr => $value) {
	#					   if($ExtraSubtotals[$rbr] > 0) {
	#						   echo '<div class="col-md-4">' . $ExtraItems[$rbr] . ' ';
	#						   echo $value . '</div> ';
	#
	#						   echo '<div class="col-md-8">' . $ExtraSubtotals[$rbr] . ' ' . s('Currency')  . '</div>';
	#					   }
	#
	#				   }

	#				   echo '---';

			require_once ROOT . '/db/v4_OrderExtras.class.php';
			$ox = new v4_OrderExtras();

			$where = ' WHERE OrderDetailsID = ' . $d->getDetailsID() . $firstTransferWhere;
			$oXkey = $ox->getKeysBy('ID', 'ASC', $where);
			if( count($oXkey) > 0 ){

				echo '<tr>
						<td colspan="2">
							<br>
							<h3 class="">'. EXTRAS .'</h3>
						</td>
					</tr>';

				foreach($oXkey as $i => $id) {
					$ox->getRow($id);
					echo '<tr><td>' .
							$ox->getServiceName() . ' x ' .
							$ox->getQty();
					echo '</td>';

					echo '<td>' .
							//Eur2( $ox->getSum(),$m->getMOrderCurrency() ) . //ne prikazivati cene
							//' ' . $m->getMOrderCurrency() .
					'</td></tr>';
				}
			}
			?>

			</td>
		</tr>
		<tr>
			<td colspan="2">
				<br>
				<h3><?= TOTAL ?></h3>
			</td>
		</tr>		
		<? if ($profile == "driver") { ?>
			<tr>
				<td><strong>Driver's Price:</strong></td>
				<td><strong><?= number_format($d->DriversPrice,2) . ' ' . CURRENCY ?></strong></td>
			</tr>
			<? if ($d->PaymentMethod == 2 or  $d->PaymentMethod == 3) { ?>
			<tr>
				<td><strong><?= CASH ?>:</strong></td>
				<td><strong><?= number_format($d->PayLater ,2)  . ' ' . CURRENCY ?></strong></td>
			</tr>
			<? } ?>		
		<? } else { ?>		
			<? if ($d->PaymentMethod==4) { ?>
			<tr>
				<td><strong>Payment Method:</strong></td>
				<td><strong>Invoice</strong></td>
			</tr>
			<? } else { ?>
			<tr>	
				<td><strong><?=  ONLINE ?>:</strong></td>
				<td><strong><?= number_format($d->PayNow ,2)  . ' ' . CURRENCY ?></strong></td>
			</tr>
			<tr>
				<td><strong><?=  CASH ?>:</strong></td>
				<td><strong><?= number_format($d->PayLater ,2)  . ' ' . CURRENCY ?></strong></td>
			</tr>
			<? } ?>
		<? } ?>
		<tr>
			<td colspan="2">
				<br><br>
				<p style="font-size:.7em;text-transform:uppercase;text-align:left;">
					<?= SERVICES_DESC1 ?> |
					<?= SERVICES_DESC2 ?> |
					<?= SERVICES_DESC3 ?> |
					<?= SERVICES_DESC4 ?> |
					<?= SERVICES_DESC5 ?> |
					<?= SERVICES_DESC6 ?> |
					<?= SERVICES_DESC7 ?> |
					<?= SERVICES_DESC8 ?> |
					<?= SERVICES_DESC9 ?>
					<br>
				</p>
			</td>
		</tr>
	</table>
<?
}

/**
 * Create a web friendly URL slug from a string.
 *
 */
function url_slug($str) {

$str = trim($str);
$separator= '+';
 # special accents
	$a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','A','a','A','a','A','a','Č','č','Ć','ć','C','c','C','c','D','d','Ð','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','?','?','J','j','K','k','L','l','L','l','L','l','?','?','L','l','N','n','N','n','N','n','?','O','o','O','o','O','o','Œ','œ','R','r','R','r','R','r','S','s','S','s','S','s','Š','š','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Ÿ','Z','z','Z','z','Ž','ž','?','ƒ','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','?','?','?','?','?','?');
	$b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
	$str= strtolower(str_replace($a,$b,$str));


	if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
		$str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
	$str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
	$str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\\1', $str);
	$str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
	$str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), $separator, $str);
	$str = strtolower( trim($str, '_') );
	$str = preg_replace('/\+\++/', $separator, $str);
	return $str;

}



/*
	cita file i pretvara ga u valjani jquery string
*/
function prepareScript($file) {
	$string = "'" . file_get_contents($file) . "'";
	$string = str_replace('{{', "'+", $string);
	$string = str_replace('}}', "+'", $string);
	$string = str_replace("''+", "\''+", $string);
	$string = str_replace("+''", "+'\'", $string);

	$string = str_replace(PHP_EOL, "", $string);
	return $string;
}

function parseOutput($string) {
	$string = str_replace('{{', "'+", $string);
	$string = str_replace('; ?>', "+'", $string);
	$string = str_replace("''+", "\''+", $string);
	$string = str_replace("+''", "+'\'", $string);

	$string = str_replace(PHP_EOL, "", $string);
	$string = trim(preg_replace('/\t+/', '', $string));
	$string = trim(preg_replace('/\n+/', '', $string));
	$string = trim(preg_replace('/\ +/', ' ', $string));
	return $string;
}

function langs($lang, $string)
{
	# make full search string
	$s1 = '['.$lang.']';
	$s2 = '[/'.$lang.']';

	# find positions
	$start = stripos($string, $s1)+4;
	$end   = stripos($string, $s2);

	# required language found
	if ($start and $end)
	{
		$retStr = substr( $string, $start, $end - $start);
		return $retStr;
	}
	# required language not found, other languages exist, return default language
	else if (stripos($string, '[') )
	{
		$retStr = substr( $string, 0, stripos($string, '[') );
		return $retStr;
	}

	# no languages but default
	return $string;
}



function fillPaxNo($maxPax=55)
{
	for ($i=0; $i<$maxPax + 1;$i++)
	{

		echo '<option value="'.$i.'" ';
		if (s('PaxNo') == $i) echo 'selected="selected" ';
		echo '>';
		if ($i == 0) echo '---';
		else echo $i;
		echo '</option>';
	}
}



# vraca VehicleTypeID preko ServiceID
function GetVehicleIDFromServiceID($service_id)
{
$query_Recordset1 = "SELECT * FROM ".DB_PREFIX."services
					 WHERE ServiceID = '".$service_id."'
					 "
					 ;

$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

return $row_Recordset1['VehicleID'];
}


# booking_thankyou.php
function GetRouteID($t, $d)
{
	$qry = "SELECT RouteID FROM ".DB_PREFIX."routes
			WHERE (FromID = {$t} AND ToID = {$d})
			OR (FromID = {$d} AND ToID = {$t})
			ORDER BY RouteID ASC";
	$res = mysql_query($qry) or die(mysql_error());
	$row = mysql_fetch_assoc($res);

	return $row['RouteID'];
}


function GetRouteDetails($t, $d)
{
	require_once ROOT . '/db/db.class.php';
	$db = new DataBaseMysql();

	$qry = "SELECT * FROM v4_Routes
			WHERE (FromID = {$t} AND ToID = {$d})
			OR (FromID = {$d} AND ToID = {$t})
			ORDER BY RouteID ASC";
	$res = $db->RunQuery($qry);
	$row = $res->fetch_assoc();

	return $row;
}

# Fill $countries array with country data
function fillCountries()
{
	$countries = array();

	# Find all routes that have drivers
#	$q = "SELECT RouteID, OwnerID FROM ".DB_PREFIX."routes WHERE OwnerID =".$_SESSION['OwnerID'];

#	$w = mysql_query($q) or die(mysql_error());

#	while($d = mysql_fetch_object($w))
#	{

		# find starting and ending points for each Route
		$q1 = "SELECT * FROM ".DB_PREFIX."routes

					";
		$r1 = mysql_query($q1) or die(mysql_error());

		while($r = mysql_fetch_object($r1))
		{

			# Get Place Country id's
			$q2 = "SELECT * FROM ".DB_PREFIX."places
				   WHERE PlaceID = '{$r->FromID}'
				   OR PlaceID = '{$r->ToID}'
						";
			$w2 = mysql_query($q2) or die(mysql_error());

			while ($p = mysql_fetch_object($w2))
			{
				# Get Country Names
				$q3 = "SELECT * FROM ".DB_PREFIX."countries
							WHERE CountryID = '{$p->PlaceCountry}'
							";
				$r3 = mysql_query($q3) or die(mysql_error());

				$c = mysql_fetch_object($r3);
				$v = 'CountryName'.Lang();

				# Check for duplicates and add to array
				if (!in_array($c->$v,$countries)) $countries[$c->CountryID] = $c->$v;
			}
#	   }
	}

	# Sort by name
	asort($countries);
	return $countries;

} #end function


# echo country <option>
function getCountries()
{
	$countries = fillCountries();

		echo '<option value="0">';
		echo PLEASE_SELECT;
		echo '</option>';

	foreach ($countries as $id => $name)
	{
		# code...
		echo '<option value="'.$id.'"';
		if ($id == s('wCountry')) echo ' selected="selected"';
		echo '>';
		echo $name;
		echo '</option>';

	}
} # end function


#iz demo index.php
function isLocation($name)
{
	global $countryDisplayName, $locationID;

	$name2 = strtolower($name);
	$q  = "SELECT * FROM ".DB_PREFIX."places WHERE PlaceLinkName = '" . $name2 . "' ORDER BY PlaceLinkName ASC";

	$w = mysql_query($q) or die(mysql_error().' Places');

	if (mysql_num_rows($w) == 1) {
		$p = mysql_fetch_object($w);
		$c = GetCountryName($p->PlaceCountry);

		$countryDisplayName = $c;
		$_SESSION['locationID'] = $locationID = $p->PlaceID;
		$_SESSION['countryId'] = $p->PlaceCountry;

		return $p->PlaceLinkName;
	}

	else return false;

}


function Percent($ukupno, $detalj) {
	return  round(($detalj / $ukupno) * 100, 2);
}


/*
**
** FUNKCIJE ZA IZRACUNAVANJE CIJENA I DODATAKA
**
*/
function calcSurcharge( $base, $percent, $amount=0) {
	$add = $base * $percent / 100;
	if ($amount == 0) return number_format($base + $add, 2, '.','');
	if ($percent == 0) return number_format($base + $amount,2, '.','');
}

function calcAddPrice( $base, $percent, $amount=0) {
	$add = $base * $percent / 100;
	if ($amount == 0) return number_format($add, 2, '.','');
	if ($percent == 0) return number_format($amount,2, '.','');
}

// izracun dodataka na cijene za booking formu
function Surcharges($OwnerID, $SurCategory, $base, $tDate, $tTime, $rDate='', $rTime='',
					 $RouteID='', $VehicleID='', $ServiceID='',
					 $VSurCategory='', $DRSurCategory='') {

	// Variables
	$sur = array(
								'NightPrice'		=> 0,
								'MonPrice'		  => 0,
								'TuePrice'		  => 0,
								'WedPrice'		  => 0,
								'ThuPrice'		  => 0,
								'FriPrice'		  => 0,
								'SatPrice'		  => 0,
								'SunPrice'		  => 0,
								'S1Price'		   => 0,
								'S2Price'		   => 0,
								'S3Price'		   => 0,
								'S4Price'		   => 0,
								'S5Price'		   => 0,
								'S6Price'		   => 0,
								'S7Price'		   => 0,
								'S8Price'		   => 0,
								'S9Price'		   => 0,
								'S10Price'		  => 0

	);
	$owp = 0;
	$rp  = 0;

	$finished = false;

	for($i=1; $i<=4;$i++) {

		if(!$finished) {

			switch($i) {
				case '4':
					require_once ROOT . '/db/v4_SurGlobal.class.php';
					$sc = new v4_SurGlobal();

					$sck = $sc->getKeysBy('ID', 'asc', ' WHERE OwnerID = ' . $OwnerID);
					if (count($sck) > 0) $sc->getRow($sck[0]);
					//if($sc->getOwnerID() != $OwnerID) return $sur; ?? ovo nisam siguran
					break;


				case '2':
					require_once ROOT . '/db/v4_SurVehicle.class.php';
					$sc = new v4_SurVehicle();
					$where = ' WHERE OwnerID = ' . $OwnerID . ' AND VehicleID = ' . $VehicleID;
					$sck = $sc->getKeysBy('ID', 'asc', $where);
					if (count($sck) > 0) {
						$sc->getRow($sck[0]);
						//$finished = true;
					}
					break;


				case '3':
					require_once ROOT . '/db/v4_SurRoute.class.php';
					$sc = new v4_SurRoute();
					$where = ' WHERE OwnerID = ' . $OwnerID . ' AND DriverRouteID = ' . $RouteID;
					$sck = $sc->getKeysBy('DriverRouteID', 'asc', $where);
					if (count($sck) > 0) {
						$sc->getRow($sck[0]);
						//$finished = true;
					}
					break;



				case '1':
					require_once ROOT . '/db/v4_SurService.class.php';
					$sc = new v4_SurService();
					$where = ' WHERE OwnerID = ' . $OwnerID . ' AND ServiceID = ' . $ServiceID;
					$sck = $sc->getKeysBy('ID', 'asc', $where);
					if (count($sck) > 0) {
						$sc->getRow($sck[0]);
						//$finished = true;
					}
					break;
			}

			if(
				// service surcharges
				($i == 1 and $SurCategory == 4) or
				// route surcharges
				($i == 3 and $DRSurCategory == 3) or
				// vehicle surcharges
				($i == 2 and $VSurCategory == 2) or

				// global surcharges
				(($i == 4 and $SurCategory == 1) and
				($i == 4 and $VSurCategory == 1) and
				($i == 4 and $DRSurCategory == 1) )
			) {
				// trazimo samo dodatke na osnovnu cijenu, ne i konacne cijene!
				// zato je na kraju -base

				if( inTimeRange($sc->getNightStart(), $sc->getNightEnd(), $tTime) ) {
					$owp = calcAddPrice($base, $sc->getNightPercent(), $sc->getNightAmount() );
				}
				if($rTime != '') {
					if( inTimeRange($sc->getNightStart(), $sc->getNightEnd(), $rTime) ) {
						$rp = calcAddPrice($base, $sc->getNightPercent(), $sc->getNightAmount() );
					}
				}
				$sur['NightPrice'] = ($owp + $rp); $owp = $rp = 0;


				// Monday
				if( date("w", strtotime($tDate)) == 1 ) {
					$owp = calcAddPrice($base, $sc->getMonPercent(), $sc->getMonAmount() );
				}
				if($rDate != '') {
					if( date("w", strtotime($rDate)) == 1 ) {
						$rp = calcAddPrice($base, $sc->getMonPercent(), $sc->getMonAmount() );
					}
				}
				$sur['MonPrice'] = ($owp + $rp); $owp = $rp = 0;


				// Tuesday
				if( date("w", strtotime($tDate)) == 2 ) {
					$owp = calcAddPrice($base, $sc->getTuePercent(), $sc->getTueAmount() );
				}
				if($rDate != '') {
					if( date("w", strtotime($rDate)) == 2 ) {
						$rp = calcAddPrice($base, $sc->getTuePercent(), $sc->getTueAmount() );
					}
				}
				$sur['TuePrice'] = ($owp + $rp); $owp = $rp = 0;


				// Wednesday
				if( date("w", strtotime($tDate)) == 3 ) {
					$owp = calcAddPrice($base, $sc->getWedPercent(), $sc->getWedAmount() );
				}
				if($rDate != '') {
					if( date("w", strtotime($rDate)) == 3 ) {
						$rp = calcAddPrice($base, $sc->getWedPercent(), $sc->getWedAmount() );
					}
				}
				$sur['WedPrice'] = ($owp + $rp); $owp = $rp = 0;


				// Thursday
				if( date("w", strtotime($tDate)) == 4 ) {
					$owp = calcAddPrice($base, $sc->getThuPercent(), $sc->getThuAmount() );
				}
				if($rDate != '') {
					if( date("w", strtotime($rDate)) == 4 ) {
						$rp = calcAddPrice($base, $sc->getThuPercent(), $sc->getThuAmount() );
					}
				}
				$sur['ThuPrice'] = ($owp + $rp); $owp = $rp = 0;

				// Friday
				if( date("w", strtotime($tDate)) == 5 ) {
					$owp = calcAddPrice($base, $sc->getFriPercent(), $sc->getFriAmount() );
				}
				if($rDate != '') {
					if( date("w", strtotime($rDate)) == 5 ) {
						$rp = calcAddPrice($base, $sc->getFriPercent(), $sc->getFriAmount() );
					}
				}
				$sur['FriPrice'] = ($owp + $rp); $owp = $rp = 0;

				// Saturday
				if( date("w", strtotime($tDate)) == 6 ) {
					$owp = calcAddPrice($base, $sc->getSatPercent(), $sc->getSatAmount() );
				}
				if($rDate != '') {
					if( date("w", strtotime($rDate)) == 6 ) {
						$rp = calcAddPrice($base, $sc->getSatPercent(), $sc->getSatAmount() );
					}
				}
				$sur['SatPrice'] = ($owp + $rp); $owp = $rp = 0;


				// Sunday
				if( date("w", strtotime($tDate)) == 0 ) {
					$owp = calcAddPrice($base, $sc->getSunPercent(), $sc->getSunAmount() );
				}
				if($rDate != '') {
					if( date("w", strtotime($rDate)) == 0 ) {
						$rp = calcAddPrice($base, $sc->getSunPercent(), $sc->getSunAmount() );
					}
				}
				$sur['SunPrice'] = ($owp + $rp); $owp = $rp = 0;


				// Season 1
				if( inDateRange($sc->getS1Start(), $sc->getS1End(), $tDate) ) {
					$owp = calcAddPrice($base, $sc->getS1Percent(), 0 );
				}
				if($rDate != '') {
					if( inDateRange($sc->getS1Start(), $sc->getS1End(), $rDate) ) {
						$rp = calcAddPrice($base, $sc->getS1Percent(), 0 );
					}
				}
				$sur['S1Price'] = ($owp + $rp); $owp = $rp = 0;


				// Season 2
				if( inDateRange($sc->getS2Start(), $sc->getS2End(), $tDate) ) {
					$owp = calcAddPrice($base, $sc->getS2Percent(), 0 );
				}
				if($rDate != '') {
					if( inDateRange($sc->getS2Start(), $sc->getS2End(), $rDate) ) {
						$rp = calcAddPrice($base, $sc->getS2Percent(), 0 );
					}
				}
				$sur['S2Price'] = ($owp + $rp); $owp = $rp = 0;

				// Season 3
				if( inDateRange($sc->getS3Start(), $sc->getS3End(), $tDate) ) {
					$owp = calcAddPrice($base, $sc->getS3Percent(), 0 );
				}
				if($rDate != '') {
					if( inDateRange($sc->getS3Start(), $sc->getS3End(), $rDate) ) {
						$rp = calcAddPrice($base, $sc->getS3Percent(), 0 );
					}
				}
				$sur['S3Price'] = ($owp + $rp); $owp = $rp = 0;

				// Season 4
				if( inDateRange($sc->getS4Start(), $sc->getS4End(), $tDate) ) {
					$owp = calcAddPrice($base, $sc->getS4Percent(), 0 );
				}
				if($rDate != '') {
					if( inDateRange($sc->getS4Start(), $sc->getS4End(), $rDate) ) {
						$rp = calcAddPrice($base, $sc->getS4Percent(), 0 );
					}
				}
				$sur['S4Price'] = ($owp + $rp); $owp = $rp = 0;


					// Season 5
					if( inDateRange($sc->getS5Start(), $sc->getS5End(), $tDate) ) {
						$owp = calcAddPrice($base, $sc->getS5Percent(), 0 );
					}
					if($rDate != '') {
						if( inDateRange($sc->getS5Start(), $sc->getS5End(), $rDate) ) {
							$rp = calcAddPrice($base, $sc->getS5Percent(), 0 );
						}
					}
					$sur['S5Price'] = ($owp + $rp); $owp = $rp = 0;


					// Season 6
					if( inDateRange($sc->getS6Start(), $sc->getS6End(), $tDate) ) {
						$owp = calcAddPrice($base, $sc->getS6Percent(), 0 );
					}
					if($rDate != '') {
						if( inDateRange($sc->getS6Start(), $sc->getS6End(), $rDate) ) {
							$rp = calcAddPrice($base, $sc->getS6Percent(), 0 );
						}
					}
					$sur['S6Price'] = ($owp + $rp); $owp = $rp = 0;

					// Season 7
					if( inDateRange($sc->getS7Start(), $sc->getS7End(), $tDate) ) {
						$owp = calcAddPrice($base, $sc->getS7Percent(), 0 );
					}
					if($rDate != '') {
						if( inDateRange($sc->getS7Start(), $sc->getS7End(), $rDate) ) {
							$rp = calcAddPrice($base, $sc->getS7Percent(), 0 );
						}
					}
					$sur['S7Price'] = ($owp + $rp); $owp = $rp = 0;

					// Season 8
					if( inDateRange($sc->getS8Start(), $sc->getS8End(), $tDate) ) {
						$owp = calcAddPrice($base, $sc->getS8Percent(), 0 );
					}
					if($rDate != '') {
						if( inDateRange($sc->getS8Start(), $sc->getS8End(), $rDate) ) {
							$rp = calcAddPrice($base, $sc->getS8Percent(), 0 );
						}
					}
					$sur['S8Price'] = ($owp + $rp); $owp = $rp = 0;

					// Season 9
					if( inDateRange($sc->getS9Start(), $sc->getS9End(), $tDate) ) {
						$owp = calcAddPrice($base, $sc->getS9Percent(), 0 );
					}
					if($rDate != '') {
						if( inDateRange($sc->getS9Start(), $sc->getS9End(), $rDate) ) {
							$rp = calcAddPrice($base, $sc->getS9Percent(), 0 );
						}
					}
					$sur['S9Price'] = ($owp + $rp); $owp = $rp = 0;

					// Season 10
					if( inDateRange($sc->getS10Start(), $sc->getS10End(), $tDate) ) {
						$owp = calcAddPrice($base, $sc->getS10Percent(), 0 );
					}
					if($rDate != '') {
						if( inDateRange($sc->getS10Start(), $sc->getS10End(), $rDate) ) {
							$rp = calcAddPrice($base, $sc->getS10Percent(), 0 );
						}
					}
					$sur['S10Price'] = ($owp + $rp);	$owp = $rp = 0;


			}



		} // endif SurCategory > 0
	}
	return $sur;
}

/*
**
** PADA LI DATUM ILI SAT UNUTAR NEKOG PERIODA
** korisno za npr. nocne voznje
*/

function inDateTimeRange($startDate, $startTime, $endDate, $endTime, $date_needle, $time_needle) {

	$t1 = strtotime("{$startDate} {$startTime}:00");
	$t2 = strtotime("{$endDate} {$endTime}:00");
	$tn = strtotime("{$date_needle} {$time_needle}:00");

	return ($tn >= $t1) && ($tn <= $t2); // or return ($tn > $t1) && ($tn < $t2);
}

function inTimeRange($time_start, $time_end, $time_needle) {
	$res = false;
	$t1 = strtotime("1970-01-01 {$time_start}:00");
	$t2 = strtotime("1970-01-01 {$time_end}:00");
	$tn = strtotime("1970-01-01 {$time_needle}:00");
	if ($t1 >= $t2) $t2 = strtotime('+1 day', $t2);
	if ($tn <= $t1) $tn = strtotime('+1 day', $tn);
	return ($tn >= $t1) && ($tn <= $t2); // or return ($tn > $t1) && ($tn < $t2);
}


function inDateRange($start, $end, $needle) {
	if (empty($start)) return false;
	if (empty($end)) return false;
	if (empty($needle)) return false;

	$parts = explode('-', $needle);
	$year = $parts[0];

	$fullStart = $year . '-'.$start;
	$fullEnd   = $year . '-'.$end;

	if($fullStart < $fullEnd) {
		return ($needle >= $fullStart) && ($needle <= $fullEnd);
	}
	if($fullStart > $fullEnd) {
		$fullEnd   = $year+1 . '-'.$end;
		return ($needle >= $fullStart) && ($needle <= $fullEnd);
	}
	if($fullStart == $fullEnd) {
		return ($needle == $fullStart) && ($needle == $fullEnd);
	}
}


function isInDateRange($start, $end, $needle) {
	if (empty($start)) return false;
	if (empty($end)) return false;
	if (empty($needle)) return false;

	$fullStart = $start;
	$fullEnd   = $end;

	if($fullStart < $fullEnd) {
		return ($needle >= $fullStart) && ($needle <= $fullEnd);
	}
	if($fullStart > $fullEnd) {
		$fullEnd   = date("Y")+1 . '-'.$end;
		return ($needle >= $fullStart) && ($needle <= $fullEnd);
	}
	if($fullStart == $fullEnd) {
		return ($needle == $fullStart) && ($needle == $fullEnd);
	}
}


/*
**
** GLAVNA FUNKCIJA ZA ISPIS POTVRDE / CONFIRMATION / VOUCHER
** poziva:  cms/a/sendUpdateEmail.php
**		  cms/p/modules/bookingFreeForm.php
**		  f/voucher.php
**		  t/para_thankyou.php
**		  widget/thankyou.php
*/
function printVoucher($OrderID, $showPrices = true) {
	//echo '<pre>'; print_r($_REQUEST); echo '</pre>';


	if(!empty($OrderID) and is_numeric($OrderID)) {
		//$OrderID = $_REQUEST['OrderID'];
	}
	else die(TRANSFER_MISSING);

	define("NL", '<br>');
	require_once ROOT . '/db/v4_OrdersMaster.class.php';
	require_once ROOT . '/db/v4_OrderDetails.class.php';
	require_once ROOT . '/db/v4_OrderExtras.class.php';
	require_once ROOT . '/db/v4_AuthUsers.class.php';

	// classes
	$om = new v4_OrdersMaster();
	$od = new v4_OrderDetails();
	$ox = new v4_OrderExtras();
	$au = new v4_AuthUsers();


	$oKey = $om->getKeysBy('MOrderID', 'ASC', ' WHERE MOrderID = ' .$OrderID);
	if(count($oKey) == 1) {
		$om->getRow($oKey[0]);
		$AuthUserID = $om->getMUserID();

		$dKey = $od->getKeysBy('DetailsID', 'ASC', ' WHERE OrderID = ' .$OrderID);
		if(count($dKey) > 0) {
			$transferCount = count($dKey);
		}
		else die(TRANSFER_NOT_FOUND);

	}

	// Podaci o useru - Taxi site ili partner, agent
	$users = array('2', '4', '5', '6', '12');

	$au->getRow($AuthUserID);
	$level = $au->getAuthLevelID();

	if(in_array($level, $users)) {
		$userCo = $au->getAuthUserCompany();
		$userAddress = $au->getAuthCoAddress();
		$userMail = $au->getAuthUserMail();
		$userTel = $au->getAuthUserTel();
	}
	else {
        // bilo do Pet 09 Vel 2018 14:23:46 
		//$userCo = s('co_name');
		//$userAddress = s('co_address');
		//$userMail = s('co_email');
		//$userTel = s('co_tel');
		
		// stavi JamTransfer
		require_once ROOT .'/db/v4_CoInfo.class.php';
		$co = new v4_CoInfo();
		$co->getRow('1');
	    
		$userCo = $co->getco_name();
		$userAddress = $co->getco_address();
		$userMail = $co->getco_email();
		$userTel = $co->getco_tel();

	}

	$od->getRow($dKey[0]);
	$firstTransferWhere = ' OR OrderDetailsID = ' . $od->getDetailsID();
	$pickupNotes = '<small>['.$OrderID.'-1]<br></small>'.$od->getPickupNotes();
	$detailPriceSum = $od->getDetailPrice();
	?>

	<table cellpadding="0" cellspacing="0" style="font-family:Arial, sans-serif;width:100%;table-layout:fixed">
		<col width="200px">
		<col>
		<tr>
			<td colspan="2">
				<? if ((s('AuthLevelID') != 31) and (s('AuthLevelID') != 32)) { // ne prikazuj vozacu ?>
				<p>
					<h1><? if ( s('AuthLevelID') == 2 ) echo 'Agent: ' ?><?= $userCo ?></h1>
				</p>
				<br>
				<? } ?>
				
				<h2><?= RESERVATION_CODE ?>: <strong><?= $om->getMOrderKey().'-'.$om->getMOrderID() ?></strong></h2>
				<small><?= $om->getMOrderDate().' '. $om->getMOrderTime() ?></small>
				<br>
				<br>
			</td>
		</tr>

		<tr>
			<td colspan="2">
				<hr>
				<h3 style="font-weight:100"><?= YOUR_CONTACT_INFO ?></h3>
				<hr>
			</td>
		</tr>
		<tr>
			<td>
				<?=  NAME ?>:
			</td>
			<td>
				<?= $om->getMPaxFirstName(). ' ' . $om->getMPaxLastName() ?>
			</td>
		</tr>
		<tr>
			<td>
				<?=  EMAIL ?>:
			</td>
			<td>
				<?= $om->getMPaxEmail() ?>
			</td>
		</tr>
		<tr>
			<td>
				<?=  MOBILE_NUMBER ?>:
			</td>
			<td>
				<?= $om->getMPaxTel() ?>
			</td>
		</tr>
		<tr>
			<td>
				<?= PASSENGERS_NO?>:
			</td>
			<td>
				<?= $od->getPaxNo() ?>
			</td>
		</tr>

		<tr>
			<td colspan="2">
				<hr>
				<h3 style="font-weight:100"><?= ABOUT_YOUR_TRANSFER?></h3>
				<hr>
			</td>
		</tr>

<? if ($od->getPickupName() != 'other'){ ?>
        <tr>
            <td><?= FROM ?>:</td>
            <td>
                <strong><?= $od->getPickupName() ?></strong>
            </td>
        </tr>
<? } ?>	
			<td>
				<?= PICKUP_ADDRESS ?>:
			</td>
			<td>
				<?= $od->getPickupAddress() ?>
			</td>
		</tr>
<? if ($od->getDropName() != 'other'){ ?>
		<tr>
			<td>
				<?= TO ?>:
			</td>
			<td>
				<strong><?=  $od->getDropName() ?></strong>
			</td>
		</tr>
<? } ?>			
		<tr>
			<td>
				<?= DROPOFF_ADDRESS ?>:
			</td>
			<td>
				<?=  $od->getDropAddress() ?>
			</td>
		</tr>
		<tr>
			<td>
				<?= PICKUP_DATE ?>:
			</td>
			<td>
				<?= $od->getPickupDate() ?> <small>(Y-M-D)</small>
				<strong><em> <?= TRANSFER_ID ?>: <?= $od->getOrderID().'-'.$od->getTNo() ?></em></strong>
			</td>
		</tr>
		<tr>
			<td>
				<?= PICKUP_TIME ?>:
			</td>
			<td>
				<?= $od->getPickupTime() ?> <small>(H:M 24h)</small>
			</td>
		</tr>
		<? if( $od->getFlightNo() != '') { ?>
		<tr>
			<td>
				<?= FLIGHT_NO ?>:
			</td>
			<td>
				<?= $od->getFlightNo() ?>
			</td>
		</tr>
		<? } ?>

		<? if( $od->getFlightTime() != '') { ?>
		<tr>
			<td>
				<?= FLIGHT_TIME ?>:
			</td>
			<td>
				<?= $od->getFlightTime() ?>
			</td>
		</tr>
		<? } ?>

		<? if ($transferCount == 2)  {

				// podaci za drugi transfer
				$od->getRow($dKey[1]);
				$pickupNotes .= '<br><small>['.$OrderID.'-2]<br></small>'.$od->getPickupNotes();
				$detailPriceSum += $od->getDetailPrice();

			?>
		<tr>
			<td>
				<?= RETURN_TRANSFER ?>:
			</td>
			<td>
				<?= YES ?>
			</td>
		</tr>
		<tr>
			<td>
				<?= FROM ?>:
			</td>
			<td>
				<?= $od->getPickupName() ?>
			</td>
		</tr>
		<tr>
			<td>
				<?= PICKUP_ADDRESS ?>:
			</td>
			<td>
				<?= $od->getPickupAddress() ?>
			</td>
		</tr>
		<tr>
			<td>
				<?= TO ?>:
			</td>
			<td>
				<strong><?=  $od->getDropName() ?></strong>
			</td>
		</tr>
		<tr>
			<td>
				<?= DROPOFF_ADDRESS ?>:
			</td>
			<td>
				<?=  $od->getDropAddress() ?>
			</td>
		</tr>
		<tr>
			<td>
				<?= RETURN_DATE ?>:
			</td>
			<td>
				<?= $od->getPickupDate() ?> <small>(Y-M-D)</small>
				<strong><em> <?= TRANSFER_ID ?>: <?= $od->getOrderID().'-'.$od->getTNo() ?></em></strong>
			</td>
		</tr>
		<tr>
			<td>
				<?= RETURN_TIME ?>:
			</td>
			<td>
				<?= $od->getPickupTime() ?> <small>(H:M 24h)</small>
			</td>
		</tr>

		<? if( $od->getFlightNo() != '') { ?>
		<tr>
			<td>
				<?= FLIGHT_NO ?>:
			</td>
			<td>
				<?= $od->getFlightNo() ?>
			</td>
		</tr>
		<? } ?>

		<? if( $od->getFlightTime() != '') { ?>
		<tr>
			<td>
				<?= FLIGHT_TIME ?>:
			</td>
			<td>
				<?= $od->getFlightTime() ?>
			</td>
		</tr>
		<? } ?>
	<? } ?>


		<tr>
			<td colspan="2">
				<hr>
				<h3 style="font-weight:100"><?= SELECTED_VEHICLE?></h3>
				<hr>
			</td>
		</tr>
		<tr>
			<td>
				<?=  VEHICLE_CAPACITY ?>:
			</td>
			<td>
				<?=  getMaxPax( $od->getVehicleType() )  ?> x <?= $od->getVehiclesNo(); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?=  VEHICLE_TYPE ?>:
			</td>
			<td>
				<?= getVehicleTypeName( $od->getVehicleType() ) ?> x <?= $od->getVehiclesNo(); ?>
			</td>
		</tr>
<?/*
		<tr>
			<td>
				<?=  DRIVER_NAME ?>:
			</td>
			<td>
				<?= $od->getDriverName() ?>
			</td>
		</tr>
*/?>
		<? if($showPrices == true) { ?>
			<tr>
				<td>
					<?= PRICE ?>:
				</td>
				<td>
				<strong><?= Eur2($detailPriceSum,$om->getMOrderCurrency()) . ' ' .
									$om->getMOrderCurrency() ?></strong>
				<? if($od->getDiscount() > 0) echo '(-' . $od->getDiscount() .'%)';?>
				</td>
			</tr>
		<? } ?>
		<tr>
			<td>
				<?= NOTES ?>:
			</td>
			<td><?= $pickupNotes ?>

			</td>
		</tr>
		<?
			$where = ' WHERE OrderDetailsID = ' . $od->getDetailsID() . $firstTransferWhere;
			$oXkey = $ox->getKeysBy('ID', 'ASC', $where);
			if( count($oXkey) > 0 ){

				echo '  <tr>
							<td colspan="2">
								<hr>
								<h3 style="font-weight:100">'. EXTRAS .'</h3>
								<hr>
							</td>
						<tr>';

				foreach($oXkey as $i => $id) {
					$ox->getRow($id);
					echo '<tr><td>' .
								$ox->getServiceName() . ' x ' . $ox->getQty();
					echo '</td> ';

					echo '<td>' .
						Eur2( $ox->getSum(),$om->getMOrderCurrency() ) . ' ' . $om->getMOrderCurrency() .
					'</td></tr>';

				}
			}
		?>

		<? if($showPrices == true) { ?>
			<tr>
				<td>
					<hr>
					<h3><?=  TOTAL ?>:</h3>
					<hr>
				</td>
				<td>
					<hr>
					<h3><?= nf($om->getMOrderPriceEUR()) . ' ' . $om->getMOrderCurrency() ?></h3>
					<hr>
				</td>
			</tr>
		<? } ?>

		<? if($showPrices == true) { ?>
			<? if($om->getMPayNow() > 0) {?>

			<tr>
				<td>
					<h3><?=  PAY_NOW ?>:</h3>
					<hr>
				</td>
				<td>
					<h3><?= Eur2( $om->getMPayNow(),$om->getMOrderCurrency() )  . ' ' .
									$om->getMOrderCurrency() ?></h3>
					<hr>
				</td>
			</tr>
			<?}?>
		<?}?>

		<? if($showPrices == true) { ?>
			<tr>
				<td>
					<h3><?=  PAY_LATER ?>:</h3>
					<hr>

				</td>
				<td>
					<h3><?= Eur2($om->getMPayLater(),$om->getMOrderCurrency() ) . ' ' .
									$om->getMOrderCurrency() ?></h3>
					<hr>

				</td>
			</tr>
		<? } ?>
		<tr>
			<td colspan="2">
				<hr>
				<p style="font-family:Arial, sans-serif;color:#444">
						<?= SERVICES_DESC1 ?> |
						<?= SERVICES_DESC2 ?> |
						<?= SERVICES_DESC3 ?> |
						<?= SERVICES_DESC4 ?> |
						<?= SERVICES_DESC5 ?> |
						<?= SERVICES_DESC6 ?> |
						<?= SERVICES_DESC7 ?> |
						<?= SERVICES_DESC8 ?> |
						<?= SERVICES_DESC9 ?>
						<br><br>
						<?= ACCEPTED_TERMS ?>
						<br>
					</ul>
				</p>
				<br>
			</td>
		</tr>
	</table>


	<?
}// end printVoucher

// poziva:  t/para_thankyou.php
function PrintTransferMaterial($OrderID) {
	//echo '<pre>'; print_r($_REQUEST); echo '</pre>';


	if(!empty($OrderID) and is_numeric($OrderID)) {
		//$OrderID = $_REQUEST['OrderID'];
	}
	else die(TRANSFER_MISSING);

	define("NL", '<br>');
	require_once ROOT . '/db/v4_OrdersMaster.class.php';
	require_once ROOT . '/db/v4_OrderDetails.class.php';
	require_once ROOT . '/db/v4_OrderExtras.class.php';
	require_once ROOT . '/db/v4_AuthUsers.class.php';

	// classes
	$om = new v4_OrdersMaster();
	$od = new v4_OrderDetails();
	$ox = new v4_OrderExtras();
	$au = new v4_AuthUsers();


	$oKey = $om->getKeysBy('MOrderID', 'ASC', ' WHERE MOrderID = ' .$OrderID);
	if(count($oKey) == 1) {
		$om->getRow($oKey[0]);
		$AuthUserID = $om->getMUserID();

		$dKey = $od->getKeysBy('DetailsID', 'ASC', ' WHERE OrderID = ' .$OrderID);
		if(count($dKey) > 0) {
			$transferCount = count($dKey);
		}
		else die(TRANSFER_NOT_FOUND);

	}

	// Podaci o useru - Taxi site ili partner, agent
	$users = array('2', '4', '5', '6', '12');
	$au->getRow($AuthUserID);
	$level = $au->getAuthLevelID();
	if(in_array($level, $users)) {
		$userCo = $au->getAuthUserCompany();
		$userAddress = $au->getAuthCoAddress();
		$userMail = $au->getAuthUserMail();
		$userTel = $au->getAuthUserTel();
	}
	else {
		$userCo = s('co_name');
		$userAddress = s('co_address');
		$userMail = s('co_email');
		$userTel = s('co_tel');
	}

	$od->getRow($dKey[0]);
	$firstTransferWhere = ' OR OrderDetailsID = ' . $od->getDetailsID();
	$pickupNotes = '<small>['.$OrderID.'-1]<br></small>'.$od->getPickupNotes();
	$detailPriceSum = $od->getDetailPrice();
?>

	<div id="thankyou" class="white container row">
		<div class="row white">

			<div class="col s12  pad1em" style="min-height:800px">

				<p>
					<? if ((s('AuthLevelID') != 31) and (s('AuthLevelID') != 32)) { ?>
						<span class="l"><strong><?= $userCo ?></strong></span><br>
					<? } ?>
					<!--<?//=  $userAddress ?><br>-->
					<?= $userMail ?><br> <?= $userTel ?><br>
				</p>

				<br>
				<h4><?= RESERVATION_CODE ?>: <strong><?= $om->getMOrderKey().'-'.$om->getMOrderID() ?></strong></h4>
				<small><?= $om->getMOrderDate().' '. $om->getMOrderTime() ?></small>
				<br>
				<br>

				<div class="col s12"><hr></div>
				<div class="col s12 grey-text"><h4><?= YOUR_CONTACT_INFO ?></h4></div>
				<div class="col s12"><hr></div>

				<div class="col s12 m4 l4 grey-text"><?=  NAME ?>:</div>
				<div class="col s12 m8 l8">
					<?= $om->getMPaxFirstName(). ' ' . $om->getMPaxLastName() ?>
				</div>
				<br>

				<div class="col s12 m4 l4 grey-text"><?=  EMAIL ?>:</div>
				<div class="col s12 m8 l8">
					<?= maskEmail($om->getMPaxEmail()) ?>
				</div>
				<br>

				<div class="col s12 m4 l4 grey-text"><?=  MOBILE_NUMBER ?>:</div>
				<div class="col s12 m8 l8">
					<?= $om->getMPaxTel() ?>
				</div>
				<br>

				<div class="col s12 m4 l4 grey-text"><?= PASSENGERS_NO?>:</div>
				<div class=" col s12 m8 l8">
					<?= $od->getPaxNo() ?>
				</div>
				<br>

				<div class="col s12"><hr></div>
				<div class="col s12 grey-text"><h4><?=  ABOUT_YOUR_TRANSFER ?></h4></div>
				<hr>

				<div class="col s12 m4 l4 grey-text"><?= FROM ?>:</div>
				<div class=" col s12 m8 l8">
					<strong><?= getPlaceName( $od->getPickupID() ) ?></strong>
				</div>
				<br>

				<div class="col s12 m4 l4 grey-text"><?= PICKUP_ADDRESS ?>:</div>
				<div class=" col s12 m8 l8">
					<?= $od->getPickupAddress() ?>
				</div>
				<br>

				<div class="col s12 m4 l4 grey-text"><?= TO ?>:</div>
				<div class=" col s12 m8 l8">
					<strong><?= getPlaceName( $od->getDropID() ) ?></strong>
				</div>
				<br>

				<div class="col s12 m4 l4 grey-text"><?= DROPOFF_ADDRESS ?>:</div>
				<div class=" col s12 m8 l8">
					<?=  $od->getDropAddress() ?>
				</div>
				<br>

				<div class="col s12 m4 l4 grey-text"><?= PICKUP_DATE ?>:</div>
				<div class=" col s12 m8 l8">
					<?= $od->getPickupDate() ?> <small>(Y-M-D)</small>
					<strong><em> <?= TRANSFER_ID ?>: <?= $od->getOrderID().'-'.$od->getTNo() ?></em></strong>
				</div>
				<br>

				<div class="col s12 m4 l4 grey-text"><?= PICKUP_TIME ?>:</div>
				<div class=" col s12 m8 l8">
					<?= $od->getPickupTime() ?> <small>(H:M 24h)</small>
				</div>
				<br>

				<? if( $od->getFlightNo() != '') { ?>
				<div class="col s12 m4 l4 grey-text"><?= FLIGHT_NO ?>:</div>
				<div class=" col s12 m8 l8">
					<?= $od->getFlightNo() ?>
				</div>
				<br>
				<? } ?>

				<? if( $od->getFlightTime() != '') { ?>
				<div class="col s12 m4 l4 grey-text"><?= FLIGHT_TIME ?>:</div>
				<div class=" col s12 m8 l8">
					<?= $od->getFlightTime() ?>
				</div>
				<br>
				<? } ?>

			<? if ($transferCount == 2)  {

					// podaci za drugi transfer
					$od->getRow($dKey[1]);
					$pickupNotes .= '<br><small>['.$OrderID.'-2]<br></small>'.$od->getPickupNotes();
					$detailPriceSum += $od->getDetailPrice();

				?>
				<div class="col s12"><hr></div>

				<div class="col s12 m4 l4 grey-text"><?= RETURN_TRANSFER ?>:</div>
				<div class="col s12 m8 l8">
						<?= YES ?>
				</div>
				<br>

				<div class="col s12 m4 l4 grey-text"><?= FROM ?>:</div>
				<div class=" col s12 m8 l8">
					<strong><?= getPlaceName( $od->getPickupID() ) ?></strong>
				</div>
				<br>

				<div class="col s12 m4 l4 grey-text"><?= PICKUP_ADDRESS ?>:</div>
				<div class=" col s12 m8 l8">
					<?= $od->getPickupAddress() ?>
				</div>
				<br>

				<div class="col s12 m4 l4 grey-text"><?= TO ?>:</div>
				<div class=" col s12 m8 l8">
					<strong><?= getPlaceName( $od->getDropID() ) ?></strong>
				</div>
				<br>

				<div class="col s12 m4 l4 grey-text"><?= DROPOFF_ADDRESS ?>:</div>
				<div class=" col s12 m8 l8">
					<?=  $od->getDropAddress() ?>
				</div>
				<br>

				<div class="col s12 m4 l4 grey-text"><?= RETURN_DATE ?>:</div>
				<div class=" col s12 m8 l8">
					<?= $od->getPickupDate() ?> <small>(Y-M-D)</small>
					<strong><em> <?= TRANSFER_ID ?>: <?= $od->getOrderID().'-'.$od->getTNo() ?></em></strong>
				</div>
				<br>

				<div class="col s12 m4 l4 grey-text"><?= RETURN_TIME ?>:</div>
				<div class=" col s12 m8 l8">
					<?= $od->getPickupTime() ?> <small>(H:M 24h)</small>
				</div>
				<br>

				<? if( $od->getFlightNo() != '') { ?>
				<div class="col s12 m4 l4 grey-text"><?= FLIGHT_NO ?>:</div>
				<div class=" col s12 m8 l8">
					<?= $od->getFlightNo() ?>
				</div>
				<br>
				<? } ?>

				<? if( $od->getFlightTime() != '') { ?>
				<div class="col s12 m4 l4 grey-text"><?= FLIGHT_TIME ?>:</div>
				<div class=" col s12 m8 l8">
					<?= $od->getFlightTime() ?>
				</div>
				<? } ?>
				<? //$pickupNotes .= '<br>' . $od->getPickupNotes(); NEPOTREBNO - DUPLIRA NOTES ?>

			<? } ?>





				<div class="col s12"><hr></div>

				<div class="col s12 grey-text"><h4><?= SELECTED_VEHICLE?></h4></div>
				<div class="col s12"><hr></div>

				<div class="col s12 m4 l4 grey-text"><?=  VEHICLE_CAPACITY ?>:</div>
				<div class="col s12 m8 l8">
					<?= getMaxPax( $od->getVehicleType() ) ?> x <?= $od->getVehiclesNo(); ?>
				</div>
				<br>

				<div class="col s12 m4 l4 grey-text"><?=  VEHICLE_TYPE ?>:</div>
				<div class="col s12 m8 l8">
					<?= getVehicleTypeName( $od->getVehicleType() ) ?> x <?= $od->getVehiclesNo(); ?>
				</div>
				<br>
<?/*
				<div class="col s12 m4 l4 grey-text"><?=  DRIVER_NAME ?>:</div>
				<div class="col s12 m8 l8">
					<?= $od->getDriverName() ?>
				</div>
				<br>
*/?>
				<div class="col s12 m4 l4 grey-text"><?= PRICE ?>:</div>
				<div class="col s12 m8 l8">
					<strong><?= Eur2($detailPriceSum,$om->getMOrderCurrency()) . ' ' .
								$om->getMOrderCurrency() ?></strong>
					<? if($od->getDiscount() > 0) echo '(-' . $od->getDiscount() .'%)';?>
				</div>
				<br>

				<div class="col s12 m4 l4 grey-text" style="vertical-align:top"><?= NOTES ?>:</div>
				<div class=" col s12 m8 l8">
					<?= $pickupNotes ?>
				</div>
				<br>

				<div class="col s12"><hr></div>

				<?

					$where = ' WHERE OrderDetailsID = ' . $od->getDetailsID() . $firstTransferWhere;
					$oXkey = $ox->getKeysBy('ID', 'ASC', $where);
					if( count($oXkey) > 0 ){

						echo '<div class="col s12 grey-text"><h4>'. EXTRAS .'</h4></div>
								<div class="col s12"><hr></div>';

						foreach($oXkey as $i => $id) {
							$ox->getRow($id);
							echo '<div class="col s4">' .
										$ox->getServiceName() . ' x ' .
										$ox->getQty();
							echo '</div> ';

							echo '<div class="col s12 m8 l8">' .
								Eur2( $ox->getSum(),$om->getMOrderCurrency() ) .
								' ' . $om->getMOrderCurrency() .
							'</div>';


						}

					}



				?>


				<div class="col s4 "><h5><?=  TOTAL ?>:</h5></div>
				<div class="col s12 m8 l8">
					<h5><?= nf($om->getMOrderPriceEUR()) . ' ' .
								$om->getMOrderCurrency() ?></h5>
				</div>

				<div class="col s12"><hr></div>

				<? if($om->getMPayNow() > 0) {?>
				<div class="col s12 light-green xpad1em white-text z-depth-2">
					<div class="col s4 "><h5><?=  PAY_NOW ?>:</h5></div>
					<div class="col s12 m8 l8">
						<h5><?= Eur2( $om->getMPayNow(),$om->getMOrderCurrency() )  . ' ' .
									$om->getMOrderCurrency() ?></h5>
					</div>
				</div>
				<br>
				<?}?>

				<div class="col s12 red lighten-2 xpad1em white-text z-depth-2">
					<div class="col s4 "><h5><?=  PAY_LATER ?>:</h5></div>
					<div class="col s12 m8 l8">
						<h5><?= Eur2($om->getMPayLater(),$om->getMOrderCurrency() ) . ' ' .
									$om->getMOrderCurrency() ?></h5>
					</div>
				</div>
				<br>

				<br>
				<div class="col s12 center">
					<p style="font-size:.7em;text-transform:uppercase;text-align:left;">
							<?= SERVICES_DESC1 ?> |
							<?= SERVICES_DESC2 ?> |
							<?= SERVICES_DESC3 ?> |
							<?= SERVICES_DESC4 ?> |
							<?= SERVICES_DESC5 ?> |
							<?= SERVICES_DESC6 ?> |
							<?= SERVICES_DESC7 ?> |
							<?= SERVICES_DESC8 ?> |
							<?= SERVICES_DESC9 ?>
							<br><br>
							<?= ACCEPTED_TERMS ?>
							<br>

						</ul>
					</p>
					<br>

				</div>

			</div>
		</div>
	</div>
<? } // end function




/*
**
** GLAVNA FUNKCIJA ZA ISPIS POTVRDE / CONFIRMATION / VOUCHER
** poziva:  widget/thankyou.php
*/

function PrintTransfer($OrderID) {
	//echo '<pre>'; print_r($_REQUEST); echo '</pre>';


	if(!empty($OrderID) and is_numeric($OrderID)) {
		//$OrderID = $_REQUEST['OrderID'];
	}
	else die(TRANSFER_MISSING);

	define("NL", '<br>');
	require_once ROOT . '/db/v4_OrdersMaster.class.php';
	require_once ROOT . '/db/v4_OrderDetails.class.php';
	require_once ROOT . '/db/v4_OrderExtras.class.php';
	require_once ROOT . '/db/v4_AuthUsers.class.php';
	require ROOT . '/LoadLanguage.php';

	// classes
	$om = new v4_OrdersMaster();
	$od = new v4_OrderDetails();
	$ox = new v4_OrderExtras();
	$au = new v4_AuthUsers();


	$oKey = $om->getKeysBy('MOrderID', 'ASC', ' WHERE MOrderID = ' .$OrderID);
	if(count($oKey) == 1) {
		$om->getRow($oKey[0]);


		$dKey = $od->getKeysBy('DetailsID', 'ASC', ' WHERE OrderID = ' .$OrderID);
		if(count($dKey) > 0) {
			$transferCount = count($dKey);
		}
		else die(TRANSFER_NOT_FOUND);

	}



	$od->getRow($dKey[0]);
	$firstTransferWhere = ' OR OrderDetailsID = ' . $od->getDetailsID();
	$pickupNotes = '<small>['.$OrderID.'-1]<br></small>'.$od->getPickupNotes();
	$detailPriceSum = $od->getDetailPrice();

	// Podaci o useru - Taxi site ili partner, agent
	$AuthUserID = $od->getUserID();
	if($AuthUserID < 1) $AuthUserID = '53';
	$au->getRow($AuthUserID);

?>

	<div id="thankyou" class="white grid">
		<div class="grid white">

			<div class="col-1-1 pad1em" style="min-height:800px">
				<? if ((s('AuthLevelID') != 31) and (s('AuthLevelID') != 32)) { ?>
					<p>
						<span class="l"><strong><?= $au->getAuthUserCompany() ?></strong></span>	<br>
						<?= $au->getAuthCoAddress() ?><br>
						<?= $au->getAuthUserMail() ?> <?= $au->getAuthUserTel() ?><br>
					</p>
				<? } ?>
				<h3><?= RESERVATION_CODE ?>: <strong><?= $om->getMOrderKey().'-'.$om->getMOrderID() ?></strong></h3>
				<small><?= $om->getMOrderDate().' '. $om->getMOrderTime() ?></small>
				<br>
				<br>

				<div class="w25 aaa"><?= FROM ?>:</div>
				<div class=" w75">
					<strong><?=  $od->getPickupName() ?></strong>
				</div>
				<br>

				<div class="w25 aaa"><?= PICKUP_ADDRESS ?>:</div>
				<div class=" w75">
					<?= $od->getPickupAddress() ?>
				</div>
				<br>

				<div class="w25 aaa"><?= TO ?>:</div>
				<div class=" w75">
					<strong><?= $od->getDropName() ?></strong>
				</div>
				<br>

				<div class="w25 aaa"><?= DROPOFF_ADDRESS ?>:</div>
				<div class=" w75">
					<?=  $od->getDropAddress() ?>
				</div>
				<br>

				<div class="w25 aaa"><?= PICKUP_DATE ?>:</div>
				<div class=" w75">
					<?= $od->getPickupDate() ?> <small>(Y-M-D)</small>
					<strong><em> <?= TRANSFER_ID ?>: <?= $od->getOrderID().'-'.$od->getTNo() ?></em></strong>
				</div>
				<br>

				<div class="w25 aaa"><?= PICKUP_TIME ?>:</div>
				<div class=" w75">
					<?= $od->getPickupTime() ?> <small>(H:M 24h)</small>
				</div>
				<br>

				<? if( $od->getFlightNo() != '') { ?>
				<div class="w25 aaa"><?= FLIGHT_NO ?>:</div>
				<div class=" w75">
					<?= $od->getFlightNo() ?>
				</div>
				<br>
				<? } ?>

				<? if( $od->getFlightTime() != '') { ?>
				<div class="w25 aaa"><?= FLIGHT_TIME ?>:</div>
				<div class=" w75">
					<?= $od->getFlightTime() ?>
				</div>
				<? } ?>


		<?
			$where = ' WHERE OrderDetailsID = ' . $od->getDetailsID();
			$oXkey = $ox->getKeysBy('ID', 'ASC', $where);
			if( count($oXkey) > 0 ){

				echo '  <tr>
							<td colspan="2">
								<p class="line eee"></p>
								<h3 style="font-weight:100" class="aaa">'. $EXTRAS .'</h3>
								<p class="line eee"></p>
							</td>
						<tr>';

				foreach($oXkey as $i => $id) {
					$ox->getRow($id);
					echo '<tr><td>' .
								$ox->getServiceName() . ' x ' . $ox->getQty();
					echo '</td> ';

					echo '<td>(' .
						Eur2( $ox->getSum(),$om->getMOrderCurrency() ) . ' ' . $om->getMOrderCurrency() .
					')</td></tr>';

				}
			}
		?>



			<? if ($transferCount == 2)  {

					// podaci za drugi transfer
					$od->getRow($dKey[1]);
					$pickupNotes .= '<br><small>['.$OrderID.'-2]<br></small>'.$od->getPickupNotes();
					$detailPriceSum += $od->getDetailPrice();

				?>
				<p class="line eee"></p>

				<div class="w25 aaa"><?= RETURN_TRANSFER ?>:</div>
				<div class="w75">
						<?= YES ?>
				</div>
				<br>

				<div class="w25 aaa"><?= FROM ?>:</div>
				<div class=" w75">
					<strong><?= $od->getPickupName() ?></strong>
				</div>
				<br>

				<div class="w25 aaa"><?= PICKUP_ADDRESS ?>:</div>
				<div class=" w75">
					<?= $od->getPickupAddress() ?>
				</div>
				<br>

				<div class="w25 aaa"><?= TO ?>:</div>
				<div class=" w75">
					<strong><?= $od->getDropName() ?></strong>
				</div>
				<br>

				<div class="w25 aaa"><?= DROPOFF_ADDRESS ?>:</div>
				<div class=" w75">
					<?=  $od->getDropAddress() ?>
				</div>
				<br>

				<div class="w25 aaa"><?= RETURN_DATE ?>:</div>
				<div class=" w75">
					<?= $od->getPickupDate() ?> <small>(Y-M-D)</small>
					<strong><em> <?= TRANSFER_ID ?>: <?= $od->getOrderID().'-'.$od->getTNo() ?></em></strong>
				</div>
				<br>

				<div class="w25 aaa"><?= RETURN_TIME ?>:</div>
				<div class=" w75">
					<?= $od->getPickupTime() ?> <small>(H:M 24h)</small>
				</div>
				<br>

				<? if( $od->getFlightNo() != '') { ?>
				<div class="w25 aaa"><?= FLIGHT_NO ?>:</div>
				<div class=" w75">
					<?= $od->getFlightNo() ?>
				</div>
				<br>
				<? } ?>

				<? if( $od->getFlightTime() != '') { ?>
				<div class="w25 aaa"><?= FLIGHT_TIME ?>:</div>
				<div class=" w75">
					<?= $od->getFlightTime() ?>
				</div>
				<? } ?>
				<? //$pickupNotes .= '<br>' . $od->getPickupNotes(); NEPOTREBNO - DUPLIRA NOTES ?>

			<? } ?>


		<?
			$where = ' WHERE OrderDetailsID = ' . $od->getDetailsID();
			$oXkey = $ox->getKeysBy('ID', 'ASC', $where);
			if( count($oXkey) > 0 ){

				echo '  <tr>
							<td colspan="2">
								<p class="line eee"></p>
								<h3 style="font-weight:100" class="aaa">'. $EXTRAS .'</h3>
								<p class="line eee"></p>
							</td>
						<tr>';

				foreach($oXkey as $i => $id) {
					$ox->getRow($id);
					echo '<tr><td>' .
								$ox->getServiceName() . ' x ' . $ox->getQty();
					echo '</td> ';

					echo '<td>(' .
						Eur2( $ox->getSum(),$om->getMOrderCurrency() ) . ' ' . $om->getMOrderCurrency() .
					')</td></tr>';

				}
			}
		?>
				<p class="line eee"></p>

				<h3 class="aaa"><?= YOUR_CONTACT_INFO ?></h3><p class="line eee"></p>
				<div class="w25 aaa"><?=  NAME ?>:</div>
				<div class="w75">
					<?= $om->getMPaxFirstName(). ' ' . $om->getMPaxLastName() ?>
				</div>
				<br>

				<div class="w25 aaa"><?=  EMAIL ?>:</div>
				<div class="w75">
					<?= maskEmail($om->getMPaxEmail()) ?>
				</div>
				<br>

				<div class="w25 aaa"><?=  MOBILE_NUMBER ?>:</div>
				<div class="w75">
					<?= $om->getMPaxTel() ?>
				</div>
				<br>

				<div class="w25 aaa"><?= PASSENGERS_NO?>:</div>
				<div class=" w75">
					<?= $od->getPaxNo() ?>
				</div>
				<br>

				<p class="line eee"></p>

				<h3 class="aaa"><?= SELECTED_VEHICLE?></h3><p class="line eee"></p>

				<div class="w25 aaa"><?=  VEHICLE_CAPACITY ?>:</div>
				<div class="w75">
					<?=  getMaxPax( $od->getVehicleType() )  ?> x <?= $od->getVehiclesNo(); ?>
				</div>
				<br>

				<div class="w25 aaa"><?=  VEHICLE_TYPE ?>:</div>
				<div class="w75">
					<?= getVehicleTypeName( $od->getVehicleType() ) ?> x <?= $od->getVehiclesNo(); ?>
				</div>
				<br>
<?/*
				<div class="w25 aaa"><?=  DRIVER_NAME ?>:</div>
				<div class="w75">
					<?= $od->getDriverName() ?>
				</div>
				<br>
*/?>
				<div class="w25 aaa"><?= PRICE ?>:</div>
				<div class="w75">
					<strong>
						<?= Eur2($detailPriceSum,$om->getMOrderCurrency()) . ' ' .
								$om->getMOrderCurrency() ?>
					</strong>
					<? if($od->getDiscount() > 0) echo '(-' . $od->getDiscount() .'%)';?>
				</div>
				<br>
				<p class="line eee"></p>
				<div class="w25 aaa" style="vertical-align:top"><?= NOTES ?>:</div>
				<div class=" w75">
					<?= $pickupNotes ?>
				</div>
				<br>

				<p class="line eee"></p>

				<?/*
					$where = ' WHERE OrderDetailsID = ' . $od->getDetailsID() . $firstTransferWhere;
					$oXkey = $ox->getKeysBy('ID', 'ASC', $where);
					if( count($oXkey) > 0 ){

						echo '<h3 class="aaa">'. EXTRAS .'</h3><p class="line eee"></p>';

						foreach($oXkey as $i => $id) {
							$ox->getRow($id);
							echo '<div class="w25">' .
										$ox->getServiceName() . ' x ' .
										$ox->getQty();
							echo '</div> ';

							echo '<div class="w75">' .
								Eur2( $ox->getSum(),$om->getMOrderCurrency() ) .
								' ' . $om->getMOrderCurrency() .
							'</div>';


						}

						echo '<p class="line eee"></p>';
					}

					*/

				?>


				<div class="w25 bold">
					<?=  TOTAL ?>:
				</div>
				<div class="w75 bold">
					<?= nf($om->getMOrderPriceEUR()) . ' ' . $om->getMOrderCurrency() ?>
				</div>

				<p class="line eee"></p>

				<? if($om->getMPayNow() > 0) {?>
				<div class="green pad1em bold">
					<div class="w25">
						<?=  PAY_NOW ?>:
					</div>
					<div class="w75">
						<?= Eur2( $om->getMPayNow(), $om->getMOrderCurrency() )  . ' ' . $om->getMOrderCurrency() ?>
					</div>
				</div>
				<br>
				<?}?>

				<div class="red lighten-2 pad1em bold">
					<div class="w25">
						<?=  PAY_LATER ?>:
					</div>
					<div class="w75">
						<?= Eur2( $om->getMPayLater(), $om->getMOrderCurrency() ) . ' ' . $om->getMOrderCurrency() ?>
					</div>
				</div>
				<br>

				<br>
				<div class="w100 center">
					<p style="font-size:.7em;text-transform:uppercase;text-align:left;">
							<?= SERVICES_DESC1 ?> |
							<?= SERVICES_DESC2 ?> |
							<?= SERVICES_DESC3 ?> |
							<?= SERVICES_DESC4 ?> |
							<?= SERVICES_DESC5 ?> |
							<?= SERVICES_DESC6 ?> |
							<?= SERVICES_DESC7 ?> |
							<?= SERVICES_DESC8 ?> |
							<?= SERVICES_DESC9 ?>
							<br><br>
							<?= ACCEPTED_TERMS ?>
							<br>

						</ul>
					</p>
					<br>

				</div>

			</div>
		</div>
	</div>
<? } // end function


/*
**
** GLAVNA FUNKCIJA ZA ISPIS POTVRDE / CONFIRMATION / VOUCHER
** TABELARNI OBLIK
** poziva:  confirmOrder.php
*/

function PrintTransferTable($OrderID) {
	//echo '<pre>'; print_r($_REQUEST); echo '</pre>';


	if(!empty($OrderID) and is_numeric($OrderID)) {
		//$OrderID = $_REQUEST['OrderID'];
	}
	else die(TRANSFER_MISSING);

	define("NL", '<br>');
	require_once ROOT . '/db/v4_OrdersMaster.class.php';
	require_once ROOT . '/db/v4_OrderDetails.class.php';
	require_once ROOT . '/db/v4_OrderExtras.class.php';
	require_once ROOT . '/db/v4_AuthUsers.class.php';

	// classes
	$om = new v4_OrdersMaster();
	$od = new v4_OrderDetails();
	$ox = new v4_OrderExtras();
	$au = new v4_AuthUsers();


	$oKey = $om->getKeysBy('MOrderID', 'ASC', ' WHERE MOrderID = ' .$OrderID);
	if(count($oKey) == 1) {
		$om->getRow($oKey[0]);
		$AuthUserID = $om->getMUserID();

		$dKey = $od->getKeysBy('DetailsID', 'ASC', ' WHERE OrderID = ' .$OrderID);
		if(count($dKey) > 0) {
			$transferCount = count($dKey);
		}
		else die(TRANSFER_NOT_FOUND);

	}

	// Podaci o useru - Taxi site ili partner, agent
	$au->getRow($AuthUserID);

	$od->getRow($dKey[0]);
	$firstTransferWhere = ' OR OrderDetailsID = ' . $od->getDetailsID();
	$pickupNotes = '<small>['.$OrderID.'-1]<br></small>'.$od->getPickupNotes();
?>

	<table cellpadding="3" cellspacing="0" width="100%">
		<tr>
			<td colspan="2">
				<? if ((s('AuthLevelID') != 31) and (s('AuthLevelID') != 32)) { ?>
					<p>
						<h1><?= $au->getAuthUserCompany() ?></h1>
						<?= $au->getAuthCoAddress() ?><br>
						<?= $au->getAuthUserMail() ?> <?= $au->getAuthUserTel() ?><br>
					</p>
				<? } ?>
				<h3><?= RESERVATION_CODE ?>: <strong><?= $om->getMOrderKey().'-'.$om->getMOrderID() ?></strong></h3>
				<small><?= $om->getMOrderDate().' '. $om->getMOrderTime() ?></small>
				<br>
			</td>
			</tr>
			<tr><td colspan="2"><hr></td></tr>
			<tr>
				<td class="w25 aaa"><?= FROM ?>:</td>
				<td class=" w75">
					<strong><?= getPlaceName( $od->getPickupID() ) ?></strong>
				</td>
			</tr>
			<tr>
				<td class="w25 aaa"><?= PICKUP_ADDRESS ?>:</td>
				<td class=" w75">
					<?= $od->getPickupAddress() ?>
				</td>
			</tr>
			<tr>
				<td class="w25 aaa"><?= TO ?>:</td>
				<td class=" w75">
					<strong><?= getPlaceName( $od->getDropID() ) ?></strong>
				</td>
			</tr>
			<tr>
				<td class="w25 aaa"><?= DROPOFF_ADDRESS ?>:</td>
				<td class=" w75">
					<?=  $od->getDropAddress() ?>
				</td>
			</tr>
			<tr>
				<td class="w25 aaa"><?= PICKUP_DATE ?>:</td>
				<td class=" w75">
					<?= $od->getPickupDate() ?> <small>(Y-M-D)</small>
					<strong><em> <?= TRANSFER_ID ?>: <?= $od->getOrderID().'-'.$od->getTNo() ?></em></strong>
				</td>
			</tr>
			<tr>
				<td class="w25 aaa"><?= PICKUP_TIME ?>:</td>
				<td class=" w75">
					<?= $od->getPickupTime() ?> <small>(H:M 24h)</small>
				</td>
			</tr>

			<? if( $od->getFlightNo() != '') { ?>
			<tr>
				<td class="w25 aaa"><?= FLIGHT_NO ?>:</td>
				<td class=" w75">
					<?= $od->getFlightNo() ?>
				</td>
			</tr>
			<? } ?>

			<? if( $od->getFlightTime() != '') { ?>
			<tr>
				<td class="w25 aaa"><?= FLIGHT_TIME ?>:</td>
				<td class=" w75">
					<?= $od->getFlightTime() ?>
				</td>
			</tr>
			<? } ?>

			<? if ($transferCount == 2)  {

					// podaci za drugi transfer
					$od->getRow($dKey[1]);
					$pickupNotes .= '<br><small>['.$OrderID.'-2]<br></small>'.$od->getPickupNotes();

				?>
				<tr><td colspan="2"><hr></td></tr>
				<tr>
					<td class="w25 aaa"><?= RETURN_TRANSFER ?>:</td>
					<td class="w75">
							<?= YES ?>
					</td>
				</tr>
				<tr>
					<td class="w25 aaa"><?= FROM ?>:</td>
					<td class=" w75">
						<strong><?= getPlaceName( $od->getPickupID() ) ?></strong>
					</td>
				</tr>
				<tr>
					<td class="w25 aaa"><?= TO ?>:</td>
					<td class=" w75">
						<strong><?= getPlaceName( $od->getDropID() ) ?></strong>
					</td>
				</tr>
				<tr>
					<td class="w25 aaa"><?= RETURN_DATE ?>:</td>
					<td class=" w75">
						<?= $od->getPickupDate() ?> <small>(Y-M-D)</small>
						<strong><em> <?= TRANSFER_ID ?>: <?= $od->getOrderID().'-'.$od->getTNo() ?></em></strong>
					</td>
				</tr>
				<tr>
					<td class="w25 aaa"><?= RETURN_TIME ?>:</td>
					<td class=" w75">
						<?= $od->getPickupTime() ?> <small>(H:M 24h)</small>
					</td>
				</tr>
				<? if( $od->getFlightNo() != '') { ?>
				<tr>
					<td class="w25 aaa"><?= FLIGHT_NO ?>:</td>
					<td class=" w75">
						<?= $od->getFlightNo() ?>
					</td>
				</tr>
				<? } ?>

				<? if( $od->getFlightTime() != '') { ?>
				<tr>
					<td class="w25 aaa"><?= FLIGHT_TIME ?>:</td>
					<td class=" w75">
						<?= $od->getFlightTime() ?>
					</td>
				</tr>
				<? } ?>
			<? } /* end drugi transfer */ ?>

			<tr>
				<td colspan="2">
					<hr>
					<h3 class="aaa"><?= YOUR_CONTACT_INFO ?></h3>
					<hr>
				</td>
			</tr>
			<tr>
				<td class="w25 aaa"><?=  NAME ?>:</td>
				<td class="w75">
					<?= $om->getMPaxFirstName(). ' ' . $om->getMPaxLastName() ?>
				</td>
			</tr>
			<tr>
				<td class="w25 aaa"><?=  EMAIL ?>:</td>
				<td class="w75">
					<?= maskEmail($om->getMPaxEmail()) ?>
				</td>
			</tr>
			<tr>
				<td class="w25 aaa"><?=  MOBILE_NUMBER ?>:</td>
				<td class="w75">
					<?= $om->getMPaxTel() ?>
				</td>
			</tr>
			<tr>
				<td class="w25 aaa"><?= PASSENGERS_NO?>:</td>
				<td class=" w75">
					<?= $od->getPaxNo() ?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
				<hr>
				<h3 class="aaa"><?= SELECTED_VEHICLE?></h3>
				<hr>
				</td>
			</tr>
			<tr>
				<td class="w25 aaa"><?=  VEHICLE_CAPACITY ?>:</td>
				<td class="w75">
					<?=  getMaxPax( $od->getVehicleType() )  ?> x <?= $od->getVehiclesNo(); ?>
				</td>
			</tr>
			<tr>
				<td class="w25 aaa"><?=  VEHICLE_TYPE ?>:</td>
				<td class="w75">
					<?= getVehicleTypeName( $od->getVehicleType() ) ?> x <?= $od->getVehiclesNo(); ?>
				</td>
			</tr>
<?/*
			<tr>
				<td class="w25 aaa"><?=  DRIVER_NAME ?>:</td>
				<td class="w75">
					<?= $od->getDriverName() ?>
				</td>
			</tr>
*/?>
			<tr>
				<td class="w25 aaa"><?= PRICE ?>:</td>
				<td class="w75">
					<strong><?= Eur2($om->getMTransferPrice(),$om->getMOrderCurrency()) . ' ' .
								$om->getMOrderCurrency() ?></strong>
					<? if($od->getDiscount() > 0) echo '(-' . $od->getDiscount() .'%)';?>
				</td>
			</tr>
			<tr>
				<td class="w25 aaa" style="vertical-align:top"><?= NOTES ?>:</td>
				<td class=" w75">
					<?= $pickupNotes ?>
				</td>
			</tr>

				<?
					$where = ' WHERE OrderDetailsID = ' . $od->getDetailsID() . $firstTransferWhere;
					$oXkey = $ox->getKeysBy('ID', 'ASC', $where);
					if( count($oXkey) > 0 ){

						echo	'<tr>
									<td colspan="2">
										<hr>
										<h3 class="aaa">'. EXTRAS .'</h3>
										<hr>
									</td>
								</tr>';

						foreach($oXkey as $i => $id) {
							$ox->getRow($id);
							echo '<tr><td class="w25">' .
										$ox->getServiceName() . ' x ' .
										$ox->getQty();
							echo '</td> ';

							echo '<td class="w75">' .
								Eur2( $ox->getSum(),$om->getMOrderCurrency() ) .
								' ' . $om->getMOrderCurrency() .
							'</td></tr>';


						}

						echo '<tr><td colspan="2"><hr></td></tr>';
					}



				?>
			</tr>
			<tr>
				<td class="w25 "><strong><?=  TOTAL ?>:</strong></td>
				<td class="w75">
					<strong><?= nf($om->getMOrderPriceEUR()) . ' ' .
								$om->getMOrderCurrency() ?></strong>
				</td>
			</tr>

			<tr><td colspan="2"><hr></td></tr>

				<? if($om->getMPayNow() > 0) {?>

			<tr>
				<td class="w25 "><strong><?=  PAY_NOW ?>:</strong></td>
				<td class="w75">
					<strong><?= Eur2( $om->getMPayNow(),$om->getMOrderCurrency() )  . ' ' .
								$om->getMOrderCurrency() ?></strong>
				</td>
				</td>
			</tr>

				<?}?>
			<tr>
				<td class="w25 "><strong><?=  PAY_LATER ?>:</strong></td>
				<td class="w75">
					<strong><?= Eur2($om->getMPayLater(),$om->getMOrderCurrency() ) . ' ' .
								$om->getMOrderCurrency() ?></strong>
				</td>

			</tr>
			<tr>
				<td class="w100" colspan="2">
					<p style="font-size:.7em;text-transform:uppercase;text-align:left;">
							<?= SERVICES_DESC1 ?> |
							<?= SERVICES_DESC2 ?> |
							<?= SERVICES_DESC3 ?> |
							<?= SERVICES_DESC4 ?> |
							<?= SERVICES_DESC5 ?> |
							<?= SERVICES_DESC6 ?> |
							<?= SERVICES_DESC7 ?> |
							<?= SERVICES_DESC8 ?> |
							<?= SERVICES_DESC9 ?>
							<br><br>
							<?= ACCEPTED_TERMS ?>
							<br>
					</p>
				</td>
			</tr>
	</table>
<? } // end function


/**
 *
 *  TecajValutaNBH($currencyName='all')
 *  vraca array sa svim valutama ili za jednu valutu
 *
 *  Format:
 *	  $array['IME_VALUTE']
 *	  $array['IME_VALUTE']['code']
 *	  $array['IME_VALUTE']['for']
 *	  $array['IME_VALUTE']['buy']
 *	  $array['IME_VALUTE']['avg']
 *	  $array['IME_VALUTE']['sel']
 *  Uzima CURL-om tecajnu listu sa NBH, sprema je u file
 *  Cita taj file i trazi link na tabelu s podacima
 *  Uzima CURL-om podatke s tog linka i sprema ih u isti file
 *  Cita taj file u varijablu i izvlaci podatke po valutama
 *  Vraca array za sve (default='all') ili samo za odabranu valutu
 */
function TecajValutaNBH($currencyName='all')
{
	$ch = curl_init("https://www.hnb.hr/tecajn/htecajn.htm");
	$fileName = ROOT . "/tecajValutaHNB.txt";
	$fp = fopen($fileName, "w");

	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_exec($ch);
	curl_close($ch);



	$fp = fopen($fileName, "r");
	$content = fread($fp, filesize($fileName));

	# ovo pronalazi f*.dat u stringu, npr. f20140420.dat
	# to je zapravo tabela s tecajevima
	# ovo (\w+) je ima bit wildcard :))
	$pattern = '/f(\w+).dat/';
	preg_match($pattern, $content, $matches);
	$tabela = $matches[0];

	$ch = curl_init("https://www.hnb.hr/tecajn/htecajn.htm");
	$fp = fopen($fileName, "w");

	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);

	curl_exec($ch);
	curl_close($ch);
	fclose($fp);
}


function ParseTecaj($currencyName='all') {

	$fileName = ROOT . "/tecajValutaHNB.txt";
	$fp = fopen($fileName, "r");
	$content = fread($fp, filesize($fileName));
	fclose($fp);

	# ovo splita niz kad nadje blankove [\s]+ i to bilo koji broj blankova
	$niz = preg_split("/[\s]+/", $content);

	# prvi element nam ne treba
	unset($niz[0]);

	# kreiranje multi arraya, za svaku valutu po jedan
	$i = 1;
	foreach ($niz as $key => $val)
	{
		if ($i > 4) {
			$i = 1;
			$valute[$name] = $valuta;
			$valuta = array();
		}

		if($i == 1) {

			$code = substr($val,0,3);
			$name = substr($val,3,3);
			$unit = substr($val,6,3);

			$valuta['name'] = $name;
			$valuta['code'] = $code;
			$valuta['for']  = (int)$unit;
		}
		elseif ($i == 2) {
			$valuta['buy']= str_replace(',','.',$val);
		}
		elseif ($i== 3) {
			$valuta['avg']= str_replace(',','.',$val);
		}
		elseif ($i== 4) {
			$valuta['sel']= str_replace(',','.',$val);
		}

		$i++;
	}

	if ($currencyName != 'all') return $valute[$currencyName];
	else return $valute;

} #end Function

/*
**
** CURRENCY FUNCTIONS
**
*/
function toCurrency($iznos) {
	if(!isset($_SESSION['Currency']) or $_SESSION['Currency'] == '') return $iznos;

	$tecajevi = ParseTecaj();
	$EUR = $tecajevi['EUR']['avg'];
	$tecajValute = $tecajevi[$_SESSION['Currency']]['avg'];
	$zaJedan = $tecajValute / $tecajevi[$_SESSION['Currency']]['for'];

	if($zaJedan == '0') return nf($iznos);

	return nf($iznos * ($EUR / $zaJedan));
}

function ExchangeRatio() {
	if(!isset($_SESSION['Currency']) or $_SESSION['Currency'] == '') return 1;

	$tecajevi = ParseTecaj();
	$EUR = $tecajevi['EUR']['avg'];
	$tecajValute = $tecajevi[$_SESSION['Currency']]['avg'];
	$zaJedan = $tecajValute / $tecajevi[$_SESSION['Currency']]['for'];

	if($zaJedan == '0') return 1;

	return nf(($EUR / $zaJedan));
}

function Eur2($iznos, $currency) {
	if($currency=='' or $currency == 'EUR') return nf($iznos);

	$tecajevi = ParseTecaj();
	$EUR = $tecajevi['EUR']['avg'];
	$tecajValute = $tecajevi[$currency]['avg'];
	$zaJedan = $tecajValute / $tecajevi[$currency]['for'];

	if($zaJedan == '0') return nf($iznos);

	return nf($iznos * ($EUR / $zaJedan));
}

function nf($number) { return number_format($number,2,'.','');}
/*
**
** LOG FUNCTIONS
**
*/

function logit($message, $type=3) {
	if(gettype($message) == 'array') $message = var_export($message, true);

	error_log(
				date("d.m.Y H:i:s") . ' ' .
				$message . ' - IP:'.
				"\n",
				$type,
				ROOT . '/log/applog_'.date("Y-m-d").'.log');
}


function Blogit($message, $type=3) {
	if(gettype($message) == 'array') $message = var_export($message, true);

	error_log(
				date("d.m.Y H:i:s") . ' ' .
				$message . '								  '.
				"\n",
				$type,
				ROOT . '/log/cmsLog_'.date("Y-m-d").'.log');
}


function logReferer($message) {
	if(gettype($message) == 'array') $message = var_export($message, true);

	error_log(
				date("d.m.Y H:i:s") . ' ' .
				$message.
				"\n",
				'3',
				ROOT . '/log/httpReferer.log');
}

/*
**
** Function to get the client IP address
**
*/

function get_client_ip() {
	$ipaddress = '';
	if ($_SERVER['HTTP_CLIENT_IP'])
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if($_SERVER['HTTP_X_FORWARDED_FOR'])
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if($_SERVER['HTTP_X_FORWARDED'])
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if($_SERVER['HTTP_FORWARDED_FOR'])
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if($_SERVER['HTTP_FORWARDED'])
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if($_SERVER['REMOTE_ADDR'])
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	else
		$ipaddress = 'UNKNOWN';
	return $ipaddress;
}


function ymd2dmy($date, $format = "d.m.Y") {
	return date($format, strtotime($date) );
}




function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
	$output = NULL;
	if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
		$ip = $_SERVER["REMOTE_ADDR"];
		if ($deep_detect) {
			if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
				$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
	}
	$purpose	= str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
	$support	= array("country", "countrycode", "state", "region", "city", "location", "address", "ip");
	$continents = array(
		"AF" => "Africa",
		"AN" => "Antarctica",
		"AS" => "Asia",
		"EU" => "Europe",
		"OC" => "Australia (Oceania)",
		"NA" => "North America",
		"SA" => "South America"
	);
	if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
		$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
		if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
			switch ($purpose) {
				case "location":
					$output = array(
						"city"		   => @$ipdat->geoplugin_city,
						"state"		  => @$ipdat->geoplugin_regionName,
						"country"		=> @$ipdat->geoplugin_countryName,
						"country_code"   => @$ipdat->geoplugin_countryCode,
						"continent"	  => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
						"continent_code" => @$ipdat->geoplugin_continentCode
					);
					break;
				case "address":
					$address = array($ipdat->geoplugin_countryName);
					if (@strlen($ipdat->geoplugin_regionName) >= 1)
						$address[] = $ipdat->geoplugin_regionName;
					if (@strlen($ipdat->geoplugin_city) >= 1)
						$address[] = $ipdat->geoplugin_city;
					$output = implode(", ", array_reverse($address));
					break;
				case "city":
					$output = @$ipdat->geoplugin_city;
					break;
				case "state":
					$output = @$ipdat->geoplugin_regionName;
					break;
				case "region":
					$output = @$ipdat->geoplugin_regionName;
					break;
				case "country":
					$output = @$ipdat->geoplugin_countryName;
					break;
				case "countrycode":
					$output = @$ipdat->geoplugin_countryCode;
					break;
				case "ip":
					$output = @$ip;
					break;

			}
		}
	}
	return $output;
}

function isSessionGood () {
	if ( $_SESSION['returnTransfer'] == 1 and
		( is('returnDate') == false or is('returnTime') == false )
	)
		return false;

	if (	(is('ServiceID') == true)
		and (is('RouteID') == true)
		and (is('MPaxFirstName') == true)
		and (is('MPaxLastName') == true)
		and (is('MPaxEmail') == true)
		and (is('FromID') == true)
		and (is('transferDate') == true)
		and (is('transferTime') == true)
		and (is('ToID') == true)
		and (is('PaxNo') == true)
		and (is('VehicleID') == true)
		and (is('TotalPrice') == true)
	)
		 return true;
	else return false;
}


/*
 * PHP progress bar
 */
function PrepareProgress() {
	//ob_start();

  echo <<<KRAJ
<div id="progress" class="progress"></div>
<!-- Progress information -->
<div id="information" style="width"></div>

KRAJ;

}

function ShowProgress($i, $total) {
	// Calculate the percentation
	$percent = intval($i/$total * 100)."%";
	$divisor = 100;
  $quotient = intval($i / $divisor);
  $remainder = $i % $divisor;

  if ($remainder == 0 or $i == $total) {
	// Javascript for updating the progress bar and information
	echo '<script language="javascript">
	document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:#336699;\">&nbsp;</div>";
	document.getElementById("information").innerHTML="'.$i.' row(s) processed.";
	</script>';


  // This is for the buffer achieve the minimum size in order to flush data
	echo str_repeat(' ',1024*128);
	//echo str_pad('',4096)."\n";


  // Send output to browser immediately
	ob_flush();
	flush();




  // Sleep one second so we can see the delay
	sleep(1);
  }
}
/*
 * END PHP progress bar
 */


// CMS: Agent Booking Form
// provjerava jeli $AuthUserID od agenta jedan od dozvoljenih
// (napravit transfer na isti dan, cash placanje)
function isLocalAgent ($agentID) {
	$local = 0;
	//$allowed = array(234, 406, 409, 422, 789, 919, 2831, 2833, 2835, 2836, 2837, 2838, 2839, 2841); // dozvoljeni agenti
	$allowed = array(234, 406, 409, 422, 789, 919, 2831,2833); // dozvoljeni agenti

	for ($i = 0; $i < count($allowed); $i++) {
		if ($agentID == $allowed[$i]) $local = 1;
	}

	return $local;
}

// vrati broj postojecih specificnih korisnickih imena iz v4_AuthUsers (nesmije biti >1)
function usernameExists ($name) {
	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();
	$q  = 'SELECT * FROM v4_AuthUsers WHERE AuthUserName = "' . $name . '"';
	$w = $db->RunQuery($q);

	return $w->num_rows;
}

function days_in_month($month, $year) 
{ 
// calculate number of days in a month 
return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31); 
} 

function getConnectedUser($id) {
	if ($id==1712) return 1711;
	else if ($id==1711) return 1712;
	else if ($id==943) return 2233;
	else if ($id==2233) return 943;
	else if ($id==1309) return 1749;
	else if ($id==1749) return 1309;
	
	else return -1;
}

function getConnectedUserName($id) {
	if (getConnectedUser($id)!=-1) {
		$user = getUser(getConnectedUser($id));
		$userData = trim($user->AuthUserCompany);
		return '+'.$userData;
	}
	else return '';
}

function getConnectedUserNamePlus($id) {
	if (getConnectedUser($id)!=-1) {
		$user = getUserData(getConnectedUser($id));
		$userData = trim($user['AuthUserCompany']);
		return '+'.$userData;
	}
}