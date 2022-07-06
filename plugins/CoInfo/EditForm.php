
<script type="text/x-handlebars-template" id="ItemEditTemplate">
<form id="ItemEditForm{{ID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
	<div class="box-header">
		<div class="box-title">
			<? if ($isNew) { ?>
				<h3><?= NNEW ?></h3>
			<? } else { ?>
				<h3><?= EDIT ?> - {{co_name}}</h3>
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
						<label for="co_name"><?=CO_NAME;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="co_name" id="co_name" class="w100" value="{{co_name}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_address"><?=CO_ADDRESS;?></label>
					</div>
					<div class="col-md-9">
						<textarea name="co_address" id="co_address" rows="5" 
					class="textarea" cols="50" style="width:100%">{{co_address}}</textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_tel"><?=CO_TEL;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="co_tel" id="co_tel" class="w100" value="{{co_tel}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_fax"><?=CO_FAX;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="co_fax" id="co_fax" class="w100" value="{{co_fax}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_city"><?=CO_CITY;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="co_city" id="co_city" class="w100" value="{{co_city}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_country"><?=CO_COUNTRY;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="co_country" id="co_country" class="w100" value="{{co_country}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_zip"><?=CO_ZIP;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="co_zip" id="co_zip" class="w100" value="{{co_zip}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_email"><?=CO_EMAIL;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="co_email" id="co_email" class="w100" value="{{co_email}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_taxno"><?=CO_TAXNO;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="co_taxno" id="co_taxno" class="w100" value="{{co_taxno}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_bank"><?=CO_BANK;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="co_bank" id="co_bank" class="w100" value="{{co_bank}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_accountno"><?=CO_ACCOUNTNO;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="co_accountno" id="co_accountno" class="w100" value="{{co_accountno}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_iban"><?=CO_IBAN;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="co_iban" id="co_iban" class="w100" value="{{co_iban}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_swift"><?=CO_SWIFT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="co_swift" id="co_swift" class="w100" value="{{co_swift}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_domestictax"><?=CO_DOMESTICTAX;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="co_domestictax" id="co_domestictax" class="w100" value="{{co_domestictax}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_foreigntax"><?=CO_FOREIGNTAX;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="co_foreigntax" id="co_foreigntax" class="w100" value="{{co_foreigntax}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_eurinfo"><?=CO_EURINFO;?></label>
					</div>
					<div class="col-md-9">
						<textarea name="co_eurinfo" id="co_eurinfo" rows="5" 
					class="textarea" cols="50" style="width:100%">{{co_eurinfo}}</textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_paymentinfo"><?=CO_PAYMENTINFO;?></label>
					</div>
					<div class="col-md-9">
						<textarea name="co_paymentinfo" id="co_paymentinfo" rows="5" 
					class="textarea" cols="50" style="width:100%">{{co_paymentinfo}}</textarea>
					</div>
				</div>
<hr>
				<div class="row">
					<div class="col-md-3">
						<label for="co_facebook"><?=CO_FACEBOOK;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="co_facebook" id="co_facebook" class="w100" value="{{co_facebook}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_twitter"><?=CO_TWITTER;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="co_twitter" id="co_twitter" class="w100" value="{{co_twitter}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_linkedin"><?=CO_LINKEDIN;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="co_linkedin" id="co_linkedin" class="w100" value="{{co_linkedin}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_youtube"><?=CO_YOUTUBE;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="co_youtube" id="co_youtube" class="w100" value="{{co_youtube}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="co_googleplus"><?=CO_GOOGLEPLUS;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="co_googleplus" id="co_googleplus" class="w100" value="{{co_googleplus}}">
					</div>
				</div>




			</div>
	    </div>
		    

	<!-- Statuses and messages -->
	<div class="box-footer">
		<? if (!$isNew) { ?>
		<div>
    	<button class="btn btn-default hidden" onclick="return deleteItem('{{ID}}', '<?= $inList ?>');">
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
				"lists": false, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
				"html": false, //Button which allows you to edit the generated HTML. Default false
				"link": false, //Button to insert a link. Default true
				"image": false, //Button to insert an image. Default true,
				"color": false //Button to change color of font 
				
		});
		
		// uklanja ikonu Saved - statusMessage sa ekrana
		$("form").change(function(){
			$("#statusMessage").html('');
		});
	
	</script>
</script>
	
