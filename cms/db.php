<?



//require_once '../db/db.class.php';

define("DB_PREFIX","v4_");

/*
	$mysqli = new mysqli($host,$user,$pass, $db);
	//mysqli_select_db($db);
	
	//* check connection 
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", $mysqli->connect_error);
		exit();
	}
*/

function getMyDb()
{
	$host = 'localhost';
	//$user = 'jamtrans_cezar';
	$user = 'jamtrans_cms';
	//$pass = '3WLRAFu;E_!F';	
	$pass = '~5%OuH{etSL)';
	
	$db   = 'jamtrans_touradria';


    static $mysqli;

    if (!$mysqli) {
        $mysqli = new mysqli($host,$user,$pass, $db);
    }

    return $mysqli;
}

