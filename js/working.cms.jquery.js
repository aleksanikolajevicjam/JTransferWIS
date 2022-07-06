// VARIABLES AVAILABLE TO ALL FUNCTIONS
var allTransfers = [];
var window.root = 'http://www.jamtransfer.com';
var drivers = [];

var placesCache = {
    data: {},
    remove: function (url) {
        delete placesCache.data[url];
    },
    exist: function (url) {
        return placesCache.data.hasOwnProperty(url) && placesCache.data[url] !== null;
    },
    get: function (url) {
        //console.log('Getting in cache for url' + url);
        return placesCache.data[url];
    },
    set: function (url, cachedData) {
        placesCache.remove(url);
        placesCache.data[url] = cachedData;
    }
};
//**************************************


/*
Uzima podatke za listu transfera
parametri dolaze iz input/select polja u formu
pa ih treba definirati tamo
*/

function getAllTransfers() {

	// podaci iz input polja - filtriranje
	var where = $("#whereCondition").val(); // glavni filter koji uvijek radi
 	var status = $("#status").val(); // prikazuje samo transfere koji imaju taj status
 	var filter = $("#Search").val(); // filtrira prema zadanom tekstu
 	var length = $("#length").val(); // dropdown za broj prikazanih transfera na stranici
 	// advanced search
 	var advancedSearch = '';
 	var bookedCond = $("#filterBooked").val();
 	var bookedDate = $("#filterBookedDate").val();
 	var pickupCond = $("#filterPickup").val();
 	var pickupDate = $("#filterPickupDate").val();
 	var driverCond = $("#filterDriverID").val();
 	var sortOrder  = $("#sortOrder").val();
 	
 	// slozi dodatni where uvjet
 	if (bookedDate != '') {
 		advancedSearch += ' AND OrderDate ' + bookedCond + " '" + bookedDate + "' ";
 	}

 	if (pickupDate != '') {
 		advancedSearch += ' AND PickupDate ' + pickupCond + " '" + pickupDate + "' ";
 	}

 	if (driverCond != '0') {
 		advancedSearch += ' AND DriverID = '+  driverCond ;
 	}
 	
 	if (advancedSearch != '' && advancedSearch != ' AND DriverID = '+  driverCond) { $("#advancedSearchActive").html('<i class="fa fa-toggle-on l text-red"></i>');}
 	else $("#advancedSearchActive").html('<i class="fa fa-toggle-off l"></i>');
 	
	var callFunction = 'getAllTransfersFilter()'; // funkcija koju paginator poziva kod promjene stranice
	
	// ovo koristi i paginator funkcija!
 	var recordsTotal = 0;
 	var page  = $("#pageSelector").val();

	if(typeof page==='undefined') {page=1;}
	if(page<=0) {page=1;}
	//

 	var url = window.root + '/cms/a/allTransfers.php?where='+where+advancedSearch+'&status='+status+
 	'&Search='+filter+'&page='+page+'&length='+length+'&sortOrder='+sortOrder;

	$.ajax({
	 type: 'GET',
	  url: url,
	  async: true,
	  contentType: "application/json",
	  dataType: 'jsonp',
	  success: function(allTransfersData) {

		  // CUSTOM STUFF
		  // uzmi samo podatke o transferima
		  var data = allTransfersData.data;
		  recordsTotal = allTransfersData.recordsTotal;
		
		  paginator(page,recordsTotal,length, callFunction);
		  
		  $.each(data, function(i, item) {
		    data[i].color ='white';
			//var ts = data[i].TransferStatus;
			//data[i].TransferStatus = statusDescription.status[ts].desc;
			if(data[i].TransferStatus == '3') {data[i].color = 'red lighten-3';}
		  });

			allTransfers = data;
			
			// poziva se handlebars da pripremi prikaz
			// template je u parts/transferList.Driver.php

			var source   = $("#transfersTemplate").html();
			var template = Handlebars.compile(source);

			var HTML = template({transfers : allTransfers});

			$("#showTransfers").html(HTML);
			$(".timepicker").pickatime({format: 'HH:i'});
	  }, 
	  error: function() { alert('Get All Transfers error');}

	});

}

/*
PAGINATOR BLOCK
Omogucava paginaciju. 
U #infoShow div koji mora biti u formu pise podatke o ukupnom broju slogova i trenutnoj stranici
U #pageSelect div koji mora biti u formu ubacuje dropdown gdje se bira stranica koja ce se prikazati
parametri:
	page - broj trenutno prikazane stranice. Inicijalno mora biti 1
	recordsTotal - ukupni broj podataka za prikaz
	length - broj podataka na stranici
	callFunction - funkcija koja se poziva za svaku promjenu stranice
*/
function paginator(page, recordsTotal, length, callFunction) {
		
		var iPage = parseInt(page,10);
 
		if (iPage <= 1) {iPage=1;}
		
		// izracunaj broj stranica
		iMaxPages = parseInt(recordsTotal,10) / parseInt(length,10);
		
		// vidi ima li ostatka
		var iRemainder = parseInt(recordsTotal,10) % parseInt(length,10);
		
		// ako ima, dodaj jos jednu stranicu
		if(iRemainder > 0) {
			iMaxPages = parseInt(recordsTotal,10) / parseInt(length,10)+parseInt(1,10);
		}
		
		// ne idi dalje od zadnje stranice
		if (iPage > parseInt(iMaxPages,10)) {iPage=parseInt(iMaxPages,10);}
		
		//prvi prikazani slog na stranici
		var begin = parseInt(length,10) * parseInt(iPage,10)-parseInt(length,10);
        
        // INFO BLOCK -> #infoShow div element   
        $("#infoShow").html('<span class="text-light-blue"><i class="ic-stack"></i> ' + recordsTotal + ' | ' + 
        '<i class="fa fa-eye"></i> ' +
        parseInt(begin+1,10) + '-' + parseInt(parseInt(begin,10)+parseInt(length,10),10) + 
        ' | <i class="ic-file"></i> ' + parseInt(iPage,10) + '/' + parseInt(iMaxPages,10)) + '</span>';
        
        
        // PAGINATION DROPDOWN and BUTTONS -> #pageSelect div element
        var selHtml = '<button class="btn btn-primary align" onclick="paginatorPrevPage();">Prev</button>';
        selHtml += '<select id="pageSelector" onchange="'+ callFunction + ';">'; // ajax refresh prikaza
        for (var i=1;i<=iMaxPages;i++)
        { 
            selHtml += '<option value="'+i+'"';
            if (i==iPage) {selHtml += ' selected="selected" ';}
            selHtml += '>'+parseInt(i,10)+'</option>';
        }
        
        selHtml += '</select>';
        selHtml += '<button class="btn btn-primary align" onclick="paginatorNextPage();">Next</button>';
        $("#pageSelect").html(selHtml);
}

