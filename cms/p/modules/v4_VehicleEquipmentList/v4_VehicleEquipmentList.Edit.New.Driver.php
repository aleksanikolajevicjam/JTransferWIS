<?

require_once '../db/db.class.php';
$db = new DataBaseMysql();

?>

<div id="v4_VehicleEquipmentListWrapperNew" class="editFrame container" style="display:none">
	<div id="inlineContentNew" class="row">
		<div id="new_v4_VehicleEquipmentList">
			
		</div>
	</div>
</div>

<?
	define("READ_ONLY_FLD","");

	$isNew = true;
	$VehicleID=$_REQUEST['VehicleID'];
	require_once '../db/v4_SubVehicles.class.php';
	$vh = new v4_SubVehicles();
	$vh->getRow($VehicleID);
	
	require_once 'p/modules/v4_VehicleEquipmentList/v4_VehicleEquipmentListEditForm.Driver.php';	
	require_once 'p/modules/v4_VehicleEquipmentList/v4_VehicleEquipmentList_JS.php';

?>

<script>
	new_v4_VehicleEquipmentList();
</script>

