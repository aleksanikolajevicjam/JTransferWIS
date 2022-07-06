<?
require_once '../../config.php';
require_once ROOT . '/db/v4_Services.class.php';
$db = new v4_Services();
$dbT = new DataBaseMysql();

$keyName = 'ServiceID';
$ItemName='ServiceID ';

#********************************
# kolone za koje je moguc Search 
# treba ih samo nabrojati ovdje
# Search ce ih sam pretraziti
#********************************
$aColumns = array(
	'ServiceID' // dodaj ostala polja!
);