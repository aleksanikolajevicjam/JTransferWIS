<?
	header("Content-type: image/jpeg");
	require '../config.php';
	//error_reporting(E_PARSE);


	if (!isset($_REQUEST['UserID']) or $_REQUEST['UserID'] == '') {
		$img = file_get_contents(ROOT . '/cms/img/default.jpg');
		echo $img;
		die();
	}
	
	//require $_SERVER['DOCUMENT_ROOT'] . '/db/db.class.php';
	
	$db = new DataBaseMysql();
			
	$r = $db->RunQuery("SELECT DBImage, DBImageType FROM v4_AuthUsers 
	                    WHERE AuthUserID = " . $_REQUEST['UserID']);
	$img = $r->fetch_object();
	
	if($r->num_rows > 0 and !empty($img->DBImage)) {
		header("Content-type: $img->DBImageType");
		echo $img->DBImage;
	} 

	else {
		$r = $db->RunQuery("SELECT CustImage, CustImageType FROM v4_Customers 
		                    WHERE CustID = " . $_REQUEST['UserID']);
		$img = $r->fetch_object();
	
		if($r->num_rows > 0 and !empty($img->CustImage)) {
			header("Content-type: $img->CustImageType");
			echo $img->CustImage;
		}

		else { 
		header("Content-type: image/jpg");
		$img = file_get_contents(ROOT . '/cms/img/default.jpg');
		echo $img;
		}
	}