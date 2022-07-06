<?
@session_start();
error_reporting(E_PARSE);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$root='/home/jamtrans/laravel/public/cms.jamtransfer.com';

//require_once 'db.class.php';
//require_once '../../db/v4_Places.class.php';
require_once $root . '/db/v4_Places.class.php';
require_once $root .  '/f2/f.php';



$db = new DataBaseMysql();
$pl = new v4_Places();
	$longt=$_REQUEST['Long'];
	$latt=$_REQUEST['Latt'];
	$country=$_REQUEST['Country'];
	if ($latt<>0 && $longt<>0) {
		$plKeys = $pl->getKeysBy('PlaceID','asc',"WHERE (PlaceType=1)");
		$dMin=9999999;
		foreach($plKeys as $pli => $id) {
			$pl->getRow($id);
			$dMinP=vincentyGreatCircleDistance($pl->Latitude, $pl->Longitude, $latt, $longt, $earthRadius = 6371000);
			if ($dMinP<$dMin && $dMinP<200000 && $pl->CountryNameEN==$country) {
				$dMin=$dMinP;
				$terminalID=$id;
				$placeName = mb_strtoupper($pl->PlaceNameEN, 'UTF-8');
                $placeName .= ', ' . getPlaceCountryCode($pl->PlaceCountry);
				$TerminalName=$placeName;
				$TerminalLongitude=$pl->Longitude;		
				$TerminalLatitude=$pl->Latitude;					
			}	
		}
	} 

	$res = array(
	'TerminalID'=>$terminalID,
	'TerminalName'=>$TerminalName,
	'Longitude'=>$TerminalLongitude,
	'Latitude' => $TerminalLatitude,
	);
	
	$res = json_encode($res);	
	ob_start();
	echo $_GET['callback'] . '(' . $res. ')';
	ob_end_flush();
				
function konv($res) {
	$ww=$res;  
	$ww=explode(' ',$ww);
	$xx=str_replace('°','',$ww[0]);
	//$dlat=preg_replace('/[^0-9]/', '', $ww[1])*60+preg_replace('/[^0-9]/', '', $ww[2]);
	$dxx=(str_replace("'","",$ww[1])*60+str_replace("''","",$ww[2]))/3600;
	if ($ww[3]=='S') $zxx=-1;
	else if ($ww[3]=='W') $zxx=-1;
	else $zxx=1;
	$xx=$zxx*($xx+$dxx);
	return $xx;	  
}	

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