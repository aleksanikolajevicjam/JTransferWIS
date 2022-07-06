<?
	session_start();
	// HTML HEADER - sve
	require_once './headerScripts.php';
	require_once './f/f.php';
	
?>
<body>

	<div class="container white">
	<br>
 

<?		

	$_REQUEST['userid']=$_REQUEST['id'];
	/*unset ($_SESSION['UserAuthorized']);
	require_once 'login.php';*/
	
	if($_SESSION['CLOSE'.$_REQUEST['code']] == true) die('<h1>Confirmation completed.</h1>You can close this window now.');
	
	//echo '<pre>'; print_r($_REQUEST); echo '</pre>';
		
	// classes
	require_once '../db/db.class.php';
	require_once '../db/v4_OrderDetails.class.php';
	require_once '../db/v4_OrdersMaster.class.php';
	
	// Drivers
	require_once '../db/v4_AuthUsers.class.php';
	
	// Log
	require_once '../db/v4_OrderLog.class.php';
	
	$db = new DataBaseMysql();	
	$d = new v4_OrderDetails();
	$m = new v4_OrdersMaster();
	$u = new v4_AuthUsers();
	$ol= new v4_OrderLog();
	
	$showConfirmDecline = false;

	// uzmi podatke u svakom slucaju
	$DetailsID 	= $_REQUEST['code'];
	$OrderKey 	= $_REQUEST['control'];
	$DriverID	= $_REQUEST['id'];

	// get out - something wrong
	if(!is_numeric($DetailsID)) die ('<h1>Error - Parameter not valid.</h1>');
	if(!is_numeric($DriverID)) die ('<h1>Error - Parameter not valid.</h1>');

	$d->getRow($DetailsID);
	$m->getRow($d->OrderID);

    //if($m->MOrderStatus == '3') die('<h1>Transfer has been Cancelled.</h1>');
    if($d->TransferStatus == '3') die('<h1>Transfer has been Cancelled.</h1>');
	
	 if($d->TransferStatus == '4') die('<h1>Transfer wait for customer confirmation.</h1>'); 

	if($m->MOrderKey != $OrderKey) die('<h1>Error - Parameter not valid.</h1>');

	$u->getRow($DriverID);
	if($u->getAuthUserID() != $DriverID) die ('<h1>Error - Parameter not valid.</h1>');	
	
	if($u->getAuthUserID() != $d->getDriverID() and $d->getDriverID() != '0') 
	die('<h2>Error - transfer cannot be confirmed.</h2>');		

	if($u->getAuthUserID() == $d->getDriverID() and $d->getDriverConfStatus() == '2') 
	die('<h2>You have already confirmed this transfer.</h2>');	

	if($u->getAuthUserID() == $d->getDriverID() and $d->getDriverConfStatus() == '4') 
	die('<h2>You have already declined this transfer.</h2>');	
	
	// button pressed 
	
	if( isset($_REQUEST['Confirm']) ) { 
		
		if($_REQUEST['Confirm'] == 'Confirmed') {
			
			//izracunavanje i punjenje driver extras charge
			$idd=$d->getDetailsID();
			$query="SELECT `ServiceID`,`Qty` FROM `v4_OrderExtras` WHERE `OrderDetailsID`=".$idd;
			$result = $db->RunQuery($query);
			$suma=0;
			while($row = $result->fetch_array(MYSQLI_ASSOC)){  
				$id=$row['ServiceID'];
				$kol=$row['Qty'];
				$query1="SELECT `ID`,`DriverPrice`,`Provision`  FROM `v4_Extras` WHERE `ID`=".$id	;
				$result1 = $db->RunQuery($query1);
				while($row1 = $result1->fetch_array(MYSQLI_ASSOC)){  
					$suma+=$row1['DriverPrice']*$kol;	
					$query4="UPDATE `v4_OrderExtras` SET 
						`DriverPrice`=".$row1['DriverPrice'].",
						`Provision`=".$row1['Provision'].",
						`DriverPriceSum`=".$row1['DriverPrice']."*`Qty`				
						where `ServiceID`=".$row1['ID'];		
					$result4 = $db->RunQuery($query4);			
				}
			}				
			$d->setDriverExtraCharge($suma);
			// kraj driver extras charge
			$d->setDriverConfStatus('2');
			if($d->TransferStatus == '6') $d->setTransferStatus('1');
			if($d->TransferStatus == '0') $d->setTransferStatus('1');						
			$d->setDriverID($_REQUEST['DriverID']);
			$d->setDriverName($_REQUEST['DriverName']);
			$d->setDriverEmail($_REQUEST['DriverEmail']);
			$d->setDriverTel($_REQUEST['DriverTel']);
			//$d->setDriverConfStatus($_REQUEST['DriverConfStatus']);
			$d->setDriverConfDate($_REQUEST['DriverConfDate']);
			$d->setDriverConfTime($_REQUEST['DriverConfTime']);
			$d->setPickupPlace($_REQUEST['PickupPoint']);				
			
			$d->saveRow();
			$message = "CONFIRMED";
			
			if ($u->getContractFile()=='inter') $phonemessage=' (do NOT send SMS, only for calls)';
			else $phonemessage='/GSM';
			
			// Ovdje obavijestiti kupca da je vozac promijenjen, odnosno da je prihvatio transfer
			$mailMessage = '<span style="font-weight:bold">PLEASE DO NOT REPLY TO THIS MESSAGE</span><br>
			Hello ' . ucwords($d->PaxName) . '!<br>
			We have assigned one of our best drivers to look after You.<br>
			<br>
			Reservation Code: ' . $m->MOrderKey . '-' . $m->MOrderID . '<br>
			TransferID: ' . $d->OrderID . '-' . $d->TNo . '<br>
			Direction: ' . $d->PickupName . ' to ' . $d->DropName . '<br>
			Pickup Point: ' . htmlspecialchars($_REQUEST['PickupPoint']) . '<br>
			<br><br>
			<span style="font-weight:bold">';
			//$mailMessage .='Your Driver\'s Name: ' . htmlspecialchars($_REQUEST['SubDriverName']) . '<br>'; ne prikazivati
			$mailMessage .='Driver\'s Telephone';
			$mailMessage .=$phonemessage;
			$mailMessage .=': ' . htmlspecialchars($_REQUEST['SubDriverTel']) . '</span>
			<br>
			<br>
			You can contact Your driver directly in case You are delayed etc.<br>
			or you can call our Customer Service 24/7 as well.<br>
			<br>
			If you can not reach driver\'s phone number, please contact our Call Centre +381646597200<br>
			If you need to contact us, please send an email to info@jamtransfer.com<br>
			<br>
			Have a nice trip and please recommend us if You like our service!<br>
			<br>
			Kindest regards, <br>
			<br>
			JamTransfer.com Team';

			
			$mailto = $m->MPaxEmail;
			$subject = 'Important Update for Transfer: '. ' ' . $m->MOrderKey.'-'.$m->MOrderID . '-' . $d->TNo;
			
			mail_html($mailto, 'driver-info@jamtransfer.com', 'JamTransfer.com', 'info@jamtransfer.com',
		  	$subject , $mailMessage);
			
			/*mail_html('jamtransfercomtransfers@jamtransfer.freshdesk.com', 'driver-info@jamtransfer.com', 'JamTransfer', 'driver-info@jamtransfer.com',
						  $subject.'-'.$agentmail, $mailMessage);				*/
			// blok za premostavanje blokade primanja mail-ova preko ticketing-a
			/*$agentmail=$mailto;
			$agentmail_arr=explode('@',$agentmail);
			$agentmail_pr=$agentmail_arr[1];
			
			if ($agentmail_pr<>'gmail.com' && $agentmail_pr<>'yahoo.com') {
				mail_html('jamtransfercomtransfers@jamtransfer.freshdesk.com', 'driver-info@jamtransfer.com', 'JamTransfer', 'driver-info@jamtransfer.com',
						  $subject.'-'.$agentmail, $mailMessage);	  					
			}*/
			// kraj bloka			

			mail_html('cms@jamtransfer.com', 'driver-info@jamtransfer.com', 'JamTransfer.com', 'driver-info@jamtransfer.com',
		  	$subject , $mailMessage);			
			
			// Log
			$ol->setOrderID($m->getMOrderID);
			$ol->setDetailsID($DetailsID);
			$ol->setAction('Driver');
			$ol->setTitle('Driver Confirmed');
			//$ol->setDescription('Driver ' . $u->getAuthUserCompany() . ' confirmed this transfer.');
			$ol->setDescription('Driver ' . $u->getAuthUserRealName() . ' confirmed this transfer. Subdriver phone:'.$_REQUEST['SubDriverTel']);
			$ol->setDateAdded(date("Y-m-d"));
			$ol->setTimeAdded(date("H:i:s"));
			$ol->setUserID($u->getAuthUserID());
			$ol->setIcon('fa fa-check bg-blue');
			$ol->setShowToCustomer('0');

			$ol->saveAsNew();			
		
		}
		
		if($_REQUEST['Confirm'] == 'Declined') {
			$d->setDriverConfStatus('4');
			$d->setDriverID('');
			$d->saveRow();
			$message = "DECLINED";
			
			// Log
			$ol->setOrderID($m->getMOrderID);
			$ol->setDetailsID($DetailsID);
			$ol->setAction('Driver');
			$ol->setTitle('Driver declined');
			//$ol->setDescription('Driver ' . $u->getAuthUserCompany() . ' DECLINED this transfer.');
			$ol->setDescription('Driver ' . $u->getAuthUserCompany() . ' DECLINED this transfer for reason: '.$_REQUEST['DeclineReason'].' / '. $_REQUEST['DeclineMessage']);						
			$ol->setDateAdded(date("Y-m-d"));
			$ol->setTimeAdded(date("H:i:s"));
			$ol->setUserID($u->getAuthUserID());
			$ol->setIcon('fa fa-remove bg-red');
			$ol->setShowToCustomer('0');

			$ol->saveAsNew();	
			$subject = 'Important Update for Transfer: '. ' ' . $m->MOrderKey.'-'.$m->MOrderID . '-' . $d->TNo;			

			echo $mailMessage = 'Driver ' . $u->getAuthUserCompany() .'<br>
							has DECLINED the transfer:<br><br>' .
							$d->OrderID .'-'.$d->TNo.'<br>for reason: '.$_REQUEST['DeclineReason'].' / '. $_REQUEST['DeclineMessage']. '
							Passenger: '.$d->PaxName.'<br>
							Pickup Date: '.$d->PickupDate.'.<br><br>
							Please select and inform another driver.';
							
							
			mail_html('cms@jamtransfer.com', 'transfer-update@jamtransfer.com', 'JamTransfer.com', 'info@jamtransfer.com',
		  	$subject , $mailMessage);				
		}
		
		$_SESSION['CLOSE'.$_REQUEST['code']] = true;
		
	} else {
	
		$showConfirmDecline = true;
	} // end if/else confirm/decline

	
	// LANGUAGES
	if ( isset($_REQUEST['CMSLang']) and $_REQUEST['CMSLang'] != '') {
		$_SESSION['CMSLang'] = $_REQUEST['CMSLang'];
	}
	else $_SESSION['CMSLang'] = 'en';
	
	if ( isset($_SESSION['CMSLang']) and $_SESSION['CMSLang'] != '') {

		$languageFile = './lng/' . $_SESSION['CMSLang'] . '_text.php';

		if ( file_exists( $languageFile) ) require_once $languageFile;
		else {
			$_SESSION['CMSLang'] = 'en';
			require_once './lng/en_text.php';
		}
	}
	else {
		$_SESSION['CMSLang'] = 'en';
		require_once './lng/en_text.php';
	}
	// END OF LANGUAGES	
	
