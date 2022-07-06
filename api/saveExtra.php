<?

    require_once ROOT . '/db/db.class.php';
    require_once ROOT . '/db/v4_Extras.class.php';
    require_once ROOT . '/db/v4_OrderExtrasTemp.class.php';

    $db = new DataBaseMysql();
    $x  = new v4_Extras();
    $xt = new v4_OrderExtrasTemp();

    $out        = array();
    $Extras     = array();
    
    $Extras     = json_decode($_REQUEST['extras'], true);



    $DetailsID  = $_REQUEST['DetailsID_1'];
    $RT         = $_REQUEST['returnTransfer'];
    $RDetailsID = $_REQUEST['DetailsID_2'];


    // delete all previously entered extras as a precaution
    $q  = "DELETE FROM v4_OrderExtrasTemp ";
    $q .= "WHERE OrderDetailsID = '" . $DetailsID ."' ";
    $q .= "OR OrderDetailsID = '" . $RDetailsID ."' ";
    
    $db->RunQuery($q);


    // add latest version of extras
    foreach( $Extras as $key => $val) {

        list($way, $XServiceID) = explode('_', $key);
        list($sum, $Qty) = explode('_', $val);

        $x->getRow( $XServiceID );

        if($way == '1') {
            $xt->setOrderDetailsID( $DetailsID );

            $xt->setServiceName( $x->getServiceEN() );
            $xt->setServiceID( $XServiceID );
            $xt->setPrice( $x->getPrice() );
            $xt->setQty( $Qty );
            $xt->setSum( $sum );

            $xt->saveAsNew();

            $out[] = $way . ' ' . $RDetailsID .' Service: ' . $XServiceID . ' Qty: '. $Qty . ' Added to OrderExtrasTemp';
        }
        if($way == '2') {
            $xt->setOrderDetailsID( $RDetailsID );
            $xt->setServiceName( $x->getServiceEN() );
            $xt->setServiceID( $XServiceID );
            $xt->setPrice( $x->getPrice() );
            $xt->setQty( $Qty );
            $xt->setSum( $sum );

            $xt->saveAsNew();

            $out[] = $way . ' ' . $RDetailsID .' Service: ' . $XServiceID . ' Qty: '. $Qty . ' Added to OrderExtrasTemp';
        }


    }


    //$x->getRow($ExtrasID);


//$out = array($ExtrasID);
// return data
$retArr = json_encode($out);
echo $_GET['callback'] . '(' . $retArr. ')';


