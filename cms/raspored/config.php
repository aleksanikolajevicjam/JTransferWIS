<?
#
# CMS App Settings
# Warning - do NOT change uppercase text !!!
#
# -------->change only this V-------V
# define("UPPERCASE_TEXT", "Some text");

# Your e-mail address
//define("SITE_MAIL","bogo@jamtransfer.com");

# Site language - if not English (en) 
# you MUST have /lng/xx_config.php file where xx is the language code (de, it, fr etc.)
# 

require 'db.php';

$host = DB_HOST;
$user = DB_USER;
$pass = DB_PASSWORD;
$db   = DB_NAME;

###############################################################################################
# WARNING: DO NOT CHANGE ANYTHING BELOW THIS LINE !!!
###############################################################################################
# User types for Registration
define("AGENT_USER","2");
define("IFRAME_USER","5");
define("API_USER","6");
define("DRIVER_USER","31");
define("OPERATOR_USER","41");
define("ADMIN_USER","91");
define("SYSADMIN_USER","99");

# Confirmation Page 
define("INFORMED","1");
define("CONFIRMED","2");
define("DECLINED", "3");

define("NL", '<br/>'); // newline char for tooltips
define("JNL", '\\r\\n'); // newline char for tooltips
define("SITE_URL","http://".$_SERVER['SERVER_NAME']."/cms/raspored/");
define("DB_PREFIX", "");