?>
		<? if($showConfirmDecline) { ?>
			<h2><?= CONFIRM_TRANSFER ?></h2> 
			<form  method="post" action='' >
				<input type="hidden" name="DetailsID" value="<?= $DetailsID ?>">
				<input type="hidden" name="DriverID" value="<?= $DriverID ?>">
				
				<input type="hidden" name="DriverName" value="<?= $u->getAuthUserCompany() ?>">
				<input type="hidden" name="DriverEmail" value="<?= $u->getAuthUserMail() ?>">
				
				<input type="hidden" name="DriverConfStatus" value="2">
				<input type="hidden" name="DriverConfDate" value="<?= date('Y-m-d') ?>">
				<input type="hidden" name="DriverConfTime" value="<?= date('H:i:s') ?>">
				<br>
				<?= THIS_INFO_WILL_BE_SENT_TO_CUSTOMER ?>
				<br><br>


				<div class="row">
					<div class="col-md-2"><?= DRIVER_NAME ?> :</div>
					<div class="col-md-8">
						<input class="form-control" type="text" 
						name="SubDriverName" 
						id="SubDriverName" placeholder="Please put DRIVERS NAME or OPERATOR (do not put YOUR COMPANY name)" value="" onfocus="if (this.value=='Please put DRIVERS NAME or OPERATOR (do not put YOUR COMPANY name)') this.value='';">
					</div>
				</div>
				<div class="row">
					<div class="col-md-2"><?= DRIVER_TEL ?> :</div>
					<div class="col-md-8">
						<input class="form-control" type="text" 
						name="SubDriverTel" 
						id="SubDriverTel" placeholder='International format (e.g +33...)' value="" onfocus="if (this.value=='Please put phone number in international format (e.g +33...)') this.value='';">
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-2"><?= PICKUP_POINT ?> :</div>
					<div class="col-md-8">
						<textarea class="form-control" cols="40" 
						rows="5" name="PickupPoint"
						id="PickupPoint"></textarea>
					</div>
				</div>											
				<div id="drr" class="row" style="display:none">
					<div class="col-md-2">Decline reason:</div>
					<div class="col-md-8">
						<select name="DeclineReason" id="DeclineReason">
							<option value="cr">Choose reason</option>													
							<option value="Price">Price incorect</option>	
							<option value="Availability">No availability</option>														
							<option value="Wrong">Wrong reservation details</option>													
							<option value="Other">Other</option>
						</select>			
					</div>
				</div>											
				<div id="dm"class="row" style="display:none">
					<div class="col-md-2">Decline message:</div>
					<div class="col-md-8">
						<textarea id= 'dmta' class="form-control" cols="40" 
						rows="5" name="DeclineMessage"
						id="DeclineMessage" name="DeclineMessage"></textarea>
					</div>
				</div>												
				<div class="row">
					<div class="col-md-12">
					<span class='red'>&nbsp Please, CHECK this transfer details before confirming transfer request!</span> 
					<br>			
					<br>
					
					<button id='confirm' class="btn btn-success" type="button" 
					onclick="confirmTransfer()"
					name="Confirm" value="Confirmed" >
						<i class="fa fa-check l"></i> <?= CONFIRM ?> 
					</button>
					<!-- novi blok !-->
					<button id='decline1' type="button" class="btn btn-danger"
					onclick="declineTransfer1()">
						<i class="fa fa-remove l"></i> <?= DECLINE ?>
					</button>
					
					<button id='decline2' class="btn btn-danger" type="button"
					style="display:none; "
					onclick="declineTransfer2()" name="Confirm" value="Declined">
						<i class="fa fa-remove l"></i> <?= DECLINE ?>
					</button>
					<!-- kraj bloka !-->
					</div>		
				</div>			

			</form>
		<? } else echo '<h2>' . $message . '</h2>'; ?>

		<br><br>

		<div class="alert alert-info" style="color:black;background:#eee">		
			<? 
				printReservation($DetailsID, 'driver', $d, $m);
			?>
		</div>
	</div>
