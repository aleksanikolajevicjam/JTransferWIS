<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once '../config.php';

# init libs
require_once '../db/v4_AuthUsers.class.php';
// require_once '../../db/v4_DriverRoutes.class.php';

# init vars
$out = array();

# init class
$au = new v4_AuthUsers();
// $dr = new v4_DriverRoutes();
# route
// $RouteID = $_REQUEST['RouteID'];

// $drWhere = ' WHERE RouteID = ' . $RouteID;
// $drKeys = $dr->getKeysBy('OwnerID', 'asc', $drWhere);

$auWhere = " WHERE AuthLevelID = '31' AND Active='1' ";
$auKeys = $au->getKeysBy('Country, Terminal, AuthUserCompany', 'asc', $auWhere);

foreach($auKeys as $n => $ID) {
//	$dr->getRow($ID);
	
	$au->getRow($ID);
		$out[] = array(
					'UserID'		=> $au->getAuthUserID(), 
					'RealName' 		=> $au->getAuthUserRealName(),
					'Company' 		=> $au->getAuthUserCompany(),
					'Tel' 			=> $au->getAuthUserTel(),
					'Email'			=> $au->getAuthUserMail(),
					'Country'       => $au->getCountry(),
					'Terminal'      => $au->getTerminal()
		);
	
}

# send output back
$output = json_encode($out);

unset($out);
//print_r($output);
echo $_REQUEST['callback'] . '(' . $output . ')';


