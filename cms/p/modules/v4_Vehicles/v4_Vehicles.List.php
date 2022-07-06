<?
//error_reporting(E_PARSE);

require_once ROOT.'/f/f.php';


$dashboardFilter = '';
$titleAddOn = '';

$driver = false;

if ($_SESSION['AuthLevelID'] == DRIVER_USER) {
//	$dashboardFilter = " AND OwnerID = '".$_SESSION['AuthUserID']."' ";
	$driver = true;
}

require_once ROOT . '/cms/fixDriverID.php';
foreach($fakeDrivers as $key => $fakeDriverID) {
    if($_SESSION['AuthUserID'] == $fakeDriverID) $dashboardFilter = " AND OwnerID = '".$realDrivers[$key]."'";   
}

?>
<div class="container">
	<h1><?= VEHICLES ?> <?= $titleAddOn ?></h1>
	<? if (isset($_SESSION['UseDriverID']) && $_SESSION['UseDriverID']>0) {?><a class="btn btn-primary btn-xs" href="index.php?p=new_v4_Vehicles"><?= NNEW ?></a><?}?>
	<br><br>
		
	<input type="hidden"  id="whereCondition" name="whereCondition" 
	value=" WHERE VehicleID > 0 <?= $dashboardFilter ?>">
	
	<div class="row pad1em" id="searchRow">
		<div class="col-md-3" id="infoShow"></div>

		<? if ( !$driver ) { ?>
		<div class="col-md-3">
			<i class="fa fa-filter"></i>
			<select name="OwnerID" id="OwnerID"  class="w75" onchange="all_v4_VehiclesFilter();">
				<option value="0"> <?= ALL_DRIVERS ?> </option>
		
				<?
				require_once '../db/v4_AuthUsers.class.php';

				# init class
				$au = new v4_AuthUsers();

				$auk = $au->getKeysBy('AuthUserRealName', 'asc', "WHERE AuthLevelID = 31");

				foreach($auk as $n => $ID) {
	
					$au->getRow($ID);
					echo '<option value="'.$au->getAuthUserID() .'">'.$au->getAuthUserRealName().'</option>';

				}
		
				?>
			</select>
		</div>
		<? } else {?>
			<input type="hidden" name="OwnerID" id="OwnerID" value="<?= s('AuthUserID'); ?>">
		<? } ?>
		
				
		<div class="col-md-2">
			<i class="fa fa-eye"></i>
			<select id="length" class="w75" onchange="all_v4_VehiclesFilter();">
				<option value="5"> 5 </option>
				<option value="10" selected> 10 </option>
				<option value="20"> 20 </option>
				<option value="50"> 50 </option>
				<option value="100"> 100 </option>
			</select>
		</div>

		<div class="col-md-2">
			<i class="fa fa-text-width"></i>
			<input type="text" id="Search" class=" w75" onchange="all_v4_VehiclesFilter();" placeholder="Text + Enter to Search">
		</div>

		<div class="col-md-2">
			
			<i class="fa fa-sort-amount-asc"></i> 
			<select class="w75" name="sortOrder" id="sortOrder" onchange="all_v4_VehiclesFilter();">
				<option value="ASC" selected="selected"> <?= ASCENDING ?> </option>
				<option value="DESC"> <?= DESCENDING ?> </option>
			</select>
			
		</div>
	
	</div>

	<div id="show_v4_Vehicles"><?= THERE_ARE_NO . DATA ?></div>
	
	<? 
		// inList razlikuje je li direktan poziv Edit transfera (npr. iz dashboarda)
		// ili ide preko liste svih transfera
		// ako je iz liste, onda je true
		$inList = true;
		define("READ_ONLY_FLD", '');
		// Poziva se template za Listu i za Edit transfera
		// koristi handlebars
		require_once $modulesPath .'/v4_Vehicles/v4_VehiclesListTemplate.'.$_SESSION['GroupProfile'].'.php'; 
		require_once $modulesPath .'/v4_Vehicles/v4_VehiclesEditForm.'.$_SESSION['GroupProfile'].'.php'; 
	?>
	<br>
	<div id="pageSelect" class="col-md-12"></div>
	<br><br><br><br>
</div>

<? require_once ROOTPATH.'/p/modules/v4_Vehicles/v4_Vehicles_JS.php' ?>	

<script type="text/javascript">
	$(document).ready(function(){
		$(".datepicker").pickadate({format:'yyyy-mm-dd'});
		all_v4_Vehicles(); // definirano u v4_Vehicles_JS.php
	});

	function all_v4_VehiclesFilter() {
		all_v4_Vehicles(); // definirano u v4_Vehicles_JS.php
	}
</script>	
	
