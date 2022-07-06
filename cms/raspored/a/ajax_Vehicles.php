<?
//error_reporting(0);

session_start();

require_once '../f/db_funcs.php';
require_once '../data.php';
require_once('../lng/en_config.php');


# Init vars

//$ownerID = $_SESSION['OwnerID'];

if ( isset($_REQUEST['VehicleID']) )            $vID        = $_REQUEST['VehicleID'];
if ( isset($_REQUEST['VehicleDescription']) )   $vName      = $_REQUEST['VehicleDescription'];

if ( isset($_REQUEST['VehicleCapacity']) )      $vCap       = $_REQUEST['VehicleCapacity'];


if ( isset($_REQUEST['newVehicleDescription']) )   $vName      = $_REQUEST['newVehicleDescription'];

if ( isset($_REQUEST['newVehicleCapacity']) )      $vCap       = $_REQUEST['newVehicleCapacity'];


if ( isset($_REQUEST['Action']) )               $action     = $_REQUEST['Action'];

//echo $action . ' action';
$msg = COMPLETED;

if (($vName == '' or $vCap == '') and ($action != 'delete'))
{
        echo '<div class="alert alert-error">' . CHANGES_NOT_SAVED . '</div><br/>';
        die;
}


if ($action == 'update')
{
    
    $data = array(
            'VehicleID' => $vID,
            'VehicleDescription' => $vName,
            'VehicleCapacity'  => $vCap
            
    );
    

    
    $where = " VehicleID=".$vID;
    
    $updated = XUpdate('Vehicles', $data, $where);
    
    if ($updated) $msg = CHANGES_SAVED;
    else 
    {
        echo '<div class="alert alert-error">' . VEHICLE_NOT_UPDATED . '</div><br/>';
        die;
    }
}

if ($action == 'delete')
{
    # Delete from Vehicles
    XDelete('Vehicles','VehicleID='.$vID);

}


if ($action == 'new') 
{

   
    # Insert to Vehicles
        
    $data = array(
            'VehicleDescription' => $vName,
            'VehicleCapacity'  => $vCap
    );
    
    $vehicleID = XInsert('Vehicles',$data);

            //$msg = 'Nesto ne valja';


}

echo '<div class="alert alert-success">' . $msg . '</div><br/>';

