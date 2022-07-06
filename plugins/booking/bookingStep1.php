<? 
	require_once ROOT.'/db/v4_Places.class.php';	
	require_once 'scripts.js.php';
	require_once ROOT.'/db/v4_AuthUsers.class.php';

	
	$pl = new v4_Places();
	
	if (isset($_SESSION['AgentID']) && $_SESSION['AgentID']>0) $AgentID=$_SESSION['AgentID'];
	else $AgentID=0;	
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
	if (isset($_SESSION['PaxNo']) && $_SESSION['PaxNo']>0) $PaxNo=$_SESSION['PaxNo'];
	else $PaxNo=0;	
	
	if (s('MPaxTel')=='') $PaxTel=" ";
	else $PaxTel=s('MPaxTel');	
	
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
    	
	if (s('MPaxFirstName')=='') $PaxFirstName=" ";
	else $PaxFirstName=s('MPaxFirstName');
	for($i=1; $i<55; $i++) {
		$paxOptions .= '<option value="'.$i.'" ';
		if ($PaxNo==$i) $paxOptions .= 'selected="selected"';
		$paxOptions .= '>'.$i.'</option>';
	}	
	
	$au = new v4_AuthUsers();	
	$agents = array(); 
	$agents = getAgents(); 
				
	foreach($agents as $id => $name) {
		if ($AgentID==$id) $selected='selected';
		else $selected='';
		$allAgents.='<option value="'.$id.'"  '. $selected . '>' . $name .'</option>';
	}	
	
    ?>

    <div style="background: transparent url('i/header/112.jpg') center fixed; background-size: cover;
		margin-top:-20px !important">
        <br>
       <div class="container pad1em" style="background-color: rgba(70,79,96,0.75); border:1px solid #000;border-radius:6px;">
            <div class="row">

				<div class="col s12 xucase center white-text">
                    <h3>ADMINISTRATION <?= BOOKING ?>
					</h3>
					<p class="divider clearfix"></p>
					
                </div>
                <!-- title column -->
                
                <div class="col s12 xgrey xlighten-3">
                    <br>
                    <form id="bookingForm" name="bookingForm" action="booking/final" method="POST" enctype="multipart/form-data"
                    onsubmit="return validateBookingForm();">
                        <input type="hidden" id="pleaseSelect" value="<?= PLEASE_SELECT?>"/>
                        <input type="hidden" id="loading" value="<?= LOADING ?>"/>
                        
                        <div class="col l6 s12">
                            <label for="AuthUserIDe"><i class="fa fa-globe"></i> Book as <strong>Agent</strong></label><br>
                            <div>						
								<select name="AgentID" id="AgentID" class="xchosen-select browser-default" value='<?= s('AgentID') ?>'>
									<option value="0"> --- </option>
									<?= $allAgents; ?>
								</select>
							</div>
                        </div>					
                        <div class="col s12 l2" >
                            <label for="ReferenceNo"><i class="fa fa-book"></i> Agent Reference Number</label><br>
                            <input type="text"  id="ReferenceNo" class="browser-default" name="ReferenceNo"  value="">
                        </div>						
                        <div class="col s12 l2" id='webyblock' style="display:none">
                            <label for="wrn"><i class="fa fa-book"></i> Weby Reference Number</label><br>						
                            <select id="wref" class="browser-default" name="wref" value=''>
                            </select>
                        </div>						

                        <div class="col s12 l2" id='sunblock'  style="display:none">
                            <label for="srn"><i class="fa fa-book"></i> Sun Reference Number</label><br>						
                            <input type="file"  id="srn" class="browser-default" name="SunReferenceNo"  value="">
                        </div>	
                        
                        <div class="col s12 l6">
                        	<br>
                            <label for="fromSelectorValue"><i class="fa fa-map-marker"></i> <?= FROM ?></label><br>
							<input type="hidden" id="FromID" name="FromID" value="<?= $fromID ?>"><i class="pe-7s-car pe-lg  pe-va white-text"></i>
							<?= $STARTING_FROM ?>
							<input type="text" id="FromName" name="FromName" value="<?= $fromName ?>" class="input-lg" style="width:100%"  placeholder="<?= $SEARCH_PLACEHOLDER ?>"
								autocomplete="off">
							<span id="fromLoading" class="small"><?= $TYPE_SEARCH ?></span>
							<div id="selectFrom_options" class="list-group white" style="max-height:15em;overflow:auto"></div>
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
                        </div>
                        <!-- to -->
                        <div class="col l6 s12">
                        	<br>
                            <label for="paxSelector">
                            <i class="fa fa-user"></i> <?= PASSENGERS_NO ?>
                            </label>
                            <select id="paxSelector" class="browser-default" name="PaxNo" value='<?= $PaxNo ?>'>
                                <option value="0"> --- </option>
                                <?= $paxOptions ?>
                            </select>
                        </div>
                        <!-- passengers no. -->
                        
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
                        <!-- pickup time -->
                        
                        <div class="col l6 s12">
                        	<br>
                            <div class="switch">
                                <label for="returnTransferCheck">
                                    <i class="fa fa-undo"></i> <?= RETURN_TRANSFER ?>
                                </label>
                                <br><br>
                                <label class="center">
                                    <?= NO ?>
                                    <input type="checkbox" name="returnTransferCheck" id="returnTransferCheck" 
                                        <? if (s('returnTransfer')=='1') echo 'checked';?>>
                                    <span class="lever"></span>
                                    <?= YES ?>
                                </label>
                                <br><br>
                            </div>
                        </div>
                        <!-- return transfer switch -->
                        
                        <div id="showReturn" style="display:none;margin:-0.75rem !important" class="col s12">
                            <div class="col s12 l3">
                            	<br>
                                <label for="returnDate"><i class="fa fa-calendar-o"></i> <?= RETURN_DATE ?></label><br>
                                <input type="text"  id="returnDate" class="browser-default" 
                                    name="returnDate" readonly 
                                    value="<?= s('returnDate')?>" data-field="date"> 
                            </div>
                            <div class="col s12 l3">
                            	<br>
                                <label for="returnTime"><i class="fa fa-clock-o"></i> <?= PICKUP_TIME ?></label><br>
                                <input type="text" id="returnTime" name="returnTime" 
                                    class="browser-default timepick" data-field="time"
                                    value="<?= s('returnTime')?>">
                                    <br><br>
                            </div>
                        </div>
                        <!-- show return date/time -->
                        <br>
				        <div class="col s12 pad1em white-text" style="padding: 1rem !important; background: rgba(0,0,0,.5)">
				            <div class="col s12 l9">
				                <p><i class="fa fa-info-circle fa-2x red-text"></i> 
				                <?= AVAILABILITY_DEPENDS ?> </p>
				            </div>
				            <div class="col s6 l3 pull">
				                <button id="selectCarAdminBtn" type="submit" class="btn blue btn-large"
				                    onclick="return false;">
                                    <i class="fa fa-chevron-down"></i> <?= SELECT_CAR ?>
				                </button>
				                <button id='empty' type="button" class="btn btn-large">Empty fields</button>
				            </div>							
				        </div>
                        <!-- select car button --> 
                        

                        <div class="col s12">
                            <div class="tab" id="tab_1">
                                <div id="selectCar">
									<div class="col s12 center-align xwhite-text">
										<br>
										 <h4><?= PRICES_STARTING_FROM?>:</h4> 
									</div>
									<div class="col s12 1">
										<?
										$car =   getRoutePrices( s('FromID'), s('ToID') );
										foreach($car as $VehicleCapacity => $price) {
											?>
											<div class="col s12 card 4">
												<i class="fa fa-user"></i> <?= $VehicleCapacity?>
												<i class="fa fa-tags red-text"></i> <?= $price ?> <?= s('Currency') ?>
											</div>
											<?
										} ?>
									</div>
                                </div>
								<div id="final" style='display: none;'>Proba</div>

                            </div>
                            <!-- tab_1 -->
                        </div> 
						
                        <input type="hidden" id="PaxNo2" name="PaxNo2" value="0"> 
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
						<input type="hidden" id="api" name="api" value="">    
						
						<input type="hidden" id="PaxFirstName" name="PaxFirstName" value="<?= $PaxFirstName ?>">                   
						<input type="hidden" id="PaxSurName" name="PaxSurName" value="<?= s('MPaxLastName')?>">      
						<input type="hidden" id="PaxTel" name="PaxTel" value="<?= $PaxTel ?>">  
						
						<input type="hidden" id="FlightNo" name="FlightNo" value="<?=s('FlightNo') ?>">  						
						<input type="hidden" id="FlightCo" name="FlightCo" value="">   
						<input type="hidden" id="FlightTime" name="FlightTime" value="<?= s('FlightTime') ?>">  
						<input type="hidden" id="DFlightNo" name="DFlightNo" value="<?=s('DFlightNo') ?>">  						
						<input type="hidden" id="DFlightCo" name="DFlightCo" value="">   
						<input type="hidden" id="DFlightTime" name="DFlightTime" value="<?= s('DFlightTime') ?>">  						
						
						<input type="hidden" id="RFlightNo" name="RFlightNo" value="<?=s('RFlightNo') ?>">  						
						<input type="hidden" id="RFlightCo" name="RFlightCo" value="">   
						<input type="hidden" id="RFlightTime" name="RFlightTime" value="<?= s('RFlightTime') ?>">  
						<input type="hidden" id="RDFlightNo" name="RDFlightNo" value="<?=s('RDFlightNo') ?>">  						
						<input type="hidden" id="RDFlightCo" name="RDFlightCo" value="">   
						<input type="hidden" id="RDFlightTime" name="RDFlightTime" value="<?= s('RDFlightTime') ?>">  						
						
						<input id='SPAddressHotel' name='SPAddressHotel' type='hidden'/>
						<input id='SDAddressHotel' name='SDAddressHotel' type='hidden'/>
						<input id='RPAddressHotel' name='RPAddressHotel' type='hidden'/>  
						<input id='RDAddressHotel' name='RDAddressHotel' type='hidden'/>				
						<input id='PickupAddress' name='PickupAddress' type='hidden' value="<?= s('PickupAddress') ?>"/>
						<input id='DropAddress' name='DropAddress' type='hidden' value="<?= s('DropAddress') ?>"/>
						<input id='RPickupAddress' name='RPickupAddress' type='hidden' value="<?= s('RPickupAddress') ?>"/> 
						<input id='RDropAddress' name='RDropAddress' type='hidden' value="<?= s('RDropAddress') ?>"/>
						
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
	// display
	$smarty->display("plugins/booking/templates/bookingStep1.tpl");	

