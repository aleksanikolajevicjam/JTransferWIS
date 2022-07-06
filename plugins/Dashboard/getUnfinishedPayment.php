<?
	$db = new DataBaseMysql();
	$time=date("Y-m-d",time()-48*3600);
	$query="SELECT * FROM `v4_OrdersMasterTemp` WHERE `MPaymentStatus`=1 and `MOrderDate`>'".$time."' and `MPaymentMethod` in (1,3) and `MOrderKey` not in (SELECT `MCardNumber` FROM `v4_OrdersMaster` WHERE `MOrderDate`>'".$time."'  and `MPaymentMethod` in (1,3)) and `MPayNow`>0";
	//`MPaymentStatus`=1 and 
	$result = $db->RunQuery($query); 
	$payments=array();
	while($row = $result->fetch_array(MYSQLI_ASSOC)){ 
		$payments[]=$row;
	}	
	$smarty->assign('payments',$payments);		

