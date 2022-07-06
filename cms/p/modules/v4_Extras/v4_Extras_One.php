<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	# init libs
	require_once ROOT . '/db/db.class.php';
	require_once ROOT . '/db/v4_Extras.class.php';
	require_once ROOT . '/db/v4_AuthUsers.class.php';
	require_once ROOT . '/db/v4_ExtrasMaster.class.php';


	# init vars
	$out = array();


	# init class
	$db = new v4_Extras();
	//$em = new v4_ExtrasMaster();
	$au = new v4_AuthUsers();


	# filters

	$ID = $_REQUEST['ID'];

	# Details  red
	$db->getRow($ID);
	$au->getRow($db->getOwnerID());
	//$em->getRow($db->getServiceID());


	# get fields and values
	$detailFlds = $db->fieldValues();
	$detailFlds["OwnerName"] = $au->getAuthUserRealName();
	//$detailFlds["Service"] = $em->getServiceEN();

    # remove slashes 
    foreach ($detailFlds as $key=>$value) {
        $detailFlds[$key] = stripslashes($value);
    }


	$out[] = $detailFlds;

	# send output back
	$output = json_encode($out);
	echo $_GET['callback'] . '(' . $output . ')';
	
