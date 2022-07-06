<?
session_start();

require_once '../config.php';
require_once '../data.php';
require_once '../f/db_funcs.php';

$detailsID  = $_REQUEST['DetailsID'];
$newDrvr = $_REQUEST['NewDriver'];

$r = XRecords (DB_PREFIX.'mydrivers', ' DriverID = ' . $newDrvr);

$driver = mysql_fetch_object($r);

$data = array(
    'DriverID' => $newDrvr,
    'DriverName' => $driver->DriverName
);

$where = " DetailsID = " . $detailsID;


XUpdate(DB_PREFIX . "OrderDetails", $data, $where);


//echo 'Changed ' . $newDrvr;

