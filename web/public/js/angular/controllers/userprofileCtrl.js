gqAus.controller('userprofileCtlr', function ($rootScope, $scope, $window, _, AjaxService, $filter) {
    $scope.IsLoaded = false;
    $scope.IsLoadedEvidences = false;
    $scope.pageStats = {
       evidenceEdit:false,
       evidenceView:'list',
       libraryView:'list',
       evidenceFiles:{},
       isLibrary:false
    };
    $scope.selectedCat = 'test';
    $scope.checkVal = {};
    $scope.fileAssToArr = [];
    $scope.fileAssToObj = {};
    $scope.fileLinToArr = [];
    $scope.fileLinToObj = {};
    $scope.fileFormToArr = [];
    $scope.fileFormToObj = {};
    $scope.allEvidenceCats = [];
    $scope.allEvidences = [];
    $scope.filterEvds = [];
    $scope.evidenceView = {};
    $scope.userCCodes = {};
    $scope.filterLib = {};
    $scope.courseUnit = {};
    $scope.userId = $window.or_user_id || 0;
    $scope.userCourses = [];
    $scope.evidences = {};
    $scope.propertyName = 'name';
//    $scope.feedBackType = '';
//    $scope.detailedFeedBack = '';
    $scope.reverse = true;
    $scope.uploadAdditional = {};
    $scope.selectedListArr = [];
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
    $scope.fileFormToFld = false;
    $scope.fileLinkToFld = false;
    $scope.getAllEvidenceCats = function(){
        AjaxService.apiCall("getAllEvidenceCats", {}).then(function (data) {
           $scope.allEvidenceCats = data;
           $scope.IsLoaded = true;
           $scope.class = "active";
           $scope.getUserCourses();
           $scope.getEvidenceLibrary();
           $scope.getUploadDetails();
        }, function (error) {
            console.log(error);
        });
    };
    
    $scope.getEvidenceLibrary = function(){
        AjaxService.apiCall("units/getEvidenceLibrary", {}).then(function (data) {
            // Re-init collapse UI
           CONTROL_COLLAPSE.init();
           $scope.allEvidences = data;
           $scope.IsLoadedEvidences = true;
           $scope.evidences = data;
           
        }, function (error) {
            console.log(error);
        }).finally(function(){
            FILE_THUMBNAIL.computation_interval();
        });
    };
    
    $scope.getUserCourses = function(){
        AjaxService.apiCall("getUserCourses", {}).then(function (data) {
           $scope.userCourses = data;
        }, function (error) {
            console.log(error);
        });
    }
    
    $scope.filterCat = function(catid){
        if(catid === '6')  {
            $scope.allEvidences = $scope.evidences;
        }
        else {
            $scope.allEvidences = _.where($scope.evidences, {"catId":catid});
            $scope.selectedCat = $scope.allEvidenceCats[catid].name;
        }
    }
    
//    $scope.fileAssociatedTo = function(courseCode){
//        $scope.filterEvds = _.where($scope.evidences, {"courseCode":courseCode});
//        $scope.allEvidences = _.union($scope.filterEvds);
//    }
    
    $scope.clearFilters = function(){
        angular.forEach($scope.userCCodes, function (fileAssVal, fileAssIndex) {
               $scope.userCCodes[fileAssIndex] = false;
        });
        angular.forEach($scope.filterLib, function (formVal, formIndex) {
            $scope.filterLib[formIndex] = false;
        });
        angular.forEach($scope.courseUnit, function (courseVal, courseIndex) {
            $scope.courseUnit[courseIndex] = false;
        });
    }
    
    $scope.applyFilters = function(){
        if(angular.isObject($scope.userCCodes)){
            $scope.fileFormToFld = false;
            $scope.fileLinkToFld = false;
            $scope.selectedfileAssArr = [];
            angular.forEach($scope.userCCodes, function (fileAssVal, fileAssIndex) {
                if(fileAssVal === true){
                    $scope.fileAssToObj[fileAssIndex] = _.where($scope.evidences, {"courseCode":fileAssIndex});
                } else if(fileAssVal === false){
                     delete $scope.fileAssToObj[fileAssIndex];
                     $scope.fileAssToObj[fileAssIndex] = [];
                 }
                $scope.fileAssToArr = angular.extend({},$scope.fileAssToArr, $scope.fileAssToObj);
            });
            angular.forEach($scope.fileAssToArr, function(key, obj){
                angular.forEach(key, function(key1, obj1){
                    $scope.selectedfileAssArr.push(key1);
                });
            });
        }
        if (_.isEmpty($scope.selectedfileAssArr))
            $scope.allEvidences = $scope.evidences;
        else
            $scope.allEvidences = $scope.selectedfileAssArr;
                
        if(angular.isObject($scope.filterLib)){          
            $scope.selectedfileFormToArr = [];
            $scope.fileLinkToFld = false;
            angular.forEach($scope.filterLib, function (formVal, formIndex) {
                if(formVal === true){
                    $scope.fileFormToObj[formIndex] = _.where($scope.allEvidences, {"type":formIndex});
                    $scope.fileFormToFld = true;
                } else if(formVal === false){
                     delete $scope.fileFormToObj[formIndex];
                     $scope.fileFormToObj[formIndex] = [];
                 }
                $scope.fileFormToArr = angular.extend({},$scope.fileFormToArr, $scope.fileFormToObj);
            });
            angular.forEach($scope.fileFormToArr, function(key2, obj2){
                angular.forEach(key2, function(key3, obj3){
                        $scope.selectedfileFormToArr.push(key3);
                });
            });
            if ($scope.fileFormToFld === true)
                $scope.allEvidences = $scope.selectedfileFormToArr;
        }
        if(angular.isObject($scope.courseUnit)){   
            $scope.selectedfileLinkToArr = [];
            angular.forEach($scope.courseUnit, function (courseUnitVal, courseUnitIndex) {
                if(courseUnitVal === true){
                    $scope.fileLinToObj[courseUnitIndex] = _.where($scope.allEvidences, {"linkToMulti":courseUnitIndex});
                    $scope.fileLinkToFld = true;
                } else if(courseUnitVal === false){
                     delete $scope.fileLinToObj[courseUnitIndex];
                     $scope.fileLinToObj[courseUnitIndex] = [];
                 }
                $scope.fileLinToArr = angular.extend({},$scope.fileLinToArr, $scope.fileLinToObj);
            });
            angular.forEach($scope.fileLinToArr, function(key4, obj4){
                angular.forEach(key4, function(key5, obj5){
                        $scope.selectedfileLinkToArr.push(key5);
                });
            });
            if ($scope.fileLinkToFld === true)
                $scope.allEvidences = $scope.selectedfileLinkToArr;
        }
        console.log($scope.allEvidences);
        FILE_THUMBNAIL.computation_interval();

        $('#evidenceFilter').modal('hide');
    }    
    $scope.sortBy = function(propertyName, highlightText) {
        $scope.reverse = ($scope.propertyName === propertyName) ? !$scope.reverse : false;
        $scope.propertyName = propertyName;
        document.getElementById('evidence-controls-label').innerHTML = highlightText;
        FILE_THUMBNAIL.computation_interval();
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

    $scope.customCheck = function() {
        $scope.pageStats.evidenceEdit === false ? $scope.pageStats.evidenceEdit = true : $scope.pageStats.evidenceEdit = false;
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
    
    $scope.sendFeedback = function(userId) {
         AjaxService.apiCall("help/sentFeedBack", {feedBackType: $scope.feedBackType, detFeedBack: $scope.detailedFeedBack, userId: userId}).then(function (data) {
            console.log(data);
        }, function (error) {
            console.log(error);
        });
    };
    
    $scope.getAllEvidenceCats();
});