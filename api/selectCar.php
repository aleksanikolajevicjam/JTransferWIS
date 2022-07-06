<? 
/*
	Dependencies: 
		t/booking_new.php
		js/pages/booking_new.php.js
*/
	error_reporting(E_PARSE);
	@session_start();
	require_once $_SERVER['DOCUMENT_ROOT'] . '/f/f.php';

	// LANGUAGES
	if ( isset($_SESSION['CMSLang']) and $_SESSION['CMSLang'] != '') {
		$languageFile = $_SERVER['DOCUMENT_ROOT'].'/cms/lng/' . $_SESSION['CMSLang'] . '_text.php';
		if ( file_exists( $languageFile) ) require_once $languageFile;
		else {
			$_SESSION['CMSLang'] = 'en';
			require_once $_SERVER['DOCUMENT_ROOT'].'/lng/en.php';
		}
	}
	else {
		$_SESSION['CMSLang'] = 'en';
		require_once $_SERVER['DOCUMENT_ROOT'].'/lng/en.php';
	}
	define("SITE_CODE", '2');
	define("B", ' ');
	define("BD", ': ');
	define("NL", '<br>');
	
	
	// priprema podataka o vozilima i vozacima
	require_once $_SERVER['DOCUMENT_ROOT'] . '/api/getCars.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/m/getContractPrices.php';
	
 	// prikaz Km i Duration route
	$routeDetails = array();
	$detailsDesc = '';
	if(is('FromID') and is('ToID')) {
		$routeDetails = GetRouteDetails(s('FromID'), s('ToID'));
		if($routeDetails['Km'] > 0) $detailsDesc .= $routeDetails['Km'] .' km,';
		if($routeDetails['Duration'] > 0) $detailsDesc .= $routeDetails['Duration'] .' mins';
		if($detailsDesc != '') $detailsDesc = '<span><i class="fa fa-dashboard"></i> '.$detailsDesc.'</span>';
	}
/*
Iz gornje skripte
prima podatke o vozilu:
							$cars[] = array(
								'RouteID'			=> $id,
								'OwnerID'			=> $OwnerID,
								'DriverCompany'		=> $DriverCompany,
								'ProfileImage'		=> $ProfileImage,
								'ServiceID' 		=> $ServiceID,
								'VehicleID' 		=> $VehicleID,
								'VehicleTypeID' 	=> $VehicleTypeID,
								'VehicleName'		=> $VehicleName,
								'VehicleImage'		=> $VehicleImage,
								'VehicleCapacity'	=> $VehicleCapacity,
								'BasePrice'			=> round($BasePrice,0),
								'Rating'			=> $Rating,
								'NightPrice'		=> $sur['NightPrice'],
								'MonPrice'			=> $sur['MonPrice'],
								'TuePrice'			=> $sur['TuePrice'],
								'WedPrice'			=> $sur['WedPrice'],
								'ThuPrice'			=> $sur['ThuPrice'],
								'FriPrice'			=> $sur['FriPrice'],
								'SatPrice'			=> $sur['SatPrice'],
								'SunPrice'			=> $sur['SunPrice'],
								'S1Price'			=> $sur['S1Price'],
								'S2Price'			=> $sur['S2Price'],
								'S3Price'			=> $sur['S3Price'],
								'S4Price'			=> $sur['S4Price']
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

/*****************************************************************************************

				DISPLAY SECTION
				
*****************************************************************************************/			

//echo '<pre>'; print_r($cars); echo '</pre>';


