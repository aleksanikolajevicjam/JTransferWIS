<?
#=====================================================================#
# FORM FUNCTIONS                                                      #
#=====================================================================#



# Create Form
function startForm($onsubmit = NULL)
{
	echo '<table align="center" class="bogoFormTable" >';
	echo '<form name="edit_form" id="edit_form" action="'.$_SERVER['PHP_SELF'].'" method="POST" onsubmit="'.$onsubmit.'">';
}


# Input Fields
function inField($desc, $name, $value, $fld_type, $length=NULL, $css_class=NULL,$lookupParams=NULL,$custom=NULL)
{

	#cleanup $value
	$value = clearVal($value);
	
	# duzina polja
	$fld_size = ($length > 40 ? 40 : $length);

	# pocetak reda
	echo '<tr><td>';
	echo '<span class="'.$css_class.'">'.$desc.' : </span>';
	echo '</td><td>';

	switch ($fld_type)
	{
		# textarea
		case 'text':
			echo '<textarea name="'.$name.'" id="'.$name.'" rows="5" cols="60"
			 class="tinymce '.$css_class.'">'.$value.'</textarea>';
		break;


		case 'password':
			# save old password value
			echo '
			<input name="h'.$name.'"
			id="h'.$name.'"
			type="hidden" value="'.$value.'"/>
			';

			$value = '******';

			echo '
			<input name="'.$name.'"
			 id="'.$name.'"
			 type="password" maxlength="'.$length.'"
			 class="'.$css_class.'"
			 size="'.$length.'"
			 value="'.$value.'"
			 onclick="this.value=\'\';" onfocus="this.select()" 
			 ';
			echo ' />';

			break;


		# sva ostala polja
		default:
				# clean-up value varijable
				$value = stripslashes($value);

				# Lookup Field
				if ( isset($lookupParams['Field']) )
				{
					doLookup(
					$lookupParams['Field'],
					$lookupParams['Table'],
					$lookupParams['Lookup_Key'],
					$lookupParams['Lookup_Text'],
					$lookupParams['Lookup_Query'],
					$lookupParams['Lookup_Type'],
					$value
					);
					break;
				}


                # Date Field
				if ( $fld_type == 'date' )
				{
					echo '<input name="'.$name.
				    '" id="'.$name.
				    '" type="text" maxlength="'.$fld_length.
				    '" class="date_pick" size="'.$fld_size.
				    '" value="'.$value.'"';
				    //echo 'onchange="date_pick"';
				    echo $custom;
				    echo ' />';

				    break;
				}



                # Time Field
				if ( $fld_type == 'time' )
				{
					echo '<input name="'.$name.
				    '" id="'.$name.
				    '" type="text" maxlength="'.$fld_length.
				    '" class="timepicker" size="'.$fld_size.
				    '" value="'.$value.'"';
				    
				    echo $custom;
				    echo ' />';

				    break;
				}

                # Display Field
				if ( $fld_type == 'display' )
				{
					if (!isset($css_class)) $css_class = 'bogoFormDisplay';

					echo '<span class="'.
					$css_class.'">'.
					$value.
					'</span>';

					break;
				}


                # Read Only Field
				if ( $fld_type == 'read' )
				{
					if (!isset($css_class)) $css_class = 'bogoFormDisplay';

				    echo '<input name="'.$name.
				    '" id="'.$name.
				    '" type="text"'.
				    '" class="'.$css_class.
				    '" size="'.$fld_size.
				    '" value="'.$value.'"
				    readonly="readonly" />';

					break;
				}


				# Other Fields
				echo '<input name="'.$name.
				'" id="'.$name.
				'" type="text"'.
				'" class="'.$css_class.
				'" size="'.$fld_size.
				'" value="'.$value.'"';
				echo $custom;
				echo ' />';
				
				break;
	}

	# kraj kolone i reda
	echo '</td></tr>';
}





