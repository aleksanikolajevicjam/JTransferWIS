<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once '../../../../db/db.class.php';
	require_once '../../../../db/v4_Invoices.class.php';


	# init class
	$db = new v4_Invoices();

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

		 	
	if(isset($_REQUEST['UserID'])) { $db->setUserID($db->myreal_escape_string($_REQUEST['UserID']) ); } 

		 	
	if(isset($_REQUEST['Type'])) { $db->setType($db->myreal_escape_string($_REQUEST['Type']) ); } 

		 	
	if(isset($_REQUEST['StartDate'])) { $db->setStartDate($db->myreal_escape_string($_REQUEST['StartDate']) ); } 

		 	
	if(isset($_REQUEST['EndDate'])) { $db->setEndDate($db->myreal_escape_string($_REQUEST['EndDate']) ); } 

		 	
	if(isset($_REQUEST['InvoiceNumber'])) { $db->setInvoiceNumber($db->myreal_escape_string($_REQUEST['InvoiceNumber']) ); } 

		 	
	if(isset($_REQUEST['InvoiceDate'])) { $db->setInvoiceDate($db->myreal_escape_string($_REQUEST['InvoiceDate']) ); } 

		 	
	if(isset($_REQUEST['DueDate'])) { $db->setDueDate($db->myreal_escape_string($_REQUEST['DueDate']) ); } 

		 	
	if(isset($_REQUEST['SumPrice'])) { $db->setSumPrice($db->myreal_escape_string($_REQUEST['SumPrice']) ); } 

		 	
	if(isset($_REQUEST['SumSubtotal'])) { $db->setSumSubtotal($db->myreal_escape_string($_REQUEST['SumSubtotal']) ); } 

		 	
	if(isset($_REQUEST['CommPrice'])) { $db->setCommPrice($db->myreal_escape_string($_REQUEST['CommPrice']) ); } 

		 	
	if(isset($_REQUEST['CommSubtotal'])) { $db->setCommSubtotal($db->myreal_escape_string($_REQUEST['CommSubtotal']) ); } 

		 	
	if(isset($_REQUEST['TotalPriceEUR'])) { $db->setTotalPriceEUR($db->myreal_escape_string($_REQUEST['TotalPriceEUR']) ); } 

		 	
	if(isset($_REQUEST['TotalSubTotalEUR'])) { $db->setTotalSubTotalEUR($db->myreal_escape_string($_REQUEST['TotalSubTotalEUR']) ); } 

		 	
	if(isset($_REQUEST['VATNotApp'])) { $db->setVATNotApp($db->myreal_escape_string($_REQUEST['VATNotApp']) ); } 

		 	
	if(isset($_REQUEST['VATBaseTotal'])) { $db->setVATBaseTotal($db->myreal_escape_string($_REQUEST['VATBaseTotal']) ); } 

		 	
	if(isset($_REQUEST['VATtotal'])) { $db->setVATtotal($db->myreal_escape_string($_REQUEST['VATtotal']) ); } 

		 	
	if(isset($_REQUEST['GrandTotal'])) { $db->setGrandTotal($db->myreal_escape_string($_REQUEST['GrandTotal']) ); } 

		 	
	if(isset($_REQUEST['CreatedBy'])) { $db->setCreatedBy($db->myreal_escape_string($_REQUEST['CreatedBy']) ); } 

		 	
	if(isset($_REQUEST['CreatedDate'])) { $db->setCreatedDate($db->myreal_escape_string($_REQUEST['CreatedDate']) ); } 

		 	
	if(isset($_REQUEST['Note'])) { $db->setNote($db->myreal_escape_string($_REQUEST['Note']) ); } 

		 	
	if(isset($_REQUEST['PaymentDate'])) { $db->setPaymentDate($db->myreal_escape_string($_REQUEST['PaymentDate']) ); } 

		 	
	if(isset($_REQUEST['PaymentAmtEUR'])) { $db->setPaymentAmtEUR($db->myreal_escape_string($_REQUEST['PaymentAmtEUR']) ); } 

		 	
	//if(isset($_REQUEST['Status'])) { $db->setStatus($db->myreal_escape_string($_REQUEST['Status']) ); } 
	
	if(isset($_REQUEST['PaymentStatus'])) { 
		$db->setStatus($db->myreal_escape_string($_REQUEST['PaymentStatus']) ); 			
		$query="UPDATE `v4_OrderDetails` SET `PaymentStatus`=".$_REQUEST['PaymentStatus']." WHERE `InvoiceNumber`='".$_REQUEST['InvoiceNumber']."'"; 
		$base = new  DataBaseMysql();
		$base->RunQuery($query);  
	} 
	if(isset($_REQUEST['DriverPayment'])) { 
		$db->setStatus($db->myreal_escape_string($_REQUEST['DriverPayment']) ); 		
		$query="UPDATE `v4_OrderDetails` SET `DriverPayment`=".$_REQUEST['DriverPayment']." WHERE `DriverInvoiceNumber`='".$_REQUEST['InvoiceNumber']."'";
		$base = new  DataBaseMysql();
		$base->RunQuery($query);  
	} 

		 	

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
	