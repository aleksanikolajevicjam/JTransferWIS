    <nav>
        <ul class="list-unstyled main-menu">
          
          <!--Include your navigation here-->
          <li class="text-right"><a href="#" id="nav-close">X</a></li>
          <li id="dashboard"><a href="index.php?p=dashboard"><?= DASHBOARD ?> <span class="icon"></span></a></li>
          
          <li><a href="#"><?= TRANSFERS ?></a>
            <ul class="list-unstyled">
              		<li class="sub-nav">
              			<a href="index.php?p=transfersList"><?= ALL_TRANSFERS ?> 
              			<span class="icon"></span></a>
              		</li>
              		<li class="divider"></li>
              		<li class="sub-nav">
              			<a href="index.php?p=transfersList&transfersFilter=notConfirmed"><?= NOT_CONFIRMED ?> 
              			<span class="icon"></span></a>
              		</li>
              		<li class="sub-nav">
              			<a href="index.php?p=transfersList&transfersFilter=confirmed"><?= CONFIRMED ?> 
              			<span class="icon"></span></a>
              		</li>
              		<li class="sub-nav">
              			<a href="index.php?p=transfersList&transfersFilter=noDriver"><?= NO_DRIVER ?> 
              			<span class="icon"></span></a>
              		</li>
              		<li class="sub-nav">
              			<a href="index.php?p=transfersList&transfersFilter=canceled"><?= CANCELLED ?> 
              			<span class="icon"></span></a>
              		</li>
            </ul>
          </li>
          
          
          <li><a href="#"><?= USERS ?></a>
            <ul class="list-unstyled">
              		<li class="sub-nav" id="usersList"><a href="index.php?p=usersList"><?= USERS ?>  
              			<span class="icon"></span></a>
              		</li>
              		<li class="sub-nav" id="drivers"><a href="index.php?p=drivers"><?= DRIVERS ?>  
              			<span class="icon"></span></a>
              		</li>
              		<li class="sub-nav" id="driverRoutes"><a href="index.php?p=driverRoutes"><?= DRIVER_ROUTES ?>  
              			<span class="icon"></span></a>
              		</li>

            </ul>
          </li>          
          
          
          
          <li><a href="#">Menu Four <span class="icon"></span></a></li>
          <li><a href="#">Menu Five <span class="icon"></span></a></li>
        </ul>
      </nav>
          
    <div class="navbar navbar-inverse navbar-fixed-top">      
        
        <!--Include your brand here-->
        <!-- <a class="navbar-brand" href="<?= $_SERVER['PHP_SELF']?>">ADMIN</a> -->
        <div class="navbar-header xpull-right navbar-brand">
          <a id="nav-expander" class="nav-expander fixed" style="color:#fff !important">
            <i class="fa fa-bars xfa-lg white"></i> ADMIN
          </a>
                 
        </div>
        

            <ul class="nav navbar-nav navbar-right">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="a/showProfileImage.php?UserID=<?= $_SESSION['AuthUserID']?>" 
                                    class="img-circle" alt="User Image" style="height:2em"/>
                                <span> &nbsp;</span>
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
        
        
    </div>
