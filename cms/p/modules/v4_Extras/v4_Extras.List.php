
	<?
//error_reporting(E_PARSE);

require_once ROOT.'/f/f.php';


$dashboardFilter = '';

if($_SESSION['AuthLevelID'] == DRIVER_USER) $dashboardFilter = ' AND OwnerID = ' . $_SESSION['AuthUserID'];

require_once ROOT . '/cms/fixDriverID.php';
foreach($fakeDrivers as $key => $fakeDriverID) {
    if($_SESSION['AuthUserID'] == $fakeDriverID) $dashboardFilter = " AND OwnerID = '".$realDrivers[$key]."'";   
}

?>
<div class=" container">
	<h1><?= EXTRAS ?></h1>
	<? if ($_SESSION["AuthLevelID"] != TRANSLATOR_USER && ((isset($_SESSION['UseDriverID']) && $_SESSION['UseDriverID']>0) || $_SESSION['AuthLevelID']==31)) { ?>
	<a class="btn btn-primary btn-xs" href="index.php?p=new_v4_Extras"><?= NNEW ?></a>
	<? } ?>
	<br><br>
		
	<input type="hidden"  id="whereCondition" name="whereCondition" 
	value=" WHERE ID > 0 <?= $dashboardFilter ?>">
	
	<div class="row pad1em">
		<div class="col-md-3" id="infoShow"></div>

		<div class="col-md-2">
			<i class="fa fa-eye"></i>
			<select id="length" class="w75" onchange="all_v4_ExtrasFilter();">
				<option value="5"> 5 </option>
				<option value="10" selected> 10 </option>
				<option value="20"> 20 </option>
				<option value="50"> 50 </option>
				<option value="100"> 100 </option>
			</select>
		</div>

		<div class="col-md-3">
			<i class="fa fa-text-width"></i>
			<input type="text" id="Search" class=" w75" onkeyup="all_v4_ExtrasFilter();">
		</div>

		<div class="col-md-4">
			
			<i class="fa fa-sort-amount-asc"></i> 
			<select name="sortOrder" id="sortOrder" onchange="all_v4_ExtrasFilter();">
				<option value="ASC" selected="selected"> <?= ASCENDING ?> </option>
				<option value="DESC"> <?= DESCENDING ?> </option>
			</select>
			
		</div>
	
	</div>

	<div id="show_v4_Extras"><?= THERE_ARE_NO_DATA ?></div>
	
	<? 
		// inList razlikuje je li direktan poziv Edit transfera (npr. iz dashboarda)
		// ili ide preko liste svih transfera
		// ako je iz liste, onda je true
		$inList = true;
		define("READ_ONLY_FLD", '');
		// Poziva se template za Listu i za Edit transfera
		// koristi handlebars
		require_once $modulesPath .'/v4_Extras/v4_ExtrasListTemplate.'.$_SESSION['GroupProfile'].'.php'; 
		require_once $modulesPath .'/v4_Extras/v4_ExtrasEditForm.'.$_SESSION['GroupProfile'].'.php'; 
	?>
	<br>
	<div id="pageSelect" class="col-sm-12"></div>
	<br><br><br><br>
</div>

<? require_once ROOTPATH.'/p/modules/v4_Extras/v4_Extras_JS.php' ?>	

<script type="text/javascript">
	$(document).ready(function(){
		$(".datepicker").pickadate({format:'yyyy-mm-dd'});
		all_v4_Extras(); // definirano u v4_Extras_JS.php
	});

	function all_v4_ExtrasFilter() {
		all_v4_Extras(); // definirano u v4_Extras_JS.php
	}
</script>
