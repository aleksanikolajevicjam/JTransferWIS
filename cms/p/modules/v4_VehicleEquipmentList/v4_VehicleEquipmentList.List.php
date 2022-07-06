<?
error_reporting(E_PARSE);
require_once ROOTPATH.'/f/f.php';
require_once '../db/db.class.php';
require_once '../db/v4_SubVehicles.class.php';
$vh = new v4_SubVehicles();

//akcije-troskovi

$dashboardFilter = '';
//FR fix
$SOwnerID = $_SESSION["OwnerID"];
$VehicleID=$_REQUEST['VehicleID'];
$vh->getRow($VehicleID);
require_once ROOT . '/cms/fixDriverID.php';
foreach($fakeDrivers as $key => $fakeListID) {
    if($_SESSION['AuthUserID'] == $fakeListID) $SOwnerID = $realDrivers[$key];
}

?>
<div class="container">
	<h1>Vehicle equipment lists - <?= $vh->VehicleDescription ?></h1>
	<a class="btn btn-primary btn-xs" href="index.php?p=new_v4_VehicleEquipmentList&VehicleID=<?= $VehicleID ?>"><?= NNEW ?></a>
	<br><br>
		
	<input type="hidden"  id="VehicleID" name="VehicleID" 
	value="<?= $_REQUEST['VehicleID'] ?>">

	<div id="show_v4_VehicleEquipmentList"><?= THERE_ARE_NO . DATA ?></div>
	
	<? 
		// inList razlikuje je li direktan poziv Edit transfera (npr. iz dashboarda)
		// ili ide preko liste svih transfera
		// ako je iz liste, onda je true
		$inList = true;
		define("READ_ONLY_FLD", '');
		// Poziva se template za Listu i za Edit transfera
		// koristi handlebars 
		require_once $modulesPath .'/v4_VehicleEquipmentList/v4_VehicleEquipmentListListTemplate.'.$_SESSION['GroupProfile'].'.php'; 		
		require_once $modulesPath .'/v4_VehicleEquipmentList/v4_VehicleEquipmentListEditForm.'.$_SESSION['GroupProfile'].'.php'; 
	?>
	<br>
	<div id="pageSelect" class="col-md-12"></div>
	<br><br><br><br>
</div>

<? require_once ROOTPATH.'/p/modules/v4_VehicleEquipmentList/v4_VehicleEquipmentList_JS.php' ?>	
<script type="text/javascript">
	$(document).ready(function(){
		$(".datepicker").pickadate({format:'yyyy-mm-dd'});

		all_v4_VehicleEquipmentList(); // definirano u v4_VehicleEquipmentList_JS.php
	});

	function all_v4_VehicleEquipmentListFilter() {
		all_v4_VehicleEquipmentList(); // definirano u v4_VehicleEquipmentList_JS.php
	}
</script>	

