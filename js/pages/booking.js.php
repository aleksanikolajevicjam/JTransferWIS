<? session_start() ?>
<? //echo '<pre>'; print_r($_SESSION); echo '</pre>'; ?>

<script>

    selectCountry('<?= $_SESSION['CountryID'] ?>');

    $("#btnContinue").click(function(){

		/* privremeno izbaceno

        if (validateBookingForm() == false) {
            return false;
        }
		*/
        var bookingFormData = $("#bookingForm").serialize();

        $.ajax({
          type: "POST",
          url: "./bf/a/test.php",
          data: bookingFormData
        }).done(function( msg ) {
                    $("#selectCar").html( msg );
                    $('#selectCar').slideDown('slow');
                    $('html, body').animate({scrollTop: $('#selectCar').offset().top }, 800);

                    $("#selectExtras").slideUp('slow');
                    $("#paymentData").slideUp('slow');
        });
        return false;
    });


	function carSelected(linkId) {

		/*
		ovo je trik koji omogucava da se unutar a taga stavi button
		ako je kliknut button, onda se a tag nece aktivirati
		inace se aktivira a tag
		*/
		if(document.activeElement.tagName=='BUTTON') {return false;}
		

		var id = $("#"+linkId).attr("data-vehiclecapacity");
		var price = $("#"+linkId).attr("data-price");

		$("#VehicleCapacity").val(id);
		$("#Price").val(price);

		$("#bookingForm").submit();
	}
	
	
	
	function ShowDriverProfile(id) {
		alert(id);
		return false;
	}
	
	
		$(document).ready(function()
		{
			function strpad00(s)
			{
				s = s + '';
				if (s.length === 1) s = '0'+s;
				return s;
			}

			var now = new Date();
			// minimum dva dana unaprijed
			var minDatex = now.getFullYear()+ "-" + strpad00(now.getMonth()+1) + "-" + strpad00(now.getDate()+2);
			$("#dtBox").DateTimePicker({
				dateFormat: 'yyyy-mm-dd',
				minDate: minDatex
			});
			//$(".timepick").DateTimePicker();
		});
</script>
