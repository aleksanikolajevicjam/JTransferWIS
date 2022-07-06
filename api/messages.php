<?
header('Content-Type: text/javascript; charset=UTF-8');
session_start();
error_reporting(E_PARSE);

$output = array();

	require_once '../../db/db.class.php';
	require_once '../../db/v4_Messages.class.php';
	
	$i = new v4_Messages();
	
	$ID			= $_REQUEST['ID'];
	$UserID 	= $_SESSION['AuthUserID'];
	$newItem 	= $_REQUEST['newMessage'];
	$action		= $_REQUEST['action'];

$UserLevel = '91';
$where2 = '';
$UserID = '564';

	if ( $action == 'add') {
	
		# add item here
		if($newItem != '') {

	
			$i->saveAsNew();
		}
	}

	if ( $action == 'delete') {
	
		# delete item here
		$i->deleteRow($ID);

	}

	if ( $action == 'deleteCompleted') {


	}

	if ( $action == 'update') {
		
		$i->getRow($ID);

		# update item here

		$i->saveRow();


	}

	if ( $action == 'completed') {
	
		# toggle status of the item here
		$i->getRow($ID);

	
		$i->saveRow();

	}

	$where = ' WHERE UserLevel = ' . $UserLevel;

	if ($action == 'sent') {
		$where = ' WHERE MsgFrom = ' . $UserID;
	}

	# refresh items list

	$keys = $i->getKeysBy('ID','desc LIMIT 10',$where);
	
	foreach($keys as $n => $key) {
		$i->getRow($key);
		
		$done = '';
		$checked = '';
		if ( $i->getStatus() != '1' ) {
			$done = 'done';
			$checked = 'checked';
		}
		
		//$dateCompleted = '';
		//if ($i->getDateCompleted() != '0000-00-00') $dateCompleted = $i->getDateCompleted();
		
		$output[] = array(
			"ID"				=> $i->getID(),
			"from" 				=> $i->getFromName(), 
			"subject" 			=> $i->getMsg(), 
			"message" 			=> $i->getBody(), 
			"dateTime" 			=> $i->getDateTime(),
			"status" 			=> $i->getStatus()
		
		);
	}
	

if(count($output) == 0) $output[] = array("task" => 'No tasks', "elapsed" => '');
	
echo $_GET['callback'] . '(' . json_encode($output) . ')';	
