
<script>
var apiPath="/api/";

// Local storage support
if(typeof(Storage) !== "undefined") {
	// Supported
	var LS = true;
} else {
    // Sorry! No Web Storage support..
    var LS = false;
}

function changeCurrency() {
	var currency = $("#currencySelector").val();
	$.get("/t/changeCurrency.php?currency="+currency);
}

 String.prototype.ucwords = function () {
    return this.replace(/\w+/g, function(a){ 
      return a.charAt(0).toUpperCase() + a.slice(1).toLowerCase()
    })
  }


function selectCountry(selected) {

    	var pleaseSelect 	= $("#pleaseSelect").val();
    	var loading      	= $("#loading").val();
		var selectActive 	= '';
		ReplaceSelectorText("#countrySelector", loading);
		$("#countrySelector").addClass('nextElement');

	//
	//	ovo je nacin za uzimanje varijable data iz ajax poziva
	//	kreira se funkcija - npr LoadFrom, a onda se pozove ovako kao doli
	//	na taj nacin se jedino moze doci do data varijable u nekoj drugoj funkciji
	//	Zapravo, umjesto da ajax funkcija jednostavno vrati vrijednost preko return-a
	//	mora se sve staviti u ovu doli bezimenu funkciju i u njoj se sve obradi
	//

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
				
				var cName = data[i].text;
				var cNameShow = cName.split('|');

        		$("#countrySelector").append('<option value="'+
        		data[i].id+'" ' +selectActive+'>'+cNameShow[0].ucwords()+'</option>');
        	}
			$("#countrySelector").select2({
				data: data
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
		$("#fromSelector").removeClass('nextElement');
		

	LoadTo(
		// ovo je ono sto callback poziva
		function ( data ) {
			//$("#toSelectorSpan").text(pleaseSelect);
        	ReplaceSelectorText("#toSelector", pleaseSelect);

        	for(var i=0; i < data.length; i++) {

				if (selected==data[i].id) {
					selectActive = 'selected="selected"';
					$("#toSelectorSpan").text(data[i].text);
					$("#toSelector").val(data[i].id);
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


    

// Funkcija za prikaz svih Places u selectu
// koristi chosen select paket, ali ne mora
// Nakon odabira Place poziva Booking form!
function selectAll(selected) {

    	var pleaseSelect 	= $("#pleaseSelect").val();
    	var loading      	= $("#loading").val();
		var selectActive	= '';

	LoadAll(
		// ovo je ono sto callback poziva
		function ( data ) {
        	ReplaceSelectorText("#allSelector", pleaseSelect);
        	for(var i=0; i < data.length; i++) {

				if (selected==data[i].id) {
					selectActive = 'selected="selected"';
					$("#allSelectorSpan").text(data[i].text);
					$("#allSelector").val(data[i].id);
				}
				else {
					selectActive = '';
				}

        		$("#allSelector").append('<option value="'+data[i].id+'" data-seo="'+data[i].seo +
        								 '" ' +selectActive+'>'+data[i].text+'</option>');
        	}
        	$("#allSelector").trigger("chosen:updated");
    	}
    );
}

<? /*
// Ajax load
function LoadAll(callback) {

    var pleaseSelect = $("#pleaseSelect").val();
    var loading      = $("#loading").val();
	ReplaceSelectorText("#allSelector",$("#loading").val());

		request = $.getJSON( apiPath + "getAllPlaces.php?callback=?",

		function(data) {
			localStorage.data = [];
			localStorage.data = data;
		    callback(data);
		});
}  

// klik na Place poziva Booking form
function goToLink(){
	var link =  $('#allSelector option:selected').data('seo');
	window.location="<?= LINK_PREFIX . LINK_FROM ?>"+link;
}

// bezuvjetno poziva funkciju
selectAll();
*/ ?>
/***************** KRAJ SELECTA NA HOMEPAGE **************/


// Salje email sa podacima o cijenama na unesenu email adresu
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
		var formData = $("#quoteForm").serialize();
		if (email != '') {
		    request = $.get( "t/emailQuote.php?"+formData,

					function(data) {
					    //$("body").html(data);
					});
			Materialize.toast("E-mail sent to: " + email, 3000, 'blue white-text');
		}
	} else {
		Materialize.toast("Please fill-in all data", 3000, 'red white-text');
	}
	return false;
}





// premijesta naglaseni okvir oko select polja na sljedece
$("#toSelector").change(function(){
	$("#toSelector").removeClass('nextElement');
	$("#paxSelector").addClass('nextElement');
});
$("#fromSelector").change(function(){
	$("#fromSelector").removeClass('nextElement');
	$("#toSelector").addClass('nextElement');
});
$("#countrySelector").change(function(){
	$("#countrySelector").removeClass('nextElement');
	$("#fromSelector").addClass('nextElement');
});
$("#paxSelector").change(function(){
	$("#paxSelector").removeClass('nextElement');
});

// ako su potrebni podaci iz forma ispunjeni, prikazi donji dio
$("#paxSelector, #countrySelector, #fromSelector, #toSelector").change(function(){
	var pax = $("#paxSelector").val();
	var country = $("#countrySelector").val();
	var from = $("#fromSelector").val();
	var to = $("#toSelector").val();
	if(pax > 0 && from > 0 && to > 0 && country > 0) {
		$(".hideMe").show('slow');
	}
});

$(document).ready(function(){
	// ako su potrebni podaci iz forma vec ispunjeni, prikazi donji dio	
	// potrebno za npr. povratak na home, refresh i sl.
	var pax = $("#paxSelector").val();
	var country = $("#countrySelectorValue").val();
	var from = $("#fromSelectorValue").val();
	var to = $("#toSelectorValue").val();
	if(pax > 0 && from > 0 && to > 0 && country > 0) {
		$(".hideMe").show('slow');
	}
}); // end doc ready

</script>

