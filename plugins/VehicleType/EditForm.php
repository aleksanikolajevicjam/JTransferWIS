<script type="text/x-handlebars-template" id="ItemEditTemplate">
<form id="ItemEditForm{{VehicleTypeID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
	<div class="box-header">
		<div class="box-tools pull-right">
			
			<span id="statusMessage" class="text-info xl"></span>
			
			<? if (!$isNew) { ?>
				<button class="btn btn-warning" title="<?= CLOSE?>" 
				onclick="return editCloseItem('{{VehicleTypeID}}');">
				<i class="fa fa-close"></i>
				</button>

				<button class="btn btn-danger" title="<?= CANCEL ?>" 
				onclick="return deleteItem('{{VehicleTypeID}}');">
				<i class="fa fa-ban"></i>
				</button>
			<? } ?>	
			<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
			onclick="return editSaveItem('{{VehicleTypeID}}');">
			<i class="fa fa-save"></i>
			</button>
		</div>
	</div>

	<div class="box-body ">
        <div class="row">
			<div class="col-md-12">
				<? if ($isNew || !isset($_SESSION['UseDriverID'])) { ?>
				<div class="row">
					<div class="col-md-4">
						<label for="VehicleTypeID"><?=VEHICLETYPEID;?></label>
					</div>
					<div class="col-md-8">
						<input type="text" name="VehicleTypeID" id="VehicleTypeID" class="w100" value="{{VehicleTypeID}}" readonly >
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<label for="VehicleClass"><?=VEHICLECLASS;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="VehicleClass" id="VehicleClass" class="w100" value="{{VehicleClass}}" readonly >
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-4">
						<label for="VehicleTypeName"><?=VEHICLETYPENAME;?></label>
					</div>
					<div class="col-md-8">
						<input type="text" name="VehicleTypeName" id="VehicleTypeName" class="w100" value="{{VehicleTypeName}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<label for="Min"><?=MIN;?></label>
					</div>
					<div class="col-md-8">
						<input type="text" name="Min" id="Min" class="w100" value="{{Min}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<label for="Max"><?=MAX;?></label>
					</div>
					<div class="col-md-8">
						<input type="text" name="Max" id="Max" class="w100" value="{{Max}}">
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<label for="DescriptionEN"><?=DESCRIPTION;?></label>
					</div>
					<div class="col-md-9">
						<textarea name="DescriptionEN" id="DescriptionEN" rows="5" class="textarea" rows="10" style="width:100%" >{{DescriptionEN}}</textarea>
					</div>
				</div>				
				<? } else { ?>				
				<div class="row">
					<div class="col-md-3">
						<label for="DriverVehicle">Driver Vehicle</label>
					</div>
					<div class="col-md-9">
						{{yesNoSelect DriverVehicle 'DriverVehicle' }}
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<label for="SurCategory"><?=SURCATEGORY;?></label>
					</div>
					<div class="col-md-3">
						<select name="SurCategory" id="SurCategory" class="w100">
							{{#select SurCategory}}
								<option value="1" {{#compare SurCategory "==" 1}}selected{{/compare}}><?= USE_GLOBAL ?></option>
								<option value="2" {{#compare SurCategory "==" 3}}selected{{/compare}}><?= VEHICLE_SPECIFIC ?></option>
								<option value="0" {{#compare SurCategory "==" 0}}selected{{/compare}}><?= NO_SURCHARGES ?></option>
							{{/select}}								
						</select>
					</div>
					<div class="col-md-2">
						<a target='_blank' href='rules/global'>Edit Global Rules</a>
					</div>					
					<div class="col-md-2">
						<a target='_blank' href='rules/vehicles/{{VehicleTypeID}}'>Edit Vehicles Rules</a>
					</div>					
				</div>				
				<? } ?>
			</div>
	    </div>
</form>


	<script>

		//bootstrap WYSIHTML5 - text editor
		$(".textarea").wysihtml5({
				"font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
				"emphasis": true, //Italics, bold, etc. Default true
				"lists": false, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
				"html": true, //Button which allows you to edit the generated HTML. Default false
				"link": false, //Button to insert a link. Default true
				"image": false, //Button to insert an image. Default true,
				"color": true //Button to change color of font 
				
		});
		
		// uklanja ikonu Saved - statusMessage sa ekrana
		$("form").change(function(){
			$("#statusMessage").html('');
		});
	
	</script>
</script>

