<?php
	error_reporting(E_PARSE);
	
	$error = "";
	$msg = "";
	
	// ime elementa iz forma - npr. input type="file" name="imageFile"
	$fileElementName = 'PDFFile_'.$_REQUEST['i'];

	// Spremi podatke za ovu sliku u array
	$IMAGE = array();
	$IMAGE = $_FILES[$fileElementName];
	
	// temp folder - relativan u odnosu na ovu skriptu
	$tempFolder = '../../../raspored/PDF/';
	
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
			
			if(filesize($IMAGE['tmp_name']) > 1204800) { // file too big
				$error = 'Max. size allowed is 1200kB';
			} elseif ($IMAGE['type'] != 'application/pdf') {
				$error = 'Sorry! Only .pdf files are allowed.';
			} else {		
			
				$msg .= 'FILE UPLOADED \n';
				$msg .= " File Name: " . $IMAGE['name'] . ", ";
				$msg .= " File Size: " . @filesize($IMAGE['tmp_name']);
				//$msg .= " File Type: " . $IMAGE['type'];
			
				//for security reason, we force to remove all uploaded file
				//@unlink($_FILES['fileToUpload']);	
				
				// spremi u temp folder, deleteTempImage.php ce kasnije sliku izbrisati
				move_uploaded_file ( $IMAGE['tmp_name'] , $tempFolder . $IMAGE['name']);
			

				// spremi sliku u BLOB polje u datoteci			
				require_once 'data.php';
		
				mysqli_query($conn, "UPDATE v4_OrderDetails SET 
								PDFFile = '".$IMAGE['name'] ."' 
								WHERE DetailsID = " . $_REQUEST['DetailsID']
							);
				// spremljeno - showProfileImage.php prikazuje sliku
			}			
	}

	echo "{";
	echo				"error: '" . $error . "',\n";
	echo				"msg: '" . $msg . "',\n";
	echo				"img: '" . $IMAGE['name'] . "'\n";
	echo "}";

