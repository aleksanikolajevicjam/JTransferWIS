
<script type="text/x-handlebars-template" id="v4_DriverRoutesListTemplate">

	{{#each v4_DriverRoutes}}
		<div  onclick="one_v4_DriverRoutes({{ID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{ID}}">
		
					<div class="col-md-3">
						<strong>{{ID}}</strong>
					</div>

					<div class="col-md-9">
						<strong>{{RouteName}}</strong>
					</div>
			</div>
		</div>
		<div id="v4_DriverRoutesWrapper{{ID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{ID}}" class="row">
				<div id="one_v4_DriverRoutes{{ID}}" >
					<?= LOADING ?>
				</div>
			</div>
		</div>

	{{/each}}


</script>
	
