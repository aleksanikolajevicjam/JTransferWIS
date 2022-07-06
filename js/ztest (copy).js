
function selectCountry(selected) {

    	var pleaseSelect 	= $("#pleaseSelect").val();
    	var loading      	= $("#loading").val();
		var selectActive 	= '';

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

        	//$("#countrySelectorSpan").text(pleaseSelect);
			$("#fromSelector").text(' ---');
			//$("#fromSelectorSpan").html('<img src="i/loading8.gif">');
			$("#toSelector").text(' ---');
			//ReplaceSelectorText("#countrySelector", pleaseSelect);
        	ReplaceSelectorText("#fromSelector", ' ---');
        	ReplaceSelectorText("#toSelector", ' ---');


        	for(var i=0; i < data.length; i++) {
				if (selected==data[i].id) {
					selectActive = 'selected="selected"';
					//$("#countrySelectorSpan").text(data[i].val);
					$("#countrySelector").val(data[i].id);


				}
				else {
					selectActive = '';

				}

        		$("#countrySelector").append('<option value="'+data[i].id+'" ' +selectActive+'>'+data[i].val+'</option>');
        	}
			
			$("#countrySelector").trigger("chosen:updated");
			
			if (selected > 0) {
			$("#fromSelector").text(' --- ');
				$("#toSelector").text(' --- ');
				selectFrom($("#fromSelectorValue").val());
			}
    	}
    );
}

function LoadCountries(callback) {

    request = $.getJSON("https://taxido.net/widget/ajax_getCountries2.php?callback=?",
     function(data) {

		callback(data);
    });
}

// Fire up the loading - prebaceno u booking.php
//selectCountry();

