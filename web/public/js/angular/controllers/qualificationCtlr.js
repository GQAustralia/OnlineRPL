gqAus.controller('qualificationCtlr', function ($rootScope, $scope, $window, _, AjaxService) {
    $scope.IsLoaded = false;
    $scope.unitsFetched = false;
    $scope.electiveUnits = [];
    $scope.allElectiveUnits = [];
    $scope.selectedElectiveUnits = [];
    $scope.coreUnits = [];
    $scope.allCoreUnits = [];
    $scope.selectedCoreUnits = [];
    $scope.requiredElective = 0;
    $scope.unitDetails = {};
    $scope.userElectiveUnits = [];
    $scope.userCoreUnits = [];

    $scope.addRemoveUnit = function(unit) {
        
        var obj = _.where($scope.selectedElectiveUnits,unit);
        if(_.isEmpty(obj)) {
            if($scope.selectedElectiveUnits.length == $scope.requiredElective) return false;
            $scope.selectedElectiveUnits.push(unit);
        }else{
            $scope.selectedElectiveUnits = _.without($scope.selectedElectiveUnits, unit);
        }
    };
    
    $scope.isSelected = function(unit) {
        return !_.isEmpty(_.where($scope.selectedElectiveUnits,unit));
    };
    
    $scope.getUnits = function () {
        AjaxService.apiCall("units/getUnits", {"courseCode": $scope.courseCode}).then(function (data) {
            console.log(data);
            $scope.electiveUnits = data.Units.Elective;
            $scope.coreUnits = data.Units.Core.unit;
            $scope.requiredElective = data.Units.Elective.validation.requirement;
            $scope.IsLoaded = true;
            $scope.unitsFetched = true;
            angular.forEach($scope.electiveUnits.groups, function (value, key) {
                angular.forEach(value.unit, function (val, index) {
                    $scope.allElectiveUnits.push(val);
                    $scope.getUnitDetails(val.id);
                });
            });
            angular.forEach($scope.coreUnits, function (val, index) {
                    $scope.allCoreUnits.push(val);
                    $scope.getUnitDetails(val.id);
                });
                $scope.userSelectedSync();
        }, function (error) {
            console.log(error);
        });
        $scope.getUserUnits();        
    };
    
    $scope.getUserUnits = function () {
        
        AjaxService.apiCall("units/getUserUnits", {"courseCode": $scope.courseCode}).then(function (data) {
            console.log(data);
            $scope.userElectiveUnits = data.elective;
            $scope.userCoreUnits = data.core;
            
        }, function (error) {
            console.log(error);
        });
    };
    
    $scope.getUnitDetails = function (unitCode) {
        $scope.unitDetails[unitCode] = {
            "elements" : "Loading elements .....",
            "evidence_guide" : "Loading evidence guide .....",
            "skills_and_knowledge" : "Loading skilss and knowledge ....."
        };
        AjaxService.apiCall("units/getUnitDetails", {"unitCode": unitCode}).then(function (data) {
            $scope.unitDetails[unitCode] = data;
        }, function (error) {
            console.log(error);
        });
    };
    
    $scope.doneSelecting = function() {
        AjaxService.apiCall("units/updateSelectedElectiveUnits", {"units" : $scope.selectedElectiveUnits,"courseCode":$scope.courseCode}).then(function (data) {
            $scope.getUserUnits();
        }, function (error) {
            console.log(error);
        });
    };
    
    $scope.userSelectedSync = function() {
        angular.forEach($scope.userElectiveUnits, function (val, index) {
                    if(val.electiveStatus == 1){
                       var $obj =  _.where($scope.allElectiveUnits,{"id":val.unitId});
                        if(!_.isEmpty($obj))$scope.selectedElectiveUnits.push($obj[0]);
                    }
                });
    };
    
    // Watchers
    $scope.$watch('qualificationPage', function (newValues) {
        if (newValues !== '') {
            $scope.IsLoaded = false;
           if(newValues === "qualification") {
               $rootScope.pageTitle = "GQ - RPL Qualification";
               $scope.IsLoaded = true;
           }else{
               if(newValues === "core") $rootScope.pageTitle = "GQ - RPL Core unit";
               if(newValues === "elective") $rootScope.pageTitle = "GQ - RPL Elective unit";
               ($scope.unitsFetched == false) ? $scope.getUnits() : $scope.IsLoaded = true;
           }
           
        }
    });
    
    $scope.$watch('userElectiveUnits', function (newValues) {
        $scope.userSelectedSync();
    });
    
});
