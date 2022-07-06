<? require_once 'init.php';?>

<?
# ispitati moze li se ovaj program napraviti da bude univerzalan za sve prilike kad se treba
# prikazati lista transfera

?>

<input type="hidden"  id="whereCondition" name="whereCondition" value=" WHERE DriverID = 100">



		<div class="grid">
			<div class="col-2-12">
					<select id="status" onchange="getAllTransfersFilter();" >
						<option value="0"> All </option>
						<?
						foreach($StatusDescription as $val => $text) {
							echo  '<option value="'.$val.'"> ' . $text . '</option>';
						}
						?>
					</select>

			</div>
			<div class="col-3-12" style="display:inline !important">
				<input type="text" class="w100" id="Search" onchange="getAllTransfersFilter();"
				placeholder="Filter...">
			</div>
		</div>

		<? 
		# ovdje se prikazuju transferi
		?>
		<div id="showTransfers">No transfers</div>

		<?
			if ($_SESSION['AuthLevelID'] < '90') define("READ_ONLY_FLD", 'readonly="readonly"');
			if ($_SESSION['AuthLevelID'] >= '91') define("READ_ONLY_FLD", '');

			# ucitaj template script za listu transfera - handlebars
			require_once './parts/transferList.Driver.php';

			# ucitaj template za jedan transfer - editiranje - handlebars
		 	require_once './parts/transferEditForm.Admin.php';
		 ?>

<script type="text/javascript">

// ovdje se postavlja glavni WHERE uvjet
// a getAllTransfers poziva preko ajaxa a/allTransfers.php
// koji vraca podatke o transferima.
// podaci se pune u #showTransfers div.
// template-i su u parts/ folderu

$(document).ready(function(){
	getAllTransfers($("#whereCondition").val());
});

function getAllTransfersFilter() {
	getAllTransfers($("#whereCondition").val());
}

</script>
