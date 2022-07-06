<?
//$OwnerID = '843'; // $_SESSION['OwnerID']

//$dateFrom = $_REQUEST['DateFrom'];
//$dateTo = $_REQUEST['DateTo'];
// prethodni ponedjeljak
//$testdate = date("Y-m-d",strtotime('last monday', strtotime('2018-05-01')) );

// dan u tjednu 0=nedjelja 1=ponedjeljak
//echo date('w', strtotime($testdate));
// redni broj dana u godini
//echo date('z', strtotime($testdate)) +1;



//require_once ROOT .'/cms/lng/en_text.php';

//require './headerScripts.php';

require_once ROOT . '/db/db.class.php';
require_once ROOT . '/f2/f.php';
require_once ROOT . '/db/v4_OrdersMaster.class.php';
require_once ROOT . '/db/v4_OrderDetails.class.php';
require_once ROOT . '/db/v4_Routes.class.php';

$db = new DataBaseMysql();
$om = new v4_OrdersMaster();
$od = new v4_OrderDetailsFR();
$ro = new v4_Routes();

$ShowHidden = '0';
if(isset($_REQUEST['ShowHidden'])) $ShowHidden = $_REQUEST['ShowHidden'];

$OwnerID = $_SESSION['AuthUserID'];

$Month = $_REQUEST['Month'];
$Year = $_REQUEST['Year'];
$SubDriverID = $_REQUEST['SubDriverID'];

// podaci o subdriveru
$sd = getUser($SubDriverID);

//echo '<pre>';print_r($_REQUEST);echo '</pre>';



