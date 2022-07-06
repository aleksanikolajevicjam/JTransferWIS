<? 

	error_reporting(E_PARSE);
	@session_start();
	require_once ROOT . '/f/f.php';
	require_once ROOT . '/LoadLanguage.php';
	require_once ROOT . '/f/f.php';
	require_once ROOT . '/db/db.class.php';
	require_once ROOT . '/db/v4_Services.class.php';
	require_once ROOT . '/db/v4_Places.class.php';
	require_once ROOT . '/db/v4_Routes.class.php';
	require_once ROOT . '/db/v4_DriverRoutes.class.php';
	require_once ROOT . '/db/v4_AuthUsers.class.php';
	require_once ROOT . '/db/v4_Vehicles.class.php';
	require_once ROOT . '/db/v4_VehicleTypes.class.php';
	require_once ROOT . '/db/v4_DriverPrices.class.php';
	require_once ROOT . '/db/v4_OrderDetails.class.php';

	$db = new DataBaseMysql();
	$s 	= new v4_Services();
	$pl = new v4_Places();
	$r 	= new v4_Routes();
	$dr = new v4_DriverRoutes();
	$au = new v4_AuthUsers();
	$v	= new v4_Vehicles();
	$vt = new v4_VehicleTypes();
	$dp = new v4_DriverPrices();
	$od = new v4_OrderDetails();
	// LANGUAGES
	if ( isset($_SESSION['CMSLang']) and $_SESSION['CMSLang'] != '') {
		$languageFile = ROOT.'/lng/' . $_SESSION['CMSLang'] . '_text.php';
		if ( file_exists( $languageFile) ) require_once $languageFile;
		else {
			$_SESSION['CMSLang'] = 'en';
			require_once ROOT.'/lng/en.php';
		} 
	}
	else {
		$_SESSION['CMSLang'] = 'en';
		require_once ROOT.'/lng/en.php';
	}

	define("DEBUG", 0);
	define("SITE_CODE", '2');
	define("B", ' ');
	define("BD", ': ');
	define("NL", '<br>');
	

 	// prikaz Km i Duration route
	$routeDetails = array();
	$detailsDesc = '';
	if(is('FromID') and is('ToID')) {
		$routeDetails = GetRouteDetails(s('FromID'), s('ToID'));
		if($routeDetails['Km'] > 0) $detailsDesc .= $routeDetails['Km'] .' km,';
		if($routeDetails['Duration'] > 0) $detailsDesc .= $routeDetails['Duration'] .' mins';
		if($detailsDesc != '') $detailsDesc = '<span><i class="fa fa-dashboard"></i> '.$detailsDesc.'</span>';
	}

	$FromID	= $_REQUEST['FromID'];
	$FromLatitude = $_REQUEST['FromLatitude'];
	$FromLongitude = $_REQUEST['FromLongitude'];
	$FromElevation = $_REQUEST['FromElevation'];
	$FromCountry = $_REQUEST['FromCountry'];
	$ToID 	= $_REQUEST['ToID'];
	$ToLatitude = $_REQUEST['ToLatitude'];
	$ToLongitude = $_REQUEST['ToLongitude'];
	$ToElevation = $_REQUEST['ToElevation'];
	$ToCountry = $_REQUEST['ToCountry'];
	$PaxNo	= $_REQUEST['PaxNo'];
	$Distance = $_REQUEST['Distance'];
	
	$terminalID=999999999;
	$TerminalName="";
	if ($FromLatitude==0 || $FromLongitude==0)
	{	
		$pl->getRow($FromID);
		$fromPlaceType=$pl->PlaceType;
		if ($pl->PlaceType==1) {
			$terminalID=$pl->PlaceID;
			$direct="Arrivals";
			$TerminalName=$pl->PlaceNameEN;
		}	
		$FromLatitude=$pl->Latitude;
		$FromLongitude=$pl->Longitude;		
		$FromElevation=$pl->Elevation;	
	}
	if ($FromLatitude==0 && $FromLongitude==0 && $FromID==0) exit ("NO DATA");
	
	
	if ($ToID!=0) {
		$pl->getRow($ToID);	
		$toPlaceType=$pl->PlaceType;
		if ($pl->PlaceType==1) {
			$terminalID=$pl->PlaceID;
			$direct="Departure";
			$TerminalName=$pl->PlaceNameEN;
		}	
		$ToLatitude=$pl->Latitude;
		$ToLongitude=$pl->Longitude;			
	}		
	$api_key="5b3ce3597851110001cf6248ec7fafd8eca44e0ca5590caf093aa7cb";
	$url="https://api.openrouteservice.org/elevation/point?api_key=".$api_key."&geometry=".$FromLongitude.",".$FromLatitude;			
	$json = file_get_contents($url);   
	$obj="";
	$obj = json_decode($json,true);
	if ($json)  $FromElevation=$obj['geometry']['coordinates'][2];	
	else $ToElevation=-9999;
	$url="https://api.openrouteservice.org/elevation/point?api_key=".$api_key."&geometry=".$ToLongitude.",".$ToLongitude;			
	$json = file_get_contents($url);   
	$obj="";
	$obj = json_decode($json,true);
	if ($json) $ToElevation=$obj['geometry']['coordinates'][2];	
	else $ToElevation=-9999;
	if ($FromElevation>-9999 && $ToElevation>-9999) $ElevationDiff=nf($ToElevation-$FromElevation,2);
	else $ElevationDiff="N/A";
	
	
	if ($ToLatitude==0 && $ToLongitude==0 && $ToID==0) exit ("NO DATA");
	

	
	if ($terminalID==999999999) {
		$plKeys = $pl->getKeysBy('PlaceID','asc',"WHERE (PlaceType=1 and Longitude<>0 and Latitude<>0)"); 
		$dMin=9999999;
		foreach($plKeys as $pli => $id) {
			$pl->getRow($id);
			$dFrom=vincentyGreatCircleDistance($pl->Latitude, $pl->Longitude, $FromLatitude, $FromLongitude, $earthRadius = 6371000);
			$dTo=vincentyGreatCircleDistance($pl->Latitude, $pl->Longitude, $ToLatitude, $ToLongitude, $earthRadius = 6371000);
			/*if ($dFrom<$dTo) $dMinP=$dFrom;
			else $dMinP=$dTo;*/
			$dMinP=$dFrom+$dTo;  
			if ($dMinP<$dMin && $dMinP<400000 && ($ToCountry==$pl->CountryNameEN || $FromCountry==$pl->CountryNameEN)) {
				$dMin=$dMinP;
				$terminalID=$id;
				$TerminalName=$pl->PlaceNameEN;
			}
				
		}
	}	
	if ($terminalID==999999999) exit ("NO DATA");

	$airdistance=vincentyGreatCircleDistance($FromLatitude, $FromLongitude, $ToLatitude, $ToLongitude, $earthRadius = 6371000)/1000;
	
	$transferDate 	= $_REQUEST['transferDate'];
	$transferTime 	= $_REQUEST['transferTime'];
	// broj transfera na taj dan
	$odKeys = $od->getKeysBy('OrderID','asc',"WHERE (PickupID = {$terminalID} OR DropID = {$terminalID}) AND PickupDate = '{$transferDate}' AND TransferStatus not in (3,9)");
	$numberTfuture=count($odKeys);
	
	
	
	$pastDate=lastYearDate($transferDate);
	$odKeys = $od->getKeysBy('OrderID','asc',"WHERE (PickupID = {$terminalID} OR DropID = {$terminalID}) AND PickupDate = '{$pastDate}' AND TransferStatus not in (3,9)");
	$numberTpast=count($odKeys);

	$cars = array(); // podaci o vozilima 
	$drivers = array(); // podaci o vozacima
	# check if such route exists
	$routesKeys = $r->getKeysBy('RouteID','asc',"WHERE (FromID = {$FromID} AND ToID = {$ToID}) OR (FromID = {$ToID} AND ToID = {$FromID})");

	$api_key="5b3ce3597851110001cf6248ec7fafd8eca44e0ca5590caf093aa7cb";
	$url='https://api.openrouteservice.org/v2/directions/driving-car?api_key='.$api_key.'&start='.$FromLongitude.','.$FromLatitude.'&end='.$ToLongitude.','.$ToLatitude;		
	

	if (count($routesKeys)==1) {
		$r->getRow($routesKeys[0]);
		$id=$r->getRouteID();
		$Km=$r->getKm();
		$Duration = $r->getDuration();

		if ($Km==0 || $Duration==0) {
			$json = file_get_contents($url);   
			$obj="";
			$obj = json_decode($json,true);				 	
			if ($json) {
				 if ($Km==0) $Km=($obj['features'][0]['properties']['segments'][0]['distance'])/1000;
				 if ($Duration==0) $Duration=nf(($obj['features'][0]['properties']['segments'][0]['duration'])/60);
			}
		}
		$roaddistance = nf($Km);
		$drWhere = "WHERE RouteID = {$id} AND Active = '1'";

		require 'routePanel.php';		
		$driverRouteKeys = $dr->getKeysBy('OwnerID', "ASC", $drWhere);
		foreach($driverRouteKeys as $dri => $rowId) {
			
			if($dr->getRow($rowId)===false) break;
			$OwnerID = $dr->getOwnerID();
			if($au->getRow($OwnerID)===false) break;
			$DriverCompany = $au->getAuthUserCompany();
			if($au->getImage() == '') $ProfileImage = 'i/noImage.png';
			$serviceKeys = $s->getKeysBy("ServiceID", "ASC", "WHERE RouteID = {$id} AND OwnerID = {$OwnerID} AND Active = '1'");
				
			foreach($serviceKeys as $si => $sId) {
				$s->getRow($sId);
				$ServiceID = $s->getServiceID();
				$ServicePrice	=$s->getServicePrice1();	
				$PriceKM 		= $v->getPriceKM();
				$ServicePriceCalc = $PriceKM*$Km;	
				$OwnerID		=	$s->getOwnerID();				
				$v->getRow($s->getVehicleID());
				$DriverRouteID	=$dr->getID();				
				$SurCategory 	= $s->getSurCategory();
				$DRSurCategory 	= $dr->getSurCategory();
				require 'carPanel.php';
				
			} // end foreach services
		} // end foreach DriverRoutes
	}
	else {
		$json = file_get_contents($url);   
		$obj="";
		$obj = json_decode($json,true);					
		if ($json) {
			 $Km=($obj['features'][0]['properties']['segments'][0]['distance'])/1000;
			 $Duration=nf(($obj['features'][0]['properties']['segments'][0]['duration'])/60);
		}		
		$roaddistance = nf($Km);

		require_once 'routePanel.php';		
		require_once ROOT . '/db/v4_DriverTerminals.class.php';
		$dt = new v4_DriverTerminals();
		$whereT="WHERE TerminalID=".$terminalID;
		$dtKeys = $dt->getKeysBy('ID','asc',$whereT);
		foreach($dtKeys as $dti => $id) {	
			$dt->getRow($id);
			$au->getRow($dt->DriverID);
			$DriverCompany = $au->getAuthUserCompany();
			$OwnerID=$dt->DriverID;
			$whereV="WHERE OwnerID=".$dt->DriverID;				
			$vehicleKeys = $v->getKeysBy("VehicleID", "ASC", $whereV);	
			foreach($vehicleKeys as $vi => $id) {
				$v->getRow($id);
				$vt->getRow($v->VehicleTypeID);				
				$PriceKM 		= $v->getPriceKM();				
				$ServicePriceCalc = $PriceKM*$Km;
				$ServicePrice = $ServicePriceCalc;		
				$ServiceID		=0;
				$DriverRouteID	=0;
				$SurCategory 	= 0;
				$DRSurCategory 	= 0;
				require 'carPanel.php';				
			}
		}
	}	

