<?
require_once ROOTPATH.'/f/f.php';
require_once '../db/db.class.php';

//akcije-troskovi
require_once '../db/v4_Actions.class.php';
$ac = new v4_Actions();
$ack = $ac->getKeysBy('DisplayOrder ', '','WHERE Active=1');
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

$q = 'SELECT DISTINCT Expense FROM v4_SubExpenses WHERE Approved<9 AND OwnerID = '.$_SESSION["OwnerID"].' ORDER BY Expense ASC';
$r = $db->RunQuery($q);
$expenseArr = array();
while($s = $r->fetch_object()) {
	$expenseArr[] = $s;
}
?>

<div class="container">

	<form action="index.php?p=expensesReport" method="POST">
		<h1><?= EXPENSES_REPORT ?></h1><br>

		<div style="width:100px;display:inline-block"><?= FROM ?>: </div> 
		<input class="datepicker" name="DateFrom"><br>

		<div style="width:100px;display:inline-block"><?= TO ?>: </div> 
		<input class="datepicker" name="DateTo"><br><br>

		<div style="width:100px;display:inline-block"><?= DRIVER ?>:</div>
		<select name="SubDriverID">
		{{#select AuthUserID}}
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
		<div class='row'>
			<div class="col-md-6">
				<?
				foreach ($opis as $expenseID => $expense) {
					echo '<div style="height:2em">';
					echo '<input type="checkbox" name="expenses[]" style="height: 0.8em"';
					echo ' value="'.$expenseID.'" > ';
					echo $expense.'</div>';
				}
				?>
				<br>
				<!--<select name="actionID">
					<option value="0" selected> All </option>
						<?
						foreach ($opis as $expenseID => $expense) {
							echo '<option value="'.$expenseID.'">';
							echo $expense.'</option>';
						}
						?>
				</select>!-->
			</div>	
			<div class="col-md-6">			
				<div style="height:2em">
					<input type="checkbox" name="card" style="height: 0.8em" value="" checked> Cash
				</div>

				<div style="height:2em">
					<input type="checkbox" name="approved" style="height: 0.8em" value="" > Approved
				</div>
				
				<div style="height:2em">
					<input type="checkbox" name="unapproved" style="height: 0.8em" value="" > Unapproved
				</div>				
			</div>
		</div>
		<input class="btn btn-primary" type="submit" value="<?= SHOW_EXPENSES ?>" name="submit">
	</form>

</div>

<script>
$(document).ready(function(){
	$(".datepicker").pickadate({format:'yyyy-mm-dd'});
});
</script>

