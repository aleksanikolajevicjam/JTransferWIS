<?

require_once 'data.php';
require_once './f/db_funcs.php';

$today = date("Y-m-d");

$q1 = "SELECT * FROM Orders 
	   WHERE Driver = '79' 
	   AND (STR_TO_DATE(ArrivalDate,'%d.%m.%Y') >= '2016-01-01' 
	   OR STR_TO_DATE(DepartureDate,'%d.%m.%Y') >= '2016-01-01') 
	   ORDER BY  OrderID ASC";
$r1 = mysql_query($q1) or die( mysql_error() . ' Orders - Start');

while ($o = mysql_fetch_object($r1)) {

      
        if ($o->ServiceID != '0') {
    	    $routeid = GetRIDFromServiceID($o->ServiceID);
    	    $terminalID = GetTermFromRID($routeid);
	        $destinationID = GetDestFromRID($routeid);
    	    $terminal = GetTerminalName($terminalID);
	        $destination = GetDestName($destinationID);
	    }
	    
	    if ( !empty($o->Terminal) and !empty($o->Destination) ) {
       
	        $terminal = $o->Terminal;
	        $destination = $o->Destination;
	    }


###################################################################################################
# PREBACENO IZ TIMETABLE.PHP - Otvoreno novo polje Extras !
###################################################################################################
		$extras = '';
		if(!empty($o->BabyStroler)) 	$extras  = '<br>Baby Stroler: ' . $o->BabyStroler;
		if(!empty($o->BabySeat)) 		$extras .= '<br>Baby Seat: ' . $o->BabySeat;
		if(!empty($o->ChildSeat)) 		$extras .= '<br>Child Seat: ' . $o->ChildSeat;
		if(!empty($o->ChildSeat2)) 		$extras .= '<br>Booster Seat: ' . $o->ChildSeat2;
		if(!empty($o->SkiSnowboard)) 	$extras .= '<br>Ski/Snowboard: ' . $o->SkiSnowboard;
		if(!empty($o->GolfBag)) 		$extras .= '<br>Golf Bag: ' . $o->GolfBag;
		if(!empty($o->ExtraLuggage)) 	$extras .= '<br>Extra Luggage: ' . $o->ExtraLuggage;
		if(!empty($o->Bicycle)) 		$extras .= '<br>Bicycle: ' . $o->Bicycle;
################################################################################################### 
echo '<br>' .$o->OrderID . '<br>'.$extras;

    # provjeri postoji li vec taj podatak
    $q2 = "SELECT * FROM TimeTable WHERE OrderID = '" . $o->OrderID ."'";
    $r2 = mysql_query($q2) or die( mysql_error() . ' provjera u TimeTable');


	# PRIPREMA PODATAKA ZA UPIS

    $VehicleType = GetVehicleIDFromServiceID($o->ServiceID);
    
    if ($o->SingleReturn == 'Single') {
        if ($o->Direction == 'TD') {
            $From = $terminal;
            $To = $destination;
            $FromAddress = '';
            $ToAddress = $o->AccomodationName . ' ' . $o->AccomodationAddress . ' ' . $o->AccomodationTel;
        }
        else { // DT
            $From = $destination;
            $To = $terminal;
            $FromAddress = $o->AccomodationName . ' ' . $o->AccomodationAddress . ' ' . 
            $o->AccomodationTel . 
            			   ' ' . $o->APickupAddress;
            $ToAddress = '';
        }
    }
    
    if ($o->SingleReturn == 'Return') {
        if ($o->Direction == 'TD') {
            $From = $terminal;
            $To = $destination;
            $FromAddress = '';
            $ToAddress = $o->AccomodationName . ' ' . $o->AccomodationAddress . ' ' . $o->AccomodationTel;
            
            $From2 = $destination;
            $To2 = $terminal;
            $FromAddress2 = $o->PickupName . ' ' . $o->PickupAddress . ' ' . $o->PickupTel;
            $ToAddress2 = '';
        }
        else { // DT
            $From = $destination;
            $To = $terminal;
            $FromAddress = $o->AccomodationName . ' ' . $o->AccomodationAddress . ' ' . 
            $o->AccomodationTel . 
            			   ' ' . $o->APickupAddress;
            $ToAddress = '';
            
            $From2 = $terminal;
            $To2 = $destination;
            $FromAddress2 = '';
            $ToAddress2 = $o->PickupName . ' ' . $o->PickupAddress . ' ' . $o->PickupTel . ' ' . 
            $o->RDropAddress;
        }
    }         
    
    $PaxName = $o->OrderName . ' ' . $o->OrderSurname;
    
    if ($o->PayNow == 0 and $o->PayLater == 0 and $o->InvoiceAmount == 0){
        $TPayNow = 0;
        $TPayLater = $o->OrderPrice;
    }
    else {
        $TPayNow = $o->PayNow;
        $TPayLater = $o->PayLater;
    }
    
    
    if ($o->SingleReturn == 'Return') {
        $PayNow2 = $TPayNow / 2;
        $PayLater2 = $TPayLater / 2;
        $PayNow = $PayNow2;
        $PayLater = $PayLater2;
    }
    else {
        $PayNow = $TPayNow;
        $PayLater = $TPayLater;
    }	


 
    
    # ako ne postoji, dodaj novi
    if (mysql_num_rows($r2) == 0) {
    
       
        # upis prvog transfera
        $data = array(
            //'ID' => '',
            'OrderID' => $o->OrderID,
            'OrderKey' => $o->OrderKey,
            'OrderPickupDate' => DMY_to_YMD($o->ArrivalDate),
            'OrderPickupTime' => $o->ArrivalTime,
            'VehicleType' => $VehicleType,
            'PaxNo' => $o->PassengersNo,
            'PickupDate' => DMY_to_YMD($o->ArrivalDate),
            'PickupTime' => $o->ArrivalTime,
            'PickupDetails' => CleanUp($o->ArrivalDetails),
            //'SubDriver' => '',
            //'Car' => '',
            'PaxName' => CleanUp($PaxName),
            'PaxTel' => $o->OrderTel,
            //'FlightNo' => '',
            //'FlightTime' => '',
            'SingleReturn' => $o->SingleReturn,
            'PayNow' => $PayNow,
            'PayLater' => $PayLater,
            'PaxNote' => CleanUp($o->ArrivalNote),
            //'SubDriverNote' => 
            'FromPlace' => $From,
            'FromAddress' => CleanUp($FromAddress),
            'ToPlace' => CleanUp($To),
            'ToAddress' => CleanUp($ToAddress),
            'OrderStatus' => $o->OrderStatusID,
            'Extras'      => $extras
          
            //'TransferStatus' => 
            //'FinalNote' =>  
        );
        
        $success = XInsert('TimeTable', $data);
        unset($data);

        
        if ($o->SingleReturn == 'Return'){
            # upis return transfera
            $data2 = array(
                //'ID' => '',
                'OrderID' => $o->OrderID,
                'OrderKey' => $o->OrderKey,
                'OrderPickupDate' => DMY_to_YMD($o->DepartureDate),
                'OrderPickupTime' => $o->DepartureTime,
                'VehicleType' => $VehicleType,
                'PaxNo' => $o->PassengersNo,
                'PickupDate' => DMY_to_YMD($o->DepartureDate),
                'PickupTime' => $o->DepartureTime,
                'PickupDetails' => CleanUp($o->DepartureDetails),
                //'SubDriver' => '',
                //'Car' => '',
                'PaxName' => CleanUp($PaxName),
                'PaxTel' => $o->OrderTel,
                //'FlightNo' => '',
                //'FlightTime' => '',
                'SingleReturn' => $o->SingleReturn,
                'PayNow' => $PayNow2,
                'PayLater' => $PayLater2,
                'PaxNote' => CleanUp($o->DepartureNote),
                //'SubDriverNote' => 
                'FromPlace' => CleanUp($From2),
                'FromAddress' => CleanUp($FromAddress2),
                'ToPlace' => CleanUp($To2),
                'ToAddress' => CleanUp($ToAddress2),
                'OrderStatus' => $o->OrderStatusID,
                'Extras'      => $extras
                //'TransferStatus' => 
                //'FinalNote' =>  
            );
            
            $success2 = XInsert('TimeTable', $data2);
            unset($data2);
        
        }
    }
    
    # ako podatak postoji, azuriraj podatke
    else {
 		    
	    # transferi vec postoje u TimeTable
	    # zato se ovo radi u while petlji
	    # tako da se $i usporedjuje sa $nrf u kojem je 1 ili 2 (return transfer)
	    # onda se svaki azurira sa svojim podacima
	    $qf = "SELECT * FROM TimeTable WHERE OrderID = '{$o->OrderID}' ORDER BY ID ASC";
	    $wf = mysql_query($qf) or die(mysql_error() . 'TimeTable First Query');
	    
	    $nrf = mysql_num_rows($wf);
	    $i = 1;
	    
	    while ($tt = mysql_fetch_object($wf)) {
	     
			if ($i == 1) { // prvi transfer

				# upis prvog transfera
				$datax = array(
					//'ID' => '',
					'OrderID' => $o->OrderID,
					'OrderKey' => $o->OrderKey,
					'OrderPickupDate' => DMY_to_YMD($o->ArrivalDate),
					'OrderPickupTime' => $o->ArrivalTime,
					'VehicleType' => $VehicleType,
					'PaxNo' => $o->PassengersNo,
					'PickupDate' => DMY_to_YMD($o->ArrivalDate),
					//'PickupTime' => $o->ArrivalTime,
					'PickupDetails' => CleanUp($o->ArrivalDetails),
					//'SubDriver' => '',
					//'Car' => '',
					'PaxName' => CleanUp($PaxName),
					'PaxTel' => $o->OrderTel,
					//'FlightNo' => '',
					//'FlightTime' => '',
					'SingleReturn' => $o->SingleReturn,
					'PayNow' => $PayNow,
					'PayLater' => $PayLater,
					'PaxNote' => CleanUp($o->ArrivalNote),
					//'SubDriverNote' => 
					'FromPlace' => CleanUp($From),
					'FromAddress' => CleanUp($FromAddress),
					'ToPlace' => CleanUp($To),
					'ToAddress' => CleanUp($ToAddress),
					'OrderStatus' => $o->OrderStatusID,
					'Extras'      => $extras
					//'TransferStatus' => 
					//'FinalNote' =>  
				);
	
				XUpdate('TimeTable', $datax, ' ID = '.$tt->ID);
				unset($datax);

			}
			
			if ($i == 2 and $nrf == 2) { // ako je $nrf=2 znaci da postoji i return transfer
			
				if ($o->SingleReturn == 'Return') {
					# upis return transfera

					# upis return transfera
					$dataxx = array(
						//'ID' => '',
						//'OrderID' => $o->OrderID,
						'OrderKey' => $o->OrderKey,
						'OrderPickupDate' => DMY_to_YMD($o->DepartureDate),
						'OrderPickupTime' => $o->DepartureTime,
						'VehicleType' => $VehicleType,
						'PaxNo' => $o->PassengersNo,
						'PickupDate' => DMY_to_YMD($o->DepartureDate),
						//'PickupTime' => $o->DepartureTime,
						'PickupDetails' => CleanUp($o->DepartureDetails),
						//'SubDriver' => '',
						//'Car' => '',
						'PaxName' => CleanUp($PaxName),
						'PaxTel' => $o->OrderTel,
						//'FlightNo' => '',
						//'FlightTime' => '',
						'SingleReturn' => $o->SingleReturn,
						'PayNow' => $PayNow2,
						'PayLater' => $PayLater2,
						'PaxNote' => CleanUp($o->DepartureNote),
						//'SubDriverNote' => 
						'FromPlace' => CleanUp($From2),
						'FromAddress' => CleanUp($FromAddress2),
						'ToPlace' => CleanUp($To2),
						'ToAddress' => CleanUp($ToAddress2),
						'OrderStatus' => $o->OrderStatusID,
						'Extras'      => $extras
						//'TransferStatus' => 
						//'FinalNote' =>  
					);
		
					XUpdate('TimeTable', $dataxx, ' ID = '.$tt->ID);
					unset($dataxx);

				}

			} #end nrf=2

			$i++;
			
        } # end While

    } #end if-else - postoji - ne postoji

} #end While

