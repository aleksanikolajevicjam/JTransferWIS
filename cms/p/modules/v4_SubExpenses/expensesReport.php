<?
require_once ROOT .'/f/f.php';
require_once ROOT .'/db/db.class.php';
//akcije-troskovi
require_once ROOT .'/db/v4_Actions.class.php';
$db = new DataBaseMySql();
$ac = new v4_Actions();
$ack = $ac->getKeysBy('DisplayOrder ', '','WHERE Active=1');
foreach ($ack as $nn => $key)
{
	$ac->getRow($key);
	$opis[$key]=$ac->getTitle();		
}

$dateFrom 	= $_REQUEST['DateFrom'];
$dateTo 	= $_REQUEST['DateTo'];
$DriverID	= $_REQUEST['SubDriverID'];
$SOwnerID   = $_SESSION['OwnerID'];



require_once ROOT . '/cms/fixDriverID.php';
foreach($fakeDrivers as $key => $fakeDriverID) {
    if($SOwnerID == $fakeDriverID) $SOwnerID = $realDrivers[$key];    
}



if( isset($_REQUEST['Save']) and $_REQUEST['Save'] == '1') {

    foreach($_REQUEST['Approved'] as $ID => $Approved) {
        //echo $ID . '=>' . $Approved . '<br>';
        $qu = "UPDATE v4_SubExpenses SET Approved = '" . $Approved . "' WHERE ID = '" . $ID . "'";
        $db->RunQuery($qu);
    }
}




$currency = array(
    '1' => 'EUR',
    '2' => 'HRK',
    '3' => 'CHF');

$q = 'SELECT * FROM v4_SubExpenses';
$q .= ' INNER JOIN v4_AuthUsers ON v4_SubExpenses.DriverID = v4_AuthUsers.AuthUserID';
$q .= ' WHERE v4_SubExpenses.Approved <9 AND v4_SubExpenses.OwnerID = '.$SOwnerID;

if ($dateFrom != null) $q .= " AND Datum >= '".$dateFrom."'";
if ($dateTo != null) $q .= " AND Datum <= '".$dateTo."'";
if ($DriverID != "0") $q .= ' AND v4_SubExpenses.DriverID = '.$DriverID;

if (isset($_REQUEST['expenses'])) {
	$expenseArr = $_REQUEST['expenses'];
	$q .= ' AND (Expense = "'.$expenseArr[0].'"';
	for ($i = 1; $i < count($expenseArr); $i++) {
		$q .= ' OR Expense = "'.$expenseArr[$i].'"';
	}
	$q .= ')';
}
//if (isset($_REQUEST['actionID']) && $_REQUEST['actionID']>0) $q .= ' AND Expense = '.$_REQUEST['actionID'];

if (isset($_REQUEST['card'])) $q .= ' AND Card = 0';
if (isset($_REQUEST['approved'])) $q .= ' AND Approved = 1';
if (isset($_REQUEST['unapproved'])) $q .= ' AND Approved = 0';

$q .= ' ORDER BY Datum DESC';
$r = $db->RunQuery($q);
$expArr = array();
$expensesTotal = 0;
$expensesCashTotal = 0;
$expensesCardTotal = 0;
$pologTotal = 0;

$qd  = "SELECT SUM(CashIn) AS TotalCash FROM v4_OrderDetails ";
$qd .= "WHERE SubDriver = '" . $DriverID . "' ";
$qd .= "AND PickupDate >= '" . $dateFrom . "' ";
$qd .= "AND PickupDate <= '" . $dateTo . "' ";
$qd .= "AND TransferStatus != '3' ";
$qd .= "AND TransferStatus != '4' ";
$qd .= "AND TransferStatus != '9' ";

$rd = $db->RunQuery($qd);
$sd = $rd->fetch_object();

$totalCashIn = $sd->TotalCash;


?>


<style>
.row {
	text-align: center;
	font-size: 14px;
}
.header {
	padding: 10px;
	font-weight: bold;
}
.expense {
	border-top: solid 1px gray;
	padding: 8px;
}

.small {
	width: auto;
	height: 25px;
	background-color: #d6edfc;
}
	.large {
	width: 700px;
	height: auto;

	background-color: #fc0;
	margin: 10px auto;
}
.rotate {
  -moz-transform: rotate(90deg);
  -webkit-transform: rotate(90deg);
  -o-transform: rotate(90deg);
  -ms-transform: rotate(90deg);
  transform: rotate(90deg);
}
  </style>




