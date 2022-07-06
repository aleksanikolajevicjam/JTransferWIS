<?
require_once 'data.php';

define("B", " ");
define("NL", "<br>");

if (isset($_REQUEST['reset']) and $_REQUEST['reset'] != 0) $_REQUEST = array();	
	
if (isset($_REQUEST['StartDate']) and isset($_REQUEST['EndDate']))
{

	$total = 0;
	$totNow = 0;
	$totLater = 0;
	$totInv = 0;
		
	#++++++++++++++++++++++++++++++++++++++++++++++++++
	# polazni transferi
	#++++++++++++++++++++++++++++++++++++++++++++++++++
	$q = "SELECT *, PickupDate AS ArrDate  FROM TimeTable "; 
	
	if ($_REQUEST['SSubDriver'] != 0) {
	$q .= " WHERE (SubDriver = " . $_REQUEST['SSubDriver'];
	$q .= " OR SubDriver2 = " . $_REQUEST['SSubDriver'];
	$q .= " OR SubDriver3 = " . $_REQUEST['SSubDriver'];
	$q .= " ) AND ";
	}
	else $q .= " WHERE ";
	        
    $q .= " PickupDate >= '{$_REQUEST['StartDate']}' 
		  AND PickupDate <= '{$_REQUEST['EndDate']}' 
		  AND OrderStatus != '3' ";

	//if (!empty($_REQUEST['driverid'])) 
	//$q .= ' AND Driver = ' . $_REQUEST['driverid'] . ' ';


	if ($_REQUEST['SortSubDriver'] != '0') $q.= "  ORDER BY  ArrDate ASC, SubDriver ASC, PickupTime ASC ";
	else $q .= "  ORDER BY  ArrDate ASC, PickupTime ASC";


    //$q .= " ORDER BY  ArrDate ASC, SubDriver ASC, PickupTime ASC";
		  
	$e = mysql_query($q) or die(mysql_error());
	
	$totalTransfers = mysql_num_rows($e);
    // output as file
    //query_to_csv($conn, $q, "TransfersList.csv", false, true);
    
    echo '<p class="lead">Transfers List - From: ' . YMD_to_DMY($_REQUEST['StartDate']) . ' To: ' . YMD_to_DMY($_REQUEST['EndDate']) . '</p>';
	echo '';

    echo '<form action="index.php?o=11" method="POST">';
    hiddenField('StartDate', $_REQUEST['StartDate']);
    hiddenField('EndDate', $_REQUEST['EndDate']);
    hiddenField('SSubDriver', $_REQUEST['SSubDriver']);
    hiddenField('SortSubDriver', $_REQUEST['SortSubDriver']);
    ?>
    Sort: <span class="label label-info"> Date </span><span class="label label-info"><i class="icon icon-white icon-plus"></i> Time </span>
    <button type="submit" class="label label-info" onclick='Sortiraj();' style="border:none !important"><i id="SortBtn" class="icon icon-white"></i> SubDriver</button>
    </form>  
    <form action="print.php" method="post">
    <?
    hiddenField('StartDate', $_REQUEST['StartDate']);
    hiddenField('EndDate', $_REQUEST['EndDate']);
    hiddenField('SSubDriver', $_REQUEST['SSubDriver']);
    hiddenField('SortSubDriver', $_REQUEST['SortSubDriver']);
    ?>
    <button type="submit"> Print </button>
    </form>
     
    <?

    echo '<hr/>';
	
	$i = 0;
	$totalPayLater = 0;
	$totalCashIn = 0;   
	$totalOrderPrice = 0;
	$totalPayNow = 0;

while ($t = mysql_fetch_object($e)) {

 
    
    # oznaci gdje ima, a gdje nema vozaca i vozila
    if ($t->SubDriver == '0' or $t->Car == '0') {
        $style= "border-left: 8px solid red !important; padding-left: 12px;";
    }
    else $style= "border-left: 8px solid green !important;padding-left: 12px;";
    
    # zbroji cash za naplatu
    $totalPayLater += $t->PayLater;
    $totalCashIn += $t->CashIn;

?>    
    <div class="row alert-info" style="padding-top: 15px;padding-bottom:5px;">
       
        <div class="span2">
            <span class="lead" style="<?= $style ?>"><?= YMD_to_DMY($t->PickupDate) ?></span>

		<a href="http://www.jamtransfer.com/cms/printTransfer.php?OrderID=<?= $t->OrderID ?>" target="_blank"><?= $t->OrderKey ?>-<?= $t->TNo ?></a><br />            
        </div>

        <div class="span4">
            <b><?= $t->FromPlace ?> - <?= $t->ToPlace ?></b><br/>
            Card: <?= $t->PayNow ?> EUR - <b>Cash: <?= $t->PayLater ?></b> EUR<br>
            <? echo hasReturn($t->OrderKey, $t->ID); ?>
        </div>
        <div class="span4 pull-right">    
       		 <? SubDriver($t->SubDriver, $i); Car($t->Car, $i); ?> <a href="#" onclick="return ShowSubdriver2('<?= $i ?>');"> + </a>
       		
       		<div id="subDriver2<?= $i ?>" style="display:none">
       			<? SubDriver2($t->SubDriver2, $i); Car2($t->Car2, $i); ?>  <a href="#" onclick="return ShowSubdriver3('<?= $i ?>');"> + </a>
       		</div>

       		<div id="subDriver3<?= $i ?>" style="display:none">
       			<? SubDriver3($t->SubDriver3, $i); Car3($t->Car3, $i); ?>  
       		</div>
       		
        </div>
        <div class="span2 pull-right">
            
            <input type="text" class="timepicker span1" id="PickupTime_<?= $i ?>" name="PickupTime_<?= $i ?>"
            onchange="updateNotes(<?= $i ?>)" value="<?= $t->PickupTime ?>"
            style="font-weight:bold; font-size:1.2em;line-height: 1em;margin:2px;padding-left:2px;"/>
            
            <button onclick="ShowShow(<?= $i?>)">&nbsp;</button>
            <small>P: <?= $t->PaxNo ?>-V: <?= $t->VehicleType ?> <? if($extras != '') echo '<strong>X</strong>';?></small>
        </div>        
    </div> <!--/row-->
    
    <div class="row" id="show<?= $i ?>" style="display:none">
        <div class="span2">
            <?= $t->OrderKey ?>
            <br>
            <?= $t->SingleReturn ?>
            <b>Pax: <?= $t->PaxNo ?> VT: <?= $t->VehicleType ?></b><br>
            <?=$t->OrderPickupDate ?> <?=$t->OrderPickupTime ?><br>
            <?= $t->PaxName ?><br/>
            <?= $t->PaxTel ?>
        </div>
        
        
        <div class="span4">
            <b><?= $t->FromPlace ?></b>
            <br> 
                <?= $t->FromAddress ?>
                <br>
                <?= $t->PickupDetails ?>
                <br>
                <?= $t->PaxNote ?>
        </div>

        <div class="span3">
            <b><?= $t->ToPlace ?></b>
            <br>
            <?= $t->ToAddress ?>
            
			<?
			
				if($extras != '') echo '<hr>'.$extras;
				else echo '<br><hr>No extras';
			
			
			?>
        </div>
    
        <div class="span3">

            <small>Flight No / Time:</small><br/>
            
            <input type="text" class="span2" name="FlightNo_<?= $i ?>" id="FlightNo_<?= $i ?>" 
		    value="<?= $t->FlightNo ?>" xonchange="updateNotes('<?= $i ?>');" />
		
		    <input type="text" class="span1 timepicker" name="FlightTime_<?= $i ?>" id="FlightTime_<?= $i ?>" 
		    value="<?= $t->FlightTime ?>" xonchange="updateNotes('<?= $i ?>');" />         
		    
		    <br>

		    <small>Notes to driver:</small><br/>
		    <textarea style="border: 1px solid #eee;" name="SubDriverNote_<?= $i ?>" 
		    id="SubDriverNote_<?= $i ?>" class="span3"
		    xonchange="updateNotes('<?= $i ?>');"><?= stripslashes( $t->SubDriverNote ) ?></textarea>
		    <small>Razduženo - Cash (€):</small><br/>
			<input type="text" name="CashIn_<?= $i ?>" id="CashIn_<?= $i ?>" xonchange="updateNotes('<?= $i ?>');" value="<?= $t->CashIn; ?>"><br>
			
			<button class="btn btn-primary" onclick="updateNotes('<?= $i ?>');"> Save </button>
			
			
			<? if ($t->SingleReturn == 'Return') { ?>
				<button name="UpdateReturn_<?= $i ?>" 
				id="UpdateReturn_<?= $i ?>" value="0" onclick="$(this).val('1');updateNotes('<?= $i ?>');$(this).val('0');"> 
				Ažuriraj i drugi transfer? 
				</button>
				<br><br>
				<button class="btn btn-danger" name="DeleteTransfer_<?= $i ?>" 
				id="DeleteTransfer__<?= $i ?>" value="0" onclick="deleteTransfer('<?= $i ?>');"> 
				Izbriši ovaj transfer 
				</button>				
			<?}?>
		    <div style="display:inline-block;color:#900;" id="upd<?= $i ?>"></div>
		    <div><br><strong>Final note: </strong><?= $t->FinalNote ?></div>


		    
        </div>

    </div><!--/row-->
     <div class="row" id="showR<?= $i ?>" style="display:none">
        <div class="span12">
        	<hr>
        	<? if(!empty($t->PDFFile)) { ?>
        	<div id="existingPDF<?= $i ?>" style="display: inline">
				  
				<a href="http://www.jamtransfer.com/cms/raspored/PDF/<?= $t->PDFFile ?>" target="_blank"
				class="btn btn-small btn-primary">
				Download Receipt <?= $t->PDFFile ?></a>&nbsp;&nbsp;
				<button onclick="return deletePDF('<?= $t->PDFFile ?>','<?= $i ?>','<?= $t->ID?>');" 
				class="btn btn-small btn-danger" >
				Delete Receipt <?= $t->PDFFile ?> </button>&nbsp;&nbsp; 
			</div>
			<? } ?>
		
			<form name="form" action="" method="POST" enctype="multipart/form-data" style="display:inline">
				<input type="file" name="PDFFile_<?= $i ?>" id="PDFFile_<?= $i ?>" 
				onchange="return ajaxFileUpload('<?= $i ?>');" style="display:none">
				<input type="hidden" name="ID_<?= $i ?>" id="ID_<?= $i ?>" value="<?= $t->ID?>">
										<button id="imgUpload" class="btn btn-small btn-default" 
											onclick="$('#PDFFile_<?= $i ?>').click();return false;">
											Upload new PDF 
										</button>

			</form>
			<div style="display:inline-block;color:#900;" id="PDFUploaded_<?= $i ?>"></div>

        </div>
    </div><!--/row-->
    <hr/>
 <? 
		# save OrderID with same index as the price
		hiddenField('ID_'.$i, $t->ID);
		hiddenField('OrderID_'.$i, $t->OrderID);
		hiddenField('UpdateReturn_'.$i, '0');
		//hiddenField('FlightTime_'.$i, $t->FlightTime);
		//hiddenField('SubDriver_'.$i, $t->SubDriver);
		//hiddenField('Car_'.$i, $t->Car);
		//hiddenField('SubDriverNote_'.$i, $t->SubDriverNote);
		
		$i++;  
}
/*
	$qx = "SELECT tt.PickupDate, tt.PickupTime, tt.PaxName, tt.PaxTel, tt.FromPlace, tt.ToPlace, tt.SingleReturn, tt.PaxNo, tt.OrderKey, tt.PayLater, tt.PaxNote, sd.DriverName, v.VehicleDescription FROM TimeTable AS tt, SubDrivers AS sd, Vehicles AS v "; 
	
	if ($_REQUEST['SSubDriver'] != 0) 
	$qx .= " WHERE SubDriver = " . $_REQUEST['SSubDriver'] . " AND ";
	else $qx .= " WHERE ";
	        
    $qx .= " PickupDate >= '{$_REQUEST['StartDate']}' 
		  AND PickupDate <= '{$_REQUEST['EndDate']}' 
		  AND OrderStatus != '3' 
		  AND sd.DriverID = tt.SubDriver AND v.VehicleID = tt.Car 
		  ";

    query_to_csv($conn, $qx, 'TransfersList.csv');
*/

echo '<div class="row alert alert-success"><div class="span8">';
echo 'Transfers: ' . $totalTransfers;
echo ' | ';

echo 'Total Card : ' . number_format($totalPayNow,2) . ' EUR ';
echo ' | ';

echo 'Total cash : ' . number_format($totalPayLater,2) . ' EUR ';
echo ' | ';

echo 'Total paid : ' . number_format($totalCashIn,2) . ' EUR ';
//echo ' | ';

//echo 'Total Orders: ' . number_format($totalPayNow + $totalPayLater,2) . ' EUR ';
echo '</div>';
//echo '</div><div class="span3">';
//echo '<a href="TransfersList.csv">Download CSV</a></div>';
echo '</div>';



}
else
{

	echo '<div align="left" style="padding: 10px;" >';
	echo '<form action="index.php?o=11" method="POST">';
	
	echo '<h1>Transfers List</h1>';
	
	echo '<div style="width:100px;display: inline-block">Start Date:</div> 
	        <input type="text" name="StartDate" id="StartDate" value="" size="12" class="datepicker"/>';
	echo '<br/>';
	echo '<div style="width:100px;display: inline-block">End  Date:</div> 
	        <input type="text" name="EndDate" id="EndDate" value="" size="12" class="datepicker"/>';
	
	echo '<br/><br/>';
	echo 'Optional<hr/>';
	echo '<div style="width:100px;display: inline-block">SubDriver:</div>';
	SSubDriver();
	echo '<br/><br/>';
	echo '<input type="hidden" name="SortSubDriver" id="SortSubDriver" value="0"/>';
	echo '<input class="btn btn-primary" type="submit" value=" Show transfers " name="submit" />';
	echo '</form>';
	echo '</div>';
}


