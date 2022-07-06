<?
error_reporting(E_PARSE);
@session_start();
    require_once ROOT . '/db/db.class.php';
	$db = new DataBaseMysql();

	
	if (isset($_REQUEST['id1'])) $id1=$_REQUEST['id1'];
	else $id1=0;
	if (isset($_REQUEST['id2'])) $id2=$_REQUEST['id2'];
	else $id2=0;	

	$routes = array(); $i = 0;
	$result = $db->RunQuery("SELECT `RouteID` FROM `v4_Routes` WHERE `FromID`=".$id1." and `ToID`=".$id2."");
	$row = $result->fetch_array(MYSQLI_ASSOC);
	if (count($row)>0) $rid= $row["RouteID"];	
	else $rid=0;
		
	if (!isset($_SESSION['visitid'])) { 
		if ($_SERVER['REQUEST_URI']=='booking') $rid1=0;
		else $rid1=$rid;	
		$resin = $db->RunQuery("INSERT INTO `v4_Visits`(`time`, `IP`, `Route1ID`) VALUES (".time().",'".$_SERVER['REMOTE_ADDR']."',".$rid1.")");			
		$_SESSION['visitid']=$db->conn->insert_id;
	}
	$resup = $db->RunQuery("UPDATE `v4_Visits` SET `Route2ID`=".$rid."  WHERE `VisitID` =" . $_SESSION['visitid']);			
		
	if ($rid>0)	{
		$drivers = array(); $j = 0;
		$result2 = $db->RunQuery("SELECT `OwnerID` FROM `v4_DriverRoutes` WHERE `RouteID`=".$rid." AND `Active`=1");
		while($row2 = $result2->fetch_array(MYSQLI_ASSOC)){
			$drivers[$j] = $row2["OwnerID"];
			$j++;
		}		
		
		foreach ($drivers as $dr)
		{
			$specials = array(); $k = 0;
			$result3 = $db->RunQuery("SELECT * FROM `v4_DriverMessages` WHERE `OwnerID`=".$dr."");
			if (count (result3)>0) {
				while($row3 = $result3->fetch_array(MYSQLI_ASSOC)){
					$spec_arr=array();
					$spec_arr['msg'] = $row3["Message"];
					$spec_arr['phone'] = $row3["Phone"];
					$res = json_encode($spec_arr);
					//echo $res;
					ob_start();
					echo $_GET['callback'] . '(' . $res. ')';
					ob_end_flush();
					exit ();
					$k++;
				}		
			}
		}	
	}	
    else {
		//echo json_encode(array());
		ob_start();
		echo $_GET['callback'] . '(' . json_encode(array()). ')';
		ob_end_flush();
	}	
	


