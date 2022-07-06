<script type="text/javascript">
	//
	// USERS EDIT FORM FUNCTIONS *********************************************************************************
	//

	var data_v4_VehicleEquipmentList = [];
	function all_v4_VehicleEquipmentList() {

		// podaci iz input polja - filtriranje
		var VehicleID  = $("#VehicleID").val(); // glavni filter koji uvijek radi

	 	var url = window.root + '/cms/p/modules/v4_VehicleEquipmentList/v4_VehicleEquipmentList_All.php?VehicleID='+VehicleID+'&callback=?';
		$.ajax({
		 type: 'GET',
		  url: url,
		  async: false,
		  contentType: "application/json",
		  dataType: 'jsonp',
		  success: function(v4_VehicleEquipmentListData) {

			  // CUSTOM STUFF
			  // uzmi samo podatke o transferima
			  var data = v4_VehicleEquipmentListData.data;
			  
			  $.each(data, function(i, item) {
				data[i].color ='white';
				//var ts = data[i].TransferStatus;
				//data[i].TransferStatus = statusDescription.status[ts].desc;
			  });

				data_v4_VehicleEquipmentList = data;
			
				// poziva se handlebars da pripremi prikaz
				// template je u parts/transferList.Driver.php

				var source   = $("#v4_VehicleEquipmentListListTemplate").html();
				var template = Handlebars.compile(source);

				var HTML = template({v4_VehicleEquipmentList : data_v4_VehicleEquipmentList});

				$("#show_v4_VehicleEquipmentList").html(HTML);
		  },
		  error: function() { alert('Get error occured.');}

		});

	}


	function one_v4_VehicleEquipmentList(id,inList) { 

		// default value. inList znaci je li prikaz sa liste ili nije
		//if (typeof inList === "undefined" || inList === null) { inList = true; }
		if (notDefined(inList)) {inList=true;}

		// click na element - hide element ako je vec prikazan, nema potrebe za ajax
		if(inList==true) {
			if ( $("#v4_VehicleEquipmentListWrapper"+id).css('display') != 'none') {$("#v4_VehicleEquipmentListWrapper"+id).hide('slow'); return;}
		}

		// ako element nije prikazan, uzmi potrebne podatke i prikazi ga
		var url = window.root + '/cms/p/modules/v4_VehicleEquipmentList/v4_VehicleEquipmentList_One.php?ID='+id;
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

				var source   = $("#v4_VehicleEquipmentListEditTemplate").html();
				var template = Handlebars.compile(source);

				var HTML = template(data[0]);

				// promjena boje pozadine zadnje gledane plocice
				if(inList==true) { $("#t_"+id).removeClass('white').addClass('bg-light-blue'); }

				$("#one_v4_VehicleEquipmentList"+id).html(HTML);

				$("#v4_VehicleEquipmentListWrapper"+id).show('slow');
			},
			error: function(xhr, status, error) {alert("Show error occured: " + xhr.status + " " + xhr.statusText); }
		});
	}


	function new_v4_VehicleEquipmentList() { 
		var data = {
			ID: '',
			OwnerID: '',
			ListID: '',
			Datum: '',
			Expense: '',
			Description: '',
			Amount: '',
			Card: '',
            CurrencyID: '',
            Note: ''
		};
		var source   = $("#v4_VehicleEquipmentListEditTemplate").html();
		var template = Handlebars.compile(source);

		var HTML = template(data);

		$("#new_v4_VehicleEquipmentList").html(HTML);

		$("#v4_VehicleEquipmentListWrapperNew").show('slow');
	}


	function editClosev4_VehicleEquipmentList(id, inList) {
		if (notDefined(inList)) {inList=true;}
		if (inList==true) { $(".editFrame").hide('slow');$(".editFrame form").html(''); }
		return false;
	}

	function editSavev4_VehicleEquipmentList(id, inList) { 
	
		if($("#v4_VehicleEquipmentListEditForm"+id).valid() == false) {return false;}
		// default value. inList znaci je li prikaz sa liste ili nije
		if (notDefined(inList)) {inList=true;}

		var newData = $("#v4_VehicleEquipmentListEditForm"+id).serializeObject();
		var formData = $("#v4_VehicleEquipmentListEditForm"+id).serialize();

		// update data on server
		var url = window.root + '/cms/p/modules/v4_VehicleEquipmentList/'+
		'v4_VehicleEquipmentList_Save.php?callback=?&keyName=ID&keyValue='+id+'&'+ formData;
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
					refreshv4_VehicleEquipmentListData(id, newData);
					$(".editFrame").hide('slow');
					$(".editFrame form").html('');
				}
			},
			error: function(xhr, status, error) {alert("Save error occured: " + xhr.status + " " + xhr.statusText); }
		});

		return false;
	}


	
	function deletev4_VehicleEquipmentList(id, inList) { 

		if (notDefined(inList)) {inList=true;}

		var newData = $("#v4_VehicleEquipmentListEditForm"+id).serializeObject();
		var formData = $("#v4_VehicleEquipmentListEditForm"+id).serialize();

		// update data on server
		var url = window.root + '/cms/p/modules/v4_VehicleEquipmentList/'+
		'v4_VehicleEquipmentList_Delete.php?ID='+ id+'&'+formData+'&callback=?';
	
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
					all_v4_VehicleEquipmentList();
					//refreshUserData(id, newData);
				}
				$(".editFrame").hide('slow');
				$(".editFrame form").html('');
			},
			error: function(xhr, status, error) {alert("Delete error occured: " + xhr.status + " " + xhr.statusText+" "); }
		});

		return false;
	}


	function editPrintv4_VehicleEquipmentList(id, inList) {
		// default value. inList znaci je li prikaz sa liste ili nije
		if (notDefined(inList)) {inList=true;}

	  	if(inList==true) { $(".editFrame").hide('slow'); $(".editFrame form").html('');}
	  	alert('Printed');
	  	
	  return false;
	}


	/* trazenje elementa object array-a i refresh liste transfera */
	function refreshv4_VehicleEquipmentListData(id, newData) {

	  var result = $.grep(data_v4_VehicleEquipmentList, function(e){ return e.ID == id; });

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

		    changeall_v4_VehicleEquipmentList(id, ress);

		    data = data_v4_VehicleEquipmentList;

		    var source   = $("#v4_VehicleEquipmentListListTemplate").html();
		    var template = Handlebars.compile(source);

		    var HTML = template({v4_VehicleEquipmentList : data});

		    $("#show_v4_VehicleEquipmentList").html(HTML);

	  } else {
		// multiple items found
	  }

	}

	/* promjena cijelog sloga datoteke odjednom */
	function changeall_v4_VehicleEquipmentList( id, sve ) {
	   for (var i in data_v4_VehicleEquipmentList) {
		 if (data_v4_VehicleEquipmentList[i].ID == id) {
		    data_v4_VehicleEquipmentList[i] = sve;
		    break; //Stop this loop, we found it!
		 }
	   }
	}
</script>			
		