function ShowRatings($userId) {
	require_once ROOT . '/db/v4_Ratings.class.php';
	$r = new v4_Ratings();
	$r->getRow($userId);
	if($r->getVotes() > 0)	return $r->getAverage() / $r->getVotes();
	else return '0';	
}


// Dodavanje dogovorene provizije na osnovnu cijenu
function calculateBasePrice($price, $ownerid, $VehicleClass = 1) {
	global $db;
		$priceR = round($price, 2);
		# Driver
		$q = "SELECT * FROM v4_AuthUsers
					WHERE AuthUserID = '" .$ownerid."' 
					";
		$w = $db->RunQuery($q);
		$d = mysqli_fetch_object($w);
		if($d->AuthUserID == $ownerid) {
			// STANDARD CLASS
			if($VehicleClass < 11) {
				if ($priceR >= $d->R1Low and $priceR <= $d->R1Hi) return $price + ($price*$d->R1Percent / 100);
				else if ($priceR >= $d->R2Low and $priceR <= $d->R2Hi) return $price + ($price*$d->R2Percent / 100);
				else if ($priceR >= $d->R3Low and $priceR <= $d->R3Hi) return $price + ($price*$d->R3Percent / 100);
				else return $price;
			}
			// PREMIUM CLASS
			if($VehicleClass >= 11 and $VehicleClass < 21) {
				if ($price >= $d->PR1Low and $price <= $d->PR1Hi) return $price + ($price*$d->PR1Percent / 100);
				else if ($price >= $d->PR2Low and $price <= $d->PR2Hi) return $price + ($price*$d->PR2Percent / 100);
				else if ($price >= $d->PR3Low and $price <= $d->PR3Hi) return $price + ($price*$d->PR3Percent / 100);
				else return $price;
			}
			// FIRST CLASS
			if($VehicleClass >= 21) {
				if ($price >= $d->FR1Low and $price <= $d->FR1Hi) return $price + ($price*$d->FR1Percent / 100);
				else if ($price >= $d->FR2Low and $price <= $d->FR2Hi) return $price + ($price*$d->FR2Percent / 100);
				else if ($price >= $d->FR3Low and $price <= $d->FR3Hi) return $price + ($price*$d->FR3Percent / 100);
				else return $price;
			}
		}
		return '0';	
}

