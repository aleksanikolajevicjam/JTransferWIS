<?
//header('Content-Type: text/javascript; charset=UTF-8');

error_reporting(E_PARSE); 

//session_start();

# init libs
require_once ROOT .'/db/db.class.php';
require_once ROOT .'/db/v4_OrderDetails.class.php';
require_once ROOT .'/db/v4_OrderLog.class.php';

// ukljuci mail funkcije
require_once ROOT .'/cms/a/informFuncs.php';

$DetailsID = $_REQUEST['DetailsID'];
$NewStatus = $_REQUEST['NewStatus'];
$FinalNote = $_REQUEST['FinalNote'];

$od = new v4_OrderDetails();

$od->getRow($DetailsID);


// za log
$OrderID = $od->getOrderID();
$TNo = $od->getTNo();

// transfer status 9 = izbrisan - deleted
$od->setTransferStatus('5');


// spremanje u Log
$ol = new v4_OrderLog();

#	var driverConfStatus = {};
#	driverConfStatus[0] = 'No driver';
#	driverConfStatus[1] = 'Not Confirmed';
#	driverConfStatus[2] = 'Confirmed';
#	driverConfStatus[3] = 'Ready';
#	driverConfStatus[4] = 'Declined';
#	driverConfStatus[5] = 'No-show';
#	driverConfStatus[6] = 'Driver error';
#	driverConfStatus[7] = 'Completed';
#	driverConfStatus[8] = 'Operator error';
#	driverConfStatus[9] = 'Dispatcher error';


if($NewStatus == 5) {
	# init vars
	$icon = 'fa fa-minus-square bg-red';
	$logDescription = 'Order status is now NO SHOW<br>'.$FinalNote;
	$logAction = 'NoShow';
	$logTitle = 'No-Show reported by ' . $_REQUEST['UserName'];
	$showToCustomer = 0;
	$od->setDriverConfStatus('5');
	$od->saveRow();
}

if($NewStatus == 6) {
	# init vars
	$icon = 'fa fa-taxi bg-red';
	$logDescription = 'Order status is now Driver Error<br>'.$FinalNote;
	$logAction = 'DriverError';
	$logTitle = 'Driver Error reported by ' . $_REQUEST['UserName'];
	$showToCustomer = 0;
	$od->setDriverConfStatus('6');
	$od->setDriversPrice(0);
	$od->setDriverPaymentAmt(0);
	$od->setDriverExtraCharge(0);
	
	$od->saveRow();
}

if($NewStatus == 8) {
	# init vars 
	$icon = 'fa fa-tasks bg-red';
	$logDescription = 'Order status is now Operator Error<br>'.$FinalNote;
	$logAction = 'OperatorError';
	$logTitle = 'Operator Error reported by ' . $_REQUEST['UserName'];
	$showToCustomer = 0;
	$od->setDriverConfStatus('8');
	$od->saveRow();
}

if($NewStatus == 9) {
	# init vars
	$icon = 'fa fa-road bg-red';
	$logDescription = 'Order status is now Dispatcher Error<br>'.$FinalNote;
	$logAction = 'DispatcherError';
	$logTitle = 'Dispatcher Error reported by ' . $_REQUEST['UserName'];
	$showToCustomer = 0;
	$od->setDriverConfStatus('9');
	$od->saveRow();
}

if($NewStatus == 10) {
	# init vars
	$icon = 'fa fa-road bg-red';
	$logDescription = 'Order status is now Agent Error<br>'.$FinalNote;
	$logAction = 'AgentError';
	$logTitle = 'Agent Error reported by ' . $_REQUEST['UserName'];
	$showToCustomer = 0;
	$od->setDriverConfStatus('10');
	$od->saveRow();
}

if($NewStatus == 11) {
	# init vars
	$icon = 'fa fa-road bg-red';
	$logDescription = 'Order status is now Force majeure<br>'.$FinalNote;
	$logAction = 'Force majeure';
	$logTitle = 'Force majeure reported by ' . $_REQUEST['UserName'];
	$showToCustomer = 0;
	$od->setDriverConfStatus('11');
	$od->saveRow();
}

if($NewStatus == 12) {
	# init vars
	$icon = 'fa fa-road bg-red';
	$logDescription = 'Order status is now Pending<br>'.$FinalNote;
	$logAction = 'Pending';
	$logTitle = 'Pending reported by ' . $_REQUEST['UserName'];
	$showToCustomer = 0;
	$od->setDriverConfStatus('12');
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
