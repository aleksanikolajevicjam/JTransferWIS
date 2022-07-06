<?


	writeProgress("Job Started: ".date("Y-m-d H:i:s")."\n");
	
	require_once '../../db/db.class.php';

		
	$db = new DataBaseMysql();

	$i = 0;
	$total = $db->TotalOfRows('v4_Routes');
	$jobStarted = 'Job Started: '. date("Y-m-d H:i:s");
	
	$q = "SELECT * FROM v4_Routes ORDER BY RouteID ASC";
	$w = $db->RunQuery($q);
	

	
	while( $r = $w->fetch_object() ) {
				
		$i++;
		
		$from 	= getPlaceName($r->FromID);
		$to 	= getPlaceName($r->ToID);
		$routeName = $from . ' - ' . $to;
		
		$qUpd = "	UPDATE v4_Routes 
					SET 
					RouteName   = '" . $db->real_escape_string($routeName) . "', 
					RouteNameEN = '" . $db->real_escape_string($routeName) . "' 
					WHERE RouteID = '".$r->RouteID ."'";

		$u = $db->RunQuery($qUpd);

		if($u == TRUE) {
			$qUpdDR = "	UPDATE v4_DriverRoutes 
						SET 
						RouteName   = '" . $db->real_escape_string($routeName) . "', 
						RouteNameEN = '" . $db->real_escape_string($routeName) . "' 
						WHERE RouteID = '".$r->RouteID ."'";
			
			$uDR = $db->RunQuery($qUpdDR);
			
			if($uDR != TRUE) writeProgress("DriverRoute update on ".$r->RouteID." failed.\n");
			//else fwrite($fp, $r->RouteID.", ");	
			
		} else {
			writeProgress("Route update on ".$r->RouteID." failed.\n");
			die;
		}


		writeProgress("Processed " . $i . ' of ' . $total);

							
	}//end while $r
	
 	writeProgress('Completed.'.date("Y-m-d H:i:s")."\n");
	
	
	
function getPlaceName ($placeID) {
	require_once '../../db/db.class.php';
	$db = new DataBaseMysql();
	
	$placeID = $db->real_escape_string($placeID);
	
	$q  = " SELECT * FROM v4_Places ";
	$q .= " WHERE PlaceID = '{$placeID}'";

	$w = $db->RunQuery($q);
	$c = mysqli_fetch_object($w);

	$name = 'PlaceNameEN';
	
	$PlaceName = $c->$name; // $c->{$name};
	$db->CloseMysql();

	return $PlaceName;	
}

function writeProgress($what) {
	global $jobStarted;
	$fp = fopen('progress.txt', 'w');	
	fwrite($fp, $jobStarted.' '.$what);
	fclose($fp);	
}	
