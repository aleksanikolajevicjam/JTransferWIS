<?

	require_once ROOT .'/db/db.class.php';
	$db = new DataBaseMysql();
	
	$q  = " SELECT SUM(ProvisionAmount) AS Provision, SUM(InvoiceAmount) AS Invoice FROM v4_OrderDetails ";
	$q .= " WHERE UserID = '".$_SESSION['AuthUserID'] ."'";
	//$q .= " WHERE UserID = '96'";


	$w = $db->RunQuery($q);
	$c = mysqli_fetch_object($w);
	
	$firstDay = date("Y-m-d", strtotime("first day of january this year"));
	$lastDay  = date("Y-m-d", strtotime("today"));


	$q  = " SELECT SUM(ProvisionAmount) AS Provision, SUM(InvoiceAmount) AS Invoice FROM v4_OrderDetails ";
	$q .= " WHERE UserID = '".$_SESSION['AuthUserID'] ."'";
	$q .= " AND (OrderDate > '" . $firstDay . "' AND OrderDate < '" . $lastDay . "') ";


	$w = $db->RunQuery($q);
	$d = mysqli_fetch_object($w);	
	
	


?>    

                            <!-- Box (with bar chart) -->
                            <div class="box box-info box-solid bg-gray">
                            	
                                <div class="box-header">
                                    <!-- tools box -->
                                    <div class="pull-right box-tools">
                                        
                                        <button class="btn btn-info btn-sm" data-widget='collapse' 
                                        data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                        
                                        <button class="btn btn-info btn-sm" data-widget='remove' 
                                        data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                                        
                                    </div><!-- /. tools -->
                                    
                                    <i class="fa fa-arrow-circle-down"></i>
                                    <h3 class="box-title"><?= PROVISION ?></h3>
                                </div><!-- /.box-header -->

                                <div class="box-body">
                                	<img src="../i/header/2.jpg" width="100%">
                                	<br><br>
                                    <div class="row">
                                        <div class="col-md-12">
                                        	<div class="col-md-6 right">
                                        		<h3 class="box-title"><?= THIS_YEAR ?></h3>
                                        		<p class="line eee"></p>
	                                        	<p><?= PROVISION ?> : <?= $d->Provision ?> <?= CURRENCY ?></p>
	                                        	<p><?= INVOICES ?> : <?= $d->Invoice ?> <?= CURRENCY ?></p>
                                        	</div>
                                        	<div class="col-md-6 right">
                                        		<h3 class="box-title"><?= TOTAL ?></h3>
                                        		<p class="line eee"></p>
	                                        	<p><?= PROVISION ?> : <?= $c->Provision ?> <?= CURRENCY ?></p>
	                                        	<p><?= INVOICES ?> : <?= $c->Invoice ?> <?= CURRENCY ?></p>
                                        	</div>
                                        </div><!-- /.col -->
                                    </div><!-- /.row - inside box -->
									<p class="line eee"></p>
                                    <div class="row">
                                        <div class="col-md-12">
                                        	<div class="col-md-6 red darken-3">
	                                        	<br>
	                                        	<h5 class="box-title"><?= UNPAID_INVOICES ?></h5>
	                                        	<p class="line"></p>
	                                        	<p><?= $d->Invoice ?> <?= CURRENCY ?></p>
	                                        	<br>
                                        	</div>
                                        	<div class="col-md-6 xgreen darken-1 xwhite-text">
                                        		<br>
		                                    	<h5 class="box-title"><?= PAID_INVOICES ?></h5>
		                                    	<p class="line"></p>
		                                    	<p><?= $c->Invoice ?> <?= CURRENCY ?></p>
		                                    	<br>
                                        	</div>
                                        	
                                        </div><!-- /.col -->
                                    </div><!-- /.row - inside box -->
                                    <br>

                                </div><!-- /.box-body -->

                            </div><!-- /.box -->   
                            

	
	
	
	
	
	
	
