<?
@session_start();
$SOwnerID = $_SESSION['OwnerID'];

// FRANCUSKA FIX
$fakeDriverFound = false;
require_once ROOT . '/cms/fixDriverID.php';
foreach($fakeDrivers as $key => $fakeDriverID) {
    if($SOwnerID == $fakeDriverID) {
        $fakeDriverFound = true;
        $OwnerID = $realDrivers[$key];
    }
}


    require './headerScripts.php';
    require_once ROOT . '/db/db.class.php';
    require_once ROOT . '/f2/f.php';
    
    $db = new DataBaseMysql();
    
    
    $SubDriverID = '1655'; // vukovic
    $SubDriverID = $_REQUEST['SubDriverID'];
       
if(isset($_REQUEST['SubDriverID'])) {    
    $month = $_REQUEST['Month'];
    
    $year = $_REQUEST['Year'];
    
    $daysInMonth = days_in_month($month, $year);
    $i = 0;   
    echo '<div class="container-fluid"><div class="row center">';

    showHeader();
    
    for( $day=1; $day <= $daysInMonth; $day++) {
        $dayTemp = '0'.$day;
        $day = substr($dayTemp, -2);
        
        // construct date
        $dateToShow = $year.'-'.$month.'-'.$day;
        
        $q  = "SELECT * FROM v4_WorkingHours ";
        $q .= "WHERE SubDriverID = '" . $SubDriverID ."' ";
        $q .= "AND forDate = '" . $dateToShow ."' ";
        $q .= "ORDER BY ID ASC";
        
        $w = $db->RunQuery($q);

        
        if($w->num_rows > 0) {
            
            while($wh = $w->fetch_object() ) {
                
                if( ($wh->ukupno != '00:00' and $wh->ukupno != '') or $wh->shifts != '2') {
                    showActiveRow($wh, $dateToShow);
                }
            }
            
        } else {
            showEmptyRow($dateToShow, $wh);
        }
    }
    showFooter();
    echo '</table>';

    echo '</div></div><br><br><br>';
    echo '<div class="row"><div class="col-md-12">';
    echo '<a class="btn xblue l" href="https://www.jamtransfer.com/cms/fr/selector.php?user='.$_REQUEST['user'].'">Back</a>&nbsp;&nbsp;';
    echo '</div</div><br><br><br>'; 


} else { // prikazi input form ?>
    <body>
    <style>
        input, select { width: 200px; }
        #RequiredFrom, #RequiredTo { visibility: hidden; padding-left: 4px; color: red; }
        .formLabel { width: 100px; display: inline-block; }
    </style>

    <div class="container">
        <h1>Monthly Report for driver</h1><br><br>

        <form action="" method="POST" onsubmit="return validate();">

            <input type="hidden" name="user" value="<?= $_REQUEST['user'] ?>">

            <div class="row">
                <div class="formLabel"><?= MONTH ?>:</div>
                <select name="Month" id="Month">
                    <option value="0">---</option>
                    <?
                        for ($i=1; $i<= 12; $i++) {
                            $month = substr('0'.$i, -2);
                            echo '<option value="' . $month . '">' . $month . '</option>';
                        }
                    ?>
                </select>
            </div>

            <div class="row">
                <div class="formLabel"><?= YEAR ?>:</div>
                <select name="Year">
                    <option value="2018">2018</option>

                </select>
            </div>

            <div class="row">
                <div class="formLabel"><?= DRIVER ?>:</div>
                <select name="SubDriverID" id="SubDriverID">

                    <option value="0"> --- </option>
                        <?
                        $q  = "SELECT AuthUserID, AuthUserRealName FROM v4_AuthUsers ";
                        $q .= "WHERE DriverID = '".$OwnerID."' ORDER BY AuthUserRealName ASC";
                        $r  = $db->RunQuery($q);

                        while($driver = $r->fetch_object()) {
                            echo '<option value="'.$driver->AuthUserID.'">';
                            echo $driver->AuthUserRealName . '</option>';
                        }
                        ?>

                </select>
            </div>

            <div class="row">
                <input type="hidden" name="SortSubDriver" id="SortSubDriver" value="0">
                
                <button type="submit" class="btn btn-primary" name="submit"
                style="margin-left: 105px"><?= SHOW_TRANSFERS ?></button>
            </div>
            <div id="greska"></div>
            
        </form>
    </div>



<script>

    function validate() {
        if( $("#SubDriverID").val() == 0 || $("#Month").val() == 0) {
            $("#greska").html('<i class="fa fa-times fa-2x fa-spin"></i> Enter all data');
            return false;
        }
    }
</script>
<?

}



 
function showActiveRow($wh, $dateToShow) { 
    global $i;
    
    $showDate = true;
    $rowColor = 'white';
    if($wh->shifts == "3") {$rowColor = 'pink lighten-3 bold'; $showDate = false;}
    if($wh->shifts == "4") {$rowColor = 'xgreen lighten-3 bold'; $showDate = false;}
 
 ?>
        <tr class="row <?=$rowColor?> pad4px" style="border-bottom: 1px solid #ddd;">

            <td style="white-space:nowrap;">
                <?if($showDate) echo $dateToShow?>
            </td>
            <td>
                <?if($showDate) echo dayToLang( date('l', strtotime($dateToShow)) )?>
            </td>

            <td>
                <?=$wh->startTime == '00:00' ? '' : $wh->startTime ?>
            </td>

            <td>
                <?=$wh->endTime == '00:00' ? '' : $wh->endTime ?>
            </td>

            <td>
                <?=$wh->pauzaStart == '00:00' ? '' : $wh->pauzaStart ?>
            </td>

            <td>
                <?=$wh->pauzaEnd == '00:00' ? '' : $wh->pauzaEnd ?>
            </td>

            <td>
                <?=$wh->ukRedovno == '' ? '00:00' : $wh->ukRedovno ?>
            </td>

            <td>
                <?=$wh->ukPauza == '' ? '00:00' : $wh->ukPauza ?>
            </td>

            <td>
                <?=$wh->ukNoc == '' ? '00:00' : $wh->ukNoc ?>
            </td>

            <td>
                <?=$wh->ukNedjelja == '' ? '00:00' : $wh->ukNedjelja ?>
            </td>

            <td>
                <?=$wh->ukPraznik == '' ? '00:00' : $wh->ukPraznik ?>
            </td>

            <td>
                <?=$wh->ukupno == '' ? '00:00' : $wh->ukupno ?>
            </td>

            <td>
                <?=$wh->Description?>
                <?if($wh->Description == 'Jour libre' or $wh->Description == 'Jour de congé'  or $wh->Description == 'congé payé') $i+=1;?>
            </td>

        </tr>
<?
}
 
 
 
