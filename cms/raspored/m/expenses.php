<?
	session_start();
	
	$opis = array(
		'1'	=> 'Gorivo',
		'2' => 'Autoput',
		'3' => 'Parking',
		'4' => 'Pranje',
		'5' => 'Popravci',
		'99'=> 'Ostalo'
	);
	
	$placanje = array(
		'0' => 'Cash',
		'1' => 'Card'
	);
	
	$total = 0;
	$totalCard = 0;
	$ex = array();
	$datum = date("Y-m-d");
	$driverId = $_SESSION['DriverID'];
	//$driverId = '769'; // test

	// Dodavanje novog troska
	if (
		isset($_REQUEST['addExpense']) and 
		$_REQUEST['addExpense'] == 'Add' and 
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
		
		mysqli_query($con, $q) or die('Error in SubExpenses add query <br>' . mysqli_connect_error());
	
	}


	// Brisanje troska
	if ( isset($_REQUEST['action']) and 
		$_REQUEST['action'] == 'del' and 
		isset($_REQUEST['row']) and 
		$_REQUEST['row'] != ''
		)
	{
		$q 	= "DELETE FROM v4_SubExpenses ";
		$q .= "WHERE ID = '" . $_REQUEST['row'] ."'";
		mysqli_query($con, $q) or die('Error in SubExpenses delete query <br>' . mysqli_connect_error());
	}


	// Priprema podataka za display liste troskova	
	$q  = " SELECT * FROM v4_SubExpenses";
	$q .= " WHERE DriverID = '" . $driverId . "'";
	$q .= " AND Datum = '" . $datum . "' ";
	$q .= " ORDER BY ID ASC";

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
		else $total += $exo->Amount;
	}


?>

<h3><?= $_SESSION['DriverName'] ?> - Expenses - <?= date("d.m.Y") ?></h3>

<div xclass="ui-grid-a">
	<div xclass="ui-block-a"  style="background: #eee" >
	   <form style="padding-left:20%;padding-right:20%;" action="index.php?option=troskovi" method="POST">
			<fieldset data-role="controlgroup" data-type="vertical" data-theme="a">			

				<div class="ui-field-contain">
			        <label for="Expense">Vrsta troška:</label>
			        <select name="Expense" id="Expense">
			            <option value="0">Odaberi:</option>
			            <option value="1"><?= $opis[1] ?></option>
			            <option value="2"><?= $opis[2] ?></option>
			            <option value="3"><?= $opis[3] ?></option>
			            <option value="4"><?= $opis[4] ?></option>
			            <option value="5"><?= $opis[5] ?></option>
			            
			            <option value="99"><?= $opis[99] ?></option>
			        </select>
				</div>
				<div class="ui-field-contain">
			        <label for="Amount">Iznos (EUR):</label>
			        <input type="number" name="Amount" id="Amount" value="" 
			        placeholder="Iznos" pattern="[0-9]*">
				</div>
				<div class="ui-field-contain">
			        <label for="Card">Način plaćanja:</label>
			        <select name="Card" id="Card">
			            <option value="1">Card</option>
			            <option value="0">Cash</option>
			            
			        </select>            
				</div>

				<input type="hidden" name="OwnerID" id="OwnerID" value="<?= $_SESSION['OwnerID'] ?>">
				<input type="hidden" name="DriverID" id="DriverID" value="<?= $_SESSION['DriverID'] ?>">
				<input type="hidden" name="Datum" id="Datum" value="<?= date("Y-m-d") ?>">

				<div class="ui-field-contain">
			        <button type="submit" name="addExpense" value="Add" class="ui-btn ui-corner-all ui-shadow xui-btn-inline ui-btn-b" data-icon="plus">Add</button>
				</div>       
			</fieldset>
	    </form>

	</div>

	<div xclass="ui-block-b">
		<ul data-role="listview"  data-inset="true" id="expensesList">
			<? foreach($ex as $key => $exp) { ?>
				<li data-theme="d" data-icon="delete">
					<a href="index.php?option=troskovi&action=del&row=<?= $key?>">
						<div class="ui-grid-a">
							<div class="ui-block-a">
								<?= $opis[$exp['Expense']]?>
							</div>
							<div class="ui-block-b" style="text-align:right">
								<?= $exp['Amount']?> &nbsp;
								<?= $placanje[$exp['Card']]?>
							</div>
						</div>
					</a>
				</li>
			<? } ?>
				<li data-theme="a">

						<div class="ui-grid-a">
							<div class="ui-block-a">
								Total Card: <br>
								Total Cash: <br>
								<strong>Total :</strong>
							</div>
							<div class="ui-block-b" style="text-align:right">
								<?= number_format($totalCard,2) ?> EUR<br>
								<?= number_format($total,2) ?> EUR<br>
								<strong><?= number_format($total+$totalCard,2) ?> EUR</strong>
							</div>
						</div>

				</li>
		</ul>
	</div>

</div>

<a href="index.php?option=menu" data-role="button" data-icon="home" data-theme="a" data-transition="slide" data-direction="reverse">Home</a>



