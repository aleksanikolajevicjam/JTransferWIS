<? error_reporting(E_ALL); ?>
<div id="ajaxMsg"></div>
        <h2>Sub-Drivers&nbsp; 
        	
             <input type="hidden" id="searchFld" value=""> 
             <input type="hidden" id="pageLength" value="15">
            <button id="addButton" class="btn pull-right" onclick= 
            "$('#ajaxNewMsg').html('');$('#newFormDiv').slideDown('slow');$('#editFormDiv').slideUp('slow');">
            <i class="icon icon-plus"></i>&nbsp;New
            </button>
        </h2>

        <?##################################################################################################?>
        <?# EDIT FORM                                                                                       ?>
        <?##################################################################################################?>
        <div id="editFormDiv" style="display:none" class="formDisplay well">
        	<h4><?= A_EDIT ?></h4>
            <hr>
            <div>
                <form id="editForm" method="post" enctype="multipart/form-data" name="editForm">
                	<input type="hidden" id="Action" name="Action" value="update"/>
                    <div class="row">
                        <div>
                            <input type="hidden" id="DriverID" name="DriverID" value="">
                        </div>
                   <div class="span2">
                        <b><?= NAME ?></b>
                        <br>
                        <input type="text" id="DriverName" name="DriverName" class="span2">
                    </div>

                    <div class="span2">
                        <b><?= PASSWORD ?></b>
                        <br>
                        <input type="hidden" id="oldPass" name="oldPass" value=""/>
                        <input type="text" id="DriverPassword" name="DriverPassword" class="span2"/>
                    </div>
                    <div class="span2">
                        <b><?= CO_EMAIL ?></b>
                        <br>
                        <input type="text" id="DriverEmail" name="DriverEmail" class="span2 email">
                    </div>
                    <div class="span2">
                        <b><?= TELEPHONE ?></b>
                        <br>
                        <input type="text" id="DriverTel" name="DriverTel" class="span2">
                    </div>

                    <div class="span3">
                        <b><?= NOTES ?></b>
                        <br>
                        <textarea id="Notes" name="Notes" class="span3" rows="5"></textarea>
                    </div>
                    </div>
                    <div class="pull-right">
                        <button onclick="$('#editFormDiv').slideUp('slow');return false;" class="btn btn-primary">
                        <?= CLOSE ?>
                        </button> <button id="updateButton" class="btn btn-primary"><?= UPDATE ?>
                        </button>
                    </div>
                    <div class="pull-left">
                        <button id="deleteButton" class="btn btn-danger"><?= A_DELETE ?>
                        </button>
                    </div>
                </form>
            </div>

            
        </div>
        <?##################################################################################################?>
        <?##################################################################################################?>
        <?# NEW FORM                                                                                       ?>
        <?##################################################################################################?>
        <div id="newFormDiv" style="display:none;" class="formDisplay well">
        	<h4><?= A_NEW ?></h4>

            <!--    <div class="span12">-->
            <form id="newForm" method="post" enctype="multipart/form-data" name="newForm">
            	<input type="hidden" id="Action" name="Action" value="new"/>
                <div class="row">
                    <div class="span2">
                        <b><?= NAME ?></b>
                        <br>
                        <input type="text" id="newDriverName" name="newDriverName" class="span2">
                    </div>

                    <div class="span2">
                        <b><?= PASSWORD ?></b>
                        <br>
                        <input type="text" id="newDriverPassword" name="newDriverPassword" class="span2">
                    </div>
                    <div class="span2">
                        <b><?= CO_EMAIL ?></b>
                        <br>
                        <input type="text" id="newDriverEmail" name="newDriverEmail" class="span2 email">
                    </div>
                    <div class="span2">
                        <b><?= TELEPHONE ?></b>
                        <br>
                        <input type="text" id="newDriverTel" name="newDriverTel" class="span2">
                    </div>

                    <div class="span3">
                        <b><?= NOTES ?></b>
                        <br>
                        <textarea id="newNotes" name="newNotes" class="span3" rows="5"></textarea>
                    </div>
					

                </div>
                <div class="row">
                    <div class="pull-right">
                        <button onclick="$('#newFormDiv').slideUp('slow');return false;" class="btn btn-primary">
                        <?= CLOSE ?>
                        </button> <button id="saveButton" class="btn btn-primary"><?= SAVE ?>
                        </button>
                    </div>
                </div>
            </form><!--    </div>-->

        </div><!--newform-->
        <?##################################################################################################?>

        <div id="infoShow" class="span12"></div>
        <br>
        <table id="t" class="table table-striped">
            <thead style="font-weight:bold">
                <tr>
                    <td style="display:none">
                        <?= ID ?>
                        </td>
                    <td><?= NAME ?>&nbsp;<i class="icon-arrow-down"></i></td>
                    <td>
                        <?= CO_EMAIL ?>
                        </td>
                    <td>
                        <?= TELEPHONE ?>
                        </td>

                    <td width="10%"></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4">
                        <img src="./i/loading.gif"/>
                    </td>
                </tr>
            </tbody>
        </table>
        <div id="pagination" class="pull-right"></div>
        
