<h2>kopiranje iz timetable u v4_orderdetails</h2>

<?
	require_once ROOT.'/db/TimeTable.class.php';
	require_once ROOT.'/db/v4_OrderDetails.class.php';


	$t = new TimeTable();
	$od = new v4_OrderDetails();

	$i = 0;
	PrepareProgress();

	$ttArray = $t->getKeysBy('ID', 'ASC', "WHERE OrderPickupDate >= '2016-08-01'");
	$ttCount = count($ttArray);
	

	foreach($ttArray as $val => $ID) {
		
		$t->getRow($ID);

		$where = "WHERE OrderID = '".$t->getOrderID()."' AND TNo = '".$t->getTNo()."'";

		if ($t->getTNo() == '0') {
			$where = "WHERE OrderID = '".$t->getOrderID()."' AND PickupDate = '".$t->getOrderPickupDate()."' AND PickupTime = '".$t->getOrderPickupTime()."'";
		}
		
		$odArray = $od->getKeysBy('DetailsID', 'ASC', $where);

		if (count($odArray) > 0) {
			
			$od->getRow($odArray[0]);

			//if (($t->getOrderID() == $od->getOrderID()) &&	($t->getTNo() == $od->getTNo())) {

			$od->setSubDriver		($t->getSubDriver());
			$od->setCar				($t->getCar());
			$od->setSubDriver2		($t->getSubDriver2());
			$od->setCar2			($t->getCar2());
			$od->setSubDriver3		($t->getSubDriver3());
			$od->setCar3			($t->getCar3());
			$od->setSubPickupDate	($t->getPickupDate());
			$od->setSubPickupTime	($t->getPickupTime());
			$od->setPDFFile			($t->getPDFFile());
			$od->setExtras			($t->getExtras());
			$od->setSubDriverNote	($t->getSubDriverNote());
			$od->setCashIn			($t->getCashIn());
			$od->setSubFinalNote	($t->getFinalNote());

			
			$od->saveRow();
			

			$i++;
			
			//}
				
		
		}

		else {
			echo 'FALI: '.$t->getID().' '.$t->getOrderID().' '.$t->getTno().' '.$t->getOrderPickupDate().' '.$t->getOrderPickupTime().'<br>';

		}

			ShowProgress($i, $ttCount);	

	}

	echo 'kopirano '.$i.' od '.$ttCount;
	
	
/*
 * PHP progress bar
 */
function PrepareProgress() {

  echo <<<KRAJ
<div id="progress" class="progress" style="width:100%;border:1px solid #ccc;font-size:3em"></div>
<!-- Progress information -->
<div id="information"></div>

KRAJ;
}

function ShowProgress($i, $total) {
    // Calculate the percentation
    $percent = intval($i/$total * 100)."%";
    $divisor = 100;
  $quotient = intval($i / $divisor);
  $remainder = $i % $divisor;

  //if ($remainder == 0 or $i == $total) {
  // This is for the buffer achieve the minimum size in order to flush data
    echo str_repeat(' ',1024*128);

    // Javascript for updating the progress bar and information
    echo '<script language="javascript">
    document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:#336699;\">&nbsp;</div>";
    document.getElementById("information").innerHTML="'.$i.' row(s) processed.";
    </script>';
    

    flush();
    
    

  // Sleep one second so we can see the delay
    //sleep(1);
  //} 
}
/*
 * END PHP progress bar
 */	