if( isset($_REQUEST['submit']) || isset($_REQUEST['Save']) ) {


    ##########################################################################################
    ## UPIS U TABLICE
    ##########################################################################################

    if(isset($_REQUEST['Save'])) {

        foreach($_REQUEST['DateFrom'] as $key => $value) {
            
                $Description = '';
                $monthNumber = $Month;
                $forDate = $_REQUEST['DateFrom'][$key];
                $startTime = $_REQUEST['startTime_1'][$key];
                $endTime = $_REQUEST['endTime_1'][$key];
                $pauzaStart = $_REQUEST['pauzaStart_1'][$key];
                $pauzaEnd = $_REQUEST['pauzaEnd_1'][$key];
                $ukRedovno = $_REQUEST['ukRedovno_1'][$key];
                $ukPauza = $_REQUEST['ukPauza_1'][$key];
                $ukNoc = $_REQUEST['ukNoc_1'][$key];
                $ukNedjelja = $_REQUEST['ukNedjelja_1'][$key];
                $ukPraznik = $_REQUEST['ukPraznik_1'][$key];
                $ukupno = $_REQUEST['ukupno_1'][$key];
                $weekNumber = $_REQUEST['WeekNumber'][$key];
                $Description = $_REQUEST['Description'][$key];
                $shifts = '1';
               
/*
                if($Description != '') {
                    $startTime = '00:00';
                    $endTime = '00:00';
                    $pauzaStart = '00:00';
                    $pauzaEnd = '00:00';
                    $ukRedovno = '00:00';
                    $ukPauza = '00:00';
                    $ukNoc = '00:00';
                    $ukNedjelja = '00:00';
                    $ukPraznik = '00:00';
                    $ukupno = '00:00';
                }
*/
                $q  = "REPLACE INTO v4_WorkingHours ";
                $q .= "(SubDriverID, forDate, shifts, startTime, endTime, pauzaStart, pauzaEnd, ukRedovno, ukPauza, ukNoc, ukNedjelja, 
                ukPraznik, ukupno, weekNumber, Description, monthNumber) ";
                $q .= "VALUES ('" . $SubDriverID."', '" .$forDate ."', '". $shifts ."' , '".$startTime ."', '" .$endTime ."',
                '" .$pauzaStart ."', '" .$pauzaEnd ."', '" .$ukRedovno ."', '" .$ukPauza ."', '" .$ukNoc ."', '" .$ukNedjelja ."',
                '" .$ukPraznik ."', '" .$ukupno ."', '" .$weekNumber . "', '" .$Description . "', '" .$monthNumber ."') ";

                $db->RunQuery($q);

                // smjena 2
                $forDate = $_REQUEST['DateFrom'][$key];
                $startTime = $_REQUEST['startTime_2'][$key];
                $endTime = $_REQUEST['endTime_2'][$key];
                $pauzaStart = $_REQUEST['pauzaStart_2'][$key];
                $pauzaEnd = $_REQUEST['pauzaEnd_2'][$key];
                $ukRedovno = $_REQUEST['ukRedovno_2'][$key];
                $ukPauza = $_REQUEST['ukPauza_2'][$key];
                $ukNoc = $_REQUEST['ukNoc_2'][$key];
                $ukNedjelja = $_REQUEST['ukNedjelja_2'][$key];
                $ukPraznik = $_REQUEST['ukPraznik_2'][$key];
                $ukupno = $_REQUEST['ukupno_2'][$key];
                $weekNumber = $_REQUEST['WeekNumber'][$key];
                $shifts = '2';
                

                if($Description != '') {
                    $startTime = '00:00';
                    $endTime = '00:00';
                    $pauzaStart = '00:00';
                    $pauzaEnd = '00:00';
                    $ukRedovno = '00:00';
                    $ukPauza = '00:00';
                    $ukNoc = '00:00';
                    $ukNedjelja = '00:00';
                    $ukPraznik = '00:00';
                    $ukupno = '00:00';
                }
                
               
                $q  = "REPLACE INTO v4_WorkingHours ";
                $q .= "(SubDriverID, forDate, shifts, startTime, endTime, pauzaStart, pauzaEnd, ukRedovno, ukPauza, ukNoc, ukNedjelja, 
                ukPraznik, ukupno, weekNumber, Description, monthNumber) ";
                $q .= "VALUES ('" . $SubDriverID."', '" .$forDate ."', '". $shifts ."' , '".$startTime ."', '" .$endTime ."',
                '" .$pauzaStart ."', '" .$pauzaEnd ."', '" .$ukRedovno ."', '" .$ukPauza ."', '" .$ukNoc ."', '" .$ukNedjelja ."',
                '" .$ukPraznik ."', '" .$ukupno ."', '" .$weekNumber . "', '" .$Description . "', '" .$monthNumber ."') ";

                $db->RunQuery($q);
                
                
                // WEEK SUMMARY- shifts = 3
                if( in_array($forDate, $_REQUEST['AfterDate']) ) {
                    
                    $key = array_search($forDate, $_REQUEST['AfterDate']);
                    $startTime = '00:00';
                    $endTime = '00:00';
                    $pauzaStart = '00:00';
                    $pauzaEnd = '00:00';
                    $ukRedovno = $_REQUEST['ukRedovno_w'][$key];
                    $ukPauza = $_REQUEST['ukPauza_w'][$key];
                    $ukNoc = $_REQUEST['ukNoc_w'][$key];
                    $ukNedjelja = $_REQUEST['ukNedjelja_w'][$key];
                    $ukPraznik = $_REQUEST['ukPraznik_w'][$key];
                    $ukupno = $_REQUEST['ukupno_w'][$key];
                    $Description = 'Week Summary';
                    $shifts = '3';

                    $q  = "REPLACE INTO v4_WorkingHours ";
                    $q .= "(SubDriverID, forDate, shifts, startTime, endTime, pauzaStart, pauzaEnd, ukRedovno, ukPauza, ukNoc, ukNedjelja, 
                    ukPraznik, ukupno, weekNumber, Description, monthNumber) ";
                    $q .= "VALUES ('" . $SubDriverID."', '" .$forDate ."', '". $shifts ."' , '".$startTime ."', '" .$endTime ."',
                    '" .$pauzaStart ."', '" .$pauzaEnd ."', '" .$ukRedovno ."', '" .$ukPauza ."', '" .$ukNoc ."', '" .$ukNedjelja ."',
                    '" .$ukPraznik ."', '" .$ukupno ."', '" .$weekNumber . "', '" .$Description . "', '" .$monthNumber ."') ";

                    $db->RunQuery($q);
                    
                }

        }
        
        
        // MONTH SUMMARY - shifts = 4
        $startTime = '00:00';
        $endTime = '00:00';
        $pauzaStart = '00:00';
        $pauzaEnd = '00:00';
        $ukRedovno = $_REQUEST['ukRedovno_M'];
        $ukPauza = $_REQUEST['ukPauza_M'];
        $ukNoc = $_REQUEST['ukNoc_M'];
        $ukNedjelja = $_REQUEST['ukNedjelja_M'];
        $ukPraznik = $_REQUEST['ukPraznik_M'];
        $ukupno = $_REQUEST['ukupno_M'];
        $Description = 'Month Summary';
        $shifts = '4';

        $q  = "REPLACE INTO v4_WorkingHours ";
        $q .= "(SubDriverID, forDate, shifts, startTime, endTime, pauzaStart, pauzaEnd, ukRedovno, ukPauza, ukNoc, ukNedjelja, 
        ukPraznik, ukupno, weekNumber, Description, monthNumber) ";
        $q .= "VALUES ('" . $SubDriverID."', '" .$forDate ."', '". $shifts ."' , '".$startTime ."', '" .$endTime ."',
        '" .$pauzaStart ."', '" .$pauzaEnd ."', '" .$ukRedovno ."', '" .$ukPauza ."', '" .$ukNoc ."', '" .$ukNedjelja ."',
        '" .$ukPraznik ."', '" .$ukupno ."', '" .$weekNumber . "', '" .$Description . "', '" .$monthNumber ."') ";

        $db->RunQuery($q);        

        
        
        // hide or delete unwanted records
        foreach($_REQUEST as $key => $value) {

            $ima = strpos($key, 'Detail_');

            if($ima !== false) {
                $cutString = explode("_",$key);
                $DetailsID = $cutString[1];
                $od->getRow($DetailsID);

                $od->setExpired($value);
                $od->saveRow();
            }
        }
	} // end if save
    ##########################################################################################
    ## KRAJ UPISA U TABLICE
    ##########################################################################################    





    ##########################################################################################
    ## PRIKAZIVANJE PODATAKA
    ########################################################################################## 

    $daysInMonth = days_in_month($Month, $Year);

    $where  = "WHERE PickupDate >= '" . $Year.'-'.$Month.'-01' . "' ";
    $where .= "AND PickupDate <= '" . $Year.'-'.$Month.'-'.$daysInMonth . "' ";
    $where .= "AND DriverID = '". $OwnerID ."' ";
    $where .= "AND TransferStatus != '3' ";
    $where .= "AND TransferStatus != '9' ";
    $where .= "AND TransferStatus != '4' ";

    $where2= "AND Expired != '1' ";

    if($_REQUEST['SubDriverID'] != 0) {
        $where .= "AND (SubDriver = '" . $_REQUEST['SubDriverID'] . "' ";
        $where .= "OR SubDriver2 = '" . $_REQUEST['SubDriverID'] . "' ";
        $where .= "OR SubDriver3 = '" . $_REQUEST['SubDriverID'] . "') ";
    }

    if($ShowHidden) $odk = $od->getKeysBy("PickupDate", "ASC, PickupTime ASC", $where);
    else $odk = $od->getKeysBy("PickupDate", "ASC, PickupTime ASC", $where.$where2);

    if($ShowHidden) $odk2 = $od->getKeysBy("PickupDate", "ASC, PickupTime ASC",  $where.$where2);

    echo '<body class="grey lighten-2" style="font-size:13px;">';
 
    echo '<br><div class="center"><h1>Liste de transfert de chauffeur</h1><h3>' . $sd->AuthUserRealName . '</h3>';
    echo $Year.'-'.$Month.'-01' . ' - ' . $Year.'-'.$Month.'-'.$daysInMonth;

    if ($ShowHidden) echo ' (' . count($odk2) . '/' . count($odk) . ' transfers)';
    else echo ' (' . count($odk) . ' transfers)';


    echo '<br><br><button class="btn btn-default" onclick="$(\'.noPrint\').toggle(\'slow\');return false;">Show / Hide transfer details</button>';

    echo '</div><br><br>';


     echo '<form action="" method="POST">';
    // Container start LISTA
    echo '<div class="container-fluid white pad4px">';

    $prijenosIzProslogMjeseca = true;
    
    for($day = 1; $day <= $daysInMonth; $day++) {
        
        $dayTemp = '0'.$day;
        $day = substr($dayTemp, -2);
        
        // construct date
        $dateFrom = $Year.'-'.$Month.'-'.$day;        

        $dayOfYear = date("z", strtotime($dateFrom)) +1;

        $weekNo = date("W", strtotime($dateFrom));
        $dayOfWeek = date("l", strtotime($dateFrom));



        $where  = "WHERE PickupDate = '" . $dateFrom . "' ";
        $where .= "AND DriverID = '". $OwnerID ."' ";
        $where .= "AND TransferStatus != '3' ";
        $where .= "AND TransferStatus != '9' ";
        $where .= "AND TransferStatus != '4' ";

        $where2= "AND Expired != '1' ";

        if($SubDriverID != 0) {
            $where .= "AND (SubDriver = '" . $SubDriverID . "' ";
            $where .= "OR SubDriver2 = '" . $SubDriverID . "' ";
            $where .= "OR SubDriver3 = '" . $SubDriverID . "') ";
        }

        if($ShowHidden)     $odk = $od->getKeysBy("PickupDate", "ASC, PickupTime ASC", $where);
        else                $odk = $od->getKeysBy("PickupDate", "ASC, PickupTime ASC", $where.$where2);

        if($ShowHidden)     $odk2 = $od->getKeysBy("PickupDate", "ASC, PickupTime ASC",  $where.$where2);
        
       
        //if( count($odk) > 0 ) { // prikazi transfere za $dateFrom
        if(true) {        
            
            if( count($odk) == 0 )  $slobodanDan = true; else $slobodanDan = false; 
            
            foreach( $odk as $nn => $DetailsID ) {

                $od->getRow($DetailsID);
                $om->getRow($od->OrderID);


                if($od->PayNow > 0 and $od->PayLater == 0) $icon = '<i class="fa fa-credit-card xfa-2x"></i>';
                if($od->PayNow == 0 and $od->PayLater > 0) $icon = '<i class="fa fa-money xfa-2x xblue-text"></i>';
                if($od->PayNow == 0 and $od->PayLater == 0 and $od->InvoiceAmount > 0) $icon = '<i class="fa fa-user xfa-2x grey-text"></i>';

                $sd = getUser($od->SubDriver);
                if($od->SubDriver2 != '') $sd2 = getUser($od->SubDriver2);
                if($od->SubDriver3 != '') $sd3 = getUser($od->SubDriver3);
                
                // oznaci izbrisane, tj. skrivene - Expired = 1
                $colorClass = "white";
                if($od->Expired) $colorClass = "pink lighten-5";

                $expectedArrival = '';
                if( !empty($od->RouteID) ) {
                    $ro->getRow($od->RouteID);
                    $minutes_to_add = $ro->Duration + 15;
                    $time = new DateTime($od->PickupDate . ' ' . $od->PickupTime);
                    $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
                    $expectedArrival = $time->format('H:i');
                }
                ?>
                <!-- PODACI O TRANSFERU -->

                <div class="row pad4px <?=$colorClass?> noPrint" style="border-top: 1px solid #ccc">
                    <div class="col-md-1">
                        <?= $icon ?><br>
                        <?=dayToLang( date('l', strtotime($dateFrom)) )?><br>
                        <strong class="l"><?=$dateFrom?></strong>
                    </div>
                    <div class="col-md-2">
                        <span class="l">
                            <?/*<span class="xblue-text"><?= $od->SubPickupDate ?> - <?=$od->SubPickupTime ?></span>*/?>
                            <?= $od->PickupTime ?>
                            <? if($expectedArrival != '') echo '(ETA: ' . $expectedArrival .')'?>
                            <br>
                        </span>
                        <?= $om->MOrderKey ?> - <?= $om->MOrderID ?> - <?=$od->TNo ?><br>
                        <?= $od->PaxName ?><br>
                        <?= $om->MPaxTel ?>
                    </div>

                    <div class="col-md-2">
                        <?= $od->PickupName ?><br>
                        <?= $od->PickupAddress ?><br>
                    </div>

                    <div class="col-md-2">
                        <?= $od->DropName ?><br>
                        <?= $od->DropAddress ?><br>
                    </div>

                    <div class="col-md-2">
                        <?= trim( $sd->AuthUserRealName )?><br>

                        Cash: <?= $od->PayLater ?> EUR<br>
                        Online: <?= $od->PayNow ?> EUR<br>
                        Invoice: <?= $od->InvoiceAmount ?> EUR

                    </div>

                    <div class="col-md-2">
                        <?
                        if($od->SubDriver2 != '') {
                            echo $sd2->AuthUserRealName;
                            echo '<br>';
                        }
                        if($od->SubDriver3 != '') {
                            echo $sd3->AuthUserRealName;
                            echo '<br>';
                        }
                        ?>
                    </div>

                    <div class="col-md-1">
                        <input type="hidden" name="Detail_<?= $od->DetailsID ?>" id="Det_<?= $od->DetailsID ?>" value="<?= $od->Expired?>">

                        <input type="checkbox" id="Detail_<?= $od->DetailsID ?>"
                            <? if($od->Expired) echo 'checked="checked"'; ?>
                        onchange="toggleCheck('<?= $od->DetailsID ?>')" >

                    </div>

                </div>
                <?        
            }// end foreach odk



            ###################################################################
            ## KRAJ DANA
            ###################################################################


            // get previous working hours summary
            $q  = "SELECT * FROM v4_WorkingHours  ";
            $q .= "WHERE SubDriverID  = '" . $SubDriverID . "' ";
            $q .= "AND forDate  = '" . $dateFrom . "' ";
            $q .= "AND shifts  = '1' ";

            $r = $db->RunQuery($q);

            if($r->num_rows > 0) {
                $w = $r->fetch_object();
                $startTime_1 = $w->startTime;
                $endTime_1 = $w->endTime;
                $pauzaStart_1 = $w->pauzaStart;
                $pauzaEnd_1 = $w->pauzaEnd;
			    $ukRedovno_1 = $w->ukRedovno;
                $ukPauza_1 = $w->ukPauza;
                $ukNoc_1 = $w->ukNoc;
                $ukNedjelja_1 = $w->ukNedjelja;
                $ukPraznik_1 = $w->ukPraznik;
                $ukupno_1 = $w->ukupno;
                $Description = $w->Description;
            }
            if($startTime_1 == '') $startTime_1 = "00:00";
            if($endTime_1 == '') $endTime_1 = "00:00";
            if($pauzaStart_1 == '') $pauzaStart_1 = "00:00";
            if($pauzaEnd_1 == '') $pauzaEnd_1 = "00:00";
            if($ukRedovno_1 == '') $ukRedovno_1 = "00:00";
            if($ukPauza_1 == '') $ukPauza_1 = "00:00";
            if($ukNoc_1 == '') $ukNoc_1 = "00:00";
            if($ukNedjelja_1 == '') $ukNedjelja_1 = "00:00";
            if($ukPraznik_1 == '') $ukPraznik_1 = "00:00";
            if($ukupno_1 == '') $ukupno_1 = "00:00";
            
            if($Description == '') $Description = "Jour de congé";
            ?>

            <input type="hidden" name="DateFrom[]" value="<?=$dateFrom?>">
            <input type="hidden" name="WeekNumber[]" value="<?=$weekNo?>">
            <?  
                $color1 = 'grey lighten-2';
                $color2 = 'grey lighten-1';
                if ($slobodanDan) { 
                    $color1 = 'xorange lighten-3 xblack-text';
                    $color2 = 'xorange lighten-2 xblack-text';
               
                    
            ?>
            <div class="row pad4px <?=$color1?>">
                <div class="col-md-1">
                    <strong><?=$dateFrom?></strong><br>
                    <?=dayToLang( date('l', strtotime($dateFrom)) )?>
                    <? if(prazniciFR($dateFrom)) echo '<br><span class="red">HOLIDAY</span>'; ?>
                </div>            
                <div class="col-md-1"><strong>FREE</strong></div>
                <div class="col-md-10">
                    <input class="w100 xblack-text" type="text" name="Description[]" value="<?=$Description?>">
                </div>
            </div>
            <? } else { ?>
            <input type="hidden" name="Description[]">
            <? } ?>
            
            <? if(date('w', strtotime($dateFrom)) == '0' ) $nedilja = '1'; else $nedilja = 0; ?>
            <input type="hidden" id="Nedjelja1_<?=$dayOfYear?>" value="<?=$nedilja?>">
            <input type="hidden" id="Nedjelja2_<?=$dayOfYear?>" value="<?=$nedilja?>">
            
            <? if(prazniciFR($dateFrom)) $praznik = '1'; else $praznik = 0; ?>
            <input type="hidden" id="Praznik1_<?=$dayOfYear?>" value="<?=$praznik?>">
            <input type="hidden" id="Praznik2_<?=$dayOfYear?>" value="<?=$praznik?>">

            <div class="row pad4px <?=$color1?>" id="RONDE_1_<?=$dayOfYear?>" xstyle="display:none">
                <div class="col-md-1">
                    <strong><?=$dateFrom?></strong><br>
                    <?=dayToLang( date('l', strtotime($dateFrom)) )?>
                    <? if(prazniciFR($dateFrom)) echo '<br><span class="red">HOLIDAY</span>'; ?>
                </div>
                <div class="col-md-1">
                    RONDE 1<br>
                    <button class="btn" style="background:transparent !important" title="Show-Hide RONDE 2"
                    onclick="$('#RONDE_2_<?=$dayOfYear?>').toggle('slow');return false;"><i class="fa fa-sort"></i></button>
                </div>
                <div class="col-md-1">
                    Debut:<br>
                    <input class="timepicker w100" id="startTime_1_<?=$dayOfYear?>" name="startTime_1[]" value="<?=$startTime_1?>"
                    onchange="timeDifference('1_<?=$dayOfYear?>', 'startTime_', 'endTime_', 'ukRedovno_','<?=$weekNo?>');">
                </div>

                <div class="col-md-1">
                    Fin:<br>
                    <input class="timepicker w100" id="endTime_1_<?=$dayOfYear?>" name="endTime_1[]" value="<?=$endTime_1?>"
                    onchange="timeDifference('1_<?=$dayOfYear?>', 'startTime_', 'endTime_', 'ukRedovno_','<?=$weekNo?>');">
                </div>

                <div class="col-md-1">
                    Pause debut:<br>
                    <input class="timepicker w100"  id="pauzaStart_1_<?=$dayOfYear?>" name="pauzaStart_1[]" value="<?=$pauzaStart_1?>"
                    onchange="timeDifference('1_<?=$dayOfYear?>', 'pauzaStart_', 'pauzaEnd_', 'ukPauza_','<?=$weekNo?>');">
                </div>

                <div class="col-md-1">
                    Pause fin:<br>
                    <input class="timepicker w100"  id="pauzaEnd_1_<?=$dayOfYear?>" name="pauzaEnd_1[]" value="<?=$pauzaEnd_1?>"
                    onchange="timeDifference('1_<?=$dayOfYear?>', 'pauzaStart_', 'pauzaEnd_', 'ukPauza_','<?=$weekNo?>');">
                </div>

                <div class="col-md-1">
                    TOT. H. REGULIERES:<br>
                    <input class="w100 ukRedovno<?=$weekNo?>" id="ukRedovno_1_<?=$dayOfYear?>" name="ukRedovno_1[]" value="<?=$ukRedovno_1?>" 
				    onchange="timeTotal('1_<?=$dayOfYear?>','<?=$weekNo?>')" readonly>
                </div>

                <div class="col-md-1">
                    TOTAL PAUSE:<br>
                    <input class="w100 ukPauza<?=$weekNo?>" id="ukPauza_1_<?=$dayOfYear?>" name="ukPauza_1[]" value="<?=$ukPauza_1?>" 
				    onchange="timeTotal('1_<?=$dayOfYear?>','<?=$weekNo?>')" readonly>
                </div>

                <div class="col-md-1">
                    TOT.H. DE NUIT:<br>
                    <input class="timepicker w100 ukNoc<?=$weekNo?>"  id="ukNoc_1_<?=$dayOfYear?>" name="ukNoc_1[]" value="<?=$ukNoc_1?>" 
				    onchange="timeTotal('1_<?=$dayOfYear?>','<?=$weekNo?>')">
                </div>

                <div class="col-md-1">
                    TOTAL DIMANCHE:<br>
                    <input class="timepicker w100 ukNedjelja<?=$weekNo?>"  id="ukNedjelja_1_<?=$dayOfYear?>" name="ukNedjelja_1[]" value="<?=$ukNedjelja_1?>" 
				    onchange="timeTotal('1_<?=$dayOfYear?>','<?=$weekNo?>')">
                </div>

                <div class="col-md-1">
                    TOTAL JOURS FERIES:<br>
                    <input class="timepicker w100 ukPraznik<?=$weekNo?>"  id="ukPraznik_1_<?=$dayOfYear?>" name="ukPraznik_1[]" value="<?=$ukPraznik_1?>" 
				    onchange="timeTotal('1_<?=$dayOfYear?>','<?=$weekNo?>')">
                </div>

                <div class="col-md-1">
                    TOTAL:<br>
                    <input class="w100 ukupnoDan<?=$weekNo?>" id="ukupno_1_<?=$dayOfYear?>" name="ukupno_1[]" value="<?=$ukupno_1?>" readonly>
                </div>

            </div>

            <?

            // get previous working hours summary
            $q  = "SELECT * FROM v4_WorkingHours  ";
            $q .= "WHERE SubDriverID  = '" . $SubDriverID . "' ";
            $q .= "AND forDate  = '" . $dateFrom . "' ";
            $q .= "AND shifts  = '2' ";

            $r = $db->RunQuery($q);

            if($r->num_rows > 0) {
                $w = $r->fetch_object();
                $startTime_2 = $w->startTime;
                $endTime_2 = $w->endTime;
                $pauzaStart_2 = $w->pauzaStart;
                $pauzaEnd_2 = $w->pauzaEnd;
			    $ukRedovno_2 = $w->ukRedovno;
	            $ukPauza_2 = $w->ukPauza;
	            $ukNoc_2 = $w->ukNoc;
	            $ukNedjelja_2 = $w->ukNedjelja;
	            $ukPraznik_2 = $w->ukPraznik;
	            $ukupno_2 = $w->ukupno;
            }
            if($startTime_2 == '') $startTime_2 = "00:00";
            if($endTime_2 == '') $endTime_2 = "00:00";
            if($pauzaStart_2 == '') $pauzaStart_2 = "00:00";
            if($pauzaEnd_2 == '') $pauzaEnd_2 = "00:00";
            if($ukRedovno_2 == '') $ukRedovno_2 = "00:00";
            if($ukPauza_2 == '') $ukPauza_2 = "00:00";
            if($ukNoc_2 == '') $ukNoc_2 = "00:00";
            if($ukNedjelja_2 == '') $ukNedjelja_2 = "00:00";
            if($ukPraznik_2 == '') $ukPraznik_2 = "00:00";
            if($ukupno_2 == '' or $ukupno_2 == '0:00') $ukupno_2 = "00:00";
            
            //if($slobodanDan) $hideShift2 = 'hidden'; else $hideShift2 = '';
            if($ukupno_2 == '00:00') $initialDisplay = 'style="display:none"'; else $initialDisplay = '';
            
            ?>
            <div class="row pad4px <?=$color2?> <?=$hideShift2?>" id="RONDE_2_<?=$dayOfYear?>" <?=$initialDisplay?>>
                <div class="col-md-1">
                    <strong><?=$dateFrom?></strong><br>
                    <?=dayToLang( date('l', strtotime($dateFrom)) )?>
                    <? if(prazniciFR($dateFrom)) echo '<br><span class="red">HOLIDAY</span>'; ?>
                </div>
                <div class="col-md-1">
                    RONDE 2
                </div>
                <div class="col-md-1">
                    Debut:<br>
                    <input class="timepicker w100" id="startTime_2_<?=$dayOfYear?>" name="startTime_2[]" value="<?=$startTime_2 ?>"
                    onchange="timeDifference('2_<?=$dayOfYear?>', 'startTime_', 'endTime_', 'ukRedovno_','<?=$weekNo?>');">
                </div>

                <div class="col-md-1">
                    Fin:<br>
                    <input class="timepicker w100" id="endTime_2_<?=$dayOfYear?>" name="endTime_2[]" value="<?=$endTime_2 ?>"
                    onchange="timeDifference('2_<?=$dayOfYear?>', 'startTime_', 'endTime_', 'ukRedovno_','<?=$weekNo?>');">
                </div>

                <div class="col-md-1">
                    Pause debut:<br>
                    <input class="timepicker w100"  id="pauzaStart_2_<?=$dayOfYear?>" name="pauzaStart_2[]" value="<?=$pauzaStart_2 ?>"
                    onchange="timeDifference('2_<?=$dayOfYear?>', 'pauzaStart_', 'pauzaEnd_', 'ukPauza_','<?=$weekNo?>');">
                </div>

                <div class="col-md-1">
                    Pause fin:<br>
                    <input class="timepicker w100"  id="pauzaEnd_2_<?=$dayOfYear?>" name="pauzaEnd_2[]" value="<?=$pauzaEnd_2 ?>"
                    onchange="timeDifference('2_<?=$dayOfYear?>', 'pauzaStart_', 'pauzaEnd_', 'ukPauza_','<?=$weekNo?>');">
                </div>

                <div class="col-md-1">
                    TOT. H. REGULIERES:<br>
                    <input class="w100 ukRedovno<?=$weekNo?>" id="ukRedovno_2_<?=$dayOfYear?>" name="ukRedovno_2[]" value="<?=$ukRedovno_2 ?>" 
				    onchange="timeTotal('2_<?=$dayOfYear?>','<?=$weekNo?>')" readonly>
                </div>

                <div class="col-md-1">
                    TOTAL PAUSE:<br>
                    <input class="w100 ukPauza<?=$weekNo?>" id="ukPauza_2_<?=$dayOfYear?>" name="ukPauza_2[]" value="<?=$ukPauza_2 ?>"
                    onchange="timeTotal('2_<?=$dayOfYear?>','<?=$weekNo?>')" readonly>
                </div>

                <div class="col-md-1">
                    TOT.H. DE NUIT:<br>
                    <input class="timepicker w100 ukNoc<?=$weekNo?>"  id="ukNoc_2_<?=$dayOfYear?>" name="ukNoc_2[]" value="<?=$ukNoc_2 ?>"
                    onchange="timeTotal('2_<?=$dayOfYear?>','<?=$weekNo?>')">
                </div>

                <div class="col-md-1">
                    TOTAL DIMANCHE:<br>
                    <input class="timepicker w100 ukNedjelja<?=$weekNo?>"  id="ukNedjelja_2_<?=$dayOfYear?>" name="ukNedjelja_2[]" value="<?=$ukNedjelja_2 ?>"
                    onchange="timeTotal('2_<?=$dayOfYear?>','<?=$weekNo?>')">
                </div>

                <div class="col-md-1">
                    TOTAL JOURS FERIES:<br>
                    <input class="timepicker w100 ukPraznik<?=$weekNo?>"  id="ukPraznik_2_<?=$dayOfYear?>" name="ukPraznik_2[]" value="<?=$ukPraznik_2 ?>"
                    onchange="timeTotal('2_<?=$dayOfYear?>','<?=$weekNo?>')">
                </div>

                <div class="col-md-1">
                    TOTAL:<br>
                    <input class="w100 ukupnoDan<?=$weekNo?>" id="ukupno_2_<?=$dayOfYear?>" name="ukupno_2[]" value="<?=$ukupno_2 ?>" readonly>
                </div>

            </div>

        <?
      
        } // end if odk > 0
        else { 
        
            // nema transfera, slobodan dan
            $q  = "SELECT * FROM v4_WorkingHours  ";
            $q .= "WHERE SubDriverID  = '" . $SubDriverID . "' ";
            $q .= "AND forDate  = '" . $dateFrom . "' ";
            $q .= "AND shifts  = '1' ";

            $r = $db->RunQuery($q);
            if($r->num_rows > 0) {
                $w = $r->fetch_object();
                $startTime_1 = $w->startTime;
                $endTime_1 = $w->endTime;
                $pauzaStart_1 = $w->pauzaStart;
                $pauzaEnd_1 = $w->pauzaEnd;
			    $ukRedovno_1 = $w->ukRedovno;
                $ukPauza_1 = $w->ukPauza;
                $ukNoc_1 = $w->ukNoc;
                $ukNedjelja_1 = $w->ukNedjelja;
                $ukPraznik_1 = $w->ukPraznik;
                $ukupno_1 = $w->ukupno;
                $Description = $w->Description;
            }
            if($startTime_1 == '') $startTime_1 = "00:00";
            if($endTime_1 == '') $endTime_1 = "00:00";
            if($pauzaStart_1 == '') $pauzaStart_1 = "00:00";
            if($pauzaEnd_1 == '') $pauzaEnd_1 = "00:00";
            if($ukRedovno_1 == '') $ukRedovno_1 = "00:00";
            if($ukPauza_1 == '') $ukPauza_1 = "00:00";
            if($ukNoc_1 == '') $ukNoc_1 = "00:00";
            if($ukNedjelja_1 == '') $ukNedjelja_1 = "00:00";
            if($ukPraznik_1 == '') $ukPraznik_1 = "00:00";
            if($ukupno_1 == '') $ukupno_1 = "00:00";
 
            // nema transfera, slobodan dan
            $q  = "SELECT * FROM v4_WorkingHours  ";
            $q .= "WHERE SubDriverID  = '" . $SubDriverID . "' ";
            $q .= "AND forDate  = '" . $dateFrom . "' ";
            $q .= "AND shifts  = '2' ";            
            if($r->num_rows > 0) {
                $w = $r->fetch_object();
                $startTime_2 = $w->startTime;
                $endTime_2 = $w->endTime;
                $pauzaStart_2 = $w->pauzaStart;
                $pauzaEnd_2 = $w->pauzaEnd;
			    $ukRedovno_2 = $w->ukRedovno;
	            $ukPauza_2 = $w->ukPauza;
	            $ukNoc_2 = $w->ukNoc;
	            $ukNedjelja_2 = $w->ukNedjelja;
	            $ukPraznik_2 = $w->ukPraznik;
	            $ukupno_2 = $w->ukupno;
            }
            if($startTime_2 == '') $startTime_2 = "00:00";
            if($endTime_2 == '') $endTime_2 = "00:00";
            if($pauzaStart_2 == '') $pauzaStart_2 = "00:00";
            if($pauzaEnd_2 == '') $pauzaEnd_2 = "00:00";
            if($ukRedovno_2 == '') $ukRedovno_2 = "00:00";
            if($ukPauza_2 == '') $ukPauza_2 = "00:00";
            if($ukNoc_2 == '') $ukNoc_2 = "00:00";
            if($ukNedjelja_2 == '') $ukNedjelja_2 = "00:00";
            if($ukPraznik_2 == '') $ukPraznik_2 = "00:00";
            if($ukupno_2 == '') $ukupno_2 = "00:00";
            
            if($Description == '') $Description = "Jour de congé";
                
        
            ?>
            <input type="hidden" name="DateFrom[]" value="<?=$dateFrom?>">
            <input type="hidden" name="WeekNumber[]" value="<?=$weekNo?>">
            <div class="row pad4px red">
                <div class="col-md-1 blue">
                    <?=$dateFrom?><br>
                    <?=dayToLang( date('l', strtotime($dateFrom)) )?>
                </div>
                <div class="col-md-1">
                    Debut:<br>
                    <input type="text"  class="timepicker w100"  id="startTime_1_<?=$dayOfYear?>" name="startTime_1[]" value="<?=$startTime_1 ?>">
                </div>
                <div class="col-md-1">
                    Fin:<br>
                    <input type="test"  class="timepicker w100" id="endTime_1_<?=$dayOfYear?>" name="endTime_1[]" value="<?=$endTime_1 ?>">
                </div>
                <div class="col-md-6">
                    <br>
                    <input class="w100 xblack-text" type="text" name="Description[]" value="<?=$Description?>">
                    

                    <input type="hidden"  id="pauzaStart_1_<?=$dayOfYear?>" name="pauzaStart_1[]" value="<?=$pauzaStart_1 ?>">

                    <input type="hidden"  id="pauzaEnd_1_<?=$dayOfYear?>" name="pauzaEnd_1[]" value="<?=$pauzaEnd_1 ?>">

                    <input type="hidden" class="ukRedovno<?=$weekNo?>" id="ukRedovno_1_<?=$dayOfYear?>" name="ukRedovno_1[]" value="<?=$ukRedovno_1 ?>">
 
                    <input type="hidden" class="ukPauza<?=$weekNo?>" id="ukPauza_1_<?=$dayOfYear?>" name="ukPauza_1[]" value="<?=$ukPauza_1 ?>">

                    <input type="hidden" class="ukNoc<?=$weekNo?>"  id="ukNoc_1_<?=$dayOfYear?>" name="ukNoc_1[]" value="<?=$ukNoc_1 ?>">

                    <input type="hidden" class="ukNedjelja<?=$weekNo?>"  id="ukNedjelja_1_<?=$dayOfYear?>" name="ukNedjelja_1[]" value="<?=$ukNedjelja_1 ?>">
  
                    <input type="hidden" class="ukPraznik<?=$weekNo?>"  id="ukPraznik_1_<?=$dayOfYear?>" name="ukPraznik_1[]" value="<?=$ukPraznik_1 ?>">

                    <input type="hidden" class="ukupnoDan<?=$weekNo?>" id="ukupno_1_<?=$dayOfYear?>" name="ukupno_1[]" value="<?=$ukupno_2 ?>">
                    
                    
                    <input type="hidden"  id="startTime_2_<?=$dayOfYear?>" name="startTime_2[]" value="<?=$startTime_2 ?>">

                    <input type="hidden"  id="endTime_2_<?=$dayOfYear?>" name="endTime_2[]" value="<?=$endTime_2 ?>">

                    <input type="hidden"  id="pauzaStart_2_<?=$dayOfYear?>" name="pauzaStart_2[]" value="<?=$pauzaStart_2 ?>">

                    <input type="hidden"  id="pauzaEnd_2_<?=$dayOfYear?>" name="pauzaEnd_2[]" value="<?=$pauzaEnd_2 ?>">

                    <input type="hidden" class="ukRedovno<?=$weekNo?>" id="ukRedovno_2_<?=$dayOfYear?>" name="ukRedovno_2[]" value="<?=$ukRedovno_2 ?>">
 
                    <input type="hidden" class="ukPauza<?=$weekNo?>" id="ukPauza_2_<?=$dayOfYear?>" name="ukPauza_2[]" value="<?=$ukPauza_2 ?>">

                    <input type="hidden" class="ukNoc<?=$weekNo?>"  id="ukNoc_2_<?=$dayOfYear?>" name="ukNoc_2[]" value="<?=$ukNoc_2 ?>">

                    <input type="hidden" class="ukNedjelja<?=$weekNo?>"  id="ukNedjelja_2_<?=$dayOfYear?>" name="ukNedjelja_2[]" value="<?=$ukNedjelja_2 ?>">
  
                    <input type="hidden" class="ukPraznik<?=$weekNo?>"  id="ukPraznik_2_<?=$dayOfYear?>" name="ukPraznik_2[]" value="<?=$ukPraznik_2 ?>">

                    <input type="hidden" class="ukupnoDan<?=$weekNo?>" id="ukupno_2_<?=$dayOfYear?>" name="ukupno_2[]" value="<?=$ukupno_2 ?>">
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                </div>
            </div>        
        <?
        }
        
        ###################################################################
        ## KRAJ TJEDNA
        ###################################################################
        if(date('w', strtotime($dateFrom)) == '0' or  $day == $daysInMonth) {
        
            // get previous working hours summary
            $q  = "SELECT * FROM v4_WorkingHours  ";
            $q .= "WHERE SubDriverID  = '" . $SubDriverID . "' ";
            $q .= "AND monthNumber  = '" . $Month . "' ";
            $q .= "AND weekNumber  = '" . $weekNo . "' ";
            $q .= "AND shifts  = '3' ";

            $r = $db->RunQuery($q);

            if($r->num_rows > 0) {
                $w = $r->fetch_object();
                $ukRedovno = $w->ukRedovno;
                $ukPauza = $w->ukPauza;
                $ukNoc = $w->ukNoc;
                $ukNedjelja = $w->ukNedjelja;
                $ukPraznik = $w->ukPraznik;
                $ukupno = $w->ukupno;
            }          
            if($ukRedovno == '') $ukRedovno = "00:00";
            if($ukPauza == '') $ukPauza = "00:00";
            if($ukNoc == '') $ukNoc = "00:00";
            if($ukNedjelja == '') $ukNedjelja = "00:00";
            if($ukPraznik == '') $ukPraznik = "00:00";
            if($ukupno == '') $ukupno = "00:00";       
        
        
        ?>

            <input type="hidden" name="AfterDate[]" value="<?=$dateFrom?>">
            <div class="row pink lighten-4 pad4px">

                <div class="col-md-6 l">TJEDAN <?=date("W", strtotime($dateFrom));?></div>
                <div class="col-md-1">
                    TOT.H.REGULIERES:<br>
                    <input class="w100 ukRedovno_w" id="ukRedovno_w<?=$weekNo?>" name="ukRedovno_w[]" 
				    value="<?=$ukRedovno?>" readonly>
                </div>

                <div class="col-md-1">
                    TOTAL PAUSE:<br>
                    <input class="w100 ukPauza_w" id="ukPauza_w<?=$weekNo?>" name="ukPauza_w[]"
				    value="<?=$ukPauza?>" readonly>
                </div>

                <div class="col-md-1">
                    TOT.H. DE NUIT:<br>
                    <input class="w100 ukNoc_w"  id="ukNoc_w<?=$weekNo?>" name="ukNoc_w[]"
				    value="<?=$ukNoc?>" readonly>
                </div>

                <div class="col-md-1">
                    TOTAL DIMANCHE:<br>
                    <input class="w100 ukNedjelja_w"  id="ukNedjelja_w<?=$weekNo?>" name="ukNedjelja_w[]"
				    value="<?=$ukNedjelja?>" readonly>
                </div>

                <div class="col-md-1">
                    TOTAL JOURS FERIES:<br>
                    <input class="w100 ukPraznik_w"  id="ukPraznik_w<?=$weekNo?>" name="ukPraznik_w[]"
				    value="<?=$ukPraznik?>" readonly>
                </div>

                <div class="col-md-1">
                    TOTAL:<br>
                    <input class="w100 ukupno_w" id="ukupno_w<?=$weekNo?>" name="ukupno_w[]"
				    value="<?=$ukupno?>" readonly>
                </div>
            </div>
        
        
        
        
        <?
        } // end if Sunday
        
    } // end for $day
    

    ###################################################################
    ## KRAJ MJESECA
    ###################################################################
    
    // get previous working hours summary
    $q  = "SELECT * FROM v4_WorkingHours  ";
    $q .= "WHERE SubDriverID  = '" . $SubDriverID . "' ";
    $q .= "AND monthNumber  = '" . $Month . "' ";
    $q .= "AND shifts  = '4' ";

    $r = $db->RunQuery($q);

    if($r->num_rows > 0) {
        $w = $r->fetch_object();
        $ukRedovno = $w->ukRedovno;
        $ukPauza = $w->ukPauza;
        $ukNoc = $w->ukNoc;
        $ukNedjelja = $w->ukNedjelja;
        $ukPraznik = $w->ukPraznik;
        $ukupno = $w->ukupno;
    }      

    if($ukRedovno == '') $ukRedovno = "00:00";
    if($ukPauza == '') $ukPauza = "00:00";
    if($ukNoc == '') $ukNoc = "00:00";
    if($ukNedjelja == '') $ukNedjelja = "00:00";
    if($ukPraznik == '') $ukPraznik = "00:00";
    if($ukupno == '') $ukupno = "00:00";
    
    ?>

    <div class="row xgreen lighten-3 pad4px">
        <div class="col-md-6 l">MJESEC <?=date("m", strtotime($dateFrom));?></div>
        <div class="col-md-1">
            TOT. H. REGULIERES:<br>
            <input class="w100" id="ukRedovno_M" name="ukRedovno_M" value="<?=$ukRedovno?>" readonly>
        </div>

        <div class="col-md-1">
            TOTAL PAUSE:<br>
            <input class="w100" id="ukPauza_M" name="ukPauza_M" value="<?=$ukPauza?>" readonly>
        </div>

        <div class="col-md-1">
            TOT.H. DE NUIT:<br>
            <input class="w100 "  id="ukNoc_M" name="ukNoc_M" value="<?=$ukNoc?>" readonly>
        </div>

        <div class="col-md-1">
            TOTAL DIMANCHE:<br>
            <input class="w100"  id="ukNedjelja_M" name="ukNedjelja_M" value="<?=$ukNedjelja?>" readonly>
        </div>

        <div class="col-md-1">
            TOTAL JOURS FERIES:<br>
            <input class="w100"  id="ukPraznik_M" name="ukPraznik_M" value="<?=$ukPraznik?>" readonly>
        </div>

        <div class="col-md-1">
            TOTAL:<br>
            <input class="w100 ukupno_M" id="ukupno_M" name="ukupno_M" value="<?=$ukupno?>" readonly>
        </div>
    </div>   
    
    <!-- SPREMI ZA KASNIJE -->
    <input type="hidden" name="user" value="<?= $_REQUEST['user']?>">
    <input type="hidden" name="Month" value="<?= $Month?>">
    <input type="hidden" name="Year" value="<?= $Year?>">
    <input type="hidden" name="SubDriverID" value="<?= $SubDriverID?>">
    
    <?
    echo '<br><br>';
    
    echo '<div class="row"><div class="col-md-12">';
    
    echo '<a class="btn xblue l" href="https://www.jamtransfer.com/cms/fr/selector.php?user='.$_REQUEST['user'].'">Back</a>&nbsp;&nbsp;';
    
    echo '<a class="btn xgreen l center" href="https://www.jamtransfer.com/cms/fr/monthlyReport.php?user='.$_REQUEST['user'].
    '&SubDriverID='.$SubDriverID.'&Month='.$Month.'&Year='.$Year.'">Print Report</a>&nbsp;&nbsp;';

    echo '<a class="btn xgreen l center xwhite-text" href="https://www.jamtransfer.com/cms/fr/transfersReport.php?user='.$_REQUEST['user'].
    '&SubDriverID='.$SubDriverID.'&Month='.$Month.'&Year='.$Year.'&submit=yes">Transfers List</a>';
    
    echo '<button class="btn red pull-right l" type="submit" name="Save" value="Save" >Save</button>';
    
    echo '</div></div><br><br><br>';

    echo '</div></form>'; // sve je u formu
  
     

} else { // prikazi input form ?>
    <body>
    <style>
        input, select { width: 200px; }
        #RequiredFrom, #RequiredTo { visibility: hidden; padding-left: 4px; color: red; }
        .formLabel { width: 100px; display: inline-block; }
    </style>

    <div class="container">
        <h1><?= TRANSFER_LIST ?></h1><br><br>

        <form action="" method="post" onsubmit="return validate()">

            <input type="hidden" name="OwnerID" value="<?= $OwnerID ?>">

            <div class="row">
                <div class="formLabel"><?= MONTH ?>:</div>
                <select name="Month">
                    <option value="0">---</option>
                    <?
                        for ($i=1; $i<= 12; $i++) {
                            $month = substr('0'.$i, -2);
                            echo '<option value="'.$month.'">'.$month.'</option>';
                        }
                    ?>
                </select>
            </div>


            <div class="row">
                <div class="formLabel"><?= YEAR ?>:</div>
                <select name="Year">
					<option value="2020">2020</option>				
                    <option value="2019">2019</option>
                    <option value="2018">2018</option>

                </select>
            </div>

            <div class="row">
                <div class="formLabel"><?= DRIVER ?>:</div>
                <select name="SubDriverID" id="SubDriverID">

                    <option value="0"> --- </option>
                    <?

                        $q  = "SELECT AuthUserID, AuthUserRealName FROM v4_AuthUsers ";
                        $q .= "WHERE DriverID = ".$OwnerID." ORDER BY AuthUserRealName ASC";
                        $r  = $db->RunQuery($q);

                        while($driver = $r->fetch_object()) {
                            echo '<option value="'.$driver->AuthUserID.'">';
                            echo $driver->AuthUserRealName.'</option>';
                        }
                    ?>

                </select>
            </div>

            <div class="row">
                <div class="formLabel">Show Hidden:</div><input type="checkbox" name="ShowHidden">
                <br><br>
                <input type="hidden" name="SortSubDriver" id="SortSubDriver" value="0">
                <input type="submit" class="btn btn-primary" name="submit"
                value="<?= SHOW_TRANSFERS ?>" style="margin-left: 105px">
            </div>
            
        </form>
    </div>

<?
}
?>



