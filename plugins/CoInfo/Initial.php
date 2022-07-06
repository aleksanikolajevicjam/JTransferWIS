<?
require_once '../../config.php';
require_once ROOT . '/db/v4_CoInfo.class.php';
$db = new v4_CoInfo();
$keyName = 'ID';
$ItemName='co_name ';
#********************************
# kolone za koje je moguc Search 
# treba ih samo nabrojati ovdje
# Search ce ih sam pretraziti
#********************************
$aColumns = array(
	'ID', // dodaj ostala polja!
	'co_name',
);
