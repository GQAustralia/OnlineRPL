gqAus.controller('userprofileCtlr', function ($rootScope, $scope, $window, _, AjaxService, $filter) {
    $scope.IsLoaded = false;
    $scope.IsLoadedEvidences = false;
    $scope.allEvidenceCats = [];
    $scope.allEvidences = [];
    $scope.evidenceView = {};
    $scope.userId = $window.or_user_id || 0;
    $scope.userCourses = [];
    $scope.evidences = {};
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
           $scope.evidences = data;
           $scope.IsLoadedEvidences = true;
           $scope.getUserCourses();
        }, function (error) {
            console.log(error);
        });
    };
    
    $scope.getUserCourses = function(){
        AjaxService.apiCall("getUserCourses", {}).then(function (data) {
           $scope.userCourses = data;
        }, function (error) {
            console.log(error);
        });
    }
    
    $scope.filerCat = function(catid){
        if(catid === '6') 
             $scope.allEvidences = $scope.evidences;
        else
            $scope.allEvidences = _.where($scope.evidences, {"catId":catid});
    }
    
    $scope.getAllEvidenceCats();
});