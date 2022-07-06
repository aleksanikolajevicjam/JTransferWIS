<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once '../../../../db/db.class.php';
	require_once '../../../../db/v4_DriverRoutes.class.php';
	require_once '../../../../db/v4_Services.class.php';

	# init class
	$db = new v4_DriverRoutes();
	$s  = new v4_Services();

	# init vars
	$out = array();
	
	# ovo je u hidden polju
	$OwnerID = $_REQUEST['OwnerID'];

	# ID je DriverRoute ID, ne RouteID
	$db->getRow($_REQUEST['ID']);
	
	# spremi RouteID 
	$RouteID = $db->getRouteID();
	
	# delete from v4_DriverRoutes by key value
	$db->deleteRow($_REQUEST['ID']);
	
	# delete all services for the route
	$k = $s->getKeysBy('RouteID', 'asc', ' WHERE RouteID = '. $RouteID . ' AND OwnerID = ' . $OwnerID);
	
	foreach($k as $n => $id) {
		$s->deleteRow($id);
	}	
	
	
	$out[] = 'Deleted';

	# send output back
	$output = json_encode($out);
	echo $_GET['callback'] . '(' . $output . ')';
	
