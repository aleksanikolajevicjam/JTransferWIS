<?

require_once 'conn_string.php';
require_once ROOT. '/definitions.php';
require_once ROOT . '/db/db.class.php';
$db = new DataBaseMysql();


// AUTOLOAD FUNCTION
spl_autoload_register(
    function($classname) {
        //if ($classname<>'Smarty_Autoloader') require_once ROOT.'/db/'. $classname . '.class.php';
    }
);

require_once ROOT. '/sessionThingy.php';
require_once ROOT.'/common/functions/f.php';
require_once ROOT.'/common/class/PathVars.php';

require_once ROOT.'/common/class/smartyHelper.php';
require_once ROOT.'/common/class/class.smartypluginblock.php';
require_once ROOT.'/common/libs/Smarty.class.php';
require_once ROOT.'/common/libs/SmartyValidate.class.php';
require_once ROOT.'/common/libs/SmartyPaginate.class.php';

require_once ROOT.'/common/class/adminTable.php';

$smarty = new Smarty;
$smarty->compile_check = true;
$smarty->debugging =false;
$modulesPath = ROOT . '/plugins'; // base folder for modules
$smarty->assign('root_home',ROOT_HOME);
$smarty->assign('root',ROOT);

// LANGUAGES
if ( isset($_SESSION['CMSLang']) and $_SESSION['CMSLang'] != '') {
    $languageFile = 'lng/' . $_SESSION['CMSLang'] . '_text.php';
    if ( file_exists( $languageFile) ) require_once $languageFile;
    else {
        $_SESSION['CMSLang'] = 'en';
        require_once 'lng/en_text.php';
    }
} else {
    $_SESSION['CMSLang'] = 'en';
    require_once 'lng/en_text.php';
}
require_once 'lng/var-en.php';

$defvar=get_defined_vars();
foreach ($defvar as $key => $dv) {
    if (gettype($dv)=='string' or gettype($dv)=='array') $smarty->assign($key,$dv);
}
$defcon=get_defined_constants();
foreach ($defcon as $key => $dc) {
    $smarty->assign($key,$dc);
}
$smarty->assign('language',$_SESSION['CMSLang']);

// END OF LANGUAGES

// pdv
$filename = ROOT . '/cms/vatRate.inc';
$vat = file_get_contents($filename, FILE_USE_INCLUDE_PATH);
$_SESSION['vat'] = $vat;

// COMPANY DATA FROM DATABASE
if (!is('co_name')) {
    require_once ROOT . '/db/v4_CoInfo.class.php';
    $co = new v4_CoInfo();
    $co->getRow('1');
    $companyData = $co->fieldValues();
    $co->endv4_CoInfo();

    foreach($companyData as $name => $value) {
        $_SESSION[$name] = $value;
    }
}

if (isset($_SESSION['AuthUserID'])) {
    $AuthUserID=$_SESSION['AuthUserID'];
    $local = isLocalAgent($AuthUserID);
    $smarty->assign('local',$local);
}
$smarty->assign('isNew',false);

?>