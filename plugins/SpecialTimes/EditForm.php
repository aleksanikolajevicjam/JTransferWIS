
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
				<div class="row hidden">
					<div class="col-md-3">
						<label for="OwnerID"><?=OWNERID;?></label>
					</div>
					<div class="col-md-9">
						<input type="hidden" name="OwnerID" id="OwnerID" class="w50" value="<?=$_SESSION['OwnerID'] ?>">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="VehicleTypeID"><?=VEHICLETYPEID;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="VehicleTypeID" id="VehicleTypeID" class="w50" value="{{VehicleTypeID}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="StartSeason"><?=STARTDATE;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="StartSeason" id="StartSeason" class="w50 datepicker" value="{{StartSeason}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="EndSeason"><?=ENDDATE;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="EndSeason" id="EndSeason" class="w50 datepicker" value="{{EndSeason}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="WeekDays"><?=WEEKDAYS;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="WeekDays" id="WeekDays" class="w20" value="{{WeekDays}}">
					</div>					
				</div>
				
				<div class="row">
					<i>0-Sunday,1-Monday...6-Saturday / Format: (0,1,2,3,4,5,6) / Sample: 0,5,6  for Friday, Saturday and Sunday</i>
				
				</div>
				
				<div class="row">
					<div class="col-md-3">
						<label for="SpecialDate"><?=SPECIALDATE;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="SpecialDate" id="SpecialDate" class="w50 datepicker" value="{{SpecialDate}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="StartTime"><?=STARTTIME;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="StartTime" id="StartTime" class="w50 timepicker" value="{{StartTime}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="EndTime"><?=ENDTIME;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="EndTime" id="EndTime" class="w50 timepicker" value="{{EndTime}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="CorrectionPercent"><?=CORRECTIONPERCENT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="CorrectionPercent" id="CorrectionPercent" class="w25" value="{{CorrectionPercent}}">%
					</div>
				</div>
			
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
	
