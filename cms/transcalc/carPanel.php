<?
	$VSurCategory 	= $v->getSurCategory();
	$VehicleName	= vehicleTypeName( $v->getVehicleTypeID() );
	$VehicleTypeID 	= $v->getVehicleTypeID();
	$VehicleCapacity= $v->getVehicleCapacity();
	$VehicleID 		= $v->getVehicleID();
	$ReturnDiscount = $v->getReturnDiscount();
	$VehicleImageRoot = "https://" . $_SERVER['HTTP_HOST'];
	if ($VehicleCapacity > 15) $vehicleImageFile = '/i/cars/bus.png';
	$vt->getRow($VehicleTypeID);
	$VehicleClass   = $vt->getVehicleClass();												
	$VehicleDescription = $vt->getDescription();
	$VehicleImage=getCarImage($vt->getVehicleClass());
	$sur = array();
	$sur = Surcharges($OwnerID, $SurCategory, $ServicePrice, 
					  $transferDate, $transferTime, 
					  $returnDate, $returnTime, 
					  $DriverRouteID, $VehicleID, $ServiceID,
					  $VSurCategory, $DRSurCategory
					  );
					  
	$weekdayPrice =   
					$sur['MonPrice'] +
					$sur['TuePrice'] +
					$sur['WedPrice'] +
					$sur['ThuPrice'] +
					$sur['FriPrice'] +
					$sur['SatPrice'] + 
					$sur['SunPrice'];
	$seasonPrice =   
					$sur['S1Price'] +
					$sur['S2Price'] +
					$sur['S3Price'] +
					$sur['S4Price'] +
					$sur['S5Price'] +
					$sur['S6Price'] +
					$sur['S7Price'] +
					$sur['S8Price'] +
					$sur['S9Price'] +
					$sur['S10Price'];	
	$addToPrice =   
					$weekdayPrice +
					$seasonPrice +
					$sur['NightPrice'];									


	//$DriversPrice = $ServicePrice + $addToPrice;

	$DriversPriceNetto=calculateDriversPriceNetto($OwnerID, $SurCategory, $ServicePrice, 
					  $transferDate, $transferTime, 
					  $returnDate, $returnTime, 
					  $DriverRouteID, $VehicleID, $ServiceID,
					  $VSurCategory, $DRSurCategory
					  );
	//$specialDatesPrice = calculateSpecialDates($OwnerID,$DriversPrice,$transferDate, $transferTime);
	//$DriversPrice = $DriversPrice + $specialDatesPrice;	
	$specialTimesPrice = calculateSpecialTimes($OwnerID,$VehicleTypeID,$DriversPriceNetto,$transferDate, $transferTime);
	$DriversPrice = $DriversPriceNetto + $specialTimesPrice;		
		
	$Provision = getProvision($DriversPrice, $OwnerID, $VehicleClass);
	
	$BasePrice = calculateBasePrice($DriversPrice, $OwnerID, $VehicleClass);
	$BasePrice2 = (1+$Provision/100)*$DriversPrice;
	
	// blok za alternativne cene
	$spt_arr=array();
	if ($toPlaceType==1) $f=-1;
	else if ($fromPlaceType==1) $f=1;
	else $f=0;
	for ($i = 1; $i <= 5; $i++) {
		if ($f==0) $ib=$i-3;
		else $ib=$i;	
		$tt = date('H:i', strtotime($transferTime) + $f*$ib*60*60);
		$BasePriceALT = calculateBasePrice2 ($OwnerID, $SurCategory, $ServicePrice, $transferDate, $tt, $returnDate, $returnTime, 
					 $DriverRouteID, $VehicleID, $VehicleTypeID,$VehicleClass, $ServiceID,$VSurCategory, $DRSurCategory); 
		if ($BasePrice2>$BasePriceALT && $BasePriceALT>0 && !isVehicleOffDuty($VehicleID, $transferDate, $tt))	{		 
			$arr=array(
					'AltTime'=>$tt,
					'Price'=>$BasePriceALT
			);
			$spt_arr[]=$arr; 				
		}	
	}
	$spd_arr=array();
	for ($i = -3; $i <= 4; $i++) {	
		$td = date('Y-m-d', strtotime($transferDate) + $i*24*60*60);
		$BasePriceALT = calculateBasePrice2 ($OwnerID, $SurCategory, $ServicePrice, $td, $transferTime, $returnDate, $returnTime, 
					 $DriverRouteID, $VehicleID, $VehicleTypeID,$VehicleClass, $ServiceID,$VSurCategory, $DRSurCategory); 
		if ($BasePrice2>$BasePriceALT && $BasePriceALT>0 && !isVehicleOffDuty($VehicleID, $td, $transferTime))	{		 
			$arr=array(
					'AltDate'=>$td,
					'Price'=>$BasePriceALT
			);
			$spd_arr[]=$arr; 				
		}	
	}	
	
	// blok za alternativne cene
	/*require_once ROOT . '/db/v4_SpecialTimes.class.php';
    $st = new v4_SpecialTimes();
	$spt_arr=array();
	$where="WHERE 
		OwnerID = '" . $OwnerID ."' and 
		(SpecialDate = '".$transferDate."' or 
		(StartSeason <= '".$transferDate."' and EndSeason >= '".$transferDate."'))
	";
	$keys = $st->getKeysBy("StartTime", "ASC", $where);
    if( count($keys) > 0) {
        foreach($keys as $nn => $ID) { 

            $st->getRow($ID);
			$altPrice=($DriversPrice-$specialTimesPrice-$sur['NightPrice']) * (100+$st->getCorrectionPercent())/100;
			$altPrice = (1+$Provision/100)*$altPrice;			
			if (
					(($fromPlaceType==1 && $transferTime<$st->getStartTime()) ||
					($toPlaceType==1 && $transferTime>$st->getEndTime())) &&
					(nf($BasePrice2)>nf($altPrice) && nf($BasePrice2)!=nf($altPrice))
				)	
			{
				$arr=array(
						'Begin'=>$st->getStartTime(),
						'End'=>$st->getEndTime(),				
						'Percent'=>$st->getCorrectionPercent(),
						'Price'=>$altPrice
				);
				$spt_arr[]=$arr;
			} 
        }
    }*/	
	
	// zaokruzenje cijena
	$BasePrice = nf( round($BasePrice,2) );
	$BasePrice2 = nf( round($BasePrice2,2) );
	
	if ($BasePrice<>$BasePrice2) exit("Wrong calculation");
					
	if($au->getActive() == 0) $DriverActive="No";
	else $DriverActive="Yes";
	
	if(isVehicleOffDuty($VehicleID, $transferDate, $transferTime)) $OffDuty="Yes";
	else $OffDuty="No";
	
	$rating = ShowRatings($OwnerID);
	if      ($VehicleCapacity <= 3) $vehicleImage = '/i/cars/sedan.png';
	else if ($VehicleCapacity <= 4) $vehicleImage = '/i/cars/taxi.png';
	else if ($VehicleCapacity <= 8) $vehicleImage = '/i/cars/minivan.png';
	else if ($VehicleCapacity <= 16) $vehicleImage = '/i/cars/minibus.png';
	else if ($VehicleCapacity > 16) $vehicleImage = '/i/cars/bus.png';
	
	
	if ($BasePrice2==0 || $OffDuty=='Yes' || $DriverActive=="No") $color="orange";
	else $color="green";
		
	
	
