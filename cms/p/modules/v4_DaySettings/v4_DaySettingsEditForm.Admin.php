<!-- Ionicons -->
        
        
<script type="text/x-handlebars-template" id="v4_DaySettingsEditTemplate">
<form id="v4_DaySettingsEditForm{{ID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
	<div class="box-header">
		<div class="box-title">
			<? if ($isNew) { ?>
				<h3><?= NNEW ?></h3>
			<? } else { ?>
				<h3><?= EDIT ?></h3>
			<? } ?>
		</div>
		<div class="box-tools pull-right">
			
			<span id="statusMessage" class="text-info xl"></span>
			
			<? if (!$isNew) { ?>
				<? if ($inList=='true') { ?>
					<button class="btn btn-warning" title="<?= CLOSE?>" 
					onclick="return editClosev4_DaySettings('{{ID}}', '<?= $inList ?>');">
					<i class="ic-close"></i>
					</button>
				<? } else { ?>
					<button class="btn btn-danger" title="<?= CANCEL ?>" 
					onclick="return deletev4_DaySettings('{{ID}}', '<?= $inList ?>');">
					<i class="fa fa-ban"></i>
					</button>
				<? } ?>	
			<? } ?>	
			<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
			onclick="return editSavev4_DaySettings('{{ID}}', '<?= $inList ?>');">
			<i class="ic-disk"></i>
			</button>
			<? if (!$isNew) { ?>
				<button class="btn btn-danger" title="<?= PRINTIT ?>" 
				onclick="return editPrintv4_DaySettings('{{ID}}', '<?= $inList ?>');">
				<i class="ic-print"></i>
				</button>
			<? } ?>	
		</div>
	</div>

	<div class="box-body ">
        <div class="row">
			<div class="col-md-12">
<!--
				<div class="row">
					<div class="col-md-3">
						<label for="ID"><?=ID;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="ID" id="ID" class="w100" value="{{ID}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="OwnerID"><?=OWNERID;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="OwnerID" id="OwnerID" class="w100" value="{{OwnerID}}">
					</div>
				</div>
