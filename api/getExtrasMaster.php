<?
header('Content-Type: text/javascript; charset=UTF-8');

# init libs
require_once '../../db/v4_ExtrasMaster.class.php';

# init vars
$out = array();

# init class
$db = new v4_ExtrasMaster();

//$dbKeys = $db->getKeysBy('ServiceEN', 'asc');
$dbKeys = $db->getKeysBy('DisplayOrder', 'asc', ' WHERE DisplayOrder>0 ' );

foreach($dbKeys as $n => $ID) {
	$db->getRow($ID);
		$out[] = array(
					'ID'			=> $db->getID(), 
					'ServiceEN' 	=> $db->getServiceEN()
		);
	
}

# send output back
$output = json_encode($out);

unset($out);
//print_r($output);
echo $_REQUEST['callback'] . '(' . $output . ')';


