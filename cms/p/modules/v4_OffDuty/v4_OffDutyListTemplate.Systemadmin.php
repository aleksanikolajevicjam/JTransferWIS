
<script type="text/x-handlebars-template" id="v4_OffDutyListTemplate">

	{{#each v4_OffDuty}}
		<div  onclick="one_v4_OffDuty({{ID}});">
		
			<div class="row {{color}} pad1em listTile" 
			style="border-top:1px solid #ddd" 
			id="t_{{ID}}">
		
					<div class="col-sm-3">
						<strong>{{ID}}</strong>
					</div>

					<div class="col-sm-2">
					</div>

					<div class="col-sm-2">
					</div>

					<div class="col-sm-3">
					</div>
			</div>
		</div>
		<div id="v4_OffDutyWrapper{{ID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{ID}}" class="row">
				<div id="one_v4_OffDuty{{ID}}" >
					<?= LOADING ?>
				</div>
			</div>
		</div>

	{{/each}}


</script>
	