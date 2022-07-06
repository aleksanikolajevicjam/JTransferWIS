<?
	/* CMS Studio 3.0 modify.php *///

	$_ADMINPAGES = true;
	include_once("../../../config.php");
		
	global $smarty;
	global $auth;
	
	
	if($auth->isActionAllowed("ACTION_ORDER_MODIFY"))
	{
		$kurs = $ObjectFactory->createObject("PrKurs",1);
		$smarty->assign("kurs",$kurs->getKurs());
		
		if(isset($_REQUEST["mode"])) $_REQUEST["orderid"]=-1;								
		if(isset($_REQUEST["orderid"]))
		{
			// deo za insertovanje novog sloga
			if(isset($_REQUEST["mode"])) $smarty->assign("mode", 'insert');
			else $smarty->assign("mode", 'edit');
			
			$order = $ObjectFactory->createObject("PrOrder", $_REQUEST["orderid"], array("PrOrderItem","User","SfOrderType"));
			$smarty->assign($order->toArray());
			$smarty->assign('user', $order->getUser()->toArray());
			
			$shipping = $ObjectFactory->createObject("PrOrderShipping",$_REQUEST["orderid"]);	
			$smarty->assign("shipping", $shipping->toArray());	

			// statusi
			$ObjectFactory->AddFilter(" tip_status_id = " . STATUS_TIP_ORDER);
			$statusi = $ObjectFactory->createObjects("SfStatus");
			$shStatus = new SmartyHtmlSelection("status",$smarty);

			foreach ($statusi as $s) 
			{
				$shStatus->AddOutput($s->getVrednost());
				$shStatus->AddValue($s->getStatusID());
			}
			$shStatus->AddSelected($order->SfStatus->getStatusID());
			$shStatus->SmartyAssign();
			$ObjectFactory->ResetFilters();

			$orderitem_proiz_rb = array();
			$orderitem_proiz_nazivi = array();
			$orderitem_proiz_sifre  = array();
			$orderitem_proiz_kolicine = array();
			$orderitem_proiz_cene = array();
			$orderitem_proiz_iznosi = array();
			$orderitem_proiz_ukupna_cena = 0;
			
			$i = 0;
			foreach($order->PrOrderItem as $oi)
			{
				//punim sve order items-e sa proizvodima
				$DBBR->poveziSaJednim($oi,$oi->PrProizvod);
				
				array_push($orderitem_proiz_rb,++$i);
				array_push($orderitem_proiz_nazivi,$oi->getProductName());
				array_push($orderitem_proiz_sifre,$oi->getProductCode());
				array_push($orderitem_proiz_kolicine,number_format($oi->getQuantity(),2,",",""));
				array_push($orderitem_proiz_cene,number_format($oi->getPrice(),2,",",""));
				array_push($orderitem_proiz_iznosi,number_format($oi->getAmount(),2,",",""));
				
				$orderitem_proiz_ukupna_cena += $oi->getAmount();
			}
			
			$smarty->assign("orderitem_proiz_rb",$orderitem_proiz_rb);
			$smarty->assign("orderitem_proiz_nazivi",$orderitem_proiz_nazivi);
			$smarty->assign("orderitem_proiz_sifre",$orderitem_proiz_sifre);
			$smarty->assign("orderitem_proiz_kolicine",$orderitem_proiz_kolicine);
			$smarty->assign("orderitem_proiz_cene",$orderitem_proiz_cene);
			$smarty->assign("orderitem_proiz_iznosi",$orderitem_proiz_iznosi);
			$smarty->assign("orderitem_proiz_ukupna_cena",number_format($orderitem_proiz_ukupna_cena,2,",",""));
		}
		
		$smarty->display('modify.tpl');
	}
	else 
	{
		// show error message not enough rights
		$smarty->assign("norights_message",getTranslation("PLG_NORIGHT"));
		$smarty->display('../../templates/norights.tpl');
	}

?>