<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);

session_start();

	# init libs
	require_once '../../../../db/db.class.php';
	require_once '../../../../db/v4_SubVehicles.class.php';


	# init class
	$db = new v4_SubVehicles();

# init vars
$keyName = '';
$keyValue = '';

if (isset($_REQUEST['keyName']) and $_REQUEST['keyName'] != '') 	$keyName = $_REQUEST['keyName'];
if (isset($_REQUEST['keyValue']) and $_REQUEST['keyValue'] != '') 	$keyValue = $_REQUEST['keyValue'];

$fldList = array();
$out = array();

require_once ROOT . '/cms/fixDriverID.php';
foreach($fakeDrivers as $key => $fakeDriverID) {
    if($_REQUEST['OwnerID'] == $fakeDriverID) $_REQUEST['OwnerID'] = $realDrivers[$key];    
}

# if Update - get the row by keyValue
if ($keyName != '' and $keyValue != '') $db->getRow($keyValue);


	if(isset($_REQUEST['VehicleID'])) { $db->setVehicleID($db->myreal_escape_string($_REQUEST['VehicleID']) ); } 

		 	
	if(isset($_REQUEST['OwnerID'])) { $db->setOwnerID($db->myreal_escape_string($_REQUEST['OwnerID']) ); } 

		 	
	if(isset($_REQUEST['VehicleTypeID'])) { $db->setVehicleTypeID($db->myreal_escape_string($_REQUEST['VehicleTypeID']) ); } 

		 	
	if(isset($_REQUEST['VehicleDescription'])) { $db->setVehicleDescription($db->myreal_escape_string($_REQUEST['VehicleDescription']) ); } 

		 	
	if(isset($_REQUEST['VehicleCapacity'])) { $db->setVehicleCapacity($db->myreal_escape_string($_REQUEST['VehicleCapacity']) ); } 

		 	
	if(isset($_REQUEST['Active'])) { $db->setActive($db->myreal_escape_string($_REQUEST['Active']) ); } 

		 	

$upd = '';
$newID = '';

// ako je update, azuriraj trazeni slog

if ($keyName != '' and $keyValue != '') {
	$res = $db->saveRow();
	$upd = 'Updated';
	if($res !== true) $upd = $res;
}

// inace dodaj novi slog	
if ($keyName != '' and $keyValue == '') {
	$db->setOwnerID($_SESSION['OwnerID']);
	$db->setActive(1);
	$newID = $db->saveAsNew();
}


$out = array(
	'update' => $upd,
	'insert' => $newID
);

# send output back
$output = json_encode($out);
echo $_REQUEST['callback'] . '(' . $output . ')';
	
