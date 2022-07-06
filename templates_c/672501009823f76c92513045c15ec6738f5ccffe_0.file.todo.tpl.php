<?php
/* Smarty version 3.1.32, created on 2022-06-08 13:51:08
  from 'C:\wamp\www\jamtransfer\plugins\Dashboard\templates\todo.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_62a08d2ce3f907_24201688',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '672501009823f76c92513045c15ec6738f5ccffe' => 
    array (
      0 => 'C:\\wamp\\www\\jamtransfer\\plugins\\Dashboard\\templates\\todo.tpl',
      1 => 1654689063,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_62a08d2ce3f907_24201688 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="showToDo"></div>
 <?php echo '<script'; ?>
> 
 
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
	
 <?php echo '</script'; ?>
>
 
 
 
<?php }
}
