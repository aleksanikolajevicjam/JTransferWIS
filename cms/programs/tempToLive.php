<?

/*
izgubljena rezervacija sa webteha
provjeri jeli rezervacija placena (potreban 15-znameknast order_number)
mylog.log prati order_number (ako je response_code '0000', placeno je)
ako je placena pokreni tempToLive.php sa unesenim order_number u TempOrderKey
pa javi bg da resendaju potvrde za transfer ako je potrebno

poziv programa:
http://www.jamtransfer.com/cms/tempToLive.php?TID={WEBTEH-KOD}
*/

require_once ROOT . '/db/v4_OrderDetails.class.php';
require_once ROOT . '/db/v4_OrderDetailsTemp.class.php';
require_once ROOT . '/db/v4_OrdersMaster.class.php';
require_once ROOT . '/db/v4_OrdersMasterTemp.class.php';
require_once ROOT . '/db/v4_OrderExtras.class.php';
require_once ROOT . '/db/v4_OrderExtrasTemp.class.php';

$om 	= new v4_OrdersMaster();
$omt 	= new v4_OrdersMasterTemp();
$od 	= new v4_OrderDetails();
$odt 	= new v4_OrderDetailsTemp();
$ex 	= new v4_OrderExtras();
$ext 	= new v4_OrderExtrasTemp();

$TempOrderKey = '';
$TempOrderKey = $_REQUEST['TID'];
if($TempOrderKey == '') die('TID not set!');

$omKeys = $om->getKeysBy('MOrderID', 'asc', " WHERE MCardNumber = '" .$TempOrderKey ."'");
if( count($omKeys)>0 ) {
	echo 'Order ID: '. $omMOrderID. 'already exist.';
	exit();
}	

$omtKeys = $omt->getKeysBy('MOrderID', 'asc', " WHERE MOrderKey = '" .$TempOrderKey ."'");

