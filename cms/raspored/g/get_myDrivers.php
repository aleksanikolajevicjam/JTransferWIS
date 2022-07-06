<?
/*
 * Easy set variables
 */

@session_start();
if (!$_SESSION['UserAuthorized']) die('Bye, bye');

require_once "../config.php";


/* Database connection information */
$gaSql['user']       = $user;
$gaSql['password']   = $pass;
$gaSql['db']         = $db;
$gaSql['server']     = $host;

/* Indexed column (used for fast and accurate table cardinality) */
$sIndexColumn = "DriverID";

/* DB table to use */
$sTable =  "SubDrivers";

/* Array of database columns which should be read and sent back to DataTables.
* Use a space where
* you want to insert a non-database field
* (for example a counter or static image)
*/
//$aColumns = array('VehicleImage','VehicleID', 'VehicleName','VehicleTypeID', 'VehicleDescription','PriceKm','ReturnDiscount');

$aColumns = array('DriverID', 'DriverName', 'DriverEmail','DriverTel', 'Notes');

# WHERE UVJET - VRIJEDI UVIJEK. DEFAULT JE ""
# ============================================
//$sWhere = " WHERE AuthLevelID = '99' ";
//$sWhere = " WHERE OwnerID = " . $_SESSION['OwnerID']." ";
$sWhere="";


/*
 * If you just want to use the basic configuration for DataTables
 * with PHP server-side, there is
 * no need to edit below this line
 */

/*
 * MySQL connection
 */
$gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'],
	$gaSql['password']  ) or
	die( 'Could not open connection to server' );

mysql_select_db( $gaSql['db'], $gaSql['link'] ) or
	die( 'Could not select database '. $gaSql['db'] );


/*
 * Paging
 */
$sLimit = "";
if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
{
	$sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
		mysql_real_escape_string( $_GET['iDisplayLength'] );
}


/*
 * Ordering
 */
if ( isset( $_GET['iSortCol_0'] ) )
{
	$sOrder = "ORDER BY  ";
	for ( $i=0 ; $i< intval( $_GET['iSortingCols'] ) ; $i++ )
	{
		if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
		{
			$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
			 	".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
		}
	}

	$sOrder = substr_replace( $sOrder, "", -2 );
	if ( $sOrder == "ORDER BY" )
	{
		$sOrder = "";
	}
}


/*
 * Filtering
 * NOTE this does not match the built-in DataTables filtering which does it
 * word by word on any field. It's possible to do here,
 * but concerned about efficiency
 * on very large tables, and MySQL's regex functionality is very limited
 */

//$sWhere = "";

if ( $_GET['sSearch'] != "" )
{
	########################################################################
	# VAZNO - bez ovoga su mogli gledati tudja vozila
	########################################################################
	#         Y                                      Y   Y - bilo WHERE 
	$sWhere = "WHERE ";
	for ( $i=0 ; $i< count($aColumns) ; $i++ )
	{
		$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
	}
	$sWhere = substr_replace( $sWhere, "", -3 );
	//$sWhere .= ')';
}

/* Individual column filtering */
for ( $i=0 ; $i< count($aColumns) ; $i++ )
{
	if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
	{
		if ( $sWhere == "" )
		{
			$sWhere = "WHERE ";
		}
		else
		{
			$sWhere .= " AND ";
		}
		$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
	}
}


/*
 * SQL queries
 * Get data to display
 */
$sQuery = "
	SELECT SQL_CALC_FOUND_ROWS *
	FROM   $sTable
	$sWhere
	$sOrder
	$sLimit
";
$rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());

/* Data set length after filtering */
$sQuery = "
	SELECT FOUND_ROWS()
";
$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
$iFilteredTotal = $aResultFilterTotal[0];

/* Total data set length */
$sQuery = "
	SELECT COUNT(".$sIndexColumn.")
	FROM   $sTable
";
$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
$aResultTotal = mysql_fetch_array($rResultTotal);
$iTotal = $aResultTotal[0];


/*
 * Output
 */
$sOutput = '{';
$sOutput .= '"sEcho": '.intval($_GET['sEcho']).', ';
$sOutput .= '"iTotalRecords": '.$iTotal.', ';
$sOutput .= '"iTotalDisplayRecords": '.$iFilteredTotal.', ';
$sOutput .= '"aaData": [ ';

while ( $aRow = mysql_fetch_array( $rResult ) )
{

	$sOutput .= "[";
	for ( $i=0 ; $i< count($aColumns) ; $i++ )
	{
		if ( $aColumns[$i] != ' ' )
		{
			/* General output */
			$sOutput .= '"'.str_replace('"', '\"',  $aRow[ $aColumns[$i] ] ) .'",';
		}

	}

#######################
# CUSTOM CODE #########
#######################



/*
	$link = '<a href="index.php?option=vehicles&action=edit&rec_no='.$aRow['VehicleID'].
			'" title="Edit"><div class="ui-icon ui-icon-document"></div></a>';
*/
    # Edit Link
	$link = '<button onclick="editDriver(' . $aRow['DriverID'].');"' . 
	        ' id="' . $aRow['DriverID'].'" data-name="' . $aRow['DriverName'].'"'.
	        ' data-pass="' . $aRow['DriverPassword'].'"' .
	        ' data-email="' . $aRow['DriverEmail'].'"' .
	        ' data-tel="' . $aRow['DriverTel'].'"' .
	        ' data-notes="' . $aRow['Notes'].'"' .
			'" title="Edit" class="routeEdit btn btn-primary btn-small"><i class="icon-white icon-edit"></i> Edit</button>';	
	
	
	
	$sOutput .= '"'.str_replace('"', '\"', $link).'",';





#######################
# END OF CUSTOM CODE ##
#######################

	$sOutput = substr_replace( $sOutput, "", -1 );
	$sOutput .= "],";
}
$sOutput = substr_replace( $sOutput, "", -1 );
$sOutput .= '] }';

echo $sOutput;


function GetVehicleTypeName($id)
{
	$qry = "SELECT * FROM vehicletypes
	WHERE VehicleTypeID = '".$id."'
	";

	$res = mysql_query($qry) or die(mysql_error());
	$row = mysql_fetch_assoc($res);

	return $row['VehicleTypeName'];
}

?>
