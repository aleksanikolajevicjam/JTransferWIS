<? error_reporting(E_ALL) ?>

					<? require_once $modulesPath . '/smallBoxes.Driver.php'; ?>
					<? require_once $modulesPath . '/emptyRow.php'; ?>
					
<?
	    $fakeDriverFound = false;
	    require_once ROOT . '/cms/fixDriverID.php';
	    foreach($fakeDrivers as $key => $fakeDriverID) {
            if($_SESSION['AuthUserID'] == $fakeDriverID) {
                $fakeDriverFound = true; 
            }
        }
        if($fakeDriverFound == false) require_once $modulesPath . '/calendarPlugin.php';



?>
                    
                    <? //require_once $modulesPath . '/calendarPlugin.php'; ?>
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-6 xconnectedSortable"> 
							<? require_once $modulesPath . '/todo.php'; ?>
                        </section><!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-6 xconnectedSortable">
							<? //require_once 'modules/map.php'; ?>
							<? //require_once 'modules/chat.php'; ?>
							<? require_once $modulesPath . '/quickEmail.php'; ?>
                        </section><!-- right col -->
                    </div><!-- /.row (main row) -->                    
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="js/theme/dashboard.js" type="text/javascript"></script>  
	

<?
#<div class="grid xgrid-pad ">
#	<div class="col-1-3">
#		<div class="pad1em lgray shadow">
#			<h1 id="r-Head">Recent activity</h1>
#		</div>
#		<div class="white  pad1em em15 shadow hidden">
#			<h1 id="r-Det">Recent activity</h1>
#			Transfer: 1022 accepted<br>
#			Transfer: 0988 DECLINED<br>
#			Prices updated<br>
#			Transfer: 2233 Confirmed<br>
#		</div>
#	</div>


#	<div class="col-1-3">
#		<div class="pad1em lgray shadow">
#			<h1 id="m-Head">Messages</h1>
#		</div>
#		<div class="white pad1em em15 shadow hidden">
#			<h1 id="m-Det">Messages</h1>
#			From: Admin | Date: 2014-01-31<br>
#			Subject: Server downtime
#			<hr>
#			From: Admin | Date: 2014-01-31<br>
#			Subject: Server downtime
#			<hr>
#			From: Admin | Date: 2014-01-31<br>
#			Subject: Server downtime
#			<hr>
#			From: Admin | Date: 2014-01-31<br>
#			Subject: Server downtime
#			<hr>
#		</div>
#	</div>
#	<div class="col-1-3">
#		<div class="pad1em lgray shadow">
#			<h1 id="nt-Head">New Transfers</h1>
#		</div>
#		<div  class="white pad1em em15 shadow hidden">
#			<h1 id="nt-Det">New transfers</h1>
#			2345 Split Airport - Split Ferry Port<br>
#			2014-02-23 19:00 4 pax Fergusson
#			<hr>
#			2345 Split Airport - Split Ferry Port<br>
#			2014-02-23 19:00 4 pax Fergusson
#			<hr>
#			2345 Split Airport - Split Ferry Port<br>
#			2014-02-23 19:00 4 pax Fergusson
#			<hr>
#			2345 Split Airport - Split Ferry Port<br>
#			2014-02-23 19:00 4 pax Fergusson
#			<hr>
#			2345 Split Airport - Split Ferry Port<br>
#			2014-02-23 19:00 4 pax Fergusson
#			<hr>
#			2345 Split Airport - Split Ferry Port<br>
#			2014-02-23 19:00 4 pax Fergusson
#			<hr>
#			2345 Split Airport - Split Ferry Port<br>
#			2014-02-23 19:00 4 pax Fergusson
#			<hr>
#		</div>
#	</div>
#<!--	<div class="col-1-4">
#		<div class="pad1em blue shadow">
#			<h1 id="td-Head">To Do</h1>
#		</div>
#		<div  class="white pad1em em15 hidden">
#			<h1 id="td-Det">To do</h1>
#			<textarea grid grid-pads="4"></textarea>
#			<button id="btnToDo" name="btnToDo" type="submit" class="btn blue-1"> Save </button>
#		</div>
#	</div>-->
#</div>
#<!--
#<div class="grid grid-pad ">
#	<div class="col-1-1">
#		<div class="pad1em lgray shadow">
#			<h2 id="at-Head">Transfers</h2>
#		</div>
#		<div class="pad1em lgray shadow hidden">
#			<h1 id="at-Det">Transfers</h1>
#			<div id="allTransfers" class=" xem45"></div>
#			<br>
#			<br>
#		</div>
#	</div>
#</div>
#-->
#<div class="grid xgrid-pad ">
#	<div class="col-1-1">
#		<div class="pad1em lgray shadow">
#			<h2 id="ca-Head">Calendar</h2>
#		</div>
#		<div class="white pad1em lgray shadow hidden">
#			<h1 id="ca-Det">Calendar</h1>
#			<div id="showCalendar" class=" xem45"></div>
#			<br>
#			<br>
#		</div>
#	</div>
#</div>
#<div class="grid xgrid-pad ">
#	<div class="col-1-1">
#		<div class="lgray pad1em">
#			<h2>New Drivers</h2>
#			asdasdasdasd
#		</div>
#	</div>
#</div>
#<div class="grid xgrid-pad ">
#	<div class="col-1-3">
#		<div class="pad1em lgray em15">
#			<h2>Income statistics</h2>
#			asdasdasdasd
#		</div>
#	</div>

