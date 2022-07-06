<?
require_once '../../config.php';
require_once ROOT . '/db/v4_Countries.class.php';
$db = new v4_Countries();
$keyName = 'CountryID';
$ItemName='CountryName ';
#********************************
# kolone za koje je moguc Search 
# treba ih samo nabrojati ovdje
# Search ce ih sam pretraziti
#********************************
$aColumns = array(
	'CountryID', // dodaj ostala polja!
	'CountryName'
);