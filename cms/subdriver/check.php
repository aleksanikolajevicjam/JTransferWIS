<?
	session_start();
	require_once 'subdriver/db.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/db/db.class.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_SubActivity.class.php';	
	require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_SubVehicles.class.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_Equipment.class.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_VehicleEquipmentList.class.php';


	$db = new DataBaseMySql();
	$ac = new v4_SubActivity();
	$sv = new v4_SubVehicles();
	$eq = new v4_Equipment();
	$veql = new v4_VehicleEquipmentList();
	
	$sv->getRow($_REQUEST['VehicleID']);
	$vehicle=$sv->getVehicleDescription();
	
	$where="Where VehicleID=".$_REQUEST['VehicleID'];
	$eqk = $eq->getKeysBy('DisplayOrder ','', 'Where Active=1');
	$veqlk = $veql->getKeysBy('Datum Desc','', $where);
	$veql->getRow($veqlk[0]);
	$ListID=$veql->ListID;
	$query="SELECT EquipmentID FROM `v4_VehicleEquipmentItem` WHERE `ListID`='".$ListID."' AND VehicleID=".$_REQUEST['VehicleID'];
	$eqids = mysqli_query($con, $query) or die('Error in VehicleEquipmentItem query' . mysqli_connect_error());
	while($eqid = mysqli_fetch_object($eqids) ) {
		$eq_arr[] = $eqid->EquipmentID;
	}
	$delete=true;
	
	if (!isset($_REQUEST['SubmitFlag'])) {
		//select iz redova tabele
		$sqls="SELECT EquipmentID FROM `v4_VehicleCheckList` WHERE `ActivityID`=".$_REQUEST['ActivityID'];
		$query=mysqli_query($con, $sqls) or die('Error in VehicleCheckList query' . mysqli_connect_error());
		while($eqp = mysqli_fetch_object($query) ) {
			$eq_arr2[]=$eqp->EquipmentID;
		}
	}	
?>

<div class="container white">
	
	<div class="row">
		<div class="col-xs-12 pad1em">
		    <h3>CHECK LIST FOR <?= $vehicle ?></h3> 
		</div>
	</div>	

   <form  action="index.php?p=check" method="POST" class="pad1em no-print" enctype="multipart/form-data">
		<? foreach ($eqk as $nn => $key)   { 
		    $eq->getRow($key);
			if (in_array($key,$eq_arr)) {	
				if (!isset($_REQUEST['SubmitFlag']) && in_array($key,$eq_arr2)) {
					$checkflag="checked";
				}
				else {	
					$checkindex='check'.$key;
					if(isset($_REQUEST[$checkindex])) {
						$checkflag="checked";
						if ($delete) {
							// brisanje redova tabele
							$sqld="DELETE FROM `v4_VehicleCheckList` WHERE `ActivityID`=".$_REQUEST['ActivityID'];
							mysqli_query($con, $sqld) or die('Error in VehicleCheckList query' . mysqli_connect_error());
							//upis liste u activitiies
							$ac->getRow($_REQUEST['ActivityID']);
							$ac->setListID($_REQUEST['ListID']);
							$ac->saveRow();
							$delete=false;
						}
						// insert u tabelu
						$sqli="INSERT INTO `v4_VehicleCheckList`(`ActivityID`, `EquipmentID`) VALUES (".$_REQUEST['ActivityID'].",".$key.")";
						mysqli_query($con, $sqli) or die('Error in VehicleCheckList query' . mysqli_connect_error());
					}	
					else $checkflag="";
				}

		?>
		<div class="row">
			<div class="col-sm-6">
		        <label><?= $eq->Title ?></label>
			</div>
			<div class="col-sm-6">
				<input type="checkbox" name="check<?= $key ?>" style="height: 0.8em" value="1" <?= $checkflag ?>/>
			</div>
		</div>		
		<? } }?>


		<div>
	        <button type="submit" name="addExpense" value="Add" class="btn btn-primary btn-block l">
	        <i class="fa fa-chevron-down"></i> Add</button>
		</div>
		<input type="hidden" name="VehicleID" value="<?= $_REQUEST['VehicleID'] ?>" />
		<input type="hidden" name="ActivityID" value="<?= $_REQUEST['ActivityID'] ?>" />
		<input type="hidden" name="ListID" value="<?= $ListID ?>" />		
		<input type="hidden" name="SubmitFlag" value="1" />

    </form>	
</div>

