<?
    header('Content-Type: text/javascript; charset=UTF-8');
    error_reporting(E_PARSE);

    @session_start();    
    require_once ROOT . '/db/db.class.php';
    require_once ROOT . '/db/v4_WorkingHours.class.php';
    
    $db = new DataBaseMysql();
    $wh = new v4_WorkingHours();

    $action = $_REQUEST['action'];
    
    $SubDriverID = $_REQUEST['SubDriverID'];
    $forDate = date("Y-m-d");
    $monthNumber = date("m");
    $weekNumber = date("W", strtotime($forDate));
    $shifts = '1';
    
    $where  = " WHERE SubDriverID = '" . $SubDriverID . "' ";
    $where .= " AND forDate = '" . $forDate . "' ";
    $where .= " AND shifts = '" . $shifts . "' ";
    
    $whk = $wh->getKeysBy('ID', 'ASC', $where);
    
    if(count($whk) != 0) $update = true; else $update = false;
    
    if($update) $wh->getRow($whk[0]);
    
    $wh->setforDate($forDate);
    $wh->setSubDriverID($SubDriverID);
    $wh->setshifts($shifts);
    $wh->setweekNumber($weekNumber);
    $wh->setmonthNumber($monthNumber);
    
    switch($action) {
    	case 'start':
		    $startTime = date("H:i");
		    $out = 'Start time recorded';
            $wh->setstartTime($startTime);
		    break;

    	case 'pstart':
		    $pauzaStart = date("H:i");
		    $out = 'Pause start recorded';
            $wh->setpauzaStart($pauzaStart);
		    break;

    	case 'pend':
		    $pauzaEnd = date("H:i");
		    $out = 'Pause end recorded';
            $wh->setpauzaEnd($pauzaEnd);
		    break;		


    	case 'end':
		    $endTime = date("H:i");
		    $out = 'End time recorded';
            $wh->setendTime($endTime);
		    break;		

    }
    
    //if($update) $wh->saveRow();
    //else $wh->saveAsNew();




    
    $output = array(
        $out
    );
    //print_r($output);
    echo $_GET['callback'] . '(' . json_encode($output) . ')';    
