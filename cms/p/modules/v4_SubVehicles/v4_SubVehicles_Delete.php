<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once '../../../../db/db.class.php';
	require_once '../../../../db/v4_SubVehicles.class.php';


	# init vars
	$out = array();


	# init class
	$db = new v4_SubVehicles();

	# delete row by key value
	# vozila se nesmiju izbrisati, nego se promijeni status Active na 0
	// $db->deleteRow($_REQUEST['VehicleID']);
	$db->getRow($_REQUEST['VehicleID']);
	$db->deleteRow($_REQUEST['VehicleID']);
	//$db->setActive(0);
	//$db->saveRow();

	$out[] = 'Deleted';

	# send output back
	$output = json_encode($out);
	echo $_GET['callback'] . '(' . $output . ')';

