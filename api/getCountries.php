<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once '../config.php';

# init libs
require_once '../db/v4_Countries.class.php';

# init vars
$out = array();

# init class
$co = new v4_Countries();

$coKeys = $co->getKeysBy('CountryName', 'asc');

if($_REQUEST['returnIdAs'] == 'ID') {
	foreach($coKeys as $n => $ID) {
		$co->getRow($ID);
			$out[] = array(
						'CountryID'		=> $co->getCountryID(), 
						'CountryName' 	=> $co->getCountryName()
			);
	
	}
}


if($_REQUEST['returnIdAs'] == 'Code') {
	foreach($coKeys as $n => $ID) {
		$co->getRow($ID);
			$out[] = array(
						'CountryID'		=> $co->getCountryCode(), 
						'CountryName' 	=> $co->getCountryName()
			);
	
	}
}

if($_REQUEST['returnIdAs'] == 'Code3') {
	foreach($coKeys as $n => $ID) {
		$co->getRow($ID);
			$out[] = array(
						'CountryID'		=> $co->getCountryCode3(), 
						'CountryName' 	=> $co->getCountryName()
			);
	
	}
}


if(!isset($_REQUEST['returnIdAs']) or  $_REQUEST['returnIdAs'] == '') {
	foreach($coKeys as $n => $ID) {
		$co->getRow($ID);
			$out[] = array(
						'CountryID'		=> $co->getCountryID(), 
						'CountryName' 	=> $co->getCountryName()
			);
	
	}
}

# send output back
$output = json_encode($out);

unset($out);
//print_r($output);
echo $_REQUEST['callback'] . '(' . $output . ')';

$co->endv4_Countries();