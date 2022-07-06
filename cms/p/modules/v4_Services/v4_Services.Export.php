<style>
	.green {
		background-color: green;	
	}
</style>
<?
require_once ROOT.'/f/f.php';
require_once ROOT.'/db/db.class.php';

if (isset($_REQUEST['OwnerID']) and $_REQUEST['OwnerID'] > 0) {
	
	ob_start(); 
	MakeCSV($_REQUEST['OwnerID']);
	
	$csv = ob_get_contents();
	ob_end_clean();
	
	$au = new v4_AuthUsers();	
	$au->getRow($_REQUEST['OwnerID']);
	$driver=$au->getAuthUserRealName();
	
	$fp = fopen('PriceList_'.$driver.'.csv', 'w');
	fwrite($fp, $csv);
	fclose($fp);
	
	echo '<div class="container white pad1em"><h2>Prices exported to CSV</h2>';
	echo '<br>';
	echo '<br>';
	echo 'You can download CSV file here (or Right-Click->Save):';
	echo '<br>';
	echo '<br>';
	echo '<a href="PriceList_'.$driver.'.csv">Download CSV</a>';
	echo '<br>';
	echo '<br>';
	echo 'File format: UTF-8, semi-colon (;) delimited';
	echo '</div>';
	
} else { 

$dashboardFilter = '';
$titleAddOn = '';

$driver = false;

if ($_SESSION['AuthLevelID'] == DRIVER_USER) {
	//$dashboardFilter = " AND OwnerID = '".$_SESSION['AuthUserID']."' ";
	$driver = true;
}

$url=str_replace('&Active=0','',$_SERVER['REQUEST_URI']);
$url=str_replace('&Active=1','',$url);
$notactiveurl=$url."&Active=0";
$activeurl=$url."&Active=1";

?>
<div class="container">
	<h1><?= PRICES_EXPORT ?></h1> 
	<div>
		<? if ( !isset($_REQUEST['Active'] )) { ?> 
			<a href = '<? echo $activeurl ?>' class=" btn green" ><i class=""></i>Active</a>
			<a href = '<? echo $notactiveurl ?>' class=" btn red" ><i class=""></i>Not Active</a>
		<? } ?>				
		<? if ( isset($_REQUEST['Active'] )) { ?> <a href = '<? echo $url ?>' class=" btn blue" ><i class=""></i>All</a>	<? } ?>						
		<? if ( isset($_REQUEST['Active']) && $_REQUEST['Active'] ==0 ) { ?> <a href = '<? echo $activeurl ?>' class=" btn green" ><i class=""></i>Active</a>	<? } ?>				
		<? if ( isset($_REQUEST['Active']) && $_REQUEST['Active'] ==1 ) { ?> <a href = '<? echo $notactiveurl ?>' class=" btn red" ><i class=""></i>Not Active</a>	<? } ?>		
		
	</div>	
	<div class="row pad1em">
		<div class="col-sm-3" id="infoShow"></div>

		<? if ( !$driver ) { ?>
			<div class="col-md-12">
				<form name="pricesExport" action="index.php?p=pricesExport" method="post">
					<i class="fa fa-search"></i> <?= DRIVER ?>:<br>
					<select name="OwnerID" id="OwnerID"  class="w100">
						<option value="0"> --- </option>
			
						<?
						require_once '../db/v4_AuthUsers.class.php';

						# init class
						$au = new v4_AuthUsers();

						if (isset($_REQUEST['Active'])) {
							$auk = $au->getKeysBy('Country, Terminal, AuthUserCompany', 'asc', "WHERE AuthLevelID = 31 AND Active = ".$_REQUEST['Active']);
						}	
						else $auk = $au->getKeysBy('Country, Terminal, AuthUserCompany', 'asc', "WHERE AuthLevelID = 31");						

						foreach($auk as $n => $ID) {
							$au->getRow($ID);							
							$terminal=substr($au->getTerminal(),0,100);
							if (strlen($au->getTerminal())>100) $terminal.="...";		
							echo '<option value="'.$au->getAuthUserID() .'">'.
									$au->getCountry().'-'.$terminal.'-'.$au->getAuthUserCompany().
								 '</option>';

						}
			
						?>
					</select>
					<br><br>
					<button class=" btn btn-primary pull-right" type="submit" name="export"><i class="fa fa-send">
						</i> <?= SUBMIT?>
					</button>
				</form>
			</div>
		<? } else {?>
			<input type="hidden" name="OwnerID" id="OwnerID" value="<?= s('AuthUserID'); ?>">
		<? } ?>
	</div>
</div>	
<?
} #end main if






function MakeCSV($id) {

	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();
	$q  = " SELECT * FROM v4_VehicleTypes ";
	
	$w = $db->RunQuery($q);
	
	# Stavi VehicleTypes u array za kasnije
	$vtype = array();
	while($vt = $w->fetch_object()) {
		$vtype[$vt->VehicleTypeID] = $vt->VehicleTypeName;
	}
	#===

	// Delimiter
	$dlm = ";";
	
	# CSV first row
	echo 'RID'.$dlm.'Pax'.$dlm.'Route'.$dlm.'Vehicle'.$dlm.'OneWayPrice(EUR)'.$dlm. 'km'.$dlm./*'ReturnPrice(EUR)' . $dlm .*/ "\n";
	//SELECT * FROM `v4_Routes` , v4_Services WHERE v4_Routes.RouteID = v4_Services.RouteID AND //v4_Services.OwnerID = '504' ORDER BY v4_Routes.RouteName ASC, v4_Services.VehicleTypeID ASC
	
	$q1  = "SELECT * FROM v4_Services AS s, v4_Routes AS r ";
	$q1 .= " WHERE s.OwnerID = '" . $id ."'";
	$q1 .= " AND r.RouteID = s.RouteID ";
	$q1 .= " ORDER BY r.RouteName ASC,s.VehicleTypeID ASC";

	$w1 = $db->RunQuery($q1) or die( mysql_error() . '');

	while($dr = $w1->fetch_object()) {
		echo $dr->RouteID . $dlm. $dr->VehicleTypeID . $dlm .
				$dr->RouteName . $dlm .
				$vtype[$dr->VehicleTypeID] . $dlm . 
				$dr->ServicePrice1 .  $dlm . $dr->Km . $dlm .
				//number_format($dr->ReturnPrice,2)  . $dlm .
				"\n";
	}
		
	
}




