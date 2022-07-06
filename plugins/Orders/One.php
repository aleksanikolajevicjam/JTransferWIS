<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once 'Initial.php';

	$PaymentStatus = array(
		'0'	=>	'Not Paid',
		'1'	=>	'Warning sent',
		'2' =>	'Sued',
		'3' =>  'Refunded',
		'10'=>	'Lost - will not be paid',
		'91'=>	'Compensated',
		'99'=>	'Paid'
	);	

	# Driver Payment
	$DriverPayment = array(
		'0' => 'Not Paid',
		'1' => 'Partly paid',
		'2'	=> 'Paid',
		'3' => 'Compensated'
	);
	
	#
	$DocumentType = array(
		'0' => 'Choose document',
		'1' => 'Proforma',
		'2'	=> 'Prepayment Invoice',
		'3' => 'Invoice',
		'4' => 'Invoice Item',
		'5' => 'Cancellation Invoice',
		'6' => 'Credit Note'
	);

	# init vars
	$out = array();
	$relatedTransfers = array();
	$orderLog = array();
	
# filters
$odWhere = $_REQUEST['where'];

# Details keys
$odk = $od->getKeysBy('DetailsID', 'asc' , $odWhere);
		
# Details  red
$od->getRow($odk[0]);

# OrderID za OrdersMaster
$OrderID = $od->getOrderID();
$DetailsID = $od->getDetailsID();

# Vezani transfer, ako postoji
$odk2 = $od->getKeysBy('DetailsID', 'asc' , ' WHERE OrderID='. $OrderID);

foreach ($odk2 as $key => $value)
{
	$od->getRow($value);
	if ($od->getDetailsID() != $DetailsID) {
		$relatedTransfers[] = array(
			"RelatedTransfer" => $od->getDetailsID(),
			"RelatedTransferText" => $od->getOrderID().'-'.$od->getTNo()
		);
	}
	
}

# Details  red
$od->getRow($odk[0]);

# get fields and values
$detailFlds = $od->fieldValues();

if ($od->getPayNow()>0) {
	$query="SELECT * FROM `v4_VoutcherOrderRequests` WHERE OrderID=". $OrderID;
	
	$db = new DataBaseMysql(); 
	$result = $db->RunQuery($query);
	$row = $result->fetch_array(MYSQLI_ASSOC);
	if (count($row)>0) {
		switch ($row['ConfirmDecline']) {
			case 0:
				$text="Send request";
				break;
			case 1:
				$text="Confirm request";
				break; 
			case 2:
				$text="Decline request";
				break;
		}		 
		$detailFlds["VoutcherText"]=$text;
		$PDFfile = 	'/cms/pdfvoutcher/'.$row['OrderKey'].'-'.$row['OrderID'].'.pdf';
		$pdflink = "<a target='_blank' href='".$PDFfile."'>".$row['OrderKey']."</a>";	
		$detailFlds["VoutcherPDFfile"]=$PDFfile;				
		$detailFlds["VoutcherKey"]=$row['OrderKey'];		
		$detailFlds["VoutcherValue"]=$row['VoutcherValue'];		
	}	
	else $detailFlds["Voutcher"]="";
		
	
}	


$pm=$detailFlds["PaymentMethod"];
$detailFlds["PaymentMethodName"]=$PaymentMethod[$pm];
//zamena naziva mesta sa engleskim nazivom iz tabele places
$PickupID=$od->getPickupID();
$DropID=$od->getDropID();
if ($PickupID!=0) {
	$pl->getRow($PickupID);
	$detailFlds["PickupName"]=$pl->getPlaceNameEN();
	$detailFlds["PlaceType"]=$pl->getPlaceType(); 
}
if ($DropID!=0) {
	$pl->getRow($DropID);
	$detailFlds["DropName"]=$pl->getPlaceNameEN();
}

$detailFlds["RelatedTransfers"] = $relatedTransfers;

# VehicleTypes
$vt->getRow($od->getVehicleType() );
$detailFlds['VehicleTypeName'] = $vt->getVehicleTypeName();
$detailFlds['VehicleClass'] = $vt->getVehicleClass();
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
$detailFlds['DriversPriceEUR'] = number_format($od->getDriversPrice(),2);
$detailFlds['DetailPriceEUR'] = number_format($od->getDetailPrice(),2);
$detailFlds['ExtraChargeEUR'] = number_format($od->getExtraCharge(),2);
$detailFlds['DriverExtraChargeEUR'] = number_format($od->getDriverExtraCharge(),2);
$detailFlds['PayLaterEUR'] = number_format($od->getPayLater(),2);
$detailFlds['PayNowEUR'] = number_format($od->getPayNow(),2);
$detailFlds['InvoiceAmountEUR'] = number_format($od->getInvoiceAmount(),2);
$detailFlds['ProvisionEUR'] = number_format($od->getProvision(),2);
$detailFlds['ProvisionAmountEUR'] = number_format($od->getProvisionAmount(),2);
$detailFlds['DiscountEUR'] = number_format($od->getDiscount(),2);
$detailFlds['DriverPaymentAmtEUR'] = number_format($od->getDriverPaymentAmt(),2);

