<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);

@session_start();
# init libs
require_once '../../db/db.class.php';
require_once '../../db/v4_Countries.class.php';


#********************************************
# ulazni parametri su where, status i search
#********************************************

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
$coWhere = " " . $_REQUEST['where'];
//$coWhere = " WHERE DetailsID > '3300' ";
$coWhere .= $filter;

#********************************
# kolone za koje je moguc Search 
# treba ih samo nabrojati ovdje
# Search ce ih sam pretraziti
#********************************
$aColumns = array(
	'CountryID',
	'CountryName',
	'CountryNameRU'
);


# dodavanje search parametra u qry
# auWhere sad ima sve potrebno za qry
if ( $_REQUEST['Search'] != "" )
{
	$coWhere .= " AND (";

	for ( $i=0 ; $i< count($aColumns) ; $i++ )
	{
		# If column name exists
		if ($aColumns[$i] != " ")
		$coWhere .= $aColumns[$i]." LIKE '%"
		.mysql_real_escape_string( $_REQUEST['Search'] )."%' OR ";
	}
	$coWhere = substr_replace( $coWhere, "", -3 );
	$coWhere .= ')';
}




# init class
$co = new v4_Countries();


$coTotalRecords = $co->getKeysBy('CountryName', 'asc',$coWhere);

# test za LIMIT - trebalo bi ga iskoristiti za pagination! 'asc' . ' LIMIT 0,50'
$cok = $co->getKeysBy('CountryName ' . $sortOrder, '' . $limit , $coWhere);

if (count($cok) != 0) {
   
    foreach ($cok as $nn => $key)
    {
    	
    	$co->getRow($key);

		# levels row
		$co->getRow($co->getCountryID());

		# get fields and values
		$detailFlds = $co->fieldValues();
		$out[] = $detailFlds;    	

		
    }
}
//echo '<pre>'; print_r($out); echo '</pre>';

# send output back
$output = array(
'recordsTotal' => count($coTotalRecords),
'data' =>$out
);
//print_r($output);
echo $_GET['callback'] . '(' . json_encode($output) . ')';

