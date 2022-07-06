<?
require_once ROOTPATH.'/f/f.php';
require_once '../db/db.class.php';

$SOwnerID = $_SESSION['OwnerID'];

// FRANCUSKA FIX
$fakeDriverFound = false;
require_once ROOT . '/cms/fixDriverID.php';
foreach($fakeDrivers as $key => $fakeDriverID) {
    if($SOwnerID == $fakeDriverID) {
        $fakeDriverFound = true;
        $SOwnerID = $realDrivers[$key];
    }
}


$q = "SELECT AuthUserID, AuthUserRealName FROM v4_AuthUsers";
$q .= " WHERE DriverID = ".$SOwnerID." AND Active = '1' ORDER BY AuthUserRealName ASC";
$r = $db->RunQuery($q);

$driverArr = array();
while($e = $r->fetch_object()) { $driverArr[] = $e; }
?>

<style>
	input, select { width: 200px; }
	#RequiredFrom, #RequiredTo { visibility: hidden; padding-left: 4px; color: red; }
	.formLabel { width: 100px; display: inline-block; }
</style>

<div class="container">
	<h1><?= TRANSFER_LIST ?></h1><br><br>

	<form action="index.php?p=timetable" method="post" onsubmit="return validate()">
		<div class="formLabel"><?= FROM ?>:</div> 
		<input id="DateFrom" class="datepicker" name="DateFrom">
		<span id="RequiredFrom"><?= REQUIRED ?></span><br>

		<div class="formLabel"><?= TO ?>:</div>
		<input id="DateTo" class="datepicker" name="DateTo">
		<span id="RequiredTo"><?= REQUIRED ?></span><br>

		<input type="button" class="btn btn-primary" value="Today" style="margin-left: 105px" onclick="setToday()"><br><br>

		<div class="formLabel"><?= DRIVER ?>:</div>
		<select name="SubDriverID">
		{{#select DriverID}}
			<option value="0" selected> --- </option>
			<?
			foreach ($driverArr as $driver) {
				echo '<option value="'.$driver->AuthUserID.'">';
				echo $driver->AuthUserRealName.'</option>';
			}
			?>
		{{/select}}
		</select>
		<br><br>

		<input type="hidden" name="SortSubDriver" id="SortSubDriver" value="0">
		<input type="submit" class="btn btn-primary" name="submit"
		value="<?= SHOW_TRANSFERS ?>" style="margin-left: 105px">
	</form>
</div>

<script>
$(document).ready(function(){
	$(".datepicker").pickadate({format:'yyyy-mm-dd'});
});

function setToday() {
	var d = new Date();
	var DateFrom = document.getElementById("DateFrom");
	var DateTo = document.getElementById("DateTo");
	var month = '' + (d.getMonth()+1);
	var day = '' + d.getDate();

	if (month.length < 2) month = '0' + month;
	if (day.length < 2) day = '0' + day;
	DateFrom.value = d.getFullYear() + "-" + month + "-" + day;
	DateTo.value = d.getFullYear() + "-" + month + "-" + day;
}

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

