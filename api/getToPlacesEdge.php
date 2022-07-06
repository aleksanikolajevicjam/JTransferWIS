<?
	
	require_once '../config.php';

	//require_once $_SERVER['DOCUMENT_ROOT'] . '/sessionThingy.php';
//session_start();
error_reporting(E_PARSE);

//require_once $_SERVER['DOCUMENT_ROOT'] . '/LoadLanguage.php';
require_once ROOT . '/db/db.class.php';
//require_once $_SERVER['DOCUMENT_ROOT'] . '/f2/f.php';

$db = new DataBaseMysql();

if(isset($_REQUEST['language'])) $_SESSION['language'] = $_REQUEST['language'];

//$lang = strtoupper(substr($_SESSION['language'],0,2));
$lang = "EN";

if( $lang == 'NB') $lang='NO';

//Blogit($_SESSION);


//$fromName = $_SESSION['lastElement'];
$fID = $_REQUEST['fID'];
if(empty($fID) and isset($_SESSION['FromID']))
$fID = $_SESSION['FromID'];
/*
// Get from Cache
$filename = $_SERVER['DOCUMENT_ROOT'] . '/cache/toPlaces'.$fID.$lang.'.json';
$cachetime = 84600;

if (file_exists($filename) && time() - $cachetime < filemtime($filename)) {

	$handle = fopen($filename, "r");
	$contents = fread($handle, filesize($filename));
	fclose($handle);

	$noBrackets = str_replace('(','',$contents);
	$contents = str_replace(')','',$noBrackets);
	$res = json_decode($contents, true);


	$rewriteCache = false;

}
//*******************

else {
	#$qfid = "SELECT * FROM v4_Places WHERE PlaceID = '" . $fromName . "'";
	#$wfid = $db->RunQuery($qfid);
	#$fidObj = mysqli_fetch_object($wfid);

	#$fID = $fidObj->PlaceID;

	//$fID = $_SESSION['fromID'];

	# save variables for later usage
	//$_SESSION['fromName'] = $_SESSION['fromPlaces'][$fID];
SELECT * FROM `v4_DriverRoutes` WHERE FromID = '145740' or ToID='145740' - geneva
*/

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
			//}
		//}



	ksort($places);
	//unset($_SESSION['toPlaces']);

	//$_SESSION['toPlaces'] = $places;
	//unset($places);

	$rewriteCache = false;

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

