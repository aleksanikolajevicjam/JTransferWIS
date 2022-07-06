<?
	session_start();
	$_SESSION['UserAuthorized'] = false;
	$_SESSION['AdminAccessToDriverProfile'] = false;
	session_destroy();
	header("Location: login");
