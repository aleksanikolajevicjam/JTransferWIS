<?
//error_reporting(E_PARSE);
if ((isset($_SESSION['UseDriverID']) && $_SESSION['UseDriverID']>0) || $_SESSION['AuthLevelID']==31) {
require_once ROOT . '/f/f.php';


$dashboardFilter = '';
$titleAddOn = '';
$SAuthUserID = $_SESSION['AuthUserID'];

require_once ROOT . '/cms/fixDriverID.php';
foreach($fakeDrivers as $key => $fakeDriverID) {
    if($SAuthUserID == $fakeDriverID) $SAuthUserID = $realDrivers[$key];   
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
	<h1><?= DATE_SETTINGS?> <?= $titleAddOn ?></h1>
	<a class="btn btn-primary btn-xs" href="index.php?p=new_v4_OffDuty"><?= NNEW ?></a>
	<br><br>
		
	<input type="hidden"  id="whereCondition" name="whereCondition" 
	value=" WHERE OwnerID = <?= $SAuthUserID ?> <?= $dashboardFilter ?>">
	
	<div class="row">
		<div class="col-md-3 pad1em" id="infoShow"></div>
		<div class="col-md-2">
			<i class="fa fa-eye"></i>
			<select id="length" class="w75" onchange="all_v4_OffDutyFilter();">
				<option value="5"> 5 </option>
				<option value="10" selected> 10 </option>
				<option value="20"> 20 </option>
				<option value="50"> 50 </option>
				<option value="100"> 100 </option>
			</select>
		</div>

		<div class="col-md-3">
			<i class="fa fa-text-width"></i>
			<input type="text" id="Search" class=" w75" onkeyup="all_v4_OffDutyFilter();">
		</div>

		<div class="col-md-4">
			
			<i class="fa fa-sort-amount-asc"></i> 
			<select name="sortOrder" id="sortOrder" onchange="all_v4_OffDutyFilter();">
				<option value="ASC"> <?= ASCENDING ?> </option>
				<option value="DESC" selected="selected"> <?= DESCENDING ?> </option>
			</select>
			
		</div>
	
	</div>

	<div id="show_v4_OffDuty"><?= THERE_ARE_NO . DATA ?></div>
	
	<? 
		// inList razlikuje je li direktan poziv Edit transfera (npr. iz dashboarda)
		// ili ide preko liste svih transfera
		// ako je iz liste, onda je true
		$inList = true;
		define("READ_ONLY_FLD", '');
		// Poziva se template za Listu i za Edit transfera
		// koristi handlebars

		require_once $modulesPath .'/v4_OffDuty/v4_OffDutyListTemplate.Driver.php'; 
		require_once $modulesPath .'/v4_OffDuty/v4_OffDutyEditForm.Driver.php'; 
	?>
	<br>
	<div id="pageSelect" class="col-sm-12"></div>
	<br><br><br><br>
</div>

<? require_once $modulesPath.'/v4_OffDuty/v4_OffDuty_JS.php' ?>	

<script type="text/javascript">
	$(document).ready(function(){
		$(".datepicker").pickadate({format:'yyyy-mm-dd'});
		all_v4_OffDuty(); // definirano u v4_OffDuty_JS.php
	});

	function all_v4_OffDutyFilter() {
		all_v4_OffDuty(); // definirano u v4_OffDuty_JS.php
	}
</script>	
<?
}
else {
?>
<div class="container">
	<h1>You have to set as a driver!</h1>
</div>
<?
}	
