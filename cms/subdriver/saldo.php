<?
require_once $_SERVER['DOCUMENT_ROOT'] .'/f/f.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/db/db.class.php';

$db = new DataBaseMySql();

// TODO samo zadnja tri dana !!!

$dateFrom 	= $_REQUEST['DateFrom'];
$dateTo 	= $_REQUEST['DateTo'];
$DriverID	= $_SESSION['DriverID'];
$SOwnerID   = $_SESSION['OwnerID'];



require_once $_SERVER['DOCUMENT_ROOT'] . '/cms/fixDriverID.php';
foreach($fakeDrivers as $key => $fakeDriverID) {
    if($SOwnerID == $fakeDriverID) $SOwnerID = $realDrivers[$key];    
}



if( isset($_REQUEST['ShowExpenses']) and $_REQUEST['ShowExpenses'] != '') {



$opis = array(
	'1'	 => 'Gorivo',
	'2'  => 'Autoput',
	'3'  => 'Parking',
	'4'  => 'Pranje',
	'5'  => 'Popravci',
	'6'  => 'Plaća',
	'7'  => 'Piće',
	'8'  => 'Polog na račun',
	'9'  => 'Sredstva za čišćenje',
	'10' => 'Dijelovi za auto',
	'99' => 'Ostalo');

$currency = array(
    '1' => 'EUR',
    '2' => 'HRK',
    '3' => 'CHF');


$expensesTotal = 0;
$expensesCashTotal = 0;
$expensesCardTotal = 0;
$pologTotal = 0;


$q = 'SELECT * FROM v4_SubExpenses';
$q .= ' INNER JOIN v4_AuthUsers ON v4_SubExpenses.DriverID = v4_AuthUsers.AuthUserID';
$q .= ' WHERE v4_SubExpenses.Approved<9 AND v4_SubExpenses.OwnerID = '.$SOwnerID ;

if ($dateFrom != null)  $q .= " AND Datum >= '".$dateFrom."'";
if ($dateTo != null)    $q .= " AND Datum <= '".$dateTo."'";
if ($DriverID != "0")   $q .= ' AND v4_SubExpenses.DriverID = '.$DriverID;

$q .= ' ORDER BY Datum DESC';
$r = $db->RunQuery($q);


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
</style>

<div class="container">
	<h1><?= EXPENSES_REPORT ?></h1>

	<div class="row header">
		<div class="col-md-2"><?= DATE ?></div>
		<div class="col-md-2"><?= EXPENSE ?></div>
		<div class="col-md-2"><?= AMOUNT ?></div>
		<div class="col-md-1"><?= METHOD ?></div>
		<div class="col-md-2"><?= NOTE ?></div>
		<div class="col-md-1"><?= APPROVED ?></div>
	</div>
    

    
	<?
	while ($e = $r->fetch_object()) {
		//$expArr[] = $e;
		
		echo '<div class="row expense">';
		    echo '<div class="col-md-2">'.$e->Datum.'</div>';
		    
		    //echo '<div class="col-md-2">'.$e->AuthUserRealName.'</div>';
		    
		    echo '<div class="col-md-2">'.$opis[$e->Expense].'</div>';
		    
		    echo '<div class="col-md-2">'.$e->Amount.'</div>';
		
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
            
            echo '<div class="col-md-1">';
            if($e->Approved) echo ' <i class="fa fa-circle xgreen-text"></i>';
            else echo ' <i class="fa fa-circle red-text"></i>';
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
		    if($cashSaldo > 0) $warningClass="btn-danger"; else $warningClass = '';
		?>
		<div class="col-md-2 <?=$warningClass?>">Cash SALDO: <?= nf($cashSaldo) ?></div>
	</div>
	<br><br>



</div>

<? } else { ?>
<div class="container">

	<form action="index.php?p=summary" method="POST">
		<h1><?= EXPENSES_REPORT ?></h1><br>

		<div style="width:100px;display:inline-block"><?= FROM ?>: </div> 
		<input class="datepicker" name="DateFrom"><br>

		<div style="width:100px;display:inline-block"><?= TO ?>: </div> 
		<input class="datepicker" name="DateTo"><br><br>

		<input class="btn btn-primary" type="submit" value="<?= SHOW_EXPENSES ?>" name="ShowExpenses">
	</form>

</div>

<? } ?>



<script>
$(document).ready(function(){
	$(".datepicker").pickadate({format:'yyyy-mm-dd'});
});
</script>


<script>

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

