<script type="text/x-handlebars-template" id="ItemEditTemplate">
<form id="ItemEditForm{{ID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
	<div class="box-header">
		<div class="box-title">
			<? if ($isNew) { ?>
				<h3><?= NEWW ?></h3>
			<? } else { ?>
				<h3><?= EDIT ?> - {{Code}}</h3>
			<? } ?>
		</div>
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
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-3">
						<label for="Code"><?=CODE;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="Code" id="Code" class="w100" value="{{Code}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Discount"><?=DISCOUNT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="Discount" id="Discount" class="w100" value="{{Discount}}">
					</div>
				</div>				
				
				<div class="row">
					<div class="col-md-3">
						<label for="Description"><?=DESCRIPTION;?></label>
					</div>
					<div class="col-md-9">
						<textarea name="Description" id="Description" rows="3" 
					class="textarea" cols="50" style="width:100%">{{Description}}</textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="ValidFrom"><?=VALIDFROM;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="ValidFrom" id="ValidFrom" class="w100 datepicker" value="{{ValidFrom}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="ValidTo"><?=VALIDTO;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="ValidTo" id="ValidTo" class="w100 datepicker" value="{{ValidTo}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="TransferFromDate"><?=TRANSFERFROMDATE;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="TransferFromDate" id="TransferFromDate" class="w100 datepicker" value="{{TransferFromDate}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="TransferToDate"><?=TRANSFERTODATE;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="TransferToDate" id="TransferToDate" class="w100 datepicker" value="{{TransferToDate}}">
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="row">
					<div class="col-md-3">
						<label for="VehicleTypeID">Vehicle class</label>
					</div>
					<div class="col-md-9">
						{{vehicleClassSelect VehicleTypeID 'VehicleTypeID'}}
					</div>
				</div>			
			
				<div class="row">
					<div class="col-md-3">
						<label for="VehicleTypeID">DriverID</label>
					</div>
					<div class="col-md-9">
						<input type="text" name="DriverID" id="DriverID" class="w100" value="{{DriverID}}">
					</div>
				</div>		
				
				<!---<div class="row">
					<div class="col-md-3">
						<label for="VehicleTypeID"><?=VEHICLETYPEID;?></label>
					</div>
					<div class="col-md-9">
						{{vehicleTypeSelect VehicleTypeID 'VehicleTypeID'}}
					</div>
				</div>!--->

				<div class="row">
					<div class="col-md-3">
						<label for="LimitLocationID"><?=LIMITLOCATIONID;?></label>
					</div>
					<div class="col-md-9">
						{{placeSelect LimitLocationID 'LimitLocationID'}}
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="WeekdaysOnly"><?=WEEKDAYSONLY;?></label>
					</div>
					<div class="col-md-9">
						{{yesNoSelect WeekdaysOnly 'WeekdaysOnly'}}
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="ReturnOnly"><?=RETURNONLY;?></label>
					</div>
					<div class="col-md-9">
						{{yesNoSelect ReturnOnly 'ReturnOnly'}}
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Active"><?=ACTIVE;?></label>
					</div>
					<div class="col-md-9">
						{{yesNoSelect Active 'Active'}}
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="TimesUsed"><?=TIMESUSED;?></label>
					</div>
					<div class="col-md-9">
						{{TimesUsed}}
					</div>
				</div>
			</div>
	    </div>
		    

	<!-- Statuses and messages -->
	<div class="box-footer">
		<? if (!$isNew) { ?>
		<div>
    	<button class="btn btn-default" onclick="return deleteItem('{{ID}}', '<?= $inList ?>');">
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

		$(".datepicker").pickadate({format: "yyyy-mm-dd"});
	
	</script>
</script>

