<?
//error_reporting(E_PARSE);
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

$dashboardFilter = '';
$titleAddOn = '';
//FR fix
$SOwnerID = $_SESSION["OwnerID"];

require_once $_SERVER['DOCUMENT_ROOT'] . '/cms/fixDriverID.php';
foreach($fakeDrivers as $key => $fakeDriverID) {
    if($_SESSION['AuthUserID'] == $fakeDriverID) $SOwnerID = $realDrivers[$key];
}

$db = new DataBaseMysql();
$q = "SELECT DISTINCT Expense FROM v4_SubActivity WHERE Approved<9 AND OwnerID = ".$SOwnerID." ORDER BY Expense ASC";
$r = $db->RunQuery($q);
$expenseArr = array();
while($e = $r->fetch_object()) {
	$expenseArr[] = $e->Expense;
}

$q = "SELECT AuthUserID, AuthUserRealName FROM v4_AuthUsers WHERE AuthLevelID = 32 AND DriverID = ".$SOwnerID." ORDER BY AuthUserRealName ASC";
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

if (isset($_REQUEST['DateFrom']) && $_REQUEST['DateFrom'] != null) {
	$addFilter .= " AND Datum >=  '" .$_REQUEST['DateFrom'] ."'";
}

if (isset($_REQUEST['DateTo']) && $_REQUEST['DateTo'] != null) {
	$addFilter .= " AND Datum <=  '" .$_REQUEST['DateTo'] ."'";
}

if (isset($_REQUEST['actionID']) && $_REQUEST['actionID']>0) {
	$addFilter .= " AND Expense = " .$_REQUEST['actionID'] ;
}

if (isset($_REQUEST['SubDriverID']) && $_REQUEST['SubDriverID']>0) {
	$addFilter .= " AND v4_SubActivity.DriverID = " .$_REQUEST['SubDriverID'] ;
}

if (isset($_REQUEST['VehicleID']) && $_REQUEST['VehicleID']>0) {
	$addFilter .= " AND v4_SubActivity.VehicleID = " .$_REQUEST['VehicleID'] ;
}

if (isset($_REQUEST['card'])) $addFilter .= ' AND Card = 0';
if (isset($_REQUEST['approved'])) $addFilter .= ' AND Approved = 1';

?>
<div class="container">
	<h1><?= ACTIVITIES ?> <?= $titleAddOn ?></h1>
	<a class="btn btn-primary btn-xs" href="index.php?p=new_v4_SubActivity"><?= NNEW ?></a>
	<br><br>
		
	<input type="hidden"  id="whereCondition" name="whereCondition" 
	value=" WHERE ID > 0 AND Approved<9 AND v4_SubActivity.OwnerID = <?= $SOwnerID ?> <?= $addFilter ?>">
	
	<div class="row pad1em" id="searchRow">
		<div class="col-md-3" id="infoShow"></div>

	<!-- EXAMPLE !!!
		<div class="col-md-2">
			<i class="fa fa-list-ul"></i>
			<select id="UserLevel" class="w75" onchange="all_v4_SubActivityFilter();">
				<option value="0"> All </option>
				<?
				foreach($AuthLevels as $val => $text) {
					echo  '<option value="'.$val.'"> ' . $text . '</option>';
				}		
				?>
			</select>
		</div>
	-->
		<div class="col-md-3">
			<i class="fa fa-eye"></i>
			<select id="length" class="w75" onchange="all_v4_SubActivityFilter();">
				<option value="5"> 5 </option>
				<option value="10" selected> 10 </option>
				<option value="20"> 20 </option>
				<option value="50"> 50 </option>
				<option value="100"> 100 </option>
			</select>
		</div>

		<div class="col-md-3">
			<i class="fa fa-text-width"></i>
			<input type="text" id="Search" class=" w75" onkeyup="all_v4_SubActivityFilter();">
		</div>

		<div class="col-md-3">
			
			<i class="fa fa-sort-amount-asc"></i> 
			<select name="sortOrder" id="sortOrder" onchange="all_v4_SubActivityFilter();">
				<option value="ASC"> <?= ASCENDING ?> </option>
				<option value="DESC" selected="selected"> <?= DESCENDING ?> </option>
			</select>
			
		</div>
	
	</div>

	<div id="show_v4_SubActivity"><?= THERE_ARE_NO . DATA ?></div>
	
	<? 
		// inList razlikuje je li direktan poziv Edit transfera (npr. iz dashboarda)
		// ili ide preko liste svih transfera
		// ako je iz liste, onda je true
		$inList = true;
		define("READ_ONLY_FLD", '');
		// Poziva se template za Listu i za Edit transfera
		// koristi handlebars
		require_once $modulesPath .'/v4_SubActivity/v4_SubActivityListTemplate.'.$_SESSION['GroupProfile'].'.php'; 
		require_once $modulesPath .'/v4_SubActivity/v4_SubActivityEditForm.'.$_SESSION['GroupProfile'].'.php'; 
	?>
	<br>
	<div id="pageSelect" class="col-md-12"></div>
	<br><br><br><br>
</div>

<? require_once ROOTPATH.'/p/modules/v4_SubActivity/v4_SubActivity_JS.php' ?>	

<script type="text/javascript">
	$(document).ready(function(){
		$(".datepicker").pickadate({format:'yyyy-mm-dd'});
		all_v4_SubActivity(); // definirano u v4_SubActivity_JS.php
	});

	function all_v4_SubActivityFilter() {
		all_v4_SubActivity(); // definirano u v4_SubActivity_JS.php
	}
</script>	

