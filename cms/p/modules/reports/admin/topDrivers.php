<?

    require_once '../db/db.class.php';
    $db = new DataBaseMysql();

    	$list = array();
        $r = $db->RunQuery("SELECT v4_AuthUsers.AuthUserCompany, DriverID, count(*) AS Orders FROM `v4_OrderDetails` LEFT JOIN v4_AuthUsers ON AuthUserID WHERE v4_AuthUsers.AuthUserID = DriverID AND TransferStatus = 5 GROUP BY DriverID ORDER BY Orders DESC LIMIT 15 ");

        while ( $d = $r->fetch_object() ) {
        	$list[] = array(
        		'Driver' 	=> $d->AuthUserCompany,
        		'Orders' 	=> $d->Orders
        		);
        }

//echo json_encode($barChart);
?>
                            <!-- Box (with bar chart) -->
                            <div class="box box-solid box-info">
                                <div class="box-header">
                                	<i class="fa fa-trophy"></i> 
                                    <h1 class="box-title"><?= TOP_DRIVERS ?></h1>
                                </div><!-- /.box-header -->

                                <div class="box-body">
                                    <em>* Drivers with most completed and paid transfers.</em><br><br>
                                    <table class="table table-striped">
	                                <? foreach ($list as $key => $value): ?>
	                                    <tr>
	                                    	<td class="ucase">
	                                    		<?= $value['Driver'] ?>
	                                    	</td>
	                                    	<td>
	                                    		<?= $value['Orders'] ?>
	                                    	</td>
	                                    </tr>
                                	<? endforeach ?>
                                </table>
                                </div>
                            </div>