<? 
	require_once 'scripts.js.php';	
    require_once ROOT.'/db/v4_Countries.class.php';
	$_SESSION['AgentID']=$_REQUEST['AgentID'];
	$_SESSION['PaxNo']=$_REQUEST['PaxNo'];	
?>
    <form method="post" id="finalForm" name="finalForm" action="booking/step3"
    onsubmit="return $('#finalForm').valid();"
    style="background: #eee;
    margin-top:-20px !important"> 
    <br>
        <?
        // spremi sve u session
        foreach ($_REQUEST as $key => $value) {
            $_SESSION[$key] = $value;
        }

        if (isset($_SESSION['fromPlaces'])) unset($_SESSION['fromPlaces']);
        if (isset($_SESSION['toPlaces'])) unset($_SESSION['toPlaces']);
        if (isset($_SESSION['allPlaces'])) unset($_SESSION['allPlaces']);
        if (isset($_SESSION['countries'])) unset($_SESSION['countries']);
        ?>
		
        <div class="container pad1em row" style="background-color: rgba(70,79,96,0.75);">

			<div class="row z-depth-2 white lighten-5 center">
			
				<div class="col-md-2">
					<img src='cms/img/<?= s('logo') ?>'>	 
					<h6><?= s('AgentName') ?></h6>
					Ref: <input name='ReferenceNo' id='ReferenceNo' type='text' style="font-size:85%; text-align:right; max-width:5em text-align:right; max-width:7em" value='<?= s('ReferenceNo') ?>'>
					<input name='api' id='api' type='hidden' value='<?= s('api') ?>'>

				</div>
			
				<div class="col-md-2 white">
				<h6 style="text-transform:uppercase; font-weight:100 !important"><?= s('VehicleName') ?></h6>
			
				<img class="" src="<?= s('VehicleImage') ?>" 
				style="max-height:40%;max-width:40%;" alt="car">
					
				</div>

				<!-- car image and capacity -->
				<div class="col-md-2">
					<driver>Driver</driver>
					<h6><?= s('DriverName') ?></h6>

				</div>
				<!-- driver profile and ratings -->
				
				<div class="col-md-5 row">
					<div class="col-md-4">
						<h6>Driver's price</h6>
						<input type="text" value="<?= nf(s('DriversPrice')) ?>" 
						name="driverprice" id="driverprice" style="text-align:right; max-width:5em text-align:right; max-width:5em" readonly>
					</div>	
					<div class="col-md-4">
						<h6>Agent's price</h6>							
						<input type="text" value="<?= nf(s('AgentPrice')) ?>" 
						name="agentprice" id="agentprice" style="text-align:right; max-width:5em text-align:right; max-width:5em" readonly>						
					</div>							
					<div class="col-md-4">
						<h6>Our price</h6>		 					
						<input type="text" value="<?= s('Price') ?>" 
						name="price" id="price" style="text-align:right; max-width:5em text-align:right; max-width:5em" readonly>						
					</div>
				</div>
				<div class="col-md-1">
					<h6><?= VEHICLES_NO ?></h6>
					<input type="text" value="<?= s('VehiclesNo') ?>" style="text-align:right; max-width:5em text-align:right; max-width:5em" readonly>
				</div>
				<!-- car price -->					
		 
			</div>
				<!-- main car panel div -->					
            <!-- vehicle row -->

			<button id='empty' type="button" class="btn btn-large">Empty fields</button>

            <div class="row xpad1em">
		
				<div class="col-md-6 grey lighten-4 pad1em z-depth-1 ">
					<div class="row">
						<h6><i class="fa fa-map-marker fa-2x green-text"></i> <?= FROM ?>: <strong><?= getPlaceName( s('FromID') ) ?></strong></h6>
					</div>					
					<div class="row">
						<div class="col-md-4 ">
							<div class="chip blue white-text center z-depth-1">
								<?= PICKUP_DATE ?>: <?= s('transferDate') ?> <small>(Y-M-D)</small>
							</div>
						</div>

						<div class="col-md-4 ">
							<div class="chip blue white-text center z-depth-1">
								<?= PICKUP_TIME ?>: <?= s('transferTime') ?> <small>(H:M 24h)</small>
							</div>
						</div>

						<div class="col-md-4 ">
							<div class="chip blue white-text center z-depth-1">
								<?= PASSENGERS_NO?>: <?= s('PaxNo') ?>
							</div>
						</div>
					</div>

					<? if(getPlaceType( s('FromID')) == '1') $pickupAddress = AIRPORT;
						else $pickupAddress = s('PickupAddress');
					?>
					<div class="row">
						<div class="col-md-4"><label><?=  PICKUP_ADDRESS?></label></div>
						<div class="col-md-8">
							<input type="text" id="PickupAddress" name="PickupAddress"
							value="<?= $pickupAddress ?>" title="<?= WHERE_PICKUP ?>" 
							placeholder="<?=  PICKUP_ADDRESS?>" class="validate" onkeyup="updateAdress();" autofocus>
						</div>
					</div>
					<? $flightime=s('FlightTime'); ?>

					<? if(getPlaceType( s('FromID')) != '1' &&  getPlaceType( s('ToID')) != '1') $flightime=''; ?>
					<? if(getPlaceType( s('FromID')) == '1') { ?>
					<div class="row">
						<div class="col-md-4"><label for="FlightNo"><?= FLIGHT_NO ?></label></div>
						<div class="col-md-8">
							<input type="text" id="FlightNo" name="FlightNo"
							value="<?= s('FlightNo')?>" title="<?= YOUR_FLIGHT_NO ?>" class="validate">
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 "><label for="FlightTime"><?= FLIGHT_TIME ?>:</label></div>
						<div class=" col-md-8">
							<input type="text" id="FlightTime" name="FlightTime" class="timepick"
							value="<?= $flightime ?>" data-field="time" title="<?= YOUR_FLIGHT_TIME ?>">
						</div>
					</div>
					<? } ?>
				</div>
				
				<div class="col-md-6 grey lighten-4 pad1em z-depth-1 ">
					<div class="row">
						<h6><i class="fa fa-map-marker fa-2x red-text"></i> <?= TO ?>: <strong><?= getPlaceName( s('ToID') ) ?></strong></h6>
					</div>				

					<div class="row">
						<?  if(getPlaceType( s('ToID') ) == '1') $dropAddress = AIRPORT;
							else $dropAddress = s('DropAddress');
						?>
						<div class="col-md-4"><label for="DropAddress"><?=  DROPOFF_ADDRESS ?> *</label></div>
						<div class="col-md-8">
							<input type="text" id="DropAddress" name="DropAddress"
							value="<?= $dropAddress?>" title="<?= WHERE_DROPOFF ?>" onkeyup="updateAdress();">
						</div>
					</div>
					<? if(getPlaceType( s('ToID') ) == '1') { ?>					
					<div class="row">
						<div class="col-md-4 "><label for="DFlightNo"><?= FLIGHT_NO ?></label></div>
						<div class=" col-md-8">
							<input type="text" id="FlightNo" name="FlightNo"
							value="<?= s('FlightNo')?>" title="<?= YOUR_FLIGHT_NO ?>">
						</div>
					</div>	
					<div class="row">					
						<div class="col-md-4 "><label for="FlightTime"><?= FLIGHT_TIME ?></label></div>
						<div class="col-md-8">
							<input type="text" id="FlightTime" name="FlightTime" class=" timepick"
							value="<?= $flightime ?>" data-field="time" title="<?= YOUR_FLIGHT_TIME ?>">
						</div>
					</div>	
						<? } ?>
				</div>
            </div>
            <!-- from-to row -->


            <? if (s('returnTransfer'))  {?>
			<div class="col s12 ucase"><h5><?= RETURN_TRANSFER ?></h5></div>

            <div class="row xpad1em">
				<div class="col-md-6 grey lighten-4 pad1em z-depth-1 ">
					<div class="row">
						<h6><i class="fa fa-map-marker fa-2x green-text"></i> <?= FROM ?>: <strong><?= getPlaceName( s('ToID') ) ?></strong></h6>
					</div>
					<div class="row">
						<div class="col-md-6 ">
							<div class="chip blue white-text center z-depth-1">
								<?= RETURN_DATE ?>: <?= s('returnDate') ?> <small>(Y-M-D)</small>
							</div>
						</div>

						<div class="col-md-6 ">
							<div class="chip blue white-text center z-depth-1">
								<?= RETURN_TIME ?>: <?= s('returnTime') ?> <small>(H:M 24h)</small>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4"><label><?=  PICKUP_ADDRESS?></label></div>
						<div class="col-md-8"> 
							<input type="text" id="RPickupAddress" name="RPickupAddress"
                            value="<?= $dropAddress ?>" title="<?= WHERE_PICKUP ?>">
						</div>
					</div>
					<? if(getPlaceType( s('ToID') ) == '1') { ?>
					<div class="row">
						<div class="col-md-4"><label for="RFlightNo"><?=  FLIGHT_NO?></label></div>
						<div class="col-md-8">
 						<input type="text" id="RFlightNo" name="RFlightNo"
						value="<?= s('RFlightNo')?>" title="<?= YOUR_FLIGHT_NO ?>">
						</div>
					</div>
					<div class="row">
						<div class="col-md-4"><label for="RFlightTime"><?=  FLIGHT_TIME?></label></div>
						<div class="col-md-8">
						<input type="text" id="RFlightTime" name="RFlightTime" class=" timepick"
						value="<?= s('RFlightTime')?>" data-field="time" title="<?= YOUR_FLIGHT_TIME ?>">
						</div>
					</div>					
					<? } ?>					
				</div>
				
				<div class="col-md-6 grey lighten-4 pad1em z-depth-1 ">
					<div class="row">
						<h6><i class="fa fa-map-marker fa-2x red-text"></i> <?= TO ?>: <strong><?= getPlaceName( s('FromID') ) ?></strong></h6>
					</div>				
					<div class="row">
						<?  if(getPlaceType( s('ToID') ) == '1') $dropAddress = AIRPORT;
							else $dropAddress = s('DropAddress');
						?>
						<div class="col-md-4"><label for="DropAddress"><?=  DROPOFF_ADDRESS?> *</label></div>
						<div class="col-md-8">
                            <input type="text" id="RDropAddress" name="RDropAddress"
                            value="<?= $pickupAddress ?>" title="<?= WHERE_DROPOFF ?>"
                            placeholder="<?= DROPOFF_ADDRESS ?>" class="validate">
						</div>
					</div>
					<? if(getPlaceType( s('FromID') ) == '1') { ?>
					<div class="row">
						<div class="col-md-4"><label for="RFlightNo"><?=  FLIGHT_NO?></label></div>
						<div class="col-md-8">
 						<input type="text" id="RFlightNo" name="RFlightNo"
						value="<?= s('RFlightNo')?>" title="<?= YOUR_FLIGHT_NO ?>">
						</div>
					</div>
					<div class="row">
						<div class="col-md-4"><label for="RDFlightTime"><?=  FLIGHT_TIME?></label></div>
						<div class="col-md-8">
						<input type="text" id="RFlightTime" name="RFlightTime" class=" timepick"
						value="<?= s('RFlightTime')?>" data-field="time" title="<?= YOUR_FLIGHT_TIME ?>">
						</div>
					</div>					
					<? } ?>
				</div>
            </div>

            <!-- return transfer row -->
            <? } ?>


            <div class="row">
				<div class="col-md-6 grey lighten-4 pad1em z-depth-1 ">

					<?
						// Ovo je za logirane korisnike
						// ili ako nisu, uzima iz session
						if ( isset($_SESSION['Customer']['FirstName']) )
						$paxFirstName = $_SESSION['Customer']['FirstName'];
						else if ( isset($_SESSION['MPaxFirstName']) )
						$paxFirstName = $_SESSION['MPaxFirstName'];
						else $paxFirstName = '';

						if ( isset($_SESSION['Customer']['LastName']) )
						$paxLastName = $_SESSION['Customer']['LastName'];
						else if ( isset($_SESSION['MPaxLastName']) )
						$paxLastName = $_SESSION['MPaxLastName'];
						else $paxLastName = '';

						if ( isset($_SESSION['Customer']['Email']) )
						$paxEmail = $_SESSION['Customer']['Email'];
						else if ( isset($_SESSION['MPaxEmail']) )
						$paxEmail = $_SESSION['MPaxEmail'];
						else $paxEmail = '';

						if ( isset($_SESSION['Customer']['Mobile']) )
						$paxMobile = $_SESSION['Customer']['Mobile'];
						else if ( isset($_SESSION['MPaxTel']) )
						$paxMobile = $_SESSION['MPaxTel'];
						else $paxMobile = '';
					?>





					<div class='row'><h6><i class="fa fa-user"></i> <?= YOUR_CONTACT_INFO ?></h6></div>
					<div class='row'>
						<div class="col-md-4"><label for="PaxFirstName"><?=  NAME ?> *</label></div>
						<div class="col-md-8">
							<input type="text" id="PaxFirstName" name="MPaxFirstName"
							placeholder="<?= FIRST_NAME ?>" class="validate"
							value="<?= s('PaxFirstName') ?>" title="<?= YOUR_FIRST_NAME ?>"
							onchange="$('#ch_name').val(this.value);">
						</div>
					</div>
					<div class='row'>
						<div class="col-md-4"><label for="PaxLastName"></label></div>
						<div class="col-md-8">
							<input type="text" id="PaxLastName" name="MPaxLastName"
							placeholder="<?= LAST_NAME ?>"
							value="<?= s('PaxSurName') ?>" title="<?= YOUR_LAST_NAME ?>"
							onchange="$('#ch_last_name').val(this.value);">
						</div>
					</div>
					<div class='row'>	
						<div class="col-md-4"><label for="MPaxTel"><?=  MOBILE_NUMBER?> *</label></div>
						<div class="col-md-8">
							<input type="tel" id="MPaxTel" name="MPaxTel"
							placeholder="+111 11 111-1111"
							value="<?= s('PaxTel') ?>"
							title="<?= YOUR_TEL ?>"
							onchange="$('#ch_phone').val(this.value);"
							class="xwhite  black-text form-control">
							<span id="valid-msg" class="hidden">
								<i class="ic ic-checkmark-circle xgreen-text"></i>
							</span>
							<span id="error-msg" class="hidden error">
								<i class="ic ic-cancel-circle red-text"></i>
							</span>
						</div>
					</div>
					<div class='row'>						
						<div class="col-md-4"><label for="PaxEmail">CONTACT EMAIL *</label></div>
						<div class="col-md-8">
							<input type="email" id="PaxEmail" name="MPaxEmail" class="w75"
							placeholder="myemail@mysite.com"
							value="" title="<?= YOUR_EMAIL ?>"
							onchange="$('#ch_email').val(this.value);">
						</div>
					</div>	
					<div class='row'>	
						<div class="col-md-4"><label><?= NOTES ?></label></div>
						<div class=" col-md-8">
							<textarea name="PickupNotes" rows="4"
							id="PickupNotes"></textarea>
							<!---?= s('PickupNotes') ?!-->
						</div>
					</div>
                </div>
				<!-- passenger info row -->
				<div id="selectExtras" class="col-md-6 grey lighten-4 pad1em z-depth-1 ">
					<? require_once 'para_extras.php'; ?>
				</div>
				<!-- Extras row -->
			</div>

			<?
				$userData = array();
				$userData = getUserData(s('AgentID'));
				$UserLevelID=$userData['AuthLevelID'];
				$pm=$userData['AcceptedPayment'];
				switch ($pm) {
					case 10:
						$pmn='BANK TRANSFER';
						$pmcode=4;
						break;
					case 11:
						$pmn='ONLINE';
						$pmcode=1;
						break;
					case 12:
						$pmn='BANK TRANSFER 2';
						$pmcode=6;
						break;						
					case 13:
						$pmn='CASH';
						$pmcode=2;
						break;							
					default:
						$pmn='NOT SELECTED';
						$pmcode=0;
				}
			?>	
			
			
			<input id='TNumberMobile' name='TNumberMobile' type='hidden'/>
			<input id='SPAddressHotel' name='SPAddressHotel' type='hidden'/>
			<input id='SDAddressHotel' name='SDAddressHotel' type='hidden'/>
			<input id='RPAddressHotel' name='RPAddressHotel' type='hidden'/>
			<input id='RDAddressHotel' name='RDAddressHotel' type='hidden'/>
			
			<input id='SFlightCo' name='SFlightCo' type='hidden' value="<?= s('SFlightCo') ?>"/>
			<input id='RFlightCo' name='RFlightCo' type='hidden' value=""/>

			
			<input type="hidden" id="AgentID" name="AgentID" value="<?= s('AgentID'); ?>">
			<input type="hidden" id="UserLevelID" name="UserLevelID" value="<?= $UserLevelID; ?>">
			<input type="hidden" id="transferPrice" name="transferPrice" value="<?= number_format(s('Price'),2,'.',''); ?>">
			<input type="hidden" id="TotalPrice" name="TotalPrice" value="<?= number_format(s('Price'),2,'.',''); ?>">
			<input type="hidden" id="transferPriceC" name="transferPriceC" value="<?= s('Price'); ?>">
			<input type="hidden" id="TotalPriceC" name="TotalPriceC" value="<?= s('Price'); ?>">
			
			
			

			<div class="row blue xdarken-3 white-text xl z-depth-2 center">
				<div  class="col-md-6">Total price:
					<span class="grandTotal"><?= nf(s('Price')) ?></span>
				</div>
				<div  class="col-md-6">Payment method:
				
					<? if ($pmcode>0) {?>
					<span id="pm"><?= $pmn ?></span>
					<input type="hidden" id="PaymentMethod" name="PaymentOption" value="<?= $pmcode; ?>">

					<? } else {?>
					<select style='font-size:50%' id="PaymentMethod" name="PaymentOption" class="browser-default valid">		
						<option  value="1"><?= PAY_ONLINE ?></option>
						<option  value="2"><?= PAY_CASH ?></option>
						<option  value="4"><?= PAY_INVOICE ?></option>
						<option  value="6"><?= PAY_INVOICE ?> 2</option>
					</select>	
					<? } ?>	
					
				</div>		

				
			</div>
			<select style='display:none' id="acceptTC" oncload="acceptDeclineTC();" class="browser-default">
				<option value="0"><?= DECLINE ?></options>
				<option value="1" selected><?= ACCEPT ?></option>
			</select>
			<div class="row cashPayment" id="PaymentContinue2"> 
				<div align="center" class="col s12">
					<button type="submit" 
					class="btn btn-large gren xcol xs12 l ">
						<i id="paymentIcon" class="fa fa-times-circle"></i>&nbsp; <?= SEND ?>
						<i id='spiner' class="fa fa-circle-o-notch fa-spin" style="font-size:24px; display:none"></i>
					</button>
				</div> 
			</div>

        <? # HIDDEN FIELDS ?>
        <input  type="hidden" id="BF" name="BF" value="BF">
        <input  type="hidden" id="RT" name="RT" value="<?=s('returnTransfer')?>">
        <input  type="hidden" id="ServiceID" name="ServiceID" value="<?= s('ServiceID') ?>">
        <?
        // sada driversPrice sadrzi stvarnu cijenu i broj vozila,
        // tako da se u dbAddOrder moze maknuti mnozenje sa brojem vozila
        //$driversPrice   = number_format(s('DriversPrice'), 2, '.', '');
        ?>
        <input  type="hidden" id="DriversPrice" name="DriversPrice" value="<?= number_format(s('DriversPrice'), 2, '.', '') ?>">


            <?/* EURO */?>
            <input  type="hidden" id="TT" name="TT" value="<?= number_format(s('Price'),2,'.','')?>">
            <input  type="hidden" id="ET" name="ET" value="0">
            <input  type="hidden" id="PN" name="PN" value="0">
            <input  type="hidden" id="PL" name="PL" value="0">
            <?/* VALUTE */?>
            <input  type="hidden" id="TTC" name="TTC" value="<?= s('Price')?>">
            <input  type="hidden" id="ETC" name="ETC" value="0">
            <input  type="hidden" id="PNC" name="PNC" value="0">
            <input  type="hidden" id="PLC" name="PLC" value="0">
    </form>
<?
	// display
	$smarty->display("plugins/booking/templates/bookingStep1.tpl");	
	