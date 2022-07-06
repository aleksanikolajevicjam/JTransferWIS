<?
$result = $db->RunQuery('SELECT * FROM v4_AuthUsers 
					WHERE AuthUserID = "'.$_REQUEST['sa_u'].'" 
					AND AuthLevelID = "'.$_REQUEST['sa_l'].'"');			

if($result->num_rows == 1)
{
	$row = $result->fetch_assoc();

	if($row['Active'] == 1)
	{
		$_SESSION = array();
		session_destroy();
		session_start();
		$sql = 'SELECT Average FROM v4_ExchangeRate WHERE Name = "EUR"';
		$rEur = $db->RunQuery($sql);
		$Eur = $rEur->fetch_assoc();
				
		if ($row['CountryName']=='Serbia' &&  $row['AuthLevelID']==2) {				//$_SESSION['Currency'] = 'RSD';
			$_SESSION['Currency'] = 'EUR';
			$_SESSION['ExchFaktor'] = 1.035;					
		}				
		else {
			$_SESSION['Currency'] = 'EUR';	
			$_SESSION['ExchFaktor'] = 1;
		}
		if (in_array($row['AuthUserID'], array(2828,2830,2831,2846))) {
			$_SESSION['CurrencyRate'] = $Eur['Average'];
			$_SESSION['Currency2'] = 'HRK';
		}	
		else {
			$_SESSION['CurrencyRate'] = 1;
			$_SESSION['Currency2'] = 'EUR';
		}	
		$_SESSION['AdminAccessToDriverProfile'] = true;
		$_SESSION['UserName'] = $row['AuthUserName'];
		$_SESSION['UserRealName'] = $row['AuthUserRealName'];
		$_SESSION['UserCompany'] = $row['AuthUserCompany'];
		$_SESSION['AuthUserID'] = $row['AuthUserID'];
		$_SESSION['OwnerID'] = $row['AuthUserID'];
		$_SESSION['AuthLevelID'] = $row['AuthLevelID'];
		$_SESSION['MemberSince'] = $row['DateAdded'];
		$_SESSION['AuthUserNote1'] = $row['AuthUserNote1'];
		$_SESSION['Provision'] = $row['Provision'];
		
		$r = $db->RunQuery("SELECT * FROM v4_AuthLevels 
							WHERE AuthLevelID = " . $_REQUEST['sa_l']);	
		$level = $r->fetch_object();
		
		$_SESSION['GroupProfile'] = ucfirst(strtolower($level->AuthLevelName));
		$_SESSION['UserAuthorized'] = TRUE;
		$_SESSION['UserImage'] = $row['Image'];
		$_SESSION['UserEmail'] = $row['AuthUserMail'];
	}
	else {
		$error = '<br/><b>No such User or User not active.</b><br/>
		Please contact support immediately!';
		die($error);
	}
}