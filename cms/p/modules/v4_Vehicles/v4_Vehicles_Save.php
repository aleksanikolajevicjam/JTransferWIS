<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once '../../../../db/db.class.php';
	require_once '../../../../db/v4_Vehicles.class.php';
	require_once '../../../../db/v4_Services.class.php';
	require_once '../../../../db/v4_DriverRoutes.class.php';


	# init class
	$db = new v4_Vehicles();
	$s  = new v4_Services();
	$dr = new v4_DriverRoutes();

//echo '<pre>'; print_r($_REQUEST); echo '</pre>'; die();
# init vars
$keyName = '';
$keyValue = '';

if (isset($_REQUEST['keyName']) and $_REQUEST['keyName'] != '') 	$keyName = $_REQUEST['keyName'];
if (isset($_REQUEST['keyValue']) and $_REQUEST['keyValue'] != '') 	$keyValue = $_REQUEST['keyValue'];

$fldList = array();
$out = array();

require_once ROOT . '/cms/fixDriverID.php';
foreach($fakeDrivers as $key => $fakeDriverID) {
    if($_REQUEST['OwnerID'] == $fakeDriverID) $_REQUEST['OwnerID'] = $realDrivers[$key];    
}

# if Update - get the row by keyValue
if ($keyName != '' and $keyValue != '') $db->getRow($keyValue);


	if(isset($_REQUEST['VehicleID'])) { $db->setVehicleID($db->myreal_escape_string($_REQUEST['VehicleID']) ); } 

		 	
	if(isset($_REQUEST['OwnerID'])) { $db->setOwnerID($db->myreal_escape_string($_REQUEST['OwnerID']) ); } 

		 	
	if(isset($_REQUEST['VehicleName'])) { $db->setVehicleName($db->myreal_escape_string($_REQUEST['VehicleName']) ); } 

	 	
	if(isset($_REQUEST['VehicleTypeID'])) { $db->setVehicleTypeID($db->myreal_escape_string($_REQUEST['VehicleTypeID']) ); } 

		 	
	if(isset($_REQUEST['SurCategory'])) { $db->setSurCategory($db->myreal_escape_string($_REQUEST['SurCategory']) ); } 

		 	
	if(isset($_REQUEST['SurID'])) { $db->setSurID($db->myreal_escape_string($_REQUEST['SurID']) ); } 

		 	
	if(isset($_REQUEST['PriceKm'])) { $db->setPriceKm($db->myreal_escape_string($_REQUEST['PriceKm']) ); } 

		 	
	if(isset($_REQUEST['ReturnDiscount'])) { $db->setReturnDiscount($db->myreal_escape_string($_REQUEST['ReturnDiscount']) ); } 

		 	
	if(isset($_REQUEST['VehicleDescription'])) { $db->setVehicleDescription($db->myreal_escape_string($_REQUEST['VehicleDescription']) ); } 

		 	
	if(isset($_REQUEST['VehicleCapacity'])) { $db->setVehicleCapacity($db->myreal_escape_string($_REQUEST['VehicleCapacity']) ); 
	
	//$db->setVehicleTypeID($db->myreal_escape_string($_REQUEST['VehicleTypeID']) );
	} 

		 	
	if(isset($_REQUEST['VehicleImage'])) { $db->setVehicleImage($db->myreal_escape_string($_REQUEST['VehicleImage']) ); } 

		 	
	if(isset($_REQUEST['VehicleImage2'])) { $db->setVehicleImage2($db->myreal_escape_string($_REQUEST['VehicleImage2']) ); } 

		 	
	if(isset($_REQUEST['VehicleImage3'])) { $db->setVehicleImage3($db->myreal_escape_string($_REQUEST['VehicleImage3']) ); } 

		 	
	if(isset($_REQUEST['VehicleImage4'])) { $db->setVehicleImage4($db->myreal_escape_string($_REQUEST['VehicleImage4']) ); } 

		 	
	if(isset($_REQUEST['AirCondition'])) { $db->setAirCondition($db->myreal_escape_string($_REQUEST['AirCondition']) ); } 

		 	
	if(isset($_REQUEST['ChildSeat'])) { $db->setChildSeat($db->myreal_escape_string($_REQUEST['ChildSeat']) ); } 

		 	
	if(isset($_REQUEST['Music'])) { $db->setMusic($db->myreal_escape_string($_REQUEST['Music']) ); } 

		 	
	if(isset($_REQUEST['TV'])) { $db->setTV($db->myreal_escape_string($_REQUEST['TV']) ); } 

		 	
	if(isset($_REQUEST['GPS'])) { $db->setGPS($db->myreal_escape_string($_REQUEST['GPS']) ); } 

		 	

$upd = '';
$newID = '';

// ako je update, azuriraj trazeni slog

if ($keyName != '' and $keyValue != '') {
	$res = $db->saveRow();
	$upd = 'Updated';
	if($res !== true) $upd = $res;
	
	// sto sa Services ako se promijeni vozilo
	// nista. Neka se Driver misli o tome - cijene i ostalo
}

// inace dodaj novi slog	
if ($keyName != '' and $keyValue == '') {

	// postoji li vec isti tip vozila - JT only
	$where = " WHERE OwnerID = '" .$_REQUEST['OwnerID'] ."' AND VehicleTypeID ='".$_REQUEST['VehicleTypeID']."'";
	$dbIsNew = $db->getKeysBy('VehicleID', 'ASC', $where);
	
	// ako ne postoji, dodaj sve
	if(count($dbIsNew) == 0) {
		# newID je ID novog sloga
		$newID = $db->saveAsNew();

	
		require_once '../../../../db/v4_AuthUsers.class.php';
		$au = new v4_AuthUsers();

		# get AuthUser data
		$au->getRow($_REQUEST['OwnerID']);
		# we only need ReturnDiscount
		$ReturnDiscount = $au->getReturnDiscount();
		# no need for this anymore
		$au->endv4_AuthUsers();	
	
	
		// dodati nove Services za sve rute koje Driver vozi
		$drK = $dr->getKeysBy('RouteID', 'asc', ' WHERE OwnerID =' . $_REQUEST['OwnerID']);
	
		foreach($drK as $n => $id) {
			$dr->getRow($id);
		
			$s->setOwnerID( $_REQUEST['OwnerID'] );
			$s->setSurCategory( $_REQUEST['SurCategory'] );
			$s->setRouteID( $dr->getRouteID() );
			$s->setVehicleID( $newID );
			//$s->setVehicleTypeID ( $_REQUEST['VehicleCapacity'] );
			//$s->setVehicleCapacity ( $_REQUEST['VehicleCapacity'] );
			$s->setVehicleTypeID ( $_REQUEST['VehicleTypeID'] );
			$s->setVehicleAvailable('1');
			$s->setActive('1');
			$s->setDiscount( $ReturnDiscount );
			$s->setLastChange( date("Y-m-d H:i:s") );
		
			$s->saveAsNew();
		
		}
	}
	
}


$out = array(
	'update' => $upd,
	'insert' => $newID
);

# send output back
$output = json_encode($out);
echo $_REQUEST['callback'] . '(' . $output . ')';
	
