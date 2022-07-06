<script type="text/x-handlebars-template" id="ItemListTemplate">
	{{#each Item}}
		<div  onclick="oneItem({{CountryID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{CountryID}}">
				<div class="col-md-1">
					<strong>{{CountryID}}</strong>
				</div>

				<div class="col-md-4">
					<strong>{{CountryNameEN}}</strong>
				</div>

				<div class="col-md-4">
					{{CountryNameRU}}
				</div>

				<div class="col-md-1">
					{{CountryCode3}}
				</div>
			</div>
		</div>
		<div id="ItemWrapper{{CountryID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{CountryID}}" class="row">
				<div id="one_Item{{CountryID}}" >
					<?= LOADING ?>
				</div>
			</div>
		</div>

	{{/each}}
</script>