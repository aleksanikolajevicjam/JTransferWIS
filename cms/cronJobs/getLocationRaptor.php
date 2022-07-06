<?
$root='/home/jamtrans/laravel/public/cms.jamtransfer.com';
//require_once $_SERVER['DOCUMENT_ROOT'] . '/db/db.class.php';
require_once $root . '/db/v4_AuthUsers.class.php';
require_once $root . '/db/v4_SubVehicles.class.php';

$db = new DataBaseMysql();
$au = new v4_AuthUsers();
$sv = new v4_SubVehicles();
	
	$ownerID=876;
	$time1=time()-1200;
	$time2=time()-60;	
	// dobavi sve transfere za odabrani datum za trenutnog vlasnika timetable-a
	$q = "SELECT DetailsID, SubDriver, SubDriver2, SubDriver3 FROM v4_OrderDetails WHERE DriverID = ".$ownerID." AND PickupDate = '" . date("Y-m-d") . "' AND TransferStatus < '6' AND TransferStatus != '3' AND TransferStatus != '4' AND DriverConfStatus != '3' ORDER BY DetailsID ASC";
	$r = $db->RunQuery($q);
	$subDArray = array();
	while ($t = $r->fetch_object()) {
		if ($t->SubDriver != 0) $subDArray[] = $t->SubDriver;
		if ($t->SubDriver2 != 0) $subDArray[] = $t->SubDriver2;
		if ($t->SubDriver3 != 0) $subDArray[] = $t->SubDriver3;
	}
	$subDArray = array_unique($subDArray); // ostavi samo jedinstvene subdrivere u nizu	
	date_default_timezone_set("Europe/Paris");	
	$device='raptor';
	foreach ($subDArray as $SubDriver) { 	
		// zaduzeno vozilo
		$au->getRow($SubDriver);
		$sql="SELECT `VehicleID` FROM `v4_SubActivity` WHERE `OwnerID`=".$ownerID." and `DriverID`=".$au->getAuthUserID()." and `Expense`=109 and `Approved`=1 and `Datum`<'".date('Y-m-d', time())."' Order by Datum DESC";
		$rs = $db->RunQuery($sql);			
		$vID=$rs->fetch_object();			
		$sv->getRow($vID->VehicleID);
		// izvlacenje lokacije iz Raptora
		$link='https://api.giscloud.com/rest/1/vehicles/'.$sv->getRaptorID().'/paths.json?from='.$time1.'&to='.$time2.'&api_key=4a27e4227a88de0508aa9fa2e4c57144&app_instance_id=107495';
		$json = file_get_contents($link); 
		$obj = json_decode($json,true);		
		$lng=($obj['bound']['xmin']+$obj['bound']['xmax'])/2;
		$lat=($obj['bound']['ymin']+$obj['bound']['ymax'])/2;
		if ($lng+$lat>0) {
			$key='5b3ce3597851110001cf6248ec7fafd8eca44e0ca5590caf093aa7cb';
			$json = file_get_contents('https://api.openrouteservice.org/geocode/reverse?api_key='.$key.'&point.lon='.$lng.'&point.lat='.$lat);   
			$obj="";
			$obj = json_decode($json,true);	
			$distanceMIN=1000;
			$lngX=$obj['features'][0]['geometry']['coordinates'][0];
			$latX=$obj['features'][0]['geometry']['coordinates'][1];
			$label=$obj['features'][0]['properties']['label'];
			$label=str_replace('\'','',$label);

			$query="INSERT INTO `v4_UserLocations`( `UserID`, `Device`, `Time`, `Lat`, `Lng`, `Lat2`, `Lng2`, `label` ) 
				VALUES (
					".$SubDriver.",
					'".$device."',			
					".time().",
					".$lat.",
					".$lng.",
					".$latX.",			
					".$lngX.",			
					'".$label."'			 
				)";
				
			$db->RunQuery($query);
		}
	}
