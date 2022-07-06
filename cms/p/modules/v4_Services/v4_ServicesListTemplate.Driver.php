
<script type="text/x-handlebars-template" id="v4_ServicesListTemplate">


	{{#each v4_Services}}
		<div>
			<form id="v4_ServicesEditPriceForm{{ServiceID}}" class="form" 
				enctype="multipart/form-data" method="post" onsubmit="return false;">
				
				<div class="row  " style="font-size:.8em;border-top:1em solid transparent">
					<div class="col-md-1 grey xwhite-text">
					N:{{NightPrice}}
					</div>
					<div class="col-md-1 xgreen lighten-4">
					MO:{{MonPrice}}
					</div>
					<div class="col-md-1 xgreen lighten-4">
					TU:{{TuePrice}}
					</div>
					<div class="col-md-1 xgreen lighten-4">
					WE:{{WedPrice}}
					</div>
					<div class="col-md-1 xgreen lighten-4">
					TH:{{ThuPrice}}
					</div>
					<div class="col-md-1  red lighten-3">
					FR:{{FriPrice}}
					</div>
					<div class="col-md-1 red lighten-2">
					SA:{{SatPrice}}
					</div>
					<div class="col-md-1 red lighten-1">
					SU:{{SunPrice}}
					</div>
					<div class="col-md-1 xblue lighten-4">
					S1:{{S1Price}}
					</div>
					<div class="col-md-1 xgreen lighten-4">
					S2:{{S2Price}}
					</div>
					<div class="col-md-1 xorange lighten-4">
					S3:{{S3Price}}
					</div>
					<div class="col-md-1 grey lighten-1">
					S4:{{S4Price}}
					</div>					
				</div>				
				<div class="row  {{color}} xlistTile" 
					style="xborder-top:1px solid #ddd;cursor:default; padding:.8em" 
					id="t_{{ServiceID}}">
		
					<!--<div class="col-md-1">
						<strong>{{ServiceID}}</strong>
					</div>-->

					<div class="col-md-5">
						{{RouteName}}
					</div>

					<div class="col-md-3">
						{{VehicleName}} 
					</div>
					<div class="col-md-1">
						<i class="fa fa-user"></i> {{VehicleCapacity}}
					</div>
				
					<div class="col-md-2 right" style="font-size: .7em !important">
						<?= CURRENT_PRICE ?>: {{ServicePrice1}} <?= CURRENCY ?>
						<div class="input-group" >
						  <span class="input-group-addon"><?= NEWW ?></span>
						  
							<input type="text" 
							class=" right old form-control" 
							name="ServicePrice1" 
							id="ServicePrice1{{ServiceID}}" 
							value="{{ServicePrice1}}" 
							xstyle="color:black;border:none;background:transparent;border-bottom:2px solid #336699 !important;"

							onchange="return editSavev4_ServicePrice('{{ServiceID}}', '<?= $inList ?>');">

						</div>

					</div>
					<div class="col-md-1" onclick="one_v4_Services({{ServiceID}});"
						 style="cursor:pointer">
						<small><i class="fa fa-arrow-circle-up"></i> {{surCategory SurCategory}}</small>
						<i class="fa fa-edit pad4px" ></i> 
						
					</div>
				</div>

			</form>			
		</div>
		<div id="v4_ServicesWrapper{{ServiceID}}" class="editFrame" style="display:none">
			<div id="inlineContent{{ServiceID}}" class="row">
				<div id="one_v4_Services{{ServiceID}}" >
					<?= LOADING ?>
				</div>
			</div>
		</div>


	{{/each}}

</script>

