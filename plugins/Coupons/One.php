<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once 'Initial.php';

	# init libs
	require_once ROOT . '/db/v4_Coupons.class.php';

	# init vars
	$out = array();

	# init class
	$db = new v4_Coupons();

	# filters
	$db->getRow($_REQUEST['ItemID']);

	# get fields and values
	$detailFlds = $db->fieldValues();

    
    # remove slashes 
    foreach ($detailFlds as $key=>$value) {
        $detailFlds[$key] = stripslashes($value);
    }
	
	$out[] = $detailFlds;

	# send output back
	$output = json_encode($out);
	echo $_GET['callback'] . '(' . $output . ')';
	