<div class="container">
	<h1><?= EXPENSES_REPORT ?></h1>
	<form action="p/modules/v4_SubExpenses/expensesReportPrint.php" method="post" target="_blank" style="float:right;margin-top:-30px">
		<input type="hidden" name="DateFrom" value="<?=$dateFrom?>">
		<input type="hidden" name="DateTo" value="<?=$dateTo?>">
		<input type="hidden" name="SubDriverID" value="<?=$DriverID?>">
		<? foreach ($expenseArr as $expense) {
			echo '<input type="hidden" name="expenses[]" value="' . $expense . '">';
		} ?>
		<button type="submit" class="btn btn-primary"><i class="fa fa-print l"></i></button>
	</form>
	<br>

	<div class="row header">
		<div class="col-md-2"><?= DATE ?></div>
		<div class="col-md-1"><?= DRIVER ?></div>
		<div class="col-md-2"><?= EXPENSE ?></div>
		<div class="col-md-1"><?= AMOUNT ?></div>
		<div class="col-md-1"><?= METHOD ?></div>
		<div class="col-md-2"><?= NOTE ?></div>
		<div class="col-md-2">Document Image</div>
		<div class="col-md-1"><?= APPROVED ?></div>
	</div>
    
    <form action="index.php" method="POST">
    <input type="hidden" name="p" value="expensesReport">
    <input type="hidden" name="DateFrom" value="<?=$_REQUEST['DateFrom']?>">
    <input type="hidden" name="DateTo" value="<?=$_REQUEST['DateTo']?>">
    <input type="hidden" name="SubDriverID" value="<?=$_REQUEST['SubDriverID']?>">
    
	<?
	while ($e = $r->fetch_object()) {
		//$expArr[] = $e;
		
		echo '<div class="row expense">';
		    echo '<div class="col-md-2">'.$e->Datum.'</div>';
		    
		    echo '<div class="col-md-1">'.$e->AuthUserRealName.'</div>';
		    
		    echo '<div class="col-md-2">'.$opis[$e->Expense].'</div>';
		    
		    echo '<div class="col-md-1">'.$e->Amount.'</div>';
		
		    echo '<div class="col-md-1">';
		    if ($e->Card == 1) {
			    echo "Card";
			    if($e->Approved == '1') $expensesCardTotal += $e->Amount;
		    } else {
		        echo "Cash";
                if($e->Approved == '1') $expensesCashTotal += $e->Amount;		    
		    }
		    echo '</div>';
		
            echo '<div class="col-md-2">'.$e->Note.'</div>';
			
			if (!empty($e->DocumentImage)) echo '<div class="col-md-2"><img class="small"  src="'.$e->DocumentImage.'" alt="'.$e->DocumentImage.'" /></div>';
			else  echo '<div class="col-md-2"></div>';
            
            echo '<div class="col-md-1">';
            echo '<input type="hidden" name="Approved['.$e->ID.']" id="a'.$e->ID.'" value="'.$e->Approved.'">';
            echo '<input type="checkbox" id="'. $e->ID.'"  ';
            if($e->Approved) echo ' checked';
            echo ' onclick="checkApproved('.$e->ID.')">';
            echo '</div>';
            
        echo '</div>';
		
		if($e->Approved == '1') $expensesTotal += $e->Amount;
		if($e->Expense == '8' and $e->Approved == '1') $pologTotal += $e->Amount;
	}
	?>

	<div class="row alert alert-success" style="margin-left:-15px;padding:4px">
		<div class="col-md-2">Cash: <?= nf($totalCashIn) ?></div>
		<div class="col-md-2">Expenses Cash: <?= nf($expensesCashTotal) ?></div>
		<div class="col-md-2">Expenses Card: <?= nf($expensesCardTotal) ?></div>
		<div class="col-md-2">Expenses Total: <?= nf($expensesTotal) ?></div>
		<div class="col-md-2">(Deposit Total: <?= nf($pologTotal) ?>)</div>
		<?
		    $cashSaldo = nf( $totalCashIn - $expensesCashTotal ); 
		    if($cashSaldo > 0) $warningClass="btn-danger"; else $warningClass = 'btn-success';
		?>
		<div class="col-md-2 <?=$warningClass?>">Cash SALDO: <?= nf($cashSaldo) ?></div>
	</div>


	<div class="row" style="margin-left:-15px;padding:4px">
		<div class="col-md-12 right">
		    <button class="btn blue l" type="submit" name="Save" value="1"><i class="fa fa-save"></i> Save changes</button>
		    <br>
		    <br>
		</div>

	</div>
    </form>

</div>

<script>


$('img').click(function() {
	$(this).attr('class','large');	   

})	
$('img').mouseout(function() {
	$(this).attr('class','small');
})	
$('img').dblclick(function() {
	$(this).addClass('rotate');

})	
function checkApproved(id)
{
  var checkbox = document.getElementById(id);
  var Approved = document.getElementById('a'+id);
  
  if (checkbox.checked != true)
  {
    Approved.value = '0';
  } else Approved.value = '1';
  
  console.log(Approved.value);
}
</script>