function paginatorNextPage() {
	var thisPage = $("#pageSelector").val();
	$("#pageSelector").val(parseInt(thisPage) +parseInt(1)).change();
}
function paginatorPrevPage() {
	var thisPage = $("#pageSelector").val();
	var prevPage = parseInt(thisPage) -parseInt(1);
	if(prevPage <= 1) {prevPage=1;}
	$("#pageSelector").val(prevPage).change();
}

/* end of paginator block **********************************************************************************/


function showOneTransfer(id,inList) {
	// default value. inList znaci je li prikaz sa liste ili nije
	//if (typeof inList === "undefined" || inList === null) { inList = true; }
  	if (notDefined(inList)) {inList=true;}
  	// click na element - hide element ako je vec prikazan, nema potrebe za ajax
  	if(inList==true) {
  		if ( $("#transferWrapper"+id).css('display') != 'none') {
  			$("#transferWrapper"+id).hide('slow'); return;
  		}
  	}
  	
  	

  	// ako element nije prikazan, uzmi potrebne podatke i prikazi ga
	var url = window.root + '/cms/a/oneTransfer.php?where=WHERE DetailsID='+id;

	// sakrij sve ostale elemente prije nego se otvori novi
	if(inList==true) { 
		$(".editFrame").hide('slow'); 
		$(".form").parent().html(''); // cisti sadrzaj prethodno otvorenih form-ova iz memorije
	}

	// idemo po podatke
	$.ajax({
	   type: 'GET',
		url: url,
		async: true,
		contentType: "application/json",
		dataType: 'jsonp',
		cache: false,
		success: function(data) {

		  var source   = $("#transferTemplate").html();
		  var template = Handlebars.compile(source);

		  var HTML = template(data);
		
		  if(inList==true) { $("#t_"+id).removeClass('white').addClass('xblue lighten-4 xblack-text'); }
		  
		  $("#oneTransfer"+id).html(HTML);

		  if(inList==true) { $("#transferWrapper"+id).show('slow'); }
		  
		    //$('html,body').animate({scrollTop: $("#transferWrapper"+id).offset().top }, 500);
 			$(".datepicker").pickadate({format:'yyyy-mm-dd', formatSubmit: 'yyyy-mm-dd'});
 			$(".timepicker").pickatime({format: 'HH:i'});	
		}
	});
}

function editClose(id, inList) {
	$(".editFrame").hide('slow'); $(".form").parent().html('');
	return false;
}

function editSave(id, inList) {
	// default value. inList znaci je li prikaz sa liste ili nije
	if (notDefined(inList)) {inList=true;}

	var newData = $("#transferEditForm"+id).serializeObject();
	var formData = $("#transferEditForm"+id).serialize();

	// update data on server
	//var url = window.root + '/cms/a/'+
	//'setDbData.php?table=v4_OrderDetails&keyName=DetailsID&keyValue='+id+'&'+ formData;
	var url = window.root + '/cms/a/'+
	'saveTransfer.php?DetailsID='+id+'&'+ formData;	
	
	$.ajax({
		type: 'POST',
		url: url,
		async: false,
		contentType: "application/json",
		//dataType: 'jsonp',
		success: function(data) {
			
			$("#statusMessage").html('<i class="ic-checkmark-circle s"></i> ');
		
			// osvjezi podatke na ekranu za zadani element
			if (inList==true) {
				//getAllTransfers(); //ovo je problem... ne znam treba li
				refreshData(id, newData);
				
				$(".editFrame").hide('slow');
			} else {
				location.reload(true);
			}
				
				 
			
		},
		error: function(xhr, status, error) {alert("Save error occured: " + xhr.status + " " + xhr.statusText); 	}
	});

	return false;
}
function deleteTransfer(id, inList) {
	if (notDefined(inList)) {inList=true;}
	return changeTransferStatus(id, inList, '9');
}

function cancelTransfer(id, inList) {
	if (notDefined(inList)) {inList=true;}
	return changeTransferStatus(id, inList, '3');
}

function completedTransfer(id, inList) {
	if (notDefined(inList)) {inList=true;}
	return changeTransferStatus(id, inList, '5');
}

function activateTransfer(id, inList) {
	if (notDefined(inList)) {inList=true;}
	return changeTransferStatus(id, inList, '1');
}	
function changeTransferStatus(id, inList, newStatus) {
	// default value. inList znaci je li prikaz sa liste ili nije
	
	if(!confirm('Are you sure?')) return false;
	
	if (notDefined(inList)) {inList=true;}
	
	var formData = $("#transferEditForm"+id).serialize();

	// update data on server
	var url = window.root + '/cms/a/'+
	'changeTransferStatus.php?DetailsID='+id+'&NewStatus='+ newStatus + '&'+ formData;
	
	$.ajax({
		type: 'POST',
		url: url,
		async: false,
		contentType: "application/json",
		//dataType: 'jsonp',
		success: function(data) {
			
			$("#statusMessage").html('<i class="ic-cancel-circle s"></i> ');
		
			// osvjezi podatke na ekranu za zadani element
			if (inList==true) {
				getAllTransfers();
				//refreshData(id, newData);
				//$(".editFrame").hide('slow');
			}
		},
		error: function(xhr, status, error) {alert("Error occured: " + xhr.status + " " + xhr.statusText); }
	});

	return false;
}

function editPrint(id, inList) {
	// default value. inList znaci je li prikaz sa liste ili nije
	//if (typeof inList === "undefined" || inList === null) { inList = true; }
	if (notDefined(inList)) {inList=true;}

  	if(inList==true) { 
		window.print();
		//$(".editFrame").hide('slow'); 
	}
  	alert('Document Printed');
  	
  return false;
}


/* trazenje elementa object array-a i refresh liste transfera */
function refreshData(id, newData) {

  var result = $.grep(allTransfers, function(e){ return e.DetailsID == id; });

  if (result.length == 0) {
    // not found
  } else if (result.length == 1) {

        // ovo je u biti slog datoteke - result[0]
        //result[0].PaxName = $("#PassengerName").val();
        //result[0].PickupName = $("#PassengerName").val();


        // ovdje je trik za referncu kroz ime varijable

        // najprije napraviti novi objekt - jer ovaj vec ima [0] ...
        var ress = result[0];


        $.each(newData,function(name, value){
        	// ... onda se moze pristupiti pojedninacnoj vrijednosti preko varijable
        	ress[name] = value;
        });

        ress.color = 'xgreen lighten-4 xblack-text';

        changeAll(id, ress);

        data = allTransfers;

        var source   = $("#transfersTemplate").html();
        var template = Handlebars.compile(source);

        var HTML = template({transfers : data});

        $("#showTransfers").html(HTML);
        //alert(result[0].Name);

  } else {
    // multiple items found
  }

}

