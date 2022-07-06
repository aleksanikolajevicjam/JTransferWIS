
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
<div class="container">
	<h1><?= MY_VEHICLES ?> <?= $titleAddOn ?></h1>
	<a class="btn btn-primary btn-xs" href="index.php?p=new_v4_MyVehicles"><?= NNEW ?></a>
	<br><br>
		
	<input type="hidden"  id="whereCondition" name="whereCondition" 
	value=" WHERE OwnerID = <?= s('AuthUserID') ?> <?= $dashboardFilter ?>">
	
	<div class="row pad1em" id="searchRow">
		<div class="col-md-2" id="infoShow"></div>

	<!-- EXAMPLE !!!
		<div class="col-md-2">
			<i class="fa fa-list-ul"></i>
			<select id="UserLevel" class="w75" onchange="all_v4_MyVehiclesFilter();">
				<option value="0"> All </option>
				<?
				foreach($AuthLevels as $val => $text) {
					echo  '<option value="'.$val.'"> ' . $text . '</option>';
				}		
				?>
			</select>
		</div>
	-->
		<div class="col-md-2">
			<i class="fa fa-eye"></i>
			<select id="length" class="w75" onchange="all_v4_MyVehiclesFilter();">
				<option value="5"> 5 </option>
				<option value="10" selected> 10 </option>
				<option value="20"> 20 </option>
				<option value="50"> 50 </option>
				<option value="100"> 100 </option>
			</select>
		</div>

		<div class="col-md-3">
			<i class="fa fa-text-width"></i>
			<input type="text" id="Search" class=" w75" onkeyup="all_v4_MyVehiclesFilter();">
		</div>

		<div class="col-md-3">
			
			<i class="fa fa-sort-amount-asc"></i> 
			<select name="sortOrder" id="sortOrder" onchange="all_v4_MyVehiclesFilter();">
				<option value="ASC" selected="selected"> <?= ASCENDING ?> </option>
				<option value="DESC"> <?= DESCENDING ?> </option>
			</select>
			
		</div>
	
	</div>

	<div id="show_v4_MyVehicles"><?= THERE_ARE_NO . DATA ?></div>
	
	<? 
		// inList razlikuje je li direktan poziv Edit transfera (npr. iz dashboarda)
		// ili ide preko liste svih transfera
		// ako je iz liste, onda je true
		$inList = true;
		define("READ_ONLY_FLD", '');
		// Poziva se template za Listu i za Edit transfera
		// koristi handlebars
		require_once $modulesPath .'/v4_MyVehicles/v4_MyVehiclesListTemplate.'.$_SESSION['GroupProfile'].'.php'; 
		require_once $modulesPath .'/v4_MyVehicles/v4_MyVehiclesEditForm.'.$_SESSION['GroupProfile'].'.php'; 
	?>
	<br>
	<div id="pageSelect" class="col-md-12"></div>
	<br><br><br><br>
</div>

<? require_once ROOTPATH.'/p/modules/v4_MyVehicles/v4_MyVehicles_JS.php' ?>	

<script type="text/javascript">
	$(document).ready(function(){
		$(".datepicker").pickadate({format:'yyyy-mm-dd'});
		all_v4_MyVehicles(); // definirano u v4_MyVehicles_JS.php
	});

	function all_v4_MyVehiclesFilter() {
		all_v4_MyVehicles(); // definirano u v4_MyVehicles_JS.php
	}
</script>	
	
