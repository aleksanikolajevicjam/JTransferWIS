<?

	$qry1 = "SELECT * FROM ".DB_PREFIX."places 
	        WHERE PlaceActive = 1 
	        AND PlaceNameEN LIKE %". $_REQUEST['fromName'] .
	        " ORDER BY PlaceNameEN ASC";
	$res1 = mysql_query($qry1) or die(mysql_error() . 'PlacesOptions Qry');

    $item = array();
	while ($p = mysql_fetch_object($res1))
	{
		$item[$p->PlaceID] = $p->PlaceNameEN;
	} 
  
    echo json_encode($ret);

