<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>CMS v5.0</title>
        <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
        <meta name="googlebot" content="noindex" />
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

		<!-- STYLES -->
		<!-- bootstrap 3.0.2 -->
		<!-- <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all"/>-->

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">

		<!-- font Awesome -->
		<link href="//<?=$_SERVER['HTTP_HOST']?>/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>


		<!-- Theme style WORKING !!!-->
		<link href="//<?=$_SERVER['HTTP_HOST']?>/cms/css/theme.css" rel="stylesheet" type="text/css" media="screen"/>

		<!-- Misc -->
		<link rel="stylesheet" href="//<?=$_SERVER['HTTP_HOST']?>/css/jquery-ui-1.8.9.custom.css" type="text/css" />
		<link rel="stylesheet" href="//<?=$_SERVER['HTTP_HOST']?>/cms/js/pickadate/themes/default.css" type="text/css" media="screen"/>
		<link rel="stylesheet" href="//<?=$_SERVER['HTTP_HOST']?>/cms/js/pickadate/themes/default.date.css" type="text/css" media="screen"/>
		<link rel="stylesheet" href="//<?=$_SERVER['HTTP_HOST']?>/cms/js/pickadate/themes/default.time.css" type="text/css" media="screen"/>

		<link rel="stylesheet" href="//<?=$_SERVER['HTTP_HOST']?>/cms/css/colors.css" media="all">
		<link rel="stylesheet" href="//<?=$_SERVER['HTTP_HOST']?>/cms/css/simplegrid.css" media="all">

        <link rel="stylesheet" type="text/css" href="//<?=$_SERVER['HTTP_HOST']?>/css/JAMTimepicker.css">


		<style type="text/css" media="print">
			body {
				font-family: 'Roboto', sans-serif;
				font-size: 10px !important;
			}
			.nav, .footer { display:none; }
			@page { margin: 0.5cm; }
			@media print {
				div [class*='col-'] { display: table-cell !important; }
				div [class*='row'] { display: table-row !important; width: 100% !important; }
				div [class*='grid'] { display: table-row !important; width: 100% !important; }
				div [class*='w25'] { display: inline-block !important; width: 30% !important; }
				div [class*='w75'] { display: inline-block !important; width: 69% !important; }
				div [class*='w100'] { display: inline-block !important; width: 99% !important; }
				button, .btn { display:none !important; }
			}
		</style>

		<!-- SCRIPTS -->
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->

		<!-- jQuery -->
		<script src="https://code.jquery.com/jquery-2.0.2.js"></script>
		<!--<script src="https://www.jamtransfer.com/cms/js/jquery/2.0.2/jquery.min.js"></script>-->
		<!-- jQuery UI 1.10.3 -->
		<script src="//<?=$_SERVER['HTTP_HOST']?>/cms/js/jquery/ui/1.10.3/jquery-ui.min.js" type="text/javascript"></script>

		<!-- Bootstrap -->
		<!-- <script src="js/bootstrap.js" type="text/javascript"></script>-->
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>        


		<!-- Date / Time Picker -->
		<script src="//<?=$_SERVER['HTTP_HOST']?>/js/pickadate/picker.js" type="text/javascript"></script>
		<script src="//<?=$_SERVER['HTTP_HOST']?>/js/pickadate/picker.date.js" type="text/javascript"></script>
		<script src="//<?=$_SERVER['HTTP_HOST']?>/js/pickadate/picker.time.js" type="text/javascript"></script>


        <script src="//<?=$_SERVER['HTTP_HOST']?>/js/JAMTimepickerB.js"></script>

		<!-- App -->
		<script src="//<?=$_SERVER['HTTP_HOST']?>/cms/js/theme/app.js" type="text/javascript"></script>

		<!-- Misc -->
		<script src="//<?=$_SERVER['HTTP_HOST']?>/cms/js/handlebars-v1.3.0.js"></script>

		<script src="//<?=$_SERVER['HTTP_HOST']?>/cms/js/jquery.toaster.js"></script>
		<script src="//<?=$_SERVER['HTTP_HOST']?>/cms/lng/en_init.js"></script>

		<!--<script src="js/jquery.navgoco.js"></script>-->
		
		<style type="text/css" media="print">
			body {
				font-family: 'Roboto', sans-serif;
				font-size: 10px !important;
			}
			.nav, .footer { display:none; }
			@page { margin: 0.5cm; }
			@media print {
				div [class*='col-'] { display: table-cell !important; }
				div [class*='row'] { display: table-row !important; width: 100%; }
				div [class*='grid'] { display: table-row !important; width: 100%; }
				div [class*='w25'] { display: inline-block !important; width: 30%; }
				div [class*='w75'] { display: inline-block !important; width: 69%; }
				div [class*='w100'] { display: inline-block !important; width: 99%; }
				button, .btn, .noPrint { display:none !important; }
			}
		</style>
	</head>

