<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once '../config.php';
@session_start();
require_once '../db/v4_AuthUsers.class.php';
$au = new v4_AuthUsers();


$orders='';
$em=$_REQUEST['email'];
$oid=$_REQUEST['OrderID'];
	$q  = "SELECT v4_OrderDetails.* FROM `v4_OrdersMaster`,`v4_OrderDetails` WHERE `UserLevelID`<>2 AND `MPaxEmail`='".$em."'  and `OrderID`<>".$oid." and `MOrderID`=OrderID and v4_OrderDetails.TransferStatus not in (3,9) ORDER by `DetailsID` DESC LIMIT 5";

	$r = $db->RunQuery($q);
	if($r->num_rows > 0 ){
		while($od = $r->fetch_object() ){
			if ($od->TransferStatus == '1') $driver = '<span class="text-blue"><i class="fa fa-circle-o"></i></span> ';
			if ($od->TransferStatus == '2') $driver = '<span class="text-orange"><i class="fa fa-circle-o"></i></span> ';
			if ($od->TransferStatus == '3') $driver = '<span style="color: #c00"><i class="fa fa-times-circle"></i></span> ';
			if ($od->TransferStatus == '4') $driver = '<span class="text-orange"><i class="fa fa-question-circle"></i></span> ';
			if ($od->TransferStatus == '5') $driver = '<span class="text-green"><i class="fa fa-check-circle"></i></span> ';

			if ($od->DriverConfStatus == '0') $driver .= '<span style="color:#c00"><i class="fa fa-car"></i></span> ';
			if ($od->DriverConfStatus == '1') $driver .= '<span class="text-orange"><i class="fa fa-info-circle"></i></span> ';
			if ($od->DriverConfStatus == '2') $driver .= '<span class="text-blue"><i class="fa fa-thumbs-up"></i></span> ';
			if ($od->DriverConfStatus == '3') $driver .= '<span class="text-blue"><i class="fa fa-car"></i></span> ';
			if ($od->DriverConfStatus == '4') $driver .= '<span style="color:#c00"><i class="fa fa-thumbs-down"></i></span> ';
			if ($od->DriverConfStatus == '5') $driver .= '<span style="color:#c00"><i class="fa fa-user-times"></i></span> ';
			if ($od->DriverConfStatus == '6') $driver .= '<span style="color:#c00"><i class="fa fa-black-tie"></i></span> ';
			if ($od->DriverConfStatus == '7') $driver .= '<span class="text-green"><i class="fa fa-check-square"></i></span> ';	
			require_once '../lng/en_text.php';			
			global $StatusDescription;

			$au->getRow($od->SubDriver);
			$ttip = 
				$od->PickupName." - ". $od->DropName.NL.
				//ORDER_DATE.': '.$od->OrderDate.NL.
				PICKUP_DATE.': '.$od->PickupDate.NL.
				PICKUP_TIME.': '.$od->PickupTime.NL.
				FLIGHT_NO.': '.$od->FlightNo.NL.
				FLIGHT_TIME.': '.$od->FlightTime.NL.
				//FROM.': '.$row['PickupName'].NL.
				//TO.': '.$row['DropName'].NL.
				DRIVER.': '.$od->DriverName.NL.
				'SubDriver: '.$au->getAuthUserRealName().NL.
				//TRANSFER_STATUS .': '. $StatusDescription[$od->TransferStatus].NL.
				$DriverConfStatus[$od->DriverConfStatus].NL.NL;

			$orders.= "<b>
			<a href='index.php?p=editActiveTransfer&rec_no=".$od->DetailsID."' data-content='". $ttip ."' class='mytooltip'>
			".$driver .$od->OrderID."-".$od->TNo."
			</a></b>";
		}	
	}
if 	($orders!='') {



	?><script>$(".mytooltip").popover({trigger:'hover', html:true, placement:'bottom'});</script><?	
}	
echo $orders;
?>

