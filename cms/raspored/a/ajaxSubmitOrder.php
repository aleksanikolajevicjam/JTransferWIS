<?

session_start();

require_once '../config.php';

# Language 
$_SESSION['lng'] = 'en';
if(!empty($_COOKIE['lng'])) $_SESSION['lng'] = $_COOKIE['lng'];
if (file_exists('../lng/' . $_SESSION['lng']. '_config.php'))
{
    require_once('../lng/' . $_SESSION['lng']. '_config.php');
}
else
{
    $_SESSION['lng'] = 'en';
    require_once('../lng/' . $_SESSION['lng']. '_config.php');
} 

foreach ($_REQUEST as $key => $value)
{
    # store request to session
    $_SESSION[$key] = $value;
}


//echo '<h1>Thank You!</h1>';
//echo 'You will receive Your Booking Confirmation and Receipt shortly.';
//echo NL.NL.NL;

//echo '<pre>'; print_r($_SESSION); echo '</pre>';
/*
Array
(
    [TEST] => 1
    [logged] => 1
    [OwnerID] => 100
    [AuthUserName] => test
    [lng] => en
    [co_name] => Happy Taxi
    [countries] => Array
        (
            [55] => Croatia
            [65] => Egypt
            [81] => Germany
            [179] => Scotland
        )

    [bogoFormUPDATE] => 1
    [bogoFormINSERT] => 1
    [cal_month] => 12
    [cal_year] => 2012
    [wCountry] => 55
    [wFrom] => 200014
    [wTo] => 200010
    [wDate] => 2012-12-27
    [wTime] => 02:05
    [FromName] => Dubrovnik
    [ToName] => Split 
    [FromType] => 2
    [ToType] => 2
    [currency] => €
    [ServiceID] => 202
    [OneWayPrice] => 200
    [ReturnPrice] => 390
    [SR] => return
    [SPAddress] => pick
    [SDAddress] => drop
    [SDate] => 2012-12-27
    [STime] => 02:05
    [SNote] => info1
    [RPAddress] => pick2
    [RDAddress] => drop2
    [RDate] => 2012-12-27
    [RTime] => 22:45
    [RNote] => info2
    [RT] => 1
    [FirstName] => bogo
    [LastName] => soic
    [Email] => test@test.com
    [TCode] => 01
    [TNumber] => 12345
    [CardType] => AMEX
    [CardNumber] => 34
    [CardName] => ja
    [CardMonth] => 11
    [CardYear] => 12
    [CardCVC] => 112
    [Discount] => 
)
*/





//header('Content-Type: text/javascript; charset=UTF-8');
#*****************************************
# Output for email and screen starts here
#*****************************************
ob_start(); 



$TEST = true;
$WRITE_DB = true;



require_once '../data.php';
require_once '../f/db_funcs.php';
require_once '../f/f.php';


$OwnerID        = $_SESSION['OwnerID'];
$start          = $_SESSION['FromName'];
$end            = $_SESSION['ToName'];
$RT             = $_SESSION['RT'];

$PaxFirstName   = $_SESSION['FirstName'];
$PaxLastName    = $_SESSION['LastName'];
$PaxTel         = $_SESSION['TCode'].'/'.$_SESSION['TNumber'];
$PaxEmail       = $_SESSION['Email'];
$CardType       = $_SESSION['CardType'];
$CardFirstName  = $_SESSION['CardName'];
$CardLastName   = $_SESSION['CardName'];
$CardEmail      = $_SESSION['Email'];
$CardTel        = $_SESSION['TCode'].'/'.$_SESSION['TNumber'];
$CardNumber     = $_SESSION['CardNumber'];
$CardCVD        = $_SESSION['CardCVC'];
$CardExpDate    = $_SESSION['CardMonth'].$_SESSION['CardYear'];

$CustomerIP     = '1';
$returnPrice    = $_SESSION['TotalPrice'];
$singlePrice    = $_SESSION['OneWayPrice'];
$extras_total   = 0;
$Rextras_total  = 0;
//$serviceID      = $_SESSION['ServiceID'];
$serviceID      = '0'; //$_SESSION['ServiceID'];
$routeID        = '0';

$FlightNo       = $_SESSION['SFlightNo'];
$FlightTime     = $_SESSION['SFlightTime'];
$PickupAddress  = $_SESSION['SPAddress'];
$PickupDate     = $_SESSION['SDate'];
$PickupTime     = $_SESSION['STime'];
$PickupNotes    = $_SESSION['SNote'];
$DropAddress    = $_SESSION['SDAddress'];
$DropNotes      = '';

