<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once ROOT . '/db/db.class.php';
	require_once ROOT . '/db/v4_Labels.class.php';


	# init vars
	$out = array();


	# init class
	$db = new v4_Labels();


	# filters

	$LabelID = $_REQUEST['LabelID'];

	# Details  red
	$db->getRow($LabelID);


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
	