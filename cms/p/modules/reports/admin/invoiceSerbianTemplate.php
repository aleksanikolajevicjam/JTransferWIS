 <? $vat=$_SESSION['vat']; ?> 
 <!-- Content Wrapper. Contains page content -->
<div class="wrapper container">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <div class="invoice pad1em">
		<!-- title row -->
		<div class="row" style="display:block !important">
			<div class="col-xs-12">
				<h2 class="page-header" style="text-transform:none !important">
					<?= Logo() ?>
					<small class="pull-right">Datum: <span class="IssuedDate"><?= date("d.m.Y")?></span></small>
				</h2>
			</div>
			<!-- /.col -->
		</div>
		<!-- info row -->
		<div class="row invoice-info"  style="display:block !important">
			<div class="col-xs-4 invoice-col">
				<!--<address>
					<?= s('co_name') ?><br>
					<?= s('co_address') ?><br>
					<?= s('co_zip') ?> <?= s('co_city') ?><br>
					PIB: <?= s('co_taxno') ?><br>
					Tekući račun: <?= s('co_accountno') ?> <?= s('co_bank') ?><br>
					<!--Phone: <?= s('co_tel') ?><br>
					Email: <?= s('co_email') ?>-->
				</address>-->
				
			</div>
			
			<!-- /.col -->
			<div class="col-xs-4 invoice-col">

				<address>
					<strong><?= $u->AuthUserCompany ?></strong><br>
					<?= $u->AuthCoAddress ?><br>
					<?= $u->Zip ?> <?= $u->City ?><br>
					<?= $u->CountryName ?><br>
					PIB: <?= $u->AuthUserCompanyMB ?><br>
					<!--Phone: <?= $u->AuthUserTel ?><br>
					Email: <?= $u->AuthUserMail ?><br>-->
				</address>
			</div>
			<!-- /.col -->
			<div class="col-xs-4 invoice-col">
				<b>RAČUN br: <input type="text"></b><br>
				<br>
				<b>Datum i mesto prometa:</b><br> 
				<input type="text" value="<?= date("d.m.Y") ?>" 
				name="InvoiceDate" id="InvoiceDate" 
				style="border:none;width:7em !important;padding:0"
				class="jqdatepicker no-print"
				onchange="$('.IssuedDate').html(this.value);"> Beograd
				<br>

			</div>
			<!-- /.col -->
		</div>
      <!-- /.row -->

      <!-- Table row -->
		<div class="row"  style="display:block !important">
			<div class="col-xs-12 table-responsive">
				<table class="table table-bordered" width="100%">
					<thead>
						<tr>
							<th>Rbr.</th>
							<th>
								Vrsta dobra ili usluge<br>
							</th>
							<th>Kol.</th>
							<th>Cena u EUR</th>
							<th>Vrednost u EUR</th>
						</tr>
					</thead>
					<tbody>
	<?						
	foreach($kd as $nn => $id) {
		$od->getRow($id);
	
		$driversPriceSum += $od->getDriversPrice();
		
		$transferPrice 	= $od->getDetailPrice() + $od->getExtraCharge();
		$extrasPrice 	= $od->getExtraCharge();
		$provision		= $od->getProvisionAmount();
		
		$transfersSum	+= $transferPrice;
		$extrasSum		+= $extrasPrice;
		$provisionSum	+= $provision;
		
		//$transferIDs .= '<br>'.$od->getOrderID().'-'. $od->getTNo() .' '.nf($transferPrice). ',';
		$transfersCount += 1;
		?>
					<tr>
						<td><?= $transfersCount ?>.</td>
						<td>
							Rezervacija vozila:
							<strong><?= $od->getOrderID().'-'. $od->getTNo() ?></strong><br>
							<em><?= $od->PickupName . ' - ' . $od->DropName ?></em>
							<br>
							<span class="s">
								<?= $od->PaxName ?>, <?= $od->PaxNo ?> pax. | 
								<?= $od->PickupDate?> <?= $od->PickupTime?>
								
							</span>
						</td>
						<td>1</td>

						<td style="min-width:6em !important;text-align:right">
							<?= nf($transferPrice) ?>
						</td>
						<td style="min-width:6em !important;text-align:right"><?= nf($transferPrice) ?></td>
					</tr>
					
					<? if($od->getExtraCharge() > 0) { ?>
					<tr>
						<td></td>
						<td>
							<span class="s">
								 Dodatne usluge
							</span>
						</td>
						<td></td>

						<td style="min-width:6em !important;text-align:right">
							<?= nf($od->getExtraCharge()) ?>
						</td>
						<td style="min-width:6em !important;text-align:right"><?= nf($od->getExtraCharge()) ?></td>
					</tr>
					<? } ?>					
	<?

	} //endforeach

	?>

					<? 	
					
					$subTotal = $transfersSum;
					
					// ako je samo jedan transfer iz Srbije, podaci se prikazuju
					// znaci ako je isInSerbia false, onda se ispituje 
					// ako je vec true, ne treba dalje ispitivati, 
					// nego se podaci moraju prikazati - vidi dolje
					if($isInSerbia == false) $isInSerbia = InSerbia($od->RouteID);

					// ako je racun za knjigovodstvo uvijek prikazi podatke! - ovo sam krivo shvatio
					//if($knjigovodstvo == '1') $isInSerbia = true;
					
					
					?>
					
					<tr><td colspan="5"><br><br></td></tr>
					<tr>
						<td></td>
						<td  class="ucase" style="text-align:right">Provizija</td>
						<td></td>
						<? //$commissionAmt = nf( $subTotal * $u->Provision / 100 ); ?>
						<? $commissionAmt = nf( $provisionSum ); ?>
						<td style="min-width:6em !important;text-align:right"><?= $commissionAmt ?></td>
						<td style="min-width:6em !important;text-align:right"><?= $commissionAmt ?></td>
					</tr>

					<tr>
						<td></td>
						<td  class="ucase" style="text-align:right">Vrednost usluge u EUR</td>
						<td></td>
						<? $totalEur = nf( $subTotal -  $commissionAmt ); ?>
						<td style="min-width:6em !important;text-align:right"><?= $totalEur ?></td>
						<td style="min-width:6em !important;text-align:right"><?= $totalEur ?></td>
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
						<td></td>
						<td></td>
						<td></td>
						<? 
						$VATbase = nf( ( ($subTotal - $driversPriceSum - $commissionAmt) / ((100+$vat)/100)) * s('TecajRSD'));
						if($isInSerbia == false and $knjigovodstvo == '1') {
							$VATbase =  nf(  ($subTotal - $driversPriceSum - $commissionAmt) * s('TecajRSD'));
						}
						if($isInSerbia == false and $knjigovodstvo != '1') {
							$VATbase = '0.00';
						}						
						?>

						<td class="ucase"><small>Poreska osnovica</small></td>
						<td style="min-width:6em !important;text-align:right"><?= $VATbase ?></td>
					</tr>	




					<tr>
						<td></td>
						<td></td>
						<td></td>
						<? 
						$VATtotal = nf( $VATbase * $vat/ 100 );
						if($isInSerbia == false) $VATtotal = '0.00';
						//if($isInSerbia == false and $knjigovodstvo != '1') $VATtotal = '0.00';
						//else if($isInSerbia == true) $VATtotal = '0.00';						
						?>
						<td class="ucase"><small>Opšta stopa PDV-a <?= $vat ?></small></td>
						<td style="min-width:6em !important;text-align:right">
						<input type="text" name="VATtotal" style="text-align:right;border:none;" value="<?= $VATtotal ?>">
						</td>
					</tr>	

					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td class="ucase"><small><strong>Svega po računu (RSD)</strong></small></td>
						<td style="min-width:6em !important;text-align:right">
							<strong><?= nf( $totalEur * s('TecajRSD') ) ?></strong>
						</td>
					</tr>	
					
					</tbody>
				</table>
			</div>
			<!-- /.col -->
		</div>
      <!-- /.row -->

		<div class="row"  style="display:block !important">

			<div class="col-xs-6">
				<p>
				<p>
					<small><em>
						Napomena: PDV nije obračunat na osnovu Člana 12, <br>
						stav 6 Zakona o porezu na dodatu vrednost
					</em></small>
				</p>
		
					Način plaćanja: bezgotovinski<br>	

					Rok za plaćanje: 8 dana	<br>

					<br>
					Datum i mesto izdavanja: <span class="IssuedDate"><?= date("d.m.Y")?></span>, Beograd<br>


				</p>

			</div>
			<!-- /.col -->
			

			<div class="col-xs-6">


				<p class="rs">
					 *iskazana cena je u EUR, <br>
					 što znači da se primenjuje valutna klauzula <br>
					 (uplata u dinarskoj protivvrednosti prema <br>
					 prodajnom kursu Banca Intesa ad na dan uplate)<br> 
				</p>


			</div>
			<!-- /.col -->

		</div>
		<!-- /.row -->

		<div class="row"  style="display:block !important">

			<div class="col-xs-6">

					<p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
						Račun izdala: Andrijana Ponorac
					</p>

				</p>

			</div>
			<!-- /.col -->
			

			<div class="col-xs-6">

				<p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
					Račun je punovažan bez pečata i potpisa
				</p>

			</div>
			<!-- /.col -->

		</div>
		<!-- /.row -->
		<!-- this row will not appear when printing -->
		<div class="row no-print">
			<div class="col-xs-12">
				<a onclick="window.print();" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
			</div>
		</div>
	</div>
    <!-- /.content -->
    <div class="clearfix"></div>
</div>
<!-- /.content-wrapper -->

<script>
	$(".jqdatepicker").datepicker({ dateFormat: 'dd.mm.yy' });

</script>