$PaxNo          = $_SESSION['PaxNo'];
$FlightNo2      = $_SESSION['RFlightNo'];
$FlightTime2    = $_SESSION['RFlightTime'];
$PickupAddress2 = $_SESSION['RPAddress'];
$PickupDate2    = $_SESSION['RDate'];
$PickupTime2    = $_SESSION['RTime'];
$PickupNotes2   = $_SESSION['RNote'];
$DropAddress2   = $_SESSION['RDAddress'];

$currency       = $_SESSION['currency'];
$site_name      = $_SESSION['co_name'];
$site_email     = $_SESSION['co_email'];
# dodatak
$vehicleID = $_SESSION['VehicleID'];


if ($RT == '1') $total = $returnPrice;
else $total = $singlePrice;



if (!isset($PickupDate) or $PickupDate=='') 
{
    echo    '<h2>Oops!</h2>
            Something strange happened.<br/>
            Some of the data are missing.<br/>
            Most probable reasons:<br/>
            <ul>
            <li>Your booking process took longer than 15 minutes, so Your session has expired</li>
            <li>You never filled out Your Pick-Up Date or Time</li>
            <li>Your browser does not support java script, but we did not detect this (we tried)</li>
            </ul>
            You should try to book Your transfer from the begining.<br/>
            If the same thing occures, please inform us via help desk chat (bottom of Your screen).<br/>
            <br/>
            Thank You
    ';
    $printOut = ob_get_contents();
    ob_end_clean();

    # ovako se vraca sadrzaj kad je cross-domain ajax
    $arr = array();
    $arr['thankyou'] = $printOut;

    //echo $_GET['callback']."(".json_encode($arr).");";
    echo $printOut;
    die();
}


#if (isset($bsm-start-sel))   $start   = $start      ;
#if (isset($bsm-end-sel))   $end     = $end      ;


/*
settype($start, 'integer');
settype($end, 'integer');

$startID = $start;
$endID = $end;

#$RT =  $returnMark ;

if (!$CustomerIP) $CustomerIP = '1'; 


# get start and end names
$query = "SELECT * FROM ".DB_PREFIX."places WHERE PlaceID =". $start ;
$result = mysql_query($query) or die(mysql_error().'start');
$row    = mysql_fetch_assoc($result);
$start  = $row['PlaceNameEN'];

$query = "SELECT * FROM ".DB_PREFIX."places WHERE PlaceID =". $end ;
$result = mysql_query($query) or die(mysql_error().'end');
$row    = mysql_fetch_assoc($result);
$end  = $row['PlaceNameEN'];
*/

# get driver data

$query = "SELECT * FROM ".DB_PREFIX."AuthUsers WHERE AuthUserID =". $OwnerID ;
$result = mysql_query($query) or die(mysql_error().'AuthUsers');
$driver    = mysql_fetch_assoc($result);

//$driverTel = $driver['AuthUserTel'];

# get driver policies data
#$query = "SELECT * FROM Policies_EN WHERE OwnerID =". $OwnerID ;
#$result = mysql_query($query) or die(mysql_error().'Policies');
#$policies    = mysql_fetch_assoc($result);


# Prepare Extras Output
#$extras = PrepareExtras($_REQUEST);

# Extras ne postoje za sada
$extras = $Rextras = '';
$extras_total = $Rextras_total = 0;


#if ($RT) $Rextras = PrepareRExtras($_REQUEST);
#else $Rextras = '';


echo '<div align="left">';
echo '<h1>'.THANK_YOU.'</h1>';
echo '<br/>';
echo CONFIRMATION_SENT .NL;
echo CHECK_MAILBOX .NL.NL;
echo '</div>';
# odvajanje thank you poruke od emaila
$thankYou = ob_get_contents();
ob_end_clean();

ob_start(); 
//echo '<b>Confirmation will be sent to the e-mail address You have entered.</b>'.NL.NL;

//echo '<pre>'; print_r($_REQUEST); echo '</pre>';


# Get RouteID
	//$routeID = GetRouteID($startID, $endID);
	
	//echo 'RouteID '.$routeID;

# Get VehicleTypeID
    //$vehicleID = GetVehicleIDFromServiceID($serviceID);
    $vehicleName = GetVehicleName($vehicleID);