echo '<div class="alert alert-success"><h2>Sync Completed</h2></div>';

# Clean Up text
function CleanUp($s)
{
    return mysql_real_escape_string($s);
}


# Pretvaranje formata datuma
function DMY_to_YMD($date)
{
    $elementi = explode('.',$date);
    $new_date = $elementi[2].'-'.$elementi[1].'-'.$elementi[0];
    return $new_date;
}


# vraca Route_Id preko ServiceID
function GetRIDFromServiceID($service_id)
{
    $query_Recordset1 = "SELECT RouteID FROM Services WHERE ServiceID = '".$service_id."'";

    $Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
    $row_Recordset1 = mysql_fetch_assoc($Recordset1);

    return $row_Recordset1['RouteID'];
}


# vraca ime terminala ako je poznat routeId
function GetTermFromRID($route_id)
{
    $query_Recordset1 = "SELECT TerminalID FROM Routes WHERE RouteID = '".$route_id."'";

    $Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
    $row_Recordset1 = mysql_fetch_assoc($Recordset1);

    return $row_Recordset1['TerminalID'];
}


# vraca ime destinacije preko Route_Id
function GetDestFromRID($route_id)
{
    $query_Recordset1 = "SELECT DestinationID FROM Routes WHERE RouteID = '".$route_id."'";

    $Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
    $row_Recordset1 = mysql_fetch_assoc($Recordset1);

    return $row_Recordset1['DestinationID'];
}



# vraca ime terminala
function GetTerminalName($term_id)
{

    $query_Recordset1 = "SELECT * FROM Terminals WHERE TerminalID = '".$term_id."'";

    $Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
    $row_Recordset1 = mysql_fetch_assoc($Recordset1);
    #
    return CleanUp($row_Recordset1['TerminalName']);
}


# vraca ime destinacije
function GetDestName($dest_id)
{
    $query_Recordset1 = "SELECT * FROM Destinations WHERE DestinationID = '".$dest_id."'";

    $Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
    $row_Recordset1 = mysql_fetch_assoc($Recordset1);
    #
    return $row_Recordset1['DestinationName'];
}





# vraca VehicleTypeID preko ServiceID
function GetVehicleIDFromServiceID($service_id)
{
    $query_Recordset1 = "SELECT * FROM Services
					     WHERE ServiceID = '".$service_id."'
					     "
					     ;

    $Recordset1 = mysql_query($query_Recordset1) or die(mysql_error());
    $row_Recordset1 = mysql_fetch_assoc($Recordset1);

    return $row_Recordset1['VehicleTypeID'];
}

