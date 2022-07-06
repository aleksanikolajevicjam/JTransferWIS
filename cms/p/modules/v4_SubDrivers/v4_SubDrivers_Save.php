<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);

session_start();
 
	# init libs
	require_once '../../../../db/db.class.php';
	require_once '../../../../db/v4_SubDrivers.class.php';


	# init class
	$db = new v4_SubDrivers();

# init vars
$keyName = '';
$keyValue = '';

if (isset($_REQUEST['keyName']) and $_REQUEST['keyName'] != '') 	$keyName = $_REQUEST['keyName'];
if (isset($_REQUEST['keyValue']) and $_REQUEST['keyValue'] != '') 	$keyValue = $_REQUEST['keyValue'];

$fldList = array();
$out = array();

require_once ROOT . '/cms/fixDriverID.php';
foreach($fakeDrivers as $key => $fakeDriverID) {
    if($_REQUEST['OwnerID'] == $fakeDriverID) $_REQUEST['OwnerID'] = $realDrivers[$key];    
}

# if Update - get the row by keyValue
if ($keyName != '' and $keyValue != '') $db->getRow($keyValue);


	if(isset($_REQUEST['OwnerID'])) { $db->setOwnerID($db->myreal_escape_string($_REQUEST['OwnerID']) ); } 

		 	
	if(isset($_REQUEST['DriverID'])) { $db->setDriverID($db->myreal_escape_string($_REQUEST['DriverID']) ); } 

		 	
	if(isset($_REQUEST['AuthLevelID'])) { $db->setAuthLevelID($db->myreal_escape_string($_REQUEST['AuthLevelID']) ); } 

		 	
	if(isset($_REQUEST['DriverName'])) { $db->setDriverName($db->myreal_escape_string($_REQUEST['DriverName']) ); } 

		 	
	if(isset($_REQUEST['DriverPasswordNew'])) { $db->setDriverPassword( md5($_REQUEST['DriverPasswordNew']) ); } 

		 	
	if(isset($_REQUEST['DriverEmail'])) { $db->setDriverEmail($db->myreal_escape_string($_REQUEST['DriverEmail']) ); } 

		 	
	if(isset($_REQUEST['DriverTel'])) { $db->setDriverTel($db->myreal_escape_string($_REQUEST['DriverTel']) ); } 

		 	
	if(isset($_REQUEST['Notes'])) { $db->setNotes($db->myreal_escape_string($_REQUEST['Notes']) ); } 


	if(isset($_REQUEST['DocumentImage'])) { $db->setActive($db->myreal_escape_string($_REQUEST['DocumentImage']) ); } 
	
	
	if(isset($_REQUEST['ActionImage'])) { $db->setActive($db->myreal_escape_string($_REQUEST['ActionImage']) ); } 
	
		 	
	if(isset($_REQUEST['Active'])) { $db->setActive($db->myreal_escape_string($_REQUEST['Active']) ); } 

		 	

$upd = '';
$newID = '';

// ako je update, azuriraj trazeni slog

if ($keyName != '' and $keyValue != '') {
	$res = $db->saveRow();
	$upd = 'Updated';
	if($res !== true) $upd = $res;
}

// inace dodaj novi slog	
if ($keyName != '' and $keyValue == '') {;
	$db->setOwnerID($_SESSION['OwnerID']);
	$db->setActive(1);
	$newID = $db->saveAsNew();
}


$out = array(
	'update' => $upd,
	'insert' => $newID
);

# send output back
$output = json_encode($out);
echo $_REQUEST['callback'] . '(' . $output . ')';
	
