<?
//error_reporting(E_PARSE);

require_once ROOTPATH.'/f/f.php';
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

$dashboardFilter = '';
$titleAddOn = '';

//FR fix
$SOwnerID = $_SESSION["OwnerID"];

require_once ROOT . '/cms/fixDriverID.php';
foreach($fakeDrivers as $key => $fakeDriverID) {
    if($_SESSION['AuthUserID'] == $fakeDriverID) $SOwnerID = $realDrivers[$key];
}

$db = new DataBaseMysql();
$q = "SELECT DISTINCT Expense FROM v4_SubExpenses WHERE Approved<9 AND OwnerID = ".$SOwnerID." ORDER BY Expense ASC";
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
	$addFilter .= " AND v4_SubExpenses.DriverID = " .$_REQUEST['SubDriverID'] ;
}

if (isset($_REQUEST['VehicleID']) && $_REQUEST['VehicleID']>0) {
	$addFilter .= " AND v4_SubExpenses.VehicleID = " .$_REQUEST['VehicleID'] ;
}
if (isset($_REQUEST['card'])) $addFilter .= ' AND Card = 0';
if (isset($_REQUEST['approved'])) $addFilter .= ' AND Approved = 1';

if (isset($_REQUEST['download'])) {
	$q="SELECT DriverID,Datum,Expense,DocumentImage FROM v4_SubExpenses WHERE DocumentImage <>'' AND ID > 0 AND Approved<9 AND v4_SubExpenses.OwnerID = ". $SOwnerID  . $addFilter ;
	$r = $db->RunQuery($q);
	$downloadArr = array();
	while($e = $r->fetch_object()) {
		$downloadArr[] = $e;
	}
}
?>
<div class="container">
	<h1><?= MY_EXPENSES ?> <?= $titleAddOn ?></h1>
	<a class="btn btn-primary btn-xs" href="index.php?p=new_v4_SubExpenses"><?= NNEW ?></a>
	<br><br>
		
	<input type="hidden"  id="whereCondition" name="whereCondition" 
	value=" WHERE ID > 0 AND Approved<9 AND v4_SubExpenses.OwnerID = <?= $SOwnerID ?> <?= $addFilter ?>">
	
	<div class="row pad1em" id="searchRow">
		<div class="col-md-3" id="infoShow"></div>

	<!-- EXAMPLE !!!
		<div class="col-md-2">
			<i class="fa fa-list-ul"></i>
			<select id="UserLevel" class="w75" onchange="all_v4_SubExpensesFilter();">
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
			<select id="length" class="w75" onchange="all_v4_SubExpensesFilter();">
				<option value="5"> 5 </option>
				<option value="10" selected> 10 </option>
				<option value="20"> 20 </option>
				<option value="50"> 50 </option>
				<option value="100"> 100 </option>
			</select>
		</div>

		<div class="col-md-3">
			<i class="fa fa-text-width"></i>
			<input type="text" id="Search" class=" w75" onkeyup="all_v4_SubExpensesFilter();">
		</div>

		<div class="col-md-3">
			
			<i class="fa fa-sort-amount-asc"></i> 
			<select name="sortOrder" id="sortOrder" onchange="all_v4_SubExpensesFilter();">
				<option value="ASC"> <?= ASCENDING ?> </option>
				<option value="DESC" selected="selected"> <?= DESCENDING ?> </option>
			</select>
			
		</div>
	
	</div>

	<div id="show_v4_SubExpenses"><?= THERE_ARE_NO . DATA ?></div>
	
	<? 
		if (isset($_REQUEST['download'])) {	
			echo "<table><tr><th>Title</th><th>Download <button onclick='downloadall_v4_SubExpenses()'>Download all</button></th></tr>";
			foreach ($downloadArr as $image) {
				$found_key = array_search($image->DriverID, array_column($driverArr, 'AuthUserID'));
				$title=$driverArr[$found_key]->AuthUserRealName." / ";
				$title.=$opis[$image->Expense]." / ";
				$title.=$image->Datum."  ";
				echo "<tr><td>".$title."</td>";
				echo "<td><a class='di' href='".$image->DocumentImage."' download='".$image->DocumentImage."'>".$image->DocumentImage."</a></td></tr>";
			}
			?>
				<script>
					$('#dwnld').click(
				</script>
			<?
		}
		else {
			// inList razlikuje je li direktan poziv Edit transfera (npr. iz dashboarda)
			// ili ide preko liste svih transfera
			// ako je iz liste, onda je true
			$inList = true;
			define("READ_ONLY_FLD", '');
			// Poziva se template za Listu i za Edit transfera
			// koristi handlebars
			require_once $modulesPath .'/v4_SubExpenses/v4_SubExpensesListTemplate.'.$_SESSION['GroupProfile'].'.php'; 
			require_once $modulesPath .'/v4_SubExpenses/v4_SubExpensesEditForm.'.$_SESSION['GroupProfile'].'.php'; 
		}
	?>
	<br>
	<div id="pageSelect" class="col-md-12"></div>
	<br><br><br><br>
</div>

<? require_once ROOTPATH.'/p/modules/v4_SubExpenses/v4_SubExpenses_JS.php' ?>	

<script type="text/javascript">
	$(document).ready(function(){
		$(".datepicker").pickadate({format:'yyyy-mm-dd'});
		all_v4_SubExpenses(); // definirano u v4_SubExpenses_JS.php
	});

	function all_v4_SubExpensesFilter() {
		all_v4_SubExpenses(); // definirano u v4_SubExpenses_JS.php
	}
</script>	

