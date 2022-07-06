<?
//header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(0);
@session_start();

$SAuthUserID = $_SESSION['AuthUserID'];

# init libs
require_once ROOT . '/f/f.php';

require_once '../../db/db.class.php';
require_once '../../db/v4_AuthUsers.class.php';
require_once '../../db/v4_OrdersMaster.class.php';
require_once '../../db/v4_OrderDetails.class.php';
require_once '../../db/v4_Places.class.php';
require_once '../../db/v4_OrderDocument.class.php';
require_once '../lng/en_text.php';

// ukljuci mail funkcije
require_once 'informFuncs.php';

# init class
$au = new v4_AuthUsers();
$pl = new v4_Places();
$od = new v4_OrderDetails();
$om = new v4_OrdersMaster();
$odk = new v4_OrderDocument();

$odk->setDocumentType($_REQUEST['DocumentType']);
$odk->setOrderID($_REQUEST['OrderID']);
if ($_REQUEST['OneWay']=='true') $odk->setDetailsID($_REQUEST['DetailsID']);
//$odk->setUserID();
//$odk->setIcon();
//$odk->setAction();
$odk->setDocumentCode($_REQUEST['DocumentCode']);

//$odk->setDescription();
$odk->setDocumentDate($_REQUEST['DocumentDate']);
$odk->setIssueDate(date("Y-m-d"));

