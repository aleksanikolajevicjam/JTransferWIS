<?
    @session_start();
	
	require_once ROOT .'/cms/lng/en_text.php';

    require_once ROOT . '/db/db.class.php';
	require_once ROOT . '/db/v4_OrderDetails.class.php';
	require_once ROOT . '/db/v4_OrdersMaster.class.php';

	$db = new DataBaseMysql();
	$om = new v4_OrdersMaster();
	$od = new v4_OrderDetails();



    $month = $_REQUEST['Month'];
    $year = $_REQUEST['Year'];

    $daysInMonth = days_in_month($month, $year);

	$prevDate = '';
	
	$DriverID = $_REQUEST['DriverID']; // umjesto FR-fixa uzimamo pravi DriverID


if( isset($_REQUEST['SubDriverID']) ) {

	$SubDriverID = $_REQUEST['SubDriverID'];
	$DriverID = $_REQUEST['DriverID'];
	
    echo '<div class="container"><div class="center">';

    showHeader();
        
	for($day = 1; $day <= $daysInMonth; $day++) {
        $dayTemp = '0'.$day;
        $day = substr($dayTemp, -2);
        
        // construct date
        $dateToShow = $year.'-'.$month.'-'.$day;

		//query
        $q  = "WHERE PickupDate = '" . $dateToShow . "' ";
        $q .= "AND TransferStatus != '3' ";
        $q .= "AND TransferStatus != '9' ";
        $q .= "AND TransferStatus != '4' ";
        $q .= "AND Expired != '1' ";

        if($SubDriverID != 0) {
		    $q .= "AND DriverID = '" . $DriverID . "' ";
            $q .= "AND (SubDriver = '" . $SubDriverID . "' ";
            $q .= "OR SubDriver2 = '" . $SubDriverID . "' ";
            $q .= "OR SubDriver3 = '" . $SubDriverID . "') ";
        }

        $odk = $od->getKeysBy("PickupDate", "ASC, PickupTime ASC", $q);

        if(count($odk) > 0) {
			foreach($odk as $key => $DetailsID ){

				$od->getRow($DetailsID);
		        ?>
		    	<tr class="white pad4px" xstyle="border-bottom: 1px solid #ddd;">
		    	    <td style="white-space:nowrap;">
		    	        <?if($dateToShow != $prevDate) echo $dateToShow;?>
		    	    </td>
		    	    <td>
		    	        <?if($dateToShow != $prevDate) echo dayToLang( date('l', strtotime($dateToShow)) )?>
		    	    </td>
		    	    <td>
		    	        <?=$od->PickupTime ?>
		    	    </td>	
		    	    <td style="text-align:left">
		    	        <?=$od->PickupName?> - <?=$od->DropName ?>
		    	    </td>
		    	</tr>
		        <?
				$prevDate = $dateToShow;
		    }
            
        } else {
            showEmptyRow($dateToShow);
        }
    }//end for
        
    showFooter();

    echo '</table>';

    echo '</div></div><br><br><br>';


 


} else { // prikazi input form ?>
    <body>
    <style>
        input, select { width: 200px; }
        #RequiredFrom, #RequiredTo { visibility: hidden; padding-left: 4px; color: red; }
        .formLabel { width: 100px; display: inline-block; }
    </style>

    <div class="container">
        <h1><?= TRANSFER_LIST ?></h1><br><br>

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
                        $q .= "WHERE DriverID = '".$DriverID."' ORDER BY AuthUserRealName ASC";
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



	function showEmptyRow($dateToShow) { 
 	    ?>
        <tr class="white pad4px" xstyle="border-bottom: 1px solid #ddd;">
            <td>
                <?=$dateToShow;?>
            </td>
            <td>
                <?=dayToLang( date('l', strtotime($dateToShow)) )?>
            </td>
            <td>---</td>
            <td>---</td>
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
		    <tr class="center">
		        <h2>Liste de transfert de chauffeur - <?=$month?>.<?=$year?>.</h2>
		        <h2><?=$driver->AuthUserRealName; ?></h2>
		        <br><br>
		    </tr>
		    <tr class="white pad4px bold" xstyle="border-bottom: 1px solid #ddd; font-weight:bold;">
		        <th>Date</th>
		        <th>Jour</th>
		        <th>Heure de départ</th>
		        <th>Route</th>
		    </tr>
		    
	    <?
	} 

	function showFooter() {
	    ?>
	    <tr class="white pad4px">
		        <th>Date</th>
		        <th>Jour</th>
		        <th>Heure de départ</th>
		        <th>Route</th>
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
