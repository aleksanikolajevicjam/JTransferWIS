<?
error_reporting(E_ALL);

require_once 'data.php';

?>
<h2>Troškovi</h2>
<form onsubmit="return false;">
	<div class="row">
		<div class="span4">
			<label for="exDate">Datum *: </label>
			<input id="exDate" name="exDate" type="text" class="datepicker" />


			<label for="exDriver">Vozač: </label>
			<select id="exDriver" name="exDriver" >
				<?
					$d = DriversList();
					
					foreach($d as $id => $name) {
						echo '<option value="'.$id.'">'.$name.'</option>';
					}
				
				?>
			</select>

			
			<label for="exType">Vrsta troška: </label>
			<select id="exType" name="exType" >
				<?/*
					$d = DriversList();
					
					foreach($d as $id => $name) {
						echo '<option value="'.$id.'">'.$name.'</option>';
					}
				*/
				?>
				<option value="Honorar">Honorar</option>
				<option value="Gorivo">Gorivo</option>
				<option value="Parking">Parking</option>
				<option value="Pranje">Pranje</option>
				<option value="Trajekt">Trajekt</option>
				<option value="Autoput">Autoput</option>
				<option value="Kazne">Kazne</option>
				<option value="Popravci">Popravci</option>
				<option value="Razno">Razno</option>
			</select>
			
			<!--
			<label for="exTypeNew">New Type:</label>
			<input id="exTypeNew" name="exTypeNew" type="text" />
			<button >[+]</button>
			-->
			
			<label for="exAmt">Iznos (kn):</label>
			<input id="exAmt" name="exAmt" type="text" />
			
			<br>
			<button id="add" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i> &nbsp;Dodaj </button>
		</div>
		
		<div class="span7">
			<p class="lead">Troškovi</p>
			<div id="exForDate"></div>
			<!--
			<div id="exSum"></div>
			<input type="hidden" id="exSumFld"/>
			-->
		</div>

	</div><!--/row-->
</form>

<script type="text/javascript">

	$("#add").click(function(){
	
		var d = $("#exDate").val();
		if (d == '') { alert('Di ti je datum šefe ?'); $("#exDate").focus();return false; }

		var t = $("#exType").val();
		var v = $("#exDriver").val();
		var a = $("#exAmt").val();
		
		if (a == 0) { alert('A ovo je bilo mukte, je li ?'); $("#exAmt").focus();return false; }

		if (!isNumber(a)) {alert("Mudrac... Unesi broj!");$("#exAmt").focus();return false;}
		

		
		var es= $("#exSumFld").val()*1;
		var s = a*1 + es*1;	
		
		$.ajax({
		  type: "POST",
		  url: "ajax_expense.php",
		  data: {Datum:d, Driver:v, Type:t, Amount:a, Op:'add'}
		}).done(function( msg ) {

			if (msg != 'Error') {
				$("#exForDate").html(msg);
				
				/*
				$("#exForDate").append('<div class="span3">'+ t + ' (' + v + ')' + '</div><div class="span2" align="right">' + 
				a.toFixed(2) + ' kn</div>');
		
				$("#exAmt").val('');

				$("#exSumFld").val(s);
		
				$("#exSum").html('<div class="span3"></div><div class="span2" align="right" style="border-top:1px dotted #000">' + 
				s.toFixed(2) + ' kn</div>');
				*/
			}
			else {
				alert('Greška. Podatak nije dodan u bazu.');
			}
		});
		
		return false;
	});



	$("#exDate").change(function(){
		var d = $("#exDate").val();
		$.ajax({
		  type: "POST",
		  url: "ajax_expense.php",
		  data: {Datum:d, Op:'show'}
		}).done(function( msg ) {

			if (msg != 'Error') {
				$("#exForDate").html(msg);
			}
			else {
				alert('Greška. Podatak nije dodan u bazu.');
			}
		});	
	});
	
	
	function deleteExpense(id){

		var d = $("#exDate").val();

		$.ajax({
		  type: "POST",
		  url: "ajax_expense.php",
		  data: {Datum:d, ID:id, Op:'delete'}
		}).done(function( msg ) {

			if (msg != 'Error') {
				$("#exForDate").html(msg);
			}
			else {
				alert('Greška. Podatak nije dodan u bazu.');
			}
		});
		
		return false;	
	}
	
	function isNumber(n) {
	  return !isNaN(parseFloat(n)) && isFinite(n);
}
	
</script>

<?

function DriversList() {
	$q = "SELECT * FROM SubDrivers ORDER BY DriverName ASC";
	$w = mysql_query($q) or die(mysql_error(). ' SubDrivers - expenses');
	
	$drivers = array();
	
	while ($d = mysql_fetch_object($w)) {
		$drivers[$d->DriverName] = $d->DriverName;
	} 
	
	return $drivers;
}
