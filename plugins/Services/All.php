<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once 'Initial.php';
require_once ROOT . '/db/v4_Routes.class.php';
require_once ROOT . '/db/v4_VehicleTypes.class.php';
$dbC = new v4_Routes();
$dbC2 = new v4_VehicleTypes();

class v4_ServicesJoin extends v4_Services {
	public function getServicesByRouteName($column, $order, $where = NULL) {
		$keys = array(); $i = 0;
		$result = $this->connection->RunQuery("
			SELECT v4_Services.ServiceID FROM v4_Services 
			LEFT JOIN v4_Routes ON v4_Services.RouteID = v4_Routes.RouteID 
			$where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["ServiceID"];
				$i++;
			}
	return $keys;
	}
}

# init class
$s = new v4_ServicesJoin();

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

if (isset($_SESSION['UseDriverID'])) $DB_Where .= " AND v4_Services.OwnerID =".$_SESSION['UseDriverID'];

#********************************
# kolone za koje je moguc Search 
# treba ih samo nabrojati ovdje
# Search ce ih sam pretraziti
#********************************
$aColumns = array(
	'v4_Services.ServiceID', // dodaj ostala polja!
	'v4_Routes.RouteName'
);

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
		.$s->myreal_escape_string( $_REQUEST['Search'] )."%' OR ";
	}
	$DB_Where = substr_replace( $DB_Where, "", -3 );
	$DB_Where .= ')';
}
$dbTotalRecords = $s->getServicesByRouteName('v4_Routes.RouteName ' . $sortOrder, '', $DB_Where);
# test za LIMIT - trebalo bi ga iskoristiti za pagination! 'asc' . ' LIMIT 0,50'
$sk = $s->getServicesByRouteName('v4_Routes.RouteName ' . $sortOrder . ', v4_Services.VehicleTypeID ASC', '' . $limit , $DB_Where);

if (count($sk) != 0) {
    foreach ($sk as $nn => $key)
    {
    	$s->getRow($key);
		// ako treba neki lookup, onda to ovdje
		# get all fields and values
		$detailFlds = $s->fieldValues();
		// ako postoji neko custom polje, onda to ovdje.
		$dbC->getRow($s->getRouteID());
		$dbC2->getRow($s->getVehicleTypeID());
		$detailFlds["RouteName"]=$dbC->getRouteName();
		$detailFlds["VehicleTypeName"]=$dbC2->getVehicleTypeName();
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