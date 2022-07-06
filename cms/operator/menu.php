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
			<a class="navbar-brand" href="<?= $_SERVER['PHP_SELF']?>">OPERATOR</a>
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
						<li><a href="index.php?p=transfersList&transfersFilter=noDriver"><?= NO_DRIVER ?></a></li>
						<li><a href="index.php?p=transfersList&transfersFilter=notConfirmed"><?= NOT_CONFIRMED ?></a></li>
						<li><a href="index.php?p=transfersList&transfersFilter=confirmed"><?= CONFIRMED ?></a></li>
						<li><a href="index.php?p=transfersList&transfersFilter=declined"><?= DECLINED ?></a></li>
						<li><a href="index.php?p=transfersList&transfersFilter=canceled"><?= CANCELLED ?></a></li>
						<li><a href="index.php?p=transfersList&transfersFilter=noshow"><?= NO_SHOW ?></a></li>
						<li><a href="index.php?p=transfersList&transfersFilter=driverError"><?= DRIVER_ERROR ?></a></li>
						<li><a href="index.php?p=transfersList&transfersFilter=notCompleted">Not Completed</a></li>
						<li><a href="index.php?p=transfersList&transfersFilter=agent"><?= AGENT_TRANSFERS?></a></li>
						<li><a href="index.php?p=transfersList&transfersFilter=notConfirmedAgent"><?= AGENT_TRANSFERS?> <?= NOT_CONFIRMED ?></a></li>
						<li class="divider"></li>
						<li><a href="index.php?p=transfersList"><?= ALL_TRANSFERS ?></a></li>
						<li class="divider"></li>		
						<li><a href="index.php?p=transfersList&archive=1">Archived Transfers</a></li>
						<li class="divider"></li>		
						<li id="booking"><a href="index.php?p=booking"><?= BOOKING ?></a></li>
						<li class="divider"></li>							
						<li id="freeForm"><a href="index.php?p=freeForm"><?= FREEFORM ?></a></li>
					</ul>
				</li>
				<li id="users"><a href="index.php?p=users"><?= USERS ?></a>
				<li id="prices"><a href="index.php?p=prices"><?= PRICES ?></a>
				<li id="reports" class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<?= REPORTS ?> <span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="index.php?p=emailsForm"><?= CLIENT_EMAILS ?></a></li>
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

