<script type="text/x-handlebars-template" id="ItemListTemplate">

	{{#each Item}}
		<div  onclick="oneItem({{ID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{ID}}">
		
					<div class="col-md-1">
						<strong>{{ID}}</strong>
					</div>

					<div class="col-md-3">
						{{#compare RouteNameEN "==" ' '}}{{OrderID}}
						{{else}}{{RouteNameEN}}
						{{/compare}}
					</div>

					<div class="col-md-2">
						{{UserName}}
					</div>

					<div class="col-md-1">
						{{ScoreTotal}}
					</div>

					<div class="col-md-3">
						{{Comment}}
					</div>

					<div class="col-md-2" id="buttons_{{ID}}">
						{{#compare Approved "==" 0}}
							<button class="btn btn-default btn-sm btn-info clickable" onclick="approveReview({{ID}},1,this)">Approve</button>
							<button class="btn btn-default btn-sm red clickable" onclick="approveReview({{ID}},2,this)">Discard</button>
						{{else}}
							{{#compare Approved "==" 1}}Approved
							{{else}} Discarded
							{{/compare}}
						{{/compare}}
						<?/* {{Approved}} */?>
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
<script>
// trik za klikanje botuna a da ne otvori tile
$(".clickable").click(function(e) { e.stopPropagation() });

</script>
</script>

