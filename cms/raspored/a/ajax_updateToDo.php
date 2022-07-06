<?
//error_reporting(E_ALL);

session_start();

require_once '../../c/db.class.php';
require_once '../../c/tc_co_info.class.php';
require_once('../lng/' . $_SESSION['lng'] . '_config.php');

//echo '<pre>'; print_r($_POST); echo '</pre>';

$content    = $_REQUEST['Content'];


$r = new tc_co_info();
$r->getRow('1');

$r->setco_todo($content);

$r->saveRow();

echo '<span class="alert alert-success"><small>' . CHANGES_SAVED . '</small></span>';
