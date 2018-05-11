

wrightAgencyApp.controller('CustomerSupportCtrl', 
	['$scope','ServiceAppSender','$location',function($scope,ServiceAppSender,$location) {

    $scope.costumer = {
        firstName: '',
        lastName:  '',
        emailAdd:    '',
        phone:    '',
        subject:  '',
        message:  '',
    };
    $scope.costumerDef = $scope.costumer;

// console.log($location.absUrl());

    $scope.sendEmail = function(){

        console.log('sendEmail >> ');
        
        console.log('Raw Data >> ');
        console.log($scope.costumer);
        console.log('sendEmail Data >> ');

        $scope.data = { 
            "apiObj":"AppMain",
            "jwtToken":"j142hu412iu4joi12u81724",
            "csrfToken":"userSupportInquiry",
            "apiObjData":
            {
                "data":
                {
                    "fname": $scope.costumer.firstName,
                    "lname": $scope.costumer.lastName,
                    "email": $scope.costumer.emailAdd,
                    "phone": $scope.costumer.phone,
                    "subject":$scope.costumer.subject,
                    "message":$scope.costumer.message
                },
                    "":""
            },"apiObjMethod":"userSupportInquiry"
        };
        console.log($scope.data);


        var ret = ServiceAppSender.appRequest($scope.data).then(
            function(returnOk){

                console.log('Ret ');
                console.log(returnOk.stat);
                if(returnOk.stat){
                    console.log('Retset');
                    $scope.costumer = {
                        firstName: '',
                        lastName:  '',
                        emailAdd:    '',
                        phone:    '',
                        subject:  '',
                        message:  '',
                    };
                }

            },
            function(){}
        );
    };
}]);