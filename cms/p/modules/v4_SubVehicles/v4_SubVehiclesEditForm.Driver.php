
<script type="text/x-handlebars-template" id="v4_SubVehiclesEditTemplate">
<form id="v4_SubVehiclesEditForm{{VehicleID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
	<input type="hidden" name="OwnerID" value="<?= s('OwnerID')?>">
	<div class="box-header">
		<div class="box-title">
			<? if ($isNew) { ?>
				<h3><?= NNEW.' '.VEHICLE ?></h3>
			<? } else { ?>
				<h3><?= EDIT ?> - {{VehicleID}}</h3>
			<? } ?> 
			
		</div>

		<div class="box-tools pull-right">
		
			<span><a class='balance btn-primary' href='index.php?p=vehicleequipmentlist&VehicleID={{VehicleID}}' target="_blank"><i class="fa fa-check-square"> CHECK LIST </i></a></span>	
			<span id="statusMessage" class="text-info xl"></span>
			
			<? if (!$isNew) { ?>
				<? if ($inList=='true') { ?>
					<button class="btn" title="<?= CLOSE?>" 
					onclick="return editClosev4_SubVehicles('{{VehicleID}}', '<?= $inList ?>');">
					<i class="fa fa-arrow-up"></i>
					</button>
				<? } else { ?>
					<button class="btn btn-danger" title="<?= CANCEL ?>" 
					onclick="return deletev4_SubVehicles('{{VehicleID}}', '<?= $inList ?>');">
					<i class="fa fa-ban"></i>
					</button>
				<? } ?>	
			<? } ?>	
			<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
			onclick="return editSavev4_SubVehicles('{{VehicleID}}', '<?= $inList ?>');">
			<i class="ic-disk"></i>
			</button>
		</div>
	</div>

	<div class="box-body ">

        <div class="row">

			<div class="col-md-4">
				<div class="row">
					<div class="col-md-3">
						<label for="VehicleCapacity"><?=VEHICLECAPACITY;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="VehicleCapacity" id="VehicleCapacity" class="w100" value="{{VehicleCapacity}}">
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label for="Active">Active</label>
					</div>
					<div class="col-md-10">
						<select class="w100" name="Active"  value="{{Active}}">
							<option value="0" {{#compare Active "==" 0}} selected {{/compare}}>Not Active</option>
							<option value="1" {{#compare Active "==" 1}} selected {{/compare}}>Active</option>
						</select>					
					</div>
				</div>						
			</div>

			<div class="col-md-8">
				<div class="row">
					<div class="col-md-3">
						<label for="VehicleDescription"><?=VEHICLEDESCRIPTION;?></label>
					</div>
					<div class="col-md-9">
						<textarea name="VehicleDescription" id="VehicleDescription" rows="5" 
					class="textarea" cols="50" style="width:100%">{{VehicleDescription}}</textarea>
					</div>
				</div>
			</div>
	    </div>
		    

	<!-- Statuses and messages -->
	<div class="box-footer">
		<? if (!$isNew) { ?>
		<div>
    	<button class="btn btn-default" onclick="return deletev4_SubVehicles('{{VehicleID}}', '<?= $inList ?>');">
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

