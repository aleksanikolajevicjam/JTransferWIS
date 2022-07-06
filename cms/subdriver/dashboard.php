<?
session_start();

require_once 'subdriver/db.php';
require_once '../db/v4_OrderExtras.class.php';
require_once '../db/v4_Places.class.php';
require_once '../db/v4_AuthUsers.class.php';

	function clearTime($time) {
		$timeUF=explode('T',$time);
		$timeUF=explode(':',$timeUF[1]);
		return $timeUF[0].":".$timeUF[1];
	}	

	//trenutni vehicle id
	require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_SubActivity.class.php';
	$sa = new v4_SubActivity();
	$sak = $sa->getKeysBy('ID', 'desc' , ' WHERE DriverID='. $_SESSION['AuthUserID'] .' AND Approved<>9');
	if (count($sak)>0) {
		$sa->getRow($sak[0]);
		$_SESSION['VehicleID']=$sa->VehicleID;
		require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_SubVehicles.class.php';
		$v = new v4_SubVehicles();
		$v->getRow($_SESSION['VehicleID']);
		$_SESSION['VehicleTitle']=$v->VehicleDescription;
	}
	

$oe = new v4_OrderExtras;
$op = new v4_Places;
$au = new v4_AuthUsers();


$mydriver = $_SESSION['AuthUserID'];
$_SESSION['DriverID'] = $mydriver;

$oq = 'SELECT * FROM v4_AuthUsers WHERE AuthUserID = '. $mydriver;
$qr = mysqli_query($con, $oq) or die('Error in AuthUsers query');
$ow = mysqli_fetch_object($qr);
$_SESSION['OwnerID'] = $ow->DriverID;
$ownerid = $_SESSION['OwnerID'];
$time = date('H:i',time() + 3600);
$hour = explode(":",$time);
$hour=$hour[0];
if ($hour<12) $dateLimit = date("Y-m-d", time() - 60 * 60 * 24);
else $dateLimit = date("Y-m-d", time());
// TEST
if(isset($_REQUEST['dateLimit'])) $dateLimit = $_REQUEST['dateLimit'];


$q  = "SELECT * FROM v4_OrderDetails ";
$q .= "WHERE DriverID = '".$ownerid."' AND (SubDriver = '" . $mydriver . "' ";
$q .= " OR SubDriver2 = '" . $mydriver . "' ";
$q .= " OR SubDriver3 = '" . $mydriver . "') ";
$q .= " AND PickupDate >= '" . $dateLimit."' ";
//$q .= " AND PickupDate >= '" . date("Y-m-d")."' ";
//$q .= " AND TransferStatus != 3 ";
$q .= " AND TransferStatus != 4 ";
$q .= " AND TransferStatus != 9 ";
//$q .= " AND Extras = ''"; // dodati 1 
$q .= "ORDER BY PickupDate ASC, SubPickupTime ASC ";
//echo $q;
$qr = mysqli_query($con, $q) or die('Error in OrderDetails query');

$row_cnt = mysqli_num_rows($qr);

# get exchange rates
# $dbex = new DataBaseMysql();
# $r = $dbex->RunQuery("SELECT * FROM v4_ExchangeRate ORDER BY ID ASC");


# initialize details
$details = array();
echo '<div class="container">';
echo '<div id="alarm1" style="display:none;" class="row pad4px blue">Alarm Message</div>';
echo '<div id="alarm2" style="display:none;" class="row pad4px"><strong id="alarm3">
	</strong><button id="confirm" type="button">Confirm</button></div>';
echo '<div id="alarmid" style="display:none"></div>';
echo '<div class="row pad4px blue">Vehicle</div>';
echo '<strong>' .$_SESSION['VehicleTitle']. '</strong>';
echo '<div class="row pad4px blue">Notes</div>';
echo '<div class="row" style="margin-bottom:10px">';
echo '<div class="col-md-12">';
//echo '<strong>' . BALANCE . ':</strong> ' . $ow->Balance . '<br>';
echo '<strong>' . MESSAGE . ':</strong> ' . $ow->NoteToDriver ;
if ($ownerid==843) $afpadd="_Nice";
if ($ownerid==876) $afpadd="_Lyon";
if ($ownerid==556) $afpadd="_Split";

	$filename = $_SERVER['DOCUMENT_ROOT'] . '/cms/approvedFuelPrice'.$afpadd.'.inc';
	$afp = file_get_contents($filename, FILE_USE_INCLUDE_PATH);
