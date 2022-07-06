<?
error_reporting(E_PARSE);

    require_once ROOT . '/db/db.class.php';
	

	
	$db = new DataBaseMysql();
	
	$routes = array(); $i = 0;
	$result = $db->RunQuery("SELECT `RouteID`,`RouteName` FROM `v4_Routes` WHERE `FromID`=".$_REQUEST['id1']." and `ToID`=".$_REQUEST['id2']."");
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$routes[$i]['id'] = $row["RouteID"];
		$routes[$i]['name'] = $row["RouteName"];
		$i++;
	}

	foreach ($routes as $rt)
	{
		$drivers = array(); $j = 0;
		$result2 = $db->RunQuery("SELECT `OwnerID` FROM `v4_DriverRoutes` WHERE `RouteID`=".$rt['id']." AND `Active`=1");
		while($row2 = $result2->fetch_array(MYSQLI_ASSOC)){
			$drivers[$j] = $row2["OwnerID"];
			$j++;
		}		
		
		foreach ($drivers as $dr)
		{ 
			if ($dr=876) echo $rt['id']."-".$rt['name']."<br>";
			
			$specials = array(); $k = 0;
			$result3 = $db->RunQuery("SELECT * FROM `v4_DriverMessages` WHERE `OwnerID`=".$dr."");
			if (count (result3)>0) {
				while($row3 = $result3->fetch_array(MYSQLI_ASSOC)){
					$spec_arr=array();
					$spec_arr['msg'] = $row3["Message"];
					$spec_arr['phone'] = $row3["Phone"];
				}		
			}
		}		
	}



