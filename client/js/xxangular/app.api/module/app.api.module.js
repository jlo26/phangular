// declare a module
var appApiModule = angular.module('appApiModule', ['LocalStorageModule']);
appApiModule.config(function(localStorageServiceProvider){
	localStorageServiceProvider.setPrefix('appApiStorage');	
});