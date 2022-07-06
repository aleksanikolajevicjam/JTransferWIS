
<script type="text/x-handlebars-template" id="v4_EquipmentListTemplate">

	{{#each v4_Equipment}}
		<div  onclick="one_v4_Equipment({{ID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{ID}}">
		
					<div class="col-md-1">
						<strong>{{ID}}</strong>
					</div>

					<div class="col-md-4">
						{{Title}}
					</div>

			</div>
		</div>
		<div id="v4_EquipmentWrapper{{ID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{ID}}" class="row">
				<div id="one_v4_Equipment{{ID}}" >
					<?= LOADING ?>
				</div>
			</div>
		</div>

	{{/each}}


</script>
	
