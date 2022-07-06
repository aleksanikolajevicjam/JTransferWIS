
<script type="text/x-handlebars-template" id="v4_MyVehiclesEditTemplate">
<form id="v4_MyVehiclesEditForm{{VehicleID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">

	<input type="hidden" name="VehicleID" id="VehicleID" value="{{VehicleID}}">
	<input type="hidden" name="OwnerID" id="OwnerID" value="<?= s('AuthUserID') ?>">

	<div class="box-header">
		<div class="box-title">
			<? if ($isNew) { ?>
				<h3><?= NNEW ?></h3>
			<? } else { ?>
				<h3><?= EDIT ?> - {{ID}}</h3>
			<? } ?>
		</div>
		<div class="box-tools pull-right">
			
			<span id="statusMessage" class="text-info xl"></span>
			
			<? if (!$isNew) { ?>
				<? if ($inList=='true') { ?>
					<button class="btn" title="<?= CLOSE?>" 
					onclick="return editClosev4_MyVehicles('{{VehicleID}}', '<?= $inList ?>');">
					<i class="fa fa-arrow-up"></i>
					</button>
				<? } else { ?>
					<button class="btn btn-danger" title="<?= CANCEL ?>" 
					onclick="return deletev4_MyVehicles('{{VehicleID}}', '<?= $inList ?>');">
					<i class="fa fa-ban"></i>
					</button>
				<? } ?>	
			<? } ?>	
			<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
			onclick="return editSavev4_MyVehicles('{{VehicleID}}', '<?= $inList ?>');">
			<i class="ic-disk"></i>
			</button>
			<? if (!$isNew) { ?>
				<button class="btn btn-danger" title="<?= PRINTIT ?>" 
				onclick="return editPrintv4_MyVehicles('{{VehicleID}}', '<?= $inList ?>');">
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
						<label for="VehicleName"><?=VEHICLENAME;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="VehicleName" id="VehicleName" class="w100" value="{{VehicleName}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="VehicleDescription"><?=VEHICLEDESCRIPTION;?></label>
					</div>
					<div class="col-md-9">
						<textarea name="VehicleDescription" id="VehicleDescription" rows="5" 
					class="textarea" cols="50" style="width:100%">{{VehicleDescription}}</textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="VehicleCapacity"><?=VEHICLECAPACITY;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="VehicleCapacity" id="VehicleCapacity" class="w25" value="{{VehicleCapacity}}">
					</div>
				</div>


							<div class="row">
								<div class="col-md-3">
									<label for="AirCondition"><?=AIRCONDITION;?></label>
								</div>
								<div class="col-md-9">
									{{yesNoSelect AirCondition 'AirCondition'}}
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<label for="ChildSeat"><?=CHILDSEAT;?></label>
								</div>
								<div class="col-md-9">
									{{yesNoSelect ChildSeat 'ChildSeat'}}
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<label for="Music"><?=MUSIC;?></label>
								</div>
								<div class="col-md-9">
									{{yesNoSelect Music 'Music'}}
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<label for="TV"><?=TV;?></label>
								</div>
								<div class="col-md-9">
									{{yesNoSelect TV 'TV'}}
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<label for="GPS"><?=GPS;?></label>
								</div>
								<div class="col-md-9">
									{{yesNoSelect GPS 'GPS'}}
								</div>
							</div>


			</div>
	    </div>
		    

	<!-- Statuses and messages -->
	<div class="box-footer">
		<? if (!$isNew) { ?>
		<div>
    	<button class="btn btn-default" onclick="return deletev4_MyVehicles('{{VehicleID}}', '<?= $inList ?>');">
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
	
