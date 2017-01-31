gqAus.controller('qualificationCtlr', function ($rootScope, $scope, $window, _, AjaxService) {
    $scope.IsLoaded = false;
    
    AjaxService.apiCall("electiveUnits/getElectiveUnits").then(function (data) {

       console.log(data);
    }, function (error) {
        console.log(error);
    });
   
});