#
# hidden polja
#
function hiddenField($name,$value)
{
	echo '<input name="'.$name.'" id="'.$name.'" type="hidden" value="'.$value.'" />';
}


#
# Empty Row
#
function emptyRow($content='&nbsp;')
{
	echo '<tr><td colspan="2">';
	echo $content;
	echo '</td></tr>';
}

#
# dno forma sa botunima
#
function endForm($allow_update=false,$allow_delete=false,$allow_back=true,$allow_insert=false,$updateTxt='Submit', $onclick=NULL )
{
	echo '<tr><td></td><td align="right">';
	echo '<input type="hidden" name="form_name" id="form_name" value="MyForm" />';

	# delete button
	if ($allow_delete)
	echo '<input type="submit" name="delete" id="delete" value="Delete"
	class="my_button"
	onclick="return confirm(\'Are you sure?\');"/>';

	# back button
	if ($allow_back)
	echo '<input type="submit" name="cancel" id="cancel" value="Back"
	class="my_button" />';

	# update button
	if ($allow_update)
	echo '<input type="submit" name="update" id="update" value="'.$updateTxt.'"
	class="my_button" onclick="'.$onclick.'"/>';

	# update button
	if ($allow_insert)
	echo '<input type="submit" name="insert" id="insert" value="'.$updateTxt.'"
	class="my_button" onclick="'.$onclick.'"/>';

	echo '</td></tr>';
	echo '</table>';
}






function doLookup($field, $table, $lookup_key, $lookup_text,
$lookup_query, $type='edit', $lookup_value)
{

		# dropdown za lookup polja
		if ($type=='edit'):

			$lQry = "SELECT * FROM ".$table.
			" ORDER BY ".$lookup_key." ASC";

			if (!empty($lookup_query)) $lQry = $lookup_query;


			$lRes = mysql_query($lQry) or die(mysql_error());
			$row = mysql_fetch_assoc($lRes);

			echo '<select name="'.$field.'" id="'.$field.'"
			 class="bogoSelect">';

			do
			{
				echo '<option ';

				if ($row[$lookup_key] == $lookup_value)
				echo ' selected="selected" ';

				echo 'value="'.$row[$lookup_key].'">'
				.$row[$lookup_text].'</option>';

			}

			while ($row = mysql_fetch_assoc($lRes));
			  $rows = mysql_num_rows($lRes);
			  if($rows > 0) {
				  mysql_data_seek($lRes, 0);
				  $row = mysql_fetch_assoc($lRes);
			  }

			echo '</select>';
		endif;

		# ako je lookup polje samo za prikaz
		if ($type == 'display'):
			$lQry = "SELECT * FROM ".$table.
					" WHERE ".$lookup_key." = ".$lookup_value.
					" ORDER BY ".$lookup_key." ASC";

			$lRes = mysql_query($lQry) or die(mysql_error());
			$row = mysql_fetch_assoc($lRes);

			echo '<input name="'.$field.'" id="'.$field.'"
			type="hidden" value="'.$lookup_value.'" />';

			echo '<p class="bogoFormDisplay">'.
			$row[$lookup_text].'</p>';
		endif;


		if ($type == 'simple'):
		
			echo '<select name="'.$field.'" id="'.$field.'"
			 class="bogoSelect">';
			
			foreach ($table as $key => $val)
			{
			    echo '<option ';

				if ($key == $lookup_value)
				echo ' selected="selected" ';

				echo 'value="'.$key.'">'
				.$val.'</option>';
			}
		
		echo '</select>';
		endif;
	
}