-->
				<div class="row">
					<input type="hidden" name="MonPercent" id="MonPercent" class="w100" value="{{MonPercent}}">
					<input type="hidden" name="MonAmount" id="MonAmount" class="w100" value="{{MonAmount}}">
					<input type="hidden" name="TuePercent" id="TuePercent" class="w100" value="{{TuePercent}}">
					<input type="hidden" name="TueAmount" id="TueAmount" class="w100" value="{{TueAmount}}">
					<input type="hidden" name="WedPercent" id="WedPercent" class="w100" value="{{WedPercent}}">
					<input type="hidden" name="WedAmount" id="WedAmount" class="w100" value="{{WedAmount}}">
					<input type="hidden" name="ThuPercent" id="ThuPercent" class="w100" value="{{ThuPercent}}">
					<input type="hidden" name="ThuAmount" id="ThuAmount" class="w100" value="{{ThuAmount}}">
					<input type="hidden" name="FriPercent" id="FriPercent" class="w100" value="{{FriPercent}}">
					<input type="hidden" name="FriAmount" id="FriAmount" class="w100" value="{{FriAmount}}">
					<input type="hidden" name="SatPercent" id="SatPercent" class="w100" value="{{SatPercent}}">
					<input type="hidden" name="SatAmount" id="SatAmount" class="w100" value="{{SatAmount}}">
					<input type="hidden" name="SunPercent" id="SunPercent" class="w100" value="{{SunPercent}}">
					<input type="hidden" name="SunAmount" id="SunAmount" class="w100" value="{{SunAmount}}">
				</div>
				<div class="row">
					<div class="col-md-12">
						<br>
						<h2>Fine-tune your prices</h2>
						<br>
					</div>
				</div>
				<div class="row">
				<div class="col-md-3">
					<div class="box box-solid bg-aqua pad1em">
                		<h1><?= $dayNames[1] ?>: <span id="MonPercentS"> {{MonPercent}}%</span></h1>
						<input type="text" 
						id="MonSlider" 
						value="" 
						class="col-md-3 slider form-control" 
						data-slider-min="-50" 
						data-slider-max="50" 
						data-slider-step="1" 
						data-slider-value="[{{MonPercent}}]" 
						data-slider-orientation="horizontal" 
						data-slider-selection="after" 
						data-slider-tooltip="hide" 

						style="width:100%">
					</div>
				</div>

				<div class="col-md-3">
					<div class="box box-solid bg-aqua pad1em">
                		<h1><?= $dayNames[2] ?>: <span id="TuePercentS"> {{TuePercent}}%</span></h1>
						<input type="text" 
						id="TueSlider" 
						value="" 
						class="col-md-3 slider form-control" 
						data-slider-min="-50" 
						data-slider-max="50" 
						data-slider-step="1" 
						data-slider-value="[{{TuePercent}}]" 
						data-slider-orientation="horizontal" 
						data-slider-selection="none" 
						data-slider-tooltip="hide" 

						xstyle="width:100%">
					</div>
				</div>
				
				<div class="col-md-3">
					<div class="box box-solid bg-aqua pad1em">
                		<h1><?= $dayNames[3] ?>: <span id="WedPercentS"> {{WedPercent}}%</span></h1>
						<input type="text" 
						id="WedSlider" 
						value="" 
						class="col-md-3 slider form-control" 
						data-slider-min="-50" 
						data-slider-max="50" 
						data-slider-step="1" 
						data-slider-value="[{{WedPercent}}]" 
						data-slider-orientation="horizontal" 
						data-slider-selection="none" 
						data-slider-tooltip="hide" 

						style="width:100%">
					</div>
				</div>
				
				<div class="col-md-3">
					<div class="box box-solid bg-aqua pad1em">
                		<h1><?= $dayNames[4] ?>: <span id="ThuPercentS"> {{ThuPercent}}%</span></h1>
						<input type="text" 
						id="ThuSlider" 
						value="" 
						class="col-md-3 slider form-control" 
						data-slider-min="-50" 
						data-slider-max="50" 
						data-slider-step="1" 
						data-slider-value="[{{ThuPercent}}]" 
						data-slider-orientation="horizontal" 
						data-slider-selection="none" 
						data-slider-tooltip="hide" 

						style="width:100%">
					</div>
				</div>								

				<div class="col-md-3">
					<div class="box box-solid bg-yellow pad1em">
                		<h1><?= $dayNames[5] ?>: <span id="FriPercentS"> {{FriPercent}}%</span></h1>
						<input type="text" 
						id="FriSlider" 
						value="" 
						class="col-md-3 slider form-control" 
						data-slider-min="-50" 
						data-slider-max="50" 
						data-slider-step="1" 
						data-slider-value="[{{FriPercent}}]" 
						data-slider-orientation="horizontal" 
						data-slider-selection="none" 
						data-slider-tooltip="hide" 

						style="width:100%">
					</div>
				</div>
				
				<div class="col-md-3">
					<div class="box box-solid bg-red pad1em">
						<h1><?= $dayNames[6] ?>: <span id="SatPercentS"> {{SatPercent}}%</span></h1>
						<input type="text" 
						id="SatSlider" 
						value="" 
						class="col-md-3 slider form-control" 
						data-slider-min="-50" 
						data-slider-max="50" 
						data-slider-step="1" 
						data-slider-value="[{{SatPercent}}]" 
						data-slider-orientation="horizontal" 
						data-slider-selection="none" 
						data-slider-tooltip="hide" 

						style="width:100%">
					</div>
				</div>
				
				<div class="col-md-3">
					<div class="box box-solid bg-purple pad1em">
						<h1><?= $dayNames[0] ?>: <span id="SunPercentS"> {{SunPercent}}%</span></h1>
						<input type="text" 
						id="SunSlider" 
						value="" 
						class="col-md-3 xslider form-control" 
						data-slider-min="-50" 
						data-slider-max="50" 
						data-slider-step="1" 
						data-slider-value="[{{SunPercent}}]" 
						data-slider-orientation="horizontal" 
						data-slider-selection="none" 
						data-slider-tooltip="hide" 

						style="width:100% !important">
					</div>
				</div>
				</div>	

			</div>
	    </div>
		    

	<!-- Statuses and messages -->
	<div class="box-footer">
		<? if (!$isNew) { ?>
		<div>
    	<button class="btn btn-default" onclick="return deletev4_DaySettings('{{ID}}', '<?= $inList ?>');">
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
	$(function() {
	/* BOOTSTRAP SLIDER */
                $('#SunSlider').slider().on('slide', function(ev){
                	var sun = $('#SunSlider').val();
                	$("#SunPercent").val(sun);
                	$("#SunPercentS").html(sun+'%');
                });

                $('#SatSlider').slider().on('slide', function(ev){
                	var sun = $('#SatSlider').val();
                	$("#SatPercent").val(sun);
                	$("#SatPercentS").html(sun+'%');
                });

                $('#FriSlider').slider().on('slide', function(ev){
                	var Fri = $('#FriSlider').val();
                	$("#FriPercent").val(Fri);
                	$("#FriPercentS").html(Fri+'%');
                });                

                $('#ThuSlider').slider().on('slide', function(ev){
                	var Thu = $('#ThuSlider').val();
                	$("#ThuPercent").val(Thu);
                	$("#ThuPercentS").html(Thu+'%');
                });

                $('#WedSlider').slider().on('slide', function(ev){
                	var Wed = $('#WedSlider').val();
                	$("#WedPercent").val(Wed);
                	$("#WedPercentS").html(Wed+'%');
                });

                $('#TueSlider').slider().on('slide', function(ev){
                	var Tue = $('#TueSlider').val();
                	$("#TuePercent").val(Tue);
                	$("#TuePercentS").html(Tue+'%');
                });

                $('#MonSlider').slider().on('slide', function(ev){
                	var Mon = $('#MonSlider').val();
                	$("#MonPercent").val(Mon);
                	$("#MonPercentS").html(Mon+'%');
                });
                

	});
	</script>
</script>
	
