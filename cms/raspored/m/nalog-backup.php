<?

//echo '<pre>'; print_r($_REQUEST); echo '</pre>';
$q  = "SELECT * FROM v4_OrderDetails WHERE DetailsID=".$_REQUEST['id'];
$qr = mysqli_query($con, $q) or die('Error finding Order <br/>' . mysqli_connect_error());
$o = mysqli_fetch_object($qr);

$mokq = "SELECT * FROM v4_OrdersMaster WHERE MOrderID = ".$o->OrderID;
$mokr = mysqli_query($con, $mokq) or die('Error finding MOrder <br/>' . mysqli_connect_error());
$mok = mysqli_fetch_object($mokr);
?>

<div class="ui-grid-a">
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
Vrijeme polaska: <?= $o->PickupTime ?><br>
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
<?= $o->PickupNotes ?><br>

<br>
<hr>
<br>
<br>
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

<div class=" footer"><br/><br/>
	<a href="index.php?option=menu" data-role="button" data-icon="home" data-theme="b" data-transition="flip" data-direction="reverse">Home</a>
</div>
