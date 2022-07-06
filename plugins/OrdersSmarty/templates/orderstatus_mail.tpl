

<!-- END MODULE: Menu 9 -->
OrderID {$order.orderid}<br>
User name {$user.name} {$user.surname}<br>
Shipping <br>
	{$shipping.name} {$shipping.surname} <br>
Adresa	{$shipping.address} <br>
Mesto   {$shipping.place} <br>
ptt		{$shipping.postalcode} <br>
tel		{$shipping.phone} <br>
email	{$shipping.email} <br> 

<table border='0' cellspacing='0' cellpadding='0' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;' width='100%'>
	<tbody>
		<tr>
			<td style='vertical-align: top; padding: 0; height: 8px; -webkit-text-size-adjust: 100%; font-size: 8px; line-height: 8px;' valign='top'>&nbsp;</td>
        </tr>
	</tbody>
</table>
<table border='0' cellpadding='0' cellspacing='0' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;' width='100%'>
	<tbody>
		<tr>
			<td class='pc-cta-box-s4' style='vertical-align: top; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1)' valign='top' bgcolor='#ffffff'>
				<table border='0' cellpadding='0' cellspacing='0' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;' width='100%'>
					<tbody>
						<tr>
							<td class='pc-cta-box-in' style='vertical-align: top; padding: 42px 40px 35px;' valign='top'>
								<table class='pc-cta-s1' border='0' cellpadding='0' cellspacing='0' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;' width='100%'>
                                    <tbody>
									  <tr>
                                        <td class="pc-fb-font" style="vertical-align: top; font-family: 'Fira Sans', Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 500; line-height: 1.43; color: #40BE65; text-align: center;" valign="top" align="center">Hello {$name},</td>
                                      </tr>

										<tr>
											<td style='vertical-align: top; height: 12px; font-size: 12px; line-height: 12px;' valign='top'>&nbsp;</td>
										</tr>
										<tr>
											<td class='pc-cta-title pc-fb-font' style='vertical-align: top; font-family: Fira San, Helvetica, Arial, sans-serif; font-size: 36px; font-weight: 900; line-height: 1.28; letter-spacing: -0.6px; color: #151515; text-align: center;' valign='top' align='center'>Order status changed </td>
										</tr>

										<tr>
											<td style='vertical-align: top; height: 20px; line-height: 20px; font-size: 20px;' valign='top'>&nbsp;</td>
										</tr>
										<tr>
											<td class='pc-cta-text pc-fb-font' style='vertical-align: top; font-family: Fira San, Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 1.56; color: #9B9B9B; text-align: center;' valign='top' align='center'> Your Order number {$order.orderid} has been shipped.</td>
										</tr>
										<tr>
											<td style='vertical-align: top; height: 20px; line-height: 20px; font-size: 20px;' valign='top'>&nbsp;</td>
										</tr>
										<tr>
											<td class='pc-cta-text pc-fb-font' style='vertical-align: top; font-family: Fira San, Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 1.56; color: #9B9B9B; text-align: center;' valign='top' align='center'> {$PLG_DISTRIBUTOR}: {$order.distributor} </td>
										</tr>		
										<tr>
											<td class='pc-cta-text pc-fb-font' style='vertical-align: top; font-family: Fira San, Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 1.56; color: #9B9B9B; text-align: center;' valign='top' align='center'> {$PLG_SHPCODE}: {$order.shpcode}</td>
										</tr>	
										<tr>
											<td class='pc-cta-text pc-fb-font' style='vertical-align: top; font-family: Fira San, Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 1.56; color: #9B9B9B; text-align: center;' valign='top' align='center'> <a href='{$order.dlink}'>{$PLG_DLINK}</a></td>
										</tr>											
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
				  
				   <!-- END MODULE: Call to action 5 -->