gqAus.controller('qualificationCtlr', function ($rootScope, $scope, $window, _, AjaxService) {
    $scope.IsLoaded = false;
    $scope.unitsFetched = false;
    $scope.electiveUnits = [];
    $scope.selectedElectiveUnits = [];
    $scope.coreUnits = [];
    $scope.selectedCoreUnits = [];
    $scope.requiredElective = 0;

    $scope.addRemoveUnit = function(unit) {
        var obj = _.where($scope.selectedElectiveUnits,unit);
        if(_.isEmpty(obj)) {
            $scope.selectedElectiveUnits.push(unit);
        }else{
            $scope.selectedElectiveUnits = _.without($scope.selectedElectiveUnits, unit);
        }
    };
    
    $scope.isSelected = function(unit) {
        return !_.isEmpty(_.where($scope.selectedElectiveUnits,unit));
    };
    
    $scope.getUnits = function () {
        AjaxService.apiCall("electiveUnits/getElectiveUnits", {"courseCode": $scope.courseCode}).then(function (data) {
            $scope.electiveUnits = data.Units.Elective;
            $scope.coreUnits = data.Units.Core.unit;
            $scope.requiredElective = data.Units.Elective.validation.requirement;
            $scope.IsLoaded = true;
            $scope.unitsFetched = true;
        }, function (error) {
            console.log(error);
        });
    };
    
    $scope.doneSelecting = function() {
        
    };
    
    // Watchers
    $scope.$watch('qualificationPage', function (newValues) {
        if (newValues !== '') {
            $scope.IsLoaded = false;
           if(newValues === "qualification") {
               $scope.IsLoaded = true;
           }else{
               ($scope.unitsFetched == false) ? $scope.getUnits() : $scope.IsLoaded = true;
           }
        }
    });

});
