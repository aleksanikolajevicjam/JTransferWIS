
<script type="text/x-handlebars-template" id="v4_LabelsListTemplate">

	{{#each v4_Labels}}
		<div  onclick="one_v4_Labels({{LabelID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{LabelID}}">
					<div class="col-md-4">
						<strong>{{Label}}</strong>
					</div>

					<div class="col-md-2">
						{{LabelEN}}
					</div> 
					
					<div class="col-md-2">
						{{LabelRU}}
					</div>

					<div class="col-md-2">
						{{LabelFR}}
					</div>

					<div class="col-md-2">
						{{LabelDE}}
					</div>

					<div class="col-md-2">
						{{LabelIT}}
					</div>
			</div>
		</div>
		<div id="v4_LabelsWrapper{{LabelID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{LabelID}}" class="row">
				<div id="one_v4_Labels{{LabelID}}" >
					<?= LOADING ?>
				</div>
			</div>
		</div>

	{{/each}}


</script>
	
