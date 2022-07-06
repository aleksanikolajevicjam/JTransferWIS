
<script type="text/x-handlebars-template" id="v4_TerminalsListTemplate">

	{{#each v4_Terminals}}
		<div  onclick="one_v4_Terminals({{TerminalID}},{{ID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{TerminalID}}">
		
					<div class="col-md-1">
						<strong>{{TerminalID}}</strong>
					</div>

					<div class="col-md-4">
						{{AuthUserRealName}}
					</div>
					<div class="col-md-5">
						<i class="fa fa-building"></i> {{TerminalName}}
						
					</div>

			</div>
		</div>
		<div id="v4_TerminalsWrapper{{TerminalID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{TerminalID}}" class="row">
				<div id="one_v4_Terminals{{TerminalID}}" >
					<?= LOADING ?>
				</div>
			</div>
		</div>

	{{/each}}


</script>
	
