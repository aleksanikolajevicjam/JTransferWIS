<?
	$vat=$_SESSION['vat'];
	require_once ROOT . '/db/v4_OrderDetails.class.php';
	require_once ROOT . '/db/v4_Invoices.class.php';
	require_once ROOT . '/db/v4_InvoiceDetails.class.php';
	
	$od = new v4_OrderDetails();
	$in = new v4_Invoices();
	$id = new v4_InvoiceDetails();

if(isset($_REQUEST['Submit']) and $_REQUEST['Submit'] == '1') {
	
	//$details = array();
	
	$d	 	= $_REQUEST['d']; // DriverID
	$start 	= $_REQUEST['s']; // start date
	$end	= $_REQUEST['e']; // end date
	$si	    = $_REQUEST['si']; // sistem
	$ct	    = $_REQUEST['ct']; // realizirani transferi

	$taxPercent = 0;
	$taxAmt 	= 0;
	
	$Date = date("Y-m-d"); // invoice date - default danas
	$dueDate = date('Y-m-d', strtotime($Date. ' + 15 days')); // za strane racune rok placanja 15 dana
	
	// ako je InvoiceDate ispunjen u prvom koraku
	if(isset($_REQUEST['DriverInvoiceDate'])) {
		$dueDate = date('Y-m-d', strtotime($_REQUEST['DriverInvoiceDate']. ' + 15 days'));
	}
	
	$sum = 0;
	$transferIDs = '';
	$transfersCount = 0;
		
	//$whereD  = " WHERE DriverID ='" . $d ."' ";
	if (getConnectedUser($d)>0) $whereD = " WHERE (DriverID = '" . $d. "'  OR DriverID =  '".getConnectedUser($d). "') "; 
	else $whereD  = " WHERE DriverID ='" . $d ."' ";
	
	$whereD .= " AND PickupDate >= '{$start}' AND PickupDate <= '{$end}' ";
	$whereD .= " AND TransferStatus != 3 ";
	$whereD .= " AND TransferStatus != 4 ";
	$whereD .= " AND TransferStatus != 9 ";
	$whereD .= " AND DriverConfStatus != 5 ";//no-show
	//$whereD .= " AND DriverConfStatus != 6 ";//driver error
	//$whereD .= " AND PayLater != 0 ";	
	$whereD .= " AND PayLater > DriversPrice ";	
	
	$kd = $od->getKeysBy('DetailsID', 'asc', $whereD);
 
	 // User Object
	$u = getUser($d);
	
	
	
	if( isset($_REQUEST['Save']) and 
		$_REQUEST['Save'] == '1' and 
		isset($_REQUEST['DriverInvoiceNumber']) and 
		!empty($_REQUEST['DriverInvoiceNumber']) ) {

		
		// Provjera postoji li vec racun sa ovim brojem
		$inKey = $in->getKeysBy('ID', 'ASC', " WHERE InvoiceNumber='" . 
									$_REQUEST['DriverInvoiceNumber'] . "'");
		
		if(count($inKey) > 0) {
			$in->getRow($inKey[0]);
			if( $in->getInvoiceNumber() == $_REQUEST['DriverInvoiceNumber'] ) {
				$invoiceExists = true;
			}
		}
		
		
		// upis podataka u v4_OrderDetails i v4_Invoices
		if(!$invoiceExists) {
			
			foreach($_SESSION['detailsID'] as $nn => $DetailsID) {
				$od->getRow($DetailsID);
			
				$od->setDriverInvoiceNumber( $_REQUEST['DriverInvoiceNumber'] );
				$od->setDriverInvoiceDate( $_REQUEST['DriverInvoiceDate'] );
				
				$od->saveRow();
				

			}

			//$id->setDetailsID($DetailsID);
			$id->setInvoiceNumber( $_REQUEST['DriverInvoiceNumber'] );
			$id->setDescription( $_REQUEST['Description'] );
			$id->setQty( $_REQUEST['Qty'] );
			$id->setPrice( $_REQUEST['Price'] );
			$id->setSubTotal( $_REQUEST['SubTotal'] );
			$id->setDescription( $_REQUEST['Description'] );
			$id->setChanged( date("Y-m-d H:i:s") );
			
			$id->saveAsNew();
		
			$in->setType( '2' ); // za Drivere
			$in->setInvoiceNumber( $_REQUEST['DriverInvoiceNumber'] );
			$in->setInvoiceDate($_REQUEST['DriverInvoiceDate']);
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
			}		
		
		} else {
			$saved = true;
			$_SESSION['detailsID'] = array();
		} // endif invoiceExists
	}	
		
		
		$replaceChars = array('/','\\');
		$PDFfile = 	'/cms/pdf/RD_'. str_replace($replaceChars,'-',$_REQUEST['DriverInvoiceNumber']).'.pdf';
		
		ob_start();
 ?>
 

		 <!-- Content Wrapper. Contains page content -->
		<div class="container pad1em white">

		<form action="index.php" method="post">
			<input type="hidden" name="p" value="invoiceSum">
			<input type="hidden" name="d" value="<?= $_REQUEST['d'] ?>">
			<input type="hidden" name="s" value="<?= $_REQUEST['s'] ?>">
			<input type="hidden" name="e" value="<?= $_REQUEST['e'] ?>">
			<input type="hidden" name="Submit" value="<?= $_REQUEST['Submit'] ?>">
			<input type="hidden" name="Save" value="<?= $_REQUEST['Save'] ?>">
			<input type="hidden" name="DriverInvoiceNumber" value="<?= $_REQUEST['DriverInvoiceNumber'] ?>">
			<input type="hidden" name="DriverInvoiceDate" value="<?= $_REQUEST['DriverInvoiceDate'] ?>">
			<input type="hidden" name="GrandTotal" value="<?= $_REQUEST['GrandTotal'] ?>">

			<table style="width:100%">
					<tr>
						<td style="border-bottom:1px #eee solid;padding-bottom:1em !important">
							<h2 style="text-transform:none !important">
								<?= Logo() ?>
							</h2>
						</td>
						<td style="border-bottom:1px #eee solid;padding-bottom:1em !important"></td>
						<td style="text-align:right;border-bottom:1px #eee solid;padding-bottom:1em !important">
								<small>Date: <span class="IssuedDate">
									<? 	if(!$saved) echo date("d.m.Y");
									else echo $_REQUEST['DriverInvoiceDate'];
									?>
								</span></small>
						</td>
						<!-- /.col -->
					</tr>
					<!-- info row -->
					<tr>
						<td class="pad4px" style="vertical-align:top" width="33%">
							<br>From: <br>

								<?= s('co_name') ?><br>
								<?= s('co_address') ?><br>
								<?= s('co_zip') ?> <?= s('co_city') ?><br>
								<?= s('co_country') ?><br>
								Tax ID: 108576323
								<!--Phone: <?= s('co_tel') ?><br>
								Email: <?= s('co_email') ?>-->

						</td>
			
						<!-- /.col -->
						<td class="pad4px"  style="vertical-align:top">
							<br>To:<br>

								<strong><?= $u->AuthUserCompany ?></strong><br>
								<?= $u->AuthCoAddress ?><br>
								<?= $u->Zip ?> <?= $u->City ?><br>
								<?= $u->CountryName ?><br>
								Tax ID: <?= $u->AuthUserCompanyMB ?><br>
								<!--Phone: <?= $u->AuthUserTel ?><br>
								Email: <?= $u->AuthUserMail ?><br>-->
								<br><br>

						</td>
						<!-- /.col -->
						<td class="pad4px"  style="vertical-align:top" width="33%">
							<br>
							<strong>

								<? if(!$saved) { ?>
									Invoice #:					
									<input type="text" name="DriverInvoiceNumber" 
									value="<?= $_REQUEST['DriverInvoiceNumber'] ?>">
								<? } else { ?>
									<h3>
									Invoice #:
									<?= $_REQUEST['DriverInvoiceNumber'] ?>
									</h3>
								<? } ?>
							</strong>
							<br>
							<br>
							<strong>Delivery date:</strong> 

							<? if(!$saved) { ?>
								<input type="text" value="<?= $Date ?>" name="DriverInvoiceDate"
								 id="InvoiceDate" 
								class="jqdatepicker no-print" 
								onchange="
									$('.DueDate').html(addDays(this.value,15));
									$('#DueDate').val(addDays(this.value,15));
									$('.IssuedDate').html(this.value);
								">
							<? } 
							else echo $_REQUEST['DriverInvoiceDate'] ; ?>
							<br>
							<strong>Due date:</strong> <span class="DueDate"><?= $dueDate ?></span><br>
							<input type="hidden" name="DueDate" id="DueDate" value="<?=$dueDate?>">

						</td>
						<!-- /.col -->
					</tr>
				  <!-- /.row -->

				  <!-- Table row -->
					<tr>
						<td colspan="3">
							<table class="table table-bordered" width="100%">
								<thead>
									<tr>
										<th class="pad4px">No.</th>
										<th class="pad4px">
											Description of work
										</th>
										<th class="pad4px">Qty</th>
										<th class="pad4px">Unit price</th>
										<th class="pad4px">Subtotal</th>
									</tr>
								</thead>
								<tbody>
						<?
						$countries = array();
						$transfersInSerbia = 0;
												
						foreach($kd as $nn => $id) {
							$od->getRow($id);
							
							$isInSerbia = InSerbia($od->RouteID);			
							if($isInSerbia) $transfersInSerbia += 1;
							// da znamo sto treba azurirati u invoiceCumulativeAgent
							$_SESSION['detailsID'][] = $od->getDetailsID();
				
							$driversPriceSum += $od->getDriversPrice();
		
							$transferPrice 	= $od->getDetailPrice()+$od->getExtraCharge();
							$cash 			= $od->getPayLater();
							$driverExtraCharge = $od->getDriverExtraCharge();
		
							$transfersSum	+= $transferPrice;
							$cashTotal		+= $cash;
							$driverExtraChargeTotal += $driverExtraCharge;
							
							$paidOnline += $od->getPayNow();

							$transfersCount += 1;
							
							$pickupCountry 	= getPlaceCountry ($od->getPickupID());
							$dropCountry 	= getPlaceCountry ($od->getDropID());
							
							if(!in_array($pickupCountry, $countries ) and $pickupCountry > 0) {
								$countries[] = $pickupCountry; 
							}
							if(!in_array($dropCountry, $countries )  and $dropCountry > 0) {
								$countries[] = $dropCountry; 
							}
//echo '<br>Transfer price: '.$transferPrice . ' ID:' . $od->getOrderID();
						} //endforeach	
				
						$sum = $cashTotal - $driversPriceSum - $driverExtraChargeTotal;
						//$sum = $transfersSum - $driversPriceSum - $paidOnline;
						$VATtotal = '0.00';				
				
						?>
								<tr>
									<td class="pad4px">1.</td>
									<td class="pad4px">
										<? 
										if(!$saved) {
										
										    $description = "
										    Commission fee for ".$transfersCount." transfers realized from ". formatDate($start, 'd. M Y')." - ". formatDate($end, 'd. M Y') .	" in: ";

										    $cList = '';
										    foreach($countries as $nn => $country) {
											    $cList .= getCountryName($country) . '+';
										    }
										
										    $cList = substr( str_replace('++','+',$cList), 0, -1) ;
										    if($cList == '') $cList = $u->CountryName;
										
										    $description .= $cList;
											$description .= ' / ';
											$description .= $u->Terminal;
										    $description .= " (according to specification) 
										    "; 
										    ?>
										<textarea class="form-control" name="Description" rows="5" 
										style="border:none !important"><?= trim(strip_tags($description)) ?> </textarea>										    
										    <?

										} else {
										    echo $_REQUEST['Description'];
										}
										
										?>
										<?//= $description ?>
										<input type="hidden" name="Description" value="<?= $description?>">


									</td>
									
									<td class="pad4px">
										1
										<input type="hidden" name="Qty" value="1">
									</td>
									<td style="min-width:6em !important;text-align:right" class="pad4px">
										<?= nf($sum) ?>
										<input type="hidden" name="Price" value="<?= nf($sum) ?>">
									</td>
									<td style="min-width:6em !important;text-align:right" class="pad4px">
										<?= nf($sum) ?>
										<input type="hidden" name="SubTotal" value="<?= nf($sum) ?>">
									</td>
								</tr> 
					
								<tr><td colspan="5" class="pad4px"><br><br></td></tr>
								<tr>
									<td class="pad4px"></td>
									<td></td>
									<td></td>
									<td  class="ucase pad4px" style="text-align:right">RSD</td>
									<td  class="ucase pad4px" style="text-align:right"><strong>EUR</strong></td>
								</tr>
								<tr>
									<td class="pad4px"></td>
									<td  class="ucase pad4px" style="text-align:right">Sum</td>
									<td></td>
									<td style="min-width:6em !important;text-align:right" class="pad4px">
										<?= nf($sum*$_SESSION['TecajRSD']) ?>
										<input type="hidden" name="SumPrice" value="<?= nf($sum) ?>">
									</td>
									<td style="min-width:6em !important;text-align:right" class="pad4px">
										<?= nf($sum) ?>
										<input type="hidden" name="SumSubTotal" value="<?= nf($sum) ?>">
									</td>
								</tr>

								<tr>
									<td class="pad4px"></td>
									<td  class="ucase pad4px" style="text-align:right">Total in EUR</td>
									<td></td>
									<td style="min-width:6em !important;text-align:right" class="pad4px">
										<?= nf($sum*$_SESSION['TecajRSD']) ?>
										<input type="hidden" name="TotalPriceEUR" value="<?= nf($sum) ?>">
									</td>
									<td style="min-width:6em !important;text-align:right" class="pad4px">
										<?= nf($sum) ?>
										<input type="hidden" name="TotalSubTotalEUR" value="<?= nf($sum) ?>">
									</td>
								</tr>					

								<tr>
									<td class="pad4px"></td>
									<td class="ucase pad4px" style="text-align:right"><small>VAT base total</small></td>
									<td class="pad4px"></td>
									<td style="min-width:6em !important;text-align:right" class="pad4px">
										<?= nf($sum*$_SESSION['TecajRSD']) ?>
										<input type="hidden" name="VATBaseTotal" value="<?= nf($sum) ?>">
									</td>									
									<td style="min-width:6em !important;text-align:right" class="pad4px">
										<?= nf($sum) ?>
										<input type="hidden" name="VATBaseTotal" value="<?= nf($sum) ?>">
									</td>
								</tr>	

								<tr>
									<td class="pad4px"></td>
									<td class="ucase pad4px" style="text-align:right"><small><?= $vat ?>% VAT total</small></td>
									<td class="pad4px"></td>
									<td style="min-width:6em !important;text-align:right" class="pad4px">
										<?= nf($VATtotal*$_SESSION['TecajRSD']) ?>
										<input type="hidden" name="VATtotal" value="<?= nf($VATtotal) ?>">
									</td>									
									<td style="min-width:6em !important;text-align:right" class="pad4px">
										<?= nf($VATtotal) ?>
										<input type="hidden" name="VATtotal" value="<?= nf($VATtotal) ?>">
									</td>
								</tr>	

								<tr>
									<td class="pad4px"></td>
									<td class="ucase pad4px" style="text-align:right"><small><strong>Grand total</strong></small></td>
									<td class="pad4px"></td>
									<td style="min-width:6em !important;text-align:right" class="pad4px">
										<?= nf($sum*$_SESSION['TecajRSD']) ?>
										<input type="hidden" name="GrandTotal" value="<?= nf($sum) ?>">
									</td>									
									<td style="min-width:6em !important;text-align:right" class="pad4px">
										<strong><?= nf($sum) ?></strong>
										<input type="hidden" name="GrandTotal" value="<?= nf($sum) ?>">
									</td>
								</tr>	
					
								</tbody>
							</table>
						</td>
					</tr>

					<tr>
						<td colspan="3">
							<table style="width:100%;" >
								<tr>
									<td class="pad1em">

										<p>
											<small><em>
												Note: The total amount is calculated without VAT,<br> 
												in accordance with the Law on Value Added Tax, Article 12,
												 Paragraph 6 
											</em></small>
										</p>
										<br>
										If You have any question regarding this Invoice, please contact: <br>
										<br><em>
										Name: <? echo $_SESSION['UserRealName'];  ?><br>
										E-mail: finance@jamtransfer.com<br>
										Tel/Fax: 00 381 11 364 02 15<br>
										</em>

										<br>
										Issued: <span class="IssuedDate">
											<? 	if(!$saved) echo date("d.m.Y");
												else echo formatDate($_REQUEST['DriverInvoiceDate'], 'd. M Y');
											?>
										</span>, Belgrade<br><br>
										This Invoice is valid without signature or stamp.
									</td>

									<td class="pad1em">
								  		<p class="lead">INSTRUCTIONS FOR EUR PAYMENT:</p>
								
										<p class="rs">
											<strong>Company:</strong>  Jam Transfer d.o.o. 
											<br>
											<strong>Address:</strong> 17 Vladislava Bajčevića st., 11000 Belgrade, 
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
									</td>
								</tr>

								<!-- this row will not appear when printing -->
								<tr>
									<td>
										<div  class="pdfHide">

											<? if($saved) { ?>
											<a href="index.php?p=invoices"
											class="btn btn-default no-print">
											<i class="fa fa-back"></i> Back to invoices</a>
											<? } ?>												
										</div>
									</td>
									<td>
										<div  class="pdfHide">
											<? if(!$saved) { ?>
											<button type="submit" class="btn btn-danger l pull-right"
											name="Save" value="1"><i class="fa fa-save"></i> 1. Save</button>
											<? } ?>
											<? if($saved) { ?>
											<button type="button"
											onclick="saveFile('https://<?= $_SERVER['HTTP_HOST'].$PDFfile ?>');" 
											class="btn xblue xwhite-text l no-print">
											<i class="fa fa-download"></i> 2. Download PDF</button>
											<? } ?>											
										</div>
									</td>

								</tr>
						</table>
					</td>
				</tr>
			</table>

		</form>

		</div>
