<?
# 
# Database access
#
# Author: Bogasin Soic-Mirilovic
#
#
//if (!$_SESSION['logged']) die('Access denied!');
require_once 'config.php';
//$mysqli = getMyDb();
$conn = mysql_connect($host,$user,$pass);
mysql_select_db($db);


/* EOF */
