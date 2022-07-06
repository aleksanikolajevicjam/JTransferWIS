<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
@session_start();

# init libs
require_once '../../../../db/db.class.php';
require_once '../../../../db/v4_OrderLog.class.php';

class v4_OrderLogJoin extends v4_OrderLog {
	public function getKeysBy($column, $order, $where = NULL){
		$keys = array(); $i = 0;

		$query = "SELECT MAX(ID) as ID, DetailsID, DateAdded as datum, TimeAdded as vrime ";
		$query .= "FROM v4_OrderLog WHERE ID > 0 GROUP BY DetailsID ORDER BY datum DESC, vrime $order";

		$result = $this->connection->RunQuery($query);
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$keys[$i] = $row["ID"];
			$i++;
		}

		return $keys;
	}
}

# init class
$db = new v4_OrderLogJoin();

#********************************************
# ulazni parametri su where, status i search
#********************************************

# sastavi filter - posalji ga $_REQUEST-om

$page 		= $_REQUEST['page'];
$length 	= $_REQUEST['length'];
$sortOrder 	= $_REQUEST['sortOrder'];

$start = ($page * $length) - $length;

if ($length > 0) {
	$limit = ' LIMIT ' . $start . ',' . $length;
}
else $limit = '';

if (empty($sortOrder)) $sortOrder = 'DESC';

# init vars
$out = array();
$flds = array();

# kombinacija where i filtera
$DB_Where = " " . $_REQUEST['where'];
$DB_Where .= $filter;

#********************************
# kolone za koje je moguc Search 
# treba ih samo nabrojati ovdje
# Search ce ih sam pretraziti
#********************************
$aColumns = array(
	'ID',
	'v4_OrderLog.OrderID',
	'v4_OrderLog.DateAdded',
	'v4_OrderDetails.PaxName'
);

# dodavanje search parametra u qry
# DB_Where sad ima sve potrebno za qry
if ( $_REQUEST['Search'] != "" ) {
	$DB_Where .= " AND (";

	for ($i=0; $i< count($aColumns); $i++ ) {
		# If column name exists
		if ($aColumns[$i] != " ") {
			$DB_Where .= $aColumns[$i]." LIKE '%"
			.$db->myreal_escape_string( $_REQUEST['Search'] )."%' OR ";
		}
	}
	$DB_Where = substr_replace( $DB_Where, "", -3 );
	$DB_Where .= ')';
}
$DB_Where .= " GROUP BY v4_OrderLog.DetailsID ";

$dbTotalRecords = $db->getKeysBy('ID', 'DESC', $DB_Where);
# test za LIMIT - trebalo bi ga iskoristiti za pagination! 'asc' . ' LIMIT 0,50'
$dbk = $db->getKeysBy('DateAdded DESC, TimeAdded ' , 'DESC' . $limit , $DB_Where);

if (count($dbk) != 0) {
    foreach ($dbk as $nn => $key) {
		$q = " SELECT ";
		$q .= "v4_OrderLog.ID,";
		$q .= "v4_OrderLog.OrderID,";
		$q .= "v4_OrderLog.DetailsID,";
		$q .= "v4_OrderLog.UserID AS osoba,";
		$q .= "v4_OrderLog.Icon,";
		$q .= "v4_OrderLog.Action,";
		$q .= "v4_OrderLog.Title,";
		$q .= "v4_OrderLog.DateAdded AS datum,";
		$q .= "v4_OrderLog.TimeAdded,";

		$q .= "v4_OrderDetails.PaxName,";
		$q .= "v4_OrderDetails.TNo,";
		$q .= "v4_OrderDetails.PickupName,";
		$q .= "v4_OrderDetails.DropName,";
		$q .= "v4_OrderDetails.PickupDate,";
		$q .= "v4_OrderDetails.PickupTime,";
		$q .= "v4_OrderDetails.DetailPrice,";
		$q .= "v4_OrderDetails.ExtraCharge,";
		$q .= "v4_OrderDetails.TransferStatus,";

		$q .= "v4_AuthUsers.AuthUserRealName ";

		$q .= "FROM ((v4_OrderLog ";
		$q .= "INNER JOIN v4_OrderDetails ON v4_OrderLog.DetailsID = v4_OrderDetails.DetailsID) ";
		$q .= "LEFT JOIN v4_AuthUsers ON v4_OrderLog.UserID = v4_AuthUsers.AuthUserID) WHERE ID = {$key}";

		$result = $db->connection->RunQuery($q);
		if ($result->num_rows < 1) return false;

		$row = $result->fetch_array(MYSQLI_ASSOC);

		$db->ID				= $row["ID"];
		$db->ShowToCustomer	= $row["ShowToCustomer"];
		$db->OrderID		= $row["OrderID"];
		$db->DetailsID		= $row["DetailsID"];
		$db->UserID			= $row["osoba"];
		$db->Icon			= $row["Icon"];
		$db->Action			= $row["Action"];
		$db->Title			= $row["Title"];
		$db->Description	= $row["Description"];
		$db->DateAdded		= $row["datum"];			// krsi se sa v4_AuthUsers.DateAdded
		$db->TimeAdded		= $row["TimeAdded"];

		// ako treba neki lookup, onda to ovdje
		
		# get all fields and values
		$detailFlds = $db->fieldValues();
		
		// ako postoji neko custom polje, onda to ovdje.
		// npr. $detailFlds["AuthLevelName"] = $nekaDrugaDB->getAuthLevelName().' nesto';
		$detailFlds["PaxName"]			= $row["PaxName"];
		$detailFlds["TNo"]				= $row["TNo"];
		$detailFlds["PickupName"]		= $row["PickupName"];
		$detailFlds["DropName"]			= $row["DropName"];
		$detailFlds["PickupDate"]		= $row["PickupDate"];
		$detailFlds["PickupTime"]		= $row["PickupTime"];
		$detailFlds["DetailPrice"]		= $row["DetailPrice"];
		$detailFlds["ExtraCharge"]		= $row["ExtraCharge"];
		$detailFlds["TransferStatus"]	= $row["TransferStatus"];
		$detailFlds["AuthUserRealName"]	= $row["AuthUserRealName"];
		
		$out[] = $detailFlds;
    }
}

# send output back
$output = array(
	'recordsTotal'	=> count($dbTotalRecords),
	'data'			=> $out
);

echo $_GET['callback'] . '(' . json_encode($output) . ')';

