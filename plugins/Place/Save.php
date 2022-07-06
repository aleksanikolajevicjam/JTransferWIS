<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once 'Initial.php';
	
$keyValue = $_REQUEST['id'];
$terminalID=$_REQUEST['id'];
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
	$terminalID=$newID;
}
$out = array(
	'update' => $upd,
	'insert' => $newID
);
if (isset($_SESSION['UseDriverID']) && $_SESSION['UseDriverID']>0) {
	if ($_REQUEST['Terminal']==1) $result = $dbT->RunQuery("INSERT IGNORE INTO `v4_DriverTerminals`(`DriverID`,`TerminalID`) VALUES (".$_SESSION['UseDriverID'].",".$terminalID.")");
	else $result = $dbT->RunQuery("DELETE FROM `v4_DriverTerminals` WHERE `TerminalID`=".$terminalID." AND `DriverID`=".$_SESSION['UseDriverID']);	
}	
else {
	if ($_REQUEST['Terminal']==1) $result = $dbT->RunQuery("INSERT IGNORE INTO `v4_Terminals`(`TerminalID`) VALUES (".$terminalID.")");
	else $result = $dbT->RunQuery("DELETE FROM `v4_Terminals` WHERE `TerminalID`=".$terminalID);
}	
	

# send output back
$output = json_encode($out);
echo $_REQUEST['callback'] . '(' . $output . ')';
	