<?
//header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(0);

require_once '../../../../db/db.class.php';
require_once '../../../../db/v4_DriverRoutes.class.php';
require_once '../../../../db/v4_AuthUsers.class.php';
require_once '../../../../db/v4_Vehicles.class.php';
require_once '../../../../db/v4_Services.class.php';
require_once '../../../../db/v4_Routes.class.php';
require_once '../../../../db/v4_Places.class.php';

$dr = new v4_DriverRoutes();
$v  = new v4_Vehicles();
$s  = new v4_Services();
$r  = new v4_Routes();
$au = new v4_AuthUsers();
$pl = new v4_Places();

$DriverID 		= $_REQUEST['DriverID'];
$PlaceFromID 	= $_REQUEST['PlaceFromID'];
$PlaceToID 		= $_REQUEST['PlaceToID'];

$msg = "Adding Driver Routes";

# get AuthUser data
$au->getRow($DriverID);
# we only need ReturnDiscount
$ReturnDiscount = $au->getReturnDiscount();
# no need for this anymore
$au->endv4_AuthUsers();

// vidi postoji li ruta
$rKeys = $r->getKeysBy('RouteID', 'ASC', 'WHERE ((FromID = ' . $PlaceFromID . ' AND ToID = ' . $PlaceToID . ') OR (ToID = ' . $PlaceFromID . ' AND FromID = ' . $PlaceToID . '))');

$noRoutes = count($rKeys); // 0-nema ruta, 2-jedna ruta viska, >2-greska
$addDR = false;

// ako nema rute, dodaj novu rutu u v4_Routes i pripremi za dodavanje Driver Route
if ($noRoutes == 0) {
	$pl->getRow($PlaceFromID);
	$name = $pl->PlaceNameEN . ' - ';
	$pl->getRow($PlaceToID);
	$name .= $pl->PlaceNameEN;

	// $r->setOwnerID($DriverID);
	// $r->setApproved(1);
	$r->setFromID($PlaceFromID);
	$r->setToID($PlaceToID);
	$r->setRouteNameEn($name);
	$r->setRouteName($name); // visak
	$newRouteID = $r->saveAsNew();

	$addDR = true;
	$msg = "Driver Route added from a new Route";
}

// ako postoji ruta, vidi postoji li u DriverRoutes
else if ($noRoutes == 1) {
	$r->getRow($rKeys[0]);
	$newRouteID = $r->getRouteID();
	$drKeys = $dr->getKeysBy('RouteID', 'ASC', ' WHERE RouteID = "'.$RouteID.'" AND OwnerID="'.$DriverID.'"');
	if (count($drKeys) == 0) { $addDR = true; $msg = "Driver Route added from Routes"; }
	else { $msg = "Route already exists as Driver Route"; }
}

else $msg = "Error: Too many routes for places FromID=".$PlaceFromID." ToID=".$PlaceToID;

// ako je spremno, dodaj rutu u driver routes
if ($addDR) {
	$dr->setRouteID( $newRouteID );
	$dr->setFromID( $PlaceFromID ); // 2017-11-16 promjenjeno od r->getFromID() -R
	$dr->setToID( $PlaceToID ); // 2017-11-16 promjenjeno od r->getToID() -R
	$dr->setOwnerID( $DriverID );
	$dr->setRouteName( $r->getRouteName() );
	$dr->setActive('0');
	$dr->setApproved('1');
	$dr->setOneToTwo('1');
	$dr->setTwoToOne('1');
	$dr->setSurCategory('1');
	$dr->saveAsNew();

	# dodaj services, za svako vozilo 
	$vK = $v->getKeysBy('VehicleID', 'ASC', " WHERE OwnerID = " . $DriverID);
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
				$s->setOwnerID( $DriverID );
				$s->setSurCategory( '1' );
				$s->setRouteID( $newRouteID );
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

// send output back
echo $msg;

