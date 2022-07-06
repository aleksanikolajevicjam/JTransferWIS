<?
header('Content-Type: text/javascript; charset=UTF-8');
@session_start();
$_SESSION['UseDriverID']=$_REQUEST['id'];
echo $_SESSION['UseDriverID'];
?>
