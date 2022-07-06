<? 
switch ($activePage) {
	case 'driverRoutes':
		require_once ROOT . '/db/v4_Routes.class.php';
		$db = new v4_Routes();
		$db->getRow($item);
		$routes_arr=$db->fieldValues();
		require_once ROOT . '/db/v4_DriverRoutes.class.php';
		$dbC = new v4_DriverRoutes();
		$driverroutes_arr=$dbC->fieldValues();
		foreach ($driverroutes_arr as $key=>$dr) {
			if (array_key_exists($key, $routes_arr)) {
				eval  ("\$dbC->set".$key."('$routes_arr[$key]');");
			}	
		}		
		$dbC->setActive(1);
		$dbC->setOneToTwo(1);
		$dbC->setTwoToOne(1);
		$dbC->setSurCategory(1);
		$dbC->setOwnerID($_SESSION['UseDriverID']);
		$insertID=$dbC->saveAsNew();
	default:
}
header('Location: '.ROOT_HOME.'/'.$activePage.'/'.$insertID);
exit();
