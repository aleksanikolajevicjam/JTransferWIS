<?
require_once '../../config.php';
require_once ROOT . '/db/v4_Survey.class.php';
$db = new v4_Survey();
$keyName = 'ID';
$ItemName='UserName ';
#********************************
# kolone za koje je moguc Search 
# treba ih samo nabrojati ovdje
# Search ce ih sam pretraziti
#********************************
$aColumns = array(
	'ID',
	'Comment',
	'UserName',
	'OrderID',
	'RouteID'
);
require_once ROOT . '/db/v4_Routes.class.php';
require_once ROOT . '/db/v4_OrderDetails.class.php';
$od= new v4_OrderDetails();
$ro = new v4_Routes();