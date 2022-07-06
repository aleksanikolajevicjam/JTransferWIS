<?
//
// koristi funkciju PrintTransferMaterial za ispis na ekran i
// printVoucher za slanje u mailu
//

    @session_start();
	require_once ROOT .'/f/f.php';
	require_once 'para_back.html'; 
	require_once ROOT . '/LoadLanguage.php';
	
	define("TEST",false);
?>


<div class="blue-grey">
	<br>
	<div class="white fillHeight container pad1em">

	<?	
    
    // povratak sa webteh-a
	if($_SESSION['PaymentOption'] != '2') { // 2= cash only
		# DATA FROM WEBTEH
	
		$approval_code = $_REQUEST['approval_code'];
		$authentication= $_REQUEST['authentication'];
		$cc_type = $_REQUEST['cc_type'];
		$currency = $_REQUEST['currency'];
		$digest = $_REQUEST['digest'];
		$enrollment = $_REQUEST['enrollment'];
		$language = $_SESSION['language'];
		$order_number = $_REQUEST['order_number'];
		$response_code = $_REQUEST['response_code'];
		
		@logit('WEBTEH PAYMENT - PAYMENT RESPONSE');
		$logMail = s('MPaxEmail');
		@logit($logMail);
		@logit($_REQUEST); // logiranje responseova sa webteha
	} 
	else if ($_SESSION['PaymentOption'] == '2')	 $response_code = '0000';

	// Prevent refresh!
	if(!$_SESSION['REFRESHED'] or TEST) {

		// spremi sve u session
		foreach	($_REQUEST as $key => $value) {
			$_SESSION[$key] = $value;
		}
		// i u request
		foreach	($_SESSION as $key => $value) {
			if(gettype($value) != 'array') {
				echo '<input type="hidden" name="'.$key.'" value="'.$value.'">';
			}
		}

		if (isset($_SESSION['fromPlaces'])) unset($_SESSION['fromPlaces']);
		if (isset($_SESSION['toPlaces'])) unset($_SESSION['toPlaces']);
		if (isset($_SESSION['allPlaces'])) unset($_SESSION['allPlaces']);
		if (isset($_SESSION['countries'])) unset($_SESSION['countries']);


		// Ako je naplata uredno obavljena ili je cash placanje
		if (isSessionGood()) {
			if($response_code == '0000') {
				// Upis u bazu
				$OrderKey = '';
				require_once ROOT . '/t/dbAddOrder.php';
				$OrderID = insertOrder('final');

				$_SESSION['REFRESHED'] = true;
				$printAndSend = true;

			} else { // naplata nije obavljena - response_code != '0000'  ?>
					<div class="row">
						<div class="col s12 pad1em fillHeight">
							<br><br>
							<h2><i class="fa fa-info-circle red-text"></i> <?= PAYMENT_ERROR ?></h2>
							<?= PAYMENT_ERROR_TEXT ?>
							<br>
							<br>
						</div>
					</div>
				<? 
				
				$printAndSend = false; // ne salji voucher
				$_SESSION['REFRESHED'] = true; // zabrani refresh
		
			} // REFRESHED
		}
		else { ?>
			<div class="row">
				<div class="col s12 pad1em fillHeight">
					<br><br>
					<h2><i class="fa fa-info-circle red-text"></i> <?= UNDEFINED_ERROR ?></h2>
					<?= SOMETHING_WRONG ?>
					<br>
					<br>
				</div>
			</div>
			<? 
	
			$printAndSend = false; // ne salji voucher
			$_SESSION['REFRESHED'] = true; // zabrani refresh 
		}
		
	} else { // REFRESHED = true ?>
			<div class="row">
				<div class="col s12 pad1em fillHeight">
					<br><br>
					<h1><i class="fa fa-info-circle red-text"></i> <?= THANK_YOU ?></h1>
					<?= NO_REFRESH ?>
					<br>
					<br>
				</div>
			</div>
		<? 
		// ne salji voucher
		$printAndSend = false;
		
	} // REFRESHED
	
	// treba li printati voucher i poslati ga
	if($printAndSend) { ?>

		<div class="row blue z-depth-2">
			<div class="col s12 pad1em white-text">
				<br>
				<h1><i class="fa fa-smile-o"></i> <?= THANK_YOU ?></h1>
				<?= BOOKING_SUCCESS ?>
			</div>
		</div>

		<? 


		ob_start();	

		// printa tabelu sa voucherom za pdf i mail_html
		// ista tabela se prikazuje na ekranu 
		printVoucher($OrderID) ;

		$html = ob_get_contents();
		
		ob_end_clean();
	
		// prikaz vouchera	
		?>
		<div class="row">
			<div class="col s12 pad1em hidden"  id="voucher">
				<?= $html ?>
			</div>
			<div class="col s12 pad1em">
				<?	PrintTransferMaterial($OrderID); ?>
				<input type="button" class="btn blue" onclick="printDiv('voucher')" value="<?= PRINT_VOUCHER; ?>" />
			</div>

		</div>

		<?

		//****************
		// PDF GENERATION
		//****************
		require_once ROOT ."/mpdf60/mpdf.php";

		$mpdf=new mPDF(); 

		$mpdf->SetDisplayMode('fullpage');

		// LOAD a stylesheet
		//$stylesheet = file_get_contents('parallax/css/materialize.css');
		$stylesheet = '
			@media print { 
				table, tr, td, * {font-size:11px !important; font-family: Arial, sans-serif !important;}
			}
		';
		$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

		$html = $html .'<small style="font-family:Arial, sans-serif;">'. pdfFooter(SITE_CODE) . '</small>';

		$mpdf->WriteHTML(utf8_encode($html)); 

		$content = $mpdf->Output('', 'S');

		$content = chunk_split(base64_encode($content));

		$mpdf->Output('./pdf/'.$OrderKey.'.pdf');	


		// ALL DONE, SEND EMAILS - Stavljen moj mail da vidim dali je ovo confirmation ili verification sa taxi stranica! 
		mail_html(s('MPaxEmail'), 'confirmation@jamtransfer.com', 'JamTransfer', 'info@jamtransfer.com',
				  ORDER_CONFIRMATION.$OrderKey, '<br>'.$html, './pdf/'.$OrderKey.'.pdf');

		mail_html('cms@jamtransfer.com', 'confirmation@jamtransfer.com', 'JamTransfer', 'info@jamtransfer.com',
				  ORDER_CONFIRMATION.$OrderKey, '<br>'.$html, './pdf/'.$OrderKey.'.pdf');	

		sendDriverNotification($OrderID, $OrderKey);
				  

	} // printAndSend ?>
	
		
	</div>	
	<br><br>
