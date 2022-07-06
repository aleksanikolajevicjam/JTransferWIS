<?
	require_once ROOT . '/db/db.class.php';
	$db = new DataBaseMysql();
	
	$u = getUser($_SESSION['AuthUserID']);
	$provision = $u->Provision;
?>
<div class="xblue" style="margin-top:-70px; min-height:1080px">
<br><br>
<div class="container xwhite pad1em shadowMedium"><div class="row">
	<div class="row">
		<div class="lead" align="center">
			<br>
			<p class="l"><?= Logo('black') ?></p>
		</div>
	</div>
  
  	<div class="row">
		<div class="l col-md-12 ucase center">
			<strong><?= $_SESSION['UserName']?></strong> affiliate orders - All
			<br><br>
		</div>
	</div>
  
  <table class="table table-striped">
  	<thead>
    <tr>
      <th>Order date</th>
      <th><div align="center">Customer/OrderID</div></th>
      <th><div align="right">Order Amount (EUR)</div></th>
    </tr>
    </thead>
    
<? 

$q="SELECT * FROM v4_OrderDetails WHERE UserID = ".$_SESSION['AuthUserID']."
		 AND TransferStatus != '3' 
		 AND TransferStatus != '4' 
		 AND TransferStatus != '9' 
		 AND UserLevelID = '4' 
		 ORDER BY OrderDate DESC";
$w = $db->RunQuery($q);// or die('No orders');

$sum_price = 0;


while ($od = $w->fetch_object() ) {

	$order_date = $od->OrderDate;
	$order_customer = $od->PaxName;
	$order_price = $od->DetailPrice;
	$sum_price += $order_price;
	?>    
    
    <tr>
      <td><? echo $order_date; ?></td>
      <td><div align="center">
      	<? echo $order_customer; ?><br>
      	<?= $od->OrderID . '-' . $od->TNo ;?>
      </div></td>
      <td><div align="right"><? echo $order_price; ?></div>
      </td>
    </tr>

	<? 
} 

if($sum_price == 0) {
	echo '<tr><td colspan="3" class="center red"><br><strong>No Orders Found</strong><br><br></td></tr>';
}

?>    
   <tr>
      <td>&nbsp;</td>
      <td><div align="right">Total :</div></td>
      <td ><strong><div align="right"><? echo number_format($sum_price,2,',','.'); ?></strong></div>
      </td>
    </tr>  
   <tr>
      <td>&nbsp;</td>
      <td><div align="right" class="module_title"><strong>Provision :</strong></div></td>
      <td ><strong><div align="right"><? echo number_format(($sum_price*$provision / 100),2,',','.'); ?></strong></div>
      </td>
    </tr>  

  </table>
  <p>&nbsp;</p>
<div class="row">
<div class="col-md-12 center">
  <?
echo 'Your User Name: '.$_SESSION['UserName'];
echo '<br />';
echo 'Your Affiliate ID: '.$_SESSION['AuthUserID'];
echo '<br />';

echo 'Provision: '.$provision .'%';
echo '<br /><br>';
echo 'Your affiliate link:<br><strong> &lt;a href="https://www.jamtransfer.com/home?userid='.$_SESSION['AuthUserID'].
	 '"&gt;jamtransfer.com - Airport Taxi Transfers&lt;/a&gt;</strong>'; 
//Show_Stats($userid);
?>  
<br><br>
NOTE:
<br>
If you see this icon and number:<br> 
<i class="fa fa-server"></i> <?= $_SESSION['AuthUserID']?><br> 
on the bottom right of our homepage (after clicking on your Affilate Link),<br>
that means your Affilate Account is connected and active.
<br><br><br>
        <div class="pull-right">
            <a href="logout.php" class="btn blue btn-flat"><?= SIGN_OUT ?></a>
        </div> 
<br><br><br>   
</div>
</div>  
</div></div>

<br><br>
<div class="container center black">
	<br><h2>Banners</h2><br>
	<?
		// prikaz slika iz foldera
		$folderPath = "../../banners/";
		$images = scandir($folderPath, 1);
		foreach ($images as $key => $image) {
			if (strpos($image,".jpg") or strpos($image,".png")) {
				echo '<div class="">';
				echo '<img src="https://banners.jamtransfer.com/'.$image.'"><br><br>';
				echo '&lt;a href="https://www.jamtransfer.com/home?userid='.$_SESSION['AuthUserID'].'"&gt;&lt;img src="https://banners.jamtransfer.com/'.$image.'"&gt;&lt;/a&gt;';
				echo '</div><hr style="border-color: white">';
			}
		}
	?>
</div>

</div>
