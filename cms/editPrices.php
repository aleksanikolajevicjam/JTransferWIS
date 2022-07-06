<?
// ----------------------------------------------------------------------------
//
//  File:   priceList.php
//  Creation Date:  10/02/12
//  Last Modified:  13/02/12
//  Purpose: update all prices in one place
//
// ----------------------------------------------------------------------------

require_once 'init.php';
require_once 'f/functions.php';
require_once 'f/form_functions.php';
require_once 'f/db_funcs.php';


//$ownerID = $_SESSION['AuthUserID'];
$ownerID = '100';


if (isset($_REQUEST['update']) and $_REQUEST['update'] != '') {
	
	# set the index counter
	$i = 0;
	
	foreach	($_REQUEST['fullPrice'] as $fp )
	{
				
		# get existing price and Correction
		$km = GetRouteKm($_REQUEST['RouteID'][$i]);
				
		$s = GetServiceData($_REQUEST['ServiceID'][$i]);
		
		$v = GetVehicleData($s->VehicleID);
		
		# calculate newCorrection value
		$currentPrice = round( ($km * $v->PriceKm) );
		$newCorrection = $fp - $currentPrice;
		
		# control
		/*
		echo $_REQUEST['ServiceID'][$i] . NL;
		echo $km.NL;
		echo $s->Correction.NL;
		echo $v->PriceKm.NL;
		echo  ($currentPrice + $s->Correction) .NL;
		echo $fp.NL;
		echo $newCorrection.NL;
		echo '<hr/>';
		*/
		
		# update Correction field for selected ServiceID
		$data = array(
							//'ServicePrice1' => $fp,
							'Correction' => $newCorrection,
							'LastChange' => date("Y-m-d")
						);
						
		$where = 'ServiceID = '. $_REQUEST['ServiceID'][$i];
		$where.= ' AND OwnerID = '.$ownerID;
		
		XUpdate(DB_PREFIX.'Services',$data,$where);
				
		
		# increment index
		$i++;
	}
	
	# show Message
	dashMsg('Success','
					<div align="center">
						<br/>
						All Prices Updated!
						<br/>
						<br/>
						<br/>
						<input type="button" class="my_button" value="Continue" onClick="parent.location=\'index.php?option=dashboard\'"/>
						<br/>
					</div>
						
						');
	
}

else priceListForm($ownerID);


function GetServiceData($serviceID)
{
	$q = "SELECT * FROM ".DB_PREFIX."Services
         WHERE ServiceID = '{$serviceID}' 
        ";

	$w = mysql_query($q) or die(mysql_error());

	$r = mysql_fetch_object($w);
	
	return $r;
}


function GetVehicleData($vehicleID)
{
	$q = "SELECT * FROM ".DB_PREFIX."Vehicles 
         WHERE VehicleID = '{$vehicleID}' 
        ";

	$w = mysql_query($q) or die(mysql_error());

	$r = mysql_fetch_object($w);
	
	return $r;
}



/* This function shows all prices with possibility to change them */
function priceListForm($ownerID) 
{

	define("B"," ");
	
	$tempRouteName = '';
	
	startForm();
	echo '<div class="grid">';
	
		$d1 = '<div class="col-8-12">';
		$d2 = '<div class="col-4-12">';
		$dc = '</div>';

	  echo $d1. '<h3>'. 'Route' .'</h3>'.$dc. $d2.'<h3>'. 'Final Price'. '</h3>'.$dc;
	  
	  echo $dc;
		
		$i = 0;

	
	$q = "SELECT * FROM ".DB_PREFIX."DriverRoutes
				WHERE OwnerID = " . $ownerID . " 
				ORDER BY RouteName ASC
				";
				
				
	$w = mysql_query($q) or die(mysql_error());

	while	($dr = mysql_fetch_object($w) ) 
	{
	
		$qr = "SELECT * FROM ".DB_PREFIX."Routes
					WHERE RouteID = '{$dr->RouteID}' 
					";
		$wr = mysql_query($qr) or die(mysql_error());
		
		$r = mysql_fetch_object($wr);
	

		# output RouteName
		if ($dr->RouteName == $tempRouteName) {
			 echo  '' ;
		} else {
			  echo '<div class="grid">';
			  echo $d1. '<strong>'. $dr->RouteName.'</strong><hr>'.$dc. $d2. $r->Km .' km<hr>'. $dc;
			  echo $dc;
			  $tempRouteName = $dr->RouteName;
		}	
		
		$qs = "SELECT * FROM ".DB_PREFIX."Services
					WHERE RouteID = '{$dr->RouteID}'
					AND OwnerID = '{$ownerID}'  
					ORDER BY ServiceID ASC
					";
		$ws = mysql_query($qs) or die(mysql_error());
		
		while ($s = mysql_fetch_object($ws)) {
			
			# Get Vehicle Data
			$q2 = "SELECT * FROM ".DB_PREFIX."Vehicles 
						WHERE VehicleID = '{$s->VehicleID}'
						";
			$r2 = mysql_query($q2) or die(mysql_error());
		
			$v = mysql_fetch_object($r2);
		
		
			# show output - for now
		
		
		
		
			$price = round ( ($v->PriceKm * $r->Km) + $s->Correction);
			//$price = number_format ( $s->ServicePrice1, 0,'','');
		
		
			echo '<div class="grid">';
			echo $d1. $v->VehicleName .$dc;
		
			echo $d2.'<input type="text" 
								class="pr" 
								name="fullPrice_'.$i.'" 
								id="fullPrice_'.$i.'" 
								value="'.$price.'" 
								onchange="newPrice('.$i.');" 
								size="4" />' . ' EUR
								<div style="display:inline-block;color:#900;" id="upd'.$i.'"></div>' . $dc;
		
			echo $dc;
			
			# save ServiceID with same index as the price
			hiddenField('ServiceID_'.$i, $s->ServiceID);
			hiddenField('RouteID_'.$i, $r->RouteID);
						
			$i++;
		
			
		}	 # end Services
		
	} # end DriverRoutes
	
	
	echo '</div>';
	
	
	endForm(false,false,false);
} #end function
?>

<script type="text/javascript">
	function newPrice(i)
	{
		var np = $("#fullPrice_"+i).val();
		var s = $("#ServiceID_"+i).val();
		var r = $("#RouteID_"+i).val();
		//alert(np+' ' + s + ' ' + r);
		$("#upd"+i).html('<img src="images/loading8.gif"/>');
		$.get("ajax_setNewPrice.php",{ ServiceID: s, RouteID: r, fp:np },
	function(data){ $("#upd"+i).html(data); });
	}
</script>
