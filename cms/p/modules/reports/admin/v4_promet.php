<?
error_reporting(E_PARSE);
@session_start();

if (!$_SESSION['UserAuthorized']) die('Not authorized');

require_once ROOT."/db/db.class.php";
require_once ROOT."/f/f.php";
$db = new DataBaseMysql();


$from_date = $_REQUEST['date_from'];
$to_date = $_REQUEST['date_to'];
/*
# napuni sve drzave u niz 
$qry="SELECT * FROM v4_Countries 
		ORDER BY CountryID ASC";
$cr = $db->RunQuery($qry) or die('Error in Countries');
$c = $cr->fetch_object();

$cntry_amt = array();
$cntry_transfers = array();

do { 
$rbr = $c->CountryID;

$cntry_amt[$rbr] = 0;

 } while ($c = $cr->fetch_object());
  $rowss = $cr->num_rows;
  if($rowss > 0) {
      $cr->data_seek(0);
	  $c = $cr->fetch_row();
  } 
*/

?>
<div class="container white">
<h1>
	<?= TRANSFERS_SUMMARY;
		if(!empty($from_date)) echo ' &rarr; '. ymd2dmy($from_date) . ' - ';
		if(!empty($to_date)) echo ymd2dmy($to_date) ;
	?> 
</h1><br />
<?= TRANSFERS_SUMMARY_DESCRIPTION ?>
<br /><br />

<form action="index.php?p=promet" method="post" class="form">
	<div class="row">
		<div class="col-md-2">
			<?= FROM ?> :
		</div>
		<div class="col-md-4">
			<input type="text" name="date_from" value="<?= $from_date ?>" id="date_from" class="datepicker"/>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2">
			<?= TO ?> :
		</div>
		<div class="col-md-4">
			<input type="text" name="date_to" value="<?= $to_date ?>" id="date_to" class="datepicker"/>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2">
			<?= SHOW_DETAILS ?>:
		</div>
		<div class="col-md-4">
			<input type="checkbox" name="details" value="checked" id="details" <?= $_REQUEST['details'] ?>/>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2">
			<br>		
			<p><button name="submitPromet" class="btn btn-primary" type="submit"> <?= SUBMIT ?> </button></p>
		</div>
	</div>
</form>

