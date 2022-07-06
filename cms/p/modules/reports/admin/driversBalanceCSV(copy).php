<?
	session_start();

	require_once ROOT . '/cms/f/csv.class.php';
	require_once ROOT . '/db/db.class.php';
	
	$db = new DataBaseMysql();
	
	// CSV Setup
	$csv = new ExportCSV;
	$csv->File = 'DriverBalance';
	$csv->totalOnCols = array('7','8','9');
	
?>
<body>
<div class="container white">
<? 

if (isset($_REQUEST['reset']) and $_REQUEST['reset'] != 0) $_REQUEST = array();	
	
if (isset($_REQUEST['StartDate']) and isset($_REQUEST['EndDate']))
{

	$total = 0;
	$totOnline = 0;
	$totCash = 0;
	$totInv = 0;
	$totNetto = 0;
	$toPay = 0;
	$weOwe = 0;
		
	#++++++++++++++++++++++++++++++++++++++++++++++++++
	# polazni transferi
	#++++++++++++++++++++++++++++++++++++++++++++++++++
	$q  = " SELECT * FROM v4_OrderDetails ";
	$q .= " WHERE PickupDate >= '{$_REQUEST['StartDate']}' ";
	$q .= " AND PickupDate <= '{$_REQUEST['EndDate']}' ";
	$q .= " AND TransferStatus != '3' ";
	$q .= " AND TransferStatus != '4' ";
	$q .= " AND TransferStatus != '9' ";
	$q .= " AND TNo = '1' ";
	//$q .= " AND PayLater  = 0 "; // samo ne-cash transferi
	$q .= " AND PayLater <= DriversPrice ";

	if (!empty($_REQUEST['driverid'])) 
	$q .= ' AND DriverID = ' . $_REQUEST['driverid'] . ' ';

    $q .= " ORDER BY  PickupDate ASC, DriverID ASC, PickupTime ASC";
		  
	$e = $db->RunQuery($q);
    
   	
	echo '<h2>'.DRIVERS_BALANCE .' - OTHER ' . $_REQUEST['StartDate'] . ' - ' . $_REQUEST['EndDate'] . '</h2><br>';
	
	echo '<table class="table table-striped" style="font-size:0.8em">';
	
	$i = 0;

	// Delimiter
	$dlm = ";";
	
	# CSV first row
	$csv->addHeader(array(
			'OrderKey',
			'Passenger',
			'PaxNo',
			'Veh.Type',
			'Route',
			'DriverName',
			'Cash',
			'DriverPrice',
			'Balance'
			) );	

	
	while( $o = $e->fetch_object() )
	{
		
		echo '<tr>';
		echo '<td style="vertical-align:top;white-space: nowrap;">';
		echo '<b>' . $o->OrderID.'-'.$o->TNo . '</b>';
        
        echo '</td><td style="vertical-align:top;white-space: nowrap;">';
		echo '<b>' . $o->PaxName . '</b> <br/>';
		echo 'Pax: ' . $o->PaxNo;
        echo ' VT: ' . $o->VehicleType . ' pax <br>';
        echo ' Date: ' . $o->PickupDate;

		echo '</td><td>';
		echo '<b>' . $o->PickupName . ' <br> ' . $o->DropName .  '</b><br/>';
		echo 'Driver: ' . Driver($o->DriverID);

        echo '</td><td style="vertical-align:top;white-space: nowrap;">';
		

			$total += $o->DetailPrice;
			$totOnline += $o->PayNow;
			$totCash += $o->PayLater;
			$totInv += $o->InvoiceAmount;
			$totNetto += $o->DriversPrice * $o->VehiclesNo;
			$balance += $o->PayLater - $o->DriversPrice;
			$balanceShow = $o->PayLater - $o->DriversPrice;
		
			echo ' Cash: ' . number_format($o->PayLater,2) . ' EUR<br/>';
			echo ' Driver: ' . number_format($o->DriversPrice,2) . ' EUR<br/>';
			echo ' Balance: ' .number_format($balanceShow,2) . ' EUR';

			# CSV rows
			$csv->addRow(array(
					$o->OrderID.'-'.$o->TNo ,
					$o->PaxName,
					$o->PaxNo,
					$o->VehicleType,
					$o->PickupName. '-' . $o->DropName,
					Driver($o->DriverID),
					number_format($o->PayLater,2),
					number_format($o->DriversPrice,2),
					number_format($balanceShow,2))
					);	


		echo '</td></tr>';
		
		$i++;
		
	} # end polazni transferi
	
	
	
	#++++++++++++++++++++++++++++++++++++++++++++++++++
	# return transferi
	#++++++++++++++++++++++++++++++++++++++++++++++++++
	$q  = " SELECT * FROM v4_OrderDetails ";
	$q .= " WHERE PickupDate >= '{$_REQUEST['StartDate']}' ";
	$q .= " AND PickupDate <= '{$_REQUEST['EndDate']}' ";
	$q .= " AND TransferStatus != '3' ";
	$q .= " AND TransferStatus != '4' ";
	$q .= " AND TransferStatus != '9' ";	
	$q .= " AND TNo = '2' ";
	//$q .= " AND PayLater = 0 "; // samo ne-cash transferi
	$q .= " AND PayLater <= DriversPrice ";	

	if (!empty($_REQUEST['driverid'])) 
	$q .= ' AND DriverID = ' . $_REQUEST['driverid'] . ' ';

    $q .= " ORDER BY  PickupDate ASC, DriverID ASC, PickupTime ASC";
		  
	$e = $db->RunQuery($q);
    
   	

	


	
	while( $o = $e->fetch_object() )
	{
		
		echo '<tr>';
		echo '<td style="vertical-align:top;white-space: nowrap;">';
		echo '<b>' . $o->OrderID.'-'.$o->TNo . '</b>';
        
        echo '</td><td>';
		echo '<b>' . $o->PaxName . '</b> <br/>';
		echo 'Pax: ' . $o->PaxNo;
        echo ' VT: ' . $o->VehicleType . ' pax <br>';
        echo ' Date: ' . $o->PickupDate;

		echo '</td><td>';
		echo '<b>' . $o->PickupName . ' <br> ' . $o->DropName .  '</b><br/>';
		echo 'Driver: ' . Driver($o->DriverID) . '<br/><br/>';

        echo '</td><td style="vertical-align:top;white-space: nowrap;">';
		

			$total += $o->DetailPrice;
			$totOnline += $o->PayNow;
			$totCash += $o->PayLater;
			$totInv += $o->InvoiceAmount;
			$totNetto += $o->DriversPrice * $o->VehiclesNo;
			$balance += $o->PayLater - $o->DriversPrice;
			$balanceShow = $o->PayLater - $o->DriversPrice;
		
			echo ' Cash: ' . number_format($o->PayLater,2) . ' EUR<br/>';
			echo ' Driver: ' . number_format($o->DriversPrice,2) . ' EUR<br/>';
			echo ' Balance: ' .number_format($balanceShow,2) . ' EUR<br/>';

			# CSV rows
			$csv->addRow(array(
					$o->OrderID.'-'.$o->TNo ,
					$o->PaxName,
					$o->PaxNo,
					$o->VehicleType,
					$o->PickupName. '-' . $o->DropName,
					Driver($o->DriverID),
					number_format($o->PayLater,2),
					number_format($o->DriversPrice,2),
					number_format($balanceShow,2))
					);	


		echo '</td></tr>';
		
		$i++;
		
	} # end polazni transferi	
	
    
    echo '</table>';

    echo '<br/>Total transfers: ' . $i;
    echo ' | Total Cash: ' . number_format($totCash, 2);
    echo ' | Total Driver: ' . number_format($totNetto, 2);
    echo ' | Total Balance: <strong>' . number_format($balance, 2) . 'EUR </strong>';
    echo '<br><br><strong>* Important Note:</strong>';
    echo '<br> negative balance means that JamTransfer owes this amount to Driver.';
    echo '<br> positive Balance means that Driver owes this amount to JamTransfer.';
	echo '<div align="left" >';
	echo '<form action="index.php?p=driversWTransfers&StartDate='.$_REQUEST['StartDate'].'&EndDate='.$_REQUEST['EndDate'].'&Submit=1" method="POST">';
	echo '<br/>';
	echo '<input type="submit" class="btn btn-primary" value=" &larr; Back to Drivers List" name="reset" />';
	
	
/*
	if($_REQUEST['driverid'] > 0) {
		echo '<a class="btn btn-danger l" style="float:right;color:white !important" 
				href="index.php?p=invoiceSum&d='.$_REQUEST['driverid'].
				'&s='.$_REQUEST['StartDate'].
				'&e='.$_REQUEST['EndDate'].
				'&Submit=1" target="_blank"><i class="fa fa-cogs"></i> Create Invoice</a>';

		echo '<br/><br/>';
		echo '</form>';
		echo '</div>';	
	}
*/
	
	$csv->addTotalRow();
	$csv->save();

//	$fp = fopen($fileName.'.csv', 'w');
//	fwrite($fp, $CSV);
//	fclose($fp);
	
	echo '<hr><h4>Exported to CSV!</h4>';
	echo '<small>';
	echo '<a href="'.$csv->File.$csv->Extension.'" class="btn btn-default"><i class="fa fa-download"></i> Download CSV</a>';
	echo ' You can download CSV file here (or Right-Click->Save). ';
	echo ' <b>File format:</b> UTF-8, semi-colon (;) delimited</small>';	

	echo '</div>';		
	
	
}
else
{

	echo '<div align="left" style="padding: 10px;" >';
	echo '<form action="index.php?p=driversBalance" method="POST">';
	
	echo '<h1>'.DRIVERS_BALANCE.' - OTHER</h1><br>';
	
	echo '<div style="width:100px;display: inline-block">Start Date:</div> 
	        <input type="text" name="StartDate" id="StartDate" value="" size="12" class="datepicker"/>';
	echo '<br/>';
	echo '<div style="width:100px;display: inline-block">End  Date:</div> 
	        <input type="text" name="EndDate" id="EndDate" value="" size="12" class="datepicker"/>';
	
	echo '<br/><br/>';
	echo 'Optional<hr/>';
	echo '<div style="width:100px;display: inline-block">Driver:</div>';
	PickDriver();
	echo '<br/><br/>';
	echo '<input type="submit" value=" Show transfers " name="submit" />';
	echo '</form>';
	echo '</div>';
}

