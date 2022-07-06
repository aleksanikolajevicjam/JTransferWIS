
<script type="text/x-handlebars-template" id="ItemEditTemplate">
<form id="ItemEditForm{{ID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
	<div class="box-header">
		<div class="box-tools pull-right">
			
			<span id="statusMessage" class="text-info xl"></span>
			
			<? if (!$isNew) { ?>
				<button class="btn btn-warning" title="<?= CLOSE?>" 
				onclick="return editCloseItem('{{ID}}');">
				<i class="fa fa-close"></i>
				</button>

				<button class="btn btn-danger" title="<?= CANCEL ?>" 
				onclick="return deleteItem('{{ID}}');">
				<i class="fa fa-ban"></i>
				</button>
			<? } ?>	
			<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
			onclick="return editSaveItem('{{ID}}');">
			<i class="fa fa-save"></i>
			</button>			
		</div>
	</div>

	<div class="box-body ">
        <div class="row">
			<div class="col-md-12">
				<? if ($isNew || !isset($_SESSION['UseDriverID'])) { ?>
				<div class="row">
					<div class="col-md-2">
						<label for="ID"><?=ID;?></label>
					</div>
					<div class="col-md-10">
						{{ID}}
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<label for="DisplayOrder"><?=DISPLAYORDER;?></label>
					</div>
					<div class="col-md-10">
						<input type="text" name="DisplayOrder" id="DisplayOrder" class="w100" value="{{DisplayOrder}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<label for="ServiceEN"><?=SERVICEEN;?></label>
					</div>
					<div class="col-md-10">
						<input type="text" name="ServiceEN" id="ServiceEN" class="w100" value="{{ServiceEN}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<label for="ServiceDE"><?=SERVICEDE;?></label>
					</div>
					<div class="col-md-10">
						<input type="text" name="ServiceDE" id="ServiceDE" class="w100" value="{{ServiceDE}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<label for="ServiceRU"><?=SERVICERU;?></label>
					</div>
					<div class="col-md-10">
						<input type="text" name="ServiceRU" id="ServiceRU" class="w100" value="{{ServiceRU}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<label for="ServiceFR"><?=SERVICEFR;?></label>
					</div>
					<div class="col-md-10">
						<input type="text" name="ServiceFR" id="ServiceFR" class="w100" value="{{ServiceFR}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<label for="ServiceIT"><?=SERVICEIT;?></label>
					</div>
					<div class="col-md-10">
						<input type="text" name="ServiceIT" id="ServiceIT" class="w100" value="{{ServiceIT}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<label for="ServiceSE"><?=SERVICESE;?></label>
					</div>
					<div class="col-md-10">
						<input type="text" name="ServiceSE" id="ServiceSE" class="w100" value="{{ServiceSE}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<label for="ServiceNO"><?=SERVICENO;?></label>
					</div>
					<div class="col-md-10">
						<input type="text" name="ServiceNO" id="ServiceNO" class="w100" value="{{ServiceNO}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<label for="ServiceES"><?=SERVICEES;?></label>
					</div>
					<div class="col-md-10">
						<input type="text" name="ServiceES" id="ServiceES" class="w100" value="{{ServiceES}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<label for="ServiceNL"><?=SERVICENL;?></label>
					</div>
					<div class="col-md-10">
						<input type="text" name="ServiceNL" id="ServiceNL" class="w100" value="{{ServiceNL}}">
					</div>
				</div>
				<? } else { ?>				
				<div class="row">
					<div class="col-md-3">
						<label for="DriverExtras">Driver Extras</label>
					</div>
					<div class="col-md-9">
						{{yesNoSelect DriverExtras 'DriverExtras' }}
					</div>
				</div>
				<? } ?>
			</div>
	    </div>
		    

	<!-- Statuses and messages -->
	<div class="box-footer">
		<? /*if (!$isNew) { ?>
		<div>
    	<button class="btn btn-default" onclick="return deleteItem('{{ID}}', '<?= $inList ?>');">
    		<i class="ic-cancel-circle"></i> <?= DELETE ?>
    	</button>
    	</div>
    	<? } */?>

	</div>
</form>


	<script>

		//bootstrap WYSIHTML5 - text editor
		$(".textarea").wysihtml5({
				"font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
				"emphasis": true, //Italics, bold, etc. Default true
				"lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
				"html": true, //Button which allows you to edit the generated HTML. Default false
				"link": true, //Button to insert a link. Default true
				"image": true, //Button to insert an image. Default true,
				"color": true //Button to change color of font 
				
		});
		
		// uklanja ikonu Saved - statusMessage sa ekrana
		$("form").change(function(){
			$("#statusMessage").html('');
		});
	
	</script>
</script>
	