#
# hidden polja
#
function hiddenField($name,$value)
{
	echo '<input name="'.$name.'" id="'.$name.'" type="hidden" value="'.$value.'" />';
}

function SSubDriver()
{

        echo '<select class="span2" id="SSubDriver" name="SSubDriver">';
        echo '<option value="0"';
        //if ($driver == '0') echo ' selected="selected" ';
        echo '> --- </option>';
        
        $q = "SELECT * FROM SubDrivers ORDER BY DriverName ASC";
        $r = mysql_query($q) or die( mysql_error() . ' SSubDriver Selector');
        
        while ($d = mysql_fetch_object($r)) {
            echo '<option value="' . $d->DriverID . '" ';
            //if ($driver == $d->DriverID) echo ' selected="selected" ';
            echo '>'. $d->DriverName . '</option>';
        }
        echo '</select>';
}

function SubDriver($driver, $i)
{

        echo '<select class="span2" id="SubDriver_'.$i.'" name="SubDriver_'.$i.'" onchange="updateNotes('.$i.');" >';
        echo '<option value="0"';
        if ($driver == '0') echo ' selected="selected" ';
        echo '> --- </option>';
        
        $q = "SELECT * FROM SubDrivers ORDER BY DriverName ASC";
        $r = mysql_query($q) or die( mysql_error() . ' SubDriver Selector');
        
        while ($d = mysql_fetch_object($r)) {
            echo '<option value="' . $d->DriverID . '" ';
            if ($driver == $d->DriverID) echo ' selected="selected" ';
            echo '>'. $d->DriverName . '</option>';
        }
        echo '</select>';
}


