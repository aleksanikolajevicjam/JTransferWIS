
<script type="text/x-handlebars-template" id="ItemEditTemplate">
<form id="ItemEditForm{{ID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
	<div class="box-header">
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
					<div class="col-md-2">
						<label for="ID"><?=ID;?></label>
					</div>
					<div class="col-md-10">
						{{ID}}
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<label for="DisplayOrder">Display order</label>
					</div>
					<div class="col-md-10">
						<input type="text" name="DisplayOrder" id="DisplayOrder" class="w100" value="{{DisplayOrder}}">
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-2">
						<label for="Active">Active</label>
					</div>
					<div class="col-md-10">
						<select class="w100" name="Active"  value="{{Active}}">
							<option value="0" {{#compare Active "==" 0}} selected {{/compare}}>Not Active</option>
							<option value="1" {{#compare Active "==" 1}} selected {{/compare}}>Expense</option>
							<option value="2" {{#compare Active "==" 2}} selected {{/compare}}>Activity</option>
						</select>					
					</div>
				</div>				


						
				<div class="row">
					<div class="col-md-2">
						<label for="Title">Title</label>
					</div>
					<div class="col-md-10">
						<input type="text" name="Title" id="Title" class="w100" value="{{Title}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<label for="Title">Reciver ID</label>
					</div>
					<div class="col-md-10">
						<input type="text" name="ReciverID" id="Title" class="w100" value="{{ReciverID}}">
					</div>
				</div>

			</div>
	    </div>
		    

	<!-- Statuses and messages -->
	<div class="box-footer">
		<? if (!$isNew) { ?>
		<div>
    	<button class="btn btn-default" onclick="return deletev4_Actions('{{ID}}', '<?= $inList ?>');">
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
	
