<?

//require_once $_SERVER['DOCUMENT_ROOT'] . '/sessionThingy.php';
//error_reporting(E_ALL);
//@session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/api2/getBookingData.php';

$T = getBookingData();
if (count($T) > 2) $RT = 1; // return transfer exists

require_once $_SERVER['DOCUMENT_ROOT'].'/db/v4_Extras.class.php';

$e = new v4_Extras();

$k = $e->getKeysBy('Service', 'ASC', ' WHERE OwnerID = ' . $T[0]['DriverID']);

$extras = array();

if( count($k) > 0) {

    foreach($k as $nn => $id) {
	    $e->getRow($id);
	    $extras[] = $e->fieldValues();
    }
} //else echo 'Extras not found for Driver: '. $T[0]['DriverID'];

#if(isset($_GET['callback'])) {
#	$extras = json_encode($extras);
#	echo $_GET['callback'] . '(' . $extras. ')';
#}	

