<? session_start() ?>
<? //echo '<pre>'; print_r($_SESSION); echo '</pre>'; ?>

<script>
var apiPath="../../../api/";
var bookingFormFromName = '';
var bookingFormToName = '';
var webPath = '<?= $_SERVER['SERVER_NAME'] ?>';

	var ret = $("#returnTransfer").val();
	if (ret == 1) {
		$("#showReturn").show(700);
	} else {
		$("#showReturn").hide(500);
	}
	$("#returnTransfer").change(function() {
		var ret = $("#returnTransfer").val();
		if (ret == 1) {
			$("#showReturn").show(700);
		} else {
			$("#showReturn").hide(500);
		}
	});

	
function selectCountry(selected) {

    	var pleaseSelect 	= $("#pleaseSelect").val();
    	var loading      	= $("#loading").val();
		var selectActive 	= '';
		ReplaceSelectorText("#countrySelector", loading);

	<?/*
		ovo je nacin za uzimanje varijable data iz ajax poziva
		kreira se funkcija - npr LoadFrom, a onda se pozove ovako kao doli
		na taj nacin se jedino moze doci do data varijable u nekoj drugoj funkciji
		Zapravo, umjesto da ajax funkcija jednostavno vrati vrijednost preko return-a
		mora se sve staviti u ovu doli bezimenu funkciju i u njoj se sve obradi
	*/?>

	LoadCountries(
		<? // ovo je ono sto callback poziva ?>
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
		function ( data ) {
        	ReplaceSelectorText("#toSelector", pleaseSelect);

        	for(var i=0; i < data.length; i++) {

				if (selected==data[i].id) {
					selectActive = 'selected="selected"';
					
					bookingFormToName = data[i].val;
					
					$("#toSelectorSpan").text(data[i].val);
					$("#toSelector").val(data[i].id);


				}
				else {
					selectActive = '';
				}

        		$("#toSelector").append('<option value="'+data[i].id+'" ' +selectActive+'>'+data[i].val+'</option>');
        	}
        	$("#toSelector").trigger("chosen:updated");
        	
        	//***********************************************************
        	//
        	// POKRENI ODABIR VOZILA
        	//
        	//***********************************************************
        	//selectCar(false); // ne prikazuj alert kad se tek ucita stranica

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


function toSelected() {
	bookingFormFromName = $("#fromSelector option:selected").text();
	//console.log(bookingFormFromName);
    bookingFormToName = $("#toSelector option:selected").text();
	//console.log(bookingFormToName);
	//window.history.pushState("object or string", "Title", "/taxi-transfers-from-"+url_slug(bookingFormFromName)+'-to-'+url_slug(bookingFormToName));

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
selectCountry('<?= $_SESSION['CountryID'] ?>');


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
$('input, select').change(function(){
	$(this).removeClass('notValid');
	$(this).next().removeClass('notValid');
	$(this).next().children().removeClass('notValid');
	return false;
});

//***********************************************



// SELECT CAR BUTTON CLICKED
    $("#selectCarBtn").click(function(){
    	return selectCar(true);
    });

   




    function selectCar(showAlert) {

        
        var bookingFormData = $("#bookingForm").serialize();
        var proceed = validateBookingForm(showAlert);


        if(!proceed) {
        	//return false;
        	
		    $.ajax({
		      type: "POST",
		      url: "/cms/t/selectCarNoDate.php",
		      data: bookingFormData
		    }).done(function( msg ) {
		                $("#selectCar").html( msg );
		                $('#selectCar').slideDown('slow');
		                //$('html, body').animate({scrollTop: $('#selectCar').offset().top }, 800);

						//$(".tab").hide();
						//$("#tab_1").removeClass('hidden').show();
						//$("#tabBtn1").removeClass('hidden').show();

		    });        
        } else {
        
	        //if ($('#bookingForm').valid() == false) {
	        //    return false;
	        //}

	        
		    $.ajax({
		      type: "POST",
		      url: "/cms/t/selectCar.php",
		      data: bookingFormData
		    }).done(function( msg ) {
		                $("#selectCar").html( msg );
		                $('#selectCar').slideDown('slow');
		                

						//$(".tab").hide();
						$("#tab_1").removeClass('hidden').show();
						//$("#tabBtn1").removeClass('hidden').show();
						
						$('html, body').animate({scrollTop: $('#selectCar').offset().top }, 800);

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
		//if(document.activeElement.tagName=='BUTTON') {return false;}
		

		var vehicleid 		= $("#v"+linkId).attr("data-vehicleid");
		var vehiclecapacity = $("#v"+linkId).attr("data-vehiclecapacity");
		var vehicleimage 	= $("#v"+linkId).attr("data-vehicleimage");
		var vehiclename 	= $("#v"+linkId).attr("data-vehiclename");
		var price 			= $("#v"+linkId).attr("data-price");
		var drivername 		= $("#v"+linkId).attr("data-drivername");
		var driverid 		= $("#v"+linkId).attr("data-driverid");
		var routeid 		= $("#v"+linkId).attr("data-routeid");
		var serviceid 		= $("#v"+linkId).attr("data-serviceid");
		

		$("#VehicleID").val(vehicleid);
		$("#VehicleCapacity").val(vehiclecapacity);
		$("#VehicleImage").val(vehicleimage);
		$("#VehicleName").val(vehiclename);
		$("#Price").val(price);
		$("#DriverName").val(drivername);
		$("#DriverID").val(driverid);
		$("#RouteID").val(routeid);
		$("#ServiceID").val(serviceid);

		$("#bookingForm").submit();
		return false;
	}
	
	
// DRIVER PROFILE PANEL TOGGLE	
	function ShowDriverProfile(id) {
		$("#DriverProfile"+id).toggle('slow');
		//alert(id);
		return false;
	}
	
	
// PRIMITIVE BOOKING FORM VALIDATION
// ToDo: implement real validation 

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

		if ($("#PickupAddress").val() == '') {
			errorMessage +='Pickup Address\n';
			$("#PickupAddress").addClass('notValid');
		}

		if ($("#DropAddress").val() == '') {
			errorMessage +='Drop-off Address\n';
			$("#DropAddress").addClass('notValid');
		}

		if (errorMessage != '') {
			//alert('Please fill-in:\n\n' + errorMessage);
			if(showAlert == true) {alert('Please fill-in all data');}
			return false;
		}
		return true;



	}
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
			transferDate: {required:true, email:true}
		}
	});	
*/




/**
 * Create a web friendly URL slug from a string.
 *
 * Requires XRegExp (http://xregexp.com) with unicode add-ons for UTF-8 support.
 *
 * Although supported, transliteration is discouraged because
 *     1) most web browsers support UTF-8 characters in URLs
 *     2) transliteration causes a loss of information
 *
 * @author Sean Murphy <sean@iamseanmurphy.com>
 * @copyright Copyright 2012 Sean Murphy. All rights reserved.
 * @license http://creativecommons.org/publicdomain/zero/1.0/
 *
 * @param string s
 * @param object opt
 * @return string
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
	var alnum = (typeof(XRegExp) === 'undefined') ? RegExp('[^a-z0-9]+', 'ig') : XRegExp('[^\\p{L}\\p{N}]+', 'ig');
	s = s.replace(alnum, opt.delimiter);
	
	// Remove duplicate delimiters
	s = s.replace(RegExp('[' + opt.delimiter + ']{2,}', 'g'), opt.delimiter);
	
	// Truncate slug to max. characters
	s = s.substring(0, opt.limit);
	
	// Remove delimiter from ends
	s = s.replace(RegExp('(^' + opt.delimiter + '|' + opt.delimiter + '$)', 'g'), '');
	
	return opt.lowercase ? s.toLowerCase() : s;
}




function manageTabs(tabId) {
	$(".tab").hide();
	$("#tab_"+tabId).removeClass('hidden').show();
	return false;
}

<?
/*
	if(	
		s('CountryID') != 0 
		and s('FromID') != 0 
		and s('ToID') != 0 
		and s('PaxNo') != 0
		and s('transferDate') != '' 
		and s('transferTime') != ''
		)

		sleep(2);

		echo '

		$(document).ready(function(){
			selectCar();
		});

		';
*/
?>
</script>

