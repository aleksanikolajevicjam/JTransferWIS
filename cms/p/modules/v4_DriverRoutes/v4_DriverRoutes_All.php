<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);

@session_start();
# init libs
require_once ROOT . '/db/db.class.php';
require_once ROOT . '/db/v4_DriverRoutes.class.php';
require_once ROOT . '/db/v4_AuthUsers.class.php';

# init class
$db = new v4_DriverRoutes();
$au = new v4_AuthUsers();

#********************************************
# ulazni parametri su where, status i search
#********************************************

# sastavi filter - posalji ga $_REQUEST-om


$page 		= $_REQUEST['page'];
$length 	= $_REQUEST['length'];
$sortOrder 	= $_REQUEST['sortOrder'];
$OwnerID	= $_REQUEST['ownerId'];

require_once ROOT . '/cms/fixDriverID.php';
foreach($fakeDrivers as $key => $fakeDriverID) {
    if($OwnerID == $fakeDriverID) $OwnerID = $realDrivers[$key];    
}

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
if(!empty($OwnerID)) $DB_Where .= " AND OwnerID = " . $OwnerID; 

$DB_Where .= $filter;

#********************************
# kolone za koje je moguc Search 
# treba ih samo nabrojati ovdje
# Search ce ih sam pretraziti
#********************************
$aColumns = array(
	'ID', // dodaj ostala polja!
	'RouteName'
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






$dbTotalRecords = $db->getKeysBy('ID ASC', '',$DB_Where);

# test za LIMIT - trebalo bi ga iskoristiti za pagination! 'asc' . ' LIMIT 0,50'
$dbk = $db->getKeysBy('RouteName ' . $sortOrder, '' . $limit , $DB_Where);

if (count($dbk) != 0) {
   
    foreach ($dbk as $nn => $key)
    {
    	
    	$db->getRow($key);
    	
	
		// ako treba neki lookup, onda to ovdje
		
		# get all fields and values
		$detailFlds = $db->fieldValues();

    	$au->getRow($db->getOwnerID());
    	if ($au->getAuthUserID() == $db->getOwnerID()) {
    		$DriverName = $au->getAuthUserCompany();
			$detailFlds["DriverName"] = $DriverName;
		}
		
		$out[] = $detailFlds;    	

		
    }
}


# send output back
$output = array(
'recordsTotal' => count($dbTotalRecords),
'data' =>$out
);

echo $_GET['callback'] . '(' . json_encode($output) . ')';
	
