<?
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//header('Content-Type: text/javascript; charset=UTF-8');
//error_reporting(E_PARSE);

@session_start();
# init libs
require_once '../../../../db/db.class.php';
require_once '../../../../db/v4_VehicleEquipmentList.class.php';

# init class
$db = new v4_VehicleEquipmentList();


class v4_VehicleEquipmentListJoin extends v4_VehicleEquipmentList {
	public function getKeysBy($column, $order, $where = NULL){
		$keys = array(); $i = 0;
		$result = $this->connection->RunQuery("
			SELECT v4_VehicleEquipmentList.ID, v4_VehicleEquipmentList.ListID FROM v4_VehicleEquipmentList WHERE VehicleID=0");
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$keys[$i] = $row["ID"];
			$i++;
		}
	return $keys;
	}
}
# init class
$se = new v4_VehicleEquipmentListJoin();

#********************************************
# ulazni parametri su where, status i search
#********************************************

# sastavi filter - posalji ga $_REQUEST-om




# init vars
$out = array();
$flds = array();

# kombinacija where i filtera
//$DB_Where .= $filter;

#********************************
# kolone za koje je moguc Search 
# treba ih samo nabrojati ovdje
# Search ce ih sam pretraziti
#********************************
$aColumns = array(
	'ID',
	'ListID',
    'Description',
    'Datum'
);



$where='WHERE VehicleID='.$_REQUEST['VehicleID'];


$dbTotalRecords = $db->getKeysBy('ID ASC', '',$where);

# test za LIMIT - trebalo bi ga iskoristiti za pagination! 'asc' . ' LIMIT 0,50'
$dbk = $db->getKeysBy('ID ' , '' , $where);

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

