<script>
$('#anim').addClass('animated flipInY');
$('#fadeInDown').addClass('animated fadeInDown');

// final form validation
	jQuery.validator.setDefaults({
	  errorElement: "div"
	});
	$("#finalForm").validate({
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

// ZA EXTRAS	
	function recalcExtra(element, price) {
		var el = element.id;
		var elVal = $("#"+el).val()<? if (s('returnTransfer'))  echo '*2'; ?>;

		$('#'+el+"Total").html( (elVal * price).toFixed(2) +' <?= s('Currency') ?>');
		$('#'+el+"SubTotal").val( (elVal * price).toFixed(2));
		calcGrandTotal();
		paymentOptionSelect();
	}

	
	function calcGrandTotal() {
		var grandTotal = $("#transferPrice").val();
		
		$('.extraTotal').each(function() {
			var elementTotal = $(this).val();
			grandTotal = grandTotal*1 + elementTotal * 1;
		});		
		$("#grandTotal").html(grandTotal.toFixed(2) + ' <?= s('Currency') ?>');
		$("#TotalPrice").val(grandTotal.toFixed(2));
		//$("#ET").val(grandTotal.toFixed(2));
	}
	
		calcGrandTotal();
		paymentOptionSelect();
		
/*

	PREUZETO IZ v4_bf.js.full.php

*/		
function CheckCoupon()
{

    var values = $('#finalForm').serialize();
    $.ajax({
      type: "POST",
      url: "v4_coupons.php",
      data: values
    }).done(function( msg ) {
            
            $("#HiddenTotals").html(msg);

			var trprice	= $("#TT").val();
			var extras	= $("#ET").val();
			var price 	= trprice*1 + extras * 1;
		
		
			var pn		= (price * 20) / 100;
			var pl		= (price * 1) - (pn * 1);
		
			$("#PN").val(pn); $("#displayPN").html(pn.toFixed(2));
			$("#PL").val(pl); $("#displayPL").html(pl.toFixed(2));
			$("#totalPrice").html(price.toFixed(2));
            
            

    });
    return false;
}		



/*
** Payment selector
*/

function paymentOptionSelect(){
    var trprice	= $("#TT").val();
    var extras	= $("#ET").val();
    //var price 	= trprice * 1 + extras * 1;
    var price = $("#TotalPrice").val();
    var selected = $("#PaymentOption").val();
    
    if(selected==3) {
		var pn		= 0;
    	var pl		= (price * 1);    
	    $(".creditCardPayment").hide();
	    $(".cashPayment").show('slow');


    }
    else {
    
    	var pn		= (price * 20) / 100;
    	var pl		= (price * 1) - (pn * 1);
	    $(".cashPayment").hide();
	    $(".creditCardPayment").show('slow');

    }
  
    $("#PN").val(pn); $("#displayPN").html(pn.toFixed(2));
    $("#PL").val(pl); $("#displayPL").html(pl.toFixed(2));
    $("#totalPrice").html(price.toFixed(2));
    


}


/*
** Click on gotoPayment button
*/

$("#gotoPayment, #gotoPaymentCash").click(function(){

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

    if ($('#ch_phone').val() != '') { 
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
		alert('Please correct errors and try again');
		return false;
	}

	var values = $('#finalForm').serialize();
    $.ajax({
      type: "POST",
      url: "v4_kontrolaWebteh.php",
      data: values
    }).done(function( msg ) {
            $("#finalForm").hide();
			$("#Summary").html(msg).show();
			$('html, body').animate({scrollTop: $('#wrapper').offset().top }, 700);
            
    });
    

});	


function isValidEmailAddress(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
    
};

function acceptDeclineTC() {
	var val = jQuery("#acceptTC").val();
	if (val=='1') {
		jQuery("#gotoPayment").removeAttr('disabled','disabled');
		jQuery("#gotoPaymentCash").removeAttr('disabled','disabled');
	}
	else {
		jQuery("#gotoPayment").attr('disabled','disabled');
		jQuery("#gotoPaymentCash").attr('disabled','disabled');
		
	}
}

function acceptDeclineTC2() {
	var val = jQuery("#acceptTC2").val();
	if (val=='1') jQuery("#gotoPaymentCash").removeAttr('disabled','disabled');
	else jQuery("#gotoPaymentCash").attr('disabled','disabled');
}	
</script>