<script>



		function confirmTransfer() {
			
			// mesto + u telefonu
			var tel = $("#SubDriverTel").val() ;
			var n = tel.indexOf('+');
			
			if($("#SubDriverName").val() == '' || $("#SubDriverTel").val() == '') {
				alert('Enter Driver name and Telephone number!');
				return false;
			}
			
			// da li je ispravan format?
			if (n != 0) {
				alert ('Enter Phone number in right format starting with country code (+___)');
				return false;
			}	
			

			if($("#PickupPoint").val() == '') {
				alert('Enter Pickup point!');
				return false;
			}
			
			$('#confirm').attr('type','submit');			
			//$('form').submit();				
			 
		}
		
		// prosirivanje forme sa decline poljima
		function declineTransfer1() {
			
			$("#decline1").hide();
			$("#decline2").show();
			$("#drr").show(500);	
			//$("#dm").show(500);			// privremeno, posle izbrisati
			
		}	
		
		$('#DeclineReason').change(function(){
			var rn = $('#DeclineReason').val();		
			if (rn=='Availability') $('#dmta').attr("placeholder","Your time is:");
			if (rn=='Price') $('#dmta').attr("placeholder","Your price is:");
			if (rn=='Wrong') $('#dmta').attr("placeholder","Wrong details is:");			
			if (rn=='Other') $('#dmta').attr("placeholder","Your reason is:");			
			$("#dm").show(500);				
		}); 
		
		// decline
		function declineTransfer2() {
			var dmta = $("#dmta").val();
			dmta = dmta.trim();
			if(dmta == '') {

				alert('Enter Decline reason and message!');
				return false;
			}
			else { 
				$('#decline2').attr('type','submit');			
				$('form').submit();
			}		
		}	

		/*$("#Confirm").click(function(){

			var name = $("#SubDriverName").val();
			var tel  = $("#SubDriverTel").val();
			//var tel  = $("#SubDriverTelCountryCode").val();
	   
			if(name!='' && tel!='') { return true; }
			alert('Fill-in all data!');
			return false;
		});*/
	
</script>
</body>
</html>

