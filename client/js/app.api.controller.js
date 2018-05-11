
appApiModule.controller('AppCtrl', ['$scope', '$mdSidenav', function ($scope, $mdSidenav){
    $scope.toggleSidenav = buildToggler('closeEventsDisabled');

    function buildToggler(componentId) {
        return function () {
            $mdSidenav(componentId).toggle();
        };
    }
}]);
appApiModule.controller('__AppApiController', 
    ['$scope', '__AppServiceSender', '$rootScope', function ($scope, __AppServiceSender, $rootScope) {

    // $scope.responseType = {
    //     return_01: {
    //         type:'RESULT_INPUT_CHECKER'
    //     }
            
    // };

    $scope.__appVars    = {
        isDisabled:{},
        appModel:{},
        errorMsg:{},
        errorShow:{}
    };
    $scope.__appVarInit = function(arryVars,arrayVarValue){
        arryVars.forEach(
            function(currVar,index){
                var varVal = arrayVarValue[index];
                $scope.__appVars[currVar] = (varVal != undefined)?varVal : '';
            }
        );
    };

    $scope.sendData = function(){
        setDisableFields(true);
        var result = __AppServiceSender.__appSend($scope.__appVars.appModel);
        result.then(
            function(data){
                console.log('Broadcast Sent: RESULT_INPUT_CHECKER');
                $rootScope.$broadcast('RESULT_INPUT_CHECKER',data.items);
            },
            function(data){
                console.log('Result Error!!');
            }
        );
    };
    
    $scope.$on('RESULT_INPUT_CHECKER', function (event, args) {
        
        console.log('Broadcast Received: RESULT_INPUT_CHECKER');
        var invalidModelList    = args.invalidModelList;
        var errorMessage        = args.errorMessages;

        // Reset old content
        angular.forEach($scope.__appVars.appModel, function (modelName, key) {
            $scope.__appVars.errorMsg[key]  = '';
            $scope.__appVars.errorShow[key] = false;
            console.log('Reset : ' + key);
        });

        angular.forEach(invalidModelList, function (modelName, key) {
            $scope.__appVars.errorMsg[modelName]    = errorMessage[modelName];
            $scope.__appVars.errorShow[modelName]   = true;
        });
        setDisableFields(false);
    });

    function setDisableFields(stat){
        angular.forEach($scope.__appVars.appModel, function (modelName, key) {
            $scope.__appVars.isDisabled[key] = stat;
        });
    }//end method setDisableFields

  
}]);