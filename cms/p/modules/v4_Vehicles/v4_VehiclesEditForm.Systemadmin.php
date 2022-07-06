
<script type="text/x-handlebars-template" id="v4_VehiclesEditTemplate">
<form id="v4_VehiclesEditForm{{VehicleID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
	<div class="box-header">
		<div class="box-title">
			<? if ($isNew) { ?>
				<h3><?= NNEW ?></h3>
			<? } else { ?>
				<h3><?= EDIT ?> - {{VehicleName}}</h3>
			<? } ?>
		</div>
		<div class="box-tools pull-right">
			
			<span id="statusMessage" class="text-info xl"></span>
			
			<? if (!$isNew) { ?>
				<? if ($inList=='true') { ?>
					<button class="btn" title="<?= CLOSE?>" 
					onclick="return editClosev4_Vehicles('{{VehicleID}}', '<?= $inList ?>');">
					<i class="fa fa-chevron-up l"></i>
					</button>
				<? } else { ?>
					<button class="btn btn-danger" title="<?= CANCEL ?>" 
					onclick="return deletev4_Vehicles('{{VehicleID}}', '<?= $inList ?>');">
					<i class="fa fa-ban"></i>
					</button>
				<? } ?>	
			<? } ?>	
			<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
			onclick="return editSavev4_Vehicles('{{VehicleID}}', '<?= $inList ?>');">
			<i class="fa fa-save l"></i>
			</button>
			<? if (!$isNew) { /*?>
				<button class="btn btn-danger" title="<?= PRINTIT ?>" 
				onclick="return editPrintv4_Vehicles('{{VehicleID}}', '<?= $inList ?>');">
				<i class="fa fa-print l"></i>
				</button>
			<? */} ?>	
		</div>
	</div>

	<div class="box-body ">
		<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1{{VehicleID}}" data-toggle="tab"><?= VEHICLE ?></a></li>
                <li><a href="#tab_2{{VehicleID}}" data-toggle="tab"><?= SURCHARGES ?></a></li>
            </ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1{{VehicleID}}">		
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-3">
									<label for="VehicleID"><?=VEHICLEID;?></label>
								</div>
								<div class="col-md-9">
									<input type="text" name="VehicleID" id="VehicleID" class="w100"
									 value="{{VehicleID}}">
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

							<div class="row">
								<div class="col-md-3">
									<label for="VehicleName"><?=VEHICLENAME;?></label>
								</div>
								<div class="col-md-9">
									<input type="text" name="VehicleName" id="VehicleName" class="w100"
									 value="{{VehicleName}}">
								</div>
							</div>

