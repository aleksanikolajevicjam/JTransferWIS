<?
//error_reporting(E_ALL);

require_once ROOT.'/f/f.php';

$dashboardFilter = '';
$titleAddOn = '';
$driver = false;
$SOwnerID = $_SESSION['OwnerID'];

if ($_SESSION['AuthLevelID'] == DRIVER_USER) {
//	$dashboardFilter = " AND OwnerID = '".$_SESSION['AuthUserID']."' ";
	$driver = true;
}

require_once ROOT . '/cms/fixDriverID.php';
foreach($fakeDrivers as $key => $fakeDriverID) {
    if($_SESSION['AuthUserID'] == $fakeDriverID) $SOwnerID = $realDrivers[$key];    
}

?>
<div class="container">
	<h1><?= DRIVER_ROUTES ?> <?= $titleAddOn ?></h1>
	<!--<a class="btn btn-primary btn-xs" href="index.php?p=new_v4_DriverRoutes"><?= NNEW ?></a>-->

	<? 	if ($driver) { ?>
		<br>
		<button class="btn btn-xs btn-success " onclick="toggleRoutes('1');">
			<?= ACTIVATE ?>
		</button>
		&nbsp;&nbsp;
		<button class="btn btn-xs btn-danger " onclick="toggleRoutes('0');">
			<?= DEACTIVATE ?>
		</button>
		&nbsp;&nbsp;
		<span id="toggleRoutes"></span>
		<br><br><br>
	<? } ?>	
	<?
	# prikazi samo driverima, adminu ovo ne treba
	if ($driver) {
		require_once ROOT . '/db/v4_Places.class.php';
		$p = new v4_Places();
		$keys = $p->getKeysBy('PlaceType ASC, PlaceNameSEO ASC','');
	?>		
		<div class="row"><div class="col-md-6">
		<?=ADD_ROUTES_FROM_TO ?>
		<br>

		
			<select name="routePlace" id="routePlace" >
				<option value="0"> --- </option>
				<?		
				foreach ($keys as $key => $value) {
					$p->getRow($value);
					echo '<option value="'.$p->getPlaceID() .'">'.$p->getPlaceNameEN().'</option>';
				}
				?>

			</select>
			<button class="btn btn-success" 
			onclick="addDriverRoutes('<?= $SOwnerID ?>',$('#routePlace').val());">
				<i class="fa fa-play"></i> Go 
			</button>
		
		</div>

		<?// brisanje svih DriverRoutes koje sadrze neki PlaceID ?>
		<div class="col-md-6">
		<?= REMOVE_ROUTES_FROM_TO ?>
		<br>


			<select name="routePlace2" id="routePlace2"> 
				<option value="0"> --- </option>
				<?
				foreach ($keys as $key => $value) {
					$p->getRow($value);
					echo '<option value="'.$p->getPlaceID() .'">'.$p->getPlaceNameEN().'</option>';
				}
				?>

			</select>
			<button class="btn btn-danger" 
			onclick="removeDriverRoutes('<?= $SOwnerID ?>',$('#routePlace2').val());">
				<i class="fa fa-play"></i> Go 
			</button>
		</div>
		<div id="newRoutesAdded" class="col-md-12 red white-text pad4px" style="display:none"></div>
	</div>

	<hr>
	<div class="row"><div class="col-md-12">Add a SINGLE route between places:</div></div>
	<div class="row">
		<div class="col-md-6">
			<select name="routeFrom" id="routeFrom">
				<option value="0"> --- </option>
				<?
				foreach ($keys as $key => $value) {
					$p->getRow($value);
					echo '<option value="' . $p->getPlaceID() . '">' . $p->getPlaceNameEN() . '</option>';
				}
				?>
			</select>
		</div>

		<div class="col-md-5">
			<select name="routeTo" id="routeTo">
				<option value="0"> --- </option>
				<?
				foreach ($keys as $key => $value) {
					$p->getRow($value);
					echo '<option value="' . $p->getPlaceID() . '">' . $p->getPlaceNameEN() . '</option>';
				}
				?>
			</select>
		</div>

		<div class="col-md-1">
			<button class="btn btn-danger" 
				onclick="addSingleRoute('<?= $SOwnerID ?>', $('#routeFrom').val(), $('#routeTo').val())">
				<i class="fa fa-play"></i> Go 
			</button>
		</div>
	</div><hr>
	<?
		
	} // end if driver
	
	?>
		
	<input type="hidden"  id="whereCondition" name="whereCondition" 
	value=" WHERE ID > 0 <?= $dashboardFilter ?>">
	
	<div class="row pad1em">
		<div class="col-md-3 " id="infoShow"></div>

		<? if ( !$driver ) { ?>
		<div class="col-md-3">
			<i class="fa fa-search"></i>
			<select name="OwnerID" id="OwnerID"  class="w75" onchange="all_v4_DriverRoutesFilter();">
				<option value="0"> <?= ALL_DRIVERS ?> </option>
		
				<?
				require_once '../db/v4_AuthUsers.class.php';

				# init class
				$au = new v4_AuthUsers();

				$auk = $au->getKeysBy('AuthUserRealName', 'asc', "WHERE AuthLevelID = 31");

				foreach($auk as $n => $ID) {
	
					$au->getRow($ID);
					echo '<option value="'.$au->getAuthUserID() .'">'.$au->getAuthUserRealName().'</option>';

				}
		
				?>
			</select>
		</div>
		<? } else {?>
			<input type="hidden" name="OwnerID" id="OwnerID" value="<?= s('AuthUserID'); ?>">
		<? } ?>

		<div class="col-md-2">
			<i class="fa fa-eye"></i>
			<select id="length" class="w75" onchange="all_v4_DriverRoutesFilter();">
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
			<input type="text" id="Search" class=" w75" onchange="all_v4_DriverRoutesFilter();" placeholder="Text + Enter to Search">
		</div>

		<div class="col-md-2">
			
			<i class="fa fa-sort-amount-asc"></i> 
			<select name="sortOrder" id="sortOrder" class="w75" onchange="all_v4_DriverRoutesFilter();">
				<option value="ASC" selected="selected"> <?= ASCENDING ?> </option>
				<option value="DESC"> <?= DESCENDING ?> </option>
			</select>
			
		</div>
	
	</div>

	<div id="show_v4_DriverRoutes"><?= THERE_ARE_NO . DATA ?></div>
	
	<? 
		// inList razlikuje je li direktan poziv Edit transfera (npr. iz dashboarda)
		// ili ide preko liste svih transfera
		// ako je iz liste, onda je true
		$inList = true;
		define("READ_ONLY_FLD", '');
		// Poziva se template za Listu i za Edit transfera
		// koristi handlebars
		require_once $modulesPath .'/v4_DriverRoutes/v4_DriverRoutesListTemplate.'.$_SESSION['GroupProfile'].'.php'; 
		require_once $modulesPath .'/v4_DriverRoutes/v4_DriverRoutesEditForm.'.$_SESSION['GroupProfile'].'.php'; 
	?>
	<br>
	<div id="pageSelect" class="col-sm-12"></div>
	<br><br><br><br>
</div>

<? require_once ROOTPATH .'/p/modules/v4_DriverRoutes/v4_DriverRoutes_JS.php' ?>	

<script type="text/javascript">
	$(document).ready(function(){
		$(".datepicker").pickadate({format:'yyyy-mm-dd'});
		all_v4_DriverRoutes(); // definirano u v4_DriverRoutes_JS.php
	});

	function all_v4_DriverRoutesFilter() {
		all_v4_DriverRoutes(); // definirano u v4_DriverRoutes_JS.php
	}
</script>

