<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once '../../../../db/db.class.php';
	require_once '../../../../db/v4_Drivers.class.php';


	# init class
	$db = new v4_Drivers();

# init vars
$keyName = '';
$keyValue = '';

if (isset($_REQUEST['keyName']) and $_REQUEST['keyName'] != '') 	$keyName = $_REQUEST['keyName'];
if (isset($_REQUEST['keyValue']) and $_REQUEST['keyValue'] != '') 	$keyValue = $_REQUEST['keyValue'];

$fldList = array();
$out = array();


# if Update - get the row by keyValue
if ($keyName != '' and $keyValue != '') $db->getRow($keyValue);


	if(isset($_REQUEST['SiteID'])) { $db->setSiteID($db->myreal_escape_string($_REQUEST['SiteID']) ); } 

		 	
	if(isset($_REQUEST['DriverID'])) { $db->setDriverID($db->myreal_escape_string($_REQUEST['DriverID']) ); } 

		 	
	if(isset($_REQUEST['Country'])) { $db->setCountry($db->myreal_escape_string($_REQUEST['Country']) ); } 

		 	
	if(isset($_REQUEST['Company'])) { $db->setCompany($db->myreal_escape_string($_REQUEST['Company']) ); } 

		 	
	if(isset($_REQUEST['Tel'])) { $db->setTel($db->myreal_escape_string($_REQUEST['Tel']) ); } 

		 	
	if(isset($_REQUEST['Fax'])) { $db->setFax($db->myreal_escape_string($_REQUEST['Fax']) ); } 

		 	
	if(isset($_REQUEST['City'])) { $db->setCity($db->myreal_escape_string($_REQUEST['City']) ); } 

		 	
	if(isset($_REQUEST['Terminal'])) { $db->setTerminal($db->myreal_escape_string($_REQUEST['Terminal']) ); } 

		 	
	if(isset($_REQUEST['Account'])) { $db->setAccount($db->myreal_escape_string($_REQUEST['Account']) ); } 

		 	
	if(isset($_REQUEST['IBAN'])) { $db->setIBAN($db->myreal_escape_string($_REQUEST['IBAN']) ); } 

		 	
	if(isset($_REQUEST['Active'])) { $db->setActive($db->myreal_escape_string($_REQUEST['Active']) ); } 

		 	
	if(isset($_REQUEST['Prezime'])) { $db->setPrezime($db->myreal_escape_string($_REQUEST['Prezime']) ); } 

		 	
	if(isset($_REQUEST['Ime'])) { $db->setIme($db->myreal_escape_string($_REQUEST['Ime']) ); } 

		 	
	if(isset($_REQUEST['Email'])) { $db->setEmail($db->myreal_escape_string($_REQUEST['Email']) ); } 

		 	
	if(isset($_REQUEST['Opis'])) { $db->setOpis($db->myreal_escape_string($_REQUEST['Opis']) ); } 

		 	
	if(isset($_REQUEST['Discount'])) { $db->setDiscount($db->myreal_escape_string($_REQUEST['Discount']) ); } 

		 	

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
	
