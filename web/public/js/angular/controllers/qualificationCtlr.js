gqAus.controller('qualificationCtlr', function ($rootScope, $scope, $window, _, AjaxService) {
    $scope.IsLoaded = false;
    $scope.electiveUnits = [];
    $scope.selectedElectiveUnits = [];
    $scope.coreUnits = [];
    $scope.selectedCoreUnits = [];


    $scope.$watch('courseCode', function (newValues) {
        if (newValues != '') {
            AjaxService.apiCall("electiveUnits/getElectiveUnits", {"courseCode": $scope.courseCode}).then(function (data) {
                $scope.electiveUnits = data.Units.Elective;
                $scope.coreUnits = data.Units.Core.unit;
                console.log(data);
            }, function (error) {
                console.log(error);
            });
        }
    });


});
