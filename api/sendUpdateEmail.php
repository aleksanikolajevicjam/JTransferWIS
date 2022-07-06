<?
	header('Content-Type: text/javascript; charset=UTF-8');
	session_start();

	$mailTo = $_REQUEST['mailTo'];
	$mailFrom = $_REQUEST['mailFrom'];
	$fromName = $_REQUEST['fromName'];
	$subject = $_REQUEST['subject'];
	$message = $_REQUEST['message'];
	$profile = $_REQUEST['profile'];
	$DetailsID = $_REQUEST['DetailsID'];
	$reason = $_REQUEST['reason'];

	require_once ROOT . '/f/f.php';
	require_once ROOT . '/lng/en.php';
	require_once ROOT . '/cms/lng/en_text.php';
	require_once ROOT . '/db/v4_OrderDetails.class.php';
	require_once ROOT . '/db/v4_OrdersMaster.class.php';
	require_once ROOT . '/db/v4_AuthUsers.class.php';


	// classes
	$od = new v4_OrderDetails();
	$om = new v4_OrdersMaster();
	$au = new v4_AuthUsers();

	$od->getRow($DetailsID);
	$OrderID = $od->getOrderID();
	$oKey = $om->getKeysBy('MOrderID', 'ASC', ' WHERE MOrderID = ' .$OrderID);

	$om->getRow($oKey[0]);
	$AuthUserID = $om->getMUserID();


	// Podaci o useru - Taxi site ili partner, agent 
	//$users = array('2', '4', '5', '6', '12');

	// ticket 662 - kaze da mail vozacu stize sa mail adrese agenta. fix:
	$users = array('12');
	
	$au->getRow($AuthUserID);
	$level = $au->getAuthLevelID();
	
	if(in_array($level, $users)) {
		$fromName = $au->getAuthUserCompany();
		$mailFrom = $au->getAuthUserMail();
	}
	else {
		$fromName = 'JamTransfer.com';
		$mailFrom = 'info@jamtransfer.com';
	}


	// slaganje potvrde za poslati vozacu ili putniku
	ob_start();
	if ($profile == 'driver') {
		$subject = TRANSFER_UPDATE.$om->MOrderKey.'-'.$om->MOrderID.'-'.$od->TNo.'-Change/'.$reason;
		?>
		<div style="font-weight:bold;color:red">
			Hello, there is a change of <u><?= $reason ?></u> in the reservation. Please, check and confirm new details by email reply.
		</div>
		<?
		newPrintReservation($DetailsID, 'driver', $od, $om);
	}
	else if ($profile == 'pax') {
		$subject = TRANSFER_UPDATE.$om->MOrderKey.'-'.$om->MOrderID.'-'.$od->TNo.'-Change/'.$reason;
		?>
		<div style="font-weight:bold;color:red">
			There is a change of <u><?= $reason ?></u> in the reservation.
		</div>		
		<?
		printVoucher($od->getOrderID());
	}
	$message = ob_get_contents();
	ob_end_clean();


	// slanje maila
	if ($message != '' and $mailTo != '') {
		//$mailTo='jam.bgprogrameri@gmail.com';//za probu
		$sent = mail_html($mailTo, $mailFrom, $fromName, $mailFrom, $subject, $message);
	}
	else $sent = false;

	if ($sent) $output = '<span class="badge bg-green"><i class="ic-happy"></i> Message sent. </span>';
	else $output = '<span class="badge bg-red"><i class="ic-sad"></i> Message not sent. </span>';

	echo $_GET['callback'] . '(' . json_encode($output) . ')';


################################################################################
####				FUNKCIJE											    ####
################################################################################,


//Trazena izmjena da prilikom slanja ovog maila se uopce ne vidi pax mail (dosad bio masked) - 13.07.2018 - Dušica Vojteški

