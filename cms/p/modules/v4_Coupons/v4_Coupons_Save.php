<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once '../../../../db/db.class.php';
	require_once '../../../../db/v4_Coupons.class.php';


	# init class
	$db = new v4_Coupons();
	

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

		 	
	if(isset($_REQUEST['CreatorID'])) { $db->setCreatorID($db->myreal_escape_string($_REQUEST['CreatorID']) ); } 

		 	
	if(isset($_REQUEST['Code'])) { $db->setCode($db->myreal_escape_string($_REQUEST['Code']) ); } 

		 	
	if(isset($_REQUEST['Discount'])) { $db->setDiscount($db->myreal_escape_string($_REQUEST['Discount']) ); } 

		 	
	if(isset($_REQUEST['VehicleTypeID'])) { $db->setVehicleTypeID($db->myreal_escape_string($_REQUEST['VehicleTypeID']) ); } 
	
	
	if(isset($_REQUEST['DriverID'])) { $db->setDriverID($db->myreal_escape_string($_REQUEST['DriverID']) ); } 

		 	
	if(isset($_REQUEST['ValidFrom'])) { $db->setValidFrom($db->myreal_escape_string($_REQUEST['ValidFrom']) ); } 

		 	
	if(isset($_REQUEST['ValidTo'])) { $db->setValidTo($db->myreal_escape_string($_REQUEST['ValidTo']) ); } 

		 	
	if(isset($_REQUEST['TransferFromDate'])) { $db->setTransferFromDate($db->myreal_escape_string($_REQUEST['TransferFromDate']) ); } 

		 	
	if(isset($_REQUEST['TransferToDate'])) { $db->setTransferToDate($db->myreal_escape_string($_REQUEST['TransferToDate']) ); } 

		 	
	if(isset($_REQUEST['LimitLocationID'])) { $db->setLimitLocationID($db->myreal_escape_string($_REQUEST['LimitLocationID']) ); } 

		 	
	if(isset($_REQUEST['WeekdaysOnly'])) { $db->setWeekdaysOnly($db->myreal_escape_string($_REQUEST['WeekdaysOnly']) ); } 

		 	
	if(isset($_REQUEST['ReturnOnly'])) { $db->setReturnOnly($db->myreal_escape_string($_REQUEST['ReturnOnly']) ); } 

		 	
	if(isset($_REQUEST['Active'])) { $db->setActive($db->myreal_escape_string($_REQUEST['Active']) ); } 

		 	
	if(isset($_REQUEST['TimesUsed'])) { $db->setTimesUsed($db->myreal_escape_string($_REQUEST['TimesUsed']) ); } 

		 	

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
	