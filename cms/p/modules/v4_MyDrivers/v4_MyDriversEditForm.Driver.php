
<script type="text/x-handlebars-template" id="v4_MyDriversEditTemplate">
<form id="v4_MyDriversEditForm{{DriverID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">

	<input type="hidden" name="OwnerID" id="OwnerID" value="<?= s('AuthUserID')?>">
	<input type="hidden" name="DriverID" id="DriverID" value="{{DriverID}}">
	<div class="box-header">
		<div class="box-title">
			<? if ($isNew) { ?>
				<h3><?= NNEW ?></h3>
			<? } else { ?>
				<h3><?= EDIT ?> - {{DriverName}}</h3>
			<? } ?>
		</div>
		<div class="box-tools pull-right">
			
			<span id="statusMessage" class="text-info xl"></span>
			
			<? if (!$isNew) { ?>
				<? if ($inList=='true') { ?>
					<button class="btn" title="<?= CLOSE?>" 
					onclick="return editClosev4_MyDrivers('{{DriverID}}', '<?= $inList ?>');">
					<i class="fa fa-arrow-up"></i>
					</button>
				<? } else { ?>
					<button class="btn btn-danger" title="<?= CANCEL ?>" 
					onclick="return deletev4_MyDrivers('{{DriverID}}', '<?= $inList ?>');">
					<i class="fa fa-ban"></i>
					</button>
				<? } ?>	
			<? } ?>	
			<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
			onclick="return editSavev4_MyDrivers('{{DriverID}}', '<?= $inList ?>');">
			<i class="ic-disk"></i>
			</button>
			<? if (!$isNew) { ?>
				<button class="btn btn-danger" title="<?= PRINTIT ?>" 
				onclick="return editPrintv4_MyDrivers('{{DriverID}}', '<?= $inList ?>');">
				<i class="ic-print"></i>
				</button>
			<? } ?>	
		</div>
	</div>

	<div class="box-body ">
        <div class="row">
			<div class="col-md-12">

				<div class="row">
					<div class="col-md-3">
						<label for="DriverName"><?=DRIVERNAME;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="DriverName" id="DriverName" class="w100" value="{{DriverName}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="DriverPassword"><?=DRIVERPASSWORD;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="DriverPassword" id="DriverPassword" class="w100" value="{{DriverPassword}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="DriverEmail"><?=DRIVEREMAIL;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="DriverEmail" id="DriverEmail" class="w100" value="{{DriverEmail}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="DriverTel"><?=DRIVERTEL;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="DriverTel" id="DriverTel" class="w100" value="{{DriverTel}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Notes"><?=NOTES;?></label>
					</div>
					<div class="col-md-9">
						<textarea name="Notes" id="Notes" rows="5" 
					class="textarea" cols="50" style="width:100%">{{Notes}}</textarea>
					</div>
				</div>


			</div>
	    </div>
		    

	<!-- Statuses and messages -->
	<div class="box-footer">
		<? if (!$isNew) { ?>
		<div>
    	<button class="btn btn-default" onclick="return deletev4_MyDrivers('{{DriverID}}', '<?= $inList ?>');">
    		<i class="ic-cancel-circle"></i> <?= DELETE ?>
    	</button>
    	</div>
    	<? } ?>

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
	
