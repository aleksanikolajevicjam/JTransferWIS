<?
@session_start();
//error_reporting(E_ALL);

require_once ROOT.'/cms/db.php';
require_once ROOT.'/cms/f/form_functions.php';

$db = getMyDb();



if (!isset($_REQUEST['startDate'])) $sd = date("Y-m-d", strtotime("-1 month")); 
else $sd = $_REQUEST['startDate'];

if (!isset($_REQUEST['endDate'])) $ed = date("Y-m-d"); 
else $ed = $_REQUEST['endDate'];
?>
<div class="container white pad1em">

<h2><?= NET_INCOME ?></h2>
<br>
<form action="index.php?p=netIncome" method="post">
<?= START_DATE ?> : <input type="text" class="datepicker" name="startDate" id="startDate" value="<?= $sd ?>">
<?= END_DATE ?> : <input type="text" class="datepicker"  name="endDate" id="endDate" value="<?= $ed ?>">

<button class="btn btn-primary" name="ACRSubmit" value="1" >Submit</button>
</form>
<br/>




<?
if (is('ACRSubmit','r') ) {

	$unpaidComm = 0;
	$paidComm = 0;



	$q1  = "SELECT * FROM ".DB_PREFIX. "AuthUsers ";
	$q1 .= "WHERE AuthLevelID = 31 ";
	$q1 .= "AND AuthUserID >= 100 ";
	$q1 .= "ORDER BY AuthUserID ASC";

	$w1 = $db->query($q1) or die($db->error . ' R_allCommision.AuthUsers');

	$i = 0;

	while ($u = $w1->fetch_object())
	{
		$total += showCommision($u->AuthUserID, $_REQUEST['endDate'],$_REQUEST['startDate'] );
	}

	echo NL;
	echo '<hr/>';
	echo '<table class="l"><tr><td>Commision not paid: &nbsp;</td><td align="right">' . 
	number_format($unpaidComm,2) . ' Eur</td></tr>';

	echo '<tr><td>Commision paid:            </td><td align="right">' . 
	number_format($paidComm,2) . ' Eur</td></tr>';

	echo '<tr><td>Total Commision:         </td><td align="right">' . 
	number_format($total,2) . ' Eur</td></tr>';

	echo '</table>';

} // end main if

?>
</div>
<script type="text/javascript">
	function setPaid(i)
	{
		var detailsID = $("#detailsID"+i).val();

		//alert(np+' ' + s + ' ' + r);
		$("#upd"+i).html('...');
		$.get(window.root + "/cms/p/modules/reports/admin/ajax_setPaidComm.php",{ DetailsID: detailsID },
			function(data){ $("#upd"+i).html(data); });
	}
		
	function setWarning(i)
	{
		var detailsID = $("#detailsID"+i).val();

		//alert(np+' ' + s + ' ' + r);
		$("#upd"+i).html('---');
		$.get(window.root + "/cms/p/modules/reports/admin/ajax_setWarning.php",{ DetailsID: detailsID },
			function(data){ $("#upd"+i).html(data); });
		}		
</script>


<?
function showCommision($user, $endDate='', $startDate = '')
{
    
    # deklarirano u R_allCommision.php
    global $i, $paidComm, $unpaidComm, $db;
    
    if ($startDate == '') $startDate = date("Y-m-d", strtotime("-1 month"));
    if ($endDate == '') $endDate = date("Y-m-d");
    $subTotal = 0;

    $q1  = "SELECT * FROM ".DB_PREFIX."OrderDetails ";
    $q1 .= "WHERE DriverID = '{$user}' ";
    $q1 .= "AND TransferStatus = 5 ";
    $q1 .= "AND PickupDate >= '{$startDate}'";
    $q1 .= "AND PickupDate <= '{$endDate}'";
    $q1 .= "AND DriverConfStatus = '5'";
    //$q1 .= "AND PaymentStatus <= '10'";

    $w = $db->query($q1) or die( $db->error . ' OrderDetails');

    # ako vozac ima transfere
    if ($w->num_rows != 0) {
    
       
        
        echo '<div class="grey lighten-3 pad1em l">Driver: '. UserRealName($user) . ' ID:' . $user . '</div>';
        echo '<div class="pad1em"><table class="table xtable-striped table-hover" width="100%" colpadding="4" border="0">';
        echo '<thead>';
        echo '<tr>';
        echo '<td style="border-bottom:1px solid #eee"><b>Transfer Number</b></td>';
        echo '<td style="border-bottom:1px solid #eee"><b>Transfer Date</b></td>';
        echo '<td style="border-bottom:1px solid #eee"><b>Commision</b></td>';
        echo '<td style="border-bottom:1px solid #eee"><b>Payment Status</b></td>';
        echo '</tr>';
        echo '</thead>';

        while ($od = $w->fetch_object())
        {
            # za svaki transfer pojedinog vozaca
            echo '<tr>';
            echo '<td>' . $od->DetailsID . '</td><td>' . $od->PickupDate . '</td><td>';
            echo $od->TaxidoComm . ' EUR' . '</td>';
            echo '<td>';
            echo '<div id="upd'.$i.'">';
            if ( $od->PaymentStatus > '90') echo 'Paid'; 
            else {
            	if ( $od->PaymentStatus == '1') echo '<strong>Warning set</strong>'; 
                else echo 'Not Paid';
                
                echo '<input type="hidden" id="detailsID'.$i.'" value="'.$od->DetailsID.'" />';
                
                echo '&nbsp;&nbsp;&nbsp;<button class="btn btn-info btn-xs"
                id="setPaid'.$i.'"  
                onclick="setPaid('.$i.')"> &larr; Set to Paid </button>';

                echo '&nbsp;&nbsp;&nbsp;<button class="btn btn-warning btn-xs"
                id="setWarning'.$i.'" 
                onclick="setWarning('.$i.')"> &larr; Set Warning </button>';
                //echo $i;
            }
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            
            if ( $od->PaymentStatus < '90') $unpaidComm += $od->TaxidoComm;
            if ( $od->PaymentStatus > '90') $paidComm += $od->TaxidoComm;
            
            if ( $od->PaymentStatus < '90' ) $driverUnpaidComm += $od->TaxidoComm;
            if ( $od->PaymentStatus > '90') $driverPaidComm += $od->TaxidoComm;
            
            $subTotal += $od->TaxidoComm;
            
            $i++;
        }
        echo '<td></td><td></td><td>';
        echo '<p class="line eee"></p><b>' . number_format($subTotal,2) . ' EUR</b>' . '</td><td><p class="line eee"></p>Paid: '.number_format($driverPaidComm,2).
        ' | To Pay: '.number_format($driverUnpaidComm,2).'</td>';
        echo '</table></div>';
    }
    
    return $subTotal;
}


function UserRealName($id)
{
	global $db;
	$q = "SELECT * FROM ".DB_PREFIX."AuthUsers WHERE AuthUserID = '{$id}'";
	$r = $db->query($q);
	$u = $r->fetch_object();
	
	return $u->AuthUserRealName;
}
