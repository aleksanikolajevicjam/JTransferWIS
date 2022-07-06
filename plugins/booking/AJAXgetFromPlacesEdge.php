<?
require_once '../../config.php';
$lang=$_SESSION['CMSLang'];
$srch = explode(',' , trim($_REQUEST['qry']) );
$q  = " SELECT * FROM v4_Places ";
$q .= " WHERE PlaceActive = '1'";
	$q .= " AND (PlaceName".$lang." LIKE'%" .  $srch[0]. "%' ";
	$q .= " OR PlaceNameSEO LIKE'%" .  $srch[0]. "%') ";
$q .= " ORDER BY PlaceName".$lang." ASC";
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
			
			$placeName .= ', ' . getPlaceCountryCode($p->PlaceCountry);
			# Add Place to array
			if (!in_array($placeName . '|'.$p->PlaceNameSEO,$fromPlaces)) {
				//$fromPlaces[$p->PlaceID] = trim($placeName) . '|' . trim($p->PlaceNameSEO);
				$fromPlaces[trim($placeName)] = array(
													'ID' => $p->PlaceID,
													'PlaceNameSEO' => trim($p->PlaceNameSEO)
												);
			}
		}
	}						
}
# Sort by name
ksort($fromPlaces);
$res = array();
foreach ($fromPlaces as $key => $value)
{
	$res[] = array(
	'Place'=>mb_strtoupper($key, 'UTF-8'),
	'ID'=>$value['ID'],
	'SEO' => $value['PlaceNameSEO']

	);
}
$res = json_encode($res);
ob_start();
echo $_GET['callback'] . '(' . $res. ')';
ob_end_flush();