<script type="text/javascript">
/*
    Obavezna polja za tables.js
    Ovo mora biti ukljuceno.
    Isto tako moraju biti definirana polja
    searchFld i pageLength 
    negdje u formu.
    Mogu biti i hidden.
*/

var iStartRecord = 0;
var iDisplayLength = 10;
var iPage = 0;
var iMaxPages = 0;
var server = "./g/get_myDrivers.php";

// po kojoj koloni su podaci poredani----------Y-----------------Y-
var sortingParams = '&iSortingCols=1&bSortable_1=true&iSortCol_0=1';

// redni broj skrivenog polja ili '' - pocinje od nule, 0=1
var hideField = '0';

</script>

<script type="text/javascript" src="j/tables.js"></script>

<script type="text/javascript">

    function editDriver(id)
    {
        $('#newFormDiv').slideUp('slow');
        $("#editFormDiv").slideDown('slow');
        $("#ajaxMsg").html('');
        
        $("#DriverID").val(id);
        
        var dname = $("#"+id).attr('data-name');
        $("#DriverName").val(dname);
        
        var pass = $("#"+id).attr('data-pass');
        $("#oldPass").val(pass);

        $("#DriverPassword").val('*****');
        
        var email = $("#"+id).attr('data-email');
        $("#DriverEmail").val(email);
        
        var tel = $("#"+id).attr('data-tel');
        $("#DriverTel").val(tel);
        
        var note = $("#"+id).attr('data-notes');
        $("#Notes").val(note);        

    }
   
    $("#deleteButton").click(function(){
        
        if (confirm('Are You Sure?'))
        {
        
            var id = $("#DriverID").val();
           
            $.ajax({
                  type: "POST",
                  url: "./a/ajax_myDrivers.php",
                  data: {DriverID: id, Action: 'delete'}
                }).done(function( msg ) {
                            $("#ajaxMsg").html( msg );
                            showTheTable(iPage);
                            $('#editFormDiv').slideUp('slow');
                });
        }
        return false;
    });  

$(document).ready(function(){
	$("form").validate();
	
    var options = {
                    target:     '#ajaxMsg',
                    url:        './a/ajax_myDrivers.php',
                    success:    showResponse
    
    };


    $('#newForm').ajaxForm(options); 


    var options2 = {
                    target:     '#ajaxMsg',
                    url:        './a/ajax_myDrivers.php',
                    success:    showResponse
    
    };

    $('#editForm').ajaxForm(options2); 

    // post-submit callback 
    function showResponse(responseText, statusText, xhr, $form)  { 
        showTheTable(iPage);
        $(".formDisplay").slideUp();
    }

});    


</script>
