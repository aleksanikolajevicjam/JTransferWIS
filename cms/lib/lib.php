<?
/*
	SHORTCUTS
*/	
function r($value) {
	if(isset($_REQUEST[$value])) return $_REQUEST[$value];
	else return '';
}

function s($value) {
	if(isset($_SESSION[$value])) return $_SESSION[$value];
	else return '';
}

function is($value, $type='s') {
	if ($type == 's') {
		if( isset($_SESSION[$value]) and 
		($_SESSION[$value] != '' or $_SESSION[$value] != 0 or $_SESSION[$value] != NULL)
		) return true;
	}
	if ($type == 'r') {
		if( isset($_REQUEST[$value]) and 
		($_REQUEST[$value] != '' or $_REQUEST[$value] != 0 or $_REQUEST[$value] != NULL)
		) return true;
	}
	
	return false;
}




/*
	Kreira tabelu za datatables
	
	Primjer:
	
	$headers = array(
	'ID',
	'Date / Time',
	'Route',
	'PaxName',
	'PaxNo'
	);
	
	CreateTable('MyTable', $headers);
	
*/
	
function CreateTable($name, $headers) {
	echo '<table width="100%" cellpadding="0" cellspacing="0" border="0" class="display" id="'.$name.'"><thead><tr>';
	foreach ($headers as $h => $header)
	{
		echo '<th>' . $header . '</th>';
	}
	echo '</tr></thead><tbody><tr><td colspan="'.count($headers).'">Loading data from server</td></tr>';
	//echo '</tr></thead><tbody>';
	/*
	for($i=1; $i<50; $i++) {
		echo '<tr>';
		foreach( $headers as $k => $v) {
			echo '<td>'.rand().'</td>';
		}
		echo '</tr>';
	}
	*/
	echo '</tbody><tfoot><tr>';
	
	foreach ($headers as $f => $footer)	
	{
		echo '<th></th>';
	}	
	
	echo '</tr></tfoot></table>';
	
}


/*
	Funkcija za kreiranje TransferStatus dropdowna
	Parametri: 
		$status = TransferStatus, 
		$field 	= field name,
		$style 	= class
*/

function SelectTransferStatus($status, $field, $style=NULL) {

	echo '		<select id="'.$field.'" name="'.$field.'" class="'.$style.'">
						<option value="0"> --- </option>';

						foreach($StatusDescription as $val => $text) {
							echo  '<option value="'.$val.'"';
							if ($status == $val) echo ' selected="selected" ';
							echo '>' . $text . '</option>';
						}		

	echo '		</select>';

} # end SelectTransferStatus	