/* promjena vrijednosti u object array-u */
function changeName( id, newName ) {
   for (var i in allTransfers) {
     if (allTransfers[i].DetailsID == id) {
        allTransfers[i].PaxName = newName;
        break; //Stop this loop, we found it!
     }
   }
}

/* promjena cijelog sloga datoteke odjednom */
function changeAll( id, sve ) {
   for (var i in allTransfers) {
     if (allTransfers[i].DetailsID == id) {
        allTransfers[i] = sve;
        break; //Stop this loop, we found it!
     }
   }
}


function applyChangeDriver(selectElement) {

	alert('Old driver and New driver will be informed of this change!');


	var id   = $("#DriverSelect").val();
/*	var name = $("#DriverSelect option:selected").attr('data-realName');
	//var id   = $("#DriverSelect option:selected").val();
	
	var tel  = $("#DriverSelect option:selected").attr('data-tel');
	var email= $("#DriverSelect option:selected").attr('data-email');


	// izmjena podataka u input poljima (hidden)
	// tako da se kod save-a mogu upisati u db
	$("#DriverID").val(id);
	$("#DriverName").val(name);
	$("#DriverTel").val(tel);
	$("#sendEmailTo").val(email);
*/	
	$("#DriverConfDate").val('');
	$("#DriverConfTime").val('');
	
	if(id != 0) {
		$("#DriverConfStatus").val('1');
	} else {
		$("#DriverConfStatus").val('0');
	}
/*	
	//$("#newDriverName").html(name);
	$("#newDriverConfirm").html('');
	$("#newDriverTel").html(tel);
	$("#newDriverEmail").html(email);
*/
			var newDriverEmail = $(selectElement).find(':selected').data('email');
			var newDriverTel   = $(selectElement).find(':selected').data('tel');
			var newDriverName  = $(selectElement).find(':selected').data('realname');
			var newDriverID    = $(selectElement).val();
			
			$("#newDriverEmail").text(newDriverEmail);
			$("#newDriverTel").text(newDriverTel);
			$("#sendEmailTo").val(newDriverEmail);
			
			$("#DriverName").val(newDriverName);
			$("#DriverTel").val(newDriverTel);
			$("#DriverEmail").val(newDriverEmail);
			$("#DriverID").val(newDriverID);
			
			// reset confirmation values
			//$("#DriverConfStatus").val('1');
			$("#DriverConfDate").val('');
			$("#DriverConfTime").val('');

}


function sendEmailToDriver(transferId, tNo) {
	
	var subject = 'Update';
	var message	= $("#DriverNotes").val();
	var to 		= $("#sendEmailTo").val();
	
	// u produkciji ovo staviti
	//var to = $("#sendEmailTo").val();

	var url = window.root + '/cms/a/'+
		"sendEmail.php?to=" + to +
		"&subject=Ref. Order ID: " + transferId + '-' + tNo + ': '+ subject +
		"&OrderID=" + transferId +
		"&TNo=" + tNo +  
		"&message="+ message +
		"&callback=?";
	$("#sendMessageResponse").html('Sending...');	
	
	$.ajax({
		type: 'POST',
		url: url,
		async: false,
		contentType: "application/json",
		dataType: 'jsonp',
		success: function(data) {
			$("#sendMessageResponse").html(data);
		}
	});	

	return false;
}




function getTodoData() {
	var url = window.root + '/a/'+
	"todoItems.php?action=get&callback=?";
	
	$.ajax({
		type: 'GET',
		url: url,
		async: false,
		contentType: "application/json",
		dataType: 'jsonp',
		//cache: false,
		success: function(data) {
		  var source   = $("#todoTemplate").html();
		  var template = Handlebars.compile(source);
		  var HTML = template({todoItems : data});
		  $("#showToDo").html(HTML);
		}
	});
}




/*************************************************************************************************************
**************************************************************************************************************
** HELPERS 
**************************************************************************************************************
*************************************************************************************************************/
function notDefined(what) {
	if (typeof what === "undefined" || what === null) { return true; }
	return false;
}


/* COOKIE */
function createCookie(name, value, days) {
    var expires;

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
}

function readCookie(name) {
    var nameEQ = escape(name) + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return unescape(c.substring(nameEQ.length, c.length));
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name, "", -1);
}
/* END COOKIE */

