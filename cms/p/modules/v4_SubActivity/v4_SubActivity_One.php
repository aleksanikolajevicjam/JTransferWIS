<?
header('Content-Type: text/javascript; charset=UTF-8');
error_reporting(E_PARSE);
 
	# init libs
	require_once '../../../../f/f.php';

	require_once '../../../../db/db.class.php';
	require_once '../../../../db/v4_SubActivity.class.php';
	require_once '../../../../db/v4_Equipment.class.php';
	

	# init vars
	$out = array();

	# init class
	$ac = new v4_SubActivity();
	$eq = new v4_Equipment();
	
	# filters

	$ID = $_REQUEST['ID'];

	# Details  red
	$ac->getRow($ID);

	# get fields and values
	$detailFlds = $ac->fieldValues();

	//select iz redova tabele
	$db = new DataBaseMySql();
	$eq_arr1=array();
	$eq_arr2=array();	
	$sqls="SELECT EquipmentID FROM `v4_VehicleCheckList` WHERE `ActivityID`=".$ac->getID();
	$query=mysqli_query($db->conn, $sqls) or die('Error in VehicleCheckList query' . mysqli_connect_error());
	while($eqp = mysqli_fetch_object($query) ) {
		$eq_arr[]=$eqp->EquipmentID;
	}

	$sqls="SELECT EquipmentID FROM `v4_VehicleEquipmentItem` WHERE `VehicleID`=".$ac->getVehicleID()." AND ListID='".$ac->getListID()."'";
	$query2=mysqli_query($db->conn, $sqls) or die('Error in VehicleCheckList query' . mysqli_connect_error());
	while($eqp = mysqli_fetch_object($query2) ) {
		$x_arr['id']=$eqp->EquipmentID;
		$eq->getRow($eqp->EquipmentID);
		$x_arr['title']=$eq->Title;
		if (in_array($eqp->EquipmentID,$eq_arr)) $x_arr['checked']=1;
		else $x_arr['checked']=0;
		$eq_arr2[]=$x_arr;
	}
	
	$detailFlds['checklist']=$eq_arr2;
	$out[] = $detailFlds;
	

	# send output back
	$output = json_encode($out);
	echo $_GET['callback'] . '(' . $output . ')';
	