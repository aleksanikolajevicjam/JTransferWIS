
	<?
//error_reporting(E_PARSE);

require_once ROOT.'/f/f.php';


$dashboardFilter = '';
$titleAddOn = '';


?>
<div class=" container-fluid">
	<h1><?= CO_TEXTS ?> <?= $titleAddOn ?></h1>
	<a class="btn btn-primary btn-xs" href="index.php?p=new_v4_CoTexts"><?= NNEW ?></a>
	<br><br>
		
	<input type="hidden"  id="whereCondition" name="whereCondition" 
	value=" WHERE ID > 0 <?= $dashboardFilter ?>">
	
	<div class="row">
		<div class="col-sm-12 white pad1em" id="infoShow"></div>
	</div>
	<div class="row pad4px white"">

		<div class="col-sm-2">
			<i class="fa fa-eye"></i>
			<select id="length" class="w75" onchange="all_v4_CoTextsFilter();">
				<option value="5"> 5 </option>
				<option value="10" selected> 10 </option>
				<option value="20"> 20 </option>
				<option value="50"> 50 </option>
				<option value="100"> 100 </option>
			</select>
		</div>

		<div class="col-sm-3">
			<i class="fa fa-text-width"></i>
			<input type="text" id="Search" class=" w75" onkeyup="all_v4_CoTextsFilter();">
		</div>

		<div class="col-sm-4">
			
			<i class="fa fa-sort-amount-asc"></i> 
			<select name="sortOrder" id="sortOrder" onchange="all_v4_CoTextsFilter();">
				<option value="ASC" selected="selected"> <?= ASCENDING ?> </option>
				<option value="DESC"> <?= DESCENDING ?> </option>
			</select>
			
		</div>
	
	</div>

	<div id="show_v4_CoTexts"><?= THERE_ARE_NO . DATA ?></div>
	
	<? 
		// inList razlikuje je li direktan poziv Edit transfera (npr. iz dashboarda)
		// ili ide preko liste svih transfera
		// ako je iz liste, onda je true
		$inList = true;
		define("READ_ONLY_FLD", '');
		// Poziva se template za Listu i za Edit transfera
		// koristi handlebars
		require_once $modulesPath .'/v4_CoTexts/v4_CoTextsListTemplate.'.$_SESSION['GroupProfile'].'.php'; 
		require_once $modulesPath .'/v4_CoTexts/v4_CoTextsEditForm.'.$_SESSION['GroupProfile'].'.php'; 
	?>
	<br>
	<div id="pageSelect" class="col-sm-12"></div>
	<br><br><br><br>
</div>

<? require_once ROOTPATH.'/p/modules/v4_CoTexts/v4_CoTexts_JS.php' ?>	

<script type="text/javascript">
	$(document).ready(function(){
		$(".datepicker").pickadate({format:'yyyy-mm-dd'});
		all_v4_CoTexts(); // definirano u v4_CoTexts_JS.php
	});

	function all_v4_CoTextsFilter() {
		all_v4_CoTexts(); // definirano u v4_CoTexts_JS.php
	}
</script>	
	
