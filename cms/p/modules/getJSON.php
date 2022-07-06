<?php   
		$password = file_get_contents('weby_key.inc', FILE_USE_INCLUDE_PATH);
		$link="https://city-airport-taxis.com/api/getAllBookingsConfirmedPast48?password=".$password;   
		$json = file_get_contents($link);   
		$obj = json_decode($json,true);
		$j=-1;
		$cnt=ltrim(count ($obj['data']));
		for ($i = 0; $i < $cnt; $i++) {
			if ($obj['data'][$i]['reservation_reference']==$_REQUEST['code'])
				$j=$i;
		}		
		if ($j==-1) {
			echo 'false';
			exit();
		}	
		$new_array1=array();
		$key_pr='';
		$new_array2=toarray ($obj['data'][$j], $new_array1, $key_pr);
		function toarray($arr,$new_array,$key_pr) {
			foreach ($arr as $key=>$field)
			{
				if ($key_pr<>'') $key_res=$key_pr."_".$key;
				else $key_res=$key;		
				
				if (is_array($field)) {
				
					$new_array3=toarray($field,$new_array,$key_res);
					$new_array=array_merge($new_array, $new_array3);	
				}		
				else {
					$new_array[$key_res]=$field;	
				}		
			}
			return $new_array;
		}
		if (isset ($_REQUEST['form']) && ($_REQUEST['form']=='booking' || $_REQUEST['form']=='final')) $file = file("convert_table_booking.txt");
		else $file = file("convert_table.txt");
		foreach($file as $row)
		{ 
			if (strlen(rtrim($row))>0)
			{	
				$row=explode(" ",$row);
				if (isset($row[1]) && ltrim($row[1])<>'') {
					$index2=$row[1];
					$index1=$row[0]; 
					
					if (isset($new_array2[$index1])) {
						$iftime=explode(":",$new_array2[$index1]);
						if (count($iftime)==3) $new_array2[$index1]=$iftime[0].":".$iftime[1];
						$new_array4[$index2]=$new_array2[$index1];	
					}	
				}
			}
		}	
		
		echo $json = json_encode($new_array4);

?>