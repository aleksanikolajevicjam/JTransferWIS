
					{include file="plugins/Dashboard/templates/smallBoxes.tpl"}
					{include file="plugins/Dashboard/templates/emptyRow.tpl"} 			

					<div class="row">
						<section class="col-lg-6 xconnectedSortable"> 
							{include file="plugins/Dashboard/templates/getOrder.tpl"} 			
						</section><!-- /.Left col -->
						<section class="col-lg-6 xconnectedSortable"> 
							{include file="plugins/Dashboard/templates/getUnfinishedPayment.tpl"} 			
						</section>
					</div>	
                    <div class="row">
                        <section class="col-lg-6 xconnectedSortable"> 
							{include file="plugins/Dashboard/templates/actualTransfers.tpl"} 			
                        </section>
                        <section class="col-lg-6 xconnectedSortable">
							{include file="plugins/Dashboard/templates/todo.tpl"} 								
                        </section>
                    </div>		
                    <div class="row">
                        <section class="col-lg-6 xconnectedSortable"> 
							{include file="plugins/Dashboard/templates/quickEmail.tpl"} 
                        </section>
                        <section class="col-lg-6 xconnectedSortable">
                        </section>
                    </div>	        
