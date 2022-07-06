<?
	$smarty->assign('page',$md->getName());	
	@session_start();
	if (!$_SESSION['UserAuthorized']) die('Bye, bye');
	# Init Values - this month, this year
	//$cMonth = date("m"); $cYear=date("Y");

	if (!isset($_REQUEST["cal_month"])) {
		if (!isset($_SESSION["cal_month"])) $cMonth = date("m");
		else $cMonth = $_SESSION["cal_month"];
	}
	else {
		$_SESSION['cal_month'] = $_REQUEST["cal_month"];
		$cMonth = $_REQUEST["cal_month"];
	}

	if (!isset($_REQUEST["cal_year"])) {
		if (!isset($_SESSION["cal_year"])) $cYear = date("Y");
		else $cYear = $_SESSION["cal_year"];
	}
	else {
		$_SESSION['cal_year'] = $_REQUEST["cal_year"];
		$cYear = $_REQUEST["cal_year"];
	}
	$smarty->assign('cMonth',$cMonth);
	$smarty->assign('cYear',$cYear);
	$shmonth = new SmartyHtmlSelection("month",$smarty);
	for ($i=1; $i<13; $i++)
	{
		$shmonth->AddValue($i);
		$shmonth->AddOutput($monthNames[$i-1]);
		if ($i == $cMonth) $shmonth->AddSelected($i);
	}
	$shmonth->SmartyAssign();

	$shyear = new SmartyHtmlSelection("year",$smarty);
	for ($i=date("Y")-2; $i<date("Y")+5; $i++)	{
		$shyear->AddValue($i);
		$shyear->AddOutput($i );
		if ($i == $cYear) $shyear->AddSelected($i);
	}
	$shyear->SmartyAssign();

