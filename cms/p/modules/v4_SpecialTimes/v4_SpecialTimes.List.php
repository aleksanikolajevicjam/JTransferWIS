<?
//error_reporting(E_PARSE);

require_once ROOTPATH.'/f/f.php';


$dashboardFilter = '';
$titleAddOn = '';
$SOwnerID = $_SESSION['OwnerID'];

require_once ROOT . '/cms/fixDriverID.php';
foreach($fakeDrivers as $key => $fakeDriverID) {
    if($SOwnerID == $fakeDriverID) $SOwnerID = $realDrivers[$key];   
}

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
	<h1>Specially Priced Times <?= $titleAddOn ?></h1>
	<a class="btn btn-primary btn-xs" href="index.php?p=newSpecialTimes"><?= NNEW ?></a>
	<br><br>
		
	<input type="hidden"  id="whereCondition" name="whereCondition"   
	value=" WHERE OwnerID = '<?= $SOwnerID ?>' <?= $dashboardFilter ?>">
	
	<div class="row pad1em" id="searchRow">
		<div class="col-md-3" id="infoShow"></div>

	<!-- EXAMPLE !!!
		<div class="col-md-2">
			<i class="fa fa-list-ul"></i>
			<select id="UserLevel" class="w75" onchange="all_v4_SpecialTimesFilter();">
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
			<select id="length" class="w75" onchange="all_v4_SpecialTimesFilter();">
				<option value="5"> 5 </option>
				<option value="10" selected> 10 </option>
				<option value="20"> 20 </option>
				<option value="50"> 50 </option>
				<option value="100"> 100 </option>
			</select>
		</div>

		<div class="col-md-3">
			<i class="fa fa-text-width"></i>
			<input type="text" id="Search" class=" w75" onkeyup="all_v4_SpecialTimesFilter();">
		</div>

		<div class="col-md-3">
			
			<i class="fa fa-sort-amount-asc"></i> 
			<select name="sortOrder" id="sortOrder" onchange="all_v4_SpecialTimesFilter();">
				<option value="ASC" selected="selected"> <?= ASCENDING ?> </option>
				<option value="DESC"> <?= DESCENDING ?> </option>
			</select>
			
		</div>
	
	</div>

	<div id="show_v4_SpecialTimes"><?= THERE_ARE_NO . DATA ?></div>
	
	<? 
		// inList razlikuje je li direktan poziv Edit transfera (npr. iz dashboarda)
		// ili ide preko liste svih transfera
		// ako je iz liste, onda je true
		$inList = true;
		define("READ_ONLY_FLD", '');
		// Poziva se template za Listu i za Edit transfera
		// koristi handlebars
		//require_once $modulesPath .'/v4_SpecialTimes/v4_SpecialTimesListTemplate.'.$_SESSION['GroupProfile'].'.php'; 
		//require_once $modulesPath .'/v4_SpecialTimes/v4_SpecialTimesEditForm.'.$_SESSION['GroupProfile'].'.php'; 
		require_once $modulesPath .'/v4_SpecialTimes/v4_SpecialTimesListTemplate.Driver.php'; 
		require_once $modulesPath .'/v4_SpecialTimes/v4_SpecialTimesEditForm.Driver.php'; 
		
	?>
	<br>
	<div id="pageSelect" class="col-md-12"></div>
	<br><br><br><br>
</div>

<? require_once ROOTPATH.'/p/modules/v4_SpecialTimes/v4_SpecialTimes_JS.php' ?>	

<script type="text/javascript">
	$(document).ready(function(){
		$(".datepicker").pickadate({format:'yyyy-mm-dd'});
		all_v4_SpecialTimes(); // definirano u v4_SpecialTimes_JS.php
	});

	function all_v4_SpecialTimesFilter() {
		all_v4_SpecialTimes(); // definirano u v4_SpecialTimes_JS.php
	}
</script>	
	
