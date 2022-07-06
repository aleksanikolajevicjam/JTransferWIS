<?
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once ROOTPATH.'/f/f.php';
require_once '../db/db.class.php';

//akcije-troskovi
require_once '../db/v4_Actions.class.php';
$ac = new v4_Actions();
$ack = $ac->getKeysBy('DisplayOrder ', '','WHERE Active=2');

foreach ($ack as $nn => $key)
{
	$ac->getRow($key);
	$opis[$key]=$ac->getTitle();		
}

$q = "SELECT AuthUserID, AuthUserRealName FROM v4_AuthUsers WHERE AuthLevelID = '32' AND DriverID = '".$_SESSION["OwnerID"]."' ORDER BY AuthUserRealName ASC";
$r = $db->RunQuery($q);
$driverArr = array();
while($e = $r->fetch_object()) {
	$driverArr[] = $e;
}

$q = "SELECT VehicleID, VehicleDescription FROM v4_SubVehicles WHERE OwnerID = '".$_SESSION["OwnerID"]."' ORDER BY VehicleDescription ASC";
$r = $db->RunQuery($q);
$vehicleArr = array();
while($e = $r->fetch_object()) {
	$vehicleArr[] = $e;
}

$q = 'SELECT DISTINCT Expense FROM v4_SubActivity WHERE Approved<9 AND OwnerID = '.$_SESSION["OwnerID"].' ORDER BY Expense ASC';
$r = $db->RunQuery($q);
$expenseArr = array();
while($s = $r->fetch_object()) {
	$expenseArr[] = $s;
}
?>


<div class="container">

	<form action="index.php?p=subactivities" method="POST">
		<h1>Activities</h1>

		<div style="width:100px;display:inline-block"><?= FROM ?>: </div> 
		<input class="datepicker" name="DateFrom"><br>

		<div style="width:100px;display:inline-block"><?= TO ?>: </div> 
		<input class="datepicker" name="DateTo"><br><br>

		<div style="width:100px;display:inline-block"><?= DRIVER ?>:</div>
		<select name="SubDriverID">
			<option value="0" selected> --- </option>
			<?
			foreach ($driverArr as $driver) {
				echo '<option value="'.$driver->AuthUserID.'">';
				echo $driver->AuthUserRealName.'</option>';
			}
			?>
		</select>
		<br><br>
		
		<div style="width:100px;display:inline-block"><?= VEHICLE ?>:</div>
		<select name="VehicleID">
			<option value="0" selected> --- </option>
			<?
			foreach ($vehicleArr as $vehicle) {
				echo '<option value="'.$vehicle->VehicleID.'">';
				echo $vehicle->VehicleDescription.'</option>';
			}
			?>
		</select>
		<br><br>
		<div class='row'>
			<div class="col-md-6">

				<br>
				<select name="actionID">
					<option value="0" selected> All </option>
						<?
						foreach ($opis as $expenseID => $expense) {
							echo '<option value="'.$expenseID.'">';
							echo $expense.'</option>';
						}
						?>
				</select>
			</div>	
		</div>
		<input class="btn btn-primary" type="submit" value="Show activities" name="submit">
	</form>

</div>