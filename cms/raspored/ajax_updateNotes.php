<?
	require_once "data.php";
	//echo '<pre>'; print_r($_REQUEST); echo '</pre>';
	$data = array(
	        'FlightNo'      => $_REQUEST['FlightNo'],
	        'FlightTime'    => $_REQUEST['FlightTime'],
	        'SubDriver'     => $_REQUEST['SubDriver'],
	        'Car'           => $_REQUEST['Car'],
	        'SubDriver2'     => $_REQUEST['SubDriver2'],
	        'Car2'           => $_REQUEST['Car2'],
	        'SubDriver3'     => $_REQUEST['SubDriver3'],
	        'Car3'           => $_REQUEST['Car3'],
	        'SubDriverNote' => addslashes($_REQUEST['Notes']),
	        'PickupTime' 	=> $_REQUEST['PickupTime'],
	        'CashIn' 		=> $_REQUEST['CashIn']
	);
	
	$where = " ID = " . $_REQUEST['ID'];
	
	$success = XUpdate('TimeTable', $data, $where);
	
	if (!success) echo ' <small>Error saving data.</small>';
	echo ' <small>Saved.</small>';

if($_REQUEST['UpdateReturn'] == 1) {
	$data = array(
	        'CashIn' 		=> $_REQUEST['CashIn']
	);
	
	$where = " OrderID = " . $_REQUEST['OrderID'] . " AND ID != " . $_REQUEST['ID'];
	
	$res = XUpdate('TimeTable', $data, $where);
	
	if ($res) echo 'Drugi transfer ažuriran.';
}



# Update Function
function XUpdate ($table, $data, $where)
{

    $qry = 'UPDATE '.$table.' SET ';
    
    foreach ($data as $field => $value)
    {
        $qry .= $field . " = '" . $value. "' ,";
    }
    
    # Get rid of last ,
    $qry = substr_replace( $qry, "", -1 );
    
    $qry .= ' WHERE '.$where;
    
    unset($data);
    //return $qry;
    return mysql_query($qry) or die(mysql_error());

} #End XUpdate

?>

