<? 
	require_once 'transfers_JS.php';
	$_REQUEST['rec_no']=$pathVars->fetchByIndex($indexStart + $size - 1);
	$inList = 'false'; 
	require_once $modulesPath .'/transfers/transferEditForm.'.$_SESSION['GroupProfile'].'.php' 
	
?>

<!-- PLACEHOLDER DIV za Edit Form -->
<div id="transferWrapper<?= $_REQUEST['rec_no']?>" class="editFrame" >
	<div id="inlineContent<?= $_REQUEST['rec_no']?>" class="container-fluid ">
		<div id="oneTransfer<?= $_REQUEST['rec_no']?>" class="xcol-md-12">
			Loading...
		</div>
	</div>
</div>
<script type="text/javascript">
	showOneTransfer(<?= $_REQUEST['rec_no']?>, false);
</script>
