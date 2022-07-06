 <nav id="menu" class="panel" role="navigation">
            <ul class="nav navbar-nav">
              <li id="dashboard"><a href="index.php?p=dashboard"><?= DASHBOARD ?></a></li>
              <li id="transfersList" >
              	<a href="#" >
              		<?= TRANSFERS ?> <span class="caret"></span>
              	</a>
              	<ul >
              		<li><a href="index.php?p=transfersList"><?= ALL_TRANSFERS ?></a></li>
              		<li class="divider"></li>
              		<li><a href="index.php?p=transfersList&transfersFilter=notConfirmed"><?= NOT_CONFIRMED ?></a></li>
              		<li><a href="index.php?p=transfersList&transfersFilter=confirmed"><?= CONFIRMED ?></a></li>
              		<li><a href="index.php?p=transfersList&transfersFilter=noDriver"><?= NO_DRIVER ?></a></li>
              		<li><a href="index.php?p=transfersList&transfersFilter=canceled"><?= CANCELLED ?></a></li>
              	</ul>
              </li>
              <li id="usersListA" >
                <a href="#" ><?= USERS ?> <span class="caret"></span></a>
                <ul >
              		<li id="users"><a href="index.php?p=users"><?= USERS ?></a></li>
              		<li class="divider"></li>
              		<li id="drivers"><a href="index.php?p=drivers"><?= DRIVERS ?></a></li>
              	</ul>
              </li>

              <li id="siteContent" >
                <a href="#" >
                	<?= SITE_CONTENT ?> <span class="caret"></span>
                </a>
                <ul >
                	<li id="siteSettings"><a href="index.php?p=siteSettings"><?= SITE_SETTINGS ?></a></li>
              		<li id="fileman"><a href="index.php?p=fileman"><?= IMAGE_MANAGER ?></a></li>
              		<li id="siteArticles"><a href="index.php?p=siteArticles"><?= ARTICLES ?></a></li>
              		<li id="sitePages"><a href="index.php?p=sitePages"><?= PAGES ?></a></li>
              		<li id="coInfo"><a href="index.php?p=coInfo"><?= COMPANY_INFO ?></a></li>
              		<li id="coTexts"><a href="index.php?p=coTexts"><?= COMPANY_TEXTS ?></a></li>
              		<li id="headerImages"><a href="index.php?p=headerImages"><?= HEADER_IMAGES ?></a></li>
              	</ul>
              </li>

              <li id="routeSettings" >
                <a href="#" >
                	<?= ROUTE_SETTINGS ?> <span class="caret"></span>
                </a>
                <ul >
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
              	</ul>
              </li>

              <li id="priceSettings" >
                <a href="#" >
                	<?= PRICE_SETTINGS ?> <span class="caret"></span>
                </a>
                <ul >
                	<li id="prices"><a href="index.php?p=prices"><?= PRICES ?></a></li>
                	<li class="divider"></li>
              		<li id="extras"><a href="index.php?p=extras"><?= EXTRAS ?></a></li>
              		<li class="divider"></li>
              		<li id="daySettings"><a href="index.php?p=daySettings"><?= DAY_SETTINGS ?></a></li>
              		<li id="dateSettings"><a href="index.php?p=dateSettings"><?= DATE_SETTINGS ?></a></li>
              		<li id="nightSettings"><a href="index.php?p=nightSettings"><?= NIGHT_SETTINGS ?></a></li>
              	</ul>
              </li>

              <li id="reports" >
                <a href="#" >
                	<?= REPORTS ?> <span class="caret"></span>
                </a>
                <ul >
                	<li id="turnover"><a href="index.php?p=turnover"><?= TURNOVER ?></a></li>
                	<li id="netIncome"><a href="index.php?p=netIncome"><?= NET_INCOME ?></a></li>
              		<li id="bookingIncome"><a href="index.php?p=bookingIncome"><?= BOOKING ?></a></li>
              		<li id="canceledOrders"><a href="index.php?p=canceledOrders"><?= CANCELED_ORDERS ?></a></li>
              		<li class="divider"></li>
              		<li class="dropdown-header"><?= AGENTS ?></li>              		
              		<li id="agentsByTrDate"><a href="index.php?p=agentsByTrDate"><?= ORDERS_BY_TR_DATE ?></a></li>
              		<li id="agentsByBDate"><a href="index.php?p=agentsByBDate"><?= ORDERS_BY_B_DATE ?></a></li>
              	</ul>
              </li>

            </ul>

    </nav>
        


<script>
$(document).ready(function() {
    $('.menu-link').bigSlide();
});
</script>