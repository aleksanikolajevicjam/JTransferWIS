<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once '../config.php';

# init libs
require_once '../db/v4_Routes.class.php';

# init vars
$out = array();

# init class
$db = new v4_Routes();

$dbKeys = $db->getKeysBy('RouteNameEN', 'asc');

foreach($dbKeys as $n => $ID) {
	$db->getRow($ID);
		$out[] = array(
					'RouteID'		=> $db->getRouteID(), 
					'RouteNameEN' 	=> $db->getRouteNameEN()
		);
	
}

# send output back
$output = json_encode($out);

unset($out);
//print_r($output);
echo $_REQUEST['callback'] . '(' . $output . ')';


