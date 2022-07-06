<?
	if (!$isNew) require_once 'ListTemplate.php';
	require_once 'EditForm.php';
	if (isset($_REQUEST['orderid'])) $orderid=$_REQUEST['orderid']; 
	else if (!isset($orderid) ) $orderid=0; 
	$smarty->assign('ItemID','DetailsID');
	$smarty->assign('orderid',$orderid);
	
		