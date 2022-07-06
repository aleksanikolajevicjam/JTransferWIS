<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);

@session_start();
define("ROOT", ROOT);
# init libs
require_once ROOT . '/f/f.php';

require_once ROOT . '/db/db.class.php';
require_once ROOT . '/db/v4_Services.class.php';
require_once ROOT . '/db/v4_Routes.class.php';
require_once ROOT . '/db/v4_Vehicles.class.php';
require_once ROOT . '/db/v4_SurGlobal.class.php';


class v4_ServicesJoin extends v4_Services {
	public function getServicesByRouteName($column, $order, $where = NULL) {
		$keys = array(); $i = 0;
		$result = $this->connection->RunQuery("
			SELECT v4_Services.ServiceID FROM v4_Services 
			LEFT JOIN v4_Routes ON v4_Services.RouteID = v4_Routes.RouteID 
			$where ORDER BY $column $order");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$keys[$i] = $row["ServiceID"];
				$i++;
			}
	return $keys;
	}
}

# init class
$s = new v4_ServicesJoin();
$r  = new v4_Routes();
$v  = new v4_Vehicles();

// Surcharges
$sg	= new v4_SurGlobal();


#********************************************
# ulazni parametri su where, status i search
#********************************************

# sastavi filter - posalji ga $_REQUEST-om
require_once ROOT . '/cms/fixDriverID.php';
foreach($fakeDrivers as $key => $fakeDriverID) {
    if($_REQUEST['OwnerID'] == $fakeDriverID) $_REQUEST['OwnerID'] = $realDrivers[$key];    
}

$page 		= $_REQUEST['page'];
$length 	= $_REQUEST['length'];
$sortOrder 	= $_REQUEST['sortOrder'];
$OwnerID	= $_REQUEST['OwnerID'];

$detailFlds = array();


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
$s_Where = " " . $_REQUEST['where'];

//$s_Where .= " AND v4_Services.ServicePrice1 > 0 ";

if(!empty($OwnerID)) $s_Where .= " AND v4_Services.OwnerID = " . $OwnerID; 

$s_Where .= $filter;

#********************************
# kolone za koje je moguc Search 
# treba ih samo nabrojati ovdje
# Search ce ih sam pretraziti
#********************************
$aColumns = array(
	'v4_Services.ServiceID', // dodaj ostala polja!
	'v4_Services.OwnerID',
	'v4_Routes.RouteName'
);


# dodavanje search parametra u qry
# DB_Where sad ima sve potrebno za qry
if ( $_REQUEST['Search'] != "" )
{
	$s_Where .= " AND (";

	for ( $i=0 ; $i< count($aColumns) ; $i++ )
	{
		# If column name exists
		if ($aColumns[$i] != " ")
		$s_Where .= $aColumns[$i]." LIKE '%"
		. $_REQUEST['Search'] ."%' OR ";
	}
	$s_Where = substr_replace( $s_Where, "", -3 );
	$s_Where .= ')';
}







$sTotalRecords = $s->getServicesByRouteName('v4_Routes.RouteName ' . $sortOrder, '', $s_Where);

# test za LIMIT - trebalo bi ga iskoristiti za pagination! 'asc' . ' LIMIT 0,50'
$sk = $s->getServicesByRouteName('v4_Routes.RouteName ' . $sortOrder . ', v4_Services.VehicleTypeID ASC', '' . $limit , $s_Where);

if (count($sk) != 0) {
   
    // Services
    foreach ($sk as $nn => $key)
    {
    	
    	$s->getRow($key);

		# get all fields and values
		$detailFlds = $s->fieldValues();

    	$r->getRow( $s->getRouteID() );
    	$v->getRow( $s->getVehicleID() );
    	
    	// SurGlobal
    	if($s->getSurCategory() == '1') {
    		$sgk = $sg->getKeysBy('OwnerID', 'asc', ' WHERE OwnerID = ' . $s->getOwnerID());
    		
    		$sg->getRow($sgk[0]); // moze biti samo jedan
    		
    		// provjera
    		if($sg->getOwnerID() == $s->getOwnerID()) {
    			
    			$sp1 = $s->getServicePrice1();
    			
    			// kalkulacija cijena

				$detailFlds['NightPrice'] = calcSurcharge($sp1, $sg->getNightPercent(), $sg->getNightAmount() );
				//$detailFlds['WeekendPrice'] = calcSurcharge($sp1,$sg->getWeekendPercent(),$sg->getWeekendAmount());
				$detailFlds['MonPrice'] = calcSurcharge($sp1, $sg->getMonPercent(), $sg->getMonAmount() );
				$detailFlds['TuePrice'] = calcSurcharge($sp1, $sg->getTuePercent(), $sg->getTueAmount() );
				$detailFlds['WedPrice'] = calcSurcharge($sp1, $sg->getWedPercent(), $sg->getWedAmount() );
				$detailFlds['ThuPrice'] = calcSurcharge($sp1, $sg->getThuPercent(), $sg->getThuAmount() );
				$detailFlds['FriPrice'] = calcSurcharge($sp1, $sg->getFriPercent(), $sg->getFriAmount() );
				$detailFlds['SatPrice'] = calcSurcharge($sp1, $sg->getSatPercent(), $sg->getSatAmount() );
				$detailFlds['SunPrice'] = calcSurcharge($sp1, $sg->getSunPercent(), $sg->getSunAmount() );
				$detailFlds['S1Price']  = calcSurcharge($sp1, $sg->getS1Percent(), 0 );
				$detailFlds['S2Price']  = calcSurcharge($sp1, $sg->getS2Percent(), 0 );
				$detailFlds['S3Price']  = calcSurcharge($sp1, $sg->getS3Percent(), 0 );
				$detailFlds['S4Price']  = calcSurcharge($sp1, $sg->getS4Percent(), 0 );

    		}
    	}
		
		// ako treba neki lookup, onda to ovdje
		

		// ako postoji neko custom polje, onda to ovdje.
		// npr. $detailFlds["AuthLevelName"] = $nekaDrugaDB->getAuthLevelName().' nesto';		
		$detailFlds['RouteName'] = $r->getRouteName();
		$detailFlds['VehicleName'] = $v->getVehicleName();
		$detailFlds['VehicleCapacity'] = $v->getVehicleCapacity();
		//$detailFlds['BasePrice'] = round($v->getPriceKM() * $r->getKm() + $s->getCorrection(),0);
		//$detailFlds['ServicePrice1'] = round($v->getPriceKM() * $r->getKm() + $s->getCorrection(),0);
		$detailFlds['ServicePrice1'] = $s->getServicePrice1();
		
		
		
		$out[] = $detailFlds;    	

		
    }
}

//$out = subval_sort($out,'RouteName');

# send output back
$output = array(
'recordsTotal' => count($sTotalRecords),
'data' =>$out
);

echo $_GET['callback'] . '(' . json_encode($output) . ')';
	
