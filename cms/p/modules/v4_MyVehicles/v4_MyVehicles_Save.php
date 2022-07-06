<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once '../../../../db/db.class.php';
	require_once '../../../../db/v4_MyVehicles.class.php';


	# init class
	$db = new v4_MyVehicles();

# init vars
$keyName = '';
$keyValue = '';

if (isset($_REQUEST['keyName']) and $_REQUEST['keyName'] != '') 	$keyName = $_REQUEST['keyName'];
if (isset($_REQUEST['keyValue']) and $_REQUEST['keyValue'] != '') 	$keyValue = $_REQUEST['keyValue'];

$fldList = array();
$out = array();


# if Update - get the row by keyValue
if ($keyName != '' and $keyValue != '') $db->getRow($keyValue);


	if(isset($_REQUEST['VehicleID'])) { $db->setVehicleID($db->myreal_escape_string($_REQUEST['VehicleID']) ); } 

		 	
	if(isset($_REQUEST['OwnerID'])) { $db->setOwnerID($db->myreal_escape_string($_REQUEST['OwnerID']) ); } 

		 	
	if(isset($_REQUEST['VehicleName'])) { $db->setVehicleName($db->myreal_escape_string($_REQUEST['VehicleName']) ); } 

		 	
	if(isset($_REQUEST['VehicleTypeID'])) { $db->setVehicleTypeID($db->myreal_escape_string($_REQUEST['VehicleTypeID']) ); } 

		 	
	if(isset($_REQUEST['SurCategory'])) { $db->setSurCategory($db->myreal_escape_string($_REQUEST['SurCategory']) ); } 

		 	
	if(isset($_REQUEST['SurID'])) { $db->setSurID($db->myreal_escape_string($_REQUEST['SurID']) ); } 

		 	
	if(isset($_REQUEST['PriceKm'])) { $db->setPriceKm($db->myreal_escape_string($_REQUEST['PriceKm']) ); } 

		 	
	if(isset($_REQUEST['ReturnDiscount'])) { $db->setReturnDiscount($db->myreal_escape_string($_REQUEST['ReturnDiscount']) ); } 

		 	
	if(isset($_REQUEST['VehicleDescription'])) { $db->setVehicleDescription($db->myreal_escape_string($_REQUEST['VehicleDescription']) ); } 

		 	
	if(isset($_REQUEST['VehicleCapacity'])) { $db->setVehicleCapacity($db->myreal_escape_string($_REQUEST['VehicleCapacity']) ); } 

		 	
	if(isset($_REQUEST['VehicleImage'])) { $db->setVehicleImage($db->myreal_escape_string($_REQUEST['VehicleImage']) ); } 

		 	
	if(isset($_REQUEST['VehicleImage2'])) { $db->setVehicleImage2($db->myreal_escape_string($_REQUEST['VehicleImage2']) ); } 

		 	
	if(isset($_REQUEST['VehicleImage3'])) { $db->setVehicleImage3($db->myreal_escape_string($_REQUEST['VehicleImage3']) ); } 

		 	
	if(isset($_REQUEST['VehicleImage4'])) { $db->setVehicleImage4($db->myreal_escape_string($_REQUEST['VehicleImage4']) ); } 

		 	
	if(isset($_REQUEST['AirCondition'])) { $db->setAirCondition($db->myreal_escape_string($_REQUEST['AirCondition']) ); } 

		 	
	if(isset($_REQUEST['ChildSeat'])) { $db->setChildSeat($db->myreal_escape_string($_REQUEST['ChildSeat']) ); } 

		 	
	if(isset($_REQUEST['Music'])) { $db->setMusic($db->myreal_escape_string($_REQUEST['Music']) ); } 

		 	
	if(isset($_REQUEST['TV'])) { $db->setTV($db->myreal_escape_string($_REQUEST['TV']) ); } 

		 	
	if(isset($_REQUEST['GPS'])) { $db->setGPS($db->myreal_escape_string($_REQUEST['GPS']) ); } 

		 	

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
	$newID = $db->saveAsNew();
}


$out = array(
	'update' => $upd,
	'insert' => $newID
);

# send output back
$output = json_encode($out);
echo $_REQUEST['callback'] . '(' . $output . ')';
	