#	<div class="col-1-3">
#		<div class="lgray pad1em em15">
#			<h2>Reports</h2>
#			asdasdasdasd
#		</div>
#	</div>
#	<div class="col-1-3">
#		<div class="lgray pad1em em15">
#			<h2>Actions</h2>
#			<p><a id="pic" class='inline btn blue' href="http://dev2.jamtransfer.com/cms/activeTransfers.php">View picture</a></p>
#		</div>
#	</div>
#</div>
#<script>

#	// All Transfers AJAX LOAD
#	$("#ca-Head").click(function(){
#		// nema potrebe ucitavati ponovo. Bitno je da je ciljni div potpuno prazan!
#		if ($("#showCalendar").html() == '') {
#			$("#showCalendar").html('<h2><i class="ic-cloud-download"></i> Loading...</h2>');
#			$.get("../calendarPlugin.php",
#				function(data){
#					$("#showCalendar").html(data);
#					$("#ca-Det").parent().show();
#					$("#ca-Head").parent().hide();
#				}
#			);
#		}
#	});

#	// All Transfers AJAX LOAD
#	$("#at-Head").click(function(){
#		/*
#		// nema potrebe ucitavati ponovo. Bitno je da je ciljni div potpuno prazan!
#		if ($("#allTransfers").html() == '') {
#			$("#allTransfers").html('<h2><i class="ic-cloud-download"></i> Loading...</h2>');
#			$.get("activeTransfers.php",
#				function(data){
#					$("#allTransfers").html(data);
#					$("#at-Det").parent().show();
#					$("#at-Head").parent().hide();
#				}
#			);
#		}
#		*/
#		window.location.assign("index.php?p=transfers")
#	});

#	$("[id$=-Head]").click(function() {
#		var temp = $(this).attr('id');
#		var part = temp.split('-');
#		var el = part[0];
#		$("#"+el+"-Head").parent().hide();
#		$("#"+el+"-Det").parent().fadeIn('slow');

#	});

#	$("[id$=-Det]").click(function() {
#		var temp = $(this).attr('id');
#		var part = temp.split('-');
#		var el = part[0];
#		$("#"+el+"-Det").parent().hide();
#		$("#"+el+"-Head").parent().fadeIn('slow');
#	});
#</script>