//
// getSlug(text, separator)
// vraca slug sa rijecima odvojenim separatorom
//
// u donjim funkcijama je mapa sto se s cim mijenja
//
function getSlug(text, separator) {
    var chars = latin_map();
        chars = jQuery.extend(chars, greek_map());
        chars = jQuery.extend(chars, turkish_map());
        chars = jQuery.extend(chars, russian_map());
        chars = jQuery.extend(chars, ukranian_map());
        chars = jQuery.extend(chars, czech_map());
        chars = jQuery.extend(chars, latvian_map());
        chars = jQuery.extend(chars, polish_map());
        chars = jQuery.extend(chars, symbols_map());
        chars = jQuery.extend(chars, currency_map());
        
        var slug = new String();
        for (var i = 0; i < text.length; i++) {
            if ( chars[text.charAt(i)] ) { slug += chars[text.charAt(i)] }
            else                         { slug += text.charAt(i) }
        }
        // Ensure separator is composable into regexes
        var sep_esc  = separator.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
        var re_trail = new RegExp('^'+ sep_esc +'+|'+ sep_esc +'+$', 'g');
        var re_multi = new RegExp(sep_esc +'+', 'g');

        slug = slug.replace(/[^-\w\d\$\*\(\)\!\_]/g, separator);  // swap spaces and unwanted chars
        slug = slug.replace(re_trail, '');                               // trim leading/trailing separators
        slug = slug.replace(re_multi, separator);                   // eliminate repeated separatos
        slug = slug.toLowerCase(); 

	return slug;
}

    function latin_map() {
        return {
            'À': 'A', 'Á': 'A', 'Â': 'A', 'Ã': 'A', 'Ä': 'A', 'Å': 'A', 'Æ': 'AE', 'Ç':
            'C', 'È': 'E', 'É': 'E', 'Ê': 'E', 'Ë': 'E', 'Ì': 'I', 'Í': 'I', 'Î': 'I',
            'Ï': 'I', 'Ð': 'D', 'Ñ': 'N', 'Ò': 'O', 'Ó': 'O', 'Ô': 'O', 'Õ': 'O', 'Ö':
            'O', 'Ő': 'O', 'Ø': 'O', 'Ù': 'U', 'Ú': 'U', 'Û': 'U', 'Ü': 'U', 'Ű': 'U',
            'Ý': 'Y', 'Þ': 'TH', 'ß': 'ss', 'à':'a', 'á':'a', 'â': 'a', 'ã': 'a', 'ä':
            'a', 'å': 'a', 'æ': 'ae', 'ç': 'c', 'è': 'e', 'é': 'e', 'ê': 'e', 'ë': 'e',
            'ì': 'i', 'í': 'i', 'î': 'i', 'ï': 'i', 'ð': 'd', 'ñ': 'n', 'ò': 'o', 'ó':
            'o', 'ô': 'o', 'õ': 'o', 'ö': 'o', 'ő': 'o', 'ø': 'o', 'ù': 'u', 'ú': 'u',
            'û': 'u', 'ü': 'u', 'ű': 'u', 'ý': 'y', 'þ': 'th', 'ÿ': 'y'
        };
    }

    function greek_map() {
        return {
            'α':'a', 'β':'b', 'γ':'g', 'δ':'d', 'ε':'e', 'ζ':'z', 'η':'h', 'θ':'8',
            'ι':'i', 'κ':'k', 'λ':'l', 'μ':'m', 'ν':'n', 'ξ':'3', 'ο':'o', 'π':'p',
            'ρ':'r', 'σ':'s', 'τ':'t', 'υ':'y', 'φ':'f', 'χ':'x', 'ψ':'ps', 'ω':'w',
            'ά':'a', 'έ':'e', 'ί':'i', 'ό':'o', 'ύ':'y', 'ή':'h', 'ώ':'w', 'ς':'s',
            'ϊ':'i', 'ΰ':'y', 'ϋ':'y', 'ΐ':'i',
            'Α':'A', 'Β':'B', 'Γ':'G', 'Δ':'D', 'Ε':'E', 'Ζ':'Z', 'Η':'H', 'Θ':'8',
            'Ι':'I', 'Κ':'K', 'Λ':'L', 'Μ':'M', 'Ν':'N', 'Ξ':'3', 'Ο':'O', 'Π':'P',
            'Ρ':'R', 'Σ':'S', 'Τ':'T', 'Υ':'Y', 'Φ':'F', 'Χ':'X', 'Ψ':'PS', 'Ω':'W',
            'Ά':'A', 'Έ':'E', 'Ί':'I', 'Ό':'O', 'Ύ':'Y', 'Ή':'H', 'Ώ':'W', 'Ϊ':'I',
            'Ϋ':'Y'
        };
    }

    function turkish_map() {
        return {
            'ş':'s', 'Ş':'S', 'ı':'i', 'İ':'I', 'ç':'c', 'Ç':'C', 'ü':'u', 'Ü':'U',
            'ö':'o', 'Ö':'O', 'ğ':'g', 'Ğ':'G'
        };
    }

    function russian_map() {
        return {
            'а':'a', 'б':'b', 'в':'v', 'г':'g', 'д':'d', 'е':'e', 'ё':'yo', 'ж':'zh',
            'з':'z', 'и':'i', 'й':'j', 'к':'k', 'л':'l', 'м':'m', 'н':'n', 'о':'o',
            'п':'p', 'р':'r', 'с':'s', 'т':'t', 'у':'u', 'ф':'f', 'х':'h', 'ц':'c',
            'ч':'ch', 'ш':'sh', 'щ':'sh', 'ъ':'', 'ы':'y', 'ь':'', 'э':'e', 'ю':'yu',
            'я':'ya',
            'А':'A', 'Б':'B', 'В':'V', 'Г':'G', 'Д':'D', 'Е':'E', 'Ё':'Yo', 'Ж':'Zh',
            'З':'Z', 'И':'I', 'Й':'J', 'К':'K', 'Л':'L', 'М':'M', 'Н':'N', 'О':'O',
            'П':'P', 'Р':'R', 'С':'S', 'Т':'T', 'У':'U', 'Ф':'F', 'Х':'H', 'Ц':'C',
            'Ч':'Ch', 'Ш':'Sh', 'Щ':'Sh', 'Ъ':'', 'Ы':'Y', 'Ь':'', 'Э':'E', 'Ю':'Yu',
            'Я':'Ya'
        };
    }

    function ukranian_map() {
        return {
            'Є':'Ye', 'І':'I', 'Ї':'Yi', 'Ґ':'G', 'є':'ye', 'і':'i', 'ї':'yi', 'ґ':'g'
        };
    }

    function czech_map() {
        return {
            'č':'c', 'ď':'d', 'ě':'e', 'ň': 'n', 'ř':'r', 'š':'s', 'ť':'t', 'ů':'u',
            'ž':'z', 'Č':'C', 'Ď':'D', 'Ě':'E', 'Ň': 'N', 'Ř':'R', 'Š':'S', 'Ť':'T',
            'Ů':'U', 'Ž':'Z'
        };
    }

    function polish_map() {
        return {
            'ą':'a', 'ć':'c', 'ę':'e', 'ł':'l', 'ń':'n', 'ó':'o', 'ś':'s', 'ź':'z',
            'ż':'z', 'Ą':'A', 'Ć':'C', 'Ę':'e', 'Ł':'L', 'Ń':'N', 'Ó':'o', 'Ś':'S',
            'Ź':'Z', 'Ż':'Z'
        };
    }

    function latvian_map() {
        return {
            'ā':'a', 'č':'c', 'ē':'e', 'ģ':'g', 'ī':'i', 'ķ':'k', 'ļ':'l', 'ņ':'n',
            'š':'s', 'ū':'u', 'ž':'z', 'Ā':'A', 'Č':'C', 'Ē':'E', 'Ģ':'G', 'Ī':'i',
            'Ķ':'k', 'Ļ':'L', 'Ņ':'N', 'Š':'S', 'Ū':'u', 'Ž':'Z'
        };
    }

    function currency_map() {
        return {
            '€': 'euro', '$': 'dollar', '₢': 'cruzeiro', '₣': 'french franc', '£': 'pound',
            '₤': 'lira', '₥': 'mill', '₦': 'naira', '₧': 'peseta', '₨': 'rupee',
            '₩': 'won', '₪': 'new shequel', '₫': 'dong', '₭': 'kip', '₮': 'tugrik',
            '₯': 'drachma', '₰': 'penny', '₱': 'peso', '₲': 'guarani', '₳': 'austral',
            '₴': 'hryvnia', '₵': 'cedi', '¢': 'cent', '¥': 'yen', '元': 'yuan',
            '円': 'yen', '﷼': 'rial', '₠': 'ecu', '¤': 'currency', '฿': 'baht'
        };
    }

    function symbols_map() {
        return {
            '©':'(c)', 'œ': 'oe', 'Œ': 'OE', '∑': 'sum', '®': '(r)', '†': '+',
            '“': '"', '”': '"', '‘': "", '’': "", "'" : "", '∂': 'd', 'ƒ': 'f', '™': 'tm',
            '℠': 'sm', '…': '...', '˚': 'o', 'º': 'o', 'ª': 'a', '•': '*',
            '∆': 'delta', '∞': 'infinity', '♥': 'love', '&': 'and'
        };
    }



