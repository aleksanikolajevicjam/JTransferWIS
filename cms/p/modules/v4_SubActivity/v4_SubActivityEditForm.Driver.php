<style>


.small {
	width: auto;
	height: 25px;
	background-color: #d6edfc;
}
	.large {
	width: 700px;
	height: auto;

	background-color: #fc0;
	margin: 10px auto;
}
.rotate {
  -moz-transform: rotate(90deg);
  -webkit-transform: rotate(90deg);
  -o-transform: rotate(90deg);
  -ms-transform: rotate(90deg);
  transform: rotate(90deg);
}
  </style>

<script type="text/x-handlebars-template" id="v4_SubActivityEditTemplate">
<form id="v4_SubActivityEditForm{{ID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
	<div class="box-header">
		<div class="box-title">
			<? if ($isNew) { ?>
				<h3>New activity</h3>
			<? } else { ?>
				<h3><?= EDIT ?> - {{ID}}</h3>
			<? } ?>
		</div>
		<div class="box-tools pull-right">
			
			<span id="statusMessage" class="text-info xl"></span>
			
			<? if (!$isNew) { ?>
				<? if ($inList=='true') { ?>
					<button class="btn" title="<?= CLOSE?>" 
					onclick="return editClosev4_SubActivity('{{ID}}', '<?= $inList ?>');">
					<i class="fa fa-arrow-up"></i>
					</button>
				<? } else { ?>
					<button class="btn btn-danger" title="<?= CANCEL ?>" 
					onclick="return deletev4_SubActivity('{{ID}}', '<?= $inList ?>');">
					<i class="fa fa-ban"></i>
					</button>
				<? } ?>	
			<? } ?>	
			<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
			onclick="return editSavev4_SubActivity('{{ID}}', '<?= $inList ?>');">
			<i class="ic-disk"></i>
			</button>
		</div>
	</div>

	<div class="box-body">
        <div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-3">
						<label for="Datum"><?=DATUM;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="Datum" id="Datum" class="w100 datepicker" value="{{Datum}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Expense"><?=EXPENSE;?></label>
					</div>
					<div class="col-md-9">
						<!--<div class="input-group">
							<div class="input-group-btn" style="padding-bottom:4px">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="height:40px;">
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" style="left:0px;width:100%;">
									<?
									foreach ($opis as $expenseID => $expense) {
										echo '<li onclick="selectExpense('.$expenseID.',this)" style="padding:4px;cursor:pointer">'.$expense.'</li>';
									}
									?>
								</ul>
							</div>

							<? /* TODO zbog ovoga ce trebat tablica za nazive expenses-a, handlebars i php neidu skupa */ ?>
							<input type="text" id="ExpenseText" class="w100"
							value='{{#compare Expense "==" 1}} Gorivo {{/compare}}{{#compare Expense "==" 2}} Autoput {{/compare}}{{#compare Expense "==" 3}} Parking {{/compare}}{{#compare Expense "==" 4}} Pranje {{/compare}}{{#compare Expense "==" 5}} Popravci {{/compare}}{{#compare Expense "==" 6}} Plaća {{/compare}}	{{#compare Expense "==" 7}} Piće {{/compare}}{{#compare Expense "==" 8}} Polog na račun {{/compare}}{{#compare Expense "==" 9}} Sredstva za čišćenje {{/compare}}{{#compare Expense "==" 10}} Djelovi za auto {{/compare}}{{#compare Expense "==" 11}} Vozac predao direktoru {{/compare}}{{#compare Expense "==" 12}} Administrator predao direktoru {{/compare}}{{#compare Expense "==" 13}} Vozac predao Antoniu {{/compare}}{{#compare Expense "==" 14}} Vozac predao Nikši {{/compare}}{{#compare Expense "==" 15}} Vozac predao Peri {{/compare}}{{#compare Expense "==" 16}} Vozac predao Damiru {{/compare}}{{#compare Expense "==" 99}} Ostalo {{/compare}}' style="margin:0">
						</div>!-->
						<input type="hidden" name="actionsid" id="actionsid" value="{{Expense}}">
						<select class="w100" name="Expense" id='actionsselect' value="{{Expense}}">
							<?
							foreach ($opis as $key=>$o) {
								echo '<option value="'.$key.'">'.$o.'</option>';
							}
							?>
						</select>
					</div>
					
					
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Description"><?= DESCRIPTION ?></label>
					</div>
					<div class="col-md-9">
						<textarea name="Description" id="Description" class="w100" style="resize:none">{{Description}}</textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Note"><?= NOTE ?></label>
					</div>
					<div class="col-md-9">
						<textarea name="Note" id="Note" class="w100" style="resize:none">{{Note}}</textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<label for="Approved">Approved</label>
                    </div>
					<div class="col-md-9">				
						<input type="hidden" name="Approved" id="a{{ID}}" value="{{Approved}}">
						<input type="checkbox" id="{{ID}}" {{#compare Approved "==" 1}} checked {{/compare}} onclick="checkApproved({{ID}})">
					</div>
				</div>				
			</div>

			<div class="col-md-6">
				<div class="row">
					<div class="col-md-3">
						<label for="DriverID"><?=DRIVER;?></label>
					</div>
					<div class="col-md-9">
						<select class="w100" name="DriverID">
						{{#select DriverID}}
							<?
							foreach ($driverArr as $driver) {
								echo '<option value="'.$driver->AuthUserID.'">'.$driver->AuthUserRealName.'</option>';
							}
							?>
						{{/select}}
						</select>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Vehicle">Vehicle</label>
					</div>
					<div class="col-md-9">
						<select class="w100" name="VehicleID">
						{{#select VehicleID}}
							<?
							foreach ($vehicleArr as $vehicle) {
								echo '<option value="'.$vehicle->VehicleID.'">'.$vehicle->VehicleDescription.'</option>';
							}
							?>
						{{/select}}
						</select>
					</div>
				</div>
				




				
				<div class="row">
					<div class="col-md-3">
						<label for="DocumentImage">Document Image</label>
                    </div>
					<div class="col-md-9">
						<input type="hidden" id='docimage' name="DocumentImage" value='{{DocumentImage}}'/>
						<img id='docimage2' class="small" src="" alt="" height="50" width="50">
						<button id="image_delete" class="btn btn-default" >
							<i class="ic-cancel-circle"></i>
						</button>
						<input id='DocumentImageX' type="file"  name="DocumentImageX" onchange="editSaveIMGv4_SubActivity()">

					</div>
				</div>
				

				<div class="row">
					<div class="col-md-3">
						<label for="ActionImage">Action Image</label>
                    </div>
					<div class="col-md-9">
						<input name='ActionImage' type="hidden" id='actimage' value='{{ActionImage}}'/>
						<video id='actimage3' height="50" width="50" controls>
							<source id='actimage2' src="" alt="" type="video/mp4">
						</video>											
						<button id="action_delete" class="btn btn-default" >
							<i class="ic-cancel-circle"></i>
						</button>					
						<input id='ActionImageX' type="file"  name="ActionImageX" onchange="editSaveVIDv4_SubActivity()">						
					</div>
				</div>	


				
			</div>
	    </div>
		
		{{#each checklist}}
		<div class="row">
					<div class="col-md-3">
						<label for="Description">{{title}}</label>
					</div>	
					<div class="col-md-1">
						<input type="checkbox" name="check{{id}}" style="height: 0.8em" value="1" 
						{{#compare checked "==" 1 }} checked {{/compare}}> 
					</div>		
				</div>	
	
		{{/each}}
		
		
		<input type="hidden" name='OwnerID' value='{{OwnerID}}'/>
	</form>				
		    
		
	<!-- Statuses and messages -->
	<div class="box-footer">
		<? if (!$isNew) { ?>
		<div>
    	<button class="btn btn-default" onclick="return deletev4_SubActivity('{{ID}}', '<?= $inList ?>');">
    		<i class="ic-cancel-circle"></i> <?= DELETE ?>
    	</button>
    	</div>
    	<? } ?>

	</div>


	<script>	
		var actionid=$('#actionsid').val();
		$("#actionsselect option[value="+actionid+"]").attr("selected", "selected");		 
		
		$('img').click(function() {
			$(this).attr('class','large');	   

		})	
		$('#image_delete').click(function() {
			$("#docimage").val('');	   
			$("#docimage2").hide();	
			$('#image_delete').hide();	
		})			
		

		$('#action_delete').click(function() {
			$("#actimage").val('');	   
			$("#actimage3").hide();	
			$('#action_delete').hide();	
		})
		
		$('img').mouseout(function() {
			$(this).attr('class','small');
		})	
		$('img').dblclick(function() {
			$(this).addClass('rotate');

		})	
		var docimage=$('#docimage').val();
		if (docimage !='' && docimage !='null') {
			$('#docimage2').attr('src',docimage);
		}
		else {
			$("#docimage2").hide();	
			$('#image_delete').hide();	
		}			
	
		var actimage=$('#actimage').val(); 
		if (actimage !='' && actimage !='null') {
			$('#actimage2').attr('src',actimage); 
		}
		else {
			$("#actimage3").hide();	
			$('#action_delete').hide();	
		}	
		
		// uklanja ikonu Saved - statusMessage sa ekrana
		$("form").change(function(){
			$("#statusMessage").html('');
		});

		$(".datepicker").pickadate({format: "yyyy-mm-dd"});

		function selectExpense (expenseID, li) {
			document.getElementById("Expense").value = expenseID;
			document.getElementById("ExpenseText").value = li.innerHTML;
		}

		function selectCurrency (currencyID) {
			document.getElementById("CurrencyID").value = currencyID;
		}

		function checkApproved(id)
		{
		  var checkbox = document.getElementById(id);
		  var Approved = document.getElementById('a'+id);
		  
		  if (checkbox.checked != true)
		  {
			Approved.value = '0';
		  } else Approved.value = '1';
		  
		console.log(Approved.value);
		}		
	</script>
</script>
	
