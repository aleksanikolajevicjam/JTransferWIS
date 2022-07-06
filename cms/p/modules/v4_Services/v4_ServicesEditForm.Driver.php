
<script type="text/x-handlebars-template" id="v4_ServicesEditTemplate">
<form id="v4_ServicesEditForm{{ServiceID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">

	<input type="hidden" name="ServiceID" id="ServiceID"  value="{{ServiceID}}">
	<input type="hidden" name="RouteID" id="RouteID"  value="{{RouteID}}">
	<input type="hidden" name="OwnerID" id="OwnerID" value="{{OwnerID}}">
	<input type="hidden" name="VehicleID" id="VehicleID" value="{{VehicleID}}">
	<input type="hidden" name="SurCategory" id="SurCategory" value="{{SurCategory}}">
	<input type="hidden" name="SurID" id="SurID" value="{{SurID}}">


	<div class="box-header">
		<div class="box-title">
			<? if ($isNew) { ?>
				<h3><?= NNEW ?></h3>
			<? } else { ?>
				<h3><?= EDIT ?> - {{ServiceID}}</h3>
			<? } ?>
		</div>
		<div class="box-tools pull-right">
			
			<span id="statusMessage" class="text-info xl"></span>
			
			<? if (!$isNew) { ?>
				<? if ($inList=='true') { ?>
					<button class="btn" title="<?= CLOSE?>" 
					onclick="return editClosev4_Services('{{ServiceID}}', '<?= $inList ?>');">
					<i class="fa fa-chevron-up l"></i>
					</button>
				<? } else { ?>
					<button class="btn btn-danger" title="<?= CANCEL ?>" 
					onclick="return deletev4_Services('{{ServiceID}}', '<?= $inList ?>');">
					<i class="fa fa-ban l"></i>
					</button>
				<? } ?>	
			<? } ?>	
			<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
			onclick="return editSavev4_Services('{{ServiceID}}', '<?= $inList ?>');">
			<i class="fa fa-save l"></i>
			</button>
			<? if (!$isNew) { ?>
				<button class="btn btn-danger" title="<?= PRINTIT ?>" 
				onclick="return editPrintv4_Services('{{ServiceID}}', '<?= $inList ?>');">
				<i class="fa fa-print l"></i>
				</button>
			<? } ?>	
		</div>
	</div>

	<div class="box-body ">
		<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1{{ServiceID}}" data-toggle="tab"><?= SERVICE ?></a></li>
                <li><a href="#tab_2{{ServiceID}}" data-toggle="tab"><?= SURCHARGES ?></a></li>
            </ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1{{ServiceID}}">		
					<div class="row">
						<div class="col-md-6">


							<div class="row">
								<div class="col-md-3">
									<label for="VehicleAvailable"><?=VEHICLEAVAILABLE;?></label>
								</div>
								<div class="col-md-9">
									{{yesNoSelect VehicleAvailable 'VehicleAvailable'}}
								</div>
							</div>



							<div class="row">
								<div class="col-md-3">
									<label for="ServicePrice1"><?=SERVICEPRICE1;?></label>
								</div>
								<div class="col-md-9">
									{{ServicePrice1}}
								</div>
							</div>



							<div class="row">
								<div class="col-md-3">
									<label for="ServicePrice2"><?=SERVICEPRICE2;?></label>
								</div>
								<div class="col-md-9">
									<input type="text" name="ServicePrice2" id="ServicePrice2" class="w100"
									 value="{{ServicePrice2}}">
								</div>
							</div>


							<div class="row">
								<div class="col-md-3">
									<label for="Discount"><?=DISCOUNT;?></label>
								</div>
								<div class="col-md-9">
									<input type="text" name="Discount" id="Discount" class="w100"
									 value="{{Discount}}">
								</div>
							</div>




							<div class="row">
								<div class="col-md-3">
									<label for="ServiceETA"><?=SERVICEETA;?></label>
								</div>
								<div class="col-md-9">
									<input type="text" name="ServiceETA" id="ServiceETA" class="w100"
									 value="{{ServiceETA}}">
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<label for="Active"><?=ACTIVE;?></label>
								</div>
								<div class="col-md-9">
									{{ yesNoSelect Active 'Active'}}

								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<label for="LastChange"><?=LASTCHANGE;?></label>
								</div>
								<div class="col-md-9">
									{{LastChange}}
								</div>
							</div>


						</div>
					</div>
		    	</div> {{!-- tab1 end --}}
		    	
				<div class="tab-pane" id="tab_2{{ServiceID}}">
					<div class="row">
						<div class="col-md-3">
							<label for="SurCategory"><?=SURCATEGORY;?></label>
						</div>
						<div class="col-md-9">
							<select name="SurCategory" id="SurCategory" class="w100" 
							onchange="serviceSurcharges({{ServiceID}});">
								{{#select SurCategory}}
									<option value="1"><?= USE_GLOBAL ?></option>
									<option value="2"><?= VEHICLE_SPECIFIC ?></option>
									<option value="3"><?= ROUTE_SPECIFIC ?></option>
									<option value="4"><?= SERVICE_SPECIFIC ?></option>
									<option value="0"><?= NO_SURCHARGES ?></option>
								{{/select}}								
							</select>
							
							<input type="hidden" name="SurID" id="SurID" class="w100" value="{{SurID}}">
						</div>
					</div>
					<div id="serviceSurcharges{{ServiceID}}"></div>

				</div> {{!-- tab-pane tab_2 --}}
			</div> {{!-- end tabs --}}
			
	<!-- Statuses and messages -->
	<div class="box-footer">
		<? if (!$isNew) { ?>
		<div>
    	<button class="btn btn-default" onclick="return deletev4_Services('{{ServiceID}}', '<?= $inList ?>');">
    		<i class="fa fa-trash-o l"></i> <?= DELETE ?>
    	</button>
    	</div>
    	<? } ?>

	</div>
</form>


	<script>
		// init 
		serviceSurcharges({{ServiceID}});
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
	
