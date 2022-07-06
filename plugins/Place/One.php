<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once 'Initial.php';

	# init libs
	require_once ROOT . '/db/v4_AuthUsers.class.php';
	require_once ROOT . '/db/v4_DriverTerminals.class.php';
	

	# init vars
	$out = array();

	# init class
	$au = new v4_AuthUsers();

	# filters
	$db->getRow($_REQUEST['ItemID']);

	# get fields and values
	$detailFlds = $db->fieldValues();
	if (isset($_SESSION['UseDriverID']) && $_SESSION['UseDriverID']>0) $detailFlds['UseDriverID']=$_SESSION['UseDriverID'];
	else $detailFlds['UseDriverID']=0;
    
    # remove slashes 
    foreach ($detailFlds as $key=>$value) {
        $detailFlds[$key] = stripslashes($value);
    }

	$name=$db->getPlaceNameEN();
	$name2.=$name.",_".$db->getCountryNameEN();
	
	$url='https://en.wikipedia.org/w/api.php?action=query&prop=extracts&format=json&exintro=&titles='.$name2;
						
	$json = file_get_contents($url);  
	$obj="";
	if ($json) {
		$obj = json_decode($json,true);
		$arrey=$obj['query']['pages'];
		$desc='';
		foreach ($arrey as $arr) {
			$desc=($arr['extract']);  
		}
		if (empty($desc)) {
			$url='https://en.wikipedia.org/w/api.php?action=query&prop=extracts&format=json&exintro=&titles='.$name;
			$json = file_get_contents($url);  
			if ($json) {
				$obj = json_decode($json,true);
				$arrey=$obj['query']['pages'];
				$desc='';
				foreach ($arrey as $arr) {
					$desc=($arr['extract']);  
				}
			}
		}
	}
	else $desc="";
	
	$detailFlds['WikiDesc']=strip_tags($desc);
	
	class v4_TerminalsJoin extends v4_DriverTerminals {
		public function getKeysBy($column, $order, $where = NULL){
			$keys = array(); $i = 0; 
			$where=" WHERE v4_DriverTerminals.TerminalID=".$_REQUEST['ItemID'] ;
			 
			$result = $this->connection->RunQuery(
						"SELECT v4_DriverTerminals.ID,v4_DriverTerminals.DriverID FROM v4_DriverTerminals WHERE v4_DriverTerminals.TerminalID=".$_REQUEST['ItemID']);
				while($row = $result->fetch_array(MYSQLI_ASSOC)){
					$keys[$i] = $row["DriverID"];
					$i++;
				}

		return $keys;
		}
	}	
	
	$dt = new v4_TerminalsJoin();
	$dtk = $dt->getKeysBy('DriverID ASC ', '', '');
	if (count($dtk) != 0) {
		foreach ($dtk as $nn => $key)
		{
			$au->getRow($key);
			$drivers .= $au->getAuthUserCompany() ." / ";
		}
		$detailFlds["Drivers"] = $drivers;
	}
	//Da li je lokacija terminal?
	$detailFlds["Terminal"]=0;
	if (isset($_SESSION['UseDriverID']) && $_SESSION['UseDriverID']>0) 
		$result = $dbT->RunQuery("SELECT * FROM v4_DriverTerminals WHERE TerminalID=".$_REQUEST['ItemID']." AND DriverID=".$_SESSION['UseDriverID']); 
	else 
		$result = $dbT->RunQuery("SELECT * FROM v4_Terminals WHERE TerminalID=".$_REQUEST['ItemID']);
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$detailFlds["Terminal"]=1;
		}	
	
	$out[] = $detailFlds;

	# send output back
	$output = json_encode($out);
	echo $_GET['callback'] . '(' . $output . ')';
	