<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once ROOT . '/db/db.class.php';
	require_once ROOT . '/db/v4_DriverRoutes.class.php';
	require_once ROOT . '/db/v4_Routes.class.php';


	# init vars
	$out = array();


	# init class
	$db = new v4_DriverRoutes();
	$db2 = new v4_Routes();


	# filters

	$ID = $_REQUEST['ID'];

	# Details  red
	$db->getRow($ID);


	# get fields and values
	$detailFlds = $db->fieldValues();

    
    # remove slashes 
    foreach ($detailFlds as $key=>$value) {
        $detailFlds[$key] = stripslashes($value);
    }
	$db2->getRow($detailFlds['RouteID']);
	$detailFlds['Km']=$db2->getKm();
	$detailFlds['Duration']=$db2->getDuration();


	$out[] = $detailFlds;

	# send output back
	$output = json_encode($out);
	echo $_GET['callback'] . '(' . $output . ')';
	