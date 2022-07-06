<?

    require_once ROOT . '/db/db.class.php';
    require_once ROOT . '/f2/f.php';
    require_once ROOT . '/db/v4_OrderDetailsFR.class.php';
    require_once ROOT . '/db/v4_WorkingHours.class.php';
    require_once ROOT . '/db/v4_AuthUsers.class.php';
    
    
    $db = new DataBaseMysql();
    $od = new v4_OrderDetailsFR();
    $wh = new v4_WorkingHours();
    $au = new v4_AuthUsers();
    
    $months = array('4','5');

    $Month = '03';
    $Year = '2018';
    $SubDriverID = $_REQUEST['SubDriverID'];
        
    $SubDrivers = array();

    $odk = $od->getKeysBy("DetailsID", "ASC", " WHERE Expired = '0' AND DriverID = '876' AND PickupDate >= '" . $Year.'-'.$Month.'-01' . "'");
    
    foreach($odk as $nn => $DetailsID) {
        $od->getRow($DetailsID);
        
        if(!in_array($od->SubDriver, $SubDrivers)) $SubDrivers[] = $od->SubDriver;
        if(!in_array($od->SubDriver2, $SubDrivers)) $SubDrivers[] = $od->SubDriver2;
        if(!in_array($od->SubDriver3, $SubDrivers)) $SubDrivers[] = $od->SubDriver3;
        
        
    }

echo '<pre>';print_r($SubDrivers);echo '</pre>';

    foreach($SubDrivers as $nn => $SubDriverID) {
        $d = getUser($SubDriverID);
        echo $nn . ' ' . $SubDriverID . ' ' . $d->AuthUserRealName . '<br>';
    }

    
    
    

