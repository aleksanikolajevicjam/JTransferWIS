
<script type="text/x-handlebars-template" id="ItemEditTemplate">
<form id="ItemEditForm{{ID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
	<div class="box-header">
		<div class="box-title">
			<? if ($isNew) { ?>
				<h3><?= NNEW ?></h3>
			<? } else { ?>
				<h3><?= EDIT ?> - {{Title}}</h3>
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
						<label for="Language"><?=LANGUAGE;?></label>
					</div>
					<div class="col-md-9">
						{{languageSelect Language}}
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Title"><?=TITLE;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="Title" id="Title" class="w100" value="{{Title}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Article"><?=ARTICLE;?></label>
					</div>
					<div class="col-md-9">
						<textarea name="Article" id="Article{{ID}}" rows="100" 
							class="textarea" cols="70" style="width:100%">{{{Article}}}</textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Page"><?=PAGE;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="Page" id="Page" class="w100" value="{{Page}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Position"><?=POSITION;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="Position" id="Position" class="w100" value="{{Position}}">
					</div>
				</div>

<!--
				<div class="row">
					<div class="col-md-3">
						<label for="HTMLBefore"><?=HTMLBEFORE;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="HTMLBefore" id="HTMLBefore" class="w100" value="{{HTMLBefore}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="HTMLAfter"><?=HTMLAFTER;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="HTMLAfter" id="HTMLAfter" class="w100" value="{{HTMLAfter}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Classes"><?=CLASSES;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="Classes" id="Classes" class="w100" value="{{Classes}}">
					</div>
				</div>
-->
				<div class="row">
					<div class="col-md-3">
						<label for="Published"><?=PUBLISHED;?></label>
					</div>
					<div class="col-md-9">
						{{yesNoSelect Published 'Published' }}
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
						<label for="UserID"><?=USERID;?></label>
					</div>
					<div class="col-md-9">
						{{UserID}}
					</div>
				</div>


			</div>
	    </div>
		    

	<!-- Statuses and messages -->
	<div class="box-footer">
		<? if (!$isNew) { ?>
		<div>
    	<button class="btn btn-default" onclick="return deleteItem('{{ID}}', '<?= $inList ?>');">
    		<i class="ic-cancel-circle"></i> <?= DELETE ?>
    	</button>
    	</div>
    	<? } ?>

	</div>
</form>


	<script>
//$('#Article').destroy();	


$("#Article{{ID}}").summernote({
height: 320,
toolbar: [
    //[groupname, [button list]]
     
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    //['height', ['height']],
    ['misc', ['codeview']],
    ['insert',['picture', 'video','link','hr']]
  ],
  codemirror: {
  		lineWrapping:true
  }
});
	
function postForm() {
	$('#Article{{ID}}').text($('#Article{{ID}}').code());
	return false;
}
		// uklanja ikonu Saved - statusMessage sa ekrana
		$("form").change(function(){
			$("#statusMessage").html('');
		});
</script>
</script>
	
