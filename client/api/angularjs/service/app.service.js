wrightAgencyApp.factory('ServiceAppSender',
	['$http','$location',
		function($http,$location) {

   	return {

	   	appRequest: function(data){
			console.log('appRequest >> ');
			return $http.post($location.absUrl(), data).then(
				function(d){
					console.log(" Sent ");
					console.log(d);
					return d.data;
				}, 
				function($d){
					console.log(" Error ");
					console.log(d);
				}
			);
		},
   	};
}]);