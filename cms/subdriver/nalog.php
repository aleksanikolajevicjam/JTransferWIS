<?
define("NEMPH", "!");
define("NORMAL", "!");
define("BIG", "!1");
define("NUNDERLINED", "!Ĩ");
define("RESET", "@");
define("LINE", "\n________________________________");

session_start();

require_once 'subdriver/db.php';
require_once '../db/v4_Places.class.php';

$op = new v4_Places;

$q  = "SELECT * FROM v4_OrderDetails WHERE DetailsID=".$_REQUEST['id'];
$qr = mysqli_query($con, $q) or die('Error finding Order <br/>' . mysqli_connect_error());
$o = mysqli_fetch_object($qr);

$mokq = "SELECT * FROM v4_OrdersMaster WHERE MOrderID = ".$o->OrderID;
$mokr = mysqli_query($con, $mokq) or die('Error finding MOrder <br/>' . mysqli_connect_error());
$mok = mysqli_fetch_object($mokr);

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

/* HRVATSKI */ 
if ($_SESSION['OwnerID'] == 556) { 

//    ZA PRINT PUTNOG NALOGA ZA OWNERA 556
	$text = 
			NORMAL. 
			"J.A.M. Group d.o.o. \nSv.Nikole 18, Bogdanovici 21 227\n " .
			"OIB: 84961446693 \n " .
			LINE.
			NEMPH."\nPutni nalog broj: " .$_REQUEST['id']. "-". convertTime($o->PickupDate) ."\n\n ".
			NORMAL. NEMPH.
			"Naziv usluge: Usluga asistencije i transfera\n " .
			"Datum transfera: ". convertTime($o->PickupDate) ."\n " .
			"Vrijeme polaska: ". $o->SubPickupTime ."\n\n " .
			"Ime: ". $o->PaxName ."\n\n" .
			"Relacija: ". $PickupName ." - ".$DropName."\n " .
			"Pick-Up adresa: ". $o->PickupAddress ."\n " .
			"Drop-Off adresa: ". $o->DropAddress ."\n ";

	//ako je broj putnika 1, ispisat 2
	if($o->PaxNo==1) {
		$text .= "Broj putnika: 2\n "; 
	} else {
		$text .= "Broj putnika: ".$o->PaxNo."\n "; 
	}
	
	$text .= "Broj rezervacije: ". $o->OrderID ."\n ";

	$text .= LINE;

	$file = $_REQUEST['id'] . ".txt";
	file_put_contents('../nalozi/'.$file, $text);



?>
<div>
	<div>
		<strong><em>
			J.A.M. Group d.o.o.<br>
			Sv.Nikole 18, Bogdanovići 21 227<br>
			OIB: 84961446693<br>
			IBAN: HR252360000102220620 Zaba
		</em></strong>
	</div>
	
	<div class="ui-block-b">
		<strong><em>
			Mobitel: 00385 (0)91 537 58 42<br>
			Tel: 00385 (0)21 567 256<br>
			E-mail: office@jam-group.net
		</em></strong>
	</div>
</div>
<hr>
<div align="center">
	<h2>Putni nalog broj: <?= $_REQUEST['id'] ?> / <?= convertTime($o->PickupDate) ?></h2>
	<br>
	Naziv usluge: <strong>Usluga asistencije i transfera</strong><br>
	Datum transfera: <?= convertTime($o->PickupDate) ?><br>
	Vrijeme polaska: <?= $o->SubPickupTime ?><br>
	<br>
	Ime: <strong><?= $o->PaxName ?></strong><br>
	<br>
	Relacija: <?= $PickupName ?> - <?= $DropName ?><br>
	Pick-Up adresa: <?= $o->PickupAddress ?><br>
	Drop-Off adresa: <?= $o->DropAddress ?><br>
	Broj putnika: <?= $o->PaxNo ?><br><br>

	Odraslih: ______ Djece: ______ Beba:______<br>
	<br>
	Broj rezervacije: <?= $o->OrderID ?> Broj vouchera: <?= $mok->MOrderKey ?>-<?= $o->OrderID ?><br>
	<br>
	Napomena: <br>
	<?= $o->PickupNotes ?><br><br>
	<hr><br><br>

	Vozač: ________________________________________<br>
	<br>
	Vozilo:________________________________________<br>
	<br>
	Stanje brojila na polasku: ________________ Na povratku: ______________<br>
	<br>
	Na put sam krenuo: ________________ u ___________ sati<br>
	<br>
	S puta sam se vratio: _________________ u ___________ sati<br>
	<br>
	Datum sastavljanja: ________________________________________<br>
	<br>
	Potpis vozača: __________________________________________<br>
	<br>
	<br>
	<br>
	Potpis i pečat nalogodavca:<br>

	<a href="../nalozi/<?= $file ?>">Download</a><br><br><br>
</div>
<? }

