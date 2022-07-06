<?

$root='/home/jamtrans/laravel/public/cms.jamtransfer.com';

//require_once '../../db/db.class.php';
require_once '../../db/v4_Places.class.php';
//require_once $root . '/db/v4_Places.class.php';


//$db = new DataBaseMysql();
$pl = new v4_Places();


$plKeys = $pl->getKeysBy("PlaceCity", "DESC", "WHERE PlaceType=1 AND Longitude=0 AND Latitude=0");
	$i=0;
	foreach ($plKeys as $plR) {
		if ($i<1) {
			$pl->getRow($plR);
			$name=$pl->getPlaceNameEN();
			//$name=$pl->getPlaceCity().' Airport';


				$api_key="5b3ce3597851110001cf6248ec7fafd8eca44e0ca5590caf093aa7cb";
				$layers="coarse";
				$source1="whosonfirst";
				$source2="geonames";
				
				$text=str_replace(" ","%20",$name);

				$url="https://api.openrouteservice.org/geocode/search?api_key=".$api_key."&start&layers=".$layers."&sources=".$source1.",".$source2."&text=".$text;

				$json = file_get_contents($url);   
				$obj="";
				$obj = json_decode($json,true);	

				if ($obj) {
					$long=$obj['features'][0]['geometry']['coordinates'][0];	
					$latt=$obj['features'][0]['geometry']['coordinates'][1]; 
					if ($long>0 && $latt>0) {

						$i++;
						$pl->setLongitude($long);
						$pl->setLatitude($latt);
						$pl->saveRow();
						//echo $name;
						echo "<br>";

						echo $pl->getLongitude();
						echo "<br>";
						echo $pl->getLatitude(); 
						echo "<br>";	
					}
				}		
			

		}
	}
