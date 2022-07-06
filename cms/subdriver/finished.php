<?
require_once 'subdriver/db.php';

$q  = "SELECT * FROM v4_OrderDetails WHERE DetailsID=".$_REQUEST['id'];
$qr = mysqli_query($con, $q);
if (mysqli_connect_error()) die('Error finding Order <br/>');
$o = mysqli_fetch_object($qr);

$CashIn = $o->CashIn;
if($CashIn == 0) $CashIn = '';
$TransferStatus = $o->TransferStatus;
$PaymentStatus = $o->PaymentStatus;
$DriverConfStatus = $o->DriverConfStatus;
$SubFinalNote = $o->SubFinalNote;

if (isset($_POST['saveData'])) {

	$CashIn = $_POST['cash'];
	$TransferStatus = $_POST['status'];
	$SubFinalNote = $_POST['SubFinalNote'];
	$id = $_POST['id'];

	if (!empty($_POST['status'])) {
		switch ($_POST['status']) {
			case '10': // paid
				$TransferStatus = "5";
				$PaymentStatus = "99";
				$DriverConfStatus = "7";
				break;
			case '20': // not paid
				$TransferStatus = "5";
				$PaymentStatus = "0";
				$DriverConfStatus = "7";
				break;
			case '30': // no show
				$TransferStatus = "5";
				$PaymentStatus = "0";
				$DriverConfStatus = "5";
				break;
			case '40': // driver error
				$TransferStatus = "5";
				$PaymentStatus = "0";
				$DriverConfStatus = "6";
				break;
		}

		$q = "UPDATE v4_OrderDetails SET CashIn='".$CashIn."',TransferStatus='".$TransferStatus."',PaymentStatus='".$PaymentStatus."',DriverConfStatus='".$DriverConfStatus."',SubFinalNote='".$SubFinalNote ."' WHERE DetailsID=".$id;
		$qr = mysqli_query($con, $q) or die('Error writing Finished query <br/>' . mysqli_connect_error());
		echo '<h2>Data saved</h2>';
		require_once '../db/v4_OrderLog.class.php';
		$ol = new v4_OrderLog();
		$icon = 'fa fa-cloud-upload bg-blue';
		$logDescription = '';
		$logAction = 'Finished';
		$logTitle = 'Order Finished by ' . $_SESSION['UserName'];
		$showToCustomer = 0;
		$customerDescription = '';		
	    $ol->setOrderID($o->OrderID);
	    $ol->setDetailsID($o->DetailsID);
	    $ol->setAction($logAction);
	    $ol->setTitle($logTitle);
	    $ol->setDescription($logDescription);
	    $ol->setDateAdded(date("Y-m-d"));
	    $ol->setTimeAdded(date("H:i:s"));
	    $ol->setUserID($_SESSION['AuthUserID']);
	    $ol->setIcon($icon);
	    $ol->setShowToCustomer($showToCustomer);

	    $ol->saveAsNew();
		

		
	} else {
		echo '<h2>Error: please enter data</h2>';
	}
}

?>
<style>
input { vertical-align:middle; }
.form-control { width: 36px; }
</style>
<form action="" method="post" class="container white">
	<input type="hidden" name="id" id="id" value="<?= $_REQUEST['id']?>">

	<h1>Transfer Finished</h1>
	<br>
	<div>
	Pax: <?= $o->PaxName ?><br>
	Cash:  <?= $o->PayLater?> EUR<br>
	Notes: <?= $o->SubDriverNote ?><br>
	</div><br>

    <fieldset style="vertical-align:top">
    	<h3>Status:</h3>
		

		<div class="row pad1em">

			<div class="col-xs-1">
			    <input id="radio1" name="status" value="10" type="radio" class="form-control"
			    <? if (($PaymentStatus == '99') && ($DriverConfStatus == '7'))
				echo 'checked'; ?>>

		    </div>
			<div class="col-xs-11 l">Completed - Paid</div>
		</div>


		<div class="row pad1em">

			<div class="col-xs-1">
				<input id="radio2" name="status" value="20" type="radio" class="form-control"
				<? if (($PaymentStatus == '0') && ($DriverConfStatus == '7'))
					echo 'checked'; ?>>
		    </div>
			<div class="col-xs-11 l">Completed - Not Paid</div>
		</div>

		<div class="row pad1em">

			<div class="col-xs-1">
				<input id="radio3" name="status" value="30" type="radio" class="form-control"
				<? if (($PaymentStatus == '0') && ($DriverConfStatus == '5'))
					echo 'checked'; ?>>
		    </div>
			<div class="col-xs-11 l">No Show</div>
		</div>

		<div class="row pad1em">

			<div class="col-xs-1">
				<input id="radio4" name="status" value="40" type="radio" class="form-control"
				<? if (($PaymentStatus == '0') && ($DriverConfStatus == '6'))
					echo 'checked'; ?>>
		    </div>
			<div class="col-xs-11 l">Driver Error</div>
		</div>

    </fieldset>
	<br><br>
    <fieldset>
        <h3>Amount Paid (EUR):</h3>
        <input type="number" name="cash" id="cash" size="5" step="0.01" placeholder="" value="<?= $CashIn ?>"/>
    </fieldset>
	<br><br>
    <fieldset>
        <h3>Final Notes:</h3>
        <textarea type="text" name="SubFinalNote" rows="5" id="finalNote"><?= $SubFinalNote ?></textarea>
    </fieldset>

	<div class="row">
		<div class="col-xs-6 pad1em">
			<button name="saveData" class="btn btn-primary l"><i class="fa fa-save"></i> Save</button>
		</div>
		<div class="col-xs-6 pad1em right">
			<a href="index.php?p=dashboard"
			class="btn  l btn-default"><i class="fa fa-home"></i> Home</a> 
		</div>
	</div>
	
</form>
<br><br>
