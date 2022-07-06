<script type="text/x-handlebars-template" id="v4_OrderLogEditTemplate">
<form id="v4_OrderLogEditForm{{ID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
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
					onclick="return editClosev4_OrderLog('{{ID}}', '<?= $inList ?>');">
					<i class="fa fa-arrow-up"></i>
					</button>
				<? } else { ?>
					<button class="btn btn-danger" title="<?= CANCEL ?>" 
					onclick="return deletev4_OrderLog('{{ID}}', '<?= $inList ?>');">
					<i class="fa fa-ban"></i>
					</button>
				<? } ?>	
			<? } ?>	
			<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
			onclick="return editSavev4_OrderLog('{{ID}}', '<?= $inList ?>');">
			<i class="ic-disk"></i>
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
						<label for="ShowToCustomer"><?= 'Show to customer' ?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="ShowToCustomer" id="ShowToCustomer" class="w100" value="{{ShowToCustomer}}">
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
						<label for="DetailsID"><?=DETAILSID;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="DetailsID" id="DetailsID" class="w100" value="{{DetailsID}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="UserID"><?=USERID;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="UserID" id="UserID" class="w100" value="{{UserID}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Icon"><?=ICON;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="Icon" id="Icon" class="w100" value="{{Icon}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Action"><?=ACTION;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="Action" id="Action" class="w100" value="{{Action}}">
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
			</div>

			<div class="col-md-6">
				<div class="row">
					<div class="col-md-3">
						<label for="Description"><?=DESCRIPTION;?></label>
					</div>
					<div class="col-md-9">
						<textarea name="Description" id="Description" rows="5" 
					class="textarea" cols="50" style="width:100%">{{Description}}</textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="DateAdded"><?=DATEADDED;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="DateAdded" id="DateAdded" class="w100" value="{{DateAdded}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="TimeAdded"><?=TIMEADDED;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="TimeAdded" id="TimeAdded" class="w100" value="{{TimeAdded}}">
					</div>
				</div>


			</div>
	    </div>
		    

	<!-- Statuses and messages -->
	<div class="box-footer">
		<? if (!$isNew) { ?>
		<div>
    	<button class="btn btn-default" onclick="return deletev4_OrderLog('{{ID}}', '<?= $inList ?>');">
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

