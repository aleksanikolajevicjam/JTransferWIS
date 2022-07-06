                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-6"> 
							
                            <? require_once $modulesPath . '/reports/admin/topDriversByUnpaidCommision.php'; ?>
							
                        </section><!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-6">
                        	<? //require_once $modulesPath . '/reports/admin/mostDeclines.php'; ?>
                        </section><!-- right col -->
                    </div><!-- /.row (main row) -->

                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-4"> 
                            
                            <? require_once $modulesPath . '/reports/admin/topDrivers.php'; ?>
                        </section><!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-4">
                            <? require_once $modulesPath . '/reports/admin/topDriversByPaidCommision.php'; ?>
                        </section><!-- right col -->
                        <section class="col-lg-4"> 
                            <? require_once $modulesPath . '/reports/admin/topDriversByIncome.php'; ?>
                        </section><!-- /.Left col -->                        
                    </div><!-- /.row (main row) -->  
