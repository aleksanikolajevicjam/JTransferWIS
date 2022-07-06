
<script type="text/javascript">
	//
	// USERS EDIT FORM FUNCTIONS *********************************************************************************
	//
	var data_v4_Terminals = [];
	function all_v4_Terminals() {
		// podaci iz input polja - filtriranje
		var where  = $("#whereCondition").val(); // glavni filter koji uvijek radi
	 	var ownerId = $("#DriverID").val(); // prikazuje samo Usere sa levelom
	 	var filter = $("#Search").val(); // filtrira prema zadanom tekstu
	 	var length = $("#length").val(); // dropdown za broj prikazanih usera na stranici

	 	// advanced search
	 	var sortOrder  = $("#sortOrder").val();
	 	
		var callFunction = 'all_v4_TerminalsFilter()'; // funkcija koju paginator poziva kod promjene stranice
	
		// ovo koristi i paginator funkcija!
	 	var recordsTotal = 0;
	 	var page  = $("#pageSelector").val();

		if(typeof page==='undefined') {page=1;}
		if(page<=0) {page=1;}
		//

	 	var url = window.root + '/cms/p/modules/v4_Terminals/v4_Terminals_All.php?where='+where+
	 	'&Search='+filter+'&page='+page+'&length='+length+'&sortOrder='+sortOrder+'&DriverID='+ownerId+'&callback=?';
		$.ajax({
		 type: 'GET',
		  url: url,
		  async: false,
		  contentType: "application/json",
		  dataType: 'jsonp',
		  success: function(v4_TerminalsData) {

			  // CUSTOM STUFF
			  // uzmi samo podatke o transferima
			  var data = v4_TerminalsData.data;
			  recordsTotal = v4_TerminalsData.recordsTotal;
		
			  paginator(page,recordsTotal,length, callFunction);
			  
			  $.each(data, function(i, item) {
				data[i].color ='white';
				//var ts = data[i].TransferStatus;
				//data[i].TransferStatus = statusDescription.status[ts].desc;
			  });

				data_v4_Terminals = data;
				// poziva se handlebars da pripremi prikaz
				// template je u parts/transferList.Driver.php
				var source   = $("#v4_TerminalsListTemplate").html();				
				var template = Handlebars.compile(source);

				var HTML = template({v4_Terminals : data_v4_Terminals});
				$("#show_v4_Terminals").html(HTML);
		  },
		  error: function() { alert('Get error occured.');}

		});

	}


	function one_v4_Terminals(id,id1,inList) { 
		// default value. inList znaci je li prikaz sa liste ili nije
		//if (typeof inList === "undefined" || inList === null) { inList = true; }
		if (notDefined(inList)) {inList=true;}

		// click na element - hide element ako je vec prikazan, nema potrebe za ajax
		if(inList==true) {
			if ( $("#v4_TerminalsWrapper"+id).css('display') != 'none') {$("#v4_TerminalsWrapper"+id).hide('slow'); return;}
		}

		// ako element nije prikazan, uzmi potrebne podatke i prikazi ga
		var url = window.root + '/cms/p/modules/v4_Terminals/v4_Terminals_One.php?TerminalID='+id+'&ID='+id1;
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

				var source   = $("#v4_TerminalsEditTemplate").html();
				var template = Handlebars.compile(source);

				var HTML = template(data[0]);

				// promjena boje pozadine zadnje gledane plocice
				if(inList==true) { $("#t_"+id).removeClass('white').addClass('bg-light-blue'); }

				$("#one_v4_Terminals"+id).html(HTML);

				$("#v4_TerminalsWrapper"+id).show('slow');
			},
			error: function(xhr, status, error) {alert("Show error occured: " + xhr.status + " " + xhr.statusText); }
		});
	}


	function new_v4_Terminals() { 
		var data = {

	 			TerminalID: '',
	 			DriverID: '',
	 			TerminalName: '',
	 			TerminalTypeID: '',
	 			SurCategory: '',
	 			SurID: '',
	 			PriceKm: '',
	 			ReturnDiscount: '',
	 			TerminalDescription: '',
	 			TerminalCapacity: '',
	 			TerminalImage: '',
	 			TerminalImage2: '',
	 			TerminalImage3: '',
	 			TerminalImage4: '',
	 			AirCondition: '',
	 			ChildSeat: '',
	 			Music: '',
	 			TV: '',
	 			GPS: ''
			};
				var source   = $("#v4_TerminalsEditTemplate").html();
				var template = Handlebars.compile(source);

				var HTML = template(data);

				$("#new_v4_Terminals").html(HTML);

				$("#v4_TerminalsWrapperNew").show('slow');

	}


	function editClosev4_Terminals(id, inList) {
		if (notDefined(inList)) {inList=true;}
		if (inList==true) { $(".editFrame").hide('slow');$(".editFrame form").html(''); }
		return false;
	}



	function deletev4_Terminals(id, id1, inList) { 

		if (notDefined(inList)) {inList=true;}

		var newData = $("#v4_TerminalsEditForm"+id).serializeObject();
		var formData = $("#v4_TerminalsEditForm"+id).serialize();

		// update data on server
		var url = window.root + '/cms/p/modules/v4_Terminals/'+
		'v4_Terminals_Delete.php?TerminalID='+ id+'&ID='+id1+'&'+formData+'&callback=?'; 
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
					all_v4_Terminals();
					//refreshUserData(id, newData);
				}
				$(".editFrame").hide('slow');
				$(".editFrame form").html('');
			},
			error: function(xhr, status, error) {alert("Delete error occured: " + xhr.status + " " + xhr.statusText+" "); }
		});

		return false;
	}


	function editPrintv4_Terminals(id, inList) {
		// default value. inList znaci je li prikaz sa liste ili nije
		if (notDefined(inList)) {inList=true;}

	  	if(inList==true) { $(".editFrame").hide('slow'); $(".editFrame form").html('');}
	  	alert('Printed');
	  	
	  return false;
	}


	/* trazenje elementa object array-a i refresh liste transfera */
	function refreshv4_TerminalsData(id, newData) {

	  var result = $.grep(data_v4_Terminals, function(e){ return e.TerminalID == id; });

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

		    changeall_v4_Terminals(id, ress);

		    data = data_v4_Terminals;

		    var source   = $("#v4_TerminalsListTemplate").html();
		    var template = Handlebars.compile(source);

		    var HTML = template({v4_Terminals : data});

		    $("#show_v4_Terminals").html(HTML);

	  } else {
		// multiple items found
	  }

	}

	/* promjena cijelog sloga datoteke odjednom */
	function changeall_v4_Terminals( id, sve ) {
	   for (var i in data_v4_Terminals) {
		 if (data_v4_Terminals[i].TerminalID == id) {
		    data_v4_Terminals[i] = sve;
		    break; //Stop this loop, we found it!
		 }
	   }
	}
	
	
	
	
	function terminalSurcharges(id) {
		var formData = $("#v4_TerminalsEditForm"+id).serialize();
		var newData = $("#v4_TerminalsEditForm"+id).serializeObject();

		if(newData.SurCategory == 1) {
			// Global surcharges
			var url = window.root + '/cms/p/modules/v4_SurGlobal/'+
			'v4_SurGlobal.Display.Form.php?DriverID='+newData.DriverID+'&'+formData;
			$.ajax({
				type: 'GET',
				url: url,
				async: false,
				//contentType: "application/json",
				//dataType: 'jsonp',
				success: function(data) {

					$("#terminalSurcharges"+id).html(data);
					$("#terminalSurcharges"+id).show('slow');

				},
				error: function(xhr, status, error) {alert("Error occured: " + xhr.status + " " + xhr.statusText+" "); }
			});
		} 
		
		if(newData.SurCategory== 2) {
			// Terminal specific surcharges
			var url = window.root + '/cms/p/modules/v4_Terminals/'+
			'v4_SurTerminal.Edit.Form.php?TerminalID='+newData.TerminalID+'&'+formData;		
			$.ajax({
				type: 'GET',
				url: url,
				async: false,
				//contentType: "application/json",
				//dataType: 'jsonp',
				success: function(data) {

					$("#terminalSurcharges"+id).html(data);
					$("#terminalSurcharges"+id).show('slow');

				},
				error: function(xhr, status, error) {alert("Error occured: " + xhr.status + " " + xhr.statusText+" "); }
			});
		}
		
		if(newData.SurCategory == 0) {
			// nema surcharges. Ako ih je bilo, trebalo bi ih izbrisati?
			$("#terminalSurcharges"+id).hide('slow');
			$("#terminalSurcharges"+id).html('');
		}
	}
	
	
	
	function editSavev4_SurTerminal() { 
	
		var newData = $("#v4_SurTerminalEditForm").serializeObject();
		var formData = $("#v4_SurTerminalEditForm").serialize();

		// update data on server
		var url = window.root + '/cms/p/modules/v4_SurTerminal/'+
		'v4_SurTerminal_Save.php?callback=?TerminalID='+newData.TerminalID+'&'+ formData;
	
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
		
