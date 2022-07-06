<?
	require_once ROOT . '/db/db.class.php';
	$db = new DataBaseMysql();

# Submitted
?>
	<div class="container white pad1em">
		<h2><?= TAXI_SITE_ORDERS.'-'.BOOKING_DATE ?></h2>
		<br>
<?
if(isset($_REQUEST['OrdersSubmit']) and $_REQUEST['OrdersSubmit'] == '1') {
	$StartDate 	= $_REQUEST['StartDate'] ;
	$EndDate	= $_REQUEST['EndDate'];
	$UserID		= $_REQUEST['UserID'];
	
	$q = 	"SELECT * FROM v4_OrderDetails  
			 WHERE OrderDate >= '{$StartDate}'  
			 AND OrderDate <= '{$EndDate}'  
			 AND TransferStatus != '3' 
			 AND TransferStatus != '4'  
			 AND TransferStatus != '9' 
			 AND UserLevelID = '12'
			 ";
	if($UserID != 0) 
	$q .= 	" AND UserID = '{$UserID}'";
	$q .=	" ORDER BY OrderDate ASC";
			 
	$w = $db->RunQuery($q);

	$totalPrice = $totalInvoice = $totalProvision = $totalDriversPrice = 0;
	?>

		
		<?= $StartDate ?> <=> <?= $EndDate?><br><br>
		<div class="row" style="font-weight:bold;border-bottom:1px solid #eee">
			<div class="col-md-1">
				Br.
			</div>
			<div class="col-md-1">
				ID / Date
			</div>
			<div class="col-md-3 text-right">
				User
			</div>
			<div class="col-md-2 text-right">
				1.OrderPrice
			</div>
			<!--
			<div class="col-md-2 text-right">
				2.ProvisionAmount
			</div>
			-->			
			<div class="col-md-2 text-right">
				2.DriversPrice
			</div>	
			<div class="col-md-2 text-right">
				1-2=
			</div>
		</div>
	
	<?
	
	$i = 0;
	// Delimiter
	$dlm = ";";
	
	# CSV first row
	$CSV = 	'Br.'.$dlm.
			'Datum'.$dlm.
			'Rezervacija'.$dlm.
			'Ukupna cijena'.$dlm.
			'Netto cijena'.$dlm.
			'Način plaćanja' . $dlm .
			'Provizija' . $dlm .  
			"\n";	
			
			
	while($o = $w->fetch_object()) {
		$i++;	

		$userData = getUserData($o->UserID);
		
		echo '<div class="row" style="border-bottom:1px solid #eee;white-space:nowrap">';
		 
		echo '<div class="col-md-1"><strong>'.$i .'</strong></div>';
		echo '<div class="col-md-1"><strong>'.$o->OrderID .'-'.$o->TNo.'</strong><br><small>'.$o->OrderDate.'</small></div>';
		echo '<div class="col-md-3">';
		echo '<small><strong>';
		echo $userData['AuthUserCompany'];
		echo '</strong><br>';
		echo  $o->PickupName.'-'.$o->DropName;
		echo '</small></div>';
		echo '<div class="col-md-2 text-right">'.$o->DetailPrice .'</div>';
		//echo '<div class="col-md-2 text-right">'.$o->InvoiceAmount .'</div>';
		//echo '<div class="col-md-2 text-right">'.$o->ProvisionAmount .'</div>';
		
		$note = '';
		if($o->DriversPrice == 0) {
			$note = ' ?';
			$driversPrice = '0.00';
		}
		else $driversPrice = $o->DriversPrice;
		
		//$driversPrice = $driversPrice * $o->VehiclesNo; //bilo je ovdje 02/12/2015 
		
		echo '<div class="col-md-2 text-right">'.$driversPrice . $note . '</div>';
		
		$netto = $o->DetailPrice - $o->ProvisionAmount - $driversPrice;
		echo '<div class="col-md-2 text-right">'.number_format($netto,2) .'</div>';
		
		echo '</div>';
		
		$totalPrice += $o->DetailPrice;
		$totalInvoice += $o->InvoiceAmount;
		$totalProvision += $o->ProvisionAmount;
		$totalDriversPrice += $driversPrice;
		$totalNetto += $netto;

		
		$CSV .=	$i . $dlm. $o->OrderDate . $dlm. $o->OrderID .'-'.$o->TNo . $dlm .
		$o->OrderPrice . $dlm . $driversPrice  . $dlm .
		'Cash' . $dlm . 
		number_format($netto, 2) . $dlm . 
		"\n";


	}
	
	echo '<div class="row" style="font-weight:bold;background:#f5f5f5">';
	echo '<div class="col-md-2 col-md-offset-5 text-right">'.number_format($totalPrice,2) . '</div>';
	//echo '<div class="col-md-2 text-right">'.number_format($totalInvoice,2) . '</div>';
	//echo '<div class="col-md-2 text-right">'.number_format($totalProvision,2) . '</div>';
	echo '<div class="col-md-2 text-right">'.number_format($totalDriversPrice,2) . '</div>';
	echo '<div class="col-md-2 text-right">'.number_format($totalNetto,2) . '</div>';
	echo '</div>'; 
	

/*	
	$fp = fopen('TaxiSite_'.$UserID.'.csv', 'w');
	fwrite($fp, $CSV);
	fclose($fp);
	
	echo '<h2>Prices exported to CSV</h2>';
	echo '<br>';
	echo '<br>';
	echo 'You can download CSV file here (or Right-Click->Save):';
	echo '<br>';
	echo '<br>';
	echo '<a href="TaxiSite_'.$UserID.'.csv">Download CSV</a>';
	echo '<br>';
	echo '<br>';
	echo 'File format: UTF-8, semi-colon (;) delimited';	
*/	
	
}
else {
?>

	<form id="prometCSV" action="index.php?p=taxiSiteOrdersBookingDate" method="post">
		<div class="row">
			<div class="col-md-2">
				<label>Start Date</label>
			</div>
			<div class="col-md-4">
				<input type="text" name="StartDate" class="xform-control datepicker">
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
				<label>End Date</label>
			</div>
			<div class="col-md-4">
				<input type="text" name="EndDate" class="xform-control datepicker">
			</div>
		</div>

		<div class="row">
			<div class="col-md-2">
				<label>User</label>
			</div>
			<div class="col-md-4">
				<select name="UserID" class="form-control">
					<option value="0"> All </option>
					<?
						$q = "SELECT * FROM v4_AuthUsers 
							  WHERE AuthLevelID=12 
							  ORDER BY AuthUserRealName ASC";
							  
						$z = $db->RunQuery($q);
						
						while($u = $z->fetch_object()) {
							echo '<option value="'.$u->AuthUserID.'">' . $u->AuthUserRealName . '</option>';
						}
					
					
					?>
				</select>
			</div>
		</div>


		<div class="row">
			<div class="col-md-4 col-md-offset-2">
				<br>
				<button class="btn btn-primary" type="submit" name="OrdersSubmit" value="1">Go</button>
			</div>
		</div>
	</form>
 <script>
 	$("#prometCSV > .datepicker").datepicker({dateFormat: 'yy-mm-dd'});
 </script>     

<? } ?>
</div>


