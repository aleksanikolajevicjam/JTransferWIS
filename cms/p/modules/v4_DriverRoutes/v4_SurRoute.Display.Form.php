<?

error_reporting(E_PARSE);
session_start();
//require_once '../../../headerScripts.php';
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

/*

	EXISTING ROUTE SURCHARGES

*/
?>	
<form id="v4_SurRouteEditForm" class="form " enctype="multipart/form-data" method="post" onsubmit="return false;">	
	<div class="box-body ">
        <div class="row">
			<div class="col-md-12">

				<input type="hidden" name="ID" id="ID" class="w100" value="<?= $db->getID();?>" readonly>

				<input type="hidden" name="SiteID" id="SiteID" class="w100" value="<?= $_REQUEST['SiteID']?>" >

				<input type="hidden" name="OwnerID" id="OwnerID" class="w100" value="<?= $_REQUEST['OwnerID']?>">

				<input type="hidden" name="DriverRouteID" id="DriverRouteID" class="w100" 
						value="<?= $db->getDriverRouteID();?>">
				
				<? if (isset($_REQUEST['ServiceID'])) {?>
				<input type="hidden" name="ServiceID" id="ServiceID" value="<?= $_REQUEST['ServiceID']?>">
				<?}?>

				<div class="row alert alert-info">
					<div class="col-md-3">
						<label for="NightStart"><?=NIGHTSTART;?></label>
						<?= $db->getNightStart(); ?>
					</div>
					<div class="col-md-3">
						<label for="NightEnd"><?=NIGHTEND;?></label>
						<?= $db->getNightEnd(); ?>
					</div>
					<div class="col-md-3">
						<label for="NightPercent"><?=NIGHTPERCENT;?></label>
						<?= $db->getNightPercent(); ?>
					</div>
					<div class="col-md-3">
						<label for="NightAmount"><?=NIGHTAMOUNT;?></label>
						<?= $db->getNightAmount(); ?>
					</div>
				</div>

				<div class="row alert alert-warning">
					<div class="col-md-3">
						<label for="MonPercent"><?=MONPERCENT;?></label>
						<?= $db->getMonPercent(); ?>
						<label for="MonAmount"><?=MONAMOUNT;?></label>
						<?= $db->getMonAmount(); ?>
					</div>
					<div class="col-md-3">
						<label for="TuePercent"><?=TUEPERCENT;?></label>
						<?= $db->getTuePercent(); ?>
						<label for="TueAmount"><?=TUEAMOUNT;?></label>
						<?= $db->getTueAmount(); ?>
					</div>
					<div class="col-md-3">
						<label for="WedPercent"><?=WEDPERCENT;?></label>
						<?= $db->getWedPercent(); ?>
						<label for="WedAmount"><?=WEDAMOUNT;?></label>
						<?= $db->getWedAmount(); ?>
					</div>
					<div class="col-md-3">
						<label for="ThuPercent"><?=THUPERCENT;?></label>
						<?= $db->getThuPercent(); ?>
						<label for="ThuAmount"><?=THUAMOUNT;?></label>
						<?= $db->getThuAmount(); ?>
					</div>
				</div>

				<div class="row alert alert-success">
					<div class="col-md-3">
						<label for="FriPercent"><?=FRIPERCENT;?></label>
						<?= $db->getFriPercent(); ?>
						<label for="FriAmount"><?=FRIAMOUNT;?></label>
						<?= $db->getFriAmount(); ?>
					</div>
					<div class="col-md-3">
						<label for="SatPercent"><?=SATPERCENT;?></label>
						<?= $db->getSatPercent(); ?>
						<label for="SatAmount"><?=SATAMOUNT;?></label>
						<?= $db->getSatAmount(); ?>
					</div>
					<div class="col-md-3">
						<label for="SunPercent"><?=SUNPERCENT;?></label>
						<?= $db->getSunPercent(); ?>
						<label for="SunAmount"><?=SUNAMOUNT;?></label>
						<?= $db->getSunAmount(); ?>
					</div>
				</div>

				<div class="row box box-info alert">
					<div class="col-md-3">
						<label for="S1Start"><?=S1START;?></label>
						<?= $db->getS1Start(); ?>
					</div>
					<div class="col-md-3">
						<label for="S1End"><?=S1END;?></label>
						<?= $db->getS1End(); ?>
					</div>
					<div class="col-md-3">
						<label for="S1Percent"><?=S1PERCENT;?></label>
						<?= $db->getS1Percent(); ?>
					</div>
				</div>

				<div class="row box box-success alert">
					<div class="col-md-3">
						<label for="S2Start"><?=S2START;?></label>
						<?= $db->getS2Start(); ?>
					</div>
					<div class="col-md-3">
						<label for="S2End"><?=S2END;?></label>
						<?= $db->getS2End(); ?>
					</div>
					<div class="col-md-3">
						<label for="S2Percent"><?=S2PERCENT;?></label>
						<?= $db->getS2Percent(); ?>
					</div>
				</div>

				<div class="row box box-warning alert">
					<div class="col-md-3">
						<label for="S3Start"><?=S3START;?></label>
						<?= $db->getS3Start(); ?>
					</div>
					<div class="col-md-3">
						<label for="S3End"><?=S3END;?></label>
						<?= $db->getS3End(); ?>
					</div>
					<div class="col-md-3">
						<label for="S3Percent"><?=S3PERCENT;?></label>
						<?= $db->getS3Percent(); ?>
					</div>
				</div>

				<div class="row box alert">
					<div class="col-md-3">
						<label for="S4Start"><?=S4START;?></label>
						<?= $db->getS4Start(); ?>
					</div>
					<div class="col-md-3">
						<label for="S4End"><?=S4END;?></label>
						<?= $db->getS4End(); ?>
					</div>
					<div class="col-md-3">
						<label for="S4Percent"><?=S4PERCENT;?></label>
						<?= $db->getS4Percent(); ?>
					</div>
				</div>

			</div>
	    </div>
</form>

<?

} else {
	echo 'No Route Rules defined. Please define them first';


?>
<form id="v4_SurRouteEditForm" class="form " enctype="multipart/form-data" method="post" onsubmit="return false;">	

	<input type="hidden" name="ID" id="ID" class="w100" value="<?= $db->getID();?>" >

	<input type="hidden" name="SiteID" id="SiteID" class="w100" value="<?= $_REQUEST['SiteID']?>" >

	<input type="hidden" name="OwnerID" id="OwnerID" class="w100" value="<?= $_REQUEST['OwnerID']?>" >

	<input type="hidden" name="DriverRouteID" id="DriverRouteID" class="w100" value="<?= $db->getDriverRouteID();?>" >
	
	<? if (isset($_REQUEST['ServiceID'])) { ?>
	<input type="hidden" name="ServiceID" id="ServiceID" value="<?= $_REQUEST['ServiceID']?>">
	<? } ?>
	
</form>						

<? } ?>

	    
<script>
			$(document).ready(function(){
				$(".datepicker").pickadate({format:'mm-dd'});
				$(".timepicker").pickatime({format: 'H:i'});
			});
</script>	    
