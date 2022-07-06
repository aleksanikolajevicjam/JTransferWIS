<?
// VISKA FILE, BACI
//Ovoga puta mi pored email adrese trebaju i podaci o bukiranom transferu odnosno ruti, broj leta i home country.

require_once ROOT .'/db/db.class.php';
require_once ROOT .'/db/v4_OrdersMaster.class.php';
require_once ROOT .'/db/v4_OrderDetails.class.php';

// csv
require_once ROOT . '/cms/f/csv.class.php';

$db = new DataBaseMysql();


if (isset($_REQUEST['authUsers']) && ($_REQUEST['authUsers'] != '')) $authUsers = $_REQUEST['authUsers'];
else {
	$authUsers = 3;
	$userLevel = "Clients";
}

$qLvl = 'SELECT * FROM v4_AuthLevels ORDER BY AuthLevelID';
$rLvl = $db->RunQuery($qLvl);

?>
<meta charset="utf-8">

<div class="container">
	<form id="users" action="index.php?p=clients" method="post">
		AuthLevelName:
		<select name="authUsers" onchange="this.form.submit();">
		<?
		while ($l = $rLvl->fetch_object()) {
			echo '<option value="' . $l->AuthLevelID . '"' ;
			if ($authUsers == $l->AuthLevelID) {
				echo ' selected';
				$userLevel = $l->AuthLevelName;
			}
			echo '>' . $l->AuthLevelName . '</option>';
		}
		?>
		</select>
	</form>
<?
echo 'User Type: ' . $userLevel . '<br>';

echo '<button>Export CSV</button><br>';



	$q = "	SELECT DISTINCT MPaxEmail, MOrderID FROM v4_OrdersMaster 
			WHERE MPaxEmail != '' AND MUserLevelID = " . $authUsers . "
			ORDER BY MPaxEmail ASC
			LIMIT 100";
	
	$w = $db->RunQuery($q);


while($om = $w->fetch_object()) {

	$qd = "	SELECT * FROM v4_OrderDetails 
			WHERE OrderID = '" . $om->MOrderID ."'
			ORDER BY DetailsID ASC";
	$wd = $db->RunQuery($qd);
	
	while($od = $wd->fetch_object() ) {
		if($tempMPaxEmail != $om->MPaxEmail) {
			echo '<hr>';
			echo $om->MPaxEmail . '<br>-'.$od->PickupName .'-'.$od->DropName . '-' . $od->FlightNo . '<br>';
		} else {
			echo ' ' . '-'.$od->PickupName .'-'.$od->DropName . '-' . $od->FlightNo . '<br>';
		}
		$tempMPaxEmail = $om->MPaxEmail;
	}
		
}



/*$qEmail = "SELECT DISTINCT MPaxEmail FROM v4_OrdersMaster WHERE MPaxEmail <> '' AND MUserLevelID = " . $authUsers . " ORDER BY MPaxEmail ASC LIMIT 10";
$dEmail = new DataBaseMysql();
$rEmail = $dEmail->RunQuery($qEmail);
$dOrder = new DataBaseMysql();
$dRoute = new DataBaseMysql();
while ($e = $rEmail->fetch_object()) {
	echo '<hr>EMAIL: ' . $e->MPaxEmail;
	$qOrder = "SELECT MOrderID FROM v4_OrdersMaster WHERE MPaxEmail = '" . $e->MPaxEmail . "' ORDER BY MOrderID ASC";
	$rOrder = $dOrder->RunQuery($qOrder);
	while ($o = $rOrder->fetch_object()) {
		echo '<br>MOID: ' . $o->MOrderID;
		$qRoute = "SELECT * FROM v4_OrderDetails WHERE OrderID = " . $o->MOrderID . " ORDER BY DetailsID ASC";
		$rRoute = $dRoute->RunQuery($qRoute);
		while ($r = $rRoute->fetch_object()) {
			echo '<br>-DID: ' . $r->DetailsID;
			echo ' | PAX: ' . $r->PaxName;
			echo ' | ROU: ' . $r->PickupName . ' - ' . $r->DropName;
			echo ' | (COUNTRY)';
			echo ' | FNO: ' . $r->FlightNo;
		}
	}
}
*/

echo '<br>END</div>';

// u csv


