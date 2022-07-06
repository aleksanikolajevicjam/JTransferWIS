<?
	require_once '../db/db.class.php';
	$db = new DataBaseMysql();
	$time=date("Y-m-d",time()-48*3600);
	$query="SELECT * FROM `v4_OrdersMasterTemp` WHERE `MOrderDate`>'".$time."' and `MPaymentMethod` in (1,3) and `MOrderKey` not in (SELECT `MCardNumber` FROM `v4_OrdersMaster` WHERE `MOrderDate`>'".$time."'  and `MPaymentMethod` in (1,3)) and `MPayNow`>0";
	//`MPaymentStatus`=1 and 
	$result = $db->RunQuery($query); 
	
	?>
	<style>
		table {
			border: 1px solid black;
		}


		td, th {
			border: 1px solid black;
			text-align: center;
		}	
	</style>
    <div class="box box-info">
        <div class="box-header">
            <i class="fa fa-credit-card"></i>
            <h3 class="box-title">Unfinished online payment</h3>
		</div>	
		<div class="box-body">
	<table><tr><th>number_key</th><th>Name</th><th>Email</th><th>Time</th><th>EUR</th><th>Status</th></tr><?
	while($row = $result->fetch_array(MYSQLI_ASSOC)){ 
	?>
	<tr>
		<td>&shy; <?= $row["MOrderKey"] ?>  </td>
		<td>&shy; <?= $row["MPaxFirstName"] ?> <?= $row["MPaxLastName"] ?> </td>
		<td>&shy; <?= $row["MPaxEmail"] ?> </td>
		<td>&shy; <?= $row["MOrderDate"] ?> <?= $row["MOrderTime"] ?> </td>
		<td>&shy; <?= $row["MPayNow"] ?> </td>
		<td>&shy; <?= $row["MPaymentStatus"] ?> </td>
	</tr>			
	<?
	}
	?>
	</table>
		</div>
	</div>	