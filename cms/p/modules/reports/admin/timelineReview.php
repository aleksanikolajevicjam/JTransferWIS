<script>
function showOperator(id,action,d1,d2) {
	if ( $("#o_"+id).css('display') != 'none') {
			$("#o_"+id).hide('slow'); return;
		}
	$(".opertransfer").hide('slow');
	

	var url = window.root + '/cms/a/timeline.php?id='+id+'&action='+action+'&dateFrom='+d1+'&dateTo='+d2;
	$("#o_"+id).load(url);
	$("#o_"+id).show('slow'); 
}
</script>
<?
	@session_start();
	
    $db = new DataBaseMysql();

	//potrebna polja za query
	if (isset($_REQUEST['DateFrom'])) $DateFrom = $_REQUEST['DateFrom'];
	else $DateFrom = "2019-07-11";
	if (isset($_REQUEST['DateTo'])) $DateTo = $_REQUEST['DateTo'];
	else $DateTo=date("Y-m-d");

	$sub = array();
	$cash = array();
?>

	<div class="container white center">
		<style>
		    input, select { width: 200px; }
		    #RequiredFrom, #RequiredTo { visibility: hidden; padding-left: 4px; color: red; }
		    .formLabel { width: 100px; display: inline-block; }
		</style>

		<div class="container col-md-12">
			<h1>Timeline Review</h1>
			<form action="" method="POST" type="submit" onsubmit="return validate();">

				<div class="row">
					<div class="col-md-3">
						<label>Action Date From</label>
						<input type="text" value="<?=$DateFrom ?>" name="DateFrom" class="datepicker">
					</div>

					<div class="col-md-3">
						<label>Action Date To</label>
						<input type="text" value="<?=$DateTo ?>" name="DateTo" class="datepicker">
					</div>

					<div class="col-md-3">
						<label>Action</label>

						<select name="Action" class="form-control" value='<?=$_REQUEST['Action'] ?>'>
							<option value="Insert" <? if ($_REQUEST['Action']=='Insert') echo 'SELECTED'; ?>>Insert transfer</option>
							<option value="Update" <? if ($_REQUEST['Action']=='Update') echo 'SELECTED'; ?>>Update transfer</option>
							<option value="ChangePrice" <? if ($_REQUEST['Action']=='ChangePrice') echo 'SELECTED'; ?>>Change price</option>
							<option value="Cancel" <? if ($_REQUEST['Action']=='Cancel') echo 'SELECTED'; ?>>Cancel transfer</option>
							<option value="NoShow" <? if ($_REQUEST['Action']=='NoShow') echo 'SELECTED'; ?>>NoShow</option>
							<option value="DriverError" <? if ($_REQUEST['Action']=='DriverError') echo 'SELECTED'; ?>>Driver Error</option>
							<option value="OperatorError" <? if ($_REQUEST['Action']=='OperatorError') echo 'SELECTED'; ?>>Operator Error</option>
							<option value="DispatcherError" <? if ($_REQUEST['Action']=='DispatcherError') echo 'SELECTED'; ?>>Dispatcher Error</option>
						</select>
					</div>
				

					<div class="col-md-3">
						<button type="submit" class="btn btn-primary" name="submit"
						style="margin-left: 105px">Submit</button>
					</div>
				</div>	
			</form>
			
		
	<?


	//ako imamo oba datuma prikazi izvjestaj
	if( isset($_REQUEST['DateFrom']) and isset($_REQUEST['DateTo']) ){

		
		$q  = "SELECT v4_OrderLog.UserID,v4_AuthUsers.AuthUserRealName as name, count(*) as num FROM `v4_OrderLog`,v4_AuthUsers,v4_OrderDetails ";
		$q .= "WHERE v4_OrderLog.UserID=v4_AuthUsers.AuthUserID and v4_OrderDetails.DetailsID=v4_OrderLog.DetailsID and v4_OrderDetails.TransferStatus<9";
		if ($_REQUEST['Action']!='ChangePrice') $q .= " AND `Action`='".$_REQUEST['Action']."'";	
		else $q .= " AND `Description`  like '%CHANGE PRICE REASON%' ";		
		//$q .= " AND OrderDate >= '".$DateFrom."'";
		//$q .= " AND OrderDate <= '".$DateTo."'";
		$q .= " AND v4_OrderLog.DateAdded >= '".$DateFrom."'"; 
		$q .= " AND v4_OrderLog.DateAdded <= '".$DateTo."'";	
		$q .= " GROUP BY v4_OrderLog.UserID ORDER BY `num` DESC";


		$r = $db->RunQuery($q);

		if($r->num_rows > 0 ){

		
			while($od = $r->fetch_object() ){

			?>
			<a onclick="showOperator(<?=$od->UserID ?>,'<?=$_REQUEST['Action'] ?>', '<?=$DateFrom ?>', '<?=$DateTo ?>')">
				<div class="row xbox-solid xbg-light-blue white pad1em listTile" style="border-top:1px solid #eee;border-bottom:0px solid #eee" >
					<div class="col-sm-6">
						<?=$od->UserID ?> <?=$od->name ?>
					</div>

					<div class="col-sm-6">
						<?=$od->num ?>
					</div>
				</div>
			</a>	
			
			<div id='o_<?=$od->UserID ?>' style='display:none' class='opertransfer'>
				
			</div>	
			<?
			}
		}	
	} 
	?>
		</div>
	</div>







