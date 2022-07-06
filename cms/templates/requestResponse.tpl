
<link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="../css/ionicons.min.css" rel="stylesheet" type="text/css"/>

		<link href="../css/morris/morris.css" rel="stylesheet" type="text/css"/>



		<form action="" method='post'>

			
			
	
				<h3>REQUEST FOR TRANSFER {$data[0].ID}</h3>
				<table>
				<tr>	
					<td><b>Request type:</b></td>
					<td>{if $data[0].RequestType eq 2}	<span class="l">Low offer</span>{else} <span class="l">First confirm</span>	{/if}</td>
				</tr>
				
				<tr>
					<div class="col-md-3 "><label>Order ID</label></div>
					<div class="col-md-9">
						{$data[0].OrderID}
						{if $data[0].ReturnTime ne 0}<i class="fa fa-exchange"></i>{/if}
					</div>
				</tr>		
				<tr>
					<div class="col-md-3 "><label>Request Time</label></div>
					<div class="col-md-9">
						{$data[0].RequestDate} / {$data[0].RequestTime} 					
					</div>
				</tr>	
				<tr>
					<div class="col-md-3 "><label>Response Time</label></div>
					<div class="col-md-9">
						{if $data[0].ConfirmDecline gt 0}	{$data[0].ResponseDate} / {$data[0].ResponseTime} {/if}						
					</div>
				</tr>					
				<tr>
					<div class="col-md-3 "><label>Pickup Name</label></div>
					<div class="col-md-9">
						<span class="l">{$data[0].PickupName}</span>
					</div>
				</tr>
				<tr>
					<div class="col-md-3 "><label>Drop Name</label></div>
					<div class="col-md-9">
						<span class="l">{$data[0].DropName}</span>
					</div>
				</tr>				
				<tr>
					<div class="col-md-3 "><label>Pickup Time</label></div>
					<div class="col-md-9">
						<span class="l">{$data[0].PickupTime}</span>					
					</div>
				</tr>	
				{if $data[0].ReturnTime ne 0}
				<tr>
					<div class="col-md-3 "><label>Return Time</label></div>
					<div class="col-md-9">
						<span class="l">{$data[0].ReturnTime}</span>					
					</div>
				</tr>					
				{/if}
				
				<tr>
					<div class="col-md-3 "><label>Vehicle Type</label></div>
					<div class="col-md-9">
						<i class="fa fa-car"></i> {$data[0].VehicleType}					
					</div>
				</tr>			
				<tr>
					<div class="col-md-3 "><label>Pax No</label></div>
					<div class="col-md-9">
						{$data[0].PaxNo}				
					</div>
				</tr>	
				{if !empty($data[0].Extras)}				
				<tr>
					<div class="col-md-3 "><label>Extras</label></div>
					<div class="col-md-9">
						<tr>
							<div class="col-md-6">
								<label>Service Name</label>	
							</div>	
							<div class="col-md-6">
								<label>Qty</label>	
							</div>								
						</div>						
						{section name=pom1 loop=$data[0].Extras}
						<tr>
							<div class="col-md-6">
								{$data[0].Extras[pom1].ServiceName}	
							</div>	
							<div class="col-md-6">
								{$data[0].Extras[pom1].Qty}	
							</div>								
						</div>		
						{/section}	
					</div>
				</tr>	
				<br>
				{/if}	
				<tr>
					<div class="col-md-3 "><label>Payment Method</label></div>
					<div class="col-md-9">
						{$data[0].PaymentMethod}				
					</div>
				</tr>						
				{if $data[0].RequestType eq 2}					
					<tr>
						<div class="col-md-3 "><label>Your Price</label></div>
						<div class="col-md-9">
						{if $data[0].ConfirmDecline gt 0} 
							<span class="l">{$data[0].Price} {if $data[0].ConfirmDecline eq 1}ENTERED{/if}	</span>			
						{else}	
							<input type='text' name='Price' value=''/>	<br>	
							{if $data[0].ConfirmDecline eq 0} <b class='red'>PLEASE, ENTER YOUR PRICE FOR THIS TRANSFER</b>{/if}	
						{/if}
						</div>
					</tr>					
					{else}
					<tr>
						<div class="col-md-3 "><label>Requested Price</label></div>
						<div class="col-md-9">
							<span class="l">{$data[0].DriversPrice} {if $data[0].ConfirmDecline eq 1}ACCEPTED{/if}</span>							
						</div>
					</tr>		
					{if $data[0].ConfirmDecline eq 0} 
						<b class='red'>PLEASE, CONFIRM TRANSFER IF THIS PRICE SUIT YOU WELL</b>
					{/if}
				{/if}
				
			</div>
			<div class="col-md-1">	
				{if $data[0].ConfirmDecline eq 0} 
					<button title='Confirm'  class="btn btn-success" type='submit'><i class="fa fa-check l"></i>CONFIRM</button>
				{/if}	
			</div>					
			<input name="ConfirmDecline" type='hidden' value='1'/>
			<input name="ID" type='hidden' value='{$data[0].ID}'/>		

			
		
		</form>
	

