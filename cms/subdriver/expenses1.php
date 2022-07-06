<?
	session_start();

	require_once 'subdriver/db.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/db/db.class.php';
	
	$db = new DataBaseMySql();
	$driverId = $_SESSION['DriverID'];
	//$driverId = '1165'; // test
	
	        // CASH-IN
	        $qd  = "SELECT SUM(CashIn) AS Primljeno FROM v4_OrderDetails ";
	        $qd .= "WHERE (SubDriver = '" . $driverId ."' ";
	        $qd .= "OR SubDriver2 = '" . $driverId ."' ";
	        $qd .= "OR SubDriver3 = '" . $driverId ."') ";
	        $qd .= "AND PickupDate >= '2018-08-01'";
	
/*
	        $qd  = "SELECT SUM(CashIn) AS Primljeno FROM v4_OrderDetails ";
	        $qd .= "WHERE SubDriver = '" . $driverId ."' ";
	        $qd .= "AND PickupDate >= '2018-08-01'";	
*/
	
	
	        $w = $db->RunQuery($qd);
	        $p = $w->fetch_object();
      
	        // APPROVED CASH EXPENSES
	        $qta  = "SELECT SUM(Amount) AS Trosak FROM v4_SubExpenses WHERE Card = 0 AND Approved = 1";
	        $qta .= "AND DriverID = '" . $driverId ."' ";
	        $qta .= "AND Datum >= '2018-08-01'";
	
	        $wta = $db->RunQuery($qta);
	        $ta = $wta->fetch_object();

	        // NON-APPROVED CASH EXPENSES
	        $qt  = "SELECT SUM(Amount) AS Trosak FROM v4_SubExpenses WHERE Card = 0";
			$qt .= "AND Approved <9 ";
	        $qt .= "AND DriverID = '" . $driverId ."' ";
	        $qt .= "AND Datum >= '2018-08-01'";
	
	        $wt = $db->RunQuery($qt);
	        $t = $wt->fetch_object();


	        $Balance = $p->Primljeno - $t->Trosak; 

	        $ApprovedBalance = $p->Primljeno - $ta->Trosak; 


	
	$opis = array(
		'1'	 => 'Gorivo',
		'2'  => 'Autoput',
		'3'  => 'Parking',
		'4'  => 'Pranje',
		'5'  => 'Popravci',
		'6'  => 'Plaća',
		'7'  => 'Piće',
		'8'  => 'Polog na račun',
		'9'  => 'Sredstva za čišćenje',
		'10' => 'Dijelovi zas auto',
		'99' => 'Ostalo');

	$placanje = array(
		'0' => 'Cash',
		'1' => 'Card'
	);

	$totalCard = 0;
	$totalCash = 0;
	$ex = array();
	$datum = date("Y-m-d");
	$driverId = $_SESSION['DriverID'];
	//$driverId = '769'; // test

	// Dodavanje novog troska
	if (
		isset($_REQUEST['addExpense']) and 
		$_REQUEST['addExpense'] == 'Add'
		)
	{

		if (
			$_REQUEST['Expense'] != '0' and 
			$_REQUEST['Amount'] != ''
			)
		{

			$q 	= "INSERT INTO v4_SubExpenses (OwnerID, DriverID, Datum, Expense, Amount, Card) ";
			$q .= "VALUES('";
			$q .= $_REQUEST['OwnerID'] ."','";
			$q .= $_REQUEST['DriverID'] ."','";
			$q .= $_REQUEST['Datum'] ."','";
			$q .= $_REQUEST['Expense'] ."','";
			$q .= $_REQUEST['Amount'] ."','";
			$q .= $_REQUEST['Card'] ."')";
			// echo '<script>console.log("' . $q . '-OK")</script>';	
			mysqli_query($con, $q) or die('Error in SubExpenses add query <br>' . mysqli_connect_error());

		}
		else {
			echo "<script>alert('Enter all data and try again!');</script>";
		}
	}

	// Brisanje troska
	if ( isset($_REQUEST['expID'])) {
		// echo '<script>console.log("deleting " + ' . $_REQUEST['expID'] . ')</script>';
		//$q 	= "DELETE FROM v4_SubExpenses ";
		$q  = "UPDATE `v4_SubExpenses` SET `Approved`=9 ";
		$q .= "WHERE ID = '" . $_REQUEST['expID'] ."'";
		mysqli_query($con, $q) or die('Error in SubExpenses delete query <br>' . mysqli_connect_error());
	}


	// Priprema podataka za display liste troskova	
	$q  = " SELECT * FROM v4_SubExpenses";
	$q .= " WHERE DriverID = '" . $driverId . "'";
	$q .= " AND Approved < 9 ";	
	$q .= " AND Datum >= '" . date('Y-m-d',strtotime('-2 days')). "' ";
	$q .= " ORDER BY Datum DESC";

	$query = mysqli_query($con, $q) or die('Error in SubExpenses query <br>' . mysqli_connect_error());

	// stavi u array za kasnije
	while($exo = mysqli_fetch_object($query) ) {
		$ex[$exo->ID] = array(
			'OwnerID' 	=> $exo->OwnerID,
			'DriverID' 	=> $exo->DriverID,
			'Datum'		=> $exo->Datum,
			'Expense'	=> $exo->Expense,
			'Amount'	=> $exo->Amount,
			'Card'		=> $exo->Card
		);
		
		if($exo->Card) $totalCard += $exo->Amount;
		else $totalCash += $exo->Amount;
	}

