<?

    if(isset($_REQUEST['year'])) $year = $_REQUEST['year'];
    else $year = date("Y");

?>
    <div class="container center">
    <h2>Transfers - by Month</h2>
        <form action="" method="post">
            Year: <input type="text" name="year" value="<?=$year?>">
        </form>
    </div>
    <div class="container center s">NOTE: Selected by Pickup Date. Cancelled and Temp transfers not shown.</div><br><br>
<?
    
    
    error_reporting(0);
    
    require_once ROOT . '/db/db.class.php';
    
    $db = new DataBaseMySql();

    $DriverID = $_SESSION['AuthUserID'];

	require_once ROOT . '/cms/fixDriverID.php';
	foreach($fakeDrivers as $key => $fakeDriverID) {
		if($DriverID == $fakeDriverID) $DriverID = $realDrivers[$key];   
	}

    // summary fields
    // month
    $totalTransfersMonth = 0;
    $premiumTransfersMonth = 0;
    $firstClassTransfersMonth = 0;
    $totalCashMonth = 0;
    $totalCardMonth = 0;
    $totalAgentMonth = 0;
    // total
    $totalTransfers = 0;
    $premiumTransfers = 0;
    $firstClassTransfers = 0;
    $totalCash = 0;
    $totalCard = 0;
    $totalAgent = 0;

    $months = array();
    
        
    $q  = "SELECT * FROM v4_OrderDetails ";
    $q .= "WHERE DriverID = '" . $DriverID . "' ";
    $q .= "AND PickupDate >= '" . $year . "-01-01' ";
    $q .= "AND PickupDate <= '" . $year . "-12-31' ";
    $q .= "AND TransferStatus != '3' ";
    $q .= "AND TransferStatus != '4' ";
    $q .= "AND TransferStatus != '9' ";
    $q .= "ORDER BY PickupDate ASC";

    $w = $db->RunQuery($q);
    
    while($d = $w->fetch_object()) {
        
        $month = date("m", strtotime($d->PickupDate));

        $totalTransfersMonth = 0;
        $premiumTransfersMonth = 0;
        $firstClassTransfersMonth = 0;
        $totalCashMonth = 0;
        $totalCardMonth = 0;
        $totalAgentMonth = 0;  
        
        if(array_key_exists($month, $months)) {
            $totalTransfersMonth = $months[$month]['totalTransfersMonth'];
            $premiumTransfersMonth = $months[$month]['premiumTransfersMonth'];
            $firstClassTransfersMonth = $months[$month]['firstClassTransfersMonth'];
            $totalCashMonth = $months[$month]['totalCashMonth'];
            $totalCardMonth = $months[$month]['totalCardMonth'];
            $totalAgentMonth = $months[$month]['totalAgentMonth'];
        } 
        
        $totalTransfersMonth += 1;
        if($d->VehicleType >= 100 and $d->VehicleType < 200) $premiumTransfersMonth += 1;
        if($d->VehicleType >= 200) $firstClassTransfersMonth += 1;
        $totalCashMonth += $d->PayLater;
        $totalCardMonth += $d->PayNow;
        $totalAgentMonth += $d->InvoiceAmount;       
        
        
        $months[$month] = array(
            "totalTransfersMonth" => $totalTransfersMonth,
            "premiumTransfersMonth" => $premiumTransfersMonth,
            "firstClassTransfersMonth" => $firstClassTransfersMonth,
            "totalCashMonth" => $totalCashMonth,
            "totalCardMonth" => $totalCardMonth,
            "totalAgentMonth" => $totalAgentMonth
        );
    }// end while
    
    // headers
    echo '<div class="container-fluid white"><br><br>';

        echo '<div class="row pad1em">';
            
            echo '<div class="col-md-2 right">';
                echo $year . '.';
            echo '</div>';

            echo '<div class="col-md-1 right">';
                echo 'Tot.Trans.';
            echo '</div>';

            echo '<div class="col-md-1 right">';
                echo 'Premium';
            echo '</div>';
            
            echo '<div class="col-md-1 right">';
                echo 'FirstClass';
            echo '</div>';
            
            echo '<div class="col-md-1 right">';
                echo 'Cash';
            echo '</div>';
            
            echo '<div class="col-md-1 right">';
                echo 'Card';
            echo '</div>';
            
            echo '<div class="col-md-1 right">';
                echo 'Invoice';
            echo '</div>';                                                 

            echo '<div class="col-md-1 right">';
                echo 'Total';
            echo '</div>';  
            
        echo '</div>';

    
    // details
    foreach($months as $month => $data) {
        
        echo '<div class="row pad1em" style="border-top:1px solid #eee">';
            
            echo '<div class="col-md-2 right">';
                echo $month.'.';
            echo '</div>';

            echo '<div class="col-md-1 right">';
                echo $data['totalTransfersMonth'];
            echo '</div>';

            echo '<div class="col-md-1 right">';
                echo $data['premiumTransfersMonth'];
            echo '</div>';
            
            echo '<div class="col-md-1 right">';
                echo $data['firstClassTransfersMonth'];
            echo '</div>';
            
            echo '<div class="col-md-1 right">';
                echo nf( $data['totalCashMonth'] );
            echo '</div>';
            
            echo '<div class="col-md-1 right">';
                echo nf( $data['totalCardMonth'] );
            echo '</div>';
            
            echo '<div class="col-md-1 right">';
                echo nf( $data['totalAgentMonth'] );
            echo '</div>';                                                 
            
            echo '<div class="col-md-1 right">';
                $totalMonth = $data['totalCashMonth'] + $data['totalCardMonth'] + $data['totalAgentMonth'];
                echo nf( $totalMonth );
            echo '</div>';              
        echo '</div>';
        
        $totalTransfers += $data['totalTransfersMonth'];
        $premiumTransfers += $data['premiumTransfersMonth'];
        $firstClassTransfers += $data['firstClassTransfersMonth'];
        $totalCash += $data['totalCashMonth'];
        $totalCard += $data['totalCardMonth'];
        $totalAgent += $data['totalAgentMonth'];        
    }

    
        // totals
        echo '<div class="row blue lighten-3 pad1em">';
            
            echo '<div class="col-md-2 right">';
            echo '</div>';

            echo '<div class="col-md-1 right">';
                echo $totalTransfers;
            echo '</div>';

            echo '<div class="col-md-1 right">';
                echo $premiumTransfers;
            echo '</div>';
            
            echo '<div class="col-md-1 right">';
                echo $firstClassTransfers;
            echo '</div>';
            
            echo '<div class="col-md-1 right">';
                echo nf( $totalCash);
            echo '</div>';
            
            echo '<div class="col-md-1 right">';
                echo nf( $totalCard  );
            echo '</div>';
            
            echo '<div class="col-md-1 right">';
                echo nf( $totalAgent );
            echo '</div>';                                                 

            echo '<div class="col-md-1 right">';
                echo nf( $totalCash + $totalCard  + $totalAgent );
            echo '</div>';  
                        
        echo '</div>';    

    echo '</div><br><br>';


    

