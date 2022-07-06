<form name="exchangeRate" method="post" action="">
<div class="container">
<div class="box box-info pad1em shadowLight">
<h1><?= EXCHANGE_RATE ?></h1>
<br>
<?
	$filename = ROOT . '/cms/exchangeRate.inc';
	
	if (is('setRate', 'r') and r('setRate') == 1) {


		$somecontent = r('exchangeRate');

		// Let's make sure the file exists and is writable first.
		if (is_writable($filename)) {

			// In our example we're opening $filename in append mode.
			// The file pointer is at the bottom of the file hence
			// that's where $somecontent will go when we fwrite() it.
			if (!$handle = fopen($filename, 'w')) {
				 echo "Cannot open file ($filename)";
				 exit;
			}

			// Write $somecontent to our opened file.
			if (fwrite($handle, $somecontent) === FALSE) {
				echo "Cannot write to file ($filename)";
				exit;
			}

			echo "New Exchange Rate - $somecontent - is now active.";

			fclose($handle);

		} else {
			echo "The file $filename is not writable";
		}		
				
	
	} else {
		
		// uzmi podatke iz file-a
		$tecaj = file_get_contents($filename, FILE_USE_INCLUDE_PATH);
		$_SESSION['TecajRSD'] = $tecaj;

		
		
	?>



	<div class="row">
		<div class="col-md-3"><?= EUR_TO_RSD ?></div>
		<div class="col-md-3">
			<input type="text" name="exchangeRate" value="<?= $tecaj ?>"> RSD
		</div>		
		<div class="col-md-6">
			<button name="setRate" type="submit" class="btn btn-primary " value="1"><?= SET_NEW_RATE ?></button>
		</div>	
	</div>


<? } ?>

</div>
</div>
</form>
