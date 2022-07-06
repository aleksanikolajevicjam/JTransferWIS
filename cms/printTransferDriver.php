<?
session_start();

require_once ROOT . '/cms/headerScripts.php';
require_once ROOT . '/f/f.php';
require_once ROOT . '/lng/en.php';
	
?>
<body>
	<div class="container">
	<?= PrintTransferDriver($_REQUEST['DetailsID']) ?>
	</div>
</body>
</html>	
<?
function PrintTransferDriver($DetailsID) {
	//echo '<pre>'; print_r($_REQUEST); echo '</pre>';


	if(!empty($DetailsID) and is_numeric($DetailsID)) {
		//$OrderID = $_REQUEST['OrderID'];
	}
	else die(TRANSFER_MISSING);

	define("NL", '<br>'); 
	require_once ROOT . '/db/v4_OrdersMaster.class.php';
	require_once ROOT . '/db/v4_OrderDetails.class.php';
	require_once ROOT . '/db/v4_OrderDetailsFR.class.php';
	require_once ROOT . '/db/v4_OrderExtras.class.php';
	require_once ROOT . '/db/v4_AuthUsers.class.php';
	require_once ROOT . '/db/v4_Places.class.php';

	// classes

	if($_SESSION['AuthUserID'] == 1958 or $_SESSION['AuthUserID'] == 1957) 	{
		$od = new v4_OrderDetailsFR();
	} else {
		$od = new v4_OrderDetails();
	}
	
	$om = new v4_OrdersMaster();
	$ox = new v4_OrderExtras();
	$au = new v4_AuthUsers();
	$op = new v4_Places();
	
/*	
	$oKey = $om->getKeysBy('MOrderID', 'ASC', ' WHERE MOrderID = ' .$OrderID);
	if(count($oKey) == 1) {
		$om->getRow($oKey[0]);


		$dKey = $od->getKeysBy('DetailsID', 'ASC', ' WHERE OrderID = ' .$OrderID);
		if(count($dKey) > 0) {
			$transferCount = count($dKey);
		}
		else die(TRANSFER_NOT_FOUND);	
		
	}

*/

	$od->getRow($DetailsID);


	$dKey = $od->getKeysBy('DetailsID', 'ASC', ' WHERE OrderID = ' .$od->getOrderID() );
	if(count($dKey) > 0) {
		$od->getRow($dKey[0]);
		$firstTransferWhere = ' OR OrderDetailsID = ' . $od->getDetailsID();
	}
	

	$od->getRow($DetailsID);
	$om->getRow( $od->getOrderID());
	
	$detailPriceSum = $od->getDetailPrice();

	// Podaci o useru - Taxi site ili partner, agent 
	$AuthUserID = $od->getUserID();	
	if($AuthUserID < 1) $AuthUserID = '53';
	$au->getRow($AuthUserID);

	// dohvacanje engleskih imena lokacija iz v4_Places
	// FIXME ako je FREEFORM, PickupID i DropID su 0,
	// pa se imena dohvacaju iz v4_OrderDetails
	if($om->getMCardType() == 'FREEFORM') {
		$PickupName = $od->getPickupName();
		$DropName = $od->getDropName();
	} else {
		$op->getRow($od->getPickupID());
		$PickupName = $op->getPlaceNameEN();
		$op->getRow($od->getDropID());
		$DropName = $op->getPlaceNameEN();
	}
?>

	<div id="thankyou" class="white grid">
	 	<div class="grid white">

	 		<div class="col-1-1 pad1em" style="min-height:800px">
<!--
	 			<p>
	 				<span class="l"><strong><?= $au->getAuthUserCompany() ?></strong></span>	<br>
	 				<?= $au->getAuthCoAddress() ?><br>
	 				<?= $au->getAuthUserMail() ?> <?= $au->getAuthUserTel() ?><br>
	 			</p>
-->	 			
	 			<h3><?= RESERVATION_CODE ?>: <strong><?= $om->getMOrderKey().'-'.$om->getMOrderID().'-'.$od->getTNo() ?></strong></h3>
	 			<small><?= $om->getMOrderDate().' '. $om->getMOrderTime() ?></small>
	 			<br>
	 			<br>

				<div class="w25 aaa"><?= FROM ?>:</div>
				<div class=" w75">
					<strong><?=  $PickupName ?></strong>
				</div>
				<br>
				
				<div class="w25 aaa"><?= PICKUP_ADDRESS ?>:</div>
				<div class=" w75">
					<?= $od->getPickupAddress() ?>
				</div>
				<br>
				
				<div class="w25 aaa"><?= TO ?>:</div>
				<div class=" w75">
					<strong><?= $DropName ?></strong>
				</div>
				<br>
				
				<div class="w25 aaa"><?= DROPOFF_ADDRESS ?>:</div>
				<div class=" w75">
					<?=  $od->getDropAddress() ?>
				</div>
				<br>
				
				<div class="w25 aaa"><?= PICKUP_DATE ?>:</div>
				<div class=" w75">
					<?= $od->getPickupDate() ?> <small>(Y-M-D)</small>
					<strong><em> <?= TRANSFER_ID ?>: <?= $od->getOrderID().'-'.$od->getTNo() ?></em></strong>
				</div>
				<br>
				
				<div class="w25 aaa"><?= PICKUP_TIME ?>:</div>
				<div class=" w75">
					<?= $od->getPickupTime() ?> <small>(H:M 24h)</small>
				</div>
				<br>

				<? if( $od->getFlightNo() != '') { ?>
				<div class="w25 aaa"><?= FLIGHT_NO ?>:</div>
				<div class=" w75">
					<?= $od->getFlightNo() ?>
				</div>
				<br>
				<? } ?>

				<? if( $od->getFlightTime() != '') { ?>
				<div class="w25 aaa"><?= FLIGHT_TIME ?>:</div>
				<div class=" w75">
					<?= $od->getFlightTime() ?>
				</div>					
				<? } ?>
			
			
				<p class="line eee"></p>
				
				<h3 class="aaa"><?= YOUR_CONTACT_INFO ?></h3><p class="line eee"></p>
				<div class="w25 aaa"><?=  NAME ?>:</div>
				<div class="w75">
					<?= $om->getMPaxFirstName(). ' ' . $om->getMPaxLastName() ?>
				</div>
				<br>
<?/*				
				<div class="w25 aaa"><?=  EMAIL ?>:</div>
				<div class="w75">
					<?= maskEmail($om->getMPaxEmail()) ?>
				</div>
				<br>
*/?>				
				<div class="w25 aaa"><?=  MOBILE_NUMBER ?>:</div>
				<div class="w75">
					<?= $om->getMPaxTel() ?>
				</div>
				<br>

				<div class="w25 aaa"><?= PASSENGERS_NO?>:</div>
				<div class=" w75">
					<?= $od->getPaxNo() ?>
				</div>
				<br>	
				
				<p class="line eee"></p>
				
				<h3 class="aaa"><?= SELECTED_VEHICLE?></h3><p class="line eee"></p>
				
				<div class="w25 aaa"><?=  VEHICLE_CAPACITY ?>:</div>
				<div class="w75">
					<?=  getMaxPax( $od->getVehicleType() )  ?> x <?= $od->getVehiclesNo(); ?>
				</div>
				<br>
				
				<div class="w25 aaa"><?=  VEHICLE_TYPE ?>:</div>
				<div class="w75">
					<?= getVehicleTypeName( $od->getVehicleType() ) ?> x <?= $od->getVehiclesNo(); ?>
				</div>
				<br>
				
<!--	Vozaci ne smeju da vide ukupnu cenu, zakomentarisao Srdjan na zahtev Dejana i Stefana
				<div class="w25 aaa"><?= PRICE ?>:</div>
				<div class="w75">
					<strong>
						<?= Eur2($detailPriceSum,$om->getMOrderCurrency()) . ' ' . 
								$om->getMOrderCurrency() ?>
					</strong>
					<? if($od->getDiscount() > 0) echo '(-' . $od->getDiscount() .'%)';?>
				</div>
				<br>
-->				
				<p class="line eee"></p>
				<div class="w25 aaa" style="vertical-align:top"><?= NOTES ?>:</div>
				<div class=" w75">
					<?= $pickupNotes ?>
				</div>
				<br>
				
				<p class="line eee"></p>

				<?
					$where = ' WHERE OrderDetailsID = ' . $od->getDetailsID() . $firstTransferWhere;
					$oXkey = $ox->getKeysBy('ID', 'ASC', $where);
					if( count($oXkey) > 0 ){

						echo '<h3 class="aaa">'. EXTRAS .'</h3><p class="line eee"></p>';

						foreach($oXkey as $i => $id) {
							$ox->getRow($id);
							echo '<div class="w25">' . 
										$ox->getServiceName() . ' x ' .
										$ox->getQty();
							echo '</div> ';
						
							echo '<div class="w75">' . 
								Eur2( $ox->getSum(),$om->getMOrderCurrency() ) . 
								' ' . $om->getMOrderCurrency() . 
							'</div>';

					
						}
						
						echo '<p class="line eee"></p>';	
					}
				
				
				
				?>

				
<!--			<div class="w25 "><strong><?=  TOTAL ?>:</strong></div>
				<div class="w75">
					<strong><?= nf($detailPriceSum) . ' ' . 
								$om->getMOrderCurrency() ?></strong>
				</div>

				<p class="line eee"></p>
			
				<? if($om->getMPayNow() > 0) {?>
				<div class="green pad1em">
				<div class="w25 "><strong><?=  PAY_NOW ?>:</strong></div>
				<div class="w75">
					<strong><?= Eur2( $od->getPayNow(),$om->getMOrderCurrency() )  . ' ' . 
								$om->getMOrderCurrency() ?></strong>
				</div>
				</div>
				<br>
				<?}?>
-->
				<div class="red lighten-2 pad1em">
				<div class="w25 "><strong><?=  PAY_LATER ?>:</strong></div>
				<div class="w75">
					<strong><?= Eur2($od->getPayLater()*$_SESSION['CurrencyRate'],$om->getMOrderCurrency() ) . ' ' . 
								$_SESSION['Currency2'] ?></strong>
					<? if($_SESSION['Currency2']=='HRK') {?>	
						/ <strong><?= Eur2($od->getPayLater(),$om->getMOrderCurrency() ) . ' ' . 
									$om->getMOrderCurrency() ?></strong>			
					<? }?>	
				</div>
				</div>
				<br>
								
				<br>
				<div class="w100 center">
					<p style="font-size:.7em;text-transform:uppercase;text-align:left;">
							<?= SERVICES_DESC1 ?> | 
							<?= SERVICES_DESC2 ?> | 
							<?= SERVICES_DESC3 ?> | 
							<?= SERVICES_DESC4 ?> | 
							<?= SERVICES_DESC5 ?> | 
							<?= SERVICES_DESC6 ?> | 
							<?= SERVICES_DESC7 ?> | 
							<?= SERVICES_DESC8 ?> | 
							<?= SERVICES_DESC9 ?>
							<br><br>
							<?= ACCEPTED_TERMS ?>
							<br>
							
						</ul>
					</p>					
					<br>
				
				</div>

			</div>
		</div>
	</div>
<? } // end function
