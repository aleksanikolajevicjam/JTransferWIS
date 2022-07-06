<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once 'Initial.php';

$out = array();

# delete row by key value
if (isset($_SESSION['UseDriverID']) && $_SESSION['UseDriverID']>0) 
	$result = $dbT->RunQuery("DELETE FROM `v4_Extras` WHERE `ServiceID`=".$_REQUEST['ID']." AND `OwnerID`=".$_SESSION['UseDriverID']);	
else $db->deleteRow($_REQUEST['ID']);
$out[] = 'Deleted';

# send output back
$output = json_encode($out);
echo $_GET['callback'] . '(' . $output . ')';