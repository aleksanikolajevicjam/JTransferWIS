<?
require_once ROOT.'/f/f.php';
require_once ROOT.'/db/db.class.php';

if (isset($_REQUEST['PlaceID']) and $_REQUEST['PlaceID'] > 0) {
	
	ob_start(); 
	MakeCSV($_REQUEST['PlaceID']);
	
	$csv = ob_get_contents();
	ob_end_clean();
	
	$fp = fopen('PriceList_'.$_REQUEST['PlaceID'].'.csv', 'w');
	fwrite($fp, $csv);
	fclose($fp);
	
	echo '<div class="container white pad1em"><h2>Prices exported to CSV</h2>';
	echo '<br>';
	echo '<br>';
	echo 'You can download CSV file here (or Right-Click->Save):';
	echo '<br>';
	echo '<br>';
	echo '<a href="PriceList_'.$_REQUEST['PlaceID'].'.csv">Download CSV</a>';
	echo '<br>';
	echo '<br>';
	echo 'File format: UTF-8, semi-colon (;) delimited';
	echo '</div>';
	
} else { 

$dashboardFilter = '';
$titleAddOn = '';

$driver = false;

if ($_SESSION['AuthLevelID'] == DRIVER_USER) {
	//$dashboardFilter = " AND OwnerID = '".$_SESSION['AuthUserID']."' ";
	$driver = true;
}

?>
<div class="container">
	<h1><?= ALL_PRICES_EXPORT ?></h1>
	<div class="row pad1em">
		<div class="col-sm-3" id="infoShow"></div>

		<? if ( !$driver ) { ?>
			<div class="col-md-12">
				<form name="allPricesExport" action="index.php?p=allPricesExport2" method="post">
					<i class="fa fa-search"></i> <?= LOCATION ?>:<br>
					<select name="PlaceID" id="PlaceID"  class="w100">
						<option value="0"> --- </option>
			
						<?
						require_once '../db/v4_Places.class.php';

						# init class
						$p = new v4_Places();

						$pk = $p->getKeysBy('PlaceNameEN', 'asc');

						foreach($pk as $n => $ID) {
		
							$p->getRow($ID);
							echo '<option value="'.$p->getPlaceID() .'">'.
									$p->getPlaceNameEN().
								 '</option>';

						}
			
						?>
					</select>
					<br><br>
					<button class=" btn btn-primary pull-right" type="submit" name="export"><i class="fa fa-send">
						</i> <?= SUBMIT?>
					</button>
				</form>
			</div>
		<? } else {?>
			<input type="hidden" name="OwnerID" id="OwnerID" value="<?= s('AuthUserID'); ?>">
		<? } ?>
	</div>
</div>
<?
} #end main if






function MakeCSV($id) {

	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();
	$q  = " SELECT * FROM v4_VehicleTypes ";
	
	$w = $db->RunQuery($q);
	
	# Stavi VehicleTypes u array za kasnije
	$vtype = array();
	while($vt = $w->fetch_object()) {
		$vtype[$vt->VehicleTypeID] = $vt->VehicleTypeName;
	}
	#===

	// Delimiter
	$dlm = ";";
	
	# CSV first row
	echo 'DriverID'.$dlm.'RID'.$dlm.'Pax'.$dlm.'Route'.$dlm.'Vehicle'.$dlm.'NettoPrice(EUR)'.$dlm.'SellingPrice(EUR)' . $dlm . "\n";
	//SELECT * FROM `v4_Routes` , v4_Services WHERE v4_Routes.RouteID = v4_Services.RouteID AND //v4_Services.OwnerID = '504' ORDER BY v4_Routes.RouteName ASC, v4_Services.VehicleTypeID ASC
	
	$q  = "SELECT * FROM v4_Routes WHERE FromID = '".$id. "' OR ToID ='" . $id. "'";
	$rr = $db->RunQuery($q);
	
	while($r = $rr->fetch_object()) { // imamo rute
		
		$qdr  = "SELECT * FROM v4_DriverRoutes WHERE RouteID = '".$r->RouteID. "'";
		$drr = $db->RunQuery($qdr);
	
		while($dr = $drr->fetch_object()) { // imamo DriverRoutes
		
			$q1  = "SELECT * FROM v4_Services";
			$q1 .= " WHERE RouteID = '" . $dr->RouteID ."' ";
			$q1 .= " ORDER BY OwnerID ASC, VehicleTypeID ASC";

			$w1 = $db->RunQuery($q1) or die( mysql_error() . '');


			while($s = $w1->fetch_object()) {
		
				if($s->ServicePrice1 > 0) { // ne treba nam bez cijene
					// CSV OUTPUT
					echo $s->OwnerID . $dlm. $s->RouteID . $dlm. $s->VehicleTypeID . $dlm .
							$dr->RouteNameEN . $dlm .
							$vtype[$s->VehicleTypeID] . $dlm . 
							number_format($s->ServicePrice1,2) .  $dlm . 
							number_format(calculateBasePrice($s->ServicePrice1, $dr->OwnerID),2) .  $dlm . 
							//number_format($dr->ReturnPrice,2)  . $dlm .
							"\n";
				}
			}		
		
		}	
		
	}
	
	
}



// Dodavanje dogovorene provizije na osnovnu cijenu - UZETO IZ getCars.php
function calculateBasePrice($price, $ownerid) {
	global $db;
	
		$priceR = round($price, 0, PHP_ROUND_HALF_DOWN);
	
		# Driver
		$q = "SELECT * FROM v4_AuthUsers
					WHERE AuthUserID = '" .$ownerid."' 
					";
		$w = $db->RunQuery($q);
		
		$d = mysqli_fetch_object($w);
		
		if($d->AuthUserID == $ownerid) {
		
			// STANDARD CLASS
			//if($VehicleClass < 11) {
				if ($priceR >= $d->R1Low and $priceR <= $d->R1Hi) return $price + ($price*$d->R1Percent / 100);
				else if ($priceR >= $d->R2Low and $priceR <= $d->R2Hi) return $price + ($price*$d->R2Percent / 100);
				else if ($priceR >= $d->R3Low and $priceR <= $d->R3Hi) return $price + ($price*$d->R3Percent / 100);
				else return $price;
		}
		
		return '0';	
}

