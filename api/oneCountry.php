<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once '../../db/db.class.php';
	require_once '../../db/v4_Countries.class.php';


	# init vars
	$out = array();


	# init class
	$co = new v4_Countries();


	# filters

	$countryID = $_REQUEST['CountryID'];

	# Details  red
	$co->getRow($countryID);

	# Details  red
	$co->getRow($cok[0]);

	# get fields and values
	$detailFlds = $co->fieldValues();

	$out[] = $detailFlds;

	# send output back
	$output = json_encode($out);
	echo $_GET['callback'] . '(' . $output . ')';

	
