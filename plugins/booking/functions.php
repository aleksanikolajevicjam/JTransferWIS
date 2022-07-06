<?	
	function toarray($arr,$new_array,$key_pr) {
		foreach ($arr as $key=>$field)
		{
			if ($key_pr<>'') $key_res=$key_pr."_".$key;
			else $key_res=$key;		
			
			if (is_array($field)) {
			
				$new_array3=toarray($field,$new_array,$key_res);
				$new_array=array_merge($new_array, $new_array3);	
			}		
			else {
				$new_array[$key_res]=$field;	
			}		
		}
		return $new_array;
	}
	function getContractPrice($VehicleTypeID, $RouteID, $AgentID) {
		global $db;
		$q5 = "SELECT * FROM v4_AgentPrices
				WHERE RouteID = ".$RouteID." AND VehicleTypeID = ".$VehicleTypeID." AND AgentID = ".$AgentID;
		$w5 = $db->RunQuery($q5);
		$cp = mysqli_fetch_object($w5);
		if (count($cp)>0) return $cp->Price;
		else return 0;
	}	

	function getContractExtrasPrice($ExtrasID, $AgentID) {
		global $db;
		$q6 = "SELECT * FROM v4_AgentExtras
				WHERE ExtrasID = ".$ExtrasID." AND AgentID = ".$AgentID;
		$w6 = $db->RunQuery($q6);
		$cp = mysqli_fetch_object($w6);
		if (is_array($cp) && count($cp)>0) return $cp->Price;
		else return 0;
	}	
	function fiksniDio() {
		$term_name = GetPlaceName(s('FromID')); 
		$dest_name = GetPlaceName(s('ToID'));

		if ($term_name == '') $term_name = YOUR_TERM;
		if ($dest_name == '') $dest_name = YOUR_DEST;

		if ($_SESSION['language'] == 'en') {
			$fiksni_dio = 	BOOKING_ABOUT_1 . $term_name . BOOKING_ABOUT_2 . $dest_name .
							BOOKING_ABOUT_3 . $term_name . BOOKING_ABOUT_4 . $dest_name .
							BOOKING_ABOUT_5 . $term_name . BOOKING_ABOUT_6 . $dest_name .
							BOOKING_ABOUT_7 . $dest_name . BOOKING_ABOUT_8 . $term_name .
							BOOKING_ABOUT_9 . $dest_name . BOOKING_ABOUT_10;
		}

		return $fiksni_dio;
	}

	function getAgents()
	{
		global $au;
		$retArr = array();
		
		$where = " WHERE AuthLevelID = '2' AND Active=1";
		$k = $au->getKeysBy("AuthUserCompany", "asc", $where);
		
		if(count($k) > 0 ) {
			foreach($k as $nn => $key) {
				$au->getRow($key);
				# Stavi TaxiSite-ove u array za kasnije
				$retArr[$au->AuthUserID] = $au->AuthUserCompany;
				
			}
		}
		$where = " WHERE AuthLevelID = '12' AND Active=1";
		$k = $au->getKeysBy("AuthUserCompany", "asc", $where);
		
		if(count($k) > 0 ) {
			foreach($k as $nn => $key) {
				$au->getRow($key);
				# Stavi TaxiSite-ove u array za kasnije
				$retArr[$au->AuthUserID] = $au->AuthUserCompany;
				
			}
		}
		return $retArr;
	}	
	function insertOrder($type='temp') {	

		global $OrderKey;
		require_once ROOT . '/db/v4_OrdersMaster.class.php';
		require_once ROOT . '/db/v4_OrderDetails.class.php';
		require_once ROOT . '/db/v4_OrderExtras.class.php';
		require_once ROOT . '/db/v4_OrderLog.class.php';

		$om = new v4_OrdersMaster();
		$od = new v4_OrderDetails();
		$ox = new v4_OrderExtras();
		$ol = new v4_OrderLog();
		
		$OrderKey = create_order_key(); // pravi OrderKey
		
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
		
		$UserID = '53';
		
		if(!isset($_SESSION['Customer']['ID']) or empty($_SESSION['Customer']['ID'])) {
			
			$CustomerID = '';
			$UserLevelID = '3';
			
		} else {
			$CustomerID = $_SESSION['Customer']['ID'];
			$UserLevelID = '3';
		}
		
		if(isset($_SESSION['AuthUserID']) and isset($_SESSION['AuthLevelID']) and $_SESSION['UserAuthorized']) {
			$UserID = $_SESSION['AuthUserID'];
			$UserLevelID = $_SESSION['AuthLevelID'];
		}
		
		$user = getUserData($UserID);
		// provizija ide samo na cijenu transfera, ne na TotalPrice
		
		// oduzimam Extras jer je izgleda provizija isla na sve...
		$samoTransfer = $_SESSION['TT'] - $_SESSION['ET'];

		$Invoice = ($_SESSION['Price'] + $_SESSION['ET'] -  $_SESSION["AgentPrice"]);
		
	 
		$payNow = $_SESSION['PN'];
		$payLater = $_SESSION['PL'];
		// Pon 27 Stu 2017 20:42:13 NOVO - sve online za agente
		if($_SESSION['PaymentOption'] == '1') { // Sve online - provizija
			
			$payNow   = $invoice; // prebaci da je placeno online
			$payLater = '0';      // nista ne ostaje za cash
			$InvoiceMaster  = '0.00';   // nema nista ni za invoice
			$paymentStatus = '99';
		
		}
		if($_SESSION['PaymentOption'] == '2') { // Sve cash   
			$payLater   = $_SESSION['Price'] + $_SESSION['ET']; // prebaci da je placeno cash
			$payNow = '0';      // nista ne ostaje za online
			$InvoiceMaster  = '0.00';   // nema nista ni za invoice    
		}
		if (isset($_SESSION["AgentID"]) && $_SESSION["AgentID"]>0) {
			$orderuserid=$_SESSION["AgentID"];
			$orderuserlevelid=$_SESSION["UserLevelID"];
		}	
		else {
			$orderuserid=$_SESSION['AuthUserID'];
			$orderuserlevelid=$_SESSION["AuthLevelID"];
		}	
			
	// OrdersMaster
		$om->setMOrderKey( $OrderKey );
		$om->setSiteID('2');
		$om->setMOrderStatus('1');
		$om->setMOrderType( $_SESSION["MOrderType"]);
		$om->setMOrderDate(date("Y-m-d"));
		$om->setMOrderTime(date("H:i:s"));
		$om->setMUserID( $orderuserid);
		$om->setMUserLevelID( $orderuserlevelid ); 
		$om->setMCustomerID( $CustomerID );
		$om->setMTransferPrice( $_SESSION['TT']);
		$om->setMProvision( $_SESSION["AgentPrice"]);		
		$om->setMExtrasPrice( $_SESSION['ET']);
		$om->setMOrderPriceEUR( $_SESSION["Price"]);
		$om->setMOrderCurrency( $_SESSION["Currency"]);
		$om->setMOrderCurrencyPrice( $_SESSION["Price"]);
		$om->setMEurToCurrencyRate( ExchangeRatio());
		$om->setMPaymentMethod( $_SESSION["PaymentOption"]);
		$om->setMPaymentStatus( $paymentStatus);
		$om->setMPayNow( $payNow);
		$om->setMPayLater( $payLater);
		$om->setMInvoiceAmount( $InvoiceMaster);
		$om->setMAgentCommision( $_SESSION["AgentPrice"]);
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
		$om->setMConfirmFile( $_SESSION["ReferenceNo"]); // privremeno koristimo za smestaj referentnog broja agenta
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
			
		// Kalkulacija cijena za upis
		$InvoiceDetails = number_format($Invoice, 3, '.', '');
		$AgentCommisionDetails = $_SESSION["AgentPrice"];
		$numberOfVehicles = $_SESSION['VehiclesNo'];
		$payNow 		= number_format($_SESSION['PN'], 2, '.', '');
		$payLater 		= number_format($_SESSION['PL'], 2, '.', '');
		$extras 		= number_format($_SESSION['ET'], 2, '.', '');
		$transferPrice	= number_format($_SESSION['Price'], 3, '.', '');
		$driversPrice	= number_format($_SESSION['DriversPrice'] , 2, '.', '');
		$profit         = number_format($transferPrice - $driversPrice - $extras, 2, '.', '');

		if (s('returnTransfer')) {
			$InvoiceDetails = number_format($Invoice / 2, 3, '.', '');
			$AgentCommisionDetails = $_SESSION["AgentPrice"]/2;
			$payNow 		= number_format($_SESSION['PN'] / 2, 2, '.', '');
			$payLater 		= number_format($_SESSION['PL'] / 2, 2, '.', '');
			$extras 		= number_format($_SESSION['ET'] / 2, 2, '.', '');
			$transferPrice	= number_format($_SESSION['Price'] / 2, 3, '.', '');
			$driversPrice	= number_format($_SESSION['DriversPrice'] / 2, 2, '.', '');
			$profit         = number_format($transferPrice - $driversPrice - $extras, 2, '.', '');
		}
		
 
		// Pon 27 Stu 2017 20:42:03 NOVO - sve online za agente
		if($_SESSION['PaymentOption'] == '1') { // Sve online - provizija
			
			$payNow = $InvoiceDetails;  // prebaci da je placeno online
			$payLater = '0';            // nista ne ostaje za cash
			$InvoiceDetails = '0.00';   // nema nista ni za invoice
			$paymentStatus = '99';
		}
		if($_SESSION['PaymentOption'] == '2') { // Sve cash   
			$payLater   = $InvoiceDetails+$AgentCommisionDetails;// prebaci da je placeno cash
			$payNow = '0';      // nista ne ostaje za online
			$InvoiceDetails = '0.00';   // nema nista ni za invoice
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
		$od->setUserID( $orderuserid);
		//$od->setUserID($_SESSION['AuthUserID']);	
		$od->setUserLevelID($orderuserlevelid);
		$od->setAgentID( $orderuserid);
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
		$od->setProvision( $AgentCommisionDetails);
		$od->setDriversPrice( $driversPrice);
		$od->setDiscount( $_SESSION["Discount"]);
		$od->setExtraCharge( $extras);
		$od->setPaymentMethod( $_SESSION["PaymentOption"]);
		$od->setPaymentStatus( $paymentStatus);
		$od->setPayNow( $payNow);
		$od->setPayLater( $payLater);
		$od->setInvoiceAmount($InvoiceDetails );
		$od->setProvisionAmount($AgentCommisionDetails);
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

		$logTitle = 'Order Added by ' . $_SESSION['UserName'];
		$icon = 'fa fa-cloud-upload bg-blue';
		$logAction="Insert";
		$ol->setOrderID($omOrderID);
		$ol->setDetailsID($oneWayID);
		$ol->setAction($logAction);
		$ol->setTitle($logTitle);
		$ol->setDescription('Insert new transfer');
		$ol->setDateAdded(date("Y-m-d"));
		$ol->setTimeAdded(date("H:i:s"));
		$ol->setUserID($_SESSION['AuthUserID']);
		$ol->setIcon($icon);
		$ol->setShowToCustomer(0);

		$ol->saveAsNew();



		if (s('returnTransfer')) {
			$od->setSiteID('2');
			$od->setOrderID($omOrderID);
			$od->setTNo('2');
			$od->setUserID( $orderuserid);
			//$od->setUserID($_SESSION['AuthUserID']);	
			$od->setUserLevelID( $orderuserlevelid);
			$od->setAgentID( $orderuserid);
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
			$od->setPickupAddress( $_SESSION["RPickupAddress"]);
			$od->setPickupDate($_SESSION['returnDate']);
			$od->setPickupTime($_SESSION['returnTime']);
			$od->setPickupNotes( $_SESSION["PickupNotes"]);
			$od->setDropID($_SESSION['FromID']);
			$od->setDropName( $fromName);
			$od->setDropPlace( $_SESSION["PickupPlace"]); 
			$od->setDropAddress( $_SESSION["RDropAddress"]);
			$od->setDropNotes( $_SESSION["DropNotes"]);
			$od->setPriceClassID( $_SESSION["PriceClassID"]);
			$od->setDetailPrice( $transferPrice);
			$od->setProvision( $AgentCommisionDetails);
			$od->setDriversPrice( $driversPrice);
			$od->setDiscount( $_SESSION["Discount"]);
			$od->setExtraCharge( $extras);
			$od->setPaymentMethod( $_SESSION["PaymentOption"]);
			$od->setPaymentStatus( $paymentStatus);
			$od->setPayNow( $payNow);
			$od->setPayLater( $payLater);
			$od->setInvoiceAmount( $InvoiceDetails);
			$od->setProvisionAmount( $AgentCommisionDetails);
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
	
			$logTitle = 'Order Added by ' . $_SESSION['UserName'];
			$icon = 'fa fa-cloud-upload bg-blue';
			$logAction="Insert";
			$ol->setOrderID($omOrderID);
			$ol->setDetailsID($returnID);
			$ol->setAction($logAction);
			$ol->setTitle($logTitle);
			$ol->setDescription('Insert new transfer');
			$ol->setDateAdded(date("Y-m-d"));
			$ol->setTimeAdded(date("H:i:s"));
			$ol->setUserID($_SESSION['AuthUserID']);
			$ol->setIcon($icon);
			$ol->setShowToCustomer(0);

			$ol->saveAsNew();
			
			
		}// end if (s('returnTransfer'))

		$ExtraServices 	= s('ExtraServices');
		$ExtraSubtotals	= s('ExtraSubtotals');
		$ExtraItems		= s('ExtraItems');		
		if( count($ExtraItems) > 0 ) {
			if (s('returnTransfer')) $frt=2;
			else $frt=1;
			foreach($ExtraItems as $rbr => $value) {
				if($ExtraItems[$rbr] > 0) {
					
					$ox->setOrderDetailsID($oneWayID);
					$ox->setServiceID($rbr);
					$ox->setServiceName($ExtraServices[$rbr]);
					$ox->setPrice( number_format( $ExtraSubtotals[$rbr] / $ExtraItems[$rbr]/$frt ) );
					$ox->setQty($ExtraItems[$rbr]);
					$ox->setSum($ExtraSubtotals[$rbr]/$frt);
					
					$ox->saveAsNew();

				if (s('returnTransfer')) {//dodano spremanje servicea za return transfer (neznam dali ovo uopce treba, ali agentskim bookinzima se ne prikazuju extre za rt)

					$ox->setOrderDetailsID($returnID);
					$ox->setServiceID($rbr);
					$ox->setServiceName($ExtraServices[$rbr]);
					$ox->setPrice( number_format( $ExtraSubtotals[$rbr] / $ExtraItems[$rbr]/$frt ) );
					$ox->setQty($ExtraItems[$rbr]);
					$ox->setSum($ExtraSubtotals[$rbr]/$frt);
					
					$ox->saveAsNew();
					}
				}

			}
		}
		return $omOrderID;
	}

	function ShowRatings($userId) {
		require_once ROOT . '/db/v4_Ratings.class.php';
		
		$r = new v4_Ratings();
		
		$r->getRow($userId);
		
		if($r->getVotes() > 0)	return $r->getAverage() / $r->getVotes();
		else return '0';
		
		
	}

function getRoutePrices($fromID, $toID) {
	global $db;
	$prices = array();

	$places = array();

		# Routes for selected place
		$q1 = "SELECT FromID, ToID, RouteID FROM v4_Routes
					WHERE 
					(FromID = '{$fromID}'
					AND    ToID   = '{$toID}')
					OR
					(FromID = '{$toID}'
					AND    ToID   = '{$fromID}')				
					
					";
		$r1 = $db->RunQuery($q1);
		

		while($r = mysqli_fetch_object($r1))
		{
			
			# DriverRoutes - check if anyone drives from that Place
			$q2 = "SELECT DISTINCT RouteID FROM v4_DriverRoutes
						WHERE RouteID = '{$r->RouteID}' 
						";
			$w2 = $db->RunQuery($q2);
			
			# If does
			if  (mysqli_num_rows($w2) > 0)
			{

			# Services 
			$q3 = "SELECT * FROM v4_Services
						WHERE RouteID = '{$r->RouteID}' AND ServicePrice1 != 0 
						ORDER BY ServicePrice1 ASC";
			$w3 = $db->RunQuery($q3);
			while($s = mysqli_fetch_object($w3)) {
				$q4 = "SELECT * FROM v4_VehicleTypes
							WHERE VehicleTypeID = '{$s->VehicleTypeID}' "; 
				$w4 = $db->RunQuery($q4);
				$v = mysqli_fetch_object($w4);
				
				$type = $v->Max; // bilo VehicleTypeID - promjena 2016-05-25
				
				$sp = nf( calculateBasePrice($s->ServicePrice1, $s->OwnerID));
				
				// proveriti prisustvo route i vehicle type u tabeli ugovorenih cena za agenta, 
				// ukoliko postoji preuzeti ugovoreni cenu i formirati flag da je cena iz ugovora
				/*$AgentID=$_SESSION['AuthUserID']; 
				$VehicleTypeID=$s->VehicleTypeID;
				$RouteID=$r->RouteID;
				$q5 = "SELECT * FROM v4_AgentPrices
						WHERE RouteID = ".$RouteID." AND VehicleTypeID = ".$VehicleTypeID." AND AgentID = ".$AgentID;
				$w5 = $db->RunQuery($q5);
				$cp = mysqli_fetch_object($w5);
				if (count($cp)>0) $prices[$type]=$cp->Price;
				else {		
					if(array_key_exists($type, $prices) ) {
						if($prices[$type] > $sp) {
							$prices[$type] = $sp;
						}
					} else {				
						$prices[$type] = $sp;
					}
				}	*/			
				
				
				if(array_key_exists($type, $prices) ) {
					if($prices[$type] > $sp) {
						$prices[$type] = $sp;
					}
				} else {
				
					$prices[$type] = $sp;
				}
			}
			}

		}
	return $prices;
}

	// Dodavanje dogovorene provizije na osnovnu cijenu
	function calculateBasePrice($price, $ownerid, $VehicleClass = 1) {
		global $db;
		
			//$priceR = round($price, 0, PHP_ROUND_HALF_DOWN);
			$priceR = round($price, 2);
		
			# Driver
			$q = "SELECT * FROM v4_AuthUsers
						WHERE AuthUserID = '" .$ownerid."' 
						";
			$w = $db->RunQuery($q);
			
			$d = mysqli_fetch_object($w);
			
			if($d->AuthUserID == $ownerid) {
			
				// STANDARD CLASS
				if($VehicleClass < 11) {
					if ($priceR >= $d->R1Low and $priceR <= $d->R1Hi) return $price + ($price*$d->R1Percent / 100);
					else if ($priceR >= $d->R2Low and $priceR <= $d->R2Hi) return $price + ($price*$d->R2Percent / 100);
					else if ($priceR >= $d->R3Low and $priceR <= $d->R3Hi) return $price + ($price*$d->R3Percent / 100);
					else return $price;
				}

				// PREMIUM CLASS
				if($VehicleClass >= 11 and $VehicleClass < 21) {
					if ($price >= $d->PR1Low and $price <= $d->PR1Hi) return $price + ($price*$d->PR1Percent / 100);
					else if ($price >= $d->PR2Low and $price <= $d->PR2Hi) return $price + ($price*$d->PR2Percent / 100);
					else if ($price >= $d->PR3Low and $price <= $d->PR3Hi) return $price + ($price*$d->PR3Percent / 100);
					else return $price;
				}

				// FIRST CLASS
				if($VehicleClass >= 21) {
					if ($price >= $d->FR1Low and $price <= $d->FR1Hi) return $price + ($price*$d->FR1Percent / 100);
					else if ($price >= $d->FR2Low and $price <= $d->FR2Hi) return $price + ($price*$d->FR2Percent / 100);
					else if ($price >= $d->FR3Low and $price <= $d->FR3Hi) return $price + ($price*$d->FR3Percent / 100);
					else return $price;
				}

			}
			
			return '0';

			
	}

	function vehicleTypeName($vehicleTypeID) {
		require_once ROOT . '/db/db.class.php';
		$db = new DataBaseMysql();
		
		$w = $db->RunQuery("SELECT * FROM v4_VehicleTypes WHERE VehicleTypeID = '{$vehicleTypeID}'");
		$v = $w->fetch_object();

						$vehicleTypeName = 'VehicleTypeName'. Lang();
										
						$VehicleTypeName = strtolower($v->$vehicleTypeName);
		
		return $VehicleTypeName;
	}

	function isVehicleOffDuty($vehicleID, $transferDate, $transferTime) {
		$cnt = 0;
		require_once ROOT . '/db/db.class.php';
		$db = new DataBaseMysql();
		
		$r = $db->RunQuery("SELECT * FROM v4_OffDuty WHERE VehicleID = '".$vehicleID."' ORDER BY ID ASC");
		
		while($o = $r->fetch_object()) {

			if( inDateTimeRange($o->StartDate, $o->StartTime, $o->EndDate, $o->EndTime, $transferDate, $transferTime) ) {
				
				$cnt += 1;
			}
			
		}
		
		if($cnt >= 1) return true;
		else return false;
	}

	function calculateSpecialDates($OwnerID, $amount, $transferDate, $transferTime, $returnDate='', $returnTime='') {

		if( empty($OwnerID) or empty($amount) or empty($transferDate)  or empty($transferTime) ) return 0;

		require_once ROOT . '/db/v4_SpecialDates.class.php';
		$sd = new v4_SpecialDates();

		$add1 = 0;
		$add2 = 0;
		
		$keys = $sd->getKeysBy("ID", "ASC", " WHERE OwnerID = '" . $OwnerID ."'");
		if( count($keys) > 0) {
			foreach($keys as $nn => $ID) {
				$sd->getRow($ID);

				if( inDateTimeRange($sd->getSpecialDate(), $sd->getStartTime(), $sd->getSpecialDate(), $sd->getEndTime(), $transferDate, $transferTime) ) {
					$add1 = nf($amount * $sd->getCorrectionPercent() / 100);
				}
				
				if($returnDate != '' and $returnTime != '') {
					if( inDateTimeRange($sd->getSpecialDate(), $sd->getStartTime(), $sd->getSpecialDate(), $sd->getEndTime(), $returnDate, $returnTime) ) {
						$add2 = nf($amount * $sd->getCorrectionPercent() / 100);
					}
				}
			}
		}
		// zbroji oba transfera
		return $add1 + $add2;
	}

	function getCarImage ($VehicleClass) {
		if ($VehicleClass == '1') $vehicleImageFile = 'i/cars/sedan.jpg';
		else if ($VehicleClass == '2') $vehicleImageFile = 'i/cars/minivanl.jpg';
		else if ($VehicleClass == '3') $vehicleImageFile = 'i/cars/minibusl.jpg';
		else if ($VehicleClass == '4') $vehicleImageFile = 'i/cars/minibusl.jpg';	
		else if ($VehicleClass == '5' or $VehicleClass == '6') 	$vehicleImageFile = 'i/cars/bus.jpg';	

		else if ($VehicleClass == '11') $vehicleImageFile = 'i/cars/sedan_p.jpg';
		else if ($VehicleClass == '12') $vehicleImageFile = 'i/cars/minivans_p.jpg';
		else if ($VehicleClass == '13') $vehicleImageFile = 'i/cars/minivans_p.jpg';
		else if ($VehicleClass == '14') $vehicleImageFile = 'i/cars/minibusl_p.jpg';	
		else if ($VehicleClass == '15' or $VehicleClass == '16') 	$vehicleImageFile = 'i/cars/bus_p.jpg';							

		else if ($VehicleClass == '21') $vehicleImageFile = 'i/cars/sedan_l.jpg';
		else if ($VehicleClass == '22') $vehicleImageFile = 'i/cars/minivans_l.jpg';
		else if ($VehicleClass == '23') $vehicleImageFile = 'i/cars/minivanl_l.jpg';
		else if ($VehicleClass == '24') $vehicleImageFile = 'i/cars/minibusl_l.jpg';	
		else if ($VehicleClass == '25' or $VehicleClass == '26') 	$vehicleImageFile = 'i/cars/bus_l.jpg';
		
		return$VehicleImageRoot.$vehicleImageFile;
	}						