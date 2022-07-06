
<script type="text/x-handlebars-template" id="v4_DriverRoutesEditTemplate">
<form id="v4_DriverRoutesEditForm{{ID}}" class="form box box-info" enctype="multipart/form-data" method="post" onsubmit="return false;">
	<input type="hidden" name="ID" value="{{ID}}">
	<input type="hidden" name="RouteID" value="{{RouteID}}">
	<input type="hidden" name="OwnerID" value="<?= s('OwnerID')?>">
	<div class="box-header">
		<div class="box-title">
			<? if ($isNew) { ?>
				<h3><?= NNEW ?></h3>
			<? } else { ?>
				<h3><?= EDIT ?> - {{RouteName}}</h3>
			<? } ?>
		</div>
		<div class="box-tools pull-right">
			
			<span id="statusMessage" class="text-info xl"></span>
			
			<? if (!$isNew) { ?>
				<? if ($inList=='true') { ?>
					<button class="btn btn-warning" title="<?= CLOSE?>" 
					onclick="return editClosev4_DriverRoutes('{{ID}}', '<?= $inList ?>');">
					<i class="fa fa-chevron-up l"></i>
					</button>
				<? } ?>	
			<? } ?>	
			<button class="btn btn-info" title="<?= SAVE_CHANGES ?>" 
			onclick="return editSavev4_DriverRoutes('{{ID}}', '<?= $inList ?>');">
			<i class="fa fa-save l"></i>
			</button>
			<? if (false) { ?>
				<button class="btn btn-danger" title="<?= PRINTIT ?>" 
				onclick="return editPrintv4_DriverRoutes('{{ID}}', '<?= $inList ?>');">
				<i class="fa fa-print l"></i>
				</button>
			<? } ?>	
		</div>
	</div>

	<div class="box-body ">
		<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1{{RouteID}}" data-toggle="tab"><?= ROUTE ?></a></li>
                <li><a href="#tab_2{{RouteID}}" data-toggle="tab"><?= SURCHARGES ?></a></li>
            </ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1{{RouteID}}">		
					<div class="row">
						<div class="col-md-6">

							<div class="row">
								<div class="col-md-3">
									<label for="RouteName"><?=ROUTENAME;?></label>
								</div>
								<div class="col-md-9">
									<? if (!$isNew) { ?>
									
										{{RouteName}}
									
									<? } else { 
									
										require_once ROOT . '/db/v4_Routes.class.php';
										$r = new v4_Routes();
										
										$rids = $r->getKeysBy('RouteName', 'asc'); ?>
										
										<select name="RouteID" id="RouteID">
										{{#select RouteID}}
										<?
											foreach($rids as $nn => $RouteID) {
												$r->getRow($RouteID);
												
												echo '<option value="'.$RouteID.'">'.$r->getRouteName().'</option>';
											}
										
										?>
										{{/select}}
										</select>
										
									
									<? } ?>
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<label for="Km"><?=KM;?></label>
								</div>
								<div class="col-md-9">
									<input type="text" name="Km" id="Km" class="w100" value="{{Km}}" 
										{{#compare Km ">" 0}} readonly {{/compare}}
									>
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<label for="Duration"><?=DURATION;?></label>
								</div>
								<div class="col-md-9">
									<input type="text" name="Duration" id="Duration" class="w100" value="{{Duration}}"
									{{#compare Duration ">" 0}} readonly {{/compare}}
									>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-3">
									<label for="Approved"><?=APPROVED;?></label>
								</div>
								<div class="col-md-9">
									{{#if Approved}} <span class="badge green"><?= YES ?> </span>
									{{else}} <span class="badge red"><?= NO ?> </span>
									{{/if}}
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
									<label for="OneToTwo"><?=ONETOTWO;?></label>
								</div>
								<div class="col-md-9">
									{{yesNoSelect OneToTwo 'OneToTwo'}}
								</div>
							</div>

							<div class="row">
								<div class="col-md-3">
									<label for="TwoToOne"><?=TWOTOONE;?></label>
								</div>
								<div class="col-md-9">
									{{yesNoSelect TwoToOne 'TwoToOne'}}
								</div>
							</div>

						</div>

					</div> {{!-- row --}}
						<div class="row">
							<!-- Statuses and messages -->
							<div class="box-footer">
								<? if (!$isNew) { ?>
								<div>
								<button class="btn btn-default" 
								onclick="return deletev4_DriverRoutes('{{ID}}', '<?= $inList ?>');">							
									<i class="fa fa-trash-o l"></i> <?= DELETE ?>
								</button>
								</div>
								<? } ?>

							</div>
						</div>					
				</div> {{!-- tab-pane tab_1 --}}
				
				<div class="tab-pane" id="tab_2{{RouteID}}">
					<div class="row">
						<div class="col-md-3">
							<label for="SurCategory"><?=SURCATEGORY;?></label>
						</div>
						<div class="col-md-9">
							<select name="SurCategory" id="SurCategory" class="w100" onchange="routeSurcharges({{ID}});">
								{{#select SurCategory}}
									<option value="1"><?= USE_GLOBAL ?></option>
									<option value="3"><?= ROUTE_SPECIFIC ?></option>
									<option value="0"><?= NO_SURCHARGES ?></option>
								{{/select}}								
							</select>
							
							<input type="hidden" name="SurID" id="SurID" class="w100" value="{{SurID}}">
						</div>
					</div>
					<div id="routeSurcharges{{ID}}"></div>

				</div> {{!-- tab-pane tab_2 --}}
	    </div>
		    


</form>


	<script>
		// init 
		routeSurcharges({{ID}});

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
	