</div>

<?
// FUNCTIONS

function copyFromTemp () {
	require_once ROOT .'/db/v4_OrdersMaster.class.php';
	require_once ROOT .'/db/v4_OrderDetails.class.php';
	require_once ROOT .'/db/v4_OrderExtras.class.php';
	require_once ROOT .'/db/v4_OrdersMasterTemp.class.php';
	require_once ROOT .'/db/v4_OrderDetailsTemp.class.php';
	require_once ROOT .'/db/v4_OrderExtrasTemp.class.php';

	$om = new v4_OrdersMaster();
	$od = new v4_OrderDetails();
	$ox = new v4_OrderExtras();
	$omt = new v4_OrdersMasterTemp();
	$odt = new v4_OrderDetailsTemp();
	$oxt = new v4_OrderExtrasTemp();


	$key = array();
	$key = $omt->getKeysBy('MOrderID', 'ASC', 'WHERE MOrderKey='.$order_number);

	if ($key != null) {
		$omt->getRow($key[0]);

		$OrderKey = create_order_key(); // pravi OrderKey
		$om->setMOrderKey			( $OrderKey );
		$om->setSiteID				( $omt->getSiteID() );
		$om->setMOrderStatus		( $omt->getMOrderStatus() );
		$om->setMOrderType			( $omt->getMOrderType() );
		$om->setMOrderDate			( $omt->getMOrderDate() );
		$om->setMOrderTime			( $omt->getMOrderTime() );
		$om->setMUserID				( $omt->getMUserID() );
		$om->setMUserLevelID		( $omt->getMUserLevelID() ); 
		$om->setMCustomerID			( $omt->getMCustomerID() );
		$om->setMTransferPrice		( $omt->getMTransferPrice() );
		$om->setMExtrasPrice		( $omt->getMExtrasPrice() );
		$om->setMOrderPriceEUR		( $omt->getMOrderPriceEUR() );
		$om->setMOrderCurrency		( $omt->getMOrderCurrency() );
		$om->setMOrderCurrencyPrice	( $omt->getMOrderCurrencyPrice() );
		$om->setMEurToCurrencyRate	( $omt->getMEurToCurrencyRate() );
		$om->setMPaymentMethod		( $omt->getMPaymentMethod() );
		$om->setMPaymentStatus		( $omt->getMPaymentStatus() );
		$om->setMPayNow				( $omt->getMPayNow() );
		$om->setMPayLater			( $omt->getMPayLater() );
		$om->setMInvoiceAmount		( $omt->getMInvoiceAmount() );
		$om->setMAgentCommision		( $omt->getMAgentCommision() );
		$om->setMPaxFirstName		( $omt->getMPaxFirstName() );
		$om->setMPaxLastName		( $omt->getMPaxLastName() );
		$om->setMPaxTel				( $omt->getMPaxTel() );
		$om->setMPaxEmail			( $omt->getMPaxEmail() );
		$om->setMCardType			( $omt->getMCardType() );
		$om->setMCardFirstName		( $omt->getMCardFirstName() );
		$om->setMCardLastName		( $omt->getMCardLastName() );
		$om->setMCardEmail			( $omt->getMCardEmail() );
		$om->setMCardTel			( $omt->getMCardTel() );
		$om->setMCardAddress		( $omt->getMCardAddress() );
		$om->setMCardCity			( $omt->getMCardCity() );
		$om->setMCardZip			( $omt->getMCardZip() );
		$om->setMCardCountry		( $omt->getMCardCountry() );
		$om->setMCardNumber			( $omt->getMCardNumber() );
		$om->setMCardCVD			( $omt->getMCardCVD() );
		$om->setMCardExpDate		( $omt->getMCardExpDate() );
		$om->setMConfirmFile		( $omt->getMConfirmFile() );
		$om->setMCancelFile			( $omt->getMCancelFile() );
		$om->setMChangeFile			( $omt->getMChangeFile() );
		$om->setMSubscribe			( $omt->getMSubscribe() );
		$om->setMAcceptTerms		( $omt->getMAcceptTerms() );
		$om->setMSendEmail			( $omt->getMSendEmail() );
		$om->setMEmailSentDate		( $omt->getMEmailSentDate() );
		$om->setMCustomerIP			( $omt->getMCustomerIP() );
		$om->setMOrderLang			( $omt->getMOrderLang() );

		$omOrderID = $om->saveAsNew();
		
		// Update OrderKey za printReservation.php
		$OrderKey .= '-'.$omOrderID;

		$key = $omt->getKeysBy('TNo', 'ASC', 'WHERE MOrderID='.$omt->getMOrderID());

		foreach ($key as $foo => $value) {
			$odt->getRow($value);

			$od->setSiteID				( $odt->getSiteID() );
			$od->setOrderID				( $omOrderID);
			$od->setTNo					( $odt->getTNo() );
			$od->setUserID				( $odt->getUserID() );
			$od->setUserLevelID			( $odt->getUserLevelID() );
			$od->setAgentID				( $odt->getAgentID() );
			$od->setCustomerID			( $odt->getCustomerID() );
			$od->setTransferStatus		( $odt->getTransferStatus() );
			$od->setOrderDate			( $odt->getOrderDate() );
			$od->setTaxidoComm			( $odt->getTaxidoComm() );
			$od->setServiceID			( $odt->getServiceID() );
			$od->setRouteID				( $odt->getRouteID() );
			$od->setFlightNo			( $odt->getFlightNo() );
			$od->setFlightTime			( $odt->getFlightTime() );
			$od->setPaxName				( $odt->getPaxName() );
			$od->setPickupID			( $odt->getPickupID() );
			$od->setPickupName			( $odt->getPickupName() );
			$od->setPickupPlace			( $odt->getPickupPlace() );
			$od->setPickupAddress		( $odt->getPickupAddress() );
			$od->setPickupDate			( $odt->getPickupDate() );
			$od->setPickupTime			( $odt->getPickupTime() );
			$od->setPickupNotes			( $odt->getPickupNotes() );
			$od->setDropID				( $odt->getDropID() );
			$od->setDropName			( $odt->getDropName() );
			$od->setDropPlace			( $odt->getDropPlace() );
			$od->setDropAddress			( $odt->getDropAddress() );
			$od->setDropNotes			( $odt->getDropNotes() );
			$od->setPriceClassID		( $odt->getPriceClassID() );
			$od->setDetailPrice			( $odt->getDetailPrice() );
			$od->setDriversPrice		( $odt->getDriversPrice() );
			$od->setDiscount			( $odt->getDiscount() );
			$od->setExtraCharge			( $odt->getExtraCharge() );
			$od->setPaymentMethod		( $odt->getPaymentMethod() );
			$od->setPaymentStatus		( $odt->getPaymentStatus() );
			$od->setPayNow				( $odt->getPayNow() );
			$od->setPayLater			( $odt->getPayLater() );
			$od->setInvoiceAmount		( $odt->getInvoiceAmount() );
			$od->setProvisionAmount		( $odt->getProvisionAmount() );
			$od->setPaxNo				( $odt->getPaxNo() );
			$od->setVehiclesNo			( $odt->getVehiclesNo() );
			$od->setVehicleType			( $odt->getVehicleType() );
			$od->setVehicleID			( $odt->getVehicleID() );
			$od->setVehiclesNo			( $odt->getVehiclesNo() );
			$od->setDriverID			( $odt->getDriverID() );
			$od->setDriverName			( $odt->getDriverName() );
			$od->setDriverEmail			( $odt->getDriverEmail() );
			$od->setDriverTel			( $odt->getDriverTel() );
			$od->setDriverConfStatus	( $odt->getDriverConfStatus() );
			$od->setDriverConfDate		( $odt->getDriverConfDate() );
			$od->setDriverConfTime		( $odt->getDriverConfTime() );
			$od->setDriverNotes			( $odt->getDriverNotes() );
			$od->setDriverPayment		( $odt->getDriverPayment() );
			$od->setDriverPaymentAmt	( $odt->getDriverPaymentAmt() );
			$od->setRated				( $odt->getRated() );
			$od->setDriverPickupDate	( $odt->getDriverPickupDate() );
			$od->setDriverPickupTime	( $odt->getDriverPickupTime() );
			$od->setSubDriver			( $odt->getSubDriver() );
			$od->setCar					( $odt->getCar() );
			$od->setCashIn				( $odt->getCashIn() );
			$od->setFinalNote			( $odt->getFinalNote() );
		
			$oneWayID = $od->saveAsNew();
			
			if ( $odt->getTNo() == '1') {

				$keyx = array();
				$keyx = $oxt->getKeysBy('ID', 'ASC', 'WHERE = OrderDetailsID='.$odt->getDetialsID());
				foreach ($keyx as $foo => $value) {
					$oxt->getRow($value);

					$ox->setOrderDetailsID	( $oxt->getOrderDetailsID() );
					$ox->setServiceID		( $oxt->getServiceID() );
					$ox->setServiceName		( $oxt->getServiceName() );
					$ox->setPrice			( $oxt->getPrice() );
					$ox->setQty				( $oxt->getQty() );
					$ox->setSum				( $oxt->getSum() );
					
					$ox->saveAsNew();
				}
			}
		}
	}
}

