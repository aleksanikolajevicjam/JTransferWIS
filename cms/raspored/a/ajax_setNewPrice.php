<?
// ----------------------------------------------------------------------------
//
//  File:   priceList.php
//  Creation Date:  10/02/12
//  Last Modified:  13/02/12
//  Purpose: update all prices in one place
//
// ----------------------------------------------------------------------------
@session_start();


require_once '../../c/db.class.php';
require_once '../../c/tc_services.class.php';


$ownerID = $_SESSION['OwnerID'];
//$ownerID = '100';
$fp = intval($_REQUEST['fp']);

//usleep(300000);
	
        $sc = new tc_services();
        
        $sc->getRow($_REQUEST['ServiceID']);

        $sc->setServicePrice1( $fp);
        $sc->setServicePrice2($fp * 2);
        $sc->setLastChange( date("Y-m-d H:i:s"));

	
		$sc->saveRow();
				


	# show Message
//if ($success) 
echo '&nbsp;&nbsp; <i class="icon icon-ok-sign" alt="Updated" align="top" />';
//else echo '&nbsp;&nbsp; Error';
	
function GetServiceData($serviceID)
{
	$q = "SELECT * FROM ". DB_PREFIX."services
         WHERE ServiceID = '{$serviceID}' 
        ";

	$w = mysql_query($q) or die(mysql_error());

	$r = mysql_fetch_object($w);
	
	return $r;
}


function GetVehicleData($vehicleID)
{
	$q = "SELECT * FROM ".DB_PREFIX."vehicles 
         WHERE VehicleID = '{$vehicleID}' 
        ";

	$w = mysql_query($q) or die(mysql_error());

	$r = mysql_fetch_object($w);
	
	return $r;
}
