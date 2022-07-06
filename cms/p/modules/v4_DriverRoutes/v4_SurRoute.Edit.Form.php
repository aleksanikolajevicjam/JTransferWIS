<?

error_reporting(E_PARSE);
session_start();




//require_once '../../../headerScripts.php'; OVO PRAVI GRESKU DA MENIJI NE RADE




	// LANGUAGES
	if ( isset($_SESSION['CMSLang']) and $_SESSION['CMSLang'] != '') {

		$languageFile = '../../../lng/' . $_SESSION['CMSLang'] . '_text.php';

		if ( file_exists( $languageFile) ) require_once $languageFile;
		else {
			$_SESSION['CMSLang'] = 'en';
			require_once '../../../lng/en_text.php';
		}
	}
	else {
		$_SESSION['CMSLang'] = 'en';
		require_once '../../../lng/en_text.php';
	}
	// END OF LANGUAGES	

 
	# init libs
	require_once '../../../../db/db.class.php';
	require_once '../../../../db/v4_SurGlobal.class.php';
	require_once '../../../../db/v4_SurRoute.class.php';

	# init class
	$db = new v4_SurRoute();


	# Details  red
	$dbk = $db->getKeysBy('DriverRouteID','asc','WHERE DriverRouteID = ' . $_REQUEST['ID']);

	# Details  red
	$db->getRow($dbk[0]);
	
	// novo pravilo
	if($db->getDriverRouteID() == $_REQUEST['ID']) {

?>	
	
<? 
/*

	EXISTING ROUTE SURCHARGES

*/
?>	
<form id="v4_SurRouteEditForm" class="form " enctype="multipart/form-data" method="post" onsubmit="return false;">	
	<div class="box-body ">
        <div class="row">
			<div class="col-md-12">

						<input type="hidden" name="ID" id="ID" class="w100" value="<?= $db->getID();?>" readonly>

						<input type="hidden" name="SiteID" id="SiteID" class="w100" value="<?= $_REQUEST['SiteID']?>" readonly>

						<input type="hidden" name="OwnerID" id="OwnerID" class="w100" value="<?= $_REQUEST['OwnerID']?>" readonly>

						<input type="hidden" name="DriverRouteID" id="DriverRouteID" class="w100" value="<?= $db->getDriverRouteID();?>" readonly>


				<div class="row alert alert-info">
					<div class="col-md-3">
						<label for="NightStart"><?=NIGHTSTART;?></label>
						<input type="text" name="NightStart" id="NightStart" class="w100 timepicker" value="<?= $db->getNightStart(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="NightEnd"><?=NIGHTEND;?></label>
						<input type="text" name="NightEnd" id="NightEnd" class="w100 timepicker" value="<?= $db->getNightEnd(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="NightPercent"><?=NIGHTPERCENT;?></label>
						<input type="text" name="NightPercent" id="NightPercent" class="w100" value="<?= $db->getNightPercent(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="NightAmount"><?=NIGHTAMOUNT;?></label>
						<input type="text" name="NightAmount" id="NightAmount" class="w100" value="<?= $db->getNightAmount(); ?>" >
					</div>
				</div>

				<div class="row alert alert-warning">
					<div class="col-md-3">
						<label for="MonPercent"><?=MONPERCENT;?></label>
						<input type="text" name="MonPercent" id="MonPercent" class="w100" value="<?= $db->getMonPercent(); ?>" >
						<label for="MonAmount"><?=MONAMOUNT;?></label>
						<input type="text" name="MonAmount" id="MonAmount" class="w100" value="<?= $db->getMonAmount(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="TuePercent"><?=TUEPERCENT;?></label>
						<input type="text" name="TuePercent" id="TuePercent" class="w100" value="<?= $db->getTuePercent(); ?>" >
						<label for="TueAmount"><?=TUEAMOUNT;?></label>
						<input type="text" name="TueAmount" id="TueAmount" class="w100" value="<?= $db->getTueAmount(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="WedPercent"><?=WEDPERCENT;?></label>
						<input type="text" name="WedPercent" id="WedPercent" class="w100" value="<?= $db->getWedPercent(); ?>" >
						<label for="WedAmount"><?=WEDAMOUNT;?></label>
						<input type="text" name="WedAmount" id="WedAmount" class="w100" value="<?= $db->getWedAmount(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="ThuPercent"><?=THUPERCENT;?></label>
						<input type="text" name="ThuPercent" id="ThuPercent" class="w100" value="<?= $db->getThuPercent(); ?>" >
						<label for="ThuAmount"><?=THUAMOUNT;?></label>
						<input type="text" name="ThuAmount" id="ThuAmount" class="w100" value="<?= $db->getThuAmount(); ?>" >
					</div>
				</div>

				<div class="row alert alert-success">
					<div class="col-md-3">
						<label for="FriPercent"><?=FRIPERCENT;?></label>
						<input type="text" name="FriPercent" id="FriPercent" class="w100" value="<?= $db->getFriPercent(); ?>" >
						<label for="FriAmount"><?=FRIAMOUNT;?></label>
						<input type="text" name="FriAmount" id="FriAmount" class="w100" value="<?= $db->getFriAmount(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="SatPercent"><?=SATPERCENT;?></label>
						<input type="text" name="SatPercent" id="SatPercent" class="w100" value="<?= $db->getSatPercent(); ?>" >
						<label for="SatAmount"><?=SATAMOUNT;?></label>
						<input type="text" name="SatAmount" id="SatAmount" class="w100" value="<?= $db->getSatAmount(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="SunPercent"><?=SUNPERCENT;?></label>
						<input type="text" name="SunPercent" id="SunPercent" class="w100" value="<?= $db->getSunPercent(); ?>" >
						<label for="SunAmount"><?=SUNAMOUNT;?></label>
						<input type="text" name="SunAmount" id="SunAmount" class="w100" value="<?= $db->getSunAmount(); ?>" >
					</div>
				</div>

				<div class="row box box-info alert">
					<div class="col-md-3">
						<label for="S1Start"><?=S1START;?></label>
						<input type="text" name="S1Start" id="S1Start" class="w100 datepicker" value="<?= $db->getS1Start(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S1End"><?=S1END;?></label>
						<input type="text" name="S1End" id="S1End" class="w100 datepicker" value="<?= $db->getS1End(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S1Percent"><?=S1PERCENT;?></label>
						<input type="text" name="S1Percent" id="S1Percent" class="w100" value="<?= $db->getS1Percent(); ?>" >
					</div>
				</div>

				<div class="row box box-success alert">
					<div class="col-md-3">
						<label for="S2Start"><?=S2START;?></label>
						<input type="text" name="S2Start" id="S2Start" class="w100 datepicker" value="<?= $db->getS2Start(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S2End"><?=S2END;?></label>
						<input type="text" name="S2End" id="S2End" class="w100 datepicker" value="<?= $db->getS2End(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S2Percent"><?=S2PERCENT;?></label>
						<input type="text" name="S2Percent" id="S2Percent" class="w100" value="<?= $db->getS2Percent(); ?>" >
					</div>
				</div>

				<div class="row box box-warning alert">
					<div class="col-md-3">
						<label for="S3Start"><?=S3START;?></label>
						<input type="text" name="S3Start" id="S3Start" class="w100 datepicker" value="<?= $db->getS3Start(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S3End"><?=S3END;?></label>
						<input type="text" name="S3End" id="S3End" class="w100 datepicker" value="<?= $db->getS3End(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S3Percent"><?=S3PERCENT;?></label>
						<input type="text" name="S3Percent" id="S3Percent" class="w100" value="<?= $db->getS3Percent(); ?>" >
					</div>
				</div>

				<div class="row box alert">
					<div class="col-md-3">
						<label for="S4Start"><?=S4START;?></label>
						<input type="text" name="S4Start" id="S4Start" class="w100 datepicker" value="<?= $db->getS4Start(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S4End"><?=S4END;?></label>
						<input type="text" name="S4End" id="S4End" class="w100 datepicker" value="<?= $db->getS4End(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S4Percent"><?=S4PERCENT;?></label>
						<input type="text" name="S4Percent" id="S4Percent" class="w100" value="<?= $db->getS4Percent(); ?>" >
					</div>
				</div>
				
				
				<div class="row box alert">
					<div class="col-md-3">
						<label for="S5Start"><?=S5START;?></label>
						<input type="text" name="S5Start" id="S5Start" class="w100 datepicker" value="<?= $db->getS5Start(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S5End"><?=S5END;?></label>
						<input type="text" name="S5End" id="S5End" class="w100 datepicker" value="<?= $db->getS5End(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S5Percent"><?=S5PERCENT;?></label>
						<input type="text" name="S5Percent" id="S5Percent" class="w100" value="<?= $db->getS5Percent(); ?>" >
					</div>
				</div>
				
				<div class="row box alert">
					<div class="col-md-3">
						<label for="S6Start"><?=S6START;?></label>
						<input type="text" name="S6Start" id="S6Start" class="w100 datepicker" value="<?= $db->getS6Start(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S6End"><?=S6END;?></label>
						<input type="text" name="S6End" id="S6End" class="w100 datepicker" value="<?= $db->getS6End(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S6Percent"><?=S6PERCENT;?></label>
						<input type="text" name="S6Percent" id="S6Percent" class="w100" value="<?= $db->getS6Percent(); ?>" >
					</div>
				</div>
				
				<div class="row box alert">
					<div class="col-md-3">
						<label for="S7Start"><?=S7START;?></label>
						<input type="text" name="S7Start" id="S7Start" class="w100 datepicker" value="<?= $db->getS7Start(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S7End"><?=S7END;?></label>
						<input type="text" name="S7End" id="S7End" class="w100 datepicker" value="<?= $db->getS7End(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S7Percent"><?=S7PERCENT;?></label>
						<input type="text" name="S7Percent" id="S7Percent" class="w100" value="<?= $db->getS7Percent(); ?>" >
					</div>
				</div>
				
				<div class="row box alert">
					<div class="col-md-3">
						<label for="S8Start"><?=S8START;?></label>
						<input type="text" name="S8Start" id="S8Start" class="w100 datepicker" value="<?= $db->getS8Start(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S8End"><?=S8END;?></label>
						<input type="text" name="S8End" id="S8End" class="w100 datepicker" value="<?= $db->getS8End(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S8Percent"><?=S8PERCENT;?></label>
						<input type="text" name="S8Percent" id="S8Percent" class="w100" value="<?= $db->getS8Percent(); ?>" >
					</div>
				</div>
				
				<div class="row box alert">
					<div class="col-md-3">
						<label for="S9Start"><?=S9START;?></label>
						<input type="text" name="S9Start" id="S9Start" class="w100 datepicker" value="<?= $db->getS9Start(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S9End"><?=S9END;?></label>
						<input type="text" name="S9End" id="S9End" class="w100 datepicker" value="<?= $db->getS9End(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S9Percent"><?=S9PERCENT;?></label>
						<input type="text" name="S9Percent" id="S9Percent" class="w100" value="<?= $db->getS9Percent(); ?>" >
					</div>
				</div>
				
				<div class="row box alert">
					<div class="col-md-3">
						<label for="S10Start"><?=S10START;?></label>
						<input type="text" name="S10Start" id="S10Start" class="w100 datepicker" value="<?= $db->getS10Start(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S10End"><?=S10END;?></label>
						<input type="text" name="S10End" id="S10End" class="w100 datepicker" value="<?= $db->getS10End(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S10Percent"><?=S10PERCENT;?></label>
						<input type="text" name="S10Percent" id="S10Percent" class="w100" value="<?= $db->getS10Percent(); ?>" >
					</div>
				</div>					
<!--				<div class="row">-->
<!--					<div id="surStatusMessage"></div>-->
<!--					<button class="btn btn-primary" onclick="editSavev4_SurRoute();">Save Route Specific Surcharges</button>-->
<!--				</div>-->


			</div>
	    </div>
</form>

<?

} else {

	# init class
	$sg = new v4_SurGlobal();


	# Details  red
	$sgk = $sg->getKeysBy('OwnerID','asc','WHERE OwnerID = ' . $_REQUEST['OwnerID']);

	# Details  red
	$sg->getRow($sgk[0]);

/*

	NEW ROUTE SURCHARGES

*/
?>
<form id="v4_SurRouteEditForm" class="form" enctype="multipart/form-data" method="post" onsubmit="return false;">
	<div class="box-body ">
        <div class="row">
			<div class="col-md-12">

						<input type="hidden" name="ID" id="ID" class="w100" value="<?= $sg->getID(); ?>" readonly>

						<input type="hidden" name="SiteID" id="SiteID" class="w100" value="<?= $_REQUEST['SiteID']?>" readonly>

						<input type="hidden" name="OwnerID" id="OwnerID" class="w100" value="<?= $_REQUEST['OwnerID']?>" readonly>

						<input type="hidden" name="DriverRouteID" id="DriverRouteID" class="w100" value="<?= $_REQUEST['ID']?>" readonly>

				<div class="row alert alert-info">
					<div class="col-md-3">
						<label for="NightStart"><?=NIGHTSTART;?></label>
						<input type="text" name="NightStart" id="NightStart" class="w100 timepicker" value="<?= $sg->getNightStart(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="NightEnd"><?=NIGHTEND;?></label>
						<input type="text" name="NightEnd" id="NightEnd" class="w100 timepicker" value="<?= $sg->getNightEnd(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="NightPercent"><?=NIGHTPERCENT;?></label>
						<input type="text" name="NightPercent" id="NightPercent" class="w100" value="<?= $sg->getNightPercent(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="NightAmount"><?=NIGHTAMOUNT;?></label>
						<input type="text" name="NightAmount" id="NightAmount" class="w100" value="<?= $sg->getNightAmount(); ?>" >
					</div>
				</div>

				<div class="row alert alert-warning">
					<div class="col-md-3">
						<label for="MonPercent"><?=MONPERCENT;?></label>
						<input type="text" name="MonPercent" id="MonPercent" class="w100" value="<?= $sg->getMonPercent(); ?>" >
						<label for="MonAmount"><?=MONAMOUNT;?></label>
						<input type="text" name="MonAmount" id="MonAmount" class="w100" value="<?= $sg->getMonAmount(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="TuePercent"><?=TUEPERCENT;?></label>
						<input type="text" name="TuePercent" id="TuePercent" class="w100" value="<?= $sg->getTuePercent(); ?>" >
						<label for="TueAmount"><?=TUEAMOUNT;?></label>
						<input type="text" name="TueAmount" id="TueAmount" class="w100" value="<?= $sg->getTueAmount(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="WedPercent"><?=WEDPERCENT;?></label>
						<input type="text" name="WedPercent" id="WedPercent" class="w100" value="<?= $sg->getWedPercent(); ?>" >
						<label for="WedAmount"><?=WEDAMOUNT;?></label>
						<input type="text" name="WedAmount" id="WedAmount" class="w100" value="<?= $sg->getWedAmount(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="ThuPercent"><?=THUPERCENT;?></label>
						<input type="text" name="ThuPercent" id="ThuPercent" class="w100" value="<?= $sg->getThuPercent(); ?>" >
						<label for="ThuAmount"><?=THUAMOUNT;?></label>
						<input type="text" name="ThuAmount" id="ThuAmount" class="w100" value="<?= $sg->getThuAmount(); ?>" >
					</div>
				</div>

				<div class="row alert alert-success">
					<div class="col-md-3">
						<label for="FriPercent"><?=FRIPERCENT;?></label>
						<input type="text" name="FriPercent" id="FriPercent" class="w100" value="<?= $sg->getFriPercent(); ?>" >
						<label for="FriAmount"><?=FRIAMOUNT;?></label>
						<input type="text" name="FriAmount" id="FriAmount" class="w100" value="<?= $sg->getFriAmount(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="SatPercent"><?=SATPERCENT;?></label>
						<input type="text" name="SatPercent" id="SatPercent" class="w100" value="<?= $sg->getSatPercent(); ?>" >
						<label for="SatAmount"><?=SATAMOUNT;?></label>
						<input type="text" name="SatAmount" id="SatAmount" class="w100" value="<?= $sg->getSatAmount(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="SunPercent"><?=SUNPERCENT;?></label>
						<input type="text" name="SunPercent" id="SunPercent" class="w100" value="<?= $sg->getSunPercent(); ?>" >
						<label for="SunAmount"><?=SUNAMOUNT;?></label>
						<input type="text" name="SunAmount" id="SunAmount" class="w100" value="<?= $sg->getSunAmount(); ?>" >
					</div>
				</div>

				<div class="row box box-info alert">
					<div class="col-md-3">
						<label for="S1Start"><?=S1START;?></label>
						<input type="text" name="S1Start" id="S1Start" class="w100 datepicker" value="<?= $sg->getS1Start(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S1End"><?=S1END;?></label>
						<input type="text" name="S1End" id="S1End" class="w100 datepicker" value="<?= $sg->getS1End(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S1Percent"><?=S1PERCENT;?></label>
						<input type="text" name="S1Percent" id="S1Percent" class="w100" value="<?= $sg->getS1Percent(); ?>" >
					</div>
				</div>

				<div class="row box box-success alert">
					<div class="col-md-3">
						<label for="S2Start"><?=S2START;?></label>
						<input type="text" name="S2Start" id="S2Start" class="w100 datepicker" value="<?= $sg->getS2Start(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S2End"><?=S2END;?></label>
						<input type="text" name="S2End" id="S2End" class="w100 datepicker" value="<?= $sg->getS2End(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S2Percent"><?=S2PERCENT;?></label>
						<input type="text" name="S2Percent" id="S2Percent" class="w100" value="<?= $sg->getS2Percent(); ?>" >
					</div>
				</div>

				<div class="row box box-warning alert">
					<div class="col-md-3">
						<label for="S3Start"><?=S3START;?></label>
						<input type="text" name="S3Start" id="S3Start" class="w100 datepicker" value="<?= $sg->getS3Start(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S3End"><?=S3END;?></label>
						<input type="text" name="S3End" id="S3End" class="w100 datepicker" value="<?= $sg->getS3End(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S3Percent"><?=S3PERCENT;?></label>
						<input type="text" name="S3Percent" id="S3Percent" class="w100" value="<?= $sg->getS3Percent(); ?>" >
					</div>
				</div>

				<div class="row box alert">
					<div class="col-md-3">
						<label for="S4Start"><?=S4START;?></label>
						<input type="text" name="S4Start" id="S4Start" class="w100 datepicker" value="<?= $sg->getS4Start(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S4End"><?=S4END;?></label>
						<input type="text" name="S4End" id="S4End" class="w100 datepicker" value="<?= $sg->getS4End(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S4Percent"><?=S4PERCENT;?></label>
						<input type="text" name="S4Percent" id="S4Percent" class="w100" value="<?= $sg->getS4Percent(); ?>" >
					</div>
				</div>
				
				
				<div class="row box alert">
					<div class="col-md-3">
						<label for="S5Start"><?=S5START;?></label>
						<input type="text" name="S5Start" id="S5Start" class="w100 datepicker" value="<?= $sg->getS5Start(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S5End"><?=S5END;?></label>
						<input type="text" name="S5End" id="S5End" class="w100 datepicker" value="<?= $sg->getS5End(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S5Percent"><?=S5PERCENT;?></label>
						<input type="text" name="S5Percent" id="S5Percent" class="w100" value="<?= $sg->getS5Percent(); ?>" >
					</div>
				</div>
				
				<div class="row box alert">
					<div class="col-md-3">
						<label for="S6Start"><?=S6START;?></label>
						<input type="text" name="S6Start" id="S6Start" class="w100 datepicker" value="<?= $sg->getS6Start(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S6End"><?=S6END;?></label>
						<input type="text" name="S6End" id="S6End" class="w100 datepicker" value="<?= $sg->getS6End(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S6Percent"><?=S6PERCENT;?></label>
						<input type="text" name="S6Percent" id="S6Percent" class="w100" value="<?= $sg->getS6Percent(); ?>" >
					</div>
				</div>
				
				<div class="row box alert">
					<div class="col-md-3">
						<label for="S7Start"><?=S7START;?></label>
						<input type="text" name="S7Start" id="S7Start" class="w100 datepicker" value="<?= $sg->getS7Start(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S7End"><?=S7END;?></label>
						<input type="text" name="S7End" id="S7End" class="w100 datepicker" value="<?= $sg->getS7End(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S7Percent"><?=S7PERCENT;?></label>
						<input type="text" name="S7Percent" id="S7Percent" class="w100" value="<?= $sg->getS7Percent(); ?>" >
					</div>
				</div>
				
				<div class="row box alert">
					<div class="col-md-3">
						<label for="S8Start"><?=S8START;?></label>
						<input type="text" name="S8Start" id="S8Start" class="w100 datepicker" value="<?= $sg->getS8Start(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S8End"><?=S8END;?></label>
						<input type="text" name="S8End" id="S8End" class="w100 datepicker" value="<?= $sg->getS8End(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S8Percent"><?=S8PERCENT;?></label>
						<input type="text" name="S8Percent" id="S8Percent" class="w100" value="<?= $sg->getS8Percent(); ?>" >
					</div>
				</div>
				
				<div class="row box alert">
					<div class="col-md-3">
						<label for="S9Start"><?=S9START;?></label>
						<input type="text" name="S9Start" id="S9Start" class="w100 datepicker" value="<?= $sg->getS9Start(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S9End"><?=S9END;?></label>
						<input type="text" name="S9End" id="S9End" class="w100 datepicker" value="<?= $sg->getS9End(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S9Percent"><?=S9PERCENT;?></label>
						<input type="text" name="S9Percent" id="S9Percent" class="w100" value="<?= $sg->getS9Percent(); ?>" >
					</div>
				</div>
				
				<div class="row box alert">
					<div class="col-md-3">
						<label for="S10Start"><?=S10START;?></label>
						<input type="text" name="S10Start" id="S10Start" class="w100 datepicker" value="<?= $sg->getS10Start(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S10End"><?=S10END;?></label>
						<input type="text" name="S10End" id="S10End" class="w100 datepicker" value="<?= $sg->getS10End(); ?>" >
					</div>
					<div class="col-md-3">
						<label for="S10Percent"><?=S10PERCENT;?></label>
						<input type="text" name="S10Percent" id="S10Percent" class="w100" value="<?= $sg->getS10Percent(); ?>" >
					</div>
				</div>					
				
<!--				<div class="row">-->
<!--					<div id="surStatusMessage"></div>-->
<!--					<button class="btn btn-primary" onclick="editSavev4_SurRoute();">Save Route Specific Surcharges</button>-->
<!--				</div>-->


			</div>
	    </div>
</form>
<? } ?>




	    
<script>
			$(document).ready(function(){
				$(".datepicker").pickadate({format:'mm-dd'});
				$(".timepicker").pickatime({format: 'H:i'});
			});
</script>	    