function newPrintReservation( $OrderID, $profile, $d, $m) {
    require ROOT .  '/LoadLanguage.php';
	$total = $d->PayNow + $d->PayLater
?>
    <table width="100%" style="table-layout:fixed">
        <col width="200px">
        <col>
        <tr>
            <td colspan="2">
                <h3><?= $RESERVATION_CODE ?>:
                    <strong><?= $m->MOrderKey . '-'. $m->MOrderID .'-'.$d->TNo ?></strong>
                </h3>
                <small><?= $m->MOrderDate . ' ' . $m->MOrderTime ?></small><hr>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <h3 class=""><?= $ROUTE ?></h3>
            </td>
        <tr>
        <tr>
            <td><?= $FROM ?>:</td>
            <td><strong><?= $d->PickupName ?></strong></td>
        </tr>
        <tr>
            <td><?= $PICKUP_ADDRESS ?>:</td>
            <td><?= $d->PickupAddress  ?></td>
        </tr>
        <tr>
            <td><?= $TO ?>:</td>
            <td><strong><?= $d->DropName ?></strong></td>
        </tr>
        <tr>
            <td><?= $DROPOFF_ADDRESS ?>:</td>
            <td><?=  $d->DropAddress  ?></td>
        </tr>
        <tr>
            <td><?= $PICKUP_DATE ?>:</td>
            <td><?= $d->PickupDate  ?> <small>(Y-M-D)</small></td>
        </tr>
        <tr>
            <td><?= $PICKUP_TIME ?>:</td>
            <td><?= $d->PickupTime  ?> <small>(H:M 24h)</small></td>
        </tr>
        <tr>
            <td><?= $FLIGHT_NO ?>:</td>
            <td><?= $d->FlightNo  ?></td>
        </tr>
        <tr>
            <td><?= $FLIGHT_TIME ?>:</td>
            <td><?= $d->FlightTime  ?></td>
        </tr>
        <tr>
            <td>Pax Number:</td>
            <td><?= $d->PaxNo  ?></td>
        </tr>
        <tr>
            <td colspan="2">
                <br>
                <h3 class=""><?= $PASSENGER ?></h3>
            </td>
        </tr>
        <tr>
            <td><?= $NAME ?>:</td>
            <td><?= $d->PaxName  ?></td>
        </tr>
<?/*
        <tr>
            <td><?= $EMAIL ?>:</td>
            <td><?= maskEmail($m->MPaxEmail) ?></td>
        </tr>
*/?>
        <tr>
            <td>Mobile:</td>
            <td><?= $m->MPaxTel ?></td>
        </tr>
        <tr>
            <td colspan="2">
                <br>
                <h3 class=""><?= $VEHICLE ?></h3>
            </td>
        </tr>
        <tr>
            <td>Vehicle Type:</td>
            <td><?= getVehicleTypeName($d->VehicleType)  ?></td>
        </tr>
        <tr>
            <td>Vehicle Capacity:</td>
            <td><?= getMaxPax($d->VehicleType)  ?></td>
        </tr>

        <tr>
            <td><?=  $NOTES ?>:</td>
            <td><?= $d->PickupNotes ?></td>
        </tr>

		<?
		if($d->PaymentMethod === 2 or ($d->PaymentMethod === 3 and ($d->PayNow >= 0.2 * $total))){?>
		    <tr>
		        <td><?= $PRICE ?>:</td>
		        <td><strong><?= number_format($d->DetailPrice ,2)  . ' ' . CURRENCY ?></strong></td>
		    </tr>
		<? }?>
        <tr>
            <td>

            <?
    #                   $ExtraServices  = $d->ExtraServices ;
    #                   $ExtraSubtotals = $d->ExtraSubtotals ;
    #                   $ExtraItems     = $d->ExtraItems ;
    #
    #                   foreach($ExtraServices as $rbr => $value) {
    #                       if($ExtraSubtotals[$rbr] > 0) {
    #                           echo '<div class="col-md-4">' . $ExtraItems[$rbr] . ' ';
    #                           echo $value . '</div> ';
    #
    #                           echo '<div class="col-md-8">' . $ExtraSubtotals[$rbr] . ' ' . s('Currency')  . '</div>';
    #                       }
    #
    #                   }

    #                   echo '---';

            require_once ROOT . '/db/v4_OrderExtras.class.php';
            $ox = new v4_OrderExtras();

            $where = ' WHERE OrderDetailsID = ' . $d->getDetailsID() . $firstTransferWhere;
            $oXkey = $ox->getKeysBy('ID', 'ASC', $where);
            if( count($oXkey) > 0 ){

                echo '<tr>
                        <td colspan="2">
                            <br>
                            <h3 class="">'. $EXTRAS .'</h3>
                        </td>
                    </tr>';

                foreach($oXkey as $i => $id) {
                    $ox->getRow($id);
                    echo '<tr><td>' .
                            $ox->getServiceName() . ' x ' .
                            $ox->getQty();
                    echo '</td>';

                    echo '<td>' .
                            Eur2( $ox->getSum(),$m->getMOrderCurrency() ) .
                            ' ' . $m->getMOrderCurrency() .
                    '</td></tr>';
                }
            }
            ?>

            </td>
        </tr>
		<?
		if($d->PaymentMethod === 2 or ($d->PaymentMethod === 3 and ($d->PayNow >= 0.2 * $total))){?>
        <tr>
            <td colspan="2">
                <br>
                <h3><?= $TOTAL ?></h3>
            </td>
        </tr>
            <td><strong><?= $ONLINE ?>:</strong></td>
            <td><strong><?= number_format($d->PayNow ,2)  . ' ' . CURRENCY ?></strong></td>
        </tr>
        <tr>
            <td><strong><?= $CASH ?>:</strong></td>
            <td><strong><?= number_format($d->PayLater ,2)  . ' ' . CURRENCY ?></strong></td>
        </tr>
		<? }?>
        <tr>
            <td colspan="2">
                <br><br>
                <p style="font-size:.7em;text-transform:uppercase;text-align:left;">
                    <?= $SERVICES_DESC1 ?> |
                    <?= $SERVICES_DESC2 ?> |
                    <?= $SERVICES_DESC3 ?> |
                    <?= $SERVICES_DESC4 ?> |
                    <?= $SERVICES_DESC5 ?> |
                    <?= $SERVICES_DESC6 ?> |
                    <?= $SERVICES_DESC7 ?> |
                    <?= $SERVICES_DESC8 ?> |
                    <?= $SERVICES_DESC9 ?>
                    <br>
                </p>
            </td>
        </tr>
    </table>
<?
}

/**
 * Create a web friendly URL slug from a string.
 *
 */
################################################################################

