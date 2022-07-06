<!DOCTYPE html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="./b/default.min.css" type="text/css" />
<style type="text/css">
@media all {
	//.page-break	{ display: none; }
}

@media print {
	.page-break	{ page-break-before: auto; page-break-inside: avoid;}
	*, .lead {font-size: 12px}
	b {font-weight: bold !important}
}
</style>
</head>
<body style="margin:30px;">
<?
require_once 'data.php';

define("B", " ");
define("NL", "<br>");

	
if (isset($_REQUEST['StartDate']) and isset($_REQUEST['EndDate']))
{

	$total = 0;
	$totNow = 0;
	$totLater = 0;
	$totInv = 0;
		
	#++++++++++++++++++++++++++++++++++++++++++++++++++
	# polazni transferi
	#++++++++++++++++++++++++++++++++++++++++++++++++++
	$q = "SELECT *, DATE_FORMAT (PickupDate,'%Y-%m-%d') AS ArrDate  FROM TimeTable "; 
	
	if ($_REQUEST['SSubDriver'] != 0) $q.= " WHERE SubDriver = " . $_REQUEST['SSubDriver'] . " AND ";
	else $q .= " WHERE ";
	        
    $q .= " PickupDate >= '{$_REQUEST['StartDate']}' 
		  AND PickupDate <= '{$_REQUEST['EndDate']}' 
		  AND OrderStatus != '3' ";

	//if (!empty($_REQUEST['driverid'])) 
	//$q .= ' AND Driver = ' . $_REQUEST['driverid'] . ' ';


	if ($_REQUEST['SortSubDriver'] != '0') $q.= "  ORDER BY  ArrDate ASC, SubDriver ASC, PickupTime ASC ";
	else $q .= "  ORDER BY  ArrDate ASC, PickupTime ASC";


    //$q .= " ORDER BY  ArrDate ASC, SubDriver ASC, PickupTime ASC";
		  
	$e = mysql_query($q) or die(mysql_error());
	

    // output as file
    //query_to_csv($conn, $q, "TransfersList.csv", false, true);
    
    echo '<p class="lead">Transfers List - From: ' . YMD_to_DMY($_REQUEST['StartDate']) . ' To: ' . YMD_to_DMY($_REQUEST['EndDate']) . '</p>';
	echo '';

    //echo '<hr/>';
	
	$i = 0;
	$totalPayLater = 0;   

echo '<table style="page-break-inside: auto;">';

while ($t = mysql_fetch_object($e)) { 
    
    $i++;
?>

    
    <tr valign="top" class="page-break" style="border-top: 1px solid #ddd;">
        <td width="15%">
            <b class="lead"><?= $t->PickupTime ?></b><br>
            <small>
                <?= YMD_to_DMY($t->PickupDate) ?> 
                <?= $t->SingleReturn ?>
            </small><br>
            <?= $t->OrderKey ?><br>
            <b><?= $t->PaxName ?><br></b>
            <?= $t->PaxTel ?>
        </td>
        <td width="25%">
            <b class="lead"><?= $t->FromPlace ?></b><br/>
            <?= $t->FromAddress ?><br/>
            <?= $t->PaxNote ?>
            <hr>
            Flight No: <?= $t->FlightNo ?><br>
            Flight Time: <?= $t->FlightTime ?>
            
        </td>
        <td width="25%">
            <b class="lead"><?= $t->ToPlace ?></b><br/>
            <?= $t->ToAddress ?>
          
        </td>
        <td>
            <b class="lead">
            	<?= SubDriverName($t->SubDriver) ?>
            	<?
            		if ($t->SubDriver2 != 0) echo ' + ' . SubDriverName($t->SubDriver2);
            		if ($t->SubDriver3 != 0) echo ' + ' . SubDriverName($t->SubDriver3);
            	?> 
            </b><br>
            <?= Car($t->Car) ?>
            <? if ($t->Car2 != 0) echo ' + ' . Car($t->Car2); ?>
            <? if ($t->Car3 != 0) echo ' + ' . Car($t->Car3); ?>
            <br>
            <?= $t->SubDriverNote ?><br>
            P:<?= $t->PaxNo ?> VT:<?= $t->VehicleType ?><br>
            Cash In:<?= $t->CashIn; ?>€
            
            <?
                   /*
                    if ($i == 5)
                    {
                        $i= 0;
                        echo '<div class="page-break"></div>';  
                    }
                    */
            ?>
            
        </td>
        
    </tr>
   




<? 

    } # end while

echo '</table>';

} #endif


#
# hidden polja
#
function hiddenField($name,$value)
{
	echo '<input name="'.$name.'" id="'.$name.'" type="hidden" value="'.$value.'" />';
}

function SubDriverName($d)
{

        
        $q = "SELECT * FROM SubDrivers WHERE DriverID = " .$d;
        $r = mysql_query($q) or die( mysql_error() . ' SubDriver Selector');
        
        $d = mysql_fetch_object($r);
        return $d->DriverName;
}



function Car($car)
{
        
        $q = "SELECT * FROM Vehicles WHERE VehicleID = " . $car;
        $r = mysql_query($q) or die( mysql_error() . ' Car Selector');
        
        $d = mysql_fetch_object($r);
        return $d->VehicleDescription;
}


function query_to_csv($db_conn, $query, $filename, $attachment = false, $headers = true) {
        
        if($attachment) {
            // send response headers to the browser
            header( 'Content-Type: text/csv' );
            header( 'Content-Disposition: attachment;filename='.$filename);
            $fp = fopen('php://output', 'w');
        } else {
            $fp = fopen($filename, 'w');
        }
        
        $result = mysql_query($query, $db_conn) or die( mysql_error( $db_conn ) );
        
        if($headers) {
            // output header row (if at least one row exists)
            $row = mysql_fetch_assoc($result);
            if($row) {
                fputcsv($fp, array_keys($row));
                // reset pointer back to beginning
                mysql_data_seek($result, 0);
            }
        }
        
        while($row = mysql_fetch_assoc($result)) {
            fputcsv($fp, $row);
        }
        
        fclose($fp);
    }
    
    
# Pretvaranje formata datuma
function YMD_to_DMY($date)
{
    $elementi = explode('-',$date);
    $new_date = $elementi[2].'.'.$elementi[1].'.'.$elementi[0];
    return $new_date;
}    
?>
</body>
</html>

