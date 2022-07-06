<?
require_once '../../config.php';
$lang=$_SESSION['CMSLang'];


$fID = $_REQUEST['fID'];
if(empty($fID) and isset($_SESSION['FromID']))
$fID = $_SESSION['FromID'];
$places = array();
# Routes for selected place
$q1 = "SELECT DISTINCT RouteID, FromID, ToID FROM v4_DriverRoutes
			WHERE FromID = '{$fID}'
			OR    ToID   = '{$fID}'
			";
$r1 = $db->RunQuery($q1);
while($r = $r1->fetch_object()) {
	$srch = explode(',' , trim($_REQUEST['qry']) );
	# Places in the Country
	$q  = "SELECT * FROM v4_Places ";
	$q .= " WHERE (PlaceID  = ".$r->FromID;
	$q .= " OR    PlaceID  = ".$r->ToID .") ";
	$q .= " AND (PlaceName".$lang." LIKE'%" .  $srch[0]. "%' ";
	$q .= " OR PlaceNameSEO LIKE'%" .  $srch[0]. "%') ";
	$q .= " ORDER BY PlaceName".$lang." ASC";

	$w = $db->RunQuery($q);
	while ($p = $w->fetch_object()) {
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
				$placeName .= ', ' . getPlaceCountryCode($p->PlaceCountry);
				# Add Place to array
				if (!in_array($placeName.'|'.$p->PlaceNameSEO,$places)) {
					//$fromPlaces[$p->PlaceID] = trim($placeName) . '|' . trim($p->PlaceNameSEO);
					$places[trim($placeName)] = array(
														'ID' => $p->PlaceID,
														'PlaceNameSEO' => trim($p->PlaceNameSEO),
														'PlaceType' => $p->PlaceType
													);
				}
			}
		}
	}
	ksort($places);
}
$res = array();

foreach ($places as $key => $value)
{
    $res[] = array(
	'Place'=>mb_strtoupper($key,'UTF-8'),
    'ID'=>$value['ID'],
    'SEO' => $value['PlaceNameSEO'],
    'Type' => $value['PlaceType']

	);
}
$res = json_encode($res);
ob_start();
echo $_GET['callback'] . '(' . $res. ')';
ob_end_flush();




