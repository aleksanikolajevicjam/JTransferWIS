
<script type="text/javascript">
	//
	// USERS EDIT FORM FUNCTIONS *********************************************************************************
	//

	var data_v4_DriverRoutes = [];
	function all_v4_DriverRoutes() {

		// podaci iz input polja - filtriranje
		var where  = $("#whereCondition").val(); // glavni filter koji uvijek radi
	 	var ownerid = $("#OwnerID").val(); // prikazuje samo Usere sa levelom
	 	var filter = $("#Search").val(); // filtrira prema zadanom tekstu
	 	var length = $("#length").val(); // dropdown za broj prikazanih usera na stranici

	 	// advanced search
	 	var sortOrder  = $("#sortOrder").val();
	 	
		var callFunction = 'all_v4_DriverRoutesFilter()'; // funkcija koju paginator poziva kod promjene stranice
	
		// ovo koristi i paginator funkcija!
	 	var recordsTotal = 0;
	 	var page  = $("#pageSelector").val();

		if(typeof page==='undefined') {page=1;}
		if(page<=0) {page=1;}
		//

	 	var url = window.root + '/cms/p/modules/v4_DriverRoutes/v4_DriverRoutes_All.php?where='+where+
	 	'&Search='+filter+'&page='+page+'&length='+length+'&sortOrder='+sortOrder+'&ownerId='+ownerid+'&callback=?';

		$.ajax({
		 type: 'GET',
		  url: url,
		  async: false,
		  contentType: "application/json",
		  dataType: 'jsonp',
		  success: function(v4_DriverRoutesData) {

			  // CUSTOM STUFF
			  // uzmi samo podatke o transferima
			  var data = v4_DriverRoutesData.data;
			  recordsTotal = v4_DriverRoutesData.recordsTotal;
		
			  paginator(page,recordsTotal,length, callFunction);
			  
			  $.each(data, function(i, item) {
				data[i].color ='white';
				//var ts = data[i].TransferStatus;
				//data[i].TransferStatus = statusDescription.status[ts].desc;
			  });

				data_v4_DriverRoutes = data;
			
				// poziva se handlebars da pripremi prikaz
				// template je u parts/transferList.Driver.php

				var source   = $("#v4_DriverRoutesListTemplate").html();
				var template = Handlebars.compile(source);

				var HTML = template({v4_DriverRoutes : data_v4_DriverRoutes});

				$("#show_v4_DriverRoutes").html(HTML);
		  },
		  error: function() { alert('Get error occured.');}

		});

	}


	function one_v4_DriverRoutes(id,inList) { 

		// default value. inList znaci je li prikaz sa liste ili nije
		//if (typeof inList === "undefined" || inList === null) { inList = true; }
		if (notDefined(inList)) {inList=true;}

		// click na element - hide element ako je vec prikazan, nema potrebe za ajax
		if(inList==true) {
			if ( $("#v4_DriverRoutesWrapper"+id).css('display') != 'none') {
				$("#v4_DriverRoutesWrapper"+id).hide('slow'); return;
			}
		}

		// ako element nije prikazan, uzmi potrebne podatke i prikazi ga
		var url = window.root + '/cms/p/modules/v4_DriverRoutes/v4_DriverRoutes_One.php?ID='+id;

		// sakrij sve ostale elemente prije nego se otvori novi
		if(inList==true) { $(".editFrame").hide('slow'); $(".editFrame form").html(''); }

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

				var source   = $("#v4_DriverRoutesEditTemplate").html();
				var template = Handlebars.compile(source);

				var HTML = template(data[0]);

				// promjena boje pozadine zadnje gledane plocice
				if(inList==true) { $("#t_"+id).removeClass('white').addClass('bg-light-blue'); }

				$("#one_v4_DriverRoutes"+id).html(HTML);

				$("#v4_DriverRoutesWrapper"+id).show('slow');
			},
			error: function(xhr, status, error) {alert("Show error occured: " + xhr.status + " " + xhr.statusText); }
		});
	}


	function new_v4_DriverRoutes() { 
		var data = {

	 			ID: '',
	 			SiteID: '',
	 			OwnerID: '',
	 			RouteID: '',
	 			Active: '',
	 			Approved: '',
	 			RouteName: '',
	 			OneToTwo: '',
	 			TwoToOne: '',
	 			SurCategory: '',
	 			SurID: ''
			};
				var source   = $("#v4_DriverRoutesEditTemplate").html();
				var template = Handlebars.compile(source);

				var HTML = template(data);

				$("#new_v4_DriverRoutes").html(HTML);

				$("#v4_DriverRoutesWrapperNew").show('slow');

	}


	function editClosev4_DriverRoutes(id, inList) {
		if (notDefined(inList)) {inList=true;}
		if (inList==true) { $(".editFrame").hide('slow'); $(".editFrame form").html(''); }
		return false;
	}

	function editSavev4_DriverRoutes(id, inList) { 
	
		// sprema SurRoute surcharges.
		// radi update ako slog vec postoji ili dodaje novi

		//if($("#v4_DriverRoutesEditForm"+id).valid() == false) {return false;}
		// default value. inList znaci je li prikaz sa liste ili nije
		if (notDefined(inList)) {inList=true;}

		var newData = $("#v4_DriverRoutesEditForm"+id).serializeObject();
		var formData = $("#v4_DriverRoutesEditForm"+id).serialize();

		if(newData.SurCategory == 3) {editSavev4_SurRoute();}

		// update data on server
		var url = window.root + '/cms/p/modules/v4_DriverRoutes/'+
		'v4_DriverRoutes_Save.php?callback=?&'+ formData;
	console.log(url);
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
					refreshv4_DriverRoutesData(id, newData);
					$(".editFrame").hide('slow'); $(".editFrame form").html('');
				}
			},
			error: function(xhr, status, error) {alert("Save error occured: " + xhr.status + " " + xhr.statusText); }
		});

		return false;
	}

	function deletev4_DriverRoutes(id, inList) { 

		if (notDefined(inList)) {inList=true;}

		var newData = $("#v4_DriverRoutesEditForm"+id).serializeObject();
		var formData = $("#v4_DriverRoutesEditForm"+id).serialize();

		// update data on server
		var url = window.root + '/cms/p/modules/v4_DriverRoutes/'+
		'v4_DriverRoutes_Delete.php?ID='+ id+'&'+formData+'&callback=?';
	
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
					all_v4_DriverRoutes();
					//refreshUserData(id, newData);
				}
				$(".editFrame").hide('slow'); $(".editFrame form").html('');
			},
			error: function(xhr, status, error) {alert("Delete error occured: " + xhr.status + " " + xhr.statusText+" "); }
		});

		return false;
	}


	function editPrintv4_DriverRoutes(id, inList) {
		// default value. inList znaci je li prikaz sa liste ili nije
		if (notDefined(inList)) {inList=true;}

	  	if(inList==true) { $(".editFrame").hide('slow'); $(".editFrame form").html('');}
	  	alert('Printed');
	  	
	  return false;
	}


	/* trazenje elementa object array-a i refresh liste transfera */
	function refreshv4_DriverRoutesData(id, newData) {

	  var result = $.grep(data_v4_DriverRoutes, function(e){ return e.ID == id; });

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

		    changeall_v4_DriverRoutes(id, ress);

		    data = data_v4_DriverRoutes;

		    var source   = $("#v4_DriverRoutesListTemplate").html();
		    var template = Handlebars.compile(source);

		    var HTML = template({v4_DriverRoutes : data});

		    $("#show_v4_DriverRoutes").html(HTML);

	  } else {
		// multiple items found
	  }

	}

	/* promjena cijelog sloga datoteke odjednom */
	function changeall_v4_DriverRoutes( id, sve ) {
	   for (var i in data_v4_DriverRoutes) {
		 if (data_v4_DriverRoutes[i].ID == id) {
		    data_v4_DriverRoutes[i] = sve;
		    break; //Stop this loop, we found it!
		 }
	   }
	}
	
	
	
	function routeSurcharges(id) {
		var formData = $("#v4_DriverRoutesEditForm"+id).serialize();
		var newData = $("#v4_DriverRoutesEditForm"+id).serializeObject();

		if(newData.SurCategory == 1) {
			// Global surcharges
			var url = window.root + '/cms/p/modules/v4_SurGlobal/'+
			'v4_SurGlobal.Display.Form.php?OwnerID='+newData.OwnerID+'&'+formData;
			$.ajax({
				type: 'GET',
				url: url,
				async: false,
				//contentType: "application/json",
				//dataType: 'jsonp',
				success: function(data) {

					$("#routeSurcharges"+id).html(data);
					$("#routeSurcharges"+id).show('slow');

				},
				error: function(xhr, status, error) {alert("Error occured: " + xhr.status + " " + xhr.statusText+" "); }
			});
		} 
		
		if(newData.SurCategory== 3) {
			// Route specific surcharges
			var url = window.root + '/cms/p/modules/v4_DriverRoutes/'+
			'v4_SurRoute.Edit.Form.php?OwnerID='+newData.OwnerID+'&'+formData;		
			$.ajax({
				type: 'GET',
				url: url,
				async: false,
				//contentType: "application/json",
				//dataType: 'jsonp',
				success: function(data) {

					$("#routeSurcharges"+id).html(data);
					$("#routeSurcharges"+id).show('slow');

				},
				error: function(xhr, status, error) {alert("Error occured: " + xhr.status + " " + xhr.statusText+" "); }
			});
		}
		
		if(newData.SurCategory == 0) {
			// nema surcharges. Ako ih je bilo, trebalo bi ih izbrisati?
			$("#routeSurcharges"+id).hide('slow');
			$("#routeSurcharges"+id).html('');
		}
	}
	
	
	
	function editSavev4_SurRoute() { 
	
		var newData = $("#v4_SurRouteEditForm").serializeObject();
		var formData = $("#v4_SurRouteEditForm").serialize();

		// update data on server
		var url = window.root + '/cms/p/modules/v4_DriverRoutes/'+
		'v4_SurRoute_Save.php?callback=?&keyName=DriverRouteID&keyValue='+newData.DriverRouteID+'&'+ formData;
	
		$.ajax({
			type: 'POST',
			url: url,
			async: false,
			//contentType: "application/json",
			dataType: 'jsonp',
			success: function(data, status) {

				$("#statusMessage").html('<i class="ic-checkmark-circle s"></i> ');

			},
			error: function(xhr, status, error) {alert("Save error occured: " + xhr.status + " " + xhr.statusText); }
		});

		return true;
	}