// No Errors found
if (count($carsErrorMessage) == 0) { 



?>


			<div class="row xpad1em white-text">
				<br><br>
				<hr>
					<h4 class="center ucase"><?= AVAILABLE_VEHICLES ?></h4>
					<div class="center"><small class="ucase"><?= NOT_REAL_CAR ?></small></div>
				<hr>

			</div>
				
			<? 	
			
			// za kasnije, prebaceno iz /api/getCars.php
			if (count($carsErrorMessage) == 0) {
				$cars = subval_sort($cars, 'Rating');
				$drivers = subval_sort($drivers, 'Company');
			}	
			
			$counter = 0;
			foreach($cars as $i => $carData): 
			
			$contract='(contracted)';
			$AgentID=$_SESSION['AuthUserID']; 
			if ($_REQUEST['AuthUserID']>0) $AgentID=$_REQUEST['AuthUserID']; 
			else $AgentID=$_SESSION['AuthUserID']; 			
			$contractPrice=getContractPrice($carData['VehicleTypeID'],$carData['RouteID'],$AgentID);
			$pass=true;
			$rivijera=array(2833,2835,2836,2837,2838,2839,2841);
			if ($contractPrice==0 && (in_array($_SESSION['AuthUserID'], $rivijera))) $pass=false;
			//if ($AgentID==2833 && $carData['OwnerID']!=2828) $pass=false;			
			if ($carData['BasePrice'] > 0 && $pass):
				
				
				$counter++;
				
				$rating = ShowRatings($carData['OwnerID']);
				
				if      ($carData['VehicleCapacity'] <= 3) $vehicleImage = '/i/cars/sedan.png';
				else if ($carData['VehicleCapacity'] <= 4) $vehicleImage = '/i/cars/taxi.png';
				else if ($carData['VehicleCapacity'] <= 8) $vehicleImage = '/i/cars/minivan.png';
				else if ($carData['VehicleCapacity'] <= 16) $vehicleImage = '/i/cars/minibus.png';
				else if ($carData['VehicleCapacity'] > 16) $vehicleImage = '/i/cars/bus.png';


				?>

				<!-- CAR PANEL -->
						
				<div class="row z-depth-2 white lighten-5 center">
					<div class="col s12 l4 white">
						<? 	if($counter == 1) {  ?>
							<span class="chip red white-text left">
								<i class="fa fa-certificate"></i> <?= BEST_OFFER ?></span>
						<? } else {?>
						<br><br>
						<? }?>
						
						<? //if(file_exists($carData['VehicleImage'])) { ?>
							<img class="" src="<?= $carData['VehicleImage'] ?>" 
							style="max-height:80%;max-width:80%;" alt="car">
			
							<br>
						<?// } ?>

						<br><br>						
					</div>
					<!-- car image and capacity -->
					
					
					<div class="col s12 l4">
						<br>
						<h5 style="text-transform:uppercase; font-weight:100 !important"><?= $carData['VehicleName']?></h5>

						<div class="grey-text text-darken-3">
						<i class="fa fa-user l"></i> <?= $carData['VehicleCapacity']?>
						+ 

						<i class="fa fa-suitcase l"></i> <?= $carData['VehicleCapacity']?> + 
						<i class="fa fa-briefcase"></i> <?= $carData['VehicleCapacity']?>
								<?= $detailsDesc ?>
						</div>


						<div class="ucase s" xstyle="font-size:.5em;text-transform:uppercase;text-align:left">
							<br>
							<div class="col s6 l12 left">
							<i class='fa fa-plus-square l red-text'></i><?= SERVICES_DESC1 ?></div>
							
							<div class="col s6 l12 left">
							<i class='fa fa-clock-o l red-text'></i>&nbsp;<?= SERVICES_DESC3 ?></div>
							
							<div class="col s6 l12 left">
							<i class='fa fa-plane red-text'></i>&nbsp;<?= SERVICES_DESC4 ?></div>
							
							<div class="col s6 l12 left">
							<i class='fa fa-suitcase l red-text'></i>&nbsp;<?= SERVICES_DESC5 ?></div>							
							
						</div>

					
						<? if (SITE_CODE == '1') { ?>
							<img class="roundImg carShadow" src="<?= $carData['ProfileImage'] ?>"
							 style="height:4em;width:4em;float:left;margin-right:1em"> 

							<!-- RATINGS -->								
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
						
						<? } // end SITE_CODE ?>

						<br>

					</div>
					<!-- driver profile and ratings -->
					
					<div class="col s12 l4">
						<?
						$addToPrice =   $carData['MonPrice'] +
										$carData['TuePrice'] +
										$carData['WedPrice'] +
										$carData['ThuPrice'] +
										$carData['FriPrice'] +
										$carData['SatPrice'] +
										$carData['SunPrice'] +
										$carData['S1Price'] +
										$carData['S2Price'] +
										$carData['S3Price'] +
										$carData['S4Price'] +
										$carData['S5Price'] +
										$carData['S6Price'] +
										$carData['S7Price'] +
										$carData['S8Price'] +
										$carData['S9Price'] +
										$carData['S10Price'] ;
						

						if ($contractPrice==0) {
							$displayPrice = $carData['BasePrice'];// + $carData['NightPrice'] + $addToPrice;
							$contract='';
						}	
						else $displayPrice=$contractPrice; 
						$reducedPrice=$displayPrice*(100-$_SESSION['Provision'])/100;
						?>

						<div class="s">
							<?	
							if($carData['BasePrice'] != $displayPrice && (!in_array($_SESSION['AuthUserID'], $rivijera)))
							echo BASE_PRICE . BD . 
							nf(toCurrency($carData['BasePrice'])) . NL; 

							//if($carData['NightPrice'] != 0) 
							//	echo NIGHT_PRICE . BD . nf(toCurrency($carData['NightPrice'])) . NL;
						
							//if($addToPrice != 0) 
							//	echo OTHER_PRICES . BD . nf(toCurrency($addToPrice)) . NL; 
							?>
						</div>

						<h5 class="price">

							<? echo s('Currency') . ' ' ;?> 	
							<input type="text" value="<?= nf(toCurrency($displayPrice)*$_SESSION['ExchFaktor']) ?>" 
							name="price<?=$i+1?>" id="price<?=$i+1?>" readonly="readonly"
							class="black-text align-left" style="border:none !important; max-width:5em;">
							<input type="hidden" name='provision<?=$i+1?>' value="<?= $displayPrice*($_SESSION['Provision'])/100 ?>" />
							<?	$pricediscount=nf($displayPrice*$_SESSION['ExchFaktor']*($_SESSION['Provision'])/100) ?>
							<?	if ($displayPrice*$_SESSION['ExchFaktor']*($_SESSION['Provision'])/100!='0.00') {?><span> <?=$pricediscount ?> (dis./car)</span><? }?>
							<?	echo $contract ?>														
						</h5>
						<span class="ucase s"><?= SERVICES_DESC2 ?></span><br>
						<?//= $carData['DriverCompany']?>
						

						<? if($carData['VehicleCapacity'] < $PaxNo) { ?>
								<small class="red pad4px"><i class="ic-info"></i> <?= SMALL_VEHICLE ?></small>
								<br><br>
						<? } ?>	
						
						<label for="VehiclesNo<?=$i+1?>"><span class="black-text"><?= VEHICLES_NO ?>:</span></label>
						<select class="browser-default" name="VehiclesNo<?=$i+1?>" id="VehiclesNo<?=$i+1?>"
						        style="display:inline; max-width:3em;"
						        onchange="vehicleNumber('<?=$displayPrice*$_SESSION['ExchFaktor']?>','<?=$i+1?>');">
						    <option value="1">1</option>
						    <option value="2">2</option>
						    <option value="3">3</option>
						    <option value="4">4</option>
						</select>
						
						<br>
						<button class="btn btn-large blue"
							id="v<?=$i+1?>" 
							data-vehiclecapacity="<?= $carData['VehicleCapacity']?>" 
							data-vehicleimage="<?= $carData['VehicleImage']?>" 
							data-price="<?= $displayPrice ?>" 
							data-driversprice="<?= $carData['DriversPrice'] ?>" 
							data-routeid="<?= $carData['RouteID']?>" 
							data-serviceid="<?= $carData['ServiceID']?>" 
							data-driverid="<?= $carData['OwnerID']?>" 
							data-vehicleid="<?= $carData['VehicleID']?>" 
							data-vehiclename="<?= $carData['VehicleName']?>" 
							data-drivername="<?= $carData['DriverCompany']?>" 

							onclick="return carSelected('<?=$i+1?>');" >
							<i class="fa fa-send-o right"></i> Select
						</button>
						<br><br>
					</div>
					<!-- car price -->					
					
					<div class="col s12 lime darken-2 white-text pad1em hidden">
						<div class="col s6">
							<i class="fa fa-certificate"></i> <?= BEST_PRICE ?>
						</div>
						<div class="col s6">
							<i class="fa fa-times-circle"></i> <?= NO_ADD_CHARGE ?>
						</div>
					</div>
					<!-- bottom row -->
					<!---<? if ($carData['BookingTime']>100) { ?><span class='red'>&nbsp Free cancellation in more than 48 hours before the pick up time!&nbsp </span><?}?>!--->
				</div>
				<!-- main car panel div -->

		<?
			endif; 
			endforeach; 
		?>

</div>


	<? if (SITE_CODE == '1') { ?>
		<div class="col s12  lgray center pad1em">
				<div class="col s12 ucase">
					<hr>
						<h2 class="center"><?= DRIVERS_PROFILES ?></h2>
						<small><?= CLICK_PANEL ?></small>
					<hr>
				</div>

			<? 

			foreach($drivers as $oid => $driverData): ?>

					<div id="ProfileButton" onclick="ShowDriverProfile('<?= $oid ?>')">
					 	<div class="col s12 white shadow clickPanel pad1em">
							<img class="roundImg carShadow" src="<?= $driverData['ProfileImage'] ?>"
							 style="height:4em;width:4em;xfloat:left;margin-right:1em"><br>
							 <?= $driverData['Company']?> 
						</div>
					</div>
					<div id="DriverProfile<?=$oid?>" class="col s12 pad1em dgray hidden" 
					style="text-align:left !important; margin-bottom:1em">
						<address>
						<?= $driverData['RealName']?><br>
						<?= $driverData['Company']?><br>
						<?= $driverData['Address']?><br>
						</address>
					</div>
			
			<? endforeach; ?>
		</div>
	<? } // end SITE_CODE ?>

<? } else { // Errors found ?>
	<div class="blue">
		<div class="col s12 ">
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

