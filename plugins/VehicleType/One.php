<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once 'Initial.php';

$out = array();
# Details  red
$db->getRow($_REQUEST['ItemID']);
# get fields and values
$detailFlds = $db->fieldValues();
if (isset($_SESSION['UseDriverID']) && $_SESSION['UseDriverID']>0) $detailFlds['UseDriverID']=$_SESSION['UseDriverID'];
else $detailFlds['UseDriverID']=0;

# remove slashes 
foreach ($detailFlds as $key=>$value) {
	$detailFlds[$key] = stripslashes($value);
}
	$detailFlds["DriverVehicle"]=0;
	if (isset($_SESSION['UseDriverID']) && $_SESSION['UseDriverID']>0) {
		$result = $dbT->RunQuery("SELECT * FROM v4_Vehicles WHERE VehicleTypeID=".$_REQUEST['ItemID']." AND OwnerID=".$_SESSION['UseDriverID']); 
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$detailFlds["DriverVehicle"]=1;
			$detailFlds["SurCategory"]=$row['SurCategory'];
		}
	}	
$out[] = $detailFlds;
# send output back
$output = json_encode($out);
echo $_GET['callback'] . '(' . $output . ')';