function addDriverRoutes(driverId, placeId) {
	
	if(placeId == 0) return false;
	
	if(confirm('Add new Routes ?')) {


		// update data on server
		var url = window.root + '/cms/p/modules/v4_DriverRoutes/'+
		'v4_DriverRoutes_New.php?callback=?&DriverID='+driverId+'&PlaceID='+ placeId;
	
		$.ajax({
			type: 'POST',
			url: url,
			async: false,
			//contentType: "application/json",
			dataType: 'jsonp',
			success: function(data, status) {

				$("#newRoutesAdded").html('<i class="ic-checkmark-circle s"></i> '+ 
				data.routes + '. <?= PLEASE_REFRESH?>');
				$("#newRoutesAdded").show();
			},
			error: function(xhr, status, error) {alert("Save error occured: " + xhr.status + " " + xhr.statusText); }
		});
	}

		//location.reload();
		return false;	
}

function removeDriverRoutes(driverId, placeId) {
	
	if(placeId == 0) return false;
	if(confirm("This will destroy many Routes and Services.\nAre you sure?")) {
		if(confirm("No undo is available.\nAre you absolutely sure?\nLast chance to Cancel!")) {


			// update data on server
			var url = window.root + '/cms/p/modules/v4_DriverRoutes/'+
			'v4_DriverRoutesRemove.php?callback=?&DriverID='+driverId+'&PlaceID='+ placeId;
	
			$.ajax({
				type: 'POST',
				url: url,
				async: false,
				//contentType: "application/json",
				dataType: 'jsonp',
				success: function(data, status) {

					$("#newRoutesAdded").html('<i class="ic-checkmark-circle s"></i> '+ 
					data.routes + '. <?= PLEASE_REFRESH?>');
					$("#newRoutesAdded").show();
				},
				error: function(xhr, status, error) {alert("Error occured: " + xhr.status + " " + xhr.statusText); }
			});
		}
	}

	return false;	
}