function moreTransfers($orderID, $detailsID)
{
	$lQry = "SELECT * FROM ".DB_PREFIX."OrderDetails
			 WHERE OrderID  = '".$orderID."'
			 AND DetailsID  != '".$detailsID."'
			 ORDER BY DetailsID ASC";

	$more = selectMultiRows($lQry);
	if ( !empty( $more ) )
	{
		for($i=0; $i < count($more); $i++)
		{

			$qry = "SELECT * FROM ".DB_PREFIX."AuthUsers
			WHERE AuthUserID = '".$more[$i]['DriverID']."'
			";
			$res = mysql_query($qry) or die(mysql_error());
			$row = mysql_fetch_assoc($res);

			# Driver Data
			$driver_email = $row['AuthUserMail'];
			$driver_name = $row['AuthUserRealName'];

			$link = '
			<a href="index.php?option=activeTransfers&action=edit&rec_no='.
			$more[$i]['DetailsID'].
			'" title="Related Transfer">Related Transfer </a>';

			inField($link,'RelatedTransfer',$more[$i]['DetailsID'].' - Driver: '
			. $driver_name,'display',40);
		}
	}
}


#
# Update table from $_POST
#

function updateFromPost($table, $keyField, $keyValue)
{
	# Start
	$sql = "UPDATE ".$table." SET ";

	# Get Variable Names and Values from $_POST
	foreach ($_POST as $field => $value)
	{
		if ($field != 'form_name' &&
		$field != 'update' &&
		$field != 'insert' &&
		$field != 'PHPSESSID' &&
		stripos($field,'SpryMedia') === false &&
		stripos($field,'__utm') === false &&
		$field != 'set'
		)
		{
		$sql .= $field." ='".mysql_real_escape_string(trim($value)). "', ";
		}
	}
	# Remove last ,
	$sql = substr_replace( $sql, "", -2 );
	# Add the rest
	$sql .= "WHERE ".$keyField. "='".$keyValue."'";

	$result = mysql_query($sql);
//ShowAll();
	if (!$result) {
		echo 'Update Query failed: ' . mysql_error();
		return false;
	}
	//else echo $keyValue.' Updated';
	return true;
}


#
# Insert into table from $_POST
#

function insertFromPost($table)
{
	# Start
	$sql = "INSERT INTO ".$table." ";


	# pocetna zagrada queryja
	$columns = '(';

	# Get Variable Names and Values from $_POST
	foreach ($_POST as $field => $value)
	{
		if ($field != 'form_name' &&
		$field != 'update' &&
		$field != 'insert' &&
		$field != 'PHPSESSID' &&
		stripos($field,'SpryMedia') === false &&
		stripos($field,'__utm') === false &&
		$field != 'set'
		)
		{
		$columns .= $field.", ";
		}
	}
	# Remove last ,
	$columns = substr_replace( $columns, "", -2 );

	# zatvori zagradu
	$columns .= ')';

	# sad to isto za VALUES
	$vals = "(";

	# Get Variable Names and Values from $_POST
	foreach ($_POST as $field => $value)
	{
		if ($field != 'form_name' &&
		$field != 'update' && $field != 'insert'  		)
		{
		$vals .= "'".mysql_real_escape_string(trim($value)). "', ";
		}
	}

	# Remove last ,
	$vals = substr_replace( $vals, "", -2 );
	# zatvori zagradu
	$vals .= ")";



	# Add the rest
	$sql .= $columns." VALUES".$vals;

	//echo $sql;

	$result = mysql_query($sql);

	if (!$result) {
		echo 'Insert Query failed: ' . mysql_error();
		return false;
	}
	//else echo $keyValue.' Updated';
	return true;
}


function dashMsg($title='Message',$msgtext)
{
?>
<div style="margin:0 auto;width: 280px !important;" class="dashboard_pannel" >

    <div class="dashboard_pannel_header" style="width: 270px !important;">
        <?php  echo $title;?>
    </div>

    <div class="dashboard_pannel_content">
        <?php  echo $msgtext;?>
    </div>

</div>
<?
}


function clearVal($val)
	{
		# ovo je trik koji sprjecava da se stalno dodaju slashes
		
		if (get_magic_quotes_gpc()) {
        return stripslashes($val);
	    } else {
        return $val;
    	}

	}

/* EOF */
