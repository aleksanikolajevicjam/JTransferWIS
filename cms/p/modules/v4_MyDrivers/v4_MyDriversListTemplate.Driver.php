
<script type="text/x-handlebars-template" id="v4_MyDriversListTemplate">

	{{#each v4_MyDrivers}}
		<div  onclick="one_v4_MyDrivers({{DriverID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{DriverID}}">
		
					<div class="col-md-1">
						<strong>{{DriverID}}</strong>
					</div>

					<div class="col-md-3">
						{{DriverName}}
					</div>

					<div class="col-md-3">
						{{DriverTel}}<br>
						{{DriverEmail}}
					</div>

					<div class="col-md-3">
						{{Notes}}
					</div>
			</div>
		</div>
		<div id="v4_MyDriversWrapper{{DriverID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{DriverID}}" class="row">
				<div id="one_v4_MyDrivers{{DriverID}}" >
					<?= LOADING ?>
				</div>
			</div>
		</div>

	{{/each}}


</script>
	
