<?
// LANGUAGES
if ( isset($_SESSION['CMSLang']) and $_SESSION['CMSLang'] != '') {
    $languageFile = 'lng/' . $_SESSION['CMSLang'] . '_text.php';
    if ( file_exists( $languageFile) ) require_once $languageFile;
    else {
        $_SESSION['CMSLang'] = 'en';
        require_once ROOT .'/cms/lng/en_text.php';
    }
} else {
    $_SESSION['CMSLang'] = 'en';
    require_once ROOT .'/cms/lng/en_text.php';
}
// END OF LANGUAGES

require './headerScripts.php';
require_once ROOT . '/db/db.class.php';
require_once ROOT . '/f2/f.php';
require_once ROOT . '/db/v4_OrdersMaster.class.php';
require_once ROOT . '/db/v4_OrderDetailsFR.class.php';

$db = new DataBaseMysql();
$om = new v4_OrdersMaster();
$od = new v4_OrderDetailsFR();

$ShowHidden = '0';
if(isset($_REQUEST['ShowHidden'])) $ShowHidden = $_REQUEST['ShowHidden'];

// lyon 876 nica 843

if(isset($_REQUEST['user']) and $_REQUEST['user'] != '') {
    if($_REQUEST['user'] == 'lyon') $OwnerID = '876';
    if($_REQUEST['user'] == 'nica') $OwnerID = '843';
}

//$OwnerID = '843'; // $_SESSION['OwnerID']

$dateFrom = $_REQUEST['DateFrom'];
$dateTo = $_REQUEST['DateTo'];
//$dateTo = $_REQUEST['DateFrom'];

//echo '<pre>';print_r($_REQUEST);echo '</pre>';

// prethodni ponedjeljak
//$testdate = date("Y-m-d",strtotime('last monday', strtotime('2018-05-01')) );

// dan u tjednu 0=nedjelja 1=ponedjeljak
//echo date('w', strtotime($testdate));
// redni broj dana u godini
//echo date('z', strtotime($testdate)) +1;

if( isset($_REQUEST['submit']) or isset($_REQUEST['Save']) ) {

    if(isset($_REQUEST['Save'])) {

        foreach($_REQUEST['SummaryDate'] as $key => $value) {
            if($_REQUEST['startTime_1'][$key] != '00:00' and $_REQUEST['startTime_1'][$key] != 'Array') {
                $forDate = $_REQUEST['SummaryDate'][$key];
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

                $q  = "REPLACE INTO v4_WorkingHours ";
                $q .= "(SubDriverID, forDate, shifts, startTime, endTime, pauzaStart, pauzaEnd, ukRedovno, ukPauza, ukNoc, ukNedjelja, ukPraznik, ukupno) ";
                $q .= "VALUES ('" . $_REQUEST['SubDriverID']."', '" .$forDate ."', '1' , '".$startTime ."', '" .$endTime ."',
                '" .$pauzaStart ."', '" .$pauzaEnd ."', '" .$ukRedovno ."', '" .$ukPauza ."', '" .$ukNoc ."', '" .$ukNedjelja ."',
                '" .$ukPraznik ."', '" .$ukupno . "') ";

                $db->RunQuery($q);
            }
        }


        foreach($_REQUEST['SummaryDate'] as $key => $value) {
            if($_REQUEST['startTime_2'][$key] != '00:00' and $_REQUEST['startTime_1'][$key] != 'Array') {
                $forDate = $_REQUEST['SummaryDate'][$key];
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

                $q  = "REPLACE INTO v4_WorkingHours ";
                $q .= "(SubDriverID, forDate, shifts, startTime, endTime, pauzaStart, pauzaEnd, ukRedovno, ukPauza, ukNoc, ukNedjelja, ukPraznik, ukupno) ";
                $q .= "VALUES ('" . $_REQUEST['SubDriverID']."', '" .$forDate ."', '2' , '".$startTime ."', '" .$endTime ."',
                '" .$pauzaStart ."', '" .$pauzaEnd ."', '" .$ukRedovno ."', '" .$ukPauza ."', '" .$ukNoc ."', '" .$ukNedjelja ."',
                '" .$ukPraznik ."', '" .$ukupno . "') ";

                $db->RunQuery($q);
            }
        }



