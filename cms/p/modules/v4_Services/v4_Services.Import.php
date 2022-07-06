<style>
	.green {
		background-color: green;	
	}
</style>
<?php
require_once ROOT. '/cms/f/db_funcs.php';

function get_file_extension($file_name) {
	return end(explode('.',$file_name));
}

function errors($error){
	if (!empty($error))
	{
			$i = 0;
			while ($i < count($error)){
			$showError.= '<div class="msg-error">'.$error[$i].'</div>';
			$i ++;}
			return $showError;
	}// close if empty errors
} // close function


if (isset($_POST['upfile'])){
// check feilds are not empty

	if(get_file_extension($_FILES["uploaded"]["name"])!= 'csv')
	{
		$error[] = 'Only CSV files accepted!';
	}

	if (!$error){

		echo '<div class="container"><table class="table table-striped">
			<thead>
				<tr>
					<td>RouteID</td>
					<td>VTypeID</td>
					<td>Route</td>
					<td>Vehicle</td>
					<td>OneWay</td>
					
					<td>Status</td>
				</tr>
			</thead>
		';
		$status = '';
		$tot = 0;
		$handle = fopen($_FILES["uploaded"]["tmp_name"], "r");

		//echo file_get_contents($_FILES["uploaded"]["tmp_name"]);

		// fgetcsv - Gets line from file pointer and parse for CSV fields
		// array fgetcsv ( resource $handle [, int $length = 0 [, string $delimiter = "," 
		//                 [, string  $enclosure = '"' [, string $escape = "\" ]]]] )

		while (($data = fgetcsv($handle, 1000, trim($_POST['delimiter']))) !== FALSE) {
			
			for ($c=0; $c < 1; $c++) {

					// only run if the first column if not equal to RID 
					// because RID is in a title row and we don't need that
					if($data[0] !='RID'){
						//print_r($data);

						$record = array(
										'ServicePrice1' => $data[4]//,
										//'ReturnPrice' => $data[5]	
									);

						$where = 	"OwnerID = '" . $_REQUEST['OwnerID'] . "' AND RouteID = '" .
									$data[0] . "' AND VehicleTypeID = '" . $data[1] . "' ";

						$nr = XRecords("v4_Services", $where, null, 'num_rows');

						if ($nr > 0) {
							$ok = XUpdate("v4_Services", $record, $where);
							if ($ok) $status = 'Updated'; 
						} else $status = 'Not found';

						echo '<tr>';
						echo '<td>' .$data[0] . '</td> ';
						echo '<td>' .$data[1] . '</td> ';
						echo '<td>' .$data[2] . '</td> ';
						echo '<td>' .$data[3] . '</td> ';
						echo '<td align="right">' .$data[4] . '</td> ';
						//echo '<td>' .$data[5] . '</td> ';
						echo '<td>' .$status . '</td> ';
						echo '</tr>';
					}

				$tot++;
			}
		}
		fclose($handle);

		echo '</table></div>';

		$content.= "<div class='alert alert-warning' id='message'> CSV File Imported, $tot records processed </div>";

	}// end no error
}//close if isset upfile
else {
$er = errors($error);
echo $er;

$url=str_replace('&Active=0','',$_SERVER['REQUEST_URI']);
$url=str_replace('&Active=1','',$url);
$notactiveurl=$url."&Active=0";
$activeurl=$url."&Active=1";

?>
<div class="container">
<h1><?= PRICES_IMPORT ?></h1>
	<div>
		<? if ( !isset($_REQUEST['Active'] )) { ?> 
			<a href = '<? echo $activeurl ?>' class=" btn green" ><i class=""></i>Active</a>
			<a href = '<? echo $notactiveurl ?>' class=" btn red" ><i class=""></i>Not Active</a>
		<? } ?>				
		<? if ( isset($_REQUEST['Active'] )) { ?> <a href = '<? echo $url ?>' class=" btn blue" ><i class=""></i>All</a>	<? } ?>						
		<? if ( isset($_REQUEST['Active']) && $_REQUEST['Active'] ==0 ) { ?> <a href = '<? echo $activeurl ?>' class=" btn green" ><i class=""></i>Active</a>	<? } ?>				
		<? if ( isset($_REQUEST['Active']) && $_REQUEST['Active'] ==1 ) { ?> <a href = '<? echo $notactiveurl ?>' class=" btn red" ><i class=""></i>Not Active</a>	<? } ?>		
		
	</div>
<form enctype="multipart/form-data" action="" method="post">
					<i class="fa fa-search"></i> <?= DRIVER ?>:<br>
					<select name="OwnerID" id="OwnerID"  class="w100">
						<option value="0"> --- </option>
			
						<?
						require_once '../db/v4_AuthUsers.class.php';

						# init class
						$au = new v4_AuthUsers();

						if (isset($_REQUEST['Active'])) {
							$auk = $au->getKeysBy('Country, Terminal, AuthUserCompany', 'asc', "WHERE AuthLevelID = 31 AND Active = ".$_REQUEST['Active']);
						}	
						else $auk = $au->getKeysBy('Country, Terminal, AuthUserCompany', 'asc', "WHERE AuthLevelID = 31");						
						

						foreach($auk as $n => $ID) {
		
							$au->getRow($ID);
							$terminal=substr($au->getTerminal(),0,100);
							if (strlen($au->getTerminal())>100) $terminal.="...";
							
							echo '<option value="'.$au->getAuthUserID() .'">'.
									$au->getCountry().'-'.$terminal.'-'.$au->getAuthUserCompany().
								 '</option>';

						}
			
						?>
					</select>
	File: <br>
	<input name="uploaded" type="file" maxlength="20" class="form-control w50"/><br>
	Delimiter ( , or ; ) : <br>
	<input type="text" name="delimiter" value=";" class="form-control w25"><br><br>
	<input type="submit" name="upfile" value="Upload File" class="btn btn-danger">
</form>
</div>	
<? } ?>
