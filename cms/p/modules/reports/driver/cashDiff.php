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
	$SubDriverID = $_REQUEST['SubDriverID'];
	$NumberOfTransfers = 0;
	$TotalPayLater = 0;
	$TotalCashIn = 0;
	$NumberOfCashDiffTransfers = 0;

	echo '<div class="container white center">';

	//ako imamo oba datuma prikazi izvjestaj
	if( isset($_REQUEST['DateFrom']) and isset($_REQUEST['DateTo']) ){

		showHeader();

		if($fakeDriverFound) $q="SELECT * FROM v4_OrderDetailsFR ";
		else $q  = "SELECT * FROM v4_OrderDetails ";

		$q .= "WHERE DriverID = '".$DriverID."' ";
		$q .= "AND (PickupDate >= '".$DateFrom."' AND PickupDate <= '".$DateTo."') ";
		$q .= "AND TransferStatus != '3' ";
		$q .= "AND TransferStatus != '4' ";
		$q .= "AND TransferStatus != '9' ";
		
		if( isset($_REQUEST['SubDriverID']) ) {

			$q .= "AND (SubDriver = '".$SubDriverID."' ";
			$q .= "OR SubDriver2 = '".$SubDriverID."' ";
			$q .= "OR SubDriver3 = '".$SubDriverID."') ";
		}

		$q .= "ORDER BY PickupDate ASC";

		$w = $db->RunQuery($q);

		//ako ima rezultata
		if( $w->num_rows > 0) {  

			while($od = $w->fetch_object() ) {

				$NumberOfTransfers += 1;
				$TotalCashIn = $TotalCashIn + $od->CashIn;
				$TotalPayLater = $TotalPayLater + $od->PayLater;

				if($od->CashIn != $od->PayLater) {
					$color = 'red';
					$NumberOfCashDiffTransfers += 1;
				}
				else $color = '';

				?>
				
				<div class="row pad1em" style="border-bottom:1px solid #ddd;">
				    <div class="col-md-1">
				    <? if(!$fakeDriverFound) { ?>
					    <a href="https://www.jamtransfer.com/cms/printTransfer.php?OrderID=
					    <?= $od->OrderID ?>" target="_blank"><?= $od->OrderID ?>-<?= $od->TNo ?></a>
					<? } else { ?>
					    <a href="https://www.jamtransfer.com/cms/printTransferFR.php?DetailsID=
					    <?= $od->DetailsID ?>" target="_blank"><?= $od->OrderID ?>-<?= $od->TNo ?></a>
					<? } ?>
				    </div>
				    <div class="col-md-4">
				        <?=$od->PickupDate ?> <?=$od->PickupTime ?><br>
				        <?=$od->PaxName ?><br>
				        <?=$od->PickupName ?>-<?=$od->DropName ?>
				    </div>
					<div class="col-md-3">
				        <?=$od->SubDriverNote ?> 
				    </div>
				    <div class="col-sm-2 pad1em">
				        <?=$od->PayLater ?> €
				    </div>	
				    <div class="col-sm-2 <?=$color?> pad1em">
				        <?=$od->CashIn ?> € 
				    </div>
				</div>
			<?}?>

			<div class="row alert alert-success" style="margin-left:-15px;padding:4px;text-align:center">
				<div class="col-md-3">
					Transfers with Cash Difference: <?=$NumberOfCashDiffTransfers?>
				</div>

				<div class="col-md-3">
					Total Transfers: <?=$NumberOfTransfers?>
				</div>

				<div class="col-md-3">
					Total Pay Later: <?=$TotalPayLater?> €
				</div>

				<div class="col-md-3">
					Total CashIn: <?=$TotalCashIn?> €
				</div>
			</div>

		<?}
	} else {//otvori formu dateTo datefrom i subdriver dropdown izvuc iz v4_Authuser di im je lvl 32 i driverid iz sessiona meotda je post-submit i dodat validaciju?>

		<body>
		<style>
		    input, select { width: 200px; }
		    #RequiredFrom, #RequiredTo { visibility: hidden; padding-left: 4px; color: red; }
		    .formLabel { width: 100px; display: inline-block; }
		</style>

		<div class="container col-md-12">
			<h1>Cash Difference</h1><br><br><br>

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

				<div class="row">
				    <div class="col-md-2">
						<label>SubDriver</label>
					</div>
					<div class="col-md-2">
						<select name="SubDriverID" id="SubDriverID">

						    <option value="0"> --- </option>
						        <?
						        $q  = "SELECT AuthUserID, AuthUserRealName FROM v4_AuthUsers ";
						        $q .= "WHERE DriverID = '".$_SESSION['AuthUserID']."' ";
								$q .= "AND AuthLevelID = '32' ";
								$q .= "ORDER BY AuthUserRealName ASC";

						        $w  = $db->RunQuery($q);

						        while($subDriver = $w->fetch_object()) {
						            echo '<option value="'.$subDriver->AuthUserID.'">';
						            echo $subDriver->AuthUserRealName . '</option>';
						        }
						        ?>

						</select>
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

		global $SubDriverID;
		$dTo = $_REQUEST['DateTo'];
		$dFrom = $_REQUEST['DateFrom'];


		$driver = getUser($SubDriverID);
	 
 	    ?>
        <h2>Cash Difference</h2>
        <h2><?=$driver->AuthUserRealName; ?></h2>
		<h3><?=$dFrom?> - <?=$dTo?></h3><br><br>

		<div class="row" style="border-bottom:1px solid #000;">
		    <div class="col-md-1">
		        <strong>OrderID</strong>
		    </div>
		    <div class="col-md-4">
		        <strong>Transfer Info</strong>
		    </div>
			<div class="col-md-3">
		        <strong>Driver Notes</strong>
		    </div>
		    <div class="col-sm-2 ">
		        <strong>Pay Later (EUR)</strong>
		    </div>	
		    <div class="col-sm-2">
		        <strong>Cash In (EUR)</strong> 
		    </div>
		</div>
	    <?
	}?>

    </div><br><br><br>   

	<script>

		function validate() {
			if( $("#DateTo").val() == 0 || $("#DateFrom").val() == 0 ) {
				$("#greska").html('<i class="fa fa-times fa-2x fa-spin"></i> Enter all data');
				return false;
			}
		}
	</script>























