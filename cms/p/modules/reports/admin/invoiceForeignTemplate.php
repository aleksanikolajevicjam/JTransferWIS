<? 	$vat=$_SESSION['vat']; ?> 
 <!-- Content Wrapper. Contains page content -->
<div class="wrapper container" xstyle="width:100% !important">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <div class="invoice pad1em">
		<!-- title row -->
		<div class="row" style="display:block !important">
			<div class="col-xs-12">
				<h2 class="page-header" style="text-transform:none !important">
					<?= Logo() ?>
					<small class="pull-right">Date: <span class="IssuedDate"><?= date("Y-m-d")?></span></small>
				</h2>
			</div>
			<!-- /.col -->
		</div>
		<!-- info row -->
		<div class="row invoice-info"  style="display:block !important">
			<div class="col-xs-4 invoice-col">
				From: 
				<address>
					<?= s('co_name') ?><br>
					<?= s('co_address') ?><br>
					<?= s('co_zip') ?> <?= s('co_city') ?><br>
					<?= s('co_country') ?><br>
					Tax ID: 108576323 
					<!--Phone: <?= s('co_tel') ?><br>
					Email: <?= s('co_email') ?>-->
				</address>
			</div>
			
			<!-- /.col -->
			<div class="col-xs-4 invoice-col">
				To:
				<address>
					<strong><?= $u->AuthUserCompany ?></strong><br>
					<?= $u->AuthCoAddress ?><br>
					<?= $u->Zip ?> <?= $u->City ?><br>
					<?= $u->CountryName ?><br>
					Tax ID: <?= $u->AuthUserCompanyMB ?><br>
					<!--Phone: <?= $u->AuthUserTel ?><br>
					Email: <?= $u->AuthUserMail ?><br>-->
				</address>
			</div>
			<!-- /.col -->
			<div class="col-xs-4 invoice-col">
				<b>Invoice #: <input type="text"></b><br>
				<br>
				<b>Delivery date:</b> 
				<input type="text" value="<?= $Date ?>" name="InvoiceDate" id="InvoiceDate" style="border:none"
				class="jqdatepicker no-print pdf-input" 
				onchange="$('.DueDate').html(addDays(this.value,15));$('.IssuedDate').html(this.value);">
				<br>
				<b>Due date:</b> <span class="DueDate"><?= $dueDate ?></span><br>

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
							<th>No.</th>
							<th>
								Order/Route<br>
								<span class="s">
									Pax Info/Date/Time
								</span>
							</th>
							<th>Qty</th>
							<th>Unit price</th>
							<th>Subtotal</th>
						</tr>
					</thead>
					<tbody>
	<?						
	foreach($kd as $nn => $id) {
		$od->getRow($id);
	
		$driversPriceSum += $od->getDriversPrice();
		
		$transferPrice 	= $od->getDetailPrice();
		$extrasPrice 	= $od->getExtraCharge();
		$provision		= $od->getProvisionAmount();
		
		$transfersSum	+= $transferPrice;
		$extrasSum		+= $extrasPrice;
		$provisionSum	+= $provision;
		
		//$transferIDs .= '<br>'.$od->getOrderID().'-'. $od->getTNo() .' '.nfT($transferPrice). ',';
		$transfersCount += 1;
		?>
					<tr>
						<td><?= $transfersCount ?>.</td>
						<td>
							<strong><?= $od->getOrderID().'-'. $od->getTNo() ?></strong> 
							<em><?= $od->PickupName . ' - ' . $od->DropName ?></em>
							<br>
							<span class="s">
								<?= $od->PaxName ?>, <?= $od->PaxNo ?> pax. | 
								<?= $od->PickupDate?> <?= $od->PickupTime?>
							</span>
						</td>
						<td>1</td>

						<td style="min-width:6em !important;text-align:right">
							<?= nfT($transferPrice) ?>
						</td>
						<td style="min-width:6em !important;text-align:right"><?= nfT($transferPrice) ?></td>
					</tr>
					<? if($od->getExtraCharge() > 0.00) { ?>
					<tr>
						<td></td>
						<td>
							<span class="s">
								 Extra services
							</span>
						</td>
						<td></td>

						<td style="min-width:6em !important;text-align:right">
							<?= nfT($od->getExtraCharge()) ?>
						</td>
						<td style="min-width:6em !important;text-align:right"><?= nfT($od->getExtraCharge()) ?></td>
					</tr>
					<? } ?>
	<?

	} //endforeach

	?>

					<? 	
					
					$subTotal = $transfersSum + $extrasSum;
					
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
						<td  class="ucase" style="text-align:right">Sum</td>
						<td></td>
						<td style="min-width:6em !important;text-align:right"><?= nfT($subTotal) ?></td>
						<td style="min-width:6em !important;text-align:right"><?= nfT($subTotal) ?></td>
					</tr>

					<tr>
						<td></td>
						<td  class="ucase" style="text-align:right">Commission</td>
						<td></td>
						<? //$commissionAmt = nfT( $subTotal * $u->Provision / 100 ); ?>
						<? $commissionAmt = nfT( $provisionSum ); ?>
						<td style="min-width:6em !important;text-align:right"><?= $commissionAmt ?></td>
						<td style="min-width:6em !important;text-align:right"><?= $commissionAmt ?></td>
					</tr>

					<tr>
						<td></td>
						<td  class="ucase" style="text-align:right">Total in EUR</td>
						<td></td>
						<? $totalEur = nfT( $subTotal -  $commissionAmt ); ?>
						<td style="min-width:6em !important;text-align:right"><?= $totalEur ?></td>
						<td style="min-width:6em !important;text-align:right"><?= $totalEur ?></td>
					</tr>					

					<tr>
						<td></td>
						<td></td>
						<td></td>
						<? 
						$noVAT = nfT( $totalEur - $driversPriceSum);
						if($isInSerbia == false and $knjigovodstvo != '1') $noVAT = '0.00';
						else if($isInSerbia == true) $noVAT = '0.00';
						?>
						<td class="ucase"><small>VAT not app. acc. to Note</small></td>
						<td style="min-width:6em !important;text-align:right"><?= $noVAT ?></td>
					</tr>	

					<tr>
						<td></td>
						<td></td>
						<td></td>
						<? 
						$VATbase = nfT( ($subTotal - $driversPriceSum - $commissionAmt) / ((100+$vat)/100));
						if($isInSerbia == false) $VATbase = '0.00';
						?>
						<td class="ucase"><small>VAT base total</small></td>
						<td style="min-width:6em !important;text-align:right"><?= $VATbase ?></td>
					</tr>	

					<tr>
						<td></td>
						<td></td>
						<td></td>
						<? 
						$VATtotal = nfT( $VATbase * $vat / 100);
						if($isInSerbia == false) $VATtotal = '0.00';
						?>
						<td class="ucase"><small><?= $vat ?>% VAT total</small></td>
						<td style="min-width:6em !important;text-align:right"><?= $VATtotal ?></td>
					</tr>	

					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td class="ucase"><small><strong>Grand total</strong></small></td>
						<td style="min-width:6em !important;text-align:right">
							<strong><?= $totalEur ?></strong>
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
						Note: The total amount is calculated without VAT,<br> 
						in accordance with the Law on Value Added Tax, Article 12, Paragraph 6 
					</em></small>
				</p>
					If You have any question regarding this Invoice, please contact: <br>
					<br><em>
					Name: <? echo $_SESSION['UserRealName'];  ?><br>
					E-mail: finance@jamtransfer.com<br>
					Tel/Fax: 00 381 11 364 02 15<br>
					</em>

					<br>
					Issued: <span class="IssuedDate"><?= date("Y-m-d")?></span>, Belgrade<br>

					<p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
						This Invoice is valid without signature or stamp.
					</p>
				</p>

			</div>
			<!-- /.col -->
			

			<div class="col-xs-6">

			  <p class="lead">INSTRUCTIONS FOR EUR PAYMENT:</p>
				<p class="rs">
					<strong>Company:</strong>  Jam Transfer d.o.o. 
					<br>
					<strong>Address:</strong> 17 Vladislava Bajčevića st., 11000 Belgrade, Republic of Serbia<br>
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
	$(".jqdatepicker").datepicker({ dateFormat: 'yy-mm-dd' });

</script>
