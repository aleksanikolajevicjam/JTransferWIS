<?
require_once 'data.php';

$q = "DELETE FROM TimeTable WHERE ID = '" . $_REQUEST['ID'] . "'";
$w = mysql_query($q);
echo 'Transfer izbrisan. Refresh!';
