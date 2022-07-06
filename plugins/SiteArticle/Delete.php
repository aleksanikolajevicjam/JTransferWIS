<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once 'Initial.php';

$out = array();

# delete row by key value
$db->deleteRow($_REQUEST['ID']);
$out[] = 'Deleted';

# send output back
$output = json_encode($out);
echo $_GET['callback'] . '(' . $output . ')';