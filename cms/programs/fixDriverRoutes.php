<?
/*
2017-11-16 - popravi polja FromID i ToID u v4_DriverRoutes
preko polja RouteID iz v4_Routes pronadji ID lokacije iz v4_Routes
upiši ID lokacije u FromID ili ToID polje u DriverRoute -R
*/

require_once ROOT . '/db/db.class.php';
require_once ROOT . '/db/v4_Routes.class.php';
require_once ROOT . '/db/v4_DriverRoutes.class.php';

$r = new v4_Routes();
$dr = new v4_DriverRoutes();

echo "Fixing driver routes";

$drKeys = $dr->getKeysBy('ID', 'ASC', 'WHERE (FromID = 0) OR (ToID = 0)');

echo "<br>Driver routes with a missing location: " . count($drKeys) . "<br>";

for ($i = 0; $i < count($drKeys); $i++) {
	$dr->getRow($drKeys[$i]); // dohvati red kojem fali FromID ili ToID
	$r->getRow($dr->getRouteID()); // dohvati rutu koju koristi red id DriverRoutes

	// dohvati ID lokacija iz rute
	$FromID = $r->getFromID();
	$ToID = $r->getToID();

	// upisi ID lokacija u trenutni DriverRoute
	$dr->setFromID($FromID);
	$dr->setToID($ToID);
	$dr->saveRow();

	echo "<br>Changed driver route" . $drKeys[$i] . " FromID to " . $FromID . " and ToID to " . $ToID;
}
