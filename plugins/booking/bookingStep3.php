<?
//
// koristi funkciju PrintTransferMaterial za ispis na ekran i
// printAgentVoucher za slanje u mailu
// ODE IDE AGENTSKI MAIL ZA REZERVACIJE - FREE FORM?

	require_once 'scripts.js.php';	

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
		
	require_once ROOT . '/db/v4_OrdersMaster.class.php';

	$om = new v4_OrdersMaster();
	$Where="WHERE  MConfirmFile='".$_SESSION['ReferenceNo']."' and MConfirmFile<>''";
	$omKeys = $om->getKeysBy('MOrderID', "ASC", $Where);
	
	
	if (count($omKeys) == 0) {
	
		// Upis u bazu
		$OrderKey = '';
		$OrderID = insertOrder('final');
	
		if($OrderID !== false) {
			$ok = true;
			$OrderKey = $OrderKey .'-'.$OrderID;
		}
		if ($ok) {

			ob_start();
			
			printVoucher($OrderID, false);

			
			$potvrda = ob_get_contents();
			ob_end_clean();
			echo '<div class="container white shadow">' . $potvrda .'</div>';

			//****************
			// PDF GENERATION
			//****************
			require_once ROOT ."/common/mpdf60/mpdf.php";

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

			//$mpdf->WriteHTML(utf8_encode($html)); 
			$mpdf->WriteHTML($html); // a ovo ne

			$content = $mpdf->Output('', 'S');

			$content = chunk_split(base64_encode($content));

			$mpdf->Output('./pdf/'.$OrderKey.'.pdf');

			/* END PDF ***********************************************************************************************/

			$mailto = $_REQUEST['MPaxEmail'];

			$replyto = 'info@jamtransfer.com';
			$from_mail = 'confirmation@jamtransfer.com';
			$from_name = 'JamTransfer.com';
			$mailSubjectPrefix = '';

			$subject = $from_name . ' Order: ' . $OrderKey;
			
			$sent = mail_html('cms@jamtransfer.com', $from_mail, $from_name, $replyto, $mailSubjectPrefix.$subject, $potvrda, ROOT .'/cms/pdf/'.$OrderKey.'.pdf');
			echo ($sent? 'Sent':'Not sent :'.$mailto );
			
			if (!empty($mailto)) {
				$sent = mail_html($mailto, $from_mail, $from_name, $replyto, $subject, $potvrda);
				echo ($sent? 'Sent':'Not sent :'.$mailto );
			}
		}
		else {
			echo '	<div class="row">
						<div class="alert alert-danger">
							ERROR: Order ' . $OrderKey . ' NOT Saved!
						</div>
					</div>
			';	
		}
		
	
		sendDriverNotification($OrderID, $OrderKey);
	
		require_once ROOT . '/db/v4_OrdersMaster.class.php';
		require_once ROOT . '/db/v4_OrderDetails.class.php';
		$om = new v4_OrdersMaster();
		$od = new v4_OrderDetails();

		$om->getRow($OrderID);
	
			echo $printMessage = '
			<h5>You are successfully finished booking process!</h5><br>
			Passenger name: '. ucwords($om->MPaxFirstName) . '  ' . ucwords($om->MPaxLastName) . '<br>
			Reservation Code: <b>' . $om->MOrderKey . '-' . $om->MOrderID . '</b><br><br>';
	}
	else echo $printMessage = "<h5>You enter duplicate Reference number: ".$_SESSION['ReferenceNo']."</h5><br>";
?>
	<a href='booking' class="btn btn-large grey xcol xs12 l "><i class="fa fa-chevron-circle-left"></i>&nbsp; New booking</a>
	<a href='transfersList/order/<? echo $om->MOrderID; ?>' class="btn btn-large grey xcol xs12 l ">Go to transfer list &nbsp;<i class="fa fa-chevron-circle-right"></i></a>
