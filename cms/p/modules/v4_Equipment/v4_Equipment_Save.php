<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once ROOT . '/db/db.class.php';
	require_once ROOT . '/db/v4_Equipment.class.php';


	# init class
	$em = new v4_Equipment();
	$db = new DataBaseMysql();

# init vars
$keyName = '';
$keyValue = '';

if (isset($_REQUEST['keyName']) and $_REQUEST['keyName'] != '') 	$keyName = $_REQUEST['keyName'];
if (isset($_REQUEST['keyValue']) and $_REQUEST['keyValue'] != '') 	$keyValue = $_REQUEST['keyValue'];

$fldList = array();
$out = array();


# if Update - get the row by keyValue
if ($keyName != '' and $keyValue != '') $em->getRow($keyValue);


	if(isset($_REQUEST['ID'])) { $em->setID($em->myreal_escape_string($_REQUEST['ID']) ); } 

	if(isset($_REQUEST['DisplayOrder'])) { $em->setDisplayOrder($em->myreal_escape_string($_REQUEST['DisplayOrder']) ); } 
		 	
	if(isset($_REQUEST['Active'])) { $em->setActive($em->myreal_escape_string($_REQUEST['Active']) ); } 

		 	
	if(isset($_REQUEST['Title'])) { $em->setTitle($em->myreal_escape_string($_REQUEST['Title']) ); } 


		 	
	
$upd = '';
$newID = '';

// ako je update, azuriraj trazeni slog

if ($keyName != '' and $keyValue != '') {
	$res = $em->saveRow();
	$upd = 'Updated';
	if($res !== true) $upd = $res;
}

// inace dodaj novi slog	
if ($keyName != '' and $keyValue == '') {
	$newID = $em->saveAsNew();
}


$out = array(
	'update' => $upd,
	'insert' => $newID
);

# send output back
$output = json_encode($out);
echo $_REQUEST['callback'] . '(' . $output . ')';
	