function selectFrom(selected) {

    	var pleaseSelect 	= $("#pleaseSelect").val();
    	var loading      	= $("#loading").val();
		var countryID 		= $("#countrySelector").val();
		var selectActive	= '';

    	//$("#fromSelector").text(loading);
		//ReplaceSelectorText("#toSelector", ' ---');
		//$("#fromSelector").html('<img src="i/loading8.gif">');


	/*
		ovo je nacin za uzimanje varijable data iz ajax poziva
		kreira se funkcija - npr LoadFrom, a onda se pozove ovako kao doli
		na taj nacin se jedino moze doci do data varijable u nekoj drugoj funkciji
		Zapravo, umjesto da ajax funkcija jednostavno vrati vrijednost preko return-a
		mora se sve staviti u ovu doli bezimenu funkciju i u njoj se sve obradi
	*/

	LoadFrom(
		// ovo je ono sto callback poziva
		function ( data ) {
			//$("#fromSelectorSpan").text(pleaseSelect);
		   	//ReplaceSelectorText("#fromSelector", pleaseSelect);

			$("#toSelector").text(' --- ');
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


    request = $.getJSON("https://taxido.net/widget/ajax_getStartPlaces.php?cID="+cID+"&callback=?",
     	function(data) {
			callback(data);
    });

}


function selectTo(selected) {

    	var pleaseSelect 	= $("#pleaseSelect").val();
    	var loading      	= $("#loading").val();
		var fromID 			= $("#fromSelector").val();
		var selectActive	= '';

    		//$("#toSelectorSpan").text(loading);
$("#toSelectorSpan").html('<img src="i/loading8.gif">');

	/*
		ovo je nacin za uzimanje varijable data iz ajax poziva
		kreira se funkcija - npr LoadFrom, a onda se pozove ovako kao doli
		na taj nacin se jedino moze doci do data varijable u nekoj drugoj funkciji
		Zapravo, umjesto da ajax funkcija jednostavno vrati vrijednost preko return-a
		mora se sve staviti u ovu doli bezimenu funkciju i u njoj se sve obradi
	*/

	LoadTo(
		// ovo je ono sto callback poziva
		function ( data ) {
			//$("#toSelectorSpan").text(pleaseSelect);
        	//ReplaceSelectorText("#toSelector", pleaseSelect);

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




    request = $.getJSON("https://taxido.net/widget/ajax_getEndPlaces.php?fID="+fID+"&callback=?",

    function(data) {
        callback(data);
	});
}

function ReplaceSelectorText(selector, newText) {
	$(selector+" option").remove();
    $(selector).append('<option value="0"> '+ newText +' </option>');
}






function saveSessData(varName, varValue) {
	//$("#collector").load('sess_write.php?sessionVarName='+variable+'&sessionVarValue='+value);
	$("#"+varName).val(varValue);
}












function getCountries() {

	/*
	// podaci iz input polja - filtriranje
 	var status = $("#status").val();
 	var filter = $("#Search").val();
	*/
 	var url = 'https://taxido.net/widget/ajax_getCountries2.php?callback=?';

	$.ajax({
	 type: 'GET',
	  url: url,
	  async: false,
	  contentType: "application/json",
	  dataType: 'jsonp',
	  success: function(data) {

	  /*
	  // CUSTOM STUFF
	  $.each(data, function(i, item) {
        data[i].color ='white';
		var ts = data[i].TransferStatus;
		data[i].TransferStatus = statusDescription.status[ts].desc;
	  });
      */
		allCountries = data;

		var source   = $("#countriesTemplate").html();
		var template = Handlebars.compile(source);

		var HTML = template({countries : allCountries});

		$("#showCountries").html(HTML);
	  }
	});

}


function getStartingPoints() {
 	var cID = Session.get('cID');
 	//alert(cID);
	/*
	// podaci iz input polja - filtriranje
 	var status = $("#status").val();
 	var filter = $("#Search").val();
	*/
 	var url = 'https://taxido.net/widget/ajax_getStartPlaces.php?cID='+cID+'&callback=?';

	$.ajax({
	 type: 'GET',
	  url: url,
	  async: false,
	  contentType: "application/json",
	  dataType: 'jsonp',
	  success: function(data) {

	  /*
	  // CUSTOM STUFF
	  $.each(data, function(i, item) {
        data[i].color ='white';
		var ts = data[i].TransferStatus;
		data[i].TransferStatus = statusDescription.status[ts].desc;
	  });
      */
		startingPoints = data;

		var source   = $("#startingPointsTemplate").html();
		var template = Handlebars.compile(source);

		var HTML = template({starting : startingPoints});

		$("#showStartingPoints").html(HTML);
	  }
	});

}


function getEndingPoints() {
 	var fID = Session.get('fID');
 	//alert(cID);
	/*
	// podaci iz input polja - filtriranje
 	var status = $("#status").val();
 	var filter = $("#Search").val();
	*/
 	var url = 'https://taxido.net/widget/ajax_getEndPlaces.php?fID='+fID+'&callback=?';

	$.ajax({
	 type: 'GET',
	  url: url,
	  async: false,
	  contentType: "application/json",
	  dataType: 'jsonp',
	  success: function(data) {

	  /*
	  // CUSTOM STUFF
	  $.each(data, function(i, item) {
        data[i].color ='white';
		var ts = data[i].TransferStatus;
		data[i].TransferStatus = statusDescription.status[ts].desc;
	  });
      */
		endingPoints = data;
		console.log(data);
		var source   = $("#endingPointsTemplate").html();
		var template = Handlebars.compile(source);

		var HTML = template({ending : endingPoints});

		$("#showEndingPoints").html(HTML);
	  }
	});

}





/**************************************************************************************************************************/

/**
 * Implements JSON stringify and parse functions
 * v1.0
 *
 * By Craig Buckler, Optimalworks.net
 *
 * As featured on SitePoint.com
 * Please use as you wish at your own risk.
*
 * Usage:
 *
 * // serialize a JavaScript object to a JSON string
 * var str = JSON.stringify(object);
 *
 * // de-serialize a JSON string to a JavaScript object
 * var obj = JSON.parse(str);
 */

var JSON = JSON || {};

// implement JSON.stringify serialization
JSON.stringify = JSON.stringify || function (obj) {

	var t = typeof (obj);
	if (t != "object" || obj === null) {

		// simple data type
		if (t == "string") obj = '"'+obj+'"';
		return String(obj);

	}
	else {

		// recurse array or object
		var n, v, json = [], arr = (obj && obj.constructor == Array);

		for (n in obj) {
			v = obj[n]; t = typeof(v);

			if (t == "string") v = '"'+v+'"';
			else if (t == "object" && v !== null) v = JSON.stringify(v);

			json.push((arr ? "" : '"' + n + '":') + String(v));
		}

		return (arr ? "[" : "{") + String(json) + (arr ? "]" : "}");
	}
};


// implement JSON.parse de-serialization
JSON.parse = JSON.parse || function (str) {
	if (str === "") str = '""';
	eval("var p=" + str + ";");
	return p;
};


/**
 * Implements cookie-less JavaScript session variables
 * v1.0
 *
 * By Craig Buckler, Optimalworks.net
 *
 * As featured on SitePoint.com
 * Please use as you wish at your own risk.
*
 * Usage:
 *
 * // store a session value/object
 * Session.set(name, object);
 *
 * // retreive a session value/object
 * Session.get(name);
 *
 * // clear all session data
 * Session.clear();
 *
 * // dump session data
 * Session.dump();
 */

 if (JSON && JSON.stringify && JSON.parse) var Session = Session || (function() {

	// window object
	var win = window.top || window;

	// session store
	var store = (win.name ? JSON.parse(win.name) : {});

	// save store on page unload
	function Save() {
		win.name = JSON.stringify(store);
	};

	// page unload event
	if (window.addEventListener) window.addEventListener("unload", Save, false);
	else if (window.attachEvent) window.attachEvent("onunload", Save);
	else window.onunload = Save;

	// public methods
	return {

		// set a session variable
		set: function(name, value) {
			store[name] = value;
		},

		// get a session value
		get: function(name) {
			return (store[name] ? store[name] : undefined);
		},

		// clear session
		clear: function() { store = {}; },

		// dump session data
		dump: function() { return JSON.stringify(store); }

	};

 })();




 /************************************************************************
 	INDIVIDUAL SCREENS FUNCTIONS
 ***************************************************************************/

// From Index.php
 /*
        $(function () {
            var curr = new Date().getFullYear();

            // 2 days ahead
            var day = new Date().getDate()+2;
            var month = new Date().getMonth();
            var fromDate = new Date(curr,month,day);

            var opt = {
                'date': {
                    preset: 'date',
                    dateOrder: 'yyyyMMdd',
					dateFormat: 'yyyy-mm-dd',
					startYear: curr,
					minDate: fromDate,
					endYear: curr + 2//,
                    //invalid: { daysOfWeek: [0, 6], daysOfMonth: ['5/1', '12/24', '12/25'] }
                },
                'datetime': {
                    preset: 'datetime',
                    minDate: new Date(2012, 3, 10, 9, 22),
                    maxDate: new Date(2017, 7, 30, 15, 44),
                    stepMinute: 5
                },
                'time': {
                    preset: 'time',
					stepMinute: 10,
					timeWheels: 'HHii',
					timeFormat: 'HH:ii'

                },
                'credit': {
                    preset: 'date',
                    dateOrder: 'mmyy',
                    dateFormat: 'mm/yy',
                    startYear: curr,
                    endYear: curr + 10,
                    width: 100
                },
                'btn': {
                    preset: 'date',
                    showOnFocus: false
                },
                'inline': {
                    preset: 'date',
                    display: 'inline',
					dateOrder: 'mmddyyyy',
                }
            }

	// ovo je radilo, ali stavlja sve na prazna polja
  //$('.datepicker').val('').scroller('destroy').scroller($.extend(opt['date'], { theme: "android-ics light", mode: "mixed" }));
  //$('.timepick').val('').scroller('destroy').scroller($.extend(opt['time'], { theme: "android-ics light", mode: "mixed" }));
  
  	// ovako ostane value iz polja
	$('.datepicker').scroller('destroy').scroller($.extend(opt['date'], { theme: "android-ics light", mode: "mixed" }));
	$('.timepick').scroller('destroy').scroller($.extend(opt['time'], { theme: "android-ics light", mode: "mixed" }));
  });

*/
/* FAST SEARCH */
		$("#searchField").keyup(function(){
			if ($(this).val()) {
				var search = $(this).val().toLowerCase();
				$(".locations a").hide();
				$("[data-searchTerm*='"+search+"']").show();
			} else {
				$(".locations a").show();
			}
		});

		$("#searchField").change(function(){
			if ($(this).val()) {
				var search = $(this).val().toLowerCase();
				$(".locations a").hide();
				$("[data-searchTerm*='"+search+"']").show();
			} else {
				$(".locations a").show();
			}
		});

/****************/



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

/*
	select replacement, od onog tipa sa youtube
*/
/*
		$("select").live("change", function(e) {
			var v = $(this).val();
			var $op = $(this).find("option[value='"+v+"']");
			$(this).parents(".selWrap").find("span").text($op.text());
		});
*/


function validateBookingForm() {
	var errorMessage = '';
	if ($("#countrySelector").val() == 0) {
		errorMessage +='Country\n';
	}
	if ($("#fromSelector").val() == 0) {
		errorMessage +='From\n';
	}
	if ($("#toSelector").val() == 0) {
		errorMessage +='To\n';
	}

	if ($("#transferDate").val() == 0) {
		errorMessage +='Pickup Date\n';
	}
	if ($("#transferTime").val() == 0) {
		errorMessage +='Pickup Time\n';
	}
	if ($("#paxSelector").val() == 0) {
		errorMessage +='Passengers\n';
	}

	if ($("#returnTransfer").val() == 1) {
		if ($("#returnDate").val() == '') {
			errorMessage +='Return date\n';
		}
		if ($("#returnTime").val() == '') {
			errorMessage +='Return time\n';
		}
	}

	if ($("#PaxName").val() == '') {
		errorMessage +='Your Name\n';
	}
	if ($("#PaxEmail").val() == '') {
		errorMessage +='Your E-mail\n';
	}



	if (errorMessage != '') {
		alert('Please fill-in:\n\n' + errorMessage);
		return false;
	}
	return true;
}
