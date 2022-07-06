<?
require_once '../../config.php';
require_once ROOT . '/db/v4_Pages.class.php';
$db = new v4_Pages();
$keyName = 'ID';
$ItemName='Title ';
#********************************
# kolone za koje je moguc Search 
# treba ih samo nabrojati ovdje
# Search ce ih sam pretraziti
#********************************
$aColumns = array(
	'ID', // dodaj ostala polja!
	'Title',
);
