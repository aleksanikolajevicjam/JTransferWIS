	<div class="row white">						
		<div class="col-md-3"><h5><strong>Road Distance:</strong> <?= $roaddistance ?>km</h5></div>
		<div class="col-md-3"><h5><strong>Air Distance:</strong> <?= nf($airdistance) ?>km</h5></div>				
		<div class="col-md-3"><h5><strong>Duration:</strong> <?= $Duration ?>min</h5></div>											
		<div class="col-md-3"><h5><strong>Elevation Diff:</strong> <?= $ElevationDiff ?>m</h5></div> 
		<div class="col-md-3"><h5><strong>Curvatore coef:</strong> <?= nf($Km/$airdistance) ?></h5></div> 
		<div class="col-md-3"><h5><strong>Elev.Diff per km:</strong> <?= nf($ElevationDiff/$Km) ?>m</h5></div> 

	</div>
	<div class="row white">		
		<span>Terminal area:</span><b> <?= $TerminalName ?> </b><br>	
		<span>Booked tranfers for <?= $transferDate ?>:</span><b> <?=$numberTfuture ?></b><br>
		<span>Booked tranfers for <?= $pastDate ?>:</span><b> <?=$numberTpast ?></b><br>		
		<span>Number of Flights <?= $direct ?> for <?= $transferDate ?>:</span> <i>will be from external data set</i><br>								
		<span>Average cost for adds:</span> <i>will be from new data set</i><br>				
		<span>Average market price for this route:</span> <i>will be from new data set</i>								
		
	</div>			
