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
	if ($_REQUEST['DriverExtras']==1) $result = $dbT->RunQuery("INSERT IGNORE INTO `v4_Extras`(`ServiceID`,`OwnerID`) VALUES (".$keyValue.",".$_SESSION['UseDriverID'].")");
	else $result = $dbT->RunQuery("DELETE FROM `v4_Extras` WHERE `ServiceID`=".$keyValue." AND `OwnerID`=".$_SESSION['UseDriverID']);
}
$out = array(
	'update' => $upd,
	'insert' => $newID
);
# send output back
$output = json_encode($out);
echo $_REQUEST['callback'] . '(' . $output . ')';
	