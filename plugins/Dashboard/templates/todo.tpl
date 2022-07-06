<div id="showToDo"></div>
 <script> 
 {literal}
 	getTodoData();
	
	function getTodoData() {
		var url = 'api/'+
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




 	function todoItem(action,itemId){
 		var newItem = $("#newItem").val();
		var url = "plugins/todoItems.php?action=" + action +
		"&newItem=" + newItem +
		"&ID=" + itemId +
		"&callback=?";
		$.ajax({
			type: 'POST',
			url: url,
			async: false,
			contentType: "application/json",
			dataType: 'jsonp',
			success: function(data) {
			  var source   = $("#todoTemplate").html();
			  var template = Handlebars.compile(source);
			  var HTML = template({todoItems : data});
			  $("#showToDo").html(HTML);
			}
		});		
 	}
 	
 	function toggleCompleted(cb,id) {
 			todoItem('completed',id);
 	}
	
	function editItem(id) {
		var currentText = $("#taskText"+id).text();
		$(".fa-edit").hide();
		$(".fa-trash-o").hide();
		$("#tools"+id+" .fa-save").show();
		$("#taskText"+id).html('<input type="text" id="newItem" value="'+currentText+'">');
	}
	
	function saveItem(id) {
		todoItem('update',id);
		$(".fa-edit").show();
		$(".fa-trash-o").show();
		$(".fa-save").hide();		
	}
{/literal}	
 </script>
 
 
 
