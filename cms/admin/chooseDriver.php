<?
require_once '../headerScripts.php';

require_once '../../f/f.php';
?>		
		<select name="OwnerID" id="OwnerID"  class="w75" >
			<option value="0"> <?= ALL_DRIVERS ?> </option>
	
			<?
			require_once '../../db/v4_AuthUsers.class.php';

			# init class
			$au = new v4_AuthUsers();

			$auk = $au->getKeysBy('AuthUserRealName', 'asc', "WHERE AuthLevelID = 31 AND AuthUserRealName<>'' AND Active=1");

			foreach($auk as $n => $ID) {

				$au->getRow($ID);
				echo '<option value="'.$au->getAuthUserID() .'">'.$au->getAuthUserRealName().'</option>';

			}
	
			?>
		</select>
	
	<script>
		$('#OwnerID').change(function(){
			var id=$( "#OwnerID option:selected" ).val();
			$.ajax({
				type: 'POST',
				url: '/cms/a/sessionDriver.php',
				data: {id: id },
				success: function (response) { console.log("OK: " + response) },
				error: function (response) { console.log("ERROR: " + response) }
			});			
			
			
		})	
		
	</script>