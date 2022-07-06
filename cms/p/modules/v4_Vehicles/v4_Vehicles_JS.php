
<script type="text/javascript">
	//
	// USERS EDIT FORM FUNCTIONS *********************************************************************************
	//

	var data_v4_Vehicles = [];
	function all_v4_Vehicles() {

		// podaci iz input polja - filtriranje
		var where  = $("#whereCondition").val(); // glavni filter koji uvijek radi
	 	var ownerId = $("#OwnerID").val(); // prikazuje samo Usere sa levelom
	 	var filter = $("#Search").val(); // filtrira prema zadanom tekstu
	 	var length = $("#length").val(); // dropdown za broj prikazanih usera na stranici

	 	// advanced search
	 	var sortOrder  = $("#sortOrder").val();
	 	
		var callFunction = 'all_v4_VehiclesFilter()'; // funkcija koju paginator poziva kod promjene stranice
	
		// ovo koristi i paginator funkcija!
	 	var recordsTotal = 0;
	 	var page  = $("#pageSelector").val();

		if(typeof page==='undefined') {page=1;}
		if(page<=0) {page=1;}
		//

	 	var url = window.root + '/cms/p/modules/v4_Vehicles/v4_Vehicles_All.php?where='+where+
	 	'&Search='+filter+'&page='+page+'&length='+length+'&sortOrder='+sortOrder+'&OwnerID='+ownerId+'&callback=?';

		$.ajax({
		 type: 'GET',
		  url: url,
		  async: false,
		  contentType: "application/json",
		  dataType: 'jsonp',
		  success: function(v4_VehiclesData) {

			  // CUSTOM STUFF
			  // uzmi samo podatke o transferima
			  var data = v4_VehiclesData.data;
			  recordsTotal = v4_VehiclesData.recordsTotal;
		
			  paginator(page,recordsTotal,length, callFunction);
			  
			  $.each(data, function(i, item) {
				data[i].color ='white';
				//var ts = data[i].TransferStatus;
				//data[i].TransferStatus = statusDescription.status[ts].desc;
			  });

				data_v4_Vehicles = data;
			
				// poziva se handlebars da pripremi prikaz
				// template je u parts/transferList.Driver.php

				var source   = $("#v4_VehiclesListTemplate").html();
				var template = Handlebars.compile(source);

				var HTML = template({v4_Vehicles : data_v4_Vehicles});

				$("#show_v4_Vehicles").html(HTML);
		  },
		  error: function() { alert('Get error occured.');}

		});

	}


	function one_v4_Vehicles(id,inList) { 

		// default value. inList znaci je li prikaz sa liste ili nije
		//if (typeof inList === "undefined" || inList === null) { inList = true; }
		if (notDefined(inList)) {inList=true;}

		// click na element - hide element ako je vec prikazan, nema potrebe za ajax
		if(inList==true) {
			if ( $("#v4_VehiclesWrapper"+id).css('display') != 'none') {$("#v4_VehiclesWrapper"+id).hide('slow'); return;}
		}

		// ako element nije prikazan, uzmi potrebne podatke i prikazi ga
		var url = window.root + '/cms/p/modules/v4_Vehicles/v4_Vehicles_One.php?VehicleID='+id;

		// sakrij sve ostale elemente prije nego se otvori novi
		if(inList==true) { $(".editFrame").hide('slow'); $(".editFrame form").html('');}

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

				var source   = $("#v4_VehiclesEditTemplate").html();
				var template = Handlebars.compile(source);

				var HTML = template(data[0]);

				// promjena boje pozadine zadnje gledane plocice
				if(inList==true) { $("#t_"+id).removeClass('white').addClass('bg-light-blue'); }

				$("#one_v4_Vehicles"+id).html(HTML);

				$("#v4_VehiclesWrapper"+id).show('slow');
			},
			error: function(xhr, status, error) {alert("Show error occured: " + xhr.status + " " + xhr.statusText); }
		});
	}


	function new_v4_Vehicles() { 
		var data = {

	 			VehicleID: '',
	 			OwnerID: '',
	 			VehicleName: '',
	 			VehicleTypeID: '',
	 			SurCategory: '',
	 			SurID: '',
	 			PriceKm: '',
	 			ReturnDiscount: '',
	 			VehicleDescription: '',
	 			VehicleCapacity: '',
	 			VehicleImage: '',
	 			VehicleImage2: '',
	 			VehicleImage3: '',
	 			VehicleImage4: '',
	 			AirCondition: '',
	 			ChildSeat: '',
	 			Music: '',
	 			TV: '',
	 			GPS: ''
			};
				var source   = $("#v4_VehiclesEditTemplate").html();
				var template = Handlebars.compile(source);

				var HTML = template(data);

				$("#new_v4_Vehicles").html(HTML);

				$("#v4_VehiclesWrapperNew").show('slow');

	}


	function editClosev4_Vehicles(id, inList) {
		if (notDefined(inList)) {inList=true;}
		if (inList==true) { $(".editFrame").hide('slow');$(".editFrame form").html(''); }
		return false;
	}

	function editSavev4_Vehicles(id, inList) { 
	
		//if($("#v4_VehiclesEditForm"+id).valid() == false) {return false;}
		// default value. inList znaci je li prikaz sa liste ili nije
		if (notDefined(inList)) {inList=true;}

		var newData = $("#v4_VehiclesEditForm"+id).serializeObject();
		var formData = $("#v4_VehiclesEditForm"+id).serialize();

		// update SurVehicle
		if(newData.SurCategory == 2) {editSavev4_SurVehicle();}

		// update data on server
		var url = window.root + '/cms/p/modules/v4_Vehicles/'+
		'v4_Vehicles_Save.php?callback=?&keyName=VehicleID&keyValue='+id+'&'+ formData;
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
					refreshv4_VehiclesData(id, newData);
					$(".editFrame").hide('slow');
					$(".editFrame form").html('');
				}
			},
			error: function(xhr, status, error) {alert("Save error occured: " + xhr.status + " " + xhr.statusText); }
		});

		return false;
	}

	function deletev4_Vehicles(id, inList) { 

		if (notDefined(inList)) {inList=true;}

		var newData = $("#v4_VehiclesEditForm"+id).serializeObject();
		var formData = $("#v4_VehiclesEditForm"+id).serialize();

		// update data on server
		var url = window.root + '/cms/p/modules/v4_Vehicles/'+
		'v4_Vehicles_Delete.php?VehicleID='+ id+'&'+formData+'&callback=?';
	
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
					all_v4_Vehicles();
					//refreshUserData(id, newData);
				}
				$(".editFrame").hide('slow');
				$(".editFrame form").html('');
			},
			error: function(xhr, status, error) {alert("Delete error occured: " + xhr.status + " " + xhr.statusText+" "); }
		});

		return false;
	}


	function editPrintv4_Vehicles(id, inList) {
		// default value. inList znaci je li prikaz sa liste ili nije
		if (notDefined(inList)) {inList=true;}

	  	if(inList==true) { $(".editFrame").hide('slow'); $(".editFrame form").html('');}
	  	alert('Printed');
	  	
	  return false;
	}


	/* trazenje elementa object array-a i refresh liste transfera */
	function refreshv4_VehiclesData(id, newData) {

	  var result = $.grep(data_v4_Vehicles, function(e){ return e.VehicleID == id; });

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

		    changeall_v4_Vehicles(id, ress);

		    data = data_v4_Vehicles;

		    var source   = $("#v4_VehiclesListTemplate").html();
		    var template = Handlebars.compile(source);

		    var HTML = template({v4_Vehicles : data});

		    $("#show_v4_Vehicles").html(HTML);

	  } else {
		// multiple items found
	  }

	}

	/* promjena cijelog sloga datoteke odjednom */
	function changeall_v4_Vehicles( id, sve ) {
	   for (var i in data_v4_Vehicles) {
		 if (data_v4_Vehicles[i].VehicleID == id) {
		    data_v4_Vehicles[i] = sve;
		    break; //Stop this loop, we found it!
		 }
	   }
	}
	
	
	
	
	function vehicleSurcharges(id) {
		var formData = $("#v4_VehiclesEditForm"+id).serialize();
		var newData = $("#v4_VehiclesEditForm"+id).serializeObject();

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

					$("#vehicleSurcharges"+id).html(data);
					$("#vehicleSurcharges"+id).show('slow');

				},
				error: function(xhr, status, error) {alert("Error occured: " + xhr.status + " " + xhr.statusText+" "); }
			});
		} 
		
		if(newData.SurCategory== 2) {
			// Vehicle specific surcharges
			var url = window.root + '/cms/p/modules/v4_Vehicles/'+
			'v4_SurVehicle.Edit.Form.php?VehicleID='+newData.VehicleID+'&'+formData;		
			$.ajax({
				type: 'GET',
				url: url,
				async: false,
				//contentType: "application/json",
				//dataType: 'jsonp',
				success: function(data) {

					$("#vehicleSurcharges"+id).html(data);
					$("#vehicleSurcharges"+id).show('slow');

				},
				error: function(xhr, status, error) {alert("Error occured: " + xhr.status + " " + xhr.statusText+" "); }
			});
		}
		
		if(newData.SurCategory == 0) {
			// nema surcharges. Ako ih je bilo, trebalo bi ih izbrisati?
			$("#vehicleSurcharges"+id).hide('slow');
			$("#vehicleSurcharges"+id).html('');
		}
	}
	
	
	
	function editSavev4_SurVehicle() { 
	
		var newData = $("#v4_SurVehicleEditForm").serializeObject();
		var formData = $("#v4_SurVehicleEditForm").serialize();

		// update data on server
		var url = window.root + '/cms/p/modules/v4_SurVehicle/'+
		'v4_SurVehicle_Save.php?callback=?VehicleID='+newData.VehicleID+'&'+ formData;
	
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
</script>			
		
