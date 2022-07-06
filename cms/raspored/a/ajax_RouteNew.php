<?
session_start();

error_reporting(E_ALL);

//echo '<pre>'; print_r($_REQUEST); echo '</pre>';
require_once '../config.php';


require_once('../lng/' . $_SESSION['lng'] . '_config.php');

# Require Classes
require_once '../../c/db.class.php';
require_once '../../c/tc_routes.class.php';
require_once '../../c/tc_services.class.php';
require_once '../../c/tc_vehicles.class.php';
require_once '../../c/tc_places.class.php';

# Init Classes
$r = new tc_routes();
$s = new tc_services();
$v = new tc_vehicles();
$p = new tc_places();

# Get Variables
$fromID     = $_REQUEST['fromID'];
$toID       = $_REQUEST['toID'];
$km         = $_REQUEST['newRouteKm'];
$duration   = $_REQUEST['newRouteMins'];
$active     = $_REQUEST['newRouteActive'];

$ownerID    = $_SESSION['OwnerID'];

if (empty($fromID)) {echo '<div class="alert alert-error">' .ERROR.' '.ROUTE.' '.NOT_ADDED. '</div><br/>';die;}
if (empty($toID)) {echo '<div class="alert alert-error">' .ERROR.' '.ROUTE.' '.NOT_ADDED. '</div><br/>';die;}
if (empty($km)) {echo '<div class="alert alert-error">' .ERROR.' '.ROUTE.' '.NOT_ADDED. '</div><br/>';die;}
if (empty($duration)) {echo '<div class="alert alert-error">' .ERROR.' '.ROUTE.' '.NOT_ADDED. '</div><br/>';die;}


# Get From Name
$p->getRow($fromID);
$fromName = $p->getPlaceNameEN();

# Get To Name
$p->getRow($toID);
$toName = $p->getPlaceNameEN();

# Compose a Route Name    
$routeName = $fromName . ' - ' . $toName;
    

# Check if Route exists
$rKeys = array();
$rWhere = "	WHERE (FromID  = " . $fromID . " 
				   AND ToID = " . $toID . "
				   ) 
			OR    (FromID  = " . $toID . " 
				   AND ToID = " . $fromID . "
				   )";
$rKeys = $r->getKeysBy('RouteID','asc', $rWhere);

if (count($rKeys) != 0) {
    echo '<div class="alert alert-warning">' . ROUTE_EXISTS . '</div><br/>';
    die();
}



# Add new route to Routes
$r->setRouteName($routeName);
$r->setFromID($fromID);
$r->setToID($toID);
$r->setKm($km);
$r->setDuration($duration);
$r->setApproved($active);
$r->setOwnerID($ownerID);

$r->saveAsNew();

# Get new RouteID
$rKeys = array();
$rWhere = "	WHERE (FromID  = " . $fromID . " 
				   AND ToID = " . $toID . "
				   ) 
			OR    (FromID  = " . $toID . " 
				   AND ToID = " . $fromID . "
				   )";
$rKeys = $r->getKeysBy('RouteID','asc', $rWhere);

if (count($rKeys) != 0) {
    
    $newID = $rKeys[0];
}


# Add a new Service for each Vehicle
$msg = NL;

$vKeys = $v->getKeysBy('VehicleID', 'asc', ' WHERE OwnerID=' . $ownerID);

$i=0;

foreach ($vKeys as $el => $key)
{
    
    # get price
    $price = $_REQUEST['newPrice'];
    
    # get Vehicle data
    $v->getRow($key);

    # set Services data    
    $s->setRouteID($newID);
    $s->setOwnerID($ownerID);
    $s->setVehicleID($v->getVehicleID());
    $s->setVehicleTypeID($v->getVehicleTypeID());
    $s->setServiceETA($duration);
    $s->setVehicleAvailable('1');
    $s->setServicePrice1($price[$i]);
    $s->setServicePrice2(0);
    $s->setServicePrice3(0);
    $s->setCorrection(0);
    $s->setDiscount($v->getReturnDiscount());
    $s->setActive('1');
    $s->setLastChange(date("Y-m-d h:i:s"));
    
    if ($s->saveAsNew()) $msg .= $v->getVehicleName() . ' ' . ADDED . NL;
    $i++;
}



echo '<div class="alert alert-success">' . $newID . ' ' . ROUTE_SAVED . $msg . '</div><br/>';


/* EOF */
