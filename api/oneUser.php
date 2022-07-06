<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once '../config.php';
 
	# init libs
	require_once '../db/db.class.php';
	require_once '../db/v4_AuthUsers.class.php';
	require_once '../db/v4_AuthLevels.class.php';
	require_once '../lng/en_text.php';
	

	# init vars
	$out = array();


	# init class
	$au = new v4_AuthUsers();
	$al = new v4_AuthLevels();

	# filters

	$AuthUserID = $_REQUEST['AuthUserID'];

	# Details  red
	$au->getRow($AuthUserID);

	# AuthLevelID za levels
	$AuthLevelID = $au->getAuthLevelID();

	# levels row
	$al->getRow($AuthLevelID);

	# Details  red
	$au->getRow($auk[0]);

	# get fields and values
	$detailFlds = $au->fieldValues();
	$pm=$detailFlds["AcceptedPayment"];
	$detailFlds["AcceptedPaymentName"]=$AcceptedPayment[$pm];
	
	
	$detailFlds["AuthLevelName"] = $al->getAuthLevelName();
	$detailFlds["DBImage"] = '';

	$out[] = $detailFlds;

	# send output back
	$output = json_encode($out);
	echo $_GET['callback'] . '(' . $output . ')';
	//echo '<pre>'; print_r($out); echo '</pre>';
	
