<?
//header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
//die(var_dump(ROOT."/subdriver/uploads/"));
	if (isset($_FILES["DocumentImageX"]) && !empty(basename($_FILES["DocumentImageX"]["name"]))) { 
		$target_doc_dir = ROOT."/cms/subdriver/uploads/";
		$target_doc_file = $target_doc_dir . basename($_FILES["DocumentImageX"]["name"]);
		// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES["DocumentImageX"]["tmp_name"]);
		if($check !== false) {
			move_uploaded_file($_FILES["DocumentImageX"]["tmp_name"],$target_doc_file);
			echo basename($_FILES["DocumentImageX"]["name"]);
		}	
		else echo "File is not an image.";			
		
	}