?>
<div class="container white">
	
	<div class="row">
		<div class="col-xs-12 pad1em">
		    <h3>Expenses - <?= date("d.m.Y") ?></h3>
		    <br>
		    <?
		    if($Balance < 0) $warningClass="red white-text pad4px";
		    else $warningClass = "green white-text pad4px";
		    ?>
			<h4 title="=> 25.04.2018">Approved Account Balance: <span class="bold <?= $warningClass ?>"><?= nf($ApprovedBalance) ?> EUR</span></h4><br>
			<h4 title="=> 25.04.2018">Unapproved Account Balance: <span class="bold <?= $warningClass ?>"><?= nf($Balance) ?> EUR</span></h4>
		</div>
	</div>	

   <form  action="index.php?p=expenses" method="POST" class="pad1em no-print">
		<div class="row">
			<div class="col-sm-6">
		        <label for="Datum">Datum računa</label>
			</div>
			<div class="col-sm-6">
				<select name="Datum" id="Datum" class="col-md-10">
					<option value="<?= date('Y-m-d',strtotime('-1 days')) ?>">
						<?= date("d.m.Y",strtotime("-1 days")) ?>
					</option>
					<option value="<?= date("Y-m-d") ?>" selected>
						<?= date("d.m.Y") ?>
					</option>
				</select>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
		        <label for="Expense">Vrsta troška</label>
			</div>
			<div class="col-sm-6">
		        <select name="Expense" id="Expense" class="col-md-10">
		            <option value="0">Odaberi</option>
					<?
					foreach ($opis as $v => $t) { echo '<option value="'.$v.'">'.$t.'</option>'; }
					?>
		        </select>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
		        <label for="Amount">Iznos (EUR)</label>
			</div>
			<div class="col-sm-6">
		        <input type="number" min="0" step="0.01" name="Amount" id="Amount" value="" placeholder="0.00" class="col-md-10">
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
		        <label for="Card">Način plaćanja</label>
			</div>
			<div class="col-sm-6">
		        <select name="Card" id="Card" class="col-md-10">
		            <option value="1">Card</option>
		            <option value="0">Cash</option>
		        </select>
			</div>
		</div>

		<input type="hidden" name="OwnerID" id="OwnerID" value="<?= $_SESSION['OwnerID'] ?>">
		<input type="hidden" name="DriverID" id="DriverID" value="<?= $_SESSION['DriverID'] ?>">

		<div>
	        <button type="submit" name="addExpense" value="Add" class="btn btn-primary btn-block l">
	        <i class="fa fa-chevron-down"></i> Add</button>
		</div>
    </form>

	<form id="expensesList" class="pad1em" action="index.php?p=expenses" method="POST">
		<? foreach($ex as $key => $exp) { ?>
			<div class="row table" style="margin:6px 0">
				<div class="col-sm-3">
					<?= ymd2dmy($exp['Datum']) ?>
				</div>
				<div class="col-sm-3">
					<?= $opis[$exp['Expense']] ?>
				</div>
				<div class="col-sm-3" style="text-align:right">
					<?= $exp['Amount']?> &nbsp;
					<?= $placanje[$exp['Card']] ?>
				</div>
				<div class="col-sm-3" style="text-align:right">
					<button type="submit" name="expID" value="<?= $key ?>" class="btn btn-danger" title="Delete">
					<i class="fa fa-times-circle l"></i></button>
				</div>
			</div>
			<hr>
		<? } ?>
	</form>

	<div class="row  pad1em">
		<div class="col-sm-4 center"><strong>Card: € <?= nf($totalCard) ?></strong></div>
		<div class="col-sm-4 center"><strong>Cash: € <?= nf($totalCash) ?></strong></div>
		<div class="col-sm-4 center"><strong>Total: € <?= nf($totalCard + $totalCash) ?></strong></div>
	</div>
	
	<div class="row">
		<div class="col-xs-12 pad1em">
			<div class="btn btn-danger btn-block l" onclick="window.print();">
			<i class="fa fa-print l"></i> Save and Print</div>
		</div>
	</div>


	
</div>

