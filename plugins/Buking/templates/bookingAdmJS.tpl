
<script>
    var apiPath="/cms/api2/";
    var bookingFormFromName = '';
    var bookingFormToName = '';
    var loadingBar = '<br><br><div class="cssload-loader"><div></div><div></div><div></div><div></div><div></div></div>';

    String.prototype.ucwords = function () {
        return this.replace(/\w+/g, function(a){
            return a.charAt(0).toUpperCase() + a.slice(1).toLowerCase()
        })
    }

 
    $('#FromName').on('click keyup', function(event) {

        $("#ToName").val('');
        $(".toName").hide();
        $("#ToName").attr('disabled','disabled');
        $("#toLoading").text('{$CLICK_TO_SELECT}');


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
                    $("#fromLoading").text('{$SELECT_SEARCH}');
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
                        $("#fromLoading").text('{$TYPE_SEARCH}');
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
                        '{$NOTHING_FOUND}' +
                        '</a>';
                    html += '<a href="/contact" class="list-group-item toName blue-text" id="" >' +
                        '{$CONTACT_US}' +
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
                    $("#toLoading").text('{$CLICK_TO_SELECT}');
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
                        '{$NOTHING_FOUND}' +
                        '</a>';
                    html += '<a href="/contact" class="list-group-item toName blue-text" id="" >' +
                        '{$CONTACT_US}' +
                        '</a>';
                    $("#selectTo_options").show("slow");
                    $("#selectTo_options").html(html);
                }


            }
        });
    });

    function selectCountry(selected) {

        var pleaseSelect 	= $("#pleaseSelect").val();
        var loading      	= $("#loading").val();
        var selectActive 	= '';
        ReplaceSelectorText("#countrySelector", loading);



        LoadCountries(
            function ( data ) {

                ReplaceSelectorText("#countrySelector", pleaseSelect);
                ReplaceSelectorText("#fromSelector", ' ---');
                ReplaceSelectorText("#toSelector", ' ---');


                for(var i=0; i < data.length; i++) {
                    if (selected==data[i].id) {
                        selectActive = 'selected="selected"';
                        $("#countrySelector").val(data[i].id);
                    }
                    else {
                        selectActive = '';
                    }

                    //var cName = data[i].text;
                    //var cNameShow = cName.split('|');

                   // $("#countrySelector").append('<option value="'+
                     //   data[i].id+'" ' +selectActive+'>'+cNameShow[0].ucwords()+'</option>');
                }

                $("#countrySelector").select2({
                    data: data,
                    minimumResultsForSearch: 5
                });

                if (selected > 0) {
                    ReplaceSelectorText("#fromSelector", ' ---');
                    ReplaceSelectorText("#toSelector", ' ---');
                    selectFrom($("#fromSelectorValue").val());
                }
            }
        );
    }

    function LoadCountries(callback) {
        ReplaceSelectorText("#countrySelector", $("#loading").val());
        request = $.getJSON( "./api/getCountries.php?callback=?",
            function(data) {

                callback(data);
            });
    }


    function selectFrom(selected) {

        var pleaseSelect 	= $("#pleaseSelect").val();
        var loading      	= $("#loading").val();
        var countryID 		= $("#countrySelector").val();
        var selectActive	= '';

        ReplaceSelectorText("#toSelector", ' ---');

        LoadFrom(
            // ovo je ono sto callback poziva
            function ( data ) {

                ReplaceSelectorText("#fromSelector", pleaseSelect);
                ReplaceSelectorText("#toSelector", ' --- ');

                for(var i=0; i < data.length; i++) {
                    if (selected==data[i].id) {
                        selectActive = 'selected="selected"';



                        $("#fromSelectorSpan").text(data[i].text);
                        $("#fromSelector").val(data[i].id);


                    }
                    else {
                        selectActive = '';
                    }

                    var fName = data[i].text;
                    var fNameShow = fName.split('|');

                    $("#fromSelector").append('<option value="'+
                        data[i].id+'" ' +selectActive+'>'+fNameShow[0].ucwords() +'</option>');
                }

                $("#fromSelector").select2({
                    data: data,
                    minimumResultsForSearch: 5
                });

                if (selected > 0) {
                    $("#toSelector").text(' --- ');
                    selectTo($("#toSelectorValue").val());
                }
            },
            countryID // obavezan parametar za ajax poziv
        );
    }
    function LoadFrom(callback, cID) {
        ReplaceSelectorText("#fromSelector",$("#loading").val());
        request = $.getJSON( "./api/getFromPlaces.php?cID="+cID+"&callback=?",
            function(data) {
                callback(data);
            });

    }


    function selectTo(selected) {

        var pleaseSelect 	= $("#pleaseSelect").val();
        var loading      	= $("#loading").val();
        var fromID 			= $("#fromSelector").val();
        var selectActive	= '';

        LoadTo(
            function ( data ) {
                ReplaceSelectorText("#toSelector", pleaseSelect);

                for(var i=0; i < data.length; i++) {

                    if (selected==data[i].id) {
                        selectActive = 'selected="selected"';

                        bookingFormToName = data[i].text;

                        $("#toSelectorSpan").text(data[i].text);
                        $("#toSelector").val(data[i].id);
//$("#toSelector").trigger("change");

                    }
                    else {
                        selectActive = '';
                    }

                    var tName = data[i].text;
                    var tNameShow = tName.split('|');

                    $("#toSelector").append('<option value="'+
                        data[i].id+'" ' +selectActive+'>'+tNameShow[0].ucwords()+'</option>');
                }

                $("#toSelector").select2({
                    data: data,
                    minimumResultsForSearch: 5
                });

                //***********************************************************
                //
                // POKRENI ODABIR VOZILA
                //
                //***********************************************************
                //selectCar(false); // ne prikazuj alert kad se tek ucita stranica
                var formValid = validateBookingForm(false);
                if(formValid) { selectCar(); }

            },
            fromID // obavezan parametar za ajax poziv
        );

    }


    function LoadTo(callback, fID) {

        var pleaseSelect = $("#pleaseSelect").val();
        var loading      = $("#loading").val();
        ReplaceSelectorText("#toSelector",$("#loading").val());
        request = $.getJSON( "./api/getToPlaces.php?fID="+fID+"&callback=?",

            function(data) {
                callback(data);
            });
    }


    function toSelected() {
        bookingFormFromName = $("#fromSelector option:selected").text();
        //console.log(bookingFormFromName);
        bookingFormToName = $("#toSelector option:selected").text();
        //console.log(bookingFormToName);
        window.history.pushState("object or string", "Title", "/taxi-transfers-from-"+url_slug(bookingFormFromName)+'-to-'+url_slug(bookingFormToName));

    }

    function slugify(text)
    {
        return text.toString().toLowerCase()
            .replace(/\s+/g, '_')           // Replace spaces with -
            .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
            .replace(/\-\-+/g, '_')         // Replace multiple - with single -
            .replace(/^-+/, '')             // Trim - from start of text
            .replace(/-+$/, '');            // Trim - from end of text
    }


    // fire up Country -> From -> To selections
    selectCountry('{$_SESSION['CountryID']}');


    // sakrij vozila ako se bilo sto promijeni ******
    $("#countrySelector").change(function(){
        $("#selectCar").hide('slow');
        return false;
    });
    $("#fromSelector").change(function(){
        $("#selectCar").hide('slow');
        return false;
    });
    $("#toSelector").change(function(){
        $("#selectCar").hide('slow');
        return false;
    });
    $("#paxSelector").change(function(){
        $("#selectCar").hide('slow');
        return false;
    });
    $("#returnTransferCheck").change(function(){
        $("#selectCar").hide('slow');
        return false;
    });

    $('input, select').change(function(){
        $(this).removeClass('notValid');
        $(this).next().removeClass('notValid');
        $(this).next().children().removeClass('notValid');
        return false;
    });

    //***********************************************



    // SELECT CAR BUTTON CLICKED
    $("#selectCarBtn").click(function(){
        var formValid = validateBookingForm(true);
        if(formValid) {  	return selectCar(true); }
        //else {  	selectCarNoDate(); }
        return false;
    });
    $("#selectCarBtnN").click(function(){
        var formValid = validateBookingForm(true);
        if(formValid) {  	return selectCarN(true); }
        //else {  	selectCarNoDate(); }
        return false;
    });
    function selectCarNoDate() {
        var bookingFormData = $("#bookingForm").serialize();
        $.ajax({
            type: "GET",
            url: "./api/selectCarNoDate.php",
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
    }

    function selectCar(showAlert,ver) {

        var bookingFormData = $("#bookingForm").serialize();
        var proceed = validateBookingForm(showAlert);




        if(!proceed) {
            //return false;
            //selectCarNoDate();
            $.ajax({
                type: "GET",
                url: "./api/selectCarNoDate.php",
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


    // CAR PANEL CLICKED
    function carSelected(linkId) {

        /*
        ovo je trik koji omogucava da se unutar a taga stavi button
        ako je kliknut button, onda se a tag nece aktivirati
        inace se aktivira a tag
        */
        //if(document.activeElement.tagName=='BUTTON') { return false;}


        var vehicleid 		= $("#v"+linkId).attr("data-vehicleid");
        var vehiclecapacity = $("#v"+linkId).attr("data-vehiclecapacity");
        var vehicleimage 	= $("#v"+linkId).attr("data-vehicleimage");
        var vehiclename 	= $("#v"+linkId).attr("data-vehiclename");
        var driversPrice 	= $("#v"+linkId).attr("data-driversprice");
        //var price 			= $("#"+linkId).attr("data-price");
        var price 			= $("#price"+linkId).val();
        var vehiclesNo 		= $("#VehiclesNo"+linkId).val();
        var drivername 		= $("#v"+linkId).attr("data-drivername");
        var driverid 		= $("#v"+linkId).attr("data-driverid");
        var routeid 		= $("#v"+linkId).attr("data-routeid");
        var serviceid 		= $("#v"+linkId).attr("data-serviceid");


        $("#VehicleID").val(vehicleid);
        $("#VehiclesNo").val(vehiclesNo);
        $("#VehicleCapacity").val(vehiclecapacity);
        $("#VehicleImage").val(vehicleimage);
        $("#VehicleName").val(vehiclename);
        $("#Price").val(price);
        $("#DriversPrice").val(driversPrice);
        $("#DriverName").val(drivername);
        $("#DriverID").val(driverid);
        $("#RouteID").val(routeid);
        $("#ServiceID").val(serviceid);

        $("#bookingForm").submit();
        return false;
    }

    // VEHICLE NUMBER CHANGED
    function vehicleNumber(basePrice,id) {
        var howMany = $("#VehiclesNo"+id).val();
        var newPrice = basePrice * howMany;
        $("#price"+id).val(parseFloat(newPrice).toFixed(2));
    }

    // DRIVER PROFILE PANEL TOGGLE
    function ShowDriverProfile(id) {
        $("#DriverProfile"+id).toggle('slow');
        //alert(id);
        return false;
    }


    // PRIMITIVE BOOKING FORM VALIDATION
    // ToDo: implement real validation


    /*
        jQuery.validator.setDefaults({
          errorElement: "div"
        });
    // final form validation

        $("#bookingForm").validate({
            errorPlacement: function(error, element) {
        error.appendTo( element.parent("div") );
      },
            rules: {
                transferDate: { required:true, email:true}
            }
        });
    */






    function url_slug(s, opt) {
        s = String(s);
        opt = Object(opt);

        var defaults = {
            'delimiter': '_',
            'limit': undefined,
            'lowercase': true,
            'replacements': {},
            'transliterate': (typeof(XRegExp) === 'undefined') ? true : false
        };

        // Merge options
        for (var k in defaults) {
            if (!opt.hasOwnProperty(k)) {
                opt[k] = defaults[k];
            }
        }

        var char_map = {
            // Latin
            '??': 'A', '??': 'A', '??': 'A', '??': 'A', '??': 'A', '??': 'A', '??': 'AE', '??': 'C',
            '??': 'E', '??': 'E', '??': 'E', '??': 'E', '??': 'I', '??': 'I', '??': 'I', '??': 'I',
            '??': 'D', '??': 'N', '??': 'O', '??': 'O', '??': 'O', '??': 'O', '??': 'O', '??': 'O',
            '??': 'O', '??': 'U', '??': 'U', '??': 'U', '??': 'U', '??': 'U', '??': 'Y', '??': 'TH',
            '??': 'ss',
            '??': 'a', '??': 'a', '??': 'a', '??': 'a', '??': 'a', '??': 'a', '??': 'ae', '??': 'c',
            '??': 'e', '??': 'e', '??': 'e', '??': 'e', '??': 'i', '??': 'i', '??': 'i', '??': 'i',
            '??': 'd', '??': 'n', '??': 'o', '??': 'o', '??': 'o', '??': 'o', '??': 'o', '??': 'o',
            '??': 'o', '??': 'u', '??': 'u', '??': 'u', '??': 'u', '??': 'u', '??': 'y', '??': 'th',
            '??': 'y',

            // Latin symbols
            '??': '(c)',

            // Greek
            '??': 'A', '??': 'B', '??': 'G', '??': 'D', '??': 'E', '??': 'Z', '??': 'H', '??': '8',
            '??': 'I', '??': 'K', '??': 'L', '??': 'M', '??': 'N', '??': '3', '??': 'O', '??': 'P',
            '??': 'R', '??': 'S', '??': 'T', '??': 'Y', '??': 'F', '??': 'X', '??': 'PS', '??': 'W',
            '??': 'A', '??': 'E', '??': 'I', '??': 'O', '??': 'Y', '??': 'H', '??': 'W', '??': 'I',
            '??': 'Y',
            '??': 'a', '??': 'b', '??': 'g', '??': 'd', '??': 'e', '??': 'z', '??': 'h', '??': '8',
            '??': 'i', '??': 'k', '??': 'l', '??': 'm', '??': 'n', '??': '3', '??': 'o', '??': 'p',
            '??': 'r', '??': 's', '??': 't', '??': 'y', '??': 'f', '??': 'x', '??': 'ps', '??': 'w',
            '??': 'a', '??': 'e', '??': 'i', '??': 'o', '??': 'y', '??': 'h', '??': 'w', '??': 's',
            '??': 'i', '??': 'y', '??': 'y', '??': 'i',

            // Turkish
            '??': 'S', '??': 'I', '??': 'C', '??': 'U', '??': 'O', '??': 'G',
            '??': 's', '??': 'i', '??': 'c', '??': 'u', '??': 'o', '??': 'g',

            // Russian
            '??': 'A', '??': 'B', '??': 'V', '??': 'G', '??': 'D', '??': 'E', '??': 'Yo', '??': 'Zh',
            '??': 'Z', '??': 'I', '??': 'J', '??': 'K', '??': 'L', '??': 'M', '??': 'N', '??': 'O',
            '??': 'P', '??': 'R', '??': 'S', '??': 'T', '??': 'U', '??': 'F', '??': 'H', '??': 'C',
            '??': 'Ch', '??': 'Sh', '??': 'Sh', '??': '', '??': 'Y', '??': '', '??': 'E', '??': 'Yu',
            '??': 'Ya',
            '??': 'a', '??': 'b', '??': 'v', '??': 'g', '??': 'd', '??': 'e', '??': 'yo', '??': 'zh',
            '??': 'z', '??': 'i', '??': 'j', '??': 'k', '??': 'l', '??': 'm', '??': 'n', '??': 'o',
            '??': 'p', '??': 'r', '??': 's', '??': 't', '??': 'u', '??': 'f', '??': 'h', '??': 'c',
            '??': 'ch', '??': 'sh', '??': 'sh', '??': '', '??': 'y', '??': '', '??': 'e', '??': 'yu',
            '??': 'ya',

            // Ukrainian
            '??': 'Ye', '??': 'I', '??': 'Yi', '??': 'G',
            '??': 'ye', '??': 'i', '??': 'yi', '??': 'g',

            // Czech
            '??': 'C', '??': 'D', '??': 'E', '??': 'N', '??': 'R', '??': 'S', '??': 'T', '??': 'U',
            '??': 'Z',
            '??': 'c', '??': 'd', '??': 'e', '??': 'n', '??': 'r', '??': 's', '??': 't', '??': 'u',
            '??': 'z',

            // Polish
            '??': 'A', '??': 'C', '??': 'e', '??': 'L', '??': 'N', '??': 'o', '??': 'S', '??': 'Z',
            '??': 'Z',
            '??': 'a', '??': 'c', '??': 'e', '??': 'l', '??': 'n', '??': 'o', '??': 's', '??': 'z',
            '??': 'z',

            // Latvian
            '??': 'A', '??': 'C', '??': 'E', '??': 'G', '??': 'i', '??': 'k', '??': 'L', '??': 'N',
            '??': 'S', '??': 'u', '??': 'Z',
            '??': 'a', '??': 'c', '??': 'e', '??': 'g', '??': 'i', '??': 'k', '??': 'l', '??': 'n',
            '??': 's', '??': 'u', '??': 'z'
        };

        // Make custom replacements
        for (var k in opt.replacements) {
            s = s.replace(RegExp(k, 'g'), opt.replacements[k]);
        }

        // Transliterate characters to ASCII
        if (opt.transliterate) {
            for (var k in char_map) {
                s = s.replace(RegExp(k, 'g'), char_map[k]);
            }
        }

        // Replace non-alphanumeric characters with our delimiter
                {literal}var alnum = (typeof(XRegExp) === 'undefined') ? RegExp('[^a-z0-9]+', 'ig') : XRegExp('[^\\p{L}\\p{N}]+', 'ig');{/literal}
        s = s.replace(alnum, opt.delimiter);

        // Remove duplicate delimiters
        {literal}	s = s.replace(RegExp('[' + opt.delimiter + ']{2,}', 'g'), opt.delimiter); {{/literal}}

        // Truncate slug to max. characters
        s = s.substring(0, opt.limit);

        // Remove delimiter from ends
        s = s.replace(RegExp('(^' + opt.delimiter + '|' + opt.delimiter + '$)', 'g'), '');

        return opt.lowercase ? s.toLowerCase() : s;
    }

    function manageTabs(tabId) {
        //$(".tab").hide();
        //$("#tab_"+tabId).removeClass('hidden').show();
        return false;
    }

</script>

