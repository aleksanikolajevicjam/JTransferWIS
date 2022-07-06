
<script type="text/x-handlebars-template" id="v4_InvoicesListTemplate">

	{{#each v4_Invoices}}
		<div  onclick="one_v4_Invoices({{ID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{ID}}">
		
					<div class="col-md-3">
						<strong># {{InvoiceNumber}}</strong><br>
						{{#compare Type "==" 1}}
							<small>Agent</small>
						{{else}}
							<small>Driver</small>
						{{/compare}} 						
					</div>

					<div class="col-md-4">
						<strong>{{userName UserID "AuthUserCompany"}}</strong>
						<br>
						{{formatDate StartDate "short"}} - {{formatDate EndDate "short"}}
					</div>

					<div class="col-md-2">
						{{formatDate InvoiceDate "short"}}
					</div>

					<div class="col-md-2">
						{{GrandTotal}} Eur
					</div>


					<div class="col-md-1">
						{{#compare Status ">" 0}}
							<i class="fa fa-check text-green" title="<?= PAID ?>"></i>
						{{else}}
							<i class="fa fa-close text-red" title="<?= NOT_PAID ?>"></i>
						{{/compare}} 
					</div>

			</div>
		</div>
		<div id="v4_InvoicesWrapper{{ID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{ID}}" class="row">
				<div id="one_v4_Invoices{{ID}}" >
					<?= LOADING ?>
				</div>
			</div>
		</div>

	{{/each}}


</script>
	
