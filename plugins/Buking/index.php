<? 
$smarty->assign('page', $md->getName());
@session_start();
if (!$_SESSION['UserAuthorized']) die('Bye, bye');
/* echo "<pre>";
var_dump($_SESSION);
echo "<hr>";
var_dump($_POST);
echo "<hr>";
var_dump($_COOKIE);
echo "<hr>";
var_dump($_GET);
echo "<hr>";
echo "</pre>"; */



require_once ROOT . '/db/v4_Places.class.php';
$pl = new v4_Places();

if (isset($_SESSION['AgentID']) && $_SESSION['AgentID'] > 0) $AgentID = $_SESSION['AgentID'];
else $AgentID = 0;
if (isset($_SESSION['FromID']) && $_SESSION['FromID'] > 0) {
    $fromID = $_SESSION['FromID'];
    global $pl;
    $pl->getRow($fromID);
    $fromName = $pl->getPlaceNameEN();
}
if (isset($_SESSION['ToID']) && $_SESSION['ToID'] > 0) {
    $toID = $_SESSION['ToID'];
    global $pl;
    $pl->getRow($toID);
    $toName = $pl->getPlaceNameEN();
}
if (isset($_SESSION['PaxNo']) && $_SESSION['PaxNo'] > 0) $PaxNo = $_SESSION['PaxNo'];
else $PaxNo = 0;

if (s('MPaxTel') == '') $PaxTel = " ";
else $PaxTel = s('MPaxTel');

if (isset($_SESSION['transferDate']))  $transferDate = $_SESSION['transferDate'];

// Prevent refresh on thankyou.php page
$_SESSION['REFRESHED'] = false;

if ((isset($lastElement) and count($lastElement) == 2) or !empty($_REQUEST)) { // postoje neki parametri
    // spremi sve u session
    foreach ($_REQUEST as $key => $value) {
        $_SESSION[$key] = $value;
    }
}
require_once ROOT . '/db/v4_AuthUsers.class.php';

$au = new v4_AuthUsers();

if (s('MPaxFirstName') == '') $PaxFirstName = " ";
else $PaxFirstName = s('MPaxFirstName');
$weby_key = file_get_contents('weby_key.inc', FILE_USE_INCLUDE_PATH);

$db = new DataBaseMysql();
$query = "SELECT AuthUserID, AuthUserCompany FROM jamtrans_touradria.v4_authusers where AuthLevelID = 2;";
$result = $db->RunQuery($query);
$agents = array();
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $agents[] = $row;
}
$smarty->assign('agents', $agents);
if (s('returnTransfer') == '1') echo 'checked';
$car =   getRoutePrices(s('FromID'), s('ToID'));

$cells =  count($car);

switch ($cells) {
    case 1:
        $box = 'l4';
        $offset = 'offset-l2';
        break;
    case 2:
        $box = 'l3';
        $offset = 'offset-l3';
        break;
    case 3:
        $box = 'l4';
        $offset = '';
        break;
    case 4:
        $box = 'l3';
        $offset = '';
        break;
    case 5:
        $box = 'l2';
        $offset = 'offset-l1';
        break;
    case 6:
        $box = 'l2';
        $offset = '';
        break;
    case 7:
        $box = 'l3';
        $offset = '';
        break;
    case 8:
        $box = 'l3';
        $offset = '';
        break;
    case 9:
        $box = 'l3';
        $offset = '';
        break;
    case 10:
        $box = 'l2';
        $offset = '';
        break;
    case 11:
        $box = 'l3';
        $offset = '';
        break;
    case 12:
        $box = 'l2';
        $offset = '';
        break;
}

foreach($car as $VehicleCapacity => $price) {

    $VehicleImageRoot = "https://" . $_SERVER['HTTP_HOST'];

    if ($VehicleCapacity <= 3) $vehicleImageFile = '/i/cars/sedan.png';
    else if ($VehicleCapacity <= 4) $vehicleImageFile = '/i/cars/sedan.png';
    else if ($VehicleCapacity <= 8) $vehicleImageFile = '/i/cars/minivan.png';
    else if ($VehicleCapacity <= 15) $vehicleImageFile = '/i/cars/minibusl.png';
    else if ($VehicleCapacity > 15) $vehicleImageFile = '/i/cars/bus.png';

    $VehicleImage = $VehicleImageRoot.$vehicleImageFile;

}


/* function fiksniDio() {
	$term_name = GetPlaceName(s('FromID'));
	$dest_name = GetPlaceName(s('ToID'));

	if ($term_name == '') $term_name = YOUR_TERM;
	if ($dest_name == '') $dest_name = YOUR_DEST;

	if ($_SESSION['language'] == 'en') {
		$fiksni_dio = 	BOOKING_ABOUT_1 . $term_name . BOOKING_ABOUT_2 . $dest_name .
						BOOKING_ABOUT_3 . $term_name . BOOKING_ABOUT_4 . $dest_name .
						BOOKING_ABOUT_5 . $term_name . BOOKING_ABOUT_6 . $dest_name .
						BOOKING_ABOUT_7 . $dest_name . BOOKING_ABOUT_8 . $term_name .
						BOOKING_ABOUT_9 . $dest_name . BOOKING_ABOUT_10;
	}

	return $fiksni_dio;
} */

/* function getAgents()
{
	global $au;
	$retArr = array();

	$where = " WHERE AuthLevelID = '2' AND Active=1";
	$k = $au->getKeysBy("AuthUserCompany", "asc", $where);

	if(count($k) > 0 ) {
		foreach($k as $nn => $key) {
			$au->getRow($key);
		 	# Stavi TaxiSite-ove u array za kasnije
			$retArr[$au->AuthUserID] = $au->AuthUserCompany;

		}
	}
	$where = " WHERE AuthLevelID = '12' AND Active=1";
	$k = $au->getKeysBy("AuthUserCompany", "asc", $where);

	if(count($k) > 0 ) {
		foreach($k as $nn => $key) {
			$au->getRow($key);
		 	# Stavi TaxiSite-ove u array za kasnije
			$retArr[$au->AuthUserID] = $au->AuthUserCompany;

		}
	}
	return $retArr;
} */

//require_once ROOT . '/m/getRoutePrices.php';

if ($_POST['VehicleID' != 0]) {
    echo "yes";
}