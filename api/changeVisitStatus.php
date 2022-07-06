<?

    require_once ROOT . '/db/db.class.php';
	$db = new DataBaseMysql();
	$result = $db->RunQuery("UPDATE `v4_Visits` SET `Status`=1 WHERE `VisitID`=".$_SESSION['visitid']."");
	echo "OK";