echo '</body></html>';



#
# hidden polja
#
function hiddenField($name,$value)
{
	echo '<input name="'.$name.'" id="'.$name.'" type="hidden" value="'.$value.'" />';
}

function Driver($driverid)
{
    if (!empty($driverid))
    {
		$data = getUserData($driverid);
		
		return $data['AuthUserCompany'];
    }
    else return '<b>None</b>';
}


function PickDriver()
{
    global $db;
    
    $qd = "SELECT * FROM v4_AuthUsers 
    	   WHERE AuthLevelID = '31' 
    	   AND Active = '1' 
    	   ORDER BY Country ASC, Terminal ASC, AuthUserCompany ASC";
    	   
    $wd = $db->RunQuery($qd);
    
    echo '<select name="driverid" id="driverid">';
    echo '<option value=""> All Drivers </option>';
    while ($d = $wd->fetch_object())
    {
        echo '<option value="'.$d->AuthUserID.'">';
        echo trim($d->Country).' - '.trim($d->Terminal).' - '.trim($d->AuthUserCompany);
        echo '</option>';
    }
    
    echo '</select>';
}

function query_to_csv($db_conn, $query, $filename, $attachment = false, $headers = true) {
        
        if($attachment) {
            // send response headers to the browser
            header( 'Content-Type: text/csv' );
            header( 'Content-Disposition: attachment;filename='.$filename);
            $fp = fopen('php://output', 'w');
        } else {
            $fp = fopen($filename, 'w');
        }
        
        $result = mysql_query($query, $db_conn) or die( mysql_error( $db_conn ) );
        
        if($headers) {
            // output header row (if at least one row exists)
            $row = mysql_fetch_assoc($result);
            if($row) {
                fputcsv($fp, array_keys($row));
                // reset pointer back to beginning
                mysql_data_seek($result, 0);
            }
        }
        
        while($row = mysql_fetch_assoc($result)) {
            fputcsv($fp, $row);
        }
        
        fclose($fp);
    }
    


