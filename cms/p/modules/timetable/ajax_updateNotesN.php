<?
require_once "data.php";
@session_start();

// FRANCUSKA FIX
$SOwnerID = $_SESSION['OwnerID'];
$fakeDriverFound = false;

require_once ROOT . '/cms/fixDriverID.php';

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
        'TransferDuration' => addslashes($_REQUEST['TransferDuration']),
		'Extras'		=> $_REQUEST['Extras']
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

if (!$success) echo ' <small>Error saving data.</small>';
else echo ' <small>Saved.</small>';

