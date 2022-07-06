<?
require 'data.php';


$rid = GetRIDFromServiceID('14109');

echo GetTerminalName( GetTermFromRID($rid) );
echo '<br>';
echo GetDestName( GetDestFromRID($rid) );


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
# Clean Up text
function CleanUp($s)
{
    return mysql_real_escape_string($s);
}
?>
