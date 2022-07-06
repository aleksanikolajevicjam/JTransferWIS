<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);

# init libs
require_once '../db.php';
require_once '../f/db_funcs.php';

$mysqli = getMyDb();

	/* check connection */
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", $mysqli->connect_error);
		exit();
	}

// init vars
$table = '';
$keyName = '';
$keyValue = '';

if (isset($_REQUEST['table']) and $_REQUEST['table'] != '') 		$table = $_REQUEST['table'];
if (isset($_REQUEST['keyName']) and $_REQUEST['keyName'] != '') 	$keyName = $_REQUEST['keyName'];
if (isset($_REQUEST['keyValue']) and $_REQUEST['keyValue'] != '') 	$keyValue = $_REQUEST['keyValue'];

# init vars
$fldList = array();
$data = array();
$out = array();


$result = $mysqli->query( "SHOW COLUMNS FROM " . $table);

if (!$result) {
    echo 'Could not run query: ' . $mysqli->error;
    exit;
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        // radi samo za polja koja su poslana REQUEST-om
        if(array_key_exists($row['Field'], $_REQUEST)) {

			// priprema data arraya - 'Ime_iz_tabele' => vrijednost iz REQUEST-a
			// znaci svakom polju iz tabele se dodjeljuje vrijednost poslana REQUEST-om
	        $data[$row['Field']] = $_REQUEST[$row['Field']];
        }
    }
}
// sad imamo kompletiran $data array

// ako je update, azuriraj trazeni slog
$where = ' ' . $keyName . '=' . $keyValue;

if ($keyName != '' and $keyValue != '') {
	XUpdate($table, $data, $where);
	$upd = 'Updated';
}

// inace dodaj novi slog	
if ($keyName != '' and $keyValue == '') {
	$newID = XInsert($table, $data);
}


$out = array(
	'update' => $upd,
	'insert' => $newID
);

# send output back
$output = json_encode($out);
echo $_REQUEST['callback'] . '(' . $output . ')';
