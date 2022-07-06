 <?

// Prvi if() - Inicijalni prikaz, popunjavaju se vrijednosti 
// Drugi if() - Save opcija - koristi iste template, 
// ali tada se input polja zamjenjuju sa $_REQUEST vrijednostima

//Save ne radi ukoliko nije submit=1, kad dolazimo iz foreign template storna, 
//submit ostaje 0, dodano hidden input polje koje je uvijek 1 za storno
//Postavljamo submit na 1, kako bi save radio. bogo je storno slozio tako samo sto je dodao crticu na samom prikazu
//pa se kod savea storna zapravo radi isti racun sa drugim brojem i cijenama u plusu..potrebno staviti ako je storno da sve stavi u minus prije spremanja

if(isset($_REQUEST['Storno']) and $_REQUEST['Storno'] == '1') {
	$_REQUEST['Submit'] = 1; 
}

if(isset($_REQUEST['Submit']) and $_REQUEST['Submit'] == '1') {
	
	require_once ROOT . '/db/v4_OrdersMaster.class.php';
	require_once ROOT . '/db/v4_OrderDetails.class.php';
	require_once ROOT . '/db/v4_Invoices.class.php';
	require_once ROOT . '/db/v4_InvoiceDetails.class.php';
	
	$om = new v4_OrdersMaster();
	$od = new v4_OrderDetails();
	$in = new v4_Invoices();
	$id = new v4_InvoiceDetails();
	
	$d	 	= $_REQUEST['d']; // DriverID
	$start 	= $_REQUEST['s']; // start date
	$end	= $_REQUEST['e']; // end date 
	$ns		= $_REQUEST['ns']; // noshow
	$de 	= $_REQUEST['de']; // driverError
	$ct 	= $_REQUEST['ct']; // Completed Transfers Only
	$si 	= $_REQUEST['si']; // Sistem


	$detailsID = array();
	$invoiceExists = false;
	
	$knjigovodstvo = 0;
	$knjigovodstvo = $_REQUEST['k']; // 1 = racun za knjigovodstvo
	
	$taxPercent = 0;
	$taxAmt 	= 0;
	$driversPriceSum = 0;
	$isInSerbia = false;
	$saved = false;
	
	// uzmi podatke o tecaju RSD iz file-a
	$filename = ROOT . '/cms/exchangeRate.inc';
	$tecaj = file_get_contents($filename);
	$_SESSION['TecajRSD'] = $tecaj;
	
	$Date = date("Y-m-d"); // invoice date - default danas
	$dueDate = date('Y-m-d', strtotime($Date. ' + 15 days')); // za strane racune rok placanja 15 dana
	
	// ako je InvoiceDate ispunjen u prvom koraku
	if(isset($_REQUEST['InvoiceDate'])) {
		$dueDate = date('Y-m-d', strtotime($_REQUEST['InvoiceDate']. ' + 15 days'));
	}

	$sum = 0;
	$i = 0;

	 // User Object
	$u = getUser($d);		

	// FILTER PODATAKA
	//$whereD  = " WHERE UserID ='" . $d ."' ";
	if (getConnectedUser($d)>0) $whereD = " WHERE (UserID = '" . $d. "'  OR UserID =  '".getConnectedUser($d). "') "; 
	else $whereD  = " WHERE UserID ='" . $d ."' ";
	
	if($si != 1) {
		$whereD .= " AND OrderDate >= '{$start}' AND OrderDate <= '{$end}' ";
	} else {
		$whereD .= " AND PickupDate >= '{$start}' AND PickupDate <= '{$end}' ";
	}
	if($ct != 1) {
		$whereD .= " AND TransferStatus != 3 ";// cancel
		$whereD .= " AND TransferStatus != 4 ";// temp
		$whereD .= " AND TransferStatus != 9 ";//deleted
	} else {
		$whereD .= "AND TransferStatus = 5 ";//completed only
	}

	if($ns != 1) $whereD .= " AND DriverConfStatus != 5 ";//no-show
	if($de != 1) $whereD .= " AND DriverConfStatus != 6 ";//driver error
	
	$whereD .= " AND PaymentMethod = '4' ";

	
	$kd = $od->getKeysBy('DetailsID', 'asc', $whereD);


	// kliknut je Save botun
	if( isset($_REQUEST['Save']) and 
		$_REQUEST['Save'] == '1' and 
		isset($_REQUEST['InvoiceNumber']) and 
		!empty($_REQUEST['InvoiceNumber']) ) {
		
		// Provjera postoji li vec racun sa ovim brojem
		$inKey = $in->getKeysBy('ID', 'ASC', " WHERE InvoiceNumber='" . $_REQUEST['InvoiceNumber'] . "'");
		
		if(count($inKey) > 0) {
			$in->getRow($inKey[0]);
			if( $in->getInvoiceNumber() == $_REQUEST['InvoiceNumber'] ) {
				$invoiceExists = true;
			}
		}
		
		
		// upis podataka u v4_OrderDetails i v4_Invoices
		if(!$invoiceExists) {
			
			foreach($_SESSION['details'] as $key => $detail) {
				
				$DetailsID = $key;
				$desc = $detail['Description'];
				$qty = $detail['Qty'];
				$price = $detail['Price'];
				$subTotal = $detail['SubTotal'];
				$od->getRow($DetailsID);
				$od->setInvoiceNumber( $_REQUEST['InvoiceNumber'] );
				$od->setInvoiceDate( date_change_format ($_REQUEST['InvoiceDate'] ));
				$od->setPaymentStatus( '1' ); // Invoice sent
			
				$od->saveRow();
				
				if($u->CountryName == 'Serbia') {
					$om->getRow($od->getOrderID());
					$om->setMEurToCurrencyRate($_SESSION['TecajRSD']);
					$om->saveRow();
				}
				
				$id->setInvoiceNumber( $_REQUEST['InvoiceNumber'] );
				$id->setDescription( $desc );
				$id->setQty( $qty );
				$id->setPrice( $price );
				$id->setSubTotal( $subTotal );
				$id->setDetailsID( $DetailsID );
				
				$id->saveAsNew();
				
				
				
			}
		
			$in->setType( '1' ); // Agentski racun
			$in->setInvoiceNumber( $_REQUEST['InvoiceNumber'] );
			$in->setInvoiceDate( date_change_format ($_REQUEST['InvoiceDate'] ));
			$in->setStartDate( $start );
			$in->setEndDate( $end );
			$in->setUserID( $d );
			$in->setDueDate( $_REQUEST['DueDate'] );
			$in->setSumPrice( $_REQUEST['SumPrice'] );
			$in->setSumSubtotal( $_REQUEST['SumSubTotal'] );
			$in->setCommPrice( $_REQUEST['CommPrice'] );
			$in->setCommSubtotal( $_REQUEST['CommSubtotal'] );
			$in->setTotalPriceEUR( $_REQUEST['TotalPriceEUR'] );
			$in->setTotalSubTotalEUR( $_REQUEST['TotalSubTotalEUR'] );
			$in->setVATNotApp( $_REQUEST['VATNotApp'] );
			$in->setVATBaseTotal( $_REQUEST['VATBaseTotal'] );
			$in->setVATtotal( $_REQUEST['VATtotal'] );
			$in->setGrandTotal( $_REQUEST['GrandTotal'] );

			$in->setCreatedBy( $_SESSION['AuthUserID'] );
			$in->setCreatedDate( date("Y-m-d") );
			$in->setStatus( '0' );
		
			$result = $in->saveAsNew(); // vraca ID novog racuna
	
			if( $result > 0 ) {
		 		// OBRADA ZAVRSENA, MOZE SE PRIKAZATI PDF
				$saved = true;

			} else {
			
				echo '	<div class="center alert-danger pad1em" style="visibility:screenonly !important">
							<h1>Warning: Invoice already exists!</h1>
						</div>
					';
				$saved = true;
				//die();	
			}		
		} else {
			$saved = true;
			$_SESSION['detailsID'] = array();
		} // endif invoiceExists
		
		
		ob_start();

		if($knjigovodstvo == '1') {

			/*
			 * RACUN ZA KNJIGOVODSTVO
			 */
		
			$replaceChars = array('/','\\');
			$PDFfile = 	'/cms/pdf/RK_'. str_replace($replaceChars,'-',$_REQUEST['InvoiceNumber']).'.pdf';
					


			if($u->CountryName != 'Serbia') {
				require ROOT . '/cms/p/modules/reports/admin/invoiceForeignTemplate.PDF.php';
			}
			else {
				require ROOT . '/cms/p/modules/reports/admin/invoiceSerbianTemplate.PDF.php';
			}

		}
		
		
		if($knjigovodstvo != '1') {
			/*
			 * RACUN ZA AGENTA
			 */		
			$html = '';
			$knjigovodstvo = '0';

			$replaceChars = array('/','\\');
			$PDFfile = 	'/cms/pdf/RA_'. str_replace($replaceChars,'-',$_REQUEST['InvoiceNumber']).'.pdf';
					
			ob_start();

			if($u->CountryName != 'Serbia') {
				require ROOT . '/cms/p/modules/reports/admin/invoiceForeignTemplate.PDF.php';
			}
			else {
				require ROOT . '/cms/p/modules/reports/admin/invoiceSerbianTemplate.PDF.php';
			}
		}

		$html = ob_get_contents();
		ob_end_clean();
		echo $html;	


		//****************
		// PDF GENERATION
		//****************
		
		@unlink(ROOT .$PDFfile);
		
		require_once ROOT ."/mpdf60/mpdf.php";

		$mpdf=new mPDF(); 

		$mpdf->SetDisplayMode('fullpage');


		// LOAD a stylesheet
		$stylesheet = file_get_contents('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css').
					  //file_get_contents('css/theme.css').
					  file_get_contents('css/simplegrid.css');


		$stylesheet .= '
			table {font-family:"Roboto",sans-serif;font-size:10px !important}
			.nav, .footer {display:none}
			button, .btn, .pdfHide {visibility:screenonly !important;display:none !important}	
			.pdf-input {border-color:white !important;background-color:white !important}
		';


		$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

		$mpdf->WriteHTML($html); 

		$content = $mpdf->Output('', 'S');

		$content = chunk_split(base64_encode($content));
	
		$mpdf->Output(ROOT .$PDFfile);	

	} 
	else {
		
		// Prikazi inicijalni racun - bez broja
		if($u->CountryName != 'Serbia') {
			require_once ROOT . '/cms/p/modules/reports/admin/invoiceForeignTemplate.PDF.php';
		}
		else {
			require_once ROOT . '/cms/p/modules/reports/admin/invoiceSerbianTemplate.PDF.php';
		}
				
	}// endif Save



} else {


?>

<div class="container">
	<h1><?= TEST ?></h1><br>
	<form action="index.php?p=invoiceSumAgent" method="post">

		<div class="row">
			<div class="col-md-2">
				<label>Start Date</label>
			</div>
			<div class="col-md-4">
				<input type="text" name="s" class="xform-control datepicker">
			</div>
		</div>


		<div class="row">
			<div class="col-md-2">
				<label>End Date</label>
			</div>
			<div class="col-md-4">
				<input type="text" name="e" class="xform-control datepicker">
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
				<label>Agent</label>
			</div>
			<div class="col-md-4">
				<select name="d" class="form-control">
					<option value="0"> --- </option>
		
					<?
					require_once ROOT . '/db/v4_AuthUsers.class.php';

					# init class
					$au = new v4_AuthUsers();

					$auk = $au->getKeysBy('Country', 'asc', "WHERE AuthLevelID = 2");

					foreach($auk as $n => $ID) {
	
						$au->getRow($ID);
						echo '<option value="'.$au->getAuthUserID() .'">'.
						        $au->getAuthUserCompany().
						     '</option>';

					}
		
					?>				
				</select>
			</div>
		</div>


		<div class="row">
			<div class="col-md-4 offset-l2">
				<br>
				<button class="btn btn-primary" type="submit" name="Submit" value="1">Go</button>
			</div>
		</div>
	</form>
</div>
      
<?}

	function InSerbia($RouteID) {

		if($RouteID > 0) {

			require_once ROOT.'/db/db.class.php';
			$db = new DataBaseMysql();
	
			$q2 = "SELECT * FROM v4_Routes WHERE RouteID = '{$RouteID}'";
			$w2 = $db->RunQuery($q2);
		
			$r = $w2->fetch_object();
		
			$q3 = " SELECT * FROM v4_Places 
					WHERE PlaceID = '{$r->FromID}' 
					OR PlaceID = '{$r->ToID}' 
					AND PlaceCountry = '181'";
			$w3 = $db->RunQuery($q3);

			while ($p = $w3->fetch_object() ) {

				if ($p->PlaceCountry == '181') {
					return true; // u Srbiji je
				}
				
			}
			
			return false; // nije u Srbiji
			
		} else return false; // RouteID je nula, pretpostavka je da nije u Srbiji
	}

	function date_change_format ($date) {
		$date_arr=explode('.',$date);
		if (count($date_arr)>1) $new_date=$date_arr[2]."-".	$date_arr[1]."-". $date_arr[0];
		else $new_date=$date;
		return $new_date;	
	}	