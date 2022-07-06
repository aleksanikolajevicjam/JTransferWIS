<? 

define("DEVELOPMENT",true);
define("MONITOR", 0);
define("ALLOW_REFRESH", 1);
define("CMS_ONLY", true); 
if ($_SERVER['HTTP_HOST']=='wis.jamtransfer.com') define("LOCAL",false);
else  define("LOCAL",true);
if (LOCAL) {
	define("ROOT", $_SERVER['DOCUMENT_ROOT'] . "/JTransferWIS/");
	define("ROOT_HOME", 'https://'.$_SERVER['HTTP_HOST'] . "/JTransferWIS/");

}	
else {
	define("ROOT", $_SERVER['DOCUMENT_ROOT']);
	define("ROOT_HOME", 'https://'.$_SERVER['HTTP_HOST']);
}	
define("ROOTPATH", ROOT.'/cms');
define("SITE_CODE", '1');
if (LOCAL) {
	define("DB_HOST", "localhost");
	define("DB_USER", "jamtestd_root");
	define("DB_PASSWORD", "jamtestd_root");
	define("DB_NAME", "jamtestd_jamtrans_touradria");
}
else {
	define("DB_HOST", "127.0.0.1");
	if (DEVELOPMENT) define("DB_USER", "jamtrans_api");
	else define("DB_USER", "jamtrans_cms");
	if (DEVELOPMENT) define("DB_PASSWORD", "i97zo5X&ftt4");
	else define("DB_PASSWORD", "~5%OuH{etSL)");
	if (DEVELOPMENT) define("DB_NAME", "jamtrans_test");
	else define("DB_NAME", "jamtrans_touradria");
}	

//if (DEVELOPMENT) error_reporting(E_ALL);
if (DEVELOPMENT) error_reporting(1);
else error_reporting(E_ALL);

?>
