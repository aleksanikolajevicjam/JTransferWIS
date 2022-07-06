<meta http-equiv="refresh" content="300"/>
<?
// Timetable sa prikazom transfera po vozacima za odabrani datum
// za svakog vozaca za odabran datum su izlistani transferi u stupcima (poput kalendarskog prikaza na dashboardu)
// POSTUPAK:
// - dobavi sve transfere za odabrani datum
// - dobavi sve vozace koji su vec postavljeni za te transfere (ovo bi moglo biti bez rezultata)
// - za svakog vozaca za odabrani datum ponovno dobavi (samo njegove) transfere
// - vozace izlistati u stupcima, njihove transfere u redovima unutar stupaca -
session_start();
$DateFrom	= $_POST["DateFrom"];
$DateTo		= $_POST["DateTo"];
$NoColumns	= $_POST["NoColumns"];

if (!isset($DateFrom)) $DateFrom = date("Y-m-d");
if (!isset($DateTo)) $DateTo = date("Y-m-d");
if (!isset($NoColumns)) $NoColumns = 3;

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_AuthUsers.class.php';
$au = new v4_AuthUsers();

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/db.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_OrdersMaster.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_OrderDetails.class.php';	
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_OrderExtras.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_Places.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_Routes.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_OrderLog.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_SubActivity.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_SubVehicles.class.php';


$db = new DataBaseMysql();
$om = new v4_OrdersMaster();
$od = new v4_OrderDetails();
$d2 = new v4_OrderDetails();
$oe = new v4_OrderExtras();
$op = new v4_Places();
$or = new v4_Routes();
$ol = new v4_OrderLog();
$sa = new v4_SubActivity();
$sv = new v4_SubVehicles();


$BsColumnWidth = 12 / $NoColumns;

# Pretvaranje formata datuma
function YMD_to_DMY ($date) {
	$elementi = explode ('-', $date);
	$new_date = $elementi[2] . '.' . $elementi[1] . '.' . $elementi[0];
	return $new_date;
}

function getOtherTransferID ($DetailsID) {
	$otherDetailsID = null;
	$d1 = new v4_OrderDetails();
	$d2 = new v4_OrderDetails();
	$d1->getRow($DetailsID);
	$MOrderID = $d1->getOrderID();
	$ArrayDetailID = $d2->getKeysBy('DetailsID', 'ASC', 'WHERE OrderID = '.$MOrderID);

	if (count($ArrayDetailID) == 2) {
		if ($DetailsID == $ArrayDetailID[0]) {
			$otherDetailsID = $ArrayDetailID[1];
		}
		else if ($DetailsID == $ArrayDetailID[1]) {
			$otherDetailsID = $ArrayDetailID[0];
		}
	}
	return $otherDetailsID;
}

function getOtherTransferIDArray ($DetailsID,$details) {
	$key = array_search($DetailsID, array_column($details, 'DetailsID'));
	$oid=$details[$key]['OrderID'];
	$keys = array_keys(array_column($details, 'OrderID'),$oid);
	$otherDetailsID=null;
	if (count($keys) == 2) {
		if ($DetailsID == $details[$keys[0]]['DetailsID']) {
			$otherDetailsID=$details[$keys[1]]['DetailsID'];
		}
		else if ($DetailsID == $details[$keys[1]]['DetailsID']) {
			$otherDetailsID=$details[$keys[0]]['DetailsID'];
		}		
	}	
	return $otherDetailsID;
}

function minutesOfTime($time) {
	$time_arr=explode(":",$time);
	$time_min=$time_arr[0]*60+$time_arr[1];
	return $time_min;
}



