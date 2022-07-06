<div class="container">
    <h2>User Reviews</h2>
    <br>
    <?
        require_once ROOT . '/db/db.class.php';
        require_once ROOT . '/db/v4_Routes.class.php';
		require_once ROOT . '/db/v4_OrderDetails.class.php';

        
        $db = new DataBaseMySql();
        $r  = new v4_Routes();
		$SAuthUserID = $_SESSION['AuthUserID'];

		require_once ROOT . '/cms/fixDriverID.php';
		foreach($fakeDrivers as $key => $fakeDriverID) {
			if($SAuthUserID == $fakeDriverID) $SAuthUserID = $realDrivers[$key];   
		}


        $q  = "SELECT * FROM v4_OrderDetails ";
        $q .= "WHERE DriverID = '".$SAuthUserID."' ";
        $q .= "OR SubDriver = '".$SAuthUserID."' ";
        $q .= "OR SubDriver2 = '".$SAuthUserID."' ";
        $q .= "OR SubDriver3 = '".$SAuthUserID."' ";        
        $q .= "ORDER BY DetailsID DESC";

        $w = $db->RunQuery($q);
        
        while($od = $w->fetch_object() ) {
            
            if( $prevOrderID != $od->OrderID) {
                
                $q2  = "SELECT * FROM v4_Survey ";
                $q2 .= "WHERE OrderID = '" . $od->OrderID . "' ";
                
                $w2 = $db->RunQuery($q2);
                
                $s = $w2->fetch_object();
                
                if($s->Comment != '') { ?>
     
                    <?
                    $color = 'blue';
                    $tile = 'white';

                    if($s->ScoreTotal < 9) {
                        $color = 'red';
                        //$tile = "red lighten-4 xblack-text";
                    }

                    
                    if ($s->RouteID>0) {
						$r->getRow($s->RouteID);
						$routeName=$r->RouteNameEN;
					}	
					else $routeName=$od->PickupName."-".$od->DropName;
                    
                    ?>
                
                    <div class="row <?=$tile?> listTile pad1em">
                        <div class="col-md-2">
                            <?= $s->OrderID ?><br>
                            <small><?= $s->Date ?></small>
                        </div>

                        <div class="col-md-2">
                            <strong><?= $s->UserName ?></strong>
                         </div>
                       
                        <div class="col-md-6">
                            <strong><?= $routeName ?></strong><br><br>
                            <?= $s->Comment?>
                        </div>
                        
                        <div class="col-md-2 xl text-<?=$color?> right">
                            <?= $s->ScoreTotal ?>
                        </div>
                        
                    </div>


    <?          }
                
                $prevOrderID = $od->OrderID;
            }
        }
        

    ?>
</div>
