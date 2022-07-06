<script type="text/x-handlebars-template" id="ItemEditTemplate">
<form id="ItemEditForm{{ID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
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
						<label for="ID"><?=ID;?></label>
					</div>
					<div class="col-md-9">
						{{ID}}
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Date"><?=DATE;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="Date" id="Date" class="w100 datepicker" value="{{Date}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="OrderID"><?=ORDERID;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="OrderID" id="OrderID" class="w100" value="{{OrderID}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="RouteID"><?=ROUTEID;?></label>
					</div>
					<div class="col-md-9">
						<?/* <input type="text" name="RouteID" id="RouteID" class="w100" value="{{RouteID}}"> */?>
						{{routeSelect RouteID 'RouteID'}}
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="UserEmail"><?=USEREMAIL;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="UserEmail" id="UserEmail" class="w100" value="{{UserEmail}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="UserName"><?=USERNAME;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="UserName" id="UserName" class="w100" value="{{UserName}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Comment"><?=COMMENT;?></label>
					</div>
					<div class="col-md-9">
						<textarea name="Comment" id="Comment" rows="5" 
					class="textarea" cols="50" style="width:100%">{{Comment}}</textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Approved"><?=APPROVED;?></label>
					</div>
					<div class="col-md-9">
						{{approvedSelect Approved}}
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="row">
					<div class="col-md-4">
						<label for="ScoreService"><?=SCORESERVICE;?></label>
					</div>
					<div class="col-md-8">
						{{scoreSelect ScoreService 'ScoreService'}}
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<label for="ScoreDriver"><?=SCOREDRIVER;?></label>
					</div>
					<div class="col-md-8">
						{{scoreSelect ScoreDriver 'ScoreDriver'}}
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<label for="ScoreClean"><?=SCORECLEAN;?></label>
					</div>
					<div class="col-md-8">
						{{scoreSelect ScoreClean 'ScoreClean'}}
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<label for="ScoreValue"><?=SCOREVALUE;?></label>
					</div>
					<div class="col-md-8">
						{{scoreSelect ScoreValue 'ScoreValue'}}
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<label for="ScoreWebsite"><?=SCOREWEBSITE;?></label>
					</div>
					<div class="col-md-8">
						{{scoreSelect ScoreWebsite 'ScoreWebsite'}}
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<label for="ScoreTotal"><?=SCORETOTAL;?></label>
					</div>
					<div class="col-md-8">
						<input type="text" name="ScoreTotal" id="ScoreTotal" class="w100" value="{{ScoreTotal}}" disabled style="color:black;border:none">
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<label for="DriverOnTime"><?=DRIVERONTIME;?></label>
					</div>
					<div class="col-md-8">
						{{yesNoSelect DriverOnTime}}
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<label for="Recommend"><?=RECOMMEND;?></label>
					</div>
					<div class="col-md-8">
						{{recommendSelect Recommend}}
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<label for="BookAgain"><?=BOOKAGAIN;?></label>
					</div>
					<div class="col-md-8">
						{{bookAgainSelect BookAgain}}
					</div>
				</div>

			</div>
	    </div>

	<!-- Statuses and messages -->
</form>

	<script>		
		// uklanja ikonu Saved - statusMessage sa ekrana
		$("form").change(function(){
			$("#statusMessage").html('');
		});

		$(".datepicker").pickadate({format: "yyyy-mm-dd"});

		var ScoreService 	= document.getElementById("ScoreService");
		var ScoreDriver 	= document.getElementById("ScoreDriver");
		var ScoreClean 		= document.getElementById("ScoreClean");
		var ScoreValue 		= document.getElementById("ScoreValue");
		var ScoreWebsite 	= document.getElementById("ScoreWebsite");

		ScoreService.addEventListener("input", recalculateTotal);
		ScoreDriver.addEventListener("input", recalculateTotal);
		ScoreClean.addEventListener("input", recalculateTotal);
		ScoreValue.addEventListener("input", recalculateTotal);
		ScoreWebsite.addEventListener("input", recalculateTotal);

		function recalculateTotal () {
			var newTotal = parseInt(ScoreService.value) + parseInt(ScoreDriver.value)
							+ parseInt(ScoreClean.value) + parseInt(ScoreValue.value) + parseInt(ScoreWebsite.value);
			document.getElementById("ScoreTotal").value = (newTotal / 5).toFixed(1);
		}
	</script>
</script>

