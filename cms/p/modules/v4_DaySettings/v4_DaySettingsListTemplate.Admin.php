
<script type="text/x-handlebars-template" id="v4_DaySettingsListTemplate">

	{{#each v4_DaySettings}}
		<div  onclick="one_v4_DaySettings({{ID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{ID}}">
		
					<div class="col-sm-3">
						<strong>{{ID}}</strong>
					</div>

					<div class="col-sm-2">
						{{OwnerID}}
					</div>

					<div class="col-sm-2">
					</div>

					<div class="col-sm-3">
					</div>
			</div>
		</div>
		<div id="v4_DaySettingsWrapper{{ID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{ID}}" class="row">
				<div id="one_v4_DaySettings{{ID}}" >
					<?= LOADING ?>
				</div>
			</div>
		</div>

	{{/each}}


</script>
	