# Get ServiceID

	//$serviceID = GetServiceID($routeID, $vehicleTypeID, $OwnerID);
	//echo 'serviceID '.$serviceID;

#
# ovdje bi mozda trebalo vratiti $vehicleID= $VehicleID !!!
# provjeri u team sta se dalje dogadja
#

# Generate Order Key

	$orderKey = create_order_key();
	$orderDate = date("Y-m-d");
	$orderTime = date("H:i:s");

# upisati u bazu

	$dataMaster = array(
		'OrderID'		=>'',
		'OrderStatus' 	=> '1',
		'OrderType'		=> '',
		'OrderKey'		=> $orderKey,
		'OrderDate'		=> $orderDate,
		'OrderTime'		=> $orderTime,
		'UserID'		=> '0',
		'UserLevelID'	=> '0',
		'OrderPriceEUR' => $total,
		'OrderCurrency' => $currency,
		'OrderCurrencyPrice' => $total,
		'EurToCurrencyRate'  => '1',
		'PaymentMethod' => '1',
		'PaymentStatus' => '0',
		'MPayNow'		=> '0',
		'MPayLater'		=> $total,
		'InvoiceAmount' => 0,
		'AgentCommision' => 0,
		'MPaxNo'		=> $PaxNo,
		'PaxFirstName'	=> $PaxFirstName,
		'PaxLastName'	=> $PaxLastName,
		'PaxTel'		=> $PaxTel,
		'PaxEmail'		=> $PaxEmail,
		'CustomerID'	=> '',
		'CardType'		=> $CardType,
		'CardFirstName'	=> $CardFirstName,
		'CardLastName'	=> $CardLastName,
		'CardEmail'		=> $CardEmail,
		'CardTel'		=> $CardTel,
		'CardAddress'	=> '',
		'CardCity'		=> '',
		'CardZip'		=> '',
		'CardCountry'	=> '',
		'CardNumber'	=> $CardNumber,
		'CardCVD'		=> $CardCVD,
		'CardExpDate'	=> $CardExpDate,
		'DriverID'		=> $OwnerID,
		'DriverName'	=> '',
		'DriverTel'		=> '',
		'DriverConfirmStatus'	=> '0',
		'DriverConfirmDate' 	=> '',
		'DriverConfirmTime'		=> '',
		'DriverNotes'			=> '',
		'ConfirmFile'			=> '',
		'CancelFile'			=> '',
		'ChangeFile'			=> '',
		'Subscribe'				=> '',
		'AcceptTerms'			=> '1',
		'SendEmail'				=> '',
		'EmailSentDate'			=> '',
		'CustomerIP'			=> $CustomerIP
	);
	
	if ($WRITE_DB) {
	$newRecID = XInsert(DB_PREFIX.'OrdersMaster', $dataMaster, true);
	}

# kalkulacija placanja
	if ($RT == '1') 
	{
		$retPrice = $returnPrice - $singlePrice;
		$payLater = $total - $retPrice;// - $Rextras_total;

		
	}
	else 
	{
		$payLater = $total;

	}


# upis prvog transfera	
	$dataDetails = array(
		'DetailsID'				=> '',
		'OrderID'				=> $newRecID,
		'TransferStatus'		=> '1',
		'TaxidoComm'			=> '',
		'ServiceID'				=> $serviceID,
		'RouteID'				=> $routeID,
		'FlightNo'				=> $FlightNo,
		'FlightTime'			=> $FlightTime,
		'PaxName'				=> $PaxFirstName . ' ' . $PaxLastName,
		//'PickupID'				=> $startID,
		'PickupName'			=> $start,
		'PickupPlace'			=> '',
		'PickupAddress'			=> $PickupAddress,
		'PickupDate'			=> $PickupDate,
		'PickupTime'			=> $PickupTime,
		'PickupNotes'			=> $PickupNotes,
		//'DropID'				=> $endID,
		'DropName'				=> $end ,
		'DropPlace'				=> '',
		'DropAddress'			=> $DropAddress,
		'DropNotes'				=> $DropNotes,
		'PriceClassID'			=> '',
		'DetailPrice'			=> $singlePrice,
		'DriversPrice'			=> $singlePrice,
		'Discount'				=> '',
		'ExtraCharge'			=> $extras_total,
		'PayNow'				=> '',
		'PayLater'				=> $payLater,
		'PaxNo'					=> $PaxNo,
		'VehicleType'			=> $vehicleID,
		'DriverID'				=> '',
		'DriverName'			=> '',
		'DriverTel'				=> '',
		'DriverConfirmStatus'	=> '0',
		'DriverConfirmDate'		=> '',
		'DriverConfirmTime'		=> '',
		'DriverNotes'			=> ''
	);
	
	if ($WRITE_DB) {
	$newRecDetID = XInsert(DB_PREFIX.'OrderDetails', $dataDetails, true);
	}
	
	# EXTRAS
	
	if ($extras_total > 0)
	{
		
		foreach ($firstExtras as $k => $v)
		{
			# code...
			$v['OrderDetailsID'] = $newRecDetID;
			if ($WRITE_DB) XInsert(DB_PREFIX.'OrderExtras',$v);
		}
		
	}
	
	
	


