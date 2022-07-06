<div id="showMessages"></div>
<script type="text/x-handlebars-template" id="messageTemplate">
                    <!-- MAILBOX BEGIN -->
                    <div class="mailbox row">
                        <div class="col-xs-12">
                            <div class="box box-solid">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-4">
                                            <!-- BOXES are complex enough to move the .box-header around.
                                                 This is an example of having the box header within the box body -->
                                            <div class="box-header">
                                                <i class="fa fa-inbox"></i>
                                                <h3 class="box-title"><?= SYSTEM_MESSAGES ?></h3>
                                            </div>
                                            <!-- compose message btn -->
                                            <a class="btn btn-block btn-primary" data-toggle="modal" 
                                            									  data-target="#compose-modal">
                                            	<i class="fa fa-pencil"></i> Compose Message
                                            </a>
                                            <!-- Navigation - folders-->
                                            <div style="margin-top: 15px;">
                                                <ul class="nav nav-pills nav-stacked">
                                                    <li class="header">Folders</li>
                                                    <li xclass="active">
                                                    	<a onclick="message('inbox','0');">
                                                    		<i class="fa fa-inbox"></i> Inbox
                                                    	</a>
                                                    </li>
                                                   
                                                    <li>
                                                    	<a onclick="message('sent', '0');">
                                                    		<i class="fa fa-mail-forward"></i> Sent
                                                    	</a>
                                                    </li>
                                                    <li><a href="#"><i class="fa fa-star"></i> Important</a></li>

                                                </ul>
                                            </div>
                                        </div><!-- /.col (LEFT) -->
                                        
                                        
                                        <div class="col-md-9 col-sm-8">
                                            <div class="row pad">
                                                <div class="col-sm-6">

                                                    <!-- Action button -->
                                                    <div class="btn-group">
                                                        <button type="button" 
                                                        class="btn btn-default btn-sm btn-flat dropdown-toggle" 
                                                        data-toggle="dropdown">
                                                            Action <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="#">Mark as read</a></li>
                                                            <li><a href="#">Mark as unread</a></li>
                                                            <li class="divider"></li>
                                                            <li><a href="#">Delete</a></li>
                                                        </ul>
                                                    </div>

                                                </div>
                                              
                                            </div><!-- /.row -->

                                            <div class="xtable-responsive">
                                                <!-- THE MESSAGES -->
                                                <table class="table table-striped">
                                                {{#each messages}}
                                                    <tr class="unread">
                                                        <td class="small-col"><input type="checkbox" /></td>
                                                        <td class="small-col"><i class="fa fa-star-o"></i></td>
                                                        <td class="name">
                                                        <a data-toggle="modal" data-target="#show-modal{{ID}}">
                                                        	{{from}}
                                                        </a>
                                                        </td>
                                                        <td class="subject">
                                                        <a data-toggle="modal" data-target="#show-modal{{ID}}">
                                                        	{{subject}}
                                                        </a>
                                                        </td>
                                                        <td class="time"><small>{{dateTime}}</small></td>
                                                    </tr>
                                                    
                                                    
         <!-- SHOW MESSAGE MODAL -->
        <div class="modal fade" id="show-modal{{ID}}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-envelope-o"></i> Message</h4>
                    </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <label>FROM:</label>
                                    {{from}}
                                </div>
                            </div>
                     <div class="form-group">
                                {{{message}}}
                            </div>
                        </div>
                        <div class="modal-footer clearfix">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">
                            <i class="fa fa-times"></i> Close</button>
                        </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->                                                      
                                                    
                                                    
                                                   {{/each}}
                                                </table>
                                            </div><!-- /.table-responsive -->
                                        </div><!-- /.col (RIGHT) -->
                                    </div><!-- /.row -->
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col (MAIN) -->
                    </div>
                    <!-- MAILBOX END -->
                    
         <!-- COMPOSE MESSAGE MODAL -->
        <div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-envelope-o"></i> Compose New Message</h4>
                    </div>
                    <form action="#" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">TO:</span>
                                    <input name="email_to" type="email" class="form-control" placeholder="To User">
                                </div>
                            </div>
                         
                            <div class="form-group">
                                <textarea name="message" id="email_message" class="form-control" 
                                placeholder="Message" style="height: 120px;"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer clearfix">

                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <i class="fa fa-times"></i> Discard</button>

                            <button type="submit" class="btn btn-primary pull-left">
                            <i class="fa fa-envelope"></i> Send Message</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->                   







  </script>  


        <script type="text/javascript">
            $(function() {

                "use strict";

                //Handle starring for glyphicon and font awesome
                $(".fa-star, .fa-star-o, .glyphicon-star, .glyphicon-star-empty").click(function(e) {
                    e.preventDefault();
                    //detect type
                    var glyph = $(this).hasClass("glyphicon");
                    var fa = $(this).hasClass("fa");

                    //Switch states
                    if (glyph) {
                        $(this).toggleClass("glyphicon-star");
                        $(this).toggleClass("glyphicon-star-empty");
                    }

                    if (fa) {
                        $(this).toggleClass("fa-star");
                        $(this).toggleClass("fa-star-o");
                    }
                });

                //Initialize WYSIHTML5 - text editor
                $("#email_message").wysihtml5();
            });
            
            
            
 	message('inbox','0');
 
 	function message(action,itemId){
 		var newMessage = $("#email_message").val();
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
                
                   
