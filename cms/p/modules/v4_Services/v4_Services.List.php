
	<?
//error_reporting(E_PARSE);

require_once ROOT.'/f/f.php';


$dashboardFilter = '';
$titleAddOn = '';

$driver = false;

if ($_SESSION['AuthLevelID'] == DRIVER_USER) {
	//$dashboardFilter = " AND OwnerID = '".$_SESSION['AuthUserID']."' ";
	$driver = true; 
	
}

?>
<div class="container">
	<h1><?= PRICES ?> <?= $titleAddOn ?></h1>
	<? 	if (/*$driver*/ false) { ?>
		<br>
		<small><?= NEW_PRICES_INFO ?></small>
		<br><br>
		<button class="btn btn-xs btn-danger " onclick="alert('Admin informed'); return false;">
			<?= SUBMIT_NEW_PRICES ?>
		</button>
	<? } ?>
	<? 	if ($driver) { ?>
		<br>
		<button class="btn btn-xs btn-success " onclick="togglePrices('1');">
			<?= ACTIVATE ?>
		</button>
		&nbsp;&nbsp;
		<button class="btn btn-xs btn-danger " onclick="togglePrices('0');">
			<?= DEACTIVATE ?>
		</button>
		&nbsp;&nbsp;
		<span id="togglePrices"></span>
		<br>
	<? } ?>

	<br>
	<input type="hidden"  id="whereCondition" name="whereCondition" 
	value=" WHERE v4_Services.ServiceID > 0 <?= $dashboardFilter ?>">
	
	<div class="row pad1em">
		<div class="col-sm-3" id="infoShow"></div>

		<? if ( !$driver ) { ?>
			<div class="col-md-3">
				<i class="fa fa-search"></i>
				<select name="OwnerID" id="OwnerID"  class="w75" onchange="all_v4_ServicesFilter();">
					<option value="0"> <?= ALL_DRIVERS ?> </option>
		
					<?
					require_once '../db/v4_AuthUsers.class.php';

					# init class
					$au = new v4_AuthUsers();

					$auk = $au->getKeysBy('Country, Terminal, AuthUserCompany', 'asc', "WHERE AuthLevelID = 31 AND Active = 1");

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
			</div>
		<? } else {?>
			<input type="hidden" name="OwnerID" id="OwnerID" value="<?= s('AuthUserID'); ?>">
		<? } ?>
		
		<div class="col-sm-2">
			<i class="fa fa-eye"></i>
			<select id="length" class="w75" onchange="all_v4_ServicesFilter();">
				<option value="5"> 5 </option>
				<option value="10" selected> 10 </option>
				<option value="20"> 20 </option>
				<option value="50"> 50 </option>
				<option value="100"> 100 </option>
			</select>
		</div>

		<? if ( !$driver ) { ?>
		<div class="col-sm-2">
		<? } else { ?>
		<div class="col-sm-5">
		<? } ?>
			<i class="fa fa-text-width"></i>
			<input type="text" id="Search" class=" w75" onkeyup="all_v4_ServicesFilter();" title="Min. 3 chars">
		</div>

		<div class="col-sm-2">
			
			<i class="fa fa-sort-amount-asc"></i> 
			<select class="w75" name="sortOrder" id="sortOrder" onchange="all_v4_ServicesFilter();">
				<option value="ASC" selected="selected"> <?= ASCENDING ?> </option>
				<option value="DESC"> <?= DESCENDING ?> </option>
			</select>
			
		</div>
	
	</div>

	<div id="show_v4_Services"><div class="center"><?= THERE_ARE_NO_DATA ?></div></div>
	
	<? 
		// inList razlikuje je li direktan poziv Edit transfera (npr. iz dashboarda)
		// ili ide preko liste svih transfera
		// ako je iz liste, onda je true
		$inList = true;
		define("READ_ONLY_FLD", '');
		// Poziva se template za Listu i za Edit transfera
		// koristi handlebars
		require_once $modulesPath .'/v4_Services/v4_ServicesListTemplate.'.$_SESSION['GroupProfile'].'.php'; 
		require_once $modulesPath .'/v4_Services/v4_ServicesEditForm.'.$_SESSION['GroupProfile'].'.php'; 
	?>
	<br>
	<div id="pageSelect" class="col-sm-12"></div>
	<br><br><br><br>
</div>

<? require_once ROOTPATH.'/p/modules/v4_Services/v4_Services_JS.php' ?>	

<script type="text/javascript">
	$(document).ready(function(){
		all_v4_Services(); // definirano u v4_Services_JS.php
	});

	function all_v4_ServicesFilter() {
		if( $("#Search").val().length >= 3 || $("#Search").val().length == 0) {
			all_v4_Services(); // definirano u v4_Services_JS.php
		}
	}
</script>

