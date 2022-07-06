<?

//require_once "./f/form_functions.php";
//require_once "./data.php";
error_reporting(0);

@session_start(); if (!$_SESSION['logged']) die('Bye, bye');

$status = 0;

if (isset($_REQUEST['f'])) $status = $_REQUEST['f'];

$getscript = './g/get_allTransfers.php?driver='.$_SESSION['AuthUserID'].'&f='.$status;


?>

<script type="text/javascript" language="javascript">

$(document).ready(function() {

	oTable = $('#allTransfersTable').dataTable({
					"aaSorting": [[2,'asc']],
					"bProcessing": true,
					"bServerSide": true,
					"bStateSave": false,
					"bJQueryUI": false,
					"bInfo": true,
					"sPaginationType": "full_numbers",
					"aLengthMenu": [[10, 20, 100], [10, 20, 100]],
					"iDisplayLength": 10,
					"bAutoWidth": false,
					"aoColumns": [ 
						null,null,null,
						null,null,null,
						{ "bSearchable": false, "bSortable":false},
						{ "bSearchable": false, "bSortable":false },
						{ "bSearchable": false, "bSortable":false }
					],					
					"sAjaxSource": "<?= $getscript; ?>"//,
					//"oLanguage": {"sUrl": "dataTables.<?=DT_LANGUAGE?>.txt"}
	});
	$(".paginate_button").addClass("btn");
	$(".paginate_active").addClass("btn-primary");
	$(".paginate_button").addClass("btn");	

});


</script>

<?


# akcija iz tabelarnog prikaza
if (isset($_REQUEST['action']))
{
	switch ($_REQUEST['action'])
	{
		# ako je pritisnut edit botun
		case 'edit':
			require "../edit/edit_activeTransfer.php";
		break;
	
		# ako se dodaje novi slog
		case 'insert':
			//$myforma->newRec('new_form');
		break;	
			
		# inace, prikazi tabelu 
		default:
			showTable();
		break;
	}
}
else showTable();

# povratak iz obrade jednog sloga - form 


# ako je zatrazen Update
if (isset($_REQUEST['update'])) 
{
//ShowAll();
//echo '<pre>'; echo print_r($_REQUEST); echo '</pre>';
	updateFromPost(DB_PREFIX.'OrderDetails', 'DetailsID',
					  $_REQUEST['DetailsID']);
}
# ako je zatrazen Delete
if (isset($_REQUEST['delete'])) 
{
	//$myforma->deleteRec();
}
# ako je zatrazen Insert
if (isset($_REQUEST['insert'])) 
{
	# ako je potrebno podatke obraditi prije upisa,
	# to se treba ovdje napraviti
	//$myforma->insertRec();
}



function showTable()
{
	global $StatusDescription;
?>
        <div id="help" style="display:none">
        	<? //require_once './h/'.$_SESSION['lng'].'/transfers.html'; ?>
        </div>
        
<h2><?= ALL_TRANSFERS ?> 
    <button onclick="$('#help').toggle('slow');return false;"><i class="fa-question-sign"></i></button>
</h2>
<div class="btn-group">
	<a id="show0" href="index.php?p=transfers&f=0" class="btn btn-xs"><?= ALL_TRANSFERS ?></a>
	<a id="show1" href="index.php?p=transfers&f=1" class="btn btn-xs"><?= $StatusDescription[1]; ?></a>
	<a id="show2" href="index.php?p=transfers&f=2" class="btn btn-xs"><?= $StatusDescription[2]; ?></a>
	<a id="show3" href="index.php?p=transfers&f=3" class="btn btn-xs"><?= $StatusDescription[3]; ?></a>
	<a id="show4" href="index.php?p=transfers&f=4" class="btn btn-xs"><?= $StatusDescription[4]; ?></a>
	<a id="show5" href="index.php?p=transfers&f=5" class="btn btn-xs"><?= $StatusDescription[5]; ?></a>
	<a id="show6" href="index.php?p=transfers&f=6" class="btn btn-xs"><?= $StatusDescription[6]; ?></a>
	<a id="show7" href="index.php?p=transfers&f=7" class="btn btn-xs"><?= $StatusDescription[7]; ?></a>
</div>	
<hr/>
<table  class="display table table-striped table-condensed table-hover" id="allTransfersTable" 
style="font-size:.9em;"
>
	<thead>
		<tr>
			<th width="20"><?= ORDER_ID ?></th>
			<th width="20"><?= DETAILS_ID ?></th>
			<th width="100"><?= DATE ?><br/><?= TIME ?></th>

			<th><?= FROM ?><br/><?= TO ?></th>

			<th width="20"><?= PAX_NO ?></th>

			<th><?= PAX_NAME ?></th>
			<th width="1%"><?= STATUS ?><?//= '<br/>'.DRIVER . STATUS ?></th>
			<th><?= DRIVER ?><br/><?= VEHICLE ?></th>
			<th width="10%"></th>
		

			
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="5" class="bogoLoading">Loading data from server</td>
		</tr>
	</tbody>

</table>
<? } ?>


<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><?= CHANGE_TRANSFER_STATUS ?></h3>
  </div>
    <form id="changeTransferStatus" method="post" action="index.php?o=1">
      <div class="modal-body" id="myModalBody">
     
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button type="submit" class="btn btn-primary" data-dismiss="modal">Save changes</button>
      </div>
  </form>
</div>
		
<script type="text/javascript">

    $("#show<?= $status?>").addClass('btn-primary');
   
    function changeTransferStatus(id)
    {
   		$.get("./a/ajax_getStatusAndNotes.php",{ DetailsID: id},
        	function(data){ 
        	    $("#myModalBody").html(data);
        	    $("#myModal").modal('toggle');
        	});

        
        return true;
    }

</script>
<script type="text/javascript">
    function DrvrChange(detailsid) {
        var newDrvr = $("#pickdrvr"+detailsid).val();

            //alert(newDrvr+' '+detailsid);
            
   		$.get("./a/ajax_ChgMyDriver.php",{ DetailsID: detailsid, NewDriver: newDrvr},
        	function(data){ 
        	    //alert(data);
        	});


    }
</script>

