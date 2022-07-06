<?
	@session_start();
	
    $db = new DataBaseMysql();

	//potrebna polja za query
	$DateFrom = $_REQUEST['DateFrom'];
	$DateTo = $_REQUEST['DateTo'];

	$sub = array();
	$cash = array();

	echo '<div class="container white center">';

	//ako imamo oba datuma prikazi izvjestaj
	if( isset($_REQUEST['DateFrom']) and isset($_REQUEST['DateTo']) ){
		
		//dohvatit SVE subdrivere koji su vozili u periodu from-to iz v4_OrderDetails, a onda za svakog subdrivera dohvatit sve transfere koje su odradili u period from-to te izlistat 
		//subdriver - no. transfers
		
		$q  = "SELECT * FROM v4_OrderDetails ";
		$q .= "WHERE PickupDate >= '".$DateFrom."' ";
		$q .= "AND PickupDate <= '".$DateTo."' ";
		$q .= "AND (DriverID = '843' OR DriverID = '876') ";
		$q .= "AND SubDriver != '0' ";
		$q .= "AND TransferStatus != '3' ";
		$q .= "AND TransferStatus != '4' ";
		$q .= "AND TransferStatus != '9' ";
		$q .= "ORDER BY PickupDate ASC";

		$r = $db->RunQuery($q);

		if($r->num_rows > 0 ){

			showHeader();
		
			while($od = $r->fetch_object() ){

/**/
/**/

				$i = 1; 
				if($od->SubDriver != $od->SubDriver2 and $od->SubDriver != $od->SubDriver3 ) {
					if(array_key_exists($od->SubDriver, $sub) ){ 
						$i = $sub[$od->SubDriver] + 1; 
					}
					$sub[$od->SubDriver] = $i;

				}

				$i = 1; 
				if($od->SubDriver2 != 0 and $od->SubDriver2 != $od->SubDriver and $od->SubDriver2 != $od->SubDriver3 ) {
					if(array_key_exists($od->SubDriver2, $sub) ){
						$i = $sub[$od->SubDriver2] + 1;
					}
					$sub[$od->SubDriver2] = $i;

				}


				$i = 1; 
				if($od->SubDriver3 != 0 and $od->SubDriver3 != $od->SubDriver2 and $od->SubDriver3 != $od->SubDriver ) {
					if(array_key_exists($od->SubDriver3, $sub) ){
						$i = $sub[$od->SubDriver3] + 1;
					}
					$sub[$od->SubDriver3] = $i;
				}
			}
		}






		foreach($sub as $key => $value) {
			$u=getUser($key);
			

			//CASH IN
	        $qd  = "SELECT SUM(CashIn) AS Primljeno FROM v4_OrderDetails ";
	        $qd .= "WHERE (SubDriver = '" . $key ."' ";
	        $qd .= "OR SubDriver2 = '" . $key ."' ";
	        $qd .= "OR SubDriver3 = '" . $key ."') ";
	        $qd .= "AND PickupDate >= '2018-08-01'";

	        $w = $db->RunQuery($qd);
	        $p = $w->fetch_object();


	        // CASH EXPENSES
	        $qt  = "SELECT SUM(Amount) AS Trosak FROM v4_SubExpenses WHERE Card = 0 ";
	        $qt .= "AND DriverID = '" . $key ."' ";
	        $qt .= "AND Datum >= '2018-08-01'";
	
	        $wt = $db->RunQuery($qt);
	        $t = $wt->fetch_object();

			$balance = $p->Primljeno - $t->Trosak;

			//TOTAL VALUE
	        $qv  = "SELECT SUM(DetailPrice) AS TotalValue FROM v4_OrderDetails ";
	        $qv .= "WHERE SubDriver = '" . $key ."' ";
	        $qv .= "AND PickupDate >= '" . $DateFrom."' ";
			$qv .= "AND PickupDate <= '" . $DateTo."' ";

	        $wv = $db->RunQuery($qv);
	        $pv = $wv->fetch_object();

			$totalValue = $pv->TotalValue;


			?>
			<div class="row pad1em" style="border-bottom:1px solid #ddd;">
			    <div class="col-sm-3">
			        <?=$key?> - <?=$u->AuthUserRealName ?>
			    </div>	
			    <div class="col-sm-3">
			        <?=$value ?> 
			    </div>
			    <div class="col-sm-3">
			        <?=$totalValue ?> EUR
			    </div>
			    <div class="col-sm-3">
			        <?=$balance ?> EUR
			    </div>
			</div>
		<?}
		

			
	} else {//otvori formu dateTo datefrom ?>

		<body>
		<style>
		    input, select { width: 200px; }
		    #RequiredFrom, #RequiredTo { visibility: hidden; padding-left: 4px; color: red; }
		    .formLabel { width: 100px; display: inline-block; }
		</style>

		<div class="container col-md-12">
			<h1>SubDriver History</h1><br><br><br>

			<form action="" method="POST" type="submit" onsubmit="return validate();">

				<div class="row">
					<div class="col-md-2">
						<label>Date From</label>
					</div>
					<div class="col-md-2">
						<input type="text" value="0" name="DateFrom" class="datepicker">
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<label>Date To</label>
					</div>
					<div class="col-md-2">
						<input type="text" value="0" name="DateTo" class="datepicker">
					</div>
				</div>

				<br>
				<div class="row col-md-4">
			    	<button type="submit" class="btn btn-primary" name="submit"
					style="margin-left: 105px">Submit</button>
				</div>

				<div id="greska"></div>

				</div>
			</form>
		</div>
		</body>
	<?}

	function showHeader() { 
	 
 	    ?>
        <h2>SubDriver History from: <?=$_REQUEST['DateFrom'] ?> - <?=$_REQUEST['DateTo'] ?></h2>
        <br><br>

   		<div class="row pad1em" style="border-bottom:1px solid #ddd;">
			<div class="col-sm-3">
			    <strong>ID - Name</strong>
			</div>	
			<div class="col-sm-3">
			    <strong>Number of Transfers</strong> 
			</div>
			<div class="col-sm-3">
			    <strong>Total Value</strong> 
			</div>
			<div class="col-sm-3">
			    <strong>Account balance</strong> 
			</div>
		</div>
	    <?
	}?>

    </div><br><br><br>   

	<script>

		function validate() {
			if( $("#DateTo").val() == 0 || $("#DateFrom").val() == 0 ) {
				$("#greska").html('<i class="fa fa-times fa-2x fa-spin"></i> Enter all data');
				return false;
			}
		}
	</script>






