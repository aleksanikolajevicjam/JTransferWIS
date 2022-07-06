<?
@session_start();
if (!$_SESSION['UserAuthorized']) die('Login to cms first!');

if ($_REQUEST['o'] == 'logout') {
    unset($_SESSION['UserAuthorized']);
    session_destroy();
    header("Location: index.php");
}

$_SESSION['lng'] = 'en';

require_once 'lng/en_config.php';

?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS</title>

    <link rel="stylesheet" href="./b/default.min.css" type="text/css" />
    <link rel="stylesheet" href="./j/jquery-ui-1.8.9.custom.css" type="text/css" />
    <link rel="stylesheet" href="./j/jquery.ui.datepicker.css" type="text/css" />
    <link rel="stylesheet" href="./j/jquery.ui.timepicker.css" type="text/css" />
    <link rel="stylesheet" href="css/datatable.css" type="text/css" />

	<style type="text/css">
      	body {
        padding-top: 70px;
        padding-bottom: 40px;
      	}
      	.sidebar-nav {padding: 9px 0;}
      	.hero-unit {padding: 2% !important;}
      	.control-group {padding:0px;}
      	.control-label {max-width: 60px;padding-top:5px;}
      	.controls {margin-left:70px !important;padding-top:5px;}

      	.widget {padding-left: 2%;padding-right: 2%;}
    	.widgetFld {max-width: 94% !important;}

	    .slideShow {background: #eee; padding: 0%; vertical-align: bottom;}

      	.shadow {
            -moz-box-shadow: 0px 0px 15px #656565;
            -webkit-box-shadow: 0px 0px 15px #656565;
            -o-box-shadow: 0px 0px 15px #656565;
            box-shadow: 0px 0px 15px #656565;
        }
        .myTab {border:none !important;}
        .myPane{background: #fff; padding:1em;min-height:10em;}
        .smallFont {font-size: 0.8em !important;}

        .ui-autocomplete {
            padding: 0;
            list-style: none;
            background-color: #fff;
            width: 218px;
            border: 1px solid #B0BECA;
            max-height: 350px;
            overflow-y: scroll;
        }
        .ui-autocomplete .ui-menu-item a {
            border-top: 1px solid #B0BECA;
            display: block;
            padding: 4px 6px;
            color: #353D44;
            cursor: pointer;
        }
        .ui-autocomplete .ui-menu-item:first-child a {border-top: none;}
        .ui-autocomplete .ui-menu-item a.ui-state-hover {
            background-color: #D5E5F4;
            color: #161A1C;
        }
        label.error {color: red; font-size:0.8em;}
        .coInfoLabel {display: inline-block; width:150px; text-align:right;}
        .coInfoFld   {display: inline-block}
        table {border-bottom: 1px solid #eee}
        pre {font-family: sans-serif}
        #calendarTable td {border:1px dotted #dddddd;}
        #calendarTable {border-bottom:none !important;}
        .navbar, .navbar-inner, .hero-unit {-webkit-border-radius:0px !important;
                -moz-border-radius:0px !important;
                border-radius:0px !important;}
		/*input, select, .alert {padding: 1px !important}*/
		#podaci {font-size:12px; line-height:13px}
    </style>

    <link rel="stylesheet" href="./b/bootstrap-responsive.css" type="text/css" />

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <script type="text/javascript" src="./j/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
    <script type="text/javascript" src="./j/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="./b/bootstrap.min.js"></script>
    <script type="text/javascript" src="./j/jquery.cookie.min.js"></script>
    <script type="text/javascript" src="./j/jquery.ui.datepicker.js"></script>
    <script type="text/javascript" src="./j/jquery.ui.timepicker.js"></script>
    <script type="text/javascript" src="./j/jquery.validate.min.js"></script>
    <script type="text/javascript" src="./j/jquery.form.js"></script>
    
<script type="text/javascript">
    $(document).ready(function() {
        $(".datepicker").datepicker({dateFormat: 'yy-mm-dd'});
        $(".timepicker").timepicker();

        //$(".modal").modal({show:false});

        $('.nav>li').removeClass('active');
        $('#<?= $page;?>').addClass('active');
    });

    $("form").bind("keypress", function (e) {
        if (e.keyCode == 13) {
        	return false;
    	}
	});
</script>    
    
</head>

<body>
<!-- MENU -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="index.php?o=11">Raspored</a>

          <div class="nav-collapse">
            <ul class="nav">
                <li id="home"><a href="index.php?o=11">Transfers List</a></li>
                <li id="sync"><a href="index.php?o=12">Sync</a></li>
                <li id="subdrivers"><a href="index.php?o=14">Sub-Drivers</a></li>
                <li id="vehicles"><a href="index.php?o=13">Vehicles</a></li>
                <li id="vehicles"><a href="index.php?o=15">Troškovi</a></li>
                <li id="logout"><a href="index.php?o=logout">Logout</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
<!--/MENU-->

<div class="container">
    <div class="row">

        <div class="span12">
            <?
            if (!isset($_REQUEST['o']) or empty($_REQUEST['o'])) $o = 11;
            else $o = $_REQUEST['o'];

            switch ($o) {
                case '11':
                    require_once 'timetable.php';
                break;

                case '12':
                    require_once 'sync_new.php';
                break;

                case '13':
                    require_once 'vehicles.php';
                break;

                case '14':
                    require_once 'subdrivers.php';
                break;

                case '15':
                    require_once 'expenses.php';
                break;
                
                case 'logout':
                    require_once 'logout.php';
                break;

                default:
                    require_once 'timetable.php';
                break;
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>

