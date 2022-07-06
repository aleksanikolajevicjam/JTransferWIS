
					<? require_once $modulesPath . 'smallBoxes.php'; ?>
					<? require_once $modulesPath . 'emptyRow.php'; ?>
					

                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-6 xconnectedSortable"> 
							<? require_once $modulesPath . 'barChartBox.php'; ?>
							
                        </section><!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-6 xconnectedSortable">
                        	<? require_once $modulesPath . 'chartTabs.php'; ?>
                        	
                        	
							<? //require_once $modulesPath . 'map.php'; ?>
							<? //require_once $modulesPath . 'chat.php'; ?>
                        </section><!-- right col -->
                    </div><!-- /.row (main row) -->
                    
                    <? require_once $modulesPath . 'calendarPlugin.php'; ?>
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-6 xconnectedSortable"> 
							<? require_once $modulesPath . 'todo.php'; ?>
                        </section><!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-6 xconnectedSortable">
							<? //require_once $modulesPath . 'map.php'; ?>
							<? //require_once $modulesPath . 'chat.php'; ?>
							<? require_once $modulesPath . 'quickEmail.php'; ?>
                        </section><!-- right col -->
                    </div><!-- /.row (main row) -->                    
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="js/theme/dashboard.js" type="text/javascript"></script>  
