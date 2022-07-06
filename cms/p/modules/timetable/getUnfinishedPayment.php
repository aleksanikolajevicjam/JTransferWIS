<?
	require_once '../db/db.class.php';
	$db = new DataBaseMysql();
	$time=date("Y-m-d",time()-48*3600);
	$query="SELECT * FROM `v4_OrdersMasterTemp` WHERE `MOrderDate`>'".$time."' and `MPaymentMethod` in (1,3) and `MOrderKey` not in (SELECT `MCardNumber` FROM `v4_OrdersMaster` WHERE `MOrderDate`>'".$time."'  and `MPaymentMethod` in (1,3)) and `MPayNow`>0";
	$result = $db->RunQuery($query); 
	
	?><table><tr><th>number_key</th><th>Name</th><th>Email</th><th>Time</th></tr><?
	while($row = $result->fetch_array(MYSQLI_ASSOC)){ 
	?>
	<tr>
		<td><?= $row["MOrderKey"] ?></td>
		<td><?= $row["MPaxFirstName"] ?> <?= $row["MPaxLastName"] ?></td>
		<td><?= $row["MPaxEmail"] ?></td>
		<td><?= $row["MOrderDate"] ?> <?= $row["MOrderTime"] ?></td>
	</tr>			
	<?
	}
	?>
	</table>	
