<?
	error_reporting(0);	
		require_once $_SERVER['DOCUMENT_ROOT'] .'/db/db.class.php';
		$db = new DataBaseMysql(); 
		$sql="SELECT MConfirmFile FROM `v4_OrdersMaster` WHERE `MOrderDate`>NOW() - INTERVAL 90 DAY and MConfirmFile<>'' and `MOrderStatus` not in (3,9)";
		$r = $db->RunQuery($sql);
		while ($t = $r->fetch_object()) {
			$refNo[]=$t->MConfirmFile;
		}	
		$password = file_get_contents('weby_key.inc', FILE_USE_INCLUDE_PATH);
		if ($password!=$_REQUEST['weby_key']) {
			$handle1 = fopen('weby_key.inc', 'w');
			fwrite($handle1, $_REQUEST['weby_key']);
			$password=$_REQUEST['weby_key'];
		}	
		$link="https://city-airport-taxis.com/api/getAllBookingsConfirmedPast48?password=".$password;   
		$json = file_get_contents($link);   
		if ($json) {
			$obj = json_decode($json,true);
			$cnt=count($obj['data']);
			if ($cnt>0) {
				$html="<option value='No'>Reference Number</option>";
				for ($i = 0; $i < $cnt; $i++) {
					$rr=$obj['data'][$i]['reservation_reference'];
					if (!in_array($rr, $refNo)) $html.="<option value='".$rr."'>".$rr."</option>";
				}
				echo $html;
			}
			else echo 'No';
		}
		else echo 'No'; 	
?>