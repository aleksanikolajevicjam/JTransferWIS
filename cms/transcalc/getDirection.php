<?
	$longt1=20.2825144;
	$latt1=44.8154033;

	$longt2=19.8144217;
	$latt2=45.2715065;

	$url='https://api.openrouteservice.org/v2/directions/driving-car?api_key=5b3ce3597851110001cf6248ec7fafd8eca44e0ca5590caf093aa7cb&start='.$longt1.','.$latt1.'&end='.$longt2.','.$latt2;		
	$json = file_get_contents($url);   
	$obj="";
	$obj = json_decode($json,true);					
	


	
	if ($json) {
		
	 echo $distance=($obj['features'][0]['properties']['segments'][0]['distance'])/1000;
	 echo "<br>";
	 echo $duration=($obj['features'][0]['properties']['segments'][0]['duration'])/3600;
	}	 



