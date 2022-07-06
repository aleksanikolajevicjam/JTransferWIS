<? // get data for single transfer (one way)
$DetailsID = $_REQUEST[DetailsID];

require_once ROOT . '/db/v4_OrderDetails.class.php';
require_once ROOT . '/db/v4_OrdersMaster.class.php';
	require_once ROOT . '/db/v4_AuthUsers.class.php';

$od = new v4_OrderDetails();
$om = new v4_OrdersMaster();
$au = new v4_AuthUsers();

$od->getRow($DetailsID);
$om->getRow($od->getOrderID());
$au->getRow($od->getUserID());
?>
<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<style>
    body {
        margin-top: 24px;
        }
* {
    font-size: medium;
    }
        .row {
            margin: 6px 0;
            }
            .lighter {color: #aaa}
</style>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-3 lighter">
            ID:
        </div>
        <div class="col-md-9">
            <strong><?= $om->getMOrderID() . '-' . $od->getTNo() ?></strong>
        </div>
    </div>
    <div class="row">
    <div class="col-md-3 lighter">
        Booked by:
        </div>
        <div class="col-md-9">
            <strong><?= $au->getAuthUserCompany() . ' (' . $od->getUserID() . ')'?></strong>
    </div>
    </div>
    <div class="row">
    <div class="col-md-3 lighter">
        Price:
        </div>
        <div class="col-md-9">
            <?= $od->getDetailPrice() ?>
    </div>
    </div>
    <div class="row">
    <div class="col-md-3 lighter">
        Pax:
        </div>
        <div class="col-md-9">
            <?= $od->getPaxNo() ?>
    </div>
    </div>
    <div class="row">
    <div class="col-md-3 lighter">
        Passanger's Name:
        </div>
        <div class="col-md-9">
            <?= $om->getMPaxFirstName() . ' ' . $om->getMPaxLastName() ?>
    </div>
    </div>
    <div class="row">
    <div class="col-md-3 lighter">
        Passenger's Email:
        </div>
        <div class="col-md-9">
            <?= $om->getMPaxEmail() ?>
    </div>
    </div>
    <div class="row">
    <div class="col-md-3 lighter">
        Pickup Date:
        </div>
        <div class="col-md-9">
            <?= $od->getPickupDate() ?>
    </div>
    </div>
    <div class="row">
    <div class="col-md-3 lighter">
        Pickup Time:
        </div>
        <div class="col-md-9">
            <?= $od->getPickupTime() ?>
    </div>
    </div>
    <div class="row">
    <div class="col-md-3 lighter">
        Flight Number:
        </div>
        <div class="col-md-9">
            <?= $od->getFlightNo() ?>
    </div>
    </div>
    <div class="row">
    <div class="col-md-3 lighter">
        Flight Times:
        </div>
        <div class="col-md-9">
            <?= $od->getFlightTime() ?>
    </div>
    </div>
    <div class="row">
    <div class="col-md-3 lighter">
        Pickup Name:
        </div>
        <div class="col-md-9">
            <strong><?= $od->getPickupName() ?></strong>
    </div>
    </div>
    <div class="row">
    <div class="col-md-3 lighter">
        Pickup Address:
        </div>
        <div class="col-md-9">
            <?= $od->getPickupAddress() ?>
    </div>
    </div>
    <div class="row">
    <div class="col-md-3 lighter">
        Drop-Off Name:
        </div>
        <div class="col-md-9">
            <strong><?= $od->getDropName() ?></strong>
    </div>
    </div>
    <div class="row">
    <div class="col-md-3 lighter">
        Drop-Off Address:
        </div>
        <div class="col-md-9">
            <?= $od->getDropAddress() ?>
    </div>
    </div>
    <div class="row">
    <div class="col-md-3 lighter">
        Pickup Notes:
        </div>
        <div class="col-md-9">
            <?= $od->getPickupNotes() ?>
    </div>
    </div>
    <br>
    <div class="row">
    <div class="col-md-3 lighter">
        Order Key:
        </div>
        <div class="col-md-9">
            <?= $om->getMOrderKey() . '-' . $om->getMOrderID() ?>
    </div>
    </div>
    <div class="row">
    <div class="col-md-3 lighter">
        Paid Online:
        </div>
        <div class="col-md-9">
            <?= $od->getPayNow() ?>
    </div>
    </div>
    <div class="row">
    <div class="col-md-3 lighter">
        Cash:
        </div>
        <div class="col-md-9">
            <?= $od->getPayLater() ?>
    </div>
    </div>
    <div class="row">
    <div class="col-md-3 lighter">
        Payment method:
        </div>
        <div class="col-md-9">
            
        <? switch ($od->getPaymentMethod()) {
            case 0:
                echo 'Undefined';
                break;
            case 1:
                echo 'Online';
                break;
            case 2:
                echo 'Cash';
                break;
            case 3:
                echo 'Online and Cash';
                break;
            case 4:
                echo 'Invoice' . ' [' . $od->getInvoiceAmount() . 'Eur]';
                break;
            case 5:
                'Compensation';
                break;
            case 9: default:
                echo 'Other';
                break;            
            } ?>
    </div>
    </div>
    <div class="row">
    <div class="col-md-3 lighter">
        Driver's Name:
        </div>
        <div class="col-md-9">
            <?= $od->getDriverName() ?>
    </div>
    </div>
    <div class="row">
    <div class="col-md-3 lighter">
        Driver's Tel:
        </div>
        <div class="col-md-9">
            <?= $od->getDriverTel() ?>
    </div>
    </div>
    <div class="row">
    <div class="col-md-3 lighter">
        Driver's Email:
        </div>
        <div class="col-md-9">
            <?= $od->getDriverEmail() ?>
    </div>
    </div>
    <div class="row">
    <div class="col-md-3 lighter">
        Transfer status:
        </div>
        <div class="col-md-9">
            
        <? switch ($od->getDriverConfStatus()) {
            case 0:
                echo '<span class="badge bg-red">No Driver</span>';
                break;
            case 1:
                echo '<span class="badge bg-red">Not Confirmed</span>';
                break;
            case 2:
                echo '<span class="badge bg-blue">Confirmed</span>';
                break;
            case 3:
                echo '<span class="badge bg-green">Ready</span>';
                break;
            case 4:
                echo '<span class="badge bg-red">Declined</span>';
                break;
            case 5:
                echo '<span class="">No-show</span>';
                break;
            case 6:
                echo '<span class="">Driver error</span>';
                break;
            case 7:
                echo '<span class="">Completed</span>';
                break;
            }
        echo ' ' . $od->getDriverConfDate() . ' ' . $od->getDriverConfTime();
        ?>
    </div>
    </div>
    <div class="row">
    <div class="col-md-3 lighter">
        Payment status:
        </div>
        <div class="col-md-9">
            
        <? switch ($od->getPaymentStatus()) {
            case 0:
                echo 'Not Paid';
                break;
            case 1:
                echo 'Invoice Sent';
                break;
            case 2:
                echo 'Warning sent';
                break;
            case 3:
                echo 'Sued';
                break;
            case 4:
                echo 'Refunded';
                break;
            case 10:
                echo 'Lost - will not be paid';
                break;
            case 91:
                echo 'Compensated';
                break;
            case 99:
                echo 'Paid';
                break;
            }
        ?>
    </div>
    </div>
    <div class="row">
    <div class="col-md-3 lighter">
        Driver Payment:
        </div>
        <div class="col-md-9">
            
        <? switch ($od->getDriverPayment()) {
            case 0:
                echo 'Not Paid';
                break;
            case 1:
                echo 'Partly paid';
                break;
            case 2:
                echo 'Paid';
                break;
            case 3:
                echo 'Compensated';
                break;
            }
        ?>
    </div>
    </div>
    <div class="row">
    <div class="col-md-3 lighter">
        Amount:
        </div>
        <div class="col-md-9">
            <?= $od->getDriverPaymentAmt() ?>
    </div>
</div>
</body>
</html>	

