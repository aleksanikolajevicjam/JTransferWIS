<?

?>

<script type="text/x-handlebars-template" id="v4_SubExpensesListTemplate">

	{{#each v4_SubExpenses}}
		<div  onclick="one_v4_SubExpenses({{ID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{ID}}">
		
					<div class="col-md-1">
						<strong>{{ID}}</strong>
					</div>

					<div class="col-md-2">
						{{Datum}}
					</div>

					<div class="col-md-3">
						{{AuthUserRealName}}
					</div>

					<div class="col-md-3">
						{{ExpanceTitle}}
					</div>

					<div class="col-md-2">
						{{Amount}}

                        {{#compare CurrencyID "==" 1}} EUR {{/compare}}
                        {{#compare CurrencyID "==" 2}} HRK {{/compare}}
                        {{#compare CurrencyID "==" 3}} CHF {{/compare}}

						{{#compare Card "==" 1}} Card
						{{else}} Cash
						{{/compare}}
					</div>

					<div class="col-md-1">
						{{#compare Approved "==" 1}} <i class="fa fa-circle xgreen-text"></i>
						{{else}} <i class="fa fa-circle red-text"></i>
						{{/compare}}
					</div>	
									<span class="red">{{Note}}	</span>				

			</div>

		</div>
		<div id="v4_SubExpensesWrapper{{ID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{ID}}" class="row">
				<div id="one_v4_SubExpenses{{ID}}" >
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
