<script type="text/x-handlebars-template" id="v4_ExtrasListTemplate">

	{{#each v4_Extras}}
		<div  onclick="one_v4_Extras({{ID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{ID}}">
					<div class="col-sm-6">
						{{ServiceEN}}
					</div>

					<div class="col-sm-6">
						{{Price}} €
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

