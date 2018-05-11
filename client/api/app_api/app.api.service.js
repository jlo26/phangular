

appApiModule.factory('__AppServiceSender', 
	['$http', '$location', '__AppServiceApiConfig','$window',
		function ($http, $location, __AppServiceApiConfig, $window) {	
   	return {
	   	__appRequest: function(data){
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
	   	__appSend: function(paramData){
			console.log('__appSend >> ');
			var serverData = __AppServiceApiConfig.getSenderData(false);
			var urlReceiver = 'index.php';
			serverData.apiObjData.data = paramData;
			
			console.log("Before Send");
			console.log(serverData);
			console.log("Before Send");
   			return $http.post(urlReceiver, serverData).then(
				function(d){
					console.log(" Success __appSend>>");
					console.log(d);
					return d.data;
				}, 
				function($d){
					console.log(" Success __appSend>>");
					console.log(d);
				}
			);
	   	},
   	};

}]);

appApiModule.factory('__AppServiceResultChecker', [function () {
	return {
		__init: function () {
			
		},
		__appRequest: function (data) {
			console.log('appRequest >> ');
			return $http.post($location.absUrl(), data).then(
				function (d) {
					console.log(" Sent ");
					console.log(d);
					return d.data;
				},
				function ($d) {
					console.log(" Error ");
					console.log(d);
				}
			);
		},
	};

}]);

appApiModule.factory('__AppServiceInit', ['__AppServiceStorage', function(appStorageService) {	
   	return {
   		__init: function(){
   			var appApiConfig
   			apiObj:""
   		},
	   	__appRequest: function(data){
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

appApiModule.factory('__AppServiceApiConfig', ['$http',function($http) {

	return {
		set: function(index,val){
			LocalStorageModule.set(index,val);
		},
	   	get: function(configFile){
   			//Make http file from here if already stable
   			var configFile = {
   				"apiObj":"App001",
   				"jwtToken":"j142hu412iu4joi12u81724",
   				"csrfToken":"userSupportInquiry",
   				"apiObjMethod":"userFormCtrl",
   				"apiShowUI":false,
   				"apiObjData":{
   					"data":{
   						"fname":"Jerold",
   						"lname":"Lozares",
   						"email":"eqw",
   						"phone":"322",
   						"subject":"sds",
   						"message":"Help my tanong ako mr dj"
   					}
				},
			};
			
			return configFile;
		},
		getSenderData: function (configFile) {
			//Make http file from here if already stable
			var configFile = {
				"apiObj": "App001",
				"jwtToken": "j142hu412iu4joi12u81724",
				"csrfToken": "j142hu412iu4joi12u81724",
				"apiObjMethod": "userFormCtrl",
				"apiShowUI": false,
				"apiObjData": {
					"data": {
						"fname": "Jerold",
						"lname": "Lozares",
						"email": "eqw",
						"phone": "321",
						"subject": "sds",
						"message": "Help my tanong ako mr dj"
					}
				},
			};
			return configFile;
		},
   	};
}]);

appApiModule.factory('__AppServiceStorage', ['LocalStorageModule', function(LocalStorageModule) {
	return {
		set: function(index,val){
			LocalStorageModule.set(index,val);
		},
	   	get: function(index){
   			LocalStorageModule.get(index);   			
	   	},
   	};
}]);