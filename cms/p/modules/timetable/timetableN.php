<?
$SOwnerID = $_SESSION['OwnerID'];

// FRANCUSKA FIX
$fakeDriverFound = false;

require_once ROOT . '/cms/fixDriverID.php';
foreach($fakeDrivers as $key => $fakeDriverID) {
    if($SOwnerID == $fakeDriverID) {
        $fakeDriverFound = true;
        $SOwnerID = $realDrivers[$key];
    }
}



require_once ROOT . '/db/db.class.php';
require_once ROOT . '/db/v4_OrdersMaster.class.php';

if($fakeDriverFound) require_once ROOT . '/db/v4_OrderDetailsFR.class.php';
else require_once ROOT . '/db/v4_OrderDetails.class.php';

require_once ROOT . '/db/v4_OrderExtras.class.php';
require_once ROOT . '/db/v4_Places.class.php';
require_once ROOT . '/db/v4_Routes.class.php';
require_once ROOT . '/db/v4_OrderLog.class.php';

$db = new DataBaseMysql();
$om = new v4_OrdersMaster();

require_once ROOT . '/db/v4_AuthUsers.class.php';
$au = new v4_AuthUsers();

if($fakeDriverFound) $od = new v4_OrderDetailsFR();
else $od = new v4_OrderDetails();

if($fakeDriverFound) $d2 = new v4_OrderDetailsFR();
else  $d2 = new v4_OrderDetails();

$oe = new v4_OrderExtras();
$op = new v4_Places();
$or = new v4_Routes();
$ol = new v4_OrderLog();

$q = "SELECT * FROM v4_AuthUsers";
$q .= " WHERE DriverID = ".$SOwnerID." ORDER BY AuthUserRealName ASC";
$r = $db->RunQuery($q);

$sdArray = array();

while ($d = $r->fetch_object()) {
	$row = array();
    $row['DriverID'] = $d->AuthUserID;
    $row['DriverName'] = $d->AuthUserRealName;
	$row['Active'] = $d->Active;
    $sdArray[] = $row;
}

$q = "SELECT * FROM v4_SubVehicles";
$q .= " WHERE OwnerID = ".$SOwnerID." ORDER BY VehicleDescription ASC";
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

echo '<div class="container-fluid pad1em">';
echo '<h1>'.TRANSFER_LIST;
echo "</h1>";


