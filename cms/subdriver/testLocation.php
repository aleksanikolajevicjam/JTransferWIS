<!DOCTYPE HTML>

<head>
   <html>
		<script src="https://code.jquery.com/jquery-2.0.2.js"></script>
		<!--<script src="https://www.jamtransfer.com/cms/js/jquery/2.0.2/jquery.min.js"></script>-->
		<!-- jQuery UI 1.10.3 -->
		<script src="../js/jquery/ui/1.10.3/jquery-ui.min.js" type="text/javascript"></script>
   
      <script type = "text/javascript">
	  		geolocation();

		setInterval(function(){		
			//window.location.reload(1);	
			//getLocationUpdate();
			//geolocation();
		}, 60000);	  
         var watchID;
         var geoLoc;
         
         
         function getLocationUpdate(){
            
            if(navigator.geolocation){
               
               // timeout at 60000 milliseconds (60 seconds)
               var options = {timeout:5000};
               geoLoc = navigator.geolocation;
               watchID = geoLoc.watchPosition(showLocation, errorHandler, options);
			   
            } else {
               alert("Sorry, browser does not support geolocation!");
            }
         }
		 
		function geolocation () {
			if(navigator.geolocation){
				navigator.geolocation.getCurrentPosition(
					function(position) {
						var lat = position.coords.latitude;
						var lng = position.coords.longitude;
						alert("Latitude : " + lat + " Longitude: " + lng);
						var url= 'https://cms.jamtransfer.com/cms/subdriver/geoLocation.php?lat='+lat+'&lng='+lng;
						//alert (url);
						$.ajax({
							url: url,
							async: false,
							success: function(data){
								//alert ('OK');
							},
							error: function(){
								//alert ('FAIL');
							}
						});
					
					}
				)			
			}
		}		 
      </script>
   </head>
	TEST LOCATIONS DATA
</html>
<?php
  $arr=(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['HTTP_X_FORWARDED_FOR'])));
 echo $arr['geoplugin_latitude'];
 echo $arr['geoplugin_longitude'];
?>