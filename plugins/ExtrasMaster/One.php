<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once 'Initial.php';
	require_once ROOT . '/db/v4_Extras.class.php';
	$ex = new v4_Extras();

	$out = array();
	# Details  red
	$db->getRow($_REQUEST['ItemID']);
	# get fields and values
	$detailFlds = $db->fieldValues();
	if (isset($_SESSION['UseDriverID']) && $_SESSION['UseDriverID']>0) $detailFlds['UseDriverID']=$_SESSION['UseDriverID'];
	else $detailFlds['UseDriverID']=0;	
	# remove slashes 
	foreach ($detailFlds as $key=>$value) {
		$detailFlds[$key] = stripslashes($value);
	}
	$detailFlds["DriverExtras"]=0;
	if (isset($_SESSION['UseDriverID']) && $_SESSION['UseDriverID']>0) {
		$result = $dbT->RunQuery("SELECT * FROM v4_Extras WHERE ServiceID=".$_REQUEST['ItemID']." AND OwnerID=".$_SESSION['UseDriverID']); 
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$detailFlds["DriverExtras"]=1;
		}
	}	

	$out[] = $detailFlds;
	# send output back
	$output = json_encode($out);
	echo $_GET['callback'] . '(' . $output . ')';