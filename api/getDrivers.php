<?
header('Content-Type: text/javascript; charset=UTF-8');

# init libs
require_once '../../db/v4_AuthUsers.class.php';

# init vars
$out = array();

# init class
$au = new v4_AuthUsers();

$auk = $au->getKeysBy('AuthUserRealName', 'asc', "WHERE AuthLevelID = 31");

foreach($auk as $n => $ID) {
	
	$au->getRow($ID);
		$out[] = array(
					'UserID'		=> $au->getAuthUserID(), 
					'RealName' 		=> $au->getAuthUserRealName(),
					'Company' 		=> $au->getAuthUserCompany(),
					'Tel' 			=> $au->getAuthUserTel(),
					'Email'			=> $au->getAuthUserMail()
		);
	
}

# send output back
$output = json_encode($out);

unset($out);
//print_r($output);
echo $_REQUEST['callback'] . '(' . $output . ')';
