<?
	session_start();

	require_once 'subdriver/db.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/db/db.class.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_Actions.class.php';
	$db = new DataBaseMySql();
	$ac = new v4_Actions();
	$ack = $ac->getKeysBy('DisplayOrder ', '','WHERE Active=1');
	foreach ($ack as $nn => $key)
	{
		$ac->getRow($key);
		$opis[$key]=$ac->getTitle();		
	}
 
	
	
	$driverId = $_SESSION['DriverID'];
	
	        // CASH-IN Ostalo od boge subdriver1-2-3 treba vuci samo sub1, jer prvi vozac naplacuje transfer
	        $qd  = "SELECT SUM(CashIn) AS Primljeno FROM v4_OrderDetails ";
	        $qd .= "WHERE SubDriver = '" . $driverId ."' ";
			$qd .= "AND TransferStatus <> 9 ";
			$qd .= "AND PickupDate >= '2018-08-01'";

	        $w = $db->RunQuery($qd);
	        $p = $w->fetch_object();
      
	        // Unapproved CASH EXPENSES
	        $qta  = "SELECT SUM(Amount) AS Trosak FROM v4_SubExpenses WHERE Card = 0 AND Approved = 0 ";
	        $qta .= "AND DriverID = '" . $driverId ."' ";
	        $qta .= "AND Datum >= '2018-08-01'";
	
	        $wta = $db->RunQuery($qta);
	        $ta = $wta->fetch_object();

	        // CASH EXPENSES
	        $qt  = "SELECT SUM(Amount) AS Trosak FROM v4_SubExpenses WHERE Card = 0 ";
	        $qt .= "AND DriverID = '" . $driverId ."' ";
			$qt .= "AND Approved = 1 ";		 	
	        $qt .= "AND Datum >= '2018-08-01'";

	        $wt = $db->RunQuery($qt);
	        $t = $wt->fetch_object();

			$q1 = "SELECT Balance FROM v4_AuthUsers ";
			$q1 .= "WHERE  AuthUserID = '".$driverId."' ";

			$au = $db->RunQuery($q1);
			$auf = $au->fetch_object();

			//recived cash
			$qra  = "SELECT SUM(Amount) AS Trosak FROM v4_SubExpenses,v4_Actions WHERE v4_SubExpenses.Expense=v4_Actions.ID and v4_Actions.ReciverID>0 ";
			$qra .= "AND Approved =1 ";
			$qra .= "AND Datum >= '2018-08-01'"; 
			$qra .= "AND ReciverID = '" . $driverId ."' ";
	
			$ra= $db->RunQuery($qra);	
			$raf = $ra->fetch_object();
	
	
	

			$Deposit = $auf->Balance;
			$UnapprovedExpenses = $ta->Trosak;
	        $Balance = $p->Primljeno - $t->Trosak + $auf->Balance + $raf->Trosak; 


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


	if (isset($_FILES["DocumentImage"]) && !empty(basename($_FILES["DocumentImage"]["name"]))) { 
		$fileNameArr = explode(".", $_FILES['DocumentImage']['name']);
        $fileName = $fileNameArr[0];
        $fileExtension = strtolower(end($fileNameArr));
        
        $target_file = 'subdriver/uploads/' . md5(time() . $fileName) . '.' . $fileExtension;

        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$uploadOk = 1;
		// Check if image file is a actual image or fake image
		if(isset($_POST["addExpense"])) {
			$check = getimagesize($_FILES["DocumentImage"]["tmp_name"]);
			if($check !== false) {
				move_uploaded_file($_FILES["DocumentImage"]["tmp_name"],$target_file);
				$target_file="https://cms.jamtransfer.com/cms/".$target_file; 
			}	
			else echo "File is not an image.";
		}
		
	}
	else $target_file='';

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
			
			if ($_REQUEST['Expense']==1) {
				if ($_SESSION['OwnerID']==843) $afpadd="_Nice";
				if ($_SESSION['OwnerID']==876) $afpadd="_Lyon";
				if ($_SESSION['OwnerID']==556) $afpadd="_Split";
				$filename = $_SERVER['DOCUMENT_ROOT'] . '/cms/approvedFuelPrice'.$afpadd.'.inc';
				$afp = file_get_contents($filename, FILE_USE_INCLUDE_PATH);				
			}


			$q 	= "INSERT INTO v4_SubExpenses (OwnerID, DriverID, Datum, Expense, VehicleID, Description, Amount, Card, DocumentImage, ApprovedFuelPrice) ";
			$q .= "VALUES('";
			$q .= $_REQUEST['OwnerID'] ."','";
			$q .= $_REQUEST['DriverID'] ."','";
			$q .= $_REQUEST['Datum'] ."','";
			$q .= $_REQUEST['Expense'] ."','";
			$q .= $_REQUEST['VehicleID'] ."','";			
			$q .= $_REQUEST['Description'] ."','";
			$q .= $_REQUEST['Amount'] ."','";
			$q .= $_REQUEST['Card'] ."','";
			$q .= $target_file ."','";
			$q .= $afp ."')";
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
	$q .= " AND Expense != '12' ";
	$q .= " AND Approved < 9 ";	
