
<script type="text/x-handlebars-template" id="v4_DriverRoutesListTemplate">

	{{#each v4_DriverRoutes}}
		<div  onclick="one_v4_DriverRoutes({{ID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{ID}}">
		
					<div class="col-md-1">
						<strong>{{RouteID}}</strong>
					</div>

					<div class="col-md-4">
						{{RouteName}}
					</div>
					<div class="col-md-3">
						<i class="fa fa-car s"></i> {{DriverName}}
					</div>
					<div class="col-md-1">
						
						{{#compare Active ">" 0}}
							<i class="fa fa-circle text-green" title="<?= ACTIVE ?>"></i>
						{{else}}
							<i class="fa fa-circle text-red" title="<?= NOT_ACTIVE ?>"></i>
						{{/compare}} &nbsp;&nbsp;
						{{#compare Approved ">" 0}}
							<i class="fa fa-check text-green" title="<?= APPROVED ?>"></i>
						{{else}}
							<i class="fa fa-close text-red" title="<?= NOT_APPROVED ?>"></i>
						{{/compare}} 

					</div>

					<div class="col-md-1">
						{{#compare OneToTwo ">" 0}}
							<i class="fa fa-arrow-right text-green" title="A &rarr; B"></i>
						{{else}}
							<i class="fa fa-arrow-right text-red" title="A &rarr; B"></i>
						{{/compare}}  
						{{#compare TwoToOne ">" 0}}
							<i class="fa fa-arrow-left text-green" title="B &rarr; A"></i>
						{{else}}
							<i class="fa fa-arrow-left  text-red" title="B &rarr; A"></i>
						{{/compare}}						
					</div>
					
					<div class="col-md-2" title="<?= SURCATEGORY ?>">
						<small><i class="fa fa-arrow-circle-up"></i> {{surCategory SurCategory}}</small>
					</div>
			</div>
		</div>
		<div id="v4_DriverRoutesWrapper{{ID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{ID}}" class="row">
				<div id="one_v4_DriverRoutes{{ID}}" >
					<?= THERE_ARE_NO_DATA ?>
				</div>
			</div>
		</div>

	{{/each}}


</script>
	
