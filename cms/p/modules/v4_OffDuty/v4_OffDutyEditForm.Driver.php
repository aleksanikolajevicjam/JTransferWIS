
<script type="text/x-handlebars-template" id="v4_OffDutyEditTemplate">
<form id="v4_OffDutyEditForm{{ID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
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
					<button class="btn btn-warning" title="<?= CLOSE?>" 
					onclick="return editClosev4_OffDuty('{{ID}}', '<?= $inList ?>');">
					<i class="ic-close"></i>
					</button>
				<? } else { ?>
					<button class="btn btn-danger" title="<?= CANCEL ?>" 
					onclick="return deletev4_OffDuty('{{ID}}', '<?= $inList ?>');">
					<i class="fa fa-ban"></i>
					</button>
				<? } ?>	
			<? } ?>	
			<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
			onclick="return editSavev4_OffDuty('{{ID}}', '<?= $inList ?>');">
			<i class="ic-disk"></i>
			</button>
			<? if (!$isNew) { ?>
				<button class="btn btn-danger" title="<?= PRINTIT ?>" 
				onclick="return editPrintv4_OffDuty('{{ID}}', '<?= $inList ?>');">
				<i class="ic-print"></i>
				</button>
			<? } ?>	
		</div>
	</div>

	<div class="box-body ">
        <div class="row">
			<div class="col-md-12">
				<div class="row hidden">
					<div class="col-md-3">
						<label for="ID"><?=ID;?></label>
					</div>
					<div class="col-md-9">
						<input type="hidden" name="ID" id="ID" class="w100" value="{{ID}}">
					</div>
				</div>

				<div class="row hidden">
					<div class="col-md-3">
						<label for="OwnerID"><?=OWNERID;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="OwnerID" id="OwnerID" class="w100" 
						value="<?= s('AuthUserID')?>">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="VehicleID"><?=VEHICLE;?></label>
					</div>
					<div class="col-md-9">
						
						<select name="VehicleID" id="VehicleID" class="w100">
							<option value="-1">All vehicles</option>
						{{#select VehicleID}}
							<?
							require_once ROOT . '/db/v4_Vehicles.class.php';
							$v = new v4_Vehicles();
							$where = " WHERE OwnerID = '".s('AuthUserID')."' ";
							$vk = $v->getKeysBy('VehicleID', 'ASC', $where);
							if(count($vk) > 0 ) {
								foreach($vk as $nn => $vid) { 
								$v->getRow($vid);
								?>
									<option value="<?= $v->VehicleID?>"><?= $v->VehicleName ?></option>
								<?}
							}
						
						
							?>
						{{/select}}
						</select>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="StartDate"><?=STARTDATE;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="StartDate" id="StartDate" 
						class="w25 datepicker" value="{{StartDate}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="StartTime"><?=STARTTIME;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="StartTime" id="StartTime" 
						class="w25 timepicker" value="{{StartTime}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="EndDate"><?=ENDDATE;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="EndDate" id="EndDate" 
						class="w25 datepicker" value="{{EndDate}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="EndTime"><?=ENDTIME;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="EndTime" id="EndTime" 
						class="w25 timepicker" value="{{EndTime}}">
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-3">
						<label for="Reason"><?=REASON;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="Reason" id="Reason" class="w100" value="{{Reason}}">
					</div>
				</div>


			</div>
	    </div>
		    

	<!-- Statuses and messages -->
	<div class="box-footer">
		<? if (!$isNew) { ?>
		<div>
    	<button class="btn btn-default" onclick="return deletev4_OffDuty('{{ID}}', '<?= $inList ?>');">
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
			$(document).ready(function(){
				$(".datepicker").pickadate({format: 'yyyy-mm-dd'});
				//$(".timepicker").pickatime({format: 'HH:i', interval: 10});
				$(".timepicker").JAMTimepicker();
			});	
	</script>
</script>
	
