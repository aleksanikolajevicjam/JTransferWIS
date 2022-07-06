
<script type="text/x-handlebars-template" id="v4_SubDriversListTemplate">

	{{#each v4_SubDrivers}}
		<div  onclick="one_v4_SubDrivers({{DriverID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{DriverID}}">
		
					<div class="col-md-3">
						<strong>{{DriverID}}</strong>
					</div>

					<div class="col-md-3">
						{{DriverName}}
					</div>

					<div class="col-md-3">
						{{DriverEmail}}
					</div>

					<div class="col-md-3">
						{{DriverTel}}
					</div>
			</div>
		</div>
		<div id="v4_SubDriversWrapper{{DriverID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{DriverID}}" class="row">
				<div id="one_v4_SubDrivers{{DriverID}}" >
					<?= LOADING ?>
				</div>
			</div>
		</div>

	{{/each}}


</script>
