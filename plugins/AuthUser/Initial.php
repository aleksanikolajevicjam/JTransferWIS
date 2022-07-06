<?
require_once '../../config.php';

require_once ROOT . '/db/v4_AuthUsers.class.php';
$db = new v4_AuthUsers();
$keyName = 'AuthUserID';
$ItemName='AuthUserName ';
$type='AuthLevelID';
$selectactive='Active';
#********************************
# kolone za koje je moguc Search 
# treba ih samo nabrojati ovdje
# Search ce ih sam pretraziti
#********************************
$aColumns = array(
	'AuthUserID',
	'AuthUserName',
	'DriverID',
	'AuthUserRealName',
	'AuthUserCompany',
	'AuthUserMail',
	'Terminal'
);
