<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);

@session_start();
# init libs
require_once '../../../../db/db.class.php';
require_once '../../../../db/v4_SubExpenses.class.php';
require_once '../../../../db/v4_AuthUsers.class.php';
require_once '../../../../db/v4_Actions.class.php';
# init class
$db = new v4_SubExpenses();
$ac = new v4_Actions();

class v4_SubExpensesJoin extends v4_SubExpenses {
	public function getKeysBy($column, $order, $where = NULL){
		$keys = array(); $i = 0;
		$result = $this->connection->RunQuery("
			SELECT v4_SubExpenses.ID, v4_AuthUsers.AuthUserRealName FROM v4_SubExpenses 
			LEFT JOIN v4_AuthUsers ON v4_SubExpenses.DriverID = v4_AuthUsers.AuthUserID 
			$where AND v4_SubExpenses.Approved<9 ORDER BY $column $order");
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			$keys[$i] = $row["ID"];
			$i++;
		}
	return $keys;
	}
}

# init class
$se = new v4_SubExpensesJoin();
$au = new v4_AuthUsers();

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
$DB_Where = " " . $_REQUEST['where'];
$DB_Where .= $filter;

#********************************
# kolone za koje je moguc Search 
# treba ih samo nabrojati ovdje
# Search ce ih sam pretraziti
#********************************
$aColumns = array(
	'ID',
	'AuthUserRealName',
	'Expense',
    'Note',
    'Datum'
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



// 2017-02-13 za pretrazivanje po imenu vozaca potrebno je napraviti join -R
$DB_Where = "LEFT JOIN v4_AuthUsers ON v4_SubExpenses.DriverID = v4_AuthUsers.AuthUserID" . $DB_Where;

$dbTotalRecords = $db->getKeysBy('ID ASC', '',$DB_Where);

# test za LIMIT - trebalo bi ga iskoristiti za pagination! 'asc' . ' LIMIT 0,50'
$dbk = $db->getKeysBy('ID ' . $sortOrder, '' . $limit , $DB_Where);

if (count($dbk) != 0) {
    foreach ($dbk as $nn => $key)  
    {	
    	$db->getRow($key);
	   	$au->getRow($db->getDriverID());

		// ako treba neki lookup, onda to ovdje
		
		# get all fields and values
		$detailFlds = $db->fieldValues();
		
		// ako postoji neko custom polje, onda to ovdje.
		// npr. $detailFlds["AuthLevelName"] = $nekaDrugaDB->getAuthLevelName().' nesto';
		$detailFlds["AuthUserRealName"] = $au->getAuthUserRealName();
		$ac->getRow($db->getExpense());
		$detailFlds["ExpanceTitle"] = $ac->getTitle();
		
		$out[] = $detailFlds;
    }
}

# send output back
$output = array(
'recordsTotal' => count($dbTotalRecords),
'data' =>$out
);

echo $_GET['callback'] . '(' . json_encode($output) . ')';

