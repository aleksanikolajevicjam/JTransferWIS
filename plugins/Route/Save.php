<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once 'Initial.php';
	
$keyValue = $_REQUEST['id'];
$topRouteID=$_REQUEST['id'];

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
	$topRouteID=$newID;
}
$out = array(
	'update' => $upd,
	'insert' => $newID
);
if (isset($_SESSION['UseDriverID']) && $_SESSION['UseDriverID']>0) {
	$result = $dbT->RunQuery("DELETE FROM `v4_DriverRoutes` WHERE `RouteID`=".$keyValue." AND `OwnerID`=".$_SESSION['UseDriverID']);
	if ($_REQUEST['DriverRoute']==1) $result = $dbT->RunQuery("INSERT IGNORE INTO `v4_DriverRoutes`(`RouteID`,`OwnerID`,`SurCategory`) VALUES (".$keyValue.",".$_SESSION['UseDriverID'].",".$_REQUEST['SurCategory'].")");
}
else {	
	if ($_REQUEST['TopRoute']==1) $result = $dbT->RunQuery("INSERT IGNORE INTO `v4_TopRoutes`(`TopRouteID`) VALUES (".$topRouteID.")");
	else $result = $dbT->RunQuery("DELETE FROM `v4_TopRoutes` WHERE `TopRouteID`=".$topRouteID);
}	

# send output back
$output = json_encode($out);
echo $_REQUEST['callback'] . '(' . $output . ')';
	