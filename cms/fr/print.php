<?
require_once ROOT .'/db/db.class.php';
require_once ROOT .'/db/v4_OrdersMaster.class.php';
require_once ROOT .'/db/v4_OrderDetails.class.php';

$om = new v4_OrdersMaster();
$od = new v4_OrderDetails();
$d2 = new v4_OrderDetails();

session_start();
?>

<!DOCTYPE html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
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
	
if (isset($_REQUEST['DateFrom']) and isset($_REQUEST['DateTo']))
{

	$total = 0;
	$totNow = 0;
	$totLater = 0;
	$totInv = 0;
		
	#++++++++++++++++++++++++++++++++++++++++++++++++++
	# polazni transferi
	#++++++++++++++++++++++++++++++++++++++++++++++++++

	$column = 'PickupDate';
	$order = '';
	$where = " WHERE DriverID = " . $_SESSION['OwnerID'];

	if ($_REQUEST['SortSubDriver'] != '0') $order = " ASC, SubDriver ASC, SubPickupTime ASC, PickupTime ASC";
	else $order = " ASC, SubPickupTime ASC, PickupTime ASC";
	
	if ($_REQUEST['SubDriverID'] != 0) {
		$where .= " AND (SubDriver = " . $_REQUEST['SubDriverID'];
		$where .= " OR SubDriver2 = " . $_REQUEST['SubDriverID'];
		$where .= " OR SubDriver3 = " . $_REQUEST['SubDriverID'];
		$where .= " ) ";
	}
	        
    $where .= " AND PickupDate >= '".$_REQUEST['DateFrom']."' 
				AND PickupDate <= '".$_REQUEST['DateTo']."' 
		  		AND TransferStatus < '6' AND TransferStatus != '3'
				AND DriverConfStatus != '3' ";

	$odArray = $od->getKeysBy($column, $order, $where);
	

    echo '<p class="lead">Transfers List - From: ' . YMD_to_DMY($_REQUEST['DateFrom']) . ' To: ' . YMD_to_DMY($_REQUEST['DateTo']) . '</p>';
	echo '';

    //echo '<hr/>';
	
	$i = 0;
	$totalPayLater = 0;   

echo '<table style="page-break-inside: auto;border-collapse: collapse">';

foreach($odArray as $val => $ID) {
	$od->getRow($ID);
	$om->getRow($od->getOrderID());
//	$otherTransfer = getOtherTransferID($od->getDetailsID());
    
    $i++;
?>

    <tr valign="top" class="page-break" style="border-top:solid 1px black">
        <td width="15%">
            <b class="lead"><?= $od->getSubPickupTime(); ?></b><br>
            <small>
                <?= YMD_to_DMY($od->getPickupDate()); ?> 
                <? //$t->SingleReturn ?>
            </small><br>
            <?= $om->getMOrderKey(); ?>-<?= $od->getOrderID(); ?><br>
            <b><?= $od->getPaxName(); ?><br></b>
            <?= $om->getMPaxTel(); ?>
        </td>
        <td width="25%" style="max-width:250px !important;word-wrap:break-word !important">
            <b class="lead"><?= $od->getPickupName(); ?></b><br/>
            <?= $od->getPickupAddress(); ?><br/>
            <span style="max-width:250px !important;word-wrap:break-word"><?= $od->getPickupNotes(); ?></span>
            <hr>
            Flight No: <?= $od->getSubFlightNo(); ?><br>
            Flight Time: <?= $od->getSubFlightTime(); ?>
            
        </td>
        <td width="25%" style="word-wrap:break-word !important">
            <b class="lead"><?= $od->getDropName(); ?></b><br/>
            <?= $od->getDropAddress(); ?>
          
        </td>
        <td>
            <b class="lead">
            	<?= SubDriverName($od->getSubDriver()); ?>
            	<?
            		if ($od->getSubDriver2() != 0) echo ' + ' . SubDriverName($od->getSubDriver2());
            		if ($od->getSubDriver3() != 0) echo ' + ' . SubDriverName($od->getSubDriver3());
            	?> 
            </b><br>
            <?= Car($od->getCar()) ?>
            <? if ($od->getCar2() != 0) echo ' + ' . Car($od->getCar2()); ?>
            <? if ($od->getCar3() != 0) echo ' + ' . Car($od->getCar3()); ?>
            <br>
            <?= $od->getSubDriverNote(); ?><br>
            P:<?= $od->getPaxNo(); ?> VT:<?= $od->getVehicleType(); ?><br>
            Cash In: <?= $od->getCashIn(); ?>€
           
        </td>
    </tr>

<? 

    } # end while

echo '</table>';

} #endif


function hiddenField($name,$value) {
	echo '<input name="'.$name.'" id="'.$name.'" type="hidden" value="'.$value.'">';
}

function SubDriverName($id) {
	$q = 'SELECT * FROM v4_AuthUsers WHERE AuthUserID = '.$id;
	$db = new DataBaseMysql();
	$r = $db->RunQuery($q);
	$d = $r->fetch_object();
	return $d->AuthUserRealName;
}

function Car($car) {
	$q = 'SELECT * FROM v4_SubVehicles WHERE VehicleID = '.$car;
	$db = new DataBaseMysql();
	$r = $db->RunQuery($q);
	$d = $r->fetch_object();
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
function YMD_to_DMY($date) {
	$elementi = explode('-',$date);
	$new_date = $elementi[2].'.'.$elementi[1].'.'.$elementi[0];
	return $new_date;
}    
?>
</body>
</html>

