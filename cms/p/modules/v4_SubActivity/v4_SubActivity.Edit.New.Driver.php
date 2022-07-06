<?
require_once '../db/db.class.php';
//akcije-troskovi
require_once '../db/v4_Actions.class.php';
$ac = new v4_Actions();
$ack = $ac->getKeysBy('DisplayOrder ', '');
foreach ($ack as $nn => $key)
{
	$ac->getRow($key);
	$opis[$key]=$ac->getTitle();		
}
$db = new DataBaseMysql();
$q = "SELECT DISTINCT Expense FROM v4_SubActivity WHERE Approved <9 AND OwnerID = ".$_SESSION["OwnerID"]." ORDER BY Expense ASC";
$r = $db->RunQuery($q);
$expenseArr = array();
while($e = $r->fetch_object()) {
	$expenseArr[] = $e->Expense;
}

$q = "SELECT AuthUserID, AuthUserRealName FROM v4_AuthUsers WHERE AuthLevelID = 32 AND DriverID = ".$_SESSION["OwnerID"]." ORDER BY AuthUserRealName ASC";
$r = $db->RunQuery($q);
$driverArr = array();
while($e = $r->fetch_object()) {
	$driverArr[] = $e;
}

$q = "SELECT VehicleID, VehicleDescription FROM v4_SubVehicles WHERE OwnerID = ".$SOwnerID." ORDER BY VehicleDescription ASC";
$r = $db->RunQuery($q);
$vehicleArr = array();
while($e = $r->fetch_object()) {
	$vehicleArr[] = $e;
}
?>

<div id="v4_SubActivityWrapperNew" class="editFrame container" style="display:none">
	<div id="inlineContentNew" class="row">
		<div id="new_v4_SubActivity">
			
		</div>
	</div>
</div>

<?
	define("READ_ONLY_FLD","");
	$isNew = true;
	require_once 'p/modules/v4_SubActivity/v4_SubActivityEditForm.Driver.php';	
	require_once 'p/modules/v4_SubActivity/v4_SubActivity_JS.php';

?>

<script>
	new_v4_SubActivity();
</script>

