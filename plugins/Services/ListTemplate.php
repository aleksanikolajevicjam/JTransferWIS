<script type="text/x-handlebars-template" id="ItemListTemplate">


	{{#each Item}}
	
			<div  onclick="oneItem({{ServiceID}});">		
				<div class="row {{color}} pad1em listTile" 
				style="border-top:1px solid #ddd" 
				id="t_{{ServiceID}}">
						
						<div class="col-sm-1">
							{{ServiceID}}
						</div>							
						<div class="col-sm-4">
							{{RouteName}}
						</div>							
						<div class="col-sm-3">
							{{VehicleTypeName}}
						</div>						
						<div class="col-sm-2">
							{{ServicePrice1}}
						</div>	
						<div class="col-md-2"> 
							<small><i class="fa fa-arrow-circle-up"></i> {{surCategory SurCategory}}</small>
						</div>						
	
				</div>
			</div>
			<div id="ItemWrapper{{ServiceID}}" class="editFrame" style="display:none">
				<div id="inlineContent{{ServiceID}}" class="row">
					<div id="one_Item{{ServiceID}}" >
						<?= LOADING ?>
					</div>
				</div>
			</div>
	
	{{/each}}


</script>
	
