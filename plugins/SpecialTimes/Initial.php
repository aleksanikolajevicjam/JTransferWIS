<?
require_once '../../config.php';
require_once ROOT . '/db/v4_SpecialTimes.class.php';
$db = new v4_SpecialTimes();
$dbT = new DataBaseMysql();
$keyName = 'ID';
$ItemName='DisplayOrder ';
#********************************
# kolone za koje je moguc Search 
# treba ih samo nabrojati ovdje
# Search ce ih sam pretraziti
#********************************
$aColumns = array(
);