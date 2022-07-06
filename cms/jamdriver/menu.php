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
			<a class="navbar-brand" href="<?= $_SERVER['PHP_SELF']?>">DRIVER</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li id="dashboard"><a href="index.php?p=dashboard"><?= DASHBOARD ?></a></li>

				<? /* TRANSFERS */ ?>
				<li id="transfersList" class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<?= TRANSFERS ?> <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="index.php?p=transfersList"><?= ALL_TRANSFERS ?></a></li>
						<li class="divider"></li>
						<li><a href="index.php?p=transfersList&transfersFilter=notConfirmed"><?= NOT_CONFIRMED ?></a></li>
						<li><a href="index.php?p=transfersList&transfersFilter=confirmed"><?= CONFIRMED ?></a></li>
						<li><a href="index.php?p=transfersList&transfersFilter=declined"><?= DECLINED ?></a></li>
						<li><a href="index.php?p=transfersList&transfersFilter=canceled"><?= CANCELLED ?></a></li>
						<li><a href="index.php?p=transfersList&transfersFilter=noshow"><?= NO_SHOW ?></a></li>
						<li><a href="index.php?p=transfersList&transfersFilter=driverError"><?= DRIVER_ERROR ?></a></li>

						<? if ($_SESSION['AuthUserID'] == '556') { ?>
						<li class="divider"></li>
						<li class="dropdown-header">Josip</li>
						<li id="driversBalance"><a href="raspored/" target="_blank">Raspored - beta</a></li>
						<? } ?>
					</ul>
				</li>

				<? /* TIMETABLE */
				$allowedDrivers = array(
										'556', 
										'631', '634', '637', '646', '698',
										'720', '726', '741', '770', '771', '773', '777', '782', 
										'843', '876', '884', '885', '886', '887',
										'901', '902', '903', '907', '908', '943',
										'254', '693', '1492'
									);
			
				if ( in_array($_SESSION['AuthUserID'], $allowedDrivers) ) { ?>
					
				<li id="timetable" class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<?= TIMETABLE ?> <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li id="transfer-list">
							<a href="index.php?p=timetableForm"><?= TRANSFER_LIST ?></a>
						</li>
						<li id="column-view">
							<a href="index.php?p=timetableColumnView">Column View</a>
						</li>
						<li id="subdrivers">
							<a href="index.php?p=subdrivers"><?= MY_DRIVERS ?></a>
						</li>
						<li id="subvehicles">
							<a href="index.php?p=subvehicles"><?= MY_VEHICLES ?></a>
						</li>
						<li id="subexpenses">
							<a href="index.php?p=subexpenses"><?= MY_EXPENSES ?></a>
						</li>
						<li id="expenses-report">
							<a href="index.php?p=expenses"><?= EXPENSES_REPORT ?></a>
						</li>
					</ul>
				</li>
				<? } ?>

				<? /* ROUTE SETTINGS, PRICE SETTINGS, REPORTS */
				$allowedDrivers2 = array(
										'556','843',
										'876','884','885','886','887',
										'901','902','903', '907', '908', '1492'
									);

				if (( $_SESSION['AdminAccessToDriverProfile'] == true ) or
					( in_array($_SESSION['AuthUserID'], $allowedDrivers2) )) { ?>

				<li id="routeSettings" class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<?= ROUTE_SETTINGS ?> <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li id="vehicles"><a href="index.php?p=vehicles"><?= VEHICLE_TYPES ?></a></li> 
						<li class="divider"></li>
						<li id="driverRoutes"><a href="index.php?p=driverRoutes"><?= DRIVER_ROUTES ?></a></li>
						<!--	                
						<li class="divider"></li>
						<li id="myVehicles"><a href="index.php?p=myVehicles"><?= MY_VEHICLES ?></a></li>
						<li id="myDrivers"><a href="index.php?p=myDrivers"><?= MY_DRIVERS ?></a></li>					
						-->
					</ul>
				</li>

				<li id="priceSettings" class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<?= PRICE_SETTINGS ?> <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li id="prices"><a href="index.php?p=prices"><?= PRICES ?></a></li>
						<li class="divider"></li>
                        <li id="extras"><a href="index.php?p=extras"><?= EXTRAS ?></a></li>
						<li class="divider"></li>
						<!-- <li id="daySettings"><a href="index.php?p=daySettings"><?= DAY_SETTINGS ?></a></li> -->
						<li id="dateSettings"><a href="index.php?p=dateSettings"><?= DATE_SETTINGS ?></a></li>
						<li id="special"><a href="index.php?p=special"><?= SPECIALDATES ?></a></li>
						<!-- <li id="nightSettings"><a href="index.php?p=nightSettings"><?= NIGHT_SETTINGS ?></a></li> -->
                        <? /*  $allowedDrivers3 = array('556', '843', '876');
                            if ( in_array($_SESSION['AuthUserID'], $allowedDrivers) ) { ?>
                                <li id="exchangeRate"><a href="index.php?p=exchangeRate"><?= EXCHANGE_RATE ?></a></li>
                        <? } */?>
					</ul>
				</li>

				<li id="reports" class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<?= REPORTS ?> <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li id="incomeMonth"><a href="index.php?p=incomeMonth">Transfers - Monthly</a></li>

					</ul>
				</li>
				<? } // END SPECIAL DRIVERS ?>
				<li id="reviews"><a href="index.php?p=userReviews"><?= REVIEWS ?></a></li>
        	</ul>

			<? /* USER MENU */ ?>
        	<ul class="nav navbar-nav navbar-right">
				<!-- User Account: style can be found in dropdown.less -->
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-user"></i>
						<span><?= $_SESSION['UserName'] ?> <i class="caret"></i> &nbsp;</span>
						<img src="a/showProfileImage.php?UserID=<?= $_SESSION['AuthUserID']?>" 
							class="img-circle" alt="User Image"
							style="height:2em;padding:-.5em;margin:-.5em"/>
					</a>
					<ul class="dropdown-menu">
						<!-- User image -->
						<li class="user-header bg-light-blue">
							<img src="a/showProfileImage.php?UserID=<?= $_SESSION['AuthUserID']?>" 
							class="img-circle" alt="User Image" />
							<p>
								<?= $_SESSION['AuthUserID'] ?> -<?= $_SESSION['UserName'] ?> - <?= $_SESSION['GroupProfile'] ?>
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

