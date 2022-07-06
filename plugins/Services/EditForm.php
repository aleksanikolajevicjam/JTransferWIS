
<script type="text/x-handlebars-template" id="ItemEditTemplate">
<form id="ItemEditForm{{RouteID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
	<div class="box-header">
		<div class="box-tools pull-right">
			<span id="statusMessage" class="text-info xl"></span>
			<button class="btn btn-warning" title="<?= CLOSE?>" 
			onclick="return editCloseItem('{{RouteID}}');">
			<i class="fa fa-close"></i>
			</button>
			<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
			onclick="return editSaveItem('{{RouteID}}');">
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
									<input type="hidden" name="OwnerID" id="OwnerID" class="w100"
									 value="{{OwnerID}}">
									{{OwnerID}} {{userName OwnerID "AuthUserCompany"}}
								</div>
							</div>

							<div class="row hidden">
								<div class="col-md-3">
									<label for="ServiceID"><?=SERVICEID;?></label>
								</div>
								<div class="col-md-9">
									<input type="hidden" name="ServiceID" id="ServiceID" class="w100"
									 value="{{ServiceID}}">
									 {{ServiceID}}
								</div>
							</div>

							<div class="row hidden">
								<div class="col-md-3">
									<label for="RouteID"><?=ROUTEID;?></label>
								</div>
								<div class="col-md-9">
									<input type="hidden" name="RouteID" id="RouteID" class="w100" value="{{RouteID}}">
									{{RouteID}}
								</div>
							</div>

							<div class="row hidden">
								<div class="col-md-3">
									<label for="VehicleID"><?=VEHICLEID;?></label>
								</div>
								<div class="col-md-9">
									<input type="hidden" name="VehicleID" id="VehicleID" class="w100" 
									value="{{VehicleID}}">
									{{VehicleID}}
								</div>
							</div>

							<div class="row hidden">
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
									{{yesNoSelect VehicleAvailable 'VehicleAvailable'}}
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<label for="ServicePrice1"><?=SERVICEPRICE1;?></label>
								</div>
								<div class="col-md-9">
									<input type="text" name="ServicePrice1" id="ServicePrice1" class="w100"
									 value="{{ServicePrice1}}">
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

							<div class="row">
								<div class="col-md-3">
									<label for="SurCategory"><?=SURCATEGORY;?></label>
								</div>
								<div class="col-md-3">
									<select name="SurCategory" id="SurCategory" class="w100">
										{{#select SurCategory}}
											<option value="1" {{#compare SurCategory "==" 1}}selected{{/compare}}><?= USE_GLOBAL ?></option>
											<option value="2" {{#compare SurCategory "==" 2}}selected{{/compare}}><?= VEHICLE_SPECIFIC ?></option>
											<option value="3" {{#compare SurCategory "==" 3}}selected{{/compare}}><?= ROUTE_SPECIFIC ?></option>
											<option value="4" {{#compare SurCategory "==" 4}}selected{{/compare}}><?= SERVICE_SPECIFIC ?></option>
											<option value="0" {{#compare SurCategory "==" 0}}selected{{/compare}}><?= NO_SURCHARGES ?></option>
										{{/select}}								
									</select>
								</div>
								<div class="col-md-1">
									<a target='_blank' href='rules/global'>Edit Global Rules</a>
								</div>		
								<div class="col-md-1">
									<a target='_blank' href='rules/routes/{{RouteID}}'>Edit Route Rules</a>
								</div>								
								<div class="col-md-1">
									<a target='_blank' href='rules/vehicles/{{VehicleTypeID}}'>Edit Vehicles Rules</a>
								</div>									
								<div class="col-md-1">
									<a target='_blank' href='rules/services/{{ServiceID}}'>Edit Service Rules</a>
								</div>								
							</div>	
						</div>	
					</div>	
				</div>
			</div>
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
		
		$("#FromID").change(function(){
			var from = $("#FromID option:selected").text();
			var to   = $("#ToID option:selected").text();
			$("#RouteName").val(from + ' - ' + to);
		
		});
		$("#ToID").change(function(){
			var from = $("#FromID option:selected").text();
			var to   = $("#ToID option:selected").text();
			$("#RouteName").val(from + ' - ' + to);
		
		});	
	</script>
</script>

