<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(0);
 
	# init libs
	require_once '../../../../db/db.class.php';
	require_once '../../../../db/v4_DriverRoutes.class.php';
	require_once '../../../../db/v4_Routes.class.php';
	require_once '../../../../db/v4_Vehicles.class.php';
	require_once '../../../../db/v4_Services.class.php';
	require_once '../../../../db/v4_AuthUsers.class.php';

	$dr = new v4_DriverRoutes();
	$r  = new v4_Routes();
	$v  = new v4_Vehicles();
	$s  = new v4_Services();
	$au = new v4_AuthUsers();

	$PlaceID = $_REQUEST['PlaceID'];
	$DriverID = $_REQUEST['DriverID'];
	
	# get AuthUser data
	$au->getRow($DriverID);
	# we only need ReturnDiscount
	$ReturnDiscount = $au->getReturnDiscount();
	# no need for this anymore
	$au->endv4_AuthUsers();

	$rKeys = $r->getKeysBy('RouteID', 'asc', ' WHERE FromID = '.$PlaceID.' OR ToID = '.$PlaceID);

	$added = 0;

	foreach ($rKeys as $nn => $id) {
		// pokupi podatke za rutu
		$r->getRow($id);
		$RouteID = $r->getRouteID();

		// vidi postoji li ruta u DriverRoutes
		$drKeys = $dr->getKeysBy('RouteID', 'asc', ' WHERE RouteID = "'.$RouteID.'" AND OwnerID="'.$DriverID.'"');
		
		// ako ne postoji, dodaj je
		if (count($drKeys) == 0) {
			$dr->setRouteID( $r->getRouteID() );
			$dr->setFromID( $r->getFromID() );
			$dr->setToID( $r->getToID() );
			$dr->setOwnerID( $DriverID );
			$dr->setRouteName( $r->getRouteName() );
			$dr->setActive('0');
			$dr->setApproved('1');
			$dr->setOneToTwo('1');
			$dr->setTwoToOne('1');
			$dr->setSurCategory('1');

			$dr->saveAsNew();
			$added += 1;
			
			# dodaj services, za svako vozilo 
			$vK = $v->getKeysBy('VehicleID', 'asc', " WHERE OwnerID = " . $_REQUEST['DriverID']);
			if(count($vK) > 0) {
				foreach($vK as $nn => $id) {
					# podaci o vozilu
					$v->getRow($id);
					
					$sKey = $s->getKeysBy('ServiceID', 'asc', 
					' WHERE RouteID = "'.$RouteID.'" 
					  AND OwnerID="'.$DriverID.'" 
					  AND VehicleTypeID="'. $v->getVehicleTypeID() .'" ');
					
					// ako ne postoji
					if(count($sKey) == 0) {
						$s->setOwnerID( $_REQUEST['DriverID'] );
						$s->setSurCategory( '1' );
						$s->setRouteID( $r->getRouteID() );
						$s->setVehicleID( $v->getVehicleID() );
						$s->setVehicleTypeID ( $v->getVehicleTypeID() );
						$s->setVehicleAvailable('1');
						$s->setActive('1');
						$s->setDiscount( $ReturnDiscount );
						$s->setLastChange( date("Y-m-d H:i:s") );
		
						$s->saveAsNew();
					}			
				}
			}

		}
		else $added = 'Routes already exist';

	}




$out = array(
	'routes' => $added
);

# send output back
$output = json_encode($out);
echo $_REQUEST['callback'] . '(' . $output . ')';	
