<?

		ini_set('display_errors', 1);
		ini_set('log_errors', 1);
		ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
		//error_reporting(E_ALL);

	//header('Content-Type: text/javascript; charset=UTF-8');
	require_once '../../db/db.class.php';	
	require_once '../../db/v4_OrderDetails.class.php';
	require_once '../../common/libs/Smarty.class.php'; 
		
	$smarty = new Smarty;

	$db = new DataBaseMysql(); 

	$where="WHERE";
	$dateStart=$_REQUEST['DateStart'];
	$dateEnd=$_REQUEST['DateEnd'];
	$where.="`OrderDate`>='".$dateStart."' AND `OrderDate`<='".$dateEnd."'";

	$dateStartT=$_REQUEST['DateStartT'];
	$dateEndT=$_REQUEST['DateEndT'];
	$where.=" AND `PickupDate`>='".$dateStartT."' AND `PickupDate`<='".$dateEndT."'";

	if ($_REQUEST['status1']>0) $where.=" AND `TransferStatus` = ".$_REQUEST['status1'];   
	else $where.=" AND `TransferStatus` <> 3 AND `TransferStatus` <> 9 AND `TransferStatus` <> 4";  

	if ($_REQUEST['client']<>0) { 
		if ($_REQUEST['client']==60) {
			$ids='';
			$queryclient="SELECT `AuthUserID` as id FROM `v4_AuthUsers` WHERE NOT(`Image` is NULL or `Image`=' ') ";	
			$resultc = $db->RunQuery($queryclient);
			while($row = $resultc->fetch_array(MYSQLI_ASSOC)){ 
				$ids .= $row['id']. ",";			
			}
			$ids = substr($ids,0,strlen($ids)-1);
			$users_ids = "UserID IN (".$ids.") ";    
			$where.=" AND ".$users_ids;  
		}	
		else {
			if ($_REQUEST['client']==61) {
				$_REQUEST['client']=2; 
				$ext=" AND (`Image` is NULL or `Image`=' ')  ";
			}
			else $ext='';	
			$ids='';
			$queryclient="SELECT `AuthUserID` as id FROM `v4_AuthUsers` WHERE `AuthLevelID`=".$_REQUEST['client'].$ext;	
			$resultc = $db->RunQuery($queryclient);
			while($row = $resultc->fetch_array(MYSQLI_ASSOC)){ 
				$ids .= $row['id']. ",";			
			}
			$ids = substr($ids,0,strlen($ids)-1);
			$users_ids = "UserID IN (".$ids.") ";    
			$where.=" AND ".$users_ids;   
		}
	}
	if ($_REQUEST['AgentID']>0) $where.=" AND `AgentID` = ".$_REQUEST['AgentID'];  

	/*if (isset($_REQUEST['TerminalSelect'])) { 
		$ids='';
		$queryroute="SELECT `RouteID` as id FROM `v4_Routes` WHERE `FromID` = ".$_REQUEST['TerminalSelect']." or `ToID` = ".$_REQUEST['TerminalSelect'];	
		$resultr = $db->RunQuery($queryroute);
		while($row = $resultr->fetch_array(MYSQLI_ASSOC)){ 
			$ids .= $row['id']. ",";			
		}
		$ids = substr($ids,0,strlen($ids)-1);
		$routes_ids = "RouteID IN (".$ids.") ";    
		$where.=" AND ".$routes_ids;  
	}*/

	if (isset($_REQUEST['TerminalSelect']) && $_REQUEST['Terminal']!='') { 
		$ids='';
		$queryroute="SELECT `PlaceNameEn` as name FROM `v4_Places` WHERE `PlaceID` = ".$_REQUEST['TerminalSelect'];	
		$resultr = $db->RunQuery($queryroute);
		$row = $resultr->fetch_array(MYSQLI_ASSOC);
		$placeName = $row['name'];
		$where.=" AND (PickupName = '".$placeName."' OR DropName = '".$placeName."') ";  
	}


	if ($_REQUEST['DriverID']>0 && $_REQUEST['DriverID']<9998) $where.=" AND `DriverID` = ".$_REQUEST['DriverID'];  
	if ($_REQUEST['DriverID']==9999 || $_REQUEST['DriverID']==9998) {
			$ids='';
			$queryclient="SELECT `AuthUserID` as id FROM `v4_AuthUsers` WHERE `AuthLevelID`=31 AND `ContractFile`='Inter' ";	
			$resultc = $db->RunQuery($queryclient);
			while($row = $resultc->fetch_array(MYSQLI_ASSOC)){ 
				$ids .= $row['id']. ",";			
			}
			$ids = substr($ids,0,strlen($ids)-1);
			if ($_REQUEST['DriverID']==9999) $drv_ids = "DriverID IN (".$ids.") ";    
			if ($_REQUEST['DriverID']==9998) $drv_ids = "DriverID NOT IN (".$ids.") ";   
			$where.=" AND ".$drv_ids;   		
	}	


	if ($_REQUEST['VehicleTypeID']>0) $where.=" AND `VehicleType` = ".$_REQUEST['VehicleTypeID'];  

	if ($_REQUEST['status']<>99) $where.=" AND `DriverConfStatus` = ".$_REQUEST['status'];   
	if ($_REQUEST['stype']=='stat') {
		$query="SELECT 
			`PaymentMethod` as pm,  
			count(*) as count, 
			sum(`DetailPrice`) as detailprice,
			sum(`ExtraCharge`) as extracharge,	
			sum(`ProvisionAmount`) as provision,
			sum(`InvoiceAmount`) as invoiceamount,
			sum(`DriversPrice`) as driversprice,
			sum(`DriverExtraCharge`) as driverextracharge	
			
			FROM `v4_OrderDetails` $where  ";
			
		$querye=$query."GROUP BY `PaymentMethod`";  
		//exit ($querye);
		$result = $db->RunQuery($querye);

			$out = array();
			$sumagm=0;
			$onlprsuma=0;
			while($row = $result->fetch_array(MYSQLI_ASSOC)){  
				
				switch ($row['pm']) {
					case 0:
						$method="Undefined";
						break;				
					case 1:
						$method="Online";
						break;
					case 2:
						$method="Cash";
						break;				 
					case 3:
						$method="Online/Cash";
						break;					
					case 4:
						$method="Invoice";
						break;					
					case 5:
						$method="Compesation";
						break;		
					case 6:
						$method="Invoice2";
						break;				
					case 9:
						$method="Other";
						break;	  				
				}
				$row['title']=$method;
				$gm=$row['detailprice'];
				$gm=$gm-$row['provision'];
				$gm=$gm+$row['extracharge'];
				$onlpr=0;
				if ($row['provision']==0) {
					if ($row['pm']==1) $onlpr=$gm*0.02;
					if ($row['pm']==3) $onlpr=($row['detailprice']-$row['driversprice'])*0.02;		
				}	
				$row['onlpr']=number_format($onlpr,2);
				$onlprsuma+=$onlpr;
				$gm=$gm-$onlpr;

				$gm=$gm-$row['driversprice'];
				$gm=$gm-$row['driverextracharge'];
				$row['gm']=number_format($gm,2);
				$sumagm+=$gm;
				if ($row['driversprice']>0) $row['gmr']=number_format($gm*100/$row['driversprice'],2);
				else $row['gmr']=number_format(0,2);
				
				$out[]=$row;
			}
		$result = $db->RunQuery($query);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$row['title']="<b>TOTAL</b>";
		$row['onlpr']=number_format($onlprsuma,2);
		$row['gm']=number_format($sumagm,2);
		$row['gmr']=number_format($sumagm*100/$row['driversprice'],2);

		$out[]=$row;
		$smarty->assign('data',$out);	
	}  

	if ($_REQUEST['stype']=='list') {
		$query2="SELECT * FROM `v4_OrderDetails` $where "; 
		if ($_REQUEST['lt']=='list1') $query2.=" ORDER BY `PickupDate` DESC, `PickupTime` DESC";
		else $query2.=" ORDER BY `OrderDate` DESC";
		
		$result = $db->RunQuery($query2);
		$link_arr=array();
		require_once '../lng/en_text.php';
		global $StatusDescription;
		while($row = $result->fetch_array(MYSQLI_ASSOC)){  
			$ttip = NL.
				//PICKUP_DATE.': '.$row['PickupDate'].NL.
				PICKUP_TIME.': '.$row['PickupTime'].NL.
				FLIGHT_NO.': '.$row['FlightNo'].NL.
				FLIGHT_TIME.': '.$row['FlightTime'].NL.
				//FROM.': '.$row['PickupName'].NL.
				//TO.': '.$row['DropName'].NL.
				DRIVER.': '.$row['DriverName'].NL.
				TRANSFER_STATUS .': '. $StatusDescription[$row['TransferStatus']].NL.
				$DriverConfStatus[$row['DriverConfStatus']].NL.NL;
			# Link & Tooltip
			if ($row['TransferStatus'] == '1') $driver = '<span class="text-blue"><i class="fa fa-circle-o"></i></span> ';
			if ($row['TransferStatus'] == '2') $driver = '<span class="text-orange"><i class="fa fa-circle-o"></i></span> ';
			if ($row['TransferStatus'] == '3') $driver = '<span style="color: #c00"><i class="fa fa-times-circle"></i></span> ';
			if ($row['TransferStatus'] == '4') $driver = '<span class="text-orange"><i class="fa fa-question-circle"></i></span> ';
			if ($row['TransferStatus'] == '5') $driver = '<span class="text-green"><i class="fa fa-check-circle"></i></span> ';

			if ($row['DriverConfStatus'] == '0') $driver .= '<span style="color:#c00"><i class="fa fa-car"></i></span> ';
			if ($row['DriverConfStatus'] == '1') $driver .= '<span class="text-orange"><i class="fa fa-info-circle"></i></span> ';
			if ($row['DriverConfStatus'] == '2') $driver .= '<span class="text-blue"><i class="fa fa-thumbs-up"></i></span> ';
			if ($row['DriverConfStatus'] == '3') $driver .= '<span class="text-blue"><i class="fa fa-car"></i></span> ';
			if ($row['DriverConfStatus'] == '4') $driver .= '<span style="color:#c00"><i class="fa fa-thumbs-down"></i></span> ';
			if ($row['DriverConfStatus'] == '5') $driver .= '<span style="color:#c00"><i class="fa fa-user-times"></i></span> ';
			if ($row['DriverConfStatus'] == '6') $driver .= '<span style="color:#c00"><i class="fa fa-black-tie"></i></span> ';
			if ($row['DriverConfStatus'] == '7') $driver .= '<span class="text-green"><i class="fa fa-check-square"></i></span> ';			
			
			
			$tn =   $driver.'<b>'.$row['OrderID'] . '-' .$row['TNo'] . '</b>';
			$link =    '<b><a href="index.php?p=editActiveTransfer&rec_no='.
						$row['DetailsID'].
						'" title="<b>'.$row['OrderID'] . '-'.$row['TNo'] .' - '. $row['PaxName'] . '</b>" 
						data-content="'. str_replace('"', '',$ttip) .'" 
						class="mytooltip">' . $row['PickupName'].' - '. $row['DropName'].'</a></b>' ;

			if ($_REQUEST['lt']=='list1') $dtt=$row['PickupDate'];
			else $dtt=$row['OrderDate'];
			
			$transfer_arr[]=array("tn" =>$tn, "link" =>$link, "date" =>$dtt);
		}
		$smarty->assign('transfer',$transfer_arr);	
	}

	$smarty->assign('type',$_REQUEST['stype']);
		
	$smarty->display('../templates/TransfersStat.tpl');	 

