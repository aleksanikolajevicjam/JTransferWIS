<?
$smarty->assign('page', $md->getName());
@session_start();
if (!$_SESSION['UserAuthorized']) die('Bye, bye');


require_once ROOT . '/db/v4_Countries.class.php';
require_once "scripts.php";

?>
	<form method="post" id="finalForm" name="finalForm" action="buking/thankyou"
		  onsubmit="return $('#finalForm').valid();"
		  style="background: #eee;
    margin-top:-20px !important">
		<br>


		<?
		// spremi sve u session
		foreach ($_REQUEST as $key => $value) {
			$_SESSION[$key] = $value;
		}
		/*
                // i u request
                foreach ($_SESSION as $key => $value) {
                    if(gettype($value) != 'array') {
                        # ovo radi sranja jer u requestu ostane parametar p koji oznacava
                        # koju skriptu treba ucitati.
                        # tako ovdje u p dodje final, umjesto thankyou!

                        //echo '<input type="hidden" name="'.$key.'" value="'.$value.'">';

                    }
                }
        */
		if (isset($_SESSION['fromPlaces'])) unset($_SESSION['fromPlaces']);
		if (isset($_SESSION['toPlaces'])) unset($_SESSION['toPlaces']);
		if (isset($_SESSION['allPlaces'])) unset($_SESSION['allPlaces']);
		if (isset($_SESSION['countries'])) unset($_SESSION['countries']);

		?>


		<div class="container pad1em" style="background-color: rgba(70,79,96,0.75);">
			<div class="row">
				<div class="col s12 white-text">
					<h3 class="ucase"><?= MORE_DETAILS ?></h3>

				</div>
			</div>
			<!-- title row -->

			<div class="row">
				<div class="row xz-depth-3 white xxwhite-text">
					<?/*
                    if (s('VehicleCapacity') <= 3) $vehicleImage = '/i/cars/sedan.png';
                    else if (s('VehicleCapacity') <= 4) $vehicleImage = '/i/cars/taxi.png';
                    else if (s('VehicleCapacity') <= 8) $vehicleImage = '/i/cars/minivan.png';
                    else if (s('VehicleCapacity') <= 15) $vehicleImage = '/i/cars/minibus.png';
                    else if (s('VehicleCapacity') > 15) $vehicleImage = '/i/cars/bus.png';

                    */?>

					<div class="col l3 s11  xwhite m1em ">
						<img class="" src="<?= s('VehicleImage') ?>" alt="vehicle"
							 style="max-height:100%;max-width:100%;">
						<?
						if(s('VehiclesNo') > 1) echo  '<i class="red-text fa fa-car"></i> x ' .s('VehiclesNo');
						?>
					</div>

					<div class="col l8 s12 xoffset-l3 xwhite">
						<br>
						<div class="col s6 l3 "><?=  VEHICLE_CAPACITY ?>:</div>
						<div class="col s6 l9">
							<? if(s('VehiclesNo') > 1) echo s('VehiclesNo') . ' x ';?>
							<?= s('VehicleCapacity') ?> <i class="fa fa-user"></i>
						</div>

						<div class="col s6 l3 hidden"><?=  VEHICLE_TYPE ?>:</div>
						<div class="col s6 l9 hidden">
							<?= s('VehicleName') ?>
							<?
							if(s('VehiclesNo') > 1) echo ' x ' . s('VehiclesNo');

							?>
						</div>
						<?/*
                        <div class="col s6 l3"><?=  DRIVER_NAME ?>:</div>
                        <div class="col s6 l9">
                            <?= s('DriverName') ?>
                        </div>
*/?>
						<div class="col s6 l3 "><h5><?=  PRICE ?>:</h5></div>
						<div class="col s6 l9">
							<h5><strong><?= nf( toCurrency(s('Price')) ) . ' ' . s('Currency') ?> - <?= nf( toCurrency(s('Price')*($_SESSION['Provision'])/100) ) . ' ' . s('Currency') ?></strong></h5>
						</div>
						<div class="col s12 ucase xxwhite-text s xcenter">
							<?= SERVICES_DESC1 ?> -
							<?= SERVICES_DESC2 ?> -
							<?= SERVICES_DESC3 ?> -
							<?= SERVICES_DESC4 ?> -
							<?= SERVICES_DESC5 ?>
						</div>
					</div>

				</div>
			</div>
			<!-- vehicle row -->



			<div class="row xpad1em">
				<div class="col s12 "><br><i class="fa fa-map-marker fa-2x green-text"></i> <?= FROM ?>:</div>
				<div class="row grey lighten-4 pad1em z-depth-1 ">
					<div class="col s12">
						<h5>
							<?= countryName( s('CountryID') )?>,
							<strong><?= getPlaceName( s('FromID') ) ?></strong>
						</h5>
					</div>

					<div class="col s12 l4 ">
						<div class="chip blue white-text center z-depth-1">
							<?= PICKUP_DATE ?>: <?= s('transferDate') ?> <small>(Y-M-D)</small>
						</div>
					</div>

					<div class="col s12 l4">
						<div class="chip blue white-text center z-depth-1">
							<?= PICKUP_TIME ?>: <?= s('transferTime') ?> <small>(H:M 24h)</small>
						</div>
					</div>

					<div class="col s12 l4">
						<div class="chip blue white-text center z-depth-1">
							<?= PASSENGERS_NO?>: <?= s('PaxNo') ?>
						</div>
					</div>
					<br>&nbsp;<br>

					<?  if(getPlaceType( s('FromID') ) == '1') $pickupAddress = AIRPORT;
					else $pickupAddress = s('PickupAddress');

					?>
					<div class="col s12 ">
						<label for="PickupAddress"><?=  PICKUP_ADDRESS?></label>
					</div>
					<div class=" col s12">
						<input type="text" id="PickupAddress" name="PickupAddress"
							   value="<?= $pickupAddress ?>" title="<?= WHERE_PICKUP ?>"
							   placeholder="<?=  PICKUP_ADDRESS?>" class="validate" onkeyup="updateAdress();" autofocus>

						<br><br>
					</div>

					<? if(getPlaceType( s('FromID') ) == '1') { ?>
						<div class="col s12">
							<label for="FlightNo"><?= FLIGHT_NO ?></label>
						</div>
						<div class=" col s12">
							<input type="text" id="FlightNo" name="FlightNo"
								   value="<?= s('FlightNo')?>" title="<?= YOUR_FLIGHT_NO ?>">
							<br><br>
						</div>

						<div class="col s12 ">
							<label for="FlightTime"><?= FLIGHT_TIME ?>:</label>
						</div>
						<div class=" col s12">
							<input type="text" id="FlightTime" name="FlightTime" class="timepick"
								   value="<?= s('FlightTime')?>" data-field="time" title="<?= YOUR_FLIGHT_TIME ?>">
							<br><br>
						</div>

					<? } ?>
				</div>
			</div>

			<div class="row xpad1em">
				<div class="col s12">
					<br>
					<i class="fa fa-map-marker fa-2x red-text"></i> <?= TO ?>:
				</div>
				<div class="row grey lighten-4 pad1em  z-depth-1">
					<div class=" col s12">
						<h5>
							<strong><?= getPlaceName( s('ToID') ) ?></strong>
						</h5>
						<br><br>
					</div>

					<?  if(getPlaceType( s('ToID') ) == '1') $dropAddress = AIRPORT;
					else $dropAddress = s('dropAddress');
					?>
					<div class="col s12 ">
						<label for="DropAddress"><?=  DROPOFF_ADDRESS?> *</label>
					</div>
					<div class="col s12">
						<input type="text" id="DropAddress" name="DropAddress"
							   value="<?= $dropAddress?>" title="<?= WHERE_DROPOFF ?>" onkeyup="updateAdress();">
						<br><br>
					</div>

					<? if(getPlaceType( s('ToID') ) == '1') { ?>
						<div class="col s12 ">
							<label for="FlightNo"><?= FLIGHT_NO ?></label>
						</div>
						<div class=" col s12">
							<input type="text" id="FlightNo" name="FlightNo"
								   value="<?= s('FlightNo')?>" title="<?= YOUR_FLIGHT_NO ?>">
							<br><br>

						</div>
						<div class="col s12 ">
							<label for="FlightTime"><?= FLIGHT_TIME ?></label>
						</div>
						<div class=" col s12">
							<input type="text" id="FlightTime" name="FlightTime" class=" timepick"
								   value="<?= s('FlightTime')?>" data-field="time" title="<?= YOUR_FLIGHT_TIME ?>">
							<br><br>

						</div>
					<? } ?>

				</div>
			</div>
			<!-- from-to row -->


			<? if (s('returnTransfer'))  {?>
				<div class="row">
					<div class="xcol xs12">


						<div class="row grey lighten-2 pad1em z-depth-1">
							<div class="col s12 ucase"><h5><?= RETURN_TRANSFER ?></h5></div>
							<div class="col s12"><i class="fa fa-map-marker fa-2x"></i> <?= FROM ?>:</div>
							<div class=" col s12">
								<h5><?= getPlaceName( s('ToID') ) ?></h5>
							</div>
							<div class="col s12  l4">
								<div class="chip blue white-text center">
									<?= RETURN_DATE ?>: <?= s('returnDate') ?> <small>(Y-M-D)</small>
								</div>
							</div>

							<div class="col s12  l4">
								<div class="chip blue white-text center">
									<?= RETURN_TIME ?>: <?= s('returnTime') ?> <small>(H:M 24h)</small>
								</div>
							</div>

							<div class="col s12 ">
								<label for="RPickupAddress"><?= PICKUP_ADDRESS?> *</label>
							</div>
							<div class="col s12">
								<input type="text" id="RPickupAddress" name="RPickupAddress"
									   value="<?= $dropAddress ?>" title="<?= WHERE_PICKUP ?>">
								<br><br>
							</div>

							<? if(getPlaceType( s('ToID') ) == '1') { ?>
								<div class="col s12 "><br>
									<label for="RFlightNo"><?= FLIGHT_NO ?></label>
								</div>
								<div class=" col s12">
									<input type="text" id="RFlightNo" name="RFlightNo"
										   value="<?= s('RFlightNo')?>" title="<?= YOUR_FLIGHT_NO ?>">
									<br><br>
								</div>
								<div class="col s12">
									<label for="RFlightTime"><?= FLIGHT_TIME ?></label>
								</div>
								<div class=" col s12">
									<input type="text" id="RFlightTime" name="RFlightTime" class="timepick"
										   value="<?= s('RFlightTime')?>" data-field="time" title="<?= YOUR_FLIGHT_TIME ?>">
									<br><br>
								</div>
							<? } ?>
						</div>
					</div>

					<div class="xcol xs12">
						<div class="row grey lighten-2 pad1em z-depth-1">
							<div class="col s12 "><br><i class="fa fa-map-marker fa-2x"></i> <?= TO ?>:<br></div>
							<div class=" col s12">
								<h5><?= getPlaceName( s('FromID') ) ?></h5>
							</div>

							<div class="col s12 ">
								<label for="RDropAddress"><?= DROPOFF_ADDRESS ?></label>
							</div>
							<div class=" col s12">
								<input type="text" id="RDropAddress" name="RDropAddress"
									   value="<?= $pickupAddress ?>" title="<?= WHERE_DROPOFF ?>"
									   placeholder="<?= DROPOFF_ADDRESS ?>" class="validate">
								<br><br>
							</div>

							<? if(getPlaceType( s('FromID') ) == '1') { ?>
								<div class="col s12 ">
									<label for="RFlightNo"><?= FLIGHT_NO ?></label>
								</div>
								<div class=" col s12">
									<input type="text" id="RFlightNo" name="RFlightNo"
										   value="<?= s('RFlightNo')?>" title="<?= YOUR_FLIGHT_NO ?>">
									<br><br>
								</div>
								<div class="col s12  ">
									<label for="RFlightTime"><?= FLIGHT_TIME ?></label>
								</div>
								<div class=" col s12 ">
									<input type="text" id="RFlightTime" name="RFlightTime" class=" timepick"
										   value="<?= s('RFlightTime')?>" data-field="time" title="<?= YOUR_FLIGHT_TIME ?>">
									<br><br>
								</div>
							<? } ?>

						</div>

					</div>
				</div>

				<!-- return transfer row -->
			<? } ?>


			<div class="row">
				<div class="xcol xs12">
					<div class="row pad1em xmyblue lighten-3 white-text  xz-depth-3">

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
						######################################################################## todo
						?>





						<h5><i class="fa fa-user"></i> <?= YOUR_CONTACT_INFO ?></h5>

						<div class="col s12 l3 white-text">
							<label for="PaxFirstName"><?=  NAME ?> *</label>
						</div>
						<div class="col s12 l9">
							<input type="text" id="PaxFirstName" name="MPaxFirstName"
								   placeholder="<?= FIRST_NAME ?>"
								   value="<?= $paxFirstName ?>" title="<?= YOUR_FIRST_NAME ?>"
								   onchange="$('#ch_name').val(this.value);">


							<input type="text" id="PaxLastName" name="MPaxLastName"
								   placeholder="<?= LAST_NAME ?>"
								   value="<?= $paxLastName?>" title="<?= YOUR_LAST_NAME ?>"
								   onchange="$('#ch_last_name').val(this.value);">

							<label for="PaxLastName"></label>
						</div>

						<div class="col s12 l3 white-text">
							<label for="MPaxTel"><?=  MOBILE_NUMBER?> *</label>
						</div>
						<div class="col s12 l9 black-text">
							<input type="tel" id="MPaxTel" name="MPaxTel"
								   placeholder="+111 11 111-1111"
								   value="<?= $paxMobile?>"
								   title="<?= YOUR_TEL ?>"
								   onchange="$('#ch_phone').val(this.value);"
								   class="xwhite  black-text form-control">
							<span id="valid-msg" class="hidden">
                                <i class="ic ic-checkmark-circle xgreen-text"></i>
                            </span>
							<span id="error-msg" class="hidden error">
                                <i class="ic ic-cancel-circle red-text"></i>
                            </span>
							<br><br>
						</div>

						<div class="col s12 l3" style="vertical-align:top"><?= NOTES ?></div>
						<div class=" col s12 l9">
                            <textarea name="PickupNotes" rows="4"
									  id="PickupNotes"><?= s('PickupNotes'); ?></textarea>
						</div>
					</div>
				</div>

			</div>
			<!-- passenger info row -->

			<div id="selectExtras" class="row xxwhite xpad1em xz-depth-2">


				<? require_once 'para_extras.php'; ?>


			</div>
			<!-- Extras row -->


			<div class="row">
				<div class="xcol xs12 ">

					<div class="row white xlighten-1 xwhite-text xpad1em z-depth-3">

						<div class="col s12 l6 offset-l3">
							<div class="col s12 center  xblack-text">
								<h5 class="ucase light"><?= PAYMENT_METHOD ?></h5> <br>

								<select id="PaymentOption" name="PaymentOption" class="browser-default"
										onchange="paymentOptionSelect();" >

									<?

									$userData = array();
									$userData = getUserData($_SESSION['AuthUserID']);

									if($userData['AcceptedPayment'] == '10'){
										echo '<option value="4">'. PAY_INVOICE. '</option>';
									}

									if($userData['AcceptedPayment'] == '12'){
										echo '<option value="6">'. PAY_INVOICE. ' 2</option>';
									}

									if($userData['AcceptedPayment'] == '11') {
										echo '<option value="1">'. PAY_ONLINE. '</option>';                         }

									$AuthUserID = $_SESSION['AuthUserID'];
									$local = isLocalAgent($AuthUserID);
									if ($local == 1) {
										echo '<option value="2">'. PAY_CASH .'</option>';
									}

									?>

									<!--<option value="3"><?= PAY_ONLINE_CASH ?></options>
                                    <option value="1"><?= PAY_ONLINE ?></option>-->
								</select>
							</div>


							<div class="col s12 center  xblack-text">
								<label for="PaxEmail"><? echo  "CONTACT_EMAIL";?> *</label>
								<input type="email" id="PaxEmail" name="MPaxEmail" class="w75"
									   placeholder="myemail@mysite.com"
									   value="<?= $paxEmail?>" title="<?= YOUR_EMAIL ?>"
									   onchange="$('#ch_email').val(this.value);">
							</div>
							<div class="col s12 center">
								<br>
								<label>
									<a href="http://<?= $_SERVER['SERVER_NAME']?>/terms"
									   target="_blank" class="l" title="<?= PLEASE_READ ?>">
										<i class="ic ic-document-alt-stroke"></i> <?= TERMS_AND_CONDITIONS ?>
									</a>
								</label>
								<select id="acceptTC" onchange="acceptDeclineTC();" class="browser-default">
									<option value="0"><?= DECLINE ?></option>
									<option value="1"><?= ACCEPT ?></option>
								</select>
								<br><br>
							</div>


							<div class="row creditCardPayment" id="PaymentContinue" style="display:none">
								<div align="center" class="col s12">
									<br><br><br>
									<button type="submit" id="gotoPayment"
											class="btn grey btn-large xcol xs10 l"
											disabled="disabled">
										<i class="fa fa-lock"></i>&nbsp; <?= GOTO_PAYMENT ?>
									</button>
									<br/><br/>
									<?= RETURN_AFTER_PAYMENT  ?>
									<br/><br/>
								</div>
							</div>

							<div class="row cashPayment" id="PaymentContinue2">
								<div align="center" class="col s12">
									<br><br><br>
									<button type="submit" id="gotoPaymentCash"
											class="btn btn-large grey xcol xs12 l "
											disabled="disabled">
										<i id="paymentIcon" class="fa fa-times-circle"></i>&nbsp; <?= SEND ?>
									</button>
									<br><br>

								</div>
							</div>

						</div>
					</div>




				</div>
				<!-- main container -->
			</div>
			<br>
			<br>


			<?  # HIDDEN FIELDS ?>
			<input  type="hidden" id="BF" name="BF" value="BF">
			<input  type="hidden" id="RT" name="RT" value="<?=s('returnTransfer')?>">
			<input  type="hidden" id="ServiceID" name="ServiceID" value="<?= s('ServiceID') ?>">
			<?
			// sada driversPrice sadrzi stvarnu cijenu i broj vozila,
			// tako da se u dbAddOrder moze maknuti mnozenje sa brojem vozila
			$driversPrice   = number_format(s('DriversPrice') * s('VehiclesNo'), 2, '.', '');

			?>
			<input  type="hidden" id="DriversPrice" name="DriversPrice" value="<?= $driversPrice ?>">


			<?/* EURO */?>
			<input  type="hidden" id="TT" name="TT" value="<?= number_format(s('Price'),2,'.','')?>">
			<input  type="hidden" id="ET" name="ET" value="0">
			<input  type="hidden" id="PN" name="PN" value="0">
			<input  type="hidden" id="PL" name="PL" value="0">
			<?/* VALUTE */?>
			<input  type="hidden" id="TTC" name="TTC" value="<?= toCurrency(s('Price'))?>">
			<input  type="hidden" id="ETC" name="ETC" value="0">
			<input  type="hidden" id="PNC" name="PNC" value="0">
			<input  type="hidden" id="PLC" name="PLC" value="0">




	</form>