//	$q .= " AND Datum >= '" . date('Y-m-d',strtotime('-2 days')). "' ";
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
			'Card'		=> $exo->Card,
			'DocumentImage' => $exo->DocumentImage
		);
		
		if($exo->Card) $totalCard += $exo->Amount;
		else $totalCash += $exo->Amount;
	}

?>
<div class="container white">
	
	<div class="row">
		<div class="col-xs-12 pad1em">
		    <h3>EXPENSES <?= date("d.m.Y") ?></h3> 
			<h4>Vehicle: <?= $_SESSION['VehicleTitle'] ?></h4> 

		    <br><br>
		    <?
		    if($Balance < 0) $warningClass="red white-text pad4px";
		    else $warningClass = "green white-text pad4px";
		    ?>
			<div class="col-md-4">
				<h4 title="=> 01.08.2018">Deposit: <span class="bold <?= $warningClass ?>"><?= nf($Deposit) ?> EUR</span></h4>
			</div>
			<div class="col-md-4">
				<h4 title="=> 01.08.2018">Account Balance: <span class="bold <?= $warningClass ?>"><?= nf($Balance) ?> EUR</span></h4>
			</div>
			<div class="col-md-4">
				<h4 title="=> 01.08.2018">Unapproved Cash Expenses: <span class="bold red white-text pad4px"><?= nf($UnapprovedExpenses) ?> EUR</span></h4>
			</div>
			
		</div>
	</div>	

   <form  action="index.php?p=expenses" method="POST" class="pad1em no-print" enctype="multipart/form-data">
		<div class="row">
			<div class="col-sm-6">
		        <label for="Datum">Datum računa</label>
			</div>
			<div class="col-sm-6">
				<select name="Datum" id="Datum" class="col-md-10">
					<option value="<?= date('Y-m-d',strtotime('-2 days')) ?>">
						<?= date("d.m.Y",strtotime("-2 days")) ?>
					</option>
					<option value="<?= date('Y-m-d',strtotime('-1 days')) ?>">
						<?= date("d.m.Y",strtotime("-2 days")) ?>
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
		        <input type="text" min="0" step="0.01" name="Amount" id="Amount" value="" placeholder="0.00" class="col-md-10">
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
		
		<div id='description_block' class="row" style="display:none">
			<div class="col-sm-6">
		        <label>Kilometar sat:</label>
			</div>
			<div class="col-sm-6">
				<input type="text" name="Description" id="Description" value="">
			</div>			
		</div>
		
		
		<div class="row">
			<div class="col-sm-6">
		        <label for="DocumentImage">Document Image</label>
			</div>
			<div class="col-sm-6">
				<input id='photo' type="file" style='display:none' name="DocumentImage" accept="image/*" capture="camera">
				<button id='photo2' type="button" name="photo"  class="btn btn-primary btn-block ">TAKE A PHOTO</button>		
			</div>
		</div>
		<input type="hidden" name="OwnerID" id="OwnerID" value="<?= $_SESSION['OwnerID'] ?>">
		<input type="hidden" name="DriverID" id="DriverID" value="<?= $_SESSION['DriverID'] ?>">
		<input name='VehicleID' type="hidden" id='VehicleID' value='<?= $_SESSION['VehicleID']?>'/>
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
				<div class="col-sm-2" style="text-align:right">
					<?= $exp['Amount']?> &nbsp;
					<?= $placanje[$exp['Card']] ?>
				</div>
				<div class="col-sm-2" style="text-align:right">		
					<img  class="small" src="<?= $exp['DocumentImage'] ?>" alt="" height="50" width="50">
				</div>
				<div class="col-sm-2" style="text-align:right">
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

<script>
	$("#photo2").click(function(){
		$( "#photo" ).trigger( "click" );
	})	
	$('img').click(function() {
		$(this).attr('class','large');	
	})
	$('#Expense').change(function() {
		if ($(this).val()==1) $('#description_block').show(500);
		else $('#description_block').hide(500);
	})	
</script>