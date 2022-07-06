<?

set_time_limit(360);
require_once 'Initial.php';
require_once ROOT . '/db/v4_Places.class.php';
$pl = new v4_Places();

	$dbT->RunQuery("TRUNCATE TABLE `v4_routesterminals`");
	$dbT->RunQuery("INSERT INTO `v4_routesterminals`(`RouteID`, `TerminalID`) SELECT `RouteID`,`FromID`  FROM `v4_routes` WHERE `FromID` in (Select TerminalID from v4_terminals)");
	$dbT->RunQuery("INSERT INTO `v4_routesterminals`(`RouteID`, `TerminalID`) SELECT `RouteID`,`ToID`  FROM `v4_routes` WHERE `ToID` in (Select TerminalID from v4_terminals)");
	
	$result1=$dbT->RunQuery("SELECT TerminalID,Longitude,Latitude FROM `v4_terminals`,v4_places WHERE `TerminalID`=PlaceID");
		while($row = $result1->fetch_array(MYSQLI_ASSOC)){
			if ($row['Longitude']>0 && $row['Latitude']>0)
			$arr_row=array();
			$arr_row['TerminalID']=$row['TerminalID'];
			$arr_row['Longitude']=$row['Longitude'];
			$arr_row['Latitude']=$row['Latitude'];
			$terminals[]=$arr_row;
		}
	
	$result2=$dbT->RunQuery("SELECT RouteID FROM `v4_routes` WHERE `RouteID` not in (Select RouteID from v4_routesterminals)");

		while($row = $result2->fetch_array(MYSQLI_ASSOC)){
			$db->getRow($row['RouteID']);
			$fID=$db->getFromID();
			$pl->getRow($fID);
			$fLon=$pl->getLongitude();
			$fLat=$pl->getLatitude();
			$tID=$db->getToID();
			$pl->getRow($tID);
			$tLon=$pl->getLongitude();
			$tLat=$pl->getLatitude();
			if ($fLon>0 && $fLat>0 && $tLon>0 && $tLat>0) {
				$distanceMin=500000;
				$terminalID=0;			
				foreach($terminals as $t) {
					$terLon=$t['Longitude'];
					$terLat=$t['Latitude'];
					$distanceF=vincentyGreatCircleDistance($fLat,$fLon,$terLat,$terLon,'6371000');
					$distanceT=vincentyGreatCircleDistance($tLat,$tLon,$terLat,$terLon,'6371000');
					if ($distanceF<$distanceMin) {
						$distanceMin=$distanceF;
						$terminalID=$t['TerminalID'];
					}	
					if ($distanceT<$distanceMin) {
						$distanceMin=$distanceT;
						$terminalID=$t['TerminalID'];
					}
				}
				if ($terminalID>0) {
					$dbT->RunQuery("INSERT INTO `v4_routesterminals`(`RouteID`, `TerminalID`) VALUES (".$row['RouteID'].",".$terminalID.")");					
				}		
			}
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
