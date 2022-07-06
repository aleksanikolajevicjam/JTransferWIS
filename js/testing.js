var ang = angular.module('angTest', ['slugifier']);

//ang.config(function($locationProvider){$locationProvider.html5Mode(true);});

ang.controller('countryCtrl', ['$scope','$http',function($scope, $http){
		// isprazni sve
        $scope.places2 = [];
        $scope.places3 = [];
        
        $scope.disableFrom = true;
        $scope.disableTo = true;
		
		$scope.countryLoaded = false;
		$scope.fromLoaded = false;
		$scope.toLoaded = false;
		
		// ovo je za countries.html
		$scope.countryLoading = 'Loading Countries.Please wait...';
		
		$http.jsonp('https://taxido.net/widget/ajax_getCountries.php?callback=JSON_CALLBACK').
		  success(function(data){
		    $scope.countryLoaded = true;
		    $scope.disableFrom = false;
		    $scope.fromLoaded = false;

		    $scope.countries = data;        
		    $scope.countryLoading = 'Select a Country to continue...';
		  });

		// SELECT fromSelect
		$scope.selectFrom = function() {
		    $scope.places3 = [];
		    $scope.fromLoaded = false;
			
			  $http.jsonp('https://taxido.net/widget/ajax_getStartPlaces.php?cID='+$scope.cntrySelect+'&callback=JSON_CALLBACK').
			  success(function(data){
				
				$scope.fromLoaded = true;
				$scope.disableTo = false;
				$scope.toLoaded = false;
				
				$scope.places2 = data;
			  });
		};
		
		// SELECT toSelect
		$scope.selectTo= function() {
		  $http.jsonp('https://taxido.net/widget/ajax_getEndPlaces.php?fID='+$scope.fromSelect+'&callback=JSON_CALLBACK').
		  success(function(data){
		  	$scope.toLoaded = true;
		    $scope.places3 = data;
		  });      
		};

}]);


ang.controller('placesCtrl', ['$scope','$http',function($scope, $http){
    var url = window.location.pathname;
    var arr = url.split('taxi-transfer-from-');
    var from = arr[arr.length - 1];

	// za starting.html
    $scope.fromLoading = 'Loading Starting Points.Please wait...';

    $http.jsonp('https://taxido.net/widget/ajax_getStartPlaces.php?cID='+from+'&callback=JSON_CALLBACK').
      success(function(data){
        $scope.places = data;
        $scope.fromLoading = 'Select a Starting point of your transfer to continue...';
        $scope.fromId = from;
        
      });
}]);

ang.controller('placesCtrl2', ['$scope','$http',function($scope, $http){

    var url = window.location.pathname;
    var arr = url.split('-');
    var to = arr[arr.length - 1];

	// za ending.html
	$scope.endLoading = 'Loading Ending Points.Please wait...';

    $http.jsonp('https://taxido.net/widget/ajax_getEndPlaces.php?fID='+to+'&callback=JSON_CALLBACK').
      success(function(data){
        $scope.places2 = data;
        $scope.endLoading = 'Select the End Point of your transfer to continue...';
        $scope.toId = to;
      });
}]);


// za sada se ne koristi
ang.controller('airportCtrl', ['$scope','$http',function($scope, $http){
    $http.jsonp('http://filltext.com/?rows=30&airport={city}&callback=JSON_CALLBACK').
      success(function(data){
        $scope.airports = data;
      });
}]);

