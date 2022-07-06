
<script type="text/x-handlebars-template" id="ItemListTemplate">

	{{#each Item}}
		<div  onclick="oneItem({{ID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{ID}}">
		
					<div class="col-sm-3">
						<strong>{{co_name}}</strong>
					</div>

					<div class="col-sm-2">
					</div>

					<div class="col-sm-2">
					</div>

					<div class="col-sm-3">
					</div>
			</div>
		</div>
		<div id="ItemWrapper{{ID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{ID}}" class="row">
				<div id="one_Item{{ID}}" >
					<?= LOADING ?>
				</div>
			</div>
		</div>

	{{/each}}


</script>
	