<?/*



        <div class="container">
        <br>
            <div class="row white z-depth-2 pad1em" id="xanim">

                <div class="col s12">
                    <h3 class="ucase"><?= MORE_DETAILS ?></h3>

                    <button class="btn btn-flat s" onclick="window.history.back()" />
                    <span class="ucase s"><i class="fa fa-arrow-left"></i> <?= CLICK_BACK ?></span>
                    </button>
                    <br><br>

                    <div class="col s12 l3 ucase"><?= COUNTRY ?>:</div>
                    <div class="col s12 l9">
                        <?= countryName( s('CountryID') )?>
                    </div>

                    <p class="line eee"></p>

                    <div class="col s12 l3 ucase"><?= FROM ?>:</div>
                    <div class=" col s12 l9">
                        <strong><?= getPlaceName( s('FromID') ) ?></strong>
                    </div>

                    <?  if(getPlaceType( s('FromID') ) == '1') $pickupAddress = AIRPORT;
                        else $pickupAddress = s('PickupAddress');
                    ?>
                    <div class="col s12 l3 ucase"><?=  PICKUP_ADDRESS?> *:</div>
                    <div class="col s12 l9">
                        <input type="text" id="PickupAddress" name="PickupAddress" class="col s12 l9"
                        value="<?= $pickupAddress ?>" title="Where do we pick you up?">
                    </div>

                    <? if(getPlaceType( s('FromID') ) == '1') { ?>
                    <div class="col s12 l3 ucase"><?= FLIGHT_NO ?>:</div>
                    <div class=" col s12 l9">
                        <input type="text" id="FlightNo" name="FlightNo" class="col s12 l9"
                        value="<?= s('FlightNo')?>" title="Your Flight number">

                    </div>
                    <div class="col s12 l3 ucase"><?= FLIGHT_TIME ?>:</div>
                    <div class=" col s12 l9">
                        <input type="text" id="FlightTime" name="FlightTime" class="col s12 l9 timepick"
                        value="<?= s('FlightTime')?>" data-field="time" title="Your Flight number">

                    </div>
                    <? } ?>

                    <p class="line eee"></p>

                    <div class="col s12 l3 ucase"><?= TO ?>:</div>
                    <div class=" col s12 l9">
                        <strong><?= getPlaceName( s('ToID') ) ?></strong>

                    </div>
                    <?  if(getPlaceType( s('ToID') ) == '1') $dropAddress = AIRPORT;
                        else $dropAddress = s('DropAddress');
                    ?>
                    <div class="col s12 l3 ucase"><?=  DROPOFF_ADDRESS?> *:</div>
                    <div class="col s12 l9">
                        <input type="text" id="DropAddress" name="DropAddress" class="col s12 l9"
                        value="<?= $dropAddress?>" title="Where do we drop you off?">
                    </div>

                    <? if(getPlaceType( s('ToID') ) == '1') { ?>
                    <div class="col s12 l3 ucase"><?= FLIGHT_NO ?>:</div>
                    <div class=" col s12 l9">
                        <input type="text" id="FlightNo" name="FlightNo" class="col s12 l9"
                        value="<?= s('FlightNo')?>" title="Your Flight number">

                    </div>
                    <div class="col s12 l3 ucase"><?= FLIGHT_TIME ?>:</div>
                    <div class=" col s12 l9">
                        <input type="text" id="FlightTime" name="FlightTime" class="col s12 l9 timepick"
                        value="<?= s('FlightTime')?>" data-field="time" title="Your Flight number">

                    </div>
                    <? } ?>


                    <p class="line eee"></p>
                    <div class="col s12 l3 ucase"><?= PICKUP_DATE ?>:</div>
                    <div class=" col s12 l9">
                        <?= s('transferDate') ?> <small>(Y-M-D)</small>
                    </div>

                    <div class="col s12 l3 ucase"><?= PICKUP_TIME ?>:</div>
                    <div class=" col s12 l9">
                        <?= s('transferTime') ?> <small>(H:M 24h)</small>
                    </div>

                    <div class="col s12 l3 ucase"><?= PASSENGERS_NO?>:</div>
                    <div class=" col s12 l9">
                        <?= s('PaxNo') ?>
                    </div>

                <? if (s('returnTransfer'))  {?>
                    <div class="col s12">
                        <div class="col s12 ucase"><?= RETURN_TRANSFER ?>:</div>
                        <div class="col s12 l9">
                                <?= YES ?>
                        </div>

                            <div class="col s12 l3 ucase"><?= FROM ?>:</div>
                            <div class=" col s12 l9">
                                <?= getPlaceName( s('ToID') ) ?>
                            </div>

                            <? if(getPlaceType( s('ToID') ) == '1') { ?>
                            <div class="col s12 l3 ucase"><?= FLIGHT_NO ?>:</div>
                            <div class=" col s12 l9">
                                <input type="text" id="RFlightNo" name="RFlightNo" class="col s12 l9"
                                value="<?= s('RFlightNo')?>" title="Your Flight number">

                            </div>
                            <div class="col s12 l3 ucase"><?= FLIGHT_TIME ?>:</div>
                            <div class=" col s12 l9">
                                <input type="text" id="RFlightTime" name="RFlightTime" class="col s12 l9 timepick"
                                value="<?= s('RFlightTime')?>" data-field="time" title="Your Flight number">

                            </div>
                            <? } ?>

                            <div class="col s12 l3 ucase"><?= TO ?>:</div>
                            <div class=" col s12 l9 ucase">
                                <?= getPlaceName( s('FromID') ) ?>
                            </div>

                            <? if(getPlaceType( s('FromID') ) == '1') { ?>
                            <div class="col s12 l3 ucase"><?= FLIGHT_NO ?>:</div>
                            <div class=" col s12 l9">
                                <input type="text" id="RFlightNo" name="RFlightNo" class="col s12 l9"
                                value="<?= s('RFlightNo')?>" title="Your Flight number">

                            </div>
                            <div class="col s12 l3 ucase"><?= FLIGHT_TIME ?>:</div>
                            <div class=" col s12 l9">
                                <input type="text" id="RFlightTime" name="RFlightTime" class="col s12 l9 timepick"
                                value="<?= s('RFlightTime')?>" data-field="time" title="Your Flight number">

                            </div>
                            <? } ?>

                        <div class="col s12 l3 ucase"><?= RETURN_DATE ?>:</div>
                        <div class=" col s12 l9">
                            <?= s('returnDate') ?> <small>(Y-M-D)</small>
                        </div>

                        <div class="col s12 l3 ucase"><?= RETURN_TIME ?>:</div>
                        <div class=" col s12 l9">
                            <?= s('returnTime') ?> <small>(H:M 24h)</small>
                        </div>
                    </div>

                <? } ?>


                    <br>&nbsp;
                    <hr>
                    <h5 class="col s12 grey-text ucase"><?= SELECTED_VEHICLE?></h5><hr>
                    <div class="col s12 l3"><?=  VEHICLE_TYPE ?>:</div>
                    <div class="col s12 l9">
                        <i class="fa fa-user"></i> <?= s('VehicleCapacity') ?>
                    </div>

                    <div class="col s12 l3 ucase"><?=  VEHICLE_NAME ?>:</div>
                    <div class="col s12 l9">
                        <?= s('VehicleName') ?>
                    </div>

                    <div class="col s12 l3 ucase"><?=  DRIVER_NAME ?>:</div>
                    <div class="col s12 l9">
                        <?= s('DriverName') ?>
                    </div>

                    <div class="col s12 l3 ucase"><?=  PRICE ?>:</div>
                    <div class="col s12 l9">
                        <h5><strong><?= nf( toCurrency(s('Price')) ) . ' ' . s('Currency') ?></strong></h5>
                    </div>


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




                    <br>&nbsp;<hr>
                    <h5 class="grey-text"><?= YOUR_CONTACT_INFO ?></h5><hr>

                    <div class="col s12 l3">
                                                <label for="PaxFirstName"><?=  NAME ?> *:</label>
                                        </div>
                    <div class="col s12 l9">
                        <input type="text" id="PaxFirstName" name="MPaxFirstName" class="w50"
                        placeholder="First name"
                        value="<?= $paxFirstName ?>" title="Your first name"
                        onchange="$('#ch_name').val(this.value);">

                        <input type="text" id="PaxLastName" name="MPaxLastName" class="w50"
                        placeholder="Last name"
                        value="<?= $paxLastName?>" title="Your last name"
                        onchange="$('#ch_last_name').val(this.value);">
                    </div>

                    <div class="col s12 l3">
                                                <label for="PaxEmail"><?=  EMAIL?> *:</label>
                                        </div>
                    <div class="col s12 l9">
                        <input type="email" id="PaxEmail" name="MPaxEmail" class="col s12 l9"
                        placeholder="myemail@mysite.com"
                        value="<?= $paxEmail?>" title="Your full email address"
                        onchange="$('#ch_email').val(this.value);">
                    </div>

                    <div class="col s12 l3">
                                                <label for="MPaxTel"><?=  MOBILE_NUMBER?> *:</label>
                                        </div>
                    <div class="col s12 l9">
                        <input type="tel" id="MPaxTel" name="MPaxTel" class="browser-default"
                        placeholder="+111 11 111-1111"
                        value="<?= $paxMobile?>"
                        title="+Country Code - Area Code - Phone Number"
                        onchange="$('#ch_phone').val(this.value);">
                        <span id="valid-msg" class="hidden">
                            <i class="ic ic-checkmark-circle xgreen-text"></i>
                        </span>
                        <span id="error-msg" class="hidden error">
                            <i class="ic ic-cancel-circle red-text"></i>
                        </span>
                        <br><br>
                    </div>

                    <div class="col s12 l3" style="vertical-align:top"><?= NOTES ?>:</div>
                    <div class=" col s12 l9">
                        <textarea name="PickupNotes" rows="4"
                        id="PickupNotes" rows="5"><?= s('PickupNotes') ?></textarea>
                    </div>


                    <p class="line eee"></p>


                    <div id="selectExtras" class="xhidden col s12">
                        <? require_once $_SERVER['DOCUMENT_ROOT'].'/t/para_extras.php'; ?>

                    </div>

                    <p class="line eee"></p>
                    <br><br>

                    <div class="w100 center">
                        <p style="font-size:.7em;text-transform:uppercase;text-align:left;">
                                <?= SERVICES_DESC ?>
                            </ul>
                        </p>
                        <br><br>
                    </div>

                    <div id="paymentData">

                        <p class="line eee"></p>
                        <h3 class="aaa"><?= PAYMENT ?></h3><p class="line eee"></p>


                        <div class="row">

                            <div class="col s12 l6">

                                <div>
                                    <h5><?= PAYMENT_METHOD ?> :</h5> <br>

                                    <select id="PaymentOption" name="PaymentOption" class="browser-default"
                                    onchange="paymentOptionSelect();">
                                        <option value="2"><?= PAY_CASH ?></option>
                                        <option value="3"><?= PAY_ONLINE_CASH ?></options>
                                        <option value="1"><?= PAY_ONLINE ?></option>
                                    </select>
                                </div>

                                <div class="col s12 l6"">
                                    <div class="col-1-1">
                                        <?= PAY_NOW ?> : <span id="displayPN"></span> <?= s('Currency')?>
                                    </div>

                                    <div class="col s12 l12"">
                                        <?= PAY_LATER ?> : <span id="displayPL"></span> <?= s('Currency') ?>
                                    </div>
                                </div>

                                <div id="CouponData" class="hidden">
                                    <p><label for="Coupon"><?= COUPON ?> : </label><br/>
                                    <input type="text" id="Coupon" name="Coupon" value=""></p>

                                    <p><button class="btn blue-2" id="CouponBtn" onclick="return CheckCoupon();">
                                    <i class="ic-checkmark ic-white"></i> <?= APPLY_COUPON ?></button></p>
                                </div>

                                <div id="showNewTotal" class="col-md-4"></div>
                            </div>

                            <div class="col s12 l6"">

                            </div>

                            <div class="col s12 l6"">
                                <h3 class="creditCardPayment" style="display:none"><?= CARD_HOLDER_DETAILS ?></h3>
                                <h3 class="cashPayment" style="display:none"><?= CASH_PAYMENT_DETAILS ?></h3>
                                <br>
                                <div class="cashPayment shadow pad1em" style="display:none">
                                    <div id="sendPin">
                                        <small>
                                        <?= MOBILE_INSTRUCTIONS ?>

                                        </small>
                                        <button class="btn blue-1" onclick="return sendPIN();">
                                        <?= SEND_PIN ?></button>
                                    </div>
                                    <div class="pinSentInfo" id="pinSentInfo"></div>

                                    <div class="pinSent" id="pinSent" style="display:none">
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="creditCardPayment" style="display:none">
                                    <div class="form-group">
                                        <label for="ch_name"><?= FIRST_NAME ?> *:</label><br/>
                                        <input id="ch_name" name="ch_name" type="text" class="w100"
                                        value="<?= $paxFirstName ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label for="ch_last_name"><?= LAST_NAME ?> *:</label><br/>
                                        <input id="ch_last_name" name="ch_last_name" type="text"  class="w100"
                                        value="<?= $paxLastName ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label for="ch_address"><?= ADDRESS ?> *:</label><br/>
                                        <input id="ch_address" name="ch_address" type="text" value="" class="w100" />
                                    </div>
                                    <div class="form-group">
                                        <label for="ch_city"><?= CITY ?> *:</label><br/>
                                                                                <input id="ch_city" name="ch_city" type="text" value="" class="w100"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="ch_zip"><?= ZIP ?> *:</label><br/>
                                                                                <input id="ch_zip" name="ch_zip" type="text" value="" class="w100"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="ch_country"><?= COUNTRY ?> *:</label><br/>
                                        <select id="ch_country" name="ch_country"  class="w100">
                                            <option value=""> --- </option>
                                            <?
                                            $c = new v4_Countries();
                                            $k = $c->getKeysBy('CountryName', 'asc');

                                            foreach($k as $nn => $CountryID) {
                                                $c->getRow($CountryID);
                                                echo '<option value="' . $c->getCountryID() . '">';
                                                echo $c->getCountryName();
                                                echo '</option>';
                                            }

                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="ch_phone"><?= MOBILE_NUMBER ?> *:</label><br/>
                                                                                <input id="ch_phone" name="ch_phone" type="text" class="w100" value="<?= $paxMobile?>" />
                                    </div>
                                    <div class="form-group">
                                        <label for="ch_email"><?= EMAIL?> *:</label><br/>
                                                                                <input id="ch_email" name="ch_email" type="text" class="w100" value="<?= $paxEmail ?>" />
                                    </div>
                                </div>


                                <br><br>
                                <div class="form-group">
                                    <label for="acceptTC"><a href="http://<?= $_SERVER['SERVER_NAME']?>/terms"
                                        target="blank"><?= TERMS_AND_CONDITIONS ?> :</a></label>
                                    <br>

                                    <select id="acceptTC" onclick="acceptDeclineTC();" class="browser-default">
                                        <option value="0"><?= DECLINE ?></options>
                                        <option value="1"><?= ACCEPT ?></option>
                                    </select>
                                    &nbsp;&nbsp;<i id="terms" class="ic ic-cancel-circle l red-text"></i>
                                </div>

                                <br><br>
                            </div>

                        </div><!--/row-->

                        <div class="grid creditCardPayment" id="PaymentContinue" style="display:none">
                            <div align="center" class="col-1-1">
                                <button type="submit" id="gotoPayment"
                                class="btn btn-primary xgreen btn-large col-1-1 l"
                                disabled="disabled">
                                    <i class="ic-lock"></i>&nbsp; <?= GOTO_PAYMENT ?>
                                </button>
                                <br/><br/>
                                <?= RETURN_AFTER_PAYMENT ?>
                                <br/><br/>
                            </div>
                        </div>

                        <div class="grid cashPayment" id="PaymentContinue2">
                            <div align="center">
                                <button type="submit" id="gotoPaymentCash"
                                class="btn btn-primary btn-large xgreen col-1-1 l"
                                disabled="disabled">
                                    <i id="paymentIcon" class="ic-cancel-circle ic-white"></i>&nbsp; <?= SEND ?>
                                </button>
                                <br/><br/>

                                <br/><br/>
                            </div>
                        </div>

                    </div> <!-- END PAYMENT DATA -->


                </div>
            </div>
            <br>
        </div>

    <? # HIDDEN FIELDS ?>
    <input  type="hidden" id="BF" name="BF" value="BF"/>
    <input  type="hidden" id="RT" name="RT" value=""/>
    <input  type="hidden" id="ServiceID" name="ServiceID" value="<?= s('ServiceID') ?>"/>

    <div id="HiddenTotals" style="display:none">
        <input  type="hidden" id="TT" name="TT" value="<?= number_format(s('Price'),2,'.','')?>"/>
        <input  type="hidden" id="ET" name="ET" value="0"/>
        <input  type="hidden" id="PN" name="PN" value="0"/>
        <input  type="hidden" id="PL" name="PL" value="0"/>
        <input  type="hidden" id="TTC" name="TTC" value="<?= toCurrency(s('Price'))?>"/>
        <input  type="hidden" id="ETC" name="ETC" value="0"/>
        <input  type="hidden" id="PNC" name="PNC" value="0"/>
        <input  type="hidden" id="PLC" name="PLC" value="0"/>

    </div>



    </form>

<div id="Summary"></div>
*/

require_once "final.js.php";

