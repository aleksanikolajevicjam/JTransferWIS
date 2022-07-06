<?
define("NEMPH", "!");
define("NORMAL", "!");
define("BIG", "!1");
define("NUNDERLINED", "!Ĩ");
define("RESET", "@");
define("LINE", "\n________________________________");



//echo '<pre>'; print_r($_REQUEST); echo '</pre>';
$q  = "SELECT * FROM v4_OrderDetails WHERE DetailsID=".$_REQUEST['id'];
$qr = mysqli_query($con, $q) or die('Error finding Order <br/>
<div class=" footer"><br/><br/>
	<a href="index.php?option=menu" data-role="button" data-icon="home" data-theme="b" data-transition="flip" data-direction="reverse">Home</a>
</div>' . mysqli_connect_error());
$o = mysqli_fetch_object($qr);

$mokq = "SELECT * FROM v4_OrdersMaster WHERE MOrderID = ".$o->OrderID;
$mokr = mysqli_query($con, $mokq) or die('Error finding MOrder <br/>' . mysqli_connect_error());
$mok = mysqli_fetch_object($mokr);

$text = 
		NORMAL. "
		Etablissement secondaire \nJ A M GROUP D.O.O. SIRET\n
		81500492400032 Adresse 13 AVENUE BARTHÉLÉMY THIMONNIER - 69300 CALUIRE\n
		Activite Transports de personnes de moins de neuf voyageurs (4619B)\n\n" .
		NEMPH."Reference : \nFacture " .$_REQUEST['id']. " - ". convertTime(date("Y-m-d"),'%d/%m/%Y') ."\n\n".
		BIG ."Client: ". $o->PaxName."\n" .
		"Facture\n".
		NORMAL. NEMPH.
		"Transfert de: ". $o->PickupName ."\na\n" . $o->DropName ."\n" .
		"le ". convertTime($o->PickupDate,'%d/%m/%Y') ."\n" .
		"Montant acompte HT : " . number_format($o->PayLater / 1.1,2) . " EUR\n" .
		"TVA 10%	             : " . number_format($o->PayLater - ($o->PayLater / 1.1),2) . " EUR\n" .
		"Montant acompte TTC: " . number_format($o->PayLater,2) . " EUR\n"
		
;
$text .= LINE;


$file = $_REQUEST['id'] . ".txt";
file_put_contents('./racuni/'.$file, $text);





?>

<div class="ui-grid-a">
	<div class="ui-block-a">
		<em>
		Etablissement secondaire J A M GROUP D.O.O. SIRET<br>
		81500492400032 Adresse 13 AVENUE BARTHÉLÉMY THIMONNIER - 69300 CALUIRE<br>
		Activité Transports de personnes de moins de neuf voyageurs (4619B)
		</em>
	</div>
<!--	
	<div class="ui-block-b">
		<strong><em>
			Mobitel: 00385 (0)91 537 58 42<br>
			Tel: 00385 (0)21 567 256<br>
			E-mail: office@jam-group.net
		</em></strong>
	</div>
-->	
</div>
<hr>
<div align="left">
	Réference : Facture <?= $_REQUEST['id'] ?> - <?= convertTime(date("Y-m-d"),'%d/%m/%Y') ?>
	<br>
	Client: <strong><?= $o->PaxName ?></strong><br>
	<br>
	<h2>Facture</h2>
	<br>
	<strong>Désignation :</strong>
	<br>
	Transfert de: <?= $o->PickupName ?> à <?= $o->DropName ?><br>
	le <?= convertTime($o->PickupDate,'%d/%m/%Y') ?>
	<br><br>
	<table>
	<tr>
		<td>
			Montant acompte HT: 
		</td>
		<td align="right">
			<?= number_format($o->PayLater / 1.1,2) ?> EUR 
		</td>
	</tr>
	<tr>
		<td>
			TVA 10%	
		</td>
		<td align="right">
			
			<?= number_format($o->PayLater - ($o->PayLater / 1.1),2) ?> EUR
		</td>
	</tr>
	<tr>
		<td>
			Montant acompte TTC: 
		</td>
		<td align="right">
			<?= number_format($o->PayLater,2) ?> EUR
		</td>
	</tr>
	</table>

</div>
<a href="/racuni/<?= $file?>">Download</a>

<div class=" footer"><br/><br/>
	<a href="index.php?option=menu" data-role="button" data-icon="home" data-theme="b" data-transition="flip" data-direction="reverse">Home</a>
</div>


