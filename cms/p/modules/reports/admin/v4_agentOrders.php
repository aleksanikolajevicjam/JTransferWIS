<?
# Submitted
error_reporting(E_PARSE);
@session_start();

if (!$_SESSION['UserAuthorized']) die('Not authorized');

require_once ROOT."/db/db.class.php";
require_once ROOT."/db/v4_Places.class.php";
require_once ROOT."/f/f.php";
$db = new DataBaseMysql();

/* mogucnost biranja vise tipova korisnika (#797) */
if (!empty($_REQUEST['UserTypeAdvanced'])) {
	$UserTypes = $_REQUEST['UserTypeAdvanced'];
	$multipleUserTypes = true;
} else $multipleUserTypes = false;

if(isset($_REQUEST['AgentsOrdersSubmit']) and $_REQUEST['AgentsOrdersSubmit'] == '1') {
	$StartDate 	= $_REQUEST['StartDate']; 
	$EndDate	= $_REQUEST['EndDate'];
	$UserType	= $_REQUEST['UserType'];
	$ByWhat = $_REQUEST['ByWhat'];
	
	if($ByWhat == '1') {
		$sqlPart = "PickupDate >= '".$StartDate."'  AND PickupDate <= '".$EndDate."'";
		$title = ORDERS_BY_TR_DATE;
	}
	else if($ByWhat == '2') {
		$sqlPart = "OrderDate >= '".$StartDate."'  AND OrderDate <= '".$EndDate."'";
		$title = ORDERS_BY_B_DATE;
	}
	
	$q  = "SELECT * FROM v4_OrderDetails WHERE ";
	$q .= $sqlPart;
	$q .= " AND TransferStatus != '3' AND TransferStatus != '9' AND TransferStatus != '4' AND TransferStatus !=6 ";

	if ($multipleUserTypes) {
		$q .= ' AND (';
		foreach ($UserTypes as $key => $UType) {
			if ($key != 0) $q .= ' OR ';
			$q .= 'UserLevelID = ' . $UType;
		}
		$q .= ')';
	} else $q .= " AND UserLevelID = '{$UserType}' ";
	
	if(isset($_REQUEST['FromID']) and $_REQUEST['FromID'] > 0) {
		// $q .= " AND (PickupID = '" . $_REQUEST['FromID'] ."' ";
		// $q .= " OR DropID = '" . $_REQUEST['FromID'] ."') ";
		/* umjesto gornje dvije linije se trazi po imenu lokacije
			zbog freefrom bookinga koji ne zapisuje FromID (#797) */
		$fromPlace = new v4_Places();
		$fromPlace->getRow($_REQUEST['FromID']);
		$fromPlaceName = $fromPlace->getPlaceNameEN();
		$q .= " AND (PickupName LIKE '" . $fromPlaceName ."%' ";
		$q .= " OR DropName LIKE '" . $fromPlaceName ."%') ";
	}
	
	$q .= " ORDER BY DetailsID ASC";

	$w = $db->RunQuery($q) or die( mysql_error() . ' on Orders');

	$totalPrice = $totalInvoice = $totalProvision = 0;
	?>
	<div class="container white pad1em">
		<h2><?= ORDERS ?> <?= $title ?></h2> 
		<?= $StartDate ?> &rarr; <?= $EndDate?><br><br>
		<div class="row" style="font-weight:bold">
			<div class="col-md-1 text-right">
				No
			</div>
			<div class="col-md-1">
				ID
			</div>
			<div class="col-md-1">
				User
			</div>
			<div class="col-md-1">
				PaxName
			</div>
			<div class="col-md-1">
				Route
			</div>
			<div class="col-md-1 text-right">
				OrderPrice
			</div>
			<div class="col-md-1 text-right">
				Neto
			</div>
			<div class="col-md-1 text-right">
				Invoice
			</div>
			<div class="col-md-1 text-right">
				Online
			</div>			
			<div class="col-md-1 text-right">
				Cash
			</div>			
			<div class="col-md-1 text-right">
				Provision
			</div>			
			<div class="col-md-1 text-right">
				Gross margin
			</div>				
		</div>
	
	<?
	$i = 1;
	while($o = $w->fetch_object()) {
	    
		$m = "SELECT * FROM v4_OrdersMaster WHERE ";
		$m .= "MOrderID = '". $o->OrderID."'";
		$w2 = $db->RunQuery($m);
		$om = $w2->fetch_object();

	    $UserData = getUserData($o->UserID);
	    $UserName = $UserData['AuthUserCompany'];

		echo '<div class="row" style="border-top:1px solid #aaa;">';
		echo '<div class="col-md-1 right">'.$i.'</div>';
		echo '<div class="col-md-1" style="font-size:.8em">'.$om->MOrderKey.'-'.$o->OrderID .'-'.$o->TNo .'</div>';
		echo '<div class="col-md-1" style="font-size:.6em">'.$UserName .'</div>';
		echo '<div class="col-md-1" style="font-size:.8em">'.$o->PaxName .'</div>';
		echo '<div class="col-md-1" style="font-size:.8em">'.$o->PickupName." - ".$o->DropName.'</div>';
		echo '<div class="col-md-1 right">'.$o->DetailPrice .'</div>';
		echo '<div class="col-md-1 right">'.$o->DriversPrice .'</div>';
		echo '<div class="col-md-1 right">'.$o->InvoiceAmount .'</div>';
		echo '<div class="col-md-1 right">'.$o->PayNow .'</div>';
		echo '<div class="col-md-1 right">'.$o->PayLater .'</div>';		
		echo '<div class="col-md-1 right">'.$o->ProvisionAmount .'</div>';
		echo '<div class="col-md-1 right">'.number_format($o->InvoiceAmount+$o->PayNow+$o->PayLater-$o->DriversPrice,2).'</div>';
		echo '</div>';

		$i++;
		$totalPrice += $o->DetailPrice;
		$totalDriversPrice += $o->DriversPrice;
		$totalInvoice += $o->InvoiceAmount;
		$totalPayNow += $o->PayNow;
		$totalPayLater += $o->PayLater;
		$totalProvision += $o->ProvisionAmount;
	}

	echo '<div class="row" style="font-weight:bold;background:#f5f5f5">';
	echo '<div class="col-md-1 col-md-offset-5 right">'.number_format($totalPrice,2) . '</div>';
	echo '<div class="col-md-1 right">'.number_format($totalDriversPrice,2) . '</div>';
	echo '<div class="col-md-1 right">'.number_format($totalInvoice,2) . '</div>';
	echo '<div class="col-md-1 right">'.number_format($totalPayNow,2) . '</div>';	
	echo '<div class="col-md-1 right">'.number_format($totalPayLater,2) . '</div>';		
	echo '<div class="col-md-1 right">'.number_format($totalProvision,2) . '</div>';
	echo '<div class="col-md-1 right">'.number_format($totalInvoice+$totalPayNow+$totalPayLater-$totalDriversPrice,2) . '</div>';	
	echo '</div></div>'; 
}
else {
?>

<style>
	#AdvancedUserType {
		margin-bottom: 10px;
	}
	#AdvancedUserType input {
		height: 1em;
	}