function SubDriver2($driver, $i)
{

        echo '<select class="span2" id="SubDriver2_'.$i.'" name="SubDriver2_'.$i.'" onchange="updateNotes('.$i.');" >';
        echo '<option value="0"';
        if ($driver == '0') echo ' selected="selected" ';
        echo '> --- </option>';
        
        $q = "SELECT * FROM SubDrivers ORDER BY DriverName ASC";
        $r = mysql_query($q) or die( mysql_error() . ' SubDriver2 Selector');
        
        while ($d = mysql_fetch_object($r)) {
            echo '<option value="' . $d->DriverID . '" ';
            if ($driver == $d->DriverID) echo ' selected="selected" ';
            echo '>'. $d->DriverName . '</option>';
        }
        echo '</select>';
}

function SubDriver3($driver, $i)
{

        echo '<select class="span2" id="SubDriver3_'.$i.'" name="SubDriver3_'.$i.'" onchange="updateNotes('.$i.');" >';
        echo '<option value="0"';
        if ($driver == '0') echo ' selected="selected" ';
        echo '> --- </option>';
        
        $q = "SELECT * FROM SubDrivers ORDER BY DriverName ASC";
        $r = mysql_query($q) or die( mysql_error() . ' SubDriver3 Selector');
        
        while ($d = mysql_fetch_object($r)) {
            echo '<option value="' . $d->DriverID . '" ';
            if ($driver == $d->DriverID) echo ' selected="selected" ';
            echo '>'. $d->DriverName . '</option>';
        }
        echo '</select>';
}

