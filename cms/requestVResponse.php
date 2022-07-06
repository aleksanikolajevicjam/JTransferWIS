<?

	ini_set('display_errors', 1);
	ini_set('log_errors', 1);
	ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
	error_reporting(E_ALL);
	require_once 'headerScripts.php';

	require_once '../db/db.class.php';	
	require_once '../db/v4_OrderDetails.class.php';
	require_once '../db/v4_OrdersMaster.class.php';	
	require_once '../db/v4_OrderExtras.class.php';
	require_once '../db/v4_VehicleTypes.class.php';
	require_once '../common/libs/Smarty.class.php'; 
	require_once 'headerScripts.php';

	
	
$smarty = new Smarty;

$db = new DataBaseMysql(); 
$od = new v4_OrderDetails();
$om = new v4_OrdersMaster();
$oe = new v4_OrderExtras();
$vt = new v4_VehicleTypes();


	$check_query_p="SELECT count(*) as broj FROM `v4_VoutcherOrderRequests` WHERE OrderKey='".$_REQUEST['key']."' AND ConfirmDecline=0"; 
	$result_check_p = $db->RunQuery($check_query_p);
	$row_check_p=$result_check_p->fetch_array(MYSQLI_ASSOC);
	/*if ($row_check_p['broj']==1) {
		?>	
			<link type="text/css" href="/cms/css/request.css" rel="stylesheet">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
				<title><?= $subject?></title>
				<script type="text/javascript">
				</script>
			</head>
			<body>
				<div id="print-this">
					<div id="print-this-whole" class="container">
						<div class="logo_gost_poruka" style="height:210px;">
							<img src='https://www.jamtransfer.com/cms/img/jam.png'>  			  	  	
						</div>		
						<div class="border_blue" style="border: 0px solid #000;">
							<b style="font-size:150%">Request for payment voucher is expired or not valid. <br>Contact us via info@jamtransfer.com. 	
						</div>
					</div>	
				</div>	
			</body>	

		<? 
		exit();
	}*/
	
	
	$_REQUEST['Price']=0;
	$check_query="SELECT count(*) as broj FROM `v4_VoutcherOrderRequests` WHERE OrderKey='".$_REQUEST['key']."' AND ConfirmDecline>0"; 
	$result_check = $db->RunQuery($check_query);
	$row_check=$result_check->fetch_array(MYSQLI_ASSOC);
	if ($row_check['broj']==0) {
		$upd_query="UPDATE `v4_VoutcherOrderRequests` SET `ResponseDate`=NOW(),`ResponseTime`=NOW(),`ConfirmDecline`=".$_REQUEST['cd']." WHERE `OrderKey`='".$_REQUEST['key']."'";
		$result_upd = $db->RunQuery($upd_query);
		$first=true;
	}
	else $first=false;
	
	
	$style1=	"color:red; font-size:120%; padding:2px";
	$style2=	"font-size:120%";
	$style3=	"color:blue; font-size:120%";
		
	$html="<div style='margin:50px'>";
	$html.="<img src='https://www.jamtransfer.com/cms/img/jam.png'><br><br>";
	$query="SELECT * FROM `v4_VoutcherOrderRequests` WHERE OrderKey='".$_REQUEST['key']."'";
	$result = $db->RunQuery($query);
	while($row = $result->fetch_array(MYSQLI_ASSOC)){ 
		$out_arr=$row;
		$OrderID=$row['OrderID'];		
		$requestDate=$row['RequestDate'];
		$responseDate=$row['ResponseDate'];
		$responseTime=$row['ResponseTime'];
		$voucherValue=$row['VoutcherValue'];
		$orderKey=$row['OrderKey'];
		$first_time=$row['ResponseTime'];
		$first_date=$row['ResponseDate'];	
		$ConfirmDecline=$row['ConfirmDecline'];	
		
		$subject="Request For Voucher";
		$om->getRow($OrderID);
		$fullname=$om->getMPaxFirstName()." ".$om->getMPaxLastName();
		$oKeyC = $od->getKeysBy('OrderID', 'ASC', ' WHERE OrderID = ' .$OrderID);
		if (count($oKeyC)==2) $return=1;
		else $return=0;
		$oKey = $od->getKeysBy('TNo', 'ASC', ' WHERE OrderID = ' .$row['OrderID']);
		$od->getRow($oKey[0]);



		$route=$od->getPickupName()." - ".$od->getDropName();
		$pickupname=$od->getPickupName();
		$dropname=$od->getDropName();
		if ($return==1) $route.="/ <b>both directions</b>";
		$pickuptime=$od->getPickupDate()." / ". $od->getPickupTime();
		$paxno=$od->getPaxNo();
		$vt->getRow($od->getVehicleType());
		$price=$od->getPayNow()*($return+1);
		
		switch ($od->getPaymentMethod()) {
			case 1:
				$pm="Online";
				break;
			case 2:
				$pm="Cash";
				break;
			case 3:
				$pm="Online+Cash";
				break;
			default:
				$pm="Invoice";
				break;		
		}		
		
		$ok = $oe->getKeysBy('ID', 'ASC', " WHERE OrderDetailsID = " . $od->getDetailsID());

		$extras_all=array();
		if( count($ok) > 0) {
			foreach ($ok as $id) {
				$extras_arr=array();
				$oe->getRow($id);
				$extras_arr = array_merge($extras_arr, array("ServiceName" => $oe->getServiceName()),array("Qty" => $oe->getQty()));
				$extras_all[]=$extras_arr;
			}	
		}	 
		
		if ($return==1) {
			$html.="<h4>FIRST TRANSFER</h4>";		
		}	
		$html.="
		<table>
			<tr><td style='".$style1."'>	From:				</td><td style='".$style2."'> ".$od->getPickupName()."</td></tr>
			<tr><td style='".$style1."'>	Pickup Address:		</td><td style='".$style2."'> ".$od->getPickupAddress()."</td></tr> 
			<tr><td style='".$style1."'>	To:					</td><td style='".$style2."'> ".$od->getDropName()."</td></tr>
			<tr><td style='".$style1."'>	Drop-Off Address:	</td><td style='".$style2."'> ".$od->getDropAddress()."</td></tr>
			<tr><td style='".$style1."'>	Pickup date:		</td><td style='".$style2."'> ".$od->getPickupDate()." (Y-M-D)</td></tr>
			<tr><td style='".$style1."'>	Pickup time:		</td><td style='".$style2."'> ".$od->getPickupTime()." (H:M 24h)</td></tr>
			<tr><td style='".$style1."'>	Flight number:		</td><td style='".$style2."'> ".$od->getFlightNo()."</td></tr>
			<tr><td style='".$style1."'>	Flight time:		</td><td style='".$style2."'> ".$od->getFlightTime()."</td></tr>
		</table><br>
		";
		$lblPrice="Paid";		
		if ($return==1) {
			$html.="<h4>RETURN TRANSFER</h4>";
			$od->getRow($oKey[1]);	
			$html.="<table>
				<tr><td style='".$style1."'>	Pickup date:		</td><td style='".$style2."'> ".$od->getPickupDate()." (Y-M-D)</td></tr>
				<tr><td style='".$style1."'>	Pickup time:		</td><td style='".$style2."'> ".$od->getPickupTime()." (H:M 24h)</td></tr>
			</table><br>
			";		
			$returntime=$od->getPickupDate()." / ". $od->getPickupTime();	
			$od->getRow($oKey[0]);	
			$lblPrice.=" (both directions)";
		}
		else $returntime=0; 
		
		$html.="
		<table>
			<tr><td style='".$style1."'>	Passengers:			</td><td style='".$style2."'>".$paxno."</td></tr>
			<tr><td style='".$style1."'>	Vehicle Type:		</td><td style='".$style2."'>".$vt->getVehicleTypeName()."</td></tr>
		</table><br>";
		
		$ok = $oe->getKeysBy('ID', 'ASC', " WHERE OrderDetailsID = " . $od->getDetailsID());
		if( count($ok) > 0) {
		$html.="<h4>EXTRAS</h4>";			
		$html.="
		<table>";			
			foreach ($ok as $id) {
				$oe->getRow($id);
				$html.="
				<tr><td style='".$style1."'>	".$oe->getServiceName().":	</td><td style='".$style2."'>".$oe->getQty()."</td></tr>";
			}	
		$html.="
		</table><br>";			
		}	
		$html.="
		<table>
			<tr><td style='".$style1."'>	".$lblPrice.":		</td><td style='".$style2."'>".number_format ($price,2)." EUR</td></tr>
			<tr><td style='".$style1."'>	Payment Method:		</td><td style='".$style2."'>".$pm."</td></tr> 
		</table><br>
		";
	
		$html.="<p style='".$style3."'>THANK YOU FOR CONFIRMING AVAILABILITY FOR THIS TRANSFER!</p>";
		$html.="<p style='".$style1."'>This is just information to Jam Transfer that you have available vehicle and the price is suitable for you. If client confirms it, you will get an email with new transfer.</p>";

	}
	if ($_REQUEST['cd']==2) {

		$html.="<p style='".$style3."'>You decline request for transfer. <br>THANK YOU FOR YOUR RESPONSE!</p>";
	}
	$html.="</div>";
	
	//echo $html;
