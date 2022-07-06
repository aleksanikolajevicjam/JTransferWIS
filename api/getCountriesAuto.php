<?
session_start();
error_reporting(E_PARSE);


	require_once '../db/db.class.php';
	
	
	$db = new DataBaseMysql();


	$countries = array();

	# Find all routes that have drivers
	$q = "SELECT DISTINCT RouteID FROM v4_DriverRoutes";

	$w = $db->RunQuery($q);



	while($d = mysqli_fetch_object($w))
	{
	
		# find starting and ending points for each Route
		$q1 = "SELECT FromID, ToID FROM v4_Routes
					WHERE RouteID = '{$d->RouteID}'
					";
		$r1 = $db->RunQuery($q1) or die(mysql_error());
	
		while($r = mysqli_fetch_object($r1))
		{

			# Get Place Country id's
			$q2 = "SELECT * FROM v4_Places
						WHERE PlaceID = '{$r->FromID}' 
						OR PlaceID = '{$r->ToID}'
						";
			$w2 = $db->RunQuery($q2) or die(mysql_error());
		
			while ($p = mysqli_fetch_object($w2))
			{
				# Get Country Names
				$q3 = "SELECT * FROM v4_Countries
							WHERE CountryID = '{$p->PlaceCountry}'
							";
				$r3 = $db->RunQuery($q3) or die(mysql_error());
			
				$c = mysqli_fetch_object($r3);
			
		        # Check for duplicates and add to array	
		        if (!empty($c->CountryName)) {
					if (!in_array($c->CountryName,$countries))
					{ 
						$countries[$c->CountryID] = $c->CountryName;
					}
				}
			}					
		}
	

	}

	# Sort by name
	asort($countries);

	$_SESSION['countries'] = $countries;
	
	unset($countries);
	$rewriteCache = true;


$res = array();


foreach ($_SESSION['countries'] as $key => $value)
{
	# code...
	            $res[] = array(
                'data'=>$key,
              	'value'=>$value
            	);
}

$res = json_encode($res);
ob_start();
//echo $_GET['callback'] . '(' . $res. ')';
echo json_encode($_SESSION['countries']);

ob_end_flush();