function Car($car, $i)
{

        echo '<select class="span2" id="Car_'.$i.'" name="Car_'.$i.'" onchange="updateNotes('.$i.');" >';
        echo '<option value="0"';
        if ($car == '0') echo ' selected="selected" ';
        echo '> --- </option>';
        
        $q = "SELECT * FROM Vehicles ORDER BY VehicleDescription ASC";
        $r = mysql_query($q) or die( mysql_error() . ' Car Selector');
        
        while ($d = mysql_fetch_object($r)) {
            echo '<option value="' . $d->VehicleID . '" ';
            if ($car == $d->VehicleID) echo ' selected="selected" ';
            echo '>'. $d->VehicleDescription . '</option>';
        }
        echo '</select>';
}


function Car2($car, $i)
{

        echo '<select class="span2" id="Car2_'.$i.'" name="Car2_'.$i.'" onchange="updateNotes('.$i.');" >';
        echo '<option value="0"';
        if ($car == '0') echo ' selected="selected" ';
        echo '> --- </option>';
        
        $q = "SELECT * FROM Vehicles ORDER BY VehicleDescription ASC";
        $r = mysql_query($q) or die( mysql_error() . ' Car Selector');
        
        while ($d = mysql_fetch_object($r)) {
            echo '<option value="' . $d->VehicleID . '" ';
            if ($car == $d->VehicleID) echo ' selected="selected" ';
            echo '>'. $d->VehicleDescription . '</option>';
        }
        echo '</select>';
}


