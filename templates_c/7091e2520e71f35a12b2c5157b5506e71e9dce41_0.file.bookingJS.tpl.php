<?php
/* Smarty version 3.1.32, created on 2022-06-28 12:28:28
  from 'C:\xampp\htdocs\jamtransfer\plugins\Buking\templates\bookingJS.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_62bad7cc3eb8d1_61822520',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7091e2520e71f35a12b2c5157b5506e71e9dce41' => 
    array (
      0 => 'C:\\xampp\\htdocs\\jamtransfer\\plugins\\Buking\\templates\\bookingJS.tpl',
      1 => 1656411992,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_62bad7cc3eb8d1_61822520 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
>
    var loadingBar = '<br><br><div class="cssload-loader"><div></div><div></div><div></div><div></div><div></div></div>';
    var WEBSITE = "/api2/";

    $('#FromName').on('click keyup', function(event) {

        $("#ToName").val('');
        $(".toName").hide();
        $("#ToName").attr('disabled','disabled');
        $("#toLoading").text('<?php echo $_smarty_tpl->tpl_vars['CLICK_TO_SELECT']->value;?>
');


        // da ne prolaze krivi podaci
        $("#FromID").val(0);
 
        // pre-fill Return Transfer data
        $("#XToID").val(0);

        var html = '';
        query = $("#FromName").val();


        if (query.length < 3) {
            $("#selectFrom_options").html('');
            return;
        }

        $("#fromLoading").html(loadingBar);


        $("#selectFrom_options").hide();

        // kill previous request if still active
        if(typeof ajax_request !== 'undefined') ajax_request.abort();
        ajax_request = $.ajax({
            url:  './api/getFromPlacesEdgeN.php',
            type: 'GET',
            dataType: 'jsonp',
            data: {
                qry : query
            },
            error: function() {
                //callback();
            },
            success: function(res) {

                //console.log(res);
                if(res.length > 0) {
                    $.each( res, function( index, item ){
                        html +='<a class="list-group-item fromName black-text" id="'+ item.ID +
                            '" data-name="'+item.Place+'">'+
                            //'<a   >' +
                            item.Place +
                            //'</a>'+
                            '</a>';
                    });

                    // data received
                    $("#fromLoading").text('<?php echo $_smarty_tpl->tpl_vars['SELECT_SEARCH']->value;?>
');
                    $("#selectFrom_options").show("slow");
                    $("#selectFrom_options").html(html);

                    // option selected
                    $(".fromName").click(function(){
                        $("#FromName").val(this.text);
                        $("#FromID").val(this.id);
                        // pre-fill Return Transfer data
                        $("#XToName").val(this.text);
                        $("#XToID").val(this.id);
                        $("#selectFrom_options").hide("slow");
                        $("#fromLoading").text('<?php echo $_smarty_tpl->tpl_vars['TYPE_SEARCH']->value;?>
');
                        // clear To
                        $("#ToName").val('');
                        $("#ToID").val('');
                        $("#FromName").removeClass("fldError");
                        $("#fromLoading").html('<i class="pe-7s-check pe-2x"></i>');
                        $("#ToName").removeAttr('disabled');
                        $("#ToName").click().focus();
                    });

                } else {
                    $("#fromLoading").html('');
                    html = '<a class="list-group-item toName black-text" id="" >' +
                        '<?php echo $_smarty_tpl->tpl_vars['NOTHING_FOUND']->value;?>
' +
                        '</a>';
                    html += '<a href="/contact" class="list-group-item toName blue-text" id="" >' +
                        '<?php echo $_smarty_tpl->tpl_vars['CONTACT_US']->value;?>
' +
                        '</a>';
                    $("#selectFrom_options").show("slow");
                    $("#selectFrom_options").html(html);
                }


            }
        });
    });

    $('#ToName').on('click keyup', function(event) {

        $("#step2").hide();
        $("#step3").hide();
        $("#step4").hide();
        $("#step5").hide();
        $("#ToID").val(0);
        $("#XFromID").val(0);
        var html = '';
        query = $("#ToName").val();

        if (query.length < 3 && query.length != 0) {
            $("#selectTo_options").html('');
            return;
        }

        $("#toLoading").html(loadingBar);

        // kill previous request if still active
        if(typeof ajax_request !== 'undefined') ajax_request.abort();

        ajax_request = $.ajax({
            url: './api/getToPlacesEdge.php',
            type: 'GET',
            dataType: 'jsonp',
            data: {
                fID: $("#FromID").val(),
                qry : query
            },
            error: function() {
                //callback();
            },
            success: function(res) {
                ////console.log(res);
                if(res.length > 0) {

                    $.each( res, function( index, item ){
                        html +='<a class="list-group-item toName black-text" id="'+ item.ID +
                            '" data-name="'+item.Place+'">'+
                            //'<a   >' +
                            item.Place +
                            //'</a>'+
                            '</a>';
                    });
                    $("#toLoading").text('<?php echo $_smarty_tpl->tpl_vars['CLICK_TO_SELECT']->value;?>
');
                    $("#selectTo_options").show("slow");
                    $("#selectTo_options").html(html);

                    $(".toName").click(function() {
                        $("#ToName").val(this.text);
                        $("#ToID").val(this.id);
                        $("#ToName").removeClass("fldError");
                        // pre-fill Return Transfer data
                        $("#XFromName").val(this.text);
                        $("#XFromID").val(this.id);
                        $("#selectTo_options").hide("slow");
                        $("#toLoading").html('<i class="pe-7s-check pe-2x"></i>');
                    });

                } else {
                    $("#toLoading").html('');
                    html = '<a class="list-group-item toName black-text" id="" >' +
                        '<?php echo $_smarty_tpl->tpl_vars['NOTHING_FOUND']->value;?>
' +
                        '</a>';
                    html += '<a href="/contact" class="list-group-item toName blue-text" id="" >' +
                        '<?php echo $_smarty_tpl->tpl_vars['CONTACT_US']->value;?>
' +
                        '</a>';
                    $("#selectTo_options").show("slow");
                    $("#selectTo_options").html(html);
                }


            }
        });
    });
    $("#selectCarAdminBtn").click(function(){
        var formValid = validateBookingForm(true);
        if(formValid) {
            return selectCarAdm(true,2);
            // dodatni opis za vozilo
            var vehicle = $('#VehicleName2').val();
            $('#vehiclename').html(vehicle);
        }
        return false;
    });


    function carSelectedAdm(linkId) {

        var agentname 		= $("#AgentID").find('option:selected').text();
        var vehicleid 		= $("#v"+linkId).attr("data-vehicleid");
        var vehiclecapacity = $("#v"+linkId).attr("data-vehiclecapacity");
        var vehicleimage 	= $("#v"+linkId).attr("data-vehicleimage");
        var vehiclename 	= $("#v"+linkId).attr("data-vehiclename");
        var agentPrice 		= $("#agentprice"+linkId).val();
        var driversPrice 	= $("#driversprice"+linkId).val();
        var price 			= $("#price"+linkId).val();
        var vehiclesNo 		= $("#VehiclesNo"+linkId).val();
        var drivername 		= $("#v"+linkId).attr("data-drivername");
        var driverid 		= $("#v"+linkId).attr("data-driverid");
        var routeid 		= $("#v"+linkId).attr("data-routeid");
        var serviceid 		= $("#v"+linkId).attr("data-serviceid");


        $("#AgentName").val(agentname);
        $("#VehicleID").val(vehicleid);
        $("#VehiclesNo").val(vehiclesNo);
        $("#VehicleCapacity").val(vehiclecapacity);
        $("#VehicleImage").val(vehicleimage);
        $("#VehicleName").val(vehiclename);
        $("#Price").val(price);
        $("#AgentPrice").val(agentPrice);
        $("#DriversPrice").val(driversPrice);
        $("#DriverName").val(drivername);
        $("#DriverID").val(driverid);
        $("#RouteID").val(routeid);
        $("#ServiceID").val(serviceid);


        $("#bookingForm").submit();
        return false;
    }

    function vehicleNumberAdm (baseDriverPrice,baseAgentPrice,basePrice,id) {
        var howMany = $("#VehiclesNo"+id).val();
        var newPrice = basePrice * howMany;
        var newAgentPrice = baseAgentPrice * howMany;
        var newDriversPrice = baseDriverPrice * howMany;
        $("#price"+id).val(parseFloat(newPrice).toFixed(2));
        $("#agentprice"+id).val(parseFloat(newAgentPrice).toFixed(2));
        $("#driversprice"+id).val(parseFloat(newDriversPrice).toFixed(2));
    }

    function selectCarAdm(showAlert,ver) {
        var bookingFormData = $("#bookingForm").serialize();
        var proceed = validateBookingForm(showAlert);




        if(!proceed) {
            //return false;
            //selectCarNoDate();
            $.ajax({
                type: "GET",
                url: './api/selectCarNoDate.php',
                data: bookingFormData
            }).done(function( msg ) {
                $("#selectCar").html( msg );
                $('#selectCar').slideDown('slow');
                //$('html, body').animate({ scrollTop: $('#selectCar').offset().top }, 800);

                $(".tab").hide();
                $("#tab_1").removeClass('hidden').show();
                $("#tabBtn1").removeClass('hidden').show();
                //$("#selectExtras").slideUp('slow');
                //$("#paymentData").slideUp('slow');
            });
        } else {

            //if ($('#bookingForm').valid() == false) {
            //    return false;
            //}
            if (ver==2) var url = "./api/selectCarAdm.php";
            else var url = "./api/selectCar.php";

            $.ajax({
                type: "GET",
                url: url,
                data: bookingFormData
            }).done(function( msg ) {
                $("#selectCar").html( msg );
                $('#selectCar').slideDown('slow');
                // dodatni opis za vozilo
                var vehicle = $('#VehicleName2').val();
                $('#vehiclename').html(vehicle);

                $(".tab").hide();
                $("#tab_1").removeClass('hidden').show();
                $("#tabBtn1").removeClass('hidden').show();

                $('html, body').animate({ scrollTop: $('#selectCar').offset().top }, 800);
                //$("#selectExtras").slideUp('slow');
                //$("#paymentData").slideUp('slow');
            });

        }
        return false;
    }
<?php echo '</script'; ?>
>

<?php }
}
