<? 
	// LANGUAGES
	if ( isset($_SESSION['CMSLang']) and $_SESSION['CMSLang'] != '') {
		$languageFile = ROOT.'/lng/' . $_SESSION['CMSLang'] . '_text.php';
		if ( file_exists( $languageFile) ) require_once $languageFile;
		else {
			$_SESSION['CMSLang'] = 'en';
			require_once ROOT.'/lng/en.php';
		}
	}
	else {
		$_SESSION['CMSLang'] = 'en';
		require_once ROOT.'/lng/en.php';
	}
	
	$_SESSION['language'] = $_SESSION['CMSLang'];
	
	require_once ROOT . '/db/db.class.php';
	$db = new DataBaseMysql();
	
	require_once ROOT.'/db/v4_Places.class.php';	
	$pl = new v4_Places();
	
	
	if (isset($_SESSION['FromID']) && $_SESSION['FromID']>0) {
		$fromID=$_SESSION['FromID'];
		global $pl;
		$pl->getRow($fromID);
		$fromName=$pl->getPlaceNameEN();	
	}
	if (isset($_SESSION['ToID']) && $_SESSION['ToID']>0) {
		$toID=$_SESSION['ToID'];
		global $pl;
		$pl->getRow($toID);
		$toName=$pl->getPlaceNameEN();	
	}	

	
	if (isset($_SESSION['transferDate']))  $transferDate=$_SESSION['transferDate'];

  
	// END OF LANGUAGES	

    
    // Prevent refresh on thankyou.php page
    $_SESSION['REFRESHED'] = false;
    

    
    if ( (isset($lastElement) and count($lastElement) == 2) or !empty($_REQUEST) ) { // postoje neki parametri
    	// spremi sve u session
    	foreach	($_REQUEST as $key => $value) {
    		$_SESSION[$key] = $value;
    	}
    } 
    
    require_once "scriptsAdm.php";
	
	if (s('MPaxFirstName')=='') $PaxFirstName=" ";
	else $PaxFirstName=s('MPaxFirstName');
    ?>

    
    <div style="background: transparent  center fixed; background-size: cover; margin-top:-20px !important">
       <div class="container pad1em" style="background-color: rgba(70,79,96,0.75); border:1px solid #000;border-radius:6px;">
            <div class="row">
				<div class="col s12 xucase center white-text">
                    <h3>TRANSFER COST STRUCTURE</h3>
                </div>        
                <div class="col s12 xgrey xlighten-3">
                    <form id="bookingForm" name="bookingForm" action="index.php?p=final" method="POST" enctype="multipart/form-data"
                    onsubmit="return validateBookingForm();">
                        <input type="hidden" id="pleaseSelect" value="<?= PLEASE_SELECT?>"/>
                        <input type="hidden" id="loading" value="<?= LOADING ?>"/>
                        <div class="col s12 l6">
                        	<br>
                            <label for="fromSelectorValue"><i class="fa fa-map-marker"></i> <?= FROM ?></label><br>
							<input type="hidden" id="FromID" name="FromID" value="<?= $fromID ?>"><i class="pe-7s-car pe-lg  pe-va white-text"></i>
							<?= $STARTING_FROM ?>
							<input type="text" id="FromName" name="FromName" value="<?= $fromName ?>" class="input-lg" style="width:100%"  placeholder="<?= $SEARCH_PLACEHOLDER ?>"
								autocomplete="off">
							<span id="fromLoading" class="small"><?= $TYPE_SEARCH ?></span>
							<div id="selectFrom_options" class="list-group white" style="max-height:15em;overflow:auto"></div>
							<input type="hidden" id="FromLatitude" name="FromLatitude" value=""/>
							<input type="hidden" id="FromLongitude" name="FromLongitude" value=""/>
							<input type="hidden" id="FromElevation" name="FromElevation" value=""/>
							<input type="hidden" id="FromCountry" name="FromCountry" value=""/>
                        </div>
                        <!-- from -->
                        <div class="col l6 s12">
                        	<br>
                            <label for="toSelectorValue" ><i class="fa fa-map-marker"></i> <?= TO ?></label> <span style='color:white' id='toname2'></span><br>
							<input type="hidden" id="ToID" name="ToID" value="<?= $toID ?>"><i class="pe-7s-map-marker pe-lg  pe-va white-text"></i>
							<?= $GOING_TO ?>
							<input type="text" id="ToName" name="ToName" value="<?= $toName ?>" class="input-lg" style="width:100%"  placeholder="<?= $SEARCH_PLACEHOLDER ?>"
								autocomplete="off">
							<span id="toLoading" class="small"><?= $TYPE_SEARCH ?></span>
							<div id="selectTo_options" class="list-group white"style="max-height:15em;overflow:auto"></div>
							<input type="hidden" id="ToLatitude" name="ToLatitude" value=""/>
							<input type="hidden" id="ToLongitude" name="ToLongitude" value=""/>		
							<input type="hidden" id="ToElevation" name="ToElevation" value=""/>	
							<input type="hidden" id="ToCountry" name="ToCountry" value=""/>							
                        </div>
                        <!-- to -->
						<!--<div id="dist" class="col l6 s12" style="display:none">
                        	<br>
                            <label><i class="fa fa-map-marker"></i> Distance (test usage, will be from Google api)</label><br>
							<input type="text" id="Distance" name="Distance" value="" class="input-lg" style="width:100%" >
                        </div>*!-->
						
                        <div class="col s12 l3">
                        	<br>
                            <label for="transferDate"><i class="fa fa-calendar-o"></i> <?= PICKUP_DATE ?></label><br>
                            <input type="text"  id="transferDate" class="browser-default" 
                                name="transferDate" readonly 
                                value="<?= $transferDate ?>" data-field="date">
                        </div>
                        <!-- pickup date -->
                        
                        <div class="col s12 l3">
                        	<br>
                            <label for="transferTime"><i class="fa fa-clock-o"></i> <?= PICKUP_TIME ?></label><br>
                            <input type="text" id="transferTime" class="browser-default timepick" 
                            name="transferTime"
                                value="<?= s('transferTime')?>" data-field="time">
                        </div>
						<div class="col s12 l3 pull"><br><br>
							<button id="selectCarAdminBtn" type="submit" class="btn blue btn-large"
								onclick="return false;">
								<i class="fa fa-chevron-down"></i> Show
							</button>
						</div>							
                        <div class="col s12">
                            <div class="tab" id="tab_1"> 
                                <div id="selectCar">
									<? 
									//require_once ROOT . '/m/getRoutePrices.php';
									$car =   getRoutePrices( s('FromID'), s('ToID') );

									$cells =  count($car);

										switch ($cells) {
											case 1: $box = 'l4'; $offset = 'offset-l2'; break;
											case 2: $box = 'l3'; $offset = 'offset-l3'; break;
											case 3: $box = 'l4'; $offset = ''; break;
											case 4: $box = 'l3'; $offset = ''; break;
											case 5: $box = 'l2'; $offset = 'offset-l1'; break;
											case 6: $box = 'l2'; $offset = ''; break;
											case 7: $box = 'l3'; $offset = ''; break;
											case 8: $box = 'l3'; $offset = ''; break;
											case 9: $box = 'l3'; $offset = ''; break;
											case 10: $box = 'l2'; $offset = ''; break;
											case 11: $box = 'l3'; $offset = ''; break;
											case 12: $box = 'l2'; $offset = ''; break;
										}
									?>
                                </div>
								<div id="final" style='display: none;'>Proba</div>
                            </div>
                            <!-- tab_1 -->
                        </div> 
						
                        <input type="hidden" id="AgentName" name="AgentName" value="0"> 
						<input type="hidden" id="DriverID" name="DriverID" value="0">
						<input type="hidden" id="DriverName" name="DriverName" value="0">
						<input type="hidden" id="VehicleID" name="VehicleID" value="0">
						<input type="hidden" id="VehiclesNo" name="VehiclesNo" value="1">
						<input type="hidden" id="VehicleName" name="VehicleName" value="">
						<input type="hidden" id="VehicleCapacity" name="VehicleCapacity" value="0">
						<input type="hidden" id="VehicleImage" name="VehicleImage" value="">
						<input type="hidden" id="ServiceID" name="ServiceID" value="0">
						<input type="hidden" id="RouteID" name="RouteID" value="0">
						<input type="hidden" id="Price" name="Price" value="0">
						<input type="hidden" id="AgentPrice" name="AgentPrice" value="0">						
						<input type="hidden" id="DriversPrice" name="DriversPrice" value="0">
						<input type="hidden" id="returnTransfer" name="returnTransfer" value="0">
						<input type="hidden" id="ToName2" name="ToName2" value="0">
						<input type="hidden" id="VehicleName2" name="VehicleName2" value="">	
                    </form>
                    <!-- booking form -->
                    <br>&nbsp;     
                </div>
                <!-- booking form col grey -->
                <br><br>
            </div>
            <!-- main row -->
        </div>
        <!-- main container -->
        <br>&nbsp;
    </div>
    <!-- background div -->
