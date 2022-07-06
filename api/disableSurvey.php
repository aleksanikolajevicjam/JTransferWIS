<?
	error_reporting(0);
	$OrderID = $_REQUEST['OrderID'];
	$enable = $_REQUEST['enable'];

	require_once ROOT . '/db/db.class.php';
	require_once ROOT . '/db/v4_OrdersMaster.class.php';

	$om = new v4_OrdersMaster();
	$om->getRow($OrderID);

	if ($enable == 'true') {
		$status = 0;
	} else {
		$status = 2;
	}
	$om->setMSendEmail($status);
	$om->saveRow();

	echo 'MSendEmail changed';


