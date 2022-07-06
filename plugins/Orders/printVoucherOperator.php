<?
//if(!isset($_SESSION['UserAuthorized']) or !$_SESSION['UserAuthorized']) die('Go away!');
require_once ROOT.'/f/f.php';
	if ( isset($_SESSION['CMSLang']) and $_SESSION['CMSLang'] != '') {
		$languageFileCMS = ROOT.'/cms/lng/' . $_SESSION['CMSLang'] . '_text.php';
		$languageFileSite = ROOT.'/lng/' . $_SESSION['CMSLang'] . '.php';
		if ( file_exists( $languageFileCMS) and file_exists($languageFileSite) ){
			require_once $languageFileCMS;
			require_once $languageFileSite;
		} 
		else {
			$_SESSION['CMSLang'] = 'en';
			require_once ROOT.'/cms/lng/en_text.php';
			require_once ROOT.'/lng/en.php';
		}
	}
	else {
		$_SESSION['CMSLang'] = 'en';
		require_once ROOT.'/cms/lng/en_text.php';
		require_once ROOT.'/lng/en.php';
	}	
	
$OrderID = $_REQUEST['OrderID'];

?>

	<div class="container white" id="voucher">
	<? 
	    $html =  printVoucherOperator($OrderID, false);
	    
	    
            //****************
            // PDF GENERATION
            //****************
            require_once ROOT ."/mpdf60/mpdf.php";

            $mpdf=new mPDF();

            $mpdf->SetDisplayMode('fullpage');

            $mpdf->autoScriptToLang = true;
            $mpdf->baseScript = 1;

            // LOAD a stylesheet

            $stylesheet = '
                @media print {
                    table, tr, td, * {font-size:11px !important; font-family: Arial, sans-serif !important;}
                }
            ';
            $mpdf->WriteHTML($stylesheet,1);    // The parameter 1 tells that this is css/style only and no body/html/text

            //$html = $html .'<small style="font-family:Arial, sans-serif;">'. pdfFooter(2) . '</small>';

            //$mpdf->WriteHTML(utf8_encode($html)); // ovo spizdi cirilicu
            $mpdf->WriteHTML($html); // a ovo ne

            $content = $mpdf->Output('', 'S');

            $content = chunk_split(base64_encode($content));

            $mpdf->Output('./pdf/'.$OrderID.'.pdf');
            
            //*********** END PDF	    
	    
	    
	    echo $html;
	 ?>
	    
	    <div class="row">
	        <a href="<?= './pdf/'.$OrderID.'.pdf' ?>" class="btn red shadowMedium"  target="_blank"><i class="fa fa-chevron-down fa-2x xwhite-text"></i></a>
	        &nbsp;&nbsp;
	        <a href="#" class="btn blue shadowMedium pull-right" onclick="printDiv('voucher');"><i class="fa fa-print fa-2x xwhite-text"></i></a>

	    </div>
	    <br><br><br>
	</div>

