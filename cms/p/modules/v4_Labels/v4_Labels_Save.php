<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once ROOT . '/db/db.class.php';
	require_once ROOT . '/db/v4_Labels.class.php';


	# init class
	$db = new v4_Labels();

# init vars
$keyName = '';
$keyValue = '';

if (isset($_REQUEST['keyName']) and $_REQUEST['keyName'] != '') 	$keyName = $_REQUEST['keyName'];
if (isset($_REQUEST['keyValue']) and $_REQUEST['keyValue'] != '') 	$keyValue = $_REQUEST['keyValue'];

$fldList = array();
$out = array();


# if Update - get the row by keyValue
if ($keyName != '' and $keyValue != '') $db->getRow($keyValue);


	if(isset($_REQUEST['LabelID'])) { $db->setLabelID($db->myreal_escape_string($_REQUEST['LabelID']) ); } 

		 	
	if(isset($_REQUEST['Label'])) { $db->setLabel($db->myreal_escape_string($_REQUEST['Label']) ); } 

		 	
	if(isset($_REQUEST['LabelEN'])) { $db->setLabelEN($db->myreal_escape_string($_REQUEST['LabelEN']) ); } 

		 	
	if(isset($_REQUEST['LabelRU'])) { $db->setLabelRU($db->myreal_escape_string($_REQUEST['LabelRU']) ); } 

		 	
	if(isset($_REQUEST['LabelFR'])) { $db->setLabelFR($db->myreal_escape_string($_REQUEST['LabelFR']) ); } 

		 	
	if(isset($_REQUEST['LabelDE'])) { $db->setLabelDE($db->myreal_escape_string($_REQUEST['LabelDE']) ); } 

		 	
	if(isset($_REQUEST['LabelIT'])) { $db->setLabelIT($db->myreal_escape_string($_REQUEST['LabelIT']) ); } 

		 	
	if(isset($_REQUEST['LabelSE'])) { $db->setLabelSE($db->myreal_escape_string($_REQUEST['LabelSE']) ); } 

		 	
	if(isset($_REQUEST['LabelNO'])) { $db->setLabelNO($db->myreal_escape_string($_REQUEST['LabelNO']) ); } 

		 	
	if(isset($_REQUEST['LabelES'])) { $db->setLabelES($db->myreal_escape_string($_REQUEST['LabelES']) ); } 

		 	
	if(isset($_REQUEST['LabelNL'])) { $db->setLabelNL($db->myreal_escape_string($_REQUEST['LabelNL']) ); } 

		 	

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
	