function showEmptyRow($dateToShow, $wh) { 
 ?>
        <tr class="row white pad4px" style="border-bottom: 1px solid #ddd;">
            <td>

                <?=$dateToShow;?>
            </td>
            <td>

                <?=dayToLang( date('l', strtotime($dateToShow)) )?>
            </td>
            <td>
                Nema unosa
            </td>

        </tr>
<?
}  
 
 
function showHeader() { 

    global $SubDriverID;
    global $month;
    global $year;

    $driver = getUser($SubDriverID);

 
 ?>
    <table class="table table-condensed">
        <tr class="row center">
            <h2>Liste de transfert de chauffeur - <?=$month?>.<?=$year?>.</h2>
            <h2><?=$driver->AuthUserRealName; ?></h2>
            <br><br>
        </tr>
        <tr class="row white pad4px" style="font-weight:bold">

            <td>DATE</td>
            <td>JOUR</td>
            <td>DEBUT</td>
            <td>FIN</td>
            <td>PAUSE DEBUT</td>
            <td>PAUSE FIN</td>            
            <td>TOT. H. REGULIERES</td>
            <td>TOTAL PAUSE</td>
            <td>TOTAL HEURES DE NUIT</td>
            <td>TOTAL DIMANCHE</td>
            <td>TOTAL JOURS FERIES</td>
            <td>TOTAL</td>
            <td></td>
        </tr>
<?
} 

function showFooter() {
    global $i;
?>
        <tr class="row white pad4px" style="font-weight:bold">

            <td>DATE</td>
            <td>JOUR</td>
            <td>DEBUT</td>
            <td>FIN</td>
            <td>PAUSE DEBUT</td>
            <td>PAUSE FIN</td>            
            <td>TOT. H. REGULIERES</td>
            <td>TOTAL PAUSE</td>
            <td>TOTAL HEURES DE NUIT</td>
            <td>TOTAL DIMANCHE</td>
            <td>TOTAL JOURS FERIES</td>
            <td>TOTAL</td>
            <td>Jours de congés = <?=$i?></td>
        </tr>
<?
}


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






