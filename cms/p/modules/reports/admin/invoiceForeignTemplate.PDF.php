 <? //echo '<pre>'; print_r($_REQUEST); echo '</pre>'; 
  	$vat=$_SESSION['vat'];
 ?>
 <!-- Content Wrapper. Contains page content -->
<div class="container pad1em white">
<div  class="pdfHide well no-print">
	<? 	if($knjigovodstvo != '1') echo 'Agent Invoice<br>';
		else echo 'Knjigovodstvo<br>';
	?>
</div>

<form action="index.php" method="post">
	<input type="hidden" name="p" value="invoiceSumAgent">
	<input type="hidden" name="d" value="<?= $_REQUEST['d'] ?>">
	<input type="hidden" name="s" value="<?= $_REQUEST['s'] ?>">
	<input type="hidden" name="e" value="<?= $_REQUEST['e'] ?>">
	<input type="hidden" name="ns" value="<?= $_REQUEST['ns'] ?>">
	<input type="hidden" name="de" value="<?= $_REQUEST['de'] ?>">
	<input type="hidden" name="si" value="<?= $_REQUEST['si'] ?>">
	<input type="hidden" name="ct" value="<?= $_REQUEST['ct'] ?>">
	<input type="hidden" name="k" value="<?= $_REQUEST['k'] ?>">
	<input type="hidden" name="Submit" value="<?= $_REQUEST['Submit'] ?>">
	<input type="hidden" name="Save" value="<?= $_REQUEST['Save'] ?>">
	<input type="hidden" name="InvoiceNumber" value="<?= $_REQUEST['InvoiceNumber'] ?>">
	<input type="hidden" name="InvoiceDate" value="<?= $_REQUEST['InvoiceDate'] ?>">



	<table style="width:100%">
		<!-- Content Header (Page header) -->
		<!-- Main content -->
			<!-- title row -->
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
							else echo $_REQUEST['InvoiceDate'];
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
						<?= s('co_address') ?>						
						<br>
						<?= s('co_zip') ?> <?= s('co_city') ?><br>
						<?= s('co_country') ?><br>
						Tax ID: <?= s('co_taxno') ?> 
						<!--Phone: <?= s('co_tel') ?><br>
						Email: <?= s('co_email') ?>-->

				</td>
			
				<!-- /.col -->
				<td class="pad4px"  style="vertical-align:top">
					<br>To:<br>

						<? if ($u->AuthUserID==1711 || $u->AuthUserID==1712) $u->AuthUserCompany='WEBY Ltd.'; ?>
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
							Document br: <br>						
							<input type="text" name="InvoiceNumber" value="<?= $_REQUEST['InvoiceNumber'] ?>">
							<input type="checkbox" id="proforma" name="proforma" value="proforma">
							<label for="proforma"> Proforma</label><br>
						<? } else { ?>
							<h3>
							<? 
								if (isset($_REQUEST['proforma']) && $_REQUEST['proforma']=='proforma') {
									echo "Pro forma Invoice #:";
									echo "<input type='hidden' id='proforma' name='proforma' value='proforma'>";									
								}	
								else echo "Invoice #:";
								echo $_REQUEST['InvoiceNumber'] ;
							?>
							</h3>						
						<? } ?>
					</strong>
					<br>
					<br>
					<strong>Delivery date:</strong> 

					<? if(!$saved) { ?>
						<input type="text" value="<?= $Date ?>" name="InvoiceDate" id="InvoiceDate" 
						class="jqdatepicker no-print" 
						onchange="
							$('#DueDate').val(addDays(this.value,15));
							$('.DueDate').html(addDays(this.value,15));
							$('.IssuedDate').html(this.value);
							">
					<? } 
					else echo $_REQUEST['InvoiceDate'] ; ?>
					<br>
					<strong>Due date:</strong> <span class="DueDate"><?= $dueDate ?></span><br>
					<input type="hidden" name="DueDate" id="DueDate" value="<?= $_REQUEST['DueDate'] ?>">

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
									Order/Route<br>
									<span class="s">
										Pax Info/Date/Time
									</span>
								</th>
								<th class="pad4px">Qty</th>
								<th class="pad4px">Unit price</th>
								<th class="pad4px">Subtotal</th>
							</tr>
						</thead>
						<tbody>
				<?						
				$_SESSION['details'] = array();
				$transfersInSerbia = 0;
				$subTotal = 0;
				$commissionAmt = 0;
				$totalEur = 0;
				$VATbase = 0;
				$VATtotal = 0;
				$counter=0;		
				$pagecount=1;	
				foreach($kd as $nn => $id) {
					$counter++;
					if ($pagecount==1) $limit=16;
					else $limit=30;
					if ($counter>$limit) {
						$pagecount++;
						$counter=1;
						?>
							</tbody></table></td></tr>
							<tr>
								<td colspan="3">
									<table class="table table-bordered" width="100%">
										<thead>
											<tr>
												<th class="pad4px">No.</th>
												<th class="pad4px">
													Order/Route<br>
													<span class="s">
														Pax Info/Date/Time
													</span>
												</th>
												<th class="pad4px">Qty</th>
												<th class="pad4px">Unit price</th>
												<th class="pad4px">Subtotal</th>
											</tr>
										</thead>
										<tbody>
						<?
							
					}
					$od->getRow($id);
					$order=$od->getOrderID().'-'. $od->getTNo();
					$incl=true;
					if (isset($_REQUEST[$order]) && $_REQUEST[$order]='NO') { 
						$incl=false;
						?><input type="hidden" name="<?= $od->getOrderID().'-'. $od->getTNo() ?>" value="NO"><?
					}
					if($incl) {					
						$detailsID = $od->getDetailsID();
					
						$driversPrice = $od->getDriversPrice();
						$driversPriceSum += $driversPrice;
			
						$transferPrice 	= $od->getDetailPrice();
						$extrasPrice 	= $od->getExtraCharge();
						$provision		= $od->getProvisionAmount();
			
						$transfersSum	+= $transferPrice;
						$extrasSum		+= $extrasPrice;
						$provisionSum	+= $provision;
			
						$i += 1;
						
						
						$description = '
									<strong>'. 
									$od->getOrderID().'-'. $od->getTNo() .
									'</strong><em>'. 
									$od->PickupName . ' - ' . $od->DropName . 
									'</em><br><span class="s">'.
									$od->PaxName .','. $od->PaxNo .
									' pax. | '.
									$od->PickupDate .' '. $od->PickupTime .
									'</span>';
						

						$_SESSION['details'][$detailsID] = array(
											'InvoiceNumber' => $_REQUEST['InvoiceNumber'],
											'Description' => $description,
											'Qty' => '1',
											'Price' => $transferPrice,
											'SubTotal' => $transferPrice
						);

							$fullPrice = $transferPrice + $extrasPrice;
							$subTotal += $fullPrice;
							
							$isInSerbia = InSerbia($od->RouteID);
							if($isInSerbia == true) $transfersInSerbia += 1;

							$commissionAmt += $provision;

							$totalEur += nfT( $fullPrice -  $provision );

							if(!$isInSerbia) $noVAT += nfT( $fullPrice -  $provision - $driversPrice);

							$driversPriceTotal += nfT($driversPrice);
							
							if($isInSerbia) {
								$VATbase +=  ($fullPrice - $driversPrice - $provision) / ((100+$vat)/100);
								//$VATbaseTemp =  ($fullPrice - $driversPrice - $provision) / ((100+$vat)/100);
								//$VATbase += nfT( $VATbaseTemp );
							}	
							//if($isInSerbia == false) $VATbase = '0.00';
	 
							if($isInSerbia) $VATtotal += $VATbaseTemp * $vat / 100;
							//if($isInSerbia) $VATtotal += nfT( $VATbaseTemp * $vat / 100);
							//if($isInSerbia == false) $VATtotal = '0.00';

						
						?>
							<tr>
								<td class="pad4px">
									<?= $i ?>
									<input type="hidden" name="DetailsID" value="<?= $detailsID?>">
								</td>
								<td class="pad4px">
									<?= $description ?>
								</td>
								<td class="pad4px">
									1
									<input type="hidden" name="Qty" value="1">
								</td>

								<td style="min-width:6em !important;text-align:right" class="pad4px">
									<?= nfT($transferPrice) ?>
									<input type="hidden" name="Price" value="<?= nfT($transferPrice) ?>">
								</td>
								<td style="min-width:6em !important;text-align:right" class="pad4px">
									<?= nfT($transferPrice) ?>
									<input type="hidden" name="SubTotal" value="<?= nfT($transferPrice) ?>">
								</td>
							</tr>
							
							<? if($extrasPrice > 0.00) { ?>
							<tr>
								<td class="pad4px"></td>
								<td class="pad4px">
									<span class="s">
										 Extra services
									</span>
								</td>
								<td class="pad4px"></td>

								<td style="min-width:6em !important;text-align:right" class="pad4px">
									<?= nf($extrasPrice ) ?>
									<input type="hidden" name="Price" value="<?= nf($extrasPrice) ?>">
								</td>
								<td style="min-width:6em !important;text-align:right" class="pad4px">
									<?= nf($extrasPrice) ?>
									<input type="hidden" name="SubTotal" value="<?= nf($extrasPrice) ?>">
								</td>
							</tr>
							<? } // endif
						}

					} //endforeach

						// OBREADA PODATAKA
						// uskladjeno sa Dusicom 
						
						//$subTotal = $transfersSum + $extrasSum;
					
						// ako je samo jedan transfer iz Srbije, podaci se prikazuju
						// znaci ako je isInSerbia false, onda se ispituje 
						// ako je vec true, ne treba dalje ispitivati, 
						// nego se podaci moraju prikazati - vidi dolje
						
						/*
						if($isInSerbia == false) $isInSerbia = InSerbia($od->RouteID);
						
						$commissionAmt = nfT( $provisionSum ); 

						$totalEur = nfT( $subTotal -  $commissionAmt );

						$noVAT = nfT( $totalEur - $driversPriceSum);
						*/
						//$knjigovodstvo = '1';
						if($transfersInSerbia == 0 and $knjigovodstvo != '1') $noVAT = '0.00';
						else if($$transfersInSerbia > 0) $noVAT = '0.00';
 
						//$VATbase = nfT( ($subTotal - $driversPriceSum - $commissionAmt) / ((100+$vat)/100));
						if($transfersInSerbia == 0) $VATbase = '0.00';
 
						//$VATtotal = nfT( $VATbase * $vat / 100);
						if($transfersInSerbia == 0) $VATtotal = '0.00';

					
						?>
					
						<tr><td colspan="5" class="pad4px"><br></td></tr>

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
								<?= nfT($subTotal*$_SESSION['TecajRSD']) ?>
							</td>
							<td style="min-width:6em !important;text-align:right" class="pad4px">
								<?= nfT($subTotal) ?>
								<input type="hidden" name="SumSubTotal" value="<?= nfT($subTotal) ?>">
							</td>
						</tr>
						<tr>
							<td></td>
							<td  class="ucase pad4px" style="text-align:right">Commission</td>
							<td></td>
							<td style="min-width:6em !important;text-align:right" class="pad4px">
								<?= nfT($commissionAmt*$_SESSION['TecajRSD']) ?>
							</td>
							<td style="min-width:6em !important;text-align:right" class="pad4px">
								<?= nfT($commissionAmt) ?>
								<input type="hidden" name="CommSubtotal" value="<?= nfT($commissionAmt) ?>">
							</td>
						</tr>

						<tr>
							<td class="pad4px"></td>
							<td  class="ucase pad4px" style="text-align:right">Total in EUR</td>
							<td></td>
							<td style="min-width:6em !important;text-align:right" class="pad4px">
								<?= nfT($totalEur*$_SESSION['TecajRSD']) ?>
							</td>
							<td style="min-width:6em !important;text-align:right" class="pad4px">
								<?= nfT($totalEur) ?>
								<input type="hidden" name="TotalSubTotalEUR" value="<?= nfT($totalEur) ?>">
							</td>
						</tr>					

						<? if($knjigovodstvo == '1') { ?>
						<tr>
							<td class="pad4px"></td>
							<td class="ucase pad4px" style="text-align:right"><small>VAT not app. acc. to Note</small></td>
							<td class="pad4px"></td>
							<td style="min-width:6em !important;text-align:right" class="pad4px">
								<?= nfT($noVAT*$_SESSION['TecajRSD']) ?>
							</td>
							<td style="min-width:6em !important;text-align:right" class="pad4px">
								<?= nfT($noVAT) ?>
								<input type="hidden" name="VATNotApp" value="<?= nfT($noVAT) ?>">
							</td>
						</tr>	
						<? } ?>

						<tr>
							<td class="pad4px"></td>
							<td class="ucase pad4px" style="text-align:right"><small>VAT base total</small></td>							
							<td class="pad4px"></td>
							<td style="min-width:6em !important;text-align:right" class="pad4px">
								<?= nfT($VATbase*$_SESSION['TecajRSD']) ?>
							</td>
							<td style="min-width:6em !important;text-align:right" class="pad4px">
								<?= nfT($VATbase) ?>
								<input type="hidden" name="VATBaseTotal" value="<?= nfT($VATbase) ?>">
							</td>
						</tr>	

						<tr>
							<td class="pad4px"></td>
							<td class="ucase pad4px" style="text-align:right"><small><?= $vat ?>% VAT total</small></td>							
							<td class="pad4px"></td>
							<td style="min-width:6em !important;text-align:right" class="pad4px">
								<?= nfT($VATbase*$vat*$_SESSION['TecajRSD']/100) ?>
							</td>							
							<td style="min-width:6em !important;text-align:right" class="pad4px">
								<?= nfT($VATbase*$vat/100) ?>
								<input type="hidden" name="VATtotal" value="<?= nfT($VATbase*$vat/100) ?>">
							</td>
						</tr>	

						<? if($knjigovodstvo == '1') { ?>
						<tr>
							<td class="pad4px"></td>
							<td class="ucase pad4px" style="text-align:right"><small>IN THE NAME AND ON ACCOUNT OF A THIRD PARTY</small></td>							
							<td class="pad4px"></td>
							<td style="min-width:6em !important;text-align:right" class="pad4px">
								<?= nfT($driversPriceTotal*$_SESSION['TecajRSD']) ?>
							</td>							
							<td style="min-width:6em !important;text-align:right" class="pad4px">
								<?= nfT($driversPriceTotal) ?>
								<input type="hidden" name="driversPriceTotal" value="<?= nfT($driversPriceTotal) ?>">
							</td>
						</tr>	
						<? } ?>		 				
						
						<tr>
							<td class="pad4px"></td>
							<td class="ucase pad4px" style="text-align:right"><small><strong>Grand total</strong></small></td>							
							<td class="pad4px"></td>
							<td style="min-width:6em !important;text-align:right" class="pad4px">
								<?= nfT($totalEur*$_SESSION['TecajRSD']) ?>
							</td>
							<td style="min-width:6em !important;text-align:right" class="pad4px">
								<strong><?= nfT($totalEur) ?></strong>
								<input type="hidden" name="GrandTotal" value="<?= nfT($totalEur) ?>">
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
										<?= s('co_paymentinfo') ?>  
									</em></small>
								</p>
								If You have any question regarding this Document, please contact: <br>
								<br><em>
								Name: <? echo $_SESSION['UserRealName'];  ?><br>
								E-mail: <?= s('co_email') ?><br>
								Tel/Fax: <?= s('co_tel') ?><br>
								</em>

								<br>
								Issued: <span class="IssuedDate">
									<? 	if(!$saved) echo date("d.m.Y");
										else echo $_REQUEST['InvoiceDate'];
									?>
								</span>, Belgrade<br><br>
								This Document is valid without signature or stamp.
							</td>

							<td class="pad1em">
						  		<p class="lead">INSTRUCTIONS FOR EUR PAYMENT:</p>
								
								<p class="rs">
									<strong>Company:</strong>  <?= s('co_name') ?>
									<br>
									<strong>Address:</strong> <?= s('co_address') ?>, <?= s('co_zip') ?> <?= s('co_city') ?>, 
									<?= s('co_country') ?><br>
									<br>
									<strong>Bank:</strong> <?= s('co_bank') ?><br>
									<strong>IBAN: </strong><?= s('co_iban') ?><br>
									<strong>SWIFT: </strong><?= s('co_swift') ?>
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
									<? if($saved and $knjigovodstvo == '1') { ?>
									<a href="index.php?p=invoices"
									class="btn btn-default no-print">
									<i class="fa fa-back"></i> Back to invoices</a>
									<? } ?>

									<? if($saved and $knjigovodstvo != '1') { ?>
									<button onclick="saveFile('http://<?= $_SERVER['HTTP_HOST'].$PDFfile ?>');" 
									class="btn xblue xwhite-text l no-print">
									<i class="fa fa-download"></i> 2. Download PDF - Agent</button>
									<? } ?>	
								</div>
							</td>
							<td>
								<div  class="pdfHide">
								
									<? if(!$saved) { ?>
									<button type="submit" class="btn btn-danger l pull-right"
									name="Save" value="1"><i class="fa fa-save"></i> 1. Save</button>
									<? } ?>

									<? if($saved  and $knjigovodstvo != '1') { ?>
									<button type="submit" name="k" value="1" class="btn btn-danger l no-print">
										<i class="fa fa-cogs"></i> 3. Create PDF-Knjigovodstvo
									</button>
									<? } ?>	

									<? if($saved  and $knjigovodstvo == '1') { ?>
									<button onclick="saveFile('http://<?= $_SERVER['HTTP_HOST'].$PDFfile ?>');" 
									class="btn xblue xwhite-text  l no-print">
									<i class="fa fa-download"></i> 4. Download PDF-Knjigovodstvo</button>
									<? } ?>	
								
								</div>
							</td>

						</tr>
				</table>
			</td>
		</tr>
	</table>

</form>
<!-- /.content-wrapper -->
</div>

<script>
	$(".jqdatepicker").datepicker({ dateFormat: 'yy-mm-dd' });

</script>
