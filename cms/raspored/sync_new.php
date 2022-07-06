<?
error_reporting(E_ALL);
require_once 'data.php';
require_once './f/db_funcs.php';

$today = date("Y-m-d");
//$today = '2016-01-01';
$DriverID = '556';

$q1 = "SELECT * FROM v4_OrderDetails 
	   WHERE DriverID = '".$DriverID."' 
	   AND PickupDate >= '".$today."' AND TransferStatus < '4' 
	   ORDER BY DetailsID ASC";

$r1 = mysql_query($q1) or die( mysql_error() . ' v4_OrderDetails - Start');


// main loop
while ($o = mysql_fetch_object($r1)) {  

	$OrderID 	= $o->OrderID;
	$TNo 		= $o->TNo;
 
    # pronadji u v4_OrdersMaster    
    $q3 = "SELECT * FROM v4_OrdersMaster 
	       WHERE MOrderID = '".$OrderID."' 
	       ORDER BY MOrderID ASC";
    $r3 = mysql_query($q3) or die( mysql_error() . ' v4_OrdersMaster - Start');
    $oM = mysql_fetch_object($r3);

    // polje za upis u TimeTable
    $PaxName = $oM->MPaxFirstName . ' ' . $oM->MPaxLastName;

    
    # pripremi extra usluge
	$extras = '';
    $q5 = "SELECT * FROM v4_OrderExtras WHERE OrderDetailsID = '".$o->DetailsID."'";
    $r5 = mysql_query($q5) or die( mysql_error() . ' provjera u v4_OrderExtras');
    
    while ($oExtra = mysql_fetch_object($r5)) {
	    // polje za upis u TimeTable
        $extras .= '<br>'.$oExtra->ServiceName.': '.$oExtra->Qty;
    }


 	$SingleReturn = SingleReturn($OrderID);


       
	// sve ide na naplatu u cashu    
    if ($o->PayNow == 0 and $o->PayLater == 0 and $o->InvoiceAmount == 0){
        $TPayNow = 0;
        $TPayLater = $o->DetailPrice;
    }
    else {
    	// ima i cash i online
        $TPayNow = $o->PayNow;
        $TPayLater = $o->PayLater;
    }
 	

     # provjeri postoji li vec taj podatak u TimeTable

//     		AND OrderPickupDate = '".$o->PickupDate."' 
//    		AND OrderPickupTime = '".$o->PickupTime."'

    $q2 = " SELECT * FROM TimeTable 
    		WHERE OrderID = '" . $OrderID ."' 
    		AND TNo = '".$TNo."'
    		";
    $r2 = mysql_query($q2) or die( mysql_error() . ' provjera u TimeTable');   
    
    # ako ne postoji, dodaj novi
    if (mysql_num_rows($r2) == 0) {
 
        # upis prvog transfera
        $data = array(
            //'ID' => '',
            'OrderID' => $OrderID,
            'TNo' => $TNo,
			'OrderKey' => $oM->MOrderKey.'-'.$oM->MOrderID,
            'OrderPickupDate' => $o->PickupDate,
            'OrderPickupTime' => $o->PickupTime,
            'PaxNo' => $o->PaxNo,
            'PickupDate' => $o->PickupDate,
            'PickupTime' => $o->PickupTime,
            'PickupDetails' => CleanUp($o->PickupNotes),
            'VehicleType' => $o->VehicleType,
            //'SubDriver' => '',
            //'Car' => '',
            'PaxName' => CleanUp($PaxName),
            'PaxTel' => $oM->MPaxTel,
            'FlightNo' => $o->FlightNo,
            'FlightTime' => $o->FlightTime,
            'SingleReturn' => $SingleReturn,
            'PayNow' => $TPayNow,
            'PayLater' => $TPayLater,
            //'PaxNote' => CleanUp($o->ArrivalNote),
            //'SubDriverNote' => 
            'FromPlace' => $o->PickupName,
            'FromAddress' => addslashes($o->PickupPlace." ".$o->PickupAddress),
            'ToPlace' => $o->DropName,
            'ToAddress' => addslashes($o->DropPlace." ".$o->DropAddress),
            'OrderStatus' => $o->TransferStatus,
            'Extras'      => $extras 
            //'TransferStatus' => 
            //'FinalNote' =>  
        );
        
        $success = XInsert('TimeTable', $data);
        unset($data);
        
    }
    
    # ako podatak postoji, azuriraj podatke
    else {
			$tt = mysql_fetch_object($r2);
			
			$datax = array(
			//'ID' => '',
			'OrderID' => $OrderID,
            'TNo' => $TNo,
			'OrderKey' => $oM->MOrderKey.'-'.$oM->MOrderID,
			'OrderPickupDate' => $o->PickupDate,
			'OrderPickupTime' => $o->PickupTime,
			'PaxNo' => $o->PaxNo,
			'PickupDate' => $o->PickupDate,
			//'PickupTime' => $o->PickupTime,
			'PickupDetails' => CleanUp($o->PickupNotes),
            'VehicleType' => $o->VehicleType,
			//'SubDriver' => '',
			//'Car' => '',
			'PaxName' => CleanUp($PaxName),
			'PaxTel' => $oM->MPaxTel,
			// 'FlightNo' => $o->FlightNo,
			// 'FlightTime' => $o->FlightTime,
			'SingleReturn' => $SingleReturn,
			'PayNow' => $TPayNow,
			'PayLater' => $TPayLater,
			//'PaxNote' => CleanUp($o->ArrivalNote),
			//'SubDriverNote' => 
            'FromPlace' => $o->PickupName,
            'FromAddress' => addslashes($o->PickupPlace." ".$o->PickupAddress),
            'ToPlace' => $o->DropName,
            'ToAddress' => addslashes($o->DropPlace." ".$o->DropAddress),
			'OrderStatus' => $o->TransferStatus,
			'Extras'      => $extras
			//'TransferStatus' => 
			//'FinalNote' =>  
		);

		XUpdate('TimeTable', $datax, " ID = '". $tt->ID."'" );
		unset($datax);


    } #end if-else - postoji - ne postoji
     # provjeri postoji li vec taj podatak u TimeTable
    $q2a = " SELECT * FROM TimeTable 
    		WHERE OrderID = '" . $OrderID ."'
    		";
    $r2a = mysql_query($q2a) or die( mysql_error() . ' provjera u TimeTable');
    $r2aRows = mysql_num_rows($r2a);
    
    if( 
    	($SingleReturn == 'Single' and $r2aRows > 1) or
    	($SingleReturn == 'Return' and $r2aRows > 2) 
    ) {
    	XDelete("TimeTable", " OrderID = '".$OrderID."' AND TNo = '0'");
    }

} #end main loop While

echo '<div class="alert alert-success"><h2>Sync Completed</h2></div>';

# Clean Up text
function CleanUp($s)
{
    return mysql_real_escape_string($s);
}

function SingleReturn($OrderID) {
	    # provjeri return ili single
 
    $q4 = "SELECT * FROM v4_OrderDetails WHERE OrderID = '".$OrderID."'";
    $r4 = mysql_query($q4) or die( mysql_error() . ' provjera OrderID u v4_OrderDetails');

    $SingleReturn = 'Single';
    
    if (mysql_num_rows($r4) == 2) { // return
        $SingleReturn = 'Return';
    }
    
    return $SingleReturn;
}

