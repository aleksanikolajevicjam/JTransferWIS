<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once '../config.php';

# init libs
require_once '../db/v4_PlaceTypes.class.php';

# init vars
$out = array();

# init class
$db = new v4_PlaceTypes();

$dbKeys = $db->getKeysBy('PlaceTypeEN', 'asc');

foreach($dbKeys as $n => $ID) {
	$db->getRow($ID);
		$out[] = array(
					'PlaceTypeID'		=> $db->getPlaceTypeID(), 
					'PlaceTypeEN' 	=> $db->getPlaceTypeEN()
		);
	
}

# send output back
$output = json_encode($out);

unset($out);
//print_r($output);
echo $_REQUEST['callback'] . '(' . $output . ')';
