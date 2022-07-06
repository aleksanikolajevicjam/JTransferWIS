<?
header('Content-Type: text/javascript; charset=UTF-8');
@session_start();
$cars = array();



    require_once ROOT . '/f2/f.php';
    require_once ROOT . '/db/v4_OrdersMasterTemp.class.php';
    require_once ROOT . '/db/v4_OrderDetailsTemp.class.php';
    require_once ROOT . '/db/v4_OrderExtrasTemp.class.php';
    require_once ROOT . '/db/v4_AuthUsers.class.php';
    require_once ROOT . '/db/v4_Services.class.php';
    require_once ROOT . '/db/v4_Routes.class.php';
    require_once ROOT . '/db/v4_DriverRoutes.class.php';
    require_once ROOT . '/db/v4_Vehicles.class.php';

@Blogit('api2/saveBookingData');
@Blogit($_REQUEST);

    $allRecords = array(); // array of all records related to this transfer

    $omt = new v4_OrdersMasterTemp();
    $odt = new v4_OrderDetailsTemp();
    $oxt = new v4_OrderExtrasTemp();


    $omtFields = $omt->fieldNames();
    $odtFields = $odt->fieldNames();

    $currentOrderKey = $_REQUEST['MOrderKey'];

    $RT = $_REQUEST['returnTransfer'];
    
    // Driver data
    $driverEmail = '';
    $driverTel = '';

    if(isset($_REQUEST['DriverID']) and $_REQUEST['DriverID'] != '') {
        $driver = getUser($_REQUEST['DriverID']);
        $driverEmail = $driver->AuthUserMail;
        $driverTel = $driver->AuthUserTel;
    } 
    

    $omtKeys = $omt->getKeysBy('MOrderID', 'ASC', " WHERE MOrderKey = '" . $currentOrderKey ."'");

    if( count($omtKeys) == 1 ) { // temp order found
        $omt->getRow($omtKeys[0]);
    }

    // set values to table fields
    foreach($_REQUEST as $field => $value) {
        if( in_array($field, $omtFields) ) {
            $setter = "set". $field;
            //  call set function - example: setMOrderDate()
            $omt->$setter( $value );
        }
    }


    if( count($omtKeys) == 1 ) { // temp order found
        $omt->saveRow();
        $MOrderID = $omt->getMOrderID();

    } else { // not found, add order

        $MOrderID = $omt->saveAsNew();
    }

    $allRecords['MOrderID'] = $MOrderID;

    // check Details
    $odtKeys = $odt->getKeysBy('DetailsID', 'ASC, TNo ASC', " WHERE OrderID = '" . $MOrderID ."'");

    $detailsNo = count($odtKeys);

    $updateFirst = $updateReturn = $addFirst = $addReturn = $deleteReturn = 0; // reset all


    // cijene za RT su uduplane, treba ih prepolovit
    if($RT) {
        $_REQUEST['DetailPrice'] = $_REQUEST['DetailPrice'] / 2;
        $_REQUEST['DriversPrice'] = $_REQUEST['DriversPrice'] / 2;
    }

    // just one transfer found, update
    if( $detailsNo == 1 and $RT == 0) {$updateFirst = 1; }
    // two transfers found, update both
    if( $detailsNo == 2 and $RT == 1) {$updateFirst = 1; $updateReturn = 1;}

    // one found, return exists, but not added
    if( $detailsNo == 1 and $RT == 1) {$updateFirst = 1; $addReturn = 1;}

    // return transfer removed, update first, remove second
    if( $detailsNo == 2 and $RT == 0) {$deleteReturn = 1; $updateFirst = 1;}

    // one or both are new
    if( $detailsNo == 0 and $RT == 0) {$addFirst = 1; $addReturn = 0;}
    if( $detailsNo == 0 and $RT == 1) {$addFirst = 1; $addReturn = 1;}


    // UPDATE FIRST
    if( $updateFirst ) {
        $odt->getRow($odtKeys[0]);

        if($odt->getTNo() == '1') { // first transfer
            // set values to table fields
            foreach($_REQUEST as $field => $value) {
                if( in_array($field, $odtFields) ) {
                    $setter = "set". $field;
                    //  call set function - example: setOrderDate()
                    $odt->$setter( $value );
                }
            }
            if(isset($_REQUEST['MPaxFirstName']) and isset($_REQUEST['MPaxLastName'])) {
                $odt->setPaxName($_REQUEST['MPaxFirstName'] .' ' . $_REQUEST['MPaxLastName']);
            }
            $odt->setDriverEmail($driverEmail);
            $odt->setDriverTel($driverTel);
            $odt->saveRow();
            $allRecords['DetailsID_1'] = $odt->getDetailsID();

        }
    }

    // UPDATE SECOND
    if( $updateReturn) {
        $odt->getRow($odtKeys[1]);

        if($odt->getTNo() == '2') { // RETURN transfer

            // set values to table fields
            foreach($_REQUEST as $field => $value) {

                // Return fields have a prefix X
                // This removes the leading X. Example: XPickupTime becomes PickupTime
                $field = trim($field, 'X');

                if( in_array($field, $odtFields) ) {
                    $setter = "set". $field;
                    //  call set function - example: setOrderDate()
                    $odt->$setter( $value );
                }
            }
            if(isset($_REQUEST['MPaxFirstName']) and isset($_REQUEST['MPaxLastName'])) {
                $odt->setPaxName($_REQUEST['MPaxFirstName'] .' ' . $_REQUEST['MPaxLastName']);
            }
            $odt->setDriverEmail($driverEmail);
            $odt->setDriverTel($driverTel);            
            $odt->saveRow();
            $allRecords['DetailsID_2'] = $odt->getDetailsID();
        }
    }



    // ADD FIRST - mandatory
    if( $addFirst) {
        // set values to table fields
        foreach($_REQUEST as $field => $value) {
            if( in_array($field, $odtFields) ) {
                $setter = "set". $field;
                //  call set function - example: setOrderDate()
                $odt->$setter( $value );
            }
        }

        $odt->setOrderID( $MOrderID);
        $odt->setTNo( '1' );
        if(isset($_REQUEST['MPaxFirstName']) and isset($_REQUEST['MPaxLastName'])) {
            $odt->setPaxName($_REQUEST['MPaxFirstName'] .' ' . $_REQUEST['MPaxLastName']);
        }
        $allRecords['DetailsID_1'] = $odt->saveAsNew();
    }



    // ADD RETURN
    if( $addReturn ) {
        // set values to table fields
        foreach($_REQUEST as $field => $value) {

            // Return fields have a prefix X
            // This removes the leading X. Example: XPickupTime becomes PickupTime
            $field = trim($field, 'X');

            if( in_array($field, $odtFields) ) {
                $setter = "set". $field;
                //  call set function - example: setOrderDate()
                $odt->$setter( $value );
            }
        }
        $odt->setOrderID( $MOrderID);
        $odt->setTNo( '2' );
        if(isset($_REQUEST['MPaxFirstName']) and isset($_REQUEST['MPaxLastName'])) {
            $odt->setPaxName($_REQUEST['MPaxFirstName'] .' ' . $_REQUEST['MPaxLastName']);
        }
        $odt->setDriverEmail($driverEmail);
        $odt->setDriverTel($driverTel);        
        $allRecords['DetailsID_2'] = $odt->saveAsNew();
    }

    // DELETE RETURN
    if( $deleteReturn ) {
        $odt->getRow( $odtKeys[1]);
        // save ID for Extras
        $IDtoDelete = $odt->getDetailsID();

        $odt->deleteRow( $IDtoDelete );
        $allRecords['DetailsID_2'] = 'ReturnDeleted';

        // delete in Extras
        $where = " WHERE OrderDetailsID = '" . $IDtoDelete ."'";
        $delKeys = $oxt->getKeysBy("ID", "ASC", $where);
        if( count( $delKeys ) != 0 ) {
            foreach( $delKeys as $nn => $ID) {
                $oxt->deleteRow( $ID );
            }
        }
    }




    //echo json_encode($allRecords); // return value to caller
	
	
	
	
    $cars = json_encode($allRecords); //test
    echo $_GET['callback'] . '(' . $cars. ')';






