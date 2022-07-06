<table width="99%" style="border:none;">
	<tr>
		<td align="center">
			<table id="calendarTable" width="100%" border="0" cellpadding="0" cellspacing="0"  class="table">
				<thead>
					<th style="width:14%; background:#FDB5B5"><strong>{$dayNames[0]}</strong></th>
					<th style="width:14%; background:#f2f2f2"><strong>{$dayNames[1]}</strong></th>
					<th style="width:14%; background:#f2f2f2"><strong>{$dayNames[2]}</strong></th>
					<th style="width:14%; background:#f2f2f2"><strong>{$dayNames[3]}</strong></th>
					<th style="width:14%; background:#f2f2f2"><strong>{$dayNames[4]}</strong></th>
					<th style="width:14%; background:#f2f2f2"><strong>{$dayNames[5]}</strong></th>
					<th style="width:14%; background:#ABF1A6"><strong>{$dayNames[6]}</strong></th>
				</thead>
				{section name=pom loop=$month_transfers}
					{if $month_transfers[pom].dayofweek eq '0'} <tr>{/if}
					{if $month_transfers[pom].dayofweek eq '-1'} <td></td>
					{else}
						<td valign="top" class="cal_cell" {$style}><div class="cal_days l"><b>{$month_transfers[pom].nom}
							</b></div><br /><small>
							{section name=pom2 loop=$month_transfers[pom].transfers}
								{if $month_transfers[pom].transfers[pom2].TransferStatus eq '1'} <span class="text-blue"><i class="fa fa-circle-o"></i></span>
								{else if $month_transfers[pom].transfers[pom2].TransferStatus eq '2'} <span class="text-orange"><i class="fa fa-circle-o"></i></span>
								{else if $month_transfers[pom].transfers[pom2].TransferStatus eq '3'} <span style="color: #c00"><i class="fa fa-times-circle"></i></span>
								{else if $month_transfers[pom].transfers[pom2].TransferStatus eq '4'} <span class="text-orange"><i class="fa fa-question-circle"></i></span>
								{else if $month_transfers[pom].transfers[pom2].TransferStatus eq '5'} <span class="text-green"><i class="fa fa-check-circle"></i></span>
								{else} <span style="color: #c00"><i class="fa fa-question"></i></span> {/if}
							
								{if $month_transfers[pom].transfers[pom2].DriverConfStatus eq '1'} <span style="color:#c00"><i class="fa fa-car"></i></span>
								{else if $month_transfers[pom].transfers[pom2].DriverConfStatus eq '2'} <span class="text-orange"><i class="fa fa-info-circle"></i></span>
								{else if $month_transfers[pom].transfers[pom2].DriverConfStatus eq '3'} <span class="text-blue"><i class="fa fa-car"></i></span>
								{else if $month_transfers[pom].transfers[pom2].DriverConfStatus eq '4'} <span style="color:#c00"><i class="fa fa-thumbs-down"></i></span>
								{else if $month_transfers[pom].transfers[pom2].DriverConfStatus eq '5'} <span style="color:#c00"><i class="fa fa-user-times"></i></span>
								{else if $month_transfers[pom].transfers[pom2].DriverConfStatus eq '6'} <span style="color:#c00"><i class="fa fa-black-tie"></i></span>
								{else if $month_transfers[pom].transfers[pom2].DriverConfStatus eq '7'} <span class="text-green"><i class="fa fa-check-square"></i></span>
								{else}{/if}
								
								{$month_transfers[pom].transfers[pom2].PickupTime}&rarr;
								<a href="editActiveTransfer/{$month_transfers[pom].transfers[pom2].DetailsID}"
								title="<b>{$month_transfers[pom].transfers[pom2].OrderID}-{$month_transfers[pom].transfers[pom2].TNo} - {$month_transfers[pom].transfers[pom2].PaxName} </b>" 
								data-content="
									<br/>{$FLIGHT_NO}: {$month_transfers[pom].transfers[pom2].FlightNo}
									<br>{$FLIGHT_TIME}: {$month_transfers[pom].transfers[pom2].FlightTime}
									<br/>{$FROM}: {$month_transfers[pom].transfers[pom2].PickupName}
									<br/>{$TO}: {$month_transfers[pom].transfers[pom2].DropName}
									<br/>{$DRIVER}: {$month_transfers[pom].transfers[pom2].DriverName}
									<br/>{$TRANSFER_STATUS}: {$StatusDescription[{$month_transfers[pom].transfers[pom2].TransferStatus}]}
									<br/>{$DriverConfStatus[{$month_transfers[pom].transfers[pom2].DriverConfStatus}]}
								" 
								class="mytooltip">
									{$month_transfers[pom].transfers[pom2].OrderID}-{$month_transfers[pom].transfers[pom2].TNo}
								</a><br/>
							{/section}
							<br><small style="font-size:14px">No of transfers: {$month_transfers[pom].noOfTransfers}</small>
							</small></td>
					{/if}
					{if $month_transfers[pom].dayofweek eq '6'} </tr> {/if}
				{/section}
			</table>
		</td>
	</tr>
</table>
<div class="dashboard-legend">
	Transfer status:
	<ul>
		<i class="fa fa-circle-o text-blue"></i> Active |
		<i class="fa fa-circle-o text-orange"></i> Changed |
		<i class="fa fa-question-circle text-orange"></i> Temp |
		<i class="fa fa-times-circle" style="color:#c00"></i> Cancelled |
		<i class="fa fa-check-circle text-green"></i> Completed<br>
	</ul><br>
	Driver confirmation status:
	<ul>
		<i class="fa fa-car" style="color:#c00"></i> No driver |
		<i class="fa fa-info-circle text-orange"></i> Not Confirmed |
		<i class="fa fa-thumbs-up text-blue"></i> Confirmed |
		<i class="fa fa-car text-blue"></i> Ready |
		<i class="fa fa-thumbs-down" style="color:#c00"></i> Declined |
		<i class="fa fa-user-times" style="color:#c00"></i> No-show |
		<i class="fa fa-black-tie" style="color:#c00"></i> Driver error |
		<i class="fa fa-check-square text-green"></i> Completed
	</ul>
</div>

<script>
{literal}
	$(".mytooltip").popover({trigger:'hover', html:true, placement:'bottom'});
{/literal}	
</script>