
<script type="text/x-handlebars-template" id="v4_SubDriversEditTemplate">

<form id="v4_SubDriversEditForm{{DriverID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
	
	<input type="hidden" name="OwnerID" value="<?= s('OwnerID')?>">
	<input type="hidden" name="AuthLevelID" value="32">
 	
 	<div class="box-header">
		<div class="box-title">
			<? if ($isNew) { ?>
				<h3><?= NNEW.' '.DRIVER ?> </h3>
			<? } else { ?>
				<h3><?= EDIT ?> - {{DriverName}}</h3>
			<? } ?>
		</div>
		<div class="box-tools pull-right">
			
			<span id="statusMessage" class="text-info xl"></span>
			
			<? if (!$isNew) { ?>
				<? if ($inList=='true') { ?>
					<button class="btn" title="<?= CLOSE?>" 
					onclick="return editClosev4_SubDrivers('{{DriverID}}', '<?= $inList ?>');">
					<i class="fa fa-arrow-up"></i>
					</button>
				<? } else { ?>
					<button class="btn btn-danger" title="<?= CANCEL ?>" 
					onclick="return deletev4_SubDrivers('{{DriverID}}', '<?= $inList ?>');">
					<i class="fa fa-ban"></i>
					</button>
				<? } ?>	
			<? } ?>	
			<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
			onclick="return editSavev4_SubDrivers('{{DriverID}}', '<?= $inList ?>');">
			<i class="ic-disk"></i>
			</button>
		</div>
	</div>

	<div class="box-body ">
        <div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-3">
						<label for="DriverName"><?= NAME ?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="DriverName" id="DriverName" class="w100" value="{{DriverName}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="DriverPassword"><?= NEW_PASSWORD ?></label>
					</div>
					<div class="col-md-9">
						<input type="hidden" name="DriverPassword"
							value="{{DriverPassword}}">
						<input type="text"  name="DriverPasswordNew" class="w100">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="DriverEmail"><?= CO_EMAIL ?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="DriverEmail" id="DriverEmail" class="w100" value="{{DriverEmail}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="DriverTel"><?= TELEPHONE ?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="DriverTel" id="DriverTel" class="w100" value="{{DriverTel}}">
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="row">
					<div class="col-md-3">
						<label for="Notes"><?= NOTESS ?></label>
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
    	<button class="btn btn-default" onclick="return deletev4_SubDrivers('{{DriverID}}', '<?= $inList ?>');">
    		<i class="ic-cancel-circle"></i> <?= DELETE ?>
    	</button>
    	</div>
    	<? } ?>

	</div>
</form>

	<script>

		// uklanja ikonu Saved - statusMessage sa ekrana
		$("form").change(function(){
			$("#statusMessage").html('');
		});
	
	</script>
</script>

