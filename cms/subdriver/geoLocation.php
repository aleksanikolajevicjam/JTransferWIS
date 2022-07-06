<?
	session_start();
	require_once '../../db/db.class.php';
	/*$arr=(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['HTTP_X_FORWARDED_FOR'])));
	$lat2=$arr['geoplugin_latitude'];
	$lng2=$arr['geoplugin_longitude'];	*/
	if (isset($_SESSION['AuthUserID'])) $userID=$_SESSION['AuthUserID'];
	else $userID=0;	
	if (!isset($_REQUEST['lat'])) $_REQUEST['lat']=1;
	if (!isset($_REQUEST['lng'])) $_REQUEST['lng']=1;	
	$device='phone';
	
	$key='5b3ce3597851110001cf6248ec7fafd8eca44e0ca5590caf093aa7cb';
	$json = file_get_contents('https://api.openrouteservice.org/geocode/reverse?api_key='.$key.'&point.lon='.$_REQUEST['lng'].'&point.lat='.$_REQUEST['lat']);   
	$obj="";
	$obj = json_decode($json,true);	
	$distanceMIN=1000;
	$lngX=$obj['features'][0]['geometry']['coordinates'][0];
	$latX=$obj['features'][0]['geometry']['coordinates'][1];
	$label=$obj['features'][0]['properties']['label'];

	$db = new DataBaseMySql();
	$query="INSERT INTO `v4_UserLocations`( `UserID`, `Device`, `Time`, `Lat`, `Lng`, `Lat2`, `Lng2`, `label` ) 
		VALUES (
			".$userID.",
			'".$device."',			
			".time().",
			".$_REQUEST['lat'].",
			".$_REQUEST['lng'].",
			".$latX.",			
			".$lngX.",			
			'".$label."'			 
		)";
		
	$db->RunQuery($query);


