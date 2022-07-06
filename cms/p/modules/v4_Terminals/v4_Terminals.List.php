<?
if (isset($_SESSION['UseDriverID']) && $_SESSION['UseDriverID']>0) {
	//error_reporting(E_PARSE);
	require_once ROOT.'/f/f.php';


	$dashboardFilter = '';
	$titleAddOn = '';

	$driver = false;

	if ($_SESSION['AuthLevelID'] == DRIVER_USER) {
	//	$dashboardFilter = " AND OwnerID = '".$_SESSION['AuthUserID']."' ";
		$driver = true;

	}

	require_once ROOT . '/cms/fixDriverID.php';
	foreach($fakeDrivers as $key => $fakeDriverID) {
		if($_SESSION['AuthUserID'] == $fakeDriverID) $dashboardFilter = " AND OwnerID = '".$realDrivers[$key]."'";   
	}

	?>
	<div class="container">
		<h1><?= TERMINALS ?> <?= $titleAddOn ?></h1>

			
		<input type="hidden"  id="whereCondition" name="whereCondition" 
		value=" WHERE TerminalID > 0 <?= $dashboardFilter ?>">
		
		<div class="row pad1em" id="searchRow">


			
					
	   


				
				<input type='hidden' name="sortOrder" id="sortOrder" value="ASC" >

				
		
		</div>

		<div id="show_v4_Terminals"><?= THERE_ARE_NO . DATA ?></div>
		
		<? 
			// inList razlikuje je li direktan poziv Edit transfera (npr. iz dashboarda)
			// ili ide preko liste svih transfera
			// ako je iz liste, onda je true
			$inList = true;
			define("READ_ONLY_FLD", '');
			// Poziva se template za Listu i za Edit transfera
			// koristi handlebars
			require_once $modulesPath .'/v4_Terminals/v4_TerminalsListTemplate.php'; 
			require_once $modulesPath .'/v4_Terminals/v4_TerminalsEditForm.php'; 
		?>

	</div>

	<? require_once ROOTPATH.'/p/modules/v4_Terminals/v4_Terminals_JS.php' ?>	

	<script type="text/javascript">
		$(document).ready(function(){
			$(".datepicker").pickadate({format:'yyyy-mm-dd'});
			all_v4_Terminals(); // definirano u v4_Terminals_JS.php
		});

		function all_v4_TerminalsFilter() {
			all_v4_Terminals(); // definirano u v4_Terminals_JS.php
		}
	</script>	
<?
}
else {
?>
<div class="container">
	<h1>You have to set as a driver!</h1>
</div>
<?
}