function Car3($car, $i)
{

        echo '<select class="span2" id="Car3_'.$i.'" name="Car3_'.$i.'" onchange="updateNotes('.$i.');" >';
        echo '<option value="0"';
        if ($car == '0') echo ' selected="selected" ';
        echo '> --- </option>';
        
        $q = "SELECT * FROM Vehicles ORDER BY VehicleDescription ASC";
        $r = mysql_query($q) or die( mysql_error() . ' Car Selector');
        
        while ($d = mysql_fetch_object($r)) {
            echo '<option value="' . $d->VehicleID . '" ';
            if ($car == $d->VehicleID) echo ' selected="selected" ';
            echo '>'. $d->VehicleDescription . '</option>';
        }
        echo '</select>';
}

function query_to_csv($db_conn, $query, $filename, $attachment = false, $headers = true) {
        
        if($attachment) {
            // send response headers to the browser
            header( 'Content-Type: text/csv' );
            header( 'Content-Disposition: attachment;filename='.$filename);
            $fp = fopen('php://output', 'w');
        } else {
            $fp = fopen($filename, 'w');
        }
        
        $result = mysql_query($query, $db_conn) or die( mysql_error( $db_conn ) );
        
        if($headers) {
            // output header row (if at least one row exists)
            $row = mysql_fetch_assoc($result);
            if($row) {
                fputcsv($fp, array_keys($row));
                // reset pointer back to beginning
                mysql_data_seek($result, 0);
            }
        }
        
        while($row = mysql_fetch_assoc($result)) {
            fputcsv($fp, $row);
        }
        
        fclose($fp);
    }
    
    
