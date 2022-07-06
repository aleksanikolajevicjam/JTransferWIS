
	<?
//error_reporting(E_PARSE);

require_once ROOTPATH.'/f/f.php';


$dashboardFilter = '';
$titleAddOn = 'ALL';
/*
if ($_REQUEST['Type'] == 'agents') {
	$dashboardFilter = " AND Type ='1'";
	$titleAddOn = '- Agents';
}

if ($_REQUEST['Type'] == 'drivers') {
	$dashboardFilter = " AND Type ='2'";
	$titleAddOn = '- Drivers';
}


if ($_REQUEST['transfersFilter'] == 'noDriver') {
	$dashboardFilter = " AND DriverConfStatus ='0' ";
	$titleAddOn = '- No Driver';
}

if ( isset($_COOKIE['dateFilterCookie']) ) $filterDate = $_COOKIE['dateFilterCookie'];
else $filterDate = date("Y-m-d");
if ( isset($_REQUEST['transfersFilter']) ) $filterDate = '';

*/

?>
<div class="container">
	<h1><?= INVOICES_AGENTS ?> - <?= $titleAddOn ?></h1>
	<a class="btn btn-primary" href="index.php?p=new_v4_Invoices"><?= NEW_AGENT_INVOICE ?></a>
	<a class="btn btn-primary" href="index.php?p=new_v4_Invoices2"><?= NEW_AGENT_INVOICE ?>2</a>	
	<a class="btn btn-info" href="index.php?p=driversWTransfersCash"><?= NEW_DRIVER_INVOICE ?></a>
	<button class="btn btn-danger" onclick="$('#HELP').toggle('slow')"><i class="fa fa-question"></i> Help</button>
	<br><br>
	<div id="HELP" class="row" style="display:none">
		<div class="col-12-xs red darken-4 xwhite-text pad1em shadowMedium" style="font-size:0.9em">
			<h3>Redoslijed operacija</h3>
			Klikni na jedan od dva botuna za novi Invoice - za Agenta ili Drivera.<br>
			Unesi datume.<br>
			Sa liste Agenata ili Drivera odaberi za koga radiš račun (klikni na 'Play' znak).<br>
			Klikni na <em><b>Create Invoice</b></em> botun.<br>
			Invoice se otvara u novom prozoru!<br><br>
			Unesi broj i datum računa i prati brojeve na botunima na dnu ekrana.<br>
			Brojeve pritiskaj redom, ne preskači ništa.<br>
			Pritisni <em><b>1. Save</b></em>, onda <em><b>2. Download PDF</b></em>, pa 
			<em><b>3. Create PDF za knj.</b></em> i konačno  <em><b>4. Download PDF za knj.</b></em> <br>
			Za vozače su samo koraci 1. i 2. <br><br>
			Kad završiš, klikni botun za povratak na listu računa.<br><br>
			***<br>
			Download-ane PDF-ove spremi u neki folder na svom kompjuteru, za arhivu.<br>
			Odatle ih možeš zakačiti u mail i poslati kome treba ili printati.<br>
			***<br>
			<br>
			Svaki račun sa ove liste u Edit modu ima botune za ponovno printanje.<br>
			To su dva botuna (za agente) ili jedan (za vozače) - krajnje lijevo.<br>
			Klikom na njih se otvara pripadajući PDF file koji je spremljen na serveru, 
			koji se onda isto tako može spremiti ili printati.<br><br>
			PDF-ovi su označeni ovako:
				<ul>
					<li>R<b>A</b>_XXXXX.pdf - račun za Agenta</li>
					<li>R<b>K</b>_XXXXX.pdf - račun za Knjigovodstvo - agent</li>
					<li>R<b>D</b>_XXXXX.pdf - račun za Drivera i knjigovodstvo, jer su isti</li>
				</ul>
			XXXXXX je broj računa koji je unesen kod kreiranja računa.<br><br>
			U slučaju da račun ne valja može se izbrisati (Edit->Delete) i napraviti novi s istim brojem.<br>
			Pretraživanje na listi je moguće samo preko broja računa. Ostalo za sada ne radi!<br><br>
			Happy Invoicing :)))<br>
			
		</div>
	</div>
	<br><br>
		
	<input type="hidden"  id="whereCondition" name="whereCondition" 
	value=" WHERE ID > 0 <?= $dashboardFilter ?>">
	
	<div class="row pad1em" id="searchRow">
		<div class="col-md-2" id="infoShow"></div>


		<div class="col-md-2">
			<i class="fa fa-list-ul"></i>
			<select id="Type" class="w75" onchange="all_v4_InvoicesFilter();">
				<option value="0"> All </option>
				<option value="1"> Agents </option>
				<option value="2"> Drivers </option>

			</select>
		</div>

		<div class="col-md-2">
			<i class="fa fa-eye"></i>
			<select id="length" class="w75" onchange="all_v4_InvoicesFilter();">
				<option value="5"> 5 </option>
				<option value="10" selected> 10 </option>
				<option value="20"> 20 </option>
				<option value="50"> 50 </option>
				<option value="100"> 100 </option>
			</select>
		</div>

		<div class="col-md-3">
			<strong># </strong>
			<input type="text" id="Search" class=" w75" onkeyup="all_v4_InvoicesFilter();">
		</div>

		<div class="col-md-3">
			
			<i class="fa fa-sort-amount-asc"></i> 
			<select name="sortOrder" id="sortOrder" onchange="all_v4_InvoicesFilter();">
				<option value="ASC" selected="selected"> <?= ASCENDING ?> </option>
				<option value="DESC"> <?= DESCENDING ?> </option>
			</select>
			
		</div>
	
	</div>

	<div id="show_v4_Invoices"><?= THERE_ARE_NO . DATA ?></div>
	
	<? 
		// inList razlikuje je li direktan poziv Edit transfera (npr. iz dashboarda)
		// ili ide preko liste svih transfera
		// ako je iz liste, onda je true
		$inList = true;
		define("READ_ONLY_FLD", '');
		// Poziva se template za Listu i za Edit transfera
		// koristi handlebars
		require_once $modulesPath .'/v4_Invoices/v4_InvoicesListTemplate.'.$_SESSION['GroupProfile'].'.php'; 
		require_once $modulesPath .'/v4_Invoices/v4_InvoicesEditForm.'.$_SESSION['GroupProfile'].'.php'; 
	?>
	<br>
	<div id="pageSelect" class="col-md-12"></div>
	<br><br><br><br>
</div>

<? require_once ROOTPATH.'/p/modules/v4_Invoices/v4_Invoices_JS.php' ?>	

<script type="text/javascript">
	$(document).ready(function(){
		//$(".datepicker").pickadate({format:'yyyy-mm-dd'});
		all_v4_Invoices(); // definirano u v4_Invoices_JS.php
	});

	function all_v4_InvoicesFilter() {
		all_v4_Invoices(); // definirano u v4_Invoices_JS.php
	}
</script>	
	
