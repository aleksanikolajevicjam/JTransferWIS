<?
//error_reporting(E_ALL);

session_start();
require_once('../lng/' . $_SESSION['lng'] . '_config.php');

require_once '../../c/db.class.php';
require_once '../../c/tc_routes.class.php';
require_once '../../c/tc_services.class.php';



//echo '<pre>'; print_r($_POST); echo '</pre>';

$routeID    = $_REQUEST['routeID'];

$r = new tc_routes();
$r->getRow($routeID);

$s = new tc_services();
$sk = $s->getKeysBy('RouteID','asc', ' WHERE RouteID=' . $routeID . ' AND OwnerID=' . $_SESSION['OwnerID']);

foreach ($sk as $el => $key)
{
    # code...
    $s->deleteRow($key);
}


$r->deleteRow($routeID);

echo '<div class="alert alert-success">' . ROUTE_DELETED . '</div><br/>';
