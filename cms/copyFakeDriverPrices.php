<div class="container">
<?
//error_reporting(E_ALL);


if(isset($_REQUEST['DoIt'])) {

	define("NL", '<br>');

	require_once ROOT . '/db/db.class.php';
	require_once ROOT . '/f/f.php';
	
	require_once ROOT . '/db/v4_DriverRoutes.class.php';
	require_once ROOT . '/db/v4_Services.class.php';
		
	$db = new DataBaseMysql();
	$dr = new v4_DriverRoutes();
	$s  = new v4_Services();
	
	$FakeDriverID = '521';
	
	// parametri iz requesta
	$DriverID = $_REQUEST['DriverID'];
	$DriverVehicleType = $_REQUEST['DriverVehicleType'];
	$FakeDriverVehicleType = $_REQUEST['FakeDriverVehicleType'];
	$dateTime = date("YmdHis");
	$db->RunQuery("	CREATE TABLE SB{$dateTime}
					SELECT * FROM v4_Services WHERE (OwnerID = '521' OR OwnerID = '".$DriverID."')");
	
	echo '<h3>Replacing Driver Prices with Fake Driver Prices</h3><br>';
	
	// array RouteID koje vozac ima prijavljene
	$drKeys = $dr->getKeysBy('ID', 'ASC', " WHERE OwnerID = '{$DriverID}'");
	
	if(count($drKeys) > 0) {
		$i = 0;

		foreach($drKeys as $nn => $ID) {
			
			
			$dr->getRow($ID);
			$RouteID = $dr->getRouteID();
			
			$replaced = ' <span class="red-text">NOT replaced</span>';
			// fake driver Services
			// trebao bi biti samo jedan ServiceID !
			$sWhere = " WHERE OwnerID = '{$FakeDriverID}' 
						AND RouteID = '{$RouteID}' 
						AND VehicleTypeID = '{$FakeDriverVehicleType}'
					  ";			
			$sKeys = $s->getKeysBy('ServiceID', 'ASC', $sWhere);
			
			if(count($sKeys) == 1) {
						
				// ServiceID fake drivera
				$s->getRow($sKeys[0]);
				$price = $s->getServicePrice1();			
		
				// izbrisati Service pravog drivera, jer na njegovo mjesto 
				// dolazi Service od fake drivera
				$dWhere = " WHERE OwnerID = '{$DriverID}' 
							AND RouteID = '{$RouteID}' 
							AND VehicleTypeID = '{$DriverVehicleType}'
						  ";			
				$q = "UPDATE v4_Services SET ServicePrice1 = '{$price}' " . $dWhere;
				$w = $db->RunQuery($q);
			

				if($w) {
					$replaced = ' replaced';				

					echo 'ServiceID: ' . $s->getServiceID() . NL;
					echo 'Price: ' . nf($s->getServicePrice1()) . NL;
					//echo 'DriverID: ' . $s->getOwnerID() ;
					echo 'DriverID: ' .$DriverID . NL;
					//echo 'Fake Driver Vehicle Type: ' . $s->getVehicleTypeID() . ' replaced with ';
					echo 'Vehicle Type: ' . $DriverVehicleType . NL;
					echo 'Fake Driver Service removed.'.NL;
			
					// zamijeni FakeDriverID sa pravim driverom (polje OwnerID)
					$s->deleteRow($sKeys[0]);

					$i++;
				}

				echo '<strong>' . $dr->getRouteName() . '</strong>'. $replaced .NL;
				echo '<hr/>';
			}
			
		} // end foreach drKeys
		echo '<strong>' . $i . ' found and replaced.</strong>'.NL.NL.NL;
		
	} // endif count
} // DoIt
else {
	
?>	
	<form name="fakeDriver" action="index.php?p=fakeDriver" method="post" onsubmit="return confirm('No UNDO possible!\nAre you ABSOLUTELLY SURE?');">
	<p>
		Postupak:<br>
		Najprije sredi vozača - njegova vozila i rute.<br>
		Zapiši njegov ID i tipove vozila.<br>
		Tek nakon toga može ovo!<br><br>
		U slučaju greške ne radi dalje apsolutno ništa, nego mi javi.<br>
		Obavezno pošalji ID vozača, Fake driver vehicle type i Driver's vehicle type.<br>
		Nakon toga čekaj daljnje instrukcije.<br>
		<br>
	</p>
		<label for="DriverID">Driver ID</label>
		<input type="text" name="DriverID" class="form-control">
		<label for="FakeDriverVehicleType">Fake Driver Vehicle Type</label>
		<input type="text" name="FakeDriverVehicleType" class="form-control">
		<label for="DriverVehicleType">Driver's Vehicle Type</label>
		<input type="text" name="DriverVehicleType" class="form-control">
		<br><br>
		<button type="submit" name="DoIt" class="btn btn-danger">Replace All Prices</button> 
	</form>	
	
<? } // end else DoIt?>	
</div>	