function addSingleRoute (driverID, placeFromID, placeToID) {
	// console.log(driverID + "-" + placeFromID + "-" + placeToID);

	if ((placeFromID == 0) || (placeToID == 0)) return false;
	else {
		if (confirm('Add new Route?')) {


			// update data on server
			var url = window.root + '/cms/p/modules/v4_DriverRoutes/'+
			'v4_DriverRoutes_NewSingle.php?callback=?&DriverID='+driverID+'&PlaceFromID='+ placeFromID+'&PlaceToID='+ placeToID;
	
			$.ajax({
				type: 'POST',
				url: url,
				async: false,
				success: function(data, status) {

					$("#newRoutesAdded").html('<i class="ic-checkmark-circle s"></i> '+ 
					data + '. <?= PLEASE_REFRESH?>');
					$("#newRoutesAdded").show();
					// console.log(data);
				},
				error: function(xhr, status, error) {alert("Save error occured: " + xhr.status + " " + xhr.statusText + "." + status + error); }
			});
		}
	}

	return false;
}

function toggleRoutes(status) {
	
	var ownerID = $("#OwnerID").val();

	// update data on server
	var url = window.root + '/cms/p/modules/v4_DriverRoutes/'+
	'v4_DriverRoutesToggle.php?callback=?&OwnerID='+ownerID+'&status='+status;

	$.ajax({
		type: 'POST',
		url: url,
		async: false,
		//contentType: "application/json",
		dataType: 'jsonp',
		success: function(data, status) {

			$("#toggleRoutes").html(data.updated);

		},
		error: function(xhr, status, error) {alert("Error occured: " + xhr.status + " " + xhr.statusText); }
	});

	return true;		
}	
</script>

