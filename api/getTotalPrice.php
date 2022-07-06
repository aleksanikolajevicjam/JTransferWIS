<?
/*
 * Calculate total prices from all OrderDetailsTemp
 * and update OrdersMasterTemp
 * 
 * return totalPrice as json array
 */
	
	@session_start();
	error_reporting(E_PARSE);
	//echo '<pre>'; print_r($_REQUEST); echo '</pre>';
	require_once ROOT . '/f2/f.php';	
	require_once ROOT . '/db/v4_OrdersMasterTemp.class.php';
	require_once ROOT . '/db/v4_OrderDetailsTemp.class.php';
	
	$omt = new v4_OrdersMasterTemp();
	$odt = new v4_OrderDetailsTemp();
	
	$totalPrices = array();
	$totalTransfer = $totalExtras = $totalPrice = 0;
	
	$tempOrderKey = $_REQUEST['MOrderKey'];
	
	$omtKeys = $omt->getKeysBy('MOrderID', 'ASC', " WHERE MOrderKey = '" . $tempOrderKey ."'");

	if( count($omtKeys) == 1 ) { // temp order found
		$omt->getRow($omtKeys[0]);
		$odtKeys = $odt->getKeysBy('DetailsID', 'ASC, TNo ASC', " WHERE OrderID = '" . $omt->getMOrderID() ."'");
		
		foreach($odtKeys as $nn => $DetailsID) {
			$odt->getRow( $DetailsID );
			$totalTransfer += $odt->getDetailPrice();
			$totalExtras   += $odt->getExtraCharge();
			$totalPrice = $totalTransfer + $totalExtras;
		}
		
		$omt->setMTransferPrice( $totalTransfer );
		$omt->setMExtrasPrice( $totalExtras );
		$omt->setMOrderPriceEUR( $totalPrice );
		$omt->setMEurToCurrencyRate(1);
		$omt->setMOrderCurrencyPrice( $totalPrice );
		$omt->setMOrderCurrency( 'EUR');
		
		$omt->saveRow();
	}
	
	$totalPrices['TransferTotal'] 	= nf( $totalTransfer );
	$totalPrices['ExtrasTotal'] 	= nf( $totalExtras );
	$totalPrices['Total'] 			= nf( $totalPrice );
	
	
	$totalPrices = json_encode($totalPrices);
	echo $_GET['callback'] . '(' . $totalPrices. ')';	
