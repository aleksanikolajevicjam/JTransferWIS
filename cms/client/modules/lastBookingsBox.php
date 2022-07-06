<?

    //reqo('/db/v4_OrderDetails.class.php');
	//reqo('/db/v4_Places.class.php');

    $od = new v4_OrderDetails();
	
	$links = array();
	
	$serverName = 'http://' . $_SERVER['SERVER_NAME'] . '/cms/';
	

    // za sve bookinge do sada
    $where = ' WHERE UserID = "'.$_SESSION['AuthUserID'].'"';
    //$where = ' WHERE UserID = 53 AND PickupID != 0 AND DropID != 0 ';
    $k = $od->getKeysBy('DetailsID', 'desc LIMIT 0,10', $where);
	
	foreach ($k as $nn => $detKey) {
		
		$od->getRow($detKey);
		
		$fromName 	= getPlaceName($od->PickupID);
		$toName 	= getPlaceName($od->DropID);
		$CountryID  = getPlaceCountryFromPlaceName ($fromName); 

		if($fromName != '' and $toName != '') {
			// Store links
			$links[] = '<a  xclass="btn" href="' . $serverName .
						'index.php?p=booking&CountryID='.$CountryID.'&FromID='.$od->PickupID.'&ToID='.$od->DropID.'">' .
						$fromName . ' - ' . $toName . '</a>';
		}
	
	}

	//echo '<pre>'; print_r($links); echo '</pre>';

    $od->endv4_OrderDetails();




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
                                    <i class="fa fa-bars"></i>

                                    <h3 class="box-title"><?= LAST_BOOKINGS ?></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body"><img src="../i/10.jpg" width="100%">
                                    <div class="row">
                                        <div class="col-md-12">
                                        	<br>
                                        	<ul style="list-style-type: circle">
                                        	<?
                                        		foreach($links as $i => $link) {
                                        			echo '<li>' . $link . '</li> ';
                                        		}
                                        	?>
                                        	</ul>
 
                                        </div><!-- /.col -->
                                    </div><!-- /.row - inside box -->
                                </div><!-- /.box-body -->
                                <div class="box-footer xblue lighten-2 xwhite-text">
                                    <h3 class="s"><?= CLICK_TO_BOOK_AGAIN ?></h3>
                                </div><!-- /.box-footer -->
                            </div><!-- /.box -->   
                            

	
	
	
	
	
	
	
