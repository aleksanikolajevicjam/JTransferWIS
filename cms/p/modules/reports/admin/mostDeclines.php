<?

    require_once '../db/db.class.php';
    $db = new DataBaseMysql();

    	$list = array();
        $r = $db->RunQuery("SELECT v4_AuthUsers.AuthUserRealName, DriverID, count(*) AS Declines FROM `v4_OrderDetails` LEFT JOIN v4_AuthUsers ON AuthUserID WHERE v4_AuthUsers.AuthUserID = DriverID AND DriverConfStatus = 4 GROUP BY DriverID ORDER BY Declines DESC LIMIT 15 ");

        while ( $d = $r->fetch_object() ) {
        	$list[] = array(
        		'Driver' 	=> $d->AuthUserRealName,
        		'Declines' 	=> $d->Declines
        		);
        }

//echo json_encode($barChart);
?>
                            <!-- Box (with bar chart) -->
                            <div class="box box-solid box-danger">
                                <div class="box-header">
                                	<i class="fa fa-thumbs-down"></i> 
                                    <h3 class="box-title"><?= MOST_DECLINES ?></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                	<br><br>
                                    <table class="table table-striped">
                                    <? foreach ($list as $key => $value): ?>
                                        <tr>
                                            <td class="ucase">
                                                <?= $value['Driver'] ?>
                                            </td>
                                            <td>
                                                <?= $value['Declines'] ?>
                                            </td>
                                        </tr>
                                    <? endforeach ?>
                                </table>
                                </div>
                            </div>