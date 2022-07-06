<?
    //************************************** Dodano kao cronjob koji se pokrece jednom tjedno - 29.06.2018 - Leo!!****************************************************************
    require_once ROOT . '/db/db.class.php';
    require_once ROOT . '/db/v4_OrderDetails.class.php';
    require_once ROOT . '/db/v4_OrderDetailsFR.class.php';
    
    $db = new DataBaseMysql();
    $od = new v4_OrderDetails();
    $fr = new v4_OrderDetailsFR();

    
    $i=0;
    
    // odaberi subset podataka
    $where = " WHERE PickupDate >= '2020-01-01' ";
    
    $odk = $od->getKeysBy("DetailsID", "ASC", $where);
    $odkFr = $fr->getKeysBy("DetailsID", "ASC", $where);
    
    // koji je zadnji Order u v4_OrderDetailsFR
    $lastOrder = end($odkFr);
    $fr->getRow($lastOrder);
    $lastDetailID = $fr->DetailsID;
    
    // prepisi iz v4_OrderDetails u v4_OrderDetailsFR Orders koji nedostaju
    $success = $db->RunQuery( "INSERT INTO v4_OrderDetailsFR SELECT * FROM v4_OrderDetails WHERE DetailsID > '".$lastDetailID."'"); 

    
    // sinhroniziraj eventualne izmjene vaznijih podataka
    if( $success and count($odk) > 0) {
        foreach($odk as $nn => $DetailsID) {
            $od->getRow($DetailsID);
            
            if( $fr->getRow($DetailsID) !== false ) {
            
                $fr->setSubDriver( $od->SubDriver);
                $fr->setSubDriver2( $od->SubDriver2);
                $fr->setSubDriver3( $od->SubDriver3);
                
                $fr->setCar( $od->Car);
                $fr->setCar2( $od->Car2);
                $fr->setCar3( $od->Car3);
                
                $fr->setSubPickupDate( $od->SubPickupDate);
                $fr->setSubPickupTime( $od->SubPickupTime);
                
                $fr->setSubFlightNo( $od->SubFlightNo);
                $fr->setSubFlightTime( $od->SubFlightTime);
                
                $fr->setSubDriverNote( $od->SubDriverNote);
                $fr->setStaffNote( $od->StaffNote);
                $fr->setExtras( $od->Extras);
                $fr->setFinalNote( $od->FinalNote);
                $fr->setCashIn( $od->CashIn);
                $fr->setSubFinalNote( $od->SubFinalNote);
                
                $fr->saveRow();
                $i++;
            }
            
        }
    }
    
    echo $i . ' rows changed ' . date("H:i:s");
    
    
    
