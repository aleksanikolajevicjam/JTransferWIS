<?
header('Content-Type: text/javascript; charset=UTF-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//error_reporting(E_PARSE);

session_start();

	# init libs

	require_once '../../../../db/db.class.php';
	require_once '../../../../db/v4_VehicleEquipmentList.class.php';
	require_once '../../../../db/v4_Equipment.class.php';

	# init class
	
	$db = new v4_VehicleEquipmentList();
	$eq = new v4_Equipment();
	$dbf = new DataBaseMySql();

	
# init vars
$keyName = '';
$keyValue = '';

if (isset($_REQUEST['keyName']) and $_REQUEST['keyName'] != '') 	$keyName = $_REQUEST['keyName'];
if (isset($_REQUEST['keyValue']) and $_REQUEST['keyValue'] != '') 	$keyValue = $_REQUEST['keyValue'];

$fldList = array();
$out = array();

require_once ROOT . '/cms/fixDriverID.php';
foreach($fakeDrivers as $key => $fakeListID) {
    if($_REQUEST['OwnerID'] == $fakeListID) $_REQUEST['OwnerID'] = $realDrivers[$key];    
}

# if Update - get the row by keyValue
if ($keyName != '' and $keyValue != '') $db->getRow($keyValue);
	if(isset($_REQUEST['ID'])) { $db->setID($db->myreal_escape_string($_REQUEST['ID']) ); } 
	if(isset($_REQUEST['OwnerID'])) { $db->setOwnerID($db->myreal_escape_string($_REQUEST['OwnerID']) ); } 
	if(isset($_REQUEST['ListID'])) { $db->setListID($db->myreal_escape_string($_REQUEST['ListID']) ); } 
	if(isset($_REQUEST['VehicleID'])) { $db->setVehicleID($db->myreal_escape_string($_REQUEST['VehicleID']) ); } 	
	if(isset($_REQUEST['Datum'])) { $db->setDatum($db->myreal_escape_string($_REQUEST['Datum']) ); } 
	if(isset($_REQUEST['Description'])) { $db->setDescription($db->myreal_escape_string($_REQUEST['Description']) ); } 
	

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
	$newID = $db->saveAsNew();
}

	$eqk = $eq->getKeysBy('ID ' , '' , 'Where Active=1');
	$sql="DELETE FROM `v4_VehicleEquipmentItem` WHERE `ListID`='".$_REQUEST['ListID']."' AND VehicleID=".$_REQUEST['VehicleID'];
	$dbf->RunQuery($sql);
	if (count($eqk) != 0) {
		foreach ($eqk as $nn => $key)  
		{	
			$eq->getRow($key);
			$index='check'.$key;
			if (isset($_REQUEST[$index])) {
				$sql="INSERT INTO `v4_VehicleEquipmentItem`(`VehicleID`,`ListID`, `EquipmentID`) VALUES (".$_REQUEST['VehicleID'].",'".$_REQUEST['ListID']."',".$key.")";
				$dbf->RunQuery($sql);	
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