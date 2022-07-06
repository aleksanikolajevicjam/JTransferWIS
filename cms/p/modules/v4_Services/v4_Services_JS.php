
<script type="text/javascript">
	//
	// USERS EDIT FORM FUNCTIONS *********************************************************************************
	//

	var data_v4_Services = [];
	

	function editSavev4_ServicePrice(id, inList) { 
		
		
		//if($("#v4_ServicesEditPriceForm"+id).valid() == false) {return false;}
		// default value. inList znaci je li prikaz sa liste ili nije
		if (notDefined(inList)) {inList=true;}

		//var newData = $("#v4_ServicesEditPriceForm"+id).serializeObject();
		//var formData = $("#v4_ServicesEditPriceForm"+id).serialize();
		
		var newPrice = $("#ServicePrice1"+id).val();
		// update data on server
		var url = window.root + '/cms/p/modules/v4_Services/'+
		'v4_Services_Save.php?callback=?&keyName=ServiceID&keyValue='+id+'&ServicePrice1='+ newPrice;
	
		$.ajax({
			type: 'POST',
			url: url,
			async: false,
			//contentType: "application/json",
			dataType: 'jsonp',
			success: function(data, status) {

				// osvjezi podatke na ekranu za zadani element
				//if (inList==true) {
					//refreshv4_ServicesData(id, newData);
					//$(".editFrame").hide('slow'); 
				//}
			},
			error: function(xhr, status, error) {alert("Save error occured: " + xhr.status + " " + xhr.statusText); }
		});

		return false;
	}


	
	function all_v4_Services() {

		// podaci iz input polja - filtriranje
		var where  = $("#whereCondition").val(); // glavni filter koji uvijek radi
	 	var ownerid = $("#OwnerID").val(); // prikazuje samo Usere sa levelom
	 	var filter = $("#Search").val(); // filtrira prema zadanom tekstu
	 	var length = $("#length").val(); // dropdown za broj prikazanih usera na stranici

	 	// advanced search
	 	var sortOrder  = $("#sortOrder").val();
	 	
		var callFunction = 'all_v4_ServicesFilter()'; // funkcija koju paginator poziva kod promjene stranice
	
		// ovo koristi i paginator funkcija!
	 	var recordsTotal = 0;
	 	var page  = $("#pageSelector").val();

		if(typeof page==='undefined') {page=1;}
		if(page<=0) {page=1;}
		//

	 	var url = window.root + '/cms/p/modules/v4_Services/v4_Services_All.php?where='+where+
	 	'&Search='+filter+'&page='+page+'&length='+length+'&sortOrder='+sortOrder+'&OwnerID='+ownerid+'&callback=?';

		$.ajax({
		 type: 'GET',
		  url: url,
		  async: true,
		  contentType: "application/json",
		  dataType: 'jsonp',
		  success: function(v4_ServicesData) {

			  // CUSTOM STUFF
			  // uzmi samo podatke o transferima
			  var data = v4_ServicesData.data;
			  recordsTotal = v4_ServicesData.recordsTotal;
		
			  paginator(page,recordsTotal,length, callFunction);
			  
			  $.each(data, function(i, item) {
				data[i].color ='white';
				//var ts = data[i].TransferStatus;
				//data[i].TransferStatus = statusDescription.status[ts].desc;
			  });

				data_v4_Services = data;
			
				// poziva se handlebars da pripremi prikaz
				// template je u parts/transferList.Driver.php

				var source   = $("#v4_ServicesListTemplate").html();
				var template = Handlebars.compile(source);

				var HTML = template({v4_Services : data_v4_Services});

				$("#show_v4_Services").html(HTML);
		  },
		  error: function() { alert('Get error occured.');}

		});

	}


	function one_v4_Services(id,inList) { 

		// default value. inList znaci je li prikaz sa liste ili nije
		//if (typeof inList === "undefined" || inList === null) { inList = true; }
		if (notDefined(inList)) {inList=true;}

		// click na element - hide element ako je vec prikazan, nema potrebe za ajax
		if(inList==true) {
			if ( $("#v4_ServicesWrapper"+id).css('display') != 'none') {$("#v4_ServicesWrapper"+id).hide('slow'); return;}
		}

		// ako element nije prikazan, uzmi potrebne podatke i prikazi ga
		var url = window.root + '/cms/p/modules/v4_Services/v4_Services_One.php?ServiceID='+id;
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

				var source   = $("#v4_ServicesEditTemplate").html();
				var template = Handlebars.compile(source);

				var HTML = template(data[0]);

				// promjena boje pozadine zadnje gledane plocice
				//if(inList==true) { $("#t_"+id).removeClass('white').addClass('bg-light-blue'); }

				$("#one_v4_Services"+id).html(HTML);

				$("#v4_ServicesWrapper"+id).show('slow');
			},
			error: function(xhr, status, error) {alert("Show error occured: " + xhr.status + " " + xhr.statusText); }
		});
	}


	function new_v4_Services() { 
		var data = {

	 			OwnerID: '',
	 			ServiceID: '',
	 			RouteID: '',
	 			VehicleID: '',
	 			VehicleTypeID: '',
	 			VehicleAvailable: '',
	 			Correction: '',
	 			ServicePrice1: '',
	 			ServicePrice2: '',
	 			ServicePrice3: '',
	 			Discount: '',
	 			ServiceETA: '',
	 			Active: '',
	 			LastChange: ''
			};
				var source   = $("#v4_ServicesEditTemplate").html();
				var template = Handlebars.compile(source);

				var HTML = template(data);

				$("#new_v4_Services").html(HTML);

				$("#v4_ServicesWrapperNew").show('slow');

	}


	function editClosev4_Services(id, inList) {
		if (notDefined(inList)) {inList=true;}
		if (inList==true) { $(".editFrame").hide('slow'); }
		return false;
	}

	
	
	function editSavev4_Services(id, inList) { 
		
		//if($("#v4_ServicesEditForm"+id).valid() == false) {return false;}
		// default value. inList znaci je li prikaz sa liste ili nije
		if (notDefined(inList)) {inList=true;}
		var newData = $("#v4_ServicesEditForm"+id).serializeObject();
		var formData = $("#v4_ServicesEditForm"+id).serialize();
		
		if(newData.SurCategory == 4) {editSavev4_SurService();}

		// update data on server
		var url = window.root + '/cms/p/modules/v4_Services/'+
		'v4_Services_Save.php?callback=?&keyName=ServiceID&keyValue='+id+'&'+ formData;
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
					refreshv4_ServicesData(id, newData);
					$(".editFrame").hide('slow');
				}
			},
			error: function(xhr, status, error) {alert("Save error occured: " + xhr.status + " " + xhr.statusText); }
		});

		return false;
	}

	function deletev4_Services(id, inList) { 

		if (notDefined(inList)) {inList=true;}

		var newData = $("#v4_ServicesEditForm"+id).serializeObject();
		var formData = $("#v4_ServicesEditForm"+id).serialize();

		// update data on server
		var url = window.root + '/cms/p/modules/v4_Services/'+
		'v4_Services_Delete.php?ServiceID='+ id+'&'+formData+'&callback=?';
	
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
					all_v4_Services();
					//refreshUserData(id, newData);
				}
				$(".editFrame").hide('slow');
			},
			error: function(xhr, status, error) {alert("Delete error occured: " + xhr.status + " " + xhr.statusText+" "); }
		});

		return false;
	}


	function editPrintv4_Services(id, inList) {
		// default value. inList znaci je li prikaz sa liste ili nije
		if (notDefined(inList)) {inList=true;}

	  	if(inList==true) { $(".editFrame").hide('slow'); }
	  	alert('Printed');
	  	
	  return false;
	}


	/* trazenje elementa object array-a i refresh liste transfera */
	function refreshv4_ServicesData(id, newData) {

	  var result = $.grep(data_v4_Services, function(e){ return e.ServiceID == id; });

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

		    changeall_v4_Services(id, ress);

		    data = data_v4_Services;

		    var source   = $("#v4_ServicesListTemplate").html();
		    var template = Handlebars.compile(source);

		    var HTML = template({v4_Services : data});

		    $("#show_v4_Services").html(HTML);

	  } else {
		// multiple items found
	  }

	}

	/* promjena cijelog sloga datoteke odjednom */
	function changeall_v4_Services( id, sve ) {
	   for (var i in data_v4_Services) {
		 if (data_v4_Services[i].ServiceID == id) {
		    data_v4_Services[i] = sve;
		    break; //Stop this loop, we found it!
		 }
	   }
	}
	
	//$("input.old").live('focus', function() { $(this).select(); });
	
	function serviceSurcharges(id) {
		var formData = $("#v4_ServicesEditForm"+id).serialize();
		var newData = $("#v4_ServicesEditForm"+id).serializeObject();

		if(newData.SurCategory == 1) {
			// Global surcharges
			var url = window.root + '/cms/p/modules/v4_SurGlobal/'+
			'v4_SurGlobal.Display.Form.php?OwnerID='+newData.OwnerID+'&'+formData;
			console.log(url);
			$.ajax({
				type: 'GET',
				url: url,
				async: false,
				//contentType: "application/json",
				//dataType: 'jsonp',
				success: function(data) {

					$("#serviceSurcharges"+id).html(data);
					$("#serviceSurcharges"+id).show('slow');

				},
				error: function(xhr, status, error) {alert("Error occured: " + xhr.status + " " + xhr.statusText+" "); }
			});
		} 
		
		if(newData.SurCategory== 2) {
			// Vehicle specific surcharges
			var url = window.root + '/cms/p/modules/v4_SurVehicle/'+
			'v4_SurVehicle.Display.Form.php?OwnerID='+newData.OwnerID+'&VehicleID='+newData.VehicleID
			+'&'+formData;		
			$.ajax({
				type: 'GET',
				url: url,
				async: false,
				//contentType: "application/json",
				//dataType: 'jsonp',
				success: function(data) {

					$("#serviceSurcharges"+id).html(data);
					$("#serviceSurcharges"+id).show('slow');

				},
				error: function(xhr, status, error) {alert("Error occured: " + xhr.status + " " + xhr.statusText+" "); }
			});
		}

		if(newData.SurCategory== 3) {
			// Route specific surcharges
			var url = window.root + '/cms/p/modules/v4_SurRoute/'+
			'v4_SurRoute.Display.Form.php?OwnerID='+newData.OwnerID+'&RouteID='+newData.RouteID
			+'&'+formData;		
			$.ajax({
				type: 'GET',
				url: url,
				async: false,
				//contentType: "application/json",
				//dataType: 'jsonp',
				success: function(data) {

					$("#serviceSurcharges"+id).html(data);
					$("#serviceSurcharges"+id).show('slow');

				},
				error: function(xhr, status, error) {alert("Error occured: " + xhr.status + " " + xhr.statusText+" "); }
			});
		}



		if(newData.SurCategory== 4) {
			// Service specific surcharges
			var url = window.root + '/cms/p/modules/v4_Services/'+
			'v4_SurService.Edit.Form.php?ServiceID='+newData.ServiceID+'&'+formData;
			$.ajax({
				type: 'GET',
				url: url,
				async: false,
				//contentType: "application/json",
				//dataType: 'jsonp',
				success: function(data) {
					$("#serviceSurcharges"+id).html(data);
					$("#serviceSurcharges"+id).show('slow');

				},
				error: function(xhr, status, error) {alert("Error occured: " + xhr.status + " " + xhr.statusText+" "); }
			});
		}

		
		if(newData.SurCategory == 0) {
			// nema surcharges. Ako ih je bilo, trebalo bi ih izbrisati?
			$("#serviceSurcharges"+id).hide('slow');
			$("#serviceSurcharges"+id).html('');
		}
	}
	
	
	
	function editSavev4_SurService() { 
	
		var newData = $("#v4_SurServiceEditForm").serializeObject();
		var formData = $("#v4_SurServiceEditForm").serialize();

		// update data on server
		var url = window.root + '/cms/p/modules/v4_SurService/'+
		'v4_SurService_Save.php?callback=?&keyName=ServiceID&keyValue='+newData.ServiceID+'&'+ formData;
	
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
	
	
	function togglePrices(status) {
		
		var ownerID = $("#OwnerID").val();

		// update data on server
		var url = window.root + '/cms/p/modules/v4_Services/'+
		'v4_ServicesToggle.php?callback=?&OwnerID='+ownerID+'&status='+status;
	
		$.ajax({
			type: 'POST',
			url: url,
			async: false,
			//contentType: "application/json",
			dataType: 'jsonp',
			success: function(data, status) {

				$("#togglePrices").html(data.updated);

			},
			error: function(xhr, status, error) {alert("Error occured: " + xhr.status + " " + xhr.statusText); }
		});

		return true;		
	}
</script>

