<?
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
	@session_start();

	$fakeDriverFound = false;
	$SAuthUserID = $_SESSION['AuthUserID'];

	

    require_once ROOT . '/cms/fixDriverID.php';
    foreach($fakeDrivers as $key => $fakeDriverID) {
        if($SAuthUserID == $fakeDriverID) {
			$SAuthUserID = $realDrivers[$key];
            $fakeDriverFound = true; 
        }
    }

    if($fakeDriverFound == true) require_once ROOT . '/db/v4_OrderDetailsFR.class.php'; 

	else require_once ROOT . '/db/v4_OrderDetails.class.php';
	
    //require_once ROOT . '/db/v4_OrderDetails.class.php';

    $od = new v4_OrderDetails();
	
	// Active transfers
    $where = ' WHERE DriverID = "'.$SAuthUserID.'" AND PickupDate >= "'.date("Y-m-d").'" AND TransferStatus < "3"';
    $k = $od->getKeysBy('DetailsID', 'asc', $where);
    $activeOrders = count($k);


    // Confirmed
    $where = ' WHERE DriverID = "'.$SAuthUserID.'" AND PickupDate >= "'.date("Y-m-d").'" AND TransferStatus < "3" AND (DriverConfStatus = "2" OR DriverConfStatus = "3")';
    $k = $od->getKeysBy('DetailsID', 'asc', $where);
    $confirmedOrders = count($k);

    // NOT Confirmed
    $where = ' WHERE DriverID = "'.$SAuthUserID.'" AND TransferStatus < "3" AND DriverConfStatus = "1"';
    $k = $od->getKeysBy('DetailsID', 'asc', $where);
    $notConfirmedOrders = count($k);

	$where = ' WHERE DriverID = "'.$SAuthUserID.'" AND PickupDate = "'.date("Y-m-d").'" AND TransferStatus < "3" AND (DriverConfStatus = "1" OR DriverConfStatus = "4")';
    $k = $od->getKeysBy('DetailsID', 'asc', $where);
    $notConfirmedOrdersToday = count($k);	
	
	$where = ' WHERE DriverID = "'.$SAuthUserID.'" AND PickupDate = ("'.date("Y-m-d").'"+INTERVAL 1 DAY) AND TransferStatus < "3" AND (DriverConfStatus = "1" OR DriverConfStatus = "4")';
    $k = $od->getKeysBy('DetailsID', 'asc', $where);
    $notConfirmedOrdersTomorrow = count($k);
	
    // Tomorrow

	$datetime = new DateTime('tomorrow');
	$tomorrow = $datetime->format('Y-m-d');
    $where = ' WHERE DriverID = "'.$SAuthUserID.'" AND PickupDate = "'.$tomorrow.'" AND TransferStatus < "3"';
    $k = $od->getKeysBy('DetailsID', 'asc', $where);
    $tomorrowTransfers = count($k);

    $od->endv4_OrderDetails();

?>    

                    <!-- Small boxes (Stat box) -->
                    <div class="row">
						<?php 
						$nswitch=false;
						if ($nswitch) { 
						?>					
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <a href="index.php?p=transfersList&transfersFilter=active">
                                <div class="small-box bg-aqua">
                                    <div class="inner">
                                        <h3>
                                            <?= $activeOrders ?>
                                        </h3>
                                        <p>
                                            <?= ACTIVE ?>
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
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <a href="index.php?p=transfersList&transfersFilter=confirmed">
                                <div class="small-box bg-green">
                                    <div class="inner">
                                        <h3>
                                            <?= $confirmedOrders ?>
                                        </h3>
                                        <p>
                                            <?= CONFIRMED ?>
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
						<?php } ?>						
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <a href="index.php?p=transfersList&transfersFilter=notConfirmed">
                                <div class="small-box bg-warning">								
                                    <div class="inner">
                                        <h3>
                                            <?= $notConfirmedOrders ?>
                                        </h3>
                                        <p>
                                            <?= NOT_CONFIRMED ?> All
                                        </p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-ios7-alarm"></i>
                                    </div>
                                     <span class="small-box-footer">
                                        More info <i class="fa fa-arrow-circle-right"></i>
                                    </span>
                                </div>
                            </a>
                        </div><!-- ./col -->
						<?php 
						if (!$nswitch) { 
						?>						
						<div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <a href="index.php?p=transfersList&transfersFilter=notConfirmedToday">
                                <div class="small-box bg-yellow">							
                                    <div class="inner">
                                        <h3>
                                            <?= $notConfirmedOrdersToday ?>
                                        </h3>
                                        <p>
                                            Today unconfirmed/declined 
                                        </p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-ios7-alarm"></i>
                                    </div>
                                     <span class="small-box-footer">
                                        More info <i class="fa fa-arrow-circle-right"></i>
                                    </span>
                                </div>
                            </a>
                        </div><!-- ./col -->						
						<div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <a href="index.php?p=transfersList&transfersFilter=notConfirmedTomorrow">
                                <div class="small-box bg-orange">
                                    <div class="inner">
                                        <h3>
                                            <?= $notConfirmedOrdersTomorrow ?>
                                        </h3>
                                        <p>
                                            Tomorrow unconfirmed/declined 
                                        </p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-ios7-alarm"></i>
                                    </div>
                                     <span class="small-box-footer">
                                        More info <i class="fa fa-arrow-circle-right"></i>
                                    </span>
                                </div>
                            </a>
                        </div><!-- ./col -->
						<?php } ?>
						
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <a href="index.php?p=transfersList&transfersFilter=tomorrow">
                                <div class="small-box bg-red">
                                    <div class="inner">
                                        <h3>
                                            <?= $tomorrowTransfers ?>
                                        </h3>
                                        <p>
                                            <?= TOMORROW ?>
                                        </p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-car"></i>
                                    </div>
                                     <span class="small-box-footer">
                                        More info <i class="fa fa-arrow-circle-right"></i>
                                    </span>
                                </div>
                            </a>
                        </div><!-- ./col -->
                    </div><!-- /.row -->
