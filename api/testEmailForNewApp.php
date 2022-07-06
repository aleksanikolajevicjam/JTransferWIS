<?
header('Content-Type: text/javascript; charset=UTF-8');
session_start();

$from = $_SESSION['UserEmail'];
$from_name = $_SESSION['co_name'] . ' | ' . $_SESSION['UserRealName'];


if (!$_SESSION['TEST']) $to = $_REQUEST['to'];
else $to = 'bogo@jamtransfer.com';


$subject = $_REQUEST['subject'];
$message = $_REQUEST['message'];

if ($message != '' and $to != '') $sent = mail_html($to, $from, $from_name, $from, $subject, $message);
else $sent = false;

if ($sent) $output = '<span class="badge bg-green"><i class="ic-happy"></i> Message sent. </span>';
else $output = '<span class="badge bg-red"><i class="ic-sad"></i> Message not sent. </span>';

echo $_GET['callback'] . '(' . json_encode($output) . ')';	

# adaptacija gornje funkcije za slanje HTML-a bez attachmenta
function mail_html($mailto, $from_mail, $from_name, $replyto, $subject, $message) {

    $header = "From: ".$from_name." <".$from_mail.">\r\n";
    $header .= "Reply-To: ".$replyto."\r\n";

    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type:text/html; charset=utf-8"."\r\n";


    return mail($mailto, $subject, $message, $header);
}
