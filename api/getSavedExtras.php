<?

//echo '<pre>'; print_r($_REQUEST); echo '</pre>';
/*
 * Array
(
    [returnTransfer] => 1
    [MOrderType] => 2
    [SiteID] => 2
    [MOrderKey] => 149557287365243
    [MOrderDate] => 2017-05-31
    [MOrderTime] => 18:09:12
    [MOrderStatus] => 1
    [DetailsID_1] => 4150
    [DetailsID_2] => 4165
    [PickupID] => 145676
    [PickupName] => SPLIT CENTRE FERRY PORT
    [DropID] => 100009
    [DropName] => SPLIT AIRPORT
    [PickupDate] => 2017-07-12
    [PickupTime] => 14:10
    [XPickupID] => 100009
    [XPickupName] => SPLIT AIRPORT
    [XDropID] => 145676
    [XDropName] => SPLIT CENTRE FERRY PORT
    [XPickupDate] => 2017-07-20
    [XPickupTime] => 20:10
    [DetailPrice] => 60.00
    [BasePrice] => 54.27
    [DriversPrice] => 46.15
    [OneWayPrice] => 27.13
    [RouteID] => 9002
    [ServiceID] => 31739
    [DriverID] => 556
    [DriverName] => JAM GROUP D.O.O.
    [VehicleID] => 41
    [VehicleType] => 4
    [VehicleClass] => 1
    [VehicleName] => Standard, 4 passengers
    [VehicleDescription] => vehicle: standard vehicle class | equipment: air condition, music | driver: no specific requirements | service: meet&greet, help with luggage, music on request
    [VehicleImage] => http://dev.taxilyonairport.com/i/cars/sedan.jpg
    [VehicleCapacity] => 4
    [_ym_uid] => 1481195850568426907
    [__zlcmid] => dzg3j9o1Y1R7d3
    [_ga] => GA1.2.632826587.1461842590
    [PHPSESSID] => q4sq88gcfak47066ebirksor82
)
 */
 

	@session_start();


	require_once ROOT . '/f2/f.php';

	require_once ROOT . '/db/v4_Extras.class.php';
	require_once ROOT . '/db/v4_OrderExtrasTemp.class.php';

	$x	 = new v4_Extras();	
	$oxt = new v4_OrderExtrasTemp();
	
	$selectedExtras = $checkoutExtras = array();
	
	$details1 	= $_REQUEST['DetailsID_1'];
	$details2 	= $_REQUEST['DetailsID_2'];
	$RT 		= $_REQUEST['returnTransfer'];

	
	// check Details
	$oxtKeys1 	= $oxt->getKeysBy('ID', 'ASC', 
				" WHERE OrderDetailsID = '" . $details1 ."'");
	
	if( count($oxtKeys1) > 0) {
		foreach( $oxtKeys1 as $nn => $ID) {
			$oxt->getRow( $ID );
			$ServiceID = $oxt->getServiceID();
			
			// in jquery this translates to:
			// $("#1_19").val('10.00').change()
			//$selectedExtras['1_' . $ServiceID ] = nf( $oxt->getSum() ); 
			$selectedExtras['1_' . $ServiceID ] = array("value" =>nf( $oxt->getSum()), "pcs" => $oxt->getQty() ); 
			//$selectedExtras['1_' . $ServiceID ] = nf( $oxt->getPrice() ); 
			
			// for Checkout
			$x->getRow($ServiceID);
			// languages
			$ServiceDescLangField = 'getService'.Lang();
			if($ServiceDescLangField == 'getService') $ServiceDescLangField = 'getServiceEN';
			
			$checkoutExtras[] = array(
				'DetailsID' 	=> $details1,
				'ServiceDesc' 	=> $x->$ServiceDescLangField(),
				'Price'			=> $oxt->getPrice(),
				'Qty'			=> $oxt->getQty(),
				'Sum'			=> $oxt->getSum(),
				'ServiceID'		=> $ServiceID
			);			
		}
	}

	if($RT) {
		// check Details
		$oxtKeys2 	= $oxt->getKeysBy('ID', 'ASC', 
					" WHERE OrderDetailsID = '" . $details2 ."'");
	
		if( count($oxtKeys2) > 0) {
			foreach( $oxtKeys2 as $nn => $ID) {
				$oxt->getRow( $ID );
				$ServiceID = $oxt->getServiceID();
				// in jquery this translates to:
				// $("#2_19").val('10.00').change()
				//$selectedExtras['2_' . $ServiceID ] = nf( $oxt->getSum() );
				$selectedExtras['1_' . $ServiceID ] = array("value" => nf( $oxt->getSum()), "pcs" => $oxt->getQty() ); 
				
				
				// for Checkout
				$x->getRow($ServiceID);
				// languages
				$ServiceDescLangField = 'getService'.Lang();
				if($ServiceDescLangField == 'getService') $ServiceDescLangField = 'getServiceEN';
				
				$checkoutExtras[] = array(
					'DetailsID' 	=> $details2,
					'ServiceDesc' 	=> $x->$ServiceDescLangField(),
					'Price'			=> $oxt->getPrice(),
					'Qty'			=> $oxt->getQty(),
					'Sum'			=> $oxt->getSum(),
					'ServiceID'		=> $ServiceID
				);
			}
		}
	}
	

	if(isset($_GET['callback'])) {
		$extras = json_encode($selectedExtras);
		echo $_GET['callback'] . '(' . $extras. ')';
	}	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

