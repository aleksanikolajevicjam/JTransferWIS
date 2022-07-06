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
        $qry .= '"'.trim($value).'",';
    }
    
    # Get rid of last ,
    $qry = substr_replace( $qry, "", -1 );
    
    $qry .= ')'; 
    
    unset($data);   
    
    $success = mysql_query($qry) or die(mysql_error() . $qry . ' XInsert');
    
    if ($success ) return mysql_insert_id();
    else return 0;

} #End XInsert



# Update Function
function XUpdate ($table, $data, $where)
{

    $qry = 'UPDATE '.$table.' SET ';
    
    foreach ($data as $field => $value)
    {
        $qry .= $field . " = '" . trim($value). "' ,";
    }
    
    # Get rid of last ,
    $qry = substr_replace( $qry, "", -1 );
    
    $qry .= ' WHERE '.$where;
    
    unset($data);
    //echo $qry;
    return mysql_query($qry) or die(mysql_error().' XUpdate Error');

} #End XUpdate



function XRecords ( $table, $where = NULL, $other = NULL, $retVal = NULL)
{
    $qry = 'SELECT * FROM '.$table;
    
    if (!empty($where)) $qry .= ' WHERE ' . $where;
    
    if (!empty($other) and ($other != NULL)) $qry .= ' ' . $other;
    
    $r = mysql_query($qry) or die(mysql_error());
    
    # Return num_rows or data
    if ($retVal == 'num_rows') return mysql_num_rows($r);
    else return $r;
    
} #End XRecExists


function XDelete($table, $where)
{
	$qry = "DELETE FROM ".$table." WHERE ".$where;
	//echo $qry;
	return mysql_query($qry);// or die(mysql_error());
}
/* EOF */