<?
		$html = ob_get_contents();
		ob_end_clean();
		echo $html;	

	if($saved) {
		//****************
		// PDF GENERATION
		//****************
		
		require_once ROOT ."/mpdf60/mpdf.php";

            $mpdf=new mPDF();

            $mpdf->SetDisplayMode('fullpage');
            
            $mpdf->autoScriptToLang = true;
            $mpdf->baseScript = 1;


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

		// The parameter 1 tells that this is css/style only and no body/html/text
		$mpdf->WriteHTML($stylesheet,1);

		$mpdf->WriteHTML($html); 

		$content = $mpdf->Output('', 'S');

		$content = chunk_split(base64_encode($content));
	
		$mpdf->Output(ROOT .$PDFfile);	
		
	} // endif saved

} else { ?>

<div class="container">
	<h1><?= SUMMARY_INVOICE_DRIVER ?></h1><br>
	<form action="index.php?p=invoiceSum" method="post">


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
				<label>Driver</label>
			</div>
			<div class="col-md-4">
				<select name="d" class="form-control">
					<option value="0"> --- </option>
		
					<?
					require_once ROOT . '/db/v4_AuthUsers.class.php';

					# init class
					$au = new v4_AuthUsers();

					$auk = $au->getKeysBy('Country', 'asc', "WHERE AuthLevelID = 31");

					foreach($auk as $n => $ID) {
	
						$au->getRow($ID);
						echo '<option value="'.$au->getAuthUserID() .'">'.
						        $au->getCountry().'-'.$au->getTerminal().'-'.$au->getAuthUserCompany().
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
	
	
	function formatDate($date, $format) {
		$date = new DateTime($date);
		return $date->format($format);
	}
	
	function date_change_format ($date) {
		$date_arr=explode('.',$date);
		if (count($date_arr)>1) $new_date=$date_arr[2]."-".	$date_arr[1]."-". $date_arr[0];
		else $new_date=$date_arr;
		return $new_date;	
	}	
	
?>

<script>
	$(".jqdatepicker").datepicker({ dateFormat: 'yy-mm-dd' });
</script>
