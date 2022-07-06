<?
session_start();
error_reporting(E_PARSE);

require_once '../db/db.class.php';
$db = new DataBaseMysql();

require_once '../f/f.php';


$allPlaces = array();

# save variables for later usage
#$_SESSION['countryID'] = array_search(str_replace('_',' ',$_SESSION['lastElement']), $_SESSION['countries']);
#$cID = $_SESSION['countryID'];
#$_SESSION['countryName'] = $_SESSION['countries'][$cID];
//unset($_SESSION['countries']);
//echo '<pre>'; print_r($_SESSION); echo '</pre>';


// Get from Cache
$filename = '../cache/allPlaces.json';
$cachetime = 84600;

if (file_exists($filename) && time() - $cachetime < filemtime($filename)) {

	$handle = fopen($filename, "r");
	$contents = fread($handle, filesize($filename));
	fclose($handle);
	
	$noBrackets = str_replace('(','',$contents);
	$contents = str_replace(')','',$noBrackets);
	$jsonArray = json_decode($contents, true);

	unset($_SESSION['allPlaces']);
	foreach ($jsonArray as $key => $value)
	{
		$_SESSION['allPlaces'][$key] = $value;
	}
	
	$rewriteCache = false;
}
//*******************

else {
	# Places in the Country
	$q  = "SELECT * FROM v4_Places ";
	$q .= " ORDER BY PlaceType ASC, PlaceNameEN ASC";

	$w = $db->RunQuery($q);

	while($p = mysqli_fetch_object($w))
	{
		# Routes for selected place
		$q1 = "SELECT FromID, ToID, RouteID FROM v4_Routes
					WHERE FromID = '{$p->PlaceID}'
					OR    ToID   = '{$p->PlaceID}'
					";
		$r1 = $db->RunQuery($q1);
	

		while($r = mysqli_fetch_object($r1))
		{
		
			# DriverRoutes - check if anyone drives from that Place
			$q2 = "SELECT DISTINCT RouteID FROM v4_DriverRoutes
						WHERE RouteID = '{$r->RouteID}' 
						";
			$w2 = $db->RunQuery($q2);
		
			# If does
			if  (mysqli_num_rows($w2) > 0)
			{
			
				# Add Place to array
				if (!in_array($p->PlaceNameEN.'|'.$p->PlaceNameSEO, $allPlaces)) {
					$allPlaces[$p->PlaceID] = trim($p->PlaceNameEN) . '|' . trim($p->PlaceNameSEO);
				}
			}					
		}
	

	}

	//asort($allPlaces);
	unset($_SESSION['allPlaces']);
	
	$_SESSION['allPlaces'] = $allPlaces;
	$rewriteCache = true;
}


$res = array();

foreach ($_SESSION['allPlaces'] as $key => $value)
{
	# code...
	$names = array();
	$names = explode("|", $value);
	
    $res[] = array(
    	'id'	=> $key,
  		'val'	=> $names[0],
  		'seo' 	=> $names[1]
	);
}

$res = json_encode($res);
ob_start();
echo $_GET['callback'] . '(' . $res. ')';
ob_end_flush();

if ($rewriteCache) {
	// Save to Cache	
	$jsonFromPlaces = json_encode($_SESSION['allPlaces']);
	$filename = '../cache/allPlaces.json';
	$handle = fopen($filename, "w");
	$contents = fwrite($handle, $jsonFromPlaces);
	fclose($handle);
	// ************
}	
