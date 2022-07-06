<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once '../../../../db/db.class.php';
	require_once '../../../../db/v4_VehicleEquipmentList.class.php';
	require_once '../../../../db/v4_Equipment.class.php';

	# init vars
	$out = array();

	# init class
	$db = new v4_VehicleEquipmentList();
	$eq = new v4_Equipment();
	$dbf = new DataBaseMySql();



	$eqk = $eq->getKeysBy('DisplayOrder ' , '' , 'Where Active=1');
	if (count($eqk) != 0) {
		foreach ($eqk as $nn => $key)  
		{	
			$eq->getRow($key);	
			$out_arr['id']=$key;
			$out_arr['title']=$eq->getTitle();
			$out2[]=$out_arr;
		}
	}	
	# filters

	$ID = $_REQUEST['ID'];

	# Details  red
	$db->getRow($ID);

	# get fields and values
	$detailFlds = $db->fieldValues();
	$detailFlds['checklist']=$out2;

	$sql="SELECT `ListID`, `EquipmentID` FROM `v4_VehicleEquipmentItem` WHERE ListID='".$detailFlds['ListID']."' AND VehicleID=".$detailFlds['VehicleID'];
	$r=$dbf->RunQuery($sql);	
	$eq_list=array();
	while ($e = $r->fetch_object()) {
		$out_arr3['eqid']=$e->EquipmentID;;
		$eq_list[]=$out_arr3;
	}
	$detailFlds['eq_list']=$eq_list;
	$out[] = $detailFlds;

	# send output back
	$output = json_encode($out);
	echo $_GET['callback'] . '(' . $output . ')';
	