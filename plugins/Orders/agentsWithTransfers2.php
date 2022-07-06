<?
require_once ROOT . '/db/db.class.php';
$db = new DataBaseMysql();
//die('Not ready'); 
//echo '<pre>';print_r($_REQUEST);echo '</pre>';
# Submitted

echo '<div class="container white">';

if(isset($_REQUEST['Submit']) and $_REQUEST['Submit'] == '1') {
	$StartDate 	= $_REQUEST['StartDate'];
	$EndDate	= $_REQUEST['EndDate'];
	$noshow = 0;
	$driverError = 0;
	$CompletedTransfers = 0;
	$Sistem = 0;
	$noshow = $_REQUEST ['NoShow'];
	$driverError = $_REQUEST['DrErr'];
	$Sistem = $_REQUEST['Sistem'];
	$CompletedTransfers = $_REQUEST['CompletedTransfers'];


	$q = "SELECT DISTINCT(UserID) FROM v4_OrderDetails ";


	/*if($Sistem == 1){

		$q = 	"SELECT DISTINCT(UserID) FROM v4_OrderDetails 
				 WHERE PickupDate >= '{$StartDate}'  
				 AND PickupDate <= '{$EndDate}' 
				 AND TransferStatus != '3' 
				 AND TransferStatus != '4' 
				 AND TransferStatus != '9' 
				 AND DriverConfStatus != '5' 
				 AND DriverConfStatus != '6' 
				 AND UserLevelID = '2'
				 ORDER BY UserID ASC";
	} else {

		$q = 	"SELECT DISTINCT(UserID) FROM v4_OrderDetails 
				 WHERE OrderDate >= '{$StartDate}'  
				 AND OrderDate <= '{$EndDate}' 
				 AND TransferStatus != '3' 
				 AND TransferStatus != '4' 
				 AND TransferStatus != '9' 
				 AND DriverConfStatus != '5' 
				 AND DriverConfStatus != '6' 
				 AND UserLevelID = '2'
				 ORDER BY UserID ASC";
	}*/

	if($Sistem == 1){
		$q = 	"SELECT DISTINCT(UserID) FROM v4_OrderDetails 
				 WHERE PickupDate >= '{$StartDate}'  
				 AND PickupDate <= '{$EndDate}' ";
	}			 
		
	else {
		$q = 	"SELECT DISTINCT(UserID) FROM v4_OrderDetails 
				 WHERE OrderDate >= '{$StartDate}'  
				 AND OrderDate <= '{$EndDate}' ";
	}	
	if($CompletedTransfers != 1) {
		//iskljuceni cancel,temp deleted
		$q .=	"AND TransferStatus != '3' 
				 AND TransferStatus != '4' 
				 AND TransferStatus != '9' ";
	}
	else {	
		// samo completed
		$q .=	"AND TransferStatus = '5' ";
	}
			 
	$q .= "AND PaymentMethod = '6' "; 
		 
	//  iskljucen noshow
	if($noshow != 1) $q .=	"AND DriverConfStatus != '5' ";
	// iskljucen driver error
	if($driverError != 1) $q .=	"AND DriverConfStatus != '6' ";
	
	$q .=	"AND UserLevelID = '2'
			 ORDER BY UserID ASC";
			 

	$w = $db->RunQuery($q);



	$totalPrice = $totalInvoice = $totalProvision = 0;

	
	?>
		<h2>Select Agent</h2> 
		<?= $StartDate ?> -> <?= $EndDate?><br>
		<? if($noshow == 1) echo '<i class="fa fa-plus"></i> No-show ';
		if($driverError == 1) echo '<i class="fa fa-plus"></i> Driver Error '; 
		if($CompletedTransfers == 1) echo '<i class="fa fa-plus"></i> Completed Transfers Only '; 
		if($Sistem == 1) echo '<i class="fa fa-plus"></i> Sistem '; ?>
		<br><br>
		<div class="row" style="font-weight:bold">
			<div class="col-md-1 text-right">
				ID
			</div>
			<div class="col-md-9">
				Agent
			</div>
	
		</div>
	
	<?

	while($o = $w->fetch_object()) {
	
		$user = getUserData($o->UserID);
		$userData = trim($user['AuthUserCompany']);
		
		echo '<div class="row" style="border-bottom: 1px solid #ccc">';
		 
		echo '<div class="col-md-1 text-right">'.$o->UserID .'</div>';
		echo '<div class="col-md-9">'.$userData .getConnectedUserNamePlus($o->UserID).'</div>';
		echo '<div class="col-md-1 text-right">';
		echo '<a class="btn white lighten-2" href="index.php?p=agentsBalance&driverid='.$user['AuthUserID'].
			 '&StartDate='.$_REQUEST['StartDate'].'&EndDate='.$_REQUEST['EndDate'].
			 '&NoShow='.$_REQUEST['NoShow'].'&DrErr='.$_REQUEST['DrErr'].'&CompletedTransfers='.$_REQUEST['CompletedTransfers'].'&Sistem='.$_REQUEST['Sistem'].
			 '">'.
			 '<i class="fa fa-play blue-text"></i></a>';
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

	<form action="index.php?p=agentsWTransfers" method="post">
		<div class="row">
			<div class="col-md-12">
				<br>
				<h2>New Agent Invoice</h2>
				<br>
			</div>
		</div>

		<div class="row">
			<div class="col-md-2">
				<label>Start Date</label>
			</div>
			<div class="col-md-4">
				<input type="text" name="StartDate" class="form-control datepicker">
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
				<label>End Date</label>
			</div>
			<div class="col-md-4">
				<input type="text" name="EndDate" class="form-control datepicker">
			</div>
		</div>
		<div class="row"><div class="col-md-12"><hr/></div></div>

		<div class="row">
			<div class="col-md-2">
				<label><b>Sistemi</b></label>
			</div>
			<div class="col-md-4">
				Sistem <input type="checkbox" name="Sistem" class="form-control" value="1">
			</div>
		</div>

		<div class="row"><div class="col-md-12"><hr/></div></div>

		<div class="row">
			<div class="col-md-2">
				<label><b>Include</b></label>
			</div>
			<div class="col-md-3">
				No-show <input type="checkbox" name="NoShow" class="form-control" value="1">
			</div>
			<div class="col-md-3">
				Driver error <input type="checkbox" name="DrErr" class="form-control" value="1">
			</div>
			<div class="col-md-4">
				Completed transfers only <input type="checkbox" name="CompletedTransfers" class="form-control" value="1">
			</div>
		</div>


		<div class="row">
			<div class="col-md-4 col-md-offset-2">
				<br>
				<button class="btn btn-primary" type="submit" name="Submit" value="1">Go</button>
				<br><br>
			</div>
		</div>
	</form>
      
<?}
echo '</div>';


