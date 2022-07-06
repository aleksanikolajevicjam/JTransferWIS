<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once 'Initial.php';

@session_start();

# sastavi filter - posalji ga $_REQUEST-om
if (isset($type)) {
	if (!isset($_REQUEST['Type']) or $_REQUEST['Type'] == 0 or $_REQUEST['Type'] == 99) {
		$filter = "  AND ".$type." != 0 ";
	}
	else {
		$filter = "  AND ".$type." = '" . $_REQUEST['Type'] . "'";
	}
}
	if (isset($_REQUEST['transfersFilter'])) {
		$today              = strtotime("today 00:00");
		$yesterday          = strtotime("yesterday 00:00");
		$datetime 			= new DateTime('tomorrow');
		$tomorrow 			= $datetime->format('Y-m-d');
		$lastWeek 			= strtotime("yesterday -1 week 00:00");

		$today = date("Y-m-d", $today);
		$lastWeek= date("Y-m-d", $lastWeek);
		
		switch ($_REQUEST['transfersFilter']) {
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
$yearsOrder 	= $_REQUEST['yearsOrder'];
$yearsPickup 	= $_REQUEST['yearsPickup'];

$start = ($page * $length) - $length;

if ($length > 0) {
	$limit = ' LIMIT '. $start . ','. $length;
}
else $limit = ' LIMIT 0, ' .$length;

if(empty($sortOrder)) $sortOrder = 'ASC';


# init vars
$out = array();
$flds = array();

$dbWhere = " " . $_REQUEST['where'];
$dbWhere .= $filter . $userFilter;

if (!isset($_REQUEST['PickupDate'])) $_REQUEST['PickupDate']='2019-01-01';
$dbWhere .=' AND PickupDate>="'.$_REQUEST['PickupDate'].'"';

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
// pravljenje filtera
// year of OrderDate
$query='SELECT YEAR(`OrderDate`) as yearOrder FROM `v4_OrderDetails` '.$dbWhere.' group by YEAR(`OrderDate`) order by yearOrder DESC';
$result = $dbT->RunQuery($query);
$odYearsOrder=array();
while($row = $result->fetch_array(MYSQLI_ASSOC)){ 			
	$odYearsOrder[]=$row['yearOrder'];
}
if ($yearsOrder>0) $dbWhere .= " AND YEAR(`OrderDate`)=".$yearsOrder;

// year of PickupDate
$query='SELECT YEAR(`PickupDate`) as yearPickup FROM `v4_OrderDetails` '.$dbWhere.' group by YEAR(`PickupDate`) order by yearPickup DESC';
$result = $dbT->RunQuery($query);
$odYearsPickup=array();
while($row = $result->fetch_array(MYSQLI_ASSOC)){ 			
	$odYearsPickup[]=$row['yearPickup'];
}
if ($yearsPickup>0) $dbWhere .= " AND YEAR(`PickupDate`)=".$yearsPickup;

$odTotalRecords = $od->getFullOrderByDetailsID('v4_OrderDetails.PickupDate DESC, v4_OrderDetails.PickupTime ASC', '',$dbWhere);
$dbk = $od->getFullOrderByDetailsID('v4_OrderDetails.PickupDate ' . $sortOrder.', v4_OrderDetails.PickupTime '. $sortOrder, '' . $limit , $dbWhere);

if (count($dbk) != 0) {
    foreach ($dbk as $nn => $key)
    {
    	$od->getRow($key);    	
    	
		# OrderID za OrdersMaster
		$OrderID = $od->getOrderID();



		# master key
		$omk = $om->getKeysBy('MOrderID', 'asc' , ' WHERE MOrderID = ' . $OrderID);

		# master row
		$om->getRow($omk[0]);

		# get fields and values
		$detailFlds = $od->fieldValues();

		$detailFlds['DriversPrice'] = number_format($od->getDriversPrice()*$_SESSION['CurrencyRate'],2);
		$detailFlds['DetailPrice'] = number_format($od->getDetailPrice()*$_SESSION['CurrencyRate'],2);
		$detailFlds['ExtraCharge'] = number_format($od->getExtraCharge()*$_SESSION['CurrencyRate'],2);
		$detailFlds['DriverExtraCharge'] = number_format($od->getDriverExtraCharge()*$_SESSION['CurrencyRate'],2);
		$detailFlds['PayLater'] = number_format($od->getPayLater()*$_SESSION['CurrencyRate'],2);
		$detailFlds['PayNow'] = number_format($od->getPayNow()*$_SESSION['CurrencyRate'],2);
		$detailFlds['InvoiceAmount'] = number_format($od->getInvoiceAmount()*$_SESSION['CurrencyRate'],2);
		$detailFlds['Provision'] = number_format($od->getProvision()*$_SESSION['CurrencyRate'],2);
		$detailFlds['ProvisionAmount'] = number_format($od->getProvisionAmount()*$_SESSION['CurrencyRate'],2);
		$detailFlds['Discount'] = number_format($od->getDiscount()*$_SESSION['CurrencyRate'],2);
		$detailFlds['DriverPaymentAmt'] = number_format($od->getDriverPaymentAmt()*$_SESSION['CurrencyRate'],2);

		$pm=$detailFlds["PaymentMethod"];
		$detailFlds["PaymentMethodName"]=$PaymentMethod[$pm];

		# document key
		$odock = $odoc->getKeysBy('DocumentDate', 'desc' , ' WHERE OrderID = ' . $OrderID);
		if (count($odock)>0) {
			# document row
			$odoc->getRow($odock[0]);
			$detailFlds["Document"]=$odoc->getDocumentCode();	
			$detailFlds["DocumentDate"]=$odoc->getDocumentDate();
			if ($odoc->getDocumentType()==3) $detailFlds["DocumentType"]=$odoc->getDocumentType()+1;	
			else $detailFlds["DocumentType"]=$odoc->getDocumentType();
		}	
		else {
			$detailFlds["Document"]="No document";
			$detailFlds["DocumentDate"]="";	
			$detailFlds["DocumentType"]=0;	
		}	

		$ordermonth=date("m",strtotime($od->getOrderDate()));
		$orderyear=date("Y",strtotime($od->getOrderDate()));
		$orderym=$orderyear*12+$ordermonth;
		
		$pickupmonth=date("m",strtotime($od->getPickupDate()));
		$pickupyear=date("Y",strtotime($od->getPickupDate()));
		$pickupym=$pickupyear*12+$pickupmonth;	
		
		if ($orderym==$pickupym) $detailFlds["Advance"]=2;
		else $detailFlds["Advance"]=99;

		//zamena naziva mesta sa engleskim nazivom iz tabele places
		$PickupID=$od->getPickupID();
		$DropID=$od->getDropID();
		if ($PickupID!=0) {
			$pl->getRow($PickupID);
			$detailFlds["PickupName"]=$pl->getPlaceNameEN(); 
		}
		if ($DropID!=0) {
			$pl->getRow($DropID);
			$detailFlds["DropName"]=$pl->getPlaceNameEN();
		}
				
		# get fields and values
		$masterFlds = $om->fieldValues();
		$masterFlds['CountryPhonePrefix'] = getCountryPrefix( $om->getMCardCountry() );

		$out[] = array_merge($detailFlds , $masterFlds);    	  	
    }
}
# send output back
$output = array(
'draw' => '0',
'yearsOrder' => $odYearsOrder,
'yearsPickup' => $odYearsPickup,
'recordsTotal' => count($odTotalRecords),
'recordsFiltered' => $length,
'data' =>$out
);
echo $_GET['callback'] . '(' . json_encode($output) . ')';	