<?

error_reporting(E_PARSE);
@session_start();

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


# POST goes into SESSION
foreach($_POST as $k => $v) {
	$_SESSION[$k] = $v;
}


$_SESSION['origin'] = $_SERVER['HTTP_REFERER'];


require_once ROOT .'/f/f.php';
require_once ROOT . '/t/dbAddOrder.php';

$order_info = 'Taxi Transfer';

$_SESSION['order_number'] = time().mt_rand('11111','99999');
$order_number = $_SESSION['order_number'];

// ako nije cash placanje
if($_SESSION['PaymentOption'] != '2') { 
	$amount = number_format($_POST['PNC'],2,'.','') * 100; // online dio
}	


//$currency = 'EUR';
$currency = $_SESSION['Currency'];

$digest = SHA1($key.$order_number.$amount.$currency);

$omOrderID = insertOrder('temp');

if(is_numeric($omOrderID)) $insertSuccess = true;
else $insertSuccess = false;

if($_SESSION['PaymentOption'] != '2') { // ako nije Cash only, nego ide nesto Online

	?>

	<form id="webteh" action="<?=$submit_url?>/form" method="post">


		<input id="ch_full_name" name="ch_full_name" type="hidden" value="<?= p('ch_name')?> <?= p('ch_last_name')?>" />
		<input id="ch_address" name="ch_address" type="hidden" value="<?= p('ch_address')?>" />
		<input id="ch_city" name="ch_city" type="hidden" value="<?= p('ch_city')?>" />
		<input id="ch_zip" name="ch_zip" type="hidden" value="<?=p('ch_zip')?>" />
		<input id="ch_country" name="ch_country" type="hidden" value="<?= GetCountryName( p('ch_country') )?>" />
		<input id="ch_phone" name="ch_phone" type="hidden" value="<?=p('ch_phone')?>" />
		<input id="ch_email" name="ch_email" type="hidden" value="<?=p('ch_email')?>" />

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
		<input id="custom_params" name="custom_params" type="hidden" value="" />
	

	  
	</form>

	<? if ($insertSuccess) { ?>
		<script type="text/javascript">
			document.getElementById("webteh").submit();
		</script>
	<? } else echo BOOM_WRONG;
 
} else { // ako je placanje Cash only

	if ($insertSuccess) { ?>
		<form id="thx" action="thankyou" method="post"></form>
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
  

