<?
// Select location and then list all prices for that location

require_once ROOT . '/db/db.class.php';
require_once ROOT . '/f/f.php';

$dbPlaces = new DataBaseMysql();
$queryPlaces = 'SELECT PlaceID, PlaceNameEN
			FROM v4_Places
			ORDER BY PlaceNameEN ASC';
$places = $dbPlaces->RunQuery($queryPlaces) or die(mysql_error() . ' on v4_Places');

echo '<div class="container white pad1em"><h2>' . PRICE_LIST . '</h2><br>';
?>

	<form id="prometCSV" action="index.php?p=priceList" method="post">
		<?= LOCATION ?>: 
		<select name="location">
		<?
			while($place = $places->fetch_object()) {
				echo '<option value=' . $place->PlaceID;
				if ($_REQUEST['location'] == $place->PlaceID) echo ' selected';
				echo '>';
				echo $place->PlaceNameEN;
				echo '</option>';
			}
		?>
		</select>
		<button class="btn btn-primary" type="submit" name="priceListSubmit" value="1">Go</button>
	</form>

<?
if ($_REQUEST['priceListSubmit'] == 1) {
	$locationID = $_REQUEST['location'];

	$dbRoutes = new DataBaseMysql();
	$queryRoutes = 'SELECT RouteID, RouteName, FromID, ToID
				FROM v4_Routes
				WHERE FromID = ' . $locationID . '
				OR ToID = ' . $locationID . '
				ORDER BY RouteName ASC';
	$routes = $dbRoutes->RunQuery($queryRoutes) or die(mysql_error() . ' on v4_Routes');

	echo '<br><table class="table" style="width:100%">';
	echo '<tr><th>' . ROUTE . '</th><th width="50%">';
	echo '<table width="100%"><tr><th widht="50%">' . VEHICLE_TYPE . '</th>';
	echo '<th width="25%" class="right">' . NETTO_PRICE . '</th>';
	echo '<th width="25%" class="right">' . BASE_PRICE . '</th></tr></table></th></tr>';

	while($route = $routes->fetch_object()) {
		$dbServices = new DataBaseMysql();
		$queryServices = 'SELECT OwnerID, RouteID, VehicleTypeID, ServicePrice1
							FROM v4_Services
							WHERE RouteID = ' . $route->RouteID . '
							ORDER BY VehicleTypeID ASC';
		$services = $dbServices->RunQuery($queryServices) or die(mysql_error() . ' on v4_Services');

		echo '<tr>';	
		echo '<td width="50%">' . $route->RouteName . '</td><td width="50%"><table class="table-striped" style="width:100%">';

		while($service = $services->fetch_object()) {
			$dbVehicles = new DataBaseMysql();
			$queryVehicles = 'SELECT VehicleTypeID, VehicleTypeName
								FROM v4_VehicleTypes
								WHERE VehicleTypeID = ' . $service->VehicleTypeID;
			$vehicles = $dbVehicles->RunQuery($queryVehicles) or die(mysql_error() . ' on v4_VehicleTypes');

			while ($vehicle = $vehicles->fetch_object()) {
				echo '<tr><td></td>';
				echo '<td width="50%">' . $vehicle->VehicleTypeName . '</td>';
				echo '<td width="25%" class="right">' . $service->ServicePrice1 . '</td>';
				echo '<td width="25%" class="right">' . nf(calculateBasePrice($service->ServicePrice1,$service->OwnerID)) . '</td>';
				echo '</tr>';
			}
		}
		echo '</table></td></tr>';
	}
	echo '</table>';
}
echo '</div>';

// Dodavanje dogovorene provizije na osnovnu cijenu - UZETO IZ getCars.php
function calculateBasePrice($price, $ownerid) {
	global $db;
	
		$priceR = round($price, 0, PHP_ROUND_HALF_DOWN);
	
		# Driver
		$q = "SELECT * FROM v4_AuthUsers
					WHERE AuthUserID = '" .$ownerid."' 
					";
		$w = $db->RunQuery($q);
		
		$d = mysqli_fetch_object($w);
		
		if($d->AuthUserID == $ownerid) {
		
			// STANDARD CLASS
			//if($VehicleClass < 11) {
				if ($priceR >= $d->R1Low and $priceR <= $d->R1Hi) return $price + ($price*$d->R1Percent / 100);
				else if ($priceR >= $d->R2Low and $priceR <= $d->R2Hi) return $price + ($price*$d->R2Percent / 100);
				else if ($priceR >= $d->R3Low and $priceR <= $d->R3Hi) return $price + ($price*$d->R3Percent / 100);
				else return $price;
		}
		
		return '0';	
}

