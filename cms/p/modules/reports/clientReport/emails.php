<?
require_once ROOT . '/db/db.class.php';
require_once ROOT . '/cms/f/csv.class.php';

echo '<div class="container-fluid pad1em">';
echo '<h1>' . CLIENT_EMAIL_LIST . '</h1><br><br>';
if (($_REQUEST['DateFrom'] != null) and ($_REQUEST['DateTo'] != null)) {

	$date = $_REQUEST['date'];
	$dateFrom = $_REQUEST['DateFrom'];
	$dateTo = $_REQUEST['DateTo'];
	$userType = $_REQUEST['userType'];
	$airport = $_REQUEST['airport'];
	$completed = $_REQUEST['completed'];
	$oneway = $_REQUEST['oneway'];
	$sort = $_REQUEST['sort'];

	// CSV Setup
	$csv = new ExportCSV;
	$csv->File = 'CustomerEmails';

	# CSV first row
	$csv->addHeader(array(
			'Email',
			'Pax',
			'Tel',
			'Route',
			'Flight No',
			'Booking Date',
			'Transfer Date',
			'Transfer ID',
			'Type'
			) );

	$db = new DataBaseMysql();

	// table header
	echo '<div class="row">';
	echo '<div class="col-md-2">Email</div>';
	echo '<div class="col-md-2">Pax</div>';
	echo '<div class="col-md-1">Tel</div>';
	echo '<div class="col-md-2">Route</div>';
	echo '<div class="col-md-1">Flight No</div>';
	echo '<div class="col-md-1">Booking Date</div>';
	echo '<div class="col-md-1">Transfer Date</div>';
	echo '<div class="col-md-1">OrderID</div>';
	echo '<div class="col-md-1">Type</div>';
	echo '</div>';

	$qd = "SELECT * FROM v4_OrderDetails";
	if ($date == "order") $qd .= " WHERE OrderDate >= '" . $dateFrom . "' AND OrderDate <= '" . $dateTo . "' ORDER BY OrderDate DESC";
	else if ($date == "transfer") $qd .= " WHERE PickupDate >= '" . $dateFrom . "' AND PickupDate <= '" . $dateTo . "' ORDER BY PickupDate DESC";

	$wd = $db->RunQuery($qd);

	while ($od = $wd->fetch_object()) {
		// FILTRIRANJE
		$skip = 0;
		$qm = "SELECT * FROM v4_OrdersMaster WHERE MOrderID = " . $od->OrderID;
		$wm = $db->RunQuery($qm);
		$om = $wm->fetch_object();

		$qd2 = "SELECT * FROM v4_OrderDetails WHERE OrderID = " . $od->OrderID;
		$wd2 = $db->RunQuery($qd2);

		// prazan email
		if ($om->MPaxEmail == '') $skip = 1;

		// provjera tipa korisnika
		if (($userType != 0) and ($userType == $om->MUserLevelID)) $skip = 1;

		// provjera statusa transfera
		if (($od->TransferStatus == 3) or ($od->TransferStatus == 4) || ($od->TransferStatus == 9)) $skip = 1;

		// jeli transfer u jednom smjeru (ako je filter ukljucen)
		if (($oneway) and ($wd2->num_rows == 2)) $skip = 1;

		// jeli pocetna lokacia airport (ako je filter ukljucen)
		if ($airport) {
			if( strpos(strtolower($od->PickupName),'airport') == false ) {
				$qp = "SELECT * FROM v4_Places WHERE PlaceID = " . $od->PickupID;
				$wp = $db->RunQuery($qp);
				$p = mysqli_fetch_assoc($wp);
				if ($p["PlaceType"] != 1) $skip = 1;
			}
		}

		// jeli transfer (i return) zavrsen (ako je filter ukljucen)
		if ($completed) {
			if ($wd2->num_rows == 1) {
				if (($od->TransferStatus != 5) or ($od->PickupDate <= $dateTo)) $skip = 1;
			}
			else {
				$qd3 = "SELECT TransferStatus FROM v4_OrderDetails WHERE OrderID = " . $od->OrderID . " AND TNo = 2";
				$wd3 = $db->RunQuery($qd3);
				$od3 = mysqli_fetch_assoc($wd3);
				if ($od3["TransferStatus"] != 5) $skip = 1;
			}
		}
		// kraj FILTRIRANJA

		// GLAVNI PRINT
		if ($skip == 0) {
			echo '<hr><div class="row">';
			echo '<div class="col-md-2">' . $om->MPaxEmail . '</div>';
			echo '<div class="col-md-2">' . $od->PaxName . '</div>';
			echo '<div class="col-md-1">' . $om->MPaxTel . '</div>';
			echo '<div class="col-md-2">' . $od->PickupName . ' - ' .$od->DropName . '</div>';
			echo '<div class="col-md-1">' . $od->FlightNo . '</div>';
			echo '<div class="col-md-1">' . $od->OrderDate . '</div>';
			echo '<div class="col-md-1">' . $od->PickupDate . '</div>';
			echo '<div class="col-md-1">' . $od->OrderID . '</div>';

			echo '<div class="col-md-1">';
			if ($wd2->num_rows == 1) echo 'One way';
			else echo 'Return';
			echo '</div></div>';

			$csv->addRow(array(
				$om->MPaxEmail ,
				$od->PaxName,
				$om->MPaxTel,
				$od->PickupName . ' - ' .$od->DropName,
				$od->FlightNo,
				$od->OrderDate,
				$od->PickupDate,
				$od->DetailsID
			));
		}
	}

	$csv->save();

	echo '<hr><h4>Exported to CSV!</h4>';

	echo '<a href="'.$csv->File.$csv->Extension.'" class="btn btn-default"><i class="fa fa-download"></i> Download CSV</a><br>';
	echo 'You can download CSV file here (or Right-Click->Save). <br>';
	echo '<b>File format:</b> UTF-8, semi-colon (;) delimited<br>';
}

else echo 'Enter Dates!';
echo '</div>';

