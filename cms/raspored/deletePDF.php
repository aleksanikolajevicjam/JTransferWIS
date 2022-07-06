<?

	unlink('./PDF/'.$_REQUEST['file']);
				// azuriraj datoteku			
				require_once 'data.php';
		
				mysql_query("UPDATE TimeTable SET 
								PDFFile = '' 
								WHERE ID = " . $_REQUEST['ID']
							);	
