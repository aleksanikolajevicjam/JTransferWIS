
<script type="text/x-handlebars-template" id="v4_DriversEditTemplate">
<form id="v4_DriversEditForm{{DriverID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
	<div class="box-header">
		<div class="box-title">
			<? if ($isNew) { ?>
				<h3><?= NNEW ?></h3>
			<? } else { ?>
				<h3><?= EDIT ?> - {{Ime}} {{Prezime}} </h3>
			<? } ?>
		</div>
		<div class="box-tools pull-right">
			
			<span id="statusMessage" class="text-info xl"></span>
			
			<? if (!$isNew) { ?>
				<? if ($inList=='true') { ?>
					<button class="btn btn-warning" title="<?= CLOSE?>" 
					onclick="return editClosev4_Drivers('{{DriverID}}', '<?= $inList ?>');">
					<i class="ic-close"></i>
					</button>
				<? } else { ?>
					<button class="btn btn-danger" title="<?= CANCEL ?>" 
					onclick="return deletev4_Drivers('{{DriverID}}', '<?= $inList ?>');">
					<i class="fa fa-ban"></i>
					</button>
				<? } ?>	
			<? } ?>	
			<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
			onclick="return editSavev4_Drivers('{{DriverID}}', '<?= $inList ?>');">
			<i class="ic-disk"></i>
			</button>
			<? if (!$isNew) { ?>
				<button class="btn btn-danger" title="<?= PRINTIT ?>" 
				onclick="return editPrintv4_Drivers('{{DriverID}}', '<?= $inList ?>');">
				<i class="ic-print"></i>
				</button>
			<? } ?>	
		</div>
	</div>

	<div class="box-body ">
        <div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="row">
					<div class="col-md-3">
						<label for="SiteID"><?=SITEID;?></label>
					</div>
					<div class="col-md-9">
						{{SiteID}}
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="DriverID"><?=DRIVERID;?></label>
					</div>
					<div class="col-md-9">
						{{DriverID}}
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Company"><?=COMPANY;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="Company" id="Company" class="w100" value="{{Company}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Tel"><?=TEL;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="Tel" id="Tel" class="w100" value="{{Tel}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Fax"><?=FAX;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="Fax" id="Fax" class="w100" value="{{Fax}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="City"><?=CITY;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="City" id="City" class="w100" value="{{City}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Terminal"><?=TERMINAL;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="Terminal" id="Terminal" class="w100" value="{{Terminal}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Country"><?=COUNTRY;?></label>
					</div>
					<div class="col-md-9">
						{{countrySelect Country 'Country' 'Code3'}}
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Account"><?=ACCOUNT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="Account" id="Account" class="w100" value="{{Account}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="IBAN"><?=IBAN;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="IBAN" id="IBAN" class="w100" value="{{IBAN}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Active"><?=ACTIVE;?></label>
					</div>
					<div class="col-md-9">
						{{yesNoSelect Active 'Active'}}
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Ime"><?=IME;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="Ime" id="Ime" class="w100" value="{{Ime}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Prezime"><?=PREZIME;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="Prezime" id="Prezime" class="w100" value="{{Prezime}}">
					</div>
				</div>


				<div class="row">
					<div class="col-md-3">
						<label for="Email"><?=EMAIL;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="Email" id="Email" class="w100" value="{{Email}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Opis"><?=OPIS;?></label>
					</div>
					<div class="col-md-9">
						<textarea name="Opis" id="Opis" rows="5" 
					class="textarea" cols="50" style="width:100%">{{Opis}}</textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Discount"><?=DISCOUNT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="Discount" id="Discount" class="w100" value="{{Discount}}">
					</div>
				</div>


			</div>
	    </div>
		    

	<!-- Statuses and messages -->
	<div class="box-footer">
		<? if (!$isNew) { ?>
		<div>
    	<button class="btn btn-default" onclick="return deletev4_Drivers('{{DriverID}}', '<?= $inList ?>');">
    		<i class="ic-cancel-circle"></i> <?= DELETE ?>
    	</button>
    	</div>
    	<? } ?>

	</div>
</form>


	<script>

		//bootstrap WYSIHTML5 - text editor
		$(".textarea").wysihtml5({
				"font-styles": false, //Font styling, e.g. h1, h2, etc. Default true
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
	