if( count($omtKeys) == 1 ) {
	$omt->getRow( $omtKeys[0] ); 
	$OrderIDForDetails = $omt->getMOrderID();


	$om->setSiteID($omt->getSiteID());
	$om->setMOrderKey('CPYDFRMTM5');
	//$om->setMOrderID($omt->getMOrderID());
	$om->setMOrderStatus($omt->getMOrderStatus());
	$om->setMOrderType($omt->getMOrderType());
	$om->setMOrderDate($omt->getMOrderDate());
	$om->setMOrderTime($omt->getMOrderTime());
	$om->setMUserID($omt->getMUserID());
	$om->setMUserLevelID($omt->getMUserLevelID());
	$om->setMTransferPrice($omt->getMTransferPrice());
	$om->setMExtrasPrice($omt->getMExtrasPrice());
	$om->setMOrderPriceEUR($omt->getMOrderPriceEUR());
	$om->setMEurToCurrencyRate($omt->getMEurToCurrencyRate());
	$om->setMOrderCurrencyPrice($omt->getMOrderCurrencyPrice());
	$om->setMOrderCurrency($omt->getMOrderCurrency());
	$om->setMPaymentMethod($omt->getMPaymentMethod());
	$om->setMPaymentStatus($omt->getMPaymentStatus());
	$om->setMPayNow($omt->getMPayNow());
	$om->setMPayLater($omt->getMPayLater());
	$om->setMInvoiceAmount($omt->getMInvoiceAmount());
	$om->setMAgentCommision($omt->getMAgentCommision());
	$om->setMCustomerID($omt->getMCustomerID());
	$om->setMPaxFirstName($omt->getMPaxFirstName());
	$om->setMPaxLastName($omt->getMPaxLastName());
	$om->setMPaxTel($omt->getMPaxTel());
	$om->setMPaxEmail($omt->getMPaxEmail());
	$om->setMCardType($omt->getMCardType());
	$om->setMCardFirstName($omt->getMCardFirstName());
	$om->setMCardLastName($omt->getMCardLastName());
	$om->setMCardEmail($omt->getMCardEmail());
	$om->setMCardTel($omt->getMCardTel());
	$om->setMCardAddress($omt->getMCardAddress());
	$om->setMCardCity($omt->getMCardCity());
	$om->setMCardZip($omt->getMCardZip());
	$om->setMCardCountry($omt->getMCardCountry());
	$om->setMCardNumber($TempOrderKey);
	$om->setMCardCVD($omt->getMCardCVD());
	$om->setMCardExpDate($omt->getMCardExpDate());
	$om->setMConfirmFile($omt->getMConfirmFile());
	$om->setMCancelFile($omt->getMCancelFile());
	$om->setMChangeFile($omt->getMChangeFile());
	$om->setMSubscribe($omt->getMSubscribe());
	$om->setMAcceptTerms($omt->getMAcceptTerms());
	$om->setMSendEmail($omt->getMSendEmail());
	$om->setMEmailSentDate($omt->getMEmailSentDate());
	$om->setMCustomerIP($omt->getMCustomerIP());
	$om->setMOrderLang($omt->getMOrderLang());
	
	$omMOrderID = $om->saveAsNew();

	$odtKeys = $odt->getKeysBy('DetailsID', 'ASC', " WHERE OrderID = '" . $OrderIDForDetails ."'");
	
	foreach($odtKeys as $nn => $DetailsID) {
		
		$odt->getRow( $DetailsID ); // DetailsID je iz TEMP!
		
		
		$od->setSiteID($odt->getSiteID());
		//$od->setDetailsID($odt->getDetailsID());
		$od->setOrderID($omMOrderID);
		
		$od->setTNo($odt->getTNo());
		$od->setUserID($omt->getMUserID());
		$od->setUserLevelID($omt->getMUserLevelID());
		$od->setAgentID($odt->getAgentID());
		$od->setCustomerID($odt->getCustomerID());
		$od->setTransferStatus($odt->getTransferStatus());
		$od->setOrderDate($odt->getOrderDate());
		$od->setTaxidoComm($odt->getTaxidoComm());
		$od->setServiceID($odt->getServiceID());
		$od->setRouteID($odt->getRouteID());
		$od->setFlightNo($odt->getFlightNo());
		$od->setFlightTime($odt->getFlightTime());
		$od->setPaxName($odt->getPaxName());
		$od->setPickupID($odt->getPickupID());
		$od->setPickupName($odt->getPickupName());
		$od->setPickupPlace($odt->getPickupPlace());
		$od->setPickupAddress($odt->getPickupAddress());
		$od->setPickupDate($odt->getPickupDate());
		$od->setPickupTime($odt->getPickupTime());
		$od->setPickupNotes($odt->getPickupNotes());
		$od->setDropID($odt->getDropID());
		$od->setDropName($odt->getDropName());
		$od->setDropPlace($odt->getDropPlace());
		$od->setDropAddress($odt->getDropAddress());
		$od->setDropNotes($odt->getDropNotes());
		$od->setPriceClassID($odt->getPriceClassID());
		$od->setDetailPrice($odt->getDetailPrice());
		$od->setDriversPrice($odt->getDriversPrice());
		$od->setDiscount($odt->getDiscount());
		$od->setExtraCharge($odt->getExtraCharge());
		$od->setPaymentMethod($odt->getPaymentMethod());
		$od->setPaymentStatus($odt->getPaymentStatus());
		$od->setPayNow($odt->getPayNow());
		$od->setPayLater($odt->getPayLater());
		$od->setInvoiceAmount($odt->getInvoiceAmount());
		$od->setProvisionAmount($odt->getProvisionAmount());
		$od->setPaxNo($odt->getPaxNo());
		$od->setVehiclesNo($odt->getVehiclesNo());
		$od->setVehicleType($odt->getVehicleType());
		$od->setVehicleID($odt->getVehicleID());
		$od->setDriverID($odt->getDriverID());
		$od->setDriverName($odt->getDriverName());
		$od->setDriverEmail($odt->getDriverEmail());
		$od->setDriverTel($odt->getDriverTel());
		$od->setDriverConfStatus($odt->getDriverConfStatus());
		$od->setDriverConfDate($odt->getDriverConfDate());
		$od->setDriverConfTime($odt->getDriverConfTime());
		$od->setDriverNotes($odt->getDriverNotes());
		$od->setDriverPayment($odt->getDriverPayment());
		$od->setDriverPaymentAmt($odt->getDriverPaymentAmt());
		$od->setRated($odt->getRated());
		//$od->setDriverPickupDate($odt->getDriverPickupDate()); // IMA SAMO U TEMP !
		//$od->setDriverPickupTime($odt->getDriverPickupTime()); // IMA SAMO U TEMP !
		$od->setSubDriver($odt->getSubDriver());
		$od->setCar($odt->getCar());
		$od->setSubDriver2($odt->getSubDriver2());
		$od->setCar2($odt->getCar2());
		$od->setSubDriver3($odt->getSubDriver3());
		$od->setCar3($odt->getCar3());
		$od->setSubPickupDate($odt->getSubPickupDate());
		$od->setSubPickupTime($odt->getSubPickupTime());
		$od->setSubFlightNo($odt->getSubFlightNo());
		$od->setSubFlightTime($odt->getSubFlightTime());
		$od->setPDFFile($odt->getPDFFile());
		$od->setExtras($odt->getExtras());
		$od->setSubDriverNote($odt->getSubDriverNote());
		$od->setStaffNote($odt->getStaffNote());
		$od->setInvoiceNumber($odt->getInvoiceNumber());
		$od->setInvoiceDate($odt->getInvoiceDate());
		$od->setDriverInvoiceNumber($odt->getDriverInvoiceNumber());
		$od->setDriverInvoiceDate($odt->getDriverInvoiceDate());
		$od->setCashIn($odt->getCashIn());
		$od->setFinalNote($odt->getFinalNote());
		
		$newDetailsID = $od->saveAsNew();
		
		// EXTRAS
		$extKeys = $ext->getKeysBy('ID', 'ASC', " WHERE OrderDetailsID = '" . $DetailsID ."'");
	
		foreach($extKeys as $nn => $ID) {
		
			$ext->getRow( $ID );
			
			if($ext->getOrderDetailsID() == $DetailsID)  {	
				$ex->setOwnerID( $ext->getOwnerID() );
				$ex->setOrderDetailsID( $newDetailsID );
				$ex->setServiceID( $ext->getServiceID() );
				$ex->setServiceName( $ext->getServiceName() );
				$ex->setProvision( $ext->getProvision() );
				$ex->setDriverPrice( $ext->getDriverPrice() );
				$ex->setPrice( $ext->getPrice() );
				$ex->setQty( $ext->getQty() );
				$ex->setDriverPriceSum( $ext->getDriverPriceSum() );
				$ex->setSum( $ext->getSum() );
				
				$ex->saveAsNew();
			}
		 } // end foreach	
		
	} // end foreach
	echo 'Done. New order ID: '. $omMOrderID;
} // endif

?>

