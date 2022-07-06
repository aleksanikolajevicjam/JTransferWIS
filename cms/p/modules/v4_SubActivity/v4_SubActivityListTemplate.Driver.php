<?

?>

<script type="text/x-handlebars-template" id="v4_SubActivityListTemplate">

	{{#each v4_SubActivity}}
		<div  onclick="one_v4_SubActivity({{ID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{ID}}">
		
					<div class="col-md-1">
						<strong>{{ID}}</strong>
					</div>

					<div class="col-md-3">
						{{Datum}}
					</div>

					<div class="col-md-3">
						{{AuthUserRealName}}
					</div>

					<div class="col-md-3">
						{{ExpanceTitle}}
					</div>


					<div class="col-md-2">
						{{#compare Approved "==" 1}} <i class="fa fa-circle xgreen-text"></i>
						{{else}} <i class="fa fa-circle red-text"></i>
						{{/compare}}
					</div>	
									<span class="red">{{Note}}	</span>				

			</div>

		</div>
		<div id="v4_SubActivityWrapper{{ID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{ID}}" class="row">
				<div id="one_v4_SubActivity{{ID}}" >
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