/************************************************************************************************************
*************************************************************************************************************
** HANDLEBAR HELPERS 
*************************************************************************************************************
*************************************************************************************************************/

/*
FORMATIRANJE STATUSA ZA LISTU
*/

Handlebars.registerHelper("displayTransferStatusText", function(statusNumeric) {
    //return statusDescription.status[statusNumeric].desc;
    return statusDescription[statusNumeric];

});


/*
FORMATIRANJE USER LEVELA ZA LISTU
*/

Handlebars.registerHelper("displayUserLevelText", function(levelNumeric) {
    return userLevels[levelNumeric];
});

/*
Prikaz AuthLevelID polja kao dropdown 
uzima podatke iz userLevels objekta u init.js!
*/

Handlebars.registerHelper("userLevelSelect", function(currentLevel) {
	
	function userLevelsDropdown() {
		var userLevelsSelect = '<select name="AuthLevelID" id="AuthLevelID"><option value="0"> --- </option>';

		$.each (userLevels, function(i, val) {
			userLevelsSelect += '<option value="'+i+'" ';
			if (i == currentLevel) {
				userLevelsSelect += 'selected="selected" ';
			}
			userLevelsSelect += '>' + val + '</option>';
		});

		userLevelsSelect += '</select>';

		return  userLevelsSelect;
	}

return new Handlebars.SafeString(userLevelsDropdown());

});


/*
Prikaz izbora jezika
uzima podatke iz languages u lng/en_init.js
*/

Handlebars.registerHelper("languageSelect", function(currentLevel) {
	
	function languagesDropdown() {
		var languageSelect = '<select name="Language" id="Language">';

		$.each (languages, function(i, val) {
			languageSelect += '<option value="'+i+'" ';
			if (i == currentLevel) {
				languageSelect += 'selected="selected" ';
			}
			languageSelect += '>' + val + '</option>';
		});

		languageSelect += '</select>';

		return  languageSelect;
	}

return new Handlebars.SafeString(languagesDropdown());

});


/*
Yes-No umjesto broja
uzima podatke iz languages u lng/en_init.js
{{yesNoSelect PlaceActive 'PlaceActive' }}
*/

Handlebars.registerHelper("yesNoSelect", function(currentLevel, fieldName) {
	
	function yesNoDropdown() {
		var yesNoSelector = '<select name="'+fieldName+'" id="'+fieldName+'">';

		$.each (yesNo, function(i, val) {
			//i = i-1;
			yesNoSelector += '<option value="'+i+'" ';
			if (i == currentLevel) {
				yesNoSelector += 'selected="selected" ';
			}
			yesNoSelector += '>' + val + '</option>';
		});

		yesNoSelector += '</select>';

		return  yesNoSelector;
	}

return new Handlebars.SafeString(yesNoDropdown());

});


/*
driverConfStatus
*/
Handlebars.registerHelper("driverConfText", function(numeric) {
    return driverConfStatus[numeric];

});
Handlebars.registerHelper("driverConfStyle", function(numeric) {
    return driverConfClass[numeric];

});


/*
SurCategory - vraca slovo umjesto broja
*/
Handlebars.registerHelper("surCategory", function(numeric) {
    if(numeric == 0) return 'None';
    if(numeric == 1) return 'Global';
    if(numeric == 2) return 'Vehicle';
    if(numeric == 3) return 'Route';
    if(numeric == 4) return 'Service';

});

/*
PaymentMethod
*/
Handlebars.registerHelper("paymentMethodText", function(numericMethod) {
    return paymentMethod[numericMethod];

});

/*
PaymentStatus select
uzima podatke iz languages u lng/en_init.js
*/

Handlebars.registerHelper("paymentStatusSelect", function(currentValue) {
	
	function paymentStatusDropdown() {
		var paymentSelect = '<select name="PaymentStatus" id="PaymentStatus">';

		$.each (paymentStatus, function(i, val) {
			paymentSelect += '<option value="'+i+'" ';
			if (i == currentValue) {
				paymentSelect += 'selected="selected" ';
			}
			paymentSelect += '>' + val + '</option>';
		});

		paymentSelect += '</select>';

		return  paymentSelect;
	}

return new Handlebars.SafeString(paymentStatusDropdown());

});

/*
PaymentStatus select
uzima podatke iz languages u lng/en_init.js
*/

Handlebars.registerHelper("driverPaymentSelect", function(currentValue) {
	
	function driverPaymentDropdown() {
		var driverPaymentSelect = '<select name="DriverPayment" id="DriverPayment">';

		$.each (driverPayment, function(i, val) {
			driverPaymentSelect += '<option value="'+i+'" ';
			if (i == currentValue) {
				driverPaymentSelect += 'selected="selected" ';
			}
			driverPaymentSelect += '>' + val + '</option>';
		});

		driverPaymentSelect += '</select>';

		return  driverPaymentSelect;
	}

return new Handlebars.SafeString(driverPaymentDropdown());

});


/*
FORMATIRANJE DATUMA U Handlebars
koristi moment.js
primjer: {{formatDate PickupDate "long"}}
*/
var DateFormats = {
       short: "DD MMMM - YYYY",
       long: "DD.MM.YYYY, ddd"
};

Handlebars.registerHelper("formatDate", function(datetime, format) {
  if (moment) {
    f = DateFormats[format];
    return moment(datetime).format(f);
  }
  else {
    return datetime;
  }
});


Handlebars.registerHelper("fromNow", function(datetime) {
  if (moment) {
    return moment(datetime).fromNow();
  }
  else {
    return datetime;
  }
});

/*
Prikaz TransferStatus polja kao dropdown 
uzima podatke iz statusDescription objekta u init.js!
*/

Handlebars.registerHelper("transferStatusSelect", function(currentStatus) {
	
	function transferStatusDropdown() {
		var statusDropdown = '<select name="TransferStatus" id="TransferStatus">';

		$.each (statusDescription, function(i, val) {
			var id = i;
			statusDropdown += '<option value="'+id+'" ';
			if (id == currentStatus) {
				statusDropdown += 'selected="selected" ';
			}
			statusDropdown += '>' + statusDescription[i] + '</option>';
		});

		statusDropdown += '</select>';

		return  statusDropdown;
	}

return new Handlebars.SafeString(transferStatusDropdown());

});


Handlebars.registerHelper("transferStatusText", function(currentStatus) {
    return statusDescription[currentStatus];

});




/*
Prikaz TransferStatus polja kao dropdown 
uzima podatke iz statusDescription objekta u init.js!
*/