// dobavi sve transfere za odabrani datum za trenutnog vlasnika timetable-a
$q = "SELECT DetailsID, SubDriver, SubDriver2, SubDriver3 FROM v4_OrderDetails WHERE DriverID = " . $_SESSION['OwnerID'] . " AND PickupDate >= '" . $DateFrom . "' AND PickupDate <= '" . $DateTo . "' AND TransferStatus < '6' AND TransferStatus != '3' AND TransferStatus != '4' AND DriverConfStatus != '3' ORDER BY DetailsID ASC";
$r = $db->RunQuery($q);
$subDArray = array();
while ($t = $r->fetch_object()) {
	if ($t->SubDriver != 0) $subDArray[] = $t->SubDriver;
	if ($t->SubDriver2 != 0) $subDArray[] = $t->SubDriver2;
	if ($t->SubDriver3 != 0) $subDArray[] = $t->SubDriver3;
}
$subDArray = array_unique($subDArray); // ostavi samo jedinstvene subdrivere u nizu

// dobavi vozace od trenutnog vlasnika timetable-a, slozi ih u sdArray sa podacima
$q = "SELECT * FROM v4_AuthUsers";
$q .= " WHERE DriverID = ".$_SESSION['OwnerID']." ORDER BY AuthUserRealName ASC";
$r = $db->RunQuery($q);
$sdArray = array();
while ($d = $r->fetch_object()) {
	$row = array();
    $row['DriverID'] = $d->AuthUserID;
    $row['DriverName'] = $d->AuthUserRealName;
	$row['Active'] = $d->Active;
	$row['Mob'] = $d->AuthUserMob;
    $sdArray[] = $row;
}

// dobavi vozila od trenutnog vlasnika timetable-a, slozi ih u svArray sa podacima
$q = "SELECT * FROM v4_SubVehicles";
$q .= " WHERE OwnerID = ".$_SESSION['OwnerID']." ORDER BY VehicleDescription ASC";
$db = new DataBaseMysql();
$r = $db->RunQuery($q);
$svArray = array();
while ($v = $r->fetch_object()) {
	$row = array();
    $row['VehicleID'] = $v->VehicleID;
    $row['VehicleDescription'] = $v->VehicleDescription;
	$row['Active'] = $v->Active;
    $svArray[] = $row;
}

asort($subDArray);
?>

<style>
.ttForm {
	margin: 12px 0 0;
	padding: 12px;
	text-align: center;
	background: #d9edf7;
}
.datepicker {
	width: 10em;
	text-align: center;
}
.picker__frame {
	top: 20% !important;
}
.btn-xs {
	border: 0;
}
hr {
	border-top: 1px solid #eee;
}
.row {
	margin-left: auto;
	margin-right: auto;
}
.stupac {
	border: solid 1px #ccc;
}
.stupacWrapper {
	margin-top: 12px;
	padding: 0 2px;
}
</style>

