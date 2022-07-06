<?
	/* CMS Studio 3.0 delete_final.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");
	
	global $smarty;
	global $auth;
	
	if($auth->isActionAllowed("ACTION_ORDER_DELETE"))
	{
		if(isset($_REQUEST["orderid"]))
		{
			$order = $ObjectFactory->createObject("PrOrder",$_REQUEST["orderid"],"PrOrderItem");
			
			foreach ($order->PrOrderItem as $oi) 
			{
				$DBBR->obrisiSlog($oi);
			}
			$DBBR->obrisiSlog($order);
			echo "<div class='success'>".getTranslation("PLG_DELETE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>". getTranslation("PLG_NORIGHT")."</div>";
?>