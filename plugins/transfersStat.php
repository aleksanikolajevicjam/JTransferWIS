<? 
error_reporting(E_PARSE);

//echo ROOTPATH;
require_once '../f/f.php';
require_once '../db/db.class.php';

$today  = strtotime("today 00:00");
$today = date("Y-m-d", $today);
$nyd=strtotime("today 00:00")+365*24*3600;
$nyd = date("Y-m-d", $nyd);

require_once ROOT . '/db/v4_AuthUsers.class.php';
$au = new v4_AuthUsers();  
function getUsers($alid)
{
	global $au;
	$retArr = array();
	
	$where = " WHERE AuthLevelID = '".$alid."' ";
	$k = $au->getKeysBy("AuthUserCompany", "asc", $where);
	
	if(count($k) > 0 ) {
		foreach($k as $nn => $key) {
			$au->getRow($key);
			if ($au->AuthUserCompany !='') $retArr[$au->AuthUserID] = $au->AuthUserCompany;
		}
	}
	return $retArr;
} 

require_once ROOT . '/db/v4_VehicleTypes.class.php';
$vt = new v4_VehicleTypes();  
function getVT()
{
	global $vt;
	$retArr = array();
	
	$where = "";
	$k = $vt->getKeysBy("VehicleTypeName", "asc", $where);
	
	if(count($k) > 0 ) {
		foreach($k as $nn => $key) {
			$vt->getRow($key);
			if ($vt->VehicleTypeName !='') $retArr[$vt->VehicleTypeID] = $vt->VehicleTypeName;
		}
	}
	return $retArr;
} 

?>
<style>
	.indt {
		font-size: 80%;	
	}	
</style>

<div class="container-fluid "> 
	<h2>TRANSFERS REVIEW</h2>
	<form id="transfersStatForm" class="form box box-solid" onsubmit="return false;">
		<div class="row pad1em" >
			<div class="col-md-1">
				Status 1:<br>
				<select id="status1" name="status1" class="form-control w75">
					<option value="0">All</option>
					<option value="1">Active</option>
					<option value="2">Changed</option>
					<option value="3">Canceled</option>
					<option value="4">Temp</option>
					<option value="5">Completed</option>					
					<option value="9">Deleted</option>
				</select>
			</div> 		
			<div class="col-md-1">
				Client:<br>
				<select id="client" name="client" class="form-control w75">
					<option value="0">All</option>
					<option value="2">Agents</option>
					<option value="3">Direct Clients</option>
					<option value="4">Affiliate</option>
					<option value="5">IFrame Users</option>
					<option value="6">Api Users</option> 
					<option value="12">Taxi Site</option> 
					<option value="41">Operator</option> 
					<option value="60">Contract</option> 
					<option value="61">Direct Agent</option>  
				</select>
			</div> 
			<div class="col-md-1">
				Location:	
				<input class="form-control" type="text" id="Terminal" name="Terminal" value="" 
					onchange="$('#RDestination').val(this.value);"
					placeholder="Start typing to search...">
				<span id="FN" class="input-group-addon"><i class="fa fa-search"></i></span>
				<div id="fromList" style="display:none"></div>
			</div> 	
			<div class="col-md-1">
				Agents:
				<? $agents = getUsers(2); ?>
				<select name="AgentID" id="AgentID" class="form-control w75">
					<option value="0"> All</option>
						<? 
						foreach($agents as $id => $name) {
							echo '<option value="'.$id.'">' . $name .'</option>';
						}
						?>
				</select>
			</div>
			
			<div class="col-md-1">
				Partner:	
				<? $agents = getUsers(31); ?>
				<select name="DriverID" id="DriverID" class="form-control w75">
					<option value="0"> All</option>
					<option value="9998">EXTERNAL ALL</option>
					<option value="9999">JAM GROUP ALL</option>

						<? 
						foreach($agents as $id => $name) {
							echo '<option value="'.$id.'">' . $name .'</option>';
						}
						?>
				</select>				
			</div> 				
			<div class="col-md-1">
				Status 2:<br>
				<select id="status" name="status" class="form-control w75">
					<option value="99">All</option>
					<option value="0">No driver</option>
					<option value="1">Not confirmed</option>
					<option value="2">Confirmed</option>
					<option value="3">Ready</option>
					<option value="4">Declined</option> 
					<option value="5">No show</option>
					<option value="6">Driver Error</option>
					<option value="8">Operator Error</option>
					<option value="9">Dispatcher Error</option>
					<option value="10">Agent Error</option>
					<option value="11">Force majeure</option>
					<option value="12">Pending</option>					
					<option value="7">Completed</option>
				</select>					
			</div> 	  
			<div class="col-md-1">
				Vehicle type:
				<? $types = getVT(); ?>
				<select name="VehicleTypeID" id="VehicleTypeID" class="form-control w75">
					<option value="0"> All</option>
						<? 
						foreach($types as $id => $name) {
							echo '<option value="'.$id.'">' . $name .'</option>';
						}
						?>
				</select>						
			</div> 	 		
			<div class="col-md-2">
				Orders range: 
					<input type="text" id="DateStart" name="DateStart" class="datepicker form-control w75" value="">
					<input type="text" id="DateEnd" name="DateEnd" class="datepicker form-control w75" value="<? echo $today; ?>">
			</div>	
			<div class="col-md-2">
				Transfers range:
					<input type="text" id="DateStartT" name="DateStartT" class="datepicker form-control w75" value="">
					<input type="text" id="DateEndT" name="DateEndT" class="datepicker form-control w75" value="<? echo $nyd; ?>">
			</div>
			<div class="col-md-1"><button type="text"class="submit" name='stype' value='stat'>Stat</button></div>
			<div class="col-md-1"><button type="text" class="submit" name='stype' value='list'>List by Pickup Date</button></div>

		</div>	
	</form>
	<div><div id="statcontainer" class="center" style='display:none'></div></div>  	 
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$(".datepicker").pickadate({format:'yyyy-mm-dd'});
	});
	$('.submit').click(function(){
		var formData = $("#transfersStatForm").serialize();
		formData=formData+'&stype='+$(this).val();
		$.ajax({
            url: 'plugins/transfersStatCalc.php',
            type: 'POST',
            //dataType: 'jsonp',
            data: formData,
            error: function() {
            }, 
            success: function(data) {
				$('#statcontainer').html(data); 
				$('#statcontainer').show(500);   
			}	
		})
		
		
	})	

	$("#Terminal").keyup(function() {
		var filter = $(this).val();
		var where = ' WHERE PlaceID > 0 ';
		if(filter.length > 2) {	
			// console.log(filter);
			$.getJSON("/cms/p/modules/v4_Places/v4_Places_All.php?callback=?&Search="+filter+"&where="+where,
			 function(data) {
			 // console.log(data);
			 	$("#fromList").show();
			 	$("#fromList").html('<select name="TerminalSelect" id="TerminalSelect" class="form-group w100 blue" onchange="TSChange();">');
				$.each(data.data, function (index, value) {
		  			$("#TerminalSelect").append('<option value="'+value.PlaceID+'">'+value.PlaceNameEN + '</option>');
				});
				$("#fromList").append('</select>');
			});
		}
	});	

</script>

