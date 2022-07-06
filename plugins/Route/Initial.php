<?
require_once '../../config.php';
require_once ROOT . '/db/v4_Routes.class.php';
$db = new v4_Routes();
$dbT = new DataBaseMysql();

$keyName = 'RouteID';
$ItemName='RouteName ';

#********************************
# kolone za koje je moguc Search 
# treba ih samo nabrojati ovdje
# Search ce ih sam pretraziti
#********************************
$aColumns = array(
	'RouteID', // dodaj ostala polja!
	'RouteName'
);