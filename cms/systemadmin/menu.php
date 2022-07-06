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
    <a class="navbar-brand" href="<?= $_SERVER['PHP_SELF']?>">SYSTEM ADMIN</a>
  </div>
  <div class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
      <li id="dashboard"><a href="index.php?p=dashboard"><?= DASHBOARD ?></a></li>
      <li id="transfersList" class="dropdown">
      	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
      		<?= TRANSFERS ?> <span class="caret"></span>
      	</a>
      	<ul class="dropdown-menu" role="menu">
      		<li><a href="index.php?p=transfersList"><?= ALL_TRANSFERS ?></a></li>
      		<li class="divider"></li>
      		<li><a href="index.php?p=transfersList&transfersFilter=noDriver"><?= NO_DRIVER ?></a></li>
      		<li><a href="index.php?p=transfersList&transfersFilter=notConfirmed"><?= NOT_CONFIRMED ?></a></li>
      		<li><a href="index.php?p=transfersList&transfersFilter=confirmed"><?= CONFIRMED ?></a></li>
      		<li><a href="index.php?p=transfersList&transfersFilter=declined"><?= DECLINED ?></a></li>
			<li><a href="index.php?p=transfersList&transfersFilter=canceled"><?= CANCELLED ?></a></li>
			<li><a href="index.php?p=transfersList&transfersFilter=noshow"><?= NO_SHOW ?></a></li>
			<li><a href="index.php?p=transfersList&transfersFilter=driverError"><?= DRIVER_ERROR ?></a></li>
			<li><a href="index.php?p=updatedTransfersList"><?= UPDATED ?></a></li>
			<li class="divider"></li>
      		<li id="freeForm"><a href="index.php?p=freeForm"><?= FREEFORM ?></a></li>
      	</ul>
      </li>
      
      <li id="users"><a href="index.php?p=users"><?= USERS ?> </a>

      </li>

      <li id="siteContent" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        	<?= SITE_CONTENT ?> <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
      		<li id="fileman"><a href="index.php?p=fileman"><?= IMAGE_MANAGER ?></a></li>
      		<li id="siteArticles"><a href="index.php?p=siteArticles"><?= ARTICLES ?></a></li>
      		<li id="sitePages"><a href="index.php?p=sitePages"><?= PAGES ?></a></li>
      		<li id="coInfo"><a href="index.php?p=coInfo"><?= COMPANY_INFO ?></a></li>
      		<li id="headerImages"><a href="index.php?p=headerImages"><?= HEADER_IMAGES ?></a></li>
			<li id="finder"><a href="index.php?p=finder"><?= FINDER ?></a></li>
      		<li><a href="/" target="_blank"><?= VIEW_SITE ?></a></li>
      		<li class="divider"></li>
			<li><a href="index.php?p=refreshCache"
			onclick="return confirm('Refresh cache?\n(This could take a while)')">
				<?= REFRESH_CACHE ?>
			</a></li>
      	</ul>
      </li>

      <li id="routeSettings" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        	<?= ROUTE_SETTINGS ?> <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
        	<li id="countries"><a href="index.php?p=countries"><?= COUNTRIES ?></a></li>
      		<li id="locations"><a href="index.php?p=locations"><?= LOCATIONS ?></a></li>
      		<li id="routes"><a href="index.php?p=routes"><?= ROUTES ?></a></li>

      		<li class="divider"></li>
      		<li id="driverRoutes"><a href="index.php?p=driverRoutes"><?= DRIVER_ROUTES ?></a></li>
      		<li class="divider"></li>
      		<li id="vehicles"><a href="index.php?p=vehicles"><?= VEHICLES ?></a></li>  
      		<li class="divider"></li>
      		<li role="presentation" class="dropdown-header"><?= OTHER ?></li>
      		<li id="locations"><a href="index.php?p=locationTypes"><?= LOCATION_TYPES ?></a></li>
			<li id="routeReviews"><a href="index.php?p=routeReviews"><?= ROUTE_REVIEWS ?></a></li>
      	</ul>
      </li>

      <li id="priceSettings" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        	<?= PRICE_SETTINGS ?> <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
        	<li id="prices"><a href="index.php?p=prices"><?= PRICES ?></a></li>
			<li id="coupons"><a href="index.php?p=coupons"><?= COUPONS ?></a></li>
        	<li class="divider"></li>
      		<li id="extras"><a href="index.php?p=extras"><?= EXTRAS ?></a></li>
			<li class="divider"></li>
			<li role="presentation" class="dropdown-header"><?= OTHER ?></li>
			<li id="pricesExport"><a href="index.php?p=pricesExport"><?= PRICES_EXPORT ?></a></li>
			<li id="pricesImport"><a href="index.php?p=pricesImport"><?= PRICES_IMPORT ?></a></li>
			<li id="pricesList"><a href="index.php?p=priceList"><?= PRICE_LIST ?></a></li>
      	</ul>
      </li>

      <li id="reports" class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        	<?= REPORTS ?> <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
        	<li id="promet"><a href="index.php?p=promet"><?= TRANSFERS_SUMMARY ?></a></li>
        	<li id="promet2"><a href="index.php?p=promet2"><?= TRANSFERS_SUMMARY_BOOKING ?></a></li>
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
			<li class="dropdown-header"><?= DRIVERS ?></li>                  
			<li id="agentsByBDate"><a href="index.php?p=driversChart"><?= TOP_DRIVERS ?></a></li>
			<li class="divider"></li>
			<li class="dropdown-header"><?= BILLING ?></li>
			<li id="driversWTransfers"><a href="index.php?p=driversWTransfers"><?= DRIVERS_WITH_TRANSFERS ?></a></li>
			<li id="driversBalance"><a href="index.php?p=driversBalance"><?= DRIVERS_BALANCE ?></a></li>

			<li class="divider"></li>
			<li id="agentsWTransfers"><a href="index.php?p=agentsWTransfers"><?= AGENTS_WITH_TRANSFERS ?></a></li>
			<li class="divider"></li>				
			<li id="agentsWTransfers"><a href="index.php?p=invoices">
				<i class="fa fa-exclamation-circle red-text"></i> <?= INVOICES_AGENTS ?><br><small>...read help first!</small></a></li>
			<li class="divider"></li>
			<li id="exchangeRate"><a href="index.php?p=exchangeRate"><?= EXCHANGE_RATE ?></a></li>
			<li><a href="index.php?p=emailsForm"><?= CLIENT_EMAILS ?></a></li>
			<li><a href="index.php?p=driversEmails"><?= DRIVERS_EMAIL_LIST ?></a></li>
			<li><a href="index.php?p=driversEmailsActive"><?= DRIVERS_EMAIL_LIST ?> - Active</a></li>
			<li><a href="index.php?p=exportAgentEmails"><?= AGENT_REPORT ?></a></li>
			<li><a href="index.php?p=surveyReportForm"><?= SURVEY ?></a></li>
      	</ul>
      </li>

    </ul>
    <ul class="nav navbar-nav navbar-right">
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-user"></i>
                <span><?= $_SESSION['UserName'] ?> <i class="caret"></i> &nbsp;</span>
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
                <!-- Menu Body 
                <li class="user-body">
                    <div class="col-xs-4 text-center">
                        <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                        <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                        <a href="#">Friends</a>
                    </div>
                </li>-->
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