<script>

    $(".timepicker").JAMTimepicker();
    //$(".timepicker").pickatime({format: 'HH:i', interval: 10});

    function toggleCheck(inputFld) {
        var checked = $("#Detail_"+inputFld).prop("checked");
        if(checked == true) $("#Det_" + inputFld).val('1');
        else $("#Det_" + inputFld).val('0');
    }


    // output fld = changeFld+id
    
    function timeDifference(id, startFld, endFld, changeFld, week) {
        var startTime = $("#"+startFld+id).val();
        var endTime = $("#"+endFld+id).val();
     
        
        var nedjelja = $("#Nedjelja"+id).val();
        var praznik = $("#Praznik"+id).val();

        var satiNedjelja = '00:00';
        var satiPraznik = '00:00';
        
        var dayStart = '05:00';       
        var dayEnd   = '21:00';
        var noc = '00:00';
        
        var redovno = '00:00';
        

        if(changeFld == 'ukRedovno_') {
	        //slucajevi: 
		    //			--------POCETAK U NOCNIM SATIMA----------------

		    //			pocetak od 00:00-06:00 a kraj u dnevnim satima ok
		    if(startTime >= '00:00' && startTime < dayStart && endTime <= dayEnd && endTime >= dayStart) {
		        noc = timeDiff(dayStart, startTime);
		        //alert('pocetak od 00:00-06:00 a kraj u dnevnim satima ' + noc);
		    }
		    
		    
		    //			pocetak od 21:00-00:00 a kraj u dnevnim satima - javi ERROR
		    if(startTime >= dayEnd && startTime < '23:59' && endTime <= dayEnd && endTime >= dayStart) {
		        ////alert('pocetak od 21:00-00:00 a kraj u dnevnim satima');
		    }
		    
		    //			--------KRAJ U NOCNIM SATIMA-------------------
		    //			pocetak u dnevnim a kraj od 21:00-00:00 ok
		    if(startTime >= dayStart && startTime < dayEnd && endTime > dayEnd && endTime <= '23:59') {
		        noc = timeDiff(endTime, dayEnd);
		        //alert('pocetak u dnevnim a kraj od 21:00-00:00 '+noc);
		    }

		    //			pocetak u dnevnima a kraj od 00:00-06:00 - ERROR
		    if(startTime >= dayStart && startTime <= dayEnd && endTime <= dayStart && endTime > '00:00') {
		        ////alert('pocetak u dnevnima a kraj od 00:00-06:00');
		    }

		    //			--------POCETAK I KRAJ U NOCNIM SATIMA---------

		    //			pocetak od 00:00-06:00 a kraj od 21:00 do 00:00 ok
		    if(startTime >= '00:00' && startTime < dayStart && endTime > dayEnd && endTime <= '23:59') {
		        var noc1 = timeDiff(dayStart, startTime);
		        var noc2 = timeDiff(endTime, dayEnd);
		        noc = timeAdd(noc1, noc2);
		        
		        //alert('pocetak od 00:00-06:00 a kraj od 21:00 do 00:00 '+ noc);
		    }

		    //			pocetak od 00:00-06:00 a kraj od 00:00 do 06:00 ok
		    if(startTime >= '00:00' && startTime < dayStart && endTime > '00:00' && endTime <= dayStart) {
		        noc = timeDiff(endTime, startTime);

		        //alert('pocetak od 00:00-06:00 a kraj od 00:00 do 06:00 ' + noc);
		    }

		    //			pocetak od 21:00-00:00 a kraj od 21:00 do 00:00 ok
		    if(startTime >= dayEnd && startTime < '23:59' && endTime > dayEnd && endTime <= '23:59') {
		        noc = timeDiff(endTime, startTime);
		        //alert('pocetak od 21:00-00:00 a kraj od 21:00 do 00:00 ' + noc);
		    }

		    //			pocetak od 21:00-00:00 a kraj od 00:00 do 06:00 -ERROR
		    if(startTime >= dayEnd && startTime < '23:59' && endTime > '00:00' && endTime <= dayStart) {
		        ////alert('pocetak od 21:00-00:00 a kraj od 00:00 do 06:00');
		    }

            redovno = timeDiff(endTime, startTime); 
            // NEDJELJA
            if(nedjelja == '1') {
                satiNedjelja = redovno;
                redovno = '00:00';
                $("#ukNedjelja_"+id).val(satiNedjelja);      
            }

            // PRAZNIK
            if(praznik == '1') {
                satiPraznik = redovno;
                redovno = '00:00';
                $("#ukPraznik_"+id).val(satiPraznik);      
            }


            // ako nije nedjelja ili praznik upisuje se noc. inace NE
            if(nedjelja == 0 && praznik == 0) {
                // NOC
                $("#ukNoc_"+id).val(noc);
                var razlika = timeDiff(startTime, endTime);
                redovno = timeDiff(razlika, noc);            
            }

            $("#ukRedovno_"+id).val(redovno);

        } else { // sva ostala polja
            var razlika = timeDiff(startTime, endTime);
            $("#"+changeFld+id).val(razlika);        
        }

        timeTotal(id, week);
    }
    


    function timeDiff(startTime, endTime) {

        var startDate = new Date("January 1, 1970 " + startTime);
        var endDate = new Date("January 1, 1970 " + endTime);
        var timeDiff = Math.abs(startDate - endDate);

        var hh = Math.floor(timeDiff / 1000 / 60 / 60);
        if(hh < 10) {
            hh = '0' + hh;
        }
        timeDiff -= hh * 1000 * 60 * 60;
        var mm = Math.floor(timeDiff / 1000 / 60);
        if(mm < 10) {
            mm = '0' + mm;
        }
        timeDiff -= mm * 1000 * 60;
        var ss = Math.floor(timeDiff / 1000);
        if(ss < 10) {
            ss = '0' + ss;
        }
        return hh + ":" + mm;
        
    }



    function timeAdd(time1, time2) {
        var splitTime1= time1.split(':');
        var splitTime2= time2.split(':');


        hour = parseInt(splitTime1[0])+parseInt(splitTime2[0]);
        minute = parseInt(splitTime1[1])+parseInt(splitTime2[1]);
        hour = hour + minute/60;

        hour = Math.abs(hour);
        minute = Math.abs(minute);

        return parseInt(hour).pad(2) + ":" + parseInt(minute).pad(2) ;    
    }



    function timeTotal(id, week) {

        
        var redovno     = $("#ukRedovno_"+id).val();
        var pauza       = $("#ukPauza_"+id).val();
        var nedjelja    = $("#ukNedjelja_"+id).val();
        var noc         = $("#ukNoc_"+id).val();
        var praznik     = $("#ukPraznik_"+id).val();

        var hour=0;
        var minute=0;
        var second=0;

        /* ovo mozda i radi!!! maknuto radi sumnje da djeluje na krivo racunanje sati
            TODO: testirati pa eventualno vratiti
            
        if(redovno == '') redovno = '00:00';
        if(pauza == '') pauza = '00:00';
        if(noc == '') noc = '00:00';
        if(nedjelja == '') nedjelja = '00:00';
        if(praznik == '') praznik = '00:00';
        */
        var splitTime1= redovno.split(':');
        var splitTime2= pauza.split(':');
        var splitTime3= nedjelja.split(':');
        var splitTime4= noc.split(':');
        var splitTime5= praznik.split(':');


        hour = parseInt(splitTime1[0])-parseInt(splitTime2[0])+parseInt(splitTime3[0])+parseInt(splitTime4[0])+parseInt(splitTime5[0]);
        minute = parseInt(splitTime1[1])-parseInt(splitTime2[1])+parseInt(splitTime3[1])+parseInt(splitTime4[1])+parseInt(splitTime5[1]);
        hour = hour + Math.floor(minute/60);
        if(minute < 0) {
            minute += 60; 
        }
        minute = Math.abs(minute%60);

        $("#ukupno_"+id).val( parseInt(hour) + ":" + parseInt(minute).pad(2) );


        
        // Ukupno redovno
        var ukupnoRedovnoTjedan = '00:00';
        $('.ukRedovno'+week).each(function(index, item) {
            var itemTime = $(item).val();    
            if(itemTime == '') itemTime = '00:00';
            
            ukupnoRedovnoTjedan = timeCalc(ukupnoRedovnoTjedan, itemTime );

        });
        $("#ukRedovno_w"+week).val(ukupnoRedovnoTjedan);

        var ukupnoRedovnoMjesec = '00:00';
        $('.ukRedovno_w').each(function(index, item) {
            var itemTime = $(item).val();    
            if(itemTime == '') itemTime = '00:00';
            ukupnoRedovnoMjesec = timeCalc(ukupnoRedovnoMjesec, itemTime );
        });
        $("#ukRedovno_M").val(ukupnoRedovnoMjesec);


		//Ukupno pauza
		var ukupnoPauzaTjedan = '00:00';
        $('.ukPauza'+week).each(function(index, item) {
            var itemTime = $(item).val();    
            if(itemTime == '') itemTime = '00:00';
            ukupnoPauzaTjedan = timeCalc(ukupnoPauzaTjedan, itemTime );
        });
        $("#ukPauza_w"+week).val(ukupnoPauzaTjedan);

        var ukupnoPauzaMjesec = '00:00';
        $('.ukPauza_w').each(function(index, item) {
            var itemTime = $(item).val();    
            if(itemTime == '') itemTime = '00:00';
            ukupnoPauzaMjesec = timeCalc(ukupnoPauzaMjesec, itemTime );
        });
        $("#ukPauza_M").val(ukupnoPauzaMjesec);

		//Ukupno noc
		var ukupnoNocTjedan = '00:00';
        $('.ukNoc'+week).each(function(index, item) {
            var itemTime = $(item).val();    
            if(itemTime == '') itemTime = '00:00';
            ukupnoNocTjedan = timeCalc(ukupnoNocTjedan, itemTime );
        });
        $("#ukNoc_w"+week).val(ukupnoNocTjedan);

        var ukupnoNocMjesec = '00:00';
        $('.ukNoc_w').each(function(index, item) {
            var itemTime = $(item).val();    
            if(itemTime == '') itemTime = '00:00';
            ukupnoNocMjesec = timeCalc(ukupnoNocMjesec, itemTime );
        });
        $("#ukNoc_M").val(ukupnoNocMjesec);


		//Ukupno nedjelja
		var ukupnoNedjeljaTjedan = '00:00';
        $('.ukNedjelja'+week).each(function(index, item) {
            var itemTime = $(item).val();    
            if(itemTime == '') itemTime = '00:00';
            ukupnoNedjeljaTjedan = timeCalc(ukupnoNedjeljaTjedan, itemTime );
        });
        $("#ukNedjelja_w"+week).val(ukupnoNedjeljaTjedan);

        var ukupnoNedjeljaMjesec = '00:00';
        $('.ukNedjelja_w').each(function(index, item) {
            var itemTime = $(item).val();    
            if(itemTime == '') itemTime = '00:00';
            ukupnoNedjeljaMjesec = timeCalc(ukupnoNedjeljaMjesec, itemTime );
        });
        $("#ukNedjelja_M").val(ukupnoNedjeljaMjesec);


		//Ukupno praznik
		var ukupnoPraznikTjedan = '00:00';
        $('.ukPraznik'+week).each(function(index, item) {
            var itemTime = $(item).val();    
            if(itemTime == '') itemTime = '00:00';
            ukupnoPraznikTjedan = timeCalc(ukupnoPraznikTjedan, itemTime );
        });
        $("#ukPraznik_w"+week).val(ukupnoPraznikTjedan);

        var ukupnoPraznikMjesec = '00:00';
        $('.ukPraznik_w').each(function(index, item) {
            var itemTime = $(item).val();    
            if(itemTime == '') itemTime = '00:00';
            ukupnoPraznikMjesec = timeCalc(ukupnoPraznikMjesec, itemTime );
        });
        $("#ukPraznik_M").val(ukupnoPraznikMjesec);


		//Ukupno
		var ukupnoTjedan = '00:00';
        $('.ukupnoDan'+week).each(function(index, item) {
            var itemTime = $(item).val();    
            if(itemTime == '') itemTime = '00:00';
            ukupnoTjedan = timeCalc(ukupnoTjedan, itemTime );
        });
        $("#ukupno_w"+week).val(ukupnoTjedan);

        var ukupnoMjesec = '00:00';
        $('.ukupno_w').each(function(index, item) {
            var itemTime = $(item).val();    
            if(itemTime == '') itemTime = '00:00';
            ukupnoMjesec = timeCalc(ukupnoMjesec, itemTime );
        });
        $("#ukupno_M").val(ukupnoMjesec);


    }


    function timeCalc(time1, time2) {
        var hour=0;
        var minute=0;
        var second=0;



        var splitTime1= time1.split(':');
        var splitTime2= time2.split(':');



        hour = parseInt(splitTime1[0])+parseInt(splitTime2[0]);
        minute = parseInt(splitTime1[1])+parseInt(splitTime2[1]);
        hour = hour + Math.floor(minute/60);

        hour = Math.abs(hour);
        minute = Math.abs(minute%60);

        return parseInt(hour).pad(2) + ":" + parseInt(minute).pad(2);
    }


    // hours and minutes padding with zeroes
    Number.prototype.pad = function(size) {
      var s = String(this);
      while (s.length < (size || 2)) {s = "0" + s;}
      return s;
    }
    
    
