
<script type="text/x-handlebars-template" id="ItemListTemplate">
		<div id="ItemWrapperNew" class="editFrame" style="display:none">
			<div id="inlineContentNew" class="row">
				<div id="new_Item" >
					<?= LOADING ?>
				</div>
			</div>
		</div>
	{{#each Item}}
		<div  onclick="oneItem({{ID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{ID}}">
		
					<div class="col-md-1">
						<strong>{{ID}}</strong>
					</div>

					<div class="col-md-1">
						<strong>{{Language}}</strong>
					</div>

					<div class="col-md-4">
						<strong>{{Title}}</strong>
					</div>
					<div class="col-md-2">
						<strong>{{Page}}</strong>
					</div>
					<div class="col-md-1">
						<strong>{{Position}}</strong>
					</div>					

					<div class="col-md-1">
						{{#compare Published ">" 0}}
							<i class="fa fa-circle text-green"></i>
						{{else}}
							<i class="fa fa-circle text-red"></i>
						{{/compare}}					
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
	
