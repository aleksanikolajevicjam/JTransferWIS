<?
// Timetable sa prikazom transfera po vozacima za odabrani datum
// za svakog vozaca za odabran datum su izlistani transferi u stupcima (poput kalendarskog prikaza na dashboardu)
// POSTUPAK:
// - dobavi sve transfere za odabrani datum
// - dobavi sve vozace koji su vec postavljeni za te transfere (ovo bi moglo biti bez rezultata)
// - za svakog vozaca za odabrani datum ponovno dobavi (samo njegove) transfere
// - vozace izlistati u stupcima, njihove transfere u redovima unutar stupaca
session_start();
$DateFrom	= $_POST["DateFrom"];
$DateTo		= $_POST["DateTo"];
$NoColumns	= $_POST["NoColumns"];

if (!isset($DateFrom)) $DateFrom = date("Y-m-d");
if (!isset($DateTo)) $DateTo = date("Y-m-d");
if (!isset($NoColumns)) $NoColumns = 3;

require_once ROOT . '/db/v4_AuthUsers.class.php';
$au = new v4_AuthUsers();

require_once ROOT . '/db/db.class.php';
require_once ROOT . '/db/v4_OrdersMaster.class.php';
require_once ROOT . '/db/v4_OrderDetails.class.php';	
require_once ROOT . '/db/v4_OrderExtras.class.php';
require_once ROOT . '/db/v4_Places.class.php';
require_once ROOT . '/db/v4_Routes.class.php';
require_once ROOT . '/db/v4_OrderLog.class.php';

$db = new DataBaseMysql();
$om = new v4_OrdersMaster();
$od = new v4_OrderDetails();
$d2 = new v4_OrderDetails();
$oe = new v4_OrderExtras();
$op = new v4_Places();
$or = new v4_Routes();
$ol = new v4_OrderLog();

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

# hidden polja
function hiddenField($name,$value) {
	echo '<input name="'.$name.'" id="'.$name.'" type="hidden" value="'.$value.'" />';
}

