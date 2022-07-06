<?
	require_once ROOT . '/db/v4_Places.class.php';
	require_once ROOT . '/db/v4_OrderDetails.class.php';
	require_once ROOT . '/db/v4_OrdersMaster.class.php';
	require_once ROOT . '/db/v4_OrderDocument.class.php';

	require_once ROOT . '/db/v4_OrderLog.class.php';
	require_once ROOT . '/db/v4_VehicleTypes.class.php';
	require_once ROOT . '/db/v4_OrderExtras.class.php';
	require_once ROOT . '/db/v4_Invoices.class.php';
	require_once ROOT . '/db/v4_InvoiceDetails.class.php';
	require_once ROOT . '/db/v4_AuthUsers.class.php';



	class v4_OrdersJoin extends v4_OrderDetails {
		public function getFullOrderByDetailsID($column, $order, $where = NULL) {
			$keys = array(); $i = 0;
			$sql="
				SELECT v4_OrderDetails.*,v4_OrdersMaster.*,v4_AuthUsers.AuthUserRealName FROM v4_OrderDetails AS v4_OrderDetails, v4_OrdersMaster, v4_AuthUsers $where
				AND v4_OrderDetails.OrderID = v4_OrdersMaster.MOrderID AND v4_AuthUsers.AuthUserID=UserID ORDER BY $column $order";
			$result = $this->connection->RunQuery($sql);
				
				while($row = $result->fetch_array(MYSQLI_ASSOC)){
					$keys[$i] = $row["DetailsID"];
					$i++;
				}
		return $keys;
		}
	}

	$odt = new v4_OrderDetails();
	$od = new v4_OrdersJoin();
	$pl = new v4_Places();
	$om = new v4_OrdersMaster();
	$odoc = new v4_OrderDocument();
	$ol = new v4_OrderLog();
	$vt = new v4_VehicleTypes();
	$in = new v4_Invoices();
	$ind = new v4_InvoiceDetails();
	$oe = new v4_OrderExtras();
	$au = new v4_AuthUsers();

	$keyName = 'DetailsID';
	//$ItemName='PlaceNameEN ';
	$type='TransferStatus';
	#********************************
	# kolone za koje je moguc Search
	# treba ih samo nabrojati ovdje
	# Search ce ih sam pretraziti
	#********************************
	$aColumns = array(
		'v4_OrderDetails.OrderID',
		'v4_OrderDetails.PaxName',
		'v4_OrderDetails.PickupName',
		'v4_OrderDetails.DropName',
		'v4_OrderDetails.PickupDate',
		'v4_OrderDetails.InvoiceNumber',
		'v4_OrderDetails.UserID',	
		'v4_OrderDetails.DriverName',
		'v4_OrderDetails.FlightNo',
		'v4_OrderDetails.DriverInvoiceNumber',	
		'v4_OrdersMaster.MPaxEmail',
		'v4_OrdersMaster.MPaxTel',
		'v4_OrdersMaster.MCardNumber',
		'v4_OrdersMaster.MOrderKey',
		'v4_OrdersMaster.MConfirmFile',
		'v4_AuthUsers.AuthUserRealName'
	);
	if (isset($type)) {
		if (!isset($_REQUEST['Type']) or $_REQUEST['Type'] == 0 or $_REQUEST['Type'] == 99) {
			$filter = "  AND ".$type." != 0 ";
		}
		else {
			$filter = "  AND ".$type." = '" . $_REQUEST['Type'] . "'";
		}
	}
		if (isset($transfersFilter)) {
			$today              = strtotime("today 00:00");
			$yesterday          = strtotime("yesterday 00:00");
			$datetime 			= new DateTime('tomorrow');
			$tomorrow 			= $datetime->format('Y-m-d');
			$lastWeek 			= strtotime("yesterday -1 week 00:00");

			$today = date("Y-m-d", $today);
			$lastWeek= date("Y-m-d", $lastWeek);
			
			switch ($transfersFilter) {
				case 'noDriver':
					$filter .= " AND DriverConfStatus ='0' AND TransferStatus < '3'";	
					break;
				
				case 'notConfirmed':
					$filter .= " AND DriverConfStatus = '1' AND TransferStatus < '3'";
					break;			
					
				case 'notConfirmedTomorrow':
					$filter .= " AND PickupDate = '".$tomorrow ."' AND (DriverConfStatus = '1' OR DriverConfStatus = '4')  AND TransferStatus < '3'";
					break;			
					
				case 'confirmed':
					$filter .= " AND (DriverConfStatus ='2' OR DriverConfStatus ='3') AND TransferStatus < '3'";
					break;			
					
				case 'declined':
					$filter .= " AND DriverConfStatus ='4' AND TransferStatus < '3'";
					break;			
					
				case 'canceled':
					$filter .= " AND TransferStatus = '3'";
					break;			
					
				case 'noShow':
					$filter .= " AND DriverConfStatus = '5'";
					break;			
					
				case 'driverError':
					$filter .= " AND DriverConfStatus = '6'";
					break;			
					
				case 'notCompleted':
					$filter .= " AND TransferStatus < '3' AND PickupDate <  (CURRENT_DATE)-INTERVAL 1 DAY ";  
					break;			
					
				case 'active':
					$filter .= " AND TransferStatus < '3'";
					break;			
					
				case 'newTransfers':
					$filter .= " AND TransferStatus < '3' AND OrderDate = '" . $today . "'";
					break;			
					
				case 'tomorrow':
					$filter .= " AND TransferStatus < '3' AND PickupDate = '" . $tomorrow . "'";
					break;			
					
				case 'deleted':
					$filter .= " AND TransferStatus = '9'";
					break;			
					
				case 'agent':
					$filter .= " AND UserLevelID = '2'";
					break;			
					
				case 'notConfirmedAgent':
					$filter .= " AND DriverConfStatus = '1' AND TransferStatus < '3' AND UserLevelID = '2'";
					break;			
					
				case 'invoice2':
					$filter .= " AND PaymentMethod = '6'";
					break;			
					
				case 'agentinvoice':
					$filter .= " AND (PaymentMethod = '4' OR PaymentMethod = '6')";
					break;			
					
				case 'online':
					$filter .= " AND (PaymentMethod = '1' OR PaymentMethod = '3')";
					break;			
					
				case 'cash':
					$filter .= " AND PaymentMethod = '2'";
					break;			
					
				case 'proforma':
					$documentFilter = 1;
					break;			
					
				case 'invoice':
					$documentFilter = 3;
					break;			
					
				case 'invoice':
					$documentFilter = 3;
					break;				
					
				case 'noDate':
					$filter .= " AND PickupDate = ' '";
					break;				
					
				case 'order':
					$oid_arr=explode('-',$_REQUEST['orderid']);
					if (count($oid_arr)>1) {
						$oid=rtrim($oid_arr[0]);
						$tn=rtrim($oid_arr[1]);
						$filter .= " AND OrderID = ".$oid." AND TNo = ".$tn;
					}
					else $filter .= " AND OrderID = ".$_REQUEST['orderid'];					
					break;			
			}

			$defDate=time()-540*24*3600;
			$date = new DateTime();	
			$date->setTimestamp($defDate);
			$defDate = $date->format('Y-m-d');

			if ($filterDate == '') $filterDate = $defDate;

			
		}	
		$page 		= $_REQUEST['page'];
		$length 	= $_REQUEST['length'];
		$sortOrder 	= $_REQUEST['sortOrder'];

		$start = ($page * $length) - $length;

		if ($length > 0) {
			$limit = ' LIMIT '. $start . ','. $length;
		}
		else $limit = ' LIMIT 0, ' .$length;

		if(empty($sortOrder)) $sortOrder = 'ASC';


		# init vars
		$out = array();
		$flds = array();

		$dbWhere = " WHERE 1=1 ";
		$dbWhere .= $filter . $userFilter;

		if (!isset($_REQUEST['PickupDate'])) $_REQUEST['PickupDate']='2022-01-01';
		$dbWhere .=' AND PickupDate>='.$_REQUEST['PickupDate'];

		$documentType=$_REQUEST['document'];
		if ($documentType>0 && $documentType<10) {	 
			//$where = ' WHERE DocumentType = '.$documentType;
			$where='';
			$group = ' GROUP BY OrderID';
			$odock = $odoc->getKeysByMax('ID', 'desc' , $where , $group );
			$orders_arr="";
			if (count($odock)>0) {
				foreach ($odock as $dnn => $key)
				{
					# document row
					$odoc->getRow($key); 
					$documentOrderID=$odoc->getOrderID();
					if ($odoc->getDocumentType()==$documentType)
						$orders_arr.=$documentOrderID.",";
				}
				$orders_arr = substr($orders_arr,0,strlen($orders_arr)-1);
				$dbWhere .=" AND OrderID IN (".$orders_arr.") ";
			}
		}

		if ($documentType>9) {	
			$cd=$documentType-10;
			$query="SELECT * FROM `v4_VoutcherOrderRequests` WHERE ConfirmDecline=".$cd;
			$result = $db->RunQuery($query);
			$orders_arr="";
			//if (count($result->fetch_array(MYSQLI_ASSOC))>0) {
				while($row = $result->fetch_array(MYSQLI_ASSOC)){ 			
					$orders_arr.=$row['OrderID'].",";
				}
		 
				$orders_arr = substr($orders_arr,0,strlen($orders_arr)-1);
				$dbWhere .=" AND OrderID IN (".$orders_arr.") "; 
			/*}
			else $dbWhere .=" AND OrderID IN (1) "; */
		}

		// ako nema potrebnih podataka, izlaz
		// kod Delete transfer (kad je samo jedan na ekranu) 
		// se pojavi 'undefined' u Where dijelu, pa se dogodi greska
		// Da se to izbjegne, koristim ovaj dio:

		if (strpos($dbWhere, 'undefined') !== false) {
			# send output back
			$output = array(
			'draw' => '0',
			'recordsTotal' => 0,
			'recordsFiltered' => 0,
			'data' =>array()
			);
			echo $_GET['callback'] . '(' . json_encode($output) . ')';
			die();
		}

		# dodavanje search parametra u qry
		# DB_Where sad ima sve potrebno za qry
		if ( $_REQUEST['Search'] != "" )
		{
			$dbWhere .= " AND (";

			for ( $i=0 ; $i< count($aColumns) ; $i++ )
			{
				# If column name exists
				if ($aColumns[$i] != " ")
				$dbWhere .= $aColumns[$i]." LIKE '%"
				.$od->myreal_escape_string( $_REQUEST['Search'] )."%' OR ";
			}
			$dbWhere = substr_replace( $dbWhere, "", -3 );
			$dbWhere .= ')';
		}
		$limit = ' LIMIT 10 ';
		$odTotalRecords = $od->getFullOrderByDetailsID('v4_OrderDetails.PickupDate DESC, v4_OrderDetails.PickupTime ASC', '',$dbWhere);
		$dbk = $od->getFullOrderByDetailsID('v4_OrderDetails.PickupDate ' . $sortOrder.', v4_OrderDetails.PickupTime '. $sortOrder, '' . $limit  , $dbWhere);

		$ObjectFactory = ObjectFactory::getInstance();
		$ap = new AdminTable();		
		$ap->SetOffsetName("offset_order");
		$ap->SetTitle("Pregled narudžbenica:");
		//$ap->SetOffset();
		$ap->SetCountAllRows($odTotalRecords);
		//$ap->SetRowCount(5);
		$ap->SetHeader(
						array(
							SortLink::generateLink('ORDER ID','orderid'),
							'ORDER BY',
							'ORDER',
							)
						);	

	
		//---------------------------------------------
		$ObjectFactory->AddLimit($ap->GetRowCount()); 
		$ObjectFactory->AddOffset($ap->GetOffset());
		$ObjectFactory->ManageSort();
		$ap->SetBrowseString($ObjectFactory);
		$ap->SetRecordCount(count($dbk));

		
		//ZA SADRZAJ TABELE
		if(!empty($dbk))
		{
			foreach($dbk as $db)
			{		
				$odt->getRow($db);
				$om->getRow($odt->getOrderID());
				$au->getRow($odt->getUserID());
				$ap->AddTableRow(
							array(
								$odt->getOrderID(),
								$au->getAuthUserRealName()."(".$odt->getUserID().")<br>".$om->getMPaxEmail(),
								$odt->getOrderID()."-".$odt->getTNo()));
							}
		}
		$ap->RegisterAdminPage($smarty);
	
	
	function makeUserFilter(& $pof)
	{
		global $DBBR;
		if(isset($_REQUEST["userid"]) && $_REQUEST["userid"] != -1)
		{
			$pof->AddFilter("userid=".$_REQUEST["userid"]);
		}
		if(isset($_REQUEST["user_hit"]))
		{
			//desila se promena iz forme potrebno je azurirati sessijsku promenljivu na 0
			$_SESSION["offset_order"]=0;
		}
		$lof = new loginFactory($DBBR);
		$users = $lof->createObjects("users");
		$cmb_users  = "<select class='form-control' name='userid' onChange='formTable.submit();'>";
		$cmb_users .="<option value='-1'>".getTranslation("PLG_FILTER_NO")."</option>";
		foreach ($users as $u)
		{
			$selected = "";
			if(isset($_REQUEST["userid"]) && $u->UserID == $_REQUEST["userid"])
			{
				$selected = "selected";
			}
			$cmb_users .= "<option ".$selected." value='".$u->UserID."'>" .$u->Name." ".$u->Surname. "</option>";
		}
		return $cmb_users .= "</select><input type='hidden' name='user_hit' value='true'>";		
		
	}
	
	function makeStatusFilter(& $pof)
	{
		if(isset($_REQUEST["status"]) && $_REQUEST["status"] != -1)
		{
			$pof->AddFilter("`status`='".$_REQUEST["status"]."'");
		}
		
		if(isset($_REQUEST["status_hit"]))
		{
			//desila se promena iz forme potrebno je azurirati sessijsku promenljivu na 0
			$_SESSION["offset_order"]=0;
		}
		
		$proizvodjaci = $pof->createObjects("proizvodjaci");
		$statusi = array("obradjena","neobradjena");
		$cmb_statusi  = "<select class='form-control' name='status' onChange='formTable.submit();'>";
		$cmb_statusi .="<option value='-1'>".getTranslation("PLG_FILTER_NO")."</option>";
		foreach ($statusi as $s)
		{
			$selected = "";
			if(isset($_REQUEST["status"]) && $s == $_REQUEST["status"])
			{
				$selected = "selected";
			}
			$cmb_statusi .= "<option ".$selected." value='".$s."'>" .$s. "</option>";
		}
		return $cmb_statusi .= "</select><input type='hidden' name='status_hit' value='true'>";	
	}
	
	
	function manageSort(& $pof)
	{
		global $dir;
		$sortlink = "";
		if(isset($_REQUEST["sort"]))
		{
			$sort = $_REQUEST["sort"];
			$dir = $_REQUEST["dir"];
			$pof->SetSortBy($sort,$dir);
			$sortlink = "&sort=".$sort."&dir=".$dir;
			if($dir == "asc") $dir = "desc";
			else $dir = "asc";
		}
		else $dir = "asc";
	}
?>