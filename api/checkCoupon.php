<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once ROOT . '/f2/f.php';

// Coupons - Code - Popust

//Blogit($_REQUEST);

$code = trim(strtoupper($_REQUEST['Coupon']));

$popust = GetCode($code);

if(isset($_GET['callback'])) {
	$discount=array();
	$discount[] = $popust;
	$msg = json_encode($popust);
	echo $_GET['callback'] . '(' . $msg. ')';
} else {
	echo $popust;
}	

	
function GetCode($code) {
	
	$bookingDate 	= date("Y-m-d");
	$transferDate 	= $_REQUEST['PickupDate'];
	$returnDate 	= $_REQUEST['XPickupDate'];
	$VehicleTypeID 		= $_REQUEST['VehicleTypeID'];
	$FromID 		= $_REQUEST['FromID'];
	$returnTransfer = $_REQUEST['returnTransfer']; // 0 ili 1
	$isWeekday		= false;

	if(getWeekday($transferDate) != 0 and getWeekday($transferDate) != 6) $isWeekday = true;
	
	// ticket $INC-549 - aleksandar
	// oba transfera moraju padati u radni dan.
	// ako je returnTransfer, resetira se $isWeekday i ispituje se na returnDate
	if($returnTransfer and $isWeekday) {
		$isWeekday		= false;
		if(getWeekday($returnDate) != 0 and getWeekday($returnDate) != 6) $isWeekday = true;
	}
	
	$notValid = 0;

	require_once ROOT.'/db/db.class.php';
	$db = new DataBaseMysql();

	$q = "SELECT * FROM v4_Coupons WHERE UPPER(Code) = '" . strtoupper($code) . "' AND Active = '1'";
	$w = $db->RunQuery($q);
	
	if ($w->num_rows == 1) {
		$p = $w->fetch_object();
		
		// vrijeme bookinga
		if($p->ValidFrom != '' and $p->ValidTo != '') {
			if( isInDateRange($p->ValidFrom, $p->ValidTo, $bookingDate) == false) {
				$notValid += 1;
			}
		}

		// vrijeme transfera
		if($p->TransferFromDate != '' and $p->TransferToDate != '') {
			if( isInDateRange($p->TransferFromDate, $p->TransferToDate, $transferDate) == false) {
				$notValid += 1;
			}
		}
		
		if ($p->WeekdaysOnly == '1' and $isWeekday == false) {
			$notValid += 1;
		}
		
		if($p->LimitLocationID > 0 and $FromID != $p->LimitLocationID) {
			$notValid += 1;
		}
		
		if($p->ReturnOnly and $returnTransfer != 1) {
			$notValid += 1;
		}
		
		if($p->VehicleTypeID != '0') {
			if( $p->VehicleTypeID != $VehicleTypeID) {
				$notValid += 1;
			}
		}		
	
		if ($notValid == 0) {
			$counter = $p->TimesUsed + 1;
			$db->RunQuery("UPDATE v4_Coupons SET TimesUsed = '" . $counter."' WHERE ID = '" .$p->ID ."'");
		
			return $p->Discount;
		}
		
		else return 0;
	}	
	
	return 0;
}

function getWeekday($date) {
    return date('w', strtotime($date));
}
