<?
	/* CMS Studio 3.0 modify_final.php */

	$_ADMINPAGES = true;
	include_once("../../../config.php");

	global $smarty;
	global $auth;

	if($auth->isActionAllowed("ACTION_ORDER_MODIFY"))
	{
		//insertovanje praznog sloga, umesto insert_pre.php
		if ($_REQUEST['mode']=='insert')
		{
			require ("insert_pre.php");
			$obj = $ObjectFactory->createObject("PrOrder");
			$colid=$DBBR->vratiPoslednjiID($obj);
			$col=$colid[0];
			$id=$colid[1];
			$_REQUEST[$col]=$_POST[$col]=$id;
		}
		if(isset($_REQUEST["orderid"]))
		{
			$order = $ObjectFactory->createObject("PrOrder",-1);
			$order->OrderID = $_REQUEST["orderid"];
			$DBBR->nadjiSlogVratiGa($order);
			$order->SfStatus->setStatusID($_REQUEST["statusid"]);
			$DBBR->promeniSlog($order);

			if ($_REQUEST["statusid"]<>$_REQUEST["statusid2"] && $_REQUEST["statusid"]==STATUS_ORDER_UOBRADI) {
				
				$smarty->assign('order',$order->toArray());
				$smarty->assign('user', $order->getUser()->toArray());
				$shipping = $ObjectFactory->createObject("PrOrderShipping",$_REQUEST["orderid"]);	
				$smarty->assign("shipping", $shipping->toArray());	
				
				ob_start();
				$smarty->display("../../../templates/mail_header.tpl");
				$smarty->display("orderstatus_mail.tpl");
				$smarty->display("../../../templates/mail_footer.tpl");
				$message = ob_get_contents();
				ob_end_clean();
				if(IS_PRODUCTION) {
					if($CMSSetting->getSettingByID(ORDER_TO_USER_MAIL_ACTIVE) == SETTING_TYPE_ON)
					{
						// slanje maila da je narudzbenica kreirana
						$phpmail = new PHPMailer();

						switch($CMSSetting->getSettingByID(ORDER_TO_USER_SENDER_TYPE))
						{
							case SENDER_TYPE_SMTP:
								$phpmail->IsSMTP();
								$phpmail->Host = $CMSSetting->getSettingByID(ORDER_TO_USER_HOST_NAME);
								break;
							case SENDER_TYPE_MAIL:
								$phpmail->IsMail();
								break;
							default:
								break;
						}

						$phpmail->From = $CMSSetting->getSettingByID(ORDER_TO_USER_MAIL_EMAIL);
						$phpmail->FromName = $CMSSetting->getSettingByID(ORDER_TO_USER_MAIL_NAME);
						$phpmail->IsHTML(true);
						$user =  $ObjectFactory->createObject("User", $_REQUEST["userid"]);
						$phpmail->AddAddress($user->getEmail());

						$phpmail->Subject = "Mobillwood - Status narudžbine";



						$phpmail->Body = $message;
						$phpmail->Send();
						unset($phpmail);
					}
				}
				else echo "<div class='success'>".$message."</div>";

			}

			echo "<div class='success'>".getTranslation("PLG_CHANGE_SUCCESS")."</div>";
		}
		else echo "<div class='error'>".getTranslation("PLG_CHANGE_FAILED")."</div>";
	}
	else echo "<div class='warning'>".getTranslation("PLG_NORIGHT")."</div>";
?>
