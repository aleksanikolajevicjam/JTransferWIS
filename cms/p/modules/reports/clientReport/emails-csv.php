<?

// export sa progres barom, da se mogu svi podaci odjednom izvadit

require_once ROOT . '/db/db.class.php';
require_once ROOT . '/cms/f/csv.class.php';

echo '<div class="container-fluid pad1em">';
echo '<h1>' . CLIENT_EMAIL_LIST . '</h1><br><br>';

$i=0;
	PrepareProgress();

	$dateFrom = $_REQUEST['DateFrom'];
	$dateTo = $_REQUEST['DateTo'];
	$userType = $_REQUEST['userType'];

	// CSV Setup
	$csv = new ExportCSV;
	$csv->File = 'CustomerEmails-sept';

	# CSV first row
	$csv->addHeader(array(
			'Email',
			'Tel',
			'From',
			'To',
			'Flight No',
			'MOrderDate'
			) );

	$db = new DataBaseMysql();
	
	$q = "	SELECT DISTINCT MPaxEmail, MOrderID, MPaxTel, MOrderDate FROM v4_OrdersMaster 
			WHERE MPaxEmail != ''
			AND MOrderDate >= '2016-09-13'
			ORDER BY MOrderDate ASC";
/*
			AND MUserLevelID = " . $userType . "
			AND MOrderDate >= '" . $dateFrom . "'
			AND MOrderDate <= '" . $dateTo . "'*/
	
	$w = $db->RunQuery($q);
	$ttCount = $w->num_rows;
	
	while($om = $w->fetch_object()) {

		$qd = "	SELECT * FROM v4_OrderDetails 
				WHERE OrderID = '" . $om->MOrderID ."'
				ORDER BY DetailsID ASC";
		$wd = $db->RunQuery($qd);
		
		while($od = $wd->fetch_object() ) {

			if($tempMPaxEmail != $om->MPaxEmail) {
//				echo '<hr>';
	//			echo $om->MPaxEmail . '-'.$om->MPaxTel. '<br>-'.$od->PickupName .'-'.$od->DropName . '-' . $od->FlightNo .  '<br>';
				# CSV row
				$csv->addRow(array(
						$om->MPaxEmail ,
						$om->MPaxTel,
						$od->PickupName,
						$od->DropName,
						$od->FlightNo,
						$om->MOrderDate
						));	
			} else {
//				echo ' ' . '-'.$od->PickupName .'-'.$od->DropName . '-' . $od->FlightNo . '<br>';
				# CSV row
				$csv->addRow(array(
						'' ,
						'',
						$od->PickupName,
						$od->DropName,
						$od->FlightNo,
						$om->MOrderDate
						));					
			}
			$tempMPaxEmail = $om->MPaxEmail;
		}
				
					$i++;
					ShowProgress($i, $ttCount);		
		
	}

	$csv->save();

	echo '<hr><h4>Exported to CSV!</h4>';

	echo '<a href="'.$csv->File.$csv->Extension.'" class="btn btn-default"><i class="fa fa-download"></i> Download CSV</a><br>';
	echo ' You can download CSV file here (or Right-Click->Save). <br>';
	echo ' <b>File format:</b> UTF-8, semi-colon (;) delimited<br>';
//}

//else echo 'Enter Dates!';
echo '</div>';


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
