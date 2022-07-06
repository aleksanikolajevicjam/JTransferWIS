<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once '../../../../db/db.class.php';
	require_once '../../../../db/v4_Vehicles.class.php';
	require_once '../../../../db/v4_VehicleTypes.class.php';


	# init vars
	$out = array();


	# init class
	$db = new v4_Vehicles();
	$vt = new v4_VehicleTypes();

	# filters

	$VehicleID = $_REQUEST['VehicleID'];

	# Details  red
	$db->getRow($VehicleID);

	# Details  red
	$db->getRow($dbk[0]);
	$vt->getRow($db->getVehicleTypeID());

	# get fields and values
	$detailFlds = $db->fieldValues();
	$detailFlds["VehicleClass"] = $vt->getVehicleClass();

	$out[] = $detailFlds;

	# send output back
	$output = json_encode($out);
	echo $_GET['callback'] . '(' . $output . ')';
	
