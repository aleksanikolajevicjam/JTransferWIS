<?

    require_once '../db/v4_OrderDetails.class.php';

    $od = new v4_OrderDetails();

    // za sve bookinge do sada
    $where = ' WHERE TransferStatus = "3"';
    $k = $od->getKeysBy('DetailsID', 'asc', $where);
    $cancelTotal = count($k);

    $where = ' WHERE TransferStatus  = "5"';
    $k = $od->getKeysBy('DetailsID', 'asc', $where);
    $completedTotal = count($k);

    $where = ' WHERE TransferStatus = "5" AND PaymentStatus = "99" ';
    $k = $od->getKeysBy('DetailsID', 'asc', $where);
    $paidTotal = count($k);

    $where = ' WHERE TransferStatus = "5" AND DriverConfStatus = "5"';
    $k = $od->getKeysBy('DetailsID', 'asc', $where);
    $noshowTotal = count($k);

    $where = ' WHERE DriverConfStatus = "4"';
    $k = $od->getKeysBy('DetailsID', 'asc', $where);
    $declinedTotal = count($k);

    $where = ' WHERE TransferStatus > "0"';
    $k = $od->getKeysBy('DetailsID', 'asc', $where);
    $Total = count($k);


    // THIS YEAR 
    $where = ' WHERE PickupDate >= "'.date("Y").'-01-01" AND PickupDate <= "'.date("Y").'-12-31" AND DriverConfStatus = "4"';
    $k = $od->getKeysBy('DetailsID', 'asc', $where);
    $declined = count($k);

    $where = ' WHERE PickupDate >= "'.date("Y").'-01-01" AND PickupDate <= "'.date("Y").'-12-31" AND TransferStatus = "5"';
    $k = $od->getKeysBy('DetailsID', 'asc', $where);
    $completed = count($k);

    $where = ' WHERE PickupDate >= "'.date("Y").'-01-01" AND PickupDate <= "'.date("Y").'-12-31" AND TransferStatus = "5" AND PaymentStatus = "99"';
    $k = $od->getKeysBy('DetailsID', 'asc', $where);
    $paid = count($k);    

    $where = ' WHERE PickupDate >= "'.date("Y").'-01-01" AND PickupDate <= "'.date("Y").'-12-31" AND TransferStatus = "3"';
    $k = $od->getKeysBy('DetailsID', 'asc', $where);
    $canceled = count($k);  

    $where = ' WHERE PickupDate >= "'.date("Y").'-01-01" AND PickupDate <= "'.date("Y").'-12-31" AND TransferStatus > "0"';
    $k = $od->getKeysBy('DetailsID', 'asc', $where);
    $total = count($k);   


    $od->endv4_OrderDetails();

?>    

                            <!-- Box (with bar chart) -->
                            <div class="box box-danger" id="loading-example">
                                <div class="box-header">
                                    <!-- tools box -->
                                    <div class="pull-right box-tools">
<!--                                        <button class="btn btn-danger btn-sm refresh-btn" data-toggle="tooltip" title="Reload"><i class="fa fa-refresh"></i></button>-->
                                        <button class="btn btn-danger btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-danger btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                                    </div><!-- /. tools -->
                                    <i class="fa fa-cloud"></i>

                                    <h3 class="box-title">Bookings</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <!-- bar chart -->
                                            <div class="chart" id="bar-chart" style="height: 363px;"></div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="pad">
                                                <h3 class="s">Overall - <strong><?= $Total ?></strong> bookings</h3>
                                                <br>
                                                <!-- Progress bars -->
                                                <div class="clearfix">
                                                    <span class="pull-left">Completed</span>
                                                    <small class="pull-right"><?= Percent($Total, $completedTotal) ?>%</small>
                                                </div>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-green" style="width: <?= Percent($Total, $completedTotal) ?>%;"></div>
                                                </div>

                                                <div class="clearfix">
                                                    <span class="pull-left">Paid <small>(% of Completed)</small></span>
                                                    <small class="pull-right"><?= Percent($completedTotal, $paidTotal) ?>%</small>
                                                </div>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-light-blue" style="width: <?= Percent($Total, $paidTotal) ?>%;"></div>
                                                </div>

                                                <div class="clearfix">
                                                    <span class="pull-left">Canceled</span>
                                                    <small class="pull-right"><?= Percent($Total, $cancelTotal) ?>%</small>
                                                </div>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: <?= Percent($Total, $cancelTotal) ?>%;"></div>
                                                </div>

                                                <div class="clearfix">
                                                    <span class="pull-left">No-Show</span>
                                                    <small class="pull-right"><?= Percent($Total, $noshowTotal) ?>%</small>
                                                </div>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-aqua" style="width: <?= Percent($Total, $noshowTotal) ?>%;"></div>
                                                </div>

                                                <div class="clearfix">
                                                    <span class="pull-left">Declined</span>
                                                    <small class="pull-right"><?= Percent($Total, $declinedTotal) ?>%</small>
                                                </div>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-red" style="width: <?= Percent($Total, $declinedTotal) ?>%;"></div>
                                                </div>



                                                <!-- Buttons -->
<!--                                                <p>-->
<!--                                                    <button class="btn btn-default btn-sm"><i class="fa fa-cloud-download"></i> Generate PDF</button>-->
<!--                                                </p>-->
                                            </div><!-- /.pad -->
                                        </div><!-- /.col -->
                                    </div><!-- /.row - inside box -->
                                </div><!-- /.box-body -->
                                <div class="box-footer">
                                    <h3 class="s">This year - <?= $total ?> bookings</h3>

                                    <div class="row">

                                        <div class="col-xs-3 text-center" style="border-right: 1px solid #f4f4f4">
                                            <input type="text" class="knob" data-readonly="true" value="<?= Percent($total, $completed) ?>" data-width="60" data-height="60" data-fgColor="#090"/>
                                            <div class="knob-label">Completed</div>
                                        </div><!-- ./col -->
                                        <div class="col-xs-3 text-center" style="border-right: 1px solid #f4f4f4">
                                            <input type="text" class="knob" data-readonly="true" value="<?= Percent($total, $paid) ?>" data-width="60" data-height="60" data-fgColor="#2286C9"/>
                                            <div class="knob-label">Paid</div>
                                        </div><!-- ./col -->
                                        <div class="col-xs-3 text-center">
                                            <input type="text" class="knob" data-readonly="true" value="<?= Percent($total, $canceled) ?>" data-width="60" data-height="60" data-fgColor="orange"/>
                                            <div class="knob-label">Cancelled</div>
                                        </div><!-- ./col -->

                                        <div class="col-xs-3 text-center">
                                            <input type="text" class="knob" data-readonly="true" value="<?= Percent($total, $declined) ?>" data-width="60" data-height="60" data-fgColor="#b00"/>
                                            <div class="knob-label">Declined</div>
                                        </div><!-- ./col -->
                                    </div><!-- /.row -->
                                </div><!-- /.box-footer -->
                            </div><!-- /.box -->   
                            
                            
<script>
    //Bar chart

$.ajax({
	 type: 'GET',
	  url: window.root + '/cms/api/barChartData.php',
	  async: false,
	  contentType: "application/json",
	  //dataType: 'jsonp',
	  success: function(data) {
			new Morris.Bar({
				element: 'bar-chart',
				resize: true,
				data: $.parseJSON(data),
				barColors: ['#00a65a', '#f56954', '#900'],
				xkey: 'y',
				ykeys: ['a', 'b', 'c'],
				labels: ['Completed', 'Paid', 'Canceled'],
				hideHover: 'auto'
			});
	  	}
});





</script>                            
