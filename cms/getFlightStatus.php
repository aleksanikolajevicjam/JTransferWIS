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
	
	$q = "SELECT DetailsID FROM v4_Flights"; 
	$r = $db->RunQuery($q);
	while ($t = $r->fetch_object()) {
		$details_arr.=$t->DetailsID.',';
	}	
	$details=substr($details_arr,0,-1);	
	$q = "SELECT DetailsID FROM v4_OrderDetails 
		  WHERE PickupDate >= NOW() - INTERVAL 1 DAY
		  AND PickupDate <= NOW() + INTERVAL 3 DAY
		  AND TransferStatus < '6' 
		  AND TransferStatus != '3' 
		  AND TransferStatus != '4' 
		  AND DetailsID not in (".$details.")
		  AND DriverConfStatus != '3'"; 
	$r = $db->RunQuery($q);
	while ($t = $r->fetch_object()) {
		
		$where = " WHERE DetailsID=".$t->DetailsID;
		$flKeys = $fl->getKeysBy('FlightID', '', $where);
		if (count($flKeys)==0) {
			$od->getRow($t->DetailsID);
			$direct='ptp';	
			$pl->getRow($od->PickupID);
			if ($pl->PlaceType==1) {
				$direct='arr';
			}	
			else {
				$pl->getRow($od->DropID);	
				if ($pl->PlaceType==1) $direct='dep';
			}	
			if ($direct!='ptp') {
				$Date=$od->PickupDate;
				$Date=explode('-',$Date);
				if (isset($od->FlightNo)) $fglightno=$od->FlightNo;
				$fglightno=str_replace(' ','',$fglightno);
				if (is_numeric(substr($fglightno, 1, 1))) {
					$cc = substr($fglightno, 0, 1);  	
					$fn = substr($fglightno, 1);  	
				}
				else if (is_numeric(substr($fglightno, 2, 2))) {	
					$cc = substr($fglightno, 0, 2);  	
					$fn = substr($fglightno, 2);  	
				}
				else {
					$cc = substr($fglightno, 0, 3);  	
					$fn = substr($fglightno, 3);  			
				}	
				if ($cc=='EZY') $cc='U2';
				if ($cc=='EZS') $cc='U2';
				$cc=strtoupper($cc);
				
				$year=$Date[0];
				$month=$Date[1];
				$day=$Date[2];
				

				$link='https://api.flightstats.com/flex/flightstatus/rest/v2/json/flight/tracks/'.$cc.'/'.$fn.'/'.$direct.'/'.$year.'/'.$month.'/'.$day.'?appId=bd541bf0&appKey=4c4c2fdf1dc3d5d67e489c222f17e380&utc=false&includeFlightPlan=false&maxPositions=2';
				$json = file_get_contents($link); 
				//if (!$json) echo ($fglightno)."<br>";
				$obj = json_decode($json,true);	
				
				if (isset($obj['flightTracks'][0]['flightId'])) {

					$DetailsID=$t->DetailsID;
					$FlightNo=$cc.$fn;
					$FlightStatID=$obj['flightTracks'][0]['flightId'];
					$FromAirP=$obj['appendix']['airports'][0]['name'];
					$ToAirP=$obj['appendix']['airports'][1]['name'];
					$fl->setDetailsID($DetailsID);
					$fl->setFlightNo($FlightNo);
					$fl->setFlightStatID($FlightStatID);
					$fl->setFromAirP($FromAirP);
					$fl->setToAirP($ToAirP);
					
					$link2='https://api.flightstats.com/flex/flightstatus/rest/v2/json/flight/status/'.$FlightStatID.'?appId=bd541bf0&appKey=4c4c2fdf1dc3d5d67e489c222f17e380';	
					$json2 = file_get_contents($link2); 
					$obj2 = json_decode($json2,true);	
					if (isset($obj2['flightStatus']['operationalTimes'])) {
						$Departure=clearTime($obj2['flightStatus']['operationalTimes']['publishedDeparture']['dateLocal']);
						$Arrival=clearTime($obj2['flightStatus']['operationalTimes']['publishedArrival']['dateLocal']);
						$fl->setDeparture($Departure);
						$fl->setArrival($Arrival);
					}

					$fl->SaveAsNew();
				}
			}
		}	
	}
	function clearTime($time) {
		$timeUF=explode('T',$time);
		$timeUF=explode(':',$timeUF[1]);
		return $timeUF[0].":".$timeUF[1];
	}	