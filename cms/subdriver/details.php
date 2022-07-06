<?
$DetailsID = $_REQUEST['id'];
$AuthUserID = $_SESSION['AuthUserID'];

require_once 'subdriver/db.php';
require_once '../db/v4_OrderDetails.class.php';
require_once '../db/v4_OrdersMaster.class.php';
require_once '../db/v4_OrderExtras.class.php';
require_once '../db/v4_AuthUsers.class.php';
require_once '../db/v4_Places.class.php';

$od = new v4_OrderDetails;
$om = new v4_OrdersMaster;
$oe = new v4_OrderExtras;
$au = new v4_AuthUsers;
$op = new v4_Places;

$od->getRow($DetailsID);
$om->getRow($od->getOrderID());

$ExtrasID = $DetailsID;
if ($od->TNo == 2) { // FIXME - TEMP: povratni transfer dobavlja extra usluge od dolaznog transfera
	$odArrival = new v4_OrderDetails;
	$odArrKey = $odArrival->getKeysBy('DetailsID', 'ASC', 'WHERE OrderID = ' . $od->OrderID . ' AND TNo = 1');
	$odArrival->getRow($odArrKey[0]);
	$ExtrasID = $odArrival->DetailsID;
}
$extras = $oe->getKeysBy('ID', 'ASC', 'WHERE OrderDetailsID = ' . $ExtrasID);

$returnTransfer = hasReturn($od->OrderID, $od->TNo, $con);

$paxName = $od->PaxName;

// dohvacanje engleskih imena lokacija iz v4_Places
// ako je FREEFORM, PickupID i DropID su 0,
// pa se imena dohvacaju iz v4_OrderDetails
if (($od->PickupID != 0) and ($od->DropID != 0)) {
	$op->getRow($od->PickupID);
	$PickupName = $op->getPlaceNameEN();
	$op->getRow($od->DropID);
	$DropName = $op->getPlaceNameEN();
} else {
	$PickupName = $od->PickupName;
	$DropName = $od->DropName;
}
if ($od->PaxNo==1) $PaxNo=2;
else $PaxNo=$od->PaxNo;
?>

