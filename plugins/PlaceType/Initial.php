<?
require_once '../../config.php';
require_once ROOT . '/db/v4_PlaceTypes.class.php';
$db = new v4_PlaceTypes();
$keyName = 'PlaceTypeID';
$ItemName='PlaceType ';
#********************************
# kolone za koje je moguc Search 
# treba ih samo nabrojati ovdje
# Search ce ih sam pretraziti
#********************************
$aColumns = array(
	'PlaceTypeID', // dodaj ostala polja!
	'PlaceTypeEN'
);