<div class="container-fluid">
	<div class="row" >
		<div style="float:left; display:inline-block; width:30%">	
			<h3>Timetable - Daily View</h3>
		</div>		
		<div style="float:left; display:inline-block; ">
		<form class="ttForm" action="index.php?p=dailyColumnView" method="post">
			COLUMNS:
			<select name="NoColumns">
				<option value="1" <?if($NoColumns==1)echo'selected'?>>1</option>
				<option value="2" <?if($NoColumns==2)echo'selected'?>>2</option>
				<option value="3" <?if($NoColumns==3)echo'selected'?>>3</option>
				<option value="4" <?if($NoColumns==4)echo'selected'?>>4</option>
				<option value="6" <?if($NoColumns==6)echo'selected'?>>6</option>
				<option value="12" <?if($NoColumns==12)echo'selected'?>>12</option>
			</select>
			<button type="submit" class="btn btn-primary">Go</button>
		</form>
		</div>
	</div>
	<div class="row" style="font-size:0.85em !important">
	<?
	$i = 0;
	$columnCount = 0;
	$totalPayLater = 0;
	$totalCashIn = 0;   
	$totalOrderPrice = 0;
	$totalValue = 0;
    $uniqueTransfers = array(); // za tocno racunanje podataka na dnu (zeleni okvir)

	$q = "SELECT DetailsID,SubDriver,SubDriver2,SubDriver3 FROM v4_OrderDetails 
		  WHERE DriverID = '". $_SESSION['OwnerID']."' 
		  AND PickupDate >= '" . $DateFrom . "' 
		  AND PickupDate <= '" . $DateTo . "' 
		  AND TransferStatus < '6' 
		  AND TransferStatus != '3' 
		  AND TransferStatus != '4' 
		  AND DriverConfStatus != '3' 
		  ORDER BY PickupDate, SubPickupTime, PickupTime ASC"; 
	$r = $db->RunQuery($q);
	while ($t = $r->fetch_object()) {
		$row[]=$t;
	}
	
	$details=array();
	// za proveru return transfer-a
	$q2 = "SELECT DetailsID,OrderID FROM v4_OrderDetails ORDER BY DetailsID DESC" ;
	$r2 = $db->RunQuery($q2);
	while ($t2 = $r2->fetch_object()) {
		$row_array=array();
		$row_array['DetailsID']=$t2->DetailsID; 
		$row_array['OrderID']=$t2->OrderID; 
		
		$details[]=$row_array;
	}
	
	// promjena pickup time
	$whereL = " WHERE Description LIKE '%PickupTime%'";
	$olKeys = $ol->getKeysBy('ID', 'DESC', $whereL);
	foreach ($olKeys as $olid) {
		$ol->getRow($olid);	
		$olKeys2[]=$ol->getDetailsID();
	}		
	date_default_timezone_set("Europe/Paris");		
	foreach ($subDArray as $SubDriver) { // STUPAC (driver)
		$au->getRow($SubDriver);
		$DetailsIDArray = array();
		// zaduzeno vozilo
		$sql="SELECT `VehicleID` FROM `v4_SubActivity` WHERE `OwnerID`=".$_SESSION['AuthUserID']." and `DriverID`=".$au->getAuthUserID()." and `Expense`=109 and `Approved`=1 and `Datum`<'".date('Y-m-d', time())."' Order by Datum DESC";
		$rs = $db->RunQuery($sql);
		$lng=0;
		$lat=0;				
		$vID=$rs->fetch_object();
		if (count($vID)>0) {
			$sv->getRow($vID->VehicleID);
			$vDescription=$sv->getVehicleDescription();
			$time1=time()-1200;
			$time2=time()-60;	
			// lokacija i vreme iz UserLocation
			$timestart=time()-12*3600;
			$q = "SELECT * FROM `v4_UserLocations` WHERE 
				`UserID`=".$SubDriver." and
				`Time` > ".$timestart."
				order by time desc"; 
			$r = $db->RunQuery($q);
			$loc=array(); 
			while ($t = $r->fetch_object()) {
				$loc[] = $t;
			}
			$lc=$loc[0];
			// izvlacenje lokacije iz Raptora
			$link='https://api.giscloud.com/rest/1/vehicles/'.$sv->getRaptorID().'/paths.json?from='.$time1.'&to='.$time2.'&api_key=4a27e4227a88de0508aa9fa2e4c57144&app_instance_id=107495';
			$json = file_get_contents($link); 
			$obj = json_decode($json,true);		
			$lng=($obj['bound']['xmin']+$obj['bound']['xmax'])/2;
			$lat=($obj['bound']['ymin']+$obj['bound']['ymax'])/2;
			// uzimanje lokacije za maps
			if ($lc->Time>($time1+$time2)/2 || ($lng==0 && $lat==0)) {
				$lat=$lc->Lat;
				$lng=$lc->Lng;			
				$device='PHONE at '.date('Y-m-d h:i:s',$lc->Time);
			} else {
				$device='RAPTOR at '.date('Y-m-d h:i:s',($time1+$time2)/2);
			}			
		}
		else {
			$vDescription='';	
		}	
			
		
		foreach ($row as $rw) {
			if ($rw->SubDriver==$SubDriver || $rw->SubDriver2==$SubDriver || $rw->SubDriver3==$SubDriver) 
				$DetailsIDArray[] = $rw->DetailsID; 
		}

		
		?>
			<div class="col-md-<?= $BsColumnWidth ?> stupacWrapper">
				<div class="xcol-md-12 stupac">
					<div class="col-md-12 pad4px orange white-text">
						<strong><?= $au->getAuthUserRealName() ?></strong>  
						<a style="color:white" href="tel:<?= $au->getAuthUserMob() ?>"><?= $au->getAuthUserMob() ?></a>
						<strong><?= $vDescription; ?></strong>  
					</div>
		<?			
		$display_location=true;
		foreach ($DetailsIDArray as $ID) { // REDAK u STUPCU (transfer)

		    $od->getRow($ID);
		    $om->getRow($od->getOrderID());
		    $otherTransfer = getOtherTransferIDArray($od->getDetailsID(),$details);
		    //$otherTransfer = getOtherTransferID($od->getDetailsID());
			if( $change) $changedIcon = '<i class="fa fa-circle text-red"></i>';
			$changedIcon = '';
			$color= '';
			if (in_array($ID,$olKeys2)) {
				$changedIcon = '<i class="fa fa-circle text-red"></i>';
				$color='red';
			}	

		    if($od->getSubPickupDate() == '0000-00-00') {
			    $od->setSubPickupDate( $od->getPickupDate() );
			    $saveRow = true;
		    }

		    if($od->getSubPickupTime() == '') {
			    $od->setSubPickupTime( $od->getPickupTime() );
		    }

		    # oznaci gdje ima, a gdje nema vozaca i vozila
		    if ($od->getSubDriver() == '0' or $od->getCar() == '0') {
			    $style= "border-left: 8px solid red; padding-left: 12px;";
		    }
		    else $style= "border-left: 8px solid green; padding-left: 12px;";

		    # zbroji cash za naplatu (samo ako transfer nije ponovljen)
            if (!in_array($ID, $uniqueTransfers)) {
                $uniqueTransfers[] = $ID;
                $totalPayLater += $od->getPayLater();
                $totalCashIn += $od->getCashIn();
                $totalValue += $od->getDetailPrice();
            }

		    // elegantniji FIX :)
		    $duration = 'N/A';
		    if(!empty($od->RouteID) ) {
			    $or->getRow($od->getRouteID());
			    $duration = $or->getDuration();
		    }

		    // dohvacanje engleskih imena lokacija iz v4_Places
		    // FIXME ako je FREEFORM, PickupID i DropID su 0,
		    // pa se imena dohvacaju iz v4_OrderDetails
		    if($om->getMCardType() == 'FREEFORM') {
			    $duration .= '(FF)';
			    $PickupName = $od->getPickupName();
			    $DropName = $od->getDropName();
		    } else {
			    $op->getRow($od->getPickupID());
			    $PickupName = $op->getPlaceNameEN();
			    $op->getRow($od->getDropID());
			    $DropName = $op->getPlaceNameEN();
		    }

		    // oznacavanje zavrsenih transfera
		    $bgColor = "#caefff";
			$bgColor2 = "#fefefe";
			
			$currenttime=date('H:i',time());
			if (minutesOfTime($od->getPickupTime())<minutesOfTime($currenttime)) {
				$bgColor = "#00FF00";
				$bgColor2 = "#00FF00";
			}	
			if ((minutesOfTime($od->getPickupTime())+$duration)<minutesOfTime($currenttime)) {
				$bgColor = "#FFCCCB";
				$bgColor2 = "#FFCCCB";
			}	
		    if($od->getTransferStatus() == "5") $bgColor = "#fefefe";			


			if ($display_location && $od->getTransferStatus() != "5" ) {
				?>
					<style>
						iframe {
						position: inherit;
						top: 0;
						left: 0;
						width: 100% !important;
					}		
					</style>	
					<div style="background:<?= $bgColor2 ?>;">
						<div style=''>
							<? if ($lat>0 && $lng>0) { ?>
								<iframe src="https://maps.google.com/maps?q=<?= $lat ?>, <?= $lng ?>&z=8&output=embed"  frameborder="0" style="border:0"></iframe>
								<b><?= $device ?></b>
							<? } ?>
						</div>						
					</div>	
				<?	
				$display_location=false;				
			}	
		    ?>

		<div class="row white shadow" style="cursor:default; padding:8px !important;background:<?= $bgColor ?>; margin:12px 0">
			<div class="row"> <!-- TRANSFER -->
				<span id="indicator_<?= $i ?>" style="<?= $style ?>"><?= YMD_to_DMY($od->getPickupDate()); ?></span>
				<span><?
					if($od->getUserLevelID() == '2') {
						echo " <i class='fa fa-user-secret'></i>";
						$au->getRow($od->getAgentID());
						if ($au->getImage()<>"") {
							echo "<img src='img/".$au->getImage()."'> ";	 
							echo "<b>".$au->getAuthUserRealName()."</b> ";	
						}
					}
				?></span>
			</div>

			<div class="row">
				<h4><?= $PickupName ?> - <?= $DropName ?></h4>
			</div>

			<div class="row">
				<div class="row">
					<div class="col-md-4">
						<span class="timepicker w100 <?= $color ?>" style="font-weight:bold;text-align:center">
							<?= $od->getSubPickupTime();?>
						</span>
					</div>

					<!-- info icons -->
					<div class="col-md-4 small center align-middle">

							<div class="">
								<i class="fa fa-user"></i>&nbsp;&nbsp;<?= $od->getPaxNo() ?>
							</div>

							<div class="">
								<?
									$carColor = 'text-lightgrey';
									$vehicleType = $od->getVehicleType();
						
									if($od->getVehicleType() >= 100 and $od->getVehicleType() < 200) {
										$carColor = 'text-green white';
										$vehicleType = 'P'.($od->getVehicleType() - 100);
									}
									if($od->getVehicleType() >= 200) {
										$carColor = 'text-red white';
										$vehicleType = 'FC'.($od->getVehicleType() - 200);
									}

					
								?>
								<i class="fa fa-car <?= $carColor ?> pad4px"></i> 
								<?= $vehicleType ?> 
								<? if($od->getVehiclesNo() > 1) echo ' x '. $od->getVehiclesNo() ?>
								<br>
							</div>
						</div>

						<div class="col-md-4">
							<div class="">
								<i class="fa fa-clock-o"></i> <?= $duration ?>

							</div>
						</div>
				</div>
			</div>
			<div class="row">
				<button class="btn-xs btn-primary btn-block" onclick="ShowShow(<?= $i?>);toggleChevron(this);">
					<i class="fa fa-chevron-down"></i>
				</button>
			</div> <!--/listTile-->

		    <!-- hiddenInfo -->
		    <div class="row grey lighten-4 pad1em shadow" id="show<?= $i ?>" style="display:none;margin:0">
			    <div class="row">
				    <div class="">
				        <?= $om->getMOrderKey(); ?>-<?= $od->getOrderID() ?> 
						<? if (!empty( $om->getMConfirmFile())) { ?> 
							<br>
							Ref.No:  <b><?= $om->getMConfirmFile() ?></b>    Emergency: <b><?= $au->getEmergencyPhone() ?></b>
						<? } ?> 
				        <br>
				        <?= $t->SingleReturn; ?>
				        <b><?= PAX ?>: <?= $od->getPaxNo() ?> VT: <?= $od->getVehicleType() ?></b><br>
				        <?=$od->getPickupDate(); ?> <?=$od->getPickupTime(); ?><br>
				        <?= $od->getPaxName(); ?><br>
				        <?= $om->getMPaxTel(); ?>
				    </div>

				    <div class="">
				        <b><?= $PickupName ?></b>
				        <br> 
				            <?= $od->getPickupAddress(); ?>
				            <br>
				            <?= $od->getPickupNotes(); ?>
				    </div>

				    <div class="">
				        <b><?= $DropName ?></b>
				        <br>
				        <?= $od->getDropAddress(); ?>
				    </div>

				    <div class="">
					    <!-- #INC-373 - vozač ne treba da vidi konačan iznos
					    Card: <?= $od->getPayNow(); ?> EUR<br> -->
					    Cash: 
					    <?
					    // bogo 16.06.2017 - nema mi logike ovo!
					    //if ($od->getPaymentMethod() == 4) echo $od->getDriversPrice();
					    //else 
					    echo $od->getPayLater();
					    ?>
					    EUR 
						<? if ($od->getPayNow()>0 && $od->getPayLater()>0) echo "<b style='color:red'>IZDATI RAČUN !</b>"; ?>
						<br>
				        <? if ($otherTransfer != null) {
						    $d2->getRow($otherTransfer);
						    echo 'R: '.YMD_to_DMY($d2->getPickupDate()).' '.$d2->getPickupTime();
					    } ?>
				    </div>

				    <div class="">
					    <?= FLIGHT_NO ?>: <?= $od->getFlightNo(); ?><br>
					    <?= FLIGHT_TIME ?>: <?= $od->getFlightTime(); ?><br><br>				
					    <?
						    if ($extras != '') echo $extras;
						    else echo NO_EXTRAS;
					    ?>
				    </div>
			    </div>
			    <hr style="border-color:gray">

			    <div class="row">


				    <div class="">
					    <small class="bold"><?= STAFF_NOTE ?></small></br>
					    <span><?= stripslashes( $od->getStaffNote() ) ?></span>
				    </div>

				    <div class="">
					    <small class="bold"><?= NOTES_TO_DRIVER ?></small><br>
					    <span style="border: 1px solid #ddd;">
							<?= stripslashes( $od->getSubDriverNote() ) ?>
						</span>
				    </div>

				    <div class="">
					    <small class="bold"><?= FINAL_NOTE ?></small><br>
					    <?= $od->getSubFinalNote(); ?><br>
					    <?= $od->getFinalNote(); /* privremeno */ ?>
				    </div>

				    <div class="">
					    <small class="bold"><?= RAZDUZENO_CASH ?> (€)</small><br>
					    <span><?= $od->getCashIn(); ?></span><br>
				    </div>
		        </div>
			    <hr style="border-color:gray">	
		    </div><!--/row-->
	    </div>
	    <?
	    $i++;
	}
	echo '</div>';$columnCount++;
	if ((($columnCount) % $NoColumns) == 0) echo '</div><div class="row">';
	echo '</div>';
		// kraj stupca


}?>
</div>

