<?
	$data = '';

	$db = new DataBaseMysql();
	
	date_default_timezone_set("Europe/Paris");		
	$timeStart=date('H:i',time()-7200);
	$timeEnd=date('H:i',time()+10800);
	$query= "SELECT * FROM v4_OrderDetails
				WHERE PickupDate = '".date('Y-m-d')."' 
				AND PickupTime>'".$timeStart."' 
				AND PickupTime<'".$timeEnd."'
				AND TransferStatus not in (3,4,9)
				ORDER BY PickupDate, PickupTime ASC
				";
	$result = $db->RunQuery($query); 

	$noOfTransfers = 0;

	while($row = $result->fetch_array(MYSQLI_ASSOC)){ 

    	# No Driver Alert
    	$driver = '<span style="color: #c00"><i class="fa fa-question"></i></span> ';

		if ($row['TransferStatus'] != '3') $noOfTransfers += 1;

		/*
		TransferStatus:
			1 = Active
			2 = Changed
			3 = Cancelled
			4 = TEMP
			5 = Completed
		*/
		if ($row['TransferStatus'] == '1') $driver = '<span class="text-blue"><i class="fa fa-circle-o"></i></span> ';
		if ($row['TransferStatus'] == '2') $driver = '<span class="text-orange"><i class="fa fa-circle-o"></i></span> ';
		if ($row['TransferStatus'] == '3') $driver = '<span style="color: #c00"><i class="fa fa-times-circle"></i></span> ';
		if ($row['TransferStatus'] == '4') $driver = '<span class="text-orange"><i class="fa fa-question-circle"></i></span> ';
		if ($row['TransferStatus'] == '5') $driver = '<span class="text-green"><i class="fa fa-check-circle"></i></span> ';

		/*
		DriverConfStatus:
			0 = No driver
			1 = Not Confirmed
			2 = Confirmed
			3 = Ready
			4 = Declined
			5 = No-show
			6 = Driver error
			7 = Completed
		*/
		if ($row['DriverConfStatus'] == '0') $driver .= '<span style="color:#c00"><i class="fa fa-car"></i></span> ';
		if ($row['DriverConfStatus'] == '1') $driver .= '<span class="text-orange"><i class="fa fa-info-circle"></i></span> ';
		if ($row['DriverConfStatus'] == '2') $driver .= '<span class="text-blue"><i class="fa fa-thumbs-up"></i></span> ';
		if ($row['DriverConfStatus'] == '3') $driver .= '<span class="text-blue"><i class="fa fa-car"></i></span> ';
		if ($row['DriverConfStatus'] == '4') $driver .= '<span style="color:#c00"><i class="fa fa-thumbs-down"></i></span> ';
		if ($row['DriverConfStatus'] == '5') $driver .= '<span style="color:#c00"><i class="fa fa-user-times"></i></span> ';
		if ($row['DriverConfStatus'] == '6') $driver .= '<span style="color:#c00"><i class="fa fa-black-tie"></i></span> ';
		if ($row['DriverConfStatus'] == '7') $driver .= '<span class="text-green"><i class="fa fa-check-square"></i></span> ';

   	    # Tooltip Setup
  	    $ttip = NL.
   	            PICKUP_TIME.': '.$row['PickupTime'].NL.
   	            FLIGHT_NO.': '.$row['FlightNo'].NL.
   	            FLIGHT_TIME.': '.$row['FlightTime'].NL.
   	            FROM.': '.$row['PickupName'].NL.
   	            TO.': '.$row['DropName'].NL.
   	            DRIVER.': '.$row['DriverName'].NL.
   	            TRANSFER_STATUS .': '. $StatusDescription[$row['TransferStatus']].NL.
   	            $DriverConfStatus[$row['DriverConfStatus']];

		if ($row['ExtraCharge'] > 0) $ttip .= NL."<i class='fa fa-cubes'></i> Extra services";

		$ttip .= NL.NL;

   	    # Pickup Time
    	$data .=    $driver . $row['PickupTime'] . ' &rarr; ';


        # Link & Tooltip
        $data .=    '<a href="index.php?p=editActiveTransfer&rec_no='.
		            $row['DetailsID'].
		            '" title="<b>'.$row['OrderID'] . '-'.$row['TNo'] .' - '. $row['PaxName'] . '</b>" 
		            data-content="'. str_replace('"', '',$ttip) .'" 
		            class="mytooltip">' .
	                $row['OrderID'] . '-'.$row['TNo'] . 
	                '</a>';
		$data .= ' <span>'. $row['PickupName'] .'-'. $row['DropName']  .'</span><br/>';
	}
	$data .= '<br><small style="font-size:14px">No of transfers: '.$noOfTransfers.'</small>';
	$smarty->assign('timeStart',$timeStart);
	$smarty->assign('timeEnd',$timeEnd);
	$smarty->assign('today',date('Y-m-d'));
	$smarty->assign('data',$data);
	