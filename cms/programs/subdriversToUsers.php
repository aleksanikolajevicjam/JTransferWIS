<?
/*
v4_SubDrivers to v4_AuthUsers
svakog subdrivera u v4_SubDrivers kopirati u v4_AuthUsers, te zamijeniti njegov stari ID u v4_OrderDetails poljima SubDriver, SubDriver2 i SubDriver3 sa novim
*/

require_once '../../db/db.class.php';
require_once '../../db/v4_AuthUsers.class.php';
require_once '../../db/v4_SubDrivers.class.php';

$db = new DataBaseMysql();
$au = new v4_AuthUsers();
$sd = new v4_SubDrivers();

$sdWhere = "";
$sdK = $sd->getKeysBy("DriverID", "ASC", $sdWhere);

echo 'START';
if (count($sdK) > 0) {
	foreach($sdK as $nn => $sdID) {

		$sd->getRow($sdID);
		
		$username = $sd->getDriverName();
		$driverID = $sd->getDriverID();

		if ( usernameExists($username) > 0 ) {
			$au->setAuthUserName	( $username.$driverID );
			echo '<br>Duplicate username: ' . $username . ' - changed to: ' . $username.$driverID;
		} else {
			$au->setAuthUserName	( $username );
		}

		$au->setAuthUserRealName	( $sd->getDriverName() );
		$au->setDriverID			( $sd->getOwnerID() );
		$au->setAuthLevelID			( '32' );
		$au->setAuthUserTel			( $sd->getDriverTel() );
		$au->setAuthUserMail		( $sd->getDriverEmail() );
		$au->setAuthUserNote		( $sd->getNotes() );
		$au->setAuthUserPass		( $sd->getDriverPassword() );
		$au->setDateAdded			( date("Y-m-d") );
		$au->setLanguage			( "en" );
		$au->setActive				( $sd->getActive() );

		$newUserID = $au->saveAsNew();
		
		$updateDetails1 = "UPDATE v4_OrderDetails SET SubDriver = " . $newUserID ." 
						   WHERE SubDriver = " . $sdID;
		$db->RunQuery($updateDetails1);

		$updateDetails2 = "UPDATE v4_OrderDetails SET SubDriver2 = " . $newUserID ." 
						   WHERE SubDriver2 = " . $sdID;
		$db->RunQuery($updateDetails2);
		
		$updateDetails3 = "UPDATE v4_OrderDetails SET SubDriver3 = " . $newUserID ." 
						   WHERE SubDriver3 = " . $sdID;
		$db->RunQuery($updateDetails3);

		$updateExpenses = "UPDATE v4_SubExpenses SET DriverID = " . $newUserID ." 
						   WHERE DriverID = " . $sdID;
		$db->RunQuery($updateExpenses);

		echo '<br>Subdriver '.$driverID.' copied as User '.$newUserID;
	}
	echo "<br><br>DONE. " . count($sdK) . " subdrivers copied";
} else echo "ERROR: No subdrivers";

function usernameExists ($name) {
	$db1 = new DataBaseMysql();
	$q = 'SELECT * FROM v4_AuthUsers WHERE AuthUserName = "' . $name . '"';
	$w = $db1->RunQuery($q);

	return $w->num_rows;
}

