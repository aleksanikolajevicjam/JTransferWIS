<?
header('Content-Type: text/javascript; charset=UTF-8');
@session_start();
require_once '../../db/db.class.php';
$db = new DataBaseMysql(); 

require_once '../../db/v4_AuthUsers.class.php';
$au = new v4_AuthUsers();


$id=$_REQUEST['id'];
$action=$_REQUEST['action'];
$DateFrom=$_REQUEST['dateFrom'];
$DateTo=$_REQUEST['dateTo'];

	$q  = "SELECT v4_OrderDetails.*,v4_OrderLog.DateAdded as dateadd, v4_OrderLog.Description FROM `v4_OrderLog`,v4_AuthUsers,v4_OrderDetails ";
	$q .= "WHERE v4_OrderLog.UserID=v4_AuthUsers.AuthUserID and v4_OrderDetails.DetailsID=v4_OrderLog.DetailsID and v4_OrderDetails.TransferStatus<9";
	if ($action!='ChangePrice') $q .= " AND `Action`='".$action."'";	
	else $q .= " AND v4_OrderLog.Description like '%CHANGE PRICE REASON%' ";		
	$q .= " AND v4_OrderLog.DateAdded >= '".$DateFrom."'"; 
	$q .= " AND v4_OrderLog.DateAdded <= '".$DateTo."'";
	$q .= " AND  v4_OrderLog.UserID = ".$_REQUEST['id'];
	$q .= " Order by v4_OrderLog.DateAdded DESC ";
	
	$r = $db->RunQuery($q);
	if($r->num_rows > 0 ){
		$dt="";
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


			$ttip = NL.
				ORDER_DATE.': '.$od->OrderDate.NL.
				PICKUP_DATE.': '.$od->PickupDate.NL.
				PICKUP_TIME.': '.$od->PickupTime.NL.
				FLIGHT_NO.': '.$od->FlightNo.NL.
				FLIGHT_TIME.': '.$od->FlightTime.NL.
				//FROM.': '.$row['PickupName'].NL.
				//TO.': '.$row['DropName'].NL.
				DRIVER.': '.$od->DriverName.NL.
				TRANSFER_STATUS .': '. $StatusDescription[$od->TransferStatus].NL.
				$DriverConfStatus[$od->DriverConfStatus].NL.NL;

			if ($dt != $od->dateadd) {
				$orders.="<h5 style='text-align: left;' >".$od->dateadd."</h5>";
				$dt = $od->dateadd;
			}
			if($od->UserLevelID == '2') {
				$driver.=" <i class='fa fa-user-secret'></i>";
				$au->getRow($od->AgentID);
				if ($au->getImage()<>"") {
					$driver.= "<img src='img/".$au->getImage()."'> ";	 
				}
			}
			$tn =   $driver.'<b>'.$od->OrderID . '-' .$od->TNo . '</b>';
			$orders.="<div class='row'><div style='text-align: left;' class='col-md-3'>".$driver."</div>";
			$link = "<div style='text-align: left;' class=''col-md-3'><b>
						<a href='index.php?p=editActiveTransfer&rec_no=".$od->DetailsID."' title='".$od->OrderID . "-".$od->TNo ." - ". $od->PaxName ."' 
						data-content='". $ttip ."' class='mytooltip'>" .$od->OrderID."-".$od->TNo." ". $od->PickupName." - ". $od->DropName."</a></b></div>" ;			
			$orders.=$link;		
			$orders.= "<div style='text-align: left;' class=''col-md-3'>".$od->Description."</div></div>"	;
		}	
	}

echo $orders;
?>
		<script>
			$(".mytooltip").popover({trigger:'hover', html:true, placement:'bottom'});
		</script>