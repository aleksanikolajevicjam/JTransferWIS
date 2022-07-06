<?
/*
	Dependencies: 
		t/booking_new.php
		js/pages/booking_new.php.js
*/
	error_reporting(E_ALL);
	@session_start();
	require_once $_SERVER['DOCUMENT_ROOT'] .'/lng/'.$_SESSION['language'].'.php';
	
	// priprema podataka o vozilima i vozacima
	require_once $_SERVER['DOCUMENT_ROOT'] .'/api/getCars.php';


/*
Iz gornje skripte
prima podatke o vozilu:
							$cars[] = array(
								'RouteID'			=> $id,
								'OwnerID'			=> $OwnerID,
								'Driver'			=> $Driver,
								'ProfileImage'		=> $ProfileImage,
								'ServiceID' 		=> $ServiceID,
								'VehicleID' 		=> $VehicleID,
								'VehicleTypeID' 	=> $VehicleTypeID,
								'VehicleName'		=> $VehicleName,
								'VehicleImage'		=> $VehicleImage,
								'VehicleCapacity'	=> $VehicleCapacity,
								'BasePrice'			=> round($BasePrice,0),
								'Rating'			=> $Rating
							);

i podatke o profilu vozaca:
							$drivers[$OwnerID] = array(
										'Driver'			=> $Driver,
										'ProfileImage'		=> $ProfileImage,
										'RealName'			=> $au->getAuthUserRealName(),
										'Company'			=> $au->getAuthUserCompany(),
										'Address'			=> $au->getAuthCoAddress()
							);

i eventualne greske:
			$carsErrorMessage['title'] = 'Sorry, No available vehicles';
			$carsErrorMessage['text'] = 'or vehicles are too small for your group';

/**********************************************************************************************************

				DISPLAY SECTION
				
***********************************************************************************************************/				


// No Errors found
if (count($carsErrorMessage) == 0) { ?>

	<div class="white">
		<div class="col s12">
			<div class="col s12 pad1em">
				<br><br>
				<hr>
				<? require_once 'para_iconSection.php'; ?>
				<div class="center white">
					<? 	
						
						// za kasnije, prebaceno iz /api/getCars.php
						if (count($carsErrorMessage) == 0) {
							$cars = subval_sort($cars, 'Rating');
							$drivers = subval_sort($drivers, 'Company');
						}	
						
						foreach($cars as $i => $carData): 
						if ($carData['BasePrice'] >= 0):
							
							$rating = ShowRatings($carData['OwnerID']);
							
							// IMAGES
							if ($carData['VehicleCapacity'] <= 4) $vehicleImage = '/i/cars/taxi.png';
							else if ($carData['VehicleCapacity'] <= 8) $vehicleImage = '/i/cars/minivan.png';
							else if ($carData['VehicleCapacity'] <= 15) $vehicleImage = '/i/cars/minibus.png';
							else if ($carData['VehicleCapacity'] > 15) $vehicleImage = '/i/cars/bus.png';
					?>

					<!-- CAR PANEL -->

							
							<div class="col s12 z-depth-3 pad1em">
								<div class="col s12 l3">
									<h5><?= $carData['VehicleName']?></h5>
									<? //if(file_exists($carData['VehicleImage'])) { ?>
										<img class="xcarShadow" src="<?= $carData['VehicleImage'] ?>" 
										style="max-height:80%;max-width:80%;">
									
										<br>
									<? //} ?>
									<i class="material-icons medium">group</i> x <?= $carData['VehicleCapacity']?>
									&nbsp;&nbsp;&nbsp;&nbsp;

									<i class="material-icons teal-text">work</i> x <?= $carData['VehicleCapacity']?>
									<i class="material-icons teal-text">local_mall</i> x <?= $carData['VehicleCapacity']?>
								</div>
								
								<div class="col s12 l8">
									<h4 class="price">
									  <?= STARTING_FROM ?> 
									  <?= $carData['BasePrice'] . ' ' .$_SESSION['Currency']?> 
									</h4>
									<p>
										<?= AVAILABILITY_DEPENDS ?>
									</p>
									<p class="s">
										<?= FILL_PICKUP_PRESS_SHOW ?>
									</p>
									<br>


									
									<? if($carData['VehicleCapacity'] < $PaxNo) { ?>
											<small><i class="material-icons">face</i><?= TOO_SMALL ?></small>
											<br>
									<? } ?>	
									<br>

															
								</div>
								
								<? /*
								<div class="col-5-12"  style="text-align:left;">
									<p>
										<ul style="font-size:.7em;text-transform:uppercase;text-align:left">
											<li>This is a private transfer</li>
											<li>Service includes vehicle and driver</li>
											<li>Prices are per vehicle, not per person</li>
											<li>Waiting at the airports up to one hour is free</li>
											<li>Flight delays are monitored</li>
											<li>Each passenger is allowed 2 pcs of luggage</li>
										</ul>
									</p>
								
									<!-- RATINGS -->
									<!--	
									<img class="roundImg carShadow" src="<?= $carData['ProfileImage'] ?>"
									 style="height:4em;width:4em;float:left;margin-right:1em"> 

							
									<i class="ic-steering-wheel"></i> <?= $carData['DriverCompany']?>
								
									
									<?  
										if ($rating > 8) {
											echo '	<h2><span style="color:#a00;background:white">
														<i class="ic-bookmark"></i> 
														Top Driver &nbsp;
													</span></h2>';
										}
										else echo '<br>';
									?>

									<i class="ic-star"></i> <strong><?= $rating?></strong><small>/10</small>
									<br>
									<br>
									<br>
									-->

								</div>
								*/?>

							</div>


					<?
						endif; 
						endforeach; 
					?>

				</div>
			</div>
		</div>


<? } else { // Errors found ?>
	<div class="red">
		<div class="row ">
			<div class="col s12 pad1em">
				<br><br>
				<hr>
					<h2 class="center"><?= $carsErrorMessage['title']; ?></h2>
					<div class="center"><small class="ucase"><?= $carsErrorMessage['text']; ?></small></div>
				<hr>
			</div
		</div>
	</div>
<? } ?> 



