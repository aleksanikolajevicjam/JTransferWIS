<?
//header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(0);
@session_start();

$SAuthUserID = $_SESSION['AuthUserID'];
$FRDriver = false;

require_once ROOT . '/cms/fixDriverID.php';

foreach($fakeDrivers as $key => $fakeDriverID) {
    if($SAuthUserID == $fakeDriverID) {
        $FRDriver = true;
    }
}

# init libs
require_once ROOT . '/f/f.php';

require_once '../../db/db.class.php';
require_once '../../db/v4_AuthUsers.class.php';

if($FRDriver == true) require_once '../../db/v4_OrderDetailsFR.class.php';
else require_once '../../db/v4_OrderDetails.class.php';

require_once '../../db/v4_OrdersMaster.class.php';
require_once '../../db/v4_OrderLog.class.php';
require_once '../lng/en_text.php';

// ukljuci mail funkcije
require_once 'informFuncs.php';

# init class
$au = new v4_AuthUsers();

if($FRDriver == true) $od = new v4_OrderDetailsFR();
else $od = new v4_OrderDetails();

$om = new v4_OrdersMaster();
$ol = new v4_OrderLog();

# init vars
$data = array();
$icon = 'fa fa-cloud-upload bg-blue';
$logDescription = '';
$logAction = 'Update';
$logTitle = 'Order Updated by ' . $_GET['UserName'];
$showToCustomer = 0;
$customerDescription = '';

$DetailsID = $_GET['DetailsID'];

$od->getRow($DetailsID);
$OrderID = $od->getOrderID();

// Master
$om->getRow($OrderID);

// user data
$isAgent = false;
$MAgentCommisionPercent = 0;

if($om->getMUserLevelID() == '2') {
	$au->getRow( $om->getMUserID() );
	$MAgentCommisionPercent = $au->getProvision();
	$isAgent = true;
}


// spremi stare vrijednosti
$odFields = $od->fieldValues();
$omFields = $om->fieldValues();

$priceChanged = false;
$paxNameChanged = false;

// usporedi sto se promijenilo
// radi samo za polja koja su poslana GET-om
foreach($odFields as $fld => $value) {
	if(array_key_exists($fld, $_GET)) {

		// priprema data arraya - 'Ime_iz_tabele' => vrijednost iz GET-a
		// znaci svakom polju iz tabele se dodjeljuje vrijednost poslana GET-om
		$data[$fld] = $_GET[$fld];

		//echo $data[$fld]. ' = '.$_GET[$fld] . '<br>';

		// ako je nova vrijednost u polju
		if($value !== $_GET[$fld]) {

			$logDescription .= 'Changed: '. $fld . ' <b>from:</b> ' . $value . ' <b>to:</b> ' . 
								$_GET[$fld] . '<br>';
			
			// ako se promijenio vozac
			if ($fld == 'DriverID') {

				// obavijesti starog vozaca
				$logDescription .= informOldDriver($od->getOrderID(),$od->getTNo(),$value) . '<br>';

				// obavijesti novog vozaca
				$logDescription .= informNewDriver($od->getOrderID(),$od->getTNo(),$_GET[$fld]) .'<br>';

				// obavijesti kupca 
				$customerDescription .= YOUR_NEW_DRIVER_NAME . ' : ' . $_GET['DriverName'] . '<br>';
				$customerDescription .= YOUR_NEW_DRIVER_TEL . ' : ' . $_GET['DriverTel'] . '<br>';
				
				// Ovo se salje tek kad novi vozac potvrdi transfer
				//$logDescription .= informCustomer($od->getOrderID(),$od->getTNo(), $customerDescription) . '<br>';
							
			}

			if($fld == 'StaffNote' && !empty($data['StaffNote']) ) {
				$data['StaffNote']= date("Y-m-d"). " - " .$_SESSION['UserRealName'] ." / ".$data['StaffNote'];
			}
			if($fld == 'DetailPrice') {
				$priceChanged = true;
				
				if($isAgent) {
					// izracunaj nove vrijednosti za v4_OrderDetails
					$data['ProvisionAmount'] = nf( $_GET['DetailPrice'] * $MAgentCommisionPercent / 100 );
					$data['InvoiceAmount'] = nf( $_GET['DetailPrice'] - $data['ProvisionAmount'] );
				}
				
				// ako nije placanje racunom (agenti) onda povecaj ili umanji cash za razliku cijena
				if($odFields['InvoiceAmount'] == 0) {
					$data['PayLater'] = nf( $_GET['DetailPrice'] - $odFields['PayNow'] );
				}
			}


			if($fld == 'PayNow' or $fld == 'PayLater') {
				$priceChanged = true;
			}

			if($fld == 'DriversPrice' ) {
				$DpriceChanged = true;
			}
		}
	}
}


// usporedi sto se promijenilo
// radi samo za polja koja su poslana GET-om
foreach($omFields as $fld => $value) {
	if(array_key_exists($fld, $_GET)) {

		// priprema data arraya - 'Ime_iz_tabele' => vrijednost iz GET-a
		// znaci svakom polju iz tabele se dodjeljuje vrijednost poslana GET-om
		$dataM[$fld] = $_GET[$fld];

		// ako je nova vrijednost u polju
		if($value !== $_GET[$fld]) {
			$logDescription .= 'Changed: '. $fld . ' <b>from:</b> ' . $value . ' <b>to:</b> ' . 
								$_GET[$fld] . '<br>';

            // izuzetak - promijenjeno ime putnika
		    if($fld == 'MPaxFirstName' or $fld == 'MPaxLastName') {
			    $paxNameChanged = true;
		    }
			
		}
	}
}



