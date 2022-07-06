<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once 'Initial.php';

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
		if ($db->getRouteID()) {
			$ro->getRow($db->getRouteID());
			$routeName=$ro->getRouteNameEN();
		}
		else {
			$where2= "Where OrderID=".$db->OrderID." AND TNo=1";
			$odk = $od->getKeysBy('DetailsID ', '' , $where2);
			$od->getRow($odk[0]);			
			$routeName=$od->PickupName."-".$od->DropName;
		}	
		$detailFlds["RouteNameEN"] = $routeName;		
		$out[] = $detailFlds;    	
    }
}
class v4_SurveyJoin extends v4_Survey {
	public function getKeysBy($column, $order, $where = NULL){
		$keys = array(); $i = 0;
		$result = $this->connection->RunQuery("
			SELECT v4_Survey.ID, v4_Routes.RouteNameEN FROM v4_Survey 
			LEFT JOIN v4_Routes ON v4_Survey.RouteID = v4_Routes.ID 
			$where ORDER BY $column $order");
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$keys[$i] = $row["ID"];
			$i++;
		}
	return $keys;
	}
}

# init class
$sj = new v4_SurveyJoin();

# send output back
$output = array(
'recordsTotal' => count($dbTotalRecords),
'data' =>$out
);
echo $_GET['callback'] . '(' . json_encode($output) . ')';	