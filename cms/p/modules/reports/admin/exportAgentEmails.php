<?
require_once ROOT . '/db/db.class.php';
require_once ROOT . '/cms/f/csv.class.php';
require_once ROOT .'/db/v4_Countries.class.php';

$country = $_GET["country"];
$pageurl = '?p=exportAgentEmails';

$c = new v4_Countries();

echo '<div class="container-fluid pad1em">';
echo '<h1>' . AGENT_REPORT . '</h1><br><br>';

// CSV Setup
$csv = new ExportCSV;
$csv->File = 'AgentEmails';

# CSV first row
$csv->addHeader(array(
		'Name',
		'Username',
		'Email',
		'Company',
		'Company Web'
		) );

$db = new DataBaseMysql();
?>

Filter by Country:

<select id="CountryName" name="CountryName">
	<option value=""> --- </option>
	<?
	$k = $c->getKeysBy('CountryName', 'asc');
	foreach($k as $nn => $id) {
		$c->getRow($id);
		$CountryName = $c->getCountryName();
		echo '<option value="'.$CountryName.'"';
		if ($CountryName == $country) echo " selected";
		echo '>'.$CountryName . '</option>';
	}
	?>
</select><br><br>

<?
// table header
echo '<div class="row">';
echo '<div class="col-md-3">Name</div>';
echo '<div class="col-md-2">Username</div>';
echo '<div class="col-md-2">Email</div>';
echo '<div class="col-md-3">Company</div>';
echo '<div class="col-md-2">Company Web</div>';
echo '</div>';

$qd = "SELECT * FROM v4_AuthUsers WHERE AuthLevelID = 2";
if ($country) $qd .= " AND CountryName = '$country'";
$qd .= " ORDER BY AuthUserRealName ASC";

$wd = $db->RunQuery($qd);

while ($au = $wd->fetch_object()) {
	echo '<hr><div class="row">';
	echo '<div class="col-md-3">' . $au->AuthUserRealName . '</div>';
	echo '<div class="col-md-2">' . $au->AuthUserName . '</div>';
	echo '<div class="col-md-2">' . $au->AuthUserMail . '</div>';
	echo '<div class="col-md-3">' . $au->AuthUserCompany . '</div>';
	echo '<div class="col-md-2">' . $au->AuthUserCompanyWeb . '</div>';

	$csv->addRow(array(
		$au->AuthUserRealName,
		$au->AuthUserName,
		$au->AuthUserMail,
		$au->AuthUserCompany,
		$au->AuthUserCompanyWeb
	));

	echo '</div>';
}

$csv->save();

echo '<hr><h4>Exported to CSV!</h4>';

echo '<a href="'.$csv->File.$csv->Extension.'" class="btn btn-default"><i class="fa fa-download"></i> Download CSV</a><br>';
echo 'You can download CSV file here (or Right-Click->Save). <br>';
echo '<b>File format:</b> UTF-8, semi-colon (;) delimited<br>';

echo '</div>';
?>

<script>
$(function(){
	$('#CountryName').on('change', function () {
		var country = $(this).val();
		if (country) {
			window.location = "<?= $pageurl ?>" + "&country=" + country; // redirect
		}
		return false;
	});
});
</script>