/*
        if($_REQUEST['startTime_1'] != 0) {

            $forDate = $dateFrom;
            $startTime = $_REQUEST['startTime_1'];
            $endTime = $_REQUEST['endTime_1'];
            $pauzaStart = $_REQUEST['pauzaStart_1'];
            $pauzaEnd = $_REQUEST['pauzaEnd_1'];
            $ukRedovno = $_REQUEST['ukRedovno_1'];
            $ukPauza = $_REQUEST['ukPauza_1'];
            $ukNoc = $_REQUEST['ukNoc_1'];
            $ukNedjelja = $_REQUEST['ukNedjelja_1'];
            $ukPraznik = $_REQUEST['ukPraznik_1'];
            $ukupno = $_REQUEST['ukupno_1'];

            $q  = "REPLACE INTO v4_WorkingHours ";
            $q .= "(SubDriverID, forDate, shifts, startTime, endTime, pauzaStart, pauzaEnd, ukRedovno, ukPauza, ukNoc, ukNedjelja, ukPraznik, ukupno) ";
            $q .= "VALUES ('" . $_REQUEST['SubDriverID']."', '" .$forDate ."', '1' , '".$startTime ."', '" .$endTime ."', '" .$pauzaStart ."', '" .$pauzaEnd ."',
                           '" .$ukRedovno ."', '" .$ukPauza ."', '" .$ukNoc ."', '" .$ukNedjelja ."', '" .$ukPraznik ."', '" .$ukupno . "') ";

            $db->RunQuery($q);

        }
        // else izbrisi ako je startTime 0

        if($_REQUEST['startTime_2'] != 0) {

            $forDate = $dateFrom;
            $startTime = $_REQUEST['startTime_2'];
            $endTime = $_REQUEST['endTime_2'];
            $pauzaStart = $_REQUEST['pauzaStart_2'];
            $pauzaEnd = $_REQUEST['pauzaEnd_2'];
            $ukRedovno = $_REQUEST['ukRedovno_2'];
            $ukPauza = $_REQUEST['ukPauza_2'];
            $ukNoc = $_REQUEST['ukNoc_2'];
            $ukNedjelja = $_REQUEST['ukNedjelja_2'];
            $ukPraznik = $_REQUEST['ukPraznik_2'];
            $ukupno = $_REQUEST['ukupno_2'];

            $q  = "REPLACE INTO v4_WorkingHours ";
            $q .= "(SubDriverID, forDate, shifts, startTime, endTime, pauzaStart, pauzaEnd, ukRedovno, ukPauza, ukNoc, ukNedjelja, ukPraznik, ukupno) ";
            $q .= "VALUES ('" . $_REQUEST['SubDriverID']."', '" .$forDate ."', '2' , '".$startTime ."', '" .$endTime ."', '" .$pauzaStart ."', '" .$pauzaEnd ."',
                           '" .$ukRedovno ."', '" .$ukPauza ."', '" .$ukNoc ."', '" .$ukNedjelja ."', '" .$ukPraznik ."', '" .$ukupno . "') ";

            $db->RunQuery($q);

        }
        // else izbrisi ako je startTime 0

        // skupi sve podatke za tjedan i prikazi


        // skupi sve podatke za mjesec i prikazi

*/



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

    }

    //if(isset($_REQUEST['submit']) or isset($_REQUEST['Save'])) {



        $where  = "WHERE PickupDate >= '" . $dateFrom . "' ";
        $where .= "AND PickupDate <= '" . $dateTo . "' ";
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

        $where3 = " ORDER BY PickupTime ASC";

        if($ShowHidden) $odk = $od->getKeysBy("PickupDate", "ASC, PickupTime ASC", $where.$where3);
        else $odk = $od->getKeysBy("PickupDate", "ASC, PickupTime ASC", $where.$where2);

        if($ShowHidden) $odk2 = $od->getKeysBy("PickupDate", "ASC, PickupTime ASC",  $where.$where2);

        if( count($odk) > 0 ) {

            echo '<body class="grey lighten-2" style="font-size:11px;">';
            echo '<form action="" method="POST">';
            echo '<br><div class="center"><h1>Driver Transfers List</h1><h3>' . $sd->AuthUserRealName . '</h3>';
            echo $_REQUEST['DateFrom'] . ' - ' . $_REQUEST['DateTo'];

            if ($ShowHidden) echo ' (' . count($odk2) . '/' . count($odk) . ' transfers)';
            else echo ' (' . count($odk) . ' transfers)';
            
            echo '<br><button class="btn btn-default" onclick="$(\'.noPrint\').toggle(\'slow\');return false;">Show / Hide details</button>';

            echo '</div><br><br>';
            echo '<div class="container-fluid white pad4px">';

            echo '<input type="hidden" id="shifts" name="shifts" value="0">';
            echo '<input type="hidden" id="shift1id" name="shift1id" value="0">';
            echo '<input type="hidden" id="shift2id" name="shift2id" value="0">';

            $prevDate = $dateFrom;
            $weekNo = 0;

            #########################################################################
            ## LISTA
            #########################################################################
            foreach( $odk as $nn => $DetailsID ) {

                $dayOfYear = date("z", strtotime($prevDate)) +1;
                $weekNo = date("W", strtotime($od->PickupDate));

                $od->getRow($DetailsID);
                $om->getRow($od->OrderID);


                if($od->PayNow > 0 and $od->PayLater == 0) $icon = '<i class="fa fa-credit-card fa-2x"></i>';
                if($od->PayNow == 0 and $od->PayLater > 0) $icon = '<i class="fa fa-money fa-2x xblue-text"></i>';
                if($od->PayNow == 0 and $od->PayLater == 0 and $od->InvoiceAmount > 0) $icon = '<i class="fa fa-user fa-2x"></i>';

                $sd = getUser($od->SubDriver);
                if($od->SubDriver2 != '') $sd2 = getUser($od->SubDriver2);
                if($od->SubDriver3 != '') $sd3 = getUser($od->SubDriver3);
                // oznaci izbrisane, tj. skrivene - Expired = 1
                $colorClass = "white";
                if($od->Expired) $colorClass = "pink lighten-5";

                // spremi vrijednosti za poslije submita
                ?>
                <input type="hidden" name="SubDriverID" value="<?= $_REQUEST['SubDriverID'] ?>">
                <input type="hidden" name="DateFrom" value="<?= $_REQUEST['DateFrom'] ?>">
                <input type="hidden" name="DateTo" value="<?= $_REQUEST['DateTo']?>">
                <input type="hidden" name="OwnerID" value="<?= $OwnerID ?>">
                <input type="hidden" name="Counter" id="Counter" value="<?= $i ?>">

                <?

                // SUMMARY ZA PRETHODNI DAN

                if($prevDate != $od->PickupDate) {


                    // SMJENA 1
                    // get previous working hours summary
                    $q  = "SELECT * FROM v4_WorkingHours  ";
                    $q .= "WHERE SubDriverID  = '" . $_REQUEST['SubDriverID'] . "' ";
                    $q .= "AND forDate  = '" . $prevDate . "' ";
                    $q .= "AND shifts  = '1' ";

                    $r = $db->RunQuery($q);

                    $startTime_1 = "00:00";
                    $endTime_1 = "00:00";
                    $pauzaStart_1 = "00:00";
                    $pauzaEnd_1 = "00:00";
					$ukRedovno_1 = "00:00";
                    $ukPauza_1 = "00:00";
                    $ukNoc_1 = "00:00";
                    $ukNedjelja_1 = "00:00";
                    $ukPraznik_1 = "00:00";
                    $ukupno_1 = "00:00";


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
                    }

                    ?>

                            <input type="hidden" name="SummaryDate[]" value="<?=$prevDate?>">
                            <input type="hidden" name="SummaryNoOfWeek[]" value="<?=$weekNo?>">

                            <div class="row pad4px grey lighten-3" id="Smjena_1_<?=$dayOfYear?>" xstyle="display:none">

                                <div class="col-md-1">
                                    <?=$prevDate?>
                                </div>
                                <div class="col-md-1">
                                    <?=date('l', strtotime($prevDate))?><br>
                                    Smjena 1
                                </div>
                                <div class="col-md-1">
                                    Početak:<br>
                                    <input class="timepicker w100" id="startTime_1_<?=$dayOfYear?>" name="startTime_1[]" value="<?=$startTime_1?>"
                                    onchange="timeDifference('1_<?=$dayOfYear?>', 'startTime_', 'endTime_', 'ukRedovno_','<?=$weekNo?>');">
                                </div>

                                <div class="col-md-1">
                                    Kraj:<br>
                                    <input class="timepicker w100" id="endTime_1_<?=$dayOfYear?>" name="endTime_1[]" value="<?=$endTime_1?>"
                                    onchange="timeDifference('1_<?=$dayOfYear?>', 'startTime_', 'endTime_', 'ukRedovno_','<?=$weekNo?>');">
                                </div>

                                <div class="col-md-1">
                                    Pauza početak:<br>
                                    <input class="timepicker w100"  id="pauzaStart_1_<?=$dayOfYear?>" name="pauzaStart_1[]" value="<?=$pauzaStart_1?>"
                                    onchange="timeDifference('1_<?=$dayOfYear?>', 'pauzaStart_', 'pauzaEnd_', 'ukPauza_','<?=$weekNo?>');">
                                </div>

                                <div class="col-md-1">
                                    Pauza kraj:<br>
                                    <input class="timepicker w100"  id="pauzaEnd_1_<?=$dayOfYear?>" name="pauzaEnd_1[]" value="<?=$pauzaEnd_1?>"
                                    onchange="timeDifference('1_<?=$dayOfYear?>', 'pauzaStart_', 'pauzaEnd_', 'ukPauza_','<?=$weekNo?>');">
                                </div>

                                <div class="col-md-1">
                                    Uk.redovno:<br>
                                    <input class="w100 ukRedovno<?=$weekNo?>" id="ukRedovno_1_<?=$dayOfYear?>" name="ukRedovno_1[]" value="<?=$ukRedovno_1?>" 
									onchange="timeTotal('1_<?=$dayOfYear?>','<?=$weekNo?>')" readonly>
                                </div>

                                <div class="col-md-1">
                                    Uk.pauza:<br>
                                    <input class="w100 ukPauza<?=$weekNo?>" id="ukPauza_1_<?=$dayOfYear?>" name="ukPauza_1[]" value="<?=$ukPauza_1?>" 
									onchange="timeTotal('1_<?=$dayOfYear?>','<?=$weekNo?>')" readonly>
                                </div>

                                <div class="col-md-1">
                                    Uk.noć:<br>
                                    <input class="timepicker w100 ukNoc<?=$weekNo?>"  id="ukNoc_1_<?=$dayOfYear?>" name="ukNoc_1[]" value="<?=$ukNoc_1?>" 
									onchange="timeTotal('1_<?=$dayOfYear?>','<?=$weekNo?>')">
                                </div>

                                <div class="col-md-1">
                                    Uk.nedjelja:<br>
                                    <input class="timepicker w100 ukNedjelja<?=$weekNo?>"  id="ukNedjelja_1_<?=$dayOfYear?>" name="ukNedjelja_1[]" value="<?=$ukNedjelja_1?>" 
									onchange="timeTotal('1_<?=$dayOfYear?>','<?=$weekNo?>')">
                                </div>

                                <div class="col-md-1">
                                    Uk.praznik:<br>
                                    <input class="timepicker w100 ukPraznik<?=$weekNo?>"  id="ukPraznik_1_<?=$dayOfYear?>" name="ukPraznik_1[]" value="<?=$ukPraznik_1?>" 
									onchange="timeTotal('1_<?=$dayOfYear?>','<?=$weekNo?>')">
                                </div>

                                <div class="col-md-1">
                                    Ukupno:<br>
                                    <input class="w100 ukupnoDan<?=$weekNo?>" id="ukupno_1_<?=$dayOfYear?>" name="ukupno_1[]" value="<?=$ukupno_1?>" readonly>
                                </div>

                            </div>

                            <?

                            // SMJENA 2

                            // get previous working hours summary
                            $q  = "SELECT * FROM v4_WorkingHours  ";
                            $q .= "WHERE SubDriverID  = '" . $_REQUEST['SubDriverID'] . "' ";
                            $q .= "AND forDate  = '" . $prevDate . "' ";
                            $q .= "AND shifts  = '2' ";

                            $r = $db->RunQuery($q);

				            $startTime_2 = "00:00";
				            $endTime_2 = "00:00";
				            $pauzaStart_2 = "00:00";
				            $pauzaEnd_2 = "00:00";
							$ukRedovno_2 = "00:00";
				            $ukPauza_2 = "00:00";
				            $ukNoc_2 = "00:00";
				            $ukNedjelja_2 = "00:00";
				            $ukPraznik_2 = "00:00";
				            $ukupno_2 = "00:00";


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
                            ?>
                            <div class="row pad4px grey lighten-2" id="Smjena_2_<?=$dayOfYear?>" xstyle="display:none">
                                <div class="col-md-1">
                                    <?=$prevDate?>
                                </div>
                                <div class="col-md-1">
                                    <?=date('l', strtotime($prevDate))?><br>
                                    Smjena 2
                                </div>
                                <div class="col-md-1">
                                    Početak:<br>
                                    <input class="timepicker w100" id="startTime_2_<?=$dayOfYear?>" name="startTime_2[]" value="<?=$startTime_2 ?>"
                                    onchange="timeDifference('2_<?=$dayOfYear?>', 'startTime_', 'endTime_', 'ukRedovno_','<?=$weekNo?>');">
                                </div>

                                <div class="col-md-1">
                                    Kraj:<br>
                                    <input class="timepicker w100" id="endTime_2_<?=$dayOfYear?>" name="endTime_2[]" value="<?=$endTime_2 ?>"
                                    onchange="timeDifference('2_<?=$dayOfYear?>', 'startTime_', 'endTime_', 'ukRedovno_','<?=$weekNo?>');">
                                </div>

                                <div class="col-md-1">
                                    Pauza početak:<br>
                                    <input class="timepicker w100"  id="pauzaStart_2_<?=$dayOfYear?>" name="pauzaStart_2[]" value="<?=$pauzaStart_2 ?>"
                                    onchange="timeDifference('2_<?=$dayOfYear?>', 'pauzaStart_', 'pauzaEnd_', 'ukPauza_','<?=$weekNo?>');">
                                </div>

                                <div class="col-md-1">
                                    Pauza kraj:<br>
                                    <input class="timepicker w100"  id="pauzaEnd_2_<?=$dayOfYear?>" name="pauzaEnd_2[]" value="<?=$pauzaEnd_2 ?>"
                                    onchange="timeDifference('2_<?=$dayOfYear?>', 'pauzaStart_', 'pauzaEnd_', 'ukPauza_','<?=$weekNo?>');">
                                </div>

                                <div class="col-md-1">
                                    Uk.redovno:<br>
                                    <input class="w100 ukRedovno<?=$weekNo?>" id="ukRedovno_2_<?=$dayOfYear?>" name="ukRedovno_2[]" value="<?=$ukRedovno_2 ?>" 
									onchange="timeTotal('2_<?=$dayOfYear?>','<?=$weekNo?>')" readonly>
                                </div>

                                <div class="col-md-1">
                                    Uk.pauza:<br>
                                    <input class="w100 ukPauza<?=$weekNo?>" id="ukPauza_2_<?=$dayOfYear?>" name="ukPauza_2[]" value="<?=$ukPauza_2 ?>"
                                    onchange="timeTotal('2_<?=$dayOfYear?>','<?=$weekNo?>')" readonly>
                                </div>

                                <div class="col-md-1">
                                    Uk.noć:<br>
                                    <input class="timepicker w100 ukNoc<?=$weekNo?>"  id="ukNoc_2_<?=$dayOfYear?>" name="ukNoc_2[]" value="<?=$ukNoc_2 ?>"
                                    onchange="timeTotal('2_<?=$dayOfYear?>','<?=$weekNo?>')">
                                </div>

                                <div class="col-md-1">
                                    Uk.nedjelja:<br>
                                    <input class="timepicker w100 ukNedjelja<?=$weekNo?>"  id="ukNedjelja_2_<?=$dayOfYear?>" name="ukNedjelja_2[]" value="<?=$ukNedjelja_2 ?>"
                                    onchange="timeTotal('2_<?=$dayOfYear?>','<?=$weekNo?>')">
                                </div>

                                <div class="col-md-1">
                                    Uk.praznik:<br>
                                    <input class="timepicker w100 ukPraznik<?=$weekNo?>"  id="ukPraznik_2_<?=$dayOfYear?>" name="ukPraznik_2[]" value="<?=$ukPraznik_2 ?>"
                                    onchange="timeTotal('2_<?=$dayOfYear?>','<?=$weekNo?>')">
                                </div>

                                <div class="col-md-1">
                                    Ukupno:<br>
                                    <input class="w100 ukupnoDan<?=$weekNo?>" id="ukupno_2_<?=$dayOfYear?>" name="ukupno_2[]" value="<?=$ukupno_2 ?>" readonly>
                                </div>

                            </div>



                <?
                            // PODACI ZA TJEDAN
                            $dayOfWeek = date("w", strtotime($od->PickupDate));
                            if($dayOfWeek == 1 ) { ?>
                                <input type="hidden" name="AfterDate[]" value="<?=date("Y-m-d",strtotime('yesterday', strtotime($od->PickupDate)) );?>">
                                <div class="row pink lighten-3 pad4px">
                                    <div class="col-md-6 l">TJEDAN <?=date("W", strtotime($prevDate));?></div>
                                    <div class="col-md-1">
                                        Uk.redovno:<br>
                                        <input class="w100 ukRedovno_w" id="ukRedovno_w<?=$weekNo?>" name="ukRedovno_w[]" 
										value="00:00" readonly>
                                    </div>

                                    <div class="col-md-1">
                                        Uk.pauza:<br>
                                        <input class="w100 ukPauza_w" id="ukPauza_w<?=$weekNo?>" name="ukPauza_w[]" 
										value="00:00" readonly>
                                    </div>

                                    <div class="col-md-1">
                                        Uk.noć:<br>
                                        <input class="timepicker w100 ukNoc_w"  id="ukNoc_w<?=$weekNo?>" name="ukNoc_w[]" 
										value="00:00" readonly>
                                    </div>

                                    <div class="col-md-1">
                                        Uk.nedjelja:<br>
                                        <input class="timepicker w100 ukNedjelja_w"  id="ukNedjelja_w<?=$weekNo?>" name="ukNedjelja_w[]" 
										value="00:00" readonly>
                                    </div>

                                    <div class="col-md-1">
                                        Uk.praznik:<br>
                                        <input class="timepicker w100 ukPraznik_w"  id="ukPraznik_w<?=$weekNo?>" name="ukPraznik_w[]" 
										value="00:00" readonly>
                                    </div>

                                    <div class="col-md-1">
                                        Ukupno:<br>
                                        <input class="w100 ukupno_w" id="ukupno_w<?=$weekNo?>" name="ukupno_w[]" 
										value="00:00" readonly>
                                    </div>
                                </div>


                            <?

                            }
                            $prevDate = $od->PickupDate;
                } // end prevDate - podaci za dan





                ?>
                <!-- PODACI O TRANSFERU -->

                <div class="row pad4px <?=$colorClass?> noPrint" style="border-top: 1px solid #ccc">
                    <div class="col-md-1">
                        <?= $icon ?><br>
                        <?=date("l", strtotime($od->PickupDate));?>
                    </div>
                    <div class="col-md-2">
                        <?= $od->PickupTime ?> - <?= $od->PickupDate ?><br>
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


            } // KRAJ LISTE
        }


        ###################################################################
        ## ZADNJI DAN/TJEDAN U MJESECU
        ###################################################################


        // get previous working hours summary
        $q  = "SELECT * FROM v4_WorkingHours  ";
        $q .= "WHERE SubDriverID  = '" . $_REQUEST['SubDriverID'] . "' ";
        $q .= "AND forDate  = '" . $dateFrom . "' ";
        $q .= "AND shifts  = '1' ";

        $r = $db->RunQuery($q);

        $startTime_1 = "00:00";
        $endTime_1 = "00:00";
        $pauzaStart_1 = "00:00";
        $pauzaEnd_1 = "00:00";
		$ukRedovno_1 = "00:00";
        $ukPauza_1 = "00:00";
        $ukNoc_1 = "00:00";
        $ukNedjelja_1 = "00:00";
        $ukPraznik_1 = "00:00";
        $ukupno_1 = "00:00";


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
        }

        ?>

        <input type="hidden" name="SummaryDate[]" value="<?=$prevDate?>">
        <input type="hidden" name="SummaryNoOfWeek[]" value="<?=$weekNo?>">

        <div class="row pad4px grey lighten-3" id="Smjena_1_<?=$dayOfYear?>" xstyle="display:none">

            <div class="col-md-1">
                <?=$prevDate?>
            </div>
            <div class="col-md-1">
                <?=date('l', strtotime($prevDate))?><br>
                Smjena 1
            </div>
            <div class="col-md-1">
                Početak:<br>
                <input class="timepicker w100" id="startTime_1_<?=$dayOfYear?>" name="startTime_1[]" value="<?=$startTime_1?>"
                onchange="timeDifference('1_<?=$dayOfYear?>', 'startTime_', 'endTime_', 'ukRedovno_','<?=$weekNo?>');">
            </div>

            <div class="col-md-1">
                Kraj:<br>
                <input class="timepicker w100" id="endTime_1_<?=$dayOfYear?>" name="endTime_1[]" value="<?=$endTime_1?>"
                onchange="timeDifference('1_<?=$dayOfYear?>', 'startTime_', 'endTime_', 'ukRedovno_','<?=$weekNo?>');">
            </div>

            <div class="col-md-1">
                Pauza početak:<br>
                <input class="timepicker w100"  id="pauzaStart_1_<?=$dayOfYear?>" name="pauzaStart_1[]" value="<?=$pauzaStart_1?>"
                onchange="timeDifference('1_<?=$dayOfYear?>', 'pauzaStart_', 'pauzaEnd_', 'ukPauza_','<?=$weekNo?>');">
            </div>

            <div class="col-md-1">
                Pauza kraj:<br>
                <input class="timepicker w100"  id="pauzaEnd_1_<?=$dayOfYear?>" name="pauzaEnd_1[]" value="<?=$pauzaEnd_1?>"
                onchange="timeDifference('1_<?=$dayOfYear?>', 'pauzaStart_', 'pauzaEnd_', 'ukPauza_','<?=$weekNo?>');">
            </div>

            <div class="col-md-1">
                Uk.redovno:<br>
                <input class="w100 ukRedovno<?=$weekNo?>" id="ukRedovno_1_<?=$dayOfYear?>" name="ukRedovno_1[]" value="<?=$ukRedovno_1?>" 
				onchange="timeTotal('1_<?=$dayOfYear?>','<?=$weekNo?>')" readonly>
            </div>

            <div class="col-md-1">
                Uk.pauza:<br>
                <input class="w100 ukPauza<?=$weekNo?>" id="ukPauza_1_<?=$dayOfYear?>" name="ukPauza_1[]" value="<?=$ukPauza_1?>" 
				onchange="timeTotal('1_<?=$dayOfYear?>','<?=$weekNo?>')" readonly>
            </div>

            <div class="col-md-1">
                Uk.noć:<br>
                <input class="timepicker w100 ukNoc<?=$weekNo?>"  id="ukNoc_1_<?=$dayOfYear?>" name="ukNoc_1[]" value="<?=$ukNoc_1?>" 
				onchange="timeTotal('1_<?=$dayOfYear?>','<?=$weekNo?>')">
            </div>

            <div class="col-md-1">
                Uk.nedjelja:<br>
                <input class="timepicker w100 ukNedjelja<?=$weekNo?>"  id="ukNedjelja_1_<?=$dayOfYear?>" name="ukNedjelja_1[]" value="<?=$ukNedjelja_1?>" 
				onchange="timeTotal('1_<?=$dayOfYear?>','<?=$weekNo?>')">
            </div>

            <div class="col-md-1">
                Uk.praznik:<br>
                <input class="timepicker w100 ukPraznik<?=$weekNo?>"  id="ukPraznik_1_<?=$dayOfYear?>" name="ukPraznik_1[]" value="<?=$ukPraznik_1?>" 
				onchange="timeTotal('1_<?=$dayOfYear?>','<?=$weekNo?>')">
            </div>

            <div class="col-md-1">
                Ukupno:<br>
                <input class="w100 ukupnoDan<?=$weekNo?>" id="ukupno_1_<?=$dayOfYear?>" name="ukupno_1[]" value="<?=$ukupno_1?>" readonly>
            </div>

        </div>

        <?
        // get previous working hours summary
        $q  = "SELECT * FROM v4_WorkingHours  ";
        $q .= "WHERE SubDriverID  = '" . $_REQUEST['SubDriverID'] . "' ";
        $q .= "AND forDate  = '" . $dateFrom . "' ";
        $q .= "AND shifts  = '2' ";

        $r = $db->RunQuery($q);

        $startTime_2 = "00:00";
        $endTime_2 = "00:00";
        $pauzaStart_2 = "00:00";
        $pauzaEnd_2 = "00:00";
		$ukRedovno_2 = "00:00";
        $ukPauza_2 = "00:00";
        $ukNoc_2 = "00:00";
        $ukNedjelja_2 = "00:00";
        $ukPraznik_2 = "00:00";
        $ukupno_2 = "00:00";


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

        ?>
        <div class="row pad4px grey lighten-2" id="Smjena_2_<?=$dayOfYear?>" xstyle="display:none">
            <div class="col-md-1">
                <?=$prevDate?>
            </div>
            <div class="col-md-1">
                <?=date('l', strtotime($prevDate))?><br>
                Smjena 2
            </div>
            <div class="col-md-1">
                Početak:<br>
                <input class="timepicker w100" id="startTime_2_<?=$dayOfYear?>" name="startTime_2[]" value="<?=$startTime_2 ?>"
                onchange="timeDifference('2_<?=$dayOfYear?>', 'startTime_', 'endTime_', 'ukRedovno_','<?=$weekNo?>');">
            </div>

            <div class="col-md-1">
                Kraj:<br>
                <input class="timepicker w100" id="endTime_2_<?=$dayOfYear?>" name="endTime_2[]" value="<?=$endTime_2 ?>"
                onchange="timeDifference('2_<?=$dayOfYear?>', 'startTime_', 'endTime_', 'ukRedovno_','<?=$weekNo?>');">
            </div>

            <div class="col-md-1">
                Pauza početak:<br>
                <input class="timepicker w100"  id="pauzaStart_2_<?=$dayOfYear?>" name="pauzaStart_2[]" value="<?=$pauzaStart_2 ?>"
                onchange="timeDifference('2_<?=$dayOfYear?>', 'pauzaStart_', 'pauzaEnd_', 'ukPauza_','<?=$weekNo?>');">
            </div>

            <div class="col-md-1">
                Pauza kraj:<br>
                <input class="timepicker w100"  id="pauzaEnd_2_<?=$dayOfYear?>" name="pauzaEnd_2[]" value="<?=$pauzaEnd_2 ?>"
                onchange="timeDifference('2_<?=$dayOfYear?>', 'pauzaStart_', 'pauzaEnd_', 'ukPauza_','<?=$weekNo?>');">
            </div>

            <div class="col-md-1">
                Uk.redovno:<br>
                <input class="w100 ukRedovno<?=$weekNo?>" id="ukRedovno_2_<?=$dayOfYear?>" name="ukRedovno_2[]" value="<?=$ukRedovno_2 ?>" 
				onchange="timeTotal('2_<?=$dayOfYear?>','<?=$weekNo?>')" readonly>
            </div>

            <div class="col-md-1">
                Uk.pauza:<br>
                <input class="w100 ukPauza<?=$weekNo?>" id="ukPauza_2_<?=$dayOfYear?>" name="ukPauza_2[]" value="<?=$ukPauza_2 ?>"
                onchange="timeTotal('2_<?=$dayOfYear?>','<?=$weekNo?>')" readonly>
            </div>

            <div class="col-md-1">
                Uk.noć:<br>
                <input class="timepicker w100 ukNoc<?=$weekNo?>"  id="ukNoc_2_<?=$dayOfYear?>" name="ukNoc_2[]" value="<?=$ukNoc_2 ?>"
                onchange="timeTotal('2_<?=$dayOfYear?>','<?=$weekNo?>')">
            </div>

            <div class="col-md-1">
                Uk.nedjelja:<br>
                <input class="timepicker w100 ukNedjelja<?=$weekNo?>"  id="ukNedjelja_2_<?=$dayOfYear?>" name="ukNedjelja_2[]" value="<?=$ukNedjelja_2 ?>"
                onchange="timeTotal('2_<?=$dayOfYear?>','<?=$weekNo?>')">
            </div>

            <div class="col-md-1">
                Uk.praznik:<br>
                <input class="timepicker w100 ukPraznik<?=$weekNo?>"  id="ukPraznik_2_<?=$dayOfYear?>" name="ukPraznik_2[]" value="<?=$ukPraznik_2 ?>"
                onchange="timeTotal('2_<?=$dayOfYear?>','<?=$weekNo?>')">
            </div>

            <div class="col-md-1">
                Ukupno:<br>
                <input class="w100 ukupnoDan<?=$weekNo?>" id="ukupno_2_<?=$dayOfYear?>" name="ukupno_2[]" value="<?=$ukupno_2 ?>" readonly>
            </div>

        </div>




        <? // PODACI ZA TJEDAN ?>

        <input type="text" name="AfterDate[]" value="<?=$prevDate?>">
        <div class="row pink lighten-3 pad4px">

            <div class="col-md-6 l">TJEDAN <?=date("W", strtotime($prevDate));?></div>
            <div class="col-md-1">
                Uk.redovno:<br>
                <input class="w100 ukRedovno_w" id="ukRedovno_w<?=$weekNo?>" name="ukRedovno_w[]" 
				value="00:00" readonly>
            </div>

            <div class="col-md-1">
                Uk.pauza:<br>
                <input class="w100 ukPauza_w" id="ukPauza_w<?=$weekNo?>" name="ukPauza_w[]"
				value="00:00" readonly>
            </div>

            <div class="col-md-1">
                Uk.noć:<br>
                <input class="timepicker w100 ukNoc_w"  id="ukNoc_w<?=$weekNo?>" name="ukNoc_w[]"
				value="00:00" readonly>
            </div>

            <div class="col-md-1">
                Uk.nedjelja:<br>
                <input class="timepicker w100 ukNedjelja_w"  id="ukNedjelja_w<?=$weekNo?>" name="ukNedjelja_w[]"
				value="00:00" readonly>
            </div>

            <div class="col-md-1">
                Uk.praznik:<br>
                <input class="timepicker w100 ukPraznik_w"  id="ukPraznik_w<?=$weekNo?>" name="ukPraznik_w[]"
				value="00:00" readonly>
            </div>

            <div class="col-md-1">
                Ukupno:<br>
                <input class="w100 ukupno_w" id="ukupno_w<?=$weekNo?>" name="ukupno_w[]"
				value="00:00" readonly>
            </div>
        </div>





        <? // PODACI ZA MJESEC ?>

        <div class="row xgreen pad4px">
            <div class="col-md-6 l">MJESEC <?=date("m", strtotime($prevDate));?></div>
            <div class="col-md-1">
                Uk.redovno:<br>
                <input class="w100" id="ukRedovno_M" name="ukRedovno_M" readonly>
            </div>

            <div class="col-md-1">
                Uk.pauza:<br>
                <input class="w100" id="ukPauza_M" name="ukPauza_M" readonly>
            </div>

            <div class="col-md-1">
                Uk.noć:<br>
                <input class="timepicker w100 "  id="ukNoc_M" name="ukNoc_M" readonly>
            </div>

            <div class="col-md-1">
                Uk.nedjelja:<br>
                <input class="timepicker w100"  id="ukNedjelja_M" name="ukNedjelja_M" readonly>
            </div>

            <div class="col-md-1">
                Uk.praznik:<br>
                <input class="timepicker w100"  id="ukPraznik_M" name="ukPraznik_M" readonly>
            </div>

            <div class="col-md-1">
                Ukupno:<br>
                <input class="w100 ukupno_M" id="ukupno_M" name="ukupno_M" readonly>
            </div>
        </div>





