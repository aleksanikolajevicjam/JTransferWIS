<script type="text/x-handlebars-template" id="v4_ServicesEditTemplate">
<form id="v4_ServicesEditForm{{ServiceID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
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
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1{{ServiceID}}">		
					<div class="row">
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-3">
									<label for="OwnerID"><?=OWNERID;?></label>
								</div>
								<div class="col-md-9">
									<input type="hidden" name="OwnerID" id="OwnerID" class="w100"
									 value="{{OwnerID}}">
									{{OwnerID}} {{userName OwnerID "AuthUserCompany"}}
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<label for="ServiceID"><?=SERVICEID;?></label>
								</div>
								<div class="col-md-9">
									<input type="hidden" name="ServiceID" id="ServiceID" class="w100"
									 value="{{ServiceID}}">
									 {{ServiceID}}
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<label for="RouteID"><?=ROUTEID;?></label>
								</div>
								<div class="col-md-9">
									<input type="hidden" name="RouteID" id="RouteID" class="w100" value="{{RouteID}}">
									{{RouteID}}
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<label for="VehicleID"><?=VEHICLEID;?></label>
								</div>
								<div class="col-md-9">
									<input type="hidden" name="VehicleID" id="VehicleID" class="w100" 
									value="{{VehicleID}}">
									{{VehicleID}}
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<label for="VehicleTypeID"><?=VEHICLETYPEID;?></label>
								</div>
								<div class="col-md-9">
									<input type="hidden" name="VehicleTypeID" id="VehicleTypeID" class="w100"
									 value="{{VehicleTypeID}}">
									 {{VehicleTypeID}}
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<label for="VehicleAvailable"><?=VEHICLEAVAILABLE;?></label>
								</div>
								<div class="col-md-9">
									{{#if VehicleAvailable}}
										Yes
									{{else}}
										No
									{{/if}}
								</div>
							</div>
						</div>

						<div class="col-md-6">
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
									<label for="Discount"><?=DISCOUNT;?></label>
								</div>
								<div class="col-md-9">
									{{Discount}}
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<label for="Discount"><?=SURCHARGES;?></label>
								</div>
								<div class="col-md-9">
									{{surCategory SurCategory}}
								</div>
							</div>


							<div class="row">
								<div class="col-md-3">
									<label for="ServiceETA"><?=SERVICEETA;?></label>
								</div>
								<div class="col-md-9">
									{{ServiceETA}}
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<label for="Active"><?=ACTIVE;?></label>
								</div>
								<div class="col-md-9">
									{{#if VehicleAvailable}}
										Yes
									{{else}}
										No
									{{/if}}

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
</form>
	<script>
		// uklanja ikonu Saved - statusMessage sa ekrana
		$("form").change(function(){
			$("#statusMessage").html('');
		});
	</script>
</script>

