<?
# 
# Database access
#
# Author: Bogasin Soic-Mirilovic
#
#
//if (!$_SESSION['logged']) die('Access denied!');
require_once 'config.php';

$conn = mysql_connect($host,$user,$pass);
mysql_select_db($db);


/* EOF */
