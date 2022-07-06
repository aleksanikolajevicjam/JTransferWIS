<?
header('Content-Type: text/javascript; charset=UTF-8');
session_start();
require_once ROOT . '/f/f.php';

//$from = $_SESSION['UserEmail'];
//$from_name = $_SESSION['co_name'] . ' | ' . $_SESSION['UserRealName'];

// ovo gori sam uklonio i stavio ovo doli jer poruke vozacima iz cms-a dolaze sa taxi site adresa i domena
// mislim da to nije dobro. ako budu grintali ovo vrati na staro
		$from_name = 'JamTransfer.com';
		$from = 'info@jamtransfer.com';
		
//if (!$_SESSION['TEST']) 
$to = $_REQUEST['to'];
//else $to = 'bogo@jamtransfer.com';


$subject 	= $_REQUEST['subject'];
$message 	= $subject . '<br><br>Message:<br><br>'.$_REQUEST['message'];
$OrderID 	= $_REQUEST['OrderID'];
$TNo		= $_REQUEST['TNo'];

if ($_REQUEST['message'] != '' and $to != '') {
	$sent = mail_html($to, $from, $from_name, $from, $subject, $message);
	mail_html('bogo@jamtransfer.com', $from, $from_name, $from, $subject, $message);
}
else $sent = false;

if ($sent == 'OK') $output = '<span class="badge bg-green"><i class="ic-happy"></i> Message sent. </span>';
else $output = '<span class="badge bg-red"><i class="ic-sad"></i> Message not sent. </span>';

echo $_GET['callback'] . '(' . json_encode($output) . ')';	

