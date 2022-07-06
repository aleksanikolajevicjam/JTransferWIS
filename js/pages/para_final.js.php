<script>
$('#anim').addClass('animated flipInY');
$('#fadeInDown').addClass('animated fadeInDown');
/*
$(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});
*/
document.querySelector('form').onkeypress = checkEnter;
function checkEnter(e){
 e = e || event;
 var txtArea = /textarea/i.test((e.target || e.srcElement).tagName);
 return txtArea || (e.keyCode || e.which || e.charCode || 0) !== 13;
}

// final form validation
	$.validator.setDefaults({
		errorElement: "div"
	});
	$("#finalForm").validate({
		onClick: false,
		errorPlacement: function(error, element) {
		error.appendTo( element.parent("div") );
		},
		rules: {
			PaxFirstName: {required:true, minlength:1},
			PaxLastName: {required:true, minlength:2},
			PaxEmail: {required:true, email:true},
			PickupAddress: {required:true, minlength: 5},
			DropAddress: {required:true, minlength: 5},
			PaxTel: {required:true, minlength: 12}
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
		$('#'+el+"Total").html( totDisplay.toFixed(2) );
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
		
		var couponDiscount = parseFloat($("#CouponDiscount").val());
		
		
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

		// obracunaj kupon
		grandTotal = grandTotal - (grandTotal * couponDiscount / 100);
		grandTotalC = grandTotalC - (grandTotalC * couponDiscount / 100);
		
		// grandTotal je samo display, nema polje		
		$("#grandTotal").html( grandTotalC.toFixed(2) + " <?= s('Currency') ?>");
		
		// ovo su hidden polja
		$("#TotalPrice").val( grandTotal.toFixed(2) );
		$("#Price").val( grandTotal.toFixed(2) );
		$("#TT").val( grandTotal.toFixed(2) );
		$("#ET").val(ET);

		$("#TotalPriceC").val( grandTotalC.toFixed(2) );
		$("#TTC").val( grandTotalC.toFixed(2) );
		$("#ETC").val(ETC);

	}
	
		
//==================================================================
//	KUPON
//==================================================================		
function CheckCoupon()
{
    var values = $('#finalForm').serialize();
    $.ajax({
      type: "POST",
      url: "/api/checkCoupon.php",
      data: values
    }).done(function( discount ) {
      
      		
      		
      		if(discount > 0 && $.isNumeric(discount) ) {
      			$("#CouponDiscount").val(discount);
      			$("#couponMessage").html('<?= COUPON_APPLIED ?>');
      		} else {
      			$("#couponMessage").html('<?= COUPON_NOT_VALID ?>');
      		}

			calcGrandTotal();
			paymentOptionSelect();
    });
    return false;
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
    var couponDiscount = parseFloat( $("#CouponDiscount").val() );
    
    
    if(selected==1) { // ONLINE
    	pl		= 0;
    	pn		= price;// - (price * couponDiscount / 100);
	    $(".cashPayment").hide();
	    $(".creditCardPayment").show('slow');
    }
    if(selected==2) { // CASH
		pn		= 0;
    	pl		= price;// - (price * couponDiscount / 100); 
	    $(".creditCardPayment").hide();
	    $(".cashPayment").show('slow');
    }
    if(selected==3) { // ONLINE + CASH
    	pn		= (price - driversPrice);
    	pl		= price - pn;
    	//pn = pn - (pn * couponDiscount / 100);
	    $(".cashPayment").hide();
	    $(".creditCardPayment").show('slow');
    }

	// polja u eurima
    $("#PN").val(pn); 
    $("#PL").val(pl); 

    // preracunaj u zadanu valutu za prikaz na ekranu
    var showPN = parseFloat( pn * <?= ExchangeRatio()?> );
    var showPL = parseFloat( pl * <?= ExchangeRatio()?> );
    
	// polja u valuti
    $("#PNC").val(showPN);
    $("#PLC").val(showPL);
    // prikaz u valuti!
    $("#displayPN").html(showPN.toFixed(2));
    $("#displayPL").html(showPL.toFixed(2));    
}

//============================================================
// PIN VERIFICATION FUNCTIONS
//============================================================

function sendPIN() {
	var phoneNumber = $("#MPaxTel").intlTelInput("getNumber");
	var paxEmail	= $("#PaxEmail").val();
	var isValid 	= $("#MPaxTel").intlTelInput("isValidNumber");
	
	if(isValid == true && paxEmail != '') {
		$.get("/t/createPIN.php",{ phoneNumber: phoneNumber, paxEmail:paxEmail},
				function(data){ 
					$("#pinSentInfo").html(data).show('slow');
					$("#sendPin").hide();
				});
	} else {
		$("#pinSentInfo").html('<p class="error s"><?= INVALID_EMAIL_ADDRESS?></p>').show('slow');
	}
	return false;
}

function verifyPIN() {
	var pin = $("#verify").val();
	$.get("/t/verifyPIN.php",{ pin: pin},
			function(data){ 
				//$(".pinSent").hide();
				if(data.indexOf("&middot;") != 0) {
					data += '<input type="hidden" id="vp" value="1">';
				}
				$("#pinSentInfo").html(data);
			});
	return false;	
}


//============================================================
// Click on gotoPayment button
//============================================================
$("#gotoPaymentCash").click(function(){
	var vp = $("#vp").val();
	if( vp == 1) {return true;}
	else { 
	alert('<?= PIN_NOT_VERIFIED?>');
	return false;
	}
});

$("#gotoPayment").click(function(){

	var errors = 0;
	
    if ($('#ch_name').val() != '') { 
		$('#ch_name').parent('div').removeClass('error');
	} else {
		errors = errors+1;
		$('#ch_name').parent('div').addClass('error');
	}

    if ($('#ch_last_name').val() != '') { 
		$('#ch_last_name').parent('div').removeClass('error');
	} else {
		errors = errors+1;
		$('#ch_last_name').parent('div').addClass('error');
	}
    if ($('#ch_address').val() != '') { 
		$('#ch_address').parent('div').removeClass('error');
	} else {
		errors = errors+1;
		$('#ch_address').parent('div').addClass('error');
	}

    if ($('#ch_city').val() != '') { 
		$('#ch_city').parent('div').removeClass('error');
	} else {
		errors = errors+1;
		$('#ch_city').parent('div').addClass('error');
	}

    if ($('#ch_zip').val() != '') { 
		$('#ch_zip').parent('div').removeClass('error');
	} else {
		errors = errors+1;
		$('#ch_zip').parent('div').addClass('error');
	}	

    if ($('#ch_phone').val() != '' && $("#ch_phone").intlTelInput("isValidNumber") && $("#MPaxTel").intlTelInput("isValidNumber") ) { 
		$('#ch_phone').parent('div').removeClass('error');
	} else {
		errors = errors+1;
		$('#ch_phone').parent('div').addClass('error');
	}	

    if ($('#ch_email').val() != '' && isValidEmailAddress( $('#ch_email').val() ) ) { 
		$('#ch_email').parent('div').removeClass('error');
	} else {
		errors = errors+1;
		$('#ch_email').parent('div').addClass('error');
	}	

    if ($('#ch_country').val() != '') { 
		$('#ch_country').parent('div').removeClass('error');
	} else {
		errors = errors+1;
		$('#ch_country').parent('div').addClass('error');
	}
	

	if (errors > 0) {
		alert('<?= CORRECT_ERRORS?>');
		return false;
	}

	return true; // sve u redu
});	

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
// ovo ne znam gdje se koristi
function acceptDeclineTC2() {
	var val = $("#acceptTC2").val();
	if (val=='1') $("#gotoPaymentCash").removeAttr('disabled','disabled');
	else $("#gotoPaymentCash").attr('disabled','disabled');
}	
</script>


<!--<script src="js/intlTelInput.min.js"></script>-->
<script>
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

function updateAdress () {
	document.getElementById("RDropAddress").value = document.getElementById("PickupAddress").value;
	document.getElementById("RPickupAddress").value = document.getElementById("DropAddress").value;
}
</script>