echo "<br><strong>APPROVED FUEL PRICE: ".$afp." EUR</strong></div>";


echo '</div>';

if($row_cnt > 0) {

	// TRANSFERI
	while( $v = mysqli_fetch_object($qr) ) {
		// dohvacanje engleskih imena lokacija iz v4_Places
		// ako je FREEFORM, PickupID i DropID su 0,
		// pa se imena dohvacaju iz v4_OrderDetails
	
		$mq = "SELECT MOrderKey, MPaxTel, MConfirmFile FROM v4_OrdersMaster WHERE MOrderID = ".$v->OrderID;
		$mr = mysqli_query($con, $mq) or die('Error in OrdersMaster query <br>' . mysqli_connect_error());
		$mo = mysqli_fetch_object($mr);	
		$au->getRow($v->AgentID);
		
		if (($v->PickupID != 0) and ($v->DropID != 0)) {
			$op->getRow($v->PickupID);
			$PickupName = $op->getPlaceNameEN();
			if($op->getPlaceType()!=1) {
				$addressL=$PickupName.'+'.$v->PickupAddress;
				$point='Pickup point in '.$PickupName;
			}	
			$op->getRow($v->DropID);
			$DropName = $op->getPlaceNameEN();
			if($op->getPlaceType()!=1) {
				$addressL=$DropName.'+'.$v->DropAddress;
				$point='Drop point in '.$DropName;				
			}	
		} else {
			$PickupName = $v->PickupName;
			$DropName = $v->DropName;
		}
		$addressL=str_replace(', ','+',$addressL);
		$addressL=str_replace(',','+',$addressL);
		$addressL=str_replace(' ','+',$addressL);
		$addressL='https://www.google.com/search?q=maps+'.$addressL;
		$PickupName=mysqli_real_escape_string($con, $PickupName);
		$DropName=mysqli_real_escape_string($con, $DropName);		
		
		$moreCars = 0;
		if($v->SubDriver != 0 and $v->SubDriver2 != 0) $moreCars = 2;
		if($v->SubDriver != 0 and $v->SubDriver2 != 0 and $v->SubDriver3 != 0) $moreCars = 3;
		$hasReturn = hasReturn($v->OrderID, $v->TNo, $con);
		if ($hasReturn != '') $returnTransfer = $hasReturn;

		// koji auto vozi ovaj vozač
		if($mydriver == $v->SubDriver) $myCar = carName($v->Car);
		if($mydriver == $v->SubDriver2) $myCar = carName($v->Car2);
		if($mydriver == $v->SubDriver3) $myCar = carName($v->Car3);
		if ($v->TransferStatus==3) $cancelstyle='style="text-decoration: line-through;"';
		else $cancelstyle='';
		$order = $mo->MOrderKey.'-'.$v->OrderID.' '.$returnTransfer;
		$receipt = '<a href="https://www.jamtransfer.com/cms/raspored/PDF/'.$v->PDFFile.'">'.$v->PDFFile.'</a>';
		$details[$v->DetailsID] = array(
				        'Order'   		=> $order,
				        'VehicleType' 	=> $v->VehicleType . ' pax',
				        'hr0'			=> '-',
						'Pickup Name'   => strtoupper($PickupName),
				        'Pickup Date'   => convertTime($v->PickupDate),
				        'Pickup Time'   => $v->SubPickupTime,
				        'Pickup Address'=> $v->PickupAddress,
				        'FlightNo'		=> $v->SubFlightNo,
				        'FlightTime'	=> $v->SubFlightTime,
				        'hr'           	=> '-',
				        'Drop Name'     => $DropName,
				        'Drop Address'  => $v->DropAddress,
				        'hr1'           => '-',
				        'Pax Name'      => $v->PaxName,
				        'Pax Tel'       => $mo->MPaxTel,
				        'Pax No'       	=> $v->PaxNo,
				        'Notes'      	=> $v->PickupNotes,
				        'hr2'           => '-',
				        'Driver Notes'  => $v->SubDriverNote, 
				        'hr3'			=> '-',
				        'Cash'			=> $v->PayLater . ' Eur',
				        'hr4'			=> '-',
				        'Receipt PDF'	=> $receipt
		);						
		if ($savedDate != $v->PickupDate and $v->PickupDate < date("Y-m-d")) { // oznaka datuma za dan
			echo '<div class="row pad4px red">'.convertTime($v->PickupDate).'</div>';
		}
		if ($savedDate != $v->PickupDate and $v->PickupDate >= date("Y-m-d")) { // oznaka datuma za dan
			echo '<div class="row pad4px blue">'.convertTime($v->PickupDate).'</div>';
		}
		$savedDate = $v->PickupDate;		
		$DetailsID=$v->DetailsID;
		$_SESSION['DETAILS'] = $details;
		require_once '../db/v4_Flights.class.php';		
		require('../cms/a/getFlightStat.php');
		// TODO ima li ovih klasa?
		$carColor = 'text-lightgrey';
		$vehicleType = $v->VehicleType;
		if($vehicleType >= 100 and $vehicleType < 200) {
			$carColor = 'text-green white';
			$vehicleType = 'P'.($vehicleType - 100);
		}
		if($vehicleType >= 200) {
			$carColor = 'text-red white';
			$vehicleType = 'FC'.($vehicleType - 200);
		} 
		$extras = $oe->getKeysBy('ID', 'ASC', 'WHERE OrderDetailsID = ' . $v->DetailsID);
		if ($v->TransferStatus==3) $canceled="CANCELED";	
		else $canceled="";	
		
		$ephone=$au->getEmergencyPhone();
		$ephone=explode(',',$ephone);
		?>
			<div <?= $cancelstyle?> class="pad1em listTile">
				<? if ($mo->MConfirmFile<>"") {?> 
					<div class="row">
						<img src='img/<?= $au->getImage()?>'> 
						<b><?= $mo->MConfirmFile?></b>
						<? foreach ($ephone as $ep) { ?>						
							<i class="fa fa-phone"></i> 
							<a href="tel:<?= $ep ?>"><?= $ep ?></a>
						<? }?>	
					</div>
				<? } ?>	
				<div class="row">
					<a href="index.php?p=details&id=<?= $v->DetailsID?>">
						<?= $v->OrderID ?>-<?= $v->TNo?><?= $canceled ?>
						<br>
						<strong><?= $v->SubPickupTime ?></strong> <?= $PickupName ?> &raquo; <?= $DropName?>
						<br>
						<?= $v->PaxNo ?> pax &nbsp; <i class="fa fa-car <?= $carColor ?> pad4px"></i> 							
						<?= $myCar?>
						<? if(count($extras) > 0) {?> 
							<i class="fa fa-cubes red-text"></i>
						<? } ?>
						<? if ($moreCars > 0) {?>
							:: <strong><?= $moreCars?> cars </strong>
						<? } ?>	
						<? if ($hasReturn != '') {?>
							:: <strong><?= $hasReturn?></strong>
						<? } ?>
					</a>
				</div>
				<div class="row">				
					<i class="fa fa-user"></i> <?= $v->PaxName?> <i class="fa fa-phone"></i> <a href="tel:<?= $mo->MPaxTel?>"><?= $mo->MPaxTel?></a>
				</div>	
				<div class="row">		
					<i class="fa fa-plane"></i> <a class="mytooltip" data-content="<?= $message?>"><?= $v->FlightNo?></a> <?= $v->FlightTime?>										
				</div>
				<div class="row">		
					<i class="fa fa-map-marker"></i> <a target="_blank" href="<?= $addressL?>"><?= $point?></a>
				</div>				
			</div>
		<?			
	}
} else echo '<h2>No transfers today. Go grab a beer and relax :)</h2>';	
echo '</div><br><br><br><br>';
?>


