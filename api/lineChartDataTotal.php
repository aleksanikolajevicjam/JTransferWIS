<?
if(isset ($_REQUEST['callback'])) { header("Content-Type: application/json"); }
require_once '../../db/db.class.php';

$q = new DataBaseMysql;


if($_REQUEST['range'] == 'month') {	
$result = $q->RunQuery("SELECT PickupDate, SUM(DetailPrice) as YearTotal, YEAR(PickupDate) as Year, MONTH(PickupDate) as Month FROM v4_OrderDetails GROUP BY YEAR(PickupDate), MONTH(PickupDate)");
}

if($_REQUEST['range'] == 'year') {	
$result = $q->RunQuery("SELECT PickupDate, SUM(DetailPrice) as YearTotal, YEAR(PickupDate) as Year FROM v4_OrderDetails  GROUP BY YEAR(PickupDate)");
}


$test = array();
while($r = $result->fetch_object()) {
	if($r->Year >= date("Y")-3 and $r->Year <= date("Y")) {
		
		if($_REQUEST['range'] == 'year') 	
			$test[] = array( 
				"y"=>$r->Year , 
				"Total" =>$r->YearTotal
			);
		
		if($_REQUEST['range'] == 'month')  	
			$test[] = array( 
				"y"=>$r->Year . '-' . $r->Month, 
				"Total" =>$r->YearTotal
			);
	}
}

echo $_REQUEST['callback'] . '(' . json_encode($test) . ')';
