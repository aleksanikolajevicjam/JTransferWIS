<?
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
	
	
	$year=(date('Y',time()));
	$month=(date('m',time()));
	$day=(date('d',time()));
	

	$link='https://api.flightstats.com/flex/flightstatus/rest/v2/json/flight/tracks/'.$cc.'/'.$fn.'/arr/'.$year.'/'.$month.'/'.$day.'?appId=bd541bf0&appKey=4c4c2fdf1dc3d5d67e489c222f17e380&utc=false&includeFlightPlan=false&maxPositions=2';
	$json = file_get_contents($link); 
	$obj = json_decode($json,true);	
	
	print_r(array_keys($obj['appendix']['airports'][0]));
	exit();
	if (isset($obj['flightTracks'][0]['flightId'])) {
		$flightId=$obj['flightTracks'][0]['flightId']; 
		$link2='https://api.flightstats.com/flex/flightstatus/rest/v2/json/flight/status/'.$flightId.'?appId=bd541bf0&appKey=4c4c2fdf1dc3d5d67e489c222f17e380';	
		$json2 = file_get_contents($link2); 
		$obj2 = json_decode($json2,true);	
		if (isset($obj2['flightStatus']['operationalTimes'])) {
			ob_start();
			echo '<h3>'.$obj2['appendix']['airports'][0]['city']." - ".$obj2['appendix']['airports'][1]['city'].'</h3>';
			echo "<table>";
			foreach ($obj2['flightStatus']['operationalTimes'] as $key=>$o) {
				echo "<tr>";
				echo "<th>".$key."</th>";
				echo "<td>".clearTime($o['dateLocal'])."</td>";
				echo "</tr>";		
			}
			echo "<tr><hr></tr>";			
			foreach ($obj2['flightStatus']['delays'] as $key=>$o) {
				echo "<tr>";		
				echo "<th><h4>".$key."</h4></th>";
				echo "<td><h4>".$o."</h4></td>";
				echo "</tr>";				
			}		
			
			echo "</table>";
			$message = ob_get_contents();
			ob_end_clean();
		}
		else $message='NO DATA';
	}
	else $message='NOT VALID FLIGHT';
	
	function clearTime($time) {
		$timeUF=explode('T',$time);
		$timeUF=explode(':',$timeUF[1]);
		return $timeUF[0].":".$timeUF[1];
	}
	echo $message;
	