<footer class="footer" >
    <div class="container" style="position: fixed;
  bottom: 0;
  width: 100%;
  /* Set the fixed height of the footer here */
  min-height: 60px;
  background-color: #f5f5f5;">
  <div class="row pad1em hidden">
        <div class="col-xs-3"><button id="start" class="btn btn-primary btn-block"><i class="fa fa-taxi"></i> DayStart</button></div>
        <div class="col-xs-3"><button id="pstart" class="btn btn-success btn-block"><i class="fa fa-pause"></i> PauseStart</button></div>
        <div class="col-xs-3"><button id="pend" class="btn btn-warning btn-block"><i class="fa fa-play"></i> PauseEnd</button></div>
        <div class="col-xs-3"><button id="end" class="btn btn-danger btn-block"><i class="fa fa-home"></i> DayEnd</button></div>
    </div>
    </div>
    <br><br>
</footer> 

<script>
	geolocation();
	setTimeout(function(){		
		window.location.reload(1);	
		geolocation();
	}, 300000);
	

	var action = '';
    
    $("#start").click(function() {
        //$.toaster('Time recorded.\nHave a nice day!', 'START', 'success blue-2');
        action = 'start';
        updateHours(action);
    });    

    $("#pstart").click(function() {
        //$.toaster('Pause started', 'OK', 'success');
        action = 'pstart';
        updateHours(action);
    });   

    $("#pend").click(function() {
        //$.toaster('Pause ended', 'OK', 'warning');
        action = 'pend';
        updateHours(action);
    }); 

    $("#end").click(function() {
        
        //$.toaster('Car parked', 'OK', 'success red');
        action = 'end';
        updateHours(action);
    });
