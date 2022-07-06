<?
require_once ROOTPATH.'/f/f.php';
require_once '../db/db.class.php';

$q = 'SELECT * FROM v4_AuthLevels ORDER BY AuthLevelID';
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
	<h1><?= CLIENT_EMAIL_LIST ?></h1><br><br>

	<form action="index.php?p=emails" method="post">
		<div class="formLabel">Date by:</div>
		<input type="radio" name="date" value="transfer" style="width:10px;height:1em" checked> Transfer
		<input type="radio" name="date" value="order" style="width:10px;height:1em"> Booking<br>
		<div class="formLabel"><?= FROM ?>:</div> 
		<input id="DateFrom" class="datepicker" name="DateFrom">
		<span id="RequiredFrom"><?= REQUIRED ?></span><br>

		<div class="formLabel"><?= TO ?>:</div>
		<input id="DateTo" class="datepicker" name="DateTo">
		<span id="RequiredTo"><?= REQUIRED ?></span><br><br>

		<div class="formLabel"><?= USER_TYPE ?>:</div>
		<select name="userType">
			<option value="0">All</option>
		{{#select AuthLevelID}}
			<?
			foreach ($userArr as $userLvl) {
				echo '<option value="'.$userLvl->AuthLevelID.'">';
				echo $userLvl->AuthLevelName.'</option>';
			}
			?>
		{{/select}}
		</select><br>

		<input type="checkbox" name="airport" style="height: 1.5em;width: 50px"> Start location airport<br>
		<input type="checkbox" name="completed" style="height: 1.5em;width: 50px"> Only completed transfers<br>
		<input type="checkbox" name="oneway" style="height: 1.5em;width: 50px"> Only one-way transfers<br>
		<br>

		<input type="submit" class="btn btn-primary" name="submit"
		value="<?= SHOW_CLIENTS ?>" style="margin-left: 105px">
	</form>
</div>

<script>
$(document).ready(function(){
	$(".datepicker").pickadate({format:'yyyy-mm-dd'});
});

function validate() {
	var DateFrom = document.getElementById("DateFrom");
	var DateTo = document.getElementById("DateTo");
	var RequiredFrom = document.getElementById("RequiredFrom");
	var RequiredTo = document.getElementById("RequiredTo");
	var error = 0;

	DateFrom.style.borderColor = "#ddd";
	DateTo.style.borderColor = "#ddd";
	RequiredFrom.style.visibility = "hidden";
	RequiredTo.style.visibility = "hidden";
	
	if (DateFrom.value == "") {
		error = 1;
		DateFrom.style.borderColor = "red";
		RequiredFrom.style.visibility = "visible";
	}

	if (DateTo.value == "") {
		error = 1;
		DateTo.style.borderColor = "red";
		RequiredTo.style.visibility = "visible";
	}

	if (error == 1)	return false;
}
</script>
<script src="js/cms.jquery.js"></script>
