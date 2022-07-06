
<script type="text/javascript">
	//
	// USERS EDIT FORM FUNCTIONS *********************************************************************************
	//

	var data_v4_SurRoute = [];
	function all_v4_SurRoute() {

		// podaci iz input polja - filtriranje
		var where  = $("#whereCondition").val(); // glavni filter koji uvijek radi
	 	//var status = $("#UserLevel").val(); // prikazuje samo Usere sa levelom
	 	var filter = $("#Search").val(); // filtrira prema zadanom tekstu
	 	var length = $("#length").val(); // dropdown za broj prikazanih usera na stranici

	 	// advanced search
	 	var sortOrder  = $("#sortOrder").val();
	 	
		var callFunction = 'all_v4_SurRouteFilter()'; // funkcija koju paginator poziva kod promjene stranice
	
		// ovo koristi i paginator funkcija!
	 	var recordsTotal = 0;
	 	var page  = $("#pageSelector").val();

		if(typeof page==='undefined') {page=1;}
		if(page<=0) {page=1;}
		//

	 	var url = window.root + '/cms/p/modules/v4_SurRoute/v4_SurRoute_All.php?where='+where+
	 	'&Search='+filter+'&page='+page+'&length='+length+'&sortOrder='+sortOrder+'&callback=?';

		$.ajax({
		 type: 'GET',
		  url: url,
		  async: false,
		  contentType: "application/json",
		  dataType: 'jsonp',
		  success: function(v4_SurRouteData) {

			  // CUSTOM STUFF
			  // uzmi samo podatke o transferima
			  var data = v4_SurRouteData.data;
			  recordsTotal = v4_SurRouteData.recordsTotal;
		
			  paginator(page,recordsTotal,length, callFunction);
			  
			  $.each(data, function(i, item) {
				data[i].color ='white';
				//var ts = data[i].TransferStatus;
				//data[i].TransferStatus = statusDescription.status[ts].desc;
			  });

				data_v4_SurRoute = data;
			
				// poziva se handlebars da pripremi prikaz
				// template je u parts/transferList.Driver.php

				var source   = $("#v4_SurRouteListTemplate").html();
				var template = Handlebars.compile(source);

				var HTML = template({v4_SurRoute : data_v4_SurRoute});

				$("#show_v4_SurRoute").html(HTML);
		  },
		  error: function() { alert('Get error occured.');}

		});

	}


	function one_v4_SurRoute(id,inList) { 

		// default value. inList znaci je li prikaz sa liste ili nije
		//if (typeof inList === "undefined" || inList === null) { inList = true; }
		if (notDefined(inList)) {inList=true;}

		// click na element - hide element ako je vec prikazan, nema potrebe za ajax
		if(inList==true) {
			if ( $("#v4_SurRouteWrapper"+id).css('display') != 'none') {$("#v4_SurRouteWrapper"+id).hide('slow'); return;}
		}

		// ako element nije prikazan, uzmi potrebne podatke i prikazi ga
		var url = window.root + '/cms/p/modules/v4_SurRoute/v4_SurRoute_One.php?ID='+id;

		// sakrij sve ostale elemente prije nego se otvori novi
		if(inList==true) { $(".editFrame").hide('slow'); }

		// idemo po podatke
		$.ajax({
			type: 'GET',
			url: url,
			async: false,
			contentType: "application/json",
			dataType: 'jsonp',
			success: function(data) {

				// CUSTOM STUFF
				if(inList==true) {
					$.each(data, function(i, item) {
						data[i].color ='white';
					});
				}

				var source   = $("#v4_SurRouteEditTemplate").html();
				var template = Handlebars.compile(source);

				var HTML = template(data[0]);

				// promjena boje pozadine zadnje gledane plocice
				if(inList==true) { $("#t_"+id).removeClass('white').addClass('bg-light-blue'); }

				$("#one_v4_SurRoute"+id).html(HTML);

				$("#v4_SurRouteWrapper"+id).show('slow');
			},
			error: function(xhr, status, error) {alert("Show error occured: " + xhr.status + " " + xhr.statusText); }
		});
	}


	function new_v4_SurRoute() { 
		var data = {

	 			ID: '',
	 			SiteID: '',
	 			OwnerID: '',
	 			DriverRouteID: '',
	 			NightStart: '',
	 			NightEnd: '',
	 			NightPercent: '',
	 			NightAmount: '',
	 			WeekendPercent: '',
	 			WeekendAmount: '',
	 			MonPercent: '',
	 			MonAmount: '',
	 			TuePercent: '',
	 			TueAmount: '',
	 			WedPercent: '',
	 			WedAmount: '',
	 			ThuPercent: '',
	 			ThuAmount: '',
	 			FriPercent: '',
	 			FriAmount: '',
	 			SatPercent: '',
	 			SatAmount: '',
	 			SunPercent: '',
	 			SunAmount: '',
	 			S1Start: '',
	 			S1End: '',
	 			S1Percent: '',
	 			S2Start: '',
	 			S2End: '',
	 			S2Percent: '',
	 			S3Start: '',
	 			S3End: '',
	 			S3Percent: '',
	 			S4Start: '',
	 			S4End: '',
	 			S4Percent: '',
	 			S5Start: '',
	 			S5End: '',
	 			S5Percent: '',
	 			S6Start: '',
	 			S6End: '',
	 			S6Percent: '',
	 			S7Start: '',
	 			S7End: '',
	 			S7Percent: '',
	 			S8Start: '',
	 			S8End: '',
	 			S8Percent: '',
	 			S9Start: '',
	 			S9End: '',
	 			S9Percent: '',
	 			S10Start: '',
	 			S10End: '',
	 			S10Percent: ''		 			
			};
				var source   = $("#v4_SurRouteEditTemplate").html();
				var template = Handlebars.compile(source);

				var HTML = template(data);

				$("#new_v4_SurRoute").html(HTML);

				$("#v4_SurRouteWrapperNew").show('slow');

	}


	function editClosev4_SurRoute(id, inList) {
		if (notDefined(inList)) {inList=true;}
		if (inList==true) { $(".editFrame").hide('slow'); }
		return false;
	}

	function editSavev4_SurRoute(id, inList) { 
	
		if($("#v4_SurRouteEditForm"+id).valid() == false) {return false;}
		// default value. inList znaci je li prikaz sa liste ili nije
		if (notDefined(inList)) {inList=true;}

		var newData = $("#v4_SurRouteEditForm"+id).serializeObject();
		var formData = $("#v4_SurRouteEditForm"+id).serialize();

		// update data on server
		var url = window.root + '/cms/p/modules/v4_SurRoute/'+
		'v4_SurRoute_Save.php?callback=?&keyName=ID&keyValue='+id+'&'+ formData;
	
		$.ajax({
			type: 'POST',
			url: url,
			async: false,
			//contentType: "application/json",
			dataType: 'jsonp',
			success: function(data, status) {

				$("#statusMessage").html('<i class="ic-checkmark-circle s"></i> ');

				// osvjezi podatke na ekranu za zadani element
				if (inList==true) {
					refreshv4_SurRouteData(id, newData);
					$(".editFrame").hide('slow');
				}
			},
			error: function(xhr, status, error) {alert("Save error occured: " + xhr.status + " " + xhr.statusText); }
		});

		return false;
	}

	function deletev4_SurRoute(id, inList) { 

		if (notDefined(inList)) {inList=true;}

		var newData = $("#v4_SurRouteEditForm"+id).serializeObject();
		var formData = $("#v4_SurRouteEditForm"+id).serialize();

		// update data on server
		var url = window.root + '/cms/p/modules/v4_SurRoute/'+
		'v4_SurRoute_Delete.php?ID='+ id+'&'+formData+'&callback=?';
	
		$.ajax({
			type: 'GET',
			url: url,
			async: false,
			//contentType: "application/json",
			dataType: 'jsonp',
			success: function(data) {

				$("#statusMessage").html('<i class="ic-checkmark-circle s"></i> ');

				// osvjezi podatke na ekranu za zadani element
				if (inList==true) {
					all_v4_SurRoute();
					//refreshUserData(id, newData);
				}
				$(".editFrame").hide('slow');
			},
			error: function(xhr, status, error) {alert("Delete error occured: " + xhr.status + " " + xhr.statusText+" "); }
		});

		return false;
	}


	function editPrintv4_SurRoute(id, inList) {
		// default value. inList znaci je li prikaz sa liste ili nije
		if (notDefined(inList)) {inList=true;}

	  	if(inList==true) { $(".editFrame").hide('slow'); }
	  	alert('Printed');
	  	
	  return false;
	}


	/* trazenje elementa object array-a i refresh liste transfera */
	function refreshv4_SurRouteData(id, newData) {

	  var result = $.grep(data_v4_SurRoute, function(e){ return e.ID == id; });

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

		    ress.color = 'orange-2';

		    changeall_v4_SurRoute(id, ress);

		    data = data_v4_SurRoute;

		    var source   = $("#v4_SurRouteListTemplate").html();
		    var template = Handlebars.compile(source);

		    var HTML = template({v4_SurRoute : data});

		    $("#show_v4_SurRoute").html(HTML);

	  } else {
		// multiple items found
	  }

	}

	/* promjena cijelog sloga datoteke odjednom */
	function changeall_v4_SurRoute( id, sve ) {
	   for (var i in data_v4_SurRoute) {
		 if (data_v4_SurRoute[i].ID == id) {
		    data_v4_SurRoute[i] = sve;
		    break; //Stop this loop, we found it!
		 }
	   }
	}
</script>			
		
