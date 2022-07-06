<script type="text/x-handlebars-template" id="todoTemplate">

                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">To Do List</h3>
                                    <!-- tools box -->
                                    <div class="pull-right box-tools">
                                        
                                        <button class="btn btn-info btn-sm" data-widget='collapse' 
                                        data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                        
                                        <button class="btn btn-info btn-sm" data-widget='remove' 
                                        data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                                        
                                    </div><!-- /. tools -->                                    
								</div>
                                <div class="box-body">
                                    <ul class="todo-list">
                                        {{#each todoItems}}
                                        <li data-id="{{ID}}" class="{{done}}">

                                            <span class="handle">
                                                <i class="fa fa-ellipsis-v"></i>
                                                <i class="fa fa-ellipsis-v"></i>
                                            </span>  

                                            <input type="checkbox"  class="icheckbox_minimal simple"
                                            onclick="toggleCompleted(this,'{{ID}}');"/>

                                            <span class="text" id="taskText{{ID}}">{{task}}</span>
                                            
                                            <small class="label label-info pull-right">
                                            	<i class="fa fa-clock-o"></i> {{fromNow dateTime}} 
                                            </small>
                                            

                                            <div id="tools{{ID}}" class="tools">
                                                <i class="fa fa-edit" onclick="editItem('{{ID}}');"></i>
                                                <i class="fa fa-trash-o" onclick="todoItem('delete','{{ID}}');"></i>
                                                <i class="fa fa-save" style="display:none" onclick="saveItem('{{ID}}');"></i>
                                            </div>
                                        </li>
										{{/each}}
                                    </ul>
                                    
                                </div>
                                <div class="box-footer clearfix no-border">
                                    <input type="text" name="newItem" id="newItem" class="w100" 
                                    placeholder="New Item Text">

                                    <button class="btn btn-default pull-right" onclick="todoItem('add','');" >
                                    	<i class="fa fa-plus"></i> Save
                                    </button>
                                                                        
                                    <button class="btn btn-default btn-xs" onclick="todoItem('deleteCompleted','');" >
                                    	<i class="fa fa-times"></i> Delete Completed
                                    </button>
                                    

                                </div>
                            </div>
                         

 </script>  