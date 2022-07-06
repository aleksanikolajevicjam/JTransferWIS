<?
	session_start();

	require_once 'subdriver/db.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/db/db.class.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_Actions.class.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/db/v4_SubVehicles.class.php';


	$db = new DataBaseMySql();
	$ac = new v4_Actions();
	$ack = $ac->getKeysBy('DisplayOrder ', '','WHERE Active=2');
	foreach ($ack as $nn => $key)
	{
		$ac->getRow($key);
		$opis[$key]=$ac->getTitle();		
	}
 
	$ownerID=$_SESSION['OwnerID'];
	$driverId = $_SESSION['DriverID'];
	$sv = new v4_SubVehicles();
	$where='WHERE OwnerID='.$ownerID ." and Active=1";
	$svk = $sv->getKeysBy('VehicleID ', '',$where);
	foreach ($svk as $nn => $key)
	{
		$sv->getRow($key);
		$opis2[$key]=$sv->getVehicleDescription();		
	} 	

	$ex = array();
	$datum = date("Y-m-d");
	//$driverId = '769'; // test


	if (isset($_FILES["DocumentImage"]) && !empty(basename($_FILES["DocumentImage"]["name"]))) { 
		$target_doc_dir = "subdriver/uploads/";
		$target_doc_file = "https://cms.jamtransfer.com/cms/".$target_doc_dir . basename($_FILES["DocumentImage"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_doc_file,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		if(isset($_POST["addExpense"])) {
			$check = getimagesize($_FILES["DocumentImage"]["tmp_name"]);
			if($check !== false) move_uploaded_file($_FILES["DocumentImage"]["tmp_name"],$target_doc_file);
			else echo "File is not an image.";			
		}
		
	}
	else $target_doc_file='';
	
	if (isset($_FILES["ActionImage"]) && !empty(basename($_FILES["ActionImage"]["name"]))) { 
		$target_act_dir = "subdriver/uploads/";
		$target_act_file = "https://cms.jamtransfer.com/cms/".$target_act_dir . basename($_FILES["ActionImage"]["name"]);
		$uploadOk = 1;
		ini_set('upload_max_filesize', '30M');
		ini_set('post_max_size', '30M');
		ini_set('max_input_time', 300);
		ini_set('max_execution_time', 300);
		if(isset($_POST["addExpense"])) move_uploaded_file($_FILES["ActionImage"]["tmp_name"],$target_act_file); 
	}
	else $target_act_file='';	


	// Dodavanje novog troska
	if (isset($_REQUEST['addExpense']) and $_REQUEST['addExpense'] == 'Add') {
		$q 	= "INSERT INTO v4_SubActivity (OwnerID, DriverID, Datum, Expense, VehicleID, Description, DocumentImage, ActionImage) ";
		$q .= "VALUES('";
		$q .= $_REQUEST['OwnerID'] ."','";
		$q .= $_REQUEST['DriverID'] ."','";
		$q .= $_REQUEST['Datum'] ."','";
		$q .= $_REQUEST['Expense'] ."','";
		$q .= $_REQUEST['Vehicle'] ."','";		
		$q .= $_REQUEST['Description'] ."','";		
		$q .= $target_doc_file ."','";
		$q .= $target_act_file ."')";
		mysqli_query($con, $q) or die('Error in SubExpenses add query <br>' . mysqli_connect_error());
		//novi vehicle id
		$_SESSION['VehicleID']=$_REQUEST['Vehicle'];
		
	}

	// Brisanje troska
	if ( isset($_REQUEST['expID'])) {
		// echo '<script>console.log("deleting " + ' . $_REQUEST['expID'] . ')</script>';
		//$q 	= "DELETE FROM v4_SubActivity ";
		$q  = "UPDATE `v4_SubActivity` SET `Approved`=9 ";
		$q .= "WHERE ID = '" . $_REQUEST['expID'] ."'";
		mysqli_query($con, $q) or die('Error in SubExpenses delete query <br>' . mysqli_connect_error());
	}


	// Priprema podataka za display liste troskova	
	$q  = " SELECT * FROM v4_SubActivity";
	$q .= " WHERE DriverID = '" . $driverId . "'";
	$q .= " AND Expense != '12' ";
	$q .= " AND Approved < 9 ";	
//	$q .= " AND Datum >= '" . date('Y-m-d',strtotime('-2 days')). "' ";
	$q .= " AND Datum >= '" . date('Y-m-d',strtotime('-7 days')). "' ";	
	$q .= " ORDER BY Datum DESC";

	$query = mysqli_query($con, $q) or die('Error in SubExpenses query <br>' . mysqli_connect_error());

	// stavi u array za kasnije
	while($exo = mysqli_fetch_object($query) ) {
		$ex[$exo->ID] = array(
			'ID' 	=> $exo->ID,
			'OwnerID' 	=> $exo->OwnerID,
			'DriverID' 	=> $exo->DriverID,
			'Datum'		=> $exo->Datum,
			'Expense'	=> $exo->Expense,
			'Vehicle'	=> $exo->VehicleID,
			'DocumentImage' => $exo->DocumentImage,
			'ActionImage' => $exo->ActionImage
		);
		
		if($exo->Card) $totalCard += $exo->Amount;
		else $totalCash += $exo->Amount;
	}

?>
<div class="container white">
	
	<div class="row">
		<div class="col-xs-12 pad1em">
		    <h3>ACTIVITIES</h3> 
			<h4>Vehicle: <?= $_SESSION['VehicleTitle'] ?></h4> 			
		</div>
	</div>	

   <form  action="index.php?p=activity" method="POST" class="pad1em no-print" enctype="multipart/form-data">
		<div class="row">
			<div class="col-sm-6">
		        <label for="Datum">Activity date</label>
			</div>
			<div class="col-sm-6">
				<select name="Datum" id="Datum" class="col-md-10">
					<option value="<?= date('Y-m-d',strtotime('-2 days')) ?>">
						<?= date("d.m.Y",strtotime("-2 days")) ?>
					</option>
					<option value="<?= date('Y-m-d',strtotime('-1 days')) ?>">
						<?= date("d.m.Y",strtotime("-1 days")) ?>
					</option>					
					<option value="<?= date("Y-m-d") ?>" selected>
						<?= date("d.m.Y") ?>
					</option>
				</select>
			</div>
		</div>
 
		<div class="row">
			<div class="col-sm-6">
		        <label for="Expense">Activity type</label>
			</div>
			<div class="col-sm-6">
		        <select name="Expense" id="Expense" class="col-md-10">
		            <option value="0">Choose</option>
					<?
					foreach ($opis as $v => $t) { echo '<option value="'.$v.'">'.$t.'</option>'; }
					?>
		        </select>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
		        <label for="Vehicle">Vehicles</label>
			</div>
			<div class="col-sm-6">
		        <select name="Vehicle" id="vehicle" class="col-md-10"  >
		            <option value="0">Choose</option>
					<?
						foreach ($opis2 as $v => $t) { 
							if ($_SESSION['VehicleID']==$v) $selected="selected";
							else $selected="";
							echo "<option value='".$v."' ".$selected.">".$t."</option>"; 
						}
					?>
		        </select>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
		        <label for="Description">Description</label>
			</div>
			<div class="col-sm-6">
				<textarea id="Description" name="Description" rows="4" cols="50">
					
				</textarea>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
		        <label for="DocumentImage">Document Image</label>
			</div>
			<div class="col-sm-6">
				<input id='photo' type="file" style='display:none' name="DocumentImage" accept="image/*" capture="camera">
				<button id='photo2' type="button" name="photo"  class="btn btn-primary btn-block ">TAKE A PHOTO</button>		
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
		        <label for="ActionImage">Activity Video</label>
			</div>
			<div class="col-sm-6">
				<input id='photo_ac' type="file" style='display:none' name="ActionImage" accept="video/*" capture="camera">
				<button id='photo2_ac' type="button" name="photo_ac"  class="btn btn-primary btn-block ">TAKE A VIDEO</button>		
			</div>
		</div>			
		<input type="hidden" name="OwnerID" id="OwnerID" value="<?= $_SESSION['OwnerID'] ?>">	
		<input type="hidden" name="DriverID" id="DriverID" value="<?= $_SESSION['DriverID'] ?>">
		<input type="hidden" name="VehicleID" id="VehicleID" value="<?= $_SESSION['VehicleID'] ?>">

		<div>
	        <button type="submit" name="addExpense" value="Add" class="btn btn-primary btn-block l">
	        <i class="fa fa-chevron-down"></i> Add</button>
		</div>
    </form>

	<form id="expensesList" class="pad1em" action="index.php?p=activity" method="POST">
		<? foreach($ex as $key => $exp) { ?>
			<div class="row table" style="margin:6px 0">
				<div class="col-sm-1">
					<?= ymd2dmy($exp['Datum']) ?>
				</div>
				<div class="col-sm-2">
					<?= $opis[$exp['Expense']] ?>
				</div>
				<div class="col-sm-2">
					<?= $opis2[$exp['Vehicle']] ?>
				</div>						
				<div class="col-sm-2" style="text-align:right">		
					<img  class="small" src="<?= $exp['DocumentImage'] ?>" alt="" height="50" width="50">
				</div>
				<div class="col-sm-2" style="text-align:right">		
					<? if (!empty($exp['ActionImage'])) { ?>
					<video height="50" width="50" controls>
						<source src="<?= $exp['ActionImage'] ?>" type="video/mp4">
					</video>
					<? } ?>
				</div>				
				<div class="col-sm-2" style="text-align:right">		
					<? if ($exp['Expense']==113 && $exp['Vehicle']>0)  { ?>
						<a href='index.php?p=check&VehicleID=<?= $exp['Vehicle'] ?>&ActivityID=<?= $exp['ID'] ?>'>CHECK LIST</a>
					<? } ?>
				</div>	
				
				<div class="col-sm-1" style="text-align:right">
					<button type="submit" name="expID" value="<?= $key ?>" class="btn btn-danger" title="Delete">
					<i class="fa fa-times-circle l"></i></button>
				</div>
			</div>
			<hr>
		<? } ?>
	</form>

	
	<div class="row">
		<div class="col-xs-12 pad1em">
			<div class="btn btn-danger btn-block l" onclick="window.print();">
			<i class="fa fa-print l"></i> Save and Print</div>
		</div>
	</div>


	
</div>

<script>
	$("#vehicle").hide();

	$("#photo2").click(function(){
		$( "#photo" ).trigger( "click" );
	})	
	$("#photo2_ac").click(function(){
		$( "#photo_ac" ).trigger( "click" );
	})		
	$('img').click(function() {
		$(this).attr('class','large');	
	})	

	$("#Expense").change(function() {
		var id = $('#Expense option:selected').val();
		if (id==109) $("#vehicle").show(500);
		else {
			$("#vehicle").hide(500);
			var idc=$('#VehicleID').val();
			$("#vehicle").val(idc);
		}	
 
});	
	
</script>