$au->getRow($od->getDriverID());
$contractFile=$au->getContractFile();
//partneri
if ($contractFile!='inter') {
	$detailFlds['ContactName'] = $au->getContactPerson();
	if (empty($au->getAuthUserMob())) $detailFlds['ContactMob'] = $au->getAuthUserTel();
	else $detailFlds['ContactMob'] = $au->getAuthUserMob();	
	if ($subdriverid>0) {
		$au->getRow($subdriverid);
		$detailFlds['SubDriverName'] = $au->getAuthUserRealName();
		$detailFlds['SubDriverMob'] = $au->getAuthUserMob();
	}	
}
//JAM grupa
else {	
	$subdriverid=$od->getSubDriver();
	$detailFlds['SubDriverName'] = $au->getContactPerson();
	$detailFlds['SubDriverMob'] = $au->getAuthUserMob();		
	if ($subdriverid>0) {
		$au->getRow($subdriverid);
		$detailFlds['ContactName'] = $au->getAuthUserRealName();
		$detailFlds['ContactMob'] = $au->getAuthUserMob();
	}
}

# Invoice data
//$inn=$od->getInvoiceNumber(); 
//if ($inn<>'') {
//$inid=$in->getKeysBy('ID', 'asc', " WHERE `InvoiceNumber` = '". $inn . "'");   
//$inid = $in->getKeysBy('ID', 'asc', "WHERE `UserID` =  '".$od->getUserID()."'  AND `EndDate` >= '".$od->getOrderDate()."' AND `StartDate` <= '".$od->getOrderDate()."'");
//$inid = $in->getKeysBy('ID', 'asc', "WHERE `UserID` =  '".$od->getUserID()."'  AND `EndDate` >= '".$od->getPickupDate()."' AND `StartDate` <= '".$od->getPickupDate()."'");
$inid = $ind->getKeysBy('ID', 'asc', "WHERE `DetailsID` =  ".$od->getDetailsID());

