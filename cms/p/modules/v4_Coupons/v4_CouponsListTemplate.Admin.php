
<script type="text/x-handlebars-template" id="v4_CouponsListTemplate">

	{{#each v4_Coupons}}
		<div  onclick="one_v4_Coupons({{ID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{ID}}">
		
					<div class="col-md-1">
						<strong>{{ID}}</strong>
					</div>

					<div class="col-md-2">
						{{Code}}
					</div>

					<div class="col-md-2">
						{{Discount}}
					</div>

					<div class="col-md-3">
						{{ValidFrom}}
					</div>

					<div class="col-md-3">
						{{ValidTo}}
					</div>

					<div class="col-md-1">
						{{#compare Active ">" 0}}
							<i class="fa fa-circle text-green"></i>
						{{else}}
							<i class="fa fa-circle text-red"></i>
						{{/compare}}
					</div>
			</div>
		</div>
		<div id="v4_CouponsWrapper{{ID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{ID}}" class="row">
				<div id="one_v4_Coupons{{ID}}" >
					<?= LOADING ?>
				</div>
			</div>
		</div>

	{{/each}}


</script>
	
