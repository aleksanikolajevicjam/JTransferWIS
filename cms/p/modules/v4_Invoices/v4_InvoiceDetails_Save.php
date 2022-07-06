<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once '../../../../db/db.class.php';
	require_once '../../../../db/v4_InvoiceDetails.class.php';


	# init class
	$db = new v4_InvoiceDetails();

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

		 	
	if(isset($_REQUEST['DetailsID'])) { $db->setDetailsID($db->myreal_escape_string($_REQUEST['DetailsID']) ); } 

		 	
	if(isset($_REQUEST['InvoiceNumber'])) { $db->setInvoiceNumber($db->myreal_escape_string($_REQUEST['InvoiceNumber']) ); } 

		 	
	if(isset($_REQUEST['Description'])) { $db->setDescription($db->myreal_escape_string($_REQUEST['Description']) ); } 

		 	
	if(isset($_REQUEST['Qty'])) { $db->setQty($db->myreal_escape_string($_REQUEST['Qty']) ); } 

		 	
	if(isset($_REQUEST['Price'])) { $db->setPrice($db->myreal_escape_string($_REQUEST['Price']) ); } 

		 	
	if(isset($_REQUEST['SubTotal'])) { $db->setSubTotal($db->myreal_escape_string($_REQUEST['SubTotal']) ); } 

		 	
	if(isset($_REQUEST['Changed'])) { $db->setChanged($db->myreal_escape_string($_REQUEST['Changed']) ); } 

		 	

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
	