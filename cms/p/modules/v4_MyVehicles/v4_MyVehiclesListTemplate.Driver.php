
<script type="text/x-handlebars-template" id="v4_MyVehiclesListTemplate">

	{{#each v4_MyVehicles}}
		<div  onclick="one_v4_MyVehicles({{VehicleID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{VehicleID}}">
		
					<div class="col-md-1">
						<strong>{{VehicleID}}</strong>
					</div>

					<div class="col-md-3">
						{{VehicleName}}
					</div>

					<div class="col-md-2">
						<i class="fa fa-user"></i> {{VehicleCapacity}}
					</div>

					<div class="col-md-3">
						{{VehicleDescription}}
					</div>
			</div>
		</div>
		<div id="v4_MyVehiclesWrapper{{VehicleID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{VehicleID}}" class="row">
				<div id="one_v4_MyVehicles{{VehicleID}}" >
					<?= LOADING ?>
				</div>
			</div>
		</div>

	{{/each}}


</script>
	
