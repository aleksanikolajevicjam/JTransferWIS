<?	
	// priprema podataka
	require_once ROOT. '/api/getExtras.php';

if(!empty($extras)) { ?>


	<div class="col s12 black-text"><h5><i class="fa fa-cubes"></i> <?= EXTRAS ?></h5></div>

	<div class="row pad1em white"><br><br>
	<? 
	
	// Izlistaj sve Extra usluge
	$serviceLang = 'Service'.Lang();
	foreach($extras as $i => $extraArray) { 
		$Service 	= $extraArray[$serviceLang];
		$Price 		= $extraArray['Price'];
		$ID			= $extraArray['ID'];

	?>
	<div class="row" style="margin:0px !important">
		<div class="col s12 l7 black-text">
			<?=  $Service ?> (<?= nf(toCurrency($Price)) . ' ' . s('Currency') ?>)
		</div>
		<div class="col s1 l1 white-text center"><i class="fa fa-times"></i></div>
	
		<div class="col s11 l2">
			<!--<input type="number" id="<?= $i ?>" name="ExtraItems[<?= $ID ?>]" class="col s12 l5" 
			value="0" title="<?= $Service ?>"
			onchange="recalcExtra(this,'<?= $Price ?>');">-->
	
			<select class="browser-default" name="ExtraItems[<?= $ID ?>]" id="<?= $i ?>" 
			onchange="recalcExtra(this,'<?= $Price ?>');">
				<option value="0"> --- </option>
				<option value="1"> 1 </option>
				<option value="2"> 2 </option>
				<option value="3"> 3 </option>
				<option value="4"> 4 </option>
				<option value="5"> 5 </option>
				<option value="6"> 6 </option>
				<option value="7"> 7 </option>
				<option value="8"> 8 </option>
				<option value="9"> 9 </option>
				<option value="10"> 10 </option>
				<option value="11"> 11 </option>
				<option value="12"> 12 </option>
				<option value="13"> 13 </option>
				<option value="14"> 14 </option>
				<option value="15"> 15 </option>
			</select>
		</div>
	
		<div class="col s12 l2 right l" id="<?= $i ?>Total">0.00</div>
	
		<input type="hidden" class="extraTotal" id="<?= $i ?>SubTotal" name="ExtraSubtotals[<?= $ID ?>]">
		<input type="hidden" name="ExtraServices[<?= $ID ?>]" value="<?= $Service ?>">
		<? // DRUGE VALUTE ?>
		<input type="hidden" class="extraTotalC" id="<?= $i ?>SubTotalC" name="ExtraSubtotalsC[<?= $ID ?>]">
		<input type="hidden" name="ExtraServicesC[<?= $ID ?>]" value="<?= $Service ?>">
	
	</div><hr>
	<? }
	echo '	</div>	';
} //end if(!empty($extras))
?>

		<input type="hidden" id="transferPrice" name="transferPrice" value="<?= number_format(s('Price'),2,'.',''); ?>">
		<input type="hidden" id="TotalPrice" name="TotalPrice" value="<?= number_format(s('Price'),2,'.',''); ?>">

		<? // DRUGE VALUTE ?>
		<input type="hidden" id="transferPriceC" name="transferPriceC" value="<?= toCurrency(s('Price')); ?>">
		<input type="hidden" id="TotalPriceC" name="TotalPriceC" value="<?= toCurrency(s('Price')); ?>">

		<div class="row blue xdarken-3 white-text xl z-depth-2 center">
	
				<div  class="col s12 "><?= GRAND_TOTAL ?>:
					<? $disprice = s('Price')*s('Provision')/100 ; ?>
					<span id="grandTotal"><?= nf(s('Price')) ?> <?= s('Currency') ?></span>
					<? if(s('Provision')>0) {?><span> - <?= nf(toCurrency($disprice)) ?> <?= s('Currency') ?> (<?= PROVISION ?>)</span><? } ?>
				</div>

		</div>
<?