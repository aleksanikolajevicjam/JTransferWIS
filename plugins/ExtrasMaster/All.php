<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once 'Initial.php';

@session_start();

require_once ROOT . '/db/v4_Extras.class.php';
$ex = new v4_Extras();

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

if (isset($_SESSION['UseDriverID']) && $_REQUEST['Type']>0) { 
	$sql="SELECT ServiceID FROM `v4_Extras` WHERE `OwnerID`=".$_SESSION['UseDriverID'];	
	$result = $dbT->RunQuery($sql);
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$extras_arr.=$row['ServiceID'].",";
	}	
	$extras_arr = substr($extras_arr,0,strlen($extras_arr)-1);
	if ($_REQUEST['Type']==1) $DB_Where .= " AND ID in (".$extras_arr.")";
	else $DB_Where .= " AND ID not in (".$extras_arr.")";	
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
		$detailFlds['setting']=false;		
		if (isset($_SESSION['UseDriverID']) && $_SESSION['UseDriverID']>0) {
			$id=$db->getID();
			$keys=$ex->getKeysBy('ID', '', ' WHERE ServiceID='.$id.' AND OwnerID='.$_SESSION['UseDriverID']);		
			if (count($keys)>0) $detailFlds['setting']=true;
		}
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