<?

	if(isset($_POST['Login']))
	{
		if($_POST['username']!='' && $_POST['password']!='')
		{
			$tempPass = md5($_POST['password']);
			//Use the input username and password and check against 'users' table
			/*$query = mysql_query('SELECT * FROM '.DB_PREFIX.'AuthUsers 
								WHERE AuthUserName = "'.mysql_real_escape_string($_POST['username']).'" 
								AND AuthUserPass = "'.mysql_real_escape_string($tempPass).'"');
*/


			$q = "SELECT * FROM v4_SubDrivers";
			$q .= " WHERE DriverName = '" . mysqli_real_escape_string($con, $_POST['username']) . "'";
			$q .= " AND DriverPassword = '" . mysqli_real_escape_string($con, $tempPass) . "'";

/*
			$q = "SELECT * FROM v4_AuthUsers ";
			$q .= " WHERE AuthUserName = '" . mysqli_real_escape_string($con, $_POST['username']) . "'";
			$q .= " AND AuthUserPass = '" . mysqli_real_escape_string($con, $tempPass) . "'";
*/

			$query = mysqli_query($con, $q) or die('Error in SubDrivers query <br>' . mysqli_connect_error());

			if(mysqli_num_rows($query) == 1)
			{
				$row = mysqli_fetch_assoc($query);
				/*if($row['Active'] == 1)
				{
				*/
					//session_destroy();
					session_start();
					$_SESSION['OwnerID'] = $row['OwnerID'];
					$_SESSION['DriverName'] = $row['DriverName'];
					$_SESSION['DriverID'] = $row['DriverID'];
					$_SESSION['logged'] = TRUE;
					$_SESSION['option'] = 'menu';
					header("Location: index.php?option=menu");
				/*}
				else {
					$error = '<br/><b>Your account is not active.</b><br/>
					Please contact us immediately!';
				}*/
			}
			else {
				$error = 'Error: Login failed !';
			}
		}
		else {
			$error = 'Please user both your username and password to access your account';
		}
	}
?>

