
<script type="text/x-handlebars-template" id="v4_SubVehiclesListTemplate">

	{{#each v4_SubVehicles}}
		<div  onclick="one_v4_SubVehicles({{VehicleID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{VehicleID}}">
		
					<div class="col-md-4">
						<strong>{{VehicleID}}</strong>
					</div>

					<div class="col-md-4">
						{{VehicleDescription}}
					</div>

					<div class="col-md-4">
						{{VehicleCapacity}}
					</div>
			</div>
		</div>
		<div id="v4_SubVehiclesWrapper{{VehicleID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{VehicleID}}" class="row">
				<div id="one_v4_SubVehicles{{VehicleID}}" >
					<?= LOADING ?>
				</div>
			</div>
		</div>

	{{/each}}


</script>
	
