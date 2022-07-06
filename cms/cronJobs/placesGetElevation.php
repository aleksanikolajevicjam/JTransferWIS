<?

$root='/home/jamtrans/laravel/public/cms.jamtransfer.com';

//require_once 'db.class.php';
//require_once '../../db/v4_Places.class.php';
require_once $root . '/db/v4_Places.class.php';


$db = new DataBaseMysql();
$pl = new v4_Places();


$plKeys = $pl->getKeysBy("PlaceID", "DESC", "");
	$i=0;
	foreach ($plKeys as $plR) {
		$pl->getRow($plR);
		if ($pl->getPlaceType()==2 && $pl->getElevation()==-9999  && ($pl->getLongitude()<>9 || $pl->getLongitude()<0) && $i<3) {
			$i++;
			echo $name=$pl->getPlaceNameEN();
			echo " ";
			$longt=$pl->getLongitude();
			$latt=$pl->getLatitude();
		
		
			$url="https://api.opentopodata.org/v1/aster30m?locations=".$latt.",".$longt;
								
			
			$json = file_get_contents($url);   
			$obj="";
			$obj = json_decode($json,true);

			
			if ($json) { 
				echo $elev=$obj['results'][0]['elevation'];
				echo "<br>";
				$pl->setElevation($elev); 
			}	
			else $pl->setElevation(-9998); 
			$pl->saveRow();					
		}	
	}

