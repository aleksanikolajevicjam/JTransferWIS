<?
@session_start();
error_reporting(E_PARSE);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once ROOT . '/db/db.class.php';
require_once ROOT . '/f2/f.php';

//Blogit($_SESSION);
$db = new DataBaseMysql();


$lang = Lang();
$fromPlaces = array();


$cID = $_REQUEST['cID'];

if( $lang == 'NB') $lang='NO';

//$filename = ROOT . '/cache/fromPlaces'.$cID.$lang.'.json';
//logit($filename);
$cachetime = 84600;

    $srch = explode(',' , trim($_REQUEST['qry']) );
	
	# Places in the Country
	$q  = " SELECT * FROM v4_Places ";
	$q .= " WHERE PlaceActive = '1'";
	$q .= " AND (PlaceName".$lang." LIKE'%" .  $srch[0]. "%' ";
	$q .= " OR PlaceNameSEO LIKE'%" .  $srch[0]. "%') ";
	//$q .= " AND Longitude>0 AND Lattitude>0 ";				
	$q .= " ORDER BY PlaceType,PlaceName".$lang;
	$w = $db->RunQuery($q);

	
	# DriverRoutes - check if anyone drives from that Place
	$q2 = "SELECT DISTINCT FromID, ToID FROM v4_DriverRoutes";
	
	$w2 = $db->RunQuery($q2);
	$from_arr=array();
	$to_arr=array();
	while($p2 = mysqli_fetch_object($w2))
	{
		$from_arr[]=$p2->FromID;
		$to_arr[]=$p2->ToID;
	}
			
//Blogit($lang);	
//Blogit($q);	

	$placessearch=array();

	while($p = mysqli_fetch_object($w))
	{
		if (in_array($p->PlaceID,$from_arr) || in_array($p->PlaceID,$to_arr))
		{
			if($p->PlaceActive == '1') {
				# Add Place to array
				$pnLang = 'PlaceName'. $lang;
				if(strlen($pnLang) == 9) $pnLang = 'PlaceNameEN';
			
				$placeName = strtolower($p->$pnLang);
				
				// fix ako nema jezika
				if(empty($placeName)) $pnLang = 'PlaceNameEN';
				$placeName = mb_strtolower($p->$pnLang, 'UTF-8');			
				
				//$placeName .= ', ' . getPlaceCountryCode($p->PlaceCountry);				
				$placeName .= ', ' . $p->CountryNameEN;
				
				# Add Place to array
				if (!in_array($placeName . '|'.$p->PlaceNameSEO,$fromPlaces)) {
					array_push($placessearch,strtoupper($placeName));
					//$fromPlaces[$p->PlaceID] = trim($placeName) . '|' . trim($p->PlaceNameSEO);
					$fromPlaces[trim($placeName)] = array(
														'ID' => $p->PlaceID,
														'PlaceNameSEO' => trim($p->PlaceNameSEO),
														'Long' => $p->Longitude,
														'Latt' => $p->Latitude,
														'Country' => $p->CountryNameEN
													);
				}
			}
		}						
	}
	
	api_key="5b3ce3597851110001cf6248ec7fafd8eca44e0ca5590caf093aa7cb";
	$layers="coarse";
	$source1="whosonfirst";
	$source2="geonames";
	
	$text=str_replace(" ","%20",$srch[0]);

	$url="https://api.openrouteservice.org/geocode/autocomplete?api_key=".$api_key."&start&layers=".$layers."&sources=".$source1.",".$source2."&text=".$text;

	$json = file_get_contents($url);   
	$obj="";
	$obj = json_decode($json,true);					
	
	if ($json) {	
		foreach ($obj['features'] as $places) {
			$placeNameL=strtoupper(trim($places['properties']['label']));
			$placeName=trim($places['properties']['name']);
			if (!in_array($placeNameL,$placessearch)) { 
				$fromPlaces[$placeNameL] = array(
													'ID' => 0,
													'PlaceNameSEO' => '',
													'Long' => $places['geometry']['coordinates'][0],
													'Latt' => $places['geometry']['coordinates'][1],
													'Country' => $places['properties']['country']
												);
			}
		}
	}

	# Sort by name
	//ksort($fromPlaces);
//}

	$res = array();

	foreach ($fromPlaces as $key => $value)
	{
		$res[] = array(
		'Place'=>mb_strtoupper($key, 'UTF-8'),
		'ID'=>$value['ID'],
		'SEO' => $value['PlaceNameSEO'],
		'Long' => $value['Long'],
		'Latt' => $value['Latt'],
		'Country' => $value['Country']		
		);
	}

	


$res = json_encode($res);
echo $_GET['callback'] . '(' . $res. ')';



