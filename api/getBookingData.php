<?

function getBookingData($makeJson = false) {
    require_once ROOT . '/db/v4_OrdersMasterTemp.class.php';
    require_once ROOT . '/db/v4_OrderDetailsTemp.class.php';
    require_once ROOT . '/db/v4_OrderExtrasTemp.class.php';
    require_once ROOT . '/db/v4_AuthUsers.class.php';
    require_once ROOT . '/db/v4_Services.class.php';
    require_once ROOT . '/db/v4_Routes.class.php';
    require_once ROOT . '/db/v4_DriverRoutes.class.php';
    require_once ROOT . '/db/v4_Vehicles.class.php';

    $allRecords = $omtFields = $odtFields = array(); // array of all records related to this transfer

    $omt = new v4_OrdersMasterTemp();
    $odt = new v4_OrderDetailsTemp();

    // IOS Fix
    if( !isset($_SESSION['TOK']) or empty($_SESSION['TOK']) and (isset($_REQUEST['TOK']) and !empty($_REQUEST['TOK'])) ) {
        $_SESSION['TOK'] = $_REQUEST['TOK'];
    }

    //@Blogit($_SESSION);
    //@Blogit($_REQUEST);
    $currentOrderKey = $_SESSION['TOK'];

    @Blogit('getBookingDataNow: ' . $currentOrderKey);

    $omtKeys = $omt->getKeysBy('MOrderID', 'ASC', " WHERE MOrderKey = '" . $currentOrderKey ."'");

    if( count($omtKeys) > 0 ) { // temp order found
        $omt->getRow($omtKeys[0]);
        $allRecords['Master'] = $omt->fieldValues();
    }



    // check Details
    $odtKeys = $odt->getKeysBy('DetailsID', 'ASC, TNo ASC', " WHERE OrderID = '" . $omt->getMOrderID() ."'");

    if( count($odtKeys) > 0) {
        foreach( $odtKeys as $nn => $DetailsID) {
            $odt->getRow( $DetailsID );

            $allRecords[] = $odt->fieldValues();
        }
    }

    if ($makeJson==true) echo json_encode($allRecords); // return value to caller
    else return $allRecords;
}
