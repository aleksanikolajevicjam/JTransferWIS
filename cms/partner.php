<?
session_start();
/*
$_SESSION['InitialRequest'] = 'http://www.jamtransfer.com/cms/partner.php';
#
	$host = 'localhost';
	$user = 'jamtrans_cezar';
	$pass = '3WLRAFu;E_!F';
	$db   = 'jamtrans_touradria';
$conn = mysql_connect($host,$user,$pass);
mysql_select_db($db);
*/

require_once ROOT . '/f/f.php';

if (isset($_REQUEST['logout'])) {session_destroy();session_start();}

//$_SESSION['UserAuthorized'] = false; $_SESSION['AuthUserID'] = '';
# provjera pristupa

//require_once 'login.php';

if (!isset($_SESSION['UserAuthorized']) or !$_SESSION['UserAuthorized']) {
	require_once 'login.php';
} else {


if($_SESSION['AuthLevelID'] == '4' or $_SESSION['AuthLevelID'] == '5') {
$userid = $_SESSION['AuthUserID'];
$username = $_SESSION['UserName'];

}
else die('Not available for now.');


echo $userid;

//require_once('cms/bogo/Connections/bogo.php'); 
//mysql_select_db($database_bogo, $bogo);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Affiliate Partner's Orders</title>
<link href="<?= ASSETS ?>css/cerulean.min.css" rel="stylesheet">

<link href="<?= ASSETS ?>bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
</head>

<body>
<div class="container xmaster_table"><div class="row">
	<div class="row">
		<div class="lead" align="center">
			<br>
			<p class="lead"><h1 style="font-weight:300"><strong>jam</strong>transfer.com</h1></p>
		</div>
	</div>
  
  	<div class="row">
		<div class="alert alert-info">
			<strong><?= $username?></strong> orders - All
		</div>
	</div>
  
  <table class="table table-striped">
  	<thead>
    <tr>
      <th>Order date</th>
      <th><div align="center">Customer</div></th>
      <th><div align="right">Order Amount (EUR)</div></th>
    </tr>
    </thead>
    
<? 

$query2="SELECT * FROM v4_OrderDetails WHERE v4_OrderDetails.UserID = ".$userid."
		 AND v4_OrderDetails.TransferStatus != '3' 
		 ORDER BY v4_OrderDetails.OrderDate DESC";
$s_query_result = mysql_query($query2) or die('No orders');
//$rec_s = mysql_fetch_assoc($s_query_result);

$sum_price = 0;


while ($rec_s = mysql_fetch_assoc($s_query_result)) {

	$order_date = $rec_s['OrderDate'];
	$order_customer = $rec_s['PaxName'];
	$order_price = $rec_s['DetailPrice'];
	$sum_price += $order_price;
	?>    
    
    <tr>
      <td><? echo $order_date; ?></td>
      <td><div align="center"><? echo $order_customer; ?></div></td>
      <td><div align="right"><? echo $order_price; ?></div>
      </td>
    </tr>

	<? 
} 

?>    
   <tr>
      <td>&nbsp;</td>
      <td><div align="center" class="module_title">Total :</div></td>
      <td ><strong><div align="right"><? echo number_format($sum_price,2,',','.'); ?></strong></div>
      </td>
    </tr>  
   <tr>
      <td>&nbsp;</td>
      <td><div align="center" class="module_title"><strong>Provision :</strong></div></td>
      <td ><strong><div align="right"><? echo number_format(($sum_price*$_SESSION['Provision'] / 100),2,',','.'); ?></strong></div>
      </td>
    </tr>  

  </table>
  <p>&nbsp;</p>

  <p><a href="/partner.php?logout" target="_self" class="btn btn-primary">Logout</a></p>
  
  <?
echo 'Your User Name: '.$username;
echo '<br />';
echo 'Your User ID: '.$userid;
echo '<br />';

echo 'Provision: '.$_SESSION['Provision'] .'%';  
//Show_Stats($userid);
?>  
</div></div>
</body>
</html>
<? } ?>