<br><br>

	<div class="row alert alert-success"
		style="margin-left:-15px;padding:4px;text-align:center">
	    <div class="col-md-1"></div>
		<div class="col-md-2" id="noOfTransfers">
			<?= TRANSFERS.': '. count($uniqueTransfers) ?>
		</div>
        <div class="col-md-2" id="noOfVehicles">
            <?= 'No. of vehicles: '. count($subDArray) ?>
        </div>
		<div class="col-md-2">
			<?= TOTAL_CASH.': '.number_format($totalPayLater,2) ?> EUR
		</div>
		<div class="col-md-2">
			<?= TOTAL_PAID.': '.number_format($totalCashIn,2) ?> EUR
		</div>
		<div class="col-md-2">
			<?= TOTAL_VALUE.': '.number_format($totalValue,2) ?> EUR
		</div>
	</div>

<script>
/*setTimeout(function(){		
	window.location.reload();	
}, 300000);*/
	
function ShowShow(i) {
	$("#show"+i).toggle('slow');
}

function toggleChevron (button) {
	if (button.innerHTML == '<i class="fa fa-chevron-up"></i>')
		button.innerHTML = '<i class="fa fa-chevron-down"></i>';
	else button.innerHTML = '<i class="fa fa-chevron-up"></i>';
}



</script>










