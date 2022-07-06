<?
$smarty->assign('page', $md->getName());
@session_start();
if (!$_SESSION['UserAuthorized']) die('Bye, bye');