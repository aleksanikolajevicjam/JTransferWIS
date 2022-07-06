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
	<table><tr><th>number_key</th><th>Name</th><th>Email</th><th>Time</th><th>EUR</th><!--<th>Status</th>!--></tr>
	{section name=index loop=$payments}
	<tr>
		<td>&shy; {$payments[index].MOrderKey}  </td>
		<td>&shy; {$payments[index].MPaxFirstName} {$payments[index].MPaxLastName} </td>
		<td>&shy; {$payments[index].MPaxEmail} </td>
		<td>&shy; {$payments[index].MOrderDate} {$payments[index].MOrderTime} </td>
		<td>&shy; {$payments[index].MPayNow} </td>
		<!--<td>&shy; {$payments.MPaymentStatus} </td>!-->
	</tr>			
	{/section}
	</table>
		</div>
	</div>	