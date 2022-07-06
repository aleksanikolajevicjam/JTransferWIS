<script type="text/x-handlebars-template" id="ItemEditTemplate">
<form id="ItemEditForm{{CountryID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
	<div class="box-header">

		<div class="box-tools pull-right">
			
			<span id="statusMessage" class="text-info xl"></span>
			
			<? if (!$isNew) { ?>
				<button class="btn btn-warning" title="<?= CLOSE?>" 
				onclick="return editCloseItem('{{CountryID}}');">
				<i class="fa fa-close"></i>
				</button>

				<button class="btn btn-danger" title="<?= CANCEL ?>" 
				onclick="return deleteItem('{{CountryID}}');">
				<i class="fa fa-ban"></i>
				</button>
			<? } ?>	
			<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
			onclick="return editSaveItem('{{CountryID}}');">
			<i class="fa fa-save"></i>
			</button>
		</div>
	</div>

	<div class="box-body ">
        <div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="row">
					<div class="col-md-3">
						<label for="CountryID"><?=COUNTRYID;?></label>
					</div>
					<div class="col-md-9">
						{{CountryID}}
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="CountryName"><?=COUNTRYNAME;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="CountryName" id="CountryName" class="w100" value="{{CountryName}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="CountryNameEN"><?=COUNTRYNAMEEN;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="CountryNameEN" id="CountryNameEN" class="w100" value="{{CountryNameEN}}">
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-3">
						<label for="CountryNameRU"><?=COUNTRYNAMERU;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="CountryNameRU" id="CountryNameRU" class="w100" value="{{CountryNameRU}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="CountryDesc"><?=COUNTRYDESC;?></label>
					</div>
					<div class="col-md-9">
						<textarea name="CountryDesc" id="CountryDesc" rows="5" 
					class="textarea" cols="50" style="width:100%">{{CountryDesc}}</textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="CountryISO"><?=COUNTRYISO;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="CountryISO" id="CountryISO" class="w100" value="{{CountryISO}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="CountryCode"><?=COUNTRYCODE;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="CountryCode" id="CountryCode" class="w100" value="{{CountryCode}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="CountryCode3"><?=COUNTRYCODE3;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="CountryCode3" id="CountryCode3" class="w100" value="{{CountryCode3}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="PhonePrefix"><?=PHONEPREFIX;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="PhonePrefix" id="PhonePrefix" class="w100" value="{{PhonePrefix}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Currency"><?=COUNTRY_CURRENCY;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="Currency" id="Currency" class="w100" value="{{Currency}}">
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