# ako je return transfer upisi ga
if ($RT == '1') 
{	
	
	$payLater2 = $retPrice ;//+ $Rextras_total;
	
	
	$dataDetails = array(
		'DetailsID'				=> '',
		'OrderID'				=> $newRecID,
		'TransferStatus'		=> '1',
		'TaxidoComm'			=> '',
		'ServiceID'				=> $serviceID,
		'RouteID'				=> $routeID,
		'FlightNo'				=> $FlightNo2,
		'FlightTime'			=> $FlightTime2,
		'PaxName'				=> $PaxFirstName . ' ' . $PaxLastName,
		//'PickupID'				=> $endID,
		'PickupName'			=> $end,
		'PickupPlace'			=> '',
		'PickupAddress'			=> $PickupAddress2,
		'PickupDate'			=> $PickupDate2,
		'PickupTime'			=> $PickupTime2,
		'PickupNotes'			=> $PickupNotes2,
		//'DropID'				=> $startID,
		'DropName'				=> $start,
		'DropPlace'				=> '',
		'DropAddress'			=> $DropAddress2,
		'DropNotes'				=> $DropNotes,
		'PriceClassID'			=> '',
		'DetailPrice'			=> $retPrice,
		'DriversPrice'			=> $retPrice,
		'Discount'				=> '',
		'ExtraCharge'			=> $Rextras_total,
		'PayNow'				=> '',
		'PayLater'				=> $payLater2,
		'PaxNo'					=> $PaxNo,
		'VehicleType'			=> $vehicleID,
		'DriverID'				=> '',
		'DriverName'			=> '',
		'DriverTel'				=> '',
		'DriverConfirmStatus'	=> '0',
		'DriverConfirmDate'		=> '',
		'DriverConfirmTime'		=> '',
		'DriverNotes'			=> ''
	);
	
	if ($WRITE_DB) {
	$newRecDetID2 = XInsert(DB_PREFIX.'OrderDetails', $dataDetails, true);
	}
	
	# EXTRAS
	
	if ($Rextras_total > 0)
	{
		
		foreach ($returnExtras as $k => $v)
		{
			# code...
			$v['OrderDetailsID'] = $newRecDetID2;
			if ($WRITE_DB) XInsert(DB_PREFIX.'OrderExtras',$v);
		}
		
	}
		
}



#********************************************************************************
# MESSAGES **********************************************************************
#********************************************************************************

	
# Compose first message to driver
	$driver_message  = HELLO .','.NL.NL;
	$driver_message .= NEW_TRANSFER .NL.NL;

	$driver_message .= AMOUNT .': '. number_format($payLater,2) . ' ' .$currency .NL;
	$driver_message .= DATE .': '. $PickupDate . NL;
	$driver_message .= TIME .': '. $PickupTime . NL.NL;
	$driver_message .= $start . ' '. TO .' '. $end . NL;
	$driver_message .= VEHICLE . ': '.$vehicleName. NL;
	$driver_message .= PASSENGERS . ': '.$PaxNo . NL;	
	$driver_message .= PICKUP_NOTE . ': '. $PickupNotes . NL;

	$driver_message .= BEST_REGARDS . ','.NL;
	$driver_message .= $site_name ;
	

	# Send E-mail to the driver
	if (!$TEST) mail_html($site_email, $site_email, $site_name , 'No Reply', NEW_TRANSFER_MAIL, $driver_message);	

	# Send E-mail to me
	mail_html('bogo@jamtransfer.com', $site_email, $site_name , 'No Reply', NEW_TRANSFER_MAIL, $driver_message);	


