
	<?
//error_reporting(E_PARSE);

require_once ROOT.'/f/f.php';


$dashboardFilter = '';
$titleAddOn = '';

/* EXAMPLE !!!!

if ($_REQUEST['usersFilter'] == 'notConfirmed') {
	$dashboardFilter = " AND DriverConfStatus ='1'";
	$titleAddOn = '- Not Confirmed';
}

if ($_REQUEST['transfersFilter'] == 'confirmed') {
	$dashboardFilter = " AND DriverConfStatus ='2'";
	$titleAddOn = '- Confirmed';
}

if ($_REQUEST['transfersFilter'] == 'noDriver') {
	$dashboardFilter = " AND DriverConfStatus ='0' ";
	$titleAddOn = '- No Driver';
}

if ( isset($_COOKIE['dateFilterCookie']) ) $filterDate = $_COOKIE['dateFilterCookie'];
else $filterDate = date("Y-m-d");
if ( isset($_REQUEST['transfersFilter']) ) $filterDate = '';

*/

?>
<div class=" container-fluid">
	<h1><?= DAY_SETTINGS ?></h1>
	<a class="btn btn-primary btn-xs" href="index.php?p=daySettingsNew"><?= NNEW ?></a>
	<br><br>
		
	<input type="hidden"  id="whereCondition" name="whereCondition" 
	value=" WHERE ID > 0 <?= $dashboardFilter ?>">
	
	<div class="row">
		<div class="col-sm-12 white pad1em" id="infoShow"></div>
	</div>
	<div class="row pad4px white"">

		<div class="col-sm-2">
			<i class="fa fa-eye"></i>
			<select id="length" class="w75" onchange="all_v4_DaySettingsFilter();">
				<option value="5"> 5 </option>
				<option value="10" selected> 10 </option>
				<option value="20"> 20 </option>
				<option value="50"> 50 </option>
				<option value="100"> 100 </option>
			</select>
		</div>

		<div class="col-sm-3">
			<i class="fa fa-text-width"></i>
			<input type="text" id="Search" class=" w75" onkeyup="all_v4_DaySettingsFilter();">
		</div>

		<div class="col-sm-4">
			
			<i class="fa fa-sort-amount-asc"></i> 
			<select name="sortOrder" id="sortOrder" onchange="all_v4_DaySettingsFilter();">
				<option value="ASC" selected="selected"> <?= ASCENDING ?> </option>
				<option value="DESC"> <?= DESCENDING ?> </option>
			</select>
			
		</div>
	
	</div>

	<div id="show_v4_DaySettings"><?= THERE_ARE_NO . DATA ?></div>
	
	<? 
		// inList razlikuje je li direktan poziv Edit transfera (npr. iz dashboarda)
		// ili ide preko liste svih transfera
		// ako je iz liste, onda je true
		$inList = true;
		define("READ_ONLY_FLD", '');
		// Poziva se template za Listu i za Edit transfera
		// koristi handlebars
		require_once $modulesPath .'/v4_DaySettings/v4_DaySettingsListTemplate.'.$_SESSION['GroupProfile'].'.php'; 
		require_once $modulesPath .'/v4_DaySettings/v4_DaySettingsEditForm.'.$_SESSION['GroupProfile'].'.php'; 
	?>
	<br>
	<div id="pageSelect" class="col-sm-12"></div>
	<br><br><br><br>
</div>

<? require_once ROOTPATH.'/p/modules/v4_DaySettings/v4_DaySettings_JS.php' ?>	

<script type="text/javascript">
	$(document).ready(function(){
		$(".datepicker").pickadate({format:'yyyy-mm-dd'});
		all_v4_DaySettings(); // definirano u v4_DaySettings_JS.php
	});

	function all_v4_DaySettingsFilter() {
		all_v4_DaySettings(); // definirano u v4_DaySettings_JS.php
	}
</script>	
	
