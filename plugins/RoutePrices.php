<?
	/*ini_set('display_errors', 1);
	ini_set('log_errors', 1);
	ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
	error_reporting(E_ALL);*/

	require_once ROOT . '/db/v4_Routes.class.php';
	$order='';
	if (isset ($_REQUEST['Order'])) $order = "ORDER BY ".$_REQUEST['Order'];
		
	if (isset ($_REQUEST['Direct'])) {
		$direct = $_REQUEST['Direct'];
	}	
	$query="SELECT v4_Services.OwnerID, `AuthUserRealName`,`VehicleName`,`VehicleCapacity`,`ServicePrice1` 
		FROM `v4_Services`, `v4_AuthUsers`,`v4_Vehicles` 
		WHERE v4_Services.OwnerID=v4_AuthUsers.AuthUserID AND v4_Services.VehicleID=v4_Vehicles.VehicleID AND `RouteID` = ".$_REQUEST['RouteID'] . " ".
		$order." ".$direct;

	$result = $db->RunQuery($query); 

	$ap = new AdminTable(); 
	$r  = new v4_Routes(); 
   
	$r->getRow($_REQUEST['RouteID']);
	$smarty->assign('caption',$r->getRouteName());

	$order='Owner';
	$direct='DESC';
	$sortOwnerDesc="index.php?p=routeprices&RouteID=".$_REQUEST['RouteID']."&Order=".$order."&Direct=".$direct."";
	
	$link = "<a href=".$sortOwnerDesc."><i class='fa fa-sort-amount-desc'></i></a>";

	$ap->SetOffsetName("RoutePrices");
	$ap->SetHeader(array(
						'OwnerID ',
						sortTable('AuthUserRealName','Owner'),	
						sortTable('VehicleName','Vehicle Name'),	
						sortTable('VehicleCapacity','Vehicle Capacity'),	
						sortTable('ServicePrice1','Price'),
	));
	
	$ap->SetCountAllRows($result->num_rows);
	$limit="LIMIT ".$ap->GetOffset().",".$ap->GetRowCount();
	
	while($row = $result->fetch_array(MYSQLI_ASSOC)){ 
		$ap->AddTableRow( 
			array(
				$row["OwnerID"],
				$row["AuthUserRealName"],
				$row["VehicleName"],
				$row["VehicleCapacity"],
				$row["ServicePrice1"]));	
	}
			
	$ap->RegisterAdminPage($smarty);		 
	$smarty->display('RoutePrices.tpl');	 

	function sortTable($field, $name) {
		$sort1="index.php?p=routeprices&RouteID=".$_REQUEST['RouteID']."&Order=".$field."&Direct=ASC";
		$link1 = "<a href=".$sort1."><i class='fa fa-sort-amount-asc'></i></a>";
		$sort2="index.php?p=routeprices&RouteID=".$_REQUEST['RouteID']."&Order=".$field."&Direct=DESC";
		$link2 = "<a href=".$sort2."><i class='fa fa-sort-amount-desc'></i></a>";
		$link=$link1." ".$name." ".$link2;
		return $link;
	}	
