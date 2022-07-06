<? header('Content-Type: text/javascript; charset=UTF-8');
    @session_start();
    error_reporting(0);

    require_once ROOT.'/f2/f.php';
    require_once ROOT . '/LoadLanguage.php';

    // priprema podataka o vozilima i vozacima
    require_once ROOT.'/api2/getCars.php';


/*
Iz gornje skripte
prima podatke o vozilu:
                            $cars[] = array(
                                'RouteID'           => $id,
                                'OwnerID'           => $OwnerID,
                                'Driver'            => $Driver,
                                'ProfileImage'      => $ProfileImage,
                                'ServiceID'         => $ServiceID,
                                'VehicleID'         => $VehicleID,
                                'VehicleTypeID'     => $VehicleTypeID,
                                'VehicleName'       => $VehicleName,
                                'VehicleImage'      => $VehicleImage,
                                'VehicleCapacity'   => $VehicleCapacity,
                                'BasePrice'         => round($BasePrice,0),
                                'Rating'            => $Rating
                            );

i podatke o profilu vozaca:
                            $drivers[$OwnerID] = array(
                                        'Driver'            => $Driver,
                                        'ProfileImage'      => $ProfileImage,
                                        'RealName'          => $au->getAuthUserRealName(),
                                        'Company'           => $au->getAuthUserCompany(),
                                        'Address'           => $au->getAuthCoAddress()
                            );

i eventualne greske:
            $carsErrorMessage['title'] = 'Sorry, No available vehicles';
            $carsErrorMessage['text'] = 'or vehicles are too small for your group';

/**********************************************************************************************************

                DISPLAY SECTION

***********************************************************************************************************/
ob_start(); 

?>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <div style="font-size:14px; font-weight:100">

        <img src="https://<?= $_SERVER['HTTP_HOST']?>/jam-white-red.png">

        <?
        //echo '<h1 style="text-decoration:none !important; color:#333 !important">'.$SITE_NAME . '</h1>';
        echo $DEAR_CUSTOMER . '<br>';
        echo '<h3>'.$YOUR_QUOTE . ':</h3>';
        echo $FROM .': ' . getPlaceName($_REQUEST['PickupID']) . '<br>';
        echo $TO .': ' . getPlaceName($_REQUEST['DropID']) . '<br><br>';
        //echo $PASSENGERS_NO .': ' . $_REQUEST['PaxNo'] . '<br><br>';
        echo $PICKUP_DATE . ': ' . $_REQUEST['PickupDate'] . '<br>';
        echo $PICKUP_TIME . ': ' . $_REQUEST['PickupTime'] . '<br>';
        if ($_REQUEST['returnTransfer']) {
            echo '<br>';
            echo $RETURN_DATE . ': ' . $_REQUEST['XPickupDate'] . '<br>';
            echo $RETURN_TIME . ': ' . $_REQUEST['XPickupTime'] . '<br>';
        }

        if (strpos($_SERVER['HTTP_REFERER'], 'jamtransfer') !== false) {
            $bookingLink = "https://www.jamtransfer.com/taxi-transfers-from-".getPlaceSEO($_REQUEST['PickupID'])."-to-".getPlaceSEO($_REQUEST['DropID']);
        } else {
            $bookingLink = $_SERVER['HTTP_REFERER'];
        }
        echo '<br>';
        echo $BELOW;
        ?>

    </div>

    <?

    $car = $_REQUEST['car'] - 1; // daj samo odabrano vozilo. $cars krece od nule, zato -1

    // No Errors found
    if (count($carsErrorMessage) == 0) {

        foreach($cars as $i => $carData ):

            if ($carData['FinalPrice'] > 0 and $i == $car): // drugi uvjet maknuti ako se hoce sva vozila
                ?>
                <div style="border: 2px solid #eee; max-width:320px;text-align:center;">

                    <h1 style="text-transform:uppercase;font-weight:100"><?= $carData['VehicleName']?></h1>

                    <img src="<?= $carData['VehicleImage'] ?>" style="max-height:240px;max-width:240px;">

                    <h2 style="text-transform:uppercase;">
                         <?= $PRICE ?>: <?= 'EUR' . ' ' . number_format($carData['FinalPrice'],2) ?>
                    </h2>
                </div>
                <p>
                    <?= $QUOTE_BEFORE_BUTTON ?>
                </p>
                <br>
                <br>
                <a href="<?= $bookingLink ?>" style="padding:8px;background: #ef5350;color:#fff;text-decoration:none !important;font-weight:300;font-size:15px;line-height:20px;">
                    <?= $CONTINUE_BOOKING ?>
                </a>
                <br>
                <br>
                <?= $QUOTE_FOOTER ?>
                <br><br>
            <?
            endif;
        endforeach;

    } else {
        echo $NOTHING_FOUND;
    }
    ?>
</body>
</html>

<?

$msg = ob_get_contents();
ob_end_clean();
$from_mail = 'info@jamtransfer.com';
$from_name = 'jamtransfer.com';
if(isset($_SESSION['co_email']) and !empty($_SESSION['co_email'])) $from_mail = $_SESSION['co_email'];
if(isset($_SESSION['co_name']) and !empty($_SESSION['co_name'])) $from_name = $_SESSION['co_name'];

$sent = mail_html($_REQUEST['sendTo'], $from_mail, $from_name, $from_mail,'Taxi Transfer Quote', $msg);

//echo $msg;
$res = array(
                "Success"   => $sent
);
    $out = json_encode($res); //test
    echo $_GET['callback'] . '(' . $out. ')';