Handlebars.registerHelper("vehicleClassSelect", function(currentStatus) {
	
	function vehicleClassDropdown() {
		var vehicleClassDropdown = '<select name="TransferStatus" id="TransferStatus">';

		$.each (vehicleClass, function(i, val) {
			var id = i;
			vehicleClassDropdown += '<option value="'+id+'" ';
			if (id == currentStatus) {
				vehicleClassDropdown += 'selected="selected" ';
			}
			vehicleClassDropdown += '>' + vehicleClass[i] + '</option>';
		});

		vehicleClassDropdown += '</select>';

		return  vehicleClassDropdown;
	}

return new Handlebars.SafeString(vehicleClassDropdown());

});


Handlebars.registerHelper("vehicleClassSelect", function(currentStatus) {
    return vehicleClass[currentStatus];

});





/*
Image Upload input 
*/

Handlebars.registerHelper("uploadImage", function(UserID, btnText) {
	
	function createImageUploadInput() {
		var imageUploadInput = '<form name="form" action="" method="POST" enctype="multipart/form-data">';
		imageUploadInput += '<input type="file" name="imageFile" id="imageFile">';
		imageUploadInput += '<input type="hidden" name="UserID" value="'+UserID+'">';
		imageUploadInput += '<button id="imgUpload" class="btn btn-sm btn-info">'+btnText+'</button>';
		imageUploadInput += '</form>';
		return imageUploadInput;
	}

	return new Handlebars.SafeString(createImageUploadInput());

});
/*
Prikaz Driver polja kao dropdown 
*/

Handlebars.registerHelper("driverSelect", function(id,routeId) {
	
	function driverSelectDropdown() {
		
		var url = window.root + '/cms/a/getDriversForRoute.php?RouteID='+routeId+'&callback=';
		
		var selector = "<select class=\"w100\" name=\"DriverSelect\" id=\"DriverSelect\" onchange=\"applyChangeDriver(this);\">";
		
		selector += '<option value="0" data-tel="" data-co="" data-email="" data-realname=""> --- </option>';
		
		// trenutni id je u input/hidden polju
		//var id  = $("#DriverID").val();

		$.ajax({
			type: 'POST',
			url: url,
			async: false,
			contentType: "application/json",
			dataType: 'jsonp',

			success: function(data) {
				$.each(data, function(i,val) {
					selector += '<option value="' + val.UserID + '" ';
					selector += 'data-tel="'+val.Tel +'" ';
					selector += 'data-co="'+val.Company +'" ';
					selector += 'data-email="'+val.Email +'" ';
					selector += 'data-realname="'+val.RealName +'" ';

					if (val.UserID == id) {
						selector += ' selected="selected" ';
					}

					selector += '>' + val.Country + ' - ' + val.Terminal + ' - ' + val.Company;
					selector += '</option>';
				});

				selector += '</select>';

				// prikazi select umjesto imena vozaca
				//$("#newDriverName").html(selector);
			}
		});

		return selector;
	}

	return new Handlebars.SafeString(driverSelectDropdown());

});



/*
Prikaz MyDriver polja kao dropdown 
*/

Handlebars.registerHelper("myDriverSelect", function(id,routeId) {
	
	function driverSelectDropdown() {
		
		var url = window.root + '/cms/a/getDriversForRoute.php?RouteID='+routeId+'&callback=';
		
		var selector = "<select class=\"w100\" name=\"DriverSelect\" id=\"DriverSelect\" onchange=\"applyChangeDriver(this);\">";
		
		selector += '<option value="0"> --- </option>';
		
		// trenutni id je u input/hidden polju
		//var id  = $("#DriverID").val();

		$.ajax({
			type: 'POST',
			url: url,
			async: false,
			contentType: "application/json",
			dataType: 'jsonp',

			success: function(data) {
				$.each(data, function(i,val) {
					selector += '<option value="' + val.UserID + '" ';
					selector += 'data-tel="'+val.Tel +'" ';
					selector += 'data-co="'+val.Company +'" ';
					selector += 'data-email="'+val.Email +'" ';
					selector += 'data-realname="'+val.RealName +'" ';

					if (val.UserID == id) {
						selector += ' selected="selected" ';
					}

					selector += '>' + val.RealName + ' @ ' + val.Company;
					selector += '</option>';
				});

				selector += '</select>';

				// prikazi select umjesto imena vozaca
				//$("#newDriverName").html(selector);
			}
		});

		return selector;
	}

	return new Handlebars.SafeString(driverSelectDropdown());

});




/*
Prikaz Country polja kao dropdown 
*/

Handlebars.registerHelper("countrySelect", function(id,fieldName, returnIdAs) {
	
	
	function countrySelectDropdown() {
	
		var url = window.root + '/cms/a/getCountries.php?callback=?&returnIdAs='+returnIdAs;
		var selector = "<select class=\"w100\" name=\""+fieldName+"\" id=\""+fieldName+"\" >";
		selector += '<option value=" "> --- </option>';

		$.ajax({
			type: 'POST',
			url: url,
			async: false,
			contentType: "application/json",
			dataType: 'jsonp',

			success: function(data) {
				$.each(data, function(i,val) {
					selector += '<option value="' + val.CountryID + '" ';


					if (val.CountryID == id) {
						selector += ' selected="selected" ';
					}

					selector += '>' + val.CountryName;
					selector += '</option>';
				});

				selector += '</select>';
			}
		});

		return selector;
	}

	return new Handlebars.SafeString(countrySelectDropdown());

});

/*
Prikaz From i To polja kao dropdown 
*/

Handlebars.registerHelper("placeSelect", function(id,fieldName) {
	
	function placeSelectDropdown() {
		
		var url = window.root + '/cms/a/getPlaces.php?callback=';

		$.ajax({
			type: 'GET',
			url: url,
			async: false,
			contentType: "application/json",
			dataType: 'jsonp',
			cache: true,

            beforeSend: function () {
                if (placesCache.exist(url)) {
					selector = createPlacesSelect(placesCache.get(url), id, fieldName);
					//console.log(placesCache.get(url) );
                    return false;
                }
                return true;
            },
            success: function (data) {
                placesCache.set(url, data);
                selector = createPlacesSelect(data, id, fieldName);
            }
				
		});

		return selector;
	}

	return new Handlebars.SafeString(placeSelectDropdown());

});

function createPlacesSelect(data, id, fieldName) {

    var selector = "<select class=\"w100 "+fieldName+"\" name=\""+fieldName+"\" id=\""+fieldName+"\" >";
		selector += '<option value="0"> --- </option>';
		
		$.each(data, function(i,val) {
			selector += '<option value="' + val.PlaceID + '" ';


			if (val.PlaceID == id) {
				selector += ' selected="selected" ';
			}

			selector += '>' + val.PlaceName;
			selector += '</option>';
		});

		selector += '</select>';
		
		return selector;    
}


