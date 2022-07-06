<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);

@session_start();
# init libs
require_once ROOT . '/db/db.class.php';
require_once ROOT . '/db/v4_Places.class.php';

# init class
$db = new v4_Places();

#********************************************
# ulazni parametri su where, status i search
#********************************************

# sastavi filter - posalji ga $_REQUEST-om
# sastavi filter prema statusima
if (!isset($_REQUEST['PlaceType']) or $_REQUEST['PlaceType'] == 0) {
	$filter = "  AND (PlaceType = 1 OR PlaceType = 3 OR PlaceType = 8 OR PlaceType = 9 OR PlaceType = 12) ";
}
else {
	$filter = "  AND PlaceType = '" . $_REQUEST['PlaceType'] . "'";
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

#********************************
# kolone za koje je moguc Search
# treba ih samo nabrojati ovdje
# Search ce ih sam pretraziti
#********************************
$aColumns = array(
	'PlaceID', // dodaj ostala polja!
	'PlaceNameEN',
	'PlaceNameSEO'
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







$dbTotalRecords = $db->getKeysBy('PlaceNameEN ' . $sortOrder.', PlaceType '. $sortOrder, '',$DB_Where);

# test za LIMIT - trebalo bi ga iskoristiti za pagination! 'asc' . ' LIMIT 0,50'
$dbk = $db->getKeysBy('PlaceNameEN ' . $sortOrder.', PlaceType '. $sortOrder, '' . $limit , $DB_Where);

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
