<?php
/*
	AJAX Script !!!!
*/
require_once "../../config.php";
if (!isset($_REQUEST["cal_month"])) {
    if (!isset($_SESSION["cal_month"])) $cMonth = date("m");
    else $cMonth = $_SESSION["cal_month"]; 
}
else {
    $_SESSION['cal_month'] = $_REQUEST["cal_month"];
    $cMonth = $_REQUEST["cal_month"];
}
if (!isset($_REQUEST["cal_year"])) {
    if (!isset($_SESSION["cal_year"])) $cYear = date("Y");
    else $cYear = $_SESSION["cal_year"];
}
else {
    $_SESSION['cal_year'] = $_REQUEST["cal_year"];
    $cYear = $_REQUEST["cal_year"];
}
$prev_year = $cYear;
$next_year = $cYear;
$prev_month = $cMonth-1;
$next_month = $cMonth+1;
if ($prev_month == 0 ) {
	$prev_month = 12;
	$prev_year = $cYear - 1;
}
if ($next_month == 13 ) {
	$next_month = 1;
	$next_year = $cYear + 1;
}
$timestamp = mktime(0,0,0,$cMonth,1,$cYear);
$maxday = date("t",$timestamp);
$thismonth = getdate ($timestamp);
$startday = $thismonth['wday'];
$dayin="";
for ($i=0; $i<($maxday+$startday); $i++) {
	$fullDate = date("Y-m-d",mktime(0,0,0,$cMonth,($i - $startday + 1),$cYear));
	$dayin .= "'".$fullDate. "'," ;
}	
$dayin = substr($dayin,0,strlen($dayin)-1);

$active = "SELECT * FROM ".DB_PREFIX."OrderDetails
			WHERE PickupDate IN (".$dayin.") ";
if ($_SESSION['AuthLevelID'] == DRIVER_USER)  $active .=	"AND DriverID = '".$_SESSION['AuthUserID']."' ";
$active .=	"AND TransferStatus != '4' AND TransferStatus != '9'
			ORDER BY PickupDate, PickupTime ASC
			";
$rec = $db->RunQuery($active) ;
$tr_arr=array();
while ($row = $rec->fetch_assoc() ) {
	$tr_arr[]=$row;
}
$rec=$tr_arr;
$timestamp = mktime(0,0,0,$cMonth,1,$cYear);
$maxday = date("t",$timestamp);
$thismonth = getdate ($timestamp);
$startday = $thismonth['wday'];
for ($i=0; $i<($maxday+$startday); $i++) {
		$fullDate = date("Y-m-d",mktime(0,0,0,$cMonth,($i - $startday + 1),$cYear));
		$month_transfers[]=monthTransfers($fullDate,$rec,$i,$startday);
}	
$smarty->assign('month_transfers',$month_transfers);
$smarty->assign('startday',$startday);
$smarty->display('monthtransfers.tpl');		

function monthTransfers($date,$rec,$count,$startday)
{
	global $StatusDescription;
	global $DriverConfStatus;

	$data = '';
	$noOfTransfers = 0;
	foreach ($rec as $row) { 
		if ($row['PickupDate']==$date) {
			if ($row['TransferStatus'] != '3') $noOfTransfers += 1;
			$arr[]= $row;
		}
	}
	$dayofweek=($count % 7);
	if($count < $startday) $dayofweek=-1;
	$dayTransfers['nom']=$count - $startday + 1;
	$dayTransfers['dayofweek']=$dayofweek;
	$dayTransfers['date']=$date;
	$dayTransfers['transfers']=$arr;
	$dayTransfers['noOfTransfers']=$noOfTransfers;
    return $dayTransfers;
}