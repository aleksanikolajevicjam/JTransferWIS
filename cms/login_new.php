<?
#
# Login Form 
#
# Author: Bogasin Soic-Mirilovic
#
#
error_reporting(0);

session_start();
$_SESSION = array();

# Language
$_SESSION['CMSLang'] = 'en';
if(!empty($_COOKIE['CMSLang'])) $_SESSION['CMSLang'] = $_COOKIE['CMSLang'];
require_once('lng/' . $_SESSION['CMSLang'] . '_text.php');

if(!isset($_SESSION['UserAuthorized']) or $_SESSION['UserAuthorized'] !== true) {

	# Config File
	require_once ROOT . '/db/db.class.php';
	
	define("DB_PREFIX", "v4_");
	$db = new DataBaseMysql();

	$showLoginForm = true;

		if(isset($_REQUEST['Login']) or ($_REQUEST['userid'])) 
		{
			if(($_REQUEST['username']!='' && $_REQUEST['password']!='') or ($_REQUEST['userid']))
			{
				// ovo je druga varijanta, ali nije u upotrebi za ovu db. taxido ovo koristi
				//$tempPass = sha1($_REQUEST['password'] . md5($_REQUEST['username']));
			
				$tempPass = md5($_REQUEST['password']);
				$cleanUserName 	= $db->conn->real_escape_string($_REQUEST['username']);
				$cleanPass		= $db->conn->real_escape_string($tempPass);
			
				//Use the input username and password and check against 'users' table
				if ($_REQUEST['userid']) {
					//Use the input username and password and check against 'users' table
					$result = $db->RunQuery('SELECT * FROM '.DB_PREFIX.'AuthUsers 
										WHERE  AuthUserID = "'.$_REQUEST['userid'].'"');						
				}
				else {
					//Use the input username and password and check against 'users' table
					$result = $db->RunQuery('SELECT * FROM '.DB_PREFIX.'AuthUsers 
										WHERE AuthUserName = "'.$cleanUserName.'" 
										AND AuthUserPass = "'.$cleanPass.'"');		
					//blok za registrovanje ulaza u administraciju cms-a			
					$current_ip=$_SERVER['REMOTE_ADDR'];
					$visitor_ip=ip2long(ltrim(rtrim($current_ip)));
					$access_time=time();
					$result2 = $db->RunQuery('INSERT INTO `LogUser`(`ip_address`, `time`) VALUES ("'.$current_ip.'",'.$access_time.')');
					
				}	
			
				/*
				//Use the input username and password and check against 'users' table
				$result = $db->RunQuery('SELECT * FROM '.DB_PREFIX.'AuthUsers 
									WHERE AuthUserName = "'.$_REQUEST['username'].'" 
									AND AuthUserPass = "'.$tempPass.'"');
				*/
				
				if($result->num_rows == 1)
				{
				
					$row = $result->fetch_assoc();
				
					if($row['Active'] == 1)
					{
						session_start();
						$_SESSION['UserName'] = $row['AuthUserName'];
						$_SESSION['UserRealName'] = $row['AuthUserRealName'];
						$_SESSION['UserCompany'] = $row['AuthUserCompany'];
						$_SESSION['AuthUserID'] = $row['AuthUserID'];
						$_SESSION['OwnerID'] = $row['AuthUserID'];
						$_SESSION['AuthLevelID'] = $row['AuthLevelID'];
						$_SESSION['MemberSince'] = $row['DateAdded'];
						
						if($row['AuthLevelID'] == '2') $_SESSION['Provision'] = $row['Provision'];
						if($row['AuthLevelID'] == '4') $_SESSION['Provision'] = $row['Provision'];
						if($row['AuthLevelID'] == '5') $_SESSION['Provision'] = $row['Provision'];
						
						$r = $db->RunQuery("SELECT * FROM ".DB_PREFIX."AuthLevels 
											WHERE AuthLevelID = " . $row['AuthLevelID']);
						$level = $r->fetch_object();
						$_SESSION['GroupProfile'] = ucfirst(strtolower($level->AuthLevelName));
						
						$_SESSION['UserAuthorized'] = TRUE;
						$_SESSION['UserImage'] = $row['Image'];
						$_SESSION['UserEmail'] = $row['AuthUserMail'];
						$showLoginForm = false;
						
						$qu  = "UPDATE v4_AuthUsers SET LastVisited = '".date("Y-m-d H:i:s") ."' ";
						$qu .= " WHERE AuthUserID = '" .$_SESSION['AuthUserID']. "'";
						$db->RunQuery($qu);
				
						// vraca korisnika na link s kojim je dosao ovdje
						// InitialRequest se puni u index.php
						
						if (isset($_SESSION['InitialRequest']) and $_SESSION['InitialRequest'] !='') {
							header("Location: ". $_SESSION['InitialRequest']);
						} else {
							header("Location: index.php");
							
						}
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

	if ($showLoginForm) {


	?>
	<!DOCTYPE html>
	<html style="background: transparent  url('../i/header/121.jpg') center fixed;background-size:cover;">
	<head>
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
	<link rel="stylesheet" href="css/theme.css" type="text/css" />
	<style>
	    .shadow{
	        -webkit-box-shadow: 0px 0px 16px 0px rgba(50, 50, 50, 0.75);
            -moz-box-shadow:    0px 0px 16px 0px rgba(50, 50, 50, 0.75);
            box-shadow:         0px 0px 16px 0px rgba(50, 50, 50, 0.75);
	        }
        .form-signin {
          max-width: 330px;
          padding: 15px;
          margin: 0 auto;
        }
        .form-signin .form-signin-heading,
        .form-signin .checkbox {
          margin-bottom: 10px;
        }
        .form-signin .checkbox {
          font-weight: normal;
        }
        .form-signin .form-control {
          position: relative;
          height: auto;
          -webkit-box-sizing: border-box;
             -moz-box-sizing: border-box;
                  box-sizing: border-box;
          padding: 10px;
          font-size: 16px;
        }
        .form-signin .form-control:focus {
          z-index: 2;
        }
        .form-signin input[type="email"] {
          margin-bottom: -1px;
          border-bottom-right-radius: 0;
          border-bottom-left-radius: 0;
        }
        .form-signin input[type="password"] {
          margin-bottom: 10px;
          border-top-left-radius: 0;
          border-top-right-radius: 0;
        }	        
	</style>
	</head>

	<body style="background:transparent;display:block">
    <div class="container">
        <br><br><br><br>
      <form class="form-signin" method="post" action="<?= $_SERVER['PHP_SELF'];?>">
        <h2 class="form-signin-heading">Sign in</h2>
        <?= $error ?>
        <label for="username" class="sr-only">User name</label>
        <input type="text" name="username" id="username" class="form-control" placeholder="User name" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>

        <button class="btn btn-lg btn-primary btn-block" name="Login" type="submit">Sign in</button>
      </form>
		
    </div> <!-- /container -->
		    <br><br><br><br>

	</body>
	</html>

	<? } ?>
<? 
}
// already Logged in 
header("Location: index.php");

