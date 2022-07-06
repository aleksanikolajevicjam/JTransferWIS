<?
header('Content-Type: text/javascript; charset=UTF-8');
require_once '../config.php';
session_start();

$output = array();

	require_once '../db/v4_TodoList.class.php';
	
	$i = new v4_TodoList();
	
	$ID			= $_REQUEST['ID'];
	$OwnerID 	= $_SESSION['AuthUserID'];
	$newItem 	= $_REQUEST['newItem'];
	$action		= $_REQUEST['action'];



	if ( $action == 'add') {
	
		# add item here
		if($newItem != '') {
			$i->setTask($newItem);
			$i->setOwnerID($OwnerID);
			$i->setDateAdded(date("Y-m-d"));
			$i->setTimeAdded(date("H:i"));
	
			$i->saveAsNew();
		}
	}

	if ( $action == 'delete') {
	
		# delete item here
		$i->deleteRow($ID);

	}

	if ( $action == 'deleteCompleted') {
		$where = ' WHERE OwnerID = ' . $OwnerID . ' AND Completed = "1"';
		$keys = $i->getKeysBy('ID','asc',$where);
	
		foreach($keys as $n => $key) {
			# delete item here
			$i->deleteRow($key);
		}

	}

	if ( $action == 'update') {
		
		$i->getRow($ID);

		# update item here
		$i->setTask($newItem);
		$i->setDateAdded(date("Y-m-d"));
		$i->setTimeAdded(date("H:i"));
		$i->saveRow();


	}

	if ( $action == 'completed') {
	
		# toggle status of the item here
		$i->getRow($ID);
		$i->setCompleted(!$i->getCompleted());
		$i->setDateCompleted(date("Y-m-d"));
		$i->setTimeCompleted(date("H:i"));
	
		$i->saveRow();

	}


	# refresh items list
	$where = ' WHERE OwnerID = ' . $OwnerID;
	$keys = $i->getKeysBy('DateAdded, TimeAdded','asc',$where);
	
	foreach($keys as $n => $key) {
		$i->getRow($key);
		
		$done = '';
		$checked = '';
		if ( $i->getCompleted() != false ) {
			$done = 'done';
			$checked = 'checked';
		}
		
		//$dateCompleted = '';
		//if ($i->getDateCompleted() != '0000-00-00') $dateCompleted = $i->getDateCompleted();
		
		$output[] = array(
			"ID"				=> $i->getID(),
			"task" 				=> $i->getTask(), 
			"dateTime" 			=> $i->getDateAdded().' '.$i->getTimeAdded(),
			"completed" 		=> $checked,
			//"dateCompleted"		=> $dateCompleted,
			"done"				=> $done
		
		);
	}
	

if(count($output) == 0) $output[] = array("task" => 'No tasks', "elapsed" => '');
	
echo $_GET['callback'] . '(' . json_encode($output) . ')';	
