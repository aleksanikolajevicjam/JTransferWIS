<?
require_once '../db/db.class.php';	
$db = new DataBaseMysql();

	$query1="SELECT MOrderKey,DetailsID FROM `v4_OrdersMaster`,`v4_OrderDetails` WHERE MOrderID=OrderID and `DriverID`=876 and `DriverConfStatus`=1 and `TransferStatus`=1 group by OrderID";
	$result1 = $db->RunQuery($query1);
	while($row1 = $result1->fetch_array(MYSQLI_ASSOC)){ 
		echo $row1['MorderKey'].'-'.$row1['DetailsID'];
	}