if($FRDriver == true) {
    XUpdate('v4_OrderDetailsFR', $data, ' DetailsID='.$DetailsID );
} else{
    XUpdate('v4_OrderDetails', $data, ' DetailsID='.$DetailsID );
    XUpdate('v4_OrdersMaster', $dataM, ' MOrderID='.$OrderID );
}    

// Ime putnika treba promijeniti u oba transfera, ako postoje
// ovo je izdvojeno jer je to za sada jedini podatak koji se mijenja 
// u oba transfera i u Master
if($paxNameChanged) {
    $data = array();
	$data['PaxName'] = $_GET['MPaxFirstName'] . ' ' . $_GET['MPaxLastName'];

	if($FRDriver == true) XUpdate('v4_OrderDetailsFR', $data, ' OrderID='.$OrderID ); 
	else XUpdate('v4_OrderDetails', $data, ' OrderID='.$OrderID ); 
}

if($FRDriver == false) { // FRANCUSKA FIX - ovo ne smije radit za fake drivere
    if($priceChanged) {

	    $MTransferPrice 		= 0;
	    $MExtrasPrice 			= 0;
	    $MOrderPriceEUR			= 0;
	    $MOrderCurrencyPrice 	= 0;
	    $MPayNow				= 0;
	    $MPayLater				= 0;
	    $MInvoiceAmount			= 0;
	    $MAgentCommision		= 0;
	    $MEurToCurrencyRate 	= $om->getMEurToCurrencyRate();
	
	    // pronaci sve transfere
	    $dKey = $od->getKeysBy('DetailsID', 'asc', " WHERE OrderID = '".$OrderID."'");

	    foreach($dKey as $nn => $DetailsID) {
		
		    $od->getRow($DetailsID);
		
		    $MTransferPrice 	+= $od->getDetailPrice();
		    $MExtrasPrice 		+= $od->getExtraCharge();
		    $MOrderPriceEUR 	+= $od->getDetailPrice() + $od->getExtraCharge();
		    $MPayNow 			+= $od->getPayNow();
		    $MPayLater 			+= $od->getPayLater();
		    $MInvoiceAmount 	+= $od->getInvoiceAmount();
		    $MAgentCommision	+= $od->getProvisionAmount();
		    $MOrderCurrencyPrice+= ($od->getDetailPrice() + $od->getExtraCharge() ) * $MEurToCurrencyRate;
		
	    }
	
	    $om->getRow($OrderID);	
	    $om->setMTransferPrice($MTransferPrice);
	    $om->setMExtrasPrice($MExtrasPrice);
	    $om->setMOrderPriceEUR($MOrderPriceEUR);
	    $om->setMPayNow($MPayNow);
	    $om->setMPayLater($MPayLater);
	    $om->setMInvoiceAmount($MInvoiceAmount);
	    $om->setMAgentCommision($MAgentCommision);
	    $om->setMOrderCurrencyPrice($MOrderCurrencyPrice);
	
	    $om->saveRow();
		
		$logDescription=$logDescription." CHANGE PRICE REASON: ".$_GET['ChangePriceReason'];
    }
	if($DpriceChanged) $logDescription=$logDescription." CHANGE PRICE REASON: ".$_GET['ChangePriceReason'];


    if($logDescription != '') { // ako nema promjena u podacima, ne treba nista upisivati

	    $ol->setOrderID($OrderID);
	    $ol->setDetailsID($DetailsID);
	    $ol->setAction($logAction);
	    $ol->setTitle($logTitle);
	    $ol->setDescription($logDescription);
	    $ol->setDateAdded(date("Y-m-d"));
	    $ol->setTimeAdded(date("H:i:s"));
	    $ol->setUserID($_GET['AuthUserID']);
	    $ol->setIcon($icon);
	    $ol->setShowToCustomer($showToCustomer);

	    $ol->saveAsNew();
    }

    if($customerDescription != '') {
	    $ol->setOrderID($OrderID);
	    $ol->setDetailsID($DetailsID);
	    $ol->setAction($logAction);
	    $ol->setTitle(IMPORTANT_UPDATE);
	    $ol->setDescription($customerDescription);
	    $ol->setDateAdded(date("Y-m-d"));
	    $ol->setTimeAdded(date("H:i:s"));
	    $ol->setUserID('3');
	    $ol->setIcon('fa fa-info-circle bg-purple');
	    $ol->setShowToCustomer('1');

	    $ol->saveAsNew(); 
    }
} // end FRANCUSKA FIX

echo 'Done';


# Funkcija je promijenjena da odgovara DataBaseMysql klasi
function XUpdate ($table, $data, $where)
	{
		if (count($data)>0) {
			require_once '../../db/db.class.php';
			$mysqli = new DataBaseMysql();
			
			$qry = 'UPDATE '.$table.' SET ';
		   

			foreach ($data as $field => $value)
			{
				$value = $mysqli->real_escape_string($value);
				$qry .= $field . " = '" .  trim($value). "' ,";
			}

			# Get rid of last ,
			$qry = substr_replace( $qry, "", -1 );

			$qry .= ' WHERE '.$where;
			unset($data);
			echo $qry;

			return $mysqli->RunQuery($qry) or die($mysqli->error . ' On UPDATE');
		}
	} #End XUpdate


