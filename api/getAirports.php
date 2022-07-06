<?
session_start();
require_once ROOT . '/f2/f.php';

$lang = Lang();
/*
	// reset
	$_SESSION['CountryID'] = '';
	$_SESSION['FromID'] = '';
	$_SESSION['ToID'] = '';
	$_SESSION['fromName'] = '';
	$_SESSION['fromPlaces'] = array();
*/

//$filename = ROOT . "/cache/airports".$lang.".json";
/*
if (file_exists($filename)) {

	$handle = fopen($filename, "r");
	$contents = fread($handle, filesize($filename));
	fclose($handle);
	$noBrackets = str_replace('(','',$contents);
	$contents = str_replace(')','',$noBrackets);
	$jsonArray = json_decode($contents, true);

	unset($_SESSION['fromPlaces']);
	foreach ($jsonArray as $key => $value)
	{
		$_SESSION['fromPlaces'][$key] = $value;
	}
	
}

else {
*/
	require_once ROOT . '/db/db.class.php';
	$db = new DataBaseMysql();



	$fromPlaces = array();

	# save variables for later usage
//	$_SESSION['countryID'] = array_search(str_replace('_',' ',$_SESSION['lastElement']), $_SESSION['countries']);
//	$cID = $_SESSION['countryID'];
//	$_SESSION['countryName'] = $_SESSION['countries'][$cID];




	# Places in the Country
	$q  = "SELECT * FROM v4_Places ";
	$q .= " WHERE (PlaceType = '1'";
	$q .= " OR PlaceType = '3'";
	$q .= " OR PlaceType = '6'";
	$q .= " OR PlaceType = '8'";
	$q .= " OR PlaceType = '9')";
	$q .= " AND PlaceActive= '1'";	
	$q .= " ORDER BY PlaceType, PlaceName".Lang()." ASC";

	$w = $db->RunQuery($q);

	while($p = mysqli_fetch_object($w))
	{
		# Routes for selected place
		/*
		$q1 = "SELECT FromID, ToID, RouteID FROM v4_Routes
					WHERE FromID = '{$p->PlaceID}'
					OR    ToID   = '{$p->PlaceID}'
					";
		$r1 = $db->RunQuery($q1);

		while($r = mysqli_fetch_object($r1))
		{
		*/
		
			# DriverRoutes - check if anyone drives from that Place
			$q2 = "SELECT * FROM v4_DriverRoutes
					WHERE FromID = '{$p->PlaceID}'
					OR    ToID   = '{$p->PlaceID}'
						";
			$w2 = $db->RunQuery($q2);
		
			# If does
			if  (mysqli_num_rows($w2) > 0)
			{
				if($p->PlaceActive == '1') {
					# Add Place to array
			    	$pnLang = 'PlaceName'. $lang;
			    	if(strlen($pnLang) == 9) $pnLang = 'PlaceNameEN';
			    
				    $placeName = strtolower($p->$pnLang);
				    
				    // fix ako nema jezika
				    if(empty($placeName)) $pnLang = 'PlaceNameEN';
				    $placeName = strtolower($p->$pnLang);			
                    
                    $placeName .= ', ' . getPlaceCountryCode($p->PlaceCountry);
					
					# Add Place to array
					if (!in_array($placeName . '|'.$p->PlaceNameSEO,$fromPlaces)) {
						//$fromPlaces[$p->PlaceID] = trim($placeName) . '|' . trim($p->PlaceNameSEO);
						$fromPlaces[trim($placeName)] = array(
															'ID' => $p->PlaceID,
															'PlaceNameSEO' => trim($p->PlaceNameSEO),
															'PlaceType' => $p->PlaceType
														);
					}
				}
			}						
		//}
	

	//}

	ksort($fromPlaces);
	//$_SESSION['fromPlaces'] = $fromPlaces;
	//$jsonFromPlaces = json_encode($fromPlaces);

	//$handle = fopen($filename, "w");
	//$contents = fwrite($handle, $jsonFromPlaces);
	//fclose($handle);
	//unset($fromPlaces);
}	
