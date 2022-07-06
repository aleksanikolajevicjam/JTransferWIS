
<div id="showMessages"></div>
<script type="text/x-handlebars-template" id="messageTemplate">

                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">System Messages</h3>
								</div>
                                <div class="box-body">
                                    <ul class="todo-list">
                                        {{#each messages}}
                                        <li data-id="{{ID}}" class="{{done}}">

                                            <span class="handle">
                                                <i class="fa fa-ellipsis-v"></i>
                                                <i class="fa fa-ellipsis-v"></i>
                                            </span>  

                                            <input type="checkbox"  class="icheckbox_minimal simple"
                                            onclick="toggleCompletedMsg(this,'{{ID}}');"/>

                                            <span class="text" id="messageText{{ID}}">{{message}}</span>
                                            
                                            <small class="label label-info pull-right">
                                            	<i class="fa fa-clock-o"></i> {{fromNow dateTime}} 
                                            </small>
                                            

                                            <div id="tools{{ID}}" class="tools">
                                                <i class="fa fa-edit" onclick="editMessage('{{ID}}');"></i>
                                                <i class="fa fa-trash-o" onclick="message('delete','{{ID}}');"></i>
                                                <i class="fa fa-save" style="display:none" onclick="saveMessage('{{ID}}');"></i>
                                            </div>
                                        </li>
										{{/each}}
                                    </ul>
                                    
                                </div>
                                <div class="box-footer clearfix no-border">
                                    <input type="text" name="newMessage" id="newMessage" class="w100" 
                                    placeholder="New Message Text">

                                    <button class="btn btn-default pull-right" onclick="message('add','');" >
                                    	<i class="fa fa-plus"></i> Save
                                    </button>
                                                                        
                                    <button class="btn btn-default btn-xs" onclick="message('deleteCompleted','');" >
                                    	<i class="fa fa-times"></i> Delete Completed
                                    </button>
                                    

                                </div>
                            </div>
                         

 </script>  
 <script> 
 	message();
 
 	function message(action,itemId){
 		var newMessage = $("#newMessage").val();
		var url = window.root + '/cms/api/'+
		"messages.php?action=" + action +
		"&newMessage=" + newMessage +
		"&ID=" + itemId +
		"&callback=?";
	
		$.ajax({
			type: 'POST',
			url: url,
			async: false,
			contentType: "application/json",
			dataType: 'jsonp',
			success: function(data) {
			  var source   = $("#messageTemplate").html();
			  var template = Handlebars.compile(source);
			  var HTML = template({messages : data});
			  $("#showMessages").html(HTML);
			}
		});		
 	}
 	
 	function toggleCompletedMsg(cb,id) {
 			message('completed',id);
 	}
	
	function editMessage(id) {
		var currentText = $("#messageText"+id).text();
		$(".fa-edit").hide();
		$(".fa-trash-o").hide();
		$("#tools"+id+" .fa-save").show();
		$("#messageText"+id).html('<input type="text" id="newMessage" value="'+currentText+'">');
	}
	
	function saveMessage(id) {
		message('update',id);
		$(".fa-edit").show();
		$(".fa-trash-o").show();
		$(".fa-save").hide();		
	}
 </script>
 
 
 
