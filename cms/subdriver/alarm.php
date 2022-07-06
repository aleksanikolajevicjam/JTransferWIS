<?
	/*session_start();
	require_once '../../db/db.class.php';
	$db = new DataBaseMySql();
	
	$oq = "SELECT * FROM `v4_UserRequest` WHERE `UserID`=".$_SESSION['AuthUserID']." and `RequestType`=1 and `TimeRequest`<time();
	$qr = mysqli_query($con, $oq) or die('Error in AuthUsers query');
	$ow = mysqli_fetch_object($qr);*/
	//echo $ow->RequestID;	
	echo "OK";
