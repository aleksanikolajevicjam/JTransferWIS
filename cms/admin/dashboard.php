
					<? require_once $modulesPath . '/smallBoxes.php'; ?>
					<? require_once $modulesPath . '/emptyRow.php'; ?>				

					<div class="row">
						<section class="col-lg-6 xconnectedSortable"> 
							<? require_once $modulesPath . '/Orders/getOrder.php'; ?>
						</section><!-- /.Left col -->
						<section class="col-lg-6 xconnectedSortable"> 
							<? require_once $modulesPath . '/getUnfinishedPayment.php'; ?>
						</section>
					</div>	
                    <div class="row">
                        <section class="col-lg-6 xconnectedSortable"> 
							<? require_once $modulesPath . '/actualTransfers.php'; ?>
                        </section>
                        <section class="col-lg-6 xconnectedSortable">
							<? require_once $modulesPath . '/quickEmail.php'; ?>
                        </section>
                    </div>		
                    <div class="row">
                        <section class="col-lg-6 xconnectedSortable"> 
							<? require_once $modulesPath . '/todo.php'; ?>
                        </section>
                        <section class="col-lg-6 xconnectedSortable">
                        </section>
                    </div>	        
		<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