function getProvision($price, $ownerid, $VehicleClass = 1) {
	global $db;
		$priceR = round($price, 2);
		# Driver
		$q = "SELECT * FROM v4_AuthUsers
					WHERE AuthUserID = '" .$ownerid."' 
					";
		$w = $db->RunQuery($q);
		$d = mysqli_fetch_object($w);
		if($d->AuthUserID == $ownerid) {
		
			// STANDARD CLASS
			if($VehicleClass < 11) {
				if ($priceR >= $d->R1Low and $priceR <= $d->R1Hi) return $d->R1Percent;
				else if ($priceR >= $d->R2Low and $priceR <= $d->R2Hi) return $d->R2Percent;
				else if ($priceR >= $d->R3Low and $priceR <= $d->R3Hi) return $d->R3Percent;
				else return 0;
			}

			// PREMIUM CLASS
			if($VehicleClass >= 11 and $VehicleClass < 21) {
				if ($price >= $d->PR1Low and $price <= $d->PR1Hi) return $d->PR1Percent;
				else if ($price >= $d->PR2Low and $price <= $d->PR2Hi) return $d->PR2Percent;
				else if ($price >= $d->PR3Low and $price <= $d->PR3Hi) return $d->PR3Percent;
				else return 0;
			}

			// FIRST CLASS
			if($VehicleClass >= 21) {
				if ($price >= $d->FR1Low and $price <= $d->FR1Hi) return $d->FR1Percent;
				else if ($price >= $d->FR2Low and $price <= $d->FR2Hi) return $d->FR2Percent;
				else if ($price >= $d->FR3Low and $price <= $d->FR3Hi) return $d->FR3Percent;
				else return 0;
			}
		}
		return '0';	
}


