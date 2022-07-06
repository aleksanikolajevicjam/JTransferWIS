<? 
require_once '../config.php';

$AgentID=$_REQUEST['AgentID'];
$DriverID=$_REQUEST['DriverID'];
$DetailsID=$_REQUEST['DetailsID'];

require_once '../db/v4_Extras.class.php';
require_once '../db/v4_OrderExtras.class.php';
require_once '../a/getContractPrices.php';


$e = new v4_Extras();
$oe = new v4_OrderExtras();
$k = $e->getKeysBy('Service', 'ASC', ' WHERE OwnerID = ' . $DriverID . ' OR OwnerID = 9999'); 
$extras = array();

if( count($k) > 0) {
    foreach($k as $nn => $id) {
	    $e->getRow($id);
		$serviceid=$e->getID();
		$servicename=$e->getServiceEN();
		$extras_arr=$e->fieldValues();	
		$Price = getContractExtrasPrice($extras_arr['ServiceID'], $AgentID) ;		
		if ($Price>0) $extras_arr['Price']=$Price; 
		
		//$ok = $oe->getKeysBy('ID', 'ASC', " WHERE OrderDetailsID = " . $DetailsID . " AND ServiceID = ".$serviceid);
		$ok = $oe->getKeysBy('ID', 'ASC', " WHERE OrderDetailsID = " . $DetailsID . " AND ServiceName = '".$servicename."'");

		if( count($ok) > 0) {
			$oe->getRow($ok[0]);
			$qty=$oe->getQty();
			$extras_arr = array_merge($extras_arr, array("Qty" => $qty));	
		}	
		else $extras_arr = array_merge($extras_arr, array("Qty" => 0)); 
	    $extras[] = $extras_arr;
    }
} 
ob_start();
?> 

		<? if( count($extras) > 0) { ?>
		
		<div class="col-md-12" style="border-bottom:1px solid #ddd">
			<div class="col-md-7">
				<strong>Item</strong>
			</div>
			<div class="col-md-1">
				<strong>Price (€)</strong>
			</div>			
			<div class="col-md-2">
				<strong>Driver Price (€)</strong>
			</div>						
			<div class="col-md-2">
				<strong>Quantity</strong>
			</div>							
		</div>
	<? 
		$i = 1;
		foreach($extras as $row => $services) {	?>			
		<div class="col-md-12">
			<div class="col-md-7">
				<?= $services['ServiceEN'] ?> 
			</div>
			<div class="col-md-1">
				<?= $services['Price'] ?>
			</div>			
			<div class="col-md-2">
				<?= $services['DriverPrice'] ?>
			</div>				
			<div class="col-md-2">
				<input name='Qty' class='quant' onchange="return changeExtras(<?= $services['ID'] ?>, this.value);" data-serviceid='<?= $services['ID'] ?>' type="number" value='<?= $services['Qty']?>' min="0" max="5">
			</div>
		</div>
		<?  $i++; 
			} 
		}
		?>
		<div class="col-md-12" style="border-bottom:1px solid #ddd"></div> 
<?
$content = ob_get_contents();
ob_end_clean();
echo $content;
