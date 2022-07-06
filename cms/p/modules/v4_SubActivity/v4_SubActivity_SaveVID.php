<?
//header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
//die(var_dump(ROOT."/subdriver/uploads/"));
	if (isset($_FILES["ActionImageX"]) && !empty(basename($_FILES["ActionImageX"]["name"]))) { 
		$target_doc_dir = ROOT."/cms/subdriver/uploads/";
		$target_doc_file = $target_doc_dir . basename($_FILES["ActionImageX"]["name"]);
		// Check if image file is a actual image or fake image
		move_uploaded_file($_FILES["ActionImageX"]["tmp_name"],$target_doc_file);
		echo basename($_FILES["ActionImageX"]["name"]);
	}