function vehicleTypeName($vehicleTypeID) {
	require_once ROOT . '/db/db.class.php';
	$db = new DataBaseMysql();
	
	$w = $db->RunQuery("SELECT * FROM v4_VehicleTypes WHERE VehicleTypeID = '{$vehicleTypeID}'");
	$v = $w->fetch_object();

			    	$vehicleTypeName = 'VehicleTypeName'. Lang();
			    				    
				    $VehicleTypeName = strtolower($v->$vehicleTypeName);
	
	return $VehicleTypeName;
}

function isVehicleOffDuty($vehicleID, $transferDate, $transferTime) {
	$cnt = 0;
	require_once ROOT . '/db/db.class.php';
	$db = new DataBaseMysql();
	
	$r = $db->RunQuery("SELECT * FROM v4_OffDuty WHERE VehicleID = '".$vehicleID."' ORDER BY ID ASC");
	
	while($o = $r->fetch_object()) {

		if( inDateTimeRange($o->StartDate, $o->StartTime, $o->EndDate, $o->EndTime, $transferDate, $transferTime) ) {
			
			$cnt += 1;
		}
		
	}
	
	if($cnt >= 1) return true;
	else return false;
}

function calculateSpecialDates($OwnerID, $amount, $transferDate, $transferTime, $returnDate='', $returnTime='') {

    if( empty($OwnerID) or empty($amount) or empty($transferDate)  or empty($transferTime) ) return 0;

    require_once ROOT . '/db/v4_SpecialDates.class.php';
    $sd = new v4_SpecialDates();

    $add1 = 0;
    $add2 = 0;
    
    $keys = $sd->getKeysBy("ID", "ASC", " WHERE OwnerID = '" . $OwnerID ."'");
    if( count($keys) > 0) {
        foreach($keys as $nn => $ID) {
            $sd->getRow($ID);

            if( inDateTimeRange($sd->getSpecialDate(), $sd->getStartTime(), $sd->getSpecialDate(), $sd->getEndTime(), $transferDate, $transferTime) ) {
                $add1 = nf($amount * $sd->getCorrectionPercent() / 100);
            }
            
            if($returnDate != '' and $returnTime != '') {
                if( inDateTimeRange($sd->getSpecialDate(), $sd->getStartTime(), $sd->getSpecialDate(), $sd->getEndTime(), $returnDate, $returnTime) ) {
                    $add2 = nf($amount * $sd->getCorrectionPercent() / 100);
                }
            }
        }
    }
    // zbroji oba transfera
    return $add1 + $add2;
}

