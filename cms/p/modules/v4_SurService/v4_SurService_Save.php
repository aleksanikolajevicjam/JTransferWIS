<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once '../../../../db/db.class.php';
	require_once '../../../../db/v4_SurService.class.php';


	# init class
	$db = new v4_SurService();

	# init vars
	$new = false;

	$dbk = $db->getKeysBy('ServiceID','asc','WHERE ServiceID='.$_REQUEST['ServiceID'].' AND OwnerID='.$_REQUEST['OwnerID']);
	
	if(count($dbk) == 1) $new = false;
	else $new = true;



$fldList = array();
$out = array();


# if Update - get the row by keyValue
if (!$new) $db->getRow($keyValue);


	if(isset($_REQUEST['ID'])) { $db->setID($db->myreal_escape_string($_REQUEST['ID']) ); } 

		 	
	if(isset($_REQUEST['SiteID'])) { $db->setSiteID($db->myreal_escape_string($_REQUEST['SiteID']) ); } 

		 	
	if(isset($_REQUEST['OwnerID'])) { $db->setOwnerID($db->myreal_escape_string($_REQUEST['OwnerID']) ); } 

		 	
	if(isset($_REQUEST['ServiceID'])) { $db->setServiceID($db->myreal_escape_string($_REQUEST['ServiceID']) ); } 

		 	
	if(isset($_REQUEST['NightStart'])) { $db->setNightStart($db->myreal_escape_string($_REQUEST['NightStart']) ); } 

		 	
	if(isset($_REQUEST['NightEnd'])) { $db->setNightEnd($db->myreal_escape_string($_REQUEST['NightEnd']) ); } 

		 	
	if(isset($_REQUEST['NightPercent'])) { $db->setNightPercent($db->myreal_escape_string($_REQUEST['NightPercent']) ); } 

		 	
	if(isset($_REQUEST['NightAmount'])) { $db->setNightAmount($db->myreal_escape_string($_REQUEST['NightAmount']) ); } 

		 	
	if(isset($_REQUEST['WeekendPercent'])) { $db->setWeekendPercent($db->myreal_escape_string($_REQUEST['WeekendPercent']) ); } 

		 	
	if(isset($_REQUEST['WeekendAmount'])) { $db->setWeekendAmount($db->myreal_escape_string($_REQUEST['WeekendAmount']) ); } 

		 	
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

		 	
	if(isset($_REQUEST['S1Start'])) { $db->setS1Start($db->myreal_escape_string($_REQUEST['S1Start']) ); } 

		 	
	if(isset($_REQUEST['S1End'])) { $db->setS1End($db->myreal_escape_string($_REQUEST['S1End']) ); } 

		 	
	if(isset($_REQUEST['S1Percent'])) { $db->setS1Percent($db->myreal_escape_string($_REQUEST['S1Percent']) ); } 

		 	
	if(isset($_REQUEST['S2Start'])) { $db->setS2Start($db->myreal_escape_string($_REQUEST['S2Start']) ); } 

		 	
	if(isset($_REQUEST['S2End'])) { $db->setS2End($db->myreal_escape_string($_REQUEST['S2End']) ); } 

		 	
	if(isset($_REQUEST['S2Percent'])) { $db->setS2Percent($db->myreal_escape_string($_REQUEST['S2Percent']) ); } 

		 	
	if(isset($_REQUEST['S3Start'])) { $db->setS3Start($db->myreal_escape_string($_REQUEST['S3Start']) ); } 

		 	
	if(isset($_REQUEST['S3End'])) { $db->setS3End($db->myreal_escape_string($_REQUEST['S3End']) ); } 

		 	
	if(isset($_REQUEST['S3Percent'])) { $db->setS3Percent($db->myreal_escape_string($_REQUEST['S3Percent']) ); } 

		 	
	if(isset($_REQUEST['S4Start'])) { $db->setS4Start($db->myreal_escape_string($_REQUEST['S4Start']) ); } 

		 	
	if(isset($_REQUEST['S4End'])) { $db->setS4End($db->myreal_escape_string($_REQUEST['S4End']) ); } 

		 	
	if(isset($_REQUEST['S4Percent'])) { $db->setS4Percent($db->myreal_escape_string($_REQUEST['S4Percent']) ); } 

	if(isset($_REQUEST['S5Start'])) { $db->setS5Start($db->myreal_escape_string($_REQUEST['S5Start']) ); } 

		 	
	if(isset($_REQUEST['S5End'])) { $db->setS5End($db->myreal_escape_string($_REQUEST['S5End']) ); } 

		 	
	if(isset($_REQUEST['S5Percent'])) { $db->setS5Percent($db->myreal_escape_string($_REQUEST['S5Percent']) ); } 

		 	
	if(isset($_REQUEST['S6Start'])) { $db->setS6Start($db->myreal_escape_string($_REQUEST['S6Start']) ); } 

		 	
	if(isset($_REQUEST['S6End'])) { $db->setS6End($db->myreal_escape_string($_REQUEST['S6End']) ); } 

		 	
	if(isset($_REQUEST['S6Percent'])) { $db->setS6Percent($db->myreal_escape_string($_REQUEST['S6Percent']) ); } 

		 	
	if(isset($_REQUEST['S7Start'])) { $db->setS7Start($db->myreal_escape_string($_REQUEST['S7Start']) ); } 

		 	
	if(isset($_REQUEST['S7End'])) { $db->setS7End($db->myreal_escape_string($_REQUEST['S7End']) ); } 

		 	
	if(isset($_REQUEST['S7Percent'])) { $db->setS7Percent($db->myreal_escape_string($_REQUEST['S7Percent']) ); } 

		 	
	if(isset($_REQUEST['S8Start'])) { $db->setS8Start($db->myreal_escape_string($_REQUEST['S8Start']) ); } 

		 	
	if(isset($_REQUEST['S8End'])) { $db->setS8End($db->myreal_escape_string($_REQUEST['S8End']) ); } 

		 	
	if(isset($_REQUEST['S8Percent'])) { $db->setS8Percent($db->myreal_escape_string($_REQUEST['S8Percent']) ); } 

		 	
	if(isset($_REQUEST['S9Start'])) { $db->setS9Start($db->myreal_escape_string($_REQUEST['S9Start']) ); } 

		 	
	if(isset($_REQUEST['S9End'])) { $db->setS9End($db->myreal_escape_string($_REQUEST['S9End']) ); } 

		 	
	if(isset($_REQUEST['S9Percent'])) { $db->setS9Percent($db->myreal_escape_string($_REQUEST['S9Percent']) ); } 

		 	
	if(isset($_REQUEST['S10Start'])) { $db->setS10Start($db->myreal_escape_string($_REQUEST['S10Start']) ); } 

		 	
	if(isset($_REQUEST['S10End'])) { $db->setS10End($db->myreal_escape_string($_REQUEST['S10End']) ); } 

		 	
	if(isset($_REQUEST['S10Percent'])) { $db->setS10Percent($db->myreal_escape_string($_REQUEST['S10Percent']) ); } 			 	

$upd = '';
$newID = '';

// ako je update, azuriraj trazeni slog

if (!$new) {
	$res = $db->saveRow();
	$upd = 'Updated';
	if($res !== true) $upd = $res;
}

// inace dodaj novi slog	
if ($new) {
	$newID = $db->saveAsNew();
}


$out = array(
	'update' => $upd,
	'insert' => $newID
);

# send output back
$output = json_encode($out);
echo $_REQUEST['callback'] . '(' . $output . ')';
	