/*
Prikaz PlaceType kao dropdown 
*/

Handlebars.registerHelper("placeTypeSelect", function(id,fieldName) {
	
	function placeTypeSelectDropdown() {
		
		var url = window.root + '/cms/a/getPlaceType.php?callback=';
		var selector = "<select class=\"w100\" name=\""+fieldName+"\" id=\""+fieldName+"\" >";
		selector += '<option value="0"> --- </option>';

		$.ajax({
			type: 'POST',
			url: url,
			async: false,
			contentType: "application/json",
			dataType: 'jsonp',
			cache: true,

			success: function(data) {
				$.each(data, function(i,val) {
					selector += '<option value="' + val.PlaceTypeID + '" ';


					if (val.PlaceTypeID == id) {
						selector += ' selected="selected" ';
					}

					selector += '>' + val.PlaceTypeEN;
					selector += '</option>';
				});

				selector += '</select>';
			}
		});

		return selector;
	}

	return new Handlebars.SafeString(placeTypeSelectDropdown());

});

 
/*
Select helper
oznacava element kao selected
parametri: 	selected - sto treba oznaciti
			options - lista opcija za select
			
							<select name="SurCategory" id="SurCategory">
								{{#select SurCategory}}
									<option value="0"><?= NO_SURCHARGES ?></option>
									<option value="1"><?= USE_GLOBAL ?></option>
									<option value="2"><?= ROUTE_SPECIFIC ?></option>
								{{/select}}								
							</select>			
*/

Handlebars.registerHelper('select', function(selected, options) {
    return options.fn(this).replace(
        new RegExp(' value=\"' + selected + '\"'),
        '$& selected="selected"');
});

/*
usage: {{debug}}, {{debug someValue}}
*/
Handlebars.registerHelper("debug", function(optionalValue) {
  console.log("Current Context");
  console.log("====================");
  console.log(this);
 
  if (optionalValue) {
    console.log("Value");
    console.log("====================");
    console.log(optionalValue);
  }
});


/*
	Compare helper
	usage: 	{{#compare somevar ">" somevalue}}
			{{/compare}}
*/
Handlebars.registerHelper('compare', function (lvalue, operator, rvalue, options) {

    var operators, result;
    
    if (arguments.length < 3) {
        throw new Error("Handlerbars Helper 'compare' needs 2 parameters");
    }
    
    if (options === undefined) {
        options = rvalue;
        rvalue = operator;
        operator = "===";
    }
    
    operators = {
        '==': function (l, r) { return l == r; },
        '===': function (l, r) { return l === r; },
        '!=': function (l, r) { return l != r; },
        '!==': function (l, r) { return l !== r; },
        '<': function (l, r) { return l < r; },
        '>': function (l, r) { return l > r; },
        '<=': function (l, r) { return l <= r; },
        '>=': function (l, r) { return l >= r; },
        'typeof': function (l, r) { return typeof l == r; }
    };
    
    if (!operators[operator]) {
        throw new Error("Handlerbars Helper 'compare' doesn't know the operator " + operator);
    }
    
    result = operators[operator](lvalue, rvalue);
    
    if (result) {
        return options.fn(this);
    } else {
        return options.inverse(this);
    }

});


// zbraja dva broja
// vraca rezultat na 2 decimale
// primjer: {{addNumbers first second}}

Handlebars.registerHelper("addNumbers", function(first, second) {
	
	
	function addNumbers() {
		var value = parseFloat(first,2)+parseFloat(second,2);
		return value.toFixed(2);
	}

	return new Handlebars.SafeString(addNumbers());

});




/*
User data

{{userName details.UserID "AuthUserName"}}

id = AuthUserID
returnField = ime polja koje se vraca

Dolje je trik kako iskoristiti ime polja kao kljuc arraya
				var dataObj = {};
				dataObj = data[0];
				uName = dataObj[returnField];
*/

Handlebars.registerHelper("userName", function(id, returnField) {
	
	
	function userNameFunc() {
	
		var url = window.root + '/cms/a/oneUser.php?callback=?&AuthUserID='+id;
		var uName = 'jebote';

		$.ajax({
			type: 'POST',
			url: url,
			async: false,
			contentType: "application/json",
			dataType: 'jsonp',

			success: function(data) {
				var dataObj = {};
				dataObj = data[0];
				uName = dataObj[returnField];
			}
		});

		return uName;
	}

	return new Handlebars.SafeString(userNameFunc());

});

// maskiraj prvi dio email adrese
Handlebars.registerHelper("maskEmail", function(email) {
    var array = email.split("@",2);
    var length = array[0].length;
    var mask = "";
    
    for (var i = 0; i < length; i++) { mask = mask.concat("*"); }
    return mask + "@" + array[1];
});

/* HANDLEBARS END ************************************************************************************/




/*
pretvaranje vrijednosti skupljenih iz forma u object array
*/

(function($){
    $.fn.serializeObject = function(){

        var self = this,
            json = {},
            push_counters = {},
            patterns = {
                "validate": /^[a-zA-Z][a-zA-Z0-9_]*(?:\[(?:\d*|[a-zA-Z0-9_]+)\])*$/,
                "key":      /[a-zA-Z0-9_]+|(?=\[\])/g,
                "push":     /^$/,
                "fixed":    /^\d+$/,
                "named":    /^[a-zA-Z0-9_]+$/
            };


        this.build = function(base, key, value){
            base[key] = value;
            return base;
        };

        this.push_counter = function(key){
            if(push_counters[key] === undefined){
                push_counters[key] = 0;
            }
            return push_counters[key]++;
        };

        $.each($(this).serializeArray(), function(){

            // skip invalid keys
            if(!patterns.validate.test(this.name)){
                return;
            }

            var k,
                keys = this.name.match(patterns.key),
                merge = this.value,
                reverse_key = this.name;

            while((k = keys.pop()) !== undefined){

                // adjust reverse_key
                reverse_key = reverse_key.replace(new RegExp("\\[" + k + "\\]$"), '');

                // push
                if(k.match(patterns.push)){
                    merge = self.build([], self.push_counter(reverse_key), merge);
                }

                // fixed
                else if(k.match(patterns.fixed)){
                    merge = self.build([], k, merge);
                }

                // named
                else if(k.match(patterns.named)){
                    merge = self.build({}, k, merge);
                }
            }

            json = $.extend(true, json, merge);
        });

        return json;
    };
})(jQuery);



