<?

error_reporting(E_PARSE);
session_start();

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

	require_once '../../../../db/v4_SurVehicle.class.php';

	# init class
	$db = new v4_SurVehicle();

	
	# Details  red
	$where = 'WHERE OwnerID = ' . $_REQUEST['OwnerID'].' AND VehicleID='.$_REQUEST['VehicleID'];
	$dbk = $db->getKeysBy('VehicleID','asc',$where);

	# Details  red
	$db->getRow($dbk[0]);
	
	if($db->getVehicleID() != $_REQUEST['VehicleID']) die('No Vehicle Rules defined. You should define them first!');
?>	
	<div class="box-body ">
        <div class="row">
			<div class="col-md-12">
<!--				<div class="row">-->
<!--					<div class="col-md-3">-->
<!--						<label for="ID"><?=ID;?></label>-->
<!--					</div>-->
<!--					<div class="col-md-9">-->
<!--						<?= $db->getID(); ?>-->
<!--					</div>-->
<!--				</div>-->

<!--				<div class="row">-->
<!--					<div class="col-md-3">-->
<!--						<label for="SiteID"><?=SITEID;?></label>-->
<!--					</div>-->
<!--					<div class="col-md-9">-->
<!--						<?= $db->getSiteID(); ?>-->
<!--					</div>-->
<!--				</div>-->

<!--				<div class="row">-->
<!--					<div class="col-md-3">-->
<!--						<label for="OwnerID"><?=OWNERID;?></label>-->
<!--					</div>-->
<!--					<div class="col-md-9">-->
<!--						<?= $db->getOwnerID(); ?>-->
<!--					</div>-->
<!--				</div>-->

