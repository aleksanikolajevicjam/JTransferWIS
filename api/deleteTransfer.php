<?
//header('Content-Type: text/javascript; charset=UTF-8');

error_reporting(E_PARSE);

//session_start();

# init libs
require_once '../../db/db.class.php';
require_once '../../db/v4_OrderDetails.class.php';
require_once '../../db/v4_OrderLog.class.php';

$DetailsID = $_REQUEST['DetailsID'];

$od = new v4_OrderDetails();

$od->getRow($DetailsID);


// za log
$OrderID = $od->getOrderID();

// transfer status 4 = izbrisan - deleted
$od->setTransferStatus('4');
$od->saveRow();

// spremanje u Log
$ol = new v4_OrderLog();

# init vars
$data = array();
$icon = 'fa fa-times bg-red';
$logDescription = 'Order status is now DELETED';
$logAction = 'Delete';
$logTitle = 'Order Deleted by ' . $_REQUEST['UserName'];
$showToCustomer = 0;

$ol->setOrderID($OrderID);
$ol->setDetailsID($DetailsID);
$ol->setAction($logAction);
$ol->setTitle($logTitle);
$ol->setDescription($logDescription);
$ol->setDateAdded(date("Y-m-d"));
$ol->setTimeAdded(date("H:i:s"));
$ol->setUserID($_REQUEST['AuthUserID']);
$ol->setIcon($icon);
$ol->setShowToCustomer($showToCustomer);

$ol->saveAsNew();

echo 'Deleted';
