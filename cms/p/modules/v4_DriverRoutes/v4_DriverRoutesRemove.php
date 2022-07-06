<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once ROOT . '/db/db.class.php';
	require_once ROOT . '/db/v4_DriverRoutes.class.php';
	require_once ROOT . '/db/v4_Routes.class.php';

	$dr = new v4_DriverRoutes();
	$r  = new v4_Routes();
	$db = new DataBaseMysql();


	$PlaceID = $_REQUEST['PlaceID'];
	$DriverID = $_REQUEST['DriverID'];
	
	$deleted = 0;
	
	// sve Routes u sistemu koje imaju trazeni PlaceID, bilo kao FromID ili kao ToID
	$rKeys = $r->getKeysBy('RouteID', 'asc', ' WHERE FromID = '.$PlaceID.' OR ToID = '.$PlaceID);
	
	if(count($rKeys) > 0) {

		foreach ($rKeys as $nn => $id) {
			// pokupi podatke za rutu
			$r->getRow($id);
			$RouteID = $r->getRouteID();

			// vidi postoji li ruta u DriverRoutes
			$drKeys = $dr->getKeysBy('RouteID', 'asc', ' WHERE RouteID = "'.$RouteID.'" AND OwnerID="'.$DriverID.'"');

			 foreach($drKeys as $xx => $drID) {

				// izbrisi sve Services za tu Rutu
				$q = "DELETE FROM  v4_Services WHERE  OwnerID ='".$DriverID."' AND RouteID ='".$RouteID."'";
				$db->RunQuery($q);

				$dr->deleteRow($drID); // izbrisi rutu iz DriverRoutes
				$deleted += 1;
			}
		}

	} else { 
		$deleted = 'No Routes exist for this Location';
	}




$out = array(
	'routes' => $deleted
);

# send output back
$output = json_encode($out);
echo $_REQUEST['callback'] . '(' . $output . ')';	
