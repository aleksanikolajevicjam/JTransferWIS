<!DOCTYPE HTML>

<head>
		<script src="https://code.jquery.com/jquery-2.0.2.js"></script>
		<script src="../js/jquery/ui/1.10.3/jquery-ui.min.js" type="text/javascript"></script>
</head>	
    <script type = "text/javascript">
	  		geolocation();


		 
		function geolocation () {
			if(navigator.geolocation){
				navigator.geolocation.getCurrentPosition(
					function(position) {
						var lat = position.coords.latitude;
						var lng = position.coords.longitude;
					}
				)			
			}
		}		 
    </script>
<?
	session_start();
	require_once '../../db/db.class.php';
	$arr=(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['HTTP_X_FORWARDED_FOR'])));
	$lat2=$arr['geoplugin_latitude'];
	$lng2=$arr['geoplugin_longitude'];	
	if (isset($_SESSION['AuthUserID'])) $userID=$_SESSION['AuthUserID'];
	else $userID=0;	
	if (!isset($_REQUEST['lat'])) $_REQUEST['lat']=1;
	if (!isset($_REQUEST['lng'])) $_REQUEST['lng']=1;	
	$db = new DataBaseMySql();
	$query="INSERT INTO `v4_UserLocations`( `UserID`, `Time`, `Lat`, `Lng`, `Lat2`, `Lng2` ) 
		VALUES (
			".$userID.",
			".time().",
			".$_REQUEST['lat'].",
			".$_REQUEST['lng'].",			
			".$lat2.",
			".$lng2."
		)";
	$db->RunQuery($query);


