
<script type="text/x-handlebars-template" id="v4_CoTextsListTemplate">

	{{#each v4_CoTexts}}
		<div  onclick="one_v4_CoTexts({{ID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{ID}}">
		
					<div class="col-sm-5">
						<strong>{{language}}</strong>
					</div>

			</div>
		</div>
		<div id="v4_CoTextsWrapper{{ID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{ID}}" class="row">
				<div id="one_v4_CoTexts{{ID}}" >
					<?= LOADING ?>
				</div>
			</div>
		</div>

	{{/each}}


</script>
	
