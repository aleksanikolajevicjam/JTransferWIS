
<script type="text/x-handlebars-template" id="v4_CoTextsEditTemplate">
<form id="v4_CoTextsEditForm{{ID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
	<div class="box-header">
		<div class="box-title">
			<? if ($isNew) { ?>
				<h3><?= NNEW ?></h3>
			<? } else { ?>
				<h3><?= EDIT ?> - {{language}}</h3>
			<? } ?>
		</div>
		<div class="box-tools pull-right">
			
			<span id="statusMessage" class="text-info xl"></span>
			
			<? if (!$isNew) { ?>
				<? if ($inList=='true') { ?>
					<button class="btn btn-warning" title="<?= CLOSE?>" 
					onclick="return editClosev4_CoTexts('{{ID}}', '<?= $inList ?>');">
					<i class="ic-close"></i>
					</button>
				<? } else { ?>
					<button class="btn btn-danger" title="<?= CANCEL ?>" 
					onclick="return deletev4_CoTexts('{{ID}}', '<?= $inList ?>');">
					<i class="fa fa-ban"></i>
					</button>
				<? } ?>	
			<? } ?>	
			<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
			onclick="return editSavev4_CoTexts('{{ID}}', '<?= $inList ?>');">
			<i class="ic-disk"></i>
			</button>
			<? if (!$isNew) { ?>
				<button class="btn btn-danger" title="<?= PRINTIT ?>" 
				onclick="return editPrintv4_CoTexts('{{ID}}', '<?= $inList ?>');">
				<i class="ic-print"></i>
				</button>
			<? } ?>	
		</div>
	</div>

	<div class="box-body ">
        <div class="row">
			<div class="col-md-12">
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
						<label for="language"><?=LANGUAGE;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="language" id="language" class="w100" value="{{language}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_homepage"><?=CO_HOMEPAGE;?></label>
					</div>
					<div class="col-md-9">
						<textarea name="co_homepage" id="co_homepage" 
					class="textarea" rows="30" style="width:100%">{{co_homepage}}</textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_desc"><?=CO_DESC;?></label>
					</div>
					<div class="col-md-9">
						<textarea name="co_desc" id="co_desc" 
					class="textarea" rows="30" style="width:100%">{{co_desc}}</textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_terms"><?=CO_TERMS;?></label>
					</div>
					<div class="col-md-9">
						<textarea name="co_terms" id="co_terms" 
					class="textarea" rows="30" style="width:100%">{{co_terms}}</textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_refund"><?=CO_REFUND;?></label>
					</div>
					<div class="col-md-9">
						<textarea name="co_refund" id="co_refund" 
					class="textarea" rows="30" style="width:100%">{{co_refund}}</textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_privacy"><?=CO_PRIVACY;?></label>
					</div>
					<div class="col-md-9">
						<textarea name="co_privacy" id="co_privacy"  
					class="textarea" rows="30" style="width:100%">{{co_privacy}}</textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_howtobook"><?=CO_HOWTOBOOK;?></label>
					</div>
					<div class="col-md-9">
						<textarea name="co_howtobook" id="co_howtobook" 
					class="textarea" rows="30" style="width:100%">{{co_howtobook}}</textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_htmlblock"><?=CO_HTMLBLOCK;?></label>
					</div>
					<div class="col-md-9">
						<textarea name="co_htmlblock" id="co_htmlblock" 
					class="textarea" rows="30" style="width:100%">{{co_htmlblock}}</textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_sideblock"><?=CO_SIDEBLOCK;?></label>
					</div>
					<div class="col-md-9">
						<textarea name="co_sideblock" id="co_sideblock" 
					class="textarea" rows="30" style="width:100%">{{co_sideblock}}</textarea>
					</div>
				</div>


			</div>
	    </div>
		    

	<!-- Statuses and messages -->
	<div class="box-footer">
		<? if (!$isNew) { ?>
		<div>
    	<button class="btn btn-default" onclick="return deletev4_CoTexts('{{ID}}', '<?= $inList ?>');">
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
	
	</script>
</script>
	
