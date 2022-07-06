
<script type="text/x-handlebars-template" id="v4_ServicesListTemplate">

<form>
	{{#each v4_Services}}
		<div>

				
				<div class="row  {{color}} pad4px xlistTile" 
					style="border-top:1px solid #ddd;cursor:default" 
					id="t_{{ServiceID}}">
		
					<div class="col-md-1">
						<strong>{{ServiceID}}</strong>
					</div>

					<div class="col-md-4">
						{{RouteName}}
						{{#if RouteName}}
                            {{RouteName}}
                          {{else}}
                            > Deleted Route! <
                        {{/if}}
					</div>

					<div class="col-md-4">
						{{VehicleName}}
					</div>

					<div class="col-md-2 right">
						<input type="text" class="w50 right old" name="ServicePrice1" 
						id="ServicePrice1{{ServiceID}}" 
						value="{{ServicePrice1}}" 
						style="color:black;border:none;background:transparent;border-bottom:2px solid #336699 !important;"

						onchange="return editSavev4_ServicePrice('{{ServiceID}}', '<?= $inList ?>');"> €
					</div>
					<div class="col-md-1" onclick="one_v4_Services({{ServiceID}});"
						 style="cursor:pointer">
						<small><i class="fa fa-arrow-circle-up"></i> {{surCategory SurCategory}}</small>
						<i class="fa fa-edit pad4px" ></i> 
						
					</div>
				</div>
	
		</div>
		<div id="v4_ServicesWrapper{{ServiceID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{ServiceID}}" class="row">
				<div id="one_v4_Services{{ServiceID}}" >
					<?= LOADING ?>
				</div>
			</div>
		</div>


	{{/each}}
</form>
</script>

