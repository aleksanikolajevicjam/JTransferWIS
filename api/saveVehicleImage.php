<?php
	error_reporting(E_PARSE);
	
	$error = "";
	$msg = "";
	
	// ime elementa iz forma - npr. input type="file" name="imageFile"
	$fileElementName = 'imageFile'.$_REQUEST['ImageNo'];
	
	// Spremi podatke za ovu sliku u array
	$IMAGE = array();
	$IMAGE = $_FILES[$fileElementName];
	
	// temp folder - relativan u odnosu na ovu skriptu
	$tempFolder = '../vehicles/';
	$dbFolder	= 'vehicles/';
	
		
	require_once '../../db/db.class.php';
	$db = new DataBaseMysql();
	

	// brisanje stare slike
	$q = "SELECT * FROM v4_Vehicles ";
	$q .= " WHERE VehicleID = '" . $_REQUEST['VehicleID']."'";	
	$r = $db->RunQuery($q);

	$i = $r->fetch_object();
	
	
	if ($_REQUEST['ImageNo'] == '1' )  $oldImageName = $i->VehicleImage;
	if ($_REQUEST['ImageNo'] == '2' )  $oldImageName = $i->VehicleImage2;
	if ($_REQUEST['ImageNo'] == '3' )  $oldImageName = $i->VehicleImage3;
	if ($_REQUEST['ImageNo'] == '4' )  $oldImageName = $i->VehicleImage4;	


	
	$OldImage = $tempFolder.$oldImageName;
	if(file_exists($OldImage)) unlink($OldImage);	
	
	if ($_REQUEST['operation']!='delete') {	

		if(!empty($IMAGE['error']))
		{
			switch($IMAGE['error'])
			{

				case '1':
					$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
					break;
				case '2':
					$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
					break;
				case '3':
					$error = 'The uploaded file was only partially uploaded';
					break;
				case '4':
					$error = 'No file was uploaded.';
					break;

				case '6':
					$error = 'Missing a temporary folder';
					break;
				case '7':
					$error = 'Failed to write file to disk';
					break;
				case '8':
					$error = 'File upload stopped by extension';
					break;
				case '999':
				default:
					$error = 'No error code avaiable';
			}// end switch
			
		} elseif(empty($IMAGE['tmp_name']) || $IMAGE['tmp_name'] == 'none') { // no name
			$error = 'No file was uploaded..';
		} else { // no errors
				
				if(filesize($IMAGE['tmp_name']) > 204800) { // file too big
					$error = 'Max. size allowed is 200kB';
				} elseif ($IMAGE['type'] != 'image/jpeg') {
					$error = 'Sorry! Only .jpg images are allowed.';
				} else {		
				
					$msg .= 'FILE UPLOADED \n';
					$msg .= " File Name: " . $IMAGE['name'] . ", ";
					$msg .= " File Size: " . @filesize($IMAGE['tmp_name']);
					$msg .= " File Type: " . $IMAGE['type'];
				
					//for security reason, we force to remove all uploaded file
					@unlink($_FILES['fileToUpload']);	

					$randomImageName = rand().time().'.jpg';
					// spremi u vehicles/ folder
					move_uploaded_file ( $IMAGE['tmp_name'] , $tempFolder . $randomImageName);
				

					// spremi ime slike u db		
			
					$q = "UPDATE v4_Vehicles SET ";
					if ($_REQUEST['ImageNo'] == '1' )  $q .= "VehicleImage  = '".$dbFolder.$randomImageName."'";
					if ($_REQUEST['ImageNo'] == '2' )  $q .= "VehicleImage2 = '".$dbFolder.$randomImageName."'";
					if ($_REQUEST['ImageNo'] == '3' )  $q .= "VehicleImage3 = '".$dbFolder.$randomImageName."'";
					if ($_REQUEST['ImageNo'] == '4' )  $q .= "VehicleImage4 = '".$dbFolder.$randomImageName."'";
					$q .= " WHERE VehicleID = '" . $_REQUEST['VehicleID']."'";
				
					$db->RunQuery($q);
					// spremljeno - showProfileImage.php prikazuje sliku
				}			
		}

		echo "{";
		echo				"error: '" . $error . "',\n";
		echo				"msg: '" . $msg . "',\n";
		echo				"img: '" .  $dbFolder . $randomImageName . "'\n";
		echo "}";

	}
	
	else {
		$q = "UPDATE v4_Vehicles SET ";
		if ($_REQUEST['ImageNo'] == '1' )  $q .= "VehicleImage  = ''";
		if ($_REQUEST['ImageNo'] == '2' )  $q .= "VehicleImage2 = ''";
		if ($_REQUEST['ImageNo'] == '3' )  $q .= "VehicleImage3 = ''";
		if ($_REQUEST['ImageNo'] == '4' )  $q .= "VehicleImage4 = ''";
		$q .= " WHERE VehicleID = '" . $_REQUEST['VehicleID']."'";
				
		$db->RunQuery($q);
		echo "{";
		echo				"error: '" . $error . "',\n";
		echo				"msg: '" . $msg . "',\n";
		echo				"img: ''\n";
		echo "}";

		
	}	
