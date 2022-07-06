<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once '../config.php';
require_once '../db/v4_Places.class.php';

# init vars
$out = array();

# init class
$db = new v4_Places();

$dbKeys = $db->getKeysBy('PlaceNameEN', 'asc');

foreach($dbKeys as $n => $ID) {
	$db->getRow($ID);
		$out[] = array(
					'PlaceID'		=> $db->getPlaceID(), 
					'PlaceName' 	=> $db->getPlaceNameEN()
		);
	
}

# send output back
$output = json_encode($out);

unset($out);
echo $_REQUEST['callback'] . '(' . $output . ')';


