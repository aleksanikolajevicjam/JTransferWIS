<?

require_once 'config.php';

require_once ROOT . '/db/v4_Extras.class.php';

require_once ROOT.'/db/v4_ExtrasMaster.class.php';

$e = new v4_Extras();

$em = new v4_ExtrasMaster();

$k = $e->getKeysBy('Service', 'ASC', ' WHERE OwnerID = ' . $_SESSION['DriverID']);

$extras = array();

if( count($k) > 0) {

    foreach($k as $nn => $id) {
	    $e->getRow($id);
		$sid = $e->getServiceID();
		$em->getRow($sid);
		$extras_arr=  $e->fieldValues();
		$extras_arr = array_merge($extras_arr, array("order" => $em->getDisplayOrder()));
	    $extras[] = $extras_arr;
    }
	usort($extras,function($first,$second){
		return $first['order'] > $second['order'];
	});
}



