<?

	header('Content-Type: text/javascript; charset=UTF-8');
	error_reporting(E_PARSE);
 
	# init libs
	require_once ROOT.'/db/db.class.php';
	
	$db = new DataBaseMysql();
	
	$status = $_REQUEST['status'];
	$driver = $_REQUEST['OwnerID'];
	
	$q = "UPDATE v4_DriverRoutes SET Active='{$status}' WHERE OwnerID='{$driver}'";
	$success = $db->RunQuery($q);
	
	$upd = 'Error: Not done.';
	if($success) {
		if ($status == 1) $upd = 'Activated. <script>location.reload();</script>';
		if ($status == 0) $upd = 'Deactivated. <script>location.reload();</script>';
	}
	
	
	$out = array(
		'updated' => $upd
	);

	# send output back
	$output = json_encode($out);
	echo $_REQUEST['callback'] . '(' . $output . ')';	