if ($RT)
{	
	# Compose second message to driver
		$driver_message  = HELLO .','.NL.NL;
		$driver_message .= NEW_TRANSFER .NL.NL;

		$driver_message .= AMOUNT .': '. number_format($payLater2,2) . ' ' .$currency .NL;
		$driver_message .= DATE . ': '. $PickupDate2 . NL;
		$driver_message .= TIME .': '. $PickupTime2 . NL.NL;
		$driver_message .=  $end   . ' '. TO .' '. $start . NL;
		$driver_message .= VEHICLE . ': '.$vehicleName . NL;
		$driver_message .= PASSENGERS . ': '.$PaxNo . NL;
		$driver_message .= PICKUP_NOTE . ': '. $PickupNotes2 . NL.NL;

		$driver_message .= BEST_REGARDS . ','.NL;
		$driver_message .= $site_name ;
	


		# Send second E-mail to the driver
		if (!$TEST) mail_html($site_email, $site_email, $site_name , 'No Reply', NEW_TRANSFER_MAIL, $driver_message);	
		
	# Send E-mail to me
	mail_html('bogo@jamtransfer.com', $site_email, $site_name , 'No Reply', NEW_TRANSFER_MAIL, $driver_message);		
}

	
# TODO: poslati mail kupcu
# TODO: poslati obavijest nama

//ob_start();

#********************************************************************************
# DISPLAY SCREEN ****************************************************************
#********************************************************************************

?>
<!-- ><link rel="stylesheet" type="text/css" href="http://demo.taxicms.com/main.css" /> -->
    <div id="finalDisplay" align="left" style="color:#000;background: #fff; padding: 6px;">
    <b><?= ORDER_KEY ?>: <?= $orderKey . '-' . $newRecID;?></b>
    <br/>
    <?= ORDER_DATE_TIME ?>: <?= $orderDate . ' ' . $orderTime; ?>
    <br/>
    <br/>
    <table width="100%" class="table">
    <thead>
    	<tr>
    		<td width="50%"><h3><?= PASSENGER_DATA ?></h3></td>
<!--    		<td width="50%"><h3>Driver Data</h3></td>-->
    	</tr>
    </thead>
    <tr>
    	<td style="vertical-align: top">
			<b><?= $PaxFirstName . ' ' . $PaxLastName; ?></b>
			<br/><br/>
			<?= $PaxTel;?>
			<br/>
			<?= $PaxEmail;?>
			<br/><br/>
			<b><?= CREDIT_CARD_DETAILS ?>:</b>
			<br/>
			<?= $CardFirstName;/* . ' ' . $CardLastName;*/?>
			<br/>
			<?= $CardType;?>
			<br/>
			<?= '*************' . substr($CardNumber, -4,4);?>
			<br/>
			<?= $CardTel;?>
			<br/>
			<?= $CardEmail;?>
    	</td>

		<tr><td colspan="2" style="border-bottom: 1px solid #ccc;">&nbsp;</td></tr>
    </tr>
    </table>
    <table width="100%" class="table-striped">
    	<tr>
    		<thead>
    		<td><?= FROM ?></td>
    		<td><?= TO ?></td>
    		<td width="100"><?= DATE ?></td>
    		<td width="50"><?= TIME ?></td>
    		<td width="50"><?= TOTAL ?></td>
    		</thead>
    	</tr>
    	<tr>
    		<td>
    			<b><?= $start; ?></b><br/>
    			
			    <?= trim($PickupAddress); ?><br/>
			    <?= PASSENGERS ?>: <?= $PaxNo; ?>

    		</td>
    		<td>
    			<b><?= $end; ?></b><br/>
				
			    <?= trim($DropAddress); ?>    		
    		</td>
    		<td>
    			<?= $PickupDate; ?>
    		</td>
    		<td>
    			<?= $PickupTime; ?>
    		</td>
    		<td>
    			<b><?= number_format($payLater,2) . ' ' . $currency /*+ $extras_total*/; ?> </b>
    		</td>
    	</tr>
    	<tr><td colspan="5" style="border-bottom: 1px solid #ccc;">&nbsp;</td></tr>
    	<tr><td colspan="5" style="border-bottom: 1px solid #ccc;">
    	<b><?= TRANSFER_CODE ?>: <?= $orderKey . '-' . $newRecDetID; ?></b></td></tr>

