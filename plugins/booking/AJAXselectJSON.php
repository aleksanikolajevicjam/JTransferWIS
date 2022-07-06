<?
		$json = file_get_contents('https://city-airport-taxis.com/api/getAllBookingsConfirmedPast48?password=booki618cb7487c0697.64843243');
		$obj = json_decode($json,true);
		$cnt=count($obj['data']);
		$html="<option value='No'>No reference</option>";
		for ($i = 0; $i < $cnt; $i++) {
			$rr=$obj['data'][$i]['reservation_reference'];	
			$html.="<option value='".$rr."'>".$rr."</option>";
		}
		echo $html;
?>