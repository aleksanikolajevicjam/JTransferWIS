<link rel="stylesheet" type="text/css" href="css/bogoMain.css" />
<br/><br/><br/>
<div style="margin:0 auto;width: 400px !important;" class="dashboard_pannel" >
<div class="dashboard_pannel_header" style="width: 391px !important;">
Taxido&trade; Password Reset Request</div>
<div class="dashboard_pannel_content">
<?
#
# New php file
#
# Author: Bogasin Soic-Mirilovic
#
#

require_once 'JM_database.php';
require_once 'JM_config.php';
require_once "funcs/functions.php";

# reCAPTCHA KEYS
$publickey = "6Lfm0cgSAAAAANtsCM04S7ncie8OKEbhpWgKfjZG";
$privatekey = "6Lfm0cgSAAAAAB9x1smlR2hA2dx2cgZkOz3fXFgS";

	if(isset($_POST['Submit']))
	{

		# RECAPTCHA CHECK
	    require_once('recaptchalib.php');

	    $resp = recaptcha_check_answer ($privatekey,
			                      $_SERVER["REMOTE_ADDR"],
			                      $_POST["recaptcha_challenge_field"],
			                      $_POST["recaptcha_response_field"]);

	    if (!$resp->is_valid) {
		    $error = "<h2>Image Verification failed!.
									    Please try again.</h2>" ;
		    # reCAPTCHA end

		    # Clear POST data
		    $_POST = array();

	    }
	    else
	    {

		    if($_POST['email']!='' ) //&& valid_email($_POST['email'])==TRUE)
		    {

			    $getUser = mysql_query('SELECT AuthUserID, AuthUserName, Temp_pass, AuthUserMail FROM '.DB_PREFIX.'AuthUsers WHERE AuthUserMail = "'.mysql_real_escape_string($_POST['email']).'"');
			    if(mysql_num_rows($getUser)==1)
			    {

				    $temp_pass = random_string('alnum', 12);
				    $row = mysql_fetch_assoc($getUser);

				    $query = mysql_query("UPDATE ".DB_PREFIX."AuthUsers SET Temp_pass='".$temp_pass."', Temp_pass_active=1 WHERE `AuthUserMail`='".mysql_real_escape_string($row['AuthUserMail'])."'");

				    //$headers = 	'From: webmaster@ourdomainhere.com' . "\r\n" .
	        		//			'Reply-To: webmaster@ourdomainhere.com' . "\r\n" .
	        		//			'X-Mailer: PHP/' . phpversion();
				    $subject = "Password Reset Request";
				    $message = "Dear ".$row['AuthUserRealName'].", <br/>Someone (presumably you), has requested a password reset. <br/><br/>We have generated a new password for you to access our website:<br/> ".$temp_pass."  <br/><br/>To confirm this change and activate your new password please follow this link to our website: <br/><br/><a href='".SITE_URL."JM_confirmpass.php?ID=".$row['AuthUserID']."&new=".$temp_pass."'>Click here</a><br/><br/> Don't forget to update your profile as well after confirming this change and create a new password. <br/>If you did not initiate this request, simply disregard this email.";


				    if(
				    //mail($row['AuthUserMail'], $subject, $message, $headers) )
				    mail_html($row['AuthUserMail'], "info@taxido.net", "Taxido Reset Pass",
				     "info@taxido.net", $subject, $message))
				    {
					    $msg = 'Password reset request sent. Please check your email for instructions.';
				    }
				    else {
					    $error = 'Failed sending email';
				    }
			    }
			    else {
				    $error = 'There is no user with this e-mail.';
			    }
		    }
		    else {
			    $error = 'Invalid e-mail !';
		    }
        }
	}
?>
<?php if(isset($error)){
	echo '<div><h2>';
	echo $error;
	echo '</h2></div>';
}?>

<?php if(isset($msg)){ echo $msg;} else {
//if we have a mesage we don't need this form again. ?>


<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
<br/>
Enter e-mail address that you used to register.<br/>
New password will be sent to this address.<br/>
Your old password will be replaced with new one.<br/><br/>
    <div align="center">
    	E-Mail: <input type="text" id="email" name="email" size="32" value="" /><br><br/>

				<?php
				require_once('recaptchalib.php');
				echo recaptcha_get_html($publickey);
				?>
	</div>
	<div align="right">
    	<input type="submit" name="Submit" value="Submit" />
    </div>
</form>

</div>
</div>
<? }

?>

