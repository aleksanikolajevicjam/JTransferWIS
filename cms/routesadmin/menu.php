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
		<a class="navbar-brand" href="<?= $_SERVER['PHP_SELF']?>">ROUTES ADMINISTRATOR</a>
	  </div>
	  <div class="navbar-collapse collapse">
		<ul class="nav navbar-nav">
			<li id="countries"><a href="index.php?p=countries"><?= COUNTRIES ?></a></li>
			<li id="locations"><a href="index.php?p=locations"><?= LOCATIONS ?></a></li>
			<li id="routes"><a href="index.php?p=routes"><?= ROUTES ?></a></li>
			<li id="locations"><a href="index.php?p=locationTypes"><?= LOCATION_TYPES ?></a></li>
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

