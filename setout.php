<?
	session_start();
	//$_SESSION['UseDriverID'] = false;
	unset ($_SESSION['UseDriverID']);
	unset ($_SESSION['UseDriverName']);
	if (isset($_COOKIE['page'])) $page=$_COOKIE['page'];
	else $page='dashboard';
	header("Location: " .$page);
	exit();