# Pretvaranje formata datuma
function YMD_to_DMY($date)
{
    $elementi = explode('-',$date);
    $new_date = $elementi[2].'.'.$elementi[1].'.'.$elementi[0];
    return $new_date;
}


function hasReturn($orderKey, $ID) {
	$q  = "SELECT * FROM TimeTable ";
	$q .= "WHERE OrderKey = '" . $orderKey . "' ";
	$q .= "ORDER BY OrderKey ASC, ID ASC ";
	$qr = mysql_query($q) or die('Error in hasReturn query <br/>' . mysql_error());	
	
	$num_rows = mysql_num_rows($qr);
	
	if ($num_rows == 2) {
		while($o = mysql_fetch_object($qr)) {
			if($o->ID > $ID)
			$ret = ' R ' . YMD_to_DMY($o->PickupDate) . ' ' . $o->PickupTime;
		}
		return $ret;
	}
	return '';
}

?>






<script type="text/javascript">
	function deleteTransfer(i)
	{
		var id   = $("#ID_"+i).val();
	
		if(confirm('Sigurno?\nIzbrisani transfer se ne može vratiti!') ) {
			$("#upd"+i).html('<img src="./i/loading.gif">');
		
			$.get("deleteFromTimeTable.php",{ ID: id},
		
			function(data){ $("#upd"+i).html(data); });
		}
	}

	function updateNotes(i)
	{
		var id   = $("#ID_"+i).val();
		var oid  = $("#OrderID_"+i).val();
		
		var fn   = $("#FlightNo_"+i).val();
		var ft   = $("#FlightTime_"+i).val();
		
		var sd  = $("select#SubDriver_"+i).val();
		var c   = $("select#Car_"+i).val();

		var sd2  = $("select#SubDriver2_"+i).val();
		var c2   = $("select#Car2_"+i).val();

		var sd3  = $("select#SubDriver3_"+i).val();
		var c3   = $("select#Car3_"+i).val();

		var n   = $("#SubDriverNote_"+i).val();
		var g   = $("#CashIn_"+i).val();
		var r   = $("#UpdateReturn_"+i).val();
		
		var pt   = $("#PickupTime_"+i).val();
		
		
		//alert(np+' ' + s + ' ' + r);
		$("#upd"+i).html('<img src="./i/loading.gif">');
		
		$.get("ajax_updateNotes.php",{ ID: id, FlightNo: fn, FlightTime: ft, SubDriver: sd, SubDriver2: sd2, SubDriver3: sd3, Notes:n, Car: c, Car2: c2, Car3: c3, PickupTime: pt, CashIn: g, UpdateReturn: r, OrderID: oid },
	function(data){ $("#upd"+i).html(data); });
	    //document.location.reload(true);
	}
	
	function ShowShow(i)
	{
	    $("#show"+i).toggle('slow');
	    $("#showR"+i).toggle('slow');
	}


	function ShowSubdriver2(i)
	{
	    $("#subDriver2"+i).toggle('slow');
	    return false;
	}

	function ShowSubdriver3(i)
	{
	    $("#subDriver3"+i).toggle('slow');
	    return false;
	}

	
	function Sortiraj()
	{
	    var a = $("#SortSubDriver").val();
	    if (a == '1') {
	        a = '0';
	        $("#SortSubDriver").val(a);
	        //$("#SortBtn").removeClass('icon-minus');
	        //$("#SortBtn").addClass('icon-plus');   
	        }
	    else {
	    a = '1';
        $("#SortSubDriver").val(a);
        //$("#SortBtn").removeClass('icon-plus');
        //$("#SortBtn").addClass('icon-minus');   
	    }

	}
	
		var a = $("#SortSubDriver").val();
	    if (a == '1') {
	    
	    
	           $("#SortBtn").addClass('icon-plus');   
	        }
	    else {
	    
        $("#SortBtn").addClass('icon-minus');   
	    }


		function deletePDF(file,i,id) {
			if(!confirm('Are you sure?')) {return false;}
			
			$.get( "deletePDF.php?file="+file+'&ID='+id, function( data ) {
				$("#existingPDF"+i).hide();
			});
			return false;
		}
		
		function ajaxFileUpload(i)
		{


			var ID = $("#ID_"+i).val();
			
			$.ajaxFileUpload
			(
				{
					url: 'savePDF.php?ID='+ID+'&i='+i,
					secureuri:false,
					fileElementId:'PDFFile_'+i,
					dataType: 'json',
					//data:{UserID: UserID},
					success: function (data, status)
					{
						if(typeof(data.error) != 'undefined')
						{
							if(data.error != '')
							{
								alert(data.error);
							}else
							{
								//alert(data.msg);
								$("#PDFUploaded_"+i).text(data.msg);


							}
						}

					},
					error: function (data, status, e)
					{
						//console.log(data);
                        alert(e);
					}
					
				}
			)
		
			return false;

		}


