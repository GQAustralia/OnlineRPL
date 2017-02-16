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
    $scope.uploadAdditional = {};
    $scope.uploadControl = {};
    $scope.uploadInProgress = {
        uploads: [],
        category: {},
        libraryFiles:{}
    };
    $scope.uploadDetails = {
        maxUploadedSize: 0,
        totalUploadedSize: 0,
        evidenceCategories: []
    };
    $scope.details = {
        title: "",
        detailsType: ""
    };
    $scope.getAllEvidenceCats = function(){
        AjaxService.apiCall("getAllEvidenceCats", {}).then(function (data) {
           $scope.allEvidenceCats = data;
           $scope.IsLoaded = true;
           $scope.getUserCourses();
           $scope.getEvidenceLibrary();
           $scope.getUploadDetails();
        }, function (error) {
            console.log(error);
        });
    };
    
    $scope.getEvidenceLibrary = function(){
        AjaxService.apiCall("units/getEvidenceLibrary", {}).then(function (data) {
           $scope.allEvidences = data;
           $scope.IsLoadedEvidences = true;
           $scope.evidences = data;
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
    
    $scope.cancelUpload = function (value) {
        $scope.uploadControl.cancel(value);
        $scope.uploadInProgress.uploads.splice(value, 1);
        $scope.$applyAsync();
    };
    
    $scope.progressbar = function (uploadingSize, uploadedSize, totalSize, fileNum) {
        var uploadIndex = _.findIndex($scope.uploadInProgress.uploads, {fileNum: fileNum});
        var completed = Math.floor((uploadedSize + uploadingSize) * 100);
        if (completed > 100)
            completed = 100;
        $scope.uploadInProgress.uploads[uploadIndex].percentageCompleted = completed;
        $scope.$applyAsync();
    };
    
    $scope.uploadcomplete = function (data, obj) {
        var uploadIndex = _.findIndex($scope.uploadInProgress.uploads, {fileNum: obj.fileNum});
        $scope.uploadInProgress.uploads[uploadIndex].path = data.fileName;
        $scope.uploadInProgress.uploads[uploadIndex].jobId = data.jobId;
        var uploadedObj = $scope.uploadInProgress.uploads[uploadIndex];
        AjaxService.apiCall("addEvidences",uploadedObj).then(function (data) {
            if (data.uploadId !== '') {
                $scope.uploadInProgress.uploads =  _.without($scope.uploadInProgress.uploads, uploadedObj);
                $scope.getUploadDetails();
                $scope.$applyAsync();
            } else {
                var index = _.indexOf($scope.uploadInProgress.uploads, uploadedObj);
                $scope.enrollment.upload.uploadId[index].status = 'failed';
            }

        }, function (error) {
            console.log(error);
        });
    };
    
    $scope.uploadfailed = function (msg) {
        $window.alert(msg);
    };
    
    $scope.uploadstarted = function (file, fileNum, dataObj) {
        var index = $scope.uploadInProgress.uploads.length;
        var uploadObj = {
            file: file,
            fileNum: fileNum,
            name: file.name,
            category: dataObj.category,
            type: file.type,
            size: file.size,
            percentageCompleted: 0,
            status: 'inprogress'
        };
        console.log(uploadObj);
        $scope.uploadInProgress.uploads.push(uploadObj);
        $scope.$applyAsync();
        //angular.element("#uploadID").val(null);
        $scope.uploadEvidenceCategory = {};
        $('#uploadEvidence').modal('hide');
    };
    
     $scope.closeUploadModal = function () {
        angular.element("#uploadID").val(null);
        $scope.uploadEvidenceCategory = {};
        $('#uploadEvidence').modal('hide');
    };
    
     // Upload Evidence Functions 
    $scope.uploadIds = function () {
        if (_.isEmpty($scope.uploadInProgress.category)) {
            $window.alert('Select evidence category');
            return;
        }
        var keys = [];
        _.each($scope.uploadInProgress.libraryFiles, function (val, key) {
            if (val) {
                keys.push(key);
            }
        });
        if (angular.element("#uploadID").val() == '' && keys.length === 0 ) {
            $window.alert('Select evidence files');
            return;
        }
        if(keys.length > 0){
            $scope.uploadInProgress.libraryFiles = [];
            AjaxService.apiCall("units/copyEvidences", {evidenceIds: keys, courseCode: $scope.courseCode, unitCode: $scope.selectedUnit,category:$scope.uploadInProgress.category.id}).then(function (data) {
                $scope.getUploadDetails();
            }, function (error) {
                console.log(error);
            });
            $scope.closeUploadModal();
        }else{
            var additionalObj = {
                category: $scope.uploadInProgress.category.id,
                userId: $scope.userId
            };
            $scope.uploadControl.start(additionalObj);
                $('#uploadIdFiles').modal('hide');
            }
    };
    
     $scope.getUploadDetails = function () {
        AjaxService.apiCall("units/getUploadDetails", {}).then(function (data) {
            $scope.uploadDetails.maxUploadedSize = data.maxUploadSize;
            $scope.uploadDetails.totalUploadedSize = data.totalUploadSize;
            $scope.uploadDetails.evidenceCategories = data.evidenceCategory;
        }, function (error) {
            console.log(error);
        });
        $scope.getEvidenceLibrary();
    };
    
    
    $scope.getAllEvidenceCats();
});