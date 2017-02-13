gqAus.controller('userprofileCtlr', function ($rootScope, $scope, $window, _, AjaxService, $filter) {
    $scope.IsLoaded = false;
    $scope.IsLoadedEvidences = false;
    $scope.allEvidenceCats = [];
    $scope.allEvidences = [];
    $scope.evidenceView = {};
    $scope.userId = $window.or_user_id || 0;
   
    $scope.getAllEvidenceCats = function(){
        AjaxService.apiCall("getAllEvidenceCats", {}).then(function (data) {
           $scope.allEvidenceCats = data;
           $scope.IsLoaded = true;
           $scope.getEvidenceLibrary();
        }, function (error) {
            console.log(error);
        });
    };
    $scope.getEvidenceLibrary = function(){
        AjaxService.apiCall("units/getEvidenceLibrary", {}).then(function (data) {
           $scope.allEvidences = data;
           $scope.IsLoadedEvidences = true;
        }, function (error) {
            console.log(error);
        });
    };
    $scope.getAllEvidenceCats();
});