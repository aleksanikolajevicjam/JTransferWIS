<?
error_reporting(0);

session_start();

require_once '../../c/db.class.php';
require_once '../../c/tc_priceclass.class.php';
require_once('../lng/' . $_SESSION['lng'] . '_config.php');

//echo '<pre>'; print_r($_POST); echo '</pre>';

if ( isset($_REQUEST['ID']) )           $ID         = $_REQUEST['ID'];
if ( isset($_REQUEST['ClassDesc']) )    $desc       = $_REQUEST['ClassDesc'];
if ( isset($_REQUEST['Percent']) )      $percent    = $_REQUEST['Percent'];
if ( isset($_REQUEST['Action']) )       $action     = $_REQUEST['Action'];

$r = new tc_priceclass();

if ($action == 'update')
{
    $r->getRow($ID);
    
    $r->setClassDesc($desc);
    $r->setPercent($percent);

    $r->saveRow();
}

if ($action == 'delete') $r->deleteRow($ID);


if ($action == 'new') 
{
    $r->setClassDesc($desc);
    $r->setPercent($percent);

    $r->saveAsNew();
    $msg = 'Save';
}

echo '<div class="alert alert-success">' . $msg . ' ' .COMPLETED . '</div><br/>';
