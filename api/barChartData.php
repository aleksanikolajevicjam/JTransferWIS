<?

    require_once '../../db/v4_OrderDetails.class.php';

    $od = new v4_OrderDetails();


    $barChart = array();

    // prikaz za prethodne tri godine

    for($y=date("Y")-3; $y < date("Y"); $y++ ) {

        $where = ' WHERE PickupDate >= "'.$y.'-01-01" AND PickupDate <= "'.$y.'-12-31" AND TransferStatus = "3"';
        $k = $od->getKeysBy('DetailsID', 'asc', $where);
        $cancel = count($k);

        $where = ' WHERE PickupDate >= "'.$y.'-01-01" AND PickupDate <= "'.$y.'-12-31" AND TransferStatus >= "5"';
        $k = $od->getKeysBy('DetailsID', 'asc', $where);
        $completed = count($k);

        $where = ' WHERE PickupDate >= "'.$y.'-01-01" AND PickupDate <= "'.$y.'-12-31" AND TransferStatus = "5" AND PaymentStatus = "99" ';
        $k = $od->getKeysBy('DetailsID', 'asc', $where);
        $paid = count($k);

        $barChart[] = array("y"=>$y, "a" => $completed, "b" => $paid, "c" => $cancel);
    }


    $od->endv4_OrderDetails();


echo json_encode($barChart);
