	var data_Items = [];
	window.base='http://localhost/jamtransfer/';
	function allItems() {
		// podaci iz input polja - filtriranje
		var where  = $("#whereCondition").val(); // glavni filter koji uvijek radi
	 	var status = $("#Type").val(); // prikazuje po tipu	
		
	 	var active = $("#Active").val(); // prikazuje samo aktivne	
	 	var filter = $("#Search").val(); // filtrira prema zadanom tekstu
	 	var length = $("#length").val(); // dropdown za broj prikazanih usera na stranici
	 	var transfersFilter = $("#transfersFilter").val(); // filter za transfere
	 	var orderid = $("#orderid").val(); // filter za orderid
	 	var sortOrder  = $("#sortOrder").val();
		
	 	var yearsOrder = $("#yearsOrder").val();
		if (typeof yearsOrder=='undefined') yearsOrder='0';
	 	var yearsPickup = $("#yearsPickup").val();
		if (typeof yearsPickup=='undefined') yearsPickup='0';
		
		
		var callFunction = 'allItems()'; // funkcija koju paginator poziva kod promjene stranice
	
		// ovo koristi i paginator funkcija!
	 	var recordsTotal = 0;
	 	var page  = $("#pageSelector").val();

		if(typeof page==='undefined') {page=1;}
		if(page<=0) {page=1;}

	 	var url = window.root+'All.php?where='+where+'&Type='+status+'&Active='+active+
	 	'&Search='+filter+'&page='+page+'&length='+length+'&sortOrder='+sortOrder+
		'&transfersFilter='+transfersFilter+
		'&orderid='+orderid+
		'&yearsOrder='+yearsOrder+
		'&yearsPickup='+yearsPickup+
		'&callback=?';
		console.log(window.base+url);
		$.ajax({
		 type: 'GET',
		  url: url,
		  async: false,
		  contentType: "application/json",
		  dataType: 'jsonp',
		  success: function(ItemsData) {

			  // CUSTOM STUFF
			  // uzmi samo podatke o itemima
			  var data = ItemsData.data;
			  recordsTotal = ItemsData.recordsTotal;
			  paginator(page,recordsTotal,length, callFunction);
			  $.each(data, function(i, item) {
				data[i].color ='white';
			  });
				data_Items = data;
				// poziva se handlebars da pripremi prikaz
				var source   = $("#ItemListTemplate").html();
				var template = Handlebars.compile(source);

				var HTML = template({Item : data_Items});

				$("#show_Items").html(HTML);
				
			  if (ItemsData.yearsOrder ) {
				  var yearsOrderArr = ItemsData.yearsOrder;
				  $.each(yearsOrderArr, function(i, item) {
					    $('#yearsOrder').append('<option value="'+yearsOrderArr[i]+'">'+yearsOrderArr[i]+'</option>');
					});
					$("#yearsOrder option[value="+yearsOrder+"]").prop("selected", true)
			  }				  
			  if (ItemsData.yearsPickup ) {
				  var yearsPickupArr = ItemsData.yearsPickup;
				  $.each(yearsPickupArr, function(i, item) {
					    $('#yearsPickup').append('<option value="'+yearsPickupArr[i]+'">'+yearsPickupArr[i]+'</option>');
					});
					$("#yearsPickup option[value="+yearsPickup+"]").prop("selected", true)
			  }				
		  },
		  error: function() { alert('Get error occured.');}
		});
	}

	function oneItem(id) { 

		// click na element - hide element ako je vec prikazan, nema potrebe za ajax
		if ( $("#ItemWrapper"+id).css('display') != 'none') {$("#ItemWrapper"+id).hide('slow'); return;}

		// ako element nije prikazan, uzmi potrebne podatke i prikazi ga
		var url = window.root + 'One.php?ItemID='+id;
		// sakrij sve ostale elemente prije nego se otvori novi
		$(".editFrame").hide('slow'); $(".editFrame form").html('');
		// idemo po podatke
		console.log(window.base+url);		
		$.ajax({
			type: 'GET',
			url: url,
			async: false,
			contentType: "application/json",
			dataType: 'jsonp',
			success: function(data) {

				// CUSTOM STUFF
				$('.bg-light-blue').removeClass('bg-light-blue').addClass('white');

				var source   = $("#ItemEditTemplate").html();
				var template = Handlebars.compile(source);

				var HTML = template(data[0]);

				// promjena boje pozadine zadnje gledane plocice
				$("#t_"+id).removeClass('white').addClass('bg-light-blue');

				$("#one_Item"+id).html(HTML);

				$("#ItemWrapper"+id).show('slow');
				$("#ItemWrapper"+id)[0].scrollIntoView({
					behavior: "smooth", // or "auto" or "instant"
					block: "start" // or "end"
				});				
			},
			error: function(xhr, status, error) {alert("Show error occured: " + xhr.status + " " + xhr.statusText); }
		});
	}
	function new_Item() { 
		var source   = $("#ItemEditTemplate").html();
		var template = Handlebars.compile(source);
		var HTML = template();
		$("#new_Item").html(HTML);
		$("#ItemWrapperNew").show('slow');
	}


	function editCloseItem(id) {
		$(".editFrame").hide('slow');$(".editFrame form").html(''); 
		return false;
	}

	function editSaveItem(id) {
		if($("#ItemEditForm"+id).valid() == false) {return false;}
		var newData = $("#ItemEditForm"+id).serializeObject();
		var formData = $("#ItemEditForm"+id).serialize();
		// update data on server
		var url = window.root + 'Save.php?callback=?&id=' + id + '&' + formData;
		console.log(window.base+url);		
		$.ajax({
			type: 'POST',
			url: url,
			async: false,
			//contentType: "application/json",
			dataType: 'jsonp',
			success: function(data, status) {
				$("#statusMessage").html('<i class="ic-checkmark-circle s"></i> ');
				// osvjezi podatke na ekranu za zadani element
				if (id == '') {
					alert ('New Item created');
					window.location.href = window.currenturl;
				}	
				else allItems();
				$(".editFrame").hide('slow');
				$(".editFrame form").html('');
			},
			error: function(xhr, status, error) {alert("Save error occured: " + xhr.status + " " + xhr.statusText); }
		});
		return false;
	}

	function deleteItem(id) { 
		// update data on server
		var url = window.root + 'Delete.php?ID='+ id+'&'+'&callback=?';
		console.log(window.base+url);
		$.ajax({
			type: 'GET',
			url: url,
			async: false,
			//contentType: "application/json",
			dataType: 'jsonp',
			success: function(data) {

				$("#statusMessage").html('<i class="ic-checkmark-circle s"></i> ');

				// osvjezi podatke na ekranu za zadani element
				allItems();
				$(".editFrame").hide('slow');
				$(".editFrame form").html('');
			},
			error: function(xhr, status, error) {alert("Delete error occured: " + xhr.status + " " + xhr.statusText+" "); }
		});
		return false;
	}

	function setDriverItem(id) {
		var url = window.root + 'SetForDriver.php?ID='+ id+'&'+'&callback=?';
		console.log(window.base+url);
		$.ajax({
			type: 'GET',
			url: url,
			async: false,
			//contentType: "application/json",
			dataType: 'jsonp',
			success: function(data) {

				$("#statusMessage").html('<i class="ic-checkmark-circle s"></i> ');

				// osvjezi podatke na ekranu za zadani element
				allItems();
				$(".editFrame").hide('slow');
				$(".editFrame form").html('');
			},
			error: function(xhr, status, error) {alert("Delete error occured: " + xhr.status + " " + xhr.statusText+" "); }
		});
		return false;
	}	
	function editSaveTerminal(placeid, driverid) { 
		// update data on server
		var url = window.root + 'SaveTerminal.php?PlaceID='+placeid+'&DriverID='+ driverid;
		console.log(window.base+url);		
		$.ajax({
			type: 'POST',
			url: url,
			async: false,
			contentType: "application/json",
			dataType: 'jsonp',
			success: function(data, status) {
				if(data.update == 'Exist') {alert ("This place already connected to driver")}
				else {alert ("This place connected to driver")}
			},
			error: function(xhr, status, error) {alert("Save error occured: " + xhr.status + " " + xhr.statusText); }
		});

		return false;
	}	
	function approveReview (id, val,button) {
		var url= window.root + "ajax_updateApproved.php";
		console.log(window.base+url);		
		$.ajax({
			url: url,
			type: "POST",
			data: {
				ID: id,
				value: val
			},
			success: function (result) {
				if (result==1) var savefield='Approve';
				else var savefield='Discard';
				document.getElementById("buttons_"+id).innerHTML = savefield;
			}
		});
	}	