<?

require_once 'data.php';
require_once './f/db_funcs.php';

$q1 = "SELECT * FROM Orders WHERE Driver = '79' ORDER BY  OrderID ASC";
$r1 = mysql_query($q1) or die( mysql_error() . ' Orders - Start');

while ($o = mysql_fetch_object($r1)) {
        
        
        if ($o->PayNow == 0 and $o->PayLater == 0 and $o->InvoiceAmount == 0){
            $TPayNow = 0;
            $TPayLater = $o->OrderPrice;
        }
        else {
            $TPayNow = $o->PayNow;
            $TPayLater = $o->PayLater;
        }
        
        
        if ($o->SingleReturn == 'Return') {
            $PayNow2 = $TPayNow / 2;
            $PayLater2 = $TPayLater / 2;
            $PayNow = $PayNow2;
            $PayLater = $PayLater2;
        }
        else {
            $PayNow = $TPayNow;
            $PayLater = $TPayLater;
        }
        
        
        if ($o->SingleReturn == 'Single'){
            # upis single transfera
            $data = array(
                'PayNow' => $PayNow,
                'PayLater' => $PayLater
            );
            
            $where = ' OrderID = ' .$o->OrderID;
            
            $success = XUpdate('TimeTable', $data, $where);
            //echo $success . '<br>';
        }
        
        if ($o->SingleReturn == 'Return'){
            # upis return transfera
            $data2 = array(
                'PayNow' => $PayNow2,
                'PayLater' => $PayLater2
            );
            
            $where = ' OrderID = ' .$o->OrderID;
            
            $success2 = XUpdate('TimeTable', $data2, $where);
            //echo $success2 . '<br>';

        
        }


}

echo '<div class="alert alert-success"><h2>Sync Completed</h2></div>';

# Clean Up text
function CleanUp($s)
{
    return mysql_real_escape_string($s);
}


# Pretvaranje formata datuma
function DMY_to_YMD($date)
{
    $elementi = explode('.',$date);
    $new_date = $elementi[2].'-'.$elementi[1].'-'.$elementi[0];
    return $new_date;
}


# vraca Route_Id preko ServiceID
function GetRIDFromServiceID($service_id)
{
    $query_Recordset1 = "SELECT RouteID FROM Services WHERE ServiceID = '".$service_id."'";

    $Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
    $row_Recordset1 = mysql_fetch_assoc($Recordset1);

    return $row_Recordset1['RouteID'];
}


# vraca ime terminala ako je poznat routeId
function GetTermFromRID($route_id)
{
    $query_Recordset1 = "SELECT TerminalID FROM Routes WHERE RouteID = '".$route_id."'";

    $Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
    $row_Recordset1 = mysql_fetch_assoc($Recordset1);

    return $row_Recordset1['TerminalID'];
}


# vraca ime destinacije preko Route_Id
function GetDestFromRID($route_id)
{
    $query_Recordset1 = "SELECT DestinationID FROM Routes WHERE RouteID = '".$route_id."'";

    $Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
    $row_Recordset1 = mysql_fetch_assoc($Recordset1);

    return $row_Recordset1['DestinationID'];
}



# vraca ime terminala
function GetTerminalName($term_id)
{

    $query_Recordset1 = "SELECT * FROM Terminals WHERE TerminalID = '".$term_id."'";

    $Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
    $row_Recordset1 = mysql_fetch_assoc($Recordset1);
    #
    return CleanUp($row_Recordset1['TerminalName']);
}


# vraca ime destinacije
function GetDestName($dest_id)
{
    $query_Recordset1 = "SELECT * FROM Destinations WHERE DestinationID = '".$dest_id."'";

    $Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
    $row_Recordset1 = mysql_fetch_assoc($Recordset1);
    #
    return $row_Recordset1['DestinationName'];
}





# vraca VehicleTypeID preko ServiceID
function GetVehicleIDFromServiceID($service_id)
{
    $query_Recordset1 = "SELECT * FROM Services
					     WHERE ServiceID = '".$service_id."'
					     "
					     ;

    $Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
    $row_Recordset1 = mysql_fetch_assoc($Recordset1);

    return $row_Recordset1['VehicleTypeID'];
}
