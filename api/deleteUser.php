<?
header('Content-Type: text/javascript; charset=UTF-8');

error_reporting(0);

//session_start();

# init libs
require_once '../../db/db.class.php';
require_once '../../db/v4_AuthUsers.class.php';

$UserID = $_GET['AuthUserID'];

$au = new v4_AuthUsers();

$au->deleteRow($UserID);


# send output back
$output = array(
'action' => 'Deleted'
);

echo $_GET['callback'] . '(' . json_encode($output) . ')';