<? if ($extras != '')
{/*
?>    	
    	
    	<tr>
    		<td colspan="5" style="border-bottom: 1px solid #ccc;">
				<br/><br/>
				<b>Extras</b></td></tr>
    	
		    	<tr><td colspan="5" style="border-bottom: 1px solid #ccc;">
		    	<?= $extras; ?>
		    	<br/>
		    	Extras total: <?= number_format($extras_total,2) . ' ' . $currency; ?> <small> * included in transfer price</small>
    	</td></tr>
 <?*/ } ?>

    	
<? if ($RT)  { ?>
		<tr><td colspan="5" style="border-bottom: 1px solid #ccc;">
		<br/><br/>
    	<b><?= RETURN_TRANSFER ?></b></td></tr>
    	<tr>
    		<thead>
    		<td><?= FROM ?></td>
    		<td><?= TO ?></td>
    		<td width="100"><?= DATE ?></td>
    		<td width="50"><?= TIME ?></td>
    		<td width="50"><?= TOTAL ?></td>
    		</thead>
    	</tr>
    	<tr>
    		<td>
    			<b><?= $end; ?></b><br/>
    			
			    <?= trim($PickupAddress2); ?><br/>
			    <?= PASSENGERS ?>: <?= $PaxNo; ?>
    		</td>
    		<td>
    			<b><?= $start; ?></b><br/>
				
			    <?= trim($DropAddress2); ?>    		
    		</td>
    		<td>
    			<?= $PickupDate2; ?>
    		</td>
    		<td>
    			<?= $PickupTime2; ?>
    		</td>
    		<td>
    			<b><?= number_format($payLater2,2) . ' ' . $currency; /*$retPrice + $Rextras_total;*/ ?></b>
    		</td>
    	</tr>
    	<tr><td colspan="5" style="border-bottom: 1px solid #ccc;">&nbsp;</td></tr>
    	<tr><td colspan="5" style="border-bottom: 1px solid #ccc;">
    	<b><?= TRANSFER_CODE ?>: <?= $orderKey . '-' . $newRecDetID2; ?></b></td></tr>   	
<? } 

if ($Rextras != '')
{/*
?>    	
    	
    	<tr>
    		<td colspan="5" style="border-bottom: 1px solid #ccc;">
				<br/><br/>
				<b>Return Extras</b></td></tr>
    	
		    	<tr><td colspan="5" style="border-bottom: 1px solid #ccc;">
		    	<?= $Rextras; ?>
		    	<br/>
		    	Return Extras total: <?= number_format($Rextras_total,2). ' ' . $currency; ?> <small> * included in return transfer price</small>
    	</td></tr>
 <?*/ } ?>
    	
	</table>    	

<br/><br/>
    <?= TOTAL . ' ' . AMOUNT ?>: <h3><?= number_format($total,2). ' ' . $currency; ?></h3>
    <?
    # prikazati placanje odvojeno po transferima
    
    
    echo NL. TERMS_ACCEPTED .NL;
    echo FURTHER_COMM . NL.NL;
    echo $site_name . NL . NL;
    
    ?>

     <br/>
     <br/>
  
    </div>



<?


/*
echo '<pre>'. print_r($_REQUEST) . '</pre>';
    foreach($_REQUEST as $key => $value) {

        $_REQUEST[$key] = $value;
    }
echo '<pre>'. print_r($_POST) . '</pre>';
*/

$printOut = ob_get_contents();
ob_end_clean();

# ovako se vraca sadrzaj kad je cross-domain ajax
$arr = array();
$arr['thankyou'] = $thankYou . $printOut;

//echo $_GET['callback."(".json_encode($arr).");";
  

echo $thankYou . $printOut;

$customerMessage = '<h1>'.TAXI_TRANSFER_RESERVATION.'</h1><br/>';
$customerMessage .= '<b>'.PLEASE_PRINT.'</b>'.NL;
$customerMessage .= $printOut;


# Send E-mail to customer
if (!$TEST) mail_html($PaxEmail, $site_email, $site_name , 'No Reply', 'Transfer Booking', $customerMessage);	

# mail za nas
if (!$TEST) mail_html($site_email, $site_email, $site_name , 'No Reply', 'Transfer Booking', $customerMessage);

# mail za mene
mail_html('bogo@jamtransfer.com', $site_email, $site_name , 'No Reply', 'Transfer Booking', $customerMessage);