<?
            echo '<br><br>';
            echo '<a class="btn xblue l" href="https://www.jamtransfer.com/cms/fr/selector.php?user='.$_REQUEST['user'].'">Back</a>';
            echo '<button class="btn red pull-right l" type="submit" name="Save" value="Save" onclick="return:false;">Save</button>';
            echo '</div></form>';


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

                <div class="formLabel"><?= DATUM ?>:</div>
                <input id="DateFrom" class="datepicker" name="DateFrom">
                <span id="RequiredFrom"><?= REQUIRED ?></span><br>

               <div class="formLabel"><?= TO ?>:</div>
                <input id="DateTo" class="datepicker" name="DateTo">
                <span id="RequiredTo"><?= REQUIRED ?></span><br>

                <input type="button" class="btn btn-primary" value="Today" style="margin-left: 105px" onclick="setToday()"><br><br>

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
                <span id="RequiredSub"><?= REQUIRED ?></span>
                <br><br>
                <div class="formLabel">Show Hidden:</div><input type="checkbox" name="ShowHidden">
                <br><br>
                <input type="hidden" name="SortSubDriver" id="SortSubDriver" value="0">
                <input type="submit" class="btn btn-primary" name="submit"
                value="<?= SHOW_TRANSFERS ?>" style="margin-left: 105px">
            </form>
        </div>

        <script>
        $(document).ready(function(){
            $(".datepicker").pickadate({format:'yyyy-mm-dd'});

        });


        function setToday() {
            var d = new Date();
            var DateFrom = document.getElementById("DateFrom");
            var DateTo = document.getElementById("DateTo");
            var month = '' + (d.getMonth()+1);
            var day = '' + d.getDate();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;
            DateFrom.value = d.getFullYear() + "-" + month + "-" + day;
            DateTo.value = d.getFullYear() + "-" + month + "-" + day;
        }

        function validate() {
            var DateFrom = document.getElementById("DateFrom");
            var DateTo = document.getElementById("DateTo");
            var SubDriver = document.getElementById("SubDriverID");
            var RequiredFrom = document.getElementById("RequiredFrom");
            var RequiredTo = document.getElementById("RequiredTo");
            var RequiredSubdriver = document.getElementById("RequiredSub");
            var error = 0;

            DateFrom.style.borderColor = "#ddd";
            DateTo.style.borderColor = "#ddd";
            SubDriver.style.borderColor = "#ddd";

            RequiredFrom.style.visibility = "hidden";
            RequiredTo.style.visibility = "hidden";
            RequiredSubdriver.style.visibility = "hidden";

            if (DateFrom.value == "") {
                error = 1;
                DateFrom.style.borderColor = "red";
                RequiredFrom.style.visibility = "visible";
            }

            if (DateTo.value == "") {
                error = 1;
                DateTo.style.borderColor = "red";
                RequiredTo.style.visibility = "visible";
            }

            /*
            if (SubDriver.value == "0") {
                error = 1;
                SubDriver.style.borderColor = "red";
                RequiredSubdriver.style.visibility = "visible";
            }
            */

            if (error == 1) return false;
        }
        </script>

