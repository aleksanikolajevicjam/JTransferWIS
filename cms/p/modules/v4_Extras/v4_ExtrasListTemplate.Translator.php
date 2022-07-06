<script type="text/x-handlebars-template" id="v4_ExtrasListTemplate">
	{{#each v4_Extras}}
		<div  onclick="one_v4_Extras({{ID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{ID}}">
					<div class="col-md-2">
						<strong>{{OwnerID}}</strong><br>
						<small>{{OwnerName}}</small>
					</div>
					<div class="col-md-2">
						<strong>{{ServiceEN}}</strong>
					</div>

					<div class="col-md-2">
						{{ServiceRU}}
					</div>

					<div class="col-md-2">
						{{ServiceFR}}
					</div>

					<div class="col-md-2">
						{{ServiceDE}}
					</div>

					<div class="col-md-2">
						{{ServiceIT}}
					</div>
			</div>
		</div>
		<div id="v4_ExtrasWrapper{{ID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{ID}}" class="row">
				<div id="one_v4_Extras{{ID}}" >
					<?= LOADING ?>
				</div>
			</div>
		</div>

	{{/each}}
</script>

