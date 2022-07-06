<?
	$smarty->assign('page',$md->getName());	
	
	$filename1 = ROOT . '/plugins/'.$md->getBase(). '/approvedFuelPrice_Nice.inc';
	$filename2 = ROOT . '/plugins/'.$md->getBase(). '/approvedFuelPrice_Lyon.inc';
	$filename3 = ROOT . '/plugins/'.$md->getBase(). '/approvedFuelPrice_Split.inc';
	
	if (is('setRate', 'r') and r('setRate') == 1) {
		//Nice
		$somecontent1 = r('approvedFuelPrice1');
		// Let's make sure the file exists and is writable first.
		if (is_writable($filename1)) {
			if (!$handle1 = fopen($filename1, 'w')) {
				 echo "Cannot open file ($filename1)";
				 exit;
			}
			// Write $somecontent to our opened file.
			if (fwrite($handle1, $somecontent1) === FALSE) {
				echo "Cannot write to file ($filename)";
				exit;
			}
			fclose($handle1);
		} else echo "The file $filename is not writable";
		//Lyon
		$somecontent2 = r('approvedFuelPrice2');
		// Let's make sure the file exists and is writable first.
		if (is_writable($filename2)) {
			if (!$handle2 = fopen($filename2, 'w')) {
				 echo "Cannot open file ($filename2)";
				 exit;
			}
			// Write $somecontent to our opened file.
			if (fwrite($handle2, $somecontent2) === FALSE) {
				echo "Cannot write to file ($filename)";
				exit;
			}
			fclose($handle2);
		} else echo "The file $filename is not writable";		
		//Split
		$somecontent3 = r('approvedFuelPrice3');
		// Let's make sure the file exists and is writable first.
		if (is_writable($filename3)) {
			if (!$handle3 = fopen($filename3, 'w')) {
				 echo "Cannot open file ($filename3)";
				 exit;
			}
			// Write $somecontent to our opened file.
			if (fwrite($handle3, $somecontent3) === FALSE) {
				echo "Cannot write to file ($filename)";
				exit;
			}
			fclose($handle3);
		} else echo "The file $filename is not writable";			
		
		
	} 
	// uzmi podatke iz file-a
	$afp1 = file_get_contents($filename1, FILE_USE_INCLUDE_PATH);
	$_SESSION['afp1'] = $afp1;
	$afp2 = file_get_contents($filename2, FILE_USE_INCLUDE_PATH);
	$_SESSION['afp2'] = $afp2;
	$afp3 = file_get_contents($filename3, FILE_USE_INCLUDE_PATH);
	$_SESSION['afp3'] = $afp3;	
	
	if ($_SESSION['AuthUserID']!=843 && $_SESSION['AuthLevelID']!=91) $style1="style='display:none'";
	else $style1="";
	if ($_SESSION['AuthUserID']!=876 && $_SESSION['AuthLevelID']!=91) $style2="style='display:none'";
	else $style2="";
	if ($_SESSION['AuthUserID']!=556 && $_SESSION['AuthLevelID']!=91) $style3="style='display:none'";
	else $style3="";

	$smarty->assign('style1',$style1);
	$smarty->assign('style2',$style2);
	$smarty->assign('style3',$style3);
	$smarty->assign('afp1',$afp1);
	$smarty->assign('afp2',$afp2);
	$smarty->assign('afp3',$afp3);


