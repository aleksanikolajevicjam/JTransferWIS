<?
/*
Site functions

*/

#
# returns portion of a string for selected language. example [it]...text...[/it]
# for not existing lang, returns default value (before first square bracket)
# if there are no square brackets, returns the whole string
# Params: $lang = language code - two chars, $string = any type of text
#

function langs($lang, $string)
{
	# make full search string
	$s1 = '['.$lang.']';
	$s2 = '[/'.$lang.']';
	
	# find positions
	$start = stripos($string, $s1)+4;
	$end   = stripos($string, $s2);
	
	# required language found
	if ($start and $end)
	{
		$retStr = substr( $string, $start, $end - $start);
		return $retStr;
	}
	# required language not found, other languages exist, return default language
	else if (stripos($string, '[') )
	{
		$retStr = substr( $string, 0, stripos($string, '[') );
		return $retStr;
	}
	
	# no languages but default
	return $string;	
}	


# return session var if exists
function s($varName)
{
    if (isset($_SESSION[$varName])) return $_SESSION[$varName];
}



# kreira random broj narudzbe
function create_order_key()
{
	srand(time());
	$whichone1 = (rand()%10);
	$whichone2 = (rand()%10);
	$whichone3 = (rand()%10);
	$whichone4 = (rand()%10);
	$whichone5 = (rand()%10);
	$str = "";
	$str2 = "ABCDEFGHIJKLMNPQRSTUVWXYZA";
	for($i=0;$i<10;$i++)
	{
		$random = (rand()%10);
		$random2 = (rand()%11);
		$random3 = (rand()%26);
		if($i == $whichone1 || $i == $whichone2 || $i == $whichone3 || $i == $whichone4 || $i == $whichone5) $str .= $str2[$random3];
		else $str .= $random;
	}
	return $str;
}





# booking_thankyou.php
function GetRouteID($t, $d)
{
	$qry = "SELECT RouteID FROM ".DB_PREFIX."routes 
			WHERE (FromID = {$t} AND ToID = {$d})
			OR (FromID = {$d} AND ToID = {$t})
			ORDER BY RouteID ASC";
	$res = mysql_query($qry) or die(mysql_error());
	$row = mysql_fetch_assoc($res);
	
	return $row['RouteID'];
}


# vraca ime drzave na osnovu id
function LookupCountry($id)
{

$query_Recordset1 = "SELECT * FROM ".DB_PREFIX."countries WHERE CountryID = '". $id. "' ORDER BY CountryName ASC";
$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
#dodano zbog ruskog
//  if ($_SESSION['lang'] == 'ru') return $row_Recordset1['CountryNameRU'];
#
return $row_Recordset1['CountryName'];
}


# Fill $countries array with country data

function fillCountries()
{
    $countries = array();
    /*
    # Find all routes that have drivers
    $q = "SELECT DISTINCT RouteID, OwnerID FROM ".DB_PREFIX."driverroutes WHERE OwnerID >= 100";

    $w = mysql_query($q) or die(mysql_error());

    while($d = mysql_fetch_object($w))
    {
	
	    # find starting and ending points for each Route
	    $q1 = "SELECT FromID, ToID FROM ".DB_PREFIX."routes
				    WHERE RouteID = '{$d->RouteID}'
				    ";
	    $r1 = mysql_query($q1) or die(mysql_error());
	
	    while($r = mysql_fetch_object($r1))
	    {
    */
		    # Get Place Country id's
		    $q2 = "SELECT * FROM ".DB_PREFIX."places

					    ";
		    $w2 = mysql_query($q2) or die(mysql_error());
		
		    while ($p = mysql_fetch_object($w2))
		    {
			    # Get Country Names
			    $q3 = "SELECT * FROM ".DB_PREFIX."countries
						    WHERE CountryID = '{$p->PlaceCountry}'
						    ";
			    $r3 = mysql_query($q3) or die(mysql_error());
			
			    $c = mysql_fetch_object($r3);
			
                # Check for duplicates and add to array			
			    if (!in_array($c->CountryName,$countries)) $countries[$c->CountryID] = $c->CountryName;
		    }					
    /*	}
	

    }*/

    # Sort by name
    asort($countries);
    return $countries;

} #end function


