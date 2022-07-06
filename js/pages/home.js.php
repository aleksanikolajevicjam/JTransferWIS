
<script>
var apiPath="/api/";


function selectCountry(selected) {

    	var pleaseSelect 	= $("#pleaseSelect").val();
    	var loading      	= $("#loading").val();
		var selectActive 	= '';
		ReplaceSelectorText("#countrySelector", loading);

	/*
		ovo je nacin za uzimanje varijable data iz ajax poziva
		kreira se funkcija - npr LoadFrom, a onda se pozove ovako kao doli
		na taj nacin se jedino moze doci do data varijable u nekoj drugoj funkciji
		Zapravo, umjesto da ajax funkcija jednostavno vrati vrijednost preko return-a
		mora se sve staviti u ovu doli bezimenu funkciju i u njoj se sve obradi
	*/

	LoadCountries(
		// ovo je ono sto callback poziva
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

        		$("#countrySelector").append('<option value="'+data[i].id+'" ' +selectActive+'>'+data[i].val+'</option>');
        	}
			
			$("#countrySelector").trigger("chosen:updated");
			
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
    
    request = $.getJSON( apiPath+"getCountries.php?callback=?",
     function(data) {
		callback(data);
    });
}

// Fire up the loading - prebaceno u booking.js.php
//selectCountry();

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
					$("#fromSelectorSpan").text(data[i].val);
					$("#fromSelector").val(data[i].id);


				}
				else {
					selectActive = '';

				}

        		$("#fromSelector").append('<option value="'+data[i].id+'" ' +selectActive+'>'+data[i].val+'</option>');

		   	}
			
			$("#fromSelector").trigger("chosen:updated");	   	
		   	
		   	if (selected > 0) {
		   		$("#toSelector").text(' --- ');
				selectTo($("#toSelectorValue").val());
			}
    	},
    	countryID // obavezan parametar za ajax poziv
    );
}


/*
	ova funkcija vraca sve From lokacije.
	koristi se callback trikom da bi se mogla vratiti data varijabla
*/

function LoadFrom(callback, cID) {
	ReplaceSelectorText("#fromSelector",$("#loading").val());

    request = $.getJSON( apiPath + "getFromPlaces.php?cID="+cID+"&callback=?",
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
		// ovo je ono sto callback poziva
		function ( data ) {
			//$("#toSelectorSpan").text(pleaseSelect);
        	ReplaceSelectorText("#toSelector", pleaseSelect);

        	for(var i=0; i < data.length; i++) {

				if (selected==data[i].id) {
					selectActive = 'selected="selected"';
					$("#toSelectorSpan").text(data[i].val);
					$("#toSelector").val(data[i].id);


				}
				else {
					selectActive = '';

				}

        		$("#toSelector").append('<option value="'+data[i].id+'" ' +selectActive+'>'+data[i].val+'</option>');
        		
        	}
        	$("#toSelector").trigger("chosen:updated");
    	},
    	fromID // obavezan parametar za ajax poziv
    );
}


function LoadTo(callback, fID) {

    var pleaseSelect = $("#pleaseSelect").val();
    var loading      = $("#loading").val();
	ReplaceSelectorText("#toSelector",$("#loading").val());



    request = $.getJSON( apiPath + "getToPlaces.php?fID="+fID+"&callback=?",

    function(data) {
        callback(data);
	});
}    
    
    




selectCountry('<?= s('CountryID') ?>');




/*
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
*/



    function sendQuote() {

		var form = $( "#quoteForm" );
			form.validate({
				rules: {
					PaxNo: {required:true, min:{param:1}},
					PaxEmail: {required: true, email: true}
				}, 
				messages: {
					PaxNo: "Number of passengers empty!",
					PaxEmail: "Valid E-mail address required"
				}
			});
	
    	if(form.valid()) {
			var email = $("#PaxEmail").val();
			var formData = $("form").serialize();
			if (email != '') {
			    request = $.get( "t/emailQuote.php?"+formData,

						function(data) {
						    //$("body").html(data);
						});
				alert("E-mail sent to: " + email);
			}
    	}
    	return false;
    }
</script>

<script type="text/javascript">
$(document).ready(function(){
/*
 * Here is an example of how to use Backstretch as a slideshow.
 * Just pass in an array of images, and optionally a duration and fade value.
 */

  // Duration is the amount of time in between slides,
  // and fade is value that determines how quickly the next image will fade in
  $("#homeQuote").backstretch([
      "i/10.jpg"
    , "i/100.jpg"
    , "i/beach.jpg"
  ], {duration: 3000, fade: 750});

 }); // end doc ready
</script>

<script src="js/jquery.easing.min.js"></script>

