<?
$root='/home/jamtrans/laravel/public/cms.jamtransfer.com';
//require_once $_SERVER['DOCUMENT_ROOT'] . '/db/db.class.php';
require_once $root . '/db/v4_AuthUsers.class.php';

$db = new DataBaseMysql();
$au = new v4_AuthUsers();
	
	$ownerID=876;
		
		// izvlacenje lokacije iz Raptora
	$link='https://api.giscloud.com/rest/1/vehicles/'.$sv->getRaptorID().'/paths.json?from='.$time1.'&to='.$time2.'&api_key=4a27e4227a88de0508aa9fa2e4c57144&app_instance_id=107495';
	$json = file_get_contents($link); 
	$obj = json_decode($json,true);	
	print_r($obj);
	//$lng=($obj['bound']['xmin']+$obj['bound']['xmax'])/2;
	//$lat=($obj['bound']['ymin']+$obj['bound']['ymax'])/2;
	/*foreach ($subDArray as $SubDriver) { 	

		$query="INSERT INTO `v4_RaptorSubDrivers`( `UserID`, `Device`, `Time`, `Lat`, `Lng`, `Lat2`, `Lng2`, `label` ) 
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
	}*/
