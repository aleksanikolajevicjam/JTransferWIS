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
				if ($pl->getPlaceType()==2 && $pl->getLongitude()==0 && $i<5) {
					$i++;
					$name=$pl->getPlaceNameEN();
				
					$url='https://api.opencagedata.com/geocode/v1/json?q='.$name.'&key=26e26a7632f843e3b7edfa39c1437053';
										
					
					$json = file_get_contents($url);   
					$obj="";
					$obj = json_decode($json,true);

					if ($json) {
						$latt=konv($obj['results'][0]['annotations']['DMS']['lat']);
						$longt=konv($obj['results'][0]['annotations']['DMS']['lng']); 
					
			
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

