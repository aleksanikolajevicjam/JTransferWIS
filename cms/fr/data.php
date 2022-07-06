<?
# 
# Database access
#
# Author: Bogasin Soic-Mirilovic
#
#
//if (!$_SESSION['logged']) die('Access denied!');
require_once 'config.php';

$conn = mysqli_connect($host,$user,$pass,$db);
//mysqli_select_db($db);
mysqli_query($conn, "SET NAMES 'UTF8'"); //Pon 15 Sij 2018 20:49:39 

/* EOF */
