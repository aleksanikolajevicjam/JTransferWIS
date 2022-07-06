<?
session_start();
    require_once "../db.php";
#    require "../funcs/taxidoFuncs.php"; 
#    require "../funcs/db_funcs.php"; 
#    require "../funcs/form_functions.php"; 


if(!isset($_SESSION['OwnerID']) or $_SESSION['OwnerID'] == '') $_SESSION['logged'] = false;
if(!isset($_SESSION['DriverID']) or $_SESSION['DriverID'] == '') $_SESSION['logged'] = false;

define("DB_PREFIX","");
	$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
//	mysql_select_db(DB_NAME,$con);

# Not logged in
if ( !$_SESSION['logged'] ) {
	session_destroy();
	$_SESSION = array();
	require_once "loginProc.php";
	$action = 'login.php';	

/*
	if (isset($_SESSION['option'])) {
		switch ( $_SESSION['option'] )
		{

			case 'login':
				# process login form
				require "loginProc.php";
	
				$action = 'login.php';
				$_SESSION['page_title']='Login';
				break;

	
			default:
				break;
		}
	
	
	} else {
				require_once "loginProc.php";
				$action = 'login.php';

	}
	*/
} else { 

# Logged in

	if ( isset($_REQUEST['option']) ) $_SESSION['option'] = $_REQUEST['option'];
    switch ($_SESSION['option'])
	    {
		    case 'menu':
			    $action = 'menu.php';
			    break;

		    case 'details':
			    $action = 'details.php';
			    break;

		    case 'finished':
			    $action = 'finished.php';
			    break;

		    case 'nalog':
			    $action = 'nalog.php';
			    break;

		    case 'racun':
			    $action = 'racun.php';
			    break;
			    
		    case 'sign':
			    $action = 'sign.php';
			    break;

		    case 'troskovi':
			    $action = 'expenses.php';
			    break;

		    case 'logout':
			    unset($_SESSION['logged']);
			    session_destroy();
			    header("Location: index.php");
			    break;

            default: $action = 'menu.php'; break;
        }
        
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>JamTransfer</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!--
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />

        <script src="http://code.jquery.com/jquery-1.7.2.min.js">
        </script>
        <script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js">
        </script>
-->
<link rel="stylesheet" href="./css/themes/moja-tema.min.css" />
<link rel="stylesheet" href="./css/themes/jquery.mobile.icons.min.css" />
<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile.structure-1.4.5.min.css" />
<!--link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />-->
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>

        <!-- User-generated css -->
        <style>
        @media print {
        	.header, .footer {display:none !important}
        	* {background: #fff !important; font-size:12px}
        }
        /*small {font-size: 9px}*/
        .ui-page { -webkit-backface-visibility: hidden; }
 html,
body {
	margin:0;
	padding:0;
	height:100%;
}
#wrapper {
	min-height:100%;
	position:relative;
}
#header {

}
#content {
	padding-bottom:100px; /* Height of the footer element */
}
#footer {

	width:100%;
	height:1em;
	padding: .5em;
	position:absolute;
	bottom:0;
	left:0;
}     
        </style>
 
        <!-- User-generated js -->
        <script>
            try {

					$(function() {

					});

				  } catch (error) {
					console.error("Your javascript has an error: " + error);
				  }
        </script>

<style>
.help {display: none;
}

</style>
<script type="text/javascript">

    $("#q").focus(function(){
         $("#q").val('');
    });
/*
    $("#q").keyup(function(){
    
    var qn = $("#q").val().length;
    if (qn > 3) $("#res").html($("#q").val());
    });
    */
</script>
<script type="text/javascript">
    $(document).ready(function(){

     	$("form").bind("keypress", function (e) {
	    if (e.keyCode == 13) {
	    	
        	return false;
    	}   	

		});


 });


</script>
</head>
<body>

<div data-role="page" id="wrapper"  data-theme="a">
 
    <div data-role="header" class="header" id="header">
        <h1 style="font-weight:100"><span style="font-weight:bold">JAM&middot;</span>transfer Driver</h1>
    </div>
 
    <div id="start" data-role="content" id="content">

		<?
			if ( !empty($action) and file_exists($action) ) require $action;
			else echo 'Module not installed. Go Back!';
		?>

    </div>
 <br> <br> <br>
   <? if($_SESSION['logged']) {

		// DIO ZA TROSKOVE
   		if($action != 'expenses.php') {
	   		echo '  <div class="ui-block-b"><br/><br/>
		    <a href="index.php?option=troskovi" data-role="button" data-icon="check" 
		    data-theme="b" data-transition="slide">Expenses</a>
		    </div>';
		}

   		echo '  <div class="ui-block-b"><br/><br/>
        <a href="index.php?option=logout" data-role="button" data-icon="check" 
        data-theme="a" data-transition="slide">Logout</a> <br> <br> <br>
        </div>';

		echo '';
 	} ?>

    <div id="footer" class="footer" data-role="footer" data-theme="b">
        <small> &copy; 2012-<?= date("Y")?> JamTransfer.com
            <? if ($_SESSION['logged']) echo ' :: '.$_SESSION['DriverName']; 
            else echo 'Please Log in'; ?>
            <? if ($_SESSION['DriverName'] == '') echo 'All Drivers Shown'; ?>

        </small>
        
    </div>
 
</div>

</body>
</html>

<?
  function convertTime($ts, $dformat = '%d.%m.%Y', $sformat = '%Y-%m-%d') {
    extract(strptime($ts,$sformat));
    return strftime($dformat,mktime(
                                  intval($tm_hour),
                                  intval($tm_min),
                                  intval($tm_sec),
                                  intval($tm_mon)+1,
                                  intval($tm_mday),
                                  intval($tm_year)+1900
                                ));
  }

