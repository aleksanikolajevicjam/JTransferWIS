<?
define("NEMPH", "!");
define("NORMAL", "!");
define("BIG", "!1");
define("NUNDERLINED", "!Ĩ");
define("RESET", "@");
define("LINE", "\n________________________________");

require_once ROOT .'/db/db.class.php';
require_once ROOT .'/db/v4_Places.class.php';

$db = new DataBaseMysql();
$op = new v4_Places;

// BROJ RACUNA FIX
$q  = "SELECT * FROM v4_OrderDetailsFR ";
$q .= "WHERE PickupDate >= '2018-01-01' ";
$q .= "AND (DriverID = '876' OR DriverID = '843') ";
$q .= "AND TransferStatus != '3' ";
$q .= "AND TransferStatus != '4' ";
$q .= "AND TransferStatus != '9' ";
$q .= "AND Expired = '0' ";
//$q .= "AND PayNow = 0 ";
//$q .= "AND PayLater > 0 ";
$q .= "AND InvoiceAmount = 0 ";
$q .= "AND SubPickupTime != '00:00' ";
$q .= "AND DetailsID <= '" . $_REQUEST['id'] . "' ";
$q .= "ORDER BY PickupDate ASC, PickupTime ASC ";

$rr = $db->RunQuery($q);

$brojRacuna = $rr->num_rows;



$q  = "SELECT * FROM v4_OrderDetailsFR WHERE DetailsID=".$_REQUEST['id'];

$qr = $db->RunQuery($q);
$o = $qr->fetch_object();

$brojRacuna = $o->CustomerInvoice;
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
$pay = $o->DetailPrice + $o->ExtraCharge;
$text = 
		NORMAL. "
		Etablissement secondaire \nJ A M GROUP D.O.O. SIRET\n
		81500492400032 Adresse 13 AVENUE BARTHÉLÉMY THIMONNIER - 69300 CALUIRE\n
		Activite Transports de personnes de moins de neuf voyageurs (4619B)\n\n" .
		NEMPH."Reference : \nFacture " .$brojRacuna. " - ". convertTime($o->PickupDate,'%d/%m/%Y') ."\n\n".
		BIG ."Client: ". strtoupper( $o->PaxName )."\n" .
		"Facture\n".
		NORMAL. NEMPH.
		"Transfert de: ". $PickupName ."\na\n" . $DropName ."\n" .
		"le ". convertTime($o->PickupDate,'%d/%m/%Y') ."\n" .
		"Montant acompte HT : " . number_format($pay/ 1.1,2) . " EUR\n" .
		"TVA 10%	             : " . number_format($pay - ($pay / 1.1),2) . " EUR\n" .
		"Montant acompte TTC: " . number_format($pay,2) . " EUR\n";
$text .= LINE;

//$file = $o->CustomerInvoice . ".txt";
//file_put_contents('../racuni/'.$file, $text);

?>


	<div class="container" style="font-family: sans-serif;">
		<div class="">
			<em>
			Etablissement secondaire J A M GROUP D.O.O. SIRET<br>
			81500492400032 Adresse 13 AVENUE BARTHÉLÉMY THIMONNIER - 69300 CALUIRE<br>
			Activité Transports de personnes de moins de neuf voyageurs (4619B)
			</em>
		</div>
		<!--	
		<div class="">
			<strong><em>
				Mobitel: 00385 (0)91 537 58 42<br>
				Tel: 00385 (0)21 567 256<br>
				E-mail: office@jam-group.net
			</em></strong>
		</div>
		-->	
		<hr>
		<div align="left">
			Réference : Facture <?= $brojRacuna ?> -
			<?= convertTime($o->PickupDate,'%d/%m/%Y') ?>
			<br>
			Client: <strong><?= strtoupper( $o->PaxName) ?></strong><br>
			<br>
			<h2>Facture</h2>
			<br>
			<strong>Désignation :</strong>
			<br>
			Transfert de: <?= $PickupName ?> à <?= $DropName ?><br>
			le <?= convertTime($o->PickupDate,'%d/%m/%Y') ?>
			<br><br>
			<table>
				<tr>
					<td>
						Montant acompte HT: 
					</td>
					<td align="right">
						<?= number_format($pay / 1.1,2) ?> EUR 
					</td>
				</tr>
				<tr>
					<td>
						TVA 10%	
					</td>
					<td align="right">
						<?= number_format($pay- ($pay / 1.1),2) ?> EUR
					</td>
				</tr>
				<tr>
					<td>
						Montant acompte TTC: 
					</td>
					<td align="right">
						<?= number_format($pay,2) ?> EUR
					</td>
				</tr>
			</table>
		</div>

	</div>
</html>

<?
function convertTime($ts, $dformat = '%d.%m.%Y', $sformat = '%Y-%m-%d') {
	extract(strptime($ts,$sformat));
	return strftime($dformat,mktime(
		                          intval($tm_hour),
		                          intval($tm_min),
		                          intval($tm_sec),
		                          intval($tm_mon)+1,
		                          intval($tm_mday),
		                          intval($tm_year)+1900
		                        ));
}

