<form name="approvedFuelPrice" method="post" action="">
	<div class="container">
		<div class="box box-info pad1em shadowLight">
		<br>
			<div {$style1} class="row">
				<div class="col-md-3">
					<label>Nice:</label>
				</div>		
				<div class="col-md-6">
					<input type="text" name="approvedFuelPrice1" value="{$afp1}"> 		
				</div>	
			</div>
			<div {$style2} class="row">
				<div class="col-md-3">
					<label>Lyon:</label>
				</div>		
				<div class="col-md-6">
					<input type="text" name="approvedFuelPrice2" value="{$afp2}"> 		
				</div>	
			</div>	
			<div {$style3} class="row">
				<div class="col-md-3">
					<label>Split:</label>
				</div>		
				<div class="col-md-6">
					<input type="text" name="approvedFuelPrice3" value="{$afp3}"> 		
				</div>	
			</div>		
			<button name="setRate" type="submit" class="btn btn-primary " value="1">{$SET_NEW_RATE}</button>
		</div>
	</div>
</form>