<!--				<div class="row">-->
<!--					<div class="col-md-3">-->
<!--						<label for="RouteID"><?=ROUTEID;?></label>-->
<!--					</div>-->
<!--					<div class="col-md-9">-->
<!--						<?= $_REQUEST['RouteID']?>-->
<!--					</div>-->
<!--				</div>-->

				<div class="row alert alert-info">
					<div class="col-md-3">
						<label for="NightStart"><?=NIGHTSTART;?></label>
						<?= $db->getNightStart();?>
					</div>
					<div class="col-md-3">
						<label for="NightEnd"><?=NIGHTEND;?></label>
						<?= $db->getNightEnd();?>
					</div>
					<div class="col-md-3">
						<label for="NightPercent"><?=NIGHTPERCENT;?></label>
						<?= $db->getNightPercent();?>
					</div>
					<div class="col-md-3">
						<label for="NightAmount"><?=NIGHTAMOUNT;?></label>
						<?= $db->getNightAmount();?>
					</div>
				</div>

				<div class="row alert alert-warning">
					<div class="col-md-3">
						<label for="MonPercent"><?=MONPERCENT;?></label>
						<?= $db->getMonPercent();?><br>
						<label for="MonAmount"><?=MONAMOUNT;?></label>
						<?= $db->getMonAmount();?>
					</div>
					<div class="col-md-3">
						<label for="TuePercent"><?=TUEPERCENT;?></label>
						<?= $db->getTuePercent();?><br>
						<label for="TueAmount"><?=TUEAMOUNT;?></label>
						<?= $db->getTueAmount();?>
					</div>
					<div class="col-md-3">
						<label for="WedPercent"><?=WEDPERCENT;?></label>
						<?= $db->getWedPercent();?><br>
						<label for="WedAmount"><?=WEDAMOUNT;?></label>
						<?= $db->getWedAmount();?>
					</div>
					<div class="col-md-3">
						<label for="ThuPercent"><?=THUPERCENT;?></label>
						<?= $db->getThuPercent();?><br>
						<label for="ThuAmount"><?=THUAMOUNT;?></label>
						<?= $db->getThuAmount();?>
					</div>
				</div>

				<div class="row alert alert-success">
					<div class="col-md-3">
						<label for="FriPercent"><?=FRIPERCENT;?></label>
						<?= $db->getFriPercent();?><br>
						<label for="FriAmount"><?=FRIAMOUNT;?></label>
						<?= $db->getFriAmount();?>
					</div>
					<div class="col-md-3">
						<label for="SatPercent"><?=SATPERCENT;?></label>
						<?= $db->getSatPercent();?><br>
						<label for="SatAmount"><?=SATAMOUNT;?></label>
						<?= $db->getSatAmount();?>
					</div>
					<div class="col-md-3">
						<label for="SunPercent"><?=SUNPERCENT;?></label>
						<?= $db->getSunPercent();?><br>
						<label for="SunAmount"><?=SUNAMOUNT;?></label>
						<?= $db->getSunAmount();?>
					</div>
				</div>

				<div class="row box box-info alert">
					<div class="col-md-3">
						<label for="S1Start"><?=S1START;?></label>
						<?= $db->getS1Start();?>
					</div>
					<div class="col-md-3">
						<label for="S1End"><?=S1END;?></label>
						<?= $db->getS1End();?>
					</div>
					<div class="col-md-3">
						<label for="S1Percent"><?=S1PERCENT;?></label>
						<?= $db->getS1Percent();?>
					</div>
				</div>

				<div class="row box box-success alert">
					<div class="col-md-3">
						<label for="S2Start"><?=S2START;?></label>
						<?= $db->getS2Start();?>
					</div>
					<div class="col-md-3">
						<label for="S2End"><?=S2END;?></label>
						<?= $db->getS2End();?>
					</div>
					<div class="col-md-3">
						<label for="S2Percent"><?=S2PERCENT;?></label>
						<?= $db->getS2Percent();?>
					</div>
				</div>

				<div class="row box box-warning alert">
					<div class="col-md-3">
						<label for="S3Start"><?=S3START;?></label>
						<?= $db->getS3Start();?>
					</div>
					<div class="col-md-3">
						<label for="S3End"><?=S3END;?></label>
						<?= $db->getS3End();?>
					</div>
					<div class="col-md-3">
						<label for="S3Percent"><?=S3PERCENT;?></label>
						<?= $db->getS3Percent();?>
					</div>
				</div>

				<div class="row box alert">
					<div class="col-md-3">
						<label for="S4Start"><?=S4START;?></label>
						<?= $db->getS4Start();?>
					</div>
					<div class="col-md-3">
						<label for="S4End"><?=S4END;?></label>
						<?= $db->getS4End();?>
					</div>
					<div class="col-md-3">
						<label for="S4Percent"><?=S4PERCENT;?></label>
						<?= $db->getS4Percent();?>
					</div>
				</div>

				<div class="row box alert">
					<div class="col-md-3">
						<label for="S5Start"><?=S5START;?></label>
						<?= $db->getS5Start();?>
					</div>
					<div class="col-md-3">
						<label for="S5End"><?=S5END;?></label>
						<?= $db->getS5End();?>
					</div>
					<div class="col-md-3">
						<label for="S5Percent"><?=S5PERCENT;?></label>
						<?= $db->getS5Percent();?>
					</div>
				</div>

				<div class="row box alert">
					<div class="col-md-3">
						<label for="S6Start"><?=S6START;?></label>
						<?= $db->getS6Start();?>
					</div>
					<div class="col-md-3">
						<label for="S6End"><?=S6END;?></label>
						<?= $db->getS6End();?>
					</div>
					<div class="col-md-3">
						<label for="S6Percent"><?=S6PERCENT;?></label>
						<?= $db->getS6Percent();?>
					</div>
				</div>

				<div class="row box alert">
					<div class="col-md-3">
						<label for="S7Start"><?=S7START;?></label>
						<?= $db->getS7Start();?>
					</div>
					<div class="col-md-3">
						<label for="S7End"><?=S7END;?></label>
						<?= $db->getS7End();?>
					</div>
					<div class="col-md-3">
						<label for="S7Percent"><?=S7PERCENT;?></label>
						<?= $db->getS7Percent();?>
					</div>
				</div>

				<div class="row box alert">
					<div class="col-md-3">
						<label for="S8Start"><?=S8START;?></label>
						<?= $db->getS8Start();?>
					</div>
					<div class="col-md-3">
						<label for="S8End"><?=S8END;?></label>
						<?= $db->getS8End();?>
					</div>
					<div class="col-md-3">
						<label for="S8Percent"><?=S8PERCENT;?></label>
						<?= $db->getS8Percent();?>
					</div>
				</div>

				<div class="row box alert">
					<div class="col-md-3">
						<label for="S9Start"><?=S9START;?></label>
						<?= $db->getS9Start();?>
					</div>
					<div class="col-md-3">
						<label for="S9End"><?=S9END;?></label>
						<?= $db->getS9End();?>
					</div>
					<div class="col-md-3">
						<label for="S9Percent"><?=S9PERCENT;?></label>
						<?= $db->getS9Percent();?>
					</div>
				</div>

				<div class="row box alert">
					<div class="col-md-3">
						<label for="S10Start"><?=S10START;?></label>
						<?= $db->getS10Start();?>
					</div>
					<div class="col-md-3">
						<label for="S10End"><?=S10END;?></label>
						<?= $db->getS10End();?>
					</div>
					<div class="col-md-3">
						<label for="S10Percent"><?=S10PERCENT;?></label>
						<?= $db->getS10Percent();?>
					</div>
				</div>
			</div>
	    </div>

