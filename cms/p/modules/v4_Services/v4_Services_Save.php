<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once ROOT.'/db/db.class.php';
	require_once ROOT.'/db/v4_Services.class.php';


	# init class
	$db = new v4_Services();

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


	if(isset($_REQUEST['SiteID'])) { $db->setSiteID($db->myreal_escape_string($_REQUEST['SiteID']) ); } 

		 	
	if(isset($_REQUEST['OwnerID'])) { $db->setOwnerID($db->myreal_escape_string($_REQUEST['OwnerID']) ); } 

		 	
	if(isset($_REQUEST['ServiceID'])) { $db->setServiceID($db->myreal_escape_string($_REQUEST['ServiceID']) ); } 

		 	
	if(isset($_REQUEST['SurCategory'])) { $db->setSurCategory($db->myreal_escape_string($_REQUEST['SurCategory']) ); } 

		 	
	if(isset($_REQUEST['SurID'])) { $db->setSurID($db->myreal_escape_string($_REQUEST['SurID']) ); } 

		 	
	if(isset($_REQUEST['RouteID'])) { $db->setRouteID($db->myreal_escape_string($_REQUEST['RouteID']) ); } 

		 	
	if(isset($_REQUEST['VehicleID'])) { $db->setVehicleID($db->myreal_escape_string($_REQUEST['VehicleID']) ); } 

		 	
	if(isset($_REQUEST['VehicleTypeID'])) { $db->setVehicleTypeID($db->myreal_escape_string($_REQUEST['VehicleTypeID']) ); } 

		 	
	if(isset($_REQUEST['VehicleAvailable'])) { $db->setVehicleAvailable($db->myreal_escape_string($_REQUEST['VehicleAvailable']) ); } 

		 	
	if(isset($_REQUEST['Correction'])) { $db->setCorrection($db->myreal_escape_string($_REQUEST['Correction']) ); } 

		 	
	if(isset($_REQUEST['ServicePrice1'])) { $db->setServicePrice1($db->myreal_escape_string($_REQUEST['ServicePrice1']) ); } 

		 	
	if(isset($_REQUEST['ServicePrice2'])) { $db->setServicePrice2($db->myreal_escape_string($_REQUEST['ServicePrice2']) ); } 

		 	
	if(isset($_REQUEST['ServicePrice3'])) { $db->setServicePrice3($db->myreal_escape_string($_REQUEST['ServicePrice3']) ); } 

		 	
	if(isset($_REQUEST['Discount'])) { $db->setDiscount($db->myreal_escape_string($_REQUEST['Discount']) ); } 

		 	
	if(isset($_REQUEST['ServiceETA'])) { $db->setServiceETA($db->myreal_escape_string($_REQUEST['ServiceETA']) ); } 

		 	
	if(isset($_REQUEST['Active'])) { $db->setActive($db->myreal_escape_string($_REQUEST['Active']) ); } 

		 	
	 $db->setLastChange($db->myreal_escape_string($_REQUEST['LastChange']) ); 

		 	

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