# priprema file-a za save
	$header = '
	
	<!DOCTYPE html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" type="text/css" href="http://taxido.net/css/taxido2.css" />
	</head>
	<body style="background: #fff !important">
	<div style="width: 600px; margin: 0 auto;">
	';

	$footer = '</div></body></html>';

	$potvrda_file = '../../reservations/'.$newRecID.'.html';
	
	# save rezervacije
	file_put_contents($potvrda_file, $header . $customerMessage . $footer);

//$REFRESH = 1;


#####################################################################################
# FUNCTIONS
#####################################################################################
/*
function PrepareExtras($req)
{
	global $extras_total;
	global $firstExtras;
	
	$showExtras = 0;
    			
    foreach ($req as $k => $v)
    {
    	# find values
    	$a = explode('_', $k); 

    	if ($a[0] == 'ser') {
    		$i = $a[1];
    		$sid[$i] = $a[2];
    		$oid[$i] = $a[3];
    		$qty[$i] = $v;
    	}

    	if ($a[0] == 'p') {
    		$i = $a[1];
    		$price[$i] = $v;
    	}
    	if ($a[0] == 'sum') {
    		$i = $a[1];
    		$sum[$i] = $v;
    		$extras_total += $v;
    	}
    	if ($a[0] == 'snm') {
    		$i = $a[1];
    		$snm[$i] = $v;
    	}
    	
    }
    
	$output = 	'
    			<table width="100%">
    			<thead><tr>
    			<td><b>Service</b></td>
    			<td><b>Price</b></td>
    			<td><b>Qty</b></td>
    			<td align="right"><b>Amount</b></td></tr></thead>';

	$firstExtras = array();

    for ($i = 0; $i < count($sid); $i++)
    {
    	# assemble output
    	if ($qty[$i] != 0) 
    	{
			$output .= 	'<tr>
							<td>'.$snm[$i].'</td>
							<td>'.$price[$i].' Eur </td>
							<td>'.$qty[$i].'</td>
							<td  align="right">'.$sum[$i].' Eur </td>
						</tr>';
						
			$firstExtras[$i] = array(
								'ID' => '',
								'OwnerID' => $OwnerID,
								'ServiceID' => $sid[$i],
								'ServiceName' => $snm[$i],
								'Price' => $price[$i],
								'Qty' => $qty[$i],
								'Sum' => $sum[$i]
								);
            $showExtras += $qty[$i];
    	}
    }
    
	$output .= '</table>';
	
	# if there's nothing to show
	if ($showExtras == 0) $output = '';
	
	return $output;
}


function PrepareRExtras($req)
{
	global $Rextras_total;
	global $returnExtras;
	
	$showExtras = 0;
	
	$output = 	'
    			<table width="100%">
    			<thead><tr>
    			<td><b>Service</b></td>
    			<td><b>Price</b></td>
    			<td><b>Qty</b></td>
    			<td align="right"><b>Amount</b></td></tr></thead>';
    			
    foreach ($req as $k => $v)
    {
    	# find values
    	$a = explode('_', $k); 

    	if ($a[0] == 'Rser') {
    		$i = $a[1];
    		$sid[$i] = $a[2];
    		$oid[$i] = $a[3];
    		$qty[$i] = $v;
    	}

    	if ($a[0] == 'Rp') {
    		$i = $a[1];
    		$price[$i] = $v;
    	}
    	if ($a[0] == 'Rsum') {
    		$i = $a[1];
    		$sum[$i] = $v;
    		$Rextras_total += $v;
    	}
    	if ($a[0] == 'Rsnm') {
    		$i = $a[1];
    		$snm[$i] = $v;
    	}
    	
    }
    
    $returnExtras = array();
    
    for ($i = 0; $i < count($sid); $i++)
    {
    	# assemble output
    	if ($qty[$i] != 0) 
    	{
			$output .= 	'<tr>
							<td>'.$snm[$i].'</td>
							<td>'.$price[$i].' Eur </td>
							<td>'.$qty[$i].'</td>
							<td  align="right">'.$sum[$i].' Eur </td>
						</tr>';
						
			$returnExtras[$i] = array(
								'ID' => '',
								'OwnerID' => $OwnerID,
								'ServiceID' => $sid[$i],
								'ServiceName' => $snm[$i],
								'Price' => $price[$i],
								'Qty' => $qty[$i],
								'Sum' => $sum[$i]
								);
			$showExtras += $qty[$i];
		}    	
    }
    
	$output .= '</table>';
	
	# if there's nothing to show
	if ($showExtras == 0) $output = '';
	
	return $output;
}
*/