</style>

<div class="container">
	<form action="index.php?p=agentOrders" method="post">
		<div class="row">
			<div class="col-md-2">
				<label>User type</label>
			</div>
			<div class="col-md-4">
				<select id="UserType" name="UserType" class="form-control">
					<option value="91"><?= ADMIN ?></option>
					<option value="4"><?= AFFILIATE ?></option>
					<option value="2"><?= AGENT ?></option>
					<option value="6"><?= APIUSER ?></option>
					<option value="3"><?= CUSTOMER ?></option>
					<option value="12"><?= TAXISITE ?></option>
					<option value="41"><?= OPERATOR ?></option>

				</select>
			</div>
			<div class="col-md-1">
				<button class="btn" id="showAdvanced" type="button">More</button>
			</div>
		</div>

		<div id="AdvancedUserType" class="row" style="display:none">
			<div class="col-md-2"></div>
			<div class="col-md-4">
				<div class="row">
					<div class="col-md-6">
						<input type="checkbox" name="UserTypeAdvanced[]" value="91"> Admin<br>
						<input type="checkbox" name="UserTypeAdvanced[]" value="4"> Affiliate<br>
						<input type="checkbox" name="UserTypeAdvanced[]" value="2"> Agent<br>
						<input type="checkbox" name="UserTypeAdvanced[]" value="6"> ApiUser<br>
					</div>
					<div class="col-md-6">
						<input type="checkbox" name="UserTypeAdvanced[]" value="3"> Customer<br>
						<input type="checkbox" name="UserTypeAdvanced[]" value="41"> Operator<br>
						<input type="checkbox" name="UserTypeAdvanced[]" value="12"> Taxisite<br>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-2">
				<label>By</label>
			</div>
			<div class="col-md-4">
				<select name="ByWhat" class="form-control">
					<option value="1"
					<? if($_REQUEST['ByWhat'] == '1') echo 'selected' ?>
					><?= BY_TRANSFER_DATE ?></option>
					<option value="2"
					<? if($_REQUEST['ByWhat'] == '2') echo 'selected' ?>
					><?= BY_BOOKING_DATE ?></option>
				</select>
			</div>
		</div>


		<div class="row">
			<div class="col-md-2">
				<label>From</label>
			</div>
			<div class="col-md-4">
				<select name="FromID" class="form-control">
					<option value="0">All</option>
					<?
					$wf = $db->RunQuery("SELECT * FROM v4_Places ORDER BY PlaceNameEN ASC");
					while($p = $wf->fetch_object() ) {
						echo '<option value="'.$p->PlaceID.'">'.$p->PlaceNameEN.'</option>';
					}
					?>
				</select>
			</div>
		</div>


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
			<div class="col-md-4 offset-l2">
				<br>
				<button class="btn btn-primary" type="submit" name="AgentsOrdersSubmit" value="1">Go</button>
			</div>
		</div>
	</form>
</div>

<script>
	var showAdvanced = document.getElementById("showAdvanced");
	showAdvanced.addEventListener("click", showMore);
	function showMore () {
		var AdvancedUserType = document.getElementById("AdvancedUserType");
		var UserType = document.getElementById("UserType");
		if (AdvancedUserType.style.display == "block") {
			AdvancedUserType.style.display = "none";
			UserType.disabled = false;
			showAdvanced.innerHTML = "More"
		}
		else {
			AdvancedUserType.style.display = "block";
			UserType.disabled = true;
			showAdvanced.innerHTML = "Less"
		}
	}
</script>
      
<?}
