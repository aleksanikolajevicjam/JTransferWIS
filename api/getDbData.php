<?
header('Content-Type: text/javascript; charset=UTF-8');

# init libs
require_once '../db.php';

$mysqli = getMyDb();

$table = $_GET['table'];

$where = str_replace("'","",$_GET['where']);


# init vars
$fldList = array(); 	# field names
$prep = array(); 		# name - value pairs
$out = array();			# output array


$result = $mysqli->query("SHOW COLUMNS FROM " . $table);

if (!$result) {
    echo 'Could not run query: ' . $mysqli->error;
    exit;
}
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fldList[] = $row['Field'];
    }
}

# do some processing


$q = "SELECT * FROM " . $table . " WHERE " . $where;

$w = $mysqli->query($q) or die( $mysqli->error . '');

while ($o = $w->fetch_object())
{

	foreach($fldList as $key => $fldName) {
		$prep[$fldName] = $o->$fldName;
	}
	$out[] = $prep;
}

# send output back
$output = json_encode($out);
echo $_GET['callback'] . '(' . $output . ')';
