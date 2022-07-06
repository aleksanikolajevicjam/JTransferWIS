<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);

@session_start();
# init libs
require_once '../../../../db/db.class.php';
require_once '../../../../db/v4_Vehicles.class.php';
require_once '../../../../db/v4_VehicleTypes.class.php';
require_once '../../../../db/v4_AuthUsers.class.php';

class v4_VehiclesJoin extends v4_Vehicles {
	public function getKeysBy($column, $order, $where = NULL){
		$keys = array(); $i = 0;
		$result = $this->connection->RunQuery(
					"SELECT v4_Vehicles.VehicleID, v4_AuthUsers.AuthUserRealName FROM v4_Vehicles 
					 LEFT JOIN v4_AuthUsers ON v4_Vehicles.OwnerID = v4_AuthUsers.AuthUserID 
					$where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["VehicleID"];
				$i++;
			}
	return $keys;
	}
}

# init class
$db = new v4_VehiclesJoin();
$au = new v4_AuthUsers();
$vt = new v4_VehicleTypes();

#********************************************
# ulazni parametri su where, status i search
#********************************************

# sastavi filter - posalji ga $_REQUEST-om


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
require_once ROOT . '/cms/fixDriverID.php';
foreach($fakeDrivers as $key => $fakeDriverID) {
    if($_REQUEST['OwnerID'] == $fakeDriverID) $_REQUEST['OwnerID'] = $realDrivers[$key];    
}

$DB_Where = " " . $_REQUEST['where'];
if(isset($_REQUEST['OwnerID']) and $_REQUEST['OwnerID'] != '0') $DB_Where .= ' AND OwnerID = ' .$_REQUEST['OwnerID'];
$DB_Where .= $filter;

#********************************
# kolone za koje je moguc Search 
# treba ih samo nabrojati ovdje
# Search ce ih sam pretraziti
#********************************
$aColumns = array(
	'VehicleID', // dodaj ostala polja!
	'VehicleName',
	'AuthUserRealName'
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
		.$db->myreal_escape_string( $_REQUEST['Search'] )."%' OR ";
	}
	$DB_Where = substr_replace( $DB_Where, "", -3 );
	$DB_Where .= ')';
}







$dbTotalRecords = $db->getKeysBy('v4_Vehicles.OwnerID ASC', '',$DB_Where);

# test za LIMIT - trebalo bi ga iskoristiti za pagination! 'asc' . ' LIMIT 0,50'
$dbk = $db->getKeysBy('v4_AuthUsers.AuthUserCompany '.$sortOrder.', VehicleCapacity ' . $sortOrder.', VehicleName ' . $sortOrder, '' . $limit , $DB_Where);

if (count($dbk) != 0) {
   
    foreach ($dbk as $nn => $key)
    {
    	
    	$db->getRow($key);
    	$au->getRow($db->getOwnerID());
    	$vt->getRow($db->getVehicleTypeID());
		
		// ako treba neki lookup, onda to ovdje
		
		# get all fields and values
		$detailFlds = $db->fieldValues();
		
		// ako postoji neko custom polje, onda to ovdje.
		// npr. $detailFlds["AuthLevelName"] = $nekaDrugaDB->getAuthLevelName().' nesto';
		$detailFlds["AuthUserRealName"] = $au->getAuthUserCompany();
		$detailFlds["VehicleClass"] = $vt->getVehicleClass();
		
		$out[] = $detailFlds;    	

		
    }
}


# send output back
$output = array(
'recordsTotal' => count($dbTotalRecords),
'data' =>$out
);

echo $_GET['callback'] . '(' . json_encode($output) . ')';
$db->endv4_Vehicles();
$au->endv4_AuthUsers();


