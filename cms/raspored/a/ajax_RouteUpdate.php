<?
//error_reporting(E_ALL);

session_start();

require_once '../../c/db.class.php';
require_once '../../c/tc_routes.class.php';
require_once '../../c/tc_services.class.php';
require_once('../lng/' . $_SESSION['lng'] . '_config.php');

//echo '<pre>'; print_r($_POST); echo '</pre>';

$routeID    = $_REQUEST['routeID'];
$routeKm    = $_REQUEST['routeKm'];
$routeMins  = $_REQUEST['routeMins'];
$routeActive= $_REQUEST['routeActive'];

$r = new tc_routes();
$r->getRow($routeID);

$r->setKm($routeKm);
$r->setDuration($routeMins);
$r->setApproved($routeActive);

$r->saveRow();

$s = new tc_services;
$sKeys = $s->getKeysBy('ServiceID', 'asc', ' WHERE RouteID=' . $routeID);

foreach ($sKeys as $k => $sID)
{
    $s->getRow($sID);
    $s->setServiceETA($routeMins);
    $s->saveRow();
}

echo '<div class="alert alert-success">' . ROUTE_SAVED . '</div><br/>';

