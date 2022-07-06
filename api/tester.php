<?
//echo '<pre>'; print_r($_REQUEST); echo '</pre>';
error_reporting(0);
@session_start();

require_once ROOT . '/api/getBookingData.php';

$T = getBookingData();
if (count($T) > 2) $RT = 1; // return transfer exists

?>
<form action="/booking3" method="GET" id="booking2Form" onsubmit="return submitBookingForm();">
<!-- /.vehicle types section -->
<div id="xpackage">
	<div class="container">
		<div class="text-center">
			<br>

			<h1 class="wow fadeInLeft thin">SELECT YOUR VEHICLE</h1>
			<div class="title-line wow fadeInRight"></div>
			<br>
		</div>


		<div class="row">
			<div class="col-md-3 visible-lg wow fadeInDown" data-wow-delay="0.6s">
				<div class="row price-box">
					<div class="col-md-12">
						<h4 class="fat">Booking summary</h4>
						<h5>Step: 2/5</h5>
						<? echo 'ID: '; echo $_SESSION['TOK']; 	echo '<br>'; ?>
					</div>
					<div class="col-md-12 grey darken-4 normal">	
						<h6 class="white">First transfer</h6>
					</div>
					<div class="col-md-12">
						<?
						echo '<strong class="green">Starting from:</strong><br>';
						echo '<span class="black-text">';
						echo strtoupper($T[0]['PickupName']).'<br>';
						echo strtoupper($T[0]['PickupDate']).' @ ';
						echo strtoupper($T[0]['PickupTime']).'<br>';
						echo '</span>';

						echo '<strong class="green">Going to:</strong><br>';
						echo '<span class="black-text">';
						echo strtoupper($T[0]['DropName']);
						echo '</span>';
						if($RT) { ?>
					</div>
					<div class="col-md-12 grey darken-4 normal">
						<h6 class="white">Return transfer</h6>
					</div>
					<div class="col-md-12">
						<?
						echo '<strong class="green">Starting from:</strong><br>';
						echo '<span class="black-text">';
						echo strtoupper($T[1]['PickupName']).'<br>';
						echo strtoupper($T[1]['PickupDate']).' @ ';
						echo strtoupper($T[1]['PickupTime']).'<br>';
						echo '</span>';

						echo '<strong class="green">Going to:</strong><br>';
						echo '<span class="black-text">';
						echo strtoupper($T[1]['DropName']);
						echo '</span>';
						}
						
						?>
					</div>
					<div class="col-md-12 grey darken-4 pad1em normal">
						<a href="/booking" class="white-text">
							<i class="fa fa-arrow-left pe-va"></i>
							Change Your Route
						</a>

					</div>
				</div>
			</div>
			<div class="col-md-9">	
<? 


	$cars = array();

	// fills $cars array 
	require_once ROOT . '/api/getCars.php';

	$counter = 0;
	foreach($cars as $i => $car) {

		if ($car['BasePrice'] > 0):
			
			$detailsDesc = '';
			if($car['Km'] > 0) $detailsDesc .= $car['Km'] .' km, ';
			if($car['Duration'] > 0) $detailsDesc .= $car['Duration'] .' mins';
			if($detailsDesc != '') 
			$detailsDesc = '<span class="grey-text light">
			<i class="fa fa-clock-o"></i> ~'.$detailsDesc.'</span>';
			
			$counter++;
			$addToPrice =   $car['MonPrice'] +
							$car['TuePrice'] +
							$car['WedPrice'] +
							$car['ThuPrice'] +
							$car['FriPrice'] +
							$car['SatPrice'] +
							$car['SunPrice'] +
							$car['S1Price'] +
							$car['S2Price'] +
							$car['S3Price'] +
							$car['S4Price'] +
							$car['S5Price'] +
							$car['S6Price'] +
							$car['S7Price'] +
							$car['S8Price'] +
							$car['S9Price'] +
							$car['S10Price'] ;
			
			// ovo je sve dodano u getCars i spremljeno u BasePrice
			$displayPrice = $car['BasePrice'];// + $car['NightPrice'] + $addToPrice;
			
			$fullPrice = addJTProvision( 
							getDriverPrice($car['ServiceID']), 
							$car['OwnerID'],
							$car['VehicleClass']
						);
			if($RT) $fullPrice = $fullPrice * 2;
											// zaokruzenje cijena
			$fullPrice= nf( round($fullPrice,0,PHP_ROUND_HALF_UP) );	
			
			$car['FullPrice'] = $fullPrice;
			
			require_once ROOT . '/t2/carPanel.php';
			showCarPanel($car, $counter);


		endif; // BasePrice > 0

	}	
?>
		</div>
		</div> <!-- /row -->

	</div> <!-- /container -->
</div> <!-- /package -->

<?
	foreach($_GET as $key => $value) { ?>
			<input type="hidden" id="<?= $key ?>" name="<?= $key ?>" value="<?= $value ?>">		
<?	}
?>

<input type="hidden" id="DriversPrice" name="DriversPrice" value="">
<input type="hidden" id="Price" name="Price" value="">
<input type="hidden" id="VehicleCapacity" name="VehicleCapacity" value="">

</form>



