<?
require_once(ROOT."/cms/t/booking.js.php"); 
require_once(ROOT."/cms/transcalc/transCalc.js.php");


function getRoutePrices($fromID, $toID) {
	global $db;
	$prices = array();

	$places = array();

		# Routes for selected place
		$q1 = "SELECT FromID, ToID, RouteID FROM v4_Routes
					WHERE 
					(FromID = '{$fromID}'
					AND    ToID   = '{$toID}')
					OR
					(FromID = '{$toID}'
					AND    ToID   = '{$fromID}')				
					
					";
		$r1 = $db->RunQuery($q1);
		

		while($r = mysqli_fetch_object($r1))
		{
			
			# DriverRoutes - check if anyone drives from that Place
			$q2 = "SELECT DISTINCT RouteID FROM v4_DriverRoutes
						WHERE RouteID = '{$r->RouteID}' 
						";
			$w2 = $db->RunQuery($q2);
			
			# If does
			if  (mysqli_num_rows($w2) > 0)
			{

			# Services 
			$q3 = "SELECT * FROM v4_Services
						WHERE RouteID = '{$r->RouteID}' AND ServicePrice1 != 0 
						ORDER BY ServicePrice1 ASC";
			$w3 = $db->RunQuery($q3);
			while($s = mysqli_fetch_object($w3)) {
				$q4 = "SELECT * FROM v4_VehicleTypes
							WHERE VehicleTypeID = '{$s->VehicleTypeID}' "; 
				$w4 = $db->RunQuery($q4);
				$v = mysqli_fetch_object($w4);
				
				$type = $v->Max; // bilo VehicleTypeID - promjena 2016-05-25
				
				$sp = nf( calculateBasePrice($s->ServicePrice1, $s->OwnerID));
				if(array_key_exists($type, $prices) ) {
					if($prices[$type] > $sp) {
						$prices[$type] = $sp;
					}
				} else {
				
					$prices[$type] = $sp;
				}
			}
			}

		}
	return $prices;
}
 

function calculateBasePrice($price, $ownerid) {
	global $db;
	
		# Driver
		$q = "SELECT * FROM v4_AuthUsers
					WHERE AuthUserID = '" .$ownerid."' 
					";
		$w = $db->RunQuery($q);
		
		$d = mysqli_fetch_object($w);
		
		if($d->AuthUserID == $ownerid) {

		if ($price >= $d->R1Low and $price <= $d->R1Hi) return $price + ($price*$d->R1Percent / 100);
		else if ($price >= $d->R2Low and $price <= $d->R2Hi) return $price + ($price*$d->R2Percent / 100);
		else if ($price >= $d->R3Low and $price <= $d->R3Hi) return $price + ($price*$d->R3Percent / 100);
		else return $price;
		}
		
		return '0';		
}
