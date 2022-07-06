<?

//echo '<pre>'; print_r($_REQUEST); echo '</pre>';

$q  = "SELECT * FROM v4_OrderDetails WHERE DetailsID=".$_REQUEST['id'];
$qr = mysqli_query($con, $q);
if (mysqli_connect_error()) die('Error finding Order <br/>' . 'go Home and try again!
<a href="index.php?option=menu" data-role="button" data-icon="home" data-theme="a" data-transition="slide" data-direction="reverse">Home</a>

');
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
		} else {
			echo '<h2 class="ui-bar ui-bar-c">Error: please enter data</h2>';
		}
	}

?>
<form action="" method="post">
<input type="hidden" name="id" id="id" value="<?= $_REQUEST['id']?>">

<h1>Finished</h1>
<div class="ui-body ui-body-a ui-corner-all">
Pax: <?= $o->PaxName ?><br>
Cash:  <?= $o->PayLater?> EUR<br>
Notes: <?= $o->SubDriverNote ?><br>
</div>

            <fieldset data-role="controlgroup" data-type="vertical" data-theme="a">
            	<h3>Status:</h3>
				
                <input id="radio1" name="status" value="10" type="radio" 
                <? if (($PaymentStatus == '99') && ($DriverConfStatus == '7'))
					echo 'checked'; ?>>
                <label for="radio1">
                    Paid
                </label>

                <input id="radio2" name="status" value="20" type="radio" 
                <? if (($PaymentStatus == '0') && ($DriverConfStatus == '7'))
					echo 'checked'; ?>>
                <label for="radio2">
                    Not Paid
                </label>

                <input id="radio3" name="status" value="30" type="radio" 
                <? if (($PaymentStatus == '0') && ($DriverConfStatus == '5'))
					echo 'checked'; ?>>
                <label for="radio3">
                    No Show
                </label>

                <input id="radio4" name="status" value="40" type="radio" 
                <? if (($PaymentStatus == '0') && ($DriverConfStatus == '6'))
					echo 'checked'; ?>>
                <label for="radio4">
                    Driver Error
                </label>
            </fieldset>


 

            <fieldset data-role="controlgroup">
                <h3>Amount Paid (EUR):</h3>
                <input type="number" name="cash" id="cash" size="5" placeholder="" value="<?= $CashIn ?>"/>
            </fieldset>


            <fieldset data-role="controlgroup">
                <h3>Final Notes:</h3>
                <textarea type="text" name="SubFinalNote" rows="5" id="finalNote"><?= $SubFinalNote ?></textarea>
            </fieldset>

<?
echo '<div class="ui-grid-a">';
echo '  <div class="ui-block-a"><br/><br/>
        <a href="index.php?option=menu" data-role="button" data-icon="home" data-theme="a" data-transition="slide" data-direction="reverse">Home</a>
        </div>';
echo '  <div class="ui-block-b"><br/><br/>
        <button name="saveData" data-role="button" data-icon="cloud" data-theme="b">Save data</button>
        </div>';
echo '</div>';        
?>
</form>

