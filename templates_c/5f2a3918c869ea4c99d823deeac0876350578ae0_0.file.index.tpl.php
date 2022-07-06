<?php
/* Smarty version 3.1.32, created on 2022-07-05 10:16:13
  from 'C:\xampp\htdocs\jamtransfer\plugins\Buking\templates\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_62c3f34dda3961_04575661',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5f2a3918c869ea4c99d823deeac0876350578ae0' => 
    array (
      0 => 'C:\\xampp\\htdocs\\jamtransfer\\plugins\\Buking\\templates\\index.tpl',
      1 => 1657008048,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:plugins\\Buking\\templates\\scriptsAdm.tpl' => 1,
    'file:plugins\\Buking\\templates\\bookingAdmJS.tpl' => 1,
    'file:plugins\\Buking\\templates\\bookingJS.tpl' => 1,
  ),
),false)) {
function content_62c3f34dda3961_04575661 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:plugins\Buking\templates\scriptsAdm.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div style="background: transparent url('./i/header/112.jpg') center fixed; background-size: cover;
    margin-top:-20px !important">
    <br>
    <div class="container pad1em"
    style="background-color: rgba(70,79,96,0.75); border:1px solid #000;border-radius:6px;">
        <div class="row">
            <div class="col s12 xucase center white-text">
                <h3>ADMINISTRATION <?php echo $_smarty_tpl->tpl_vars['BOOKING']->value;?>

                </h3>
                <p class="divider clearfix"></p>
            </div>
            <div class="col s12 xgrey xlighten-3">
                <br>
                <form id="bookingForm" name="bookingForm" action="buking/final" method="POST"
                      enctype="multipart/form-data">
                    <input type="text" id="pleaseSelect" value="<?php echo $_smarty_tpl->tpl_vars['PLEASE_SELECT']->value;?>
"/>
                    <input type="text" id="loading" value="<?php echo $_smarty_tpl->tpl_vars['LOADING']->value;?>
"/>

                    <div class="col l6 s12">
                        <label for="AuthUserIDe"><i class="fa fa-globe"></i> Book as <strong>Agent</strong></label><br>
                        <div>
                            <select name="AgentID" id="AgentID" class="xchosen-select browser-default"
                                    value='<?php echo $_smarty_tpl->tpl_vars['AgentID']->value;?>
'>
                                <option value="0"> ---</option>
                                <?php
$__section_index_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['agents']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_index_0_total = $__section_index_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_index'] = new Smarty_Variable(array());
if ($__section_index_0_total !== 0) {
for ($__section_index_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] = 0; $__section_index_0_iteration <= $__section_index_0_total; $__section_index_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']++){
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['agents']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['AuthUserID'];?>
"><?php echo $_smarty_tpl->tpl_vars['agents']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['AuthUserCompany'];?>
</option>
                                <?php
}
}
?>
                            </select>
                        </div>
                    </div>
                    <div class="col s12 l2">
                        <label for="ReferenceNo"><i class="fa fa-book"></i> Agent Reference Number</label><br>
                        <input type="text" id="ReferenceNo" class="browser-default" name="ReferenceNo" value="">
                    </div>
                    <div class="col s12 l2" id='webyblock' style="display:none">
                        <label for="wrn"><i class="fa fa-book"></i> Weby Reference Number</label>
                        <input type="text" id="weby_key" name="weby_key" value="<?php echo $_smarty_tpl->tpl_vars['weby_key']->value;?>
" disabled><br>
                        <select id="wref" class="browser-default" name="wref" value=''>
                        </select>
                    </div>

                    <div class="col s12 l2" id='sunblock' style="display:none">
                        <label for="srn"><i class="fa fa-book"></i> Sun Reference Number</label><br>
                        <input type="file" id="srn" class="browser-default" name="SunReferenceNo" value="">
                    </div>
                    <div class="col s12 l6">
                        <br>
                        <label for="fromSelectorValue"><i class="fa fa-map-marker"></i>
                            <?php echo $_smarty_tpl->tpl_vars['FROM']->value;?>

                        </label><br>
                        <input type="text" id="FromID" name="FromID" value="<?php echo $_smarty_tpl->tpl_vars['fromID']->value;?>
"><i
                                class="pe-7s-car pe-lg  pe-va white-text"></i>
                        <?php echo $_smarty_tpl->tpl_vars['STARTING_FROM']->value;?>

                        <input type="text" id="FromName" name="FromName" value="<?php echo $_smarty_tpl->tpl_vars['fromName']->value;?>
" class="input-lg"
                               style="width:100%" placeholder="<?php echo $_smarty_tpl->tpl_vars['SEARCH_PLACEHOLDER']->value;?>
" autocomplete="off">
                        <span id="fromLoading" class="small">
							<?php echo $_smarty_tpl->tpl_vars['TYPE_SEARCH']->value;?>

						</span>
                        <div id="selectFrom_options" class="list-group white" style="max-height:15em;overflow:auto">
                        </div>
                    </div>
                    <div class="col l6 s12">
                        <br>
                        <label for="toSelectorValue"><i class="fa fa-map-marker"></i>
                            <?php echo $_smarty_tpl->tpl_vars['TO']->value;?>

                        </label> <span style='color:white' id='toname2'></span><br>
                        <input type="text" id="ToID" name="ToID" value="<?php echo $_smarty_tpl->tpl_vars['toID']->value;?>
"><i
                                class="pe-7s-map-marker pe-lg  pe-va white-text"></i>
                        <?php echo $_smarty_tpl->tpl_vars['GOING_TO']->value;?>

                        <input type="text" id="ToName" name="ToName" value="<?php echo $_smarty_tpl->tpl_vars['toName']->value;?>
" class="input-lg"
                               style="width:100%" placeholder="<?php echo $_smarty_tpl->tpl_vars['SEARCH_PLACEHOLDER']->value;?>
" autocomplete="off">
                        <span id="toLoading" class="small">
							<?php echo $_smarty_tpl->tpl_vars['TYPE_SEARCH']->value;?>

						</span>
                        <div id="selectTo_options" class="list-group white" style="max-height:15em;overflow:auto"></div>
                    </div>
                    <div class="col l6 s12">
                        <br>
                        <label for="paxSelector">
                            <i class="fa fa-user"></i>
                            <?php echo $_smarty_tpl->tpl_vars['PASSENGERS_NO']->value;?>

                        </label>
                        <select id="paxSelector" class="browser-default" name="PaxNo" value='<?php echo $_smarty_tpl->tpl_vars['PaxNo']->value;?>
'>
                            <option value="0"> ---</option>

                            <?php
$_smarty_tpl->tpl_vars['pax'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['pax']->step = 1;$_smarty_tpl->tpl_vars['pax']->total = (int) ceil(($_smarty_tpl->tpl_vars['pax']->step > 0 ? 54+1 - (1) : 1-(54)+1)/abs($_smarty_tpl->tpl_vars['pax']->step));
if ($_smarty_tpl->tpl_vars['pax']->total > 0) {
for ($_smarty_tpl->tpl_vars['pax']->value = 1, $_smarty_tpl->tpl_vars['pax']->iteration = 1;$_smarty_tpl->tpl_vars['pax']->iteration <= $_smarty_tpl->tpl_vars['pax']->total;$_smarty_tpl->tpl_vars['pax']->value += $_smarty_tpl->tpl_vars['pax']->step, $_smarty_tpl->tpl_vars['pax']->iteration++) {
$_smarty_tpl->tpl_vars['pax']->first = $_smarty_tpl->tpl_vars['pax']->iteration === 1;$_smarty_tpl->tpl_vars['pax']->last = $_smarty_tpl->tpl_vars['pax']->iteration === $_smarty_tpl->tpl_vars['pax']->total;?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['pax']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['pax']->value;?>
</option>
                            <?php }
}
?>
                        </select>
                    </div>
                    <div class="col s12 l3">
                        <br>
                        <label for="transferDate"><i class="fa fa-calendar-o"></i>
                            <?php echo $_smarty_tpl->tpl_vars['PICKUP_DATE']->value;?>

                        </label><br>
                        <input type="text" id="transferDate" class="browser-default" name="transferDate" readonly
                               value="<?php echo $_smarty_tpl->tpl_vars['transferDate']->value;?>
" data-field="date">
                    </div>
                    <div class="col s12 l3">
                        <br>
                        <label for="transferTime"><i class="fa fa-clock-o"></i>
                            <?php echo $_smarty_tpl->tpl_vars['PICKUP_TIME']->value;?>

                        </label><br>
                        <input type="text" id="transferTime" class="browser-default timepick" name="transferTime"
                               value="<?php echo $_smarty_tpl->tpl_vars['transferTime']->value;?>
" data-field="time">
                    </div>
                    <div class="col l6 s12">
                        <br>
                        <div class="switch">
                            <label for="returnTransferCheck">
                                <i class="fa fa-undo"></i>
                                <?php echo $_smarty_tpl->tpl_vars['RETURN_TRANSFER']->value;?>

                            </label>
                            <br><br>
                            <label class="center">
                                <?php echo $_smarty_tpl->tpl_vars['NO']->value;?>

                                <input type="checkbox" name="returnTransferCheck" id="returnTransferCheck">
                                <span class="lever"></span>
                                <?php echo $_smarty_tpl->tpl_vars['YES']->value;?>

                            </label>
                            <br><br>
                        </div>
                    </div>
                    <div id="showReturn" style="display:none;margin:-0.75rem !important" class="col s12">
                        <div class="col s12 l3">
                            <br>
                            <label for="returnDate"><i class="fa fa-calendar-o"></i>
                                <?php echo $_smarty_tpl->tpl_vars['RETURN_DATE']->value;?>

                            </label><br>
                            <input type="text" id="returnDate" class="browser-default" name="returnDate" readonly
                                   value="<?php echo $_smarty_tpl->tpl_vars['returnDate']->value;?>
" data-field="date">
                        </div>
                        <div class="col s12 l3">
                            <br>
                            <label for="returnTime"><i class="fa fa-clock-o"></i>
                                <?php echo $_smarty_tpl->tpl_vars['PICKUP_TIME']->value;?>

                            </label><br>
                            <input type="text" id="returnTime" name="returnTime" class="browser-default timepick"
                                   data-field="time" value="<?php echo $_smarty_tpl->tpl_vars['returnTime']->value;?>
">
                            <br><br>
                        </div>
                    </div>
                    <br>
                    <div class="col s12 pad1em white-text" style="padding: 1rem !important; background: rgba(0,0,0,.5)">
                        <div class="col s12 l9">
                            <p><i class="fa fa-info-circle fa-2x red-text"></i>
                                <?php echo $_smarty_tpl->tpl_vars['AVAILABILITY_DEPENDS']->value;?>

                            </p>
                        </div>
                        <div class="col s6 l3 pull">
                            <button id="selectCarAdminBtn" type="submit" class="btn blue btn-large"
                                    onclick="return false;">
                                <i class="fa fa-chevron-down"></i>
                                <?php echo $_smarty_tpl->tpl_vars['SELECT_CAR']->value;?>

                            </button>
                            <button id='empty' type="button" class="btn btn-large">Empty fields</button>
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="tab" id="tab_1">
                            <div id="selectCar">
                                <div class="col s12 center-align xwhite-text">
                                    <br>
                                    <h4>
                                        <?php echo $_smarty_tpl->tpl_vars['PRICES_STARTING_FROM']->value;?>

                                    </h4>
                                </div>
                                <div class="col s12 <?php echo $_smarty_tpl->tpl_vars['offset']->value;?>
">
                                    <div class="col s12  <?php echo $_smarty_tpl->tpl_vars['box']->value;?>
  card l">
                                        <br>
                                        <i class="fa fa-user"></i>
                                        <?php echo $_smarty_tpl->tpl_vars['VehicleCapacity']->value;?>
<br>
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['VehicleImage']->value;?>
" class="responsive-img" alt="taxi">

                                        <div class="card-action">
                                            <i class="fa fa-tags red-text"></i>
                                            <?php echo $_smarty_tpl->tpl_vars['price']->value;?>

                                            <?php echo $_smarty_tpl->tpl_vars['Currency']->value;?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 ucase s center xwhite-text">
                                    <?php echo $_smarty_tpl->tpl_vars['SERVICES_DESC1']->value;?>

                                    <?php echo $_smarty_tpl->tpl_vars['SERVICES_DESC2']->value;?>

                                    <?php echo $_smarty_tpl->tpl_vars['SERVICES_DESC3']->value;?>

                                    <?php echo $_smarty_tpl->tpl_vars['SERVICES_DESC4']->value;?>

                                    <?php echo $_smarty_tpl->tpl_vars['SERVICES_DES']->value;?>

                                </div>
                            </div>
                            <div id="final" style='display: none;'>Proba</div>
                        </div>
                    </div>
                    <input type="hidden" id="PaxNo2" name="PaxNo2" value="0">
                    <input type="hidden" id="AgentName" name="AgentName" value="0">
                    <input type="hidden" id="DriverID" name="DriverID" value="0">
                    <input type="hidden" id="DriverName" name="DriverName" value="0">
                    <input type="hidden" id="VehicleID" name="VehicleID" value="0">
                    <input type="hidden" id="VehiclesNo" name="VehiclesNo" value="1">
                    <input type="hidden" id="VehicleName" name="VehicleName" value="">
                    <input type="hidden" id="VehicleCapacity" name="VehicleCapacity" value="0">
                    <input type="hidden" id="VehicleImage" name="VehicleImage" value="">
                    <input type="hidden" id="ServiceID" name="ServiceID" value="0">
                    <input type="hidden" id="RouteID" name="RouteID" value="0">
                    <input type="hidden" id="Price" name="Price" value="0">
                    <input type="hidden" id="AgentPrice" name="AgentPrice" value="0">
                    <input type="hidden" id="DriversPrice" name="DriversPrice" value="0">
                    <input type="hidden" id="returnTransfer" name="returnTransfer" value="0">
                    <input type="hidden" id="ToName2" name="ToName2" value="0">
                    <input type="hidden" id="VehicleName2" name="VehicleName2" value="">
                    <input type="hidden" id="api" name="api" value="">
                    <input type="hidden" id="PaxFirstName" name="PaxFirstName" value="<?php echo $_smarty_tpl->tpl_vars['PaxFirstName']->value;?>
">
                    <input type="hidden" id="PaxSurName" name="PaxSurName" value="<?php echo $_smarty_tpl->tpl_vars['MPaxLastName']->value;?>
">
                    <input type="hidden" id="PaxTel" name="PaxTel" value="<?php echo $_smarty_tpl->tpl_vars['PaxTel']->value;?>
">
                    <input type="hidden" id="FlightNo" name="FlightNo" value="<?php echo $_smarty_tpl->tpl_vars['FlightNo']->value;?>
">
                    <input type="hidden" id="FlightCo" name="FlightCo" value="">
                    <input type="hidden" id="FlightTime" name="FlightTime" value="<?php echo $_smarty_tpl->tpl_vars['FlightTime']->value;?>
">
                    <input type="hidden" id="DFlightNo" name="DFlightNo" value="<?php echo $_smarty_tpl->tpl_vars['DFlightNo']->value;?>
">
                    <input type="hidden" id="DFlightCo" name="DFlightCo" value="">
                    <input type="hidden" id="DFlightTime" name="DFlightTime" value="<?php echo $_smarty_tpl->tpl_vars['DFlightTime']->value;?>
">
                    <input type="hidden" id="RFlightNo" name="RFlightNo" value="<?php echo $_smarty_tpl->tpl_vars['RFlightNo']->value;?>
">
                    <input type="hidden" id="RFlightCo" name="RFlightCo" value="">
                    <input type="hidden" id="RFlightTime" name="RFlightTime" value="<?php echo $_smarty_tpl->tpl_vars['RFlightTime']->value;?>
">
                    <input type="hidden" id="RDFlightNo" name="RDFlightNo" value="<?php echo $_smarty_tpl->tpl_vars['RDFlightNo']->value;?>
">
                    <input type="hidden" id="RDFlightCo" name="RDFlightCo" value="">
                    <input type="hidden" id="RDFlightTime" name="RDFlightTime" value="<?php echo $_smarty_tpl->tpl_vars['RDFlightTime']->value;?>
">
                    <input id='SPAddressHotel' name='SPAddressHotel' type='hidden'/>
                    <input id='SDAddressHotel' name='SDAddressHotel' type='hidden'/>
                    <input id='RPAddressHotel' name='RPAddressHotel' type='hidden'/>
                    <input id='RDAddressHotel' name='RDAddressHotel' type='hidden'/>
                    <input id='PickupAddress' name='PickupAddress' type='hidden' value="<?php echo $_smarty_tpl->tpl_vars['PickupAddress']->value;?>
"/>
                    <input id='DropAddress' name='DropAddress' type='hidden' value="<?php echo $_smarty_tpl->tpl_vars['DropAddress']->value;?>
"/>
                    <input id='RPickupAddress' name='RPickupAddress' type='hidden' value="<?php echo $_smarty_tpl->tpl_vars['RPickupAddress']->value;?>
"/>
                    <input id='RDropAddress' name='RDropAddress' type='hidden' value="<?php echo $_smarty_tpl->tpl_vars['RDropAddress']->value;?>
"/>
                </form>
                <br>&nbsp;
            </div>
            <br><br>
        </div>
    </div>
    <br>&nbsp;
</div>

<?php echo '<script'; ?>
 src="js\ztest.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
>
    function selectJSON() {
        $('#wref').empty();
        var weby_key = $('#weby_key').val();
        var param = 'weby_key=' + weby_key;
        console.log('t/selectJSON.php?' + param);
        $.ajax({
            type: 'GET',
            url: 't/selectJSON.php?' + param,
            success: function (data) {
                if (data !== 'No')
                    $('#wref').html(data);
                else {
                    alert('No reservation or wrong api key');
                    $('#weby_key').prop('disabled', false);
                }
            }
        })
        $('#webyblock').show(500);
    }

    $('#empty').on('click', function () {
        $('input').each(function () {
            $(this).attr('value', '');
        })
        $('#AgentID').val(0);
        $('#paxSelector').val(0);
        $('#PaxFirstName').val(' ');
        $('#PaxTel').val(' ');
    })
    $(document).ready(function () {
        $('#webyblock').hide(500);
        $('#sunblock').hide(500);
        var aid = $('#AgentID').val();
        if (aid == 1711) selectJSON();
        if (aid == 1712) selectJSON();
        if (aid == 2123) $('#sunblock').show(500);
    })
    $('#AgentID').on('change', function () {
        $('#webyblock').hide(500);
        $('#sunblock').hide(500);
        var aid = $('#AgentID').val();
        if (aid == 1711) selectJSON();
        if (aid == 1712) selectJSON();
        if (aid == 2123) $('#sunblock').show(500);
    })
    $('#sun').on('click', function () {
        $('#apies').hide(500);
        $('#sunblock').show(500);
        $('#api').val('SUN');
    })
    $('#weby_key').on('change', function () {
        selectJSON();
    })
    $('#wref').on('change', function () {
        var code = $('#wref :selected').val();
        var weby_key = $('#weby_key').val();
        $('#ReferenceNo').val(code);
        if (code != '') {
            var link = 't/getJSON.php';
            var param = 'code=' + code + '&form=' + 'booking' + '&weby_key=' + weby_key;
            $.ajax({
                type: 'POST',
                url: link,
                data: param,
                async: false,
                success: function (data) {
                    if (data == 'false') alert('Wrong reservation reference');
                    else {
                        var order = JSON.parse(data);
                        var keys = Object.keys(order);
                        keys.forEach(function (entry) {
                            var id_ch = '#' + entry;
                            $(id_ch).val(order[entry]);
                        })
                        $('#paxSelector option').each(function () {
                            if ($(this).val() == $('#PaxNo2').val()) $(this).prop('selected',
                                true);
                        })

                        // cekiranje povratnog transfera
                        var rt = $('#returnDate').val();
                        if (rt != '') $('#returnTransferCheck').trigger('click');
                        //opis za povratni transfer
                        var toname2 = $('#ToName2').val();
                        $('#toname2').html(toname2);

                        // dodatni opis za vozilo
                        var vehicle = $('#VehicleName2').val();
                        $('#vehiclename').html(vehicle);

                        // dodavanje hotela u adrese
                        $('#PickupAddress').val(($('#SPAddressHotel').val()) + ' ' + ($(
                            '#PickupAddress').val()));
                        $('#DropAddress').val(($('#SDAddressHotel').val()) + ' ' + ($('#DropAddress')
                            .val()));
                        $('#RPickupAddress').val(($('#RPAddressHotel').val()) + ' ' + ($(
                            '#RPickupAddress').val()));
                        $('#RDropAddress').val(($('#RDAddressHotel').val()) + ' ' + ($('#RDropAddress')
                            .val()));

                        $('#api').val('WEBY');
                    }
                }
            });
        }
    })


    $('#srn').on('change', function () {
        var data = new FormData();
        data.append('ufile', $('#srn').prop('files')[0]);
        $.ajax({
            type: 'POST',
            url: 'p/modules/getXML.php',
            data: data,
            async: false,
            processData: false, // Using FormData, no need to process data.
            contentType: false,
            success: function (data) {
                var order = JSON.parse(data);
                var keys = Object.keys(order);
                keys.forEach(function (entry) {
                    var id_ch = '#' + entry;
                    $(id_ch).val(order[entry]);
                })
                $('#paxSelector option').each(function () {
                    if ($(this).val() == $('#PaxNo2').val()) $(this).prop('selected', true);
                })
                // cekiranje povratnog transfera
                var rt = $('#returnDate').val();
                if (rt != '') $('#returnTransferCheck').trigger('click');
                var toname2 = $('#ToName2').val();
                $('#toname2').html(toname2);
                // dodatni opis za vozilo
                var vehicle = $('#VehicleName2').val();
                $('#vehiclename').html(vehicle);
                $('#api').val('SUN');
                $('#PickupAddress').val(($('#SPAddressHotel').val()) + ' ' + ($('#PickupAddress')
                    .val()));
                $('#DropAddress').val(($('#SDAddressHotel').val()) + ' ' + ($('#DropAddress').val()));
                $('#RPickupAddress').val(($('#RPAddressHotel').val()) + ' ' + ($('#RPickupAddress')
                    .val()));
                $('#RDropAddress').val(($('#RDAddressHotel').val()) + ' ' + ($('#RDropAddress')
                    .val()));

                $('#FlightNo').val(($('#FlightCo').val()) + ' ' + ($('#FlightNo').val()));
                if ($('#FlightNo').val() == ' ') $('#FlightNo').val(($('#DFlightCo').val()) + ' ' + ($(
                    '#DFlightNo').val()));
                $('#RFlightNo').val(($('#RFlightCo').val()) + ' ' + ($('#RFlightNo').val()));
                if ($('#RFlightNo').val() == ' ') $('#RFlightNo').val(($('#RDFlightCo').val()) + ' ' +
                    ($('#RDFlightNo').val()));
                if ($('#FlightTime').val() == '') $('#FlightTime').val($('#DFlightTime').val());
                if ($('#RFlightTime').val() == '') $('#RFlightTime').val($('#RDFlightTime').val());
            }
        });
    });
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender('file:plugins\Buking\templates\bookingAdmJS.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender('file:plugins\Buking\templates\bookingJS.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>




<?php }
}
