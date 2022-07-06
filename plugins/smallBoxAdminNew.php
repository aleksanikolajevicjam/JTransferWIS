<?
error_reporting(E_PARSE);
/*
# TransferStatus
$StatusDescription = array(
    '1' =>    'New',
    '2' =>    'Confirmed',
    '3' =>    'Canceled',
    '4' =>    'Refunded',
    '5' =>    'No-Show',
    '6' =>    'DriverError',
    '7' =>    'Completed',
    '8' =>    'Comm.Paid'
);
*/
    require_once '../db/v4_OrderDetails.class.php';

    $od = new v4_OrderDetails();
	$today              = strtotime("today 00:00");
	$yesterday          = strtotime("yesterday 00:00");
	$lastWeek = strtotime("yesterday -1 week 00:00");

	$fromDate= date("Y-m-d", $today);
	$lastWeek= date("Y-m-d", $lastWeek);

    $where = ' WHERE OrderDate = "'. $fromDate.'" AND TransferStatus < "3"';
    $k = $od->getKeysBy('DetailsID', 'asc', $where);
    $todayBooking = count($k);


    $where = ' WHERE OrderDate >= "'.$lastWeek.'" AND TransferStatus < "3" AND (DriverConfStatus = "2" OR DriverConfStatus = "3")';
    $k = $od->getKeysBy('DetailsID', 'asc', $where);
    $lastWeekBooking = count($k);


    $where = ' WHERE PickupDate >= "'.date("Y-m-d").'" AND TransferStatus < "3" AND DriverConfStatus = "1"';
    $k = $od->getKeysBy('DetailsID', 'asc', $where);
    $notConfirmedOrders = count($k);

    $where = ' WHERE PickupDate >= "'.date("Y-m-d").'" AND TransferStatus < "3" AND DriverConfStatus = "4"';
    $k = $od->getKeysBy('DetailsID', 'asc', $where);
    $declined = count($k);

    $od->endv4_OrderDetails();

?>    

                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-6 col-xs-6">
                            <!-- small box -->
                            <a href="index.php?p=transfersList&transfersFilter=new">
                                <div class="small-box red lighten-4">
                                    <div class="inner">
                                        <h3>
                                            <?= $todayBooking ?>
                                        </h3>
                                        <p>
                                            <?= NEWW ?>
                                        </p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-plane"></i>
                                    </div>
                                    
                                        <span  class="small-box-footer">
                                            More info <i class="fa fa-arrow-circle-right"></i>
                                        </span>
                                    
                                </div>
                            </a>
                        </div><!-- ./col -->
                        <div class="col-lg-6 col-xs-6">
                            <!-- small box -->
                            <a href="index.php?p=transfersList&transfersFilter=confirmed">
                                <div class="small-box xbg-green">
                                    <div class="inner">
                                        <h3>
                                            <?= $lastWeekBooking ?>
                                        </h3>
                                        <p>
                                            <?= THIS_WEEK ?>
                                        </p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-android-checkmark"></i>
                                    </div>
                                     <span class="small-box-footer">
                                        More info <i class="fa fa-arrow-circle-right"></i>
                                    </span>
                                </div>
                            </a>
                        </div><!-- ./col -->

                    </div><!-- /.row -->
