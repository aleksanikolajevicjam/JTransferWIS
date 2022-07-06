<script type="text/x-handlebars-template" id="ItemListTemplate">

	{{#each Item}}
		<div  onclick="oneItem({{ID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{ID}}">
		
					<div class="col-md-1">
						<strong>{{VehicleTypeID}}</strong>
					</div>

					<div class="col-md-3">
						<strong>{{StartSeason}} - {{EndSeason}}</strong>
					</div>

					<div class="col-md-2">
						<strong>{{SpecialDate}}</strong>
					</div>

					<div class="col-md-2">
						<strong>{{WeekDays}}</strong>
					</div>

					<div class="col-md-2">
					    {{StartTime}}-{{EndTime}}
					</div>

					<div class="col-md-2">
					    {{CorrectionPercent}}%
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


</script>
	