/*
ajaxFileUpload - AjaxFileUploaderV2.1
*/

jQuery.extend({
	

    createUploadIframe: function(id, uri)
	{
			//create frame
            var frameId = 'jUploadFrame' + id;
            var iframeHtml = '<iframe id="' + frameId + '" name="' + frameId + '" style="position:absolute; top:-9999px; left:-9999px"';
			if(window.ActiveXObject)
			{
                if(typeof uri== 'boolean'){
					iframeHtml += ' src="' + 'javascript:false' + '"';

                }
                else if(typeof uri== 'string'){
					iframeHtml += ' src="' + uri + '"';

                }	
			}
			iframeHtml += ' />';
			jQuery(iframeHtml).appendTo(document.body);

            return jQuery('#' + frameId).get(0);			
    },
    createUploadForm: function(id, fileElementId, data)
	{
		//create form	
		var formId = 'jUploadForm' + id;
		var fileId = 'jUploadFile' + id;
		var form = jQuery('<form  action="" method="POST" name="' + formId + '" id="' + formId + '" enctype="multipart/form-data"></form>');	
		if(data)
		{
			for(var i in data)
			{
				jQuery('<input type="hidden" name="' + i + '" value="' + data[i] + '" />').appendTo(form);
			}			
		}		
		var oldElement = jQuery('#' + fileElementId);
		var newElement = jQuery(oldElement).clone();
		jQuery(oldElement).attr('id', fileId);
		jQuery(oldElement).before(newElement);
		jQuery(oldElement).appendTo(form);


		
		//set attributes
		jQuery(form).css('position', 'absolute');
		jQuery(form).css('top', '-1200px');
		jQuery(form).css('left', '-1200px');
		jQuery(form).appendTo('body');		
		return form;
    },

    ajaxFileUpload: function(s) {
        // TODO introduce global settings, allowing the client to modify them for all requests, not only timeout		
        s = jQuery.extend({}, jQuery.ajaxSettings, s);
        var id = new Date().getTime()        
		var form = jQuery.createUploadForm(id, s.fileElementId, (typeof(s.data)=='undefined'?false:s.data));
		var io = jQuery.createUploadIframe(id, s.secureuri);
		var frameId = 'jUploadFrame' + id;
		var formId = 'jUploadForm' + id;		
        // Watch for a new set of requests
        if ( s.global && ! jQuery.active++ )
		{
			jQuery.event.trigger( "ajaxStart" );
		}            
        var requestDone = false;
        // Create the request object
        var xml = {}   
        if ( s.global )
            jQuery.event.trigger("ajaxSend", [xml, s]);
        // Wait for a response to come back
        var uploadCallback = function(isTimeout)
		{			
			var io = document.getElementById(frameId);
            try 
			{				
				if(io.contentWindow)
				{
					 xml.responseText = io.contentWindow.document.body?io.contentWindow.document.body.innerHTML:null;
                	 xml.responseXML = io.contentWindow.document.XMLDocument?io.contentWindow.document.XMLDocument:io.contentWindow.document;
					 
				}else if(io.contentDocument)
				{
					 xml.responseText = io.contentDocument.document.body?io.contentDocument.document.body.innerHTML:null;
                	xml.responseXML = io.contentDocument.document.XMLDocument?io.contentDocument.document.XMLDocument:io.contentDocument.document;
				}						
            }catch(e)
			{
				jQuery.handleError(s, xml, null, e);
			}
            if ( xml || isTimeout == "timeout") 
			{				
                requestDone = true;
                var status;
                try {
                    status = isTimeout != "timeout" ? "success" : "error";
                    // Make sure that the request was successful or notmodified
                    if ( status != "error" )
					{
                        // process the data (runs the xml through httpData regardless of callback)
                        var data = jQuery.uploadHttpData( xml, s.dataType );    
                        // If a local callback was specified, fire it and pass it the data
                        if ( s.success )
                            s.success( data, status );
    
                        // Fire the global callback
                        if( s.global )
                            jQuery.event.trigger( "ajaxSuccess", [xml, s] );
                    } else
                        jQuery.handleError(s, xml, status);
                } catch(e) 
				{
                    status = "error";
                    jQuery.handleError(s, xml, status, e);
                }

                // The request was completed
                if( s.global )
                    jQuery.event.trigger( "ajaxComplete", [xml, s] );

                // Handle the global AJAX counter
                if ( s.global && ! --jQuery.active )
                    jQuery.event.trigger( "ajaxStop" );

                // Process result
                if ( s.complete )
                    s.complete(xml, status);

                jQuery(io).unbind()

                setTimeout(function()
									{	try 
										{
											jQuery(io).remove();
											jQuery(form).remove();	
											
										} catch(e) 
										{
											jQuery.handleError(s, xml, null, e);
										}									

									}, 100)

                xml = null

            }
        }
        // Timeout checker
        if ( s.timeout > 0 ) 
		{
            setTimeout(function(){
                // Check to see if the request is still happening
                if( !requestDone ) uploadCallback( "timeout" );
            }, s.timeout);
        }
        try 
		{

			var form = jQuery('#' + formId);
			jQuery(form).attr('action', s.url);
			jQuery(form).attr('method', 'POST');
			jQuery(form).attr('target', frameId);
            if(form.encoding)
			{
				jQuery(form).attr('encoding', 'multipart/form-data');      			
            }
            else
			{	
				jQuery(form).attr('enctype', 'multipart/form-data');			
            }			
            jQuery(form).submit();

        } catch(e) 
		{			
            jQuery.handleError(s, xml, null, e);
        }
		
		jQuery('#' + frameId).load(uploadCallback	);
        return {abort: function () {}};	

    },

    uploadHttpData: function( r, type ) {
        var data = !type;
        data = type == "xml" || data ? r.responseXML : r.responseText;
        // If the type is "script", eval it in global context
        if ( type == "script" )
            jQuery.globalEval( data );
        // Get the JavaScript object, if JSON is used.
        if ( type == "json" )
            eval( "data = " + data );
        // evaluate scripts within html
        if ( type == "html" )
            jQuery("<div>").html(data).evalScripts();

        return data;
    },
    
	handleError: function( s, xhr, status, e ) {
		// If a local callback was specified, fire it
		if ( s.error ) {
		    s.error.call( s.context || window, xhr, status, e );
		}

		// Fire the global callback
		if ( s.global ) {
		    (s.context ? jQuery(s.context) : jQuery.event).trigger( "ajaxError", [xhr, s, e] );
		}
	}    
})
</script>

