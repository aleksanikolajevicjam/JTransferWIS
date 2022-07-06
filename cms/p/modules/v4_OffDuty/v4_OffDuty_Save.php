<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once '../../../../db/db.class.php';
	require_once '../../../../db/v4_OffDuty.class.php';
	require_once '../../../../db/v4_Vehicles.class.php';


	# init class
	$db = new v4_OffDuty();

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


	if(isset($_REQUEST['ID'])) { $db->setID($db->myreal_escape_string($_REQUEST['ID']) ); } 

		 	
	if(isset($_REQUEST['OwnerID'])) { $db->setOwnerID($db->myreal_escape_string($_REQUEST['OwnerID']) ); } 

		 	
	if(isset($_REQUEST['VehicleID'])) { $db->setVehicleID($db->myreal_escape_string($_REQUEST['VehicleID']) ); } 

		 	
	if(isset($_REQUEST['StartDate'])) { $db->setStartDate($db->myreal_escape_string($_REQUEST['StartDate']) ); } 

		 	
	if(isset($_REQUEST['StartTime'])) { $db->setStartTime($db->myreal_escape_string($_REQUEST['StartTime']) ); } 

		 	
	if(isset($_REQUEST['EndDate'])) { $db->setEndDate($db->myreal_escape_string($_REQUEST['EndDate']) ); } 

		 	
	if(isset($_REQUEST['EndTime'])) { $db->setEndTime($db->myreal_escape_string($_REQUEST['EndTime']) ); } 

		 	
	if(isset($_REQUEST['Reason'])) { $db->setReason($db->myreal_escape_string($_REQUEST['Reason']) ); } 

		 	

$upd = '';
$newID = '';

// ako je update, azuriraj trazeni slog

if ($keyName != '' and $keyValue != '') {
	$res = $db->saveRow();
	$upd = 'Updated';
	if($res !== true) $upd = $res;
}
//$_SESSION['AuthUserID']=520; // za test
// inace dodaj novi slog	
if ($keyName != '' and $keyValue == '') {
	if(isset($_REQUEST['VehicleID']) && $_REQUEST['VehicleID']!=-1) $newID = $db->saveAsNew();
	else {
		require_once '../../../../db/v4_Vehicles.class.php';
		$v = new v4_Vehicles();
		$where = " WHERE OwnerID = '".$_REQUEST['OwnerID']."' ";
		$vk = $v->getKeysBy('VehicleID', 'ASC', $where);
		if(count($vk) > 0 ) {
			foreach($vk as $nn => $vid) { 
				$v->getRow($vid);
				$_REQUEST['VehicleID']=$v->VehicleID;	
				if(isset($_REQUEST['VehicleID'])) { $db->setVehicleID($db->myreal_escape_string($_REQUEST['VehicleID']) ); } 
				$newID = $db->saveAsNew();
			}
		}
	}	
}

$out = array(
	'update' => $upd,
	'insert' => $newID
);

# send output back
$output = json_encode($out);
echo $_REQUEST['callback'] . '(' . $output . ')';
	