/**
* POMOCNE FUNKCIJE
**/

	function expandAll() {
		//GetFileManager();
		//GetPrices();
		//$("[id$=-Head]").parent().fadeOut();
		//$("[id$=-Det]").parent().slideDown('slow');
		$("[id$=-Head]").click();
	}

	function minimizeAll() {
		$("[id$=-Head]").parent().fadeIn('slow');
		$("[id$=-Det]").parent().slideUp();
	}
	
/*
ajaxFileUpload - AjaxFileUploaderV2.1
*/

jQuery.extend({
	

    createUploadIframe: function(id, uri)
	{
			//create frame
            var frameId = 'jUploadFrame' + id;
            var iframeHtml = '<iframe id="' + frameId + '" name="' + frameId + '" style="position:absolute; top:-9999px; left:-9999px"';
			if(window.ActiveXObject)
			{
                if(typeof uri== 'boolean'){
					iframeHtml += ' src="' + 'javascript:false' + '"';

                }
                else if(typeof uri== 'string'){
					iframeHtml += ' src="' + uri + '"';

                }	
			}
			iframeHtml += ' />';
			jQuery(iframeHtml).appendTo(document.body);

            return jQuery('#' + frameId).get(0);			
    },
    createUploadForm: function(id, fileElementId, data)
	{
		//create form	
		var formId = 'jUploadForm' + id;
		var fileId = 'jUploadFile' + id;
		var form = jQuery('<form  action="" method="POST" name="' + formId + '" id="' + formId + '" enctype="multipart/form-data"></form>');	
		if(data)
		{
			for(var i in data)
			{
				jQuery('<input type="hidden" name="' + i + '" value="' + data[i] + '" />').appendTo(form);
			}			
		}		
		var oldElement = jQuery('#' + fileElementId);
		var newElement = jQuery(oldElement).clone();
		jQuery(oldElement).attr('id', fileId);
		jQuery(oldElement).before(newElement);
		jQuery(oldElement).appendTo(form);


		
		//set attributes
		jQuery(form).css('position', 'absolute');
		jQuery(form).css('top', '-1200px');
		jQuery(form).css('left', '-1200px');
		jQuery(form).appendTo('body');		
		return form;
    },

    ajaxFileUpload: function(s) {
        // TODO introduce global settings, allowing the client to modify them for all requests, not only timeout		
        s = jQuery.extend({}, jQuery.ajaxSettings, s);
        var id = new Date().getTime()        
		var form = jQuery.createUploadForm(id, s.fileElementId, (typeof(s.data)=='undefined'?false:s.data));
		var io = jQuery.createUploadIframe(id, s.secureuri);
		var frameId = 'jUploadFrame' + id;
		var formId = 'jUploadForm' + id;		
        // Watch for a new set of requests
        if ( s.global && ! jQuery.active++ )
		{
			jQuery.event.trigger( "ajaxStart" );
		}            
        var requestDone = false;
        // Create the request object
        var xml = {}   
        if ( s.global )
            jQuery.event.trigger("ajaxSend", [xml, s]);
        // Wait for a response to come back
        var uploadCallback = function(isTimeout)
		{			
			var io = document.getElementById(frameId);
            try 
			{				
				if(io.contentWindow)
				{
					 xml.responseText = io.contentWindow.document.body?io.contentWindow.document.body.innerHTML:null;
                	 xml.responseXML = io.contentWindow.document.XMLDocument?io.contentWindow.document.XMLDocument:io.contentWindow.document;
					 
				}else if(io.contentDocument)
				{
					 xml.responseText = io.contentDocument.document.body?io.contentDocument.document.body.innerHTML:null;
                	xml.responseXML = io.contentDocument.document.XMLDocument?io.contentDocument.document.XMLDocument:io.contentDocument.document;
				}						
            }catch(e)
			{
				jQuery.handleError(s, xml, null, e);
			}
            if ( xml || isTimeout == "timeout") 
			{				
                requestDone = true;
                var status;
                try {
                    status = isTimeout != "timeout" ? "success" : "error";
                    // Make sure that the request was successful or notmodified
                    if ( status != "error" )
					{
                        // process the data (runs the xml through httpData regardless of callback)
                        var data = jQuery.uploadHttpData( xml, s.dataType );    
                        // If a local callback was specified, fire it and pass it the data
                        if ( s.success )
                            s.success( data, status );
    
                        // Fire the global callback
                        if( s.global )
                            jQuery.event.trigger( "ajaxSuccess", [xml, s] );
                    } else
                        jQuery.handleError(s, xml, status);
                } catch(e) 
				{
                    status = "error";
                    jQuery.handleError(s, xml, status, e);
                }

                // The request was completed
                if( s.global )
                    jQuery.event.trigger( "ajaxComplete", [xml, s] );

                // Handle the global AJAX counter
                if ( s.global && ! --jQuery.active )
                    jQuery.event.trigger( "ajaxStop" );

                // Process result
                if ( s.complete )
                    s.complete(xml, status);

                jQuery(io).unbind()

                setTimeout(function()
									{	try 
										{
											jQuery(io).remove();
											jQuery(form).remove();	
											
										} catch(e) 
										{
											jQuery.handleError(s, xml, null, e);
										}									

									}, 100)

                xml = null

            }
        }
        // Timeout checker
        if ( s.timeout > 0 ) 
		{
            setTimeout(function(){
                // Check to see if the request is still happening
                if( !requestDone ) uploadCallback( "timeout" );
            }, s.timeout);
        }
        try 
		{

			var form = jQuery('#' + formId);
			jQuery(form).attr('action', s.url);
			jQuery(form).attr('method', 'POST');
			jQuery(form).attr('target', frameId);
            if(form.encoding)
			{
				jQuery(form).attr('encoding', 'multipart/form-data');      			
            }
            else
			{	
				jQuery(form).attr('enctype', 'multipart/form-data');			
            }			
            jQuery(form).submit();

        } catch(e) 
		{			
            jQuery.handleError(s, xml, null, e);
        }
		
		jQuery('#' + frameId).load(uploadCallback	);
        return {abort: function () {}};	

    },

    uploadHttpData: function( r, type ) {
        var data = !type;
        data = type == "xml" || data ? r.responseXML : r.responseText;
        // If the type is "script", eval it in global context
        if ( type == "script" )
            jQuery.globalEval( data );
        // Get the JavaScript object, if JSON is used.
        if ( type == "json" )
            eval( "data = " + data );
        // evaluate scripts within html
        if ( type == "html" )
            jQuery("<div>").html(data).evalScripts();

        return data;
    },
    
	handleError: function( s, xhr, status, e ) {
		// If a local callback was specified, fire it
		if ( s.error ) {
		    s.error.call( s.context || window, xhr, status, e );
		}

		// Fire the global callback
		if ( s.global ) {
		    (s.context ? jQuery(s.context) : jQuery.event).trigger( "ajaxError", [xhr, s, e] );
		}
	}    
})

