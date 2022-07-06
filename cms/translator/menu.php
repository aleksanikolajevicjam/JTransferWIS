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
            <a class="navbar-brand" href="<?= $_SERVER['PHP_SELF']?>">TRANSLATOR</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li id="countries">
					<a href="index.php?p=countries"><?= COUNTRIES ?></a>
				</li>
                <li id="extraServices"><a href="index.php?p=extraServices"><?= EXTRA_SERVICES ?></a></li>
				<li id="sitePages">
					<a href="index.php?p=sitePages"><?= PAGES ?></a>
				</li>
				<li id="placeTypes">
					<a href="index.php?p=placeTypes"><?= LOCATION_TYPES ?></a>
				</li>
				<li id="places">
					<a href="index.php?p=places"><?= LOCATIONS ?></a>
				</li>
				<li id="vehicleTypes">
					<a href="index.php?p=vehicleTypes"><?= VEHICLE_TYPES ?></a>
				</li>
				<li id="articles">
					<a href="index.php?p=articles"><?= ARTICLES ?></a>
				</li>				
				<li id="labels">
					<a href="index.php?p=labels">Labels</a>
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
							class="img-circle" alt="User Image" style="height:2em;padding:-.5em;margin:-.5em">
					</a>
					<ul class="dropdown-menu">
						<!-- User image -->
						<li class="user-header bg-light-blue">
							<img src="a/showProfileImage.php?UserID=<?= $_SESSION['AuthUserID']?>" 
								class="img-circle" alt="User Image">
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
								<a href="logout.php" class="btn btn-default btn-flat">
									<?= SIGN_OUT ?>
								</a>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div><!--/.nav-collapse -->
	</div><!--/.container-fluid -->
</div>

