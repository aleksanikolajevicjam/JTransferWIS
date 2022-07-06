<?
//
//$smarty->assign('page', $md->getName());
//@session_start();
//if (!$_SESSION['UserAuthorized']) die('Bye, bye');
// koristi funkciju PrintTransferMaterial za ispis na ekran i
// printAgentVoucher za slanje u mailu
// ODE IDE AGENTSKI MAIL ZA REZERVACIJE - FREE FORM?

//$smarty->assign('page', $md->getName());
@session_start();
foreach	($_REQUEST as $key => $value) {
    $_SESSION[$key] = $value;
}

//require_once $_SERVER['DOCUMENT_ROOT'] .'/f/f.php';
//require_once "plugins/Buking/scripts.php";

?>
<style>
    h1,h2,h3,h4,h5 {font-size: 1.5rem !important;padding:0px !important;margin:0px !important}
    table {font-size:1.4em !important; line-height: 1.2rem !important}
    tr, td {padding:4px !important}
    hr {margin: 0 !important; padding: 0 !important;}
</style>

<div class="blue-grey">
    <br>
    <div class="white fillHeight container pad1em">

        <?

        // povratak sa webteh-a
        if($_SESSION['PaymentOption'] != '2' and $_SESSION['PaymentOption'] != '4' and $_SESSION['PaymentOption'] != '6') { // 2= cash only
            # DATA FROM WEBTEH

            $approval_code = $_REQUEST['approval_code'];
            $authentication= $_REQUEST['authentication'];
            $cc_type = $_REQUEST['cc_type'];
            $currency = $_REQUEST['currency'];
            $digest = $_REQUEST['digest'];
            $enrollment = $_REQUEST['enrollment'];
            $language = $_SESSION['language'];
            $order_number = $_REQUEST['order_number'];
            $response_code = $_REQUEST['response_code'];

        }
        else if ($_SESSION['PaymentOption'] == '2' or $_SESSION['PaymentOption'] == '4' or $_SESSION['PaymentOption'] == '6') {
            $response_code = '0000';

        }

        // Prevent refresh!
        if(!$_SESSION['REFRESHED']) {

            // spremi sve u session
            foreach	($_REQUEST as $key => $value) {
                $_SESSION[$key] = $value;

            }
            // i u request
            foreach	($_SESSION as $key => $value) {
                if(gettype($value) != 'array') {
                    echo '<input type="hidden" name="'.$key.'" value="'.$value.'">';

                }
            }
            //echo "hello";

            if (isset($_SESSION['fromPlaces'])) unset($_SESSION['fromPlaces']);
            if (isset($_SESSION['toPlaces'])) unset($_SESSION['toPlaces']);
            if (isset($_SESSION['allPlaces'])) unset($_SESSION['allPlaces']);
            if (isset($_SESSION['countries'])) unset($_SESSION['countries']);
            //echo "hello";


$response_code == '0000';
            // Ako je naplata uredno obavljena ili je cash placanje
            if($response_code == '0000') {

                // Upis u bazu
                $OrderKey = '';
                define("ROOTA", "c:\\xampp\\htdocs\\jamtransfer");

                require_once ROOTA . '/plugins/Buking/dbAddOrder.php';
                echo "hello";
                $OrderID = insertOrder('final');

                $_SESSION['REFRESHED'] = true;
                $printAndSend = true;
//                echo "hello";


            } else { // naplata
                // nije obavljena - response_code != '0000'
             // Upis u bazu

                $OrderKey = '';

                define("ROOTA", "c:\\xampp\\htdocs\\jamtransfer");

                require_once ROOTA . '/plugins/Buking/dbAddOrder.php';
                echo "hello";

                $OrderID = insertOrder('final');

             $_SESSION['REFRESHED'] = true;
             $printAndSend = true; 
         echo "hello";
         echo "<div style='height:100px; background:red'></div>";

 ?>
               
                <?

                $printAndSend = false; // ne salji voucher
                $_SESSION['REFRESHED'] = true; // zabrani refresh

            } // REFRESHED


        } else { // REFRESHED = true ?>
            <div class="row">
                <div class="col s12 pad1em">
                    <i class="fa fa-info-circle red-text"></i> <?= THANK_YOU ?>
                    <?= NO_REFRESH ?>
                    <br>
                    <br>
                </div>
            </div>
            <?
            // ne salji voucher
            $printAndSend = false;

        } // REFRESHED

        // treba li printati voucher i poslati ga
        if($printAndSend) { ?>

            <div class="row blue z-depth-2">
                <div class="col s12 pad1em white-text">
                    <h4><i class="fa fa-smile-o"></i> <?= THANK_YOU ?></h4>
                    <?= BOOKING_SUCCESS ?>
                </div>
            </div>

            <?


            ob_start();

            // printa tabelu sa voucherom za pdf i mail_html
            // ista tabela se prikazuje na ekranu
            $rivijera=array(2833,2835,2836,2837,2838,2839,2841);
            if (in_array($_SESSION['AuthUserID'], $rivijera)) $showPrices=true;
            else $showPrices=false;
            printAgentVoucher($OrderID, $showPrices);

            $html = ob_get_contents();

            ob_end_clean();

            // prikaz vouchera
            ?>
            <div class="row"  style="font-size:12px !important">
                <div class="col s12 pad1em xhidden"  id="voucher">
                    <?= $html ?>
                    <input type="button" class="btn blue" onclick="printDiv('voucher')" value="<?= PRINT_VOUCHER; ?>" />
                </div>
                <div class="col s12 pad1em hidden" id="confirmation">
                    <?//= PrintTransferMaterial($OrderID); ?>
                    <input type="button" class="btn blue" onclick="printDiv('voucher')" value="<?= PRINT_VOUCHER; ?>" />
                </div>

            </div>

            <?

            //****************
            // PDF GENERATION
            //****************
          
            // LOAD a stylesheet
            //$stylesheet = file_get_contents('parallax/css/materialize.css');
            




            // ALL DONE, SEND EMAILS - U MPaxEmail je agentov email !!!


            // blok za premostavanje blokade primanja mail-ova preko ticketing-a
            /*$agentmail=$_SESSION['MPaxEmail'];
            $agentmail_arr=explode('@',$agentmail);
            $agentmail_pr=$agentmail_arr[1];

            if ($agentmail_pr<>'gmail.com' && $agentmail_pr<>'yahoo.com') {
                mail_html('jamtransfercomtransfers@jamtransfer.freshdesk.com', 'confirmation@jamtransfer.com', 'JamTransfer', 'info@jamtransfer.com',
                          'Agent: ' . $_SESSION['UserCompany'] . ' Order - '.$OrderKey, '<br>'.$html.'<br><b>'.$agentmail.'</b>', $pdfFile);
            }*/
            // kraj bloka




            sendDriverNotification($OrderID, $OrderKey);


        } // printAndSend ?>


    </div>
    <br><br>
