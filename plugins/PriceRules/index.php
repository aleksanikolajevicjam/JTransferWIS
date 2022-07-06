<?
	$smarty->assign('page',$md->getName());	
	
	if	($_REQUEST['rulesType']=='') $_REQUEST['rulesType']='global';
	switch ($_REQUEST['rulesType']) {
		case 'global':
			require_once ROOT . '/db/v4_SurGlobal.class.php';	
			$db = new v4_SurGlobal();
			# Details  red
			$dbk = $db->getKeysBy('OwnerID','asc','WHERE OwnerID = ' . $_SESSION['UseDriverID']);
			break;
		case 'routes':	
			require_once ROOT . '/db/v4_SurRoute.class.php';	
			$db = new v4_SurRoute();
			# Details  red
			$dbk = $db->getKeysBy('OwnerID','asc','WHERE OwnerID = ' . $_SESSION['UseDriverID'] . ' 
				AND DriverRouteID = ' . $_REQUEST['item']);			
			$route_name=true;		
			$rid=$_REQUEST['item'];				
			break;		
		case 'vehicles':	
			require_once ROOT . '/db/v4_SurVehicle.class.php';	
			$db = new v4_SurVehicle();
			# Details  red
			$dbk = $db->getKeysBy('OwnerID','asc','WHERE OwnerID = ' . $_SESSION['UseDriverID'] . ' 
				AND VehicleID = ' . $_REQUEST['item']);
			$vehicle_name=true;		
			$vid=$_REQUEST['item'];	
			break;		
		case 'services':	
			require_once ROOT . '/db/v4_SurService.class.php';	
			$db = new v4_SurService();
			# Details  red
			$dbk = $db->getKeysBy('OwnerID','asc','WHERE OwnerID = ' . $_SESSION['UseDriverID'] . ' 
				AND ServiceID = ' . $_REQUEST['item']);
			$route_name=true;				
			$vehicle_name=true;		
			$sid=$_REQUEST['item'];					
			break;
	}	
	# Details  red	
	$db->getRow($dbk[0]);
	if ($route_name && $vehicle_name) {
		require_once ROOT . '/db/v4_Services.class.php';	
		$sr = new v4_Services();
		$sr->getRow($sid);
		$rid=$sr->getRouteID();
		$vid=$sr->getVehicleTypeID();	
	}
	
	if ($route_name) {
		require_once ROOT . '/db/v4_Routes.class.php';	
		$rt = new v4_Routes();
		$rt->getRow($rid);
		$smarty->assign('routeName',$rt->getRouteName());
	}	
	if ($vehicle_name) {
		require_once ROOT . '/db/v4_VehicleTypes.class.php';	
		$vh = new v4_VehicleTypes();
		$vh->getRow($vid);
		$smarty->assign('vehicleName',$vh->getVehicleTypeName());
	}		
	if (isset($_REQUEST['submit'])) {
		foreach ($db->fieldNames() as $name) {
			$content=$db->myreal_escape_string($_REQUEST[$name]);
			if(isset($_REQUEST[$name])) {
				eval("\$db->set".$name."(\$content);");	
			}	
		}
		if (isset($_REQUEST['ID']) && $_REQUEST['ID']>0) $db->saveRow();
		else $db->saveAsNew();
	}
	
	# Details  red
	$db->getRow($dbk[0]);
	
	
	foreach($db->fieldValues() as $key=>$data)
	{
		$smarty->assign($key,$data);	
	}	
	