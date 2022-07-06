
<script type="text/x-handlebars-template" id="v4_DriversListTemplate">

	{{#each v4_Drivers}}
		<div  onclick="one_v4_Drivers({{DriverID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{DriverID}}">
		
					<div class="col-sm-1">
						<strong>{{DriverID}}</strong>
					</div>

					<div class="col-sm-4">
						{{Ime}} {{Prezime}}
						<br>
						{{Email}}
					</div>

					<div class="col-sm-3">
						{{City}} {{Country}} 
					</div>

					<div class="col-sm-4">
						{{Company}}
					</div>
			</div>
		</div>
		<div id="v4_DriversWrapper{{DriverID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{DriverID}}" class="row">
				<div id="one_v4_Drivers{{DriverID}}" >
					<?= LOADING ?>
				</div>
			</div>
		</div>

	{{/each}}


</script>
	
