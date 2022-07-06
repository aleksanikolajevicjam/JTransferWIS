
<script type="text/x-handlebars-template" id="v4_SpecialDatesListTemplate">

	{{#each v4_SpecialDates}}
		<div  onclick="one_v4_SpecialDates({{ID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{ID}}">
		
					<div class="col-md-3">
						<strong>{{SpecialDate}}</strong>
					</div>

					<div class="col-md-3">
					    {{StartTime}}
					</div>

					<div class="col-md-3">
					    {{EndTime}}
					</div>

					<div class="col-md-3">
					    {{CorrectionPercent}}%
					</div>
			</div>
		</div>
		<div id="v4_SpecialDatesWrapper{{ID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{ID}}" class="row">
				<div id="one_v4_SpecialDates{{ID}}" >
					<?= LOADING ?>
				</div>
			</div>
		</div>

	{{/each}}


</script>
	
