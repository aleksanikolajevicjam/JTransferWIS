<?
// ----------------------------------------------------------------------------
//
//  File:   ajax_setPaidComm.php
//  Purpose: update commision status to paid
//
// ----------------------------------------------------------------------------
@session_start();

require_once ROOT.'/cms/db.php';
require_once ROOT.'/cms/f/form_functions.php';
require_once ROOT.'/cms/f/db_funcs.php';

$db = getMyDb();


usleep(300000);
	
		
		# update Correction field for selected ServiceID
		$data = array(
							//'ServicePrice1' => $fp,
							'PaymentStatus' => '99'
						);
						
		$where = 'DetailsID = '. $_REQUEST['DetailsID'];
		
		XUpdate(DB_PREFIX . 'OrderDetails',$data,$where);

	
	# show Message
echo '<b>Paid</b>';
	

