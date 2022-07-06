<? 
require_once ROOT . '/f/f.php';
require_once ROOT . '/db/db.class.php';

$dashboardFilter = '';
$titleAddOn = '- SubDrivers';

$dashboardFilter = " AND DriverID = '".$_SESSION['AuthUserID']."'";


require $_SERVER['DOCUMENT_ROOT'] . '/cms/fixDriverID.php';
foreach($fakeDrivers as $key => $fakeDriverID) {
    if($_SESSION['AuthUserID'] == $fakeDriverID) $dashboardFilter = " AND DriverID = '".$realDrivers[$key]."'";   
}

?>

<div class="container">
	<h1><?= USERS ?> <?= $titleAddOn ?></h1>
	<a class="btn btn-primary btn-xs" href="index.php?p=newUser"><?= NNEW ?></a>
	<a target="_blank" class="btn btn-primary btn-xs" href="/cms/p/modules/v4_SubDrivers/getRaptorDrivers.php">Raptor</a>		
	<br><br>

	<input type="hidden"  id="whereCondition" name="whereCondition" 
	value=" WHERE AuthUserID > 0 AND AuthLevelID = 32 <?= $dashboardFilter ?>">

	<div class="row pad1em">
		<div class="col-sm-3" id="infoShow"></div>

		<div class="col-sm-3">
			<i class="fa fa-eye"></i>
			<select id="length" class="w75" onchange="getAllUsersFilter();">
				<option value="5"> 5 </option>
				<option value="10" selected> 10 </option>
				<option value="20"> 20 </option>
				<option value="50"> 50 </option>
				<option value="100"> 100 </option>
			</select>
		</div>

		<div class="col-sm-2">
			<i class="fa fa-text-width"></i>
			<input type="text" id="Search" class=" w75" onkeyup="getAllUsersFilter();">
		</div>

		<div class="col-sm-2">
			<i class="fa fa-sort-amount-asc"></i> 
			<select name="sortOrder" id="sortOrder" onchange="getAllUsersFilter();">
				<option value="ASC" selected="selected"> Ascending </option>
				<option value="DESC"> Descending </option>
			</select>
		</div>

		<div class="col-sm-2">
			<i class="fa fa-filter"></i> 
			<select name="active" id="active" onchange="getAllUsersFilter();">
				<option value="1"> Active </option>
				<option value="0"> Not Active </option>
				<option value="99" selected="selected"> All </option>
			</select>
		</div>
	</div>

	<div id="showUsers"><div class="center"><?= THERE_ARE_NO_DATA ?></div></div>

	<? 
		// inList razlikuje je li direktan poziv Edit transfera (npr. iz dashboarda)
		// ili ide preko liste svih transfera
		// ako je iz liste, onda je true
		$inList = true;
		define("READ_ONLY_FLD", '');
		// Poziva se template za Listu i za Edit transfera
		// koristi handlebars

		//require_once $modulesPath .'/users/usersList.'.$_SESSION['GroupProfile'].'.php';
	?>

	<script type="text/x-handlebars-template" id="usersListTemplate">
		{{#each users}}
			<div onclick="editUser({{AuthUserID}});">
				<div class="row {{color}} pad1em listTile" 
				style="border-top:1px solid #ddd" 
				id="user_{{AuthUserID}}">
					<div class="col-sm-1 col-xs-4">
						<img src="a/showProfileImage.php?UserID={{AuthUserID}}" 
						   style="max-height:60px; max-width:60px;" 
						   class="img-thumbnail">
					</div>
					<div class="col-sm-3 col-xs-6">
						<strong>{{AuthUserName}}</strong>
						<br>
						{{#compare Active ">" 0}}
							<i class="fa fa-circle text-green"></i>
						{{else}}
							<i class="fa fa-circle text-red"></i>
						{{/compare}}
						&nbsp;
						ID: <strong>{{AuthUserID}}</strong> 
						{{displayUserLevelText AuthLevelID}} 
					</div>
					<div class="col-sm-2 col-xs-12">
						<strong>{{AuthUserCompany}}</strong>

						<br>
						<small>{{Country}} {{Terminal}}</small>
					</div>
					<div class="col-sm-3 col-xs-12">
						<a href="index.php?p=quickEmail&EmailAddress={{AuthUserMail}}"  
						class="btn btn-default btn-sm"><i class="fa fa-envelope"></i> {{AuthUserMail}}</a>
						<br>
						<small>{{AuthUserTel}}</small>
					</div>

					<div class="col-sm-3 right">
						<small>{{{AuthUserNote}}}</small><br>
						<!--Cash In: {{CashIn}}<br>
						Expenses: {{Expenses}}<br>
						Balance: {{Balance}}-->
					</div>
				</div>
			</div>
			<div id="usersWrapper{{AuthUserID}}" class="editFrame" style="display:none">
				<div id="inlineContent{{AuthUserID}}" class="row">
					<div id="oneUser{{AuthUserID}}" >
						<?= THERE_ARE_NO_DATA ?>
					</div>
				</div>
			</div>
		{{/each}}
	</script>

	<?
		require_once $modulesPath .'/users/usersEditForm.'.$_SESSION['GroupProfile'].'.php'; 
	?>
	<br>
	<div id="pageSelect" class="col-sm-12"></div>
	<br><br><br><br>
</div>

<? require_once ROOTPATH.'/p/modules/users/userEditJS.php' ?>	

<script type="text/javascript">
	$(document).ready(function(){
		$(".datepicker").pickadate({format:'yyyy-mm-dd'});
		getAllUsers(); // definirano u cms.jquery.js
	});

	function getAllUsersFilter() {
		getAllUsers(); // definirano u cms.jquery.js
	}
</script>