<?
    // kreiranje poziva funkcija za recalc nakon ucitavanja skripte


    $daysInMonth = days_in_month($Month, $Year);


    for($day = 1; $day <= $daysInMonth; $day++) {
        
        $dayTemp = '0'.$day;
        $day = substr($dayTemp, -2);
        
        // construct date
        $dateFrom = $Year.'-'.$Month.'-'.$day;        

        $dayOfYear = date("z", strtotime($dateFrom)) +1;

        $weekNo = date("W", strtotime($dateFrom));
        $dayOfWeek = date("l", strtotime($dateFrom));

        // ovo ispod su javascript funkcije koje ce se izvrsiti svaki put kad se stranica ucita!!!
?>

        timeDifference('1_<?=$dayOfYear?>', 'startTime_', 'endTime_', 'ukRedovno_','<?=$weekNo?>');
        timeDifference('2_<?=$dayOfYear?>', 'startTime_', 'endTime_', 'ukRedovno_','<?=$weekNo?>');

        timeDifference('1_<?=$dayOfYear?>', 'pauzaStart_', 'pauzaEnd_', 'ukPauza_','<?=$weekNo?>');
        timeDifference('2_<?=$dayOfYear?>', 'pauzaStart_', 'pauzaEnd_', 'ukPauza_','<?=$weekNo?>');
<?
    }

