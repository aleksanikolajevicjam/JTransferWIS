<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once '../../../../db/db.class.php';
	require_once '../../../../db/v4_MyDrivers.class.php';


	# init class
	$db = new v4_MyDrivers();

# init vars
$keyName = '';
$keyValue = '';

if (isset($_REQUEST['keyName']) and $_REQUEST['keyName'] != '') 	$keyName = $_REQUEST['keyName'];
if (isset($_REQUEST['keyValue']) and $_REQUEST['keyValue'] != '') 	$keyValue = $_REQUEST['keyValue'];

$fldList = array();
$out = array();


# if Update - get the row by keyValue
if ($keyName != '' and $keyValue != '') $db->getRow($keyValue);


	if(isset($_REQUEST['OwnerID'])) { $db->setOwnerID($db->myreal_escape_string($_REQUEST['OwnerID']) ); } 

		 	
	if(isset($_REQUEST['DriverID'])) { $db->setDriverID($db->myreal_escape_string($_REQUEST['DriverID']) ); } 

		 	
	if(isset($_REQUEST['DriverName'])) { $db->setDriverName($db->myreal_escape_string($_REQUEST['DriverName']) ); } 

		 	
	if(isset($_REQUEST['DriverPassword'])) { $db->setDriverPassword($db->myreal_escape_string($_REQUEST['DriverPassword']) ); } 

		 	
	if(isset($_REQUEST['DriverEmail'])) { $db->setDriverEmail($db->myreal_escape_string($_REQUEST['DriverEmail']) ); } 

		 	
	if(isset($_REQUEST['DriverTel'])) { $db->setDriverTel($db->myreal_escape_string($_REQUEST['DriverTel']) ); } 

		 	
	if(isset($_REQUEST['Notes'])) { $db->setNotes($db->myreal_escape_string($_REQUEST['Notes']) ); } 

		 	

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
	
