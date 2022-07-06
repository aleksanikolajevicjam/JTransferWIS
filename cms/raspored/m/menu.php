<?
session_start();

//require_once 'database.php';

$mydriver = $_SESSION['DriverID'];
$ownerid  = $_SESSION['OwnerID'];


$q  = "SELECT * FROM v4_OrderDetails ";
$q .= "WHERE DriverID = '".$ownerid."' AND (SubDriver = '" . $mydriver . "' ";
$q .= " OR SubDriver2 = '" . $mydriver . "' ";
$q .= " OR SubDriver3 = '" . $mydriver . "') ";
$q .= " AND PickupDate >= '" . date("Y-m-d", time() - 60 * 60 * 24)."' ";
$q .= " AND TransferStatus != 3 ";
$q .= " AND TransferStatus != 4 ";
$q .= " AND TransferStatus != 9 ";
//$q .= " AND TransferStatus < 10 ";
$q .= "ORDER BY PickupDate ASC, SubPickupTime ASC ";

$qr = mysqli_query($con,$q) or die('Error in OrderDetails query <br>' . mysqli_connect_error());

# initialize details
$details = array();
echo '
	<form class="ui-filterable">
		<input id="filterBasic-input" data-type="search" placeholder="Search...">
	</form>
';
echo '<ul data-role="listview" data-inset="true" data-filter="true" data-input="#filterBasic-input">';

while( $v = mysqli_fetch_object($qr) ) {
	$mq = "SELECT MOrderKey, MPaxTel FROM v4_OrdersMaster WHERE MOrderID = " . $v->OrderID;
	$mr = mysqli_query($con,$mq) or die('Error in OrdersMaster query <br>' . mysqli_connect_error());
	$mo = mysqli_fetch_object($mr);

	$moreCars = 0;
	if($v->SubDriver != 0 and $v->SubDriver2 != 0) $moreCars = 2;
	if($v->SubDriver != 0 and $v->SubDriver2 != 0 and $v->SubDriver3 != 0) $moreCars = 3;


	$hasReturn = hasReturn($v->OrderID, $v->TNo, $con);
	
	// koji auto vozi ovaj vozač
	if($mydriver == $v->SubDriver) $myCar = carName($v->Car);
	if($mydriver == $v->SubDriver2) $myCar = carName($v->Car2);
	if($mydriver == $v->SubDriver3) $myCar = carName($v->Car3);

	if ($savedDate != $v->PickupDate) {
		if($v->PickupDate < date("Y-m-d")) {
			echo ' <li data-role="list-divider" role="heading" data-theme="c">'.
		            convertTime($v->PickupDate).'</li>';
		} else {
			echo ' <li data-role="list-divider" role="heading" data-theme="a">'.
		            convertTime($v->PickupDate).'</li>';
		}
	}

		echo '<li data-theme="a">
			    <a href="index.php?option=details&id='.$v->DetailsID.'" data-transition="slide"><small>';
		echo $v->SubPickupTime . ' ' .mysqli_real_escape_string($con, $v->PickupName)  .' &raquo; ' . $v->DropName;
		echo '<br>'.$v->PaxName.' :: ' . $v->PaxNo . ' pax';
		echo ' MyCar:'.$myCar;
		if ($moreCars > 0) echo ' :: <strong>'.$moreCars.' cars </strong>' ;

	
		if ($hasReturn != '') {
			echo ' :: <strong>'.$hasReturn.'</strong>' ;
			echo '</small></a></li>';
			$returnTransfer = $hasReturn;
		}
		echo '</small></a></li>';	

		$details[$v->DetailsID] = array(
			            'Order'   		=> $mo->MOrderKey . '-' . $v->OrderID . ' ' . $returnTransfer,
			            'VehicleType' 	=> $v->VehicleType . ' pax',
			            'hr0'			=> '-',
						'Pickup Name'   => strtoupper($v->PickupName),
			            'Pickup Date'   => convertTime($v->PickupDate),
			            'Pickup Time'   => $v->SubPickupTime,
			            'Pickup Address'=> $v->PickupAddress,
			            'FlightNo'		=> $v->SubFlightNo,
			            'FlightTime'	=> $v->SubFlightTime,
			            'hr'           	=> '-',
			            'Drop Name'     => $v->DropName,
			            'Drop Address'  => $v->DropAddress,
			            'hr1'           => '-',
			            'Pax Name'      => $v->PaxName,
			            'Pax Tel'       => $mo->MPaxTel,
			            'Pax No'       	=> $v->PaxNo,
			            'Notes'      	=> $v->PickupNotes,
			            'hr2'           => '-',
			            //'PickupDate'     => convertTime($v->PickupDate),
			            //'PickupTime'     => $v->PickupTime,
			            'Driver Notes'  => $v->SubDriverNote, 
			            'hr3'			=> '-',
			            'Cash'			=> $v->PayLater . ' Eur',
			            'hr4'			=> '-',
			            'Receipt PDF'	=> '<a href="https://www.jamtransfer.com/cms/raspored/PDF/'.$v->PDFFile.'">'.$v->PDFFile.'</a>'
		);

	$savedDate = $v->PickupDate;
}

echo '</ul>';

$_SESSION['DETAILS'] = $details;


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

/*EOF*/

