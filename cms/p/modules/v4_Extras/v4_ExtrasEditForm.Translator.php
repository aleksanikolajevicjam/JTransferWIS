
<script type="text/x-handlebars-template" id="v4_ExtrasEditTemplate">
<form id="v4_ExtrasEditForm{{ID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
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
					<button class="btn" title="<?= CLOSE?>" 
					onclick="return editClosev4_Extras('{{ID}}', '<?= $inList ?>');">
					<i class="fa fa-arrow-up"></i>
					</button>
				<? } else { ?>
					<button class="btn btn-danger" title="<?= CANCEL ?>" 
					onclick="return deletev4_Extras('{{ID}}', '<?= $inList ?>');">
					<i class="fa fa-ban"></i>
					</button>
				<? } ?>	
			<? } ?>	
			<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
			onclick="return editSavev4_Extras('{{ID}}', '<?= $inList ?>');">
			<i class="ic-disk"></i>
			</button>
		</div>
	</div>

	<div class="box-body ">
        <div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-3">
						<label for="ServiceEN"><?=SERVICE.LEN;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="ServiceEN" id="ServiceEN" class="w100" value="{{ServiceEN}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="ServiceRU"><?=SERVICE.LRU;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="ServiceRU" id="ServiceRU" class="w100" value="{{ServiceRU}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="ServiceFR"><?=SERVICE.LFR;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="ServiceFR" id="ServiceFR" class="w100" value="{{ServiceFR}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="ServiceDE"><?=SERVICE.LDE;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="ServiceDE" id="ServiceDE" class="w100" value="{{ServiceDE}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="ServiceIT"><?=SERVICE.LIT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="ServiceIT" id="ServiceIT" class="w100" value="{{ServiceIT}}">
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
	
	</script>
</script>
	
