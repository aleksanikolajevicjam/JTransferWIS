 <?
	require_once ROOT . '/db/v4_OrdersMaster.class.php';
	require_once ROOT . '/db/v4_OrderDetails.class.php';
	
	$od = new v4_OrderDetails();
	$om = new v4_OrdersMaster();
	
	$details = array();
	
	$oid = $_REQUEST['oid']; // OrderID
	$Date = date("Y-m-d"); // invoice date
	$dueDate = date('Y-m-d', strtotime($Date. ' + 10 days'));
	
	$whereM = " WHERE MOrderID = '" .$oid ."'";
	
	$k = $om->getKeysBy('MOrderID', 'asc', $whereM);
	
	if ($k[0] == $oid) {
		$om->getRow($k[0]);
		
		$whereD = " WHERE OrderID ='" . $oid ."'";
		$kd = $od->getKeysBy('DetailsID', 'asc', $whereD);
		
		foreach($kd as $nn => $id) {
			$od->getRow($id);
			$details[] =  $od->fieldValues();
		}
	}
 
 //print_r($details);
 
 $driver = getUserData($details[0]['DriverID']);
 
 ?>
 
 <!-- Content Wrapper. Contains page content -->
  <div class="container" style="width:100% !important">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="invoice pad1em">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header" style="text-transform:none !important">
          <span class="l" style="font-family: Arial, sans-serif;" >
		  <span style="font-weight:300;color:black;"><span style="color:#f44336;">&#9670;</span><span style="color:black;font-weight:bold;">jam</span>transfer.com</span>
		  </span>
            <small class="pull-right">Date: <?= date("Y-m-d")?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-xs-4 invoice-col">
          From:
          <address>
            <strong><?= s('co_name') ?></strong><br>
            <?= s('co_address') ?><br>
			<?= s('co_zip') ?> <?= s('co_city') ?><br>
			<?= s('co_country') ?><br>
            Phone: <?= s('co_tel') ?><br>
            Email: <?= s('co_email') ?>
          </address>
        </div>
		
        <!-- /.col -->
        <div class="col-xs-4 invoice-col">
          To:
          <address>
            <strong><?= $driver['AuthUserCompany'] ?></strong><br>
            <?= $driver['AuthCoAddress'] ?><br>
            <?= $driver['City'] ?><br>
			<?= $driver['Country'] ?><br>
            Phone: <?= $driver['AuthUserTel'] ?><br>
            Email: <?= $driver['AuthUserMail'] ?><br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-xs-4 invoice-col">
          <b>Invoice #: 007612</b><br>
          <br>
          <b>Issued:</b> <?= $Date ?><br>
		  <!--<b>Order ID:</b> <?= $om->getMOrderKey() .'-'.$om->getMOrderID() ?><br>-->
          <b>Payment Due:</b> <?= $dueDate ?><br>
			<strong>IBAN: </strong>RS35160005390000039819<br>
			<strong>SWIFT: </strong>DBDBRSBG
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped table-bordered">
            <thead>
            <tr>
              <th>Order ID</th>
              <th>Date/Time</th>
              <th>Service/Pax Name</th>
              <th>Tax</th>
			  <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
 
			<? foreach($details as $key => $det) { ?>
				
				<? $detPrice = nf($det['DetailPrice'] - $det['DriversPrice']); ?>
				
			<tr>
              <td><?= $det['OrderID']. '-' . $det['TNo'] ?></td>
              <td><?= $det['PickupDate']?> / <?= $det['PickupTime']?></td>
			  <td>
				<?= $det['PickupName']?> - <?= $det['DropName']?><br>
				<small><?= $det['PaxName']?></small>
			  </td>
              
			  <td>0.00%</td>
              <td><?= $detPrice ?> Eur</td>
            </tr>
			<? 
			$subTotal += $detPrice;
			
			} ?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
          <p class="lead">INSTRUCTIONS FOR EUR PAYMENT:</p>
			<p class="s">
			<br>
			Company:  Taxido.net doo 
			<br>
			Address: Radojke Lakic 6, 11000 Belgrade, Republic of Serbia
			<br>
			IBAN: RS35160005390000039819
			<br>
			SWIFT: DBDBRSBG
			<br>
			You are required to fully cover the bank transaction fees.<br>
			Please, use the option (payment instruction) OUR
			<br>
			Payment is due within the 15 days<br>
			</p>
          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            This Invoice is valid without signature or stamp.
          </p>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <p class="lead">Amount Due <?= $dueDate ?></p>

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Subtotal:</th>
                <td><?= nf($subTotal) ?> Eur</td>
              </tr>
              <tr>
                <th>Tax (0%)</th>
                <td>0.00 Eur</td>
              </tr>
              <tr>
                <th>Total:</th>
                <td><?= nf($subTotal) ?> Eur</td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <a onclick="window.print();" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
          <button type="button" class="btn btn-success pull-right hidden"><i class="fa fa-credit-card"></i> Submit Payment
          </button>
          <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Generate PDF
          </button>
        </div>
      </div>
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
  </div>
  <!-- /.content-wrapper -->