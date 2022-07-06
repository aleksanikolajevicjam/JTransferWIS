<? 

	ini_set('display_errors', 1);
	ini_set('log_errors', 1);
	ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
	error_reporting(E_ALL);

	@session_start();
	
	$OrderID=$_REQUEST['OrderID'];
	$TNo=$_REQUEST['TNo'];
	$DriverID=$_REQUEST['DriverID'];
	if (isset($_REQUEST['returnTransfer'])) $returnTransfer=$_REQUEST['returnTransfer'];
	else $returnTransfer=0;
	$requestType=$_REQUEST['requestType'];
	
	
	require_once ROOT .'/f2/f.php';
    require_once ROOT .'/db/db.class.php';
	require_once ROOT .'/db/v4_AuthUsers.class.php';
	require_once ROOT .'/db/v4_OrderDetails.class.php';
	require_once ROOT .'/db/v4_OrderExtras.class.php';
	require_once ROOT .'/db/v4_VehicleTypes.class.php';

	require_once ROOT . '/PHPMailer-master/PHPMailerAutoload.php';
	require_once ROOT . '/common/libs/Smarty.class.php'; 

	$mail = new PHPMailer;
	
 
	$db = new DataBaseMysql(); 
	$u = new v4_AuthUsers();
	$od = new v4_OrderDetails();
	$oe = new v4_OrderExtras();
	$vt = new v4_VehicleTypes();
	
	$smarty = new Smarty;

	$u->getRow($DriverID);   //online
	//$u->getRow($_SESSION['AuthUserID']); //za test 
	$mailto=$u->getAuthUserMail();
	
    $orderKey = create_order_key();
	
	$query="INSERT INTO `v4_OrderRequests`(`OrderKey`,`OrderID`,`TNo`, `DriverID`, `ReturnTransfer`, `RequestType`, `RequestDate`, `RequestTime`) 
		VALUES ('".$orderKey."',".$OrderID.",".$TNo.",".$DriverID.",".$returnTransfer.",".$requestType.",NOW(),NOW()) ";
	
	$result = $db->RunQuery($query);

	$requestID=$db->insert_id();

	$link = 'https://' . $_SERVER['SERVER_NAME'] . '/cms/requestResponse.php?key='.$orderKey.'&cd=1'; 
	$link2 = 'https://' . $_SERVER['SERVER_NAME'] . '/cms/requestResponse.php?key='.$orderKey.'&cd=2'; 
	$link3 = 'https://' . $_SERVER['SERVER_NAME'] . '/cms/requestResponse.php?key='.$orderKey.'&cd=3'; 
	$link4 = 'https://' . $_SERVER['SERVER_NAME'] . '/cms/requestResponse.php?key='.$orderKey.'&cd=4'; 
	$link5 = 'https://' . $_SERVER['SERVER_NAME'] . '/cms/requestResponse.php?key='.$orderKey.'&cd=5'; 
	

	$subject="New Transfer - Request For Availability";
	if ($requestType==2) $subject.= " and price";

	$query="SELECT * FROM `v4_OrderRequests` WHERE ID=".$requestID;
	
	$result = $db->RunQuery($query);
	while($row = $result->fetch_array(MYSQLI_ASSOC)){ 
		$out_arr=$row;
		$return=$row['ReturnTransfer'];
		$tno=$row['TNo'];
		
		if ($return==0) $oKey = $od->getKeysBy('OrderID', 'ASC', ' WHERE OrderID = ' .$row['OrderID']. ' AND TNo = '. $row['TNo']);
		else $oKey = $od->getKeysBy('TNo', 'ASC', ' WHERE OrderID = ' .$row['OrderID']);
		$od->getRow($oKey[0]);



		$route=$od->getPickupName()." - ".$od->getDropName();
		$pickupname=$od->getPickupName();
		$dropname=$od->getDropName();
		if ($return==1) $route.="/ <b>both directions</b>";
		$pickuptime=$od->getPickupDate()." / ". $od->getPickupTime();
		$paxno=$od->getPaxNo();
		$vt->getRow($od->getVehicleType());
		$driverprice=$od->getDriversPrice()*($return+1);
		
		switch ($od->getPaymentMethod()) {
			case 1:
				$pm="Online";
				break;
			case 2:
				$pm="Cash";
				break;
			case 3:
				$pm="Online+Cash";
				break;
			default:
				$pm="Invoice";
				break;		
		}		
		
		$ok = $oe->getKeysBy('ID', 'ASC', " WHERE OrderDetailsID = " . $od->getDetailsID());

		$extras_all=array();
		if( count($ok) > 0) {
			foreach ($ok as $id) {
				$extras_arr=array();
				$oe->getRow($id);
				$extras_arr = array_merge($extras_arr, array("ServiceName" => $oe->getServiceName()),array("Qty" => $oe->getQty()));
				$extras_all[]=$extras_arr;
			}	
		}	 
		

		//$style1=	"color:red; font-size:120%";
		$style1=	"font-size:120%"; 
		$style2=	"font-size:120%";
		$style3=    "text-decoration:none; padding:5px; background-color: #3c8dbc; border-color: #367fa9; font-size:140%; color:white;  border-radius: 5px; -webkit-box-shadow: none; box-shadow: none; border: 1px solid transparent;"; 
		
		$footer="
		<table style='border:none;border-collapse:collapse'>
			<tbody>
			<tr style='height:0pt'>
				<td style='border-width:1pt;border-style:solid;border-color:rgb(255,255,255) rgb(0,0,0) rgb(255,255,255) rgb(255,255,255);vertical-align:top'>
					<br>&nbsp; &nbsp;
					&nbsp;&nbsp;<img alt='unnamed.png' src='https://lh4.googleusercontent.com/HhGsJG7Ld3bYiJBtgwK-GKU4xRhwptqiSTtgV763Pxw52J-I0UKA-GCehUFzdx90-SkgX-IEtGGqmA6Omb3N28OMjFA8psU9782aBxkH2SS7Y2gGLcDVttAtUvhNEYEzdGBkZ1kh' width='107' height='91' style='border:none'>
				</td>
				<td style='border-width:1pt;border-style:solid;border-color:rgb(255,255,255) rgb(255,255,255) rgb(255,255,255) rgb(0,0,0);vertical-align:middle;padding:5pt'>


					<p dir='ltr' style='line-height:1.656;margin-top:0pt;margin-bottom:0pt'>
						<span style='font-size:8pt;font-family:Arial;background-color:transparent;vertical-align:baseline;white-space:pre-wrap'><font color='#000000'><b>Phone: +44 20 8610 3500</b></font></span>
					</p>
					<p dir='ltr' style='line-height:1.38;margin-top:0pt;margin-bottom:0pt'>
						<a href='http://www.jamtransfer.com/' style='color:rgb(17,85,204)' target='_blank'><span style='font-size:8pt;font-family:Arial;color:rgb(0,0,0);background-color:transparent;vertical-align:baseline;white-space:pre-wrap'><b>www.jamtransfer.com</b></span></a>
					</p>
					<p dir='ltr' style='line-height:1.38;margin-top:0pt;margin-bottom:0pt'>
						<b><span style='font-size:8pt;font-family:Arial;color:rgb(17,85,204);background-color:transparent;vertical-align:baseline;white-space:pre-wrap'><a href='https://www.facebook.com/jamtransfer/' style='color:rgb(17,85,204)' target='_blank'><img alt='Asset_2-128.png' src='https://lh6.googleusercontent.com/V3FhFDvLidlLMHvoTmhfOyBT5J2GhuYxGlnIw4Kw8v3lMCka_jUGu8FuG0EhYdt-Ijceg6f4cr2oaUMWwnHLpeYFLB3KnpsSySOWHBFMulQEdhMBHLmfHGGMFn7PkDnzgJqVBTRq' width='20' height='20' style='border:none'></a> </span><span style='font-size:8pt;font-family:Arial;color:rgb(17,85,204);background-color:transparent;vertical-align:baseline;white-space:pre-wrap'><a href='https://www.linkedin.com/company/jam-transfer' style='color:rgb(17,85,204)' target='_blank'><img alt='Asset_5-128.png' src='https://lh5.googleusercontent.com/K1AXLHmNv5i2FOVvCr9WBRP0K-lUwR4odhW_DHVFiRS9WYAV50DnS3JfofcWMjg8lNmiiuNwxZQtWnXZswsPlEeiGtZsaI1obj3X8Mm_pcUV7KgM8FuLWLCaNfjk1VQAzJ7m9SUz' width='20' height='20' style='border:none'></a> </span><span style='font-size:8pt;font-family:Arial;color:rgb(17,85,204);background-color:transparent;vertical-align:baseline;white-space:pre-wrap'><a href='https://www.instagram.com/jamtransfer/' style='color:rgb(17,85,204)' target='_blank'><img alt='Asset_16-128.png' src='https://lh6.googleusercontent.com/Ht9hL4V7afA2Vdw2TVKnceiDNf6qky7dxWu-zrp3RqOGhJawuZaH7I9oU-t75UPwPBdxBKanRO4vkE_Enlzx-i1kfI47Wc0MdAu0WlW_IeehzU5UXIeAIS9oe0AMcSVlxMB6VSi4' width='20' height='20' style='border:none'></a> </span><a href='https://twitter.com/JamTransfer' style='color:rgb(17,85,204)' target='_blank'><span style='font-size:8pt;font-family:Arial;background-color:transparent;vertical-align:baseline;white-space:pre-wrap'><img alt='Asset_3-128.png' src='https://lh6.googleusercontent.com/vCRtXMUDS22JJBXfUUvii63BIBQMsnX5QrelTFiPkSwbSquPPZ9eclwXAU5nyXiPGYmMrh3Q0JF8qlbEOvedieB_oY2YGMu6UhIgXkNzAKMXb1L87EVpdQOrAFEkNJnru7pX2T4z' width='20' height='20' style='border:none'></span></a></b>
					</p>
					<p dir='ltr' style='line-height:1.38;margin-top:0pt;margin-bottom:0pt'>
						<a href='http://ww2.feefo.com/en-US/reviews/j-a-m-transfer' style='color:rgb(17,85,204)' target='_blank'><span style='font-size:8pt;font-family:Arial;background-color:transparent;vertical-align:baseline;white-space:pre-wrap'><b><img alt='unnamed1.png' src='https://lh4.googleusercontent.com/DQ9ehXqQy51jZ2plYEX0J-ilPmLm5s0mK209DifW0WI9BxduriFCn-5c-kZD9NAobnZIHbCCEcYHkAKIlLMYYsYSIEkTahH_66SFCpWcdYPG7Puv3yf-zoayC3Rg2bM5gRxmrciS' width='146' height='34' style='border:none'></b></span></a>
					</p>
					<p dir='ltr' style='line-height:1.38;margin-top:0pt;margin-bottom:0pt'>
						<a href='https://www.tripadvisor.com/Attraction_Review-g187265-d10955395-Reviews-Jam_Transfer-Lyon_Rhone_Auvergne_Rhone_Alpes.html' style='color:rgb(17,85,204)' target='_blank'><span style='font-size:8pt;font-family:Arial;background-color:transparent;vertical-align:baseline;white-space:pre-wrap'><b><img src='https://lh3.googleusercontent.com/dPruLELARLQIt7fY1R0rN0C1roC49-HFFctN8Ht2kwT_7sMDJHcj2X0LgOS0EybfScQuFQxe_0roinDL7OxQy2OKmyJUgFIIKAS0FIG4T_4rFHqsgRvlq3Y5siGg2lMHJBAQEkoo' width='150' height='41' style='border:none'></b></span></a>
					</p></td>
			</tr>
			</tbody>
		</table>
		";		
		
		$html="<p style='".$style2."' >Hi dear colleagues,</p>";
		
		if ($requestType==1)
			$html.="<p style='".$style2."'>we have request from the client, please check all details and click on confirmation link if all details are correct and suitable for you.</p>
				<p style='".$style2."'><u>If you confirm it, this is just information to Jam Transfer that you have available vehicle and the price is suitable for you. If client confirms it, you will get an email with new transfer.</u></p><br>";
		else
			$html.="<p style='".$style2."'>we have request from the client, please check all details on the link below and give us your best price.</p><br>";
			
		if ($return==1) {
			$html.="<h4>FIRST TRANSFER</h4>";		
		}	
		$html.="
		<table>
			<tr><td width='200px' style='".$style1."'>	From:				</td><td style='".$style2."'>".$od->getPickupName()."</td></tr>
			<tr><td style='".$style1."'>	Pickup Address:		</td><td style='".$style2."'>".$od->getPickupAddress()."</td></tr> 
			<tr><td style='".$style1."'>	To:					</td><td style='".$style2."'>".$od->getDropName()."</td></tr>
			<tr><td style='".$style1."'>	Drop-Off Address:	</td><td style='".$style2."'>".$od->getDropAddress()."</td></tr>
			<tr><td style='".$style1."'>	Pickup date:		</td><td style='".$style2."'>".$od->getPickupDate()." (Y-M-D)</td></tr>
			<tr><td style='".$style1."'>	Pickup time:		</td><td style='".$style2."'>".$od->getPickupTime()." (H:M 24h)</td></tr>
			<tr><td style='".$style1."'>	Flight number:		</td><td style='".$style2."'>".$od->getFlightNo()."</td></tr>
			<tr><td style='".$style1."'>	Flight time:		</td><td style='".$style2."'>".$od->getFlightTime()."</td></tr>
		</table><br>
		";
		$lblDriverPrice="Drivers price";		
		if ($return==1) {
			$html.="<h4>RETURN TRANSFER</h4>";
			$od->getRow($oKey[1]);	
			$html.="<table>
				<tr><td width='200px' style='".$style1."'>	Pickup date:		</td><td style='".$style2."'>".$od->getPickupDate()." (Y-M-D)</td></tr>
				<tr><td style='".$style1."'>	Pickup time:		</td><td style='".$style2."'>".$od->getPickupTime()." (H:M 24h)</td></tr>
			</table><br>
			";		
			$returntime=$od->getPickupDate()." / ". $od->getPickupTime();	
			$od->getRow($oKey[0]);	
			$lblDriverPrice.=" (both directions)";
		}
		else $returntime=0; 
		
		$html.="
		<table>
			<tr><td width='200px' style='".$style1."'>	Passengers:			</td><td style='".$style2."'>".$paxno."</td></tr>
			<tr><td style='".$style1."'>	Vehicle Type:		</td><td style='".$style2."'>".$vt->getVehicleTypeName()."</td></tr>
		</table><br>";
		
		$ok = $oe->getKeysBy('ID', 'ASC', " WHERE OrderDetailsID = " . $od->getDetailsID());
		if( count($ok) > 0) {
		$html.="<h4>EXTRAS</h4>";			
		$html.="
		<table>";			
			foreach ($ok as $id) {
				$oe->getRow($id);
				$html.="
				<tr><td width='200px' style='".$style1."'>	".$oe->getServiceName().":	</td><td style='".$style2."'>".$oe->getQty()."</td></tr>";
			}	
		$html.="
		</table><br>";			
		}	
 
		if ($requestType==1) {
			$html.="
			<table>
				<tr><td width='200px' style='".$style1."'>	".$lblDriverPrice.":		</td><td style='".$style2."'>".number_format ($driverprice,2)." EUR</td></tr>
				<tr><td width='200px' style='".$style1."'>	Payment Method:		</td><td style='".$style2."'>".$pm."</td></tr> 
			</table><br>
			";			
			$html.="<span><a style='color:green; font-size:140%' href='".$link."'>CONFIRM!</a></span><span>&nbsp;</span><BR>
			<a style='color:red; font-size:140%' href='".$link2."'>DECLINE!</a>
			<br>"; 
		} 
		else $html.="<span><a style='".$style3."' href='".$link."'>CLICK HERE FOR YOUR OFFER</a></span>
					<span><a style='color:red; font-size:140%' href='".$link2."'>DECLINE!</a></span>
					<br><p style='".$style2."'>Thank you in advance.</p><br>";
			
		$html.="<p style=".$style2.">Kind regards,</p><br>"; 
		
		
		//$html.="<img src='https://www.jamtransfer.com/cms/img/jam.png'>";
		$html.=$footer;
	}

	$message=$html;
	$replyto="info@jamtransfer.com";
	$from_mail="info@jamtransfer.com";
	$from_name="JamTransfer.com";
	
	$mail->CharSet = 'UTF-8'; 
	$mail->setFrom($from_mail, $from_name);
	$mail->addAddress($mailto);									// Add a recipient
	$mail->addReplyTo($replyto, $from_name);

	//if($attachment != '') $mail->addAttachment($attachment);	// Add attachments
	$mail->isHTML(true);										// Set email format to HTML

	$mail->Subject = $subject;
	$mail->Body    = $message;

	if(!$mail->send()) {
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		$res = array(
					'OrderID'=>$OrderID,
					'DriverID'=>$DriverID,
					'requestType'=>$requestType,
					'returnTransfer'=>$returnTransfer
					);
					
		echo json_encode($res);
	}	
	

