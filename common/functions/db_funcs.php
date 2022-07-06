<?
/*

Functions to manipulate MySQL Database

function XInsert($table, $data)

function XUpdate ($table, $data, $where)

function XRecords ( $table, $where = NULL, $other = NULL, $retVal = 'num_rows')

function XDelete($table, $where)

*/

# Insert Function
function XInsert($table, $data)
{

    $mysqli = getMyDb();
    
    $qry = 'INSERT INTO '.$table.' (';

    foreach ($data as $field => $value)
    {
        $qry .= $field . ',';
    }

    # Get rid of last ,
    $qry = substr_replace( $qry, "", -1 );

    $qry .= ') VALUES ( ';


    foreach ($data as $field => $value)
    {
        $qry .= '"'.trim($mysqli->real_escape_string($value)).'",';
    }

    # Get rid of last ,
    $qry = substr_replace( $qry, "", -1 );

    $qry .= ')';

    unset($data);
    $mysqli->query($qry);// or die($mysqli->error . print_r($data));
	if($mysqli->error) echo $mysqli->error;
    return $mysqli->insert_id;

} #End XInsert



# Update Function
function XUpdate ($table, $data, $where)
{
	$mysqli = getMyDb();
	
	$qry = 'UPDATE '.$table.' SET ';

    foreach ($data as $field => $value)
    {
        $value = $mysqli->real_escape_string($value);
        $qry .= $field . " = '" .  trim($value). "' ,";
    }

    # Get rid of last ,
    $qry = substr_replace( $qry, "", -1 );

    $qry .= ' WHERE '.$where;

    unset($data);
   // echo $qry;
    return $mysqli->query($qry) or die($mysqli->error . ' On UPDATE');

} #End XUpdate



function XRecords ( $table, $where = NULL, $other = NULL, $retVal = NULL)
{
    $mysqli = getMyDb();
    
    $qry = 'SELECT * FROM '.$table;

    if (!empty($where)) $qry .= ' WHERE ' . $where;

    if (!empty($other) and ($other != NULL)) $qry .= ' ' . $other;

    $r = $mysqli->query( $qry) or die($mysqli->error);

    # Return num_rows or data
    if ($retVal == 'num_rows') return $r->num_rows;
    else return $r;

} #End XRecords


function XDelete($table, $where)
{
	$mysqli = getMyDb();
	$qry = "DELETE FROM ".$table." WHERE ".$where;
	//echo $qry;
	return $mysqli->query($qry);// or die($mysqli->error());
}
/* EOF */


function escape($s){
		$mysqli = getMyDb();
        $s = $mysqli->real_escape_string($s);
        return "$s";
    }
