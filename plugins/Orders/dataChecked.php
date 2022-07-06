<?
	require_once ROOT . '/db/v4_OrderDetails.class.php';
	$d = new v4_OrderDetails();	
	$d->getRow($_REQUEST['code']);
	$d->setCustomerID($_REQUEST['checked']);
	$d->saveRow();

	echo $checked ;

