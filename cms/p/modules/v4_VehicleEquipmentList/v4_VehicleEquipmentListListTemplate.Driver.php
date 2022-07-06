<?
?>
		

<script type="text/x-handlebars-template" id="v4_VehicleEquipmentListListTemplate">
	{{#each v4_VehicleEquipmentList}}
		<div  onclick="one_v4_VehicleEquipmentList({{ID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{ID}}">
		
					<div class="col-md-8">
						{{ListID}}
					</div>
					<div class="col-md-4">
						{{Datum}}
					</div>
			</div>

		</div>
		<div id="v4_VehicleEquipmentListWrapper{{ID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{ID}}" class="row">
				<div id="one_v4_VehicleEquipmentList{{ID}}" >
					<?= LOADING ?>
				</div>
			</div>
		</div>
	{{/each}}


</script>

						<script>	
							var actionid=$('#actionsid').val();
							var id='#ac'+actionid;
							$(id).show();		
						</script>	
