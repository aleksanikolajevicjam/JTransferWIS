<?
require_once "data.php";
@session_start();

// FRANCUSKA FIX
$SOwnerID = $_SESSION['OwnerID'];
$fakeDriverFound = false;

require_once $_SERVER['DOCUMENT_ROOT'] . '/cms/fixDriverID.php';

foreach($fakeDrivers as $key => $fakeDriverID) {
    if($SOwnerID == $fakeDriverID) {
        $fakeDriverFound = true;
    }
}

// preko timetable se samo sljedeca polja mogu mijenjati
$data = array(
		'CustomerID'	=> $_REQUEST['CustomerID'],
        'SubPickupTime' => $_REQUEST['SubPickupTime'],
        'SubFlightNo'   => $_REQUEST['SubFlightNo'],
        'SubFlightTime' => $_REQUEST['SubFlightTime'],
        'SubDriver'     => $_REQUEST['SubDriver'],
        'SubDriver2'    => $_REQUEST['SubDriver2'],
        'SubDriver3'    => $_REQUEST['SubDriver3'],
        'Car'           => $_REQUEST['Car'],
        'Car2'          => $_REQUEST['Car2'],
        'Car3'          => $_REQUEST['Car3'],
        'CashIn' 		=> $_REQUEST['CashIn'],
		'StaffNote'		=> addslashes($_REQUEST['StaffNote']),
        'SubDriverNote' => addslashes($_REQUEST['Notes']),
        'TransferDuration' => addslashes($_REQUEST['TransferDuration'])
);

if($fakeDriverFound) $q = 'UPDATE v4_OrderDetailsFR SET';
else $q = 'UPDATE v4_OrderDetails SET';

foreach ($data as $field => $value)	{
	$q .= " " . $field . " = '" . $value. "' ,";
}

// get rid of last ,
$q = substr_replace( $q, "", -1 );

$q .= ' WHERE DetailsID = ' . $_REQUEST['ID'];

unset($data);
$success = mysqli_query($conn, $q) or die(mysqli_connect_error());

//slanje mail-a
if (isset($_REQUEST['Mail']) && $_REQUEST['Mail']==1) {
	// Ovdje obavijestiti kupca da je vozac promijenjen, odnosno da je prihvatio transfer
	require_once $_SERVER['DOCUMENT_ROOT'] . '/f/f.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_OrderDetails.class.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_OrdersMaster.class.php';	
	require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_AuthUsers.class.php';
	
	$d = new v4_OrderDetails();
	$m = new v4_OrdersMaster();	
	$u = new v4_AuthUsers();
	
	$d->getRow($_REQUEST['ID']);
	$m->getRow($d->OrderID);
	$u->getRow($d->SubDriver);
	
	$mailMessage = '<span style="font-weight:bold">PLEASE DO NOT REPLY TO THIS MESSAGE</span><br>
	Hello ' . ucwords($d->PaxName) . '!<br>
	We have assigned one of our best drivers to look after You.<br>
	<br>
	Reservation Code: ' . $m->MOrderKey . '-' . $m->MOrderID . '<br>
	TransferID: ' . $d->OrderID . '-' . $d->TNo . '<br>
	Direction: ' . $d->PickupName . ' to ' . $d->DropName . '<br>
	<br><br>
	<span style="font-weight:bold">';
	$mailMessage .='<span style="color:red;">Your New Driver\'s Name: </span>' . htmlspecialchars($u->getAuthUserRealName()) . '<br>'; 
	$mailMessage .='Driver\'s Telephone';
	$phonemessage=' (do NOT send SMS, only for calls)';
	$mailMessage .=$phonemessage;
	$mailMessage .=': ' . htmlspecialchars($u->getAuthUserMob()) . '</span>
	<br>
	<br>
	You can contact Your driver directly in case You are delayed etc.<br>
	or you can call our Customer Service 24/7 as well.<br>
	<br>
	If you can not reach driver\'s phone number, please contact our Call Centre +381646597200<br>
	If you need to contact us, please send an email to info@jamtransfer.com<br>
	<br>
	Have a nice trip and please recommend us if You like our service!<br>
	<br>
	Kindest regards, <br>
	<br>
	JamTransfer.com Team';
	
	$mailto = $m->MPaxEmail;
	//$mailto = 'jam.arhiva@gmail.com';
	$subject = 'Important Update for Transfer: '. ' ' . $m->MOrderKey.'-'.$m->MOrderID . '-' . $d->TNo;
	mail_html($mailto, 'driver-info@jamtransfer.com', 'JamTransfer.com', 'info@jamtransfer.com',
	$subject , $mailMessage);
	
}	

if (!$success) echo ' <small>Error saving data.</small>';
else echo ' <small>Saved.</small>';

