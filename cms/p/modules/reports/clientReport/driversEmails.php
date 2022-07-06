<?
	require_once ROOT . '/db/db.class.php';
	require_once ROOT . '/cms/f/csv.class.php';
	
	$db = new DataBaseMysql();
	
	// CSV Setup
	$csv = new ExportCSV;
	$csv->File = 'DriverEmails';

	# CSV first row
	$csv->addHeader(array(
			'Email',
			'Company'
			) );

	$q = "SELECT * FROM v4_AuthUsers WHERE AuthLevelID = '31' ORDER BY AuthUserCompany ASC";
	$w = $db->RunQuery($q);
?>

<div class="container pad1em">
	<h1><?= DRIVERS_EMAIL_LIST ?></h1><br><br>

	<div class="row center">
		<div class="col-md-6">EMAIL</div>
		<div class="col-md-6">COMPANY</div>
	</div>
	
<?	
	while($u = $w->fetch_object()) {
		echo '<div class="row">';
		echo '<div class="col-md-1 right">';
			if ($u->Active) echo '<i class="fa fa-circle text-green"></i>';
			else echo '<i class="fa fa-circle text-red"></i>';
		echo '</div>';
		echo '<div class="col-md-5">' . $u->AuthUserMail . '</div>';
		echo '<div class="col-md-6">' . $u->AuthUserCompany . '</div>';
		echo '</div>';
		$csv->addRow(array($u->AuthUserMail, $u->AuthUserCompany));	
	}
	
	$csv->save();

	echo '<hr><h4>Exported to CSV!</h4>';

	echo '<a href="'.$csv->File.$csv->Extension.'" class="btn btn-default"><i class="fa fa-download"></i> 
	 Download CSV</a><br>';
	echo ' You can download CSV file here (or Right-Click->Save). <br>';
	echo ' <b>File format:</b> UTF-8, semi-colon (;) delimited<br>';
	
echo '</div>';

