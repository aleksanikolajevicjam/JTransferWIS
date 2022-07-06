
<script type="text/x-handlebars-template" id="v4_VehiclesListTemplate">

	{{#each v4_Vehicles}}
		<div  onclick="one_v4_Vehicles({{VehicleID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{VehicleID}}">
		
					<div class="col-md-1">
						<strong>{{VehicleID}}</strong>
					</div>

					<div class="col-md-4">
						{{AuthUserRealName}}
					</div>

					<div class="col-md-5">
						<i class="fa fa-user"></i> {{VehicleCapacity}} | {{VehicleName}}
						
					</div>

					<div class="col-md-2">
						{{ReturnDiscount}}% &nbsp; 
						<small><i class="fa fa-arrow-circle-up"></i> {{surCategory SurCategory}}</small>
					</div>
			</div>
		</div>
		<div id="v4_VehiclesWrapper{{VehicleID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{VehicleID}}" class="row">
				<div id="one_v4_Vehicles{{VehicleID}}" >
					<?= LOADING ?>
				</div>
			</div>
		</div>

	{{/each}}


</script>
	
