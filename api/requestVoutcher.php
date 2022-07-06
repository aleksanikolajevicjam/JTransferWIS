<? 

	ini_set('display_errors', 1);
	ini_set('log_errors', 1);
	ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
	error_reporting(E_ALL);

	@session_start();
	
	$OrderKey=$_REQUEST['OrderKey'];
	
	
	require_once ROOT .'/f2/f.php';
    require_once ROOT .'/db/db.class.php';
	require_once ROOT .'/db/v4_AuthUsers.class.php';
	require_once ROOT .'/db/v4_OrderDetails.class.php';
	require_once ROOT .'/db/v4_OrdersMaster.class.php';
	require_once ROOT .'/db/v4_OrderExtras.class.php';
	require_once ROOT .'/db/v4_VehicleTypes.class.php';

	require_once ROOT . '/PHPMailer-master/PHPMailerAutoload.php';
	require_once ROOT . '/common/libs/Smarty.class.php'; 
	//require_once ROOT . '/cms/headerScripts.php';


	$mail = new PHPMailer;
	
 
	$db = new DataBaseMysql(); 
	$u = new v4_AuthUsers();
	$od = new v4_OrderDetails();
	$om = new v4_OrdersMaster();
	$oe = new v4_OrderExtras();
	$vt = new v4_VehicleTypes();
	
	$smarty = new Smarty;
	
    $voutcerorderKey = create_order_key();
	$OrderKey=$_REQUEST['OrderKey'];
	$OrderID=$_REQUEST['OrderID'];
	$VoutcherValue=$_REQUEST['VoutcherValue'];
	
	$where=" WHERE MOrderKey = '".$OrderKey."' AND MOrderID=".$OrderID."";

	$omK = $om->getKeysBy('MOrderID', 'ASC', $where);
	$om->getRow($omK[0]);
	$mailto=$om->getMPaxEmail();
	/*$u->getRow($_SESSION['AuthUserID']); //za test 
	$mailto=$u->getAuthUserMail();*/
	
	
	
	$OrderID=$om->getMOrderID();
	$query="INSERT INTO `v4_VoutcherOrderRequests`(`OrderKey`,`OrderID`, `Email`,`VoutcherValue`, `RequestDate`, `RequestTime`) 
		VALUES ('".$voutcerorderKey."',".$OrderID.",'".$mailto."',".$VoutcherValue.",NOW(),NOW()) ";
	$result = $db->RunQuery($query);

	$requestID=$db->insert_id();


	// generate pdf
	$PDFfile = 	'/cms/pdfvoutcher/'.$voutcerorderKey.'-'.$OrderID.'.pdf';
	ob_start();
	?>
	<style>
	.col-md-1 {
		float:left;
		width:8.33%;
	}		
	.col-md-2 {
		float:left;
		width:16.66%;
	}	
	.col-md-3 {
		float:left;
		width:25%;
	}		
	.col-md-4 {
		float:left;
		width:33.32%;
	}
	.col-md-5 {
		float:left;
		width:41.66%;
	}		
	.col-md-6 {
		float:left;
		width:50%;
	}
	.col-md-7 {
		float:left;
		width:58.33%;
	}		
	.col-md-8 {
		float:left;
		width:66.66%;
	}	
	.col-md-9 {
		float:left;
		width:75%;
	}		
	.col-md-10 {
		float:left;
		width:83.33%;
	}
	.col-md-11 {
		float:left;
		width:91.66%;
	}		
	.col-md-12 {
		float:left;
		width:100%;
	}	
	.bluefonts	{
		font-size:40px; 
		color:  #00394d; 
		text-align: center; 
		line-height: 40px; 
		font-weight: 450;	
	}	
	</style>
	<div class="container"> 
		<div style="width:100%">
			<br>
			<div class="row" style="margin-top:40px;"> 
				<div class="col-md-1" >&nbsp;</div>		
				<div class="col-md-6" >

					<div class="col-md-8 bluefonts" style="border: 1px solid black;">
							TRANSFER<br>VOUCHER
					</div>	
					<div class="col-md-12" style="font-size:10px; padding:10px">
						To claim this voucher, enter voucher number while you making the booking (in the “note” field) or contact our support center for help 	
					</div>
				</div>
				<div class="col-md-3" >
					<img style="height:45px;" src='https://www.jamtransfer.com/cms/img/jam.png'><br>
					<span class="bluefonts" style="text-align:right"><?= number_format($VoutcherValue,2) ?>€</span><br>
					<span class="bluefonts" style="text-align:right; font-size:25px;">DISCOUNT</span><br>					
				</div> 
			</div>
			<br>
			<div class="row" style="border: 50px solid  #00394d; font-size:17px; padding:25px;">
				Presented to: <strong><?=strtoupper($om->getMPaxFirstName())?> <?=strtoupper($om->getMPaxLastName())?></strong><br>
				Value of €: <strong><?= number_format($VoutcherValue,2) ?></strong><br>
				Date Issued: <strong><?=date("Y-m-d") ?></strong><br>
				Voucher No. <strong><?=$voutcerorderKey ?></strong><br><br>
				Terms and Conditions:<br><br>
				This voucher can only be used for a payment of transfer service booked online at jamtransfer.com. It can't be exchanged for money. It is valid in the next 2 years from date issued for all the services Jam Transfer have in the official portfolio presented on website.  It can't be transferred to other persons .
				If you need assistance, contact our friendly customer service team on info@jamtransfer.com or via phone.
			</div>
		</div>
	</div>
	<?
	$html = ob_get_contents();
	ob_end_clean();
	@unlink(ROOT .$PDFfile);
	require_once ROOT ."/mpdf60/mpdf.php";
	$mpdf = new mPDF('c', 'A4-L');  
	$mpdf->SetDisplayMode('fullpage');
	$stylesheet = file_get_contents('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css').
				  file_get_contents('css/simplegrid.css');
	/*$stylesheet .= '
		table {font-family:"Roboto",sans-serif;font-size:10px !important}
		.nav, .footer {display:none}
		button, .btn, .pdfHide {visibility:screenonly !important;display:none !important}	
		.pdf-input {border-color:white !important;background-color:white !important}
	';*/
	$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
	$mpdf->WriteHTML($html); 
	$content = $mpdf->Output('', 'S');
	$content = chunk_split(base64_encode($content));
	$mpdf->Output(ROOT .$PDFfile);	

	$link1 = 'https://' . $_SERVER['SERVER_NAME'] . '/cms/requestVResponse.php?key='.$voutcerorderKey.'&cd=1'; 
	$link2 = 'https://' . $_SERVER['SERVER_NAME'] . '/cms/requestVResponse.php?key='.$voutcerorderKey.'&cd=2'; 


	$subject="Transfer Voucher Request";

	$query="SELECT * FROM `v4_VoutcherOrderRequests` WHERE ID=".$requestID;
	
	$result = $db->RunQuery($query);
	while($row = $result->fetch_array(MYSQLI_ASSOC)){ 
		$out_arr=$row;
		
		$oKeyC = $od->getKeysBy('OrderID', 'ASC', ' WHERE OrderID = ' .$OrderID);
		if (count($oKeyC)==2) $return=1;
		else $return=0;
		$oKey = $od->getKeysBy('OrderID', 'ASC', ' WHERE OrderID = ' .$OrderID. ' AND TNo = 1');
		$od->getRow($oKey[0]);

		$route=$od->getPickupName()." - ".$od->getDropName();
		$pickupname=$od->getPickupName();
		$dropname=$od->getDropName();
		if ($return==1) $route.="/ <b>both directions</b>";
		$pickuptime=$od->getPickupDate()." / ". $od->getPickupTime();
		$paxno=$od->getPaxNo();
		$vt->getRow($od->getVehicleType());
		$price=$od->getPayNow()*($return+1);		
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
		
		$html="<p style='".$style2."' >Dear,</p>";
		
		$html.="<p style='".$style2."'>
			Due to COVID-19 situation and recommendation of <a href='https://ec.europa.eu/transport/sites/transport/files/legislation/c20201830_en.pdf'>Europian commission and their guidelines on EU passenger rights regulations</a> as well as national government instructions, Jam Transfer Ltd has decided to update <a href='https://jamtransfer.com/terms'>T&C, CANCELATION section.</a>
			Even do EU and national governments regulations issued due COVID 19 situation does not obligately Jam transfer Ltd to make any refund for a canceled trip caused by the virus or flight cancellation, resort closing, etc Jam Transfer as on socially responsible and client-oriented company made the following decision:
			<br>Jam transfer is giving you the opportunity to take a voucher in the value of the refund expected to receive and use it when circumstances are right for your dream holiday. You can use it for any destinations of Jam transfer portfolio (Europe, America, Asia, Latin America, Africa...) and if the new transfer is less value than voucher is, no problem, you can use it again until you spent the whole amount from the voucher. If the price of the new transfer is higher then the voucher value, you will pay the difference.
			<br><br>
			Your name: ".strtoupper($om->getMPaxFirstName())." ".strtoupper($om->getMPaxLastName())." <br>
			Your payment: ".number_format($om->getMPayNow(),2)." <br>
			Prepayment voucher value: ".number_format($VoutcherValue,2)." <br>
			<br><b>If you choose to take a voucher <a href='".$link1."'>click here for request</a></b>.
			<br><br><b>If you rather want to wait for a refund please click <a href='".$link2."'>here</a> and be aware of a new deadline for the refund process caused by the COVID 19.</b>
			<br><br><br>* Please note the deadline for feedback is 5 days if you do not choose voucher or a refund Jam transfer will continue via refund process which will take significantly higher due to COVID 19 situations
			</p>";
			
		/*$html.="<h4>YOUR TRANSFER</h4>";	
		$html.="<b>".$od->getPickupName()."-".$od->getDropName()."</b> / ".$od->getPickupDate()." ".$od->getPickupTime()." (Y-M-D H:M 24h) ";
		if ($return==1) {
			$oKey = $od->getKeysBy('OrderID', 'ASC', ' WHERE OrderID = ' .$OrderID. ' AND TNo = 2');
			$od->getRow($oKey[0]);	
			$html.="    <b>RETURN</b> / ". $od->getPickupDate()." ".$od->getPickupTime()." (Y-M-D H:M 24h) ";
		}
		else $returntime=0; 
		
		$html.="
		<table>
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
		$html.="
		<table>
			<tr><td width='200px' style='".$style1."'>	Paid:		</td><td style='".$style2."'>".number_format ($price,2)." EUR</td></tr>
			<tr><td width='200px' style='".$style1."'>	Voutcher Value:		</td><td style='".$style2."'>".number_format ($out_arr['VoutcherValue'],2)." EUR</td></tr>			
		</table><br>
		";	*/		

		$html.="<p style=".$style2.">Kind regards,</p><br>"; 
		$html.=$footer;
	}

	/*$message=$html;
	$replyto="info@jamtransfer.com";
	$from_mail="info@jamtransfer.com";
	$from_name="JamTransfer.com";
	$mail->CharSet = 'UTF-8'; 
	$mail->setFrom($from_mail, $from_name);
	$mail->addAddress($mailto);									// Add a recipient
	$mail->addReplyTo($replyto, $from_name);
	$mail->isHTML(true);										// Set email format to HTML
	$mail->Subject = $subject;
	$mail->Body    = $message;

	if(!$mail->send()) { 
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		$pdflink = "<a target='_blank' href='".$PDFfile."'>".$voutcerorderKey."</a>";
		echo "Send request<br>".$pdflink." (".$VoutcherValue." EUR)";
	}*/
	
	$pdflink = "<a target='_blank' href='".$PDFfile."'>".$voutcerorderKey."</a>";
	$confirmlink = "<a target='_blank' href='".$link1."'>Confirm link</a>";
	$declinelink = "<a target='_blank' href='".$link2."'>Decline link</a>";	
	echo "Send request<br>".$pdflink." (".$VoutcherValue." EUR)<br>".$confirmlink."<br>".$declinelink;	
