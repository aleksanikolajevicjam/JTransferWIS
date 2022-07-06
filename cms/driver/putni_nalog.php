<?
define("NEMPH", "!");
define("NORMAL", "!");
define("BIG", "!1");
define("NUNDERLINED", "!Ĩ");
define("RESET", "@");
define("LINE", "\n________________________________");

session_start();

//require_once 'subdriver/db.php';
//require_once '../db/v4_Places.class.php';
require_once ROOT . '/cms/subdriver/db.php';
require_once ROOT . '/db/v4_Places.class.php';
require_once ROOT . '/cms/lng/en_text.php';


$op = new v4_Places;

$q  = "SELECT * FROM v4_OrderDetails WHERE DetailsID=".$_REQUEST['id'];
$qr = mysqli_query($con, $q) or die('Error finding Order <br/>' . mysqli_connect_error());
$o = mysqli_fetch_object($qr);

$mokq = "SELECT * FROM v4_OrdersMaster WHERE MOrderID = ".$o->OrderID;
$mokr = mysqli_query($con, $mokq) or die('Error finding MOrder <br/>' . mysqli_connect_error());
$mok = mysqli_fetch_object($mokr);

if ($o->CustomerInvoice=='0') {
	$q2  = "SELECT count(*) as countInv FROM v4_OrderDetails WHERE CustomerInvoice<>'0' AND DriverID IN (843,876) AND PickupDate='".$o->PickupDate."'";
	$qr2 = mysqli_query($con, $q2) or die('Error finding Order <br/>' . mysqli_connect_error());
	$o2 = mysqli_fetch_object($qr2);
	$drb=$o2->countInv+1;
	$datum=explode('-',$o->PickupDate);
	if (count($datum)==3) $datum=mktime(0,0,0,$datum[1],$datum[2],$datum[0]);
	$drb=date('z', $datum).".".$drb;
	/*$q3  = "UPDATE `v4_OrderDetails` SET `CustomerInvoice`='".$drb."' WHERE DetailsID=".$_REQUEST['id'];
	$qr3 = mysqli_query($con, $q3) or die('Error finding Order <br/>' . mysqli_connect_error());*/
}
else $drb=$o->CustomerInvoice;

// dohvacanje engleskih imena lokacija iz v4_Places
// ako je FREEFORM, PickupID i DropID su 0,
// pa se imena dohvacaju iz v4_OrderDetails
if (($o->PickupID != 0) and ($o->DropID != 0)) {
	$op->getRow($o->PickupID);
	$PickupName = $op->getPlaceNameEN();
	$op->getRow($o->DropID);
	$DropName = $op->getPlaceNameEN();
} else {
	$PickupName = $o->PickupName;
	$DropName = $o->DropName;
}
$pay = ($o->DetailPrice + $o->ExtraCharge)*$_SESSION['CurrencyRate'];

$pm=$o->PaymentMethod;
$PaymentMethodName=$PaymentMethod[$pm];

$text = 
		NORMAL.
		"J A M GROUP D.O.O.\n".
		"Cesta Sv. Nikole 19, Bogdanovici\n".
		"OIB : 84961446693".
		LINE." \n".
		"Broj naloga : " .$o->OrderID. "-".$o->TNo." \n".
		"Datum : ". convertTime($o->PickupDate,'%d.%m.%Y').
		LINE." \n".	  
		"Klijent : ". $o->PaxName."\n" .
		"IZ: ". $PickupName ."\n". 
		"ADRESA : ". $o->PickupAddress ."\n". 
		"ZA : ". $DropName ."\n".
		"ADRESA : ". $o->PickupAddress ."\n". 
		"PUTNIKA : ". $o->PaxNo.
		LINE." \n".
		"CJENA   : " . number_format($pay  / 1.25,2) . " HRK\n" .
		"PDV 25% : " . number_format($pay  - ($pay  / 1.25),2) . " HRK\n" .
		"UKUPNO  : " . number_format($pay ,2) . " HRK\n".
		"PLACANJE: " . $PaymentMethodName.
		LINE;
		
$datum=explode('-',$o->PickupDate);
$file = $drb ."-".$datum[0].".txt";
file_put_contents('nalozi/'.$file, $text);

?>

	<div class="container">
		<div class="">
		J A M GROUP D.O.O.<BR>
		Cesta Sv. Nikole 19, Bogdanovici<BR>
		OIB : 84961446693<BR><hr>
		Broj naloga : <?= $o->OrderID ?>-<?=$o->TNo ?><BR>
		Datum : <?= convertTime($o->PickupDate,'%d.%m.%Y') ?><BR><hr>	  
		<strong>Klijent : <?=  $o->PaxName ?></strong><BR>
		IZ: <?= $PickupName ?><BR>
		ADRESA : <?= $o->PickupAddress ?><BR> 
		ZA : <?= $DropName ?><BR>
		ADRESA : <?= $o->PickupAddress ?><BR> 
		PUTNIKA : <?= $o->PaxNo ?><BR> <hr>
		<table>
		<tr><td>CJENA:</td><td style='text-align:right;'><?= number_format($pay  / 1.25,2) ?> HRK</td></tr>
		<tr><td>PDV 25%:</td><td style='text-align:right;'><?= number_format($pay  - ($pay  / 1.25),2) ?> HRK</td></tr>
		<tr><td>UKUPNO:</td><td style='text-align:right;'><?= number_format($pay ,2) ?> HRK</td></tr>
		</table>
		PLACANJE:<?= $PaymentMethodName ?><BR><hr>
		</div>
		<a href="../driver/nalozi/<?= $file?>">Download</a>
	</div>
</html>

