<?

$root='/home/jamtrans/laravel/public/cms.jamtransfer.com';

//require_once 'db.class.php';
//require_once '../../db/v4_Places.class.php';
require_once $root . '/db/v4_Places.class.php';


$db = new DataBaseMysql();
$pl = new v4_Places();


$plKeys = $pl->getKeysBy("PlaceID", "ASC", "");
	$i=0;
	foreach ($plKeys as $plR) {
		$pl->getRow($plR);
		if ($pl->getPlaceType()==2 && $i<5) {
			$i++;
			$name=$pl->getPlaceNameEN();
			$name.=", ".$db->getCountryNameEN();
			
			$url='https://en.wikipedia.org/w/api.php?action=query&prop=extracts&format=json&exintro=&titles='.$name;
								
			$json = file_get_contents($url);   
			$obj="";
			$obj = json_decode($json,true);

			$arrey=$obj['query']['pages'];
			foreach ($arrey as $arr) {
				$desc=($arr['extract']);  
			}
			if ($json) $pl->setDescription(strip_tags($desc));
			$pl->saveRow();	
		}	
	}



