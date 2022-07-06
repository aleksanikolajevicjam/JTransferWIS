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

<script type="text/x-handlebars-template" id="v4_VehicleEquipmentListEditTemplate">
<form id="v4_VehicleEquipmentListEditForm{{ID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
	<div class="box-header">
		<div class="box-title">
			<? if ($isNew) { ?>
				<h3>New equipment list - <?= $vh->VehicleDescription ?></h3>
			<? } else { ?>
				<h3><?= EDIT ?> - {{ListID}}</h3>
			<? } ?>
		</div>
		<div class="box-tools pull-right">
			
			<span id="statusMessage" class="text-info xl"></span>
			
			<? if (!$isNew) { ?>
				<? if ($inList=='true') { ?>
					<button class="btn" title="<?= CLOSE?>" 
					onclick="return editClosev4_VehicleEquipmentList('{{ID}}', '<?= $inList ?>');">
					<i class="fa fa-arrow-up"></i>
					</button>
				<? } else { ?>
					<button class="btn btn-danger" title="<?= CANCEL ?>" 
					onclick="return deletev4_VehicleEquipmentList('{{ID}}', '<?= $inList ?>');">
					<i class="fa fa-ban"></i>
					</button>
				<? } ?>	
			<? } ?>	
			<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
			onclick="return editSavev4_VehicleEquipmentList('{{ID}}', '<?= $inList ?>');">
			<i class="ic-disk"></i>
			</button>
		</div>
	</div>

	<div class="box-body">
        <div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-3">
						<label for="List">List</label>
					</div>
					<div class="col-md-9">
						<input type="text" name="ListID" id="ListID" class="w100" value="{{ListID}}">						
					</div>
				</div>			
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
						<label for="Description"><?= DESCRIPTION ?></label>
					</div>
					<div class="col-md-9">
						<textarea name="Description" id="Description" class="w100" style="resize:none">{{Description}}</textarea>
					</div>
				</div>

			</div>
			<div class="col-md-6">
	
			
			{{#each checklist}}
				<div class="row">
					<div class="col-md-9">
						<label for="Description">{{title}}</label>
					</div>	
					<div class="col-md-3">
						<input type="checkbox" name="check{{id}}" style="height: 0.8em" value="1" 
						{{#each ../eq_list}}
							{{#compare eqid "==" ../id }}
								checked
							{{/compare}}	
						{{/each}}
						> 
					</div>		
				</div>	
	
			{{/each}}			
			</div>

	
						
	    </div>
	</div>	
		<input type="hidden" name='OwnerID' value='{{OwnerID}}'/>
		<? if (isset($_REQUEST['VehicleID'])) { ?><input type="hidden" name="VehicleID" id="VehicleID" class="w100" value="<?= $_REQUEST['VehicleID'] ?>"><? } 
		else { ?><input type="hidden" name="VehicleID" id="VehicleID" class="w100" value="{{VehicleID}}"><? } ?>		
		
	</form>				
		    
		
	<!-- Statuses and messages -->
	<div class="box-footer">
		<? if (!$isNew) { ?>
		<div>
    	<button class="btn btn-default" onclick="return deletev4_VehicleEquipmentList('{{ID}}', '<?= $inList ?>');">
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
	
