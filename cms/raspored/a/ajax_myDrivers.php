<?
//error_reporting(0);

session_start();
require_once '../config.php';
require_once '../c/db.class.php';
require_once '../c/tc_mydrivers.class.php';



    $_SESSION['lng'] = 'en';
    require_once('../lng/' . $_SESSION['lng']. '_config.php');




if ( isset($_REQUEST['DriverID']) )     	$ID    = $_REQUEST['DriverID'];
if ( isset($_REQUEST['DriverName']) )   	$name  = $_REQUEST['DriverName'];
if ( isset($_REQUEST['DriverPassword']) )   $pass  = $_REQUEST['DriverPassword'];
if ( isset($_REQUEST['oldPass']) )   		$oldPass  = $_REQUEST['oldPass'];
if ( isset($_REQUEST['DriverEmail']) )      $email = $_REQUEST['DriverEmail'];
if ( isset($_REQUEST['DriverTel']) )      	$tel   = $_REQUEST['DriverTel'];
if ( isset($_REQUEST['Notes']) )      		$notes = $_REQUEST['Notes'];

if ( isset($_REQUEST['newDriverName']) )   		$name  = $_REQUEST['newDriverName'];
if ( isset($_REQUEST['newDriverPassword']) )   	$pass  = $_REQUEST['newDriverPassword'];
if ( isset($_REQUEST['newDriverEmail']) )      	$email = $_REQUEST['newDriverEmail'];
if ( isset($_REQUEST['newDriverTel']) )      	$tel   = $_REQUEST['newDriverTel'];
if ( isset($_REQUEST['newNotes']) )      		$notes = $_REQUEST['newNotes'];


if ( isset($_REQUEST['Action']) )       	$action= $_REQUEST['Action'];

//echo '<pre>'; print_r($_REQUEST); echo '</pre>';

$msg = CHANGES_NOT_SAVED;

if (empty($name) and $action != 'delete') {echo '<div class="alert alert-error">' . $msg . '</div><br/>'; die;}

$r = new SubDrivers();

# password games
# password changed or new
if ($pass != '*****') $pass = md5($pass);
else {
	# password not changed
	$pass = $oldPass;
}

# mijenja enter sa br
$notes = preg_replace('~(*BSR_ANYCRLF)\R~', "<br/>", $notes);

# dozvoljava samo slova i brojeve
$name = preg_replace("/[^a-zA-Z0-9]+/", "", $name);

if ($action == 'update')
{
    $r->getRow($ID);

  
    $r->setOwnerID($_SESSION['OwnerID']);
    $r->setDriverName($name);
    $r->setDriverPassword($pass);
    $r->setDriverEmail($email);
    $r->setDriverTel($tel);
    $r->setNotes(strip_tags($notes));
    

    $r->saveRow();
    $msg = COMPLETED;
}

if ($action == 'delete') 
{
    $r->deleteRow($ID); 
    $msg = COMPLETED;
    
}


if ($action == 'new') 
{
    $r->setOwnerID($_SESSION['OwnerID']);
    $r->setDriverName($name);
    $r->setDriverPassword($pass);
    $r->setDriverEmail($email);
    $r->setDriverTel($tel);
    $r->setNotes(strip_tags($notes));

    $r->saveAsNew();
    
    $msg = COMPLETED;
    
}

echo '<div class="alert alert-success">' . $msg . '</div><br/>';
