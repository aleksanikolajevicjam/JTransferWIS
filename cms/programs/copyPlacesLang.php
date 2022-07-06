<?
// copy place names from v4_Places to v4_Routes, v4_DriverPrices, v4_DriverRoutes

require_once ROOT.'/db/db.class.php';
require_once ROOT.'/f/f.php';

if (isset($_REQUEST["table"]) && ($_REQUEST["table"] != null)) {
	$table = $_REQUEST["table"];
	$lng = $_REQUEST["lng"];


	switch ($table) {
		case "routes": copyToRoutes($lng); break;
		case "driverRoutes": copyToDriverRoutes($lng); break;
		case "driverPrices": copyToDriverPrices($lng); break;
	}
}

function copyToRoutes ($lng) {
	$db = new DataBaseMysql();
	$var = 'PlaceName' . $lng;

	$q = "SELECT * FROM v4_Routes";
	$routes = $db->RunQuery($q);

	$total = $routes->num_rows;
	$i = 1;
	PrepareProgress();	

	while ( $route = $routes->fetch_object() ) {
		$qpf = "SELECT * FROM v4_Places WHERE PlaceID = ".$route->FromID;
		$from = $db->RunQuery($qpf);
		$pFrom = mysqli_fetch_object($from);

		$qpt = "SELECT * FROM v4_Places WHERE PlaceID = ".$route->ToID;
		$to = $db->RunQuery($qpt);
		$pTo = mysqli_fetch_object($to);

		$routeName = addslashes( $pFrom->$var ).
			' - '.addslashes( $pTo->$var );
	
		$qr  = "UPDATE v4_Routes SET RouteName".$lng." = '".$routeName.
			"' WHERE RouteID = {$route->RouteID}";
		
		echo $qr.'<br>';//$db->RunQuery($qr);
		$i++;		
	}

	echo "<br><br>COPIED places to v4_Routes - " . $lng;
}

function copyToDriverRoutes ($lng) {
	$db = new DataBaseMysql();
	$var = 'PlaceName' . $lng;

	$q = "SELECT * FROM v4_DriverRoutes";
	$dRoutes = $db->RunQuery($q);

	$total = $dRoutes->num_rows;
	$i = 1;
	PrepareProgress();	

	while ( $route = $dRoutes->fetch_object() ) {
		$qpf = "SELECT * FROM v4_Places WHERE PlaceID = ".$route->FromID;
		$from = $db->RunQuery($qpf);
		$pFrom = mysqli_fetch_object($from);

		$qpt = "SELECT * FROM v4_Places WHERE PlaceID = ".$route->ToID;
		$to = $db->RunQuery($qpt);
		$pTo = mysqli_fetch_object($to);

		$routeName = addslashes( $pFrom->$var ).
			' - '.addslashes( $pTo->$var );
	
		$qr = "UPDATE v4_DriverRoutes SET RouteName".$lng." = '".$routeName.
			"' WHERE RouteID = {$route->RouteID}";
		//$db->RunQuery($qr);
		$i++;
	}

	echo "<br><br>COPIED places to v4_DriverRoutes - " . $lng;
}

function copyToDriverPrices ($lng) {
	$db = new DataBaseMysql();
	$var = 'PlaceName' . $lng;

	$qdp = "SELECT * FROM v4_DriverPrices";
	$dPrices = $db->RunQuery($qdp);

	$total = $dPrices->num_rows;
	$i = 1;
	PrepareProgress();

	while ( $dPrice = $dPrices->fetch_object() ) {
		$qpt = "SELECT * FROM v4_Places WHERE PlaceID = ".$dPrice->TerminalID;
		$rpt = $db->RunQuery($qpt);
		$term = mysqli_fetch_object($rpt);

		$qpd = "SELECT * FROM v4_Places WHERE PlaceID = ".$dPrice->DestinationID;
		$rpd = $db->RunQuery($qpd);
		$dest = mysqli_fetch_object($rpd);

		$fromName = addslashes ( $term->$var );
		$toName = addslashes ( $dest->$var );

		$q = "UPDATE v4_DriverPrices SET FromName".$lng." = ".$fromName.", ToName".$lng." WHERE ID = ".$dPrice->ID;
		//$db->RunQuery($q);
		$i++;
	}

	echo "<br><br>COPIED places to v4_DriverPrices - " . $lng;
}
?>

<h1>Copy Places</h1>
<p>copy place names from v4_Places to v4_Routes, v4_DriverPrices, v4_DriverRoutes</p><br>

<form action="copyPlacesLang.php" type="post">
	Language:<br>
	<select name="lng">
		<option value="EN">EN</option>
		<option value="RU">RU</option>
		<option value="FR">FR</option>
		<option value="DE">DE</option>
		<option value="IT">IT</option>
	</select><br><br>

	Copy to:<br>
	<button type="submit" name="table" value="routes">v4_Routes</button>
	<button type="submit" name="table" value="driverRoutes">v4_DriverRoutes</button>
	<button type="submit" name="table" value="driverPrices">v4_DriverPrices</button>
</form>