function alarm() {
  var WEBSITEURL = 'https://' + $(location).attr('host');
  var url= WEBSITEURL + '/cms/subdriver/alarm.php';
  //window.location.reload(true); 
  if($.trim($('#alarm3').text())=='') {
	  $.ajax({
		  url: url,
		async: false,
		  success: function(data){
				if (data =='OK') {
					$('#alarm1').show(500);
					$('#alarm3').text('BUDJENJE');
					$('#alarmid').text('Test budjenja');
					$('#alarm2').show(500);
					var audio = new Audio("/cms/subdriver/Ringtone.mp3");
					audio.play();
					audio.loop=true;
					$("#confirm").click(function() {
						audio.pause();
						$('#alarm1').hide(500);
						$('#alarm2').hide(500);
						// ajax za zapis 
						var alarmid=$('#alarmid').text();
						alert (alarmid);
					});  

				}
		  }
	  });
  }
}
function geolocation () {
	var WEBSITEURL = 'https://' + $(location).attr('host');
	if(navigator.geolocation){
		navigator.geolocation.getCurrentPosition(function(position) {
			var lat = position.coords.latitude;
			var lng = position.coords.longitude;
			var url= WEBSITEURL + '/cms/subdriver/geoLocation.php?lat='+lat+'&lng='+lng;
console.log(url);
			$.ajax({
				url: url,
				async: false,
				success: function(data){
				}
			});
		})			
	}
}

function updateHours(action) {
	var url = WEBSITEURL + '/cms/a/workingHours.php?callback=?&SubDriverID=<?=$mydriver?>&action='+action;
    
	// kill previous request if still active
	if(typeof ajax_request !== 'undefined') ajax_request.abort();

	ajax_request = $.ajax({
		type: 'POST',
		url: url,
		async: true,
		contentType: "application/json",
		dataType: 'jsonp',
		success: function(data) {
		    $.toaster(data[0], 'OK', 'success blue-2');
			},
		error: function(error) {
			alert('Working Hours error');
		}
	});
}

$(".mytooltip").popover({trigger:'hover', html:true, placement:'bottom'});

</script>
<?
if ($_SESSION['AuthUserID']==948) {
	?>
	<script>
			
		//alarm();
	</script>
	<?
}	

function hasReturn($OrderID, $TNo, $con) {
	$q  = "SELECT * FROM v4_OrderDetails";
	$q .= " WHERE OrderID = '" . $OrderID . "' AND TNo > '".$TNo."'";
	$q .= " ORDER BY DetailsID ASC ";
	$qr = mysqli_query($con, $q) or die('Error in hasReturn query <br/>' . mysqli_connect_error());	
	
	$num_rows = mysqli_num_rows($qr);
	
	//if ($num_rows == 2) {
		$o = mysqli_fetch_object($qr);
		if($o->OrderID ==  $OrderID and $o->TNo != $TNo) {
			$ret = ' R ' . convertTime($o->PickupDate) . ' ' . $o->SubPickupTime;
			return $ret;
		}
		
	return '';
}

function carName($id) {
	global $con;
	$cq = "SELECT * FROM v4_SubVehicles WHERE VehicleID = " . $id;
	$cr = mysqli_query($con,$cq) or die('Error in OrdersMaster query <br>' . mysqli_connect_error());
	$car = mysqli_fetch_object($cr);
	
	return $car->VehicleDescription;
}

