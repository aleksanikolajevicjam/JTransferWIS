<style>
	th,.pm {
		font-size: 14px;
		padding:7px;
	}
	td {
		font-size: 18px;
		padding:5px;
	}	
	


</style>

	{if $type eq 'stat'}

		<style>
			table.tb {
				text-align: right;
				font-size:150%;
				border: 1px solid grey;
				margin:auto;
			}	
			td {
				border: 1px solid grey;	
			}	
		</style>

		<table class='tb'>
			<tr>
				<th>Payment method</th>
				<th> Number </th>
				<th> Price </th>
				<th> Extras </th>
				<th> Agent Prov. </th>			
				<th> Online Prov. </th>			
				<th> Drivers Price </th>
				<th> Drivers Extras </th>
				<th> Gross margin </th>	
				<th> Ratio </th>	
			</tr>
			
			{section name=pom loop=$data}
				<tr>
					<td class='pm'>{$data[pom].title}</td>
					<td>{$data[pom].count}</td>
					<td>{$data[pom].detailprice|number_format:0:'.':','}</td>
					<td>{$data[pom].extracharge|number_format:0:'.':','}</td>
					<td>{$data[pom].provision|number_format:0:'.':','}</td>				
					<td>{$data[pom].onlpr}</td>								
					<td>{$data[pom].driversprice|number_format:0:'.':','}</td>				
					<td>{$data[pom].driverextracharge|number_format:0:'.':','}</td>
					<td>{$data[pom].gm}</td>								
					<td>{$data[pom].gmr}</td>							
				</tr>
			{/section}			 
		</table>
	{/if}
	
	{if $type eq 'list'}
		{assign var="dt" value="" }
		{section name=pom1 loop=$transfer}	
			{if $dt ne $transfer[pom1].date}
				<h5 style='text-align: left;' >{$transfer[pom1].date}</h5>
				{assign var="dt" value=$transfer[pom1].date }
			{/if}	
			<div class='row'>
				<div class="col-md-1">{$transfer[pom1].tn}</div>
				<div style='text-align: left;' class="col-md-3">{$transfer[pom1].link}</div>
			</div>
		{/section}
		
		<script>
		{literal}
			$(".mytooltip").popover({trigger:'hover', html:true, placement:'bottom'});
		{/literal}	
		</script>
	{/if}
    