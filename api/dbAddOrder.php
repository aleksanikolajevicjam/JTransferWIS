<?

function insertOrder($type='temp') {	
	
	global $OrderKey;
	
	if($type == 'temp') {

		require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_OrdersMasterTemp.class.php';
		require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_OrderDetailsTemp.class.php';
		require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_OrderExtrasTemp.class.php';
		
		$om = new v4_OrdersMasterTemp();
		$od = new v4_OrderDetailsTemp();
		$ox = new v4_OrderExtrasTemp();
		
		$OrderKey = $_SESSION['order_number']; // postavlja se u webtehPayment.php
	}
	else if($type=='final') {

		require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_OrdersMaster.class.php';
		require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_OrderDetails.class.php';
		require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_OrderExtras.class.php';
		
		$om = new v4_OrdersMaster();
		$od = new v4_OrderDetails();
		$ox = new v4_OrderExtras();
		
		$OrderKey = create_order_key(); // pravi OrderKey
	}
	
	// From and To names
	$fromName 	= getPlaceName( s('FromID') );
	$toName 	= getPlaceName( s('ToID') );
	
	
	// Driver Data
	$driver = getUserData($_SESSION['DriverID']);
	$driverName = $driver['AuthUserCompany'];
	$driverTel 	= $driver['AuthUserTel'];
	$driverEmail= $driver['AuthUserMail'];
	
	$vehicleTypeID = getVehicleTypeID(s('VehicleID'));
	
	
	// Payment Statuses
	
	if($_SESSION['PL'] == 0 and $_SESSION['PN'] > 0) $paymentStatus = '99'; // PayLater = 0, sve placeno
	else $paymentStatus = '0'; // PayLater nije nula, znaci ima jos za platiti
	
	// CURRENCIES
	if($_SESSION['Currency'] != 'EUR') {
		
	}
	
	
	if(!isset($_SESSION['Customer']['ID']) or empty($_SESSION['Customer']['ID'])) {
		$CustomerID = '';
		$UserLevelID = '3';
		
	} else {
		$CustomerID = $_SESSION['Customer']['ID'];
		$UserLevelID = '3';
	}
	
	// Ili je Affiliate ili je Anonymous User (53)
	if(!isset($_SESSION['UserID']) or $_SESSION['UserID'] == '') {
		$UserID = '53';
		$UserLevelID = '3';
	}
	else {
		$UserID = $_SESSION['UserID'];
		$user = getUserData($_SESSION['UserID']);
		$UserLevelID = $user['AuthLevelID'];
	}
	
	
	// OrdersMaster
		$om->setMOrderKey( $OrderKey );
		$om->setSiteID('2');
		$om->setMOrderStatus('1');
		$om->setMOrderType( $_SESSION["MOrderType"]);
		$om->setMOrderDate(date("Y-m-d"));
		$om->setMOrderTime(date("H:i:s"));
		$om->setMUserID($UserID);
		$om->setMUserLevelID( $UserLevelID ); 
		$om->setMCustomerID( $CustomerID );
		$om->setMTransferPrice( $_SESSION['TT']);
		$om->setMExtrasPrice( $_SESSION['ET']);
		$om->setMOrderPriceEUR( $_SESSION["TotalPrice"]);
		$om->setMOrderCurrency( $_SESSION["Currency"]);
		$om->setMOrderCurrencyPrice( $_SESSION["TotalPrice"]);
		$om->setMEurToCurrencyRate( ExchangeRatio());
		$om->setMPaymentMethod( $_SESSION["PaymentOption"]);
		$om->setMPaymentStatus( $paymentStatus);
		$om->setMPayNow( $_SESSION["PN"]);
		$om->setMPayLater( $_SESSION["PL"]);
		$om->setMInvoiceAmount( $_SESSION["MInvoiceAmount"]);
		$om->setMAgentCommision( $_SESSION["MAgentCommision"]);
		$om->setMPaxFirstName( $_SESSION["MPaxFirstName"]);
		$om->setMPaxLastName( $_SESSION["MPaxLastName"]);
		$om->setMPaxTel( $_SESSION["MPaxTel"]);
		$om->setMPaxEmail( $_SESSION["MPaxEmail"]);
		$om->setMCardType( $_SESSION["MCardType"]);
		$om->setMCardFirstName( $_SESSION["ch_name"]);
		$om->setMCardLastName( $_SESSION["ch_last_name"]);
		$om->setMCardEmail( $_SESSION["ch_email"]);
		$om->setMCardTel( $_SESSION["ch_phone"]);
		$om->setMCardAddress( $_SESSION["ch_address"]);
		$om->setMCardCity( $_SESSION["ch_city"]);
		$om->setMCardZip( $_SESSION["ch_zip"]);
		$om->setMCardCountry( GetCountryName( $_SESSION["ch_country"]) );
		$om->setMCardNumber( $_SESSION["MCardNumber"]);
		$om->setMCardCVD( $_SESSION["MCardCVD"]);
		$om->setMCardExpDate( $_SESSION["MCardExpDate"]);
		$om->setMConfirmFile( $_SESSION["MConfirmFile"]);
		$om->setMCancelFile( $_SESSION["MCancelFile"]);
		$om->setMChangeFile( $_SESSION["MChangeFile"]);
		$om->setMSubscribe( $_SESSION["MSubscribe"]);
		$om->setMAcceptTerms( '1');
		$om->setMSendEmail( $_SESSION["MSendEmail"]);
		$om->setMEmailSentDate( $_SESSION["MEmailSentDate"]);
		$om->setMCustomerIP( $_SESSION["MCustomerIP"]);
		$om->setMOrderLang( $_SESSION['language']);

		
		$omOrderID = $om->saveAsNew();
		
		// Update OrderKey za printReservation.php
		$OrderKey .= '-'.$omOrderID;

		//**********
		// DETAILS
		//**********
/*		
		// Kalkulacija cijena za upis
		$numberOfVehicles = $_SESSION['VehiclesNo'];
		$payNow 		= number_format($_SESSION['PN'], 2, '.', '');
		$payLater 		= number_format($_SESSION['PL'], 2, '.', '');
		$extras 		= number_format($_SESSION['ET'], 2, '.', '');
		$transferPrice	= number_format($_SESSION['TT'], 2, '.', '');
		$driversPrice	= number_format($_SESSION['DriversPrice'] , 2, '.', '');
		$profit         = number_format($transferPrice - $driversPrice - $extras, 2, '.', '');

		if (s('returnTransfer')) {
			$payNow 		= number_format($_SESSION['PN'] / 2, 2, '.', '');
			$payLater 		= number_format($_SESSION['PL'] / 2, 2, '.', '');
			$extras 		= number_format($_SESSION['ET'] / 2, 2, '.', '');
			$transferPrice	= number_format($_SESSION['TT'] / 2, 2, '.', '');
			$driversPrice	= number_format($_SESSION['DriversPrice'] / 2, 2, '.', '');
			$profit         = number_format($transferPrice - $driversPrice - $extras, 2, '.', '');
		}
*/


		$onlyTransfer = $_SESSION['TT'] - $_SESSION['ET']; // FIX - ovo treba rijesit!!!!
		
		$numberOfVehicles = $_SESSION['VehiclesNo'];
		$payNow 		= number_format($_SESSION['PN'], 2, '.', '');
		$payLater 		= number_format($_SESSION['PL'], 2, '.', '');
		$extras 		= number_format($_SESSION['ET'], 2, '.', '');
		$transferPrice	= number_format($onlyTransfer, 2, '.', '');
		$driversPrice	= number_format($_SESSION['DriversPrice'] , 2, '.', '');
		//$profit         = number_format($transferPrice - $driversPrice - $extras, 2, '.', ''); FIX
		$profit         = number_format($transferPrice - $driversPrice, 2, '.', '');

		if (s('returnTransfer')) {
			$payNow 		= number_format($_SESSION['PN'] / 2, 2, '.', '');
			$payLater 		= number_format($_SESSION['PL'] / 2, 2, '.', '');
			$extras 		= number_format($_SESSION['ET'] / 2, 2, '.', '');
			$transferPrice	= number_format($onlyTransfer / 2, 2, '.', '');
			$driversPrice	= number_format($_SESSION['DriversPrice'] / 2, 2, '.', '');
			//$profit         = number_format($transferPrice - $driversPrice - $extras, 2, '.', ''); FIX
			$profit         = number_format($transferPrice - $driversPrice, 2, '.', '');
		}


		
		// Driver Confirmation Status
		// za JT je pitanje sto bi ivdje trebalo biti 
		// 0 = no driver 
		// 1 = Not Confirmed
		// kako sad stvari stoje, driver odmah vidi transfer 
		// mozda bi trebalo isprazniti DriverID, pa da ga operater stavi kasnije
		$driverConfStatus = '1';
		
		$od->setSiteID('2');
		$od->setOrderID($omOrderID);
		$od->setTNo('1');
		$od->setUserID( $UserID);
		$od->setUserLevelID( $UserLevelID);
		if($_SESSION['GroupProfile'] == 'Agent') $od->setAgentID($_SESSION['AuthUserID']);
		$od->setCustomerID( $CustomerID);
		$od->setTransferStatus( '1');
		$od->setOrderDate(date("Y-m-d"));
		$od->setTaxidoComm( $profit);
		$od->setServiceID( $_SESSION["ServiceID"]);
		$od->setRouteID( $_SESSION["RouteID"]);
		$od->setFlightNo( $_SESSION["FlightNo"]);
		$od->setFlightTime( $_SESSION["FlightTime"]);
		$od->setPaxName( $_SESSION["MPaxFirstName"] . ' ' . $_SESSION['MPaxLastName']);
		$od->setPickupID($_SESSION['FromID']);
		$od->setPickupName( $fromName);
		$od->setPickupPlace( $_SESSION["PickupPlace"]);
		$od->setPickupAddress( $_SESSION["PickupAddress"]);
		$od->setPickupDate($_SESSION['transferDate']);
		$od->setPickupTime($_SESSION['transferTime']);
		$od->setPickupNotes( $_SESSION["PickupNotes"]);
		$od->setDropID($_SESSION['ToID']);
		$od->setDropName( $toName);
		$od->setDropPlace( $_SESSION["DropPlace"]);
		$od->setDropAddress( $_SESSION["DropAddress"]);
		$od->setDropNotes( $_SESSION["DropNotes"]);
		$od->setPriceClassID( $_SESSION["PriceClassID"]);
		$od->setDetailPrice( $transferPrice);
		$od->setDriversPrice( $driversPrice);
		$od->setDiscount( $_SESSION["CouponDiscount"]);
		$od->setExtraCharge( $extras);
		$od->setPaymentMethod( $_SESSION["PaymentOption"]);
		$od->setPaymentStatus( $paymentStatus);
		$od->setPayNow( $payNow);
		$od->setPayLater( $payLater);
		$od->setInvoiceAmount( $_SESSION["InvoiceAmount"]);
		$od->setProvisionAmount( $_SESSION["ProvisionAmount"]);
		$od->setPaxNo($_SESSION['PaxNo']);
		$od->setVehiclesNo( $_SESSION["VehiclesNo"]);
		$od->setVehicleType( $vehicleTypeID );
		$od->setVehicleID( $_SESSION["VehicleID"]);
		$od->setVehiclesNo( $numberOfVehicles);
		$od->setDriverID( $_SESSION["DriverID"]);
		$od->setDriverName( $driverName);
		$od->setDriverEmail( $driverEmail);
		$od->setDriverTel( $driverTel);
		$od->setDriverConfStatus( $driverConfStatus);
		$od->setDriverConfDate( $_SESSION["DriverConfDate"]);
		$od->setDriverConfTime( $_SESSION["DriverConfTime"]);
		$od->setDriverNotes( $_SESSION["DriverNotes"]);
		$od->setDriverPayment( $_SESSION["DriverPayment"]);
		$od->setDriverPaymentAmt( $_SESSION["DriverPaymentAmt"]);
		$od->setRated( $_SESSION["Rated"]);
		$od->setSubPickupDate( $_SESSION["DriverPickupDate"]);
		$od->setSubPickupTime( $_SESSION["DriverPickupTime"]);
		$od->setSubDriver( $_SESSION["SubDriver"]);
		$od->setCar( $_SESSION["Car"]);
		$od->setCashIn( $_SESSION["CashIn"]);
		$od->setFinalNote( $_SESSION["FinalNote"]);

		
		$oneWayID = $od->saveAsNew();
		
		if (s('returnTransfer')) {
			$od->setSiteID('2');
			$od->setOrderID($omOrderID);
			$od->setTNo('2');
			$od->setUserID( $UserID);
			$od->setUserLevelID( $UserLevelID );
			if($_SESSION['GroupProfile'] == 'Agent') $od->setAgentID($_SESSION['AuthUserID']);
			$od->setCustomerID( $CustomerID );
			$od->setTransferStatus( '1');
			$od->setOrderDate(date("Y-m-d"));
			$od->setTaxidoComm( $profit );
			$od->setServiceID( $_SESSION["ServiceID"]);
			$od->setRouteID( $_SESSION["RouteID"]);
			$od->setFlightNo( $_SESSION["RFlightNo"]);
			$od->setFlightTime( $_SESSION["RFlightTime"]);
			$od->setPaxName( $_SESSION["MPaxFirstName"] . ' ' . $_SESSION['MPaxLastName']);
			$od->setPickupID($_SESSION['ToID']);
			$od->setPickupName( $toName);
			$od->setPickupPlace( $_SESSION["DropPlace"]);
			$od->setPickupAddress( $_SESSION["DropAddress"]);
			$od->setPickupDate($_SESSION['returnDate']);
			$od->setPickupTime($_SESSION['returnTime']);
			$od->setPickupNotes( $_SESSION["PickupNotes"]);
			$od->setDropID($_SESSION['FromID']);
			$od->setDropName( $fromName);
			$od->setDropPlace( $_SESSION["PickupPlace"]);
			$od->setDropAddress( $_SESSION["PickupAddress"]);
			$od->setDropNotes( $_SESSION["DropNotes"]);
			$od->setPriceClassID( $_SESSION["PriceClassID"]);
			$od->setDetailPrice( $transferPrice);
			$od->setDriversPrice( $driversPrice);
			$od->setDiscount( $_SESSION["CouponDiscount"]);
			$od->setExtraCharge( $extras);
			$od->setPaymentMethod( $_SESSION["PaymentOption"]);
			$od->setPaymentStatus( $paymentStatus);
			$od->setPayNow( $payNow);
			$od->setPayLater( $payLater);
			$od->setInvoiceAmount( $_SESSION["InvoiceAmount"]);
			$od->setProvisionAmount( $_SESSION["ProvisionAmount"]);
			$od->setPaxNo($_SESSION['PaxNo']);
			$od->setVehiclesNo( $_SESSION["VehiclesNo"]);
			$od->setVehicleType( $vehicleTypeID );
			$od->setVehicleID( $_SESSION["VehicleID"]);
			$od->setVehiclesNo( $numberOfVehicles );
			$od->setDriverID( $_SESSION["DriverID"]);
			$od->setDriverName( $driverName);
			$od->setDriverEmail( $driverEmail);
			$od->setDriverTel( $driverTel);
			$od->setDriverConfStatus( $driverConfStatus );
			$od->setDriverConfDate( $_SESSION["DriverConfDate"]);
			$od->setDriverConfTime( $_SESSION["DriverConfTime"]);
			$od->setDriverNotes( $_SESSION["DriverNotes"]);
			$od->setDriverPayment( $_SESSION["DriverPayment"]);
			$od->setDriverPaymentAmt( $_SESSION["DriverPaymentAmt"]);
			$od->setRated( $_SESSION["Rated"]);
			$od->setSubPickupDate( $_SESSION["DriverPickupDate"]);
			$od->setSubPickupTime( $_SESSION["DriverPickupTime"]);
			$od->setSubDriver( $_SESSION["SubDriver"]);
			$od->setCar( $_SESSION["Car"]);
			$od->setCashIn( $_SESSION["CashIn"]);
			$od->setFinalNote( $_SESSION["FinalNote"]);

		
			$returnID = $od->saveAsNew();		
		}// end if (s('returnTransfer'))
		
		$ExtraServices 	= s('ExtraServices');
		$ExtraSubtotals	= s('ExtraSubtotals');
		$ExtraItems		= s('ExtraItems');		
		if( count($ExtraItems) > 0 ) {
			foreach($ExtraItems as $rbr => $value) {
				if($ExtraSubtotals[$rbr] > 0) {
					
					$ox->setOrderDetailsID($oneWayID);
					$ox->setServiceID($rbr);
					$ox->setServiceName($ExtraServices[$rbr]);
					$ox->setPrice( nf( $ExtraSubtotals[$rbr] / $ExtraItems[$rbr] ) );
					$ox->setQty($ExtraItems[$rbr]);
					$ox->setSum($ExtraSubtotals[$rbr]);
					
					$ox->saveAsNew();
				}
			
			}
		}
		
		return $omOrderID;
}

