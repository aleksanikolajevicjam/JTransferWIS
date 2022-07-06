
<script type="text/x-handlebars-template" id="v4_CommentsListTemplate">

	{{#each v4_Comments}}
		<div  onclick="one_v4_Comments({{ID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{ID}}">
		
					<div class="col-sm-1">
						{{ID}}
					</div>
						
					<div class="col-sm-2">
						{{Author}}
					</div>

					<div class="col-sm-8">
						{{Comment}}
					</div>

			</div>
		</div>
		<div id="v4_CommentsWrapper{{ID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{ID}}" class="row">
				<div id="one_v4_Comments{{ID}}" >
					<?= LOADING ?>
				</div>
			</div>
		</div>

	{{/each}}


</script>
	