</div>

<?
// FUNCTIONS
function printAgentVoucher($OrderID, $showPrices = true) {
    //echo '<pre>'; print_r($_REQUEST); echo '</pre>';


    if(!empty($OrderID) and is_numeric($OrderID)) {
        //$OrderID = $_REQUEST['OrderID'];
    }
    else die('Transfer ID corrupt or missing.');

    define("NL", '<br>');
    require_once ROOT . '/db/v4_OrdersMaster.class.php';
    require_once ROOT . '/db/v4_OrderDetails.class.php';
    require_once ROOT . '/db/v4_OrderExtras.class.php';
    require_once ROOT . '/db/v4_AuthUsers.class.php';

    // classes
    $om = new v4_OrdersMaster();
    $od = new v4_OrderDetails();
    $ox = new v4_OrderExtras();
    $au = new v4_AuthUsers();


    $oKey = $om->getKeysBy('MOrderID', 'ASC', ' WHERE MOrderID = ' .$OrderID);
    if(count($oKey) == 1) {
        $om->getRow($oKey[0]);
        $AuthUserID = $om->getMUserID();

        $dKey = $od->getKeysBy('DetailsID', 'ASC', ' WHERE OrderID = ' .$OrderID);
        if(count($dKey) > 0) {
            $transferCount = count($dKey);
        }
        else die('Transfer not found');

    }

    // Podaci o useru - Taxi site ili partner, agent
    $users = array('2', '4', '5', '6', '12');

    $au->getRow($AuthUserID);
    $level = $au->getAuthLevelID();

    if(in_array($level, $users)) {
        $userCo = $au->getAuthUserCompany();
        $userAddress = $au->getAuthCoAddress();
        $userCity = $au->getCity();
        $userZip = $au->getZip();
        $userCountryName = $au->getCountryName();
        $userMail = $au->getAuthUserMail();
        $userTel = $au->getAuthUserTel();
    }
    else {
        $userCo = s('co_name');
        $userAddress = s('co_address');
        $userMail = s('co_email');
        $userTel = s('co_tel');
    }

    // za svaki slucaj :)
    $_SESSION['MPaxEmail'] = $userMail;

    $od->getRow($dKey[0]);
    $firstTransferWhere = ' OR OrderDetailsID = ' . $od->getDetailsID();
    $pickupNotes = '<small>['.$OrderID.'-1]<br></small>'.$od->getPickupNotes();
    ?>

    <table cellpadding="0" cellspacing="0" style="font-family:Arial, sans-serif;">
        <tr>
            <td colspan="2">
                <p>
                <h1>Agent: <?= $userCo?></h1>
                <small>
                    <?= $userAddress ?><br>
                    <?= $userZip ?> <?= $userCity ?><br>
                    <?= $userCountryName ?><br>
                    <?= $userMail ?> <?= $userTel ?><br>
                </small>
                </p>
                <br>
                <h2><?= RESERVATION_CODE ?>: <strong><?= $om->getMOrderKey().'-'.$om->getMOrderID() ?></strong></h2>
                <small><?= $om->getMOrderDate().' '. $om->getMOrderTime() ?></small>
                <br>
                <br>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <hr>
                <h3 style="font-weight:100"><?= YOUR_CONTACT_INFO ?></h3>
                <hr>
            </td>
        </tr>
        <tr>
            <td>
                <?=  NAME ?>:
            </td>
            <td>
                <?= $om->getMPaxFirstName(). ' ' . $om->getMPaxLastName() ?>
            </td>
        </tr>
        <tr>
            <td>
                <?=  EMAIL ?>:
            </td>
            <td>
                <?= $om->getMPaxEmail() ?>
            </td>
        </tr>
        <tr>
            <td>
                <?=  MOBILE_NUMBER ?>:
            </td>
            <td>
                <?= $om->getMPaxTel() ?>
            </td>
        </tr>
        <tr>
            <td>
                <?= PASSENGERS_NO?>:
            </td>
            <td>
                <?= $od->getPaxNo() ?>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <hr>
                <h3 style="font-weight:100"><?= ABOUT_YOUR_TRANSFER?></h3>
                <hr>
            </td>
        </tr>

        <tr>
            <td><?= FROM ?>:</td>
            <td>
                <strong><?= $od->getPickupName() ?></strong>
            </td>
        </tr>
        <tr>
            <td>
                <?= PICKUP_ADDRESS ?>:
            </td>
            <td>
                <?= $od->getPickupAddress() ?>
            </td>
        </tr>
        <tr>
            <td>
                <?= TO ?>:
            </td>
            <td>
                <strong><?= /*getPlaceName( $od->getDropID() )*/ $od->getDropName() ?></strong>
            </td>
        </tr>
        <tr>
            <td>
                <?= DROPOFF_ADDRESS ?>:
            </td>
            <td>
                <?=  $od->getDropAddress() ?>
            </td>
        </tr>
        <tr>
            <td>
                <?= PICKUP_DATE ?>:
            </td>
            <td>
                <?= $od->getPickupDate() ?> <small>(Y-M-D)</small>
                <strong><em> Transfer ID: <?= $od->getOrderID().'-'.$od->getTNo() ?></em></strong>
            </td>
        </tr>
        <tr>
            <td>
                <?= PICKUP_TIME ?>:
            </td>
            <td>
                <?= $od->getPickupTime() ?> <small>(H:M 24h)</small>
            </td>
        </tr>
        <? if( $od->getFlightNo() != '') { ?>
            <tr>
                <td>
                    <?= FLIGHT_NO ?>:
                </td>
                <td>
                    <?= $od->getFlightNo() ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= FLIGHT_TIME ?>:
                </td>
                <td>
                    <?= $od->getFlightTime() ?>
                </td>
            </tr>
        <? } ?>

        <? if ($transferCount == 2)  {

            // podaci za drugi transfer
            $od->getRow($dKey[1]);
            $pickupNotes .= '<br><small>['.$OrderID.'-2]<br></small>'.$od->getPickupNotes();

            ?>
            <tr>
                <td colspan="2">
                    <hr>
                    <h3 style="font-weight:100"><?= RETURN_TRANSFER ?></h3>
                    <hr>
                </td>
            </tr>
            <tr>
                <td>
                    <?= FROM ?>:
                </td>
                <td>
                    <strong><?= $od->getPickupName() ?></strong>
                </td>
            </tr>
            <tr>
                <td>
                    <?= PICKUP_ADDRESS ?>:
                </td>
                <td>
                    <?= $od->getPickupAddress() ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= TO ?>:
                </td>
                <td>
                    <strong><?= $od->getDropName() ?></strong>
                </td>
            </tr>
            <tr>
                <td>
                    <?= DROPOFF_ADDRESS ?>:
                </td>
                <td>
                    <?=  $od->getDropAddress() ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= RETURN_DATE ?>:
                </td>
                <td>
                    <?= $od->getPickupDate() ?> <small>(Y-M-D)</small>
                    <strong><em> Transfer ID: <?= $od->getOrderID().'-'.$od->getTNo() ?></em></strong>
                </td>
            </tr>
            <tr>
                <td>
                    <?= RETURN_TIME ?>:
                </td>
                <td>
                    <?= $od->getPickupTime() ?> <small>(H:M 24h)</small>
                </td>
            </tr>

            <? if( $od->getFlightNo() != '') { ?>
                <tr>
                    <td>
                        <?= FLIGHT_NO ?>:
                    </td>
                    <td>
                        <?= $od->getFlightNo() ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?= FLIGHT_TIME ?>:
                    </td>
                    <td>
                        <?= $od->getFlightTime() ?>
                    </td>
                </tr>
            <? } ?>
        <? } ?>


        <tr>
            <td colspan="2">
                <hr>
                <h3 style="font-weight:100"><?= SELECTED_VEHICLE?></h3>
                <hr>
            </td>
        </tr>
        <tr>
            <td>
                <?=  VEHICLE_CAPACITY ?>:
            </td>
            <td>
                <?=  getMaxPax( $od->getVehicleType() )  ?> x <?= $od->getVehiclesNo(); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?=  VEHICLE_TYPE ?>:
            </td>
            <td>

                <?= getVehicleTypeName( $od->getVehicleType() ) ?> x <?= $od->getVehiclesNo(); ?>
            </td>
        </tr>
        <?/*
		<tr>
			<td>
				<?=  DRIVER_NAME ?>:
			</td>
			<td>
				<?= $od->getDriverName() ?>
			</td>
		</tr>
*/?>

        <? if($showPrices == true) { ?>
            <tr>
                <td>
                    <?= PRICE ?>:
                </td>
                <td>
                    <strong><?= Eur2($om->getMTransferPrice(),$om->getMOrderCurrency()) . ' ' .
                        $om->getMOrderCurrency() ?></strong>
                </td>
            </tr>
        <? } ?>
        <tr>
            <td>
                <?= NOTES ?>:
            </td>
            <td><?= $pickupNotes ?>

            </td>
        </tr>
        <?
        $where = ' WHERE OrderDetailsID = ' . $od->getDetailsID() . $firstTransferWhere;
        $oXkey = $ox->getKeysBy('ID', 'ASC', $where);
        if( count($oXkey) > 0 ){

            echo '	<tr>
							<td colspan="2">
								<hr>
								<h3 style="font-weight:100">'. EXTRAS .'</h3>
								<hr>
							</td>
						<tr>';

            foreach($oXkey as $i => $id) {
                $ox->getRow($id);
                echo '<tr><td>' .
                    $ox->getServiceName() . ' x ' . $ox->getQty();
                echo '</td> ';

                echo '<td>' .
                    //Eur2( $ox->getSum(),$om->getMOrderCurrency() ) . ' ' . $om->getMOrderCurrency() .
                    '</td></tr>';

            }
        }
        ?>


        <? if($showPrices == true) { ?>
            <tr>
                <td>
                    <hr>
                    <h3><?=  TOTAL ?>:</h3>
                    <hr>
                </td>
                <td>
                    <hr>
                    <h3><?= nf($om->getMOrderCurrencyPrice()) . ' ' . $om->getMOrderCurrency() ?></h3>
                    <hr>
                </td>
            </tr>

            <? if($om->getMPayNow() > 0) {?>

                <tr>
                    <td>
                        <h3><?=  PAY_NOW ?>:</h3>
                        <hr>
                    </td>
                    <td>
                        <h3><?= Eur2( $om->getMPayNow(),$om->getMOrderCurrency() )  . ' ' .
                            $om->getMOrderCurrency() ?></h3>
                        <hr>
                    </td>
                </tr>
            <?}?>

            <tr>
                <td>
                    <h3><?=  PAY_LATER ?>:</h3>
                    <hr>

                </td>
                <td>
                    <h3><?= Eur2($om->getMPayLater(),$om->getMOrderCurrency() ) . ' ' .
                        $om->getMOrderCurrency() ?></h3>
                    <hr>

                </td>
            </tr>
        <? } ?>
        <tr>
            <td colspan="2">
                <p style="font-family:Arial, sans-serif;color:#444">
                    <?= SERVICES_DESC1 ?> |
                    <?= SERVICES_DESC2 ?> |
                    <?= SERVICES_DESC3 ?> |
                    <?= SERVICES_DESC4 ?> |
                    <?= SERVICES_DESC5 ?> |
                    <?= SERVICES_DESC6 ?> |
                    <?= SERVICES_DESC7 ?> |
                    <?= SERVICES_DESC8 ?> |
                    <?= SERVICES_DESC9 ?><br>
                    <?= ACCEPTED_TERMS ?><br>
                    <?= POWERED_BY ?> : <?= $_SESSION['co_name']?><br>
                    <?= CALL_CENTER ?>: <?= $_SESSION['co_tel']?><br>
                    <br>
                </p>
                <br>
            </td>
        </tr>
    </table>
    <?
}// end printVoucher

?>

<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>


