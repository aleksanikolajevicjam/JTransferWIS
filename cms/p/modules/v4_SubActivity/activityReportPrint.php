<?
session_start();
require_once '../../../lng/en_text.php';
require_once '../../../../db/db.class.php';
//akcije-troskovi
require_once '../../../../db/v4_Actions.class.php';
$db = new DataBaseMySql();
$ac = new v4_Actions();
$ack = $ac->getKeysBy('DisplayOrder ', '');
foreach ($ack as $nn => $key)
{
	$ac->getRow($key);
	$opis[$key]=$ac->getTitle();		
}


$dateFrom 	= $_REQUEST['DateFrom'];
$dateTo 	= $_REQUEST['DateTo'];
$DriverID	= $_REQUEST['SubDriverID'];

$currency = array(
    '1' => 'EUR',
    '2' => 'HRK',
    '3' => 'CHF');

$q = 'SELECT * FROM v4_SubActivitiy';
$q .= ' INNER JOIN v4_AuthUsers ON v4_SubActivitiy.DriverID = v4_AuthUsers.AuthUserID';
$q .= ' WHERE v4_SubActivitiy.Approved <9 AND v4_SubActivitiy.OwnerID = '.$_SESSION["OwnerID"];

if ($dateFrom != null) $q .= " AND Datum >= '".$dateFrom."'";
if ($dateTo != null) $q .= " AND Datum <= '".$dateTo."'";
if (isset($DriverID) and ($DriverID != "0")) $q .= ' AND v4_SubActivitiy.DriverID = '.$DriverID;

if (isset($_POST['expenses'])) {
	$expenseArr = $_REQUEST['expenses'];
	$q .= ' AND (Expense = "'.$expenseArr[0].'"';
	for ($i = 1; $i < count($expenseArr); $i++) {
		$q .= ' OR Expense = "'.$expenseArr[$i].'"';
	}
	$q .= ')';
}

$q .= ' ORDER BY Datum DESC';

$r = $db->RunQuery($q);
$expArr = array();
$expensesTotal = 0;
$expensesCardTotal = 0;
?>
<title><?= EXPENSES_REPORT . ' (' . PRINT_CONFIRMATION . ')'?></title>
<style>
* {box-sizing: border-box;}
.row {
	text-align: center;
	font-size: 14px;
	word-wrap: none;
}
.header {
	padding: 10px;
	font-weight: bold;
}
.expense {
	border-top: solid 1px gray;
	padding: 8px;
	word-wrap: none;
}
.width25 {display:inline-block;width:25%;}
.width15 {display:inline-block;width:15%;}
.width10 {display:inline-block;width:5%;}
</style>

<div>
	<h1><?= EXPENSES_REPORT . ' (' . PRINT_CONFIRMATION . ')'?></h1>
	<br>

	<div class="row header">
		<div class="width15"><?= DATE ?></div>
		<div class="width15"><?= DRIVER ?></div>
		<div class="width15"><?= EXPENSE ?></div>
		<div class="width15"><?= AMOUNT ?></div>
		<div class="width10"><?= METHOD ?></div>
		<div class="width15"><?= NOTE ?></div>
		<div class="width10"><?= APPROVED ?></div>
	</div>

	<?
	while ($e = $r->fetch_object()) {
		$expArr[] = $e;
		echo '<div class="row expense">';
		echo '<div class="width15">'.$e->Datum.'</div>';
		echo '<div class="width15">'.$e->AuthUserRealName.'</div>';
		echo '<div class="width15">'.$opis[$e->Expense].'</div>';
		echo '<div class="width15">'.$e->Amount.'</div>';
		echo '<div class="width10">';
		    if ($e->Card == 1) {
			    echo "Card";
			    if($e->Approved == '1') $expensesCardTotal += $e->Amount;
		    } else {
		        echo "Cash";
                if($e->Approved == '1') $expensesCashTotal += $e->Amount;		    
		    }
		echo '</div>';
        echo '<div class="width15">'.$e->Note.'</div>';
        echo '<div class="width10">';
        if($e->Approved) echo 'Yes'; else echo 'No';
        echo '</div>';
        echo '</div>';
		if($e->Approved == '1') $expensesTotal += $e->Amount;
	}
	?>
</div>

