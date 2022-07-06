<?
	require_once ROOT . '/sessionThingy.php';
//session_start();
error_reporting(E_PARSE);

require_once ROOT . '/LoadLanguage.php';
require_once ROOT . '/db/db.class.php';
require_once ROOT . '/f2/f.php';

$db = new DataBaseMysql();

if(isset($_REQUEST['language'])) $_SESSION['language'] = $_REQUEST['language'];

//$lang = strtoupper(substr($_SESSION['language'],0,2));
$lang = Lang();

if( $lang == 'NB') $lang='NO';

//Blogit($_SESSION);


//$fromName = $_SESSION['lastElement'];
$fID = $_REQUEST['fID'];
$tID = $_REQUEST['tID'];
$tLongitude = $_REQUEST['tLongitude'];
$tLatitude = $_REQUEST['tLatitude'];
if(empty($fID) and isset($_SESSION['FromID']))
$fID = $_SESSION['FromID'];


	$places = array();

		# Routes for selected place
		$q1 = "SELECT DISTINCT RouteID, FromID, ToID FROM v4_DriverRoutes
					WHERE FromID = '{$fID}'
					OR    ToID   = '{$fID}'
					";
		$r1 = $db->RunQuery($q1);

		while($r = $r1->fetch_object())
		{

			# DriverRoutes - check if anyone drives from that Place
			//$q2 = "SELECT DISTINCT RouteID FROM v4_DriverRoutes
			//			WHERE RouteID = '{$r->RouteID}'
			//			";
			//$w2 = $db->RunQuery($q2);

			# If does
			//if  ($w2->num_rows > 0)
			//{

				$srch = explode(',' , trim($_REQUEST['qry']) );
				# Places in the Country
				$q  = "SELECT * FROM v4_Places ";
				$q .= " WHERE (PlaceID  = ".$r->FromID;
				$q .= " OR    PlaceID  = ".$r->ToID .") ";
				$q .= " AND (PlaceName".$lang." LIKE'%" .  $srch[0]. "%' ";
				$q .= " OR PlaceNameSEO LIKE'%" .  $srch[0]. "%') ";
				$q .= " ORDER BY PlaceName".$lang." ASC";

				$w = $db->RunQuery($q);

				while ($p = $w->fetch_object())
				{

					if($p->PlaceActive == '1') {
						# Do not repeat the From name
						if ($p->PlaceID != $fID and $p->PlaceActive == '1') {
							# Add Place to array
							$pnLang = 'PlaceName'. $lang;
							if(strlen($pnLang) == 9) $pnLang = 'PlaceNameEN';

							$placeName = mb_strtolower($p->$pnLang, 'UTF-8');

							// fix ako nema jezika
							if(empty($placeName)) $pnLang = 'PlaceNameEN';
							$placeName = mb_strtolower($p->$pnLang, 'UTF-8');

                            //$placeName .= ', ' . getPlaceCountryCode($p->PlaceCountry);
							$placeName .= ', ' . $p->CountryNameEN;

							# Add Place to array
							if (!in_array($placeName.'|'.$p->PlaceNameSEO,$places)) {
								array_push($placessearch,strtoupper($placeName));
								//$fromPlaces[$p->PlaceID] = trim($placeName) . '|' . trim($p->PlaceNameSEO);
								$places[trim($placeName)] = array(
																	'ID' => $p->PlaceID,
																	'PlaceNameSEO' => trim($p->PlaceNameSEO),
																	'PlaceType' => $p->PlaceType,
																	'Long' => $p->Longitude,
																	'Latt' => $p->Latitude,
																	'Country' => $p->Country

																);
							}
						}
					}
				}
			//}
		//}
			ksort($places);



			//unset($_SESSION['toPlaces']);

			//$_SESSION['toPlaces'] = $places;
			//unset($places);

			$rewriteCache = false;

		}

		if (strlen($srch[0])>2) {
			$api_key="5b3ce3597851110001cf6248ec7fafd8eca44e0ca5590caf093aa7cb";
			$layers="coarse";
			$source1="whosonfirst";
			$source2="geonames";
			
			$text=str_replace(" ","%20",$srch[0]);

			$url="https://api.openrouteservice.org/geocode/autocomplete?api_key=".$api_key."&start&layers=".$layers."&sources=".$source1.",".$source2."&text=".$text;

			$json = file_get_contents($url);   
			$obj="";
			$obj = json_decode($json,true);					
			
			if ($json) {	
				foreach ($obj['features'] as $placesX) {
					$placeNameL=strtoupper(trim($placesX['properties']['label']));
					$placeName=trim($placesX['properties']['name']);
					if (!in_array($placeNameL,$placessearch)) { 
						$long=$placesX['geometry']['coordinates'][0];
						$latt=$placesX['geometry']['coordinates'][1];
						$country=$placesX['properties']['country'];
						if ($tID>0) $distance=vincentyGreatCircleDistance($tLatitude, $tLongitude, $latt, $long, $earthRadius = 6371000);
						else $distance=0;
						if ($distance<500000) {
							$places[$placeNameL] = array(
															'ID' => 0,
															'PlaceNameSEO' => '',
															'PlaceType' => 0,
															'Long' => $long,
															'Latt' => $latt,
															'Country' => $country
														);
						}							
					}
				}
			}	
		}




$res = array();

foreach ($places as $key => $value)
{
    $res[] = array(
	'Place'=>mb_strtoupper($key,'UTF-8'),
    'ID'=>$value['ID'],
    'SEO' => $value['PlaceNameSEO'],
    'Type' => $value['PlaceType'],
	'Long' => $value['Long'],
	'Latt' => $value['Latt'],
	'Country' => $value['Country']
	);
}

if(!isset($_SESSION['noJson'])) {

$res = json_encode($res);
ob_start();
echo $_GET['callback'] . '(' . $res. ')';
ob_end_flush();

} else unset($_SESSION['noJson']);
/*
if ($rewriteCache) {
	// Save to Cache
	$jsonToPlaces = json_encode($res);
	//$filename = '../cache/toPlaces'.$fID.'.json';
	$handle = fopen($filename, "w");
	$contents = fwrite($handle, $jsonToPlaces);
	fclose($handle);
	// ************
}
*/
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
