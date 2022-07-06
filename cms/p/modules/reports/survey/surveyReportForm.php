<?
require_once ROOTPATH.'/f/f.php';
require_once '../db/db.class.php';

$q = 'SELECT * FROM v4_Routes ORDER BY RouteNameEN';
$r = $db->RunQuery($q);
$userArr = array();
while($e = $r->fetch_object()) { $userArr[] = $e; }
?>

<style>
	input, select { width: 200px; }
	#RequiredFrom, #RequiredTo { visibility: hidden; padding-left: 4px; color: red; }
	.formLabel { width: 100px; display: inline-block; }
</style>

<div class="container">
	<h1><?= SURVEY_REPORT ?></h1><br><br>

	<form action="index.php?p=surveyReport" method="post">
		<div class="formLabel"><?= FROM ?>:</div> 
		<input id="DateFrom" class="datepicker" name="DateFrom">
		<span id="RequiredFrom"><?= REQUIRED ?></span><br>

		<div class="formLabel"><?= TO ?>:</div>
		<input id="DateTo" class="datepicker" name="DateTo">
		<span id="RequiredTo"><?= REQUIRED ?></span><br><br>

		<div class="formLabel">Route:</div>
		<select name="routeID">
			<option value="0">All</option>
			{{#select RouteID}}
				<?
				foreach ($userArr as $userLvl) {
					echo '<option value="'.$userLvl->RouteID.'">';
					echo $userLvl->RouteNameEN.'</option>';
				}
				?>
			{{/select}}
		</select>

		<br>
		<div class="formLabel">Approved:</div>
		<select name="approved">
			<option value="3" selected> All
			<option value="1"> Approved
			<option value="0"> Not approved
			<option value="2"> Discarded
		</select>

		<br><br><input type="checkbox" name="hasComment" style="height:1.5em;width:50px"> Has comment

		<br><br><br>
		<input type="submit" class="btn btn-primary" name="submit"
		value="<?= SHOW_REVIEWS ?>" style="margin-left: 105px">
	</form>
</div>

<script>
$(document).ready(function(){
	$(".datepicker").pickadate({format:'yyyy-mm-dd'});
});

</script>
<script src="js/cms.jquery.js"></script>

