<? 
# Kad dodje link bez www treba ga dodat 
//if (strpos($_SERVER[HTTP_HOST],'www') === false) header("Location: https://www.$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");

/*
	if (empty($_COOKIE['dev3']) and (!isset($_REQUEST['bogo']) or $_REQUEST['bogo'] != 'rio'))
	die('<div style="font-family:Verdana; text-align:center">
	     <h2>This web site is down for a major upgrade.</h2>
	     We\'ll be back shortly.
	     </div>
	');
	else setcookie('dev3','ok',time()+(3600*24*60));
	//error_log('You fucked up!',3,'mylog.log'); // ovo radi :)
*/
	

# Session lifetime of 3 hours
ini_set('session.gc_maxlifetime', 10800);
ini_set("session.cookie_lifetime","10800"); //3 sata

# Enable session garbage collection with a 1% chance of
# running on each session_start()
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);

# Our own session save path; it must be outside the
# default system save path so Debian's cron job doesn't
# try to clean it up. The web server daemon must have
# read/write permissions to this directory.
//session_save_path(ROOT . '/cms/sessions');	

	session_start();

	define("DEVELOPMENT",0);
	define("MONITOR", 0);
	define("ALLOW_REFRESH", 1);
	define("CMS_ONLY", true); 

	// PATHS
	define("ROOT", ROOT);
	$modulesPath = ROOT . '/cms/p/modules'; // base folder for modules
	$pluginsPath = ROOT . '/cms/plugins'; // base folder for plugins	
	$pagesPath = ROOT . '/cms/p/'; // base folder for pages
	$modulesPath = "https://".$_SERVER['SERVER_NAME'] .'/cms/p/modules/'; // relative to web root folder
	define("ROOTPATH", ROOT.'/cms');
	// END 

	// AUTOLOAD FUNCTION
	/*spl_autoload_register(function($classname) {
		if ($class_name<>'Smarty_Autoloader') require_once ROOT.'/db/'. $classname . '.class.php';
	});		*/	

	require_once 'config.php';
	require_once ROOT . '/f/f.php';
	require_once ROOT . '/db/db.class.php';
	$db = new DataBaseMysql();

	require_once '../common/libs/Smarty.class.php'; 
	require_once '../common/libs/SmartyValidate.class.php';
	require_once '../common/libs/SmartyPaginate.class.php';
	require_once '../common/class/adminTable.php';

	$smarty = new Smarty;
	$smarty->compile_check = true;
	$smarty->debugging =false;   

	if (DEVELOPMENT) error_reporting(E_ALL);
	else error_reporting(E_PARSE);

	// just for test
	$_SESSION['Currency'] = 'EUR';
	$_SESSION['TEST'] 		= false;
	$_SESSION['CMSLang'] 	= 'en';
	define("SITE_CODE", '1');


	// Ako je booking zapoceo, spremi OrderKey u COOKIE
	// da bi korisnik mogao nastaviti booking kasnije
	if($_SESSION['BOOKING_STARTED']) {
		if (isset($_SESSION['OrderKey'])) {
			setcookie("Key", $_SESSION['OrderKey'], time() + (7*24*60*60));
		}
	}


	// Sprema adresu na koju korisnik zeli doci
	// ali ako nije logiran, ne moze
	// nakon Logina vraca korisnika na spremljenu stranicu
	$_SESSION['InitialRequest'] = $_SERVER['REQUEST_URI'];

	/*
	// SESSION TIMEOUT - ovo su rekli da ne vole	
	$lockscreen = 2000; // minuta
	if(isset($_SESSION['timestamp']) and ((time() - $_SESSION['timestamp']) > $lockscreen * 60) ) { 
		unset($_SESSION['password'], $_SESSION['timestamp']);
		$_SESSION['UserAuthorized'] = false;
		header("Location: lockscreen.php"); 
		exit;
	} else {
		$_SESSION['timestamp'] = time(); 
	}
	*/


	// LOGIN
	if(!isset($_SESSION['UserAuthorized']) or $_SESSION['UserAuthorized'] == false) {
		header("Location: login.php");
		die();
	}

	// LOGIN AS USER
	if(isset($_REQUEST['sa_u']) and $_REQUEST['sa_u'] !='' and is_numeric($_REQUEST['sa_u'])
	and isset($_REQUEST['sa_l']) and $_REQUEST['sa_l'] !='' and is_numeric($_REQUEST['sa_l'])) {

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
				$_SESSION['AdminAccessToDriverProfile'] = true;
				$_SESSION['UserName'] = $row['AuthUserName'];
				$_SESSION['UserRealName'] = $row['AuthUserRealName'];
				$_SESSION['UserCompany'] = $row['AuthUserCompany'];
				$_SESSION['AuthUserID'] = $row['AuthUserID'];
				$_SESSION['OwnerID'] = $row['AuthUserID'];
				$_SESSION['AuthLevelID'] = $row['AuthLevelID'];
				$_SESSION['MemberSince'] = $row['DateAdded'];
				
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
	}


	// LANGUAGES
	if ( isset($_SESSION['CMSLang']) and $_SESSION['CMSLang'] != '') {
		$languageFile = 'lng/' . $_SESSION['CMSLang'] . '_text.php';
		if ( file_exists( $languageFile) ) require_once $languageFile;
		else {
			$_SESSION['CMSLang'] = 'en';
			require_once 'lng/en_text.php';
		}
	} else {
		$_SESSION['CMSLang'] = 'en';
		require_once 'lng/en_text.php';
	}
	// END OF LANGUAGES	
		
	
	// COMPANY DATA FROM DATABASE
	if (!is('co_name')) {
		require_once '../db/v4_CoInfo.class.php';
		$co = new v4_CoInfo();
		$co->getRow('1');
		$companyData = $co->fieldValues();
		$co->endv4_CoInfo();
		
		foreach($companyData as $name => $value) {
			$_SESSION[$name] = $value;
		}
	}

	// SELECT FOLDER/PAGE TO LOAD, ovisno o profilu korisnika
	if ($_REQUEST['af']) $_SESSION['af']=$_REQUEST['af'];
	if ($_SESSION['af']) $activeFolder=$_SESSION['af'];
	else  
		$activeFolder = trim( strtolower($_SESSION['GroupProfile']) );
	$activePage = 'dashboard';
	if(isset($_REQUEST['p']) and $_REQUEST['p'] != '') $activePage = $_REQUEST['p'];


	// ***********************************************************************************
	// HTML OUTPUT STARTS HERE
	// ***********************************************************************************

	// HTML HEADER - sve
	require_once 'headerScripts.php';

	?>
	<body class="fixed-top" style="height:100%!important;font-size:16px">
		<div class="wrapper">

			<? 
				// Provjera i ucitavanje menija
				if(file_exists($activeFolder . '/' . 'menu.php')) {
					require_once $activeFolder . '/' . 'menu.php';
				} else {
					echo 'Page not found';
					session_destroy();
					die();
				}
			?>

			<div class="container-fluid side-collapse-container"
			style="padding:0px!important">
				<? // Ucitavanje user profile controlera
				if(file_exists($activeFolder . '/' . 'controler.php')) {
					require_once $activeFolder . '/' . 'controler.php';
				} else {
					echo 'Page not found';
					session_destroy();
					die();
				}
				?>
			</div>

		</div>

		<? // MONITOR VARIABLES
		if (MONITOR) {
			//echo ip_info("Visitor", "Country") . '<br>';
			//echo ip_info("Visitor", "City") . '<br>';
			//echo ip_info("Visitor", "Address") . '<br>';
			//echo ip_info("Visitor", "ip") . '<br>'; ?>

			<button class="btn" onclick="$('#MONITOR').toggle();">Monitor</button>
			<div id="MONITOR" style="display:none">
				<pre>REQUEST<br><? print_r($_REQUEST); ?><br><hr></pre>
				<pre>SESSION<br><? print_r($_SESSION); ?><br><hr></pre>
			</div>
		<? } ?>

		<script>
			$(document).ready(function(){
				$(".datepicker").pickadate({format: 'yyyy-mm-dd'});
				//$(".timepicker").pickatime({format: 'HH:i', interval: 10});
				$(".timepicker").JAMTimepicker();
			});
		</script>
	</body>
</html>
