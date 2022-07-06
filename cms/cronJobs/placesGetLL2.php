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
				if ($pl->getLongitude()==0 && $i<5 ) {
					$i++;
					$name=$pl->getPlaceNameEN();
				
					$url='https://geocode.xyz/'.$name.'?json=1';		
					$json = file_get_contents($url);   
					$obj="";
					$obj = json_decode($json,true);					
					

					$longt=$obj['longt'];
					$latt=$obj['latt']; 
					
					if ($json) {
					
						if ($longt<>0 && $latt<>0) {
							$pl->setLongitude($longt);
							$pl->setLatitude($latt);
						} 
						else { 
							$pl->setLongitude(8);
							$pl->setLatitude(8);	
						}
					}	 
					else {
						$pl->setLongitude(9);
						$pl->setLatitude(9);	
					}
					$pl->saveRow();
				}	

	}

