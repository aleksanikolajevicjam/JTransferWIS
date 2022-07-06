<?
	@session_start();

	require_once ROOT . '/db/db.class.php';

	
    $db = new DataBaseMysql();

	//fix za francusku
    $DriverID = $_SESSION['AuthUserID'];

	$fakeDriverFound = false;

	require_once ROOT . '/cms/fixDriverID.php';
	foreach($fakeDrivers as $key => $fakeDriverID) {
		if($DriverID == $fakeDriverID) {
		    $fakeDriverFound = true;
		    $DriverID = $realDrivers[$key];
		}
	}


	//potrebna polja za query
	$DateFrom = $_REQUEST['DateFrom'];
	$DateTo = $_REQUEST['DateTo'];
	$JamTransfers = 0;
	$TotalTransfers = 0;
	$totalValue = 0;
	$totalCashIn = 0; 
	$totalJAMValue = 0;
	$totalJAMCashIn = 0;
 


	echo '<div class="container white center">';

	//ako imamo oba datuma prikazi izvjestaj
	if( isset($_REQUEST['DateFrom']) and isset($_REQUEST['DateTo']) ){

		showHeader();

		if($fakeDriverFound) $q="SELECT * FROM v4_OrderDetailsFR ";
		else $q  = "SELECT * FROM v4_OrderDetails ";

		$q .= "WHERE (OrderDate >= '".$DateFrom."' AND OrderDate <= '".$DateTo."') ";
		$q .= "AND TransferStatus != '3' ";
		$q .= "AND TransferStatus != '4' ";
		$q .= "AND TransferStatus != '9' ";
		
		$q .= "ORDER BY PickupDate ASC";

		$w = $db->RunQuery($q);

		//ako ima rezultata
		if( $w->num_rows > 0) {  

			while($od = $w->fetch_object() ) {

				$TotalTransfers += 1;
				$totalValue += $od->DetailPrice;
				$totalCashIn += $od->PayLater; 

				if($od->DriverID == 556 or $od->DriverID == 843 or $od->DriverID == 876){
					$JamTransfers += 1;
					$totalJAMValue += $od->DetailPrice;
					$totalJAMCashIn += $od->PayLater; 
				}

			}
			$percentage = ($JamTransfers / $TotalTransfers) * 100;
			$valuePercentage = ($totalJAMValue / $totalValue) * 100;
			$cashInPercentage = ($totalJAMCashIn / $totalCashIn) * 100;
			?>

			<div class="row alert alert-danger" style="margin-left:-15px;padding:4px;text-align:center">
				<div class="col-md-3">
					Total number of transfers: <?=$TotalTransfers?>
				</div>
				<div class="col-md-4">
					Total value of transfers: <?= nf($totalValue, 2) ?> €
				</div>
				<div class="col-md-4">
					Total CashIn of transfers: <?= nf($totalCashIn, 2) ?> €
				</div>
			</div>

			<div class="row alert alert-success" style="margin-left:-15px;padding:4px;text-align:center">
				<div class="col-md-3">
					Number of JAM transfers: <?=$JamTransfers?> (<?= nf($percentage, 2) ?>%)
				</div>
				<div class="col-md-4">
					Total value of JAM transfers: <?= nf($totalJAMValue, 2) ?> € (<?= nf($valuePercentage, 2) ?>%)
				</div>
				<div class="col-md-4">
					Total CashIn of JAM transfers: <?= nf($totalJAMCashIn, 2) ?> € (<?= nf($cashInPercentage, 2) ?>%)
				</div>
			</div>
		<?}
	} else {?>

		<body>
		<style>
		    input, select { width: 200px; }
		    #RequiredFrom, #RequiredTo { visibility: hidden; padding-left: 4px; color: red; }
		    .formLabel { width: 100px; display: inline-block; }
		</style>

		<div class="container col-md-12">
			<h1>Transfers Ratio</h1><br><br><br>

			<form action="" method="POST" type="submit" onsubmit="return validate();">

				<div class="row">
					<div class="col-md-2">
						<label>Date From</label>
					</div>
					<div class="col-md-2">
						<input type="text" value="0" name="DateFrom" class="datepicker">
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<label>Date To</label>
					</div>
					<div class="col-md-2">
						<input type="text" value="0" name="DateTo" class="datepicker">
					</div>
				</div>

				<br>
				<div class="row col-md-4">
			    	<button type="submit" class="btn btn-primary" name="submit"
					style="margin-left: 105px">Submit</button>
				</div>

				<div id="greska"></div>


				</div>
			</form>
		</div>
		</body>
	<?}

	function showHeader() { 

		$dTo = $_REQUEST['DateTo'];
		$dFrom = $_REQUEST['DateFrom'];
		?>

        <h2>Transfers Ratio</h2><br>
		<h3><?=$dFrom?> - <?=$dTo?></h3><br><br>

<?}?>

	<script>

		function validate() {
			if( $("#DateTo").val() == 0 || $("#DateFrom").val() == 0 ) {
				$("#greska").html('<i class="fa fa-times fa-2x fa-spin"></i> Enter all data');
				return false;
			}
		}
	</script>
