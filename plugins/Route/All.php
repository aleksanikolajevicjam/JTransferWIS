<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once 'Initial.php';
require_once ROOT . '/db/v4_DriverRoutes.class.php';
$dbC = new v4_DriverRoutes();

@session_start();

# sastavi filter - posalji ga $_REQUEST-om
if (isset($type)) {
	if (!isset($_REQUEST['Type']) or $_REQUEST['Type'] == 0) {
		$filter = "  AND ".$type." != 0 ";
	}
	else {
		$filter = "  AND ".$type." = '" . $_REQUEST['Type'] . "'";
	}
}
$page 		= $_REQUEST['page'];
$length 	= $_REQUEST['length'];
$sortOrder 	= $_REQUEST['sortOrder'];

$start = ($page * $length) - $length;

if ($length > 0) {
	$limit = ' LIMIT '. $start . ','. $length;
}
else $limit = '';

if(empty($sortOrder)) $sortOrder = 'ASC';


# init vars
$out = array();
$flds = array();

# kombinacija where i filtera
$DB_Where = " " . $_REQUEST['where'];
$DB_Where .= $filter;

if (isset($_SESSION['UseDriverID'])) {
	$sql="SELECT RouteID FROM `v4_DriverTerminals`,v4_RoutesTerminals WHERE `DriverID`=".$_SESSION['UseDriverID']." and v4_DriverTerminals.TerminalID=v4_RoutesTerminals.TerminalID";		
	$result = $dbT->RunQuery($sql);
	if ($_REQUEST['Type']>0) {
		$sql="SELECT RouteID FROM `v4_DriverRoutes` WHERE `OwnerID`=".$_SESSION['UseDriverID'];					
		$result2 = $dbT->RunQuery($sql);
		while($row2 = $result2->fetch_array(MYSQLI_ASSOC)){
			$routes[]=$row2['RouteID'];
		}
	}	
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		if ($_REQUEST['Type']==1 && in_array($row['RouteID'],$routes)) $routes_arr.=$row['RouteID'].",";
		else if ($_REQUEST['Type']==2 && !in_array($row['RouteID'],$routes)) $routes_arr.=$row['RouteID'].",";
		else if ($_REQUEST['Type']==0) $routes_arr.=$row['RouteID'].",";
	}		
	$routes_arr = substr($routes_arr,0,strlen($routes_arr)-1);	
	$DB_Where .= " AND RouteID in (".$routes_arr.")";
}
else if ($_REQUEST['Type']>0) {
	$sql="SELECT TopRouteID FROM `v4_TopRoutes` WHERE 1=1";
	$result3 = $dbT->RunQuery($sql);
	while($row3 = $result3->fetch_array(MYSQLI_ASSOC)){
		$routes_arr.=$row3['TopRouteID'].",";
	}
	
	$routes_arr = substr($routes_arr,0,strlen($routes_arr)-1);	
	if ($_REQUEST['Type']==1) $DB_Where .= " AND RouteID in (".$routes_arr.")";
	else $DB_Where .= " AND RouteID not in (".$routes_arr.")";
}	
# dodavanje search parametra u qry
# DB_Where sad ima sve potrebno za qry
if ( $_REQUEST['Search'] != "" )
{
	$DB_Where .= " AND (";

	for ( $i=0 ; $i< count($aColumns) ; $i++ )
	{
		# If column name exists
		if ($aColumns[$i] != " ")
		$DB_Where .= $aColumns[$i]." LIKE '%"
		.$db->myreal_escape_string( $_REQUEST['Search'] )."%' OR ";
	}
	$DB_Where = substr_replace( $DB_Where, "", -3 );
	$DB_Where .= ')';
}
$dbTotalRecords = $db->getKeysBy($ItemName . $sortOrder, '',$DB_Where);
# test za LIMIT - trebalo bi ga iskoristiti za pagination! 'asc' . ' LIMIT 0,50'
$dbk = $db->getKeysBy($ItemName . $sortOrder, '' . $limit , $DB_Where);

if (count($dbk) != 0) {
    foreach ($dbk as $nn => $key)
    {
    	$db->getRow($key);
		// ako treba neki lookup, onda to ovdje
		# get all fields and values
		$detailFlds = $db->fieldValues();
		// ako postoji neko custom polje, onda to ovdje.
		// npr. $detailFlds["AuthLevelName"] = $nekaDrugaDB->getAuthLevelName().' nesto';
		$out[] = $detailFlds;    	
    }
}
# send output back
$output = array(
'recordsTotal' => count($dbTotalRecords),
'data' =>$out
);
echo $_GET['callback'] . '(' . json_encode($output) . ')';	