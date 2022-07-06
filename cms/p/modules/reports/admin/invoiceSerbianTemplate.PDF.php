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
	<input type="hidden" name="Storno" value="<?= $_REQUEST['Storno'] ?>">
	<input type="hidden" name="Submit" value="<?= $_REQUEST['Submit'] ?>">
	<input type="hidden" name="Save" value="<?= $_REQUEST['Save'] ?>">
	<input type="hidden" name="InvoiceNumber" value="<?= $_REQUEST['InvoiceNumber'] ?>">
	<input type="hidden" name="InvoiceDate" value="<?= $_REQUEST['InvoiceDate'] ?>">
	<input type="hidden" name="VATtotal" value="<?= $_REQUEST['VATtotal'] ?>">

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
						<small>Datum: <span class="IssuedDate">
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
				<address>
					<?= s('co_name') ?><br>
					<?= s('co_address') ?><br>
					<?= s('co_zip') ?> <?= s('co_city') ?><br>
					PIB: <?= s('co_taxno') ?><br>
					Tekući račun: <?= s('co_accountno') ?> <?= s('co_bank') ?><br>
				</address>
				</td>
			
				<!-- /.col -->
				<td class="pad4px"  style="vertical-align:top">
						<strong><?= $u->AuthUserCompany ?></strong><br>
						<?= $u->AuthCoAddress ?><br>
						<?= $u->Zip ?> <?= $u->City ?><br>
						<?= $u->CountryName ?><br>
						PIB: <?= $u->AuthUserCompanyMB ?><br>
						<!--Phone: <?= $u->AuthUserTel ?><br>
						Email: <?= $u->AuthUserMail ?><br>-->
						<br><br>

				</td>
				<!-- /.col -->
				<td class="pad4px"  style="vertical-align:top" width="33%">
					<strong>
						<? if(!$saved) { ?>
							Dokument br: <br>						
							<input type="text" name="InvoiceNumber" value="<?= $_REQUEST['InvoiceNumber'] ?>">
							<input type="checkbox" id="proforma" name="proforma" value="proforma">
							<label for="proforma"> Proforma</label><br>

						<? } else { ?>
							<h3>
							<? 
								if (isset($_REQUEST['proforma']) && $_REQUEST['proforma']=='proforma') {
									echo "Predračun br:";							
									echo "<input type='hidden' id='proforma' name='proforma' value='proforma'>";
								}	
								else echo "Račun br: ";
								echo $_REQUEST['InvoiceNumber'] ;
							?>
							</h3>
						<? } ?>
					</strong>
					<br>
					<strong>Datum i mesto prometa:</strong><br> 

					<? if(!$saved) { ?>
						<input type="text" value="<?= date("d.m.Y") ?>" name="InvoiceDate" id="InvoiceDate" 
						class="jqdatepicker no-print" 
						onchange="$('.IssuedDate').html(this.value);">
					<? } else echo $_REQUEST['InvoiceDate'] ; ?>
					, Beograd
					<br>
					<br>

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
								<th class="pad4px">Rbr.</th>
								<th class="pad4px">
									Vrsta dobra ili usluge
								</th>
								<th class="pad4px">Kol.</th>
								<th class="pad4px">Cena u EUR</th>
								<th class="pad4px">Vrednost u EUR</th>
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
				
				foreach($kd as $nn => $id) {
									
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

								// ako je racun za knjigovodstvo uvijek prikazi podatke! - ovo sam krivo shvatio
								//if($knjigovodstvo == '1') $isInSerbia = true;
									$commissionAmt += $provision;

									$totalEur += nf( $fullPrice -  $provision );

									if($isInSerbia) 
										$VATbaseTemp =  (($fullPrice - $driversPrice - $provision) / ((100+$vat)/100)* s('TecajRSD'));
										$VATbase += nfT( $VATbaseTemp);
										
									if($isInSerbia == false and $knjigovodstvo == '1') {
										$VATbase +=  nf( ($fullPrice - $driversPrice - $provision) * s('TecajRSD'));
									}
									
									//if($isInSerbia == false and $knjigovodstvo != '1') {
										//$VATbase = '0.00';
									//}						

									if($isInSerbia) $VATtotal +=  nf($VATbaseTemp * $vat / 100);
									//if($isInSerbia == false) $VATtotal = '0.00';


							?>
								<tr>
									<td class="pad4px">
										<?= $i ?>.
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
										<?= nf($transferPrice) ?>
										<input type="hidden" name="Price" value="<?= nf($transferPrice) ?>">
									</td>
									<td style="min-width:6em !important;text-align:right" class="pad4px">
										<?= nf($transferPrice) ?>
										<input type="hidden" name="SubTotal" value="<?= nf($transferPrice) ?>">
									</td>
								</tr>
								
								<? if($extrasPrice > 0.00) { ?>
								<tr>
									<td class="pad4px"></td>
									<td class="pad4px">
										<span class="s">
											 Dodatne usluge
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

		?>

						<? 	
					
						// OBREADA PODATAKA
						// uskladjeno sa Dusicom 
/*				
						$subTotal = $transfersSum + $extrasSum;
					
						// ako je samo jedan transfer iz Srbije, podaci se prikazuju
						// znaci ako je isInSerbia false, onda se ispituje 
						// ako je vec true, ne treba dalje ispitivati, 
						// nego se podaci moraju prikazati - vidi dolje
						if($isInSerbia == false) $isInSerbia = InSerbia($od->RouteID);

						// ako je racun za knjigovodstvo uvijek prikazi podatke! - ovo sam krivo shvatio
						//if($knjigovodstvo == '1') $isInSerbia = true;
							$commissionAmt = nf( $provisionSum );

							$totalEur = nf( $subTotal -  $commissionAmt );

							$VATbase = nf( ( ($subTotal - $driversPriceSum - $commissionAmt) / ((100+$vat)/100)) * 
											s('TecajRSD'));

							if($isInSerbia == false and $knjigovodstvo == '1') {
								$VATbase =  nf(  ($subTotal - $driversPriceSum - $commissionAmt) * 
													s('TecajRSD'));
							}
*/							
							if($transfersInSerbia == 0 and $knjigovodstvo != '1') {
								$VATbase = '0.00';
							}						

							//$VATtotal = nf( $VATbase * $vat / 100 );
							if($transfersInSerbia == 0) $VATtotal = '0.00';

												
						?>
					
						<tr><td colspan="5" class="pad4px"><br><br></td></tr>
						<tr>
							<td></td>
							<td  class="ucase pad4px" style="text-align:right">Provizija</td>
							<td></td>
							<td style="min-width:6em !important;text-align:right" class="pad4px">
								<?= nf($commissionAmt) ?>
								<input type="hidden" name="CommPrice" value="<?= nf($commissionAmt) ?>">
							</td>
							<td style="min-width:6em !important;text-align:right" class="pad4px">
								<?= nf($commissionAmt) ?>
								<input type="hidden" name="CommSubtotal" value="<?= nf($commissionAmt) ?>">
							</td>
						</tr>

						<tr>
							<td class="pad4px"></td>
							<td  class="ucase pad4px" style="text-align:right">Vrednost usluge u EUR</td>
							<td></td>
							<td style="min-width:6em !important;text-align:right" class="pad4px">
								<?= nf($totalEur) ?>
								<input type="hidden" name="TotalPriceEUR" value="<?= nf($totalEur) ?>">
							</td>
							<td style="min-width:6em !important;text-align:right" class="pad4px">
								<?= nf($totalEur) ?>
								<input type="hidden" name="TotalSubTotalEUR" value="<?= nf($totalEur) ?>">
							</td>
						</tr>					

						<tr>
							<td></td>
							<td  class="ucase" style="text-align:right">Vrednost usluge u RSD</td>
							<td></td>
							<td style="min-width:6em !important;text-align:right">
								<?= nf($totalEur * s('TecajRSD')) ?>
							</td>
							<td style="min-width:6em !important;text-align:right">
								<?= nf($totalEur * s('TecajRSD')) ?>
							</td>
						</tr>	

						<tr>
							<td class="pad4px"></td>
							<td class="pad4px"></td>
							<td class="pad4px"></td>
							<td class="ucase pad4px"><small>Poreska osnovica</small></td>
							<td style="min-width:6em !important;text-align:right" class="pad4px">
								<?= nf($VATbase) ?>
								<input type="hidden" name="VATBaseTotal" value="<?= nf($VATbase) ?>">
							</td>
						</tr>

						<tr>
							<td class="pad4px"></td>
							<td class="pad4px"></td>
							<td class="pad4px"></td>

							<td class="ucase pad4px"><small>Opšta stopa PDV-a <?= $vat ?>%</small></td>
							<td style="min-width:6em !important;text-align:right" class="pad4px">
							
							<? if(!$saved) { ?>
								<input type="text" name="VATtotal" style="text-align:right" 
								value="<?= nf($VATbase*$vat/100) ?>">
							<? } else echo nf($_REQUEST['VATtotal']) ; ?>
							</td>
						</tr>	

						<? if($knjigovodstvo == '1') { ?>
						<tr>
							<td class="pad4px"></td>
							<td class="pad4px"></td>
							<td class="pad4px"></td>
							<td class="ucase pad4px"><small>Naplata u ime i za račun trećeg lica</small></td>
							<td style="min-width:6em !important;text-align:right" class="pad4px">
								<?= nf($driversPriceSum*s('TecajRSD')) ?>
								<input type="hidden" name="driversPriceSum" value="<?= nf($driversPriceSum ) ?>">
							</td>
						</tr>
						<? } ?>
						
						<tr>
							<td class="pad4px"></td>
							<td class="pad4px"></td>
							<td class="pad4px"></td>
							<td class="ucase pad4px"><small><strong>Svega po računu (RSD)</strong></small></td>
							<td style="min-width:6em !important;text-align:right" class="pad4px">
								<strong><?= nf( $totalEur * s('TecajRSD') ) ?></strong>
								<input type="hidden" name="GrandTotal" value="<?= $totalEur ?>">
							</td>
						</tr>	
					
						</tbody>
					</table>
				</td>
				<!-- /.col -->
			</tr>
		  <!-- /.row -->

			<tr>
				<td colspan="3">
					<table style="width:100%;" >
						<tr>
							<td class="pad1em">

								<p>
									<small><em>
										Napomena: PDV nije obračunat na osnovu Člana 12, <br>
										stav 6  i Člana 17, stav 4 Zakona o porezu na <br>
										dodatu vrednost
									</em></small>
								</p>
		
									Način plaćanja: bezgotovinski<br>	

									Rok za plaćanje: 8 dana	<br>

									Datum i mesto izdavanja: 
									<span class="IssuedDate">
										<? 	if(!$saved) echo date("d.m.Y");
											else echo $_REQUEST['InvoiceDate'];
										?>
									</span>, Beograd<br>
									
										Dokument izdala (identifikaciona oznaka): <br>
										<? echo $_SESSION['UserRealName'];  ?>, <? echo $_SESSION['UserIDD'];  ?>



							</td>
							<!-- /.col -->
			

							<td class="pad1em">

								<p class="rs">
									 *iskazana cena je u EUR, <br>
									 što znači da se primenjuje valutna klauzula <br>
									 (uplata u dinarskoj protivvrednosti prema <br>
									 zvaničnom srednjem kursu NBS na dan izdavanja dokumenta)<br> 
								</p>

									Ovaj dokument je izdat u elektronskom formatu i važi bez<br> 
									pečata i potpisa na osnovu člana 9. Zakona o računovodstvu<br> 
									i Mišljenja Ministarstva finansija broj 401-004169/2017-16
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
		<!-- /.content -->

	</table>
</form>
<!-- /.content-wrapper -->
</div>

<script>
	$(".jqdatepicker").datepicker({ dateFormat: 'dd.mm.yy' });

</script>
