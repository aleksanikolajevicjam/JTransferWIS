<div class="navbar navbar-inverse navbar-fixed-top shadowMedium" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?= $_SERVER['PHP_SELF']?>">HOME</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<!--<li id="dashboard"><a href="index.php?p=dashboard"><?= HOME ?></a></li>-->
				<li id="expenses"><a href="index.php?p=expenses"><?= EXPENSES ?></a></li>
				<li id="activity"><a href="index.php?p=activity">ACTIVITY</a></li>				
				<li id="calculator"><a href="index.php?p=calculator"><?= CALCULATOR ?></a></li>
				<li id="reviews"><a href="index.php?p=userReviews"><?= REVIEWS ?></a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-user"></i>
						<span><?= $_SESSION['UserName'] ?> <i class="caret"></i> &nbsp;</span>
						&nbsp;
						<img src="a/showProfileImage.php?UserID=<?= $_SESSION['AuthUserID']?>" 
						class="img-circle" alt="User Image" style="height:2em;padding:-.5em;margin:-.5em"/>
					</a>
					<ul class="dropdown-menu">
						<li class="user-header bg-light-blue">
							<img src="a/showProfileImage.php?UserID=<?= $_SESSION['AuthUserID']?>" 
							class="img-circle" alt="User Image" />
							<p>
								<?= $_SESSION['UserName'] ?> - <?= $_SESSION['GroupProfile'] ?>
								<small><?= MEMBER_SINCE.' '. $_SESSION['MemberSince'] ?></small>
							</p>
						</li>
						<li class="user-footer">
							<div class="pull-left">
								<!--<a href="index.php?p=profileEdit" class="btn btn-default btn-flat">
									<?= PROFILE ?>
								</a>-->
							</div>
							<div class="pull-right">
								<a href="logout.php" class="btn btn-default btn-flat"><?= SIGN_OUT ?></a>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>

