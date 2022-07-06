<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once 'Initial.php';

@session_start();
	// niz servisa iz tabele servisa	
	$sql="SELECT CONCAT(`RouteID`,'-',`VehicleTypeID`) as code FROM `v4_Services` WHERE `OwnerID`=".$_SESSION['UseDriverID'];
	$result = $dbT->RunQuery($sql);
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$services1[]=$row['code'];
	}	
	// niz servisa iz ukrstanja tabela dvriverroutes i vehicles
	$sql="SELECT CONCAT(`RouteID`,'-',`VehicleTypeID`) as code FROM v4_DriverRoutes,v4_Vehicles where v4_DriverRoutes.OwnerID=v4_Vehicles.OwnerID	AND v4_DriverRoutes.OwnerID=".$_SESSION['UseDriverID'];
	$result = $dbT->RunQuery($sql);
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$services2[]=$row['code'];
	}	
	foreach ($services2 as $s2) {
		if (!in_array($s2,$services1)) $services3[]=$s2;
	}	
	print_r($services3);