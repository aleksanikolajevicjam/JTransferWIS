<?
	unlink('./PDF/'.$_REQUEST['file']);
		
	require_once 'data.php';

	mysqli_query($conn, "UPDATE v4_OrderDetails 
		SET PDFFile = '' 
		WHERE DetailsID = " . $_REQUEST['DetailsID']);

