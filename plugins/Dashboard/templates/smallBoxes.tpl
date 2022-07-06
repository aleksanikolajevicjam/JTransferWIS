   

                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <a href="orders/newTransfers">
                                <div class="small-box xblue xwhite-text">
                                    <div class="inner">
                                        <h3>
                                            {$todayBooking}
                                        </h3>
                                        <p>
                                            {$NNEW} {$TODAY}
                                        </p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-cloud-download"></i>
                                    </div>
                                    
                                        <span  class="small-box-footer">
                                            More info <i class="fa fa-arrow-circle-right"></i>
                                        </span>
                                    
                                </div>
                            </a>
                        </div><!-- ./col -->
                        {*<div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <a href="orders/active">
                                <div class="small-box bg-aqua">
                                    <div class="inner">
                                        <h3>
                                            {$activeOrders}
                                        </h3>
                                        <p>
                                            {$ACTIVE}
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
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <a href="orders/confirmed">
                                <div class="small-box xgreen  xwhite-text">
                                    <div class="inner">
                                        <h3>
                                            {$confirmedOrders}
                                        </h3>
                                        <p>
                                            {$CONFIRMED}
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
						</div>*}
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <a href="orders/notConfirmed">
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3>
                                            {$notConfirmedOrders}
                                        </h3>
                                        <p>
                                            {$NOT_CONFIRMED} All
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
						<div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <a href="orders/notConfirmedToday">
                                <div class="small-box bg-yellow">
                                    <div class="inner">
                                        <h3>
                                            {$notConfirmedOrdersToday}
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
						<div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <a href="orders/notConfirmedTomorrow">
                                <div class="small-box bg-orange">
                                    <div class="inner">
                                        <h3>
                                            {$notConfirmedOrdersTomorrow}
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
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <a href="orders/declined">
                                <div class="small-box red darken-2 xwhite-text">
                                    <div class="inner">
                                        <h3>
                                            {$declined}
                                        </h3>
                                        <p>
                                            {$DECLINED}
                                        </p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-nuclear"></i>
                                    </div>
                                     <span class="small-box-footer">
                                        More info <i class="fa fa-arrow-circle-right"></i>
                                    </span>
                                </div>
                            </a>
                        </div><!-- ./col -->
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <a href="orders/tomorrow">
                                <div class="small-box teal darken-2 xwhite-text">
                                    <div class="inner">
                                        <h3>
                                            {$tomorrowTransfers}
                                        </h3>
                                        <p>
                                            {$TOMORROW}
                                        </p>
                                    </div>
                                    <div class="icon ">
                                        <i class="fa fa-car"></i>
                                    </div>
                                     <span class="small-box-footer">
                                        More info <i class="fa fa-arrow-circle-right"></i>
                                    </span>
                                </div>
                            </a>
                        </div><!-- ./col -->						
                    </div><!-- /.row -->