$cinid=count($inid);
if ($cinid>0) {	
	$ind->getRow($inid[$cinid-1]);
	$detailFlds['InvoiceNumberO'] = $ind->getInvoiceNumber();
	$inid2 = $in->getKeysBy('ID', 'asc', "WHERE `InvoiceNumber` =  '".$ind->getInvoiceNumber()."'");
	$in->getRow($inid2[0]);
	$detailFlds['InvoiceDateO'] = $in->getInvoiceDate();
	$detailFlds['DueDateO'] = $in->getDueDate();
	$detailFlds['PaymentStatusO'] = $PaymentStatus[$in->getStatus()];
	$detailFlds['GrandTotalO'] = $in->getGrandTotal();
}
# Driver Invoice data
//$dinn=$od->getDriverInvoiceNumber(); 
//if ($dinn<>'') {
//$inid=$in->getKeysBy('ID', 'asc', " WHERE `InvoiceNumber` = '". $dinn . "'"); 
$inid = $in->getKeysBy('ID', 'asc', "WHERE `UserID` =  '".$od->getDriverID()."' 
	AND `EndDate` >= '".$od->getPickupDate()."' 
	AND `StartDate` <= '".$od->getPickupDate()."'");
 if (count($inid)>0) {	 
	$in->getRow($inid[0]);
	$detailFlds['DriverInvoiceNumberO'] = $in->getInvoiceNumber();	
	$detailFlds['DriverInvoiceDateO'] = $in->getInvoiceDate();
	$detailFlds['DriverDueDateO'] = $in->getDueDate();	
	$detailFlds['DriverPaymentStatusO'] = $PaymentStatus[$in->getStatus()];
	$detailFlds['DriverGrandTotalO'] = $in->getGrandTotal();
}


//prarametri za racune
if ($_SESSION['AuthLevelID']==44) {
	//service type
	switch ($od->PaymentMethod) {
		case 1:
		case 4:
		case 5:
		case 6:
			$detailFlds['ServiceType']="Usluga prevoza";
			$detailFlds['DocumentValue']=$od->PayNow+$od->InvoiceAmount;
			break;
		case 2:
			$detailFlds['ServiceType']="Usluga nalaženja putnika";
			$detailFlds['DocumentValue']=$od->PayLater-$od->DriversPrice-$od->DriverExtraCharge;
			break;
		case 3:
			$detailFlds['ServiceType']="Usluga nalaženja prevoznika";
			$detailFlds['DocumentValue']=$od->PayNow;			
			break;	
	}
	// transfer arrea
	$pl->getRow($od->PickupID);
	$country1=$pl->CountryNameEN;
	$pl->getRow($od->DropID);
	$country2=$pl->CountryNameEN;
	if ($country1=='Serbia'	&& $country2=='Serbia') $detailFlds['TransferArea']="Srbija";
	if ($country1!='Serbia'	&& $country2!='Serbia') $detailFlds['TransferArea']="Van Srbije";
	//if ($country1!='Serbia'	&& $country2=='Serbia') $detailFlds['TransferArea']="Prekogranično";
	//if ($country1=='Serbia'	&& $country2!='Serbia') $detailFlds['TransferArea']="Prekogranično";
	// Document recepient
	if ($detailFlds['ServiceType']=="Usluga nalaženja putnika") $rid=$od->DriverID;
	else  $rid=$od->UserID;
	$au->getRow($rid);
	$detailFlds['DocumentRecepient']=$au->AuthUserRealName;
	// Type of document recipient
	$arrayX=array(2,5,6,31);
	if (in_array($au->AuthLevelID,$arrayX)) $detailFlds['TypeDocumentRecepient']="Pravno lice";
	else $detailFlds['TypeDocumentRecepient']="Fizičko lice";
	// Origin of document recipient	
	if ($au->CountryName=="Serbia") $detailFlds['OriginDocumentRecepient']="Domaće";
	else $detailFlds['OriginDocumentRecepient']="Strano";
	// vat document status
	if ($detailFlds['TransferArea']=="Srbija" && $detailFlds['OriginDocumentRecepient']=="Domaće") $detailFlds['VatDocumentStatus']="Uključen PDV";	
	else $detailFlds['VatDocumentStatus']="Oslobođen PDV-a";
	// document currency
	//service type
	switch ($od->PaymentMethod) {
		case 1:
		case 3:
			$detailFlds['DocumentCurrency']="RSD";			
			break;
		case 2:
		case 4:
		case 5:
		case 6:
			if ($detailFlds['OriginDocumentRecepient']=="Domaće") $detailFlds['DocumentCurrency']="RSD";
			else $detailFlds['DocumentCurrency']="EUR";
			break;
	}	
	$detailFlds['DocumentType']=0;
	
	
}

# documents
$odock = $odoc->getKeysBy('ID', 'asc' , ' WHERE OrderID = ' . $OrderID);
$orderDocument=array();
if(count($odock) > 0) {
	foreach ($odock as $key => $value) {
		$odoc->getRow($value);
		$doc=$odoc->fieldValues();
		$doc['DocumentTypeName']=$DocumentType[$odoc->getDocumentType()];
		$orderDocument[] = $doc;
	}
}
$detailFlds['Documents']=$orderDocument;

# master key
$omk = $om->getKeysBy('MOrderID', 'asc' , ' WHERE MOrderID = ' . $OrderID);

# master row
$om->getRow($omk[0]);

# get fields and values
$masterFlds = $om->fieldValues();
$masterFlds['CountryPhonePrefix'] = '+' . getCountryPrefix( $om->getMCardCountry() ) .'-';

# log entries
$olk = $ol->getKeysBy('ID', 'asc' , ' WHERE DetailsID = ' . $DetailsID);
if(count($olk) > 0) {
	foreach ($olk as $key => $value) {
		$ol->getRow($value);
		$orderLog[] = $ol->fieldValues();
	}
}

# extra services
$OrderDetailsID = $DetailsID;
// ako je ovo povratni transfer dohvati extra services iz prvog transfera

/* Uto 27 Ožu 2018 22:30:59  ovo sam izbacio, ali mozda nije trebalo. Javili su da se pojavljuju duple extras.
if ($od->getTNo() == 2) {
	$odk3 = $od->getKeysBy('DetailsID', 'asc' , ' WHERE OrderID = ' . $OrderID . ' AND TNo = 1');
	$od->getRow($odk3[0]);
	$OrderDetailsID = $od->getDetailsID();
}
*/
$oek = $oe->getKeysBy('ID', 'ASC', ' WHERE OrderDetailsID = ' . $OrderDetailsID);
if(count($oek) > 0) {
	foreach ($oek as $key => $value) {
		$oe->getRow($value);
		$oeServices[] = $oe->fieldValues();
	}
}

// output everything
$out = array(
	'details' 		=> $detailFlds,
	'master'  		=> $masterFlds,
	'orderLog'		=> $orderLog,
	'oeServices' 	=> $oeServices
);

	# send output back
	$output = json_encode($out);
	echo $_GET['callback'] . '(' . $output . ')';
	