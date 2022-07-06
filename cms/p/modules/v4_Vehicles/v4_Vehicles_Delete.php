<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once '../../../../db/db.class.php';
	require_once '../../../../db/v4_Vehicles.class.php';
	require_once '../../../../db/v4_Services.class.php';


	# init vars
	$out = array();


	# init class
	$db = new v4_Vehicles();
	$s  = new v4_Services();
	

	# delete row by key value
	$db->deleteRow($_REQUEST['VehicleID']);
	
	# delete all services for the vehicle
	$k = $s->getKeysBy('VehicleID', 'asc', ' WHERE VehicleID = '. $_REQUEST['VehicleID']);
	
	foreach($k as $n => $id) {
		$s->deleteRow($id);
	}
	
	$out[] = 'Deleted';

	# send output back
	$output = json_encode($out);
	echo $_GET['callback'] . '(' . $output . ')';
	