<div class="container">
	<div class="row">
		<div class="col-xs-6 right">Order :</div>
		<div class="col-xs-6"><b><?= $om->MOrderKey . '-' . $od->OrderID . ' ' . $returnTransfer; ?></b></div>
	</div>
	<div class="row">
		<div class="col-xs-6 right">VehicleType :</div>
		<div class="col-xs-6"><b><?= $od->VehicleType . ' pax' ?></b></div>
	</div>
	<div class="row">
		<div class="col-xs-6"><hr></div>
		<div class="col-xs-6"><hr></div>
	</div>
	<div class="row">
		<div class="col-xs-6 right">Pickup Name :</div>
		<div class="col-xs-6"><b><?= strtoupper($PickupName) ?></b></div>
	</div>
	<div class="row">
		<div class="col-xs-6 right">Pickup Date :</div>
		<div class="col-xs-6"><b><?= convertTime($od->PickupDate) ?></b></div>
	</div>
	<div class="row">
		<div class="col-xs-6 right">Pickup Time :</div>
		<div class="col-xs-6"><b><?= $od->SubPickupTime ?></b></div>
	</div>
	<div class="row">
		<div class="col-xs-6 right">Pickup Address :</div>
		<div class="col-xs-6"><b><?= $od->PickupAddress ?></b></div>
	</div>
	<div class="row">
		<div class="col-xs-6 right">FlightNo :</div>
		<div class="col-xs-6"><b><?= $od->SubFlightNo ?></b></div>
	</div>
	<div class="row">
		<div class="col-xs-6 right">FlightTime :</div>
		<div class="col-xs-6"><b><?= $od->SubFlightTime ?></b></div>
	</div>

	<? if ($od->SubDriver2 != 0) { /* ako ima još vozača na transferu */ ?>
		<div class="row">
			<div class="col-xs-6 right">Vozači :</div>
			<div class="col-xs-6">
				<?
				$au->getRow($od->SubDriver); echo $au->AuthUserRealName;
				$au->getRow($od->SubDriver2); echo '<br>' . $au->AuthUserRealName;
				if ($od->SubDriver3 != 0) { $au->getRow($od->SubDriver3); echo '<br>' . $au->AuthUserRealName; }
				?>
			</div>
		</div>
	<? } ?>

	<div class="row">
		<div class="col-xs-6"><hr></div>
		<div class="col-xs-6"><hr></div>
	</div>
	<div class="row">
		<div class="col-xs-6 right">Drop Name :</div>
		<div class="col-xs-6"><b><?= $DropName ?></b></div>
	</div>
	<div class="row">
		<div class="col-xs-6 right">Drop Address :</div>
		<div class="col-xs-6"><b><?= $od->DropAddress ?></b></div>
	</div>
	<div class="row">
		<div class="col-xs-6"><hr></div>
		<div class="col-xs-6"><hr></div>
	</div>
	<div class="row">
		<div class="col-xs-6 right">Pax Name :</div>
		<div class="col-xs-6"><b><?= $od->PaxName ?></b></div>
	</div>
	<div class="row">
		<div class="col-xs-6 right">Pax Tel :</div>
		<div class="col-xs-6"><b><a href='tel: <?= $om->MPaxTel ?>'><?= $om->MPaxTel ?></a></b></div>
	</div>
	<div class="row">
		<div class="col-xs-6 right">Pax No :</div>
		<div class="col-xs-6"><b><?= $PaxNo ?></b></div>
	</div>
	<div class="row">
		<div class="col-xs-6 right">Notes :</div>
		<div class="col-xs-6"><b><?= $od->PickupNotes ?></b></div>
	</div>

	<div class="row">
		<div class="col-xs-6"><hr></div>
		<div class="col-xs-6"><hr></div>
	</div>

	<? if (count($extras) > 0) { /* dobavi extra services */ ?>
		<div class="row">
			<div class="col-xs-6 right">Extras :</div>
			<div class="col-xs-6">
				<? foreach ($extras as $extra) {
					$oe->getRow($extra);
					echo $oe->ServiceName . ' x' . $oe->Qty . '<br>';
				} ?>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6"><hr></div>
			<div class="col-xs-6"><hr></div>
		</div>
	<? } ?>

	<? if ($od->TNo == 2) { /* informacije o dolaznom transferu */ ?>
		<div class="row">
			<div class="col-xs-6 right">Vozili :</div>
			<div class="col-xs-6">
				<?
					$od2 = new v4_OrderDetails;
					$arrival = $od2->getKeysBy('DetailsID', 'ASC', 'WHERE OrderID = ' . $od->OrderID . ' AND TNo = 1');
					$od2->getRow($arrival[0]);
					if ($od2->SubDriver != 0) { $au->getRow($od2->SubDriver); echo $au->AuthUserRealName; }
					if ($od2->SubDriver2 != 0) { $au->getRow($od2->SubDriver2); echo '<br>' . $au->AuthUserRealName; }
					if ($od2->SubDriver3 != 0) { $au->getRow($od2->SubDriver3); echo '<br>' . $au->AuthUserRealName; }
				?>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6 right">Final Notes :</div>
			<div class="col-xs-6"><?= $od2->FinalNote . '<br>' . $od2->SubFinalNote ?></div>
		</div>
		<div class="row">
			<div class="col-xs-6"><hr></div>
			<div class="col-xs-6"><hr></div>
		</div>
	<? } ?>

	<div class="row">
		<div class="col-xs-6 right">Driver Notes :</div>
		<div class="col-xs-6"><b><?= $od->SubDriverNote ?></b></div>
	</div>
	<div class="row">
		<div class="col-xs-6"><hr></div>
		<div class="col-xs-6"><hr></div>
	</div>

	<? /* NAPOMENA:
			prikazuje se samo za prvog SubDrivera,
			ako je povratni transfer, iznos naplate je
			podatak "Total" iz potvrde minus "Naplaćeno" iz prvog transfera
			(CashIn2 = PayLater1 + PayLater2 - CashIn1),
			u suprotnom je samo cash (PayLater) iz ovoga transfera
		  2017-06-01 - ako je sve placeno online (PayNow), isto preskoci
		  2017-10-30 - $od2 je dolazni transfer (prvi) */
	if ($AuthUserID == $od->SubDriver) { ?>
		<div class="row">
			<div class="col-xs-6 right">Naplata <strong><?$au->getRow($od->SubDriver); echo '('.$au->AuthUserRealName.')';?></strong> :</div>
			<div class="col-xs-6"><b>
				<? 
				$cr_arr=array(556,2637,2828);
				if (in_array($od->DriverID,$cr_arr)) {
					$sql = 'SELECT Average FROM v4_ExchangeRate WHERE Name = "EUR"';
					$rEur = $db->RunQuery($sql);
					$Eur = $rEur->fetch_assoc();
				}	
				if (($od->TNo == 2) and ($od->DetailPrice != $od->PayNow)) {
					$CashIn = $od->PayLater + $od2->PayLater - $od2->CashIn;
					if (in_array($od->DriverID,$cr_arr)) echo number_format($CashIn*$Eur['Average'],2) .' HRK / ';
					echo $CashIn .' EUR';
					//echo $om->MOrderCurrencyPrice - $od2->CashIn . ' Eur';
				} else {
					if (in_array($od->DriverID,$cr_arr)) echo number_format($od->PayLater*$Eur['Average'],2) .' HRK / ';
					echo $od->PayLater . ' EUR ';
				}	
				if ($od->getPayNow()>0 && $od->getPayLater()>0) echo "<b style='color:red'> IZDATI RAČUN !</b>"; 
				
				
				
				?>
			</b></div>
		</div>
		<div class="row">
			<div class="col-xs-6"><hr></div>
			<div class="col-xs-6"><hr></div>
		</div>
	<? } ?>

	<div class="row">
		<div class="col-xs-6 right">Receipt PDF :</div>
		<div class="col-xs-6"><b><?= '<a href="https://www.jamtransfer.com/cms/raspored/PDF/'.$od->PDFFile.'">'.$od->PDFFile.'</a>' ?></b></div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-xs-6 pad1em">
			<a href="index.php?p=sign&paxname=<?= $paxName ?>&id=<?= $DetailsID ?>"
			class="col-xs-12 btn btn-lg btn-info">Welcome Sign</a>
		</div>
		<div class="col-xs-6 pad1em">
			<a href="index.php?p=finished&id=<?= $DetailsID ?>"
			class="col-xs-12 btn btn-lg btn-danger">Finished</a>
		</div>

	</div>

	<div class="row">
		<div class="col-xs-6 pad1em">
			<a href="index.php?p=nalog&id=<?= $DetailsID ?>"
			class="col-xs-12 btn btn-lg btn-info">Putni nalog</a>
		</div>
		<div class="col-xs-6 pad1em">
			<a href="index.php?p=racun&id=<?= $DetailsID ?>"
			class="col-xs-12 btn btn-lg btn-info">Receipt</a> 
		</div>
	</div>
</div>

<?
function hasReturn($OrderID, $TNo, $con) {
	$q  = "SELECT * FROM v4_OrderDetails";
	$q .= " WHERE OrderID = '" . $OrderID . "' AND TNo > '".$TNo."'";
	$q .= " ORDER BY DetailsID ASC ";
	$qr = mysqli_query($con, $q) or die('Error in hasReturn query <br/>' . mysqli_connect_error());	
	
	$num_rows = mysqli_num_rows($qr);
	
	//if ($num_rows == 2) {
		$o = mysqli_fetch_object($qr);
		if($o->OrderID ==  $OrderID and $o->TNo != $TNo) {
			$ret = ' R ' . convertTime($o->PickupDate) . ' ' . $o->SubPickupTime;
			return $ret;
		}
		
	return '';
}

