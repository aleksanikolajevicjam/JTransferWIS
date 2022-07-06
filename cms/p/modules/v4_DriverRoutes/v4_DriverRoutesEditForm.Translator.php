
<script type="text/x-handlebars-template" id="v4_DriverRoutesEditTemplate">
<form id="v4_DriverRoutesEditForm{{ID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
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
					onclick="return editClosev4_DriverRoutes('{{ID}}', '<?= $inList ?>');">
					<i class="fa fa-arrow-up"></i>
					</button>
				<? } else { ?>
					<button class="btn btn-danger" title="<?= CANCEL ?>" 
					onclick="return deletev4_DriverRoutes('{{ID}}', '<?= $inList ?>');">
					<i class="fa fa-ban"></i>
					</button>
				<? } ?>	
			<? } ?>	
			<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
			onclick="return editSavev4_DriverRoutes('{{ID}}', '<?= $inList ?>');">
			<i class="ic-disk"></i>
			</button>
		</div>
	</div>

	<div class="box-body ">
        <div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-3">
						<label for="RouteName"><?=ROUTENAME;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="RouteName" id="RouteName" class="w100" value="{{RouteName}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="RouteNameEN"><?=ROUTENAMEEN;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="RouteNameEN" id="RouteNameEN" class="w100" value="{{RouteNameEN}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="RouteNameRU"><?=ROUTENAMERU;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="RouteNameRU" id="RouteNameRU" class="w100" value="{{RouteNameRU}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="RouteNameFR"><?=ROUTENAMEFR;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="RouteNameFR" id="RouteNameFR" class="w100" value="{{RouteNameFR}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="RouteNameDE"><?=ROUTENAMEDE;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="RouteNameDE" id="RouteNameDE" class="w100" value="{{RouteNameDE}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="RouteNameIT"><?=ROUTENAMEIT;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="RouteNameIT" id="RouteNameIT" class="w100" value="{{RouteNameIT}}">
					</div>
				</div>
			</div>

			<div class="row">
					<div class="col-md-3">
						<label for="RouteNameSE"><?=ROUTENAMESE;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="RouteNameSE" id="RouteNameSE" class="w100" value="{{RouteNameSE}}">
					</div>
				</div>
			</div>

			<div class="row">
					<div class="col-md-3">
						<label for="RouteNameNO"><?=ROUTENAMENO;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="RouteNameNO" id="RouteNameNO" class="w100" value="{{RouteNameNO}}">
					</div>
				</div>
			</div>

			<div class="row">
					<div class="col-md-3">
						<label for="RouteNameES"><?=ROUTENAMEES;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="RouteNameES" id="RouteNameES" class="w100" value="{{RouteNameES}}">
					</div>
				</div>
			</div>

			<div class="row">
					<div class="col-md-3">
						<label for="RouteNameNL"><?=ROUTENAMENL;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="RouteNameNL" id="RouteNameNL" class="w100" value="{{RouteNameNL}}">
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
	