function calculateSpecialTimes($OwnerID, $VehicleTypeID, $amount, $transferDate, $transferTime, $returnDate='', $returnTime='') {

    if( empty($OwnerID) or empty($amount) or empty($transferDate)  or empty($transferTime) ) return 0;

    require_once ROOT . '/db/v4_SpecialTimes.class.php';
    $st = new v4_SpecialTimes();

    $add1 = 0;
    $add2 = 0;
	$keys = $st->getKeysBy("ID", "ASC", " WHERE OwnerID = '" . $OwnerID ."'");    
    if( count($keys) > 0) {
        foreach($keys as $nn => $ID) {
            $st->getRow($ID);

			$condition=true;
			if ($st->getVehicleTypeID()!=$VehicleTypeID && $st->getVehicleTypeID()>0) $condition=false; 
			if ($st->getStartSeason()>$transferDate) $condition=false; 
			if ($st->getEndSeason()<$transferDate && $st->getEndSeason()) $condition=false;
			$wa=explode(',',$st->getWeekDays());
			if (!in_array(date('w', strtotime($transferDate)),$wa) && $st->getWeekDays()) $condition=false; 	
			if ($st->getSpecialDate()!=$transferDate && $st->getSpecialDate()<>'') $condition=false; 
			if ($st->getStartTime()>$transferTime) $condition=false;
			if ($st->getEndTime()<$transferTime && $st->getEndTime()) $condition=false;
			if ($condition) $add1 = nf($amount * $st->getCorrectionPercent() / 100);

            if($returnDate != '' and $returnTime != '') {
				$condition=true;
				if ($st->getStartSeason()>$returnDate) $condition=false; 
				if ($st->getEndSeason()<$returnDate) $condition=false;
				$wa=explode(',',$st->getWeekDays());
				if (!in_array(date('w', strtotime($returnDate)),$wa) && $st->getWeekDays()) $condition=false; 	
				if ($st->getSpecialDate()!=$returnDate && $st->getSpecialDate()<>'') $condition=false; 
				if ($st->getStartTime()>$returnTime) $condition=false;
				if ($st->getEndTime()<$returnTime) $condition=false;
				if ($condition) $add2 = nf($amount * $st->getCorrectionPercent() / 100);
			}
		}
	}
    // zbroji oba transfera
    return $add1 + $add2;
}

function calculateDriversPriceNetto($OwnerID, $SurCategory, $ServicePrice, 
				  $transferDate, $transferTime, 
				  $returnDate, $returnTime, 
				  $DriverRouteID, $VehicleID, $ServiceID,
				  $VSurCategory, $DRSurCategory
				  ) {
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


	$DriversPrice = $ServicePrice + $addToPrice;
	
	return $DriversPrice;
}	