<?
    } // end else

//} // end if save



?>

<script>

    $(".timepicker").JAMTimepicker();
    //$(".timepicker").pickatime({format: 'HH:i', interval: 10});

    function toggleCheck(inputFld) {
        var checked = $("#Detail_"+inputFld).prop("checked");
        if(checked == true) $("#Det_" + inputFld).val('1');
        else $("#Det_" + inputFld).val('0');
    }



    function timeDifference(id, startFld, endFld, changeFld, week) {
        var startTime = $("#"+startFld+id).val();
        var endTime = $("#"+endFld+id).val();

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
        $("#"+changeFld+id).val(hh + ":" + mm);
        timeTotal(id, week);
        //alert("Time Diff- " + hh + ":" + mm + ":" + ss);
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

        var splitTime1= redovno.split(':');
        var splitTime2= pauza.split(':');
        var splitTime3= nedjelja.split(':');
        var splitTime4= noc.split(':');
        var splitTime5= praznik.split(':');


        hour = parseInt(splitTime1[0])-parseInt(splitTime2[0])+parseInt(splitTime3[0])+parseInt(splitTime4[0])+parseInt(splitTime5[0]);
        minute = parseInt(splitTime1[1])-parseInt(splitTime2[1])+parseInt(splitTime3[1])+parseInt(splitTime4[1])+parseInt(splitTime5[1]);
        hour = hour + minute/60;

        hour = Math.abs(hour);
        minute = Math.abs(minute);

        $("#ukupno_"+id).val( parseInt(hour).pad(2) + ":" + parseInt(minute).pad(2) );


        // Ukupno redovno
        var ukupnoRedovnoTjedan = '00:00';
        $('.ukRedovno'+week).each(function(index, item) {
            ukupnoRedovnoTjedan = timeCalc(ukupnoRedovnoTjedan, $(item).val() );
        });
        $("#ukRedovno_w"+week).val(ukupnoRedovnoTjedan);

        var ukupnoRedovnoMjesec = '00:00';
        $('.ukRedovno_w').each(function(index, item) {
            ukupnoRedovnoMjesec = timeCalc(ukupnoRedovnoMjesec, $(item).val() );
        });
        $("#ukRedovno_M").val(ukupnoRedovnoMjesec);


		//Ukupno pauza
		var ukupnoPauzaTjedan = '00:00';
        $('.ukPauza'+week).each(function(index, item) {
            ukupnoPauzaTjedan = timeCalc(ukupnoPauzaTjedan, $(item).val() );
        });
        $("#ukPauza_w"+week).val(ukupnoPauzaTjedan);

        var ukupnoPauzaMjesec = '00:00';
        $('.ukPauza_w').each(function(index, item) {
            ukupnoPauzaMjesec = timeCalc(ukupnoPauzaMjesec, $(item).val() );
        });
        $("#ukPauza_M").val(ukupnoPauzaMjesec);

		//Ukupno noc
		var ukupnoNocTjedan = '00:00';
        $('.ukNoc'+week).each(function(index, item) {
            ukupnoNocTjedan = timeCalc(ukupnoNocTjedan, $(item).val() );
        });
        $("#ukNoc_w"+week).val(ukupnoNocTjedan);

        var ukupnoNocMjesec = '00:00';
        $('.ukNoc_w').each(function(index, item) {
            ukupnoNocMjesec = timeCalc(ukupnoNocMjesec, $(item).val() );
        });
        $("#ukNoc_M").val(ukupnoNocMjesec);


		//Ukupno nedjelja
		var ukupnoNedjeljaTjedan = '00:00';
        $('.ukNedjelja'+week).each(function(index, item) {
            ukupnoNedjeljaTjedan = timeCalc(ukupnoNedjeljaTjedan, $(item).val() );
        });
        $("#ukNedjelja_w"+week).val(ukupnoNedjeljaTjedan);

        var ukupnoNedjeljaMjesec = '00:00';
        $('.ukNedjelja_w').each(function(index, item) {
            ukupnoNedjeljaMjesec = timeCalc(ukupnoNedjeljaMjesec, $(item).val() );
        });
        $("#ukNedjelja_M").val(ukupnoNedjeljaMjesec);


		//Ukupno praznik
		var ukupnoPraznikTjedan = '00:00';
        $('.ukPraznik'+week).each(function(index, item) {
            ukupnoPraznikTjedan = timeCalc(ukupnoPraznikTjedan, $(item).val() );
        });
        $("#ukPraznik_w"+week).val(ukupnoPraznikTjedan);

        var ukupnoPraznikMjesec = '00:00';
        $('.ukPraznik_w').each(function(index, item) {
            ukupnoPraznikMjesec = timeCalc(ukupnoPraznikMjesec, $(item).val() );
        });
        $("#ukPraznik_M").val(ukupnoPraznikMjesec);


		//Ukupno
		var ukupnoTjedan = '00:00';
        $('.ukupnoDan'+week).each(function(index, item) {
            ukupnoTjedan = timeCalc(ukupnoTjedan, $(item).val() );
        });
        $("#ukupno_w"+week).val(ukupnoTjedan);

        var ukupnoMjesec = '00:00';
        $('.ukupno_w').each(function(index, item) {
            ukupnoMjesec = timeCalc(ukupnoMjesec, $(item).val() );
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
        hour = hour + minute/60;

        hour = Math.abs(hour);
        minute = Math.abs(minute);

        return parseInt(hour).pad(2) + ":" + parseInt(minute).pad(2);
    }



    function addShift(id) {

        var shifts = $("#shifts").val();
        var shift1 = $("#shift1id").val();
        var shift2 = $("#shift2id").val();

        if( $("#Smjena_"+id).is(":visible") ) {

            $("#Smjena_"+id).hide('slow');
            shifts = parseInt(shifts) - parseInt(1);
            $("#shifts").val(shifts);
            if(shift1 == id) { $("#shift1id").val(0); }
            if(shift2 == id) { $("#shift2id").val(0); }

            if(shifts >= 2) {
                alert('Only 2 shifts allowed');
            }

            //return false;
        } else {

            if(shifts < 2) {
                $("#Smjena_"+id).show('slow');
                shifts = parseInt(shifts) + parseInt(1);
                $("#shifts").val(shifts);

                if(shifts == 1) { $("#shift1id").val(id); $("#shift2id").val(0);}
                if(shifts == 2 && shift2 == 0) { $("#shift2id").val(id); }
                else { $("#shift1id").val(id); }


            } else {
                alert('Dozvoljene su samo dvije smjene u danu');
                return false;
            }

            if(shifts == 0) { $("#shift1id").val(0); $("#shift2id").val(0);}
        }


        return false;
    }


    // hours and minutes padding with zeroes
    Number.prototype.pad = function(size) {
      var s = String(this);
      while (s.length < (size || 2)) {s = "0" + s;}
      return s;
    }
</script>


</body>
</html>







