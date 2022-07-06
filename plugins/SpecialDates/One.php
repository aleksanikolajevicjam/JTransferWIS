<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once 'Initial.php';
 
	# init vars
	$out = array();

	# filters

	$ID = $_REQUEST['ItemID'];

	# Details  red
	$db->getRow($ID);

	# Details  red
	$db->getRow($dbk[0]);

	# get fields and values
	$detailFlds = $db->fieldValues();

	$out[] = $detailFlds;

	# send output back
	$output = json_encode($out);
	echo $_GET['callback'] . '(' . $output . ')';
	