# echo country <option>
function getCountries()
{
    $countries = fillCountries();

        echo '<option value="0">';
        echo PLEASE_SELECT;
        echo '</option>';
    
    foreach ($countries as $id => $name)
    {
        # code...
        echo '<option value="'.$id.'">';
        echo $name;
        echo '</option>';
    }
} # end function



function showExtrasTable($detailsID,$ownerID)
{
	$q = "	SELECT * FROM ".DB_PREFIX."OrderExtras 
			WHERE OrderDetailsID = '{$detailsID}' 
			AND OwnerID = '{$ownerID}' 
			ORDER BY ServiceID ASC
			";
	$r = mysql_query($q) or die(mysql_error());
	
	$output = '';
	
	if (mysql_num_rows($r) > 0)
	{
		$output = '<hr/>Extras<hr/><table width="100%"><tr>
					<thead>
					<td>Service</td>
					<td>Price</td>
					<td>Qty</td>
					<td>Amount</td>
					</thead></tr>';
		
		while ($s = mysql_fetch_object($r))
		{
			$output .= '<tr><td>' . $s->ServiceName . '</td>';
			$output .= '<td>' . $s->Price . '</td>';
			$output .= '<td>' . $s->Qty . '</td>';
			$output .= '<td>' . $s->Sum .'</td></tr>';
		}
		
		$output .= '</table><hr/>';
	}
	
	
	
function selectMultiRows($query)
{
	if((@$result = mysql_query ($query))==FALSE)
	{
		echo "<strong>Error in query:</strong> <br>$query";
	}
	else
	{
		$count = 0;
		$data = array();

		while ($row = mysql_fetch_array($result))
		{
			$data[$count] = $row;
			$count++;
		}
		return $data;
	}
}	
	
	return $output;
}


# vraca ime terminala ako je poznat routeId
function GetTermFromRID($route_id)
{
$query_Recordset1 = "SELECT FromID FROM ".DB_PREFIX."Routes WHERE RouteID = '".$route_id."'";

$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

return $row_Recordset1['FromID'];
}


# vraca ime destinacije preko Route_Id
function GetDestFromRID($route_id)
{
$query_Recordset1 = "SELECT ToID FROM  ".DB_PREFIX."Routes WHERE RouteID = '".$route_id."'";

$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);


return $row_Recordset1['ToID'];
}


# vraca ime terminala
function GetPlaceName($term_id)
{

$query_Recordset1 = "SELECT * FROM  ".DB_PREFIX."places WHERE PlaceID = '".$term_id."'";

$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
#dodano zbog ruskog
  if (isset($_SESSION['lng']) &&  $_SESSION['lng'] == 'ru')
  return $row_Recordset1['TermNameRU'];
#
return $row_Recordset1['PlaceNameEN'];
}



# vraca VehicleTypeID preko ServiceID
function GetVehicleIDFromServiceID($service_id)
{
$query_Recordset1 = "SELECT * FROM ".DB_PREFIX."services
					 WHERE ServiceID = '".$service_id."'
					 "
					 ;

$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

return $row_Recordset1['VehicleID'];
}

# vraca VehicleTypeName preko VehicleID
function GetVehicleName($vehicle_id)
{
$query_Recordset1 = "SELECT * FROM ".DB_PREFIX."vehicles
					 WHERE VehicleID = '".$vehicle_id."'
					 "
					 ;

$Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

return $row_Recordset1['VehicleName'];
}



function mail_html($mailto, $from_mail, $from_name, $replyto, $subject, $message) {

    $header = "From: ".$from_name." <".$from_mail.">\r\n";
    $header .= "Reply-To: ".$replyto."\r\n";

    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type:text/html; charset=utf-8"."\r\n";


    return mail($mailto, $subject, $message, $header);
}



function UserRealName($id)
{
	$q = "SELECT * FROM ".DB_PREFIX."AuthUsers WHERE AuthUserID = '{$id}'";
	$r = mysql_query($q);
	$u = mysql_fetch_object($r);
	
	if (mysql_num_rows($r) > 0) return $u->AuthUserRealName;
	else return '';
}

