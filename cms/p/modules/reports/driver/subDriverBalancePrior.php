<?
	@session_start(); 
	if(!isset($_REQUEST['requestedday'])) $_REQUEST['requestedday']=date("Y-m-d");
	echo "
		<div class='container'>
			<form action='index.php?p=sdbp' method='POST'>
				<h4><div style='display:inline-block'>Subdriver balance on date: </div> 
				<input class='datepicker' name='requestedday' value='".$_REQUEST['requestedday']."'>			
				<input type='submit' name='set' value='SET'/></h4>
			</form>
		</div>
	";
	
	if(isset($_REQUEST['requestedday'])){
		require_once ROOT . '/db/db.class.php';

		$DriverID = $_SESSION['AuthUserID'];

		require_once ROOT . '/cms/fixDriverID.php';
		foreach($fakeDrivers as $key => $fakeDriverID) {
			if($DriverID == $fakeDriverID) $DriverID = $realDrivers[$key];   
		}

		$q  = "SELECT * FROM v4_AuthUsers ";
		$q .= "WHERE DriverID = ".$DriverID. " ";
		$q .= " AND Active=1 ";
		$q .= " ORDER BY AuthUserRealName ASC";
		
		$w = $db->RunQuery($q);

		echo '<div class="container white center">';
		
		//ispis headera
		$requestedday=$_REQUEST['requestedday'];
		showHeader($requestedday);

		// CASH-IN Ostalo od boge subdriver1-2-3 treba vuci samo sub1, jer prvi vozac naplacuje transfer
		$q1  = "SELECT SubDriver, SUM(CashIn) AS Primljeno FROM v4_OrderDetails ";
		$q1 .= "WHERE PickupDate >= '2018-08-01' AND PickupDate <= '".$requestedday."'";	
		$q1 .= " GROUP BY SubDriver ";			
		$w1 = $db->RunQuery($q1);
		$orders_arr=array();
		while($od = $w1->fetch_object()) {
			$o_arr=array();
			$o_arr['SubDriver']=$od->SubDriver;
			$o_arr['Primljeno']=$od->Primljeno;
			$orders_arr[]=$o_arr;
		}
		
		// CASH EXPENSES
		$q2  = "SELECT DriverID, SUM(Amount) AS Trosak FROM v4_SubExpenses WHERE Card = 0 ";
		$q2 .= "AND Datum >= '2018-08-01' AND Datum <= '".$requestedday."' AND Approved=1";	
		$q2 .= " GROUP BY DriverID ";			
		
		$w2 = $db->RunQuery($q2);
		$expenses_arr=array();
		while($ex = $w2->fetch_object()) {
			$ex_arr=array();
			$ex_arr['DriverID']=$ex->DriverID;
			$ex_arr['Trosak']=$ex->Trosak;
			$expenses_arr[]=$ex_arr;
		}
		
		// Recived CASH 
		$q7  = "SELECT v4_Actions.ReciverID AS RID, SUM(Amount) AS Trosak FROM v4_SubExpenses,v4_Actions WHERE v4_SubExpenses.Expense=v4_Actions.ID and v4_Actions.ReciverID>0 ";
		$q7 .= "AND Datum >= '2018-08-01' AND Datum <= '".$requestedday."'"; 
		$q7 .= "AND Approved =1 "; 
		$q7 .= " GROUP BY v4_Actions.ReciverID ";			
		
		$w7 = $db->RunQuery($q7);
		while($ex7 = $w7->fetch_object()) {
			$rc_arr=array();
			$rc_arr['DriverID']=$ex7->RID;
			$rc_arr['Trosak']=$ex7->Trosak;
			$rcash_arr[]=$rc_arr;
		}
		

		
		//print_r($rcash_arr);
		//exit();
		
		while($d = $w->fetch_object()) { //ispis reporta ako je pocetno stanje vece od nule $d->Balance

				$subDriverID = $d->AuthUserID;
				//DOHVACANJE IZNOSA
				$key = array_search($subDriverID, array_column($orders_arr, 'SubDriver'));
				if ($key>-1) $Primljeno = $orders_arr[$key]['Primljeno'];			
				else $Primljeno = number_format(0,2);
						
				// CASH EXPENSES
				$key3 = array_search($subDriverID, array_column($expenses_arr, 'DriverID'));
				if ($key3>-1) $Trosak = $expenses_arr[$key3]['Trosak'];			
				else $Trosak = number_format(0,2);
				
				// Recived CASH 
				$key7 = array_search($subDriverID, array_column($rcash_arr, 'DriverID'));
				if ($key7>-1) $RCash = $rcash_arr[$key7]['Trosak'];			
				else $RCash = number_format(0,2);
				

				
				$Balance = $Primljeno - $Trosak + $d->Balance + $RCash;			
	 
				if((nf($Balance) != 0 && !isset($_POST['all'])) || isset($_POST['all'])){?>
					<div class="row" style="border-bottom:1px solid #000;">

						<div class="col-md-2 pad1em">
							<strong><?=$d->AuthUserID?></strong> - <?=$d->AuthUserRealName?>
						</div>

						<div class="col-md-2 pad1em">
							<?= nf($d->Balance) ?> 
						</div>

						<div class="col-md-2 pad1em">
							<?= nf($Primljeno) ?> 
						</div>
				
						<div class="col-md-2 pad1em">
							<?= nf($RCash) ?> 
						</div>

						<div class="col-md-2 pad1em">
							<?= nf($Trosak) ?> 
						</div>
						
						<div class="col-md-2 pad1em">
							<?= nf($Balance) ?> 
						</div>
						
					</div>
			<?}
		}
	}


	function showHeader($requestedday) { 
 	    ?>
		<div class="row" style="border-bottom:1px solid #000;">
		    <div class="col-md-2">
		        <strong>ID - Subdriver</strong>
		    </div>
		    <div class="col-md-2">
		        <strong>Deposit </strong>
		    </div>
		    <div class="col-sm-6 ">
				<div class="col-sm-4 ">
					<strong>Drives</strong>
				</div>	
				<div class="col-sm-4 ">
					<strong>Received</strong>
				</div>		
				<div class="col-sm-4 ">
					<strong>Expenses</strong>
				</div>			

			</div>	
			<div class="col-sm-2 ">
				<strong>Balance</strong>
			</div>									
		</div>
				
	    <?
	}?>
