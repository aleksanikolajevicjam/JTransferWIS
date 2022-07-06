<?
	session_start();

	require_once ROOT . '/cms/f/csv.class.php';
	require_once ROOT . '/db/db.class.php';
	
	$db = new DataBaseMysql();
	
	// CSV Setup
	$csv = new ExportCSV;
	$csv->File = 'AgentBalance';
	$csv->totalOnCols = array('7');
	
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
	$noshow = 0;
	$driverError = 0;
	$CompletedTransfers = 0;
	$Sistem = 0;
	$noshow = $_REQUEST ['NoShow'];
	$driverError = $_REQUEST['DrErr'];
	$CompletedTransfers = $_REQUEST['CompletedTransfers'];
	$Sistem = $_REQUEST['Sistem'];
		
	#++++++++++++++++++++++++++++++++++++++++++++++++++
	# polazni transferi
	#++++++++++++++++++++++++++++++++++++++++++++++++++

	$q  = " SELECT v4_OrderDetails.*,v4_OrdersMaster.MConfirmFile FROM v4_OrderDetails,v4_OrdersMaster ";

	if($Sistem != 0) { //Ako je sistem onda ide po pickup dateu
		$q .= " WHERE MOrderID=OrderID AND PickupDate >= '{$_REQUEST['StartDate']}' ";
		$q .= " AND PickupDate <= '{$_REQUEST['EndDate']}' ";

	} else { //Za ostale agente ide po datumu rezervacije
		$q .= " WHERE MOrderID=OrderID AND OrderDate >= '{$_REQUEST['StartDate']}' ";
		$q .= " AND OrderDate <= '{$_REQUEST['EndDate']}' ";
	}

		$q .= "AND PaymentMethod = '2' ";
		
	if($CompletedTransfers != 0) { //Samo odvozene transfere
		$q .= "AND TransferStatus = '5' ";

	} else { //Sve ostale
		$q .= " AND TransferStatus != '3' ";
		$q .= " AND TransferStatus != '4' ";
		$q .= " AND TransferStatus != '9' ";
	}

	if($noshow != 1) $q .= " AND DriverConfStatus != '5' ";
	if($driverError != 1) $q .= " AND DriverConfStatus != '6' ";

	if (!empty($_REQUEST['driverid'])) { 
		if (getConnectedUser($_REQUEST['driverid'])>0) $q .= ' AND (UserID = ' . $_REQUEST['driverid'] . '  OR UserID =  '.getConnectedUser($_REQUEST['driverid']). ') '; 
		else $q .= ' AND UserID = ' . $_REQUEST['driverid'] . ' ';
	}

    //$q .= " ORDER BY  PickupDate ASC, UserID ASC, PickupTime ASC";
    $q .= " ORDER BY  OrderID ASC, UserID ASC";
		  
		  
	$e = $db->RunQuery($q);
    
   	$u = getUser($_REQUEST['driverid']);
   	
	echo '<h2>'.$u->AuthUserCompany.getConnectedUserName($_REQUEST['driverid']).'</h2> ' . $_REQUEST['StartDate'] . ' - ' . $_REQUEST['EndDate'] . '<br>';

	if($noshow == 1) echo '<i class="fa fa-plus"></i> No-show ';
	if($driverError == 1) echo '<i class="fa fa-plus"></i> Driver Error <br><br>';
	if($CompletedTransfers == 1) echo '<i class="fa fa-plus"></i> Completed Transfers Only '; 
	if($Sistem == 1) echo '<i class="fa fa-plus"></i> Sistem ';


	echo '<table class="table table-striped" style="white-space: nowrap">';
	
	$i = 0;

	// Delimiter
	$dlm = ";";
	
	# CSV first row
	$csv->addHeader(array(
			'ReferenceNo',	
			'OrderKey',
			'Passenger',
			'PaxNo',
			'Veh.Type',
			'Route',
			'Agent',
			'InvoiceAmt'
			) );	

	
	while( $o = $e->fetch_object() )
	{
		
		echo '<tr>';
		echo '<td>';
		echo $i+1;
		echo '</td><td style="vertical-align:top">';
		echo '<b>' . $o->OrderID.'-'.$o->TNo . '</b>';
        
        echo '</td><td>';
		echo '<b>' . $o->PaxName . '</b> <br/>';
		echo 'Pax: ' . $o->PaxNo;
        echo ' VT: ' . $o->VehicleType . ' pax';

		echo '</td><td>';
		echo '<b>' . $o->PickupName . ' <br> ' . $o->DropName .  '</b><br/>';
		//echo 'Driver: <br/>' . Driver($o->DriverID) . '<br/><br/>';

        echo '</td><td>';
		

			//$total += $o->DetailPrice;
			//$totOnline += $o->PayNow;
			//$totCash += $o->PayLater;
			$totInv += $o->ProvisionAmount;
			$totNetto += $o->DriversPrice * $o->VehiclesNo;
		
			echo ' ' . -number_format($o->ProvisionAmount,2) . ' EUR<br/>';

			# CSV rows
			$csv->addRow(array(
					$o->MConfirmFile,			
					$o->OrderID.'-'.$o->TNo ,
					$o->PaxName,
					$o->PaxNo,
					$o->VehicleType,
					$o->PickupName. '-' . $o->DropName,
					Driver($o->UserID),
					-number_format($o->ProvisionAmount,2)
					));	


		echo '</td></tr>';
		
		$i++;
		
	} # end polazni transferi
    
    echo '</table>';

    echo '<br/>Total transfers: ' . $i;
    echo ' | Total Invoice: ' . -$totInv;

	echo '<div align="left" >';
	echo '<form action="index.php?p=agentsWTransfersCash&StartDate='.
			$_REQUEST['StartDate'].'&EndDate='.$_REQUEST['EndDate'].
			'&NoShow='.$_REQUEST['NoShow'].'&DrErr='.$_REQUEST['DrErr'].'&CompletedTransfers='.$_REQUEST['CompletedTransfers'].'&Sistem='.$_REQUEST['Sistem'].
			'&Submit=1" method="POST">';
	echo '<br/>';
	echo '<input type="submit" class="btn btn-primary" value=" &larr; Back to Agents List" name="reset" />';

	echo '<br/><br/>';
	echo '</div>';
	echo '</form>';
	echo '</div>';	
	

	
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
	echo '<form action="index.php?p=agentsBalance" method="POST">';
	
	echo '<h1>'.AGENTS_BALANCE.'</h1><br>';
	
	echo '<div style="width:100px;display: inline-block">Start Date:</div> 
	        <input type="text" name="StartDate" id="StartDate" value="" size="12" class="datepicker"/>';
	echo '<br/>';
	echo '<div style="width:100px;display: inline-block">End  Date:</div> 
	        <input type="text" name="EndDate" id="EndDate" value="" size="12" class="datepicker"/>';
	
	echo '<br/><br/>';
	echo 'Optional<hr/>';
	echo '<div style="width:100px;display: inline-block">Agent:</div>';
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
    	   WHERE AuthLevelID = '2' 
    	   AND Active = '1' 
    	   ORDER BY AuthUserCompany ASC";
    	   
    $wd = $db->RunQuery($qd);
    
    echo '<select name="driverid" id="driverid">';
    echo '<option value=""> All Agents </option>';
    while ($d = $wd->fetch_object())
    {
        echo '<option value="'.$d->AuthUserID.'">';
        echo trim($d->AuthUserCompany);
        echo '</option>';
    }
    
    echo '</select>';
}
