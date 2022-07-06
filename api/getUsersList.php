<?
header('Content-Type: text/javascript; charset=UTF-8');

# init libs
require_once '../../db/v4_AuthUsers.class.php';

# init vars
$out = array();

# init class
$au = new v4_AuthUsers();


# filters
$where = ' WHERE ' . $_REQUEST['where'];
$sort  = $_REQUEST['sortField'];
$order = $_REQUEST['sortOrder'];

# keys + key values array
$auKeys = $au->getKeysBy($sort, $order , $where);

foreach($auKeys as $k=>$v) {
	
	#  dohvati red
	$au->getRow($v);
	
	/*
	$out[] = array(
				'UserID'		=> $au->getAuthUserID(), 
				'RealName' 		=> $au->getAuthUserRealName(),
				'Company' 		=> $au->getAuthUserCompany(),
				'Tel' 			=> $au->getAuthUserTel(),
				'Email'			=> $au->getAuthUserMail()
	);
	*/
	// univerzalna verzija
	$out[] = $au->fieldValues();
}

//asort($out);
# send output back
$output = json_encode($out);

unset($out);

echo $_REQUEST['callback'] . '(' . $output . ')';
$au->endv4_AuthUsers();