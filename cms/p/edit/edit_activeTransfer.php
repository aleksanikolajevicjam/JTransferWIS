<?
echo 'edit_activeTransfer';die();
@session_start();
if (!$_SESSION['logged']) die('Bye, bye');


require_once "config.php";
require_once "data.php";
require_once "f/f.php";
require_once "f/form_functions.php";

# Language
$_SESSION['lng'] = 'en';
if(!empty($_COOKIE['lng'])) $lng = $_COOKIE['lng'];
require_once('lng/' . $_SESSION['lng'] . '_config.php');

/*
		    echo '
		    <script type="text/javascript">
		    $("#breadcrumb").html(": Edit");
		    </script>
		    ';
*/
# Get Details
$qry = "SELECT * FROM ".DB_PREFIX."OrderDetails
WHERE DetailsID = '".$_REQUEST['rec_no']."'
";
$res = mysql_query($qry) or die(mysql_error());
$d = mysql_fetch_assoc($res);


# Get Master‎
$qry = "SELECT * FROM ".DB_PREFIX."OrdersMaster
WHERE MOrderID = '".$d['OrderID']."'
";
$ord = mysql_query($qry) or die(mysql_error());
$m = mysql_fetch_assoc($ord);


# Create Form
//startForm();
	echo '<form name="edit_form" id="edit_form" action="index.php?p=transfers" method="POST" class="box box-info">';
		echo '<div class="box-body">';
# Driver Lookup Prepare
$driverLookup = array();
$driverLookup['Field'] = 'DriverID';
$driverLookup['Table'] = DB_PREFIX.'MyDrivers';
$driverLookup['Lookup_Key'] = 'DriverID';
$driverLookup['Lookup_Text'] = 'DriverName';
$driverLookup['Lookup_Query'] = 'SELECT DriverID, DriverName
				 FROM '.DB_PREFIX.'MyDrivers
				 ORDER BY DriverName ASC';
$driverLookup['Lookup_Type'] = 'edit';

# Driver Lookup Prepare
$vehicleLookup = array();
$vehicleLookup['Field'] = 'VehicleType';
$vehicleLookup['Table'] = DB_PREFIX.'Vehicles';
$vehicleLookup['Lookup_Key'] = 'VehicleID';
$vehicleLookup['Lookup_Text'] = 'VehicleName';
$vehicleLookup['Lookup_Query'] = 'SELECT *
				 FROM '.DB_PREFIX.'Vehicles
				 WHERE OwnerID = '.$_SESSION['OwnerID'].'
				 ORDER BY VehicleCapacity ASC';
$vehicleLookup['Lookup_Type'] = 'edit';

# zabrana statusa manjih od Canceled
$CompletitionAllowed = $StatusDescription;
unset($CompletitionAllowed[0]);
unset($CompletitionAllowed[1]);
//unset($CompletitionAllowed[2]);

$statusLookup = array();
$statusLookup['Field'] = 'TransferStatus';
$statusLookup['Table'] = $CompletitionAllowed;
$statusLookup['Lookup_Key'] = NULL;
$statusLookup['Lookup_Text'] = NULL;
$statusLookup['Lookup_Query'] = NULL;
$statusLookup['Lookup_Type'] = 'simple';


# Form Fields
# inField(desc, name, fld, type, length, css, lookupParams);

inField(ORDER_KEY,'MOrderKey',$m['MOrderKey'],'display',40, 'lead text-info');
inField(TRANSFER_ID,'DetaisID',$d['DetailsID'],'display',40, 'lead');
//inField('Vehicle','VehicleID',GetVehicleName($d['VehicleType']),'display',40, 'bogoFormDisplayBold');

# Related Transfers --------------------------
moreTransfers($m['MOrderID'], $d['DetailsID']);
#---------------------------------------------

emptyRow('<hr/>');

inField(STATUS,'TransferStatus',$d['TransferStatus'],'edit',6,'bogoFormDisplayBold', $statusLookup);

inField(FIRST_NAME,'MPaxFirstName', $m['MPaxFirstName'], 'display', 40, 'lead text-info');

inField(LAST_NAME,'MPaxLastName',$m['MPaxLastName'],'display',40, 'lead text-info');

inField( FLIGHT_NO,'FlightNo',$d['FlightNo'],'edit',40);
inField( FLIGHT_TIME,'FlightTime',$d['FlightTime'],'time',12);
inField( PICKUP_DATE,'PickupDate',$d['PickupDate'],'date',12);
inField( PICKUP_TIME,'PickupTime',$d['PickupTime'],'time',12);

inField( PICKUP_POINT,'PickupName',$d['PickupName'],'display',40, 'lead text-info');
inField( PICKUP_ADDRESS,'PickupAddress',$d['PickupAddress'],'edit',40);


inField( DROPOFF_POINT,'DropName',$d['DropName'],'display',40, 'lead text-info');
inField( DROPOFF_ADDRESS,'DropAddress',$d['DropAddress'],'edit',40);
//inField( DROPOFF_NOTE,'DropNotes',$d['DropNotes'],'text',40,'span4');

inField( NOTES,'PickupNotes',$d['PickupNotes'],'text',40,'col-md-4');

emptyRow();

inField(VEHICLE,'VehicleType',$d['VehicleType'],'display',6,'bogoFormDisplayBold', $vehicleLookup);
inField(DRIVER,'DriverID',$d['DriverID'],'display',6,'bogoFormDisplayBold', $driverLookup);

inField(MESSAGE_TO_DRIVER,'DriverNotes',$d['DriverNotes'],'text',40,'col-md-4');
emptyRow();

# Hidden Fields
hiddenField('DetailsID',$d['DetailsID']);
hiddenField('OrderID',$m['OrderID']);
//hiddenField('o','1');

# Driver Message Button Script
?>
	<!--<tr><td></td><td> -->
	    <div class="col-md-offset-3">
	        <button type="button" class="btn btn-info pull-left"
	            onclick='$.get("setDriver.php",{ driverID: $("#DriverID").val(),
	            message: $("#DriverNotes").html(), detailsID: $("#DetailsID").val()  },
	            function(data){ $("#checkid").html(data); });'>
	            <?= SET_DRIVER_AND_SEND_MSG ?>
	        </button>
	        <br/><br/>
	    </div>
	<div id="checkid" style="width:400px;"></div>
	<!-- </td></tr> -->
<?


echo '</div>';

# Close Form and Display Buttons (update, delete)
endForm(true);

/* EOF*/
