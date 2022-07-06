<?
	require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_OrderDetails.class.php';	
	$od = new v4_OrderDetails();
	$od->getRow($_REQUEST['detailsid']);
exit($od->OrderID);
	if (isset($_REQUEST['fn'])) $fglightno=$_REQUEST['fn'];
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
	
	$year=(date('Y',time()));
	$month=(date('m',time()));
	$day=(date('d',time()));
	

	$link='https://api.flightstats.com/flex/flightstatus/rest/v2/json/flight/tracks/'.$cc.'/'.$fn.'/arr/'.$year.'/'.$month.'/'.$day.'?appId=bd541bf0&appKey=4c4c2fdf1dc3d5d67e489c222f17e380&utc=false&includeFlightPlan=false&maxPositions=2';
	$json = file_get_contents($link); 
	$obj = json_decode($json,true);	
	
	print_r(array_keys($obj['flightTracks'][0]));
	//exit();
	if (isset($obj['flightTracks'][0]['flightId'])) {

		echo $DetailID='1';
		echo "<br>";
		echo $FlightNO=$cc.$fn;
		echo "<br>";
		echo $FlightID=$obj['flightTracks'][0]['flightId'];
		echo "<br>";		
		echo $From=$obj['appendix']['airports'][0]['name'];
		echo "<br>";		
		echo $To=$obj['appendix']['airports'][1]['name'];
		echo "<br>";		
		
	}