<?
	require_once ROOT.'/db/v4_PlaceTypes.class.php';
	$pt = new v4_PlaceTypes();
	$placeTypes = $pt->getKeysBy('PlaceTypeEN', 'asc');
	$arr_row['id']=99;
	$arr_row['name']="Terminal";
	$arr_all[]=$arr_row;
	
	foreach($placeTypes as $nn => $id) {
		$pt->getRow($id);
		$arr_row['id']=$pt->getPlaceTypeID();
		$arr_row['name']=$pt->getPlaceTypeEN();
		$arr_all[]=$arr_row;
	}
	$smarty->assign('options',$arr_all);
	$smarty->assign('selecttype',true);
?>
<script type="text/x-handlebars-template" id="ItemListTemplate">

	{{#each Item}}
		<div  onclick="oneItem({{PlaceID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{PlaceID}}">
		
					<div class="col-sm-2">
						{{PlaceID}}
					</div>

					<div class="col-sm-9">
						<strong>{{PlaceNameEN}}</strong><br>
						{{CountryNameEN}}
					</div>

					<div class="col-sm-1">
						{{#compare PlaceActive ">" 0}}
							<i class="fa fa-circle text-green"></i>
						{{else}}
							<i class="fa fa-circle text-red"></i>
						{{/compare}}
					</div>
			</div>
		</div>
		<div id="ItemWrapper{{PlaceID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{PlaceID}}" class="row">
				<div id="one_Item{{PlaceID}}" >
					<?= LOADING ?>
				</div>
			</div>
		</div>

	{{/each}}


</script>
	
