<script type="text/javascript" language="javascript1.2">
{literal}
	function modify_plugin() {
	}
{/literal}
</script>

<div id="content">
	<form id='inner' name="editcategory" action="modify_final.php" method="post" enctype="multipart/form-data">
	<input name="mode" type="hidden" id="mode" value="{$mode}">
		<div class="row wrapper  page-heading">
			<div class="col-lg-8">
				<h2 id="modi_title"></h2>
				<h2>{$orderid}</h2>
			</div>
			<div class="col-lg-4">
				<div class="title-action">
					<div name="promeni" id="promeni" class="btn btn-primary "><i class="fa fa-check"></i>&nbsp;{$PLG_SAVE}</div>
					<div class="btn btn-default close-modal" type="button"><i class="fa fa-times"></i>&nbsp;{$PLG_CLOSE}</div>
				</div>
			</div>
		</div>


		<div class="row">
			<div class="col-lg-12">
				<div class="ibox">
                    <div class="ibox-content">
                         <div class="panel-body">
						 <fieldset class="form-horizontal">
                              <div class="row">
                                    <label class="col-sm-3 control-label">{$PLG_STATUS}</label>
									<div class="col-sm-9">
										<select name="statusid" id="statusid" class="form-control">
											{html_options values=$status_val selected=$status_sel output=$status_out}
										</select>
										<input type='hidden' name='ststusid2' id='statusid2' value='{$status_sel[0]}' />
									</div>

								</div>
								<div class="row">
                                    <label class="col-sm-3 control-label">
										<strong>{$PLG_TYPE}</strong>
									</label>
									<div class="col-md-9">
										<p class="form-control-static">{$ordertype}</p>
									</div>
								</div>
								<div class="row">
                                    <label class="col-sm-3 control-label">
										<strong>{$PLG_NAME}</strong>
									</label>
									<div class="col-md-9">
										<p class="form-control-static">{$user.name} {$user.surname}</p>
									</div>
								</div>
								<div class="row">
                                    <label class="col-sm-3 control-label">
										<strong>Naziv firme - PIB</strong>
									</label>
									<div class="col-md-9">
										<p class="form-control-static">{$user.firm} - {$user.pib}</p>
									</div>
								</div>
								<div class="row">
                                    <label class="col-sm-3 control-label">
										<strong>Adresa</strong>
									</label>
									<div class="col-md-9">
										<p class="form-control-static">{$user.address}</p>
									</div>
								</div>
								<div class="row">
                                    <label class="col-sm-3 control-label">
										<strong>{$PLG_POSTALCODE}</strong>
									</label>
									<div class="col-md-9">
										<p class="form-control-static">{$user.postalcode}</p>
									</div>
								</div>
								<div class="row">
                                    <label class="col-sm-3 control-label">
										<strong>{$PLG_PLACE}</strong>
									</label>
									<div class="col-md-9">
										<p class="form-control-static">{$user.place}</p>
									</div>
								</div>
								<div class="row">
                                    <label class="col-sm-3 control-label">
										<strong>{$PLG_PHONE}</strong>
									</label>
									<div class="col-md-9">
										<p class="form-control-static">{$user.phone}</p>
									</div>
								</div>
								<div class="row">
                                    <label class="col-sm-3 control-label">
										<strong>{$PLG_EMAIL}</strong>
									</label>
									<div class="col-md-9">
										<p class="form-control-static"><a href="mailto:{$user.email}">{$user.email}</a></p>
									</div>
								</div>
								<div class="row">
                  <label class="col-sm-3 control-label">
										<strong>Podaci za slanje</strong>
									</label>
									<div class="col-md-9">
										<p class="form-control-static">Ime i prezime: {$shipping.name} {$shipping.surname} <br>
									Adresa:	{$shipping.address} <br>
									Mesto:   {$shipping.place} <br>
									Poštanski broj:		{$shipping.postalcode} <br>
									Telefon:		{$shipping.phone} <br>
									E-mail:	{$shipping.email} <br> </p>
									</div>
								</div>

								

								<div class="row">
                                    <label class="col-sm-3 control-label">
										<strong>{$PLG_NOTE}</strong>
									</label>
									<div class="col-md-9">
										<p class="form-control-static">{$note}</p>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
					<div class="ibox-content">
                         <div class="panel-body">
							<div class="row wrapper  page-heading">
								<div class="col-lg-12">
									<h2>{$PLG_ORDERLIST}</h2>
								</div>
							</div>
                            <div class="row">
								<div class="col-lg-12">
									<div class="table-responsive">
										<table  border="0" cellspacing="0" class="table table-striped table-bordered table-hover dataTables-example dataTable">
											<thead>
											<tr class="heading">
												<th>{$PLG_NO}</th>
												<th>{$PLG_CODE}</th>
												<th>{$PLG_NAME}</th>
												<th>{$PLG_QUANTITY}</th>
												<th>{$PLG_PRICE}</th>
												<th class="right">{$PLG_AMOUNT}</th>
											</tr>
											</thead>
											{section name=cnt loop=$orderitem_proiz_nazivi}
											<tr>
												<td>{$orderitem_proiz_rb[cnt]} &nbsp;</td>
												<td>{$orderitem_proiz_sifre[cnt]} &nbsp;</td>
												<td>{$orderitem_proiz_nazivi[cnt]} &nbsp;</td>
												<td>{$orderitem_proiz_kolicine[cnt]} &nbsp;</td>
												<td>{$orderitem_proiz_cene[cnt]} din</td>
												<td class="right">{$orderitem_proiz_iznosi[cnt]} din</td>
											</tr>
											{/section}
											<tr>
											<TD colspan="5"><b>{$PLG_TOTAL}</b></TD>
											<td class="right"><strong> {$orderitem_proiz_ukupna_cena} din</strong> </td>
											</tr>
										</table>
									</div>
								</div>
							</div>
					</div>
				</div>
			</div>
		</div>


  	<input name="orderid" type="hidden" id="orderid" value="{$orderid}">
</form>
</div>
