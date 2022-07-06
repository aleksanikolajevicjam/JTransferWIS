<?
require_once ROOT . '/db/db.class.php';
$db = new DataBaseMysql();

# Submitted

echo '<div class="container white">';

if(isset($_REQUEST['Submit']) and $_REQUEST['Submit'] == '1') {
	$StartDate 	= $_REQUEST['StartDate'];
	$EndDate	= $_REQUEST['EndDate'];
	
	$q = 	"SELECT DISTINCT(DriverID) FROM v4_OrderDetails 
			 WHERE PickupDate >= '{$StartDate}'  
			 AND PickupDate <= '{$EndDate}' 
			 AND TransferStatus != '3' 
			 AND TransferStatus != '4' 
			 AND TransferStatus != '9' 
			 AND PayLater > DriversPrice 
			 ORDER BY DriverID ASC";
			 
	$w = $db->RunQuery($q);

	$totalPrice = $totalInvoice = $totalProvision = 0;
	

	
	
	?>
		<h2>Select driver</h2> 
		<?= $StartDate ?> -> <?= $EndDate?><br><br>
		<div class="row" style="font-weight:bold;border-bottom:1px solid #ccc; padding-bottom:5px">
			<div class="col-md-1 text-right">
				ID
			</div>
			<div class="col-md-8">
				Driver
			</div>
			<div class="col-md-1">
				Balance
			</div>
	
		</div>
	
	<?

	while($o = $w->fetch_object()) {
	
		$user = getUserData($o->DriverID);
		$userData = trim($user['Country']).' - '.trim($user['Terminal']).' - '.
					trim($user['AuthUserCompany']).' - '.trim($user['AuthUserTel']);
		
		echo '<div class="row" style="border-bottom: 1px solid #ccc">';
		 
		echo '<div class="col-md-1 text-right">'.$o->DriverID .'</div>';
		echo '<div class="col-md-8">'.$userData .getConnectedUserNamePlus($o->DriverID).'</div>';
		echo '<div class="col-md-1 text-right">'
				.nf(getDriversBalance($StartDate, $EndDate, $o->DriverID ) ).
			 '</div>';
		echo '<div class="col-md-1 text-right">';
		echo '<a class="btn white lighten-2" href="index.php?p=driversBalanceCash&driverid='.$user['AuthUserID'].
			 '&StartDate='.$_REQUEST['StartDate'].'&EndDate='.$_REQUEST['EndDate'].'">'.
			 '<i class="fa fa-play red-text"></i></a>';
		echo '</div>';
		

		/*
		echo '<div class="col-md-2 text-right">'.$o->OrderPrice .'</div>';
		echo '<div class="col-md-2 text-right">'.$o->InvoiceAmount .'</div>';
		echo '<div class="col-md-2 text-right">'.$o->ProvisionAmount .'</div>';
		*/
		echo '</div>';
		/*
		$totalPrice += $o->OrderPrice;
		$totalInvoice += $o->InvoiceAmount;
		$totalProvision += $o->ProvisionAmount;
		*/
	}

	echo '<br>**END OF LIST**<br><br>';
	/*
	echo '<div class="row" style="font-weight:bold;background:#f5f5f5">';
	echo '<div class="col-md-2 col-md-offset-3 text-right">'.number_format($totalPrice,2) . '</div>';
	echo '<div class="col-md-2 text-right">'.number_format($totalInvoice,2) . '</div>';
	echo '<div class="col-md-2 text-right">'.number_format($totalProvision,2) . '</div>';
	echo '</div>'; 
	*/
}
else {
?>

	<form action="index.php?p=driversWTransfersCash" method="post">
		<div class="row">
			<div class="col-md-12">
				<h2>New Driver Invoice</h2> 
			</div>
		</div>

		<div class="row">
			<div class="col-md-2">
				<label>Start Date:</label>
			</div>
			<div class="col-md-4">
				<input type="text" name="StartDate" class="form-control datepicker">
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
				<label>End Date:</label>
			</div>
			<div class="col-md-4">
				<input type="text" name="EndDate" class="form-control datepicker">
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 col-md-offset-2">
				<br>
				<button class="btn btn-primary" type="submit" name="Submit" value="1">Go</button>
			</div>
		</div>
	</form>
      
<?}
echo '</div>';

function GetDriverNameNew($driver) {
	$q = "SELECT * FROM Drivers WHERE DriverID = '" . $driver ."'";
	$w = mysql_query($q) or die( mysql_error() . ' GetDriverName');
	$d = mysql_fetch_object($w);
	return trim($d->Country).' - '.trim($d->Terminal).' - '.trim($d->Prezime).' - '.trim($d->Tel);
}

function getDriversBalance($start, $end, $driver) {
	require_once ROOT . '/db/v4_OrderDetails.class.php';

	
	$od = new v4_OrderDetails();

	//$whereD  = " WHERE DriverID ='" . $driver ."' ";
	if (getConnectedUser($driver)>0) $whereD= ' WHERE (DriverID = ' . $driver . '  OR DriverID =  '.getConnectedUser($driver). ') '; 
	else $whereD  = " WHERE DriverID ='" . $driver ."' ";
	
	$whereD .= " AND PickupDate >= '{$start}' AND PickupDate <= '{$end}' ";
	$whereD .= " AND TransferStatus != 3 ";
	$whereD .= " AND TransferStatus != 4 ";
	$whereD .= " AND TransferStatus != 9 ";	
	$whereD .= " AND PayLater > DriversPrice ";	
	
		
	$kd = $od->getKeysBy('DetailsID', 'asc', $whereD);						
						
	foreach($kd as $nn => $id) {
		$od->getRow($id);
		$driversPriceSum += $od->getDriversPrice()+$od->DriverExtraCharge;
		$cashTotal		+= $od->getPayLater();

	} //endforeach	

	return $cashTotal - $driversPriceSum;	
}