?>
    
    
    
</script>


</body>
</html>

<?
function dayToLang($day) {
    $daysFR = array(
        'Sunday' => 'Dimanche',
        'Monday' => 'Lundi',
        'Tuesday' => 'Mardi',
        'Wednesday' => 'Mercredi',
        'Thursday' => 'Jeudi',
        'Friday' => 'Vendredi',
        'Saturday' => 'Samedi'
    );
    
    return $daysFR[$day];
}


function prazniciFR($date) {
    $prazniciFR = array(
        '2018-01-01',
        '2018-04-02',
        '2018-05-01',
        '2018-05-08',
        '2018-05-10',
        '2018-05-21',
        '2018-07-14',
        '2018-08-15',
        '2018-11-01',
        '2018-11-11',
        '2018-12-25'
    );
    
    if( in_array($date, $prazniciFR)) return true;
    else return false;
}


                
/*
                ###################################################################
                ## PRIJENOS IZ PROSLOG MJESECA AKO NIJE BIO KRAJ TJEDNA
                ###################################################################
                if(date('w', strtotime($dateFrom)) != '1' and  $day == '1' and $prijenosIzProslogMjeseca === true) {
                    
                    $PrevMonth = substr('0'.$Month-1,-2);
                    
                    // get previous working hours summary
                    $q  = "SELECT * FROM v4_WorkingHours  ";
                    $q .= "WHERE SubDriverID  = '" . $SubDriverID . "' ";
                    $q .= "AND monthNumber  = '" . $PrevMonth . "' ";
                    $q .= "AND weekNumber  = '" . $weekNo . "' ";
                    $q .= "AND shifts  = '3' ";

                    $r = $db->RunQuery($q);

                    if($r->num_rows > 0) {
                        $w = $r->fetch_object();
		                $ukRedovno = $w->ukRedovno;
                        $ukPauza = $w->ukPauza;
                        $ukNoc = $w->ukNoc;
                        $ukNedjelja = $w->ukNedjelja;
                        $ukPraznik = $w->ukPraznik;
                        $ukupno = $w->ukupno;
                    }                    
                    if($ukRedovno == '') $ukRedovno = "00:00";
                    if($ukPauza == '') $ukPauza = "00:00";
                    if($ukNoc == '') $ukNoc = "00:00";
                    if($ukNedjelja == '') $ukNedjelja = "00:00";
                    if($ukPraznik == '') $ukPraznik = "00:00";
                    if($ukupno == '') $ukupno = "00:00";   
                    ?>

                    <div class="row pink lighten-3 pad4px">

                        <div class="col-md-6 l">Prijenos iz prošlog mjeseca za ovaj tjedan</div>
                        <div class="col-md-1">
                            TOT. H. REGULIERES:<br>
                            <input class="w100 ukRedovno_w ukRedovno<?=$weekNo?>" value="<?=$ukRedovno?>" readonly>
                        </div>

                        <div class="col-md-1">
                            TOTAL PAUSE:<br>
                            <input class="w100 ukPauza_w ukPauza<?=$weekNo?>" value="<?=$ukPauza?>" readonly>
                        </div>

                        <div class="col-md-1">
                            TOTAL HEURES DE NUIT:<br>
                            <input class="w100 ukNoc_w ukNoc<?=$weekNo?>" value="<?=$ukNoc?>" readonly>
                        </div>

                        <div class="col-md-1">
                            TOTAL DIMANCHE:<br>
                            <input class="w100 ukNedjelja_w ukNedjelja<?=$weekNo?>" value="<?=$ukNedjelja?>" readonly>
                        </div>

                        <div class="col-md-1">
                            TOTAL JOURS FERIES:<br>
                            <input class="w100 ukPraznik_w ukPraznik<?=$weekNo?>" value="<?=$ukPraznik?>" readonly>
                        </div>

                        <div class="col-md-1">
                            TOTAL:<br>
                            <input class="w100 ukupno_w ukupnoDan<?=$weekNo?>" value="<?=$ukupno?>" readonly>
                        </div>
                    </div>
                
                
                
                
                    <?
                    $prijenosIzProslogMjeseca = false;
                } // end prijenosIzProslogMjeseca
*/