<?

	if(!empty($from_date) and !empty($to_date)) {

?>
  <table width="100%" class="table" border="0">

    <tr bgcolor="#eeeeee" class="bold">
	<td>&nbsp;</td>
      <td ><div class="txt_white"><small><?= ORDER_DATE ?>/<?=USER ?></small></div></td>
      <td><div align="right" class="txt_white">Payment Method</div></td>	  	  
      <td><div align="right" class="txt_white"><?= PICKUP_DATE ?></div></td>
      <td><div align="right" class="txt_white"><?= ID ?></div></td>
      <td><div align="right" class="txt_white"><?= PRICE ?></div></td>
      <td><div align="right" class="txt_white"><?= EXTRAS ?></div></td>	  
      <td><div align="right" class="txt_white"><?= AGENT_COMMISION ?></div></td>
      <td><div align="right" class="txt_white"><?= INVOICE ?></div></td>                  
      <td><div align="right" class="txt_white"><?= DRIVER ?></div></td> 
      <td><div align="right" class="txt_white"><?= DRIVER ?> <?= EXTRAS ?></div></td> 	  
      <td><div align="right" class="txt_white"><?= NETTO ?></div></td> 

    </tr>
   
<? 


$query2 = 	"SELECT * FROM v4_OrderDetails 
			 WHERE PickupDate >= '{$from_date}'  
			 AND PickupDate <= '{$to_date}'  
			 AND TransferStatus != '3'
			 AND TransferStatus != '4'  
			 AND TransferStatus != '9' 
			 ORDER BY PickupDate ASC";
$or = $db->RunQuery($query2) or die('No orders');
$o = $or->fetch_object();


echo '<br /><br />';

$cash = 0;
$sum_price = 0;
$sum_extras = 0;
$invoice_sum = 0;
$provision_sum = 0;
$sum_driverextras = 0;
$netto_sum = 0;
$counter = -1;
$i = 0;
$totPayLater = 0;
$totPayNow = 0;
$site = 0;
$agent = 0;
$taxiSite = 0;
$admin = 0;
$api = 0;
$siteTotal = 0;
$apiTotal = 0;
$adminTotal = 0;
$taxiSiteTotal = 0;
$agentTotal = 0;
$user = array();


do { 

$order_date = $o->OrderDate;
$order_price = $o->DetailPrice;


	$invoice_sum += $o->InvoiceAmount;
	$provision_sum += $o->ProvisionAmount;
	$sum_price += $order_price;
	$sum_extras += $o->ExtraCharge;
	$sum_driverextras += $o->DriverExtraCharge;
	$counter++;
	// izbaceno zahtjev Dusica Sri 13 Lip 2018 13:05:49 
	//if($o->DriversPrice == 0) $cijena_vozaca = GetDriverPrice($o->ServiceID);
	//else 
	$cijena_vozaca = $o->DriversPrice;
	
	$trosak_vozaca += $cijena_vozaca;
	
	/*
	$rbr = $o->CardCountry;
		

	if (!is_numeric($rbr)) $rbr = GetCountryIDX($rbr);
	
	if ($rbr == 67) $rbr = 241;
	//echo $rbr;

	if ($rbr) $cntry_amt[$rbr] = $cntry_amt[$rbr]+$o->OrderPrice;
	if ($rbr) $cntry_transfers[$rbr] += 1;
	
	*/

    
   	$totPayNow += $o->PayNow;
   	$totPayLater += $o->PayLater;
 

    $netto = $order_price + $o->ExtraCharge - $o->ProvisionAmount - $cijena_vozaca - $o->DriverExtraCharge;
    $netto_sum += $netto;





	if($o->UserLevelID == 3) {$rowClass="class='success'"; $site += 1; $siteTotal += $order_price;}
	elseif($o->UserLevelID == 2) { $rowClass="class='info'"; $agent += 1; $agentTotal += $order_price;}
	elseif($o->UserLevelID == 12) { $rowClass=""; $taxiSite += 1; $taxiSiteTotal += $order_price;}
	elseif($o->UserLevelID == 6) { $rowClass="class='warning'"; $api += 1; $apiTotal += $order_price;}
	elseif($o->UserLevelID == 1) { $rowClass="class='danger'"; $admin += 1; $adminTotal += $order_price;}
	else $rowClass = '';


		if ($_REQUEST['details']=='checked') {
			
			 if ($o->TransferStatus != 3) { 
			 
			    $user = getUserData($o->UserID);
				$pm=$o->PaymentMethod;
				switch ($pm) {
					case 1:
						$pmn='ONLINE';
						break;
					case 2:
						$pmn='CASH';
						break;
					case 3:
						$pmn='ONLINE + CASH';
						break;						
					case 4:
						$pmn='INVOICE';
						break;				
					case 6:
						$pmn='INVOICE 2';
						break;										
					default:
						$pmn='NOT SELECTED';
				}			 
			 
			    ?>
				<tr <?= $rowClass?>>
		
				<td><div align="right"><? $i++; echo $i;?>.</div></td>
				  <td>
				    <small><? echo ymd2dmy($order_date) ?><br><?= $user['AuthUserCompany']?></small>
				  </td>
				  <td><div align="right"><? echo $pmn; ?></div></td>
				  
				  <td><div align="right">
				  <? echo ymd2dmy($o->PickupDate);?></div></td>			
				  <td><div align="right"><? echo $o->OrderID .'-'.$o->TNo; ?></div></td>   				  
					
				  <td><div align="right"><? echo $order_price; ?></div>
				  <td><div align="right"><? echo $o->ExtraCharge; ?></div>
				  <td><div align="right"><? echo $o->ProvisionAmount; ?></div>
				  <td><div align="right"><? echo $o->InvoiceAmount; ?></div>
				  <?
				  	if($cijena_vozaca == 0 and ($order_price + $o->ProvisionAmount + $o->InvoiceAmount != 0) ) $warning = 'style="background:red;color:white"';
				  	else $warning = '';
				  ?>
				  <td><div align="right" <?= $warning?>><? echo number_format($cijena_vozaca,2); ?></div> 
				  </td>
				   <td><div align="right"><? echo $o->DriverExtraCharge; ?></div>

				  <td><div align="right" <?= $warning?>><? echo number_format($netto,2); ?></div> 
				  </td> 
				</tr>
		<? } 
		} # endif get details ?>

<? } while ($o = $or->fetch_object());
  $rowss = $or->num_rows;
  if($rowss > 0) {
      $or->data_seek(0);
	  $o = $or->fetch_row();
  } 
  

?>    
	   <tr style="height:28px;background: #eee;">
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td><div align="center" class="module_title"><b>Total :</b></div></td>
		  <td align="right"><strong><? echo number_format($sum_price,2,',','.'); ?></strong>
		  <td align="right"><strong><? echo number_format($sum_extras,2,',','.'); ?></strong>

		  <td align="right"><strong><? echo number_format($provision_sum,2,',','.'); ?></strong>
		  <td align="right"><strong><? echo number_format($invoice_sum,2,',','.'); ?></strong>            
		  </td>
		  <td align="right"><strong><? echo number_format($trosak_vozaca,2,',','.'); ?></strong>            
		  </td>
		  <td align="right"><strong><? echo number_format($sum_driverextras,2,',','.'); ?></strong>            
		  </td>		  
		  <td align="right"><strong><? echo number_format($netto_sum,2,',','.'); ?></strong>            
		  </td>
		</tr>  
  </table>

  <p>&nbsp;</p>
  <p><?= LEGEND ?></p>

  <p class="alert alert-danger">
  	<?= $admin ?> <?= ADMIN_ORDERS ?> - <?= number_format($adminTotal,2,',','.'); ?>
  </p>

  <p class="alert alert-warning">
  	<?= $api ?> <?= API_ORDERS?> - <?= number_format($apiTotal,2,',','.'); ?>
  </p>

  <p class="alert alert-info">
  	<?= $agent ?> <?= AGENT_ORDERS ?> - <?= number_format($agentTotal,2,',','.'); ?>
  </p>

  <p class="alert alert-success">
  	<?= $site ?> <?= SITE_ORDERS?> - <?= number_format($siteTotal,2,',','.'); ?>
  </p>

  <p class="alert alert-success xwhite">
  	<?= $taxiSite ?> <?= TAXI_SITE_ORDERS?> - <?= number_format($taxiSiteTotal,2,',','.'); ?>
  </p>

<div class="container lead">
	<div class="row">
		<div class="col-md-4">
			<?= TOTAL_TRANSFERS ?> : 
		</div>
		<div class="col-md-2" align="right">
			<? if($counter > 0) echo $counter+1;  ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<?= CARD ?> :
		</div>
		<div class="col-md-2" align="right">
			<?= number_format($totPayNow,2) ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<?= CASH?> : 
		</div>
		<div class="col-md-2" align="right">
			<?= number_format($totPayLater,2) ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<?= NETTO ?> :
		</div>
		<div class="col-md-2" align="right">
			<? echo number_format($sum_price + $sum_extras - $trosak_vozaca - $provision_sum,2,',','.'); ?>
		</div>
	</div>

</div>

</div>


<a class="btn blue-2" style="position:fixed;bottom:20px;right:20px" 
onclick="$('html, body').animate({scrollTop : 0},800);return false;">
<i class="fa fa-arrow-up"></i>
</a>


<?
} // !empty from_date & to_date

# vraca ime drzave
function GetCountryIDX($country_name)
{
	global $db;
	$q = "SELECT * FROM v4_Countries WHERE CountryName = '".$country_name."'";

	$w = $db->RunQuery($q);
	$c = $w->fetch_object();


	#dodano zbog ruskog
	#  if ($_SESSION['lang == 'ru') return $row_Recordset1['CountryNameRU;
	#  
	return $c->CountryID;
}

