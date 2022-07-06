<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once '../../../../db/db.class.php';
	require_once '../../../../db/v4_DaySettings.class.php';


	# init class
	$db = new v4_DaySettings();

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

		 	
	if(isset($_REQUEST['OwnerID'])) { $db->setOwnerID($db->myreal_escape_string($_REQUEST['OwnerID']) ); } 

		 	
	if(isset($_REQUEST['MonPercent'])) { $db->setMonPercent($db->myreal_escape_string($_REQUEST['MonPercent']) ); } 

		 	
	if(isset($_REQUEST['MonAmount'])) { $db->setMonAmount($db->myreal_escape_string($_REQUEST['MonAmount']) ); } 

		 	
	if(isset($_REQUEST['TuePercent'])) { $db->setTuePercent($db->myreal_escape_string($_REQUEST['TuePercent']) ); } 

		 	
	if(isset($_REQUEST['TueAmount'])) { $db->setTueAmount($db->myreal_escape_string($_REQUEST['TueAmount']) ); } 

		 	
	if(isset($_REQUEST['WedPercent'])) { $db->setWedPercent($db->myreal_escape_string($_REQUEST['WedPercent']) ); } 

		 	
	if(isset($_REQUEST['WedAmount'])) { $db->setWedAmount($db->myreal_escape_string($_REQUEST['WedAmount']) ); } 

		 	
	if(isset($_REQUEST['ThuPercent'])) { $db->setThuPercent($db->myreal_escape_string($_REQUEST['ThuPercent']) ); } 

		 	
	if(isset($_REQUEST['ThuAmount'])) { $db->setThuAmount($db->myreal_escape_string($_REQUEST['ThuAmount']) ); } 

		 	
	if(isset($_REQUEST['FriPercent'])) { $db->setFriPercent($db->myreal_escape_string($_REQUEST['FriPercent']) ); } 

		 	
	if(isset($_REQUEST['FriAmount'])) { $db->setFriAmount($db->myreal_escape_string($_REQUEST['FriAmount']) ); } 

		 	
	if(isset($_REQUEST['SatPercent'])) { $db->setSatPercent($db->myreal_escape_string($_REQUEST['SatPercent']) ); } 

		 	
	if(isset($_REQUEST['SatAmount'])) { $db->setSatAmount($db->myreal_escape_string($_REQUEST['SatAmount']) ); } 

		 	
	if(isset($_REQUEST['SunPercent'])) { $db->setSunPercent($db->myreal_escape_string($_REQUEST['SunPercent']) ); } 

		 	
	if(isset($_REQUEST['SunAmount'])) { $db->setSunAmount($db->myreal_escape_string($_REQUEST['SunAmount']) ); } 

		 	

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
	
