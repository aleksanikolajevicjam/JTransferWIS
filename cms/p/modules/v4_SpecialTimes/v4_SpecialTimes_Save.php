<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once '../../../../db/db.class.php';
	require_once '../../../../db/v4_SpecialTimes.class.php';


	# init class
	$db = new v4_SpecialTimes();

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


	if(isset($_REQUEST['ID'])) { $db->setID($db->myreal_escape_string($_REQUEST['ID']) ); } 
	if(isset($_REQUEST['OwnerID'])) { $db->setOwnerID($db->myreal_escape_string($_REQUEST['OwnerID']) ); } 
	if(isset($_REQUEST['VehicleTypeID'])) { $db->setVehicleTypeID($db->myreal_escape_string($_REQUEST['VehicleTypeID']) ); } 
	if(isset($_REQUEST['StartSeason'])) { $db->setStartSeason($db->myreal_escape_string($_REQUEST['StartSeason']) ); } 
	if(isset($_REQUEST['EndSeason'])) { $db->setEndSeason($db->myreal_escape_string($_REQUEST['EndSeason']) ); } 
	if(isset($_REQUEST['WeekDays'])) { $db->setWeekDays($db->myreal_escape_string($_REQUEST['WeekDays']) ); } 
	if(isset($_REQUEST['SpecialDate'])) { $db->setSpecialDate($db->myreal_escape_string($_REQUEST['SpecialDate']) ); } 
	if(isset($_REQUEST['StartTime'])) { $db->setStartTime($db->myreal_escape_string($_REQUEST['StartTime']) ); } 
	if(isset($_REQUEST['EndTime'])) { $db->setEndTime($db->myreal_escape_string($_REQUEST['EndTime']) ); } 
	if(isset($_REQUEST['CorrectionPercent'])) { $db->setCorrectionPercent($db->myreal_escape_string($_REQUEST['CorrectionPercent']) ); } 

		 	

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
	
