<?
session_start();

//echo '<pre>'; print_r($_REQUEST); echo '</pre>';
$q  = "SELECT * FROM v4_OrderDetails WHERE DetailsID=".$_REQUEST['id'];
$qr = mysqli_query($con, $q) or die('Error finding Order <br/>' . mysqli_connect_error());
$o = mysqli_fetch_object($qr);

$mokq = "SELECT * FROM v4_OrdersMaster WHERE MOrderID = ".$o->OrderID;
$mokr = mysqli_query($con, $mokq) or die('Error finding MOrder <br/>' . mysqli_connect_error());
$mok = mysqli_fetch_object($mokr);
?>

<? /* HRVATSKI */ 
if ($_SESSION['OwnerID'] == 556) { ?>
<div class="ui-grid-a"><? echo 'aaa'.$_SESSION['OwnerID'].$_SESSION['DriverID'];?>
	<div class="ui-block-a">
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
	Relacija: <?= $o->PickupName ?> - <?= $o->DropName ?><br>
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
	S puta sam se vratio: _________________ u _________ sati<br>
	<br>
	Datum sastavljanja: ________________________________________<br>
	<br>
	Potpis vozača: __________________________________________<br>
	<br>
	<br>
	<br>
	Potpis i pečat nalogodavca:<br>
</div>
<? }

/* FRANCUSKI */
else if ($_SESSION['OwnerID'] == 843 or $_SESSION['OwnerID'] == 876 or $_SESSION['OwnerID'] == 884) { ?>
<div class="ui-grid-a">
	<strong><em>
		Etablissement secondaire J A M GROUP D.O.O. SIRET<br>
		81500492400032 Adresse 13 AVENUE BARTHÉLÉMY THIMONNIER - 69300 CALUIRE<br>
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
	Itinéraire: <?= $o->PickupName ?> - <?= $o->DropName ?><br>
	Adresse de départ: <?= $o->PickupAddress ?><br>
	Adresse d'arrivée: <?= $o->DropAddress ?><br>
	<? /* za francusku ispisati kapacitet vozila umjesto PaxNo */ ?>
	Nombre de passagers: <?= $o->VehicleType ?><br><br>

	Adulte: ______ Enfant: ______ Bébé: ______<br>
	<br>
	Numéro de réservation: <?= $o->OrderID ?> Numéro de voucher: <?= $mok->MOrderKey ?>-<?= $o->OrderID ?><br>
	<br>
	Commentaire: <br>
	<?= $o->PickupNotes ?><br><br>
	<hr><br><br>

	Date: ____________<br><br>
	Signature: ____________________<br><br>
	Signature et cachet du donneur d'ordre: _____________________________
</div><? }
else echo 'Error: OwnerID not in France';
?>

<div class=" footer"><br/><br/>
	<a href="index.php?option=menu" data-role="button" data-icon="home" data-theme="b" data-transition="flip" data-direction="reverse">Home</a>
</div>

