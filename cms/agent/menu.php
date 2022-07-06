      <!-- Static navbar -->
      <div class="navbar navbar-inverse navbar-fixed-top xshadowMedium bg-black" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= $_SERVER['PHP_SELF']?>">AGENT</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li id="dashboard"><a href="index.php?p=dashboard"><?= DASHBOARD ?></a></li>
			  <li id="booking"><a href="index.php?p=booking"><?= BOOKING ?></a></li>
              <li><a href="index.php?p=transfersList"><?= TRANSFERS ?></a></li>
			  <? if (in_array($_SESSION['AuthUserID'],array(69, 1836, 2831))) { ?>
			  <li id="freeForm"><a href="index.php?p=freeForm"><?= FREEFORM ?></a></li>
			  <? } ?>
			

              
              <li id="transfersList" class="dropdown hidden">
              	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
              		<?= TRANSFERS ?> <span class="caret"></span>
              	</a>
              	<ul class="dropdown-menu" role="menu">
              		<li><a href="index.php?p=transfersList"><?= ALL_TRANSFERS ?></a></li>
              		<!--<li class="divider"></li>
              		<li><a href="index.php?p=transfersList&transfersFilter=canceled"><?= CANCELLED ?></a></li>
              		-->
              	</ul>
              </li>

<!--
              <li id="reports" class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                	<?= REPORTS ?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
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
-->
            </ul>
            <ul class="nav navbar-nav navbar-right">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?= $_SESSION['UserName'] ?> <i class="caret"></i></span>
                                <img src="a/showProfileImage.php?UserID=<?= $_SESSION['AuthUserID']?>" 
                                    class="img-circle" alt="User Image" style="height:2em;width:2em;padding:0"/>
                            </a>
                            <ul class="dropdown-menu  bg-orange shadowMedium">
                                <!-- User image -->
                                <li class="user-header">
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
                                        <a href="logout.php" class="btn btn-default  btn-flat"><?= SIGN_OUT ?></a>
                                    </div>
                                </li>
                            </ul>
                        </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>