$odk->saveAsNew();


	$br="<br>";
	
	
	$DocumentType = array(
		'1' => 'Predračun',
		'2'	=> 'Avansni račun',
		'3' => 'Račun',
		'4' => 'Stavka računa',
		'5' => 'Storno račun',
		'6' => 'Knjižno odobrenje'
	);

	$DocumentTypeEN = array(
		'1' => 'Proforma',
		'2'	=> 'Prepayment Invoice',
		'3' => 'Invoice',
		'4' => 'Invoice Item',
		'5' => 'Cancellation Invoice',
		'6' => 'Credit Note'
	);
	
	$ServiceType = array(
		'1' => 'Usluga prevoza putnika',
		'2'	=> 'Usluga posredovanja - nalaženja putnika',
		'3' => 'Usluga posredovanja - nalaženja prevoznika'
	);	
	
	$ServiceTypeEN = array(
		'1' => 'Commision fee - transport',
		'2'	=> 'Commision fee - finding passengers',
		'3' => 'Commision fee - finding a carrier'
	);	
	
		$PDFfile = 	'/cms/pdfdocument/'.$_REQUEST['DocumentCode'].'-'.$_REQUEST['OrderID'].'.pdf';
		$odtk = $od->getKeysBy('TNo', 'asc' , ' WHERE OrderID='. $_REQUEST['OrderID']);
		$od->getRow($odtk[0]);
		// transfer area
		$pl->getRow($od->PickupID);
		$country1=$pl->CountryNameEN;
		$pl->getRow($od->DropID);
		$country2=$pl->CountryNameEN;
		if ($country1=='Serbia'	&& $country2=='Serbia') $TransferArea=1;//"Srbija"
		if ($country1!='Serbia'	&& $country2!='Serbia') $TransferArea=2;//"Van Srbije"		
		
		$omk = $om->getKeysBy('MOrderID', 'asc' , ' WHERE MOrderID='. $_REQUEST['OrderID']);
		$om->getRow($omk[0]);
	
		$au->getRow($om->getMUserID());
		switch ($om->MPaymentMethod) {
			case 1:
			case 4:
			case 5:
			case 6:
				$service=1;//"Usluga prevoza"
				break;
			case 2:
				$service=2;	//"Usluga nalaženja putnika"
				break;
			case 3:
				$service=3;//"Usluga nalaženja prevoznika"
				break;	
		}
		
		$PaymentMethod=$om->MPaymentMethod;

		// Document recepient
		if ($service==2) $rid=$od->DriverID;
		else  $rid=$od->UserID;
		$au->getRow($rid);
		// blok za podatke primaoca racuna
		
		
		
		// Type of document recipient
		$arrayX=array(2,5,6,31);
		if (in_array($au->AuthLevelID,$arrayX)) $TypeDocumentRecepient=1; //"Pravno lice"
		else $TypeDocumentRecepient=2; //"Fizičko lice"
		
		// Origin of document recipient	
		if ($au->CountryName=="Serbia") $OriginDocumentRecepient=1;//"Domaće"
		else $OriginDocumentRecepient=2;//"Strano"
		
		// document type
		$dt=$_REQUEST['DocumentType'];
		if ($OriginDocumentRecepient==1) $documentType=$DocumentType[$dt];
		else $documentType=$DocumentTypeEN[$dt];

		// service Name
		if ($OriginDocumentRecepient==1) $serviceType=$ServiceType[$service];
		else $serviceType=$ServiceTypeEN[$service];
		
		// vat document status
		if ($TransferArea==1) $VatDocumentStatus=1; //"Uključen PDV";	???
		else $VatDocumentStatus=2;//"Oslobođen PDV-a";
		// document currency
		//service type
		switch ($od->PaymentMethod) {
			case 1:
			case 3:
				$DocumentCurrency="RSD";			
				break;
			case 2:
			case 4:
			case 5:
			case 6:
				if ($OriginDocumentRecepient==1) $DocumentCurrency="RSD";
				else $DocumentCurrency="EUR";
				break;
		}	
		
		$exchangerate=1;
		if ($OriginDocumentRecepient==1) {
			$filename = ROOT . '/cms/exchangeRate.inc';
			$exchangerate=file_get_contents($filename);
		}
		if ($PaymentMethod==1 || $PaymentMethod==3) $exchangerate=$om->MEurToCurrencyRate;
		// blokovi racuna
		
		// blok1 - JAMTRANSFER PODACI
		if ($OriginDocumentRecepient==1) {
			$blok1="Jam Transfer d.o.o".$br;
			$blok1.="Vladislava Bajčevića 17".$br;
			$blok1.="11000 Beograd, Srbija".$br;
			$blok1.="PIB: 108576323";
		}
		else {
			$blok1="Jam Transfer d.o.o".$br;
			$blok1.="17 Vladislava Bajčevića st.".$br;
			$blok1.="11000 Belgrade, Serbia".$br;
			$blok1.="Tax ID: 108576323";
		}
		
		// blok 2 - Datum u zaglavlju
		if ($OriginDocumentRecepient==1) {
			$blok2="<small>";
			$blok2.="Datum:";
			$blok2.="<span class='IssuedDate'>";
			$blok2.=date("d.m.Y"); 
			$blok2.="</span></small>";
		}
		else {
			$blok2="<small>";
			$blok2.="Date:";
			$blok2.="<span class='IssuedDate'>";
			$blok2.=date("Y-m-d"); 
			$blok2.="</span></small>";
		}		

		// blok 3 - Primalac dokumenta
		if ($TypeDocumentRecepient==1) {
			$blok3="<strong>".$au->AuthUserCompany."</strong>".$br;
			$blok3.=$au->AuthCoAddress.$br;
			if ($OriginDocumentRecepient==1) {	
				$blok3.=$au->Zip." ".$au->City.$br;
				$blok3.="Srbija".$br;
				$blok3.="PIB: ".$au->AuthUserCompanyMB.$br;
			}	
			else {	
				$blok3.=$au->Zip." ".$au->City.$br;
				$blok3.=$au->CountryName.$br;
				$blok3.="Tax ID: ".$au->AuthUserCompanyMB.$br;		
			}
			$blok3.=$au->AuthUserTel.$br;
			$blok3.=$au->AuthUserMail;
		}
		else $blok3="<p>&nbsp;</p>";	

		// blok 4 - Broj i datum dokumenta
		if ($OriginDocumentRecepient==1) {	
			$old_date_timestamp = strtotime($_REQUEST['DocumentDate']);
			$new_date = date('d.m.Y', $old_date_timestamp);  
			$blok4="<strong><h3>".$DocumentType[$dt].": ".$_REQUEST['DocumentCode']."</strong></h3>".$br;
			$blok4.="<strong>Datumi mesto prometa:</strong>".$br;
			$blok4.="<strong>".$new_date.", Beograd </strong>";
		}
		else {
			$blok4="<strong><h3>".$DocumentTypeEN[$dt].": ".$_REQUEST['DocumentCode']."</strong></h3>".$br;
			$blok4.="<strong>Delivery date:</strong>".$_REQUEST['DocumentDate'].$br;
			//$blok4.="<strong>Due date:</strong> <span class='DueDate'>Datum placanja</span>";			
		}	

		// blok instrukcija za placanje
		
		if ($OriginDocumentRecepient==1) {
			$blok5="<th class='pad4px'>Rbr.</th>";
			$blok5.="<th class='pad4px'>Vrsta usluge/Narudžbina/Ruta<br><span class='s'>Putnik/Datum/Vreme</span></th>";
			$blok5.="<th class='pad4px'>Kol.</th>";
			$blok5.="<th class='pad4px'>Jed.vred.</th>";
			if ($service<>2) $blok5.="<th class='pad4px'>Popust.</th>";
			$blok5.="<th class='pad4px'>Vrednost</th>";
		}
		else {
			$blok5="<th class='pad4px'>No.</th>";
			$blok5.="<th class='pad4px'>Service type/Order/Route<br><span class='s'>Pax Info/Date/Time</span></th>";
			$blok5.="<th class='pad4px'>Qty</th>";
			$blok5.="<th class='pad4px'>Unit price</th>";
			if ($service<>2) $blok5.="<th class='pad4px'>Discount.</th>";						
			$blok5.="<th class='pad4px'>Subtotal</th>";		
		}	
		
		$odtk = $od->getKeysBy('TNo', 'asc' , ' WHERE OrderID='. $_REQUEST['OrderID']);
		$rbr=0;
		if ($OriginDocumentRecepient==1) {	
			$old_pdate_timestamp = strtotime($od->PickupDate);
			$new_pdate = date('d.m.Y', $old_pdate_timestamp);  
		}
		else $new_pdate = $od->PickupDate; 

		$blok6="";
		foreach ($odtk as $odtr) {
			$od->getRow($odtr);
			$rbr++;
			$description = '
			<strong>'.
			$serviceType.'
			<br>'. 
			$od->getOrderID().'-'. $od->getTNo() .
			'</strong><em> '. 
			$od->PickupName . ' - ' . $od->DropName . 
			'</em><br><span class="s">'.
			$od->PaxName .','. $od->PaxNo .
			' pax. | '.
			$new_pdate .' '. $od->PickupTime .
			'</span>';

			// kalkulacije za kraj
			// vrednost slue
			if ($service==1) $price = $od->getDetailPrice(); // puna cena
			else $price = $od->getDetailPrice()-$od->getDriversPrice(); // provizija za JAM
			
			$provision = $od->getProvisionAmount(); // provizija agenta ili klijenta

			if ($service<>2) $priceT=$price-$provision; // redukovana cena za proviziju kod pune usluge i usluge nalazenja vozaca
			else $priceT=$price;
			
			if ($service==1) $extrasPrice 	= $od->getExtraCharge(); // puna cena ekstrasa
			else $extrasPrice 	= $od->getExtraCharge()-$od->getDriverExtraCharge(); // provizija ekstrasa za JAM
			
			$provisionSum	+= $provisionSum+$provision ; //totaliranje provizije
			$priceSum	+= $priceT+$extrasPrice ; //totaliranje cene 
			// valute - konvertovanje u valutu 
			$provisionSumVal=$provisionSum*$exchangerate;
			$priceSumVal=$priceSum*$exchangerate;
			

			// razlicite baze za obracun poreza
			if ($service==1) $noVAT += nf(($priceSum - $od->getDriversPrice()-$od->getDriverExtraCharge())*$exchangerate); //????
			if ($service<>1) $noVAT += nf($priceSum); 
			
			// poreska osnoivica i obracunat porez
			if ($VatDocumentStatus==1) {
				$VATbase += nf($noVAT/ 1.20);
				$VATtotal += nf( $VATbase * 20 / 100);
			}	
			else {
				$VATbase +=0;
				$VATtotal +=0;
			}
			
			// Ukupno za uplatu
			$GrandTotal+=$priceSumVal+$VATtotal;
			
			
			// kraj kalkulacija
			
			//blok stavka racuna
			$blok6.="<tr>";
			$blok6.="<td class='pad4px'>".$rbr."</td>";
			$blok6.="<td class='pad4px'>".$description."</td>";
			$blok6.="<td class='pad4px'>1</td>";
			$blok6.="<td style='min-width:6em !important;text-align:right' class='pad4px'>".nf($price)."</td>";
			if ($service<>2) $blok6.="<td style='min-width:6em !important;text-align:right' class='pad4px'>".nf($provision)."</td>";			
			$blok6.="<td style='min-width:6em !important;text-align:right' class='pad4px'>".nf($priceT)."</td>";				
			$blok6.="</tr>";
			
			if($extrasPrice > 0.00) { 
				$blok6.="<tr>";
				$blok6.="<td class='pad4px'></td>";
				$blok6.="<td class='pad4px'>Extra services</td>";
				$blok6.="<td class='pad4px'></td>";
				$blok6.="<td style='min-width:6em !important;text-align:right' class='pad4px'></td>";
				if ($service<>2) $blok6.="<td style='min-width:6em !important;text-align:right' class='pad4px'></td>";			
				$blok6.="<td style='min-width:6em !important;text-align:right' class='pad4px'>".nf($extrasPrice)."</td>";				
				$blok6.="</tr>";
			} 
		}	
		$om->getRow($omk[0]);
			
		//blok sume u EUR
		$blok7="<td class='pad4px'></td>";
		if ($OriginDocumentRecepient==1) $blok7.="<td  class='ucase pad4px' style='text-align:right'>Ukupna vrednost</td>";
		else $blok7.="<td  class='ucase pad4px' style='text-align:right'>Total</td>";
		$blok7.="<td></td><td></td>"; 
		if ($service<>2) $blok7.="<td style='min-width:6em !important;text-align:right' class='pad4px'>".nf($provisionSum)."</td>";
		$blok7.="<td style='min-width:6em !important;text-align:right' class='pad4px'>".nf($priceSum)."</td>";

		//blok sume u RSD 
		if ($PaymentMethod==1 || $PaymentMethod==1 || $OriginDocumentRecepient==1) { //online placanje, uvek  u RSD ili je primalac u zemlji
			$blok8="<tr><td class='pad4px'></td>";
			if ($OriginDocumentRecepient==1) $blok8.="<td  class='ucase pad4px' style='text-align:right'>Ukupna vrednost u RSD</td>";
			else $blok8.="<td  class='ucase pad4px' style='text-align:right'>Total-RSD</td>";
			$blok8.="<td></td><td></td>";
			if ($service<>2) $blok8.="<td style='min-width:6em !important;text-align:right' class='pad4px'>".nf($provisionSumVal)."</td>";
			$blok8.="<td style='min-width:6em !important;text-align:right' class='pad4px'>".nf($priceSumVal)."</td></tr>";
		}
		else { //devizna placanja
			$blok8="";
		}
		//blok PDV1 izuzece
		if ($VatDocumentStatus==2) {
			$blok9="<tr><td class='pad4px'></td><td class='pad4px'></td><td class='pad4px'></td>";
			if ($OriginDocumentRecepient==2) $blok9.="<td class='ucase pad4px'><small>VAT not app. acc. to Note</small></td>";
			else $blok9.="<td class='ucase pad4px'><small>PDV se ne primenjuje prema Napomeni</small></td>";
			if ($service<>2) $blok9.="<td style='min-width:6em !important;text-align:right' class='pad4px'></td>";			
			$blok9.="<td style='min-width:6em !important;text-align:right' class='pad4px'>".nf($noVAT)."</td></tr>";
		}	
		else $blok9="";
		
		//blok PDV2 osnovica
		$blok10="<td class='pad4px'></td><td class='pad4px'></td><td class='pad4px'></td>";
		if ($OriginDocumentRecepient==2) $blok10.="<td class='ucase pad4px'><small>VAT base</small></td>";
		else $blok10.="<td class='ucase pad4px'><small>Poreska osnovica</small></td>";
		if ($service<>2) $blok10.="<td style='min-width:6em !important;text-align:right' class='pad4px'></td>";									
		$blok10.="<td style='min-width:6em !important;text-align:right' class='pad4px'>".nf($VATbase)."</td>";
		
		//blok PDV3 vrednost
		$blok11="<td class='pad4px'></td><td class='pad4px'></td><td class='pad4px'></td>";
		if ($OriginDocumentRecepient==2) $blok11.="<td class='ucase pad4px'><small>20% VAT total</small></td>";
		else $blok11.="<td class='ucase pad4px'><small>Opšta stopa PDV-a 20%</small></td>";
		if ($service<>2) $blok11.="<td style='min-width:6em !important;text-align:right' class='pad4px'></td>";									
		$blok11.="<td style='min-width:6em !important;text-align:right' class='pad4px'>".nf($VATtotal)."</td>";

		//blok vrednost za uplatu
		$blok12="<td class='pad4px'></td><td class='pad4px'></td><td class='pad4px'></td>";
		if ($OriginDocumentRecepient==2) $blok12.="<td class='ucase pad4px'><small>Grand total</small></td>";
		else $blok12.="<td class='ucase pad4px'><small>Svega po računu </small></td>";
		if ($service<>2) $blok12.="<td style='min-width:6em !important;text-align:right' class='pad4px'></td>";									
		$blok12.="<td style='min-width:6em !important;text-align:right' class='pad4px'>".nf($GrandTotal)."</td>";

		//blok levi
		if ($OriginDocumentRecepient==2) {
			$blok13="<td class='pad1em'>
				<p>
					<small><em>
						Note: The total amount is calculated without VAT,<br> 
						in accordance with the Law on Value Added Tax, Article 12, Paragraph 6
					</em></small>
				</p>
				<br>
				If You have any question regarding this Invoice, please contact: <br>
				<br><em>
				Name:".$_SESSION['UserRealName']."<br>
				E-mail: finance@jamtransfer.com<br>
				Phone/Fax: 00 381 11 364 02 15<br>
				</em>
				<br>
				Issued: <span class='IssuedDate'>".$_REQUEST['DocumentDate']."
				</span>, Belgrade<br>
				Document issued by: ".$_SESSION['UserRealName']."
				<br>
				This Document is valid without signature or stamp.
			</td>";
		}
		else {
			$blok13="<td class='pad1em'>
				<p>
					<small><em>
						Napomena: PDV nije obračunat na osnovu Člana 12, <br>
						stav 6 Zakona o porezu na dodatu vrednost
					</em></small>
				</p>
				<br>
				Ako imate bilo kakvih pitanja u vezi sa ovim dokumentom, molimo kontaktirajte: <br>
				<br><em>
				Ime:".$_SESSION['UserRealName']."<br>
				E-mail: finance@jamtransfer.com<br>
				Tel/Fax: 011 364 02 15<br>
				</em>
				<br>
				Datum i mesto izdavanja: <span class='IssuedDate'>".$_REQUEST['DocumentDate']."
				</span>, Beograd<br>
				Dokument izdao/la: ".$_SESSION['UserRealName']."
				<br>
				Ovaj dokument je punovažan bez pečata i potpisa.
			</td>";

		}
		// blok instrukcija za placanje
		
		if ($PaymentMethod==1 || $PaymentMethod==3) {
			if ($OriginDocumentRecepient==2) {
				$blok14="<td class='pad1em'>
				<p class='lead'>Payment was made by Credit card</p></td>";
			}
			else {
				$blok14="<td class='pad1em'>
				<p class='lead'>Uplata je obavljena Kreditnom karticom</p></td>";
			}
		}
		else if ($dt==2) {
			if ($OriginDocumentRecepient==2) {
				$blok14="<td class='pad1em'>
				<p class='lead'>Payment was made by Proforma</p></td>";
			}
			else {
				$blok14="<td class='pad1em'>
				<p class='lead'>Uplata je obavljena predračunom</p></td>";
			}
		}
		else if ($dt>3) {
			$blok14="";
		}
		else {
			if ($OriginDocumentRecepient==2) {
				$blok14="<td class='pad1em'>
					<p class='lead'>INSTRUCTIONS FOR EUR PAYMENT:</p>
					
					<p class='rs'>
						<strong>Company:</strong>  Jam Transfer d.o.o. 
						<br>
						<strong>Address:</strong> 17 Vladislava Bajčevića st., Belgrade 11030, 
						Republic of Serbia<br>
						<br>
						<strong>Bank:</strong> Banca Intesa ad<br>
						<strong>IBAN: </strong>RS35160005390001506944<br>
						<strong>SWIFT: </strong>DBDBRSBG
						<br><br>
						You are required to fully cover the bank transaction fees.<br>
						Please, use the option (payment instruction) OUR
						<br>
						Payment is due within the 15 days<br>
					</p>
				</td>";
			}
			else {
				$blok14="<td class='pad1em'>
					<p class='lead'>Uputstvo za uplatu:</p>
					
					<p class='rs'>
						<br>
						<strong>Banka:</strong> Banca Intesa ad<br>
						<strong>Tekući račun: </strong>160-413379-84<br>
						<strong>Poziv na broj: </strong>kalkulisati
						<br><br>
						Na iskazanu cenu u EUR-ima, se primenjuje valutna klauzula <br>
						(uplata u dinarskoj protivvrednosti prema <br>
						zvaničnom srednjem kursu NBS na dan izdavanja računa)<br> 
						<br>
						Rok za uplatu je 8 dana<br>
					</p>
				</td>";
			}
		}
		
		ob_start();

		
		
		?>
				<table style="width:100%">
					<!-- Content Header (Page header) -->
					<!-- Main content -->
						<!-- title row -->
						<tr>
							<td style="border-bottom:1px #eee solid;padding-bottom:1em !important">
								<h3 style="text-transform:none !important"><?= Logo() ?></h3>
							</td>
							<td style="border-bottom:1px #eee solid;padding-bottom:1em !important"></td>
							<td style="text-align:right;border-bottom:1px #eee solid;padding-bottom:1em !important"><?= $blok2 ?></td>
							<!-- /.col -->
						</tr>
						<!-- info row -->
						<tr>
							<td class="pad4px" style="vertical-align:top" width="33%"><?= $blok1 ?></td>
							<!-- /.col -->
							<td class="pad4px"  style="vertical-align:top"><?= $blok3 ?></td>
							<!-- /.col -->
							<td class="pad4px"  style="vertical-align:top" width="33%"><?= $blok4 ?> </td>
							<!-- /.col -->
						</tr>
					  <!-- /.row -->
					  <!-- Table row -->
					 	<tr>
							<td colspan="3">
								<table class="table table-bordered" width="100%">
									<thead>
										<tr>
											<?= $blok5 ?>
										</tr>
									</thead>
									<tbody>
										<?= $blok6 ?>
										<tr><td colspan="5" class="pad4px"><br><br></td></tr>
										<tr><?= $blok7 ?></tr>
										<?= $blok8 ?>
										<?= $blok9 ?>
										<tr><?= $blok10 ?></tr>
										<tr><?= $blok11 ?></tr>
										<tr><?= $blok12 ?></tr>
									</tbody>
								</table>
							</td>
						</tr>	

					<tr>
						<td colspan="3">
							<table style="width:100%;" >
								<tr>
									<?= $blok13 ?>
									<?= $blok14 ?>
								</tr>

							</table>
						</td>
					</tr>


				</table>		






		<?

		$html = ob_get_contents();
		ob_end_clean();
		//echo $html;	


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

		echo $_REQUEST['DetailsID'];
		
?>		

			


		