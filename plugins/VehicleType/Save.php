<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once 'Initial.php';
	
$keyValue = $_REQUEST['id'];
$fldList = array();
$out = array();
if ($keyName != '' and $keyValue != '') $db->getRow($keyValue);
foreach ($db->fieldNames() as $name) {
	$content=$db->myreal_escape_string($_REQUEST[$name]);
	if(isset($_REQUEST[$name])) {
		eval("\$db->set".$name."(\$content);");	
	}	
}	
$upd = '';
$newID = '';
if ($keyName != '' and $keyValue != '') {
	$res = $db->saveRow();
	$upd = 'Updated';
	if($res !== true) $upd = $res;
}
if ($keyName != '' and $keyValue == '') {
	$newID = $db->saveAsNew();
}
if (isset($_SESSION['UseDriverID']) && $_SESSION['UseDriverID']>0) {
	$result = $dbT->RunQuery("DELETE FROM `v4_Vehicles` WHERE `VehicleTypeID`=".$keyValue." AND `OwnerID`=".$_SESSION['UseDriverID']);
	if ($_REQUEST['DriverVehicle']==1) $result = $dbT->RunQuery("INSERT IGNORE INTO `v4_Vehicles`(`VehicleTypeID`,`OwnerID`,`SurCategory`) VALUES (".$keyValue.",".$_SESSION['UseDriverID'].",".$_REQUEST['SurCategory'].")");
}
$out = array(
	'update' => $upd,
	'insert' => $newID
);
# send output back
$output = json_encode($out);
echo $_REQUEST['callback'] . '(' . $output . ')';
	