gqAus.controller('userprofileCtlr', function ($rootScope, $scope, $window, _, AjaxService, $filter) {
    $scope.IsLoaded = false;
    $scope.IsLoadedEvidences = false;
    $scope.pageStats = {
       evidenceEdit:false,
       evidenceView:'card',
       libraryView:'card',
       evidenceFiles:{},
       isLibrary:false
    };
    $scope.allEvidenceCats = [];
    $scope.allEvidences = [];
    $scope.evidenceView = {};
    $scope.userId = $window.or_user_id || 0;
    $scope.userCourses = [];
    $scope.evidences = {};
    $scope.propertyName = 'name';
    $scope.reverse = true;
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
    
    $scope.clearFilters = function(){}
    
    $scope.sortBy = function(propertyName) {
        $scope.reverse = ($scope.propertyName === propertyName) ? !$scope.reverse : false;
        $scope.propertyName = propertyName;
    };

    $scope.showEvidenceModal = function (evidence) {
        $scope.evidenceView = {};
        $scope.evidenceView = evidence;
        $('#filePreview').modal('show');
    };
    
    $scope.deleteEvidence = function (evidence) {
        var ids = [];
        if (evidence === undefined) {
            var keys = [];
            _.each($scope.pageStats.evidenceFiles, function (val, key) {
                if (val) {
                    keys.push(key);
                }
            });
            ids = keys;
            $scope.pageStats.evidenceFiles = [];
        } else {
            ids.push(evidence.id);
        }
        $scope.allEvidences = _.filter($scope.allEvidences, function(evi){ return !_.contains(ids, evi.id); });
        AjaxService.apiCall("units/deleteEvidences", {evidences:ids}).then(function (data) {
        }, function (error) {
            console.log(error);
        });
    };  
    
    $scope.getAllEvidenceCats();
});