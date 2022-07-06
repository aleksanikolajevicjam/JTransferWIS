<?
	ob_start();
	if (isset($_SESSION['UseDriverID']) && $_SESSION['UseDriverID']>0) $driver=true;
	else $driver=false;
?>
	<style>
	
			@media(max-width:1024px){
			  .navbar-nav{
				display: none;
			  }
			}
			@media(min-width:1025px){
			  .navbar-toggle {
				display: none;
			  }	
			}
	</style>		
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
        <a class="navbar-brand" href="">ADMIN</a>
      </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <li id="dashboard"><a href="dashboard"><?= DASHBOARD ?></a></li>
          <li id="siteContent" class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            	<?= SITE_CONTENT ?> <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
          		<li id="fileman"><a href="fileman"><?= IMAGE_MANAGER ?></a></li>
          		<li id="siteArticles"><a href="siteArticles"><?= ARTICLES ?></a></li>
          		<li id="sitePages"><a href="sitePages"><?= PAGES ?></a></li>
          		<li id="coInfo"><a href="coInfo"><?= COMPANY_INFO ?></a></li>
          		<li id="headerImages"><a href="headerImages"><?= HEADER_IMAGES ?></a></li> 
				<li id="routeReviews"><a href="routeReviews"><?= ROUTE_REVIEWS ?></a></li>
          	</ul>
          </li>		  
          <li id="transfersList" class="dropdown">
          	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
          		<?= TRANSFERS ?> <span class="caret"></span>
          	</a>
            	<ul class="dropdown-menu" role="menu">
				<li><a href="calendar">Calendar</a></li>
				<li class="divider"></li>				
          		<li><a href="transfersList/noDriver"><?= NO_DRIVER ?></a></li>
          		<li><a href="transfersList/notConfirmed"><?= NOT_CONFIRMED ?></a></li>
          		<li><a href="transfersList/confirmed"><?= CONFIRMED ?></a></li>
          		<li><a href="transfersList/declined"><?= DECLINED ?></a></li>
				<li><a href="transfersList/canceled"><?= CANCELLED ?></a></li>
				<li><a href="transfersList/noshow"><?= NO_SHOW ?></a></li>
				<li><a href="transfersList/driverError"><?= DRIVER_ERROR ?></a></li>
				<li><a href="updatedTransfersList"><?= UPDATED ?></a></li>
				<li><a href="transfersList/agent"><?= AGENT_TRANSFERS?></a></li>
				<li><a href="transfersList/notConfirmedAgent"><?= AGENT_TRANSFERS?> <?= NOT_CONFIRMED ?></a></li>
				<li><a href="transfersList/notCompleted">Not Completed</a></li>
				<li><a href="transfersList/invoice2">Invoice 2</a></li>
				<li class="divider"></li>
          		<li><a href="transfersList"><?= ALL_TRANSFERS ?></a></li>
          		<li class="divider"></li>					
          		<li><a href="transfersList/archive">Archived Transfers</a></li>
          		<li class="divider"></li>								
          		<li id="booking"><a href="booking/step1"><?= BOOKING ?></a></li>
				<li class="divider"></li>
          		<li id="freeForm"><a href="freeForm"><?= FREEFORM ?></a></li>
          	</ul>
          </li>
          
          <li id="users"><a href="users"><?= USERS ?> </a>
          </li>
		  
          <li id="masterSettings" class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            	Masters <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
            	<? if (!$driver) { ?><li id="countries"><a href="countries"><?= COUNTRIES ?></a></li>
          		<li id="locations"><a href="locationTypes"><?= LOCATION_TYPES ?></a></li><? } ?>	
          		<li id="locations"><a href="locations"><?= LOCATIONS ?></a></li>
          		<li id="routes"><a href="routes"><?= ROUTES ?></a></li>
				<li id="vehicleTypes"><a href="vehicleTypes"><?= VEHICLE_TYPES ?></a></li>
				<li id="extraServices"><a href="extraServices"><?= EXTRAS ?></a></li>
				<? if (!$driver) { ?><li id="coupons"><a href="coupons"><?= COUPONS ?></a></li><? } ?>				
          	</ul>
          </li>
		<? 
		if ($driver) {			
		?>	

          <li id="serviceSettings" class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<?= $_SESSION['UseDriverName'] ?><span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li id="setout"><a href="setout.php">Set out</a></li>
				<li class="divider"></li>				
            	<li id="services"><a href="services">Services</a></li>				
				<li class="divider"></li>
				<li id="special"><a href="index.php?p=special"><?= SPECIALDATES ?></a></li>
				<li id="special"><a href="index.php?p=specialtimes"><?= SPECIALTIMES ?></a></li>				
				<li id="dateSettings"><a href="index.php?p=dateSettings"><?= DATE_SETTINGS ?></a></li>
				<li class="divider"></li>				
				<li id="actions"><a href="actions">Actions</a></li>				
				<li id="activities"><a href="actions">Activities</a></li>				
				<li id="approvedFuelPrice"><a href="approvedFuelPrice">Fuel Price</a></li>
				<li class="divider"></li>				
				<li id="pricesExport"><a href="index.php?p=pricesExport&Active=1">Export prices</a></li>
				<li id="pricesExport"><a href="index.php?p=allPricesExport&Active=1">Export all prices</a></li>				
				<li id="pricesImport"><a href="index.php?p=pricesImport&Active=1">Import prices</a></li>
          	</ul>
          </li>
		<? } ?>  
		
		
		  
        </ul>
		
        <ul class="nav navbar-nav navbar-right">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user"></i>
                            <span><?= $_SESSION['UserName'] ?> <i class="caret"></i> &nbsp;</span>
							&nbsp;
                            <img src="api/showProfileImage.php?UserID=<?= $_SESSION['AuthUserID']?>" 
                                class="img-circle" alt="User Image" style="height:2em;padding:-.5em;margin:-.5em"/>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header bg-light-blue">
                                <img src="api/showProfileImage.php?UserID=<?= $_SESSION['AuthUserID']?>" 
                                class="img-circle" alt="User Image" />
                                <p>
                                    <?= $_SESSION['UserName'] ?> - <?= $_SESSION['GroupProfile'] ?>
                                    <small><?= MEMBER_SINCE.' '. $_SESSION['MemberSince'] ?></small>
                                </p>
                            </li>
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
<?
	$output = ob_get_contents();
	ob_end_clean();
	$smarty->assign("menu_render",$output);
?>	
  