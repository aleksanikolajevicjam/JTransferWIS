
<script type="text/x-handlebars-template" id="v4_LabelsEditTemplate">
<form id="v4_LabelsEditForm{{LabelID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
	<div class="box-header">
		<div class="box-title">
			<? if ($isNew) { ?>
				<h3><?= NNEW ?></h3>
			<? } else { ?>
				<h3><?= EDIT ?> - {{Label}}</h3>
			<? } ?>
		</div>
		<div class="box-tools pull-right">
			
			<span id="statusMessage" class="text-info xl"></span>
			
			<? if (!$isNew) { ?>

				<button class="btn" title="<?= CLOSE?>" 
				onclick="return editClosev4_Labels('{{LabelID}}', '<?= $inList ?>');">
				<i class="fa fa-arrow-up"></i>
				</button>

				<button class="btn btn-danger" title="<?= CANCEL ?>" 
				onclick="return deletev4_Labels('{{LabelID}}', '<?= $inList ?>');">
				<i class="fa fa-ban"></i>
				</button>

			<? } ?>	
			<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
			onclick="return editSavev4_Labels('{{LabelID}}', '<?= $inList ?>');">
			<i class="ic-disk"></i>
			</button>
		</div>
	</div>

	<div class="box-body ">
        <div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-3">
						<label for="LabelEN">Label KEY</label>
					</div>
					<div class="col-md-9">
						<input type="text" name="Label" id="Label" class="w100" value="{{Label}}">
					</div>
				</div>				
				<div class="row">
					<div class="col-md-3">
						<label for="LabelEN">Label (EN)</label>
					</div>
					<div class="col-md-9">
						<input type="text" name="LabelEN" id="LabelEN" class="w100" value="{{LabelEN}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="LabelRU">Label (RU)</label>
					</div>
					<div class="col-md-9">
						<input type="text" name="LabelRU" id="LabelRU" class="w100" value="{{LabelRU}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="LabelFR">Label (FR)</label>
					</div>
					<div class="col-md-9">
						<input type="text" name="LabelFR" id="LabelFR" class="w100" value="{{LabelFR}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="LabelDE">Label (DE)</label>
					</div>
					<div class="col-md-9">
						<input type="text" name="LabelDE" id="LabelDE" class="w100" value="{{LabelDE}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="LabelIT">Label (IT)</label>
					</div>
					<div class="col-md-9">
						<input type="text" name="LabelIT" id="LabelIT" class="w100" value="{{LabelIT}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="LabelSE">Label (SE)</label>
					</div>
					<div class="col-md-9">
						<input type="text" name="LabelSE" id="LabelSE" class="w100" value="{{LabelSE}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="LabelNO">Label (NO)</label>
					</div>
					<div class="col-md-9">
						<input type="text" name="LabelNO" id="LabelNO" class="w100" value="{{LabelNO}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="LabelES">Label (ES)</label>
					</div>
					<div class="col-md-9">
						<input type="text" name="LabelES" id="LabelES" class="w100" value="{{LabelES}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="LabelNL">Label (NL)</label>
					</div>
					<div class="col-md-9">
						<input type="text" name="LabelNL" id="LabelNL" class="w100" value="{{LabelNL}}">
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
	
	</script>
</script>