/* FRANCUSKI */
else if ($_SESSION['OwnerID'] == 843 or $_SESSION['OwnerID'] == 876 or $_SESSION['OwnerID'] == 884 or $_SESSION['OwnerID'] == 2828) { 
//    ZA PRINT PUTNOG NALOGA AKO JE OWNER 843, 876, 884
	$text = 
			NORMAL. "
			Etablissement secondaire \nJ A M GROUP D.O.O. SIRET\n
			81500492400032 Adresse 13 \nAVENUE BARTHÉLÉMY THIMONNIER - 69300 CALUIRE\n
			Activite Transports de personnes de moins de neuf voyageurs (4619B)\n" .
			LINE.
			NEMPH."\nCommande numéro: " .$_REQUEST['id']. "-". convertTime($o->PickupDate) ."\n\n ".
			NORMAL. NEMPH.
			"Service demandé: transfert de voyageurs\n " .
			"Date de transfert: ". convertTime($o->PickupDate) ."\n " .
			"Heure de départ: ". $o->SubPickupTime ."\n\n " .
			"Nom: ". $o->PaxName ."\n\n" .
			"Itinéraire: ". $PickupName ." - ".$DropName."\n " .
			"Adresse de départ: ". $o->PickupAddress ."\n " .
			"Adresse d'arrivée: ". $o->DropAddress ."\n ";

	//ako je PaxNo 1, ispisat 2
	if($o->PaxNo==1) {
		$PaxNo=2;
		$text .= "Nombre de passagers: 2\n"; 
	} else {
		$text .= "Nombre de passagers: ".$o->PaxNo."\n "; 
		$PaxNo=$o->PaxNo;
	}
	$text .= "Numéro de réservation: ". $o->OrderID ."\n ";

	$text .= LINE;

	$file = $_REQUEST['id'] . ".txt";
	//exit ($file);
	file_put_contents('../nalozi/'.$file, $text);

?>
<div>
	<strong><em>
		Etablissement secondaire J A M GROUP D.O.O. SIRET<br>
		81500492400032 Adresse 13AVENUE BARTHÉLÉMY THIMONNIER - 69300 CALUIRE<br>
		Activité Transports de personnes de moins de neuf voyageurs (4619B)
	</em></strong>
</div>
<hr>
<div align="center">
	<h2>Commande numéro: <?= $_REQUEST['id'] ?> / <?= convertTime($o->PickupDate) ?></h2>
	<br>
	Service demandé: <strong>transfert de voyageurs</strong><br>
	Date de transfert: <?= convertTime($o->PickupDate) ?><br>
	Heure de départ: <?= $o->SubPickupTime ?><br>
	<br>
	Nom: <strong><?= $o->PaxName ?></strong><br>
	<br>
	Itinéraire: <?= $PickupName ?> - <?= $DropName ?><br>
	Adresse de départ: <?= $o->PickupAddress ?><br>
	Adresse d'arrivée: <?= $o->DropAddress ?><br>
	<? /* za francusku ispisati za paxNo=1 paxNo=2 */ ?>
	Nombre de passagers: <?= $PaxNo ?><br><br>

	Adulte: ______ Enfant: ______ Bébé: ______<br>
	<br>
	Numéro de réservation: <?= $o->OrderID ?> Numéro de voucher: <?= $mok->MOrderKey ?>-<?= $o->OrderID ?><br>
	<br>
	Commentaire: <br>
	<?= $o->PickupNotes ?><br><br>
	<hr><br><br>

	Date: ____________<br><br>
	Signature: ____________________<br><br>
	Signature et cachet du donneur d'ordre: _____________________________<br>
	
	<a href="../nalozi/<?= $file ?>">Download</a><br><br><br>
</div><? }
else echo 'Error: OwnerID not in France';