<?/*
							<div class="row">
								<div class="col-md-3">
									<label for="SurCategory"><?=SURCATEGORY;?></label>
								</div>
								<div class="col-md-9">
									<input type="text" name="SurCategory" id="SurCategory" class="w100"
									 value="{{SurCategory}}">
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<label for="SurID"><?=SURID;?></label>
								</div>
								<div class="col-md-9">
									<input type="text" name="SurID" id="SurID" class="w100" value="{{SurID}}">
								</div>
							</div>
*/?>
							<div class="row">
								<div class="col-md-3">
									<label for="PriceKm"><?=PRICEKM;?></label>
								</div>
								<div class="col-md-9">
									<input type="text" name="PriceKm" id="PriceKm" class="w100" value="{{PriceKm}}">
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<label for="ReturnDiscount"><?=RETURNDISCOUNT;?></label>
								</div>
								<div class="col-md-9">
									<input type="text" name="ReturnDiscount" id="ReturnDiscount" class="w100"
									 value="{{ReturnDiscount}}">
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
									 
									<select name="VehicleCapacity" id="VehicleCapacity"  
									class="w25">
										{{#select VehicleCapacity}}
										<option value="0"> --- </option>
		
										<?
										require_once '../db/v4_VehicleTypes.class.php';

										# init class
										$vt = new v4_VehicleTypes();

										$vtk = $vt->getKeysBy('VehicleTypeID', 'asc');

										foreach($vtk as $n => $ID) {
											$vt->getRow($ID);
										   echo '<option value="'.$vt->getMax().'">'.$vt->getMax().'</option>';

										}
		
										?>
									</select>
									{{/select}}									 
									 
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<label for="VehicleTypeID"><?=VEHICLETYPEID;?></label>
								</div>
								<div class="col-md-9">
									{{vehicleClassSelect VehicleClass}}
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

							<div class="row">
								<div class="col-md-12">
									<br>
									<h3><?= VEHICLE_IMAGES ?></h3>
									<small><?= VEHICLE_IMAGES_NOTE ?></small>
									<br><hr>
								</div>
							</div>
							<div class="row">

								<div class="col-md-3">
									<div id="imageDiv1">
										<img src="{{VehicleImage}}"
										style="max-height:160px; max-width:160px;overflow:hidden;" 
										class="img-thumbnail">
									</div>

									<form name="form" action="" method="POST" enctype="multipart/form-data">
										<input type="file" name="imageFile1" id="imageFile1" style="display:none"
										onchange="return ajaxFileUpload('1');">
										<br>
										<button id="imgUpload1" class="btn btn-xs btn-default" 
											onclick="$('#imageFile1').click();return false;">
											<?= UPLOAD_NEW_IMAGE ?>
										</button>
										<br>
										<br>
									</form>					
								</div>


								<div class="col-md-3">
									<div id="imageDiv2">
										<img src="{{VehicleImage2}}"
										style="max-height:160px; max-width:160px;overflow:hidden;" 
										class="img-thumbnail">
									</div>

									<form name="form" action="" method="POST" enctype="multipart/form-data">
										<input type="file" name="imageFile2" id="imageFile2" style="display:none"
										onchange="return ajaxFileUpload('2');">
										<br>
										<button id="imgUpload2" class="btn btn-xs btn-default" 
											onclick="$('#imageFile2').click();return false;">
											<?= UPLOAD_NEW_IMAGE ?>
										</button>
										<br>
										<br>
									</form>					
								</div>


								<div class="col-md-3">
									<div id="imageDiv3">
										<img src="{{VehicleImage3}}"
										style="max-height:160px; max-width:160px;overflow:hidden;" 
										class="img-thumbnail">
									</div>

									<form name="form" action="" method="POST" enctype="multipart/form-data">
										<input type="file" name="imageFile3" id="imageFile3" style="display:none"
										onchange="return ajaxFileUpload('3');">
										<br>
										<button id="imgUpload3" class="btn btn-xs btn-default" 
											onclick="$('#imageFile3').click();return false;">
											<?= UPLOAD_NEW_IMAGE ?>
										</button>
										<br>
										<br>
									</form>					
								</div>

								<div class="col-md-3">
									<div id="imageDiv4">
										<img src="{{VehicleImage4}}"
										style="max-height:160px; max-width:160px;overflow:hidden;" 
										class="img-thumbnail">
									</div>

									<form name="form" action="" method="POST" enctype="multipart/form-data">
										<input type="file" name="imageFile4" id="imageFile4" style="display:none"
										onchange="return ajaxFileUpload('4');">
										<br>
										<button id="imgUpload4" class="btn btn-xs btn-default" 
											onclick="$('#imageFile4').click();return false;">
											<?= UPLOAD_NEW_IMAGE ?>
										</button>
										<br>
										<br>
									</form>					
								</div>
							</div>

						</div>
					</div>

				</div> {{!-- tab-pane tab_1 --}}
				
				<div class="tab-pane" id="tab_2{{VehicleID}}">
					<div class="row">
						<div class="col-md-3">
							<label for="SurCategory"><?=SURCATEGORY;?></label>
						</div>
						<div class="col-md-9">
							<select name="SurCategory" id="SurCategory" class="w100" 
							onchange="vehicleSurcharges({{VehicleID}});">
							
								{{#select SurCategory}}
									<option value="1"><?= USE_GLOBAL ?></option>
									<option value="2"><?= VEHICLE_SPECIFIC ?></option>
									<option value="0"><?= NO_SURCHARGES ?></option>
								{{/select}}								
							
							</select>
							
							<input type="hidden" name="SurID" id="SurID" class="w100" value="{{SurID}}">
						</div>
					</div>
					<div id="vehicleSurcharges{{VehicleID}}"></div>

				</div> {{!-- tab-pane tab_2 --}}

	    </div>
		    

	<!-- Statuses and messages -->
	<div class="box-footer">
		<? if (!$isNew) { ?>
		<div>
    	<button class="btn btn-default" onclick="return deletev4_Vehicles('{{VehicleID}}', '<?= $inList ?>');">
    		<i class="fa fa-trash-o l"></i> <?= DELETE ?>
    	</button>
    	</div>
    	<? } ?>

	</div>
</form>


	<script>
		// init 
		vehicleSurcharges({{VehicleID}});
		
		//bootstrap WYSIHTML5 - text editor
		$(".textarea").wysihtml5({
				"font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
				"emphasis": true, //Italics, bold, etc. Default true
				"lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
				"html": true, //Button which allows you to edit the generated HTML. Default false
				"link": true, //Button to insert a link. Default true
				"image": false, //Button to insert an image. Default true,
				"color": false //Button to change color of font 
				
		});
		
		// uklanja ikonu Saved - statusMessage sa ekrana
		$("form").change(function(){
			$("#statusMessage").html('');
		});
		
		
		
		function ajaxFileUpload(vehicleImageNo)
		{
			$("#loading")
			.ajaxStart(function(){
				$(this).show();
			})
			.ajaxComplete(function(){
				$(this).hide();
			});

			var VehicleID = $("#VehicleID").val();
			
			$.ajaxFileUpload
			(
				{
					url: 	window.root + 
							'/cms/a/saveVehicleImage.php?VehicleID='+VehicleID+
							'&ImageNo='+vehicleImageNo,
					secureuri:false,
					fileElementId:'imageFile'+vehicleImageNo,
					dataType: 'json',
					//data:{UserID: UserID},
					success: function (data, status)
					{
						if(typeof(data.error) != 'undefined')
						{
							if(data.error != '')
							{
								alert(data.error);
							}else
							{
								//alert(data.msg);
								$("#imageDiv"+vehicleImageNo+" > img").attr('src', data.img);

							}
						}

					},
					error: function (data, status, e)
					{
						// console.log(data);
                        alert(e);
					}
					
				}
			)
		
			return false;

		}		
	
	</script>
</script>
	
