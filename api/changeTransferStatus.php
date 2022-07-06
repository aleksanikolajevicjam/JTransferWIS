<?
//header('Content-Type: text/javascript; charset=UTF-8');
session_start();

# init libs
require_once '../db/v4_OrderDetails.class.php';
require_once '../db/v4_OrdersMaster.class.php';
require_once '../db/v4_OrderLog.class.php';

// ukljuci mail funkcije
require_once '../a/informFuncs.php';

$DetailsID = $_REQUEST['DetailsID'];
$NewStatus = $_REQUEST['NewStatus'];

$od = new v4_OrderDetails();
$om = new v4_OrdersMaster();
// spremanje u Log
$ol = new v4_OrderLog();

$od->getRow($DetailsID);
$OrderID = $od->getOrderID();
$TNo = $od->getTNo();
$om->getRow($OrderID);

// transfer status 9 = izbrisan - deleted
$od->setTransferStatus($NewStatus);
$od->saveRow();

// promjena statusa u OrdersMaster
if($NewStatus == 1) {
	$om->setMOrderStatus($NewStatus);
	$om->saveRow();
	# init vars
	$data = array();
	$icon = 'fa fa-times bg-green';
	$logDescription = 'Order status is now ACTIVATED';
	$logAction = 'Active';
	$logTitle = 'Order activated by ' . $_REQUEST['UserName'];
	$showToCustomer = 1;
	$msg = TRANSFER . ' '. $OrderID.'-'.$TNo .' '.ACTIVATED;
	$msg .= '<br><br>';
	$msgEN = 'Transfer ' . $OrderID . '-' . $TNo . ' Activated<br><br>';
	//$msg .= pdfFooter('1');
	informCustomer($OrderID, $TNo, $msg);
	informDriver($OrderID, $TNo, $msgEN);	
}

if($NewStatus == 3) {
	$om->setMOrderStatus($NewStatus);
	$om->setMConfirmFile('');
	$om->saveRow();	
	# init vars
	$data = array();
	$icon = 'fa fa-check bg-red';
	$logDescription = 'Order status is now CANCELLED';
	$logAction = 'Cancel';
	$logTitle = 'Order cancelled by ' . $_REQUEST['UserName'];
	$showToCustomer = 1;
	$msg = TRANSFER . ' '. $OrderID.'-'.$TNo .' '.CANCELLED;
	$msg .= '<br><br>';
	$msgEN = 'Transfer ' . $OrderID . '-' . $TNo . ' Cancelled<br><br>';
	//$msg .= pdfFooter('1');
	informCustomer($OrderID, $TNo, $msg);
	informDriver($OrderID, $TNo, $msgEN);

}

if($NewStatus == 9) {
	$om->setMOrderStatus($NewStatus);
	$om->setMConfirmFile('');
	$om->saveRow();
	
	# init vars
	$data = array();
	$icon = 'fa fa-times bg-red';
	$logDescription = 'Order status is now DELETED';
	$logAction = 'Delete';
	$logTitle = 'Order Deleted by ' . $_REQUEST['UserName'];
	$showToCustomer = 0;

}


if($NewStatus == 5) {
	# init vars
	$data = array();
	$icon = 'fa fa-check bg-blue';
	$logDescription = 'Order status is now COMPLETED';
	$logAction = 'Update';
	$logTitle = 'Order changed by ' . $_REQUEST['UserName'];
	$showToCustomer = 0;
	
	$od->setDriverConfStatus('7');
	$od->saveRow();
	
}


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

//echo 'Deleted';

