<?
header('Content-type: text/xml');
error_reporting(E_PARSE);
	@session_start(); 

	
	// LOGIN
	if(!isset($_SESSION['UserAuthorized']) or $_SESSION['UserAuthorized'] == false) {
		header("Location: login.php");
		die();
	}

	//echo '<pre>'; print_r($_REQUEST); echo '</pre>';

	//The second parameter on print_r returns the result to a variable rather than displaying it
	$RequestSignature = md5($_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING'].print_r($_POST, true));

	if ($_SESSION['LastRequest'] == $RequestSignature)
	{
	// refresh
	$Refresh = false; //true
	}
	else
	{
	  // This is a new request.
	  $_SESSION['LastRequest'] = $RequestSignature;
	  $Refresh = false;
	}


	require_once ROOT.'/cms/dbJT.php';
	require_once ROOT.'/cms/f/db_funcs.php';
	require_once ROOT.'/db/v4_AuthUsers.class.php';
	require_once ROOT.'/db/v4_OrderDetails.class.php';
	require_once ROOT.'/db/v4_OrdersMaster.class.php';
	require_once ROOT.'/lng/en.php';
	
	$au = new v4_AuthUsers();
	$od = new v4_OrderDetails();
	$om = new v4_OrdersMaster();
	
	
	
	$footer_options = '';
	$vtype = vehicles();

	$from_mail = 'confirmation@jamtransfer.com';
	$from_name = 'JamTransfer.com';
	$mailSubjectPrefix = '';

	
	if ($_REQUEST['SaveOrder'] == 1 and !$Refresh) {
	
		$InvoiceAmount = 0;
		$ProvisionAmount = 0;
	
		
		if(r("RT")) $SingleReturn = 'Return'; else $SingleReturn = 'Single';
	
		$OrderCurrencyPrice = r("PayNow"); // ono sto je vec placeno
		//$PayLater 	= r("TotalPrice");
		//$PayNow		= '0';
	
		if(r("TDDT") == 'TD') {
			$from 	= r("Terminal"); 
			$to 	= r("Destination");
		}
		else {
			$from 	= r("DTDestination");
			$to 	= r("DTTerminal");
		}
		
		# OPERATER
		if(r('AuthUserID') == 0 and r('AuthUserIDTaxi') == 0) {
			$UserID  = $_SESSION['AuthUserID'];
			$LevelID = $_SESSION['AuthLevelID'];
		}
		
		# AGENT
		elseif (r('AuthUserID') > 0 and r('AuthUserIDTaxi') == 0) {
			$UserID  = r("AuthUserID");
			$LevelID = '2';
			$mailSubjectPrefix = 'Agent: ';	
			# Get AuthUser Provision
			$k = $au->getKeysBy("AuthUserID", "ASC", " WHERE AuthUserID = " . $UserID);
			if(count($k) == 1) {
				$au->getRow($k[0]);
				if($au->getAuthUserID() == $UserID) {

					# pretvaranje postotka u faktor - za izracun iznosa provizije
					$ProvisionFactor = 1 - ($au->getProvision()/100);
			
					$InvoiceAmount = r('TotalPrice') * $ProvisionFactor;
					$ProvisionAmount = r('TotalPrice') - $InvoiceAmount;
				}
			}
		}
		# TAXI SITE
		elseif (r('AuthUserIDTaxi') > 0 and r('AuthUserID') == 0) {
			$UserID  = r("AuthUserIDTaxi");
			$LevelID = '12';
			$au->getRow($UserID);
			if($UserID == $au->getAuthUserID()) {
				$from_mail = $au->getAuthUserMail();
				$from_name = $au->getAuthUserCompany();	
			}
		}
		# NE MOZE OBA
		elseif (r('AuthUserIDTaxi') > 0 and r('AuthUserID') > 0) {
			echo '	<div class="alert alert-danger">
						<h2>Error - you can not select both Agent and TaxiSite User!</h2>
					</div>';
			die();
		}	
		

		$OrderKey = create_order_key();
		
		// upis u datoteke
		$ok = false;
		
		$OrderID = insertOrder('final');
		
		if($OrderID !== false) {
			$ok = true;
			$OrderKey = $OrderKey .'-'.$OrderID;
		}
		

	
		if ($ok) {
			//echo '<div class="row"><div class="alert alert-danger">Order ' . $OrderKey . ' Added to Orders</div>
			//</div>';
			
			//$_SESSION['PIN'] = $OrderKey;
			ob_start();
			
			if($LevelID == '2') printVoucher($OrderID, false);
			else printVoucher($OrderID, true);
			
			$potvrda = ob_get_contents();
			ob_end_clean();
			echo '<div class="container white shadow">' . $potvrda .'</div>';
			
			//require_once 'v4_print_order.php';
			
			//$potvrda = strip_tags($potvrda);
			# send Confirmation email


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

            $html = $potvrda .'<small style="font-family:Arial, sans-serif;">'. pdfFooter(2) . '</small>';

            //$mpdf->WriteHTML(utf8_encode($html)); // ovo spizdi cirilicu
            $mpdf->WriteHTML($html); // a ovo ne

            $content = $mpdf->Output('', 'S');

            $content = chunk_split(base64_encode($content));

            $mpdf->Output('./pdf/'.$OrderKey.'.pdf');

            /* END PDF ***********************************************************************************************/





			$mailto = r('Email');

			$replyto = 'info@jamtransfer.com';
			$subject = $from_name . ' Order: ' . $OrderKey;
			
			$sent = mail_html('cms@jamtransfer.com', $from_mail, $from_name, $replyto, $mailSubjectPrefix.$subject, $potvrda, ROOT .'/cms/pdf/'.$OrderKey.'.pdf');
			echo ($sent? 'Sent':'Not sent :'.$mailto );
			
			if (!empty($mailto)) {
				$sent = mail_html($mailto, $from_mail, $from_name, $replyto, $subject, $potvrda);
				echo ($sent? 'Sent':'Not sent :'.$mailto );
			}
			
			//echo ($sent? 'Sent':'Not sent :'.$mailto );
			
		}
		else {
			echo '	<div class="row">
						<div class="alert alert-danger">
							ERROR: Order ' . $OrderKey . ' NOT Saved!
						</div>
					</div>
			';	
		}
		
	} else {

	//echo '<pre>'; print_r($data); echo '</pre>';
	/*
	 [o] => 12
	    [Terminal] => 
	    [Destination] => 
	    [SPAddress] => 
	    [SDAddress] => 
	    [SFlightNo] => 
	    [SFlightTime] => 
	    [PaxNo] => 
	    [SDate] => 2013-10-16
	    [STime] => 
	    [VehicleID] => 0
	    [OneWayPrice] => 
	    [SNote] => 
	    [RT] => 1
	    [RTerminal] => 
	    [RDestination] => 
	    [RPAddress] => 
	    [RDAddress] => 
	    [RFlightNo] => 
	    [RFlightTime] => 
	    [RDate] => 
	    [RTime] => 
	    [ReturnPrice] => 
	    [RNote] => 
	    [TotalPrice] => 
	    [FirstName] => asd
	    [LastName] => asd
	    [Email] => 
	    [TCode] => 123
	    [TNumber] => 12345678
	    [CardType] => 
	    [CardNumber] => 
	    [CardName] => 
	    [CardMonth] => 11
	    [CardYear] => 23
	
	*/
	
	    define("FROM", "From");
	    define("TO", "To");
	    define("PICKUP_ADDRESS","Pickup Address");
	    define("DROPOFF_ADDRESS", "DropOff Address");
	    define("FLIGHT_NO", "Flight No");
	    define("FLIGHT_TIME", "Flight Time");
	    define("PAX_NO", "Pax");
	    define("PICKUP_DATE", "Pickup Date");
	    define("PICKUP_TIME", "Pickup Time");
	    define("VEHICLE", "Vehicle");
	    define("RETURN_TRANSFER", "Return Transfer");
	    define("NOTES", "Notes");
	    define("PASSENGER_INFO", "Passenger Info");
	    define("CREDIT_CARD_DETAILS", "Credit Card Details");
	    define("CASH", "Cash");
	    define("CARD", "Card");
	    define("FIRST_NAME", "First Name");
	    define("LAST_NAME", "Last Name");
	    define("EMAIL", "E-mail");
	    define("TELEPHONE", "Tel / Mobile");
	    define("CARD_NUMBER", "Card Number");
	    define("CARD_TYPE", "Card Type");
	    define("CARD_NAME", "Card Name");
	    define("CARD_CVC", "Card CVC");
	    define("CARD_EXP_DATE", "Card Expiry Date");
	    define("PLEASE_SELECT", "Please select...");
	    define("T_PRICE", "Price");
	    define("TOTAL_PRICE", "Total Price");
	    define("F_FINISH", "Save Order");
	
	/* PRIPREMA ZA TAXISITE:
	UPDATE  `Orders` SET  `UserLevelID` =12,
	`InvoiceAmount` =0,
	`ProvisionAmount` =0 WHERE  `UserID` =215 OR  `UserID` =248 OR  `UserID` =249 OR  `UserID` =250 OR  
	`UserID` =251 OR  `UserID` =255 OR  `UserID` =262
	*/
	
if(isset($_FILES['upload'])){

	$target = "uploads/".basename($_FILES['upload']['name']);

	if(move_uploaded_file($_FILES['upload']['tmp_name'],$target)){
		$xml = simplexml_load_file('uploads/'.$_FILES['upload']['name']);
	}
} else {
	echo 'There was error uploading your file, please try again!';
	echo '<input class="btn btn-success" action="index.php?p=freeForm" value="Back"/>';
}
?>

<div class="container">
	<h2>Free form Order</h2>
	<br>
	<div class="alert alert-danger">
	<i class="fa fa-ban xl xwhite red-text"></i> 
	Ne upisujte adrese u From i To polja!<br>
	Za adrese postoji polje, u From i To idu gradovi ili aerodromi, a ne cijele adrese.<br><br>
	<!--Vidim li opet ovakve kobasice u From ili To - brišem transfer!!!<br><br>
	From: Hotel Best Jacaranda 4*, Avenida de Bruselas, 4-6 Playa Fanabe, 38670 Playa de Fanabe (Costa Adeje)-->
	
	</div>
</div>
<form id="booking" name="booking" action="index.php?p=freeForm" method="POST" class="container white">
	<div class="row">
		<div class="col-md-12">
			<h2 class="xblue-text">One Way Transfer</h2>
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
<?= 'File: '.$_FILES['upload']['name'].' successfully uploaded!';?><br><br>
			Book as <strong>Agent</strong>: <br>
			<? $agents = array(); $agents = getAgents(); ?>
			<select name="AuthUserID" id="AuthUserID" class="form-control w75">
				<option value="0"> --- </option>
				<? 
					foreach($agents as $id => $name) {
						echo '<option value="'.$id.'">' . $name .'</option>';
					}
					?>
			</select>
			<br><br>
		</div>
		<div class="col-md-6">
			<strong>OR</strong> book as <strong>TaxiSite</strong>: 
			<? $taxiSites = array(); $taxiSites = getTaxiSites(); ?>
			<select name="AuthUserIDTaxi" id="AuthUserIDTaxi" class="form-control w75">
				<option value="0"> --- </option>
				<? 
					foreach($taxiSites as $id => $name) {
						echo '<option value="'.$id.'">' . $name .'</option>';
					}
					?>
			</select>
			<br><br>
		</div>
		<br>
	</div>

	<!--row-->
	<div id="TD">
		<div class="row">
			
			<div class="col-md-6">
				<label><?= FROM ?></label>
				<div class="input-group" id="FNMask">
					<input class="form-control" type="text" id="Terminal" name="Terminal" value="<?= $xml->transfers->transfer[0]->origin->name ?>" 
						onchange="$('#RDestination').val(this.value);"
						placeholder="Start typing to search...">
					<span id="FN" class="input-group-addon"><i class="fa fa-search"></i></span>
					
				</div>
				<div id="fromList" style="display:none">
				</div>
			</div>
			
			
			<div class="col-md-6">
				<label><?= TO ?></label>
				<div class="input-group" id="TNMask">
					<input class="form-control" type="text" id="Destination" name="Destination" value="<?= $xml->transfers->transfer[0]->destination->name ?>" 
						onchange="$('#RTerminal').val(this.value);"
						placeholder="Start typing to search...">
					<span id="TN" class="input-group-addon"><i class="fa fa-search"></i></span>
					
				</div>
				<div id="toList" class="xblue-text" style="display:none">
				</div>	
			</div>
		</div>
		<!--row-->
	</div><br>

		<div class="row">
<? if($xml->transfers->transfer[0]->origin->accommodation->pickup_address != ''){?>
			<div class="col-md-4">
				<label><?= PICKUP_ADDRESS ?></label>
				<input class="form-control required" type="text" id="SPAddress" name="SPAddress" value="<?= $xml->transfers->transfer[0]->origin->accommodation->pickup_address ?>" 
				onchange="$('#RDAddress').val(this.value);"/>/>
			</div>
<? } elseif($xml->transfers->transfer[0]->origin->name != '') { ?>
			<div class="col-md-4">
				<label><?= PICKUP_ADDRESS ?></label>
				<input class="form-control required" type="text" id="SPAddress" name="SPAddress" value="<?= $xml->transfers->transfer[0]->origin->name ?>" 
				onchange="$('#RDAddress').val(this.value);"/>
			</div>
<? } else { ?>
			<div class="col-md-4">
				<label><?= PICKUP_ADDRESS ?></label>
				<input class="form-control required" type="text" id="SPAddress" name="SPAddress" value="" 
				onchange="$('#RDAddress').val(this.value);"/>/>
			</div>
<? }
	if($xml->transfers->transfer[0]->destination->accommodation->pickup_address != ''){?>
			<div class="col-md-4">
				<label><?= DROPOFF_ADDRESS ?></label>
				<input class="form-control required" type="text" id="SDAddress" name="SDAddress" value="<?= $xml->transfers->transfer[0]->destination->accommodation->pickup_address ?>" 
				onchange="$('#RPAddress').val(this.value);"/> 
			</div>
<? } elseif($xml->transfers->transfer[0]->destination->name != ''){?>
			<div class="col-md-4">
				<label><?= DROPOFF_ADDRESS ?></label>
				<input class="form-control required" type="text" id="SDAddress" name="SDAddress" value="<?= $xml->transfers->transfer[0]->destination->name ?>" 
				onchange="$('#RPAddress').val(this.value);"/> 
			</div>
<? } else {?>
			<div class="col-md-4">
				<label><?= DROPOFF_ADDRESS ?></label>
				<input class="form-control required" type="text" id="SDAddress" name="SDAddress" value="" 
				onchange="$('#RPAddress').val(this.value);"/> 
			</div>
<? } ?>
		</div>
	<!--row-->
	<div class="row">
		<div class="col-md-2">
			<label><?= FLIGHT_NO ?></label>
			<input class="form-control col-md-2" type="text" id="SFlightNo" name="SFlightNo" value="<?=$xml->transfers->transfer[0]->origin->flight->flight_number?>"/>
		</div>
		<div class="col-md-2">
			<?	$flightDate = new DateTime($xml->transfers->transfer[0]->origin->flight->date);?>
			<label><?= FLIGHT_TIME ?></label>
			<input type="text" id="SFlightTime" name="SFlightTime" value="<?= $flightDate->format('H:i')?>"
				class="col-md-2 timepicker form-control"/>
		</div>
		<div class="col-md-2">
			<label><?= PAX_NO ?></label>
			<input class="form-control col-md-2 required" min="1" type="text" id="PaxNo" name="PaxNo" value="<?=$xml->transfers->transfer[0]->passengers->total_passengers?>"/>
		</div>
	</div>
	<!--row-->
	<div class="row">
	<?	$pickupDateTime = new DateTime($xml->transfers->transfer[0]->origin->pickup_time);?>
		<div class="col-md-2">
			<label><?= PICKUP_DATE ?></label>
			<div class="input-group">
				<input type="text" id="SDate" name="SDate" value="<?= $pickupDateTime->format('Y-m-d')?>"
					class="form-control required col-md-2 datepicker"/>
			</div>
		</div>
		<div class="col-md-2">
			<label><?= PICKUP_TIME ?></label>
			<div class="input-group">
				<input type="text" id="STime" name="STime" value="<?= $pickupDateTime->format('H:i')?>"
					class="form-control col-md-2 timepicker"/>
			</div>
		</div>
		<div class="col-md-4">
			<label><?= VEHICLE ?></label>
			<select id="VehicleType1" name="VehicleType1" class="form-control">
				<option value="0"> --- </option>
				<?
					$v = vehicles();
					
					foreach ($v as $id => $name) {
						echo '<option value="'.$id.'">'.$name.'</option>';
					}
					?>
			</select><small>Vehicle: <?= $xml->transfers->transfer[0]->vehicle->title ?> - <?= $xml->transfers->transfer[0]->vehicle->max_passengers ?>pax</small>
		</div>
		<div class="col-md-3">
			<label><b><?= T_PRICE ?></b></label>
			<input type="text" id="OneWayPrice" name="OneWayPrice" value=""
				class="col-md-2 form-control required" onchange="setTotal();"/>
		</div>
	</div>
	<!-- row -->
	<div class="row">
		<div class="col-md-6">
			<br>
			<label><?= NOTES ?></label>
			<textarea id="SNote" name="SNote" rows="4" class="form-control">
<?foreach($xml->transfers->transfer[0]->extras->extra as $extra){
					echo $extra->name.' x '.$extra->quantity.PHP_EOL;
				}?></textarea>
			<br>
			<br>
		</div>
	</div>
	<!-- row -->
	<div class="row">
		<div class="col-md-12" xstyle="background: #99ccff">
			<h2  class="xblue-text"><?= RETURN_TRANSFER ?> &nbsp;
				<input type="checkbox" id="RTCheck" name="RTCheck" class="form-control w25 iCheck" 
				xstyle="width:30px;vertical-align:bottom;cursor:pointer" xonclick="RTChange();">
				<input type="hidden" name="RT" id="RT" value="0">
			</h2>
			<br>
		</div>
	</div>
	<!--row-->

	<!-- ----RETURN TRANSFER---------------------------------------------------------------------- -->
<? if($xml->transfers->transfer[1]->transfer_document != '') { ?>
	<div id="returnTransfer" style="display:visible">
<? } else { ?>
	<div id="returnTransfer" style="display:none">
<? } ?>
		<!--
			<div class="row">
				<h3><?= RETURN_TRANSFER ?></h3>
			</div>
			-->
		<div class="row">
			<div class="col-md-4">
				<label><?= FROM ?></label>
				<input class="form-control" type="text" id="RTerminal" name="RTerminal" value="<?= $xml->transfers->transfer[1]->origin->name ?>"
					/>
			</div>
			<div class="col-md-4">
				<label><?= TO ?></label>
				<input class="form-control" type="text" id="RDestination" name="RDestination" value="<?= $xml->transfers->transfer[1]->destination->name ?>"
					/>
			</div>
		</div>
		<!--row-->
		<div class="row">
<? if($xml->transfers->transfer[1]->origin->accommodation->pickup_address != ''){?>
			<div class="col-md-4">
				<label><?= PICKUP_ADDRESS ?></label>
				<input class="form-control" type="text" id="RPAddress" name="RPAddress" value="<?= $xml->transfers->transfer[1]->origin->accommodation->pickup_address ?>" />
			</div>
<? } elseif($xml->transfers->transfer[1]->origin->name != '') { ?>
			<div class="col-md-4">
				<label><?= PICKUP_ADDRESS ?></label>
				<input class="form-control" type="text" id="RPAddress" name="RPAddress" value="<?= $xml->transfers->transfer[1]->origin->name ?>" />
			</div>
<? } else { ?>
			<div class="col-md-4">
				<label><?= PICKUP_ADDRESS ?></label>
				<input class="form-control" type="text" id="RPAddress" name="RPAddress" value="" />
			</div>
<? }
	if($xml->transfers->transfer[1]->destination->accommodation->pickup_address != ''){?>
			<div class="col-md-4">
				<label><?= DROPOFF_ADDRESS ?></label>
				<input class="form-control" type="text" id="RDAddress" name="RDAddress" value="<?= $xml->transfers->transfer[1]->destination->accommodation->pickup_address ?>" />
			</div>
<? } elseif($xml->transfers->transfer[1]->destination->name != ''){?>
			<div class="col-md-4">
				<label><?= DROPOFF_ADDRESS ?></label>
				<input class="form-control" type="text" id="RDAddress" name="RDAddress" value="<?= $xml->transfers->transfer[1]->destination->name ?>" />
			</div>
<? } else {?>
			<div class="col-md-4">
				<label><?= DROPOFF_ADDRESS ?></label>
				<input class="form-control" type="text" id="RDAddress" name="RDAddress" value="" />
			</div>
<? } ?>
		</div>
		<!--row-->
		<div class="row">
			<div class="col-md-2">
				<label><?= FLIGHT_NO ?></label>
				<input type="text" id="RFlightNo" name="RFlightNo" value="<?=$xml->transfers->transfer[1]->destination->flight->flight_number ?>"
					class="col-md-2 form-control"/>
			</div>
			<div class="col-md-2">
				<?	$flightDate = new DateTime($xml->transfers->transfer[1]->destination->flight->date);?>
				<label><?= FLIGHT_TIME ?></label>
				<input type="text" id="RFlightTime" name="RFlightTime" value="<?= $flightDate->format('H:i')?>"
					class="form-control col-md-2 timepicker"/>
			</div>
		
		</div>
		<!--row-->
		<div class="row">
			<div class="col-md-2">
			<?	$returnDateTime = new DateTime($xml->transfers->transfer[1]->origin->pickup_time);?>
				<label><?= PICKUP_DATE ?></label>
				<div class="input-group">
					<input type="text" id="RDate" name="RDate" value="<?= $returnDateTime->format('Y-m-d')?>"
						class="col-md-2 datepicker form-control"/>
				</div>
			</div>
			<div class="col-md-2">
				<label><?= PICKUP_TIME ?></label>
				<div class="input-group">
					<input type="text" id="RTime" name="RTime" value="<?= $returnDateTime->format('H:i')?>"
						class="form-control col-md-2 timepicker"/>
				</div>
			</div>
			<div class="col-md-3 offset4">
				<label><b><?= T_PRICE ?></b></label>
				<input class="form-control" type="text" id="ReturnPrice" name="ReturnPrice" value=""
					class="col-md-2" onchange="setTotal();"/>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<label><?= NOTES ?></label>
				<textarea id="RNote" name="RNote" rows="4" class="form-control">
<?foreach($xml->transfers->transfer[1]->extras->extra as $extra){
					echo $extra->name.' x '.$extra->quantity.PHP_EOL;
				}?></textarea>
			</div>
		</div>
		<!--row-->

	</div>
	<!--returnTransfer-->

	<br><br>

	<hr style="border: solid 1px #000 !important">

	<!-- --------CUSTOMER DATA------------------------------------------------------------------------- -->		
	<div class="row">
		<div class="col-md-6" xstyle="background: #f98282">
			<h3 class="red-text"><?= TOTAL_PRICE ?>: 
				&nbsp;<input class="form-control xpull-right w25" type="text" 
						id="TotalPrice" name="TotalPrice" value=""
						style="background: transparent !important; border:none !important;text-align:right"
					readonly="readonly"/> EUR
			</h3>
		</div>
	</div>

	<hr style="border: solid 1px #000 !important">

	<div class="row">
		<div class="col-md-6">
			<span class="lead">
				<h3 class="xblue-text"><?= PASSENGER_INFO ?></h3>
				<br/>
			</span>
		</div>
		<div class="col-md-4">
			<span class="lead">
				<h3 class="xblue-text">Payment Details</h3>
				<br/>
			</span>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<label><?= FIRST_NAME ?></label>
			<p><input id="FirstName" name="FirstName" type="text" class="form-control required" 
				value="<?=$xml->lead_passenger->name?>"/></p>
			<label><?= LAST_NAME ?></label>
			<p><input id="LastName" name="LastName" type="text" class="form-control required" 
				value="<?=$xml->lead_passenger->surname?>"/></p>
			<label><?= EMAIL ?></label>
			<p><input id="Email" name="Email" type="text" class="form-control xrequired email" 
				value="booking@jamtransfer.com"/></p>
			<label><?= TELEPHONE ?></label>
			<p>
			<div class="input-group form-control">
				<!--
					<span class="input-group-addon"> + </span>
					
					<input id="TCode" name="TCode" type="text" 
					   class="form-control required number input-mini def" minlength="2" maxlength="4" 
					   value=""/>
					-->
				<? telCodes();?>
				<span class="input-group-addon"> - </span>
				<input id="TNumber" name="TNumber" type="text" 
					class="form-control required digits input-small def" 
					value=""/>
			</div>
			</p><small>Phone: <?=$xml->lead_passenger->mobile?></small>
		</div>
		<div class="col-md-4">
			<label><?= CASH ?></label>
			<p><input id="PayLater" name="PayLater" type="text" class="form-control def" value="0"/></p>
			<label><?= CARD ?></label>
			<p><input id="PayNow" name="PayNow" type="text" class="form-control def" value="0"/></p>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8">
			<br/><br/>
			<button id="finish" type="submit" name="SaveOrder" value="1" 
			class="btn btn-success btn-large"><?= F_FINISH ?></button></p>                
		</div>
	</div>

</form>


<script type="text/javascript">

	
	
	$("#finish").click(function(){
	    if ( $("#booking").valid() ) {
	    return true;
	    }
	
	});
	
document.getElementById('RTCheck').onchange = function() {
    // access properties using this keyword
    if ( this.checked ) {
        // if checked ...
        $("#RT").val('1');
        $("#RDestination").val( $("#Terminal").val() );
        $("#RTerminal").val( $("#Destination").val() );
        $("#RPAddress").val( $("#SDAddress").val() );
        $("#RDAddress").val( $("#SPAddress").val() );
        $("#returnTransfer").show('slow');
    } else {
        // if not checked ...
        $("#RT").val('0');
        $("#returnTransfer").hide('slow');
    }
};
	
	
	$("#Terminal").keyup(function() {
		var filter = $(this).val();
		var where = ' WHERE PlaceID > 0 ';
		if(filter.length > 2) {	
			// console.log(filter);
			$.getJSON("/cms/p/modules/v4_Places/v4_Places_All.php?callback=?&Search="+filter+"&where="+where,
			 function(data) {
			 // console.log(data);
			 	$("#fromList").show();
			 	$("#fromList").html('<select name="TerminalSelect" id="TerminalSelect" class="form-group w100 blue" onchange="TSChange();">');
				$.each(data.data, function (index, value) {
		  			$("#TerminalSelect").append('<option value="'+value.PlaceID+'">'+value.PlaceNameEN + '</option>');
				});
				$("#fromList").append('</select>');
			});
		}
	});
	
	function TSChange(){
		var text = $("#TerminalSelect option:selected").text();
		var id   = $("#TerminalSelect").val();
		// console.log(id);
		$("#Terminal").val(text);
	
	}
	

	$("#Destination").keyup(function() {
		var filter = $(this).val();
		var where = ' WHERE PlaceID > 0 ';
		if(filter.length > 2) {	
			// console.log(filter);
			$.getJSON("/cms/p/modules/v4_Places/v4_Places_All.php?callback=?&Search="+filter+"&where="+where,
			 function(data) {
			 // console.log(data);
			 	$("#toList").show();
			 	$("#toList").html('<select name="DestSelect" id="DestSelect" class="form-group w100 blue" onchange="DSChange();">');
				$.each(data.data, function (index, value) {
		  			$("#DestSelect").append('<option value="'+value.PlaceID+'">'+value.PlaceNameEN + '</option>');
				});
				$("#toList").append('</select>');
			});
		}
	});
	
	function DSChange(){
		var text = $("#DestSelect option:selected").text();
		var id   = $("#DestSelect").val();
		// console.log(id);
		$("#Destination").val(text);
	
	}
	
	
/*	
	// Terminal - Destination
	$("#FN").click(function(){
	 $("#Terminal").val('Loading...');
	$.get("ajaxTerminalsSelect.php",{ FieldName: 'Terminal', SpanID: 'FN' },
	 function(data){ 
	     //alert(data);
	     $("#Terminal").hide();
	     $("#FN").hide();
	     $("#FNMask").append(data); 
	 });
	});
	
	$("#TN").click(function(){
	var t = $("#Terminal").val();
	
	 $("#Destination").val('Loading...');
	$.get("ajaxDestinationsSelect.php",{ FieldName: 'Destination', SpanID: 'TN',term: t },
	 function(data){ 
	     //alert(data);
	     if (data != 'Error') {
	   $("#Destination").hide();
	   $("#TN").hide();
	   $("#TNMask").append(data); 
	}
	else { 
	$("#Destination").val('Pick From first');
	}
	 });
	});
	
	// Destination - Terminal
	$("#DTFN").click(function(){
	
	 $("#DTDestination").val('Loading...');
	$.get("ajaxDestinationsSelectDT.php",{ FieldName: 'DTDestination', SpanID: 'DTFN'},
	 function(data){ 
	     //alert(data);
	     $("#DTDestination").hide();
	     $("#DTFN").hide();
	     $("#DTFNMask").append(data); 
	 });
	});
	
	$("#DTTN").click(function(){
	var d = $("#DTDestination").val();
	 $("#DTTerminal").val('Loading...');
	$.get("ajaxTerminalsSelectDT.php",{ FieldName: 'DTTerminal', SpanID: 'DTTN', dest:d },
	 function(data){ 
	     //alert(data);
	     
	     if (data != 'Error') {
	   $("#DTTerminal").hide();
	   $("#DTTN").hide();
	   $("#DTTNMask").append(data); 
	}
	else {
	$("#DTTerminal").val('Pick From first');
	}
	 });
	});
	
*/	
	
	
	function setTotal()
	{
	    var t1 = '0' + $("#OneWayPrice").val();
	    var t2 = '0' + $("#ReturnPrice").val();
	    var total = parseFloat(t1) + parseFloat(t2);
	    
	    $("#TotalPrice").val(parseFloat(total).toFixed(2));
	}
	
	$(".def").focus(function(){
	if($(this).val() == $(this)[0].defaultValue)
	$(this).val("");
	});
	
	//da se tekst vrati nazad kada se klikne sa strane
	$(".def").blur(function(){
	if($.trim($(this).val()) == "")
	$(this).val($(this)[0].defaultValue);
	});
	
</script>




<?
} # end SaveOrder if loop



/*
**
** PHP FUNCTIONS
**
*/


function getAgents()
{
	global $au;
	$retArr = array();
	
	$where = " WHERE AuthLevelID = '2' ";
	$k = $au->getKeysBy("AuthUserCompany", "asc", $where);
	
	if(count($k) > 0 ) {
		foreach($k as $nn => $key) {
			$au->getRow($key);
		 	# Stavi TaxiSite-ove u array za kasnije
			$retArr[$au->AuthUserID] = $au->AuthUserCompany;
			
		}
	}
	return $retArr;
}

function getTaxiSites()
{
	global $au;
	$retArr = array();
	
	$where = " WHERE AuthLevelID = '12' ";
	$k = $au->getKeysBy("AuthUserCompany", "asc", $where);
	
	if(count($k) > 0 ) {
		foreach($k as $nn => $key) {
			$au->getRow($key);
		 	# Stavi TaxiSite-ove u array za kasnije
			$retArr[$au->AuthUserID] = $au->AuthUserCompany;
			
		}
	}
	return $retArr;
}

function vehicles()
{
	require_once ROOT.'/db/v4_VehicleTypes.class.php';
	$vt = new v4_VehicleTypes();
	
	$retArr = array();

	$k = $vt->getKeysBy("Max", "asc");
	
	if(count($k) > 0 ) {
		foreach($k as $nn => $key) {
			$vt->getRow($key);
		 	# Stavi TaxiSite-ove u array za kasnije
			$retArr[$vt->VehicleTypeID] = $vt->VehicleTypeName;
			
		}
	}
	return $retArr;
}



//function r($var) { return mysql_real_escape_string($_POST[$var]); }
function mail_utf8($to, $from_email, $from_user, $subject = '(No subject)', $message = '')
{ 
	$from_user = "=?UTF-8?B?".base64_encode($from_user)."?=";
	$subject = "=?UTF-8?B?".base64_encode($subject)."?=";
	$headers = "From: $from_user <$from_email>\r\n". 
	"MIME-Version: 1.0" . "\r\n" . 
	"Content-type: text/html; charset=UTF-8" . "\r\n"; 
	return mail($to, $subject, $message, $headers); 
}

function telCodes() {
echo '
<select name="TCode" id="TCode" class="form-control">
	<option value=""> --- </option>
	<option value="355">Albania (+355)</option>
	<option value="213">Algeria (+213)</option>
	<option value="376">Andorra (+376)</option>
	<option value="244">Angola (+244)</option>
	<option value="1264">Anguilla (+1264)</option>
	<option value="1268">Antigua &amp; Barbuda (+1268)</option>
	<option value="599">Antilles (Dutch) (+599)</option>
	<option value="54">Argentina (+54)</option>
	<option value="374">Armenia (+374)</option>
	<option value="297">Aruba (+297)</option>
	<option value="247">Ascension Island (+247)</option>
	<option value="61">Australia (+61)</option>
	<option value="43">Austria (+43)</option>
	<option value="994">Azerbaijan (+994)</option>
	<option value="1242">Bahamas (+1242)</option>
	<option value="973">Bahrain (+973)</option>
	<option value="880">Bangladesh (+880)</option>
	<option value="1246">Barbados (+1246)</option>
	<option value="375">Belarus (+375)</option>
	<option value="32">Belgium (+32)</option>
	<option value="501">Belize (+501)</option>
	<option value="229">Benin (+229)</option>
	<option value="1441">Bermuda (+1441)</option>
	<option value="975">Bhutan (+975)</option>
	<option value="591">Bolivia (+591)</option>
	<option value="387">Bosnia Herzegovina (+387)</option>
	<option value="267">Botswana (+267)</option>
	<option value="55">Brazil (+55)</option>
	<option value="673">Brunei (+673)</option>
	<option value="359">Bulgaria (+359)</option>
	<option value="226">Burkina Faso (+226)</option>
	<option value="257">Burundi (+257)</option>
	<option value="855">Cambodia (+855)</option>
	<option value="237">Cameroon (+237)</option>
	<option value="1">Canada (+1)</option>
	<option value="238">Cape Verde Islands (+238)</option>
	<option value="1345">Cayman Islands (+1345)</option>
	<option value="236">Central African Republic (+236)</option>
	<option value="56">Chile (+56)</option>
	<option value="86">China (+86)</option>
	<option value="57">Colombia (+57)</option>
	<option value="269">Comoros (+269)</option>
	<option value="242">Congo (+242)</option>
	<option value="682">Cook Islands (+682)</option>
	<option value="506">Costa Rica (+506)</option>
	<option value="385">Croatia (+385)</option>
	<option value="53">Cuba (+53)</option>
	<option value="90392">Cyprus North (+90392)</option>
	<option value="357">Cyprus South (+357)</option>
	<option value="42">Czech Republic (+42)</option>
	<option value="45">Denmark (+45)</option>
	<option value="2463">Diego Garcia (+2463)</option>
	<option value="253">Djibouti (+253)</option>
	<option value="1809">Dominica (+1809)</option>
	<option value="1809">Dominican Republic (+1809)</option>
	<option value="593">Ecuador (+593)</option>
	<option value="20">Egypt (+20)</option>
	<option value="353">Eire (+353)</option>
	<option value="503">El Salvador (+503)</option>
	<option value="240">Equatorial Guinea (+240)</option>
	<option value="291">Eritrea (+291)</option>
	<option value="372">Estonia (+372)</option>
	<option value="251">Ethiopia (+251)</option>
	<option value="500">Falkland Islands (+500)</option>
	<option value="298">Faroe Islands (+298)</option>
	<option value="679">Fiji (+679)</option>
	<option value="358">Finland (+358)</option>
	<option value="33">France (+33)</option>
	<option value="594">French Guiana (+594)</option>
	<option value="689">French Polynesia (+689)</option>
	<option value="241">Gabon (+241)</option>
	<option value="220">Gambia (+220)</option>
	<option value="7880">Georgia (+7880)</option>
	<option value="49">Germany (+49)</option>
	<option value="233">Ghana (+233)</option>
	<option value="350">Gibraltar (+350)</option>
	<option value="30">Greece (+30)</option>
	<option value="299">Greenland (+299)</option>
	<option value="1473">Grenada (+1473)</option>
	<option value="590">Guadeloupe (+590)</option>
	<option value="671">Guam (+671)</option>
	<option value="502">Guatemala (+502)</option>
	<option value="224">Guinea (+224)</option>
	<option value="245">Guinea - Bissau (+245)</option>
	<option value="592">Guyana (+592)</option>
	<option value="509">Haiti (+509)</option>
	<option value="504">Honduras (+504)</option>
	<option value="852">Hong Kong (+852)</option>
	<option value="36">Hungary (+36)</option>
	<option value="354">Iceland (+354)</option>
	<option value="91">India (+91)</option>
	<option value="62">Indonesia (+62)</option>
	<option value="98">Iran (+98)</option>
	<option value="964">Iraq (+964)</option>
	<option value="353">Ireland (+353)</option>
	<option value="972">Israel (+972)</option>
	<option value="39">Italy (+39)</option>
	<option value="225">Ivory Coast (+225)</option>
	<option value="1876">Jamaica (+1876)</option>
	<option value="81">Japan (+81)</option>
	<option value="962">Jordan (+962)</option>
	<option value="7">Kazakhstan (+7)</option>
	<option value="254">Kenya (+254)</option>
	<option value="686">Kiribati (+686)</option>
	<option value="850">Korea North (+850)</option>
	<option value="82">Korea South (+82)</option>
	<option value="965">Kuwait (+965)</option>
	<option value="996">Kyrgyzstan (+996)</option>
	<option value="856">Laos (+856)</option>
	<option value="371">Latvia (+371)</option>
	<option value="961">Lebanon (+961)</option>
	<option value="266">Lesotho (+266)</option>
	<option value="231">Liberia (+231)</option>
	<option value="218">Libya (+218)</option>
	<option value="417">Liechtenstein (+417)</option>
	<option value="370">Lithuania (+370)</option>
	<option value="352">Luxembourg (+352)</option>
	<option value="853">Macao (+853)</option>
	<option value="389">Macedonia (+389)</option>
	<option value="261">Madagascar (+261)</option>
	<option value="265">Malawi (+265)</option>
	<option value="60">Malaysia (+60)</option>
	<option value="960">Maldives (+960)</option>
	<option value="223">Mali (+223)</option>
	<option value="356">Malta (+356)</option>
	<option value="692">Marshall Islands (+692)</option>
	<option value="596">Martinique (+596)</option>
	<option value="222">Mauritania (+222)</option>
	<option value="269">Mayotte (+269)</option>
	<option value="52">Mexico (+52)</option>
	<option value="691">Micronesia (+691)</option>
	<option value="373">Moldova (+373)</option>
	<option value="377">Monaco (+377)</option>
	<option value="976">Mongolia (+976)</option>
	<option value="382">Montenegro (+382)</option>
	<option value="1664">Montserrat (+1664)</option>
	<option value="212">Morocco (+212)</option>
	<option value="258">Mozambique (+258)</option>
	<option value="95">Myanmar (+95)</option>
	<option value="264">Namibia (+264)</option>
	<option value="674">Nauru (+674)</option>
	<option value="977">Nepal (+977)</option>
	<option value="31">Netherlands (+31)</option>
	<option value="687">New Caledonia (+687)</option>
	<option value="64">New Zealand (+64)</option>
	<option value="505">Nicaragua (+505)</option>
	<option value="227">Niger (+227)</option>
	<option value="234">Nigeria (+234)</option>
	<option value="683">Niue (+683)</option>
	<option value="672">Norfolk Islands (+672)</option>
	<option value="670">Northern Marianas (+670)</option>
	<option value="47">Norway (+47)</option>
	<option value="968">Oman (+968)</option>
	<option value="92">Pakistan (+92)</option>
	<option value="680">Palau (+680)</option>
	<option value="507">Panama (+507)</option>
	<option value="675">Papua New Guinea (+675)</option>
	<option value="595">Paraguay (+595)</option>
	<option value="51">Peru (+51)</option>
	<option value="63">Philippines (+63)</option>
	<option value="48">Poland (+48)</option>
	<option value="351">Portugal (+351)</option>
	<option value="1787">Puerto Rico (+1787)</option>
	<option value="974">Qatar (+974)</option>
	<option value="262">Reunion (+262)</option>
	<option value="40">Romania (+40)</option>
	<option value="7">Russia (+7)</option>
	<option value="250">Rwanda (+250)</option>
	<option value="378">San Marino (+378)</option>
	<option value="239">Sao Tome &amp; Principe (+239)</option>
	<option value="966">Saudi Arabia (+966)</option>
	<option value="221">Senegal (+221)</option>
	<option value="381">Serbia (+381)</option>
	<option value="248">Seychelles (+248)</option>
	<option value="232">Sierra Leone (+232)</option>
	<option value="65">Singapore (+65)</option>
	<option value="421">Slovak Republic (+421)</option>
	<option value="386">Slovenia (+386)</option>
	<option value="677">Solomon Islands (+677)</option>
	<option value="252">Somalia (+252)</option>
	<option value="27">South Africa (+27)</option>
	<option value="34">Spain (+34)</option>
	<option value="94">Sri Lanka (+94)</option>
	<option value="290">St. Helena (+290)</option>
	<option value="1869">St. Kitts (+1869)</option>
	<option value="1758">St. Lucia (+1758)</option>
	<option value="249">Sudan (+249)</option>
	<option value="597">Suriname (+597)</option>
	<option value="268">Swaziland (+268)</option>
	<option value="46">Sweden (+46)</option>
	<option value="41">Switzerland (+41)</option>
	<option value="963">Syria (+963)</option>
	<option value="886">Taiwan (+886)</option>
	<option value="7">Tajikstan (+7)</option>
	<option value="66">Thailand (+66)</option>
	<option value="228">Togo (+228)</option>
	<option value="676">Tonga (+676)</option>
	<option value="1868">Trinidad &amp; Tobago (+1868)</option>
	<option value="216">Tunisia (+216)</option>
	<option value="90">Turkey (+90)</option>
	<option value="7">Turkmenistan (+7)</option>
	<option value="993">Turkmenistan (+993)</option>
	<option value="1649">Turks &amp; Caicos Islands (+1649)</option>
	<option value="688">Tuvalu (+688)</option>
	<option value="256">Uganda (+256)</option>
	<option value="44">UK (+44)</option>
	<option value="380">Ukraine (+380)</option>
	<option value="971">United Arab Emirates (+971)</option>
	<option value="598">Uruguay (+598)</option>
	<option value="1">USA (+1)</option>
	<option value="7">Uzbekistan (+7)</option>
	<option value="678">Vanuatu (+678)</option>
	<option value="379">Vatican City (+379)</option>
	<option value="58">Venezuela (+58)</option>
	<option value="84">Vietnam (+84)</option>
	<option value="1284">Virgin Islands - British (+1284)</option>
	<option value="1340">Virgin Islands - US (+1340)</option>
	<option value="681">Wallis &amp; Futuna (+681)</option>
	<option value="969">Yemen (North)(+969)</option>
	<option value="967">Yemen (South)(+967)</option>
	<option value="243">Zaire (+243)</option>
	<option value="260">Zambia (+260)</option>
	<option value="263">Zimbabwe (+263)</option>
</select>
';
}



function insertOrder($type='temp') {	
	
	global $OrderKey;
	
	if($type == 'temp') {

		require_once ROOT . '/db/v4_OrdersMasterTemp.class.php';
		require_once ROOT . '/db/v4_OrderDetailsTemp.class.php';
		require_once ROOT . '/db/v4_OrderExtrasTemp.class.php';
		
		$om = new v4_OrdersMasterTemp();
		$od = new v4_OrderDetailsTemp();
		$ox = new v4_OrderExtrasTemp();
		
		$OrderKey = r('order_number'); // postavlja se u webtehPayment.php
	}
	else if($type=='final') {

		require_once ROOT . '/db/v4_OrdersMaster.class.php';
		require_once ROOT . '/db/v4_OrderDetails.class.php';
		require_once ROOT . '/db/v4_OrderExtras.class.php';
		
		$om = new v4_OrdersMaster();
		$od = new v4_OrderDetails();
		$ox = new v4_OrderExtras();
		
		$OrderKey = create_order_key(); // pravi OrderKey
	}
	
	require_once ROOT . '/db/v4_AuthUsers.class.php';
	$au = new v4_AuthUsers();
	
	// From and To names
	$fromName 	=  r('Terminal') ;
	$toName 	=  r('Destination');

	
	$omOrderID = '';
	
	// Driver Data
	$driver = '';
	$driverName = '';
	$driverTel 	= '';
	$driverEmail= '';

	$InvoiceAmount = 0;
	$ProvisionAmount = 0;
	
	$returnTransfer = r("RT");
		
	if(r('AuthUserID') == 0 and r('AuthUserIDTaxi') == 0) {
		$UserID  = $_SESSION['AuthUserID'];
		$LevelID = $_SESSION['AuthLevelID'];
	}
	elseif (r('AuthUserID') > 0 and r('AuthUserIDTaxi') == 0) {
		$UserID  = r("AuthUserID");
		$LevelID = '2';	
		# Get AuthUser Provision
		$k = $au->getKeysBy("AuthUserID", "ASC", " WHERE AuthUserID = " . $UserID);
		if(count($k) == 1) {
			$au->getRow($k[0]);
			if($au->getAuthUserID() == $UserID) {

				# pretvaranje postotka u faktor - za izracun iznosa provizije
				$ProvisionFactor = 1 - ($au->getProvision()/100);
		
				$InvoiceAmount = r('TotalPrice') * $ProvisionFactor;
				$ProvisionAmount = r('TotalPrice') - $InvoiceAmount;
			}
		}
	}

	elseif (r('AuthUserIDTaxi') > 0 and r('AuthUserID') == 0) {
		$UserID  = r("AuthUserIDTaxi");
		$LevelID = '12';	
	}
	elseif (r('AuthUserIDTaxi') > 0 and r('AuthUserID') > 0) {
		echo '	<div class="alert alert-danger">
					<h2>Error - you can not select both Agent and TaxiSite User!</h2>
				</div>';
		die();
	}		
	
	// Payment Statuses
	
	if(r('PayLater') == 0 and r('PayNow') > 0) {
	    $paymentStatus = '99'; // PayLater = 0, sve placeno
	    $paymentMethod = '2';
	   }
	elseif (r('PayLater') > 0 and r('PayNow') > 0) {
	    $paymentStatus = '0'; // PayLater nije nula, znaci ima jos za platiti
	    $paymentMethod = '3';
	}
	elseif (r('PayLater') == 0 and r('PayNow') > 0) {
	    $paymentStatus = '99'; // PayLater nije nula, znaci ima jos za platiti
	    $paymentMethod = '1';
	}
	
	// CURRENCIES
	if(r('Currency') != 'EUR') {
		
	}
	
	if($UserID == '') $UserID = '53';
	
	// OrdersMaster
		$om->setMOrderKey( $OrderKey );
		$om->setSiteID('2');
		$om->setMOrderStatus('1');
		
		$om->setMOrderType( r("MOrderType") );
		
		$om->setMOrderDate(date("Y-m-d"));
		$om->setMOrderTime(date("H:i:s"));
		$om->setMUserID($UserID);
		$om->setMUserLevelID( $LevelID ); 
		$om->setMTransferPrice( r('TotalPrice') );
		//$om->setMExtrasPrice( r('ET') );
		$om->setMOrderPriceEUR( r("TotalPrice") );
		$om->setMOrderCurrency( 'EUR' );
		$om->setMOrderCurrencyPrice( r("TotalPrice") );
		$om->setMEurToCurrencyRate( '1');
		//$om->setMPaymentMethod( r("PaymentOption") );
		$om->setMPaymentStatus( $paymentStatus);
		$om->setMPayNow( r('PayNow') );
		$om->setMPayLater( r('PayLater') );
		$om->setMInvoiceAmount( $InvoiceAmount);
		$om->setMAgentCommision( $ProvisionAmount);
		$om->setMPaxFirstName( r("FirstName") );
		$om->setMPaxLastName( r("LastName") );
		$om->setMPaxTel( r("TCode") . '-'. r("TNumber") );
		$om->setMPaxEmail( r("Email") );
		//$om->setMCustomerID( r('Customer']['ID');
		$om->setMCardType( 'FREEFORM');
		/*
		$om->setMCardFirstName( r("ch_name");
		$om->setMCardLastName( r("ch_last_name");
		$om->setMCardEmail( r("ch_email");
		$om->setMCardTel( r("ch_phone");
		$om->setMCardAddress( r("ch_address");
		$om->setMCardCity( r("ch_city");
		$om->setMCardZip( r("ch_zip");
		$om->setMCardCountry( GetCountryName( r("ch_country") );
		$om->setMCardNumber( r("MCardNumber");
		$om->setMCardCVD( r("MCardCVD");
		$om->setMCardExpDate( r("MCardExpDate");
		$om->setMConfirmFile( r("MConfirmFile");
		$om->setMCancelFile( r("MCancelFile");
		$om->setMChangeFile( r("MChangeFile");
		$om->setMSubscribe( r("MSubscribe");
		$om->setMAcceptTerms( '1');
		$om->setMSendEmail( r("MSendEmail");
		$om->setMEmailSentDate( r("MEmailSentDate");
		$om->setMCustomerIP( r("MCustomerIP");
		$om->setMOrderLang( r('language');
		*/

		
		$omOrderID = $om->saveAsNew();
		
		// Update OrderKey za printReservation.php
		//$OrderKey .= '-' . $omOrderID;

		//**********
		// DETAILS
		//**********
		
		// Kalkulacija cijena za upis
		$payNow 		= number_format(r('PayNow'), 2, '.', '');
		$payLater 		= number_format(r('PayLater'), 2, '.', '');
		$extras 		= number_format(r('ET'), 2, '.', '');
		$transferPrice	= number_format(r('TotalPrice'), 2, '.', '');
		
		$driversPrice	= number_format(getDriverPrice(r('ServiceID')), 2, '.', '');

		if ($returnTransfer) {
			$payNow 		= number_format(r('PayNow') / 2, 2, '.', '');
			$payLater 		= number_format(r('PayLater') / 2, 2, '.', '');
			$extras 		= number_format(r('ET') / 2, 2, '.', '');
			$transferPrice	= number_format(r('TotalPrice') / 2, 2, '.', '');
			
			$driversPrice	= number_format(getDriverPrice(r('ServiceID')), 2, '.', '');
			$InvoiceAmount  = number_format($InvoiceAmount / 2, 2, '.', '');
			$ProvisionAmount  = number_format($ProvisionAmount / 2, 2, '.', '');
		}
		
		// Driver Confirmation Status
		// za JT je pitanje sto bi ivdje trebalo biti 
		// 0 = no driver 
		// 1 = Not Confirmed
		// kako sad stvari stoje, driver odmah vidi transfer 
		// mozda bi trebalo isprazniti DriverID, pa da ga operater stavi kasnije
		$driverConfStatus = '1';
		
		$od->setSiteID('2');
		$od->setOrderID($omOrderID);
		$od->setTNo('1');
		$od->setUserID( $UserID );
		$od->setUserLevelID( $LevelID );
		if($LevelID == 2) $od->setAgentID( $UserID );
		//$od->setCustomerID( r("Customer"]["ID");
		$od->setTransferStatus( '1');
		$od->setOrderDate(date("Y-m-d"));
		//$od->setTaxidoComm( r("TaxidoComm") );
		//$od->setServiceID( r("ServiceID"));
		//$od->setRouteID( r("RouteID"));
		$od->setFlightNo( r("SFlightNo") );
		$od->setFlightTime( r("SFlightTime") );
		$od->setPaxName( r("FirstName") . ' ' . r('LastName') );
		$od->setPickupID('');
		$od->setPickupName( $fromName);
		//$od->setPickupPlace( r("PickupPlace");
		$od->setPickupAddress( r("SPAddress") );
		$od->setPickupDate(r('SDate') );
		$od->setPickupTime(r('STime') );
		$od->setPickupNotes( r("SNote") );
		$od->setDropID('' );
		$od->setDropName( $toName );
		//$od->setDropPlace( r("DropPlace");
		$od->setDropAddress( r("SDAddress") );
		$od->setDropNotes( r("SNote") );
		//$od->setPriceClassID( r("PriceClassID") );
		$od->setDetailPrice( $transferPrice);
		$od->setDriversPrice( $driversPrice);
		//$od->setDiscount( r("Discount");
		//$od->setExtraCharge( $extras);
		//$od->setPaymentMethod( r("PaymentOption") );
		$od->setPaymentStatus( $paymentStatus);
		$od->setPayNow( $payNow);
		$od->setPayLater( $payLater);
		$od->setInvoiceAmount( $InvoiceAmount);
		$od->setProvisionAmount( $ProvisionAmount);
		$od->setPaxNo(r('PaxNo') );
		$od->setVehiclesNo( '1');
		$od->setVehicleType( r("VehicleType1") ); // vidit
		$od->setVehicleID( r("VehicleID") );
		/*
		$od->setDriverID( r("DriverID") );
		$od->setDriverName( $driverName);
		$od->setDriverEmail( $driverEmail);
		$od->setDriverTel( $driverTel);
		$od->setDriverConfStatus( $driverConfStatus);
		$od->setDriverConfDate( r("DriverConfDate");
		$od->setDriverConfTime( r("DriverConfTime");
		$od->setDriverNotes( r("DriverNotes");
		$od->setDriverPayment( r("DriverPayment");
		$od->setDriverPaymentAmt( r("DriverPaymentAmt");
		$od->setRated( r("Rated");
		$od->setDriverPickupDate( r("DriverPickupDate");
		$od->setDriverPickupTime( r("DriverPickupTime");
		$od->setSubDriver( r("SubDriver");
		$od->setCar( r("Car");
		$od->setCashIn( r("CashIn");
		$od->setFinalNote( r("FinalNote");
		*/
		
		$oneWayID = $od->saveAsNew();
		
		if ($returnTransfer) {
			$od->setSiteID('2');
			$od->setOrderID($omOrderID);
			$od->setTNo('2');
			$od->setUserID( $UserID);
			$od->setUserLevelID( $LevelID);
			if($LevelID == 2) $od->setAgentID( $UserID);
			//$od->setCustomerID( r("Customer"]["ID");
			$od->setTransferStatus( '1');
			$od->setOrderDate(date("Y-m-d"));
			//$od->setTaxidoComm( r("TaxidoComm") );
			//$od->setServiceID( r("ServiceID") );
			//$od->setRouteID( r("RouteID") );
			$od->setFlightNo( r("RFlightNo") );
			$od->setFlightTime( r("RFlightTime") );
			$od->setPaxName( r("FirstName") . ' ' . r('LastName') );
			$od->setPickupID('' );
			$od->setPickupName( $toName);
			//$od->setPickupPlace( r("DropPlace"));
			$od->setPickupAddress( r("RPAddress"));
			$od->setPickupDate(r('RDate') );
			$od->setPickupTime(r('RTime') );
			$od->setPickupNotes( r("RNote") );
			$od->setDropID('');
			$od->setDropName( $fromName);
			//$od->setDropPlace( r("PickupPlace") );
			$od->setDropAddress( r("RDAddress") );
			$od->setDropNotes( r("RNote") );
			//$od->setPriceClassID( r("PriceClassID") );
			$od->setDetailPrice( $transferPrice);
			$od->setDriversPrice( $driversPrice);
			//$od->setDiscount( r("Discount");
			//$od->setExtraCharge( $extras);
			//$od->setPaymentMethod( r("PaymentOption") );
			$od->setPaymentStatus( $paymentStatus);
			$od->setPayNow( $payNow);
			$od->setPayLater( $payLater);
			$od->setInvoiceAmount( $InvoiceAmount);
			$od->setProvisionAmount( $ProvisionAmount);
			$od->setPaxNo(r('PaxNo') );
			$od->setVehiclesNo( '1');
			$od->setVehicleType( r("VehicleType1") ); // vidit
			$od->setVehicleID( r("VehicleID") );
			/*
			$od->setDriverID( r("DriverID");
			$od->setDriverName( $driverName);
			$od->setDriverEmail( $driverEmail);
			$od->setDriverTel( $driverTel);
			$od->setDriverConfStatus( $driverConfStatus );
			$od->setDriverConfDate( r("DriverConfDate");
			$od->setDriverConfTime( r("DriverConfTime");
			$od->setDriverNotes( r("DriverNotes");
			$od->setDriverPayment( r("DriverPayment");
			$od->setDriverPaymentAmt( r("DriverPaymentAmt");
			$od->setRated( r("Rated");
			$od->setDriverPickupDate( r("DriverPickupDate");
			$od->setDriverPickupTime( r("DriverPickupTime");
			$od->setSubDriver( r("SubDriver");
			$od->setCar( r("Car");
			$od->setCashIn( r("CashIn");
			$od->setFinalNote( r("FinalNote");
			*/
		
			$returnID = $od->saveAsNew();		
		}// end if (s('returnTransfer')) 
		/*
		$ExtraServices 	= s('ExtraServices');
		$ExtraSubtotals	= s('ExtraSubtotals');
		$ExtraItems		= s('ExtraItems');		
		if( count($ExtraItems) > 0 ) {
			foreach($ExtraItems as $rbr => $value) {
				if($ExtraSubtotals[$rbr] > 0) {
					
					$ox->setOrderDetailsID($oneWayID);
					$ox->setServiceID($rbr);
					$ox->setServiceName($ExtraServices[$rbr);
					$ox->setPrice( nf( $ExtraSubtotals[$rbr] / $ExtraItems[$rbr] ) );
					$ox->setQty($ExtraItems[$rbr);
					$ox->setSum($ExtraSubtotals[$rbr);
					
					$ox->saveAsNew();
				}
			
			}
		}
		*/
		if($omOrderID !== '') return $omOrderID;
		else return false;
}

