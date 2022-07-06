<?
header('Content-Type: text/javascript; charset=UTF-8');

@session_start();

require_once ROOT.'/f2/f.php';

if($_POST['Requester'] == 'guest') $sendToEmail = 'info@jamtransfer.com';
if($_POST['Requester'] == 'customer') $sendToEmail = 'info@jamtransfer.com';
if($_POST['Requester'] == 'agent') $sendToEmail = 'info@jamtransfer.com';
if($_POST['Requester'] == 'driver') $sendToEmail = 'info@jamtransfer.com';
if($_POST['Requester'] == 'partner') $sendToEmail = 'info@jamtransfer.com';


switch ($_POST['Requester'])
{
    case 'guest':
            $sendToEmail = 'info@jamtransfer.com';
            $msgPrefix = 'Requester: GUEST<br>Name: ' . $_POST['Name'] . '<br>Email: '. $_POST['Email'] .'<br><br>Message: <br>';
            break;
    case 'customer':
            $sendToEmail = 'info@jamtransfer.com';
            $msgPrefix = 'Requester: CUSTOMER<br>Name: ' . $_POST['Name'] . '<br>Email: '. $_POST['Email'] .'<br><br>Message: <br>';
            break;
    case 'agent':
            $sendToEmail = 'info@jamtransfer.com';
            $msgPrefix = 'Requester: AGENT<br>Name: ' . $_POST['Name'] . '<br>Email: '. $_POST['Email'] .'<br><br>Message: <br>';
            break;
    case 'driver':
            $sendToEmail = 'info@jamtransfer.com';
            $msgPrefix = 'Requester: DRIVER<br>Name: ' . $_POST['Name'] . '<br>Email: '. $_POST['Email'] .'<br><br>Message: <br>';
            break;
    case 'partner':
            $sendToEmail = 'info@jamtransfer.com';
            $msgPrefix = 'Requester: PARTNER<br>Name: ' . $_POST['Name'] . '<br>Email: '. $_POST['Email'] .'<br><br>Message: <br>';
            break;

    default: break;

}

if(!empty($_POST['Name']) and !empty($_POST['Email']) and !empty($_POST['Message']) ) {

    $sent = mail_html($sendToEmail, $_POST['Email'] , $_POST['Name'], $_POST['Email'],
              'JamTransfer.com Contact Form', $msgPrefix . $_POST['Message']);

    $showMessage = '<h3 class="white-text">Thank you! We will reply shortly.</h3>';

} else {

    $sent = 'OK';
    $showMessage = '<div class="red white-text text-center"> Please fill-in all data and press Submit</div>';
}


$res = array(
                "Success"   => $sent,
                "Message"   => $showMessage
);
    $out = json_encode($res); //test
    echo $_GET['callback'] . '(' . $out. ')';
