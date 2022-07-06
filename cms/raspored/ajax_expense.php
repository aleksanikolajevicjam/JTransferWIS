<?

require_once 'data.php';
require_once 'f/db_funcs.php';

$ID			= $_REQUEST['ID'];
$Datum 		= $_REQUEST['Datum'];
$Driver 	= $_REQUEST['Driver'];
$Type		= $_REQUEST['Type'];
$Amount		= $_REQUEST['Amount'];
$Op			= $_REQUEST['Op'];


if ($Datum != '' and $Driver != '' and $Type != '' and $Amount != '' and $Op == 'add') {
	
	$data = array(
		'ID' 		=> '',
		'Datum' 	=> $Datum,
		'Driver' 	=> $Driver,
		'Expense' 	=> $Type,
		'Amount' 	=> $Amount
	);
	
	$inserted = XInsert("Expenses", $data);

	if ($inserted != 0) {
		ShowExpenses($Datum);
	}
	else echo 'Error';
}

if ($Datum != '' and $Op == 'show') ShowExpenses($Datum);

if ($ID != '' and $Op == 'delete' and $Datum != '') {
	XDelete("Expenses", " ID = " . $ID);
	ShowExpenses($Datum);
}



function ShowExpenses($datum) {
	$q = "SELECT * FROM Expenses WHERE Datum = '" . $datum . "' ORDER BY ID ASC";
	$w = mysql_query($q) or die(mysql_error() . ' ajax_expense ShowExpenses');
	
	$sum = 0;
	
	while ($x = mysql_fetch_object($w)) {
		$sum += $x->Amount;
		?>
		<div class="span3"><?= $x->Expense ?> (<?= $x->Driver?>)</div>
		<div class="span2" align="right"><?= number_format($x->Amount,2)?> kn</div>
		<div class=span1><a href="#" onclick="deleteExpense(<?= $x->ID ?>);"><i class="icon-remove-sign"></i></a></div>
		<?
	}
		?>
		<div class="span3"></div>
		<div class="span2 alert-error" align="right" style="border-top:1px dotted #000"><?= number_format($sum,2)?> kn</div>
		<?
		SumByDriver($datum);
		SumByType($datum);
}

function SumByDriver($datum) {
	$q = "SELECT Datum, Driver, SUM(Amount) AS Suma FROM Expenses WHERE Datum = '".$datum."' GROUP BY Driver";
	$w = mysql_query($q) or die(mysql_error() . ' ajax_expense SumByDriver');
	
	?><div class="span7"><br><p class="lead">- po vozačima</p></div><?
	
	while($s = mysql_fetch_object($w)) {
		?>
		
		<div class="span3"><?= $s->Driver ?></div>
		<div class="span2" align="right"><?= number_format($s->Suma,2)?> kn</div>	
		<?
	}
}


function SumByType($datum) {
	$q = "SELECT Datum, Expense, SUM(Amount) AS Suma FROM Expenses WHERE Datum = '".$datum."' GROUP BY Expense";
	$w = mysql_query($q) or die(mysql_error() . ' ajax_expense SumByDriver');
	
	?><div class="span7"><br><p class="lead">- po vrstama troška</p></div><?
	
	while($s = mysql_fetch_object($w)) {
		?>
		
		<div class="span3"><?= $s->Expense ?></div>
		<div class="span2" align="right"><?= number_format($s->Suma,2)?> kn</div>	
		<?
	}
}
