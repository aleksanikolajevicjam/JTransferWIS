<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once ROOT . '/db/v4_DriverRoutes.class.php';
	require_once ROOT . '/db/v4_Routes.class.php';

	require_once ROOT . '/cms/fixDriverID.php';
	foreach($fakeDrivers as $key => $fakeDriverID) {
		if($_REQUEST['OwnerID'] == $fakeDriverID) $_REQUEST['OwnerID'] = $realDrivers[$key];    
	}

	# init class
	$db = new v4_DriverRoutes();
	$db2 = new v4_Routes();
	
	# init vars
	$new = false;

	$dbk = $db->getKeysBy('RouteID','asc','WHERE RouteID='.$_REQUEST['RouteID'].' AND OwnerID='.$_REQUEST['OwnerID']);
	
	if(count($dbk) == 1) $new = false;
	else $new = true;

$fldList = array();
$out = array();


# if Update - get the row by keyValue
if (!$new) {
	$db->getRow($dbk[0]);
	$db2->getRow($_REQUEST['RouteID']);
}	

/* BEFORE
	if(isset($_REQUEST['ID'])) { $db->setID($db->myreal_escape_string($_REQUEST['ID']) ); } 

		 	
	if(isset($_REQUEST['SiteID'])) { $db->setSiteID($db->myreal_escape_string($_REQUEST['SiteID']) ); } 

		 	
	if(isset($_REQUEST['OwnerID'])) { $db->setOwnerID($db->myreal_escape_string($_REQUEST['OwnerID']) ); } 

		 	
	if(isset($_REQUEST['RouteID'])) { $db->setRouteID($db->myreal_escape_string($_REQUEST['RouteID']) ); } 

		 	
	if(isset($_REQUEST['Active'])) { $db->setActive($db->myreal_escape_string($_REQUEST['Active']) ); } 

		 	
	if(isset($_REQUEST['Approved'])) { $db->setApproved($db->myreal_escape_string($_REQUEST['Approved']) ); } 

		 	
	if(isset($_REQUEST['RouteID'])) { $db->setRouteName($db->myreal_escape_string(getRouteName($_REQUEST['RouteID'])) ); } 

		 	
	if(isset($_REQUEST['OneToTwo'])) { $db->setOneToTwo($db->myreal_escape_string($_REQUEST['OneToTwo']) ); } 

		 	
	if(isset($_REQUEST['TwoToOne'])) { $db->setTwoToOne($db->myreal_escape_string($_REQUEST['TwoToOne']) ); } 

		 	
	if(isset($_REQUEST['SurCategory'])) { $db->setSurCategory($db->myreal_escape_string($_REQUEST['SurCategory']) ); } 

		 	
	if(isset($_REQUEST['SurID'])) { $db->setSurID($db->myreal_escape_string($_REQUEST['SurID']) ); } 
*/


	if(isset($_REQUEST['ID'])) { $db->setID($db->myreal_escape_string($_REQUEST['ID']) ); } 

		 	
	if(isset($_REQUEST['SiteID'])) { $db->setSiteID($db->myreal_escape_string($_REQUEST['SiteID']) ); } 

		 	
	if(isset($_REQUEST['OwnerID'])) { $db->setOwnerID($db->myreal_escape_string($_REQUEST['OwnerID']) ); } 

		 	
	if(isset($_REQUEST['RouteID'])) { $db->setRouteID($db->myreal_escape_string($_REQUEST['RouteID']) ); } 

		 	
	if(isset($_REQUEST['Active'])) { $db->setActive($db->myreal_escape_string($_REQUEST['Active']) ); } 

		 	
	if(isset($_REQUEST['Approved'])) { $db->setApproved($db->myreal_escape_string($_REQUEST['Approved']) ); } 
	
	
	if(isset($_REQUEST['Km'])) { $db2->setKm($db2->myreal_escape_string($_REQUEST['Km']) ); } 
	
	
	if(isset($_REQUEST['Duration'])) { $db2->setDuration($db->myreal_escape_string($_REQUEST['Duration']) ); } 

		 	
	if(isset($_REQUEST['RouteName'])) { $db->setRouteName($db->myreal_escape_string($_REQUEST['RouteName']) ); 
										 $db->setRouteNameEN($db->myreal_escape_string($_REQUEST['RouteName']) ); } 

// fix
if(!$new and $db->getRouteName() != '') $db->setRouteNameEN($db->getRouteName());
		 	
	if(isset($_REQUEST['RouteNameRU'])) { $db->setRouteNameRU($db->myreal_escape_string($_REQUEST['RouteNameRU']) ); } 

	if(isset($_REQUEST['RouteNameEN'])) { $db->setRouteNameRU($db->myreal_escape_string($_REQUEST['RouteNameEN']) ); } 
		 	
	if(isset($_REQUEST['RouteNameFR'])) { $db->setRouteNameFR($db->myreal_escape_string($_REQUEST['RouteNameFR']) ); } 

		 	
	if(isset($_REQUEST['RouteNameDE'])) { $db->setRouteNameDE($db->myreal_escape_string($_REQUEST['RouteNameDE']) ); } 

		 	
	if(isset($_REQUEST['RouteNameIT'])) { $db->setRouteNameIT($db->myreal_escape_string($_REQUEST['RouteNameIT']) ); } 

		 	
	if(isset($_REQUEST['RouteNameSE'])) { $db->setRouteNameSE($db->myreal_escape_string($_REQUEST['RouteNameSE']) ); } 

		 	
	if(isset($_REQUEST['RouteNameNO'])) { $db->setRouteNameNO($db->myreal_escape_string($_REQUEST['RouteNameNO']) ); } 

		 	
	if(isset($_REQUEST['RouteNameES'])) { $db->setRouteNameES($db->myreal_escape_string($_REQUEST['RouteNameES']) ); } 

		 	
	if(isset($_REQUEST['RouteNameNL'])) { $db->setRouteNameNL($db->myreal_escape_string($_REQUEST['RouteNameNL']) ); } 

		 	
	if(isset($_REQUEST['OneToTwo'])) { $db->setOneToTwo($db->myreal_escape_string($_REQUEST['OneToTwo']) ); } 

		 	
	if(isset($_REQUEST['TwoToOne'])) { $db->setTwoToOne($db->myreal_escape_string($_REQUEST['TwoToOne']) ); } 

		 	
	if(isset($_REQUEST['SurCategory'])) { $db->setSurCategory($db->myreal_escape_string($_REQUEST['SurCategory']) ); } 

		 	
	if(isset($_REQUEST['SurID'])) { $db->setSurID($db->myreal_escape_string($_REQUEST['SurID']) ); } 
		 	

$upd = '';
$newID = '';

// ako je update, azuriraj trazeni slog

if (!$new) {
	$res = $db->saveRow();
	$res2 = $db2->saveRow();
	$upd = 'Updated';
	if($res !== true) $upd = $res;
}

// inace dodaj novi slog	
if ($new) {
	$newID = $db->saveAsNew();
}


$out = array(
	'update' => $upd,
	'insert' => $newID
);

# send output back
$output = json_encode($out);
echo $_REQUEST['callback'] . '(' . $output . ')';


function getRouteName($id, $lang='EN') {
	require_once ROOT . '/db/db.class.php';
	$db = new DataBaseMysql();
	$q = "SELECT * FROM v4_Routes WHERE RouteID = '" . $id . "'";
	$w = $db->RunQuery($q);	
	$r = $w->fetch_object();
	$RouteName = 'RouteName'.$lang;
	return $r->$RouteName;
}


	
