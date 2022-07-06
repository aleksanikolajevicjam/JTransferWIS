<?
	error_reporting(0); 
	$root='/home/jamtrans/laravel/public/cms.jamtransfer.com';

	//require_once $root . '/db/db.class.php';
	require_once $root . '/db/v4_OrderDetails.class.php';	
	require_once $root . '/db/v4_Places.class.php';	
	require_once $root . '/db/v4_Flights.class.php';	

	$db = new DataBaseMysql();	
	$od = new v4_OrderDetails();
	$pl = new v4_Places();	
	$fl = new v4_Flights();
		
	//blok flight shedule
	$q = "SELECT DetailsID FROM v4_Flights"; 
	$r = $db->RunQuery($q);
	while ($t = $r->fetch_object()) {
		$details_arr.=$t->DetailsID.',';
	}	
	$details=substr($details_arr,0,-1);	
	$q = "SELECT DetailsID FROM v4_OrderDetails 
		  WHERE PickupDate >= NOW() - INTERVAL 1 DAY
		  AND TransferStatus < '6' 
		  AND TransferStatus != '3' 
		  AND TransferStatus != '4' 
		  AND DetailsID not in (".$details.")"; 
	$r = $db->RunQuery($q);
	while ($t = $r->fetch_object()) {
		
		//$where = " WHERE DetailsID=".$t->DetailsID;
		//$flKeys = $fl->getKeysBy('FlightID', '', $where);
		$flKeys=array();
		if (count($flKeys)==0) {
			$od->getRow($t->DetailsID);
			$direct='ptp';	
			$pl->getRow($od->PickupID);
			if ($pl->PlaceType==1) {
				$direct='arriving';
			}	
			else {
				$pl->getRow($od->DropID);	
				if ($pl->PlaceType==1) $direct='departing';
			}	
			if ($direct!='ptp') {
				$Date=$od->PickupDate;
				$Date=explode('-',$Date);
				if (isset($od->FlightNo)) $fglightno=$od->FlightNo;
				$fglightno=str_replace(' ','',$fglightno);
				$fglightno=str_replace('-','',$fglightno);
				if (is_numeric(substr($fglightno, 2, 2))) {	
					$cc = substr($fglightno, 0, 2);  	
					$fn = substr($fglightno, 2);  	
				}
				else {
					$cc = substr($fglightno, 0, 3);  	
					$fn = substr($fglightno, 3);  			
				}	
				if ($cc=='EZY') $cc='U2';
				if ($cc=='EZS') $cc='U2';
				if ($cc=='EJU') $cc='U2';
				$cc=strtoupper($cc);
				
				$year=$Date[0];
				$month=$Date[1];
				$day=$Date[2];
				

				$link='https://api.flightstats.com/flex/schedules/rest/v1/json/flight/'.$cc.'/'.$fn.'/'.$direct.'/'.$year.'/'.$month.'/'.$day.'?appId=bd541bf0&appKey=4c4c2fdf1dc3d5d67e489c222f17e380';
				$json = file_get_contents($link); 
				$obj = json_decode($json,true);	
				if (isset($obj['scheduledFlights'][0]['carrierFsCode'])) {
					$DetailsID=$t->DetailsID;
					$FlightNo=$cc.$fn;
				
					$DepartureCode=$obj['scheduledFlights'][0]['departureAirportFsCode'];
					$FirstCode=$obj['appendix']['airports'][0]['fs'];
					if($DepartureCode==$FirstCode) {
						$FromAirP=$obj['appendix']['airports'][0]['city'];
						$ToAirP=$obj['appendix']['airports'][1]['city'];
					}
					else {
						$FromAirP=$obj['appendix']['airports'][1]['city'];
						$ToAirP=$obj['appendix']['airports'][0]['city'];						
					}	
					$Departure=clearTime($obj['scheduledFlights'][0]['departureTime']);
					$Arrival=clearTime($obj['scheduledFlights'][0]['arrivalTime']);
					$fl->setDetailsID($DetailsID);
					$fl->setFlightNo($FlightNo);
					$fl->setFromAirP($FromAirP);
					$fl->setToAirP($ToAirP);
					$fl->setDeparture($Departure);
					$fl->setArrival($Arrival);
					$fl->SaveAsNew();
				}
				else {
						
				}	
			}
		}	
	}
	
	// block flightID
	$q = 	"SELECT v4_Flights.*,PickupDate,PickupID FROM `v4_Flights`,v4_OrderDetails 
			WHERE v4_Flights.DetailsID=v4_OrderDetails.DetailsID
			AND FlightStatID = 0
			AND PickupDate >= NOW() - INTERVAL 1 DAY
			AND PickupDate <= NOW() + INTERVAL 2 DAY";
			
	$r = $db->RunQuery($q);
	while ($t = $r->fetch_object()) {	

		$Date=$t->PickupDate;
		$Date=explode('-',$Date);
		$year=$Date[0];
		$month=$Date[1];
		$day=$Date[2];
		$pl->getRow($t->PickupID);
		if ($pl->PlaceType==1) $direct='arr';	
		else $direct='dep';
		$cc = substr($t->FlightNo, 0, 2);  	
		$fn = substr($t->FlightNo, 2);  	
		
		$link2='https://api.flightstats.com/flex/flightstatus/rest/v2/json/flight/tracks/'.$cc.'/'.$fn.'/'.$direct.'/'.$year.'/'.$month.'/'.$day.'?appId=bd541bf0&appKey=4c4c2fdf1dc3d5d67e489c222f17e380&utc=false&includeFlightPlan=false&maxPositions=2';
		$json2 = file_get_contents($link2); 
		$obj2 = json_decode($json2,true);	
		if (isset($obj2['flightTracks'][0]['flightId'])) {
			$fl->getRow($t->FlightID);
			$FlightStatID=$obj2['flightTracks'][0]['flightId'];
			$fl->setFlightStatID($FlightStatID);
			
			/*$link2='https://api.flightstats.com/flex/flightstatus/rest/v2/json/flight/status/'.$FlightStatID.'?appId=bd541bf0&appKey=4c4c2fdf1dc3d5d67e489c222f17e380';	
			$json2 = file_get_contents($link2); 
			$obj2 = json_decode($json2,true);	
			if (isset($obj2['flightStatus']['operationalTimes'])) {
				$Departure=clearTime($obj2['flightStatus']['operationalTimes']['publishedDeparture']['dateLocal']);
				$Arrival=clearTime($obj2['flightStatus']['operationalTimes']['publishedArrival']['dateLocal']);
				$fl->setDeparture($Departure);
				$fl->setArrival($Arrival);
			}*/

			$fl->SaveRow();
		}
	}
	function clearTime($time) {
		$timeUF=explode('T',$time);
		$timeUF=explode(':',$timeUF[1]);
		return $timeUF[0].":".$timeUF[1];
	}	