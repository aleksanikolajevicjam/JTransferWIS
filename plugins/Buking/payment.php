<?
$smarty->assign('page', $md->getName());
@session_start();
if (!$_SESSION['UserAuthorized']) die('Bye, bye');
require_once '../../config.php';

//$smarty->assign('page', $md->getName());
//@session_start();

# POST goes into SESSION
foreach($_POST as $k => $v) {
	$_SESSION[$k] = $v;
}

//require_once $_SERVER['DOCUMENT_ROOT'] .'/f/f.php';

require_once 'dbAddOrder.php';


$order_info = 'Taxi Transfer';

// testiranje online placanja
define("TEST", false);


if(TEST) { // test payment gateway

    $key = "jam76trans";
    $submit_url = 'https://ipgtest.webteh.hr';
    $token = "5a935f335730aac8b4e2933d219b75edd32d874a";

} else { // LIVE payment gateway

    $key = 'j.A.35(#$m';
    $submit_url = 'https://ipg.webteh.hr';
    $token = "53a7f19756e9d205517d9f070a97ab986fcf0a55";
}
//****************************

$_SESSION['order_number'] = time().mt_rand('11111','99999');
$order_number = $_SESSION['order_number'];

$amount = 0;

// NOVO: Online placanje za agente
if($_SESSION['PaymentOption'] == '1') {
@Blogit('AGENT ONLINE - kreiranje amounta');
	$UserID = $_SESSION['AuthUserID'];
	$user = getUserData($UserID);
	// provizija ide samo na cijenu transfera, ne na TotalPrice
	$AgentCommision = nf($_POST['TT']-$_POST['ET'])* ($user['Provision'] / 100);
	$Invoice = nf($_POST['TotalPrice'] -  $AgentCommision);
	
	
	//$amount = number_format($_POST['PNC'],2,'.','') * 100;

	// ovo je za placanje karticom za agenta.
	// placa sve osim svoje provizije
	$amount = number_format($Invoice,2,'.','') * 100; 
}	

//$currency = 'EUR';
$currency = $_SESSION['Currency'];



$digest = SHA1($key.$order_number.$amount.$currency);


//$omOrderID = insertOrder('temp');
$omOrderID=9999999;

if(is_numeric($omOrderID)) {

    $insertSuccess = true;
    @Blogit('AGENT ONLINE - insert success true');
} else {
    $insertSuccess = false;
    @Blogit('AGENT ONLINE - insert success false');
} 

if($_SESSION['PaymentOption'] == '1') { // Online za agente
@Blogit('AGENT ONLINE - webteh loop');
	# payment gateway
	//$submit_url = 'https://ipg.webteh.hr'; 

	?>

	<form id="webteh" action="<?=$submit_url?>/form" method="post">

		<input id="ch_full_name" name="ch_full_name" type="hidden" value="<?= p('MPaxFirstName')." ".p('MPaxSecondName')?>" />
		<input id="ch_address" name="ch_address" type="hidden" value="Address" />
		<input id="ch_city" name="ch_city" type="hidden" value="City" />
		<input id="ch_zip" name="ch_zip" type="hidden" value="Zip" />
		<input id="ch_country" name="ch_country" type="hidden" value="Country" />
		<input id="ch_phone" name="ch_phone" type="hidden" value="<?= p('MPaxTel') ?>" />
		<input id="ch_email" name="ch_email" type="hidden" value="<?= p('MPaxEmail') ?>" />

		<input id="order_info" name="order_info" type="hidden" value="<?=$order_info?>" />
		<input id="amount" name="amount" type="hidden" value="<?=$amount?>" /></p>
		<input id="order_number" name="order_number" type="hidden" value="<?=$order_number?>" />
		<input id="currency" name="currency" type="hidden" value="<?=$currency?>" />
		<input id="transaction_type" name="transaction_type" type="hidden" value="purchase" />
		<input id="number_of_installments" name="number_of_installments" type="hidden" value="" />
		<input id="cc_type_for_installments" name="cc_type_for_installments" type="hidden" value="" />

		<input id="moto" name="moto" type="hidden" value="false" />

		<input id="authenticity_token" name="authenticity_token" type="hidden" 
		value="<?= $token ?>" />

		<input id="digest" name="digest" type="hidden" value="<?= $digest ?>" />

		<input id="language" name="language" type="hidden" value="en" />
		<input id="custom_params" name="custom_params" type="hidden" value="<?=$_SERVER['HTTP_REFERER']?>" />
  
	</form>

	<? if ($insertSuccess) { ?>
		<script type="text/javascript"> document.getElementById("webteh").submit(); </script>
	<? } else echo BOOM_WRONG;
 
} else { // ako je placanje Cash only

	if ($insertSuccess) { ?>
		<form id="thx" action="index.php?p=agentThankyou2" method="post"></form> 
		<script type="text/javascript"> document.getElementById("thx").submit(); </script>
		<?
		
	} else { 
		 echo BOOM_WRONG;
		 die();
	}

}

?>

<?
/*
** FUNCTIONS
*/
  
function p ( $var ) {
  	if (isset($_POST[$var])) return $_POST[$var];
  	else return '';
}
  