function calculateBasePrice2 ($OwnerID, $SurCategory, $ServicePrice, $transferDate, $transferTime, $returnDate, $returnTime, 
				  $DriverRouteID, $VehicleID, $VehicleTypeID,$VehicleClass, $ServiceID,$VSurCategory, $DRSurCategory) {
	
	$DriversPriceNetto=calculateDriversPriceNetto($OwnerID, $SurCategory, $ServicePrice, 
				  $transferDate, $transferTime, 
				  $returnDate, $returnTime, 
				  $DriverRouteID, $VehicleID, $ServiceID,
				  $VSurCategory, $DRSurCategory
				  ) ;
	$specialTimesPrice = calculateSpecialTimes($OwnerID,$VehicleTypeID,$DriversPriceNetto,$transferDate, $transferTime);
	$DriversPrice = $DriversPriceNetto + $specialTimesPrice;		
		
	$Provision = getProvision($DriversPrice, $OwnerID, $VehicleClass);
	$BasePrice2 = (1+$Provision/100)*$DriversPrice;
	return $BasePrice2;			  
}			  
function getCarImage ($VehicleClass) {
	if ($VehicleClass == '1') $vehicleImageFile = '/i/cars/sedan.jpg';
	else if ($VehicleClass == '2') $vehicleImageFile = '/i/cars/minivanl.jpg';
	else if ($VehicleClass == '3') $vehicleImageFile = '/i/cars/minibusl.jpg';
	else if ($VehicleClass == '4') $vehicleImageFile = '/i/cars/minibusl.jpg';	
	else if ($VehicleClass == '5' or $VehicleClass == '6') 	$vehicleImageFile = '/i/cars/bus.jpg';	

	else if ($VehicleClass == '11') $vehicleImageFile = '/i/cars/sedan_p.jpg';
	else if ($VehicleClass == '12') $vehicleImageFile = '/i/cars/minivans_p.jpg';
	else if ($VehicleClass == '13') $vehicleImageFile = '/i/cars/minivans_p.jpg';
	else if ($VehicleClass == '14') $vehicleImageFile = '/i/cars/minibusl_p.jpg';	
	else if ($VehicleClass == '15' or $VehicleClass == '16') 	$vehicleImageFile = '/i/cars/bus_p.jpg';							

	else if ($VehicleClass == '21') $vehicleImageFile = '/i/cars/sedan_l.jpg';
	else if ($VehicleClass == '22') $vehicleImageFile = '/i/cars/minivans_l.jpg';
	else if ($VehicleClass == '23') $vehicleImageFile = '/i/cars/minivanl_l.jpg';
	else if ($VehicleClass == '24') $vehicleImageFile = '/i/cars/minibusl_l.jpg';	
	else if ($VehicleClass == '25' or $VehicleClass == '26') 	$vehicleImageFile = '/i/cars/bus_l.jpg';
	
	return$VehicleImageRoot.$vehicleImageFile;
}	

function vincentyGreatCircleDistance(
  $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
{
  // convert from degrees to radians
  $latFrom = deg2rad($latitudeFrom);
  $lonFrom = deg2rad($longitudeFrom);
  $latTo = deg2rad($latitudeTo);
  $lonTo = deg2rad($longitudeTo);

  $lonDelta = $lonTo - $lonFrom;
  $a = pow(cos($latTo) * sin($lonDelta), 2) +
    pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
  $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

  $angle = atan2(sqrt($a), $b);
  return $angle * $earthRadius;
}

function lastYearDate($date) {
	$dayofweek = date('w', strtotime($date));
	$dayofyear = date('z', strtotime($date));
	$weekofyear = date('W', strtotime($date));
	$weekdayofyear = number_format($dayofyear/7,0);
	$lastyearday=date('Y-m-d', strtotime($date. ' -365 days'));
	$lastyear=date('Y', strtotime($lastyearday));
	$lyfd=$lastyear."-01-01";
	$lastyearfirstday=date('w', strtotime($lyfd));
	$diff=$dayofweek-$lastyearfirstday;
	if ($diff<0) $diff=$diff+7;
	$diff=$diff+($weekofyear-1)*7;
	$period=" + ".$diff." days";
	$lastyearday=date('Y-m-d', strtotime($lyfd. $period));
	return $lastyearday;
}

function konv($res) {
	$ww=$res;  
	$ww=explode(' ',$ww);
	$xx=str_replace('°','',$ww[0]);
	//$dlat=preg_replace('/[^0-9]/', '', $ww[1])*60+preg_replace('/[^0-9]/', '', $ww[2]);
	$dxx=(str_replace("'","",$ww[1])*60+str_replace("''","",$ww[2]))/3600;
	if ($ww[3]=='S') $zxx=-1;
	else if ($ww[3]=='W') $zxx=-1;
	else $zxx=1;
	$xx=$zxx*($xx+$dxx);
	return $xx;	  
}	

?>
<script>
	$(".headerclick").click(function(){
		$(this).next().toggleClass( "hidden" );
	})
</script>	