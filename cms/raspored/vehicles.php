        <div id="ajaxMsg"></div>
     
        <h2><?= VEHICLES ?>&nbsp;
      
             <input type="hidden" id="searchFld" value=""> 
             <input type="hidden" id="pageLength" value="10">
            <button id="addButton" class="btn pull-right" onclick= 
            "$('#ajaxNewMsg').html('');$('#newFormDiv').slideDown('slow');$('#editFormDiv').slideUp('slow');">
            <i class="icon icon-plus"></i>&nbsp;<?= A_NEW ?>
            </button>
        </h2>
        <?##################################################################################################?>
        <?# EDIT FORM                                                                                       ?>
        <?##################################################################################################?>
        <div id="editFormDiv" style="display:none" class="formDisplay well well-small">
            <h4><?= A_EDIT ?></h4>
            <hr>
            <div>
                <form id="editForm" method="post" enctype="multipart/form-data"
                name="editForm">
                    <div class="row">
                        <div>
                            <input type="hidden" id="Action" name="Action" value="update"/>
                            <input type="hidden" id="VehicleID" name="VehicleID" class="span1" value="">
                        </div>
                        <div class="span3">
                            <b><?= VEHICLE_NAME ?>
                            </b>
                            <br>
                            <input type="text" id="VehicleDescription" name="VehicleDescription" class="span3" value="">
                        </div>

                        <div class="span1">
                            <b><?= VEHICLE_CAPACITY ?>
                            </b>
                            <br>
                            <input type="text" id="VehicleCapacity" name="VehicleCapacity" class="span1"
                            value="">
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
                <br/>
            </div>

            
        </div>
        <?##################################################################################################?>
        <?##################################################################################################?>
        <?# NEW FORM                                                                                       ?>
        <?##################################################################################################?>
        <div id="newFormDiv" style="display:none;" class="formDisplay well well-small">
            <h4><?= A_NEW ?></h4>
            <hr>
            <!--    <div class="span12">-->
            <form id="newForm" method="post" enctype="multipart/form-data" name="newForm">
                <div class="row">
                    <div class="span3">
                        <b><?= VEHICLE_NAME ?>
                        </b>
                        <br>
                        <input type="text" id="newVehicleDescription" name="newVehicleDescription" class="span3">
                    </div>

                    <div class="span1">
                        <b><?= VEHICLE_CAPACITY ?>
                        </b>
                        <br>
                        <input type="text" id="newVehicleCapacity" name="newVehicleCapacity" class="span1">
                    </div>

                </div>
                <div class="row">
                    <div class="pull-right">
                        <input type="hidden" id="Action" name="Action" value="new"/>
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

                    <td>
                        <?= VEHICLE_NAME ?>
                    </td>
                    <td>
                        <?= VEHICLE_CAPACITY ?>
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
var server = "./g/get_vehicles.php";

// po kojoj koloni su podaci poredani----------Y-----------------Y-
var sortingParams = '&iSortingCols=1&bSortable_1=true&iSortCol_0=1';

// redni broj skrivenog polja ili '' - pocinje od nule, 0=1
var hideField = '0';

</script>

<script type="text/javascript" src="./j/tables.js"></script>

<script type="text/javascript">

    function editVehicles(id)
    {
        $("#newFormDiv").slideUp('slow');
        $("#editFormDiv").slideDown('slow');
        $("#ajaxMsg").html('');
        
        $("#VehicleID").val(id);
        
        var name = $("#"+id).attr('data-name');
        $("#VehicleDescription").val(name);
        
        var cap = $("#"+id).attr('data-cap');
        $("#VehicleCapacity").val(cap);
        
    }
   
    $("#deleteButton").click(function(){
        
        if (confirm('<?= ARE_YOU_SURE ?>'))
        {
        
            var id = $("#VehicleID").val();
           
            $.ajax({
                  type: "POST",
                  url: "./a/ajax_Vehicles.php",
                  data: {VehicleID: id, Action: 'delete'}
                }).done(function( msg ) {
                            $("#ajaxMsg").html( msg );
                            showTheTable(iPage);
                            $('#editFormDiv').slideUp('slow');
                });
        }
        return false;
    });  

$(document).ready(function(){

    var options = {
                    target:     '#ajaxMsg',
                    url:        './a/ajax_Vehicles.php',
                    success:    showResponse
    
    };


    $('#newForm').ajaxForm(options); 


    var options2 = {
                    target:     '#ajaxMsg',
                    url:        './a/ajax_Vehicles.php',
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
