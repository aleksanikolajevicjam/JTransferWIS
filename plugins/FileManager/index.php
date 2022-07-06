<?
$smarty->assign('pageOLD',true);
?>
 <link rel="stylesheet" href="css/progress.css">
<br><br>
<div class="container"> 
	<div class="row">
		<!-- Button to select & upload files -->
		<span class="btn blue fileinput-button">
			<span class="btn"><i class="fa fa-cloud-upload xl"></i> <?= UPLOAD_IMAGES ?></span>
			<!-- The file input field used as target for the file upload widget -->
			<input class="btn" id="fileupload" type="file" name="files[]" multiple>
		</span>
	</div>
	<div class="row">
		<!-- The global progress bar -->
		<br>
		<p>Upload progress</p>
		<div id="progress" class="progress progress-info progress-striped">
			<div class="bar"></div>
		</div>
	</div>  
  
	<div class="row">  
		<!-- The list of files uploaded -->
		<h2>Uploaded:</h2>
		<br><br>
	</div>
	
	<div class="row"><div class="col-md-12"id="files"></div></div>
  
  <div class="row">
  <br><br>
  <h2>Images on Server:</h2>
  <br>
  <?
  		$dir = '../i/';
  		$validTypes = array('jpg', 'jpeg', 'JPG', 'png', 'PNG');
		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
				$i = 1;
				while (($file = readdir($dh)) !== false) {
				    
				    if ( in_array(pathinfo($file, PATHINFO_EXTENSION), $validTypes ) ) {
						echo '<div class="col-md-12" id="'.$i.'" >'.
						' <button class="btn red" onclick="DeleteFile(\''.$file.'\', \''.$i.'\');">
						<i class="fa fa-times-circle l"></i></button> '.
						'
						<a href="../i/'.$file.'" target="_blank" border="0">
						<img style="max-width:100%; padding:1em" class="thumbnail" src="'.$dir.$file.'" title="'.$dir.$file.'">
						</a>
						<h4>'."http://".$_SERVER['SERVER_NAME'].'/i/'.$file.'</h4> 
						
						'.
						
						" <br><br></div>";
						$i++;
				    }
				}
				closedir($dh);
			}
		}  
  
  ?>
  </div>
  <!-- Load jQuery and the necessary widget JS files to enable file upload 
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
  <script src="js/vendor/jquery.ui.widget.js"></script>
  <script src="js/jquery.iframe-transport.js"></script>
  <script src="js/jquery.fileupload.js"></script>
  
  
  
  
  <!-- JavaScript used to call the fileupload widget to upload files -->
  <script>
  
  function DeleteFile(filex,id) {


  	$.get("fileManagerDelete.php?file="+filex,
  			function(data){ 
  			$("#"+id).html('<p class="alert alert-danger">' + filex + ' ' + data + '</p><br><br>');
  			});
  			
  }
 
 
 // File Manager - Upload Manager AJAX LOAD
	function GetFileManager() {
		$.get("fileManager.php",
			function(data){ 
				$("#fileManager").html(data); 
				
			}
		);
	}
  
  
    // When the server is ready...
    $(function () {
        'use strict';
        
        // Define the url to send the image data to
        var url = '../i/index.php';
        
        // Call the fileupload widget and set some parameters
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {
                // Add each uploaded file name to the #files list
                $.each(data.result.files, function (index, file) {
                    $('<div/>').html(' <img src="../i/'+file.name+'" style="max-width:100%"><br> ' + file.name).appendTo('#files');
                    GetFileManager();
                    
                });
            },
            progressall: function (e, data) {
                // Update the progress bar while files are being uploaded
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .bar').css(
                    'width',
                    progress + '%'
                );
            }
        });
        
    });
    
  </script>
</div>
