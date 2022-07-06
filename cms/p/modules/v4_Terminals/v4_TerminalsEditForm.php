<script type="text/x-handlebars-template" id="v4_TerminalsEditTemplate">
<form id="v4_TerminalsEditForm{{TerminalID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
	<div class="box-header">
		<div class="box-title">
			<? if ($isNew) { ?>
				<h3><?= NNEW ?></h3>
			<? } else { ?>
				<h3><?= EDIT ?> - {{PlaceNameEN}}</h3>
			<? } ?>
		</div>
		<div class="box-tools pull-right">
			
			<span id="statusMessage" class="text-info xl"></span>
			
			<? if (!$isNew) { ?>
				<? if ($inList=='true') { ?>
					<button class="btn" title="<?= CLOSE?>" 
					onclick="return editClosev4_Terminals('{{PlaceID}}', '<?= $inList ?>');">
					<i class="fa fa-chevron-up l"></i>
					</button>
				<? } else { ?>
					<button class="btn btn-danger" title="<?= CANCEL ?>" 
					onclick="return deletev4_Terminals('{{PlaceID}}', '<?= $inList ?>');">
					<i class="fa fa-ban"></i>
					</button>						
				<? } ?>	
			<? } else { ?>	
				<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
				onclick="return editSavev4_Terminals('{{ID}}', '<?= $inList ?>');">
				<i class="ic-disk"></i>
				</button>			
			<? } ?>	

		</div>
	</div>

	<div class="box-body ">
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-3">
						<label for="TerminalID"><?=PLACEID;?></label>
					</div>
					<div class="col-md-9">
						{{PlaceID}}
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="TerminalName"><?=PLACENAME;?></label>
					</div>
					<div class="col-md-9">
						{{PlaceNameEN}}
					</div>
				</div>

			</div>
		</div>

	    </div>
		    

	<!-- Statuses and messages -->
	<div class="box-footer">
		<? if (!$isNew) { ?>
		<div>
    	<button class="btn btn-default" onclick="return deletev4_Terminals('{{PlaceID}}', {{ID}}, '<?= $inList ?>');">
    		<i class="fa fa-trash-o l"></i> <?= DELETE ?>
    	</button>
    	</div>
    	<? } ?>

	</div>
</form>


	<script>
		// init 
		terminalSurcharges({{TerminalID}});
		
		//bootstrap WYSIHTML5 - text editor
		$(".textarea").wysihtml5({
				"font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
				"emphasis": true, //Italics, bold, etc. Default true
				"lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
				"html": true, //Button which allows you to edit the generated HTML. Default false
				"link": true, //Button to insert a link. Default true
				"image": false, //Button to insert an image. Default true,
				"color": false //Button to change color of font 
				
		});
		
		// uklanja ikonu Saved - statusMessage sa ekrana
		$("form").change(function(){
			$("#statusMessage").html('');
		});
		
		
		
	
	
	</script>
</script>
	
