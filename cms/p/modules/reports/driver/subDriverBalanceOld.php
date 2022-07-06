<?
	@session_start(); 

	require_once ROOT . '/db/db.class.php';

    $DriverID = $_SESSION['AuthUserID'];

	require_once ROOT . '/cms/fixDriverID.php';
	foreach($fakeDrivers as $key => $fakeDriverID) {
		if($DriverID == $fakeDriverID) $DriverID = $realDrivers[$key];   
	}

	$q  = "SELECT * FROM v4_AuthUsers ";
	$q .= "WHERE DriverID = ".$DriverID. " ";
	if(!isset($_POST['all'])) $q .= " AND Active=1 ";
	$q .= " ORDER BY AuthUserRealName ASC";
	
    $w = $db->RunQuery($q);

	echo '<div class="container white center">';

	//ispis headera
    $today=date("Y-m-d");
	showHeader($today);

	// CASH-IN Ostalo od boge subdriver1-2-3 treba vuci samo sub1, jer prvi vozac naplacuje transfer
	$q1  = "SELECT SubDriver, SUM(CashIn) AS Primljeno FROM v4_OrderDetails ";
	$q1 .= "WHERE PickupDate >= '2018-08-01' AND PickupDate < '".$today."'";	
	$q1 .= " GROUP BY SubDriver ";			
	$w1 = $db->RunQuery($q1);
	$orders_arr=array();
	while($od = $w1->fetch_object()) {
		$o_arr=array();
		$o_arr['SubDriver']=$od->SubDriver;
		$o_arr['Primljeno']=$od->Primljeno;
		$orders_arr[]=$o_arr;
	}
	// CASH-IN for today
	$q4  = "SELECT SubDriver, SUM(CashIn) AS Primljeno FROM v4_OrderDetails ";
	$q4 .= "WHERE PickupDate = '".$today."'";	
	$q4 .= " GROUP BY SubDriver ";		

	$w4 = $db->RunQuery($q4);
	$orders_arr2=array();
	while($od2 = $w4->fetch_object()) {
		$o_arr2=array();
		$o_arr2['SubDriver']=$od2->SubDriver;
		$o_arr2['Primljeno']=$od2->Primljeno;
		$orders_arr2[]=$o_arr2;
	}
	// CASH PLAN for today
	$q6  = "SELECT SubDriver, SUM(PayLater) AS CashPlan FROM v4_OrderDetails ";
	$q6 .= "WHERE PickupDate = '".$today."'";	
	$q6 .= " GROUP BY SubDriver ";			
	$w6 = $db->RunQuery($q6);
	$orders_arr3=array();
	while($od3 = $w6->fetch_object()) {
		$o_arr3=array();
		$o_arr3['SubDriver']=$od3->SubDriver;
		$o_arr3['CashPlan']=$od3->CashPlan;
		$orders_arr3[]=$o_arr3;
	}	
	
	// CASH EXPENSES
	$q2  = "SELECT DriverID, SUM(Amount) AS Trosak FROM v4_SubExpenses WHERE Card = 0 ";
	$q2 .= "AND Datum >= '2018-08-01' AND Datum < '".$today."' AND Approved=1";	
	$q2 .= " GROUP BY DriverID ";			
	
	$w2 = $db->RunQuery($q2);
	$expenses_arr=array();
	while($ex = $w2->fetch_object()) {
		$ex_arr=array();
		$ex_arr['DriverID']=$ex->DriverID;
		$ex_arr['Trosak']=$ex->Trosak;
		$expenses_arr[]=$ex_arr;
	}

	// CASH EXPENSES TODAY
	$q5  = "SELECT DriverID, SUM(Amount) AS Trosak FROM v4_SubExpenses WHERE Card = 0 ";
	$q5 .= "AND Datum = '".$today."' AND Approved=1";	
	$q5 .= " GROUP BY DriverID ";			
	
	$w5 = $db->RunQuery($q5);
	$expenses_arr3=array();
	while($ex3 = $w5->fetch_object()) {
		$ex_arr3=array();
		$ex_arr3['DriverID']=$ex3->DriverID;
		$ex_arr3['Trosak']=$ex3->Trosak;
		$expenses_arr3[]=$ex_arr3;
	}
	
	// Unapproved CASH EXPENSES
	$q3  = "SELECT DriverID, SUM(Amount) AS Trosak FROM v4_SubExpenses WHERE Card = 0 AND Approved = 0 ";
	$q3 .= "AND Datum >= '2018-08-01'"; 
	$q3 .= " GROUP BY DriverID ";			
	
	$w3 = $db->RunQuery($q3);
	$expenses_arr2=array();
	while($ex2 = $w3->fetch_object()) {
		$ex_arr2=array();
		$ex_arr2['DriverID']=$ex2->DriverID;
		$ex_arr2['Trosak']=$ex2->Trosak;
		$expenses_arr2[]=$ex_arr2;
	}
	
	// Recived CASH 
	$q7  = "SELECT v4_Actions.ReciverID AS RID, SUM(Amount) AS Trosak FROM v4_SubExpenses,v4_Actions WHERE v4_SubExpenses.Expense=v4_Actions.ID and v4_Actions.ReciverID>0 ";
	$q7 .= "AND Datum >= '2018-08-01'"; 
	$q7 .= "AND Approved =1 "; 
	$q7 .= " GROUP BY v4_Actions.ReciverID ";			
	
	$w7 = $db->RunQuery($q7);
	while($ex7 = $w7->fetch_object()) {
		$rc_arr=array();
		$rc_arr['DriverID']=$ex7->RID;
		$rc_arr['Trosak']=$ex7->Trosak;
		$rcash_arr[]=$rc_arr;
	}
	
	// POLOG
	/*$q8  = "SELECT DriverID, SUM(Amount) AS Trosak FROM v4_SubExpenses WHERE Expense=8 ";
	$q8 .= "AND Datum >= '2018-08-01'"; 
	$q8 .= " GROUP BY DriverID ";			
	
	$w8 = $db->RunQuery($q8);
	$deposit_arr=array();
	while($ex8 = $w8->fetch_object()) {
		$plg=array();
		$plg['DriverID']=$ex8->DriverID;
		$plg['Trosak']=$ex8->Trosak;
		$deposit_arr[]=$plg;
	}	*/
	
	//print_r($rcash_arr);
	//exit();
	
    while($d = $w->fetch_object()) { //ispis reporta ako je pocetno stanje vece od nule $d->Balance

			$subDriverID = $d->AuthUserID;


			//DOHVACANJE IZNOSA
			$key = array_search($subDriverID, array_column($orders_arr, 'SubDriver'));
			if ($key>-1) $Primljeno = $orders_arr[$key]['Primljeno'];			
			else $Primljeno = number_format(0,2);
					
	        // CASH-IN Ostalo od boge subdriver1-2-3 treba vuci samo sub1, jer prvi vozac naplacuje transfer
	        /*$q1  = "SELECT SUM(CashIn) AS Primljeno FROM v4_OrderDetails ";
	        $q1 .= "WHERE SubDriver = '" . $subDriverID ."' ";
	        $q1 .= "AND PickupDate >= '2018-08-01' AND PickupDate < '".$today."'";

	        $w1 = $db->RunQuery($q1);
	        $p1 = $w1->fetch_object();*/

			$key2 = array_search($subDriverID, array_column($orders_arr2, 'SubDriver'));
			if ($key2>-1) $Primljeno2 = $orders_arr2[$key2]['Primljeno'];			
			else $Primljeno2 = number_format(0,2);

	        // CASH-IN for today 
	        /*$q14  = "SELECT SUM(CashIn) AS Primljeno FROM v4_OrderDetails ";*
	        $q14 .= "WHERE SubDriver = '" . $subDriverID ."' ";
	        $q14 .= "AND PickupDate = '".$today."'";

	        $w12 = $db->RunQuery($q14);
	        $p12 = $w12->fetch_object();*/

	        // CASH EXPENSES
			$key3 = array_search($subDriverID, array_column($expenses_arr, 'DriverID'));
			if ($key3>-1) $Trosak = $expenses_arr[$key3]['Trosak'];			
			else $Trosak = number_format(0,2);
			
			
	        /*$q2  = "SELECT SUM(Amount) AS Trosak FROM v4_SubExpenses WHERE Card = 0 ";
	        $q2 .= "AND DriverID = '" . $subDriverID ."' ";
	        $q2 .= "AND Datum >= '2018-08-01' AND Datum < '".$today."'";
	
	        $w2 = $db->RunQuery($q2);
	        $p2 = $w2->fetch_object();*/

	        // CASH EXPENSES TODAY
			$key5 = array_search($subDriverID, array_column($expenses_arr3, 'DriverID'));
			if ($key5>-1) $Trosak3 = $expenses_arr3[$key5]['Trosak'];			
			else $Trosak3 = number_format(0,2);
			
			// CASH PLAN TODAY
			$key6 = array_search($subDriverID, array_column($orders_arr3, 'SubDriver'));
			if ($key6>-1) $CashPlan = $orders_arr3[$key6]['CashPlan'];			
			else $CashPlan = number_format(0,2);


	        // Unapproved CASH EXPENSES
			$key4 = array_search($subDriverID, array_column($expenses_arr2, 'DriverID'));
			if ($key4>-1) $Trosak2 = $expenses_arr2[$key4]['Trosak'];			
			else $Trosak2 = number_format(0,2);
			
	        /*$q3  = "SELECT SUM(Amount) AS Trosak FROM v4_SubExpenses WHERE Card = 0 AND Approved = 0 ";
	        $q3 .= "AND DriverID = '" . $subDriverID ."' ";
	        $q3 .= "AND Datum >= '2018-08-01'";
	
	        $w3 = $db->RunQuery($q3);
	        $p3 = $w3->fetch_object();*/

	        // Recived CASH 
			$key7 = array_search($subDriverID, array_column($rcash_arr, 'DriverID'));
			if ($key7>-1) $RCash = $rcash_arr[$key7]['Trosak'];			
			else $RCash = number_format(0,2);
			

	        // Deposit
			/*$key8 = array_search($subDriverID, array_column($deposit_arr, 'DriverID'));
			if ($key8>-1) $Deposit = $deposit_arr[$key8]['Trosak'];			
			else $Deposit = number_format(0,2);*/
			
			$UnapprovedExpenses = $Trosak2;
	        $Balance = $Primljeno - $Trosak + $d->Balance;			
	        $BalanceT = $Balance + $Primljeno2 - $Trosak3;
			$BalanceT2 = $BalanceT + $RCash;
 
			if((nf($BalanceT2) != 0 && !isset($_POST['all'])) || isset($_POST['all'])){?>
				<div class="row" style="border-bottom:1px solid #000;">

					<div class="col-md-2 pad1em">
						<strong><?=$d->AuthUserID?></strong> - <?=$d->AuthUserRealName?>
					</div>

					<div class="col-md-1 pad1em">
						<?= nf($d->Balance) ?> 
					</div>

					<div class="col-md-1 pad1em">
						<?= nf($Balance) ?> 
					</div>
					
					<div class="col-md-1 pad1em">
						<? echo $CashPlan ?> 
					</div>
					
					<div class="col-md-1 pad1em">
						<? echo $Primljeno2; ?> 
					</div>
					
					<div class="col-md-1 pad1em">
						<? echo $Trosak3; ?> 				
					</div>
					 
					<div class="col-md-1 pad1em">
						<?= nf($UnapprovedExpenses) ?>
					</div>

					<div class="col-md-1 pad1em">
						<?= nf($BalanceT) ?> 
					</div>

					<div class="col-md-1 pad1em">
						<?= nf($RCash) ?> 
					</div>
					
					<div class="col-md-1 pad1em">
						<?= nf($BalanceT2) ?> 
					</div>					
				</div>
		<?}
	}



	function showHeader($today) { 

		global $DriverID;
		$driver = getUser($DriverID);
 	    ?>
        <h2>SubDriver Balance Report (EUR)</h2>
        <h2><?=$driver->AuthUserRealName; ?></h2>
		<? if(!isset($_POST['all'])){?>
			<form action="index.php?p=sdb" method="POST">
				<input type="submit" name='all' value='ALL'/> 
			</form>
		<? }?>			
		<div class="row" style="border-bottom:1px solid #000;">
		    <div class="col-md-2">
		        <strong>ID - Subdriver</strong>
		    </div>
		    <div class="col-md-1">
		        <strong>Deposit </strong>
		    </div>
		    <div class="col-sm-1 ">
		        <strong>Balance <br>(until <? echo $today; ?>)</strong>
		    </div>	
		    <div class="col-sm-3 ">
				<div class="col-sm-12 ">
					<strong>Cash (<? echo $today; ?>)</strong>
				</div>					
				<div class="col-sm-4 ">
					<strong>Plan</strong>
				</div>				
				<div class="col-sm-4 ">
					<strong>In</strong>
				</div>				
				<div class="col-sm-4 ">
					<strong>Expenses</strong>
				</div>		
			</div>
		    <div class="col-sm-1">
		        <strong>Unapproved Expenses </strong> 
		    </div>
		    <div class="col-sm-1 ">
		        <strong>Balance total</strong>
		    </div>				
			<div class="col-sm-1 ">
		        <strong>Recived cash</strong>
		    </div>				
			<div class="col-sm-1 ">
		        <strong>Balance total2</strong>
		    </div>			
		</div>
				
	    <?
	}?>
