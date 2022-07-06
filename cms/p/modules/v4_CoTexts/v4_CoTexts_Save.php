<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once '../../../../db/db.class.php';
	require_once '../../../../db/v4_CoTexts.class.php';


	# init class
	$db = new v4_CoTexts();

# init vars
$keyName = '';
$keyValue = '';

if (isset($_REQUEST['keyName']) and $_REQUEST['keyName'] != '') 	$keyName = $_REQUEST['keyName'];
if (isset($_REQUEST['keyValue']) and $_REQUEST['keyValue'] != '') 	$keyValue = $_REQUEST['keyValue'];

$fldList = array();
$out = array();


# if Update - get the row by keyValue
if ($keyName != '' and $keyValue != '') $db->getRow($keyValue);


	if(isset($_REQUEST['ID'])) { $db->setID($db->myreal_escape_string($_REQUEST['ID']) ); } 

		 	
	if(isset($_REQUEST['language'])) { $db->setlanguage($db->myreal_escape_string($_REQUEST['language']) ); } 

		 	
	if(isset($_REQUEST['co_homepage'])) { $db->setco_homepage($db->myreal_escape_string($_REQUEST['co_homepage']) ); } 

		 	
	if(isset($_REQUEST['co_desc'])) { $db->setco_desc($db->myreal_escape_string($_REQUEST['co_desc']) ); } 

		 	
	if(isset($_REQUEST['co_terms'])) { $db->setco_terms($db->myreal_escape_string($_REQUEST['co_terms']) ); } 

		 	
	if(isset($_REQUEST['co_refund'])) { $db->setco_refund($db->myreal_escape_string($_REQUEST['co_refund']) ); } 

		 	
	if(isset($_REQUEST['co_privacy'])) { $db->setco_privacy($db->myreal_escape_string($_REQUEST['co_privacy']) ); } 

		 	
	if(isset($_REQUEST['co_howtobook'])) { $db->setco_howtobook($db->myreal_escape_string($_REQUEST['co_howtobook']) ); } 

		 	
	if(isset($_REQUEST['co_htmlblock'])) { $db->setco_htmlblock($db->myreal_escape_string($_REQUEST['co_htmlblock']) ); } 

		 	
	if(isset($_REQUEST['co_sideblock'])) { $db->setco_sideblock($db->myreal_escape_string($_REQUEST['co_sideblock']) ); } 

		 	

$upd = '';
$newID = '';

// ako je update, azuriraj trazeni slog

if ($keyName != '' and $keyValue != '') {
	$res = $db->saveRow();
	$upd = 'Updated';
	if($res !== true) $upd = $res;
}

// inace dodaj novi slog	
if ($keyName != '' and $keyValue == '') {
	$newID = $db->saveAsNew();
}


$out = array(
	'update' => $upd,
	'insert' => $newID
);

# send output back
$output = json_encode($out);
echo $_REQUEST['callback'] . '(' . $output . ')';
	
