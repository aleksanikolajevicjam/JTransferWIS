<?
	@session_start();
	
	if(isset($_SESSION['language']) and $_SESSION['language'] != '' and 
	file_exists(ROOT . '/lng/'.$_SESSION['language'].'.php')) {
	
		require_once ROOT . '/lng/'.$_SESSION['language'].'.php';
	}
	else {
		$_SESSION['language'] = 'en';
		require_once ROOT . '/lng/en.php';
	}	