if (($_REQUEST['DateFrom'] != null) and ($_REQUEST['DateTo'] != null))
{
	$column = 'PickupDate';
	$order = 'ASC';
	$where = " WHERE DriverID = " . $SOwnerID;

	if ($_REQUEST['SortSubDriver'] == '1') $order = " ASC, SubDriver ASC, SubPickupTime ASC, PickupTime ASC";
	//else $order = " ASC, SubPickupTime ASC, PickupTime ASC";
	else $order = " ASC, SubPickupTime ASC";
	
	if ($_REQUEST['SubDriverID'] != 0) {
		$where .= " AND (SubDriver = " . $_REQUEST['SubDriverID'];
		$where .= " OR SubDriver2 = " . $_REQUEST['SubDriverID'];
		$where .= " OR SubDriver3 = " . $_REQUEST['SubDriverID'];
		$where .= " )";
	}
	        
    $where .= " AND PickupDate >= '".$_REQUEST['DateFrom']."' 
				AND PickupDate <= '".$_REQUEST['DateTo']."' 
				AND TransferStatus < '6' AND TransferStatus != '3' AND TransferStatus != '4'
				AND DriverConfStatus != '3' ";

    //if($fakeDriverFound) $where .= " AND Expired = '0'";
	$odArray = $od->getKeysBy($column, $order, $where);


    echo '<p class="lead">'.YMD_to_DMY($_REQUEST['DateFrom']).' - '.YMD_to_DMY($_REQUEST['DateTo']).'</p>';

?>
	<form action="index.php?p=timetable" method="post" style="display:inline-block;width:30%;">
		<?
		hiddenField('DateFrom', $_REQUEST['DateFrom']);
		hiddenField('DateTo', $_REQUEST['DateTo']);
		hiddenField('SubDriverID', $_REQUEST['SubDriverID']);
		hiddenField('SortSubDriver', $_REQUEST['SortSubDriver']);
		hiddenField('OwnerID', $SOwnerID);
		?>
		<?= SORT ?>:
		<div class="btn-group">
			<button class="btn btn-danger " disabled><?= DATE ?> <i class="fa fa-chevron-down"></i></button>
			<button class="btn btn-danger " disabled></i><?= TIME ?> <i class="fa fa-chevron-down"></i></button>
			<button id="SortBtn" class="btn btn-default" type="submit" onclick="Sortiraj()"><?= DRIVER ?> <i class="fa fa-chevron-down"></i></button>
		</div>
    </form>
	<div style="display:inline-block;width:30%;">
		<button class="btn" onclick="hideChecked()"><?= DISPLAY_NOT_CHECKED ?></button>
		<button class="btn" onclick="displayAll()"><?= DISPLAY_ALL ?></button>
	</div>
    <form action="p/modules/timetable/print.php" method="post" target="_blank" style="display:inline-block;width:39%;text-align:right;">
		<?
		hiddenField('DateFrom', $_REQUEST['DateFrom']);
		hiddenField('DateTo', $_REQUEST['DateTo']);
		hiddenField('SubDriverID', $_REQUEST['SubDriverID']);
		hiddenField('SortSubDriver', $_REQUEST['SortSubDriver']);
		?>
    	<button type="submit" class="btn btn-primary"><i class="fa fa-print l"></i></button>
    </form>

    <br><br>
	
<?	
	$i = 0;
	$totalPayLater = 0;
	$totalCashIn = 0;   
	$totalOrderPrice = 0;
	$totalValue = 0;
	

	// red u tablici
	foreach($odArray as $val => $ID) {

		$od->getRow($ID);
		$om->getRow($od->getOrderID());
		$otherTransfer = getOtherTransferID($od->getDetailsID());
		
		
		// promjena pickup time
		$whereL = " WHERE DetailsID = '" . $ID ."' AND Description LIKE '%PickupTime%'";
		$olKeys = $ol->getKeysBy('ID', 'DESC', $whereL);
		
		$changedIcon = '';
		if( count($olKeys) > 0 ) $changedIcon = '<i class="fa fa-circle text-red"></i>';
		
		
		
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
		
		if($ExtrasID) {
		    $extras = '';
		    $oeArray = $oe->getKeysBy('OrderDetailsID', 'ASC', 'WHERE OrderDetailsID = '.$ExtrasID);

		    if(count($oeArray) > 0) {
		        foreach ($oeArray as $val => $ID) {
			        $oe->getRow($ID);
			        $extras .= $oe->getServiceName();
			        $extras .= '<br>';
		        }
		    }
		}
		
		# oznaci gdje ima, a gdje nema vozaca i vozila
		if ($od->getSubDriver() == '0' or $od->getCar() == '0') {
		    $style= "border-left: 8px solid red; padding-left: 12px;";
		}
		else $style= "border-left: 8px solid green; padding-left: 12px;";
		
		# zbroji cash za naplatu
		$totalPayLater += $od->getPayLater();
		$totalCashIn += $od->getCashIn();
		$totalValue += $od->getDetailPrice();

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
		<div class="row white shadow" 
		style="cursor:default; padding:8px !important;background:<?= $bgColor ?>">
		    <div class="col-md-2">
		        <span id="indicator_<?= $i ?>" style="<?= $style ?>"><?= YMD_to_DMY($od->getPickupDate()); ?></span>
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
				    <? if(!$fakeDriverFound) { ?>
					    <a href="https://www.jamtransfer.com/cms/printTransfer.php?OrderID=
					    <?= $od->getOrderID() ?>" target="_blank"><?= $om->getMOrderKey();?>-
					    <?= $od->getOrderID(); ?>-<?= $od->getTNo() ?></a><br>
						Booked: <?= $od->getOrderDate()?>
					<? } else { ?>
					    <a href="https://www.jamtransfer.com/cms/printTransferFR.php?DetailsID=
					    <?= $od->getDetailsID() ?>" target="_blank"><?= $om->getMOrderKey();?>-
					    <?= $od->getOrderID(); ?>-<?= $od->getTNo() ?></a>
						Booked: <?= $od->getOrderDate()?>
					<? } ?>
				</div>
				<large class="bold"><input class='check' onchange="updateNotes('<?= $i ?>');" id="checkdata_<?=$i?>" type="checkbox" name="checkeddata" value="<?= $od->getCustomerID();?>" 
				<? 
					if ($od->getCustomerID()==1) echo "checked"; 
				?>
				><?= DATA_CHECKED ?> </large>
		    </div>

		    <div class="col-md-2">
		        <b><?= $PickupName ?><br><?= $DropName ?></b>
		    </div>

		    <div class="col-md-3">
				<div class="row">
					<div class="col-md-6">
					    <?= $changedIcon ?>
						<input type="text" class="timepicker w50" id="SubPickupTime_<?= $i ?>"
							name="SubPickupTime_<?= $i ?>"
							onchange="updateNotes(<?= $i ?>);"
							value="<?= $od->getSubPickupTime();?>"
						style="font-weight:bold;text-align:center"/>
					</div>

					<!-- info icons -->
				    <div class="col-md-6 small center align-middle">
						<div class="row">
							<div class="col-md-6">
								<i class="fa fa-user"></i>&nbsp;&nbsp;<?= $od->getPaxNo() ?>
							</div>
							<div class="col-md-6">
								<i class="fa fa-clock-o"></i> <?= $duration ?>

							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
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
							<div class="col-md-6">
								
								<input type="text" name="TransferDuration_<?=$i?>" 
								id="TransferDuration_<?=$i?>" value="<?= $od->getTransferDuration() ?>" 
								title="Transfer duration"
								onchange="updateNotes(<?= $i ?>);" class="timepicker w75" >
								
								<? if($extras != '') echo '<i class="fa fa-cubes red-text"></i>'; ?>
							</div>
						</div>
					</div>
				</div>
		    </div>

			<div class="col-md-4">
				<div class="row" style="line-height:140%">
					<div class="col-md-5">
						<select style="width:100%;height:2em"
						id="SubDriver_<?=$i?>" name="SubDriver_<?=$i?>"
						onchange="updateNotes(<?=$i?>);">
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
						id="Car_<?=$i?>" name="Car_<?=$i?>"
						onchange="updateNotes(<?=$i?>);">
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
						id="SubDriver2_<?=$i?>" name="SubDriver2_<?=$i?>"
						onchange="updateNotes(<?=$i?>);">
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
						id="Car2_<?=$i?>" name="Car2_<?=$i?>"
						onchange="updateNotes(<?=$i?>);">
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
						id="SubDriver3_<?=$i?>" name="SubDriver3_<?=$i?>"
						onchange="updateNotes(<?=$i?>);">
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
						id="Car3_<?=$i?>" name="Car3_<?=$i?>"
						onchange="updateNotes(<?=$i?>);">
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

			<div class="col-md-1">
				<button class="btn btn-danger" onclick="ShowShow(<?= $i?>);toggleChevron(this);">
					<i class="fa fa-chevron-down"></i>
				</button>
				<?
				    if($od->getTransferStatus() == '5') echo ' <i class="fa fa-check-square"></i>';
				?>
			</div>
		</div> <!--/listTile-->




<?
/*************************************************************************************************************************************/

?>		





		<div class="row grey lighten-4 pad1em shadow" id="show<?= $i ?>" style="display:none;margin:0">

			<div class="row">
				<div class="col-md-2">
				    <?= $om->getMOrderKey(); ?>-<?= $od->getOrderID() ?>
				    <br>
				    <?= $t->SingleReturn; ?>
				    <b><?= PAX ?>: <?= $od->getPaxNo() ?> VT: <?= $od->getVehicleType() ?></b><br>
				    <?=$od->getPickupDate(); ?> <?=$od->getPickupTime(); ?><br>
				    <?= $od->getPaxName(); ?><br>
				    <?= $om->getMPaxTel(); ?>
				</div>

				<div class="col-md-3">
				    <b><?= $PickupName ?></b>
				    <br> 
				        <?= $od->getPickupAddress(); ?>
				        <br>
				        <?= $od->getPickupNotes(); ?>
				</div>

				<div class="col-md-3">
				    <b><?= $DropName ?></b>
				    <br>
				    <?= $od->getDropAddress(); ?>
				</div>

				<div class="col-md-2">
					<!-- #INC-373 - vozač ne treba da vidi konačan iznos
					Card: <?= $od->getPayNow(); ?> EUR<br> -->
					Cash: 
					<?
					// bogo 16.06.2017 - nema mi logike ovo!
					//if ($od->getPaymentMethod() == 4) echo $od->getDriversPrice();
					//else 
					echo $od->getPayLater();
					?>
					EUR<br>
				    <? if ($otherTransfer != null) {
						$d2->getRow($otherTransfer);
						echo 'R: '.YMD_to_DMY($d2->getPickupDate()).' '.$d2->getPickupTime();
					} ?>
				</div>

				<div class="col-md-2">
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
				<div class="col-md-2">
				    <small class="bold"><?= FLIGHT_NO.' / '.TIME ?></small><br>

				    <input type="text" name="SubFlightNo_<?= $i ?>" id="SubFlightNo_<?= $i ?>" 
					value="<? if ($od->getSubFlightNo() != null) echo $od->getSubFlightNo(); else echo $od->getFlightNo(); ?>">

					<input type="text" class="timepicker" name="SubFlightTime_<?= $i ?>" id="SubFlightTime_<?= $i ?>" 
					value="<? if ($od->getSubFlightTime() != null) echo $od->getSubFlightTime(); else echo $od->getFlightTime(); ?>">         
				</div>

				<div class="col-md-3">
					<small class="bold"><?= STAFF_NOTE ?></small></br>
					<textarea name="StaffNote_<?= $i ?>" id="StaffNote_<?= $i ?>"
					rows="4"><?= stripslashes( $od->getStaffNote() ) ?></textarea>
				</div>

				<div class="col-md-3"> <!-- DODANO AKO IMA RETURN TRANSFER DA U NOTES-U STOJI NAPOMENA KAKO BI SE DOGOVORIO PICKUP - 19.07.2018 - Zatrazio J. Mandic -->
					<small class="bold"><?= NOTES_TO_DRIVER ?></small><br>
					<textarea style="border: 1px solid #ddd;" name="SubDriverNote_<?= $i ?>" 
					id="SubDriverNote_<?= $i ?>" class="span3" rows="4"
					xonchange="updateNotes('<?= $i ?>');"><? 
						if ($otherTransfer != null ){
							/* ima return transfer ako nema napomenu da ima transfer dodaj nepomenu */
							$poruka = $od->getSubDriverNote();
							$napomena = 'Ima return transfer - dogovoriti mjesto Pick-Upa! ';
							if(strpos($poruka, $napomena) === false and $od->getTNo() !== 2) { echo $napomena; }
						}
						echo stripslashes( $od->getSubDriverNote() ); ?></textarea>
				</div>

				<div class="col-md-2">
					<small class="bold"><?= FINAL_NOTE ?>s</small><br>
					<?	// prikaz Final note od prvog transfera
						if ($od->getTNo() == 2) {
							echo '<small>' . $od->getOrderID() . '-1:</small>';
							echo '<br>' . $d2->getSubFinalNote();
							echo '<br>' . $d2->getFinalNote();
							echo '<hr style="border-top: 1px dashed gray; margin: 6px 0">';
						}
					?>
					<?= $od->getSubFinalNote(); ?><br>
					<?= $od->getFinalNote(); /* privremeno */ ?>
				</div>

				<div class="col-md-2">
					<small class="bold"><?= RAZDUZENO_CASH ?> (€)</small><br>
					<? if ($od->getTNo() == 2) {
						echo '<small>' . $od->getOrderID() . '-1:</small> ' . $d2->getCashIn();
						echo '<hr style="border-top: 1px dashed gray; margin: 6px 0">';
					} ?>
					<input type="text" name="CashIn_<?= $i ?>" id="CashIn_<?= $i ?>" xonchange="updateNotes('<?= $i ?>');" value="<?= $od->getCashIn(); ?>"><br>
					<button class="btn btn-primary" onclick="updateNotes('<?= $i ?>');"><?= SAVE ?></button>
					<div style="display:inline-block;color:#900;" id="upd<?= $i ?>"></div>
				</div>
		    </div>
			<hr style="border-color:gray">

			<!-- PDF Receipt -->
			<div class="row">
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

		</div><!--/row-->

<div style="line-height: .5em !important"><br></div>
<? 
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

	<div class="row alert alert-success"
		style="margin-left:-15px;padding:4px;text-align:center">
		<div class="col-md-3">
			<?= TRANSFERS.': '.count($odArray) ?>
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

<?

}

else echo 'Enter Dates!';
echo '</div>';



?>


<script type="text/javascript">

	function hideChecked() {
		$('.row'). each(function(){
			if ($(this).find('.check').prop('checked')) $(this).hide(400);
		})
	}	
	
	function displayAll() {
		$('.white'). each(function(){
			$(this).show(400);
		})
	}
	
	function updateNotes (i)
	{
		var status = "<? echo $status; ?>";
		var id	= $("#ID_"+i).val();
		var oid	= $("#OrderID_"+i).val();
		var checked = $('#checkdata_'+i).prop('checked');
		if (checked) {
			checked=1;
			$('#checkdata'+i).prop('checked',true);
		}	
		else {
			checked=0;
			$('#checkdata'+i).prop('checked',false);
		}		
		var fn	= $("#SubFlightNo_"+i).val();
		var ft	= $("#SubFlightTime_"+i).val();
		var pt	= $("#SubPickupTime_"+i).val();
		var sd	= $("select#SubDriver_"+i).val();
		var sd2	= $("select#SubDriver2_"+i).val();
		var sd3	= $("select#SubDriver3_"+i).val();
		var c	= $("select#Car_"+i).val();
		var c2	= $("select#Car2_"+i).val();
		var c3	= $("select#Car3_"+i).val();
		var sn	= $("#StaffNote_"+i).val();
		var n	= $("#SubDriverNote_"+i).val();
		var g	= $("#CashIn_"+i).val();
		var td	= $("#TransferDuration_"+i).val();

		/*$.get("p/modules/timetable/ajax_updateNotes.php", {ID: id,OrderID: oid,SubFlightNo: fn,SubFlightTime: ft,SubPickupTime: pt,SubDriver: sd,SubDriver2: sd2,SubDriver3: sd3,Car: c,Car2: c2,Car3: c3,Notes: n,CashIn: g },
			function (data) {
				$("#upd"+i).html(data);	}
			}); */

		var url= "p/modules/timetable/ajax_updateNotesN.php";
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
				$("#upd"+i).html(result);
			
				var res = $.trim(result);
				
				if(res != '<small>Saved.</small>') {
					$.toaster(result, 'Oops', 'success red-2');
				} else {
				    $.toaster(result, 'Success', 'success green-2');
				}
				if ((sd == '0') || (c == '0')) {
					$("#indicator_"+i).css("borderLeftColor","red");
				}
				else {
					$("#indicator_"+i).css("borderLeftColor","green");
				}
			},
			error: function (result) {
				alert("There was an error: " + result);
			}
		});
	}
	
	function ShowShow(i)
	{
	    $("#show"+i).toggle('slow');
	}

	function toggleChevron (button) {
		if (button.innerHTML == '<i class="fa fa-chevron-up"></i>')
			button.innerHTML = '<i class="fa fa-chevron-down"></i>';
		else button.innerHTML = '<i class="fa fa-chevron-up"></i>';
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

<?
// DALJE SU FUNKCIJE

#
# hidden polja
#
function hiddenField($name,$value)
{
	echo '<input name="'.$name.'" id="'.$name.'" type="hidden" value="'.$value.'" />';
}
/*
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
*/

# Pretvaranje formata datuma
function YMD_to_DMY($date)
{
    $elementi = explode('-',$date);
    $new_date = $elementi[2].'.'.$elementi[1].'.'.$elementi[0];
    return $new_date;
}


function getOtherTransferID ($DetailsID) {

	global $fakeDriverFound;

	$otherDetailsID = null;
	
	if($fakeDriverFound) {
        $d1 = new v4_OrderDetailsFR();
	    $d2 = new v4_OrderDetailsFR();	
	} else {
    	$d1 = new v4_OrderDetails();
	    $d2 = new v4_OrderDetails();
	}
	
	$d1->getRow($DetailsID);
	$MOrderID = $d1->getOrderID();
	$ArrayDetailID = $d2->getKeysBy('DetailsID', 'ASC', 'WHERE OrderID = '.$MOrderID);
	
	if (count($ArrayDetailID) == 2)
	{
		if ($DetailsID == $ArrayDetailID[0]) {
			$otherDetailsID = $ArrayDetailID[1];
		}
		else if ($DetailsID == $ArrayDetailID[1]) {
			$otherDetailsID = $ArrayDetailID[0];
		}
	}
	
	return $otherDetailsID;
}

