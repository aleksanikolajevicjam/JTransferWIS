<? 

$ServiceID=$_REQUEST['ServiceID'];
$Qty=$_REQUEST['Qty'];
$AgentID=$_REQUEST['AgentID'];
$DriverID=$_REQUEST['DriverID'];
$DetailsID=$_REQUEST['DetailsID'];
$User=$_REQUEST['user'];
$AuthUserID=$_REQUEST['AuthUserID'];


require_once ROOT.'/db/v4_Extras.class.php';
require_once ROOT.'/db/v4_OrderExtras.class.php';
require_once ROOT.'/db/v4_OrderDetails.class.php';
require_once ROOT .'/db/v4_OrderLog.class.php';
require_once ROOT . '/a/getContractPrices.php';


$e = new v4_Extras();
$oe = new v4_OrderExtras();
$k = $e->getKeysBy('Service', 'ASC', ' WHERE (OwnerID = ' . $DriverID . ' OR OwnerID = 9999) AND ID = '.$ServiceID); 
$e->getRow($k[0]);

$price = getContractExtrasPrice($e->getServiceID(), $AgentID);	
if ($price==0) $price = $e->getPrice();

$driverPrice = $e->getDriverPrice();
$name= $e->getServiceEN(); 
$provision = $e->getProvision(); 
$id = $e->getID();

$ok = $oe->getKeysBy('ID', 'ASC', " WHERE OrderDetailsID = " . $DetailsID . " AND ServiceID = ".$id);
if ($Qty!=0) {
	if( count($ok) > 0) {
		$oe->getRow($ok[0]);
		$oe->setPrice($price);
		$oe->setDriverPrice($driverPrice);
		$oe->setProvision($provision);
		$oe->setQty($Qty);
		$oe->setSum($price*$Qty);
		$oe->setDriverPriceSum($driverPrice*$Qty);	
		$oe->saveRow();
	}
	else { 
		$oe->setOrderDetailsID($DetailsID);
		$oe->setServiceID($id);
		$oe->setServiceName($name);
		$oe->setPrice($price);
		$oe->setDriverPrice($driverPrice);
		$oe->setProvision($provision);
		$oe->setQty($Qty);
		$oe->setSum($price*$Qty);
		$oe->setDriverPriceSum($driverPrice*$Qty);

		$oe->saveAsNew();		 
	}
}
else 
	if( count($ok) > 0)  $oe->deleteRow($ok[0]);


// izracunavanje extraCharge i DriverExtraCharge
$ok1 = $oe->getKeysBy('ID', 'ASC', " WHERE OrderDetailsID = " . $DetailsID );
$sumae=0;
$sumade=0;
    foreach($ok1 as $nn => $id) {
	    $oe->getRow($id);
		$sumae+=$oe->getSum();
		$sumade+=$oe->getDriverPriceSum();			
	}
// promena u OrderDetails
$dt = new v4_OrderDetails();
$dt->getRow($DetailsID);
$OrderID=$dt->getOrderID();
$raz=$sumae-$dt->getExtraCharge(); 
$newprice=$dt->getDetailPrice()+$sumae;
if ($dt->getPaymentMethod()==1) $dt->setPayNow($newprice-$dt->getProvisionAmount());
if ($dt->getPaymentMethod()==2) $dt->setPayLater($newprice);
if ($dt->getPaymentMethod()==3) {
	$dt->setPayNow($newprice-$dt->getDriversPrice()-$dt->getProvisionAmount());
	$dt->setPayLater($dt->getDriversPrice());	
}	
if ($dt->getPaymentMethod()>3) $dt->setInvoiceAmount($newprice-$dt->getProvisionAmount());

$dt->setExtraCharge($sumae); 
$dt->setDriverExtraCharge($sumade);
$dt->setDriverPaymentAmt($sumade+$dt->getDriversPrice());
$dt->saveRow(); 

// promena u timaline-u
$ol= new v4_OrderLog();

$icon = 'fa fa-tasks bg-red';
$logDescription = 'Change Extras';
$logAction = 'Update';
$logTitle = 'Change Extras by ' . $User;
$showToCustomer = 0; 

$ol->setOrderID($OrderID); 
$ol->setDetailsID($DetailsID);
$ol->setAction($logAction);
$ol->setTitle($logTitle);
$ol->setDescription($logDescription);
$ol->setDateAdded(date("Y-m-d"));
$ol->setTimeAdded(date("H:i:s"));
$ol->setUserID($AuthUserID);
$ol->setIcon($icon);
$ol->setShowToCustomer($showToCustomer);
$ol->saveAsNew();


$extrascharge=$sumae."/".$sumade;
echo $extrascharge;
//$extrascharge['extrascharge']=$sumae;
//$extrascharge['driverextrascharge']=$sumade;

/*$extrascharge = json_encode($extrascharge);
echo $_GET['callback'] . '(' . $extrascharge. ')';*/

