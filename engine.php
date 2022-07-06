<?


// Sprema adresu na koju korisnik zeli doci
// ali ako nije logiran, ne moze
// nakon Logina vraca korisnika na spremljenu stranicu
$_SESSION['InitialRequest'] = $_SERVER['REQUEST_URI'];

require_once 'pathToVars.php';

// LOGIN
if(!isset($_SESSION['UserAuthorized']) or $_SESSION['UserAuthorized'] == false) {
	require_once 'login.php';
	exit();	
}
else setcookie("page", $activePage, time() + (7*24*60*60));

// LOGIN AS USER
if(isset($_REQUEST['sa_u']) and $_REQUEST['sa_u'] !='' and is_numeric($_REQUEST['sa_u'])
and isset($_REQUEST['sa_l']) and $_REQUEST['sa_l'] !='' and is_numeric($_REQUEST['sa_l'])) {
	require_once 'loginasuser.php'; 
}
// SELECT FOLDER/PAGE TO LOAD, ovisno o profilu korisnika
if (isset($_REQUEST['af']) && $_REQUEST['af']) $_SESSION['af']=$_REQUEST['af'];
if (isset ($_SESSION['af']) && $_SESSION['af']) $activeFolder=$_SESSION['af'];
else $activeFolder = 'cms/'.trim( strtolower($_SESSION['GroupProfile']) );

// kontrola pristupa
$modules_arr='';
if(isset($_SESSION['UseDriverID'])) $AuthLevelID=43;
else $AuthLevelID=$_SESSION['AuthLevelID'];
$sql="SELECT ModulID FROM `v4_ModulesLevel` WHERE AuthLevelID=".$AuthLevelID;
$result = $db->RunQuery($sql);
while($row = $result->fetch_array(MYSQLI_ASSOC)){
	$modules_arr.=$row['ModulID'].",";
}
$modules_arr = substr($modules_arr,0,strlen($modules_arr)-1);
// meni
require_once 'db/v4_Modules.php';
$md = new v4_Modules();
$mdk = $md->getKeysBy('MenuOrder ' ,'asc', "where ParentID=0 AND ModulID in (".$modules_arr.")");
$menu1=array();
foreach($mdk as $key) {
	$md->getRow($key);
	$row1=array();
	$row1['title']=$md->getName();;
	$row1['link']=$md->getCode();	
	$row1['icon']=$md->getIcon();
	$mdk2 = $md->getKeysBy('MenuOrder ' ,'asc', "where ParentID=".$md->getModulID()." AND ModulID in (".$modules_arr.")");
	$menu2=array();
	if ($md->getCode()==$activePage) $active_parent=true;		
	else $active_parent=false;
	if (count($mdk2)>0) {
		$row1['arrow']='fa arrow';
		foreach($mdk2 as $key2) {
			$md->getRow($key2);
			$row2=array();
			$row2['title']=$md->getName();;
			$row2['link']=$md->getCode();	
			//$row2['icon']=$md->getIcon();
			if ($md->getCode()==$activePage) {
				$row2['active']='active';
				$active_parent=true;
			}	
			else $row2['active']='';
			$menu2[]=$row2;	
		}
	}
	else $row1['arrow']='';	
	if ($active_parent) $row1['active']='active';
	else $row1['active']='';		
	$row1['menu']=$menu2;	
	$menu1[]=$row1;
}	
$smarty->assign('menu1',$menu1);
$mdk = $md->getKeysBy('ModulID ' ,'asc', "where code='$activePage'");
if (count($mdk)==1) {
	$key=$mdk[0];
	$md->getRow($key);
	require_once $modulesPath . '/'.$md->getBase().$includefile;
	if (is_dir($modulesPath . '/'.$md->getBase().'/templates')) 
		$smarty->assign('page',$md->getName());		
	else $smarty->assign('pageList',$md->getName());	
	$smarty->assign('currenturl',ROOT_HOME.$activePage);
	$smarty->assign('title',$md->getName());
	$smarty->assign('base',$md->getBase());
	$smarty->assign('parentID',$md->getParentID());
	
}
//staro resenje 
else {
	require_once $activeFolder . '/' . 'controler.php';	
	$smarty->assign('title',$activePage);
}
 
// display
?><script type="text/x-handlebars-template"></script><?

$smarty->display("index.tpl");	

?>