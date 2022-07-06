<script type="text/x-handlebars-template" id="ItemEditTemplate">
<form id="ItemEditForm{{PlaceTypeID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
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
				onclick="return editCloseItem('{{PlaceTypeID}}');">
				<i class="fa fa-close"></i>
				</button>

				<button class="btn btn-danger" title="<?= CANCEL ?>" 
				onclick="return deleteItem('{{PlaceTypeID}}');">
				<i class="fa fa-ban"></i>
				</button>
			<? } ?>	
			<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
			onclick="return editSaveItem('{{PlaceTypeID}}');">
			<i class="fa fa-save"></i>
			</button>
		</div>
	</div>

	<div class="box-body ">
        <div class="row">
			<div class="col-md-6">
				<div class="row hidden">
					<div class="col-md-3">
						<label for="PlaceTypeID"><?=PLACETYPEID;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="PlaceTypeID" id="PlaceTypeID" class="w100" value="{{PlaceTypeID}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="PlaceTypeEN"><?=PLACETYPEEN;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="PlaceTypeEN" id="PlaceTypeEN" class="w100" value="{{PlaceTypeEN}}">
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
	