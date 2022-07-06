<?
error_reporting(E_PARSE);
	@session_start(); 
	
	// LOGIN
	if(!isset($_SESSION['UserAuthorized']) or $_SESSION['UserAuthorized'] == false) {
		header("Location: login.php");
		die();
	}

	//echo '<pre>'; print_r($_REQUEST); echo '</pre>';

	//The second parameter on print_r returns the result to a variable rather than displaying it
	$RequestSignature = md5($_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING'].print_r($_POST, true));

	if ($_SESSION['LastRequest'] == $RequestSignature)
	{
	// refresh
	$Refresh = false; //true
	}
	else
	{
	  // This is a new request.
	  $_SESSION['LastRequest'] = $RequestSignature;
	  $Refresh = false;
	}
?>

<div class="container">
	<h2>Booking Free Form</h2>
	<br>
	<div class="alert alert-danger">
	<i class="fa fa-ban xl xwhite red-text"></i> 
	Za ručni unos kliknite gumb "Next"<br>
	Za automatski unos ucitajte *.xml file i pritisnite "Upload"<br><br>
	
	</div>
</div>
<div class="container white">
	<div class="row">
		<div class="col-md-6" style="color:white;text-decoration:none;background-color:none;">
			<a href="https://www.jamtransfer.com/cms/index.php?p=freeForm"><p class="col-md-2 btn btn-success">Next</p></a>
		</div>
	</div>
	<br>
</div>

<form action="index.php?p=freeFormUpload" method="POST" enctype="multipart/form-data" class="container white">
	<div class="row">
		<div class="col-md-6">
			<input name='upload' type='file'/>
			<input class="col-md-2 btn btn-warning" action="index.php?p=freeFormUpload" type="submit" value="Upload" />
		</div>
	</div>
</form>


