<link rel="stylesheet" type="text/css" href="css/all.css" media="screen">
<link rel="stylesheet" type="text/css" href="js/jQuery/jquery.ui.datepicker.css">
<link rel="stylesheet" type="text/css" href="js/jQuery/jquery-ui-timepicker.css">
<script src="js/all.js"></script>
<script src="js/jQuery/jquery.ui.core.js"></script>
<script src="js/jQuery/jquery.ui.timepicker.js"></script>

<script>
	var loadingBar = '<br><br><div class="cssload-loader"><div></div><div></div><div></div><div></div><div></div></div>';
	var base_url = 'plugins/booking/';
	$(document).ready(function(){
		// blok za rezervacione sisteme
		$('#webyblock').hide(500);	
		$('#sunblock').hide(500);			
		var aid=$('#AgentID').val();
		if (aid==1711) selectJSON();
		if (aid==1712) selectJSON();
		if (aid==2123) $('#sunblock').show(500);		
		$('#AgentID').on('change', function() {
			$('#webyblock').hide(500);	
			$('#sunblock').hide(500);			
			var aid=$('#AgentID').val();
			if (aid==1711) selectJSON();
			if (aid==1712) selectJSON();
			if (aid==2123) $('#sunblock').show(500);
		})	
		$('#sun').on('click', function() {
			$('#apies').hide(500);
			$('#sunblock').show(500);	
			$('#api').val('SUN');
		})	
		$('#wref').on('change', function() {
			var code = $('#wref :selected').val();
			$('#ReferenceNo').val(code);
			if (code != '') {
				var link  = base_url+'AJAXgetJSON.php';
				var param = 'code='+code+'&form='+'booking';
				console.log(link+'?'+param);
				$.ajax({
					type: 'POST',
					url: link,
					data: param,
					async: false,
						success: function(data) {
							if (data=='false') alert ('Wrong reservation reference');
							else {
								var order = JSON.parse(data);
								var keys = Object.keys(order);
								keys.forEach(function(entry) {
										var id_ch = '#'+entry;
										$(id_ch).val(order[entry]);
									})	
								$('#paxSelector option').each(function() {
									if ($(this).val() == $('#PaxNo2').val()) $(this).prop('selected', true);
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
							$('#PickupAddress').val(($('#SPAddressHotel').val())+' '+($('#PickupAddress').val()));
							$('#DropAddress').val(($('#SDAddressHotel').val())+' '+($('#DropAddress').val()));
							$('#RPickupAddress').val(($('#RPAddressHotel').val())+' '+($('#RPickupAddress').val()));
							$('#RDropAddress').val(($('#RDAddressHotel').val())+' '+($('#RDropAddress').val()));
							
								$('#api').val('WEBY');
							}
						}
				});	
			}		 
		}) 
		$('#srn').on('change', function() {
			var data = new FormData();
			data.append('ufile', $('#srn').prop('files')[0]);
			$.ajax({
				type: 'POST',
				url: base_url+'AJAXgetXML.php',
				data: data,
				async: false,
				processData: false, // Using FormData, no need to process data.
				contentType: false,
					success: function(data) {
						var order = JSON.parse(data);
						var keys = Object.keys(order);
						keys.forEach(function(entry) {
								var id_ch = '#'+entry;
								$(id_ch).val(order[entry]);
							})	
						$('#paxSelector option').each(function() {
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
						$('#PickupAddress').val(($('#SPAddressHotel').val())+' '+($('#PickupAddress').val()));
						$('#DropAddress').val(($('#SDAddressHotel').val())+' '+($('#DropAddress').val()));
						$('#RPickupAddress').val(($('#RPAddressHotel').val())+' '+($('#RPickupAddress').val()));
						$('#RDropAddress').val(($('#RDAddressHotel').val())+' '+($('#RDropAddress').val()));
						
						$('#FlightNo').val(($('#FlightCo').val())+' '+($('#FlightNo').val()));
						if ($('#FlightNo').val()==' ') $('#FlightNo').val(($('#DFlightCo').val())+' '+($('#DFlightNo').val()));					
						$('#RFlightNo').val(($('#RFlightCo').val())+' '+($('#RFlightNo').val()));
						if ($('#RFlightNo').val()==' ') $('#RFlightNo').val(($('#RDFlightCo').val())+' '+($('#RDFlightNo').val()));
						if ($('#FlightTime').val()=='') $('#FlightTime').val($('#DFlightTime').val());					
						if ($('#RFlightTime').val()=='') $('#RFlightTime').val($('#RDFlightTime').val());										
					}
			});
		});
		// praznjenje
		$('#empty').on('click', function() {
			$('input').each(function() {
				$(this).attr('value', '');  
			})
			$('#AgentID').val(0);
			$('#paxSelector').val(0);
			$('#PaxFirstName').val(' ');
			$('#PaxTel').val(' ');	
				
		})			
		// blok lokacija
		$('#FromName').on('click keyup', function(event) {
			$("#ToName").val('');
			$(".toName").hide();
			$("#ToName").attr('disabled','disabled');
			$("#toLoading").text('<?= $CLICK_TO_SELECT ?>');
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

			//$("#fromLoading").text('<?= $SEARCHING?>');
			$("#fromLoading").html(loadingBar);


			$("#selectFrom_options").hide();

			// kill previous request if still active
			if(typeof ajax_request !== 'undefined') ajax_request.abort();
			ajax_request = $.ajax({
				url:  base_url+'AJAXgetFromPlacesEdge.php',
				type: 'GET',
				dataType: 'jsonp',
				data: {
					qry : query
				},
				error: function() {
					//callback();
				},
				success: function(res) {
					
					console.log(res);
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
						$("#fromLoading").text('<?= $SELECT_SEARCH ?>');
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
							$("#fromLoading").text('<?= $TYPE_SEARCH ?>');
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
										'<?= $NOTHING_FOUND ?>' +
								'</a>';
						html += '<a href="/contact" class="list-group-item toName blue-text" id="" >' +
										'<?= $CONTACT_US ?>' +
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

			//$("#toLoading").text('<?= $SEARCHING?>');
			$("#toLoading").html(loadingBar);

			// kill previous request if still active
			if(typeof ajax_request !== 'undefined') ajax_request.abort();

			ajax_request = $.ajax({
				url: base_url+'AJAXgetToPlacesEdge.php',
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
						$("#toLoading").text('<?= $CLICK_TO_SELECT ?>');
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
										'<?= $NOTHING_FOUND ?>' +
								'</a>';
						html += '<a href="/contact" class="list-group-item toName blue-text" id="" >' +
										'<?= $CONTACT_US ?>' +
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
				return selectCarAdm(true); 
				// dodatni opis za vozilo
				var vehicle = $('#VehicleName2').val();
				$('#vehiclename').html(vehicle);		
			}		
			return false;
		});

		$("#selectCarAdminBtn").attr('type','button');
	
		$('.ourprice, .agentprice #VehiclesNo3').on('change', function() {
			var idx=$(this).attr('id');
			idx=idx.replace('agentprice','');
			idx=idx.replace('price',''); 
			idL='#ourdriver'+idx;
			console.log(idL);
			var our=$(idL).val();
			if (our==1) {
				id='#driversprice'+idx;
				var dp=$(id).val();
				var agentid=$('#AgentID').val();
					id1='#price'+idx;
					var p=Number($(id1).val());				
					id2='#agentprice'+idx;
					var ap=Number($(id2).val());
				if (agentid==1711) {	
					var np =  (p-ap)*0.85; 
				}
				else {	
					var np = p*0.85; 
				}	
				$(id).val(np);
			}
		})
		
		var local = $('#local').val();
		var currentDate 	= new Date();
		var currentTime 	= currentDate.getHours();
		if (local!=1) {
			var dateLimit 		= -1; 
			var hourLimit   	= -24; 
			var limitT			= parseInt(currentTime + hourLimit, 10);
			if( limitT > 24 ) {
				dateLimit += 1;
				limitT = limitT - 24;
			}
		}
		else {
			var dateLimit 		= 0; 
			var hourLimit   	= currentTime;			
			var limitT	= currentTime;
		}
		var limitDate = new Date(currentDate.getFullYear(),currentDate.getMonth(),currentDate.getDate()
								  +dateLimit);
	
		$("#transferDate").datepicker({
			dateFormat: 'yy-mm-dd',
			showOtherMonths: true,
			selectOtherMonths: true,
			minDate: dateLimit,
			onSelect: function(dateStr) {
				$("#returnDate").datepicker('option', 'minDate', dateStr);
				$("#transferTime").val('');
			}
		 });

		$("#returnDate").datepicker({
			dateFormat: 'yy-mm-dd',
			showOtherMonths: true,
			selectOtherMonths: true,
			minDate: dateLimit,
		   	onSelect: function(dateStr) {
				$("#returnTime").val('');
			}
		 });

		$('#transferTime').timepicker({
			onHourShow: function( hour ) { 

				if ( $('#transferDate').val() == $.datepicker.formatDate ( 'yy-mm-dd', limitDate ) ) {
					if ( hour <= limitT ) return false;   
				}
			    return true;
			}
		});

		$('#returnTime').timepicker({
			onHourShow: function( hour ) { 
				if ( $('#returnDate').val() == $.datepicker.formatDate ( 'yy-mm-dd', limitDate ) ) {
					if ( hour <= limit ) {
							return false;
						}
				}
			    if( $("#returnDate").val() == $("#transferDate").val() ) {
			    	limit = parseInt( $("#transferTime").val() +1, 10);
			        if ( hour <= limit ) {
			            return false;
			        }
			    }
			    return true;
			}
		});
	})	
	
	function selectJSON() {
		$('#wref').empty();
		$.ajax({
			type: 'GET',
			url: base_url+'AJAXselectJSON.php',
			success: function(data) {
				$('#wref').html(data);
			}	
		})	
		$('#webyblock').show(500);		
	}	
	
	function validateBookingForm(showAlert) {
		$('input, select').removeClass('notValid');
		$('input, select').next().removeClass('notValid');
		$('input, select').next().children().removeClass('notValid');

  	
		var errorMessage = '';
		if ($("#countrySelector").val() == 0) {
			errorMessage +='Country\n';
			$("#countrySelector_chosen, #countrySelector_chosen  a").addClass('notValid');
		}
		if ($("#fromSelector").val() == 0) {
			errorMessage +='From\n';
			$("#fromSelector_chosen, #fromSelector_chosen a").addClass('notValid');
		}
		if ($("#toSelector").val() == 0) {
			errorMessage +='To\n';
			$("#toSelector_chosen, #toSelector_chosen a").addClass('notValid');
		}

		if ($("#transferDate").val() == 0) {
			errorMessage +='Pickup Date\n';
			$("#transferDate").addClass('notValid');
		}
		if ($("#transferTime").val() == 0) {
			errorMessage +='Pickup Time\n';
			$("#transferTime").addClass('notValid');
		}
		if ($("#paxSelector").val() == 0) {
			errorMessage +='Passengers\n';
			$("#paxSelector").addClass('notValid');
		}

		if ($("#returnTransfer").val() == 1) {
			if ($("#returnDate").val() == '') {
				errorMessage +='Return date\n';
				$("#returnDate").addClass('notValid');
			}
			if ($("#returnTime").val() == '') {
				errorMessage +='Return time\n';
				$("#returnTime").addClass('notValid');
			}
		}


		if ($("#PaxFirstName").val() == '') {
			errorMessage +='First Name\n';
			$("#PaxFirstName").addClass('notValid');
		}

		if ($("#PaxLastName").val() == '') {
			errorMessage +='Last Name\n';
			$("#PaxLastName").addClass('notValid');
		}

		if ($("#PaxEmail").val() == '') {
			errorMessage +='E-mail\n';
			$("#PaxEmail").addClass('notValid');
		}

		if ($("#PaxTel").val() == '') {
			errorMessage +='Mobile number\n';
			$("#PaxTel").addClass('notValid');
		}


		if (errorMessage != '') {
			//alert('Please fill-in:\n\n' + errorMessage);
			if(showAlert == true) {
				//alert('Please fill-in all data');
				Materialize.toast('Please fill in all data', 3000, 'red white-text');
				//$('#selectCar').slideDown('slow');
			}
			return false;
		}
		return true;
	}
	
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
	
    function selectCarAdm(showAlert) {
        var bookingFormData = $("#bookingForm").serialize();
        var proceed = validateBookingForm(showAlert);
		var url = base_url+"AJAXselectCar.php"; 
		$.ajax({
		  type: "POST",
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
					
					$('html, body').animate({scrollTop: $('#selectCar').offset().top }, 800);
		});
        
        
        return false;
    }	
// final form validation
	$.validator.setDefaults({
		errorElement: "div"
	});
	$("#finalForm").validate({
		errorPlacement: function(error, element) {
			error.appendTo( element.parent("div") );
			$('#spiner').hide();	
		},
		submitHandler: function(){
			$('#spiner').show();
			$('form').submit();	
		},
		rules: {
			PaxFirstName: {required:true, minlength:1},
			PaxLastName: {required:true, minlength:2},
			MPaxFirstName: {required:true, minlength:1},
			MPaxLastName: {required:true, minlength:2},			
			MPaxEmail: {required:true, email:true},
			PickupAddress: {required:true, minlength: 5},
			DropAddress: {required:true, minlength: 5},
			PaxTel: {required:true, minlength: 12},
			MPaxTel: {required:true, minlength: 12}			
		}
	});

//================================================================================
// ZA EXTRAS	
//================================================================================
	function recalcExtra(element, price) {
		var el = element.id;
		var elVal = $("#"+el).val()<? if (s('returnTransfer'))  echo '*2'; ?>;

		// Druge valute
		// Total je samo display
		var totDisplay = elVal * price * <?= ExchangeRatio() ?>;
		$('#'+el+"Total").html( totDisplay.toFixed(2) +' <?= s('Currency') ?>');
		// SubTotalC se prenosi kao array
		$('#'+el+"SubTotalC").val( totDisplay.toFixed(2)); // valuta
		$('#'+el+"SubTotal").val( (elVal * price).toFixed(2)); // Euro
		
		calcGrandTotal();
		paymentOptionSelect();
	}

	
	function calcGrandTotal() {
		var grandTotal = parseFloat($("#transferPrice").val());
		var ET = 0;

		var grandTotalC =  parseFloat($("#transferPriceC").val());
		var ETC = 0;
		
		
		$('.extraTotal').each(function() {
			var elementTotal = parseFloat($(this).val());
			if(elementTotal > 0) {
				ET = (ET*1 + elementTotal*1)*1;
				grandTotal = (grandTotal*1 + elementTotal * 1)*1;
				
			}

			var elementTotalC = parseFloat( $(this).val() * <?= ExchangeRatio() ?> );
			if(elementTotalC > 0) {
				ETC = ETC + elementTotalC;
				grandTotalC = grandTotalC + elementTotalC;
			}
			

		});	

		// agenti nemaju kupone

		// grandTotal je samo display, nema polje		
		$(".grandTotal").html( grandTotalC.toFixed(2) + " <?= s('Currency') ?>");
		
		// ovo su hidden polja
		$("#TotalPrice").val( grandTotal.toFixed(2) );
		$("#Price").val( grandTotal.toFixed(2) );
		$("#TT").val( grandTotal.toFixed(2) );
		$("#ET").val(ET);

		$("#TotalPriceC").val( grandTotalC.toFixed(2) );
		$("#TTC").val( grandTotalC.toFixed(2) );
		$("#ETC").val(ETC);

	}
	
	//========================================================================
	// PaymentOption selector
	//========================================================================

	function paymentOptionSelect(){
		// odabrana opcija iz dropdowna
		var selected = $("#PaymentOption").val();
		// cijene
		var trprice	= parseFloat( $("#TT").val() );
		var extras	= parseFloat( $("#ET").val() );
		var price = parseFloat( $("#TotalPrice").val() );
		var pn = parseFloat( $("#PN").val() );
		var pl = parseFloat( $("#PL").val() );
		var driversPrice = parseFloat( $("#DriversPrice").val() );
		
		if(selected==1) { // ONLINE
			pl		= 0;
			pn		= price;
			$(".cashPayment").hide();
			$(".creditCardPayment").show('slow');
		}
		if(selected==2) { // CASH
			pn		= 0;
			pl		= price;    
			$(".creditCardPayment").hide();
			$(".cashPayment").show('slow');
		}
		if(selected==3) { // ONLINE + CASH
			pn		= (price - driversPrice);
			pl		= price - pn;
			$(".cashPayment").hide();
			$(".creditCardPayment").show('slow');
		}

		// polja u eurima
		$("#PN").val(pn); 
		$("#PL").val(pl); 

		// preracunaj u zadanu valutu za prikaz na ekranu
		var showPN = parseFloat( pn );
		var showPL = parseFloat( pl );
		
		// polja u valuti
		$("#PNC").val(showPN);
		$("#PLC").val(showPL);
		// prikaz u valuti!
		$("#displayPN").html(showPN.toFixed(2));
		$("#displayPL").html(showPL.toFixed(2));     
	}

	//============================================================
	
	// koristi se u gornjoj funkciji
	function isValidEmailAddress(email) {
		var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  return regex.test(email);
		
	};
	//=  KRAJ VALIDACIJE ====================================================


	//=======================================================================
	// ACCEPT T&C
	//=======================================================================
	function acceptDeclineTC() {
		var val = $("#acceptTC option:selected").val();

		if (val=='1') {
			$("#gotoPayment, #gotoPaymentCash").removeAttr('disabled','disabled').removeClass('grey').addClass('green');
			$("#paymentIcon").removeClass('fa-times-circle').addClass('fa-check-circle');
			$("#terms").removeClass('red-text fa-times-circle').addClass('green-text fa-check-circle');
		}
		else {
			$("#gotoPayment, #gotoPaymentCash").attr('disabled','disabled').removeClass('green').addClass('grey');
			$("#paymentIcon").removeClass('fa-check-circle').addClass('fa-times-circle');
			$("#terms").removeClass('green-text fa-check-circle').addClass('red-text fa-times-circle');
			
		}
	}
	acceptDeclineTC();

	//========================================================
	// PRIKAZ I PROVJERA TEL. BROJA - mora imati gornji file
	//========================================================
		var telInput = $("#MPaxTel"),
		  errorMsg = $("#error-msg"),
		  validMsg = $("#valid-msg");

		// initialise plugin
		telInput.intlTelInput({
		  utilsScript: "/js/intlTel/js/utils.js",  
		  nationalMode:false
		});

		// on blur: validate
		telInput.blur(function() {
		  if ($.trim(telInput.val())) {
			if (telInput.intlTelInput("isValidNumber")) {
			  validMsg.removeClass("hidden");
			} else {
			  telInput.addClass("error");
			  errorMsg.removeClass("hidden");
			  validMsg.addClass("hidden");
			}
		  }
		});

		// on keydown: reset
		telInput.keydown(function() {
		  telInput.removeClass("error");
		  errorMsg.addClass("hidden");
		  validMsg.addClass("hidden");
		});



	//============================================================
	// IZVRSI KAD SE UCITA FINAL
	//============================================================
		calcGrandTotal();
		paymentOptionSelect();
		
		$('.timepick').timepicker();

	function updateAdress () {
		if ($("#returnTransfer").val() == 1) {
			document.getElementById("RDropAddress").value = document.getElementById("PickupAddress").value;
			document.getElementById("RPickupAddress").value = document.getElementById("DropAddress").value;
		}
	}
	
	var api = $('#api').val();
	var agentid = $('#AgentID').val();
	
	if (agentid==1793) {
		$('#PickupNotes').val('Cancellation without payment up to 12 hours before the pick up time.')
	}	
	
	//$('#PaxEmail').val('jam.bg13@gmail.com');
	if (api=="WEBY") {
		var code = $('#ReferenceNo').val();	
		var link  = base_url+'AJAXgetJSON.php';
		var param = 'code='+code+'&form=final';
		$.ajax({
			type: 'POST',
			url: link,
			data: param, 
			async: false,
				success: function(data) {
					if (data=='false') alert ('Wrong reservation reference');
					else {
						var order = JSON.parse(data);
						var keys = Object.keys(order);
						keys.forEach(function(entry) {
								var id_ch = '#'+entry;
								if (order[entry] !='') $(id_ch).val(order[entry]);
							})	
					}
				}
		});	
		
		// dodavanje hotela u adrese
		$('#PickupAddress').val(($('#SPAddressHotel').val())+' '+($('#PickupAddress').val()));
		$('#DropAddress').val(($('#SDAddressHotel').val())+' '+($('#DropAddress').val()));
		$('#RPickupAddress').val(($('#RPAddressHotel').val())+' '+($('#RPickupAddress').val()));
		$('#RDropAddress').val(($('#RDAddressHotel').val())+' '+($('#RDropAddress').val()));

	}
	if (api=="SUN") {
		var code = $('#ReferenceNo').val();	
		//$('#PickupNotes').val('Broj njihove rezervacije je '+code+'. U slučaju no show-a prijaviti na +33975186856, tek onda pustiti vozača.')
	}
	$('#empty').on('click', function() {
		$('#FlightNo').val('');
		$('#FlightTime').val('');
		$('#PickupAddress').val('');
		$('#DropAddress').val('');
		$('#RPickupAddress').val('');
		$('#RDropAddress').val('');
		$('#RFlightNo').val('');
		$('#RFlightTime').val('');		
		$('#PaxFirstName').val('');
		$('#PaxLastName').val('');
		$('#MPaxTel').val('');
		$('#PaxEmail').val('');
		$('#PickupNotes').val('');
	
	})		
</script>
