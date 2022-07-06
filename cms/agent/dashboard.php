
					<? //require_once './p/modules/smallBoxes.Agent.php'; ?>
					<? require_once './p/modules/emptyRow.php'; ?>
					

                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-6 xconnectedSortable"> 
							<? require_once 'agent/modules/lastBookingsBox.php'; ?>

							
                        </section><!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-6 xconnectedSortable">
                        	<? require_once 'agent/modules/agentBalance.php'; ?>
                        	
                        	
							<? //require_once 'p/modules/map.php'; ?>
							<? //require_once 'p/modules/chat.php'; ?>
                        </section><!-- right col -->
                    </div><!-- /.row (main row) -->
                    
                    <? //require_once 'calendarPlugin.php'; ?>
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-6 xconnectedSortable"> 
							<? require_once './p/modules/todo.php'; ?>
                        </section><!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-6 xconnectedSortable">
							<? //require_once 'modules/map.php'; ?>
							<? //require_once 'modules/chat.php'; ?>
							<? require_once './p/modules/quickEmail.php'; ?>
                        </section><!-- right col -->
                    </div><!-- /.row (main row) -->                    

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="js/theme/dashboard.js" type="text/javascript"></script>  

