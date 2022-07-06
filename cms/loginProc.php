<?
require_once 'config.php';
$error = '';


	if(isset($_POST['Login']))
	{
		if($_POST['username']!='' && $_POST['password']!='')
		{
			$tempPass = sha1($_POST['password'] . md5($_POST['username']));
			//Use the input username and password and check against 'users' table
			$query = mysql_query('SELECT * FROM '.DB_PREFIX.'AuthUsers 
								WHERE AuthUserName = "'.mysql_real_escape_string($_POST['username']).'" 
								AND AuthUserPass = "'.mysql_real_escape_string($tempPass).'"');

			if(mysql_num_rows($query) == 1)
			{
				$row = mysql_fetch_assoc($query);
				if($row['Active'] == 1)
				{
					session_start();
					$_SESSION['AuthUserName'] = $row['AuthUserName'];
					$_SESSION['AuthUserRealName'] = $row['AuthUserRealName'];
					$_SESSION['AuthUserID'] = $row['AuthUserID'];
					$_SESSION['OwnerID'] = $row['AuthUserID'];
					$_SESSION['AuthLevelID'] = $row['AuthLevelID'];
					$_SESSION['UserAuthorized'] = TRUE;
					header("Location: index.php");
				}
				else {
					$error = '<br/><b>Your account has been blocked.</b><br/>
					Please contact us immediately!';
				}
			}
			else {
				$error = LOGIN_FAILED;
			}
		}
		else {
			$error = USE_BOTH;
		}
	}

