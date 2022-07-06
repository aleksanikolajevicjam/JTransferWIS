<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once '../config.php';

@session_start();
require_once ROOT .'/db/v4_AuthUsers.class.php';
require_once ROOT .'/db/v4_AuthLevels.class.php';

# init class
$au = new v4_AuthUsers();
$al = new v4_AuthLevels();
$ddb = new DataBaseMySql();


#********************************************
# ulazni parametri su where, status i search
#********************************************

# sastavi filter prema statusima
if (!isset($_REQUEST['UserLevel']) or $_REQUEST['UserLevel'] == 0) {
	$filter = "  AND AuthLevelID < 100 "; 
}
else {
	$filter = "  AND AuthLevelID = '" . $_REQUEST['UserLevel'] . "'"; 
}

# sastavi filter prema Active
if (isset($_REQUEST['active']) and $_REQUEST['active'] == 1) {
	$filter .= "  AND Active = '1' "; 
}
else if (isset($_REQUEST['active']) and $_REQUEST['active'] == 0) {
	$filter .= "  AND Active = '0' "; 
}
else if (isset($_REQUEST['active']) and $_REQUEST['active'] == '99') {
	$filter .= "  AND ( Active = '0' OR Active = '1') "; 
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
$auWhere = " " . $_REQUEST['where'];
//$auWhere = " WHERE DetailsID > '3300' ";
$auWhere .= $filter;

#********************************
# kolone za koje je moguc Search 
# treba ih samo nabrojati ovdje
# Search ce ih sam pretraziti
#********************************
$aColumns = array(
	'AuthUserID',
	'AuthUserName',
	'DriverID',
	'AuthUserRealName',
	'AuthUserCompany',
	'AuthUserMail',
	'Terminal'
);


# dodavanje search parametra u qry
# auWhere sad ima sve potrebno za qry
if ( $_REQUEST['Search'] != "" )
{
	$auWhere .= " AND (";

	for ( $i=0 ; $i< count($aColumns) ; $i++ )
	{
		# If column name exists
		if ($aColumns[$i] != " ")
		$auWhere .= $aColumns[$i]." LIKE '%"
		.$au->myreal_escape_string( $_REQUEST['Search'] )."%' OR ";
	}
	$auWhere = substr_replace( $auWhere, "", -3 );
	$auWhere .= ')';
}






$auTotalRecords = $au->getKeysBy('AuthLevelID ASC, AuthUserID ASC', '',$auWhere);

# test za LIMIT - trebalo bi ga iskoristiti za pagination! 'asc' . ' LIMIT 0,50'
$auk = $au->getKeysBy('AuthLevelID ' . $sortOrder.', AuthUserID '. $sortOrder, '' . $limit , $auWhere);

if (count($auk) != 0) {
   
    foreach ($auk as $nn => $key)
    {
    	
    	$au->getRow($key);

		# levels row
		$al->getRow($au->getAuthLevelID());

		# get fields and values
		$detailFlds = $au->fieldValues();
		$detailFlds["AuthLevelName"] = $al->getAuthLevelName();
		$detailFlds["DBImage"] = '';
		
		
		
		if($au->getAuthLevelID() == '32') {
		
	        $driverId = $au->getAuthUserID();
	        $qd  = "SELECT SUM(CashIn) AS Primljeno FROM v4_OrderDetails ";
	        $qd .= "WHERE (SubDriver = '" . $driverId ."' ";
	        $qd .= "OR SubDriver2 = '" . $driverId ."' ";
	        $qd .= "OR SubDriver3 = '" . $driverId ."') ";
	        $qd .= "AND PickupDate >= '2018-08-01'";

	
	        $w = $ddb->RunQuery($qd);
	
	        $p = $w->fetch_object();
	        $detailFlds['CashIn'] = $p->Primljeno;	
	        
	        
	        $qt  = "SELECT SUM(Amount) AS Trosak FROM v4_SubExpenses WHERE Card = 0 ";
	        $qt .= "AND DriverID = '" . $driverId ."' ";
			$qt .= "AND Approved < 9 ";	
	        $qt .= "AND Datum >= '2018-08-01'";


	
	        $wt = $ddb->RunQuery($qt);
	
	        $t = $wt->fetch_object();
	        $detailFlds['Expenses'] = $t->Trosak; 
	        $detailFlds['Balance'] = $p->Primljeno - $t->Trosak;  		
		}
		
		
		
		

		$out[] = $detailFlds;    	

		
    }
}
//echo '<pre>'; print_r($out); echo '</pre>';

# send output back
$output = array(
'recordsTotal' => count($auTotalRecords),
'data' =>$out
);
//print_r($output);
echo $_GET['callback'] . '(' . json_encode($output) . ')';