?>	
	
<link type="text/css" href="/cms/css/request.css" rel="stylesheet">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<title><?= $subject?></title>
	<script type="text/javascript">
	</script>
</head>
<body>
	<div id="print-this">
		<div id="print-this-whole" class="container">
			<div class="logo_gost_poruka" style="height:210px;">
				<img src='https://www.jamtransfer.com/cms/img/jam.png'>
	  			  			  	  	
			</div>
			<div class="potvrda_podatci" style="height:auto;">
				<span id="potvrda_br"><?= $subject?> <br>N° <?= $_REQUEST['key']?> - <?= $requestDate?></span>
				<span id="datum_potvrde"><strong>Response at <?= $responseDate?> <?= $responseTime?></strong></span>
				<span id="gost_podaci"></span>	
			</div> 
			<div class="row" style="clear:both;">
				<div class="mini_naslov">
					<h2 style="border:none">Transfer reservation details</h2>	
				</div>
				
				<div class="col-md-5">   	
					<span class="info_icon"></span>	
					<hr class="siva">				
					<div id="ponuda-unos">
						<div  class="border_blue" style="border: 0px solid #000;">
							<strong> Vaucher: </strong> 
							<div class="znak_eura"><? echo $orderKey; ?> </div>
						</div>  
						<div class="border_blue" style="border: 1px solid #000;">
							<div class="box_cijena_ponuda"> Value: </div> 
							<div class="znak_eura"> <?=number_format ($voucherValue,2) ?> </div>
							<div class="znak_eura"> € </div>
						</div>
						
						<? if ($first) {?>							
							<? if ($ConfirmDecline==1) { ?>	
								<? if ($first) { ?>	
									<div class="border_blue" style="border: 0px solid #000;">
										<b>This is information to Jam Transfer that you have accept compesation payment voucher. </b>
										
									</div>
								<? } ?>
							<? } ?>
		
							<div class="border_blue" style="border: 0px solid #000;">
							<? if ($ConfirmDecline==1) { ?>	
								<? if ($first) { 
									$PDFfile = 	'/cms/pdfvoutcher/'.$orderKey.'-'.$OrderID.'.pdf';
								?>	 
									<span style='font-size:150%'>You can view and download this <a target='_blank' href='<?=$PDFfile ?>'>voucher</a>.</span> 
								<? } ?>
							<? } else {?>	
								<span style='font-size:150%'>You decided to wait for a refund, according <a href="https://jamtransfer.com/terms" target="_blank">T&amp;C, CANCELATION section.</a></span>
							<? } ?> 
							</div>
						<? } else {?> 
							<? if ($ConfirmDecline==1) { ?>	
								<div class="border_blue" style="border: 0px solid #000;">
									<b style='color:red'>Sorry, this request is already confirmed at <?=$first_date ?>  <?=$first_time ?></b>
								</div>
							<? } else {?>
								<div class="border_blue" style="border: 0px solid #000;">
									<b style='color:red'>Sorry, this request is already declined at <?=$first_date ?>  <?=$first_time ?></b>
								</div>								
							<? } ?>								
						<? } ?> 
						
					</div>	  	
				</div>				
				
				
				<div class="col-md-7">   	  	
					<span class="info_icon"></span>	
					<strong class="table-legend-istaknuto">Info: </strong>
					<hr class="siva">
					<!-- info o transferu -->
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tbody>
							<tr>
							  <td valign="top" width="200px;"><strong>Passenger:</strong> </td>
							  <td><span style='font-size:150%'><?=$fullname ?></span></td>
							</tr>	
							<tr>
							  <td valign="top" width="200px;"><strong>Paid online:</strong> </td>
							  <td><?=$om->getMPayNow() ?></td>
							</tr>							
							<tr>
							  <td valign="top" width="200px;"><strong>Transfer route:</strong> </td>
							  <td><?=$od->getPickupAddress()?>, <?=$od->getPickupName()?> » <?=$od->getDropAddress()?>, <?=$od->getDropName()?></td>
							</tr>
							<tr>
							  <td valign="top"><strong>Number of vehicles:</strong> </td>
							  <td><?=$od->getVehiclesNo()?></td>
							</tr>
							<tr>
							  <td valign="top"><strong>Vehicle:</strong> </td>
							  <td><?=$vt->getVehicleTypeName()?></td>
							</tr> 
							<tr>
							  <td valign="top"><strong>Persons:</strong> </td>
							  <td><?=$od->getPaxNo()?></td>
							</tr>     
						 </tbody>
					</table>
					<!-- polazak -->
					<div style="margin-top:20px; height:auto; display:inline-block; width:100%">	 		 
						<span class="way_icon_one"></span>	
						<strong class="table-legend-istaknuto"> Departure:  </strong>
						<hr class="siva">					
					   <table width="100%" border="0" cellpadding="0" cellspacing="0">
						  <tbody>
						  <tr>
							  <td valign="top" width="200px;"><strong>Date and time of service:</strong> </td>
							  <td><?=$od->getPickupDate()?> <?=$od->getPickupTime()?></td>
						  </tr>
						  <tr>
							  <td valign="top"><strong>Start address: </strong> </td>
							  <td><?=$od->getPickupAddress()?></td>
						  </tr>
						  <tr>
							  <td valign="top"><strong>Flight No: </strong> </td>
							  <td><?=$od->getFlightNo()?></td>
						  </tr>		 
						  <tr>
							  <td valign="top"><strong>Flight Time: </strong> </td>
							  <td><?=$od->getFlightTime()?></td>
						  </tr>		  
						  </tbody>
						</table>
					</div>         
					<? if ($return==1) {
						$od->getRow($oKey[1]);		
						?>
						<!-- povratak -->
						<div style="margin-top:40px; height:auto; display:inline-block; clear: both; width:100%">	
							<span class="way_icon_one"></span>	
							<strong class="table-legend-istaknuto"> Return:  </strong>
							<hr class="siva">					
						   <table width="100%" border="0" cellpadding="0" cellspacing="0">
							  <tbody>
							  <tr>
								  <td valign="top" width="200px;"><strong>Date and time of service:</strong> </td>
								  <td><?=$od->getPickupDate()?> <?=$od->getPickupTime()?></td>
							  </tr>
							  <tr>
								  <td valign="top"><strong>Start address: </strong> </td>
								  <td><?=$od->getPickupAddress()?></td>
							  </tr>
							  <tr>
								  <td valign="top"><strong>Flight No: </strong> </td>
								  <td><?=$od->getFlightNo()?></td>
							  </tr>		 
							  <tr>
								  <td valign="top"><strong>Flight Time: </strong> </td>
								  <td><?=$od->getFlightTime()?></td>
							  </tr>		  
							  </tbody>
							</table>
						</div>		
						<?
						$od->getRow($oKey[0]);	
					}
					?> 
					<?	if( count($ok) > 0) {		
						?>	
						 <!-- extras -->
						<div style="margin-top:40px; height:auto; display:inline-block; clear: both; width:100%">	
							<span class="way_icon_one"></span>	
							<strong class="table-legend-istaknuto"> Extras:  </strong>
							<hr class="siva">					
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
							  <tbody>
							  <?
							  foreach ($ok as $id) {
								  $oe->getRow($id);
								  ?>
								  <tr>
									  <td valign="top" width="200px;"><strong><?=$oe->getServiceName()?>:</strong> </td>
									  <td><?=$oe->getQty()?> </td>
								  </tr>
								  <?
							  }
							  ?>			
							  </tbody>
							</table>		
						</div>					
						<?
					}	
					?>					
				</div>  <!-- detalji_lijevi_box END -->	


				<div class="podnozje_partner">
					<hr style="padding: 5px 0;">
					THANK YOU FOR YOUR RESPONSE!
				</div>
			</div>	
		</div>
	</div>
	<div class="ui-resizable-handle ui-resizable-n"></div>
	<div class="ui-resizable-handle ui-resizable-e"></div>
	<div class="ui-resizable-handle ui-resizable-s"></div>
	<div class="ui-resizable-handle ui-resizable-w"></div>
	<div class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se ui-icon-grip-diagonal-se" style="z-index: 1001;"></div>
	<div class="ui-resizable-handle ui-resizable-sw" style="z-index: 1002;"></div>
	<div class="ui-resizable-handle ui-resizable-ne" style="z-index: 1003;"></div>
	<div class="ui-resizable-handle ui-resizable-nw" style="z-index: 1004;"></div>
</body>
</html>	

