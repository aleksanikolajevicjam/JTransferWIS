<?

	ini_set('display_errors', 1);
	ini_set('log_errors', 1);
	ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
	error_reporting(E_ALL);

    require_once ROOT . '/db/db.class.php';
    $db = new DataBaseMysql();
    $DetailsID  = $_REQUEST['DetailsID'];

	$query="SELECT `ServiceID`,`Qty` FROM `v4_OrderExtras` WHERE `OrderDetailsID`=".$_REQUEST['DetailsID'];
	$result = $db->RunQuery($query);

	$suma=0;
	while($row = $result->fetch_array(MYSQLI_ASSOC)){  
		$id=$row['ServiceID'];
		$kol=$row['Qty'];
		$query1="SELECT `ID`,`DriverPrice`,`Provision`  FROM `v4_Extras` WHERE `ID`=".$id	;
		$result1 = $db->RunQuery($query1);
		while($row1 = $result1->fetch_array(MYSQLI_ASSOC)){  
			$suma+=$row1['DriverPrice']*$kol;	
			$query4="UPDATE `v4_OrderExtras` SET 
				`DriverPrice`=".$row1['DriverPrice'].",
				`Provision`=".$row1['Provision'].",
				`DriverPriceSum`=".$row1['DriverPrice']."*`Qty`				
				where `ServiceID`=".$row1['ID'];		
			$result4 = $db->RunQuery($query4);			
		}
	}

	$query3="UPDATE `v4_OrderDetails` SET `DriverExtraCharge`=".$suma." where `DetailsID`=".$_REQUEST['DetailsID'];
	$result3 = $db->RunQuery($query3);
	
	echo $suma;


