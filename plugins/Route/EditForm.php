
<script type="text/x-handlebars-template" id="ItemEditTemplate">
<form id="ItemEditForm{{RouteID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
	<div class="box-header">
		<div class="box-tools pull-right">
			
			<span id="statusMessage" class="text-info xl"></span>
			
			<? if (!$isNew) { ?>
				<button class="btn btn-warning" title="<?= CLOSE?>" 
				onclick="return editCloseItem('{{RouteID}}');">
				<i class="fa fa-close"></i>
				</button>

				<button class="btn btn-danger" title="<?= CANCEL ?>" 
				onclick="return deleteItem('{{RouteID}}');">
				<i class="fa fa-ban"></i>
				</button>
			<? } ?>	
			<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
			onclick="return editSaveItem('{{RouteID}}');">
			<i class="fa fa-save"></i>
			</button>			
		</div>
	</div>

	<div class="box-body ">
        <div class="row">
			<div class="col-md-6 ">
				<div class="row hidden">
					<div class="col-md-3">
						<label for="OwnerID"><?=OWNERID;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="OwnerID" id="OwnerID" class="w100" value="{{OwnerID}}" readonly>
					</div>
				</div>

				<div class="row hidden">
					<div class="col-md-3">
						<label for="RouteID"><?=ROUTEID;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="RouteID" id="RouteID" class="w100" value="{{RouteID}}" readonly>
					</div>
				</div>

				<div class="row hidden">
					<div class="col-md-3">
						<label for="FromID"><?=FROM;?></label>
					</div>
					<div class="col-md-9">
						{{placeSelect FromID 'FromID'}}
					</div>
				</div>

				<div class="row hidden">
					<div class="col-md-3">
						<label for="ToID"><?=TO;?></label>
					</div>
					<div class="col-md-9">
						{{placeSelect ToID 'ToID'}}
					</div>
				</div>

				<? if ($isNew || !isset($_SESSION['UseDriverID'])) { ?>
				<div class="row">
					<div class="col-md-3">
						<label for="Approved"><?=APPROVED;?></label>
					</div>
					<div class="col-md-9">
						{{yesNoSelect Approved 'Approved'}}
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="TopRoute">Top Route</label>
					</div>
					<div class="col-md-9">
						{{yesNoSelect TopRoute 'TopRoute' }}
					</div>
				</div>
				
				<div class="row hidden">
					<div class="col-md-3">
						<label for="RouteName"><?=ROUTENAME;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="RouteName" id="RouteName" class="w100" value="{{RouteName}}">
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="Km"><?=KM;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="Km" id="Km" class="w100" value="{{Km}}">
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<label for="Duration"><?=DURATION;?></label>
					</div>
					<div class="col-md-9">
						<input type="text" name="Duration" id="Duration" class="w100" value="{{Duration}}">
					</div>
				</div>
				<? } else { ?>				
				<div class="row">
					<div class="col-md-3">
						<label for="DriverRoute">Driver Route</label>
					</div>
					<div class="col-md-9">
						{{yesNoSelect DriverRoute 'DriverRoute' }}
					</div>
				</div>	
				<div class="row">
					<div class="col-md-3">
						<label for="SurCategory"><?=SURCATEGORY;?></label>
					</div>
					<div class="col-md-3">
						<select name="SurCategory" id="SurCategory" class="w100">
							{{#select SurCategory}}
								<option value="1" {{#compare SurCategory "==" 1}}selected{{/compare}}><?= USE_GLOBAL ?></option>
								<option value="3" {{#compare SurCategory "==" 3}}selected{{/compare}}><?= ROUTE_SPECIFIC ?></option>
								<option value="0" {{#compare SurCategory "==" 0}}selected{{/compare}}><?= NO_SURCHARGES ?></option>
							{{/select}}								
						</select>
					</div>
					<div class="col-md-3">
						<a target='_blank' href='rules/global'>Edit Global Rules</a>
					</div>					
					<div class="col-md-3">
						<a target='_blank' href='rules/routes/{{RouteID}}'>Edit Route Rules</a>
					</div>
				</div>
			
				<? } ?>

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
		
		$("#FromID").change(function(){
			var from = $("#FromID option:selected").text();
			var to   = $("#ToID option:selected").text();
			$("#RouteName").val(from + ' - ' + to);
		
		});
		$("#ToID").change(function(){
			var from = $("#FromID option:selected").text();
			var to   = $("#ToID option:selected").text();
			$("#RouteName").val(from + ' - ' + to);
		
		});	
	</script>
</script>