function query_to_csv($db_conn, $query, $filename, $attachment = false, $headers = true) {
	if($attachment) {
		// send response headers to the browser
		header( 'Content-Type: text/csv' );
		header( 'Content-Disposition: attachment;filename='.$filename);
		$fp = fopen('php://output', 'w');
	} else {
		$fp = fopen($filename, 'w');
	}

	$result = mysql_query($query, $db_conn) or die( mysql_error( $db_conn ) );

	if($headers) {
		// output header row (if at least one row exists)
		$row = mysql_fetch_assoc($result);
		if($row) {
		    fputcsv($fp, array_keys($row));
		    // reset pointer back to beginning
		    mysql_data_seek($result, 0);
		}
	}

	while($row = mysql_fetch_assoc($result)) {
		fputcsv($fp, $row);
	}

	fclose($fp);
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
	<h1>Timetable - Column View</h1><hr>
	<div class="row" >
		<div style="float:left; display:inline-block; width:30%">	
			<button class="btn" onclick="hideChecked()"><?= DISPLAY_NOT_CHECKED ?></button>
			<button class="btn" onclick="displayAll()"><?= DISPLAY_ALL ?></button>
		</div>		
		<div style="float:left; display:inline-block; width:69%">
		<form class="ttForm" action="index.php?p=timetableColumnViewN" method="post" onsubmit="return validate()">
			From
			<input id="DateFrom" class="datepicker" name="DateFrom" value="<?=$DateFrom?>">
			to
			<input id="DateTo" class="datepicker" name="DateTo" value="<?=$DateTo?>">
			with
			<select name="NoColumns">
				<option value="1" <?if($NoColumns==1)echo'selected'?>>1</option>
				<option value="2" <?if($NoColumns==2)echo'selected'?>>2</option>
				<option value="3" <?if($NoColumns==3)echo'selected'?>>3</option>
				<option value="4" <?if($NoColumns==4)echo'selected'?>>4</option>
				<option value="6" <?if($NoColumns==6)echo'selected'?>>6</option>
				<option value="12" <?if($NoColumns==12)echo'selected'?>>12</option>
			</select>
			columns
			<button type="submit" class="btn btn-primary">Go</button>
		</form>

		<form action="p/modules/timetable/print.php" method="post" target="_blank" style="display:inline-block;text-align:right;float:right;margin-top:-55px;">
			<?
			hiddenField('DateFrom', $_REQUEST['DateFrom']);
			hiddenField('DateTo', $_REQUEST['DateTo']);
			hiddenField('SubDriverID', $_REQUEST['SubDriverID']);
			hiddenField('SortSubDriver', $_REQUEST['SortSubDriver']);
			?>
			<button type="submit" class="btn btn-primary"><i class="fa fa-print l"></i></button>
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
	foreach ($subDArray as $SubDriver) { // STUPAC (driver)
		$au->getRow($SubDriver);

		/*$q = "SELECT DetailsID FROM v4_OrderDetails 
		      WHERE DriverID = '". $_SESSION['OwnerID']."' 
		      AND PickupDate >= '" . $DateFrom . "' 
		      AND PickupDate <= '" . $DateTo . "' 
		      AND TransferStatus < '6' 
		      AND TransferStatus != '3' 
		      AND TransferStatus != '4' 
		      AND DriverConfStatus != '3' 
		      AND ((SubDriver = " . $SubDriver . ") OR (SubDriver2 = " . $SubDriver . ") OR (SubDriver3 = " . $SubDriver . ")) 
		      ORDER BY PickupDate, SubPickupTime, PickupTime ASC"; 
		
		// Josip trazio da se sortira po SubPickupTime. Izmjena 31.01.2018.
		
		$r = $db->RunQuery($q);*/
		$DetailsIDArray = array();

		// CEMU OVO SLUZI?
		/*while ($t = $r->fetch_object()) {
			$DetailsIDArray[] = $t->DetailsID;
		}*/

		foreach ($row as $rw) {
			if ($rw->SubDriver==$SubDriver || $rw->SubDriver2==$SubDriver || $rw->SubDriver3==$SubDriver) 
				$DetailsIDArray[] = $rw->DetailsID;  
		}
		
		echo '<div class="col-md-' . $BsColumnWidth . ' stupacWrapper">
				<div class="xcol-md-12 stupac">
					<div class="col-md-12 pad4px orange white-text"><strong>' . $au->getAuthUserRealName() . "</strong></div>";

		foreach ($DetailsIDArray as $ID) { // REDAK u STUPCU (transfer)

		    $od->getRow($ID);
		    $om->getRow($od->getOrderID());
		    $otherTransfer = getOtherTransferIDArray($od->getDetailsID(),$details);
		    //$otherTransfer = getOtherTransferID($od->getDetailsID());

		    // promjena pickup time
			
			/*$change = false ;
			echo count($olKeys);
			foreach ($olKeys as $k) {
				if ($k==$ID) $change=true;
			}	*/

			$changedIcon = '';
			$color= '';
			
			if (in_array($ID,$olKeys2)) {
				$changedIcon = '<i class="fa fa-circle text-red"></i>';
				$color='red';
			}	
			//if( count($olKeys) > 0 ) $changedIcon = '<i class="fa fa-circle text-red"></i>';
			//if( $change) $changedIcon = '<i class="fa fa-circle text-red"></i>';


		    // rjesenje problema kad su SubPickupDate ili SubPickupTime prazni
		    $saveRow = false;

		    if($od->getSubPickupDate() == '0000-00-00') {
			    $od->setSubPickupDate( $od->getPickupDate() );
			    $saveRow = true;
		    }

		    if($od->getSubPickupTime() == '') {
			    $od->setSubPickupTime( $od->getPickupTime() );
			    $saveRow = true;
		    }

		    if ($saveRow) {
			    $od->saveRow();
			    $od->getRow($ID);
		    }
		    // end

		    // dohvacanje extra usluga
		    // FIXME - TEMP: povratni transfer dobavlja extra usluge od dolaznog transfera
		    $ExtrasID = $ID;
		    if ($od->getTNo() == 2) {
			    $ExtrasID = $otherTransfer;
		    }

		    $extras = '';
		    $oeArray = $oe->getKeysBy('OrderDetailsID', 'ASC', 'WHERE OrderDetailsID = '.$ExtrasID);

		    foreach ($oeArray as $val => $ID) {
			    $oe->getRow($ID);
			    $extras .= $oe->getServiceName();
			    $extras .= '<br>';
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
		    if($od->getTransferStatus() == "5") $bgColor = "#fefefe";

		    ?>

		<div class="row white shadow" style="cursor:default; padding:8px !important;background:<?= $bgColor ?>; margin:12px 0">
			<div class="row"> <!-- TRANSFER -->
				<span id="indicator_<?= $i ?>" style="<?= $style ?>"><?= YMD_to_DMY($od->getPickupDate()); ?></span>
				<large style='float:right' class="bold"><input class='check' onchange="saveTransfer('<?= $i ?>');" id="checkdata_<?=$i?>" type="checkbox" name="checkeddata" value="<?= $od->getCustomerID();?>" 
					<? 
						if ($od->getCustomerID()==1) echo "checked"; 
					?>
					><?= DATA_CHECKED ?> 
				</large>
				<?
					if($od->getUserLevelID() == '2') {
						echo " <i class='fa fa-user-secret'></i>";
						//if($od->getUserID() == '1556') echo "M";
						/*if($od->getUserID() == '1556') echo "<img src='img/mozio.png'> ";	
						if($od->getUserID() == '2123') echo "<img src='img/stiberia.png'> ";*/	
						$au->getRow($od->getAgentID());
						if ($au->getImage()<>"") {
							echo "<img src='img/".$au->getImage()."'> ";	 
							echo "<b>".$au->getAuthUserRealName()."</b> ";	
						}
					}

				?>
				<br>
				<div class="small">
					<a href="https://www.jamtransfer.com/cms/printTransfer.php?OrderID=
					<?= $od->getOrderID() ?>" target="_blank"><?= $om->getMOrderKey();?>-
					<?= $od->getOrderID(); ?>-<?= $od->getTNo() ?></a>
				</div>
			</div>

			<div class="row">
				<b><?= $PickupName ?><br><?= $DropName ?></b>
			</div>

			<div class="row">
				<div class="row">
					<div class="col-md-4">
						<?= $changedIcon ?>
						<input type="text" class="timepicker w100 <?= $color ?>" id="SubPickupTime_<?= $i ?>"
							name="SubPickupTime_<?= $i ?>"
							value="<?= $od->getSubPickupTime();?>" onchange="saveTransfer(<?=$i?>)"
						style="font-weight:bold;text-align:center"/>
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

							<div>
								<input type="text" name="TransferDuration_<?=$i?>" 
								id="TransferDuration_<?=$i?>" value="<?= $od->getTransferDuration() ?>" 
								title="Transfer duration" class="timepicker w75" onchange="saveTransfer(<?=$i?>)">
				
								<? if($extras != '') echo '<i class="fa fa-cubes red-text"></i>'; ?>
							</div>
						</div>
				</div>
			</div>

			<div class="row">
				<div class="row" style="line-height:140%">
					<div class="col-md-5">
						<select style="width:100%;height:2em"
						id="SubDriver_<?=$i?>" name="SubDriver_<?=$i?>" onchange="saveTransfer(<?=$i?>)">
							<option value='0'> --- </option>
							<? foreach ($sdArray as $Driver) {
								echo '<option value="'.$Driver['DriverID'].'"';
								if ($Driver['DriverID'] == $od->getSubDriver())
									{ echo ' selected'; }
								else if ($Driver['Active'] == '0')
									{ echo ' hidden'; }
								echo '>'.$Driver['DriverName'].'</option>';
								} ?>
						</select>
					</div>
					<div class="col-md-5">
						<select style="width:100%;height:2em"
						id="Car_<?=$i?>" name="Car_<?=$i?>" onchange="saveTransfer(<?=$i?>)">
							<option value='0'> --- </option>
							<? foreach ($svArray as $Vehicle) {
								echo '<option value="'.$Vehicle['VehicleID'].'"';
								if ($Vehicle['VehicleID'] == $od->getCar())
									{ echo ' selected'; }
								else if ($Vehicle['Active'] == '0')
									{ echo ' hidden'; }
								echo '>'.$Vehicle['VehicleDescription'].'</option>';
								} ?>
						</select>
					</div>
					<div class="col-md-2">
						<a href="#" class="btn btn-default" onclick="return ShowSubdriver2('<?= $i ?>');">
							<i class="fa fa-plus"></i>
						</a>
					</div>
				</div>

				<div id="subDriver2<?=$i?>" class="row"
				<? if (($od->getPaxNo() < 8) && ($od->getSubDriver2() == 0) && ($od->getCar2() == 0)) echo ' style="display:none"'; ?> >
					<div class="col-md-5">
						<select style="width:100%;height:2em"
						id="SubDriver2_<?=$i?>" name="SubDriver2_<?=$i?>" onchange="saveTransfer(<?=$i?>)">
							<option value='0'> --- </option>
							<? foreach ($sdArray as $Driver) {
								echo '<option value="'.$Driver['DriverID'].'"';
								if ($Driver['DriverID'] == $od->getSubDriver2())
									{ echo ' selected'; }
								else if ($Driver['Active'] == '0')
									{ echo ' hidden'; }
								echo '>'.$Driver['DriverName'].'</option>';
								} ?>
						</select>
					</div>
					<div class="col-md-5">
						<select style="width:100%;height:2em"
						id="Car2_<?=$i?>" name="Car2_<?=$i?>" onchange="saveTransfer(<?=$i?>)">
							<option value='0'> --- </option>
							<? foreach ($svArray as $Vehicle) {
								echo '<option value="'.$Vehicle['VehicleID'].'"';
								if ($Vehicle['VehicleID'] == $od->getCar2())
									{ echo ' selected'; }
								else if ($Vehicle['Active'] == '0')
									{ echo ' hidden'; }
								echo '>'.$Vehicle['VehicleDescription'].'</option>';
								} ?>
						</select>
					</div>
					<div class="col-md-2">
						<a href="#" class="btn btn-default" onclick="return ShowSubdriver3('<?= $i ?>');">
							<i class="fa fa-plus"></i>
						</a>
					</div>
				</div>

				<div id="subDriver3<?= $i ?>" class="row"
				<? if (($od->getSubDriver3() == 0) && ($od->getCar3() == 0)) echo ' style="display:none"'; ?> >
					<div class="col-md-5">
						<select style="width:100%;height:2em"
						id="SubDriver3_<?=$i?>" name="SubDriver3_<?=$i?>" onchange="saveTransfer(<?=$i?>)">
							<option value='0'> --- </option>
							<? foreach ($sdArray as $Driver) {
								echo '<option value="'.$Driver['DriverID'].'"';
								if ($Driver['DriverID'] == $od->getSubDriver3())
									{ echo ' selected'; }
								else if ($Driver['Active'] == '0')
									{ echo ' hidden'; }
								echo '>'.$Driver['DriverName'].'</option>';
								} ?>
						</select>
					</div>
					<div class="col-md-5">
						<select style="width:100%;height:2em"
						id="Car3_<?=$i?>" name="Car3_<?=$i?>" onchange="saveTransfer(<?=$i?>)">
							<option value='0'> --- </option>
							<? foreach ($svArray as $Vehicle) {
								echo '<option value="'.$Vehicle['VehicleID'].'"';
								if ($Vehicle['VehicleID'] == $od->getCar3())
									{ echo ' selected'; }
								else if ($Vehicle['Active'] == '0')
									{ echo ' hidden'; }
								echo '>'.$Vehicle['VehicleDescription'].'</option>';
								} ?>
						</select>
					</div>
					<div class="col-md-2"></div>

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
				        <small class="bold"><?= FLIGHT_NO.' / '.TIME ?></small><br>

				        <input type="text" name="SubFlightNo_<?= $i ?>" id="SubFlightNo_<?= $i ?>" 
					    value="<? if ($od->getSubFlightNo() != null) echo $od->getSubFlightNo(); else echo $od->getFlightNo(); ?>">

					    <input type="text" class="timepicker" name="SubFlightTime_<?= $i ?>" id="SubFlightTime_<?= $i ?>" 
					    value="<? if ($od->getSubFlightTime() != null) echo $od->getSubFlightTime(); else echo $od->getFlightTime(); ?>">         
				    </div>

				    <div class="">
					    <small class="bold"><?= STAFF_NOTE ?></small></br>
					    <textarea name="StaffNote_<?= $i ?>" id="StaffNote_<?= $i ?>"
					    rows="4"><?= stripslashes( $od->getStaffNote() ) ?></textarea>
				    </div>

				    <div class="">
					    <small class="bold"><?= NOTES_TO_DRIVER ?></small><br>
					    <textarea style="border: 1px solid #ddd;" name="SubDriverNote_<?= $i ?>" 
					    id="SubDriverNote_<?= $i ?>" class="span3" rows="4">
					    <?= stripslashes( $od->getSubDriverNote() ) ?></textarea>
				    </div>

				    <div class="">
					    <small class="bold"><?= FINAL_NOTE ?></small><br>
					    <?= $od->getSubFinalNote(); ?><br>
					    <?= $od->getFinalNote(); /* privremeno */ ?>
				    </div>

				    <div class="">
					    <small class="bold"><?= RAZDUZENO_CASH ?> (€)</small><br>
					    <input type="text" name="CashIn_<?= $i ?>" id="CashIn_<?= $i ?>" value="<?= $od->getCashIn(); ?>"><br>
					    <div style="display:inline-block;color:#900;" id="upd<?= $i ?>"></div>
				    </div>
		        </div>
			    <hr style="border-color:gray">

			    <!-- PDF Receipt -->
			    <div class="col-md-6">
					    <? if($od->getPDFFile()) { ?>
					    <div id="existingPDF<?= $i ?>" style="display: inline">
						    <a href="https://www.jamtransfer.com/cms/raspored/PDF/<?= $od->getPDFFile() ?>" target="_blank"
						    class="btn btn-small btn-primary">
							    <?= DOWNLOAD_RECEIPT.' '.$od->getPDFFile() ?>
						    </a>&nbsp;&nbsp;
						    <button onclick="return deletePDF('<?= $od->getPDFFile() ?>','<?= $i ?>','<?= $od->getDetailsID() ?>');" 
						    class="btn btn-small btn-danger" >
							    <?= DELETE_RECEIPT.' '.$od->getPDFFile() ?>
						    </button>&nbsp;&nbsp; 
					    </div>
					    <? }?>

					    <form name="form" action="" method="POST" enctype="multipart/form-data" style="display:inline">
						    <input type="file" name="PDFFile_<?= $i ?>" id="PDFFile_<?= $i ?>" 
						    onchange="return ajaxFileUpload('<?= $i ?>');" style="display:none">
						    <input type="hidden" name="ID_<?= $i ?>" id="ID_<?= $i ?>" value="<?= $od->getDetailsID()?>">
						    <button id="imgUpload" class="btn btn-small btn-default" 
							    onclick="$('#PDFFile_<?= $i ?>').click();return false;">
							    <?= UPLOAD_PDF_RECEIPT ?>
						    </button>
					    </form>

					    <div style="display:inline-block;color:#900;" id="PDFUploaded_<?= $i ?>"></div>
			    </div>
			    <div class="col-md-6">
				    <button class="btn btn-primary btn-block" onclick="saveTransfer(<?= $i?>)">
					    <i class="fa fa-save"></i> Save
				    </button>
			    </div>
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
		<div class="col-md-3">
			<?= TRANSFERS.': '. count($uniqueTransfers) ?>
		</div>
		<div class="col-md-3">
			<?= TOTAL_CASH.': '.number_format($totalPayLater,2) ?> EUR
		</div>
		<div class="col-md-3">
			<?= TOTAL_PAID.': '.number_format($totalCashIn,2) ?> EUR
		</div>
		<div class="col-md-3">
			<?= TOTAL_VALUE.': '.number_format($totalValue,2) ?> EUR
		</div>
	</div>

<script>
$(document).ready(function(){
	$(".datepicker").pickadate({format:'yyyy-mm-dd'});
});

function validate() {
	var DateFrom = document.getElementById("DateFrom");
	var DateTo = document.getElementById("DateTo");
	var error = 0;

	DateFrom.style.borderColor = "#ddd";
	DateTo.style.borderColor = "#ddd";
	
	if (DateFrom.value == "") {
		error = 1;
		DateFrom.style.borderColor = "red";
	}

	if (DateTo.value == "") {
		error = 1;
		DateTo.style.borderColor = "red";
	}

	if (error == 1)	return false;
}

function ShowShow(i) {
	$("#show"+i).toggle('slow');
}

function toggleChevron (button) {
	if (button.innerHTML == '<i class="fa fa-chevron-up"></i>')
		button.innerHTML = '<i class="fa fa-chevron-down"></i>';
	else button.innerHTML = '<i class="fa fa-chevron-up"></i>';
}
</script>

<script type="text/javascript">

	function hideChecked() {
		$('.white'). each(function(){
			if ($(this).find('.check').prop('checked')) $(this).hide(400);
		})
	}	
	
	function displayAll() {
		$('.white'). each(function(){
			$(this).show(400);
		})
	}

	function saveTransfer (i) {
		
		var id	= $("#ID_" + i).val();
		var oid	= $("#OrderID_" + i).val();
		var checked = $('#checkdata_'+i).prop('checked');
		if (checked) {
			checked=1;
			$('#checkdata'+i).prop('checked',true);
		}	
		else {
			checked=0;
			$('#checkdata'+i).prop('checked',false);
		}				
		var fn	= $("#SubFlightNo_" + i).val();
		var ft	= $("#SubFlightTime_" + i).val();
		var pt	= $("#SubPickupTime_" + i).val();
		var sd	= $("select#SubDriver_" + i).val();
		var sd2	= $("select#SubDriver2_" + i).val();
		var sd3	= $("select#SubDriver3_" + i).val();
		var c	= $("select#Car_" + i).val();
		var c2	= $("select#Car2_" + i).val();
		var c3	= $("select#Car3_" + i).val();
		var sn	= $("#StaffNote_" + i).val();
		var n	= $("#SubDriverNote_" + i).val();
		var g	= $("#CashIn_" + i).val();
		var td	= $("#TransferDuration_" + i).val();
		var msg = $("#save-button-msg-" + i);

		msg.innerHTML = "Saving...";
		var url= "p/modules/timetable/ajax_updateNotes.php";
		$.ajax({
			url: url,
			type: "POST",
			data: {
				ID: id,
				OrderID: oid,
				CustomerID: checked,								
				SubFlightNo: fn,
				SubFlightTime: ft,
				SubPickupTime: pt,
				SubDriver: sd,
				SubDriver2: sd2,
				SubDriver3: sd3,
				Car: c,
				Car2: c2,
				Car3: c3,
				StaffNote: sn,
				Notes: n,
				CashIn: g,
				TransferDuration: td
			},
			success: function (result) {
				msg.innerHTML = "Saved";

				$("#upd"+i).html(result);
				var res = $.trim(result);
				
				if(res != '<small>Saved.</small>') {
					$.toaster(result, 'Oops', 'success red-2');
				}
				if ((sd == '0') || (c == '0')) {
					$("#indicator_"+i).css("borderLeftColor","red");
				}
				else {
					$("#indicator_"+i).css("borderLeftColor","green");
				}
			},
			error: function (e) {
				msg.innerHTML = "Error";
				// console.log("Error:");
				// console.log(e);
			}
		});
	}




	function ShowSubdriver2(i)
	{
	    $("#subDriver2"+i).toggle('slow');
	    return false;
	}

	function ShowSubdriver3(i)
	{
	    $("#subDriver3"+i).toggle('slow');
	    return false;
	}

	
	function Sortiraj()
	{
	    var a = $("#SortSubDriver").val();
	    if (a == '1') {
	        a = '0';
	        $("#SortSubDriver").val(a);
	        }
	    else {
			a = '1';
		    $("#SortSubDriver").val(a);
	    }

	}
	
		var a = $("#SortSubDriver").val();
	    if (a == '1') {
	    
	    
	           $("#SortBtn").removeClass('btn-default');
	           $("#SortBtn").addClass('btn-danger'); 
	        }
	    else {
	    
	           $("#SortBtn").removeClass('btn-danger');
	           $("#SortBtn").addClass('btn-default');   
	    }


		function deletePDF(file,i,id) {
			if(!confirm('Are you sure?')) {return false;}
			
			$.get( "p/modules/timetable/deletePDF.php?file="+file+'&DetailsID='+id, function( data ) {
				$("#existingPDF"+i).hide();
			});
			return false;
		}
		
		function ajaxFileUpload(i)
		{
			var ID = $("#ID_"+i).val();
			
			$.ajaxFileUpload
			(
				{
					url: 'p/modules/timetable/savePDF.php?DetailsID='+ID+'&i='+i,
					secureuri:false,
					fileElementId:'PDFFile_'+i,
					dataType: 'json',
					//data:{UserID: UserID},
					success: function (data, status)
					{
						if(typeof(data.error) != 'undefined')
						{
							if(data.error != '')
							{
								alert(data.error);
							}else
							{
								//alert(data.msg);
								$("#PDFUploaded_"+i).text(data.msg);


							}
						}

					},
					error: function (data, status, e)
					{
						// console.log(data);
                        alert(e);
					}
					
				}
			)
		
			return false;

		}


/*
ajaxFileUpload - AjaxFileUploaderV2.1
*/

jQuery.extend({
    createUploadIframe: function(id, uri)
	{
			//create frame
            var frameId = 'jUploadFrame' + id;
            var iframeHtml = '<iframe id="' + frameId + '" name="' + frameId + '" style="position:absolute; top:-9999px; left:-9999px"';
			if(window.ActiveXObject)
			{
                if(typeof uri== 'boolean'){
					iframeHtml += ' src="' + 'javascript:false' + '"';

                }
                else if(typeof uri== 'string'){
					iframeHtml += ' src="' + uri + '"';

                }	
			}
			iframeHtml += ' />';
			jQuery(iframeHtml).appendTo(document.body);

            return jQuery('#' + frameId).get(0);			
    },
    createUploadForm: function(id, fileElementId, data)
	{
		//create form	
		var formId = 'jUploadForm' + id;
		var fileId = 'jUploadFile' + id;
		var form = jQuery('<form  action="" method="POST" name="' + formId + '" id="' + formId + '" enctype="multipart/form-data"></form>');	
		if(data)
		{
			for(var i in data)
			{
				jQuery('<input type="hidden" name="' + i + '" value="' + data[i] + '" />').appendTo(form);
			}			
		}		
		var oldElement = jQuery('#' + fileElementId);
		var newElement = jQuery(oldElement).clone();
		jQuery(oldElement).attr('id', fileId);
		jQuery(oldElement).before(newElement);
		jQuery(oldElement).appendTo(form);


		
		//set attributes
		jQuery(form).css('position', 'absolute');
		jQuery(form).css('top', '-1200px');
		jQuery(form).css('left', '-1200px');
		jQuery(form).appendTo('body');		
		return form;
    },

    ajaxFileUpload: function(s) {
        // TODO introduce global settings, allowing the client to modify them for all requests, not only timeout		
        s = jQuery.extend({}, jQuery.ajaxSettings, s);
        var id = new Date().getTime()        
		var form = jQuery.createUploadForm(id, s.fileElementId, (typeof(s.data)=='undefined'?false:s.data));
		var io = jQuery.createUploadIframe(id, s.secureuri);
		var frameId = 'jUploadFrame' + id;
		var formId = 'jUploadForm' + id;		
        // Watch for a new set of requests
        if ( s.global && ! jQuery.active++ )
		{
			jQuery.event.trigger( "ajaxStart" );
		}            
        var requestDone = false;
        // Create the request object
        var xml = {}   
        if ( s.global )
            jQuery.event.trigger("ajaxSend", [xml, s]);
        // Wait for a response to come back
        var uploadCallback = function(isTimeout)
		{			
			var io = document.getElementById(frameId);
            try 
			{				
				if(io.contentWindow)
				{
					 xml.responseText = io.contentWindow.document.body?io.contentWindow.document.body.innerHTML:null;
                	 xml.responseXML = io.contentWindow.document.XMLDocument?io.contentWindow.document.XMLDocument:io.contentWindow.document;
					 
				}else if(io.contentDocument)
				{
					 xml.responseText = io.contentDocument.document.body?io.contentDocument.document.body.innerHTML:null;
                	xml.responseXML = io.contentDocument.document.XMLDocument?io.contentDocument.document.XMLDocument:io.contentDocument.document;
				}						
            }catch(e)
			{
				jQuery.handleError(s, xml, null, e);
			}
            if ( xml || isTimeout == "timeout") 
			{				
                requestDone = true;
                var status;
                try {
                    status = isTimeout != "timeout" ? "success" : "error";
                    // Make sure that the request was successful or notmodified
                    if ( status != "error" )
					{
                        // process the data (runs the xml through httpData regardless of callback)
                        var data = jQuery.uploadHttpData( xml, s.dataType );    
                        // If a local callback was specified, fire it and pass it the data
                        if ( s.success )
                            s.success( data, status );
    
                        // Fire the global callback
                        if( s.global )
                            jQuery.event.trigger( "ajaxSuccess", [xml, s] );
                    } else
                        jQuery.handleError(s, xml, status);
                } catch(e) 
				{
                    status = "error";
                    jQuery.handleError(s, xml, status, e);
                }

                // The request was completed
                if( s.global )
                    jQuery.event.trigger( "ajaxComplete", [xml, s] );

                // Handle the global AJAX counter
                if ( s.global && ! --jQuery.active )
                    jQuery.event.trigger( "ajaxStop" );

                // Process result
                if ( s.complete )
                    s.complete(xml, status);

                jQuery(io).unbind()

                setTimeout(function()
									{	try 
										{
											jQuery(io).remove();
											jQuery(form).remove();	
											
										} catch(e) 
										{
											jQuery.handleError(s, xml, null, e);
										}									

									}, 100)

                xml = null

            }
        }
        // Timeout checker
        if ( s.timeout > 0 ) 
		{
            setTimeout(function(){
                // Check to see if the request is still happening
                if( !requestDone ) uploadCallback( "timeout" );
            }, s.timeout);
        }
        try 
		{

			var form = jQuery('#' + formId);
			jQuery(form).attr('action', s.url);
			jQuery(form).attr('method', 'POST');
			jQuery(form).attr('target', frameId);
            if(form.encoding)
			{
				jQuery(form).attr('encoding', 'multipart/form-data');      			
            }
            else
			{	
				jQuery(form).attr('enctype', 'multipart/form-data');			
            }			
            jQuery(form).submit();

        } catch(e) 
		{			
            jQuery.handleError(s, xml, null, e);
        }
		
		jQuery('#' + frameId).load(uploadCallback	);
        return {abort: function () {}};	

    },

    uploadHttpData: function( r, type ) {
        var data = !type;
        data = type == "xml" || data ? r.responseXML : r.responseText;
        // If the type is "script", eval it in global context
        if ( type == "script" )
            jQuery.globalEval( data );
        // Get the JavaScript object, if JSON is used.
        if ( type == "json" )
            eval( "data = " + data );
        // evaluate scripts within html
        if ( type == "html" )
            jQuery("<div>").html(data).evalScripts();

        return data;
    },
    
	handleError: function( s, xhr, status, e ) {
		// If a local callback was specified, fire it
		if ( s.error ) {
		    s.error.call( s.context || window, xhr, status, e );
		}

		// Fire the global callback
		if ( s.global ) {
		    (s.context ? jQuery(s.context) : jQuery.event).trigger( "ajaxError", [xhr, s, e] );
		}
	}    
})
</script>




<?/*


	// red u tablici
	foreach($odArray as $val => $ID) {
		

		# save OrderID with same index as the price
		hiddenField('ID_'.$i, $od->getDetailsID());
		hiddenField('OrderID_'.$i, $od->getOrderID());
		//hiddenField('FlightTime_'.$i, $t->FlightTime);
		//hiddenField('SubDriver_'.$i, $t->SubDriver);
		//hiddenField('Car_'.$i, $t->Car);
		//hiddenField('SubDriverNote_'.$i, $t->SubDriverNote);

		$i++;
	}
?>




