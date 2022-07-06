<?
	$link='https://api.giscloud.com/rest/1/drivers.json?api_key=4a27e4227a88de0508aa9fa2e4c57144&app_instance_id=107495';
	$json = file_get_contents($link); 
	$obj = json_decode($json,true);	
	
	$excl_arr=array('devtype','client_id','company_id','note','fuel_tank_litres','expenses_per_h','expenses_per_km',
					'device_id','custom_options','gps_device_id','last_change_time',
					'satellites','app_instance_owner_id','last_active_time');
	$excl_arr=array('');
	echo "<table>";		
	foreach ($obj['data'][0] as $key=>$o) {
		if (!in_array($key, $excl_arr)) {
			echo "<th>";
			echo $key;	
			echo "</th>";	
		}	
	}	
	foreach ($obj['data'] as $o1) {
		echo "<tr>";
		foreach ($o1 as $key=>$o2) {
			if (!in_array($key, $excl_arr)) {
				echo "<td>";
				echo $o2;
				echo "</td>";
			}
		}
		echo "</tr>";
	}	
	echo "</table>";
	