?>


<!-- Google Code for potvrda uplate https: Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1031456451;
var google_conversion_language = "en_US";
var google_conversion_format = "1";
var google_conversion_color = "ffffff";
var google_conversion_label = "VCQPCPngpQEQw43r6wM";
var google_conversion_value = <?= $_SESSION["TotalPrice"] ?>;
var google_conversion_currency = "EUR";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1031456451/?value=<?= $_SESSION["TotalPrice"] ?>&currency_code=EUR&label=VCQPCPngpQEQw43r6wM&guid=ON&script=0"/>
</div>
</noscript>


<!-- E_COMMERCE SCRIPT -->

<? 
$OID = $OrderID;
$TP  = $_SESSION['TotalPrice'];
$NP  = $_SESSION["TotalPrice"] - $_SESSION["DriversPrice"];
$FT  = getPlaceName($_SESSION["FromID"]) . "-" . getPlaceName($_SESSION["ToID"]);
$CC  = getCountryName($_SESSION["ch_country"]);
$TC  = getCountryName($_SESSION["CountryID"]);


echo " <script>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-4061039-1']);
  _gaq.push(['_trackPageview']);
  _gaq.push(['_addTrans',
    '". $OID ."',           // order ID - required
    'JamTransfer.com',  // affiliation or store name
    '". $TP ."',          // total - required
    '".$NP."',           // tax
    '0',              // shipping
    '". $FT ."',       // city
    '". $CC."',     // state or province
    '". $TC."'             // country
  ]);

  _gaq.push(['_trackTrans']); //submits transaction to the Analytics servers

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
";
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

<?
//echo '<div class="hidden"><pre>'; print_r($_SESSION); echo '</pre></div>';	
