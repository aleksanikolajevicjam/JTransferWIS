



/***************************************************************************************************************/

function ReplaceSelectorText(selector, newText) {
	$(selector+" option").remove();
    $(selector).append('<option value="0"> '+ newText +' </option>');
    $(selector).trigger("chosen:updated");
}






function saveSessData(varName, varValue) {
	//$("#collector").load('sess_write.php?sessionVarName='+variable+'&sessionVarValue='+value);
	$("#"+varName).val(varValue);
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

/* FAST SEARCH */
		$("#searchField").keyup(function(){
			if ($(this).val()) {
				var search = $(this).val().toLowerCase();
				$(".locations").hide();
				$("[data-searchTerm*='"+search+"']").show();
			} else {
				$(".locations").show();
			}
		});

		$("#searchField").change(function(){
			if ($(this).val()) {
				var search = $(this).val().toLowerCase();
				$(".locations").hide();
				$("[data-searchTerm*='"+search+"']").show();
			} else {
				$(".locations").show();
			}
		});

/****************/



	var ret = $("#returnTransferCheck").prop('checked');

	if (ret == 1) {
		$("#showReturn").show(700);
		$("#returnTransfer").val('1');
	} else {
		$("#showReturn").hide(500);
		$("#returnTransfer").val('0');
	}

	$("#returnTransferCheck").click(function() {
		var ret = $("#returnTransferCheck").is(':checked');
		if (ret == 1) {
			$("#showReturn").show(700);
			$("#returnTransfer").val('1');
		} else {
			$("#showReturn").hide(500);
			$("#returnTransfer").val('0');
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

/*$('.modal-trigger').leanModal({
	dismissible: true, // Modal can be dismissed by clicking outside of the modal
	opacity: .5, // Opacity of modal background
	in_duration: 300, // Transition in duration
	out_duration: 200, // Transition out duration
	//ready: function() { alert('Ready'); }, // Callback for Modal open
	//complete: function() { alert('Closed'); } // Callback for Modal close
});*/

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
