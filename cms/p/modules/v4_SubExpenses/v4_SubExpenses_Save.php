<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);

session_start();

	# init libs
	require_once '../../../../db/db.class.php';
	require_once '../../../../db/v4_SubExpenses.class.php';


	# init class
	$db = new v4_SubExpenses();

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

		 	
	if(isset($_REQUEST['DriverID'])) { $db->setDriverID($db->myreal_escape_string($_REQUEST['DriverID']) ); } 

		 	
	if(isset($_REQUEST['Datum'])) { $db->setDatum($db->myreal_escape_string($_REQUEST['Datum']) ); } 

		 	
	if(isset($_REQUEST['Expense'])) { $db->setExpense($db->myreal_escape_string($_REQUEST['Expense']) ); } 
	
	 	
	if(isset($_REQUEST['Description'])) { $db->setDescription($db->myreal_escape_string($_REQUEST['Description']) ); } 

		 	
	if(isset($_REQUEST['Amount'])) { $db->setAmount($db->myreal_escape_string($_REQUEST['Amount']) ); } 

		 	
	if(isset($_REQUEST['Card'])) { $db->setCard($db->myreal_escape_string($_REQUEST['Card']) ); } 

		 	
	if(isset($_REQUEST['CurrencyID'])) { $db->setCurrencyID($db->myreal_escape_string($_REQUEST['CurrencyID']) ); } 


	if(isset($_REQUEST['DocumentImage'])) { $db->setDocumentImage($db->myreal_escape_string($_REQUEST['DocumentImage']) ); } 

		 	
	if(isset($_REQUEST['Approved'])) { $db->setApproved($db->myreal_escape_string($_REQUEST['Approved']) ); } 

	
	if(isset($_REQUEST['Note'])) { $db->setNote($db->myreal_escape_string($_REQUEST['Note']) ); } 


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
	$db->setOwnerID($_SESSION['OwnerID']);
	$newID = $db->saveAsNew();
}


$out = array(
	'update' => $upd,
	'insert' => $newID
);

# send output back
$output = json_encode($out);
echo $_REQUEST['callback'] . '(' . $output . ')';

