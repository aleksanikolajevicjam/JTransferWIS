<?
	$smarty->assign('page',$md->getName());	
	
	$filename = ROOT . '/plugins/'.$md->getBase(). '/headerImages.inc';

	if (is('setImages', 'r') and r('setImages') == 1) {
		$somecontent = r('firstImage').';'.r('secondImage').';'.r('thirdImage');

		// Let's make sure the file exists and is writable first.
		if (is_writable($filename)) {

			// In our example we're opening $filename in append mode.
			// The file pointer is at the bottom of the file hence
			// that's where $somecontent will go when we fwrite() it.
			if (!$handle = fopen($filename, 'w')) {
				 echo "Cannot open file ($filename)";
				 exit;
			}

			// Write $somecontent to our opened file.
			if (fwrite($handle, $somecontent) === FALSE) {
				echo "Cannot write to file ($filename)";
				exit;
			}

			echo "Success";

			fclose($handle);

		} else {
			echo "The file $filename is not writable";
		}		
				
	
	} 
		
	// uzmi podatke iz file-a
	$images = file_get_contents($filename ,  FILE_USE_INCLUDE_PATH);
	$img = explode(';', $images);
	$smarty->assign('img',$img);
	


