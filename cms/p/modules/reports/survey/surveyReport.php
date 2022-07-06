<?
require_once ROOT . '/db/db.class.php';
require_once ROOT . '/cms/f/csv.class.php';
require_once ROOT . '/db/v4_Routes.class.php';
require_once ROOT . '/db/v4_OrderDetails.class.php';
echo '<div class="container-fluid pad1em">';
echo '<h1>' . SURVEY_RESULTS_LIST . '</h1><br><br>';

$dateFrom 	= $_REQUEST['DateFrom'];
$dateTo 	= $_REQUEST['DateTo'];
$hasComment = $_REQUEST['hasComment'];
$routeID 	= $_REQUEST['routeID'];
$approved	= $_REQUEST['approved'];

// CSV Setup
$csv = new ExportCSV;
$csv->File = 'SurveyResults';

# CSV first row
$csv->addHeader(array(
		'Approved',
		'PickupDate',
		'Date',
		'OrderID',
		'RouteID',
		'UserEmail',
		'UserName',
		'Comment',
		'ScoreService',
		'ScoreDriver',
		'ScoreClean',
		'ScoreValue',
		'ScoreWebsite',
		'ScoreTotal',
		'DriverOnTime',
		'Recommend',
		'BookAgain'
		) );

$db = new DataBaseMysql();
$or = new v4_Routes();
$od = new v4_OrderDetails();

$qs = "SELECT * FROM v4_Survey WHERE ID > 0";
if ($dateFrom) 		$qs .= " AND Date >= '" . $dateFrom . "'";
if ($dateTo) 		$qs .= " AND Date <= '" . $dateTo . "'";
if ($routeID) 		$qs .= " AND RouteID = " . $routeID;
if ($hasComment) 	$qs .= " AND Comment != ''";
if ($approved != 3) { $qs .= " AND Approved = " . $approved; }
$qs .= " ORDER BY ID DESC";

// table header
echo '<div class="row">';
echo '<div class="col-md-1">Approved</div>';
echo '<div class="col-md-1">PickupDate</div>';
echo '<div class="col-md-1">Date</div>';
echo '<div class="col-md-1">OrderID</div>';
echo '<div class="col-md-1">Route</div>';
echo '<div class="col-md-1">UserEmail</div>';
echo '<div class="col-md-1">UserName</div>';
echo '<div class="col-md-1">Comment</div>';
echo '<div class="col-md-1">ScoreTotal</div>';
echo '<div class="col-md-1">DriverOnTime</div>';
echo '<div class="col-md-1">Recommend</div>';
echo '<div class="col-md-1">BookAgain</div>';
echo '</div>';

$wd = $db->RunQuery($qs);

while ($sr = $wd->fetch_object()) {
	$OrderKeys = $od->getKeysBy("DetailsID", "ASC", "WHERE OrderID = " . $sr->OrderID);
	$od->getRow($OrderKeys[count($OrderKeys) - 1]);
	$OrderDate = $od->getPickupDate();

	if ($sr->DriverOnTime == 1) $DriverOnTime = 'Yes';
	else $DriverOnTime = 'No';

	if ($sr->Recommend == 3) $Recommend = 'Yes';
	else if ($sr->Recommend == 2) $Recommend = 'Maybe';
	else $Recommend = 'No';

	if ($sr->BookAgain == 3) $BookAgain = 'Yes';
	else if ($sr->BookAgain == 2) $BookAgain = 'Maybe';
	else $BookAgain = 'No';

	if ($sr->Approved == 0) $isApproved = 'No';
	else if ($sr->Approved == 1) $isApproved = 'Yes';
	else $isApproved = 'Discarded';

	echo '<hr><div class="row">';
	echo '<div class="col-md-1">' . $isApproved . '</div>';
	echo '<div class="col-md-1">' . $OrderDate . '</div>';
	echo '<div class="col-md-1">' . $sr->Date . '</div>';
	echo '<div class="col-md-1">' . $sr->OrderID . '</div>';

	/* prikaz "?" umisto nepoznate rute (#795) */
	if ($sr->RouteID == 0) $Route = '?';
	else {
		$or->getRow($sr->RouteID);
		$Route = $or->RouteNameEN;
	}
	echo '<div class="col-md-1">' . $Route . '</div>';
	echo '<div class="col-md-1">' . $sr->UserEmail . '</div>';
	echo '<div class="col-md-1">' . $sr->UserName . '</div>';
	echo '<div class="col-md-1">' . $sr->Comment . '</div>';
	echo '<div class="col-md-1">' . $sr->ScoreTotal . '</div>';

	echo '<div class="col-md-1">' . $DriverOnTime . '</div>';
	echo '<div class="col-md-1">' . $Recommend . '</div>';
	echo '<div class="col-md-1">' . $BookAgain . '</div>';

	echo '</div>';

	$csv->addRow(array(
		$isApproved,
		$OrderDate,
		$sr->Date ,
		$sr->OrderID,
		$sr->RouteID,
		$sr->UserEmail,
		$sr->UserName,
		$sr->Comment,
		$sr->ScoreService,
		$sr->ScoreDriver,
		$sr->ScoreClean,
		$sr->ScoreValue,
		$sr->ScoreWebsite,
		$sr->ScoreTotal,
		$DriverOnTime,
		$Recommend,
		$BookAgain
	));
}

$csv->save();
echo '<hr><h4>Exported to CSV!</h4>';
echo '<a href="'.$csv->File.$csv->Extension.'" class="btn btn-default"><i class="fa fa-download"></i> Download CSV</a><br>';
echo 'You can download CSV file here (or Right-Click->Save). <br>';
echo '<b>File format:</b> UTF-8, semi-colon (;) delimited<br>';

echo '</div>';

