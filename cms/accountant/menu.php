      <!-- Static navbar -->
      <div class="navbar navbar-inverse navbar-fixed-top shadowMedium" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= $_SERVER['PHP_SELF']?>">ACCOUNTANT</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li id="dashboard"><a href="index.php?p=dashboard"><?= DASHBOARD ?></a></li>
				<li id="calendar"><a href="index.php?p=calendar">Calendar</a></li>
              <li id="transfersList" class="dropdown">
              	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
              		<?= TRANSFERS ?> <span class="caret"></span>
              	</a>
              	<ul class="dropdown-menu" role="menu">
              		<li><a href="index.php?p=transfersList"><?= ALL_TRANSFERS ?></a></li>
              		<li class="divider"></li>
					<li><a href="index.php?p=transfersList&transfersFilter=agentinvoice">Agent's Invoice</a></li>
					<li><a href="index.php?p=transfersList&transfersFilter=online">Online</a></li>
					<li><a href="index.php?p=transfersList&transfersFilter=cash">Driver's Invoice</a></li>
					<li><a href="index.php?p=transfersList&transfersFilter=proforma">Proforma</a></li>
					<li><a href="index.php?p=transfersList&transfersFilter=invoice">Invoice</a></li>
					<li><a href="index.php?p=transfersList&transfersFilter=sentvoucher">Sent Voucher</a></li>
					<li><a href="index.php?p=transfersList&transfersFilter=acceptedvoucher">Accepted Voucher</a></li>
					<li><a href="index.php?p=transfersList&transfersFilter=declinedvoucher">Declined Voucher</a></li>	 				
              	</ul>
              </li>

              <li id="reports" class="dropdown">
              	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
              		<?= REPORTS ?> <span class="caret"></span>
              	</a>
              	<ul class="dropdown-menu" role="menu">
              		<li><a href="index.php?p=o2017">Online payments</a></li>
              		<li><a href="index.php?p=i2017">Invoices-Agents</a></li>
              		<li class="divider"></li>
                    <!-- kopirano iz admin -->
                	<li id="promet"><a href="index.php?p=promet"><?= TRANSFERS_SUMMARY ?></a></li>
                	<li id="promet2"><a href="index.php?p=promet2"><?= TRANSFERS_SUMMARY_BOOKING ?></a></li>

                	<!--<li id="turnover"><a href="index.php?p=turnover"><?= TURNOVER ?></a></li>-->
                	<?/*
				    <li id="netIncome"><a href="index.php?p=netIncome"><?= NET_INCOME ?></a></li>
              		<li id="bookingIncome"><a href="index.php?p=bookingIncome"><?= BOOKING ?></a></li>
				
              		<li id="canceledOrders"><a href="index.php?p=canceledOrders"><?= CANCELED_ORDERS ?></a></li>
				    */ ?>
              		<li class="divider"></li>
              		<li class="dropdown-header"><?= ORDERS ?></li>              		
              		<li id="agentsByTrDate">
					    <a href="index.php?p=agentOrders&ByWhat=1">...<?= ORDERS_BY_TR_DATE ?></a>
				    </li>
              		<li id="agentsByBDate">
					    <a href="index.php?p=agentOrders&ByWhat=2">...<?= ORDERS_BY_B_DATE ?></a>
				    </li>
              		<li id="agentsByBDate">
					    <a href="index.php?p=taxiSiteOrdersBookingDate">...<?= TAXI_SITE_ORDERS.'-'.BOOKING_DATE ?></a>
				    </li>
				    <li class="divider"></li>

				    <li class="dropdown-header"><?= BILLING ?></li>                  
				    <!--<li id="agentsByBDate"><a href="index.php?p=invoiceSum"><?= SUMMARY_INVOICE_DRIVER ?></a></li>-->
				    <li id="driversWTransfers"><a href="index.php?p=driversWTransfersCash"><?= DRIVERS_WITH_TRANSFERS ?> - <?= CASH ?></a></li>
				    <li id="driversBalance"><a href="index.php?p=driversBalanceCash"><?= DRIVERS_BALANCE ?> - <?= CASH ?></a></li>
                    <li class="divider"></li>
				    <li id="driversWTransfers"><a href="index.php?p=driversWTransfers"><?= DRIVERS_WITH_TRANSFERS ?> - <?= OTHER ?></a></li>
				    <li id="driversBalance"><a href="index.php?p=driversBalance"><?= DRIVERS_BALANCE ?> - <?= OTHER ?></a></li>

				    <li class="divider"></li>
				    <li id="agentsWTransfers"><a href="index.php?p=agentsWTransfers"><?= AGENTS_WITH_TRANSFERS ?></a></li>
				    <li class="divider"></li>				
				    <li id="agentsWTransfers"><a href="index.php?p=invoices">
					    <i class="fa fa-exclamation-circle red-text"></i> <?= INVOICES_AGENTS ?><br><small>...read help first!</small></a></li>
              	</ul>
              </li>
              
            </ul>
            <ul class="nav navbar-nav navbar-right">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?= $_SESSION['UserName'] ?> <i class="caret"></i></span>
								&nbsp;
                                <img src="a/showProfileImage.php?UserID=<?= $_SESSION['AuthUserID']?>" 
                                    class="img-circle" alt="User Image" style="height:2em;padding:-.5em;margin:-.5em"/>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="a/showProfileImage.php?UserID=<?= $_SESSION['AuthUserID']?>" 
                                    class="img-circle" alt="User Image" />
                                    <p>
                                        <?= $_SESSION['UserName'] ?> - <?= $_SESSION['GroupProfile'] ?>
                                        <small><?= MEMBER_SINCE.' '. $_SESSION['MemberSince'] ?></small>
                                    </p>
                                </li>

                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="index.php?p=profileEdit" class="btn btn-default btn-flat">
                                        	<?= PROFILE ?>
                                        </a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="logout.php" class="btn btn-default btn-flat"><?= SIGN_OUT ?></a>
                                    </div>
                                </li>
                            </ul>
                        </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>

