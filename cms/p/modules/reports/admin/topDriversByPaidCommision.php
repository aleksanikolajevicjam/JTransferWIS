<?

    require_once '../db/db.class.php';
    $db = new DataBaseMysql();

    	$list = array();
        $r = $db->RunQuery(
                            "SELECT v4_AuthUsers.AuthUserCompany, DriverID, 
                                    SUM(v4_OrderDetails.TaxidoComm) AS TotalIncome
                            FROM `v4_OrderDetails` 
                            LEFT JOIN v4_AuthUsers ON AuthUserID 
                            WHERE v4_AuthUsers.AuthUserID = DriverID AND PaymentStatus = 99 
                            AND TransferStatus = 5 
                            GROUP BY DriverID 
                            ORDER BY TotalIncome DESC LIMIT 15 ");

        while ( $d = $r->fetch_object() ) {
        	$list[] = array(
        		'Driver' 	    => $d->AuthUserCompany,
        		'TotalIncome'	=> $d->TotalIncome
        		);
        }

//echo json_encode($list);
?>
                            <!-- Box (with bar chart) -->
                            <div class="box box-solid box-success">
                                <div class="box-header">
                                	<i class="fa fa-trophy"></i> 
                                    <h1 class="box-title"><?= TOP_DRIVERS ?></h1>
                                </div><!-- /.box-header -->

                                <div class="box-body">
                                    <em>* By PAID commission</em><br><br>
                                    <table class="table table-striped">
	                                <? foreach ($list as $key => $value): ?>
	                                    <tr>
	                                    	<td class="ucase">
	                                    		<?= $value['Driver'] ?>
	                                    	</td>
	                                    	<td align="right">
	                                    		<?= number_format($value['TotalIncome'],2) ?> EUR
	                                    	</td>
	                                    </tr>
                                	<? endforeach ?>
                                </table>
                                </div>
                            </div>