?>				
<div class="row <?= $color?>">			
	<div  class="row headerclick">						
		<div class="col-md-4"><h5><img class="" src="<?= $VehicleImage ?>" style="max-height:20%; max-width:20%;" alt="car">
			<i><?= $VehicleName?></i></h5></div>	
		<div class="col-md-6"><h5><b><?= $DriverCompany?></b></h5></div>	
		<div class="col-md-2 right"><h5><b><?= $BasePrice2?></b></h5></div>	

	</div>
	<div id="card" class="row hidden">	
		<p class="divider clearfix"></p>
		<div class="col-md-3">
			<div class="row">	 
				<div class="col-md-6 right"> <?= $PriceKM ?></div>
				<div class="col-md-6 right"><strong>Price per kilometer:</strong></div>
			</div>
			<div class="row">	
				<div class="col-md-6 right"> N/A %</div>
				<div class="col-md-6 right"><strong>Coefficient:</strong></div>
			</div>		
			<p class="divider clearfix"></p>
			<div class="row">	
				<div class="col-md-6 right"> <?= $ServicePriceCalc ?></div>
				<div class="col-md-6 right"><strong>Service price:</strong></div>
			</div>								
		</div>	 

		<div class="col-md-3">
			<div class="row">	
				<div class="col-md-6 right"> <?= nf(toCurrency($weekdayPrice)) ?></div>
				<div class="col-md-6 right"><strong>Weekday price:</strong></div>
			</div>
			<div class="row">	
				<div class="col-md-6 right"> <?= nf(toCurrency($seasonPrice)) ?></div>
				<div class="col-md-6 right"><strong>Season price:</strong></div>
			</div>		
			<div class="row">	
				<div class="col-md-6 right">  <?= nf(toCurrency($sur['NightPrice'])) ?></div>
				<div class="col-md-6 right"><strong>Night price:</strong></div>
			</div>	
			<p class="divider clearfix"></p>
			<div class="row">	
				<div class="col-md-6 right">  <?= nf(toCurrency($addToPrice)) ?></div>
				<div class="col-md-6 right"><strong>Add to price:</strong></div>
			</div>								
		</div>	
		<div class="col-md-3">
			<div class="row">	
				<div class="col-md-6 right"> <?= nf(toCurrency($ServicePrice)) ?></div>
				<div class="col-md-6 right"><strong>Service price:</strong></div>
			</div>
			<div class="row">	
				<div class="col-md-6 right"> <?= nf(toCurrency($addToPrice)) ?></div>
				<div class="col-md-6 right"><strong>Add to price:</strong></div>
			</div>		
			<div class="row">	
				<div class="col-md-6 right">  <?= nf($ReturnDiscount) ?>%</div>
				<div class="col-md-6 right"><strong>Return discount:</strong></div>
			</div>	
			<div class="row">	
				<div class="col-md-6 right">  <?= nf(toCurrency($specialTimesPrice)) ?></div>
				<div class="col-md-6 right"><strong>Special price:</strong></div>
			</div>								
			<p class="divider clearfix"></p>
			<div class="row">	
				<div class="col-md-6 right"> <?= nf(toCurrency($DriversPrice)) ?></div>
				<div class="col-md-6 right"><strong>Driver's price:</strong></div>
			</div>					 			
		</div>						
		<div class="col-md-3">
			<div class="row">	
				<div class="col-md-6 right"> <?= nf(toCurrency($DriversPrice)) ?></div>							
				<div class="col-md-6 right"><strong>Driver's price:</strong></div>
			</div>
			<div class="row">
				<div class="col-md-6 right"> <?= nf($Provision) ?>%</div>
				<div class="col-md-6 right"><strong>Provision:</strong></div>
			</div>		
			<p class="divider clearfix"></p>
			<div class="row">
				<div class="col-md-6 right"><h5><b> <?= nf(toCurrency($BasePrice2)) ?></b></h5></div>							
				<div class="col-md-6 right"><strong>Final Price:</strong></div>															
			</div>			
		</div>			
		<p class="divider clearfix"></p>
		<div class="row">
		<div class="col-md-3">
			<strong>Alternative times and prices</strong>
		</div>
		<? foreach ($spt_arr as $value) { ?>
			<div class="col-md-1">
				<?= $value['AltTime']?><h5><b><?= nf($value['Price']) ?></b></h5>
			</div>
		<? } ?>
		</div>
		<p class="divider clearfix"></p>		
		<div class="row">
		<div class="col-md-3">
			<strong>Alternative dates and prices</strong>
		</div>
		<? foreach ($spd_arr as $value) { ?>
			<div class="col-md-1">
				<?= $value['AltDate']?><h5><b><?= nf($value['Price']) ?></b></h5>
			</div>
		<? } ?>
		</div>
		<p class="divider clearfix"></p>			
		<div class="col-md-4 right"><strong>Driver active:</strong> <?= $DriverActive ?></div>
		<div class="col-md-4 right"><strong>Off duty day:</strong> <?= $OffDuty ?></div>
		<div class="col-md-4 right"><strong>Raiting:</strong> <?= $rating ?></div>
	</div>						
</div>		