<?
// FUNCTIONS
function printVoucherOperator($OrderID, $showPrices = true) {
	//echo '<pre>'; print_r($_REQUEST); echo '</pre>';

    ob_start();
    
	if(!empty($OrderID) and is_numeric($OrderID)) {
		//$OrderID = $_REQUEST['OrderID'];
	}
	else die('Transfer ID corrupt or missing.');

	define("NL", '<br>'); 
	require_once ROOT . '/db/v4_OrdersMaster.class.php';
	require_once ROOT . '/db/v4_OrderDetails.class.php';
	require_once ROOT . '/db/v4_OrderExtras.class.php';
	require_once ROOT . '/db/v4_AuthUsers.class.php';

	// classes
	$om = new v4_OrdersMaster();
	$od = new v4_OrderDetails();
	$ox = new v4_OrderExtras();
	$au = new v4_AuthUsers();
	
	
	$oKey = $om->getKeysBy('MOrderID', 'ASC', ' WHERE MOrderID = ' .$OrderID);
	if(count($oKey) == 1) {
		$om->getRow($oKey[0]);
		$AuthUserID = $om->getMUserID();

		$dKey = $od->getKeysBy('DetailsID', 'ASC', ' WHERE OrderID = ' .$OrderID);
		if(count($dKey) > 0) {
			$transferCount = count($dKey);
		}
		else die('Transfer not found');	
		
	}
	
	// Podaci o useru - Taxi site ili partner, agent 
	$users = array('2', '4', '5', '6', '12');
	
	$au->getRow($AuthUserID);
	$level = $au->getAuthLevelID();
	
	if(in_array($level, $users)) {
		$userCo = $au->getAuthUserCompany();
		$userAddress = $au->getAuthCoAddress();
		$userMail = $au->getAuthUserMail();
		$userTel = $au->getAuthUserTel();
	}
	else {
		$userCo = s('co_name');
		$userAddress = s('co_address');
		$userMail = s('co_email');
		$userTel = s('co_tel');		
	}
	
	$od->getRow($dKey[0]);
	$firstTransferWhere = ' OR OrderDetailsID = ' . $od->getDetailsID();
	$pickupNotes = '<small>['.$OrderID.'-1]<br></small>'.$od->getPickupNotes();
	?>
	
	<table cellpadding="0" cellspacing="0" style="font-family:Arial, sans-serif;">
		<tr>
			<td colspan="2">
	 			<p>
	 				<h1><?= $userCo?></h1>
	 				<small>
	 					<?= $userAddress ?><br>
	 					<?= $userMail ?> <?= $userTel ?><br>
	 				</small>
	 			</p>
	 			<br>
	 			<h2>VOUCHER No: <strong><?= $om->getMOrderKey().'-'.$om->getMOrderID() ?></strong></h2>
	 			<small><?= $om->getMOrderDate().' '. $om->getMOrderTime() ?></small>
	 			<br>
	 			<br>				
			</td>
		</tr>
		
		<tr>
			<td colspan="2">
				<hr>
				<h3 style="font-weight:100"><?= YOUR_CONTACT_INFO ?></h3>
				<hr>
			</td>
		</tr>	
		<tr>
			<td>
				<?=  NAME ?>:
			</td>
			<td>
				<?= $om->getMPaxFirstName(). ' ' . $om->getMPaxLastName() ?>
			</td>
		</tr>	
		<tr>
			<td>
				<?=  EMAIL ?>:
			</td>
			<td>
				<?= $om->getMPaxEmail() ?>
			</td>
		</tr>	
		<tr>
			<td>
				<?=  MOBILE_NUMBER ?>:
			</td>
			<td>
				<?= $om->getMPaxTel() ?>
			</td>
		</tr>	
		<tr>
			<td>
				<?= PASSENGERS_NO?>:
			</td>
			<td>
				<?= $od->getPaxNo() ?>
			</td>
		</tr>

		<tr>
			<td colspan="2">
				<hr>
				<h3 style="font-weight:100"><?= ABOUT_YOUR_TRANSFER?></h3>
				<hr>
			</td>
		</tr>	

		<tr>
			<td><?= FROM ?>:</td>
			<td>
				<strong><?= $od->getPickupName() ?></strong>
			</td>
		</tr>
		<tr>
			<td>
				<?= PICKUP_ADDRESS ?>:
			</td>
			<td>
				<?= $od->getPickupAddress() ?>
			</td>
		</tr>
		<tr>
			<td>
				<?= TO ?>:
			</td>
			<td>
				<strong><?= /*getPlaceName( $od->getDropID() )*/ $od->getDropName() ?></strong>
			</td>
		</tr>
		<tr>
			<td>
				<?= DROPOFF_ADDRESS ?>:
			</td>
			<td>
				<?=  $od->getDropAddress() ?>
			</td>
		</tr>
		<tr>
			<td>
				<?= PICKUP_DATE ?>:
			</td>
			<td>
				<?= $od->getPickupDate() ?> <small>(Y-M-D)</small>
				<strong><em> Transfer ID: <?= $od->getOrderID().'-'.$od->getTNo() ?></em></strong>
			</td>
		</tr>
		<tr>
			<td>
				<?= PICKUP_TIME ?>:
			</td>
			<td>
				<?= $od->getPickupTime() ?> <small>(H:M 24h)</small>
			</td>
		</tr>
		<? if( $od->getFlightNo() != '') { ?>
		<tr>
			<td>
				<?= FLIGHT_NO ?>:
			</td>
			<td>
				<?= $od->getFlightNo() ?>
			</td>
		</tr>
		<tr>
			<td>
				<?= FLIGHT_TIME ?>:
			</td>
			<td>
				<?= $od->getFlightTime() ?>
			</td>
		</tr>
		<? } ?>	
		
		<? if ($transferCount == 2)  {
				
				// podaci za drugi transfer
				$od->getRow($dKey[1]);
				$pickupNotes .= '<br><small>['.$OrderID.'-2]<br></small>'.$od->getPickupNotes();
		
			?>		
		<tr>
			<td colspan="2">
				<hr>
				<h3 style="font-weight:100"><?= RETURN_TRANSFER ?></h3>
				<hr>
			</td>
		</tr>
		<tr>
			<td>
				<?= FROM ?>:
			</td>
			<td>
				<strong><?= $od->getPickupName() ?></strong>
			</td>
		</tr>	
		<tr>
			<td>
				<?= PICKUP_ADDRESS ?>:
			</td>
			<td>
				<?= $od->getPickupAddress() ?>
			</td>
		</tr>															
		<tr>
			<td>
				<?= TO ?>:
			</td>
			<td>
				<strong><?= /*getPlaceName( $od->getDropID() )*/ $od->getDropName() ?></strong>
			</td>
		</tr>	
		<tr>
			<td>
				<?= DROPOFF_ADDRESS ?>:
			</td>
			<td>
				<?=  $od->getDropAddress() ?>
			</td>
		</tr>
		<tr>
			<td>
				<?= RETURN_DATE ?>:
			</td>
			<td>
				<?= $od->getPickupDate() ?> <small>(Y-M-D)</small>
				<strong><em> Transfer ID: <?= $od->getOrderID().'-'.$od->getTNo() ?></em></strong>
			</td>
		</tr>	
		<tr>
			<td>
				<?= RETURN_TIME ?>:
			</td>
			<td>
				<?= $od->getPickupTime() ?> <small>(H:M 24h)</small>
			</td>
		</tr>
		
		<? if( $od->getFlightNo() != '') { ?>
		<tr>
			<td>
				<?= FLIGHT_NO ?>:
			</td>
			<td>
				<?= $od->getFlightNo() ?>
			</td>
		</tr>	
		<tr>
			<td>
				<?= FLIGHT_TIME ?>:
			</td>
			<td>
				<?= $od->getFlightTime() ?>
			</td>
		</tr>
		<? } ?>	
	<? } ?>	
		
	
		<tr>
			<td colspan="2">
				<hr>
				<h3 style="font-weight:100"><?= SELECTED_VEHICLE?></h3>
				<hr>
			</td>
		</tr>	
		<tr>
			<td>
				<?=  VEHICLE_CAPACITY ?>:
			</td>
			<td>
				<?=  getMaxPax( $od->getVehicleType() )  ?> x <?= $od->getVehiclesNo(); ?>
			</td>
		</tr>	
		<tr>
			<td>
				<?=  VEHICLE_TYPE ?>:
			</td>
			<td>
				<?= getVehicleTypeName( $od->getVehicleType() ) ?> X <?=$od->getVehiclesNo() ?>
			</td>
		</tr>	
<?/*
		<tr>
			<td>
				<?=  DRIVER_NAME ?>:
			</td>
			<td>
				<?= $od->getDriverName() ?>
			</td>
		</tr>	
*/?>

		<? if($showPrices == true) { ?>
			<tr>
				<td>
					<?= PRICE ?>:
				</td>
				<td>
				<strong><?= Eur2($om->getMTransferPrice(),$om->getMOrderCurrency()) . ' ' . 
									$om->getMOrderCurrency() ?></strong>
				</td>
			</tr>
		<? } ?>
		<tr>
			<td>
				<?= NOTES ?>:
			</td>
			<td><?= $pickupNotes ?>
				
			</td>
		</tr>
		<?
			$where = ' WHERE OrderDetailsID = ' . $od->getDetailsID() . $firstTransferWhere;
			$oXkey = $ox->getKeysBy('ID', 'ASC', $where);
			if( count($oXkey) > 0 ){

				echo '	<tr>
							<td colspan="2">
								<hr>
								<h3 style="font-weight:100">'. EXTRAS .'</h3>
								<hr>
							</td>
						<tr>';

				foreach($oXkey as $i => $id) {
					$ox->getRow($id);
					echo '<tr><td>' . 
								$ox->getServiceName() . ' x ' . $ox->getQty();
					echo '</td> ';
				
					echo '<td>' . 
						Eur2( $ox->getSum(),$om->getMOrderCurrency() ) . ' ' . $om->getMOrderCurrency() . 
					'</td></tr>';
			
				}
			}
		?>		
		
			
		<? if($showPrices == true) { ?>
			<tr>
				<td>				
					<hr>
					<h3><?=  TOTAL ?>:</h3>
					<hr>
				</td>
				<td>
					<hr>
					<h3><?= nf($om->getMOrderPriceEUR()) . ' ' . $om->getMOrderCurrency() ?></h3>
					<hr>
				</td>
			</tr>
		
			<? if($om->getMPayNow() > 0) {?>
			
			<tr>
				<td>
					<h3><?=  PAY_NOW ?>:</h3>
					<hr>
				</td>
				<td>
					<h3><?= Eur2( $om->getMPayNow(),$om->getMOrderCurrency() )  . ' ' . 
									$om->getMOrderCurrency() ?></h3>
					<hr>
				</td>
			</tr>																											
			<?}?>
		
			<tr>
				<td>
					<h3><?=  PAY_LATER ?>:</h3>
					<hr>

				</td>
				<td>
					<h3><?= Eur2($om->getMPayLater(),$om->getMOrderCurrency() ) . ' ' . 
									$om->getMOrderCurrency() ?></h3>
					<hr>

				</td>
			</tr>
		<? } ?>	
		<tr>
			<td colspan="2">
				<hr>
				<p style="font-family:Arial, sans-serif;color:#333">
					<?= SERVICES_DESC1 ?> | 
					<?= SERVICES_DESC2 ?> | 
					<?= SERVICES_DESC3 ?> | 
					<?= SERVICES_DESC4 ?> | 
					<?= SERVICES_DESC5 ?> | 
					<?= SERVICES_DESC6 ?> | 
					<?= SERVICES_DESC7 ?> | 
					<?= SERVICES_DESC8 ?> | 
					<?= SERVICES_DESC9 ?><br>
					<?= ACCEPTED_TERMS ?><br>
					<?= POWERED_BY ?> : <?= $_SESSION['co_name']?><br>
					<?= CALL_CENTER ?>: <?= $_SESSION['co_tel']?><br>

							<br>
							

					</p>					
					<br>
			</td>

		</tr>	
		
			
		
												
	</table>
	
	
	
	<br><br><br><br>
	<?
	
	$output = ob_get_contents();
	ob_end_clean();
	
	return $output;
}// end